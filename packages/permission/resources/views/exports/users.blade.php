<x-lara-permission::report-layout>
    <x-slot name="title">User List</x-slot>
    <table>
        <thead>
            <tr>
                <th colspan="5" style="border: 1px solid #000; font-weight:bold; font-size: 20px; text-align: center;">
                    User List
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid #000; font-weight:bold; text-align:center; background: gray;">SL</th>
                <th style="border: 1px solid #000; font-weight:bold; text-align:center; background: gray;">Name</th>
                <th style="border: 1px solid #000; font-weight:bold; text-align:center; background: gray;">Email</th>
                <th style="border: 1px solid #000; font-weight:bold; text-align:center; background: gray;">Status</th>
                <th style="border: 1px solid #000; font-weight:bold; text-align:center; background: gray;">
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td style="border: 1px solid #000">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #000">{{ $user->name }}</td>
                    <td style="border: 1px solid #000">{{ $user->email }}</td>
                    <td style="border: 1px solid #000; text-align:center;">Active</td>
                    <td style="border: 1px solid #000; text-align:center;">
                        {{ $user->created_at->format('d-M-Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-lara-permission::report-layout>
