<table>
    <thead>
        <th width="10">NO</th>
        
        @if($questionTitle->assessment_type == 1)
            <th width="20">KATEGORI_PENILAIAN</th>
        @endif

        <th width="20">SOAL</th>

        @for($i = 0; $i < $questionTitle->total_choices; $i++)
            <th width="15">PILIHAN_{{ chr(65 + $i) }}</th>
        @endfor

        @if($questionTitle->assessment_type != 4)
            <th width="10">JAWABAN</th>
        @endif

        @if($questionTitle->assessment_type == 4)
            @for($i = 0; $i < $questionTitle->total_choices; $i++)
                <th width="25">BOBOT_JAWABAN_{{ chr(65 + $i) }}</th>
            @endfor
        @endif

        @if($questionTitle->assessment_type == 3)
            <th width="25">POIN_JAWABAN_BENAR</th>
        @endif
    </thead>
</table>