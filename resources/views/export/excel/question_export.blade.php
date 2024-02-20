<table>
    <thead>
        <tr>
            <th>NO</th>
            
            @if($questionTitle->assessment_type == 1)
                <th width="20">KATEGORI_PENILAIAN</th>
            @endif

            <th width="20">SOAL</th>

            @for($i = 0; $i < $questionTitle->total_choices; $i++)
                <th width="15">PILIHAN_{{ chr(65 + $i) }}</th>
            @endfor

            @if($questionTitle->assessment_type != 4)
                <th>JAWABAN</th>
            @endif

            @if($questionTitle->assessment_type == 4)
                @for($i = 0; $i < $questionTitle->total_choices; $i++)
                    <th width="25">BOBOT_JAWABAN_{{ chr(65 + $i) }}</th>
                @endfor
            @endif

            @if($questionTitle->assessment_type == 3)
                <th width="25">POIN_JAWABAN_BENAR</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($questions as $index => $question)
            <tr>
                <td>{{ $index + 1 }}</td>

                @if($questionTitle->assessment_type == 1)
                    <td>{{ $question->valueCategory->name ?? '-' }}</td>
                @endif

                <td>{{ $question->question }}</td>

                @for($i = 1; $i <= $questionTitle->total_choices; $i++)
                    <td>{{ $question["option_" . $i] }}</td>
                @endfor

                @if($questionTitle->assessment_type != 4)
                    <td>{{ chr(64 + $question->answer) }}</td>
                @endif

                @if($questionTitle->assessment_type == 4)
                    @for($i = 1; $i <= $questionTitle->total_choices; $i++)
                        <td>{{ $question["point_" . $i] }}</td>
                    @endfor
                @endif

                @if($questionTitle->assessment_type == 3)
                    <td>{{ $question->correct_point }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
