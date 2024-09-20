<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $tableName }}</title>
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
                    <th valign="middle" @style($thStyle)>
                        Column Name
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Data Type
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Length
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Nullable
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Default
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Constraints
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Indexes
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Unique Keys
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Foreign Keys
                    </th>
                    <th valign="middle" @style($thStyle)>
                        Comments
                    </th>
                </tr>
            </thead>
            @foreach ($schema as $column)
                @php
                    $tdStyle = ['border: 1px solid #000', 'background: #f2f2f2' => $loop->iteration % 2 == 0];
                @endphp
                <tbody>
                    <tr>
                        <td valign="middle" @style($tdStyle)>
                            {{ $column['column_name'] }}
                        </td>
                        <td valign="middle" @style($tdStyle)>
                            {{ $column['data_type'] }}
                        </td>
                        <td valign="middle" @style($tdStyle)>
                            {{ $column['length'] }}
                        </td>
                        <td valign="middle" @style($tdStyle)>
                            {{ $column['nullable'] }}
                        </td>
                        <td valign="middle" @style($tdStyle)>
                            {{ $column['default'] }}
                        </td>
                        <td valign="middle" @style($tdStyle)></td>
                        <td valign="middle" @style($tdStyle)></td>
                        <td valign="middle" @style($tdStyle)></td>
                        <td valign="middle" @style($tdStyle)></td>
                        <td valign="middle" @style($tdStyle)></td>
                    </tr>
                </tbody>
            @endforeach
        </table>

    </body>

</html>
