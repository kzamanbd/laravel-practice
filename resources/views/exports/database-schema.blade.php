<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TABLE</title>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th {
                background-color: #f2f2f2;
            }

            th,
            td {
                border: 1px solid #000000;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
        </style>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th valign="middle"
                        style="border: 1px solid #000; text-align: center; font-weight: bold; font-size: 20px;"
                        colspan="10">
                        Table Name: {{ $tableName }}
                    </th>
                </tr>
                <tr>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Column Name
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Data Type
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Length
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Nullable
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Default
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Comments
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Constraints
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Indexes
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Triggers
                    </th>
                    <th valign="middle"
                        style="border: 1px solid #000;font-weight:bold;text-align:center;background: #E2EDFA">
                        Foreign Keys
                    </th>
                </tr>
            </thead>
            @foreach ($schema as $column)
                <tbody>
                    <tr>
                        <td valign="middle" style="border: 1px solid #000">
                            {{ $column['column_name'] }}
                        </td>
                        <td valign="middle" style="border: 1px solid #000">
                            {{ $column['data_type'] }}
                        </td>
                        <td valign="middle" style="border: 1px solid #000">
                            {{ $column['length'] }}
                        </td>
                        <td valign="middle" style="border: 1px solid #000">
                            {{ $column['nullable'] }}
                        </td>
                        <td valign="middle" style="border: 1px solid #000">
                            {{ $column['default'] }}
                        </td>
                        <td valign="middle" style="border: 1px solid #000"></td>
                        <td valign="middle" style="border: 1px solid #000"></td>
                        <td valign="middle" style="border: 1px solid #000"></td>
                        <td valign="middle" style="border: 1px solid #000"></td>
                        <td valign="middle" style="border: 1px solid #000"></td>
                    </tr>
                </tbody>
            @endforeach
        </table>

    </body>

</html>
