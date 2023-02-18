<table>
    <thead>
        <tr>
            <th style="border: 1px solid #000; font-weight:bold;">SL</th>
            <th style="border: 1px solid #000; font-weight:bold;">Name</th>
            <th style="border: 1px solid #000; font-weight:bold;">Email</th>
            <th style="border: 1px solid #000; font-weight:bold;">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td style="border: 1px solid #000">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #000">{{ $user->name }}</td>
                <td style="border: 1px solid #000">{{ $user->email }}</td>
                <td style="border: 1px solid #000">{{ $user->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
