<html>
    <head>
        <title>{{ $exam->lessonCategory->name }} - {{ $exam->title }}</title>
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
            <img src="{{ $setting->app_url }}/storage/upload_files/settings/{{ $setting->logo }}" alt="" width="80px" style="position: absolute; margin-top:-50px;">
            <br>
            <br>
        @endif
        <center>
            <div class="title">
                <h3>REKAPITULASI NILAI {{ strtoupper($exam->title) }}</h3>
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
    </body>
</html>