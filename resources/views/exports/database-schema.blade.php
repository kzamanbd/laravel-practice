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
                    <th style="border: 1px solid #000; font-weight:bold;">
                        Column Name
                    </th>
                    <th style="border: 1px solid #000; font-weight:bold;">
                        Data Type
                    </th>
                    <th style="border: 1px solid #000; font-weight:bold;">
                        Length
                    </th>
                    <th style="border: 1px solid #000; font-weight:bold;">
                        Nullable
                    </th>
                    <th style="border: 1px solid #000; font-weight:bold;">
                        Default
                    </th>
                </tr>
            </thead>
            @foreach ($schema as $column)
                <tbody>
                    <tr>
                        <td style="border: 1px solid #000">
                            {{ $column['column_name'] }}
                        </td>
                        <td style="border: 1px solid #000">
                            {{ $column['data_type'] }}
                        </td>
                        <td style="border: 1px solid #000">
                            {{ $column['length'] }}
                        </td>
                        <td style="border: 1px solid #000">
                            {{ $column['nullable'] }}
                        </td>
                        <td style="border: 1px solid #000">
                            {{ $column['default'] }}
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>

    </body>

</html>
