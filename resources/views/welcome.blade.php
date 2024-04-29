@extends('layouts.app')

@section('content')
@push('css-plugins')
<link rel="stylesheet" href="{{ asset('style.css') }}" />
@endpush

@include('components.navbar')

<!-- Main -->
<main>
  <div class="bg-hero"></div>

  <!-- Hero Section -->
  <section id="home">
    <img src="../assets/images/landing-page/HeroIllustration.svg" alt="welcome" class="img-welcome">

    <div>
      <h1 class="text-h1">BBDP Sambas</h1>

      <p id="description" class="text-hero-p">Sistem Informasi BDDP Sambas.</p>

      <a href="{{ route('login') }}"><button class="btn btn-primary">Masuk</button></a>
    </div>
  </section>

  <!-- Service Section -->
  <section id="service">
    <h1 class="text-h1"></h1>

    <div class="card-container">
      <div class="card">
        <img src="{{ asset('assets/images/landing-page/Card1.svg') }}" alt="Card1" class="card1">
        <p class="text-card"></p>
      </div>

      <div class="card">
        <img src="{{ asset('assets/images/landing-page/Card2.svg') }}" alt="Card2" class="card2">
        <p class="text-card"></p>
      </div>

      <div class="card">
        <img src="{{ asset('assets/images/landing-page/Card3.svg') }}" alt="Card3" class="card3">
        <p class="text-card"></p>
      </div>
    </div>
  </section>

  <!-- Tentang Section -->
  <section id="tentang">
    <div class="item-tentang">
      <img src="{{ asset('assets/images/landing-page/Tentang1.png') }}" alt="Tentang1" class="img-tentang1">

      <div>
        <h2 class="text-tentang-h2"></h2>

        <p class="text-tentang-p"></p>

        <a href="#"><button class="btn btn-primary btn-tentang">Lihat</button></a>
      </div>
    </div>

    <div class="item-tentang">
      <img src="{{ asset('assets/images/landing-page/Tentang2.png') }}" alt="Tentang2" class="img-tentang2">

      <div>
        <h2 class="text-tentang-h2"></h2>

        <p class="text-tentang-p"></p>

        <a href="#"><button class="btn btn-primary btn-tentang">Lihat</button></a>
      </div>
    </div>
  </section>

  <!-- Form Kontak -->
  <section id="form-section">
    <div class="form-container">
      <h3 class="text-form-title">Dapatkan Informasi Terbaru BBDP Sambas</h3>

      <form action="" id="form">
        <div class="input-container">
          <label for="name" class="label">Nama</label>
          <input class="p-2" type="text" name="name" id="name" required>
        </div>

        <div class="input-container">
          <label for="city" class="label">Kota</label>
          <input class="p-2" type="text" name="city" id="city">
        </div>

        <div class="input-container">
          <label for="email" class="label">Email</label>
          <input class="p-2" type="email" name="email" id="email" required>
        </div>

        <div class="input-container">
          <label for="zip-code" class="label">Zip Code</label>
          <input class="p-2" type="number" name="zipCode" id="zip-code" min="0" oninput="this.value = Math.abs(this.value)">
        </div>

        <div class="spanning">
          <div class="input-container checkbox">
            <input type="checkbox" name="status" id="status">

            <label for="status" id="check">Dengan ini saya menyatakan data yang diisi pada form ini adalah benar dan telah sesuai</label>
          </div>

          <div class="input-container">
            <button type="submit" id="submit-form" class="btn btn-primary bg-[#5eb24f]">Submit</button>
          </div>
        </div>

        <div id="warning"></div>
      </form>
    </div>
  </section>
</main>

@include('components.footer')
@endsection