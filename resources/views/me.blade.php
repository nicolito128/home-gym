<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel | {{ config('app.name', '/HOME/GYM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
    <main class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-6 border-b border-stone-800 pb-8 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-amber-300">Panel de Usuario</p>
                <h1 class="mt-3 text-4xl font-black text-stone-50">Bienvenido, {{ auth()->user()->username }}.</h1>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="rounded-full border border-stone-700 px-5 py-3 text-sm font-semibold text-stone-100 transition hover:border-stone-500">Inicio</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-full bg-amber-300 px-5 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-200">Cerrar sesion</button>
                </form>
            </div>
        </header>

        <section class="grid gap-5 py-10 lg:grid-cols-[1.2fr_0.8fr]">
            
            <div class="grid gap-5">
                <article class="rounded-4xl border border-amber-400/30 bg-amber-300/10 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-amber-200">Usuario actual</p>
                    <dl class="mt-4 space-y-3 text-sm text-stone-200">
                        <div>
                            <dt class="text-stone-400">Nombre</dt>
                            <dd class="text-lg font-semibold text-stone-50">{{ auth()->user()->username }}</dd>
                        </div>
                        <div>
                            <dt class="text-stone-400">Correo</dt>
                            <dd>{{ auth()->user()->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-stone-400">Alta</dt>
                            <dd>{{ auth()->user()->created_at?->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </article>
            </div>
        </section>
    </main>
</body>
</html>