<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', '/home/gym') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
    <main class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.2),transparent_35%),linear-gradient(135deg,rgba(12,10,9,1),rgba(41,37,36,0.95))]"></div>
        <div class="relative mx-auto flex min-h-screen max-w-6xl flex-col justify-between px-6 py-10 lg:px-12">
            <header class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-[0.25em] uppercase text-amber-300">/home/gym</a>
                <nav class="flex items-center gap-3 text-sm font-medium">
                    @auth
                        <a href="{{ route('me') }}" class="rounded-full border border-stone-700 px-4 py-2 text-stone-100 transition hover:border-amber-300 hover:text-amber-200">Panel</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-full bg-amber-300 px-4 py-2 text-stone-950 transition hover:bg-amber-200">Salir</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-stone-700 px-4 py-2 text-stone-100 transition hover:border-amber-300 hover:text-amber-200">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="rounded-full bg-amber-300 px-4 py-2 text-stone-950 transition hover:bg-amber-200">Crear cuenta</a>
                    @endauth
                </nav>
            </header>

            <section class="grid gap-10 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:py-24">
                <div class="space-y-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-300">Entrena con estructura</p>
                    <div class="space-y-5">
                        <h1 class="max-w-3xl text-5xl font-black leading-none text-stone-50 sm:text-6xl">Organiza rutinas, ejercicios y progreso desde un solo lugar.</h1>
                        <p class="max-w-2xl text-lg leading-8 text-stone-300">/home/gym te da un espacio simple para construir planes de entrenamiento, administrar horarios y mantener tus sesiones bajo control.</p>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ auth()->check() ? route('me') : route('register') }}" class="rounded-full bg-amber-300 px-6 py-3 text-base font-semibold text-stone-950 transition hover:bg-amber-200">{{ auth()->check() ? 'Ir al panel' : 'Empezar ahora' }}</a>
                        <a href="{{ route('login') }}" class="rounded-full border border-stone-700 px-6 py-3 text-base font-semibold text-stone-100 transition hover:border-stone-500">Ya tengo cuenta</a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <article class="rounded-3xl border border-stone-800 bg-stone-900/70 p-6 backdrop-blur">
                        <p class="text-sm uppercase tracking-[0.2em] text-stone-400">Rutinas</p>
                        <h2 class="mt-4 text-2xl font-bold text-stone-50">Planes claros para cada objetivo</h2>
                        <p class="mt-3 text-sm leading-7 text-stone-300">Define bloques de fuerza, hipertrofia o movilidad y adapta cada semana en minutos.</p>
                    </article>
                    <article class="rounded-3xl border border-amber-400/30 bg-amber-300/10 p-6 backdrop-blur">
                        <p class="text-sm uppercase tracking-[0.2em] text-amber-200">Constancia</p>
                        <h2 class="mt-4 text-2xl font-bold text-stone-50">Tu calendario siempre visible</h2>
                        <p class="mt-3 text-sm leading-7 text-stone-200">Revisa que toca hoy, mañana y el resto de la semana sin salir del panel.</p>
                    </article>
                    <article class="rounded-3xl border border-stone-800 bg-stone-900/70 p-6 backdrop-blur sm:col-span-2">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.2em] text-stone-400">Acceso protegido</p>
                                <h2 class="mt-4 text-2xl font-bold text-stone-50">Sesion persistente con autenticación</h2>
                            </div>
                            <span class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">Activo</span>
                        </div>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-stone-300">El acceso al área privada usa el guard web y sesiones de base de datos, con login, registro y cierre de sesión integrado.</p>
                    </article>
                </div>
            </section>
        </div>
    </main>
</body>
</html>