<table border="1">
    <thead>
        <tr>
            <td colspan="6" align="center">REKAPITULASI NILAI {{ strtoupper($exam->title) }}</td>
        </tr>
        <tr>
            <td>No</td>
            <td>Nama Lengkap</td>
            <td>Jenis Kelamin</td>
            <td>Provinsi</td>
            <td>Kota/Kab</td>
            <td>Nilai</td>
        </tr>
    </thead>
    <tbody>
        @foreach($rankingExams as $index => $examUser)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $examUser->user->name }}</td>
                <td>{{ $examUser->user->student ? ($examUser->user->student->gender == "F" ? "P" : "L") : '-'}}</td>
                <td>{{ $examUser->user->student ? ($examUser->user->student->province->name ?? '-') : '-' }}</td>
                <td>{{ $examUser->user->student ? ($examUser->user->student->city->name ?? '-') : '-' }}</td>
                <td>{{ $examUser->grade }}</td>
            </tr>
        @endforeach
    </tbody>
</table>