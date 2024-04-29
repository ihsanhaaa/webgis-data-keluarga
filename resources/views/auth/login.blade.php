<!DOCTYPE html>
<html>
<title>Masuk</title>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#baffae] p-5">
	<div class="p-10 max-w-md mx-auto my-auto border bg-green-50 rounded-t-full">
		<div class="flex justify-center">
			<a href="{{ url('/') }}">
				<img class="w-32" src="{{ asset('assets/images/images.png') }}">
			</a>
		</div>
		</h2>
		<h1 class="text-black text-2xl font-bold p-5">
			<p class="text-center text-2xl">Selamat Datang</p>
			<p class="text-center text-base">Silahkan masuk untuk melanjutkan</p>
		</h1>
		<form method="POST" action="{{ route('login') }}">
			@csrf
			<div class="mb-4">
				<input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" placeholder="Email" />

				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<div class="mb-4">
				<input type="password" id="password" name="password" required autocomplete="current-password" class="block w-full border border-gray-400 rounded px-3 py-1 mt-1" placeholder="Password" />

				@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			<p class="mt-4 text-gray-600">
				<a href="{{ route('password.request') }}" class="text-[#5eb24f]">
					<p class="text-right p-2">Lupa Password?</p>
				</a>
			</p>
			<button id="masuk" type="submit" class="bg-[#5eb24f] text-white font-bold px-4 py-2 rounded w-full">
				Masuk
			</button>
			<p class="mt-4 text-center">Belum Memiliki Akun?
				<a href="{{ route('register') }}" class="text-[#5eb24f]">Daftar Sekarang
				</a>
			</p>
			</p>
		</form>
	</div>
</body>

</html>