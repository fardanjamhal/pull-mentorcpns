<header id="header" class="d-flex align-items-center header-scrolled">
  <div class="container-fluid container-xxl d-flex align-items-center">

    <div id="logo" class="me-auto">
      <!-- Uncomment below if you prefer to use a text logo -->
       <h1><a>Trisula <span>Training Center</span></a></h1>
      {{-- <a href="index.html" class="scrollto"><img src="{{ asset('assets/landing-page/theme_2/assets/img/logo') }}" alt="" title=""></a> --}}
    </div>

    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>
        <li><a class="nav-link scrollto {{ Route::is('home') ? "active" : "" }}" href="{{ route('home') }}">Beranda</a></li>
        <li><a class="nav-link scrollto" href="{{ route('home') }}#about">Tentang</a></li>
        <li><a class="nav-link scrollto" href="{{ route('home') }}#speakers">Alumni</a></li>
        <li><a class="nav-link scrollto" href="{{ route('home') }}#gallery">Galeri</a></li>
        <li><a class="nav-link scrollto {{ Route::is('landing_page.physical-calculations') ? "active" : "" }}" href="{{ route('landing_page.physical-calculations') }}">Kalkulator Jasmani POLRI</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
    <a class="buy-tickets scrollto" href="{{ route('login') }}">Login</a>

  </div>
</header><!-- End Header -->