<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Iniciar sesion | {{ config('app.name', '/home/gym') }}</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
	<main class="grid min-h-screen lg:grid-cols-[0.95fr_1.05fr]">
		<section class="hidden bg-[linear-gradient(180deg,rgba(251,191,36,0.14),rgba(12,10,9,0.96)),radial-gradient(circle_at_top,rgba(251,191,36,0.2),transparent_40%)] p-12 lg:flex lg:flex-col lg:justify-between">
			<a href="{{ route('home') }}" class="text-lg font-semibold uppercase tracking-[0.3em] text-amber-300">/home/gym</a>
			<div class="max-w-md space-y-5">
				<p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-300">Bienvenido de nuevo</p>
				<h1 class="text-5xl font-black leading-none text-stone-50">Entra a tu plan y retoma la proxima sesion.</h1>
				<p class="text-base leading-8 text-stone-300">Accede a tu espacio privado para revisar rutinas y ejercicios.</p>
			</div>
			<p class="text-sm leading-7 text-stone-400"></p>
		</section>

		<section class="flex items-center justify-center px-6 py-12 sm:px-10">
			<div class="w-full max-w-md rounded-3xl border border-stone-800 bg-stone-900/85 p-8 shadow-2xl shadow-black/40 backdrop-blur">
				<div class="mb-8 space-y-2 text-center lg:text-left">
					<a href="{{ route('home') }}" class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300 lg:hidden">/home/gym</a>
					<h2 class="text-3xl font-bold text-stone-50">Iniciar sesion</h2>
				</div>

				<form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
					@csrf
					<div class="space-y-2">
						<label for="email" class="text-sm font-medium text-stone-200">Correo</label>
						<input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition placeholder:text-stone-500 focus:border-amber-300" placeholder="vos@email.com">
						@error('email')
							<p class="text-sm text-rose-300">{{ $message }}</p>
						@enderror
					</div>

					<div class="space-y-2">
						<label for="password" class="text-sm font-medium text-stone-200">Contrasena</label>
						<input id="password" name="password" type="password" required class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition focus:border-amber-300" placeholder="********">
					</div>

					<label class="flex items-center gap-3 text-sm text-stone-300">
						<input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-stone-600 bg-stone-950 text-amber-300 focus:ring-amber-300">
						Mantener sesion iniciada
					</label>

					<button type="submit" class="w-full rounded-2xl bg-amber-300 px-4 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-stone-950 transition hover:bg-amber-200">Entrar</button>
				</form>

				<p class="mt-6 text-center text-sm text-stone-400 lg:text-left">No tienes cuenta? <a href="{{ route('register') }}" class="font-semibold text-amber-300 hover:text-amber-200">Registrate</a></p>
			</div>
		</section>
	</main>
</body>
</html>
