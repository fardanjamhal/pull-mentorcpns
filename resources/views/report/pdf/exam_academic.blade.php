<html>
    <head>
        <title>Tes Akademik - {{ $grade->nama }}</title>
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
        @endif
        <br><br>
        <center>    
            <div class="title">
                <h3>REKAPITULASI NILAI TRY OUT AKADEMIK</h3>
            </div>
        </center>

        <table width="100%" style="border:1px solid #bbb;">
            <tbody>
                <tr>
                    <th width="200px">Nama Lengkap</th>
                    <td width="2px">:</td>
                    <td>{{ $grade->nama }}</td>
                </tr>

                <tr>
                    <th>Jenis Kelamin</th>
                    <td>:</td>
                    <td>{{ $grade->gender == 1 ? "L" : "P" }}</td>
                </tr>                

                <tr>
                    <th>Kategori Mata Pelajaran</th>
                    <td>:</td>
                    <td>Tes Akademik</td>
                </tr>

                <tr>
                    <th>Mata Pelajaran Yang Diujikan</th>
                    <td>:</td>
                    <td>
                        {{ $grade->nilai_twk ? 'Wawasan Kebangsaan' : '' }}
                        {{ $grade->nilai_mtk ? ', Matematika' : '' }}
                        {{ $grade->nilai_pu ? ', Pengetahuan Umum' : '' }}
                        {{ $grade->nilai_inggris ? ', Bahasa Inggris' : '' }}
                    </td>
                </tr> 
            </tbody>
        </table>
        <br>
        <table width="100%" border="1">
            <thead>
                <tr>
                    <td width="10%">No</td>
                    <td width="35%">Mata Pelajaran</td>
                    <td width="30%">Keterangan</td>
                    <td width="25%" align="right">Nilai</td>
                </tr>
            </thead>

            @php
                $arrayLabel = ['Wawasan Kebangsaan', 'Matematika', 'Pengetahuan Umum', 'Bahasa Inggris'];
                $arrayGrade = ['twk','mtk', 'pu', 'inggris'];   
            @endphp
            <tbody>
                @php
                    $no = 1;
                @endphp
                @for ($i = 0; $i < count($arrayGrade); $i++)
                    @if ($grade->{'nilai_'.$arrayGrade[$i]})
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $arrayLabel[$i] }}</td>
                            <td>{{ $grade->{$arrayGrade[$i].'_ke'} ? 'Try Out Ke '.$grade->{$arrayGrade[$i].'_ke'} : '-' }}</td>
                            <td align="right">{{ $grade->{'nilai_'.$arrayGrade[$i]} }}</td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endif
                @endfor
                @if (!empty($grade->nilai_twk) & !empty($grade->nilai_pu) && !empty($grade->nilai_mtk) && !empty($grade->nilai_inggris))
                    <tr>
                        <th colspan="3">Nilai Akhir</th>
                        <th style="text-align: right;">{{ ($grade->nilai_twk * (35/100)) + ($grade->nilai_pu * (30/100)) + ($grade->nilai_mtk * (20/100)) + ($grade->nilai_inggris * (15/100)) }}</th>
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <table align="right">
                        <tr>
                            <td align="center"><b>{{ dateFormat(\Carbon\Carbon::now(), 'd F Y')  }}</b></td>
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