@extends('landing_page.theme_2.layouts.app')

@section('content')
  <section id="hero">
      <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
          <img src="{{ asset('assets/landing-page/theme_2/assets/img/logo_trisula.png') }}" alt="" title="" width="150px">
          <br>
          <h1 class="mb-4 pb-0"><span>Trisula Traning Center</span><br>"Jadilah Penerus Bangsa Bersama Kami"</h1>
          <p class="mb-4 pb-0">BIMBINGAN BELAJAR UNTUK PERSIAPAN MASUK POLRI, TNI DAN SEKOLAH KEDINASAN</p>
          <a href="https://wa.me/6282114808100" class="about-btn scrollto" target="_blank">Bergabung Sekarang</a>
      </div>
  </section>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about">
        <div class="container position-relative" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Tentang Trisula</h2>
                    <p>Trisula Training Center Merupakan lembaga bimbingan belajar persiapan masuk TNI, POLRI dan Sekolah Kedinasan meliputi bimbingan Psikologi, Akademik dan Jasmani. Trisula training center merupakan bimbel terakurat se-JABODETABEK.</p>
                </div>
                <div class="col-lg-3">
                    <h3>lokasi</h3>
                    <p>Jl. Aria Santika, No.16, Karawaci, Kota Tangerang</p>
                </div>
                <div class="col-lg-3">
                    <h3>Kontak</h3>
                    <p>
                        Whatsapp: 082114808100 <br>
                        Instagram: bimbel_trisulatrainingcenter
                    </p>
                    <p></p>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Speakers Section ======= -->
    <section id="speakers">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Alumni Siswa Trisula Training Center</h2>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/8.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/6.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/1.png') }}" alt="Speaker 1" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/9.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/2.png') }}" alt="Speaker 2" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/3.png') }}" alt="Speaker 3" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/4.png') }}" alt="Speaker 4" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/5.png') }}" alt="Speaker 5" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/7.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/10.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/11.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/landing-page/theme_2/assets/img/speakers/12.png') }}" alt="Speaker 6" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Speakers Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Galeri</h2>
                <p>Galeri Kegiatan Bimbel Trisula Training Center</p>
            </div>
        </div>

        <div class="gallery-slider swiper">
            <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/1.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/1.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/2.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/2.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/3.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/3.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/4.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/4.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/5.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/5.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/6.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/6.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/7.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/7.jpg') }}" class="img-fluid" alt=""></a></div>
                <div class="swiper-slide"><a href="{{ asset('assets/landing-page/theme_2/assets/img/gallery/8.jpg') }}" class="gallery-lightbox"><img src="{{ asset('assets/landing-page/theme_2/assets/img/gallery/8.jpg') }}" class="img-fluid" alt=""></a></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section><!-- End Gallery Section -->

    <!-- =======  F.A.Q Section ======= -->
    <section id="faq">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Apa saja yang didapat ketika belajar dan berlatih di Trisula Training Center ?</h2>
            </div>

            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-9">
                    <ul class="faq-list">
                        <li>Mendapatkan pembelajaran dan pelatihan Akademik, Psikotes dan Jasmani</li>
                        <li>Pembelajaran sudah menggunakan CAT (Computer Assisted Test)</li>
                        <li>Pembelajaran akan terfokus pada semua bidang tes dengan pembelajaran yang berimbang antara kelas dan lapangan</li>
                        <li>Bimbingan untuk pemeriksaan kesehatan dan jika ada kendala akan dibimbing untuk pengobatan oleh Tenaga Ahli yang kompeten dibidangnya</li>
                        <li>Bimbingan pemberkasan atau surat-surat yang perlu dipersiapkan untuk pendaftaran</li>
                        <li>Pengajar Akademik dan Psikologi yang kompeten dan telah bersertifikasi</li>
                        <li>Pelatih Jasmani dari TNI dan POLRI yang telah memiliki sertifikasi sesuai dengan institusinya</li>
                        <li>Materi yang diberikan adalah materi terupdate setiap tahunnya</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!-- End  F.A.Q Section -->
  </main>
@endsection