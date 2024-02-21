<html>
    <head>
        <title>{{ $examGroup->lessonCategory->name }} - {{ $examGroup->title }}</title>
        <style>
            table {
                border-collapse: collapse;
                font-size:12px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            table th {
                padding:8px; 
                text-align: left;
            }

            table td {
                padding:4px; 
                /* text-align: center; */
            }

            .title {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"
            }

            @media print {
                .new-page {
                    page-break-before: always;
                }
            }
                        
        </style>
    </head>
    <body>
        @if($setting)
            <br>
            <img src="{{ $setting->app_url }}/storage/upload_files/settings/{{ $setting->logo }}" alt="" width="80px" style="position: absolute; margin-top:-40px; margin-bottom:20px;">
        @endif
        <center>
            <div class="title">
                <h3>REKAPITULASI {{ strtoupper($examGroup->title) }}</h3>
            </div>
        </center>

        <table width="100%" border="1" style="font-size:8;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Provinsi</th>
                    <th>Kota/Kab</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examGroup->examGroupUser as $index => $examGroupUser)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $examGroupUser->user->name }}</td>
                        <td>{{ $examGroupUser->user->student ? ($examGroupUser->user->student->gender == "F" ? "P" : "L") : '-'}}</td>
                        <td>{{ $examGroupUser->user->student ? ($examGroupUser->user->student->province->name ?? '-') : '-' }}</td>
                        <td>{{ $examGroupUser->user->student ? ($examGroupUser->user->student->city->name ?? '-') : '-' }}</td>
                        <td>{{ $examGroupUser->grade }}</td>
                        <td>{{ $examGroupUser->description ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>