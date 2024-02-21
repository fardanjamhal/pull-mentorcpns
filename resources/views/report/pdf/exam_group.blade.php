<html>
    <head>
        <title>{{ $history->examGroup->lessonCategory->name }} - {{ $history->user->name }}</title>
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
                <h3>REKAPITULASI {{ strtoupper($history->examGroup->title) }}</h3>
            </div>
        </center>

        <table width="100%" style="border:1px solid #bbb;">
            <tbody>
                <tr>
                    <th width="200px">Nama Lengkap</th>
                    <td width="2px">:</td>
                    <td>{{ $history->user->name }}</td>
                </tr>

                <tr>
                    <th>Jenis Kelamin</th>
                    <td>:</td>
                    <td>{{ $history->user->student ? ($history->user->student->gender == "F" ? "P" : "L") : '-'}}</td>
                </tr>                

                <tr>
                    <th>Kategori Mata Pelajaran</th>
                    <td>:</td>
                    <td>{{ $history->examGroup->lessonCategory->name }}</td>
                </tr>

                <tr>
                    <th>Mata Pelajaran Yang Diujikan</th>
                    <td>:</td>
                    <td>
                        {{ implode(', ', $history->examGroup->grade->pluck('lesson.name')->toArray()) }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Mengerjakan</th>
                    <td>:</td>
                    <td>{{ dateFormat($history->created_at, 'd F Y') }}</td>
                </tr>    
            </tbody>
        </table>
        <br>
        <table width="100%" border="1">
            <thead>
                <tr>
                    <td width="10%">No</td>
                    <td width="35%">Kategori Penilaian</td>
                    @if($history->examGroup->minimal_grade_type == 1)
                        <td width="25%">Ambang Batas</td>
                    @endif
                    @if($history->examGroup->minimal_grade_type != 1)
                        <td width="30%">Keterangan</td>
                    @endif
                    <td width="25%" align="right">Nilai</td>
                </tr>
            </thead>

            @foreach($history->examGroup->grade as $index => $grade) 
                <tbody>
                    @if($grade->exam->questionTitle->assessment_type == 1 || $grade->exam->questionTitle->assessment_type == 2)
                        <tr>
                            <th colspan="4" style="background:#eee;">{{ $grade->lesson->name }}</th>
                        </tr>
                    @endif

                    @if($grade->exam->questionTitle->assessment_type != 1 && $grade->exam->questionTitle->assessment_type != 2)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $grade->lesson->name }}</td>
                            <td>{{ $grade->exam->questionTitle->passing_grade ?? '-'}}</td>
                            <td align="right">{{  $grade->grade  }}</td>
                        </tr>
                    @endif
                    
                    @if(($grade->exam->questionTitle->assessment_type == 1 || $grade->exam->questionTitle->assessment_type == 2) && $grade->grade_details)
                        @foreach($grade->grade_details as $index => $gradeDetail)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $gradeDetail['grade_category_name'] }}</td>
                                <td>{{ $gradeDetail['grade_category'] }}</td>
                                <td align="right">{{ $gradeDetail['grade'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            @endforeach

            @if($history->is_finished == 1)
                <tfoot>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <th colspan="2">Nilai Akhir</th>
                        <td colspan="2" align="right"><b>{{ $history->grade }}</b></td> 
                    </tr>

                    @if($history->examGroup->minimal_grade_type != 0)
                        <tr>
                            <th colspan="2">Keterangan<</th>
                            <td colspan="2" align="right">
                                <b>
                                    {{ $history->description ?? '' }}
                                </b>
                            </td>
                        </tr>
                    @endif
                </tfoot>
            @endif
        </table>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <table align="right">
                        <tr>
                            <td align="center"><b>{{ dateFormat($history->created_at, 'd F Y') }}</b></td>
                        </tr>
                        <tr>
                            <td align="center"><img src="{{ $setting->app_url }}/storage/upload_files/settings/{{ $setting->signed_image }}" width="150px"></td>
                        </tr>
                        <tr>
                            <td align="center"><b>{{ $setting->signed_name }}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>