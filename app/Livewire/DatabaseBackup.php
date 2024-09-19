<?php

namespace App\Livewire;

use App\Exports\DatabaseSchemaExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseBackup extends Component
{

    public $tables = [];

    /**
     * Export the structure of all tables in the oracle database
     *
     * @return void
     */
    public function exportOracleTableStructure()
    {
        $connection = 'oracle'; // The database connection to use
        // Fetch the list of tables owned by the current schema (user)
        $tables = DB::connection($connection)->select("
            SELECT table_name
            FROM user_tables
        ");

        // Iterate over each table and get column metadata
        foreach ($tables as $table) {
            $tableName = $table->table_name;

            // Fetch column metadata for the current table from USER_TAB_COLUMNS
            $columns = DB::connection($connection)->select("
                SELECT
                    column_name,
                    data_type,
                    data_length,
                    nullable,
                    data_default,
                    char_length,
                    data_precision,  -- For NUMBER columns
                    data_scale        -- For NUMBER columns
                FROM user_tab_columns
                WHERE table_name = :table_name
            ", ['table_name' => $tableName]);

            // Add the table name and its columns with metadata to the schema array
            foreach ($columns as $column) {
                $schema[] = [
                    'table' => $tableName,
                    'column_name' => $column->column_name,
                    'data_type' => $column->data_type,
                    'length' => $column->char_length ?? $column->data_length, // Character or data length
                    'precision' => $column->data_precision ?? 'N/A', // For numbers
                    'scale' => $column->data_scale ?? 'N/A', // For numbers
                    'nullable' => $column->nullable,
                    'default' => $column->data_default ?? 'N/A', // Default value, if any
                ];
            }
        }

        return collect($schema)->groupBy('table');
    }

    /**
     * Export the structure of all tables in the mysql database
     *
     * @return void
     */

    public function exportMysqlTableStructure() {}


    /**
     * Export the structure of all tables in the database
     *
     * @return void
     */
    public function viewTableStructure()
    {
        $this->tables = $this->exportOracleTableStructure();
    }

    public function exportTableStructure()
    {
        $tables = $this->tables;
        if (empty($tables)) {
            $tables = $this->exportOracleTableStructure();
        }

        foreach ($tables as $table => $columns) {
            $name = strtoupper($table);

            $heading = [
                'Column Name',
                'Data Type',
                'Length',
                'Precision',
                'Scale',
                'Nullable',
                'Default',
            ];

            $columns->prepend($heading);

            Excel::store(new DatabaseSchemaExport($columns->toArray()), "backup/TABLE-{$name}.xlsx", 'local');
        }
    }

    public function render()
    {
        return view('livewire.database-backup');
    }
}
