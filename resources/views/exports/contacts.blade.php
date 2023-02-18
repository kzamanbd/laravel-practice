<table>
    <thead>
        <tr>
            <th style="border: 1px solid #000; font-weight:bold;">SL</th>
            <th style="border: 1px solid #000; font-weight:bold;">Name</th>
            <th style="border: 1px solid #000; font-weight:bold;">Mobile</th>
            <th style="border: 1px solid #000; font-weight:bold;">Address</th>
            <th style="border: 1px solid #000; font-weight:bold;">E-TIN</th>
            <th style="border: 1px solid #000; font-weight:bold;">Old TIN</th>
            <th style="border: 1px solid #000; font-weight:bold;">TIN Date</th>
            <th style="border: 1px solid #000; font-weight:bold;">Police Station</th>
            <th style="border: 1px solid #000; font-weight:bold;">Circle Name</th>
            <th style="border: 1px solid #000; font-weight:bold;">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $contact)
            <tr>
                <td style="border: 1px solid #000">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #000">{{ $contact->name }}</td>
                <td style="border: 1px solid #000">{{ $contact->mobile }}</td>
                <td style="border: 1px solid #000">{{ $contact->address }}</td>
                <td style="border: 1px solid #000">{{ $contact->tin }}</td>
                <td style="border: 1px solid #000">{{ $contact->old_tin }}</td>
                <td style="border: 1px solid #000">{{ $contact->tin_date }}</td>
                <td style="border: 1px solid #000">{{ $contact->police_station }}</td>
                <td style="border: 1px solid #000">{{ $contact->circle_name }}</td>
                <td style="border: 1px solid #000">{{ $contact->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
