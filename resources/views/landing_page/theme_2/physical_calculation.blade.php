@extends('landing_page.theme_2.layouts.app')

@section('content')
<main id="main">
    <section id="contact" class="section-with-bg" style="margin-top:72px;">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Hitung Nilai Jasmani POLRI</h2>
                <p>Ketahui Nilai Keselurahan Dari Tiap Tes Jasmani POLRI</p>
            </div>

            <div class="form">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Perhatian !</strong> Silakan isi data dengan benar.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('landing_page.physical-calculations.store') }}" method="POST" role="form" class="php-email-form mb-3">
                    @csrf
                    <div class="row">
                        <label class="form-label col-lg-3 col-md-3">Jenis Kelamin</label>
                        <div class="form-group col-lg-9">
                            <select name="sex" class="form-control @error('sex') is-invalid @enderror" id="sex">
                                <option value="1" @selected($errors->any() ? (old('sex') == "1") : (@$sex == "1"))>Pria</option>
                                <option value="0" @selected($errors->any() ? (old('sex') == "0") : (@$sex == "0"))>Wanita</option>
                            </select>
                            @error('sex')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Jarak Lari 12 Menit (Meter)</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="number" name="running" class="form-control @error('running') is-invalid @enderror" placeholder="Lari" min="0" value="{{ old('running', isset($running) ? $running : '') }}">
                            @error('running')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradeRunning }}">
                        </div>
                    </div>

                    <hr class="mt-3 my-3">

                    <div class="row mt-3" id="chinning_form">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Chinning (1 Menit)</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="number" name="chinning" class="form-control @error('chinning') is-invalid @enderror" placeholder="Chinning" min="0" value="{{ old('chinning', isset($chinning) ? $chinning : '') }}">
                            @error('chinning')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradeChinning }}">
                        </div>
                    </div>

                    <div class="row mt-3" id="pull_up_form">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Pull Up (1 Menit)</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="number" name="pull_up" class="form-control @error('pull_up') is-invalid @enderror" placeholder="Pull Up" min="0" value="{{ old('pull_up', isset($pull_up) ? $pull_up : '') }}">
                            @error('pull_up')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradePullUp }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Sit Up (1 Menit)</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="number" name="sit_up" class="form-control @error('sit_up') is-invalid @enderror" placeholder="Sit Up" min="0" value="{{ old('sit_up', isset($sit_up) ? $sit_up : '') }}">
                            @error('sit_up')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradeSitUp }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Push Up (1 Menit)</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="number" name="push_up" class="form-control @error('push_up') is-invalid @enderror" placeholder="Push Up" min="0" value="{{ old('push_up', isset($push_up) ? $push_up : '') }}">
                            @error('push_up')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradePushUp }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Shuttle Run</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="text" name="shuttle_run" class="form-control @error('shuttle_run') is-invalid @enderror" placeholder="Shuttle Run" min="0" value="{{ old('shuttle_run', isset($shuttle_run) ? $shuttle_run : '') }}">
                            @error('shuttle_run')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradeShuttleRun }}">
                        </div>
                    </div>
                    <hr>

                    <div class="row mt-3 mb-3">
                        <label class="form-label col-lg-3 col-md-3 col-sm-12">Renang</label>
                        <div class="form-group col-lg-6 col-md-6 col-8">
                            <input type="text" name="swimming" class="form-control @error('swimming') is-invalid @enderror" placeholder="Renang" min="0" value="{{ old('swimming', isset($swimming) ? $swimming : '') }}">
                            @error('swimming')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-4">
                            <input type="text" class="form-control" placeholder="Nilai" disabled value="Nilai : {{ @$gradeSwimming }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger px-5">Hitung</button> 
                        <a href="{{ route('landing_page.physical-calculations') }}" class="btn btn-warning px-5">Reset</a>
                    </div>
                </form>

                @if (isset($finalGrade))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="text-center">
                            <strong>Hasil Penilaian</strong>
                            <h2 style="font-family:tahoma;">{{ number_format(@$finalGrade, 2) }}</h2>
                        </div>
                        <p>Nilai Kesamaptaan Jasmani (70%) :
                            <strong>
                            @if(isset($finalSamapta))
                                @if(is_float($finalSamapta))
                                    {{ number_format($finalSamapta, 2) }}
                                @else
                                    {{ $finalSamapta }}
                                @endif
                            @else
                                Nilai Tidak Tersedia
                            @endif
                            </strong>
                            <br>
                            Nilai Renang (30%) :
                            <strong>
                                @if(isset($finalSwimming))
                                    @if(is_float($finalSwimming))
                                        {{ number_format($finalSwimming, 2) }}
                                    @else
                                        {{ $finalSwimming }}
                                    @endif
                                @else
                                    Nilai Tidak Tersedia
                                @endif
                            </strong>
                        </p>                        
                    </div>
                @endif
            </div>
        </div>
    </section><!-- End Contact Section -->
</main>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        changeSex("{{ $errors->any() ? old('sex') : (isset($sex) ? $sex : 1) }}");

        $('#sex').on('change', function() {
            changeSex($(this).val());
        });

        function changeSex(sex = 1)
        {
            if(sex == 0) {
                $('#chinning_form').show();
                $('#pull_up_form').hide();
            } else {
                $('#chinning_form').hide();
                $('#pull_up_form').show();
            }
        }
    </script>
@endpush