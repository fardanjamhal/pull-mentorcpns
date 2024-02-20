<table border="1">
    <thead>
        <tr>
            <th colspan="6">REKAPITULASI {{ strtoupper($examGroup->title) }}</th>
        </tr>
        <tr>
            <td width="10">No</td>
            <td width="30">Nama Lengkap</td>
            <td width="20">Jenis Kelamin</td>
            <td width="30">Provinsi</td>
            <td width="30">Kota</td>
            <td width="30">Nilai</td>
            <td width="30">Keterangan</td>
        </tr>
    </thead>
    <tbody>
        @foreach($examGroup->examGroupUser as $index => $examGroupUser)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $examGroupUser->user->name }}</td>
                <td>{{ $examGroupUser->user && $examGroupUser->user->student ? ($examGroupUser->user->student->gender == "F" ? "Perempuan" : "Laki-laki") : '-'}}</td>
                <td>{{ $examGroupUser->user && $examGroupUser->user->student && $examGroupUser->user->student->province ? $examGroupUser->user->student->province->name : '-' }}</td>
                <td>{{ $examGroupUser->user && $examGroupUser->user->student && $examGroupUser->user->student?->city ? $examGroupUser->user->student->city->name : '-' }}</td>
                <td>{{ $examGroupUser->grade }}</td>
                <td>{{ $examGroupUser->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>