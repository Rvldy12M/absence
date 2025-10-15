<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Metode</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->student_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->class_name }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ $row->time }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->method }}</td>
                <td>{{ $row->notes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
