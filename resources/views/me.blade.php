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
                <a href="{{ route('calendar') }}" class="rounded-full border border-stone-700 px-5 py-3 text-sm font-semibold text-stone-100 transition hover:border-stone-500">Calendario</a>
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
        <section class="py-6">
            <div class="grid gap-4">
                <article class="rounded-4xl border border-stone-800 p-6">
                    <h2 class="text-lg font-bold">Planes de entrenamiento</h2>

                    <form action="{{ route('plans.store') }}" method="POST" class="mt-4 flex gap-2">
                        @csrf
                        <input name="name" placeholder="Nombre del plan" required class="rounded px-3 py-2 text-white-900" />
                        <button class="rounded bg-amber-300 text-stone-950 px-4 py-2">Crear</button>
                    </form>

                    <div class="mt-6 space-y-4">
                        @if(isset($plans) && $plans->count())
                            @foreach($plans as $plan)
                                <div class="rounded border border-stone-700 p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-semibold">{{ $plan->name }}</h3>
                                            <p class="text-sm text-stone-400">Creado: {{ $plan->created_at?->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <form action="{{ route('exercises.store', ['workout_plan' => $plan->id]) }}" method="POST" class="grid gap-2 sm:grid-cols-2">
                                            @csrf
                                            <input name="name" placeholder="Nombre ejercicio" required class="rounded px-3 py-2 text-white-900" />
                                            <select name="muscle_group" class="rounded px-3 py-2 text-white-400 border-stone-700" required>
                                                <option value="">Seleccionar grupo muscular</option>
                                                <option value="Pecho" {{ old('muscle_group') == 'Pecho' ? 'selected' : '' }}>Pecho</option>
                                                <option value="Espalda" {{ old('muscle_group') == 'Espalda' ? 'selected' : '' }}>Espalda</option>
                                                <option value="Piernas" {{ old('muscle_group') == 'Piernas' ? 'selected' : '' }}>Piernas</option>
                                                <option value="Hombros" {{ old('muscle_group') == 'Hombros' ? 'selected' : '' }}>Hombros</option>
                                                <option value="Biceps" {{ old('muscle_group') == 'Biceps' ? 'selected' : '' }}>Bíceps</option>
                                                <option value="Triceps" {{ old('muscle_group') == 'Triceps' ? 'selected' : '' }}>Tríceps</option>
                                                <option value="Core" {{ old('muscle_group') == 'Core' ? 'selected' : '' }}>Core</option>
                                                <option value="Gluteos" {{ old('muscle_group') == 'Gluteos' ? 'selected' : '' }}>Glúteos</option>
                                                <option value="Full Body" {{ old('muscle_group') == 'Full Body' ? 'selected' : '' }}>Full Body</option>
                                                <option value="Cardio" {{ old('muscle_group') == 'Cardio' ? 'selected' : '' }}>Cardio</option>
                                            </select>
                                            <textarea name="description" placeholder="Descripcion" class="rounded px-3 py-2 text-white-900 col-span-2"></textarea>
                                            <input name="equipment_needed" placeholder="Equipo" class="rounded px-3 py-2 text-white-900" />
                                            <button class="rounded bg-amber-300 text-stone-950 px-4 py-2">Agregar ejercicio</button>
                                        </form>
                                    </div>

                                    @if($plan->exercises->count())
                                        <div class="mt-4 space-y-2">
                                            @foreach($plan->exercises as $exercise)
                                                <div class="rounded border border-stone-800 p-3">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="font-semibold">{{ $exercise->name }}</p>
                                                            <p class="text-sm text-stone-400">{{ $exercise->muscle_group }}</p>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('schedules.store', ['exercise' => $exercise->id]) }}" method="POST" class="mt-3 grid grid-cols-2 gap-2">
                                                        @csrf
                                                        <select name="day_of_week" required class="rounded px-3 py-2 text-white-900">
                                                            <option value="0">Domingo</option>
                                                            <option value="1">Lunes</option>
                                                            <option value="2">Martes</option>
                                                            <option value="3">Miercoles</option>
                                                            <option value="4">Jueves</option>
                                                            <option value="5">Viernes</option>
                                                            <option value="6">Sabado</option>
                                                        </select>
                                                        <input type="time" name="start_at" required class="rounded px-3 py-2 text-white-900" />
                                                        <input type="number" name="repetitions" min="1" placeholder="Repeticiones" class="rounded px-3 py-2 text-white-900" />
                                                        <input type="number" name="breaks" min="0" placeholder="Descansos (seg)" class="rounded px-3 py-2 text-white-900" />
                                                        <div class="col-span-2">
                                                            <button class="rounded bg-amber-300 text-stone-900 px-4 py-2">Asignar al calendario</button>
                                                        </div>
                                                    </form>

                                                    @if($exercise->schedules->count())
                                                        <div class="mt-3 text-sm text-stone-400">
                                                            @foreach($exercise->schedules as $s)
                                                                <div>- {{ ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'][$s->day_of_week] }} {{ \Carbon\Carbon::parse($s->start_at)->format('H:i') }} · x{{ $s->repetitions }} · descanso {{ $s->breaks }}s</div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-stone-400 mt-3">No tienes planes creados aun.</p>
                        @endif
                    </div>
                </article>
            </div>
        </section>
    </main>
</body>
</html>