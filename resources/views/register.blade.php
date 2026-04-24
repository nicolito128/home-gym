<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Registro | {{ config('app.name', '/home/gym') }}</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
	<main class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
		<section class="flex items-center justify-center px-6 py-12 sm:px-10">
			<div class="w-full max-w-xl rounded-4xl border border-stone-800 bg-stone-900/85 p-8 shadow-2xl shadow-black/40 backdrop-blur sm:p-10">
				<div class="mb-8 space-y-2">
					<a href="{{ route('home') }}" class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">/home/gym</a>
					<h1 class="text-3xl font-bold text-stone-50 sm:text-4xl">Crear cuenta</h1>
				</div>

				<form action="{{ route('register.store') }}" method="POST" class="grid gap-5 sm:grid-cols-2">
					@csrf
					<div class="space-y-2 sm:col-span-2">
						<label for="username" class="text-sm font-medium text-stone-200">Nombre de usuario</label>
						<input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition placeholder:text-stone-500 focus:border-amber-300" placeholder="entrenador123">
						@error('username')
							<p class="text-sm text-rose-300">{{ $message }}</p>
						@enderror
					</div>

					<div class="space-y-2 sm:col-span-2">
						<label for="email" class="text-sm font-medium text-stone-200">Correo</label>
						<input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition placeholder:text-stone-500 focus:border-amber-300" placeholder="tu@email.com">
						@error('email')
							<p class="text-sm text-rose-300">{{ $message }}</p>
						@enderror
					</div>

					<div class="space-y-2">
						<label for="password" class="text-sm font-medium text-stone-200">Contraseña</label>
						<input id="password" name="password" type="password" required class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition focus:border-amber-300" placeholder="mínimo 8 caracteres">
						@error('password')
							<p class="text-sm text-rose-300">{{ $message }}</p>
						@enderror
					</div>

					<div class="space-y-2">
						<label for="password_confirmation" class="text-sm font-medium text-stone-200">Confirmar contraseña</label>
						<input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-stone-700 bg-stone-950 px-4 py-3 text-stone-100 outline-none transition focus:border-amber-300" placeholder="Repite la contraseña">
					</div>

					<button type="submit" class="sm:col-span-2 rounded-2xl bg-amber-300 px-4 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-stone-950 transition hover:bg-amber-200">Crear cuenta</button>
				</form>

				<p class="mt-6 text-sm text-stone-400">Ya tienes cuenta? <a href="{{ route('login') }}" class="font-semibold text-amber-300 hover:text-amber-200">Inicia sesion</a></p>
			</div>
		</section>

		<section class="hidden bg-[radial-gradient(circle_at_bottom,rgba(251,191,36,0.22),transparent_36%),linear-gradient(180deg,rgba(41,37,36,0.96),rgba(12,10,9,1))] p-12 lg:flex lg:flex-col lg:justify-between">
			<div class="rounded-full border border-amber-300/30 px-4 py-2 text-sm font-semibold uppercase tracking-[0.2em] text-amber-200">Tu gimnasio, tu ritmo</div>
			<div class="space-y-6">
				<h2 class="max-w-md text-5xl font-black leading-none text-stone-50">Empieza con una cuenta y convierte el plan en habito.</h2>
				<p class="max-w-md text-base leading-8 text-stone-300">Despues del registro entraras directo al area protegida para continuar configurando tus entrenamientos.</p>
			</div>
			<div class="grid gap-4">
				<div class="rounded-3xl border border-stone-700 bg-stone-900/40 p-5">
					<p class="text-sm uppercase tracking-[0.2em] text-stone-400">Acceso</p>
					<p class="mt-2 text-lg font-semibold text-stone-100">Sesion segura con autenticacion y regeneracion del identificador de sesion.</p>
				</div>
				<div class="rounded-3xl border border-stone-700 bg-stone-900/40 p-5">
					<p class="text-sm uppercase tracking-[0.2em] text-stone-400">Organizacion</p>
					<p class="mt-2 text-lg font-semibold text-stone-100">Un lugar para administrar ejercicios, planes y agenda.</p>
				</div>
			</div>
		</section>
	</main>
</body>
</html>
