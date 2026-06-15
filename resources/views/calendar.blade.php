<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario | {{ config('app.name', '/HOME/GYM') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
    <main class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Calendario semanal</h1>
            <a href="{{ route('me') }}" class="rounded-full border border-stone-700 px-4 py-2">Volver</a>
        </header>

        <section class="mb-6">
            <h2 class="mb-3 font-semibold">Ejercicios (arrastra al día)</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($exercises as $ex)
                    <div draggable="true" data-exercise-id="{{ $ex->id }}" class="cursor-grab rounded border border-stone-700 px-3 py-2 bg-stone-900/40">
                        <strong class="block">{{ $ex->name }}</strong>
                        <small class="text-stone-400">{{ $ex->muscle_group }}</small>
                    </div>
                @endforeach
            </div>
        </section>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="grid grid-cols-7 gap-4">
            @php $days = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado']; @endphp
            @for($i = 0; $i < 7; $i++)
                <div class="rounded border border-stone-800 p-4" data-day="{{ $i }}">
                    <h2 class="mb-3 font-semibold">{{ $days[$i] }}</h2>

                    @if(isset($grouped[$i]) && $grouped[$i]->count())
                        <ul class="space-y-2 text-sm">
                            @foreach($grouped[$i] as $s)
                                <li class="rounded bg-stone-900/40 p-2">
                                    <div class="font-medium">{{ \Carbon\Carbon::parse($s->start_at)->format('H:i') }} — {{ $s->exercise->name }}</div>
                                    <div class="text-stone-400 text-xs">Plan: {{ $s->exercise->workoutPlan->name }} · x{{ $s->repetitions }} · descanso {{ $s->breaks }}s</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-stone-500 no-assignments">Sin asignaciones</p>
                    @endif
                </div>
            @endfor
        </div>

        <script>
            (function(){
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                document.querySelectorAll('[draggable="true"]').forEach(item => {
                    item.addEventListener('dragstart', (e) => {
                        e.dataTransfer.setData('text/plain', item.dataset.exerciseId);
                    });
                });

                document.querySelectorAll('[data-day]').forEach(day => {
                    day.addEventListener('dragover', (e) => e.preventDefault());
                    day.addEventListener('drop', async (e) => {
                        e.preventDefault();
                        const exerciseId = e.dataTransfer.getData('text/plain');
                        const dayOfWeek = day.dataset.day;

                        const startAt = prompt('Hora de inicio (HH:MM)', '07:00');
                        if (!startAt) return;
                        const repetitions = prompt('Repeticiones (número)', '3') || 1;
                        const breaks = prompt('Descansos en segundos', '60') || 0;

                        const form = new FormData();
                        form.append('day_of_week', dayOfWeek);
                        form.append('start_at', startAt);
                        form.append('repetitions', repetitions);
                        form.append('breaks', breaks);

                        const res = await fetch(`/exercises/${exerciseId}/schedules`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: form
                        });

                        if (!res.ok) { alert('Error al asignar horario'); return; }

                        const data = await res.json();
                        const s = data.schedule;

                        // append to the day list
                        // remove "Sin asignaciones" placeholder if present
                        const placeholder = day.querySelector('.no-assignments');
                        if (placeholder) placeholder.remove();

                        let ul = day.querySelector('ul');
                        if (!ul) {
                            ul = document.createElement('ul');
                            ul.className = 'space-y-2 text-sm';
                            day.appendChild(ul);
                        }

                        const li = document.createElement('li');
                        li.className = 'rounded bg-stone-900/40 p-2';
                        li.innerHTML = `<div class="font-medium">${s.start_at} — ${s.exercise.name}</div><div class="text-stone-400 text-xs">Plan: ${s.exercise.workout_plan.name} · x${s.repetitions} · descanso ${s.breaks}s</div>`;
                        ul.appendChild(li);
                    });
                });
            })();
        </script>
    </main>
</body>
</html>
