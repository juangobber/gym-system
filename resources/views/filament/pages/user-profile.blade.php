@php
    use App\Filament\Resources\Routines\RoutineResource;
@endphp

<x-filament-panels::page>
    <div class="space-y-6">

        {{-- ENCABEZADO --}}
        <x-filament::section>
            <div class="flex items-center gap-4">
                <x-filament::icon
                    icon="heroicon-o-user-circle"
                    class="w-16 h-16 text-gray-400"
                />
                <div>
                    <div class="text-lg font-semibold">
                       Hola, {{ $this->user->name }}!
                    </div>
                    <div class="text-sm">
                        {{ $this->user->email }}
                    </div>
                </div>
            </div>
        </x-filament::section>

        <br>

        {{-- DATOS DE LA CUENTA --}}
        <x-filament::section>
        <x-slot name="heading">Datos de la cuenta</x-slot>

            <div class="space-y-2 text-sm">
                @php
                    $lastPaid = $this->user?->payments()->value('paid_at');
                    $paymentStatus = $lastPaid && \Illuminate\Support\Carbon::parse($lastPaid)->gte(now()->subDays(30)) ? 'Al día' : 'Vencido';
                @endphp
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Nombre completo:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->user?->name }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Correo electrónico:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->user?->email }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">DNI:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->user?->dni ?? '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Teléfono:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $this->user?->phone ?? '—' }}</span>
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Último pago:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $lastPaid ? \Illuminate\Support\Carbon::parse($lastPaid)->format('d/m/Y') : '—' }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Estado de pago:</span>
                    @if($lastPaid)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $paymentStatus === 'Al día' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $paymentStatus }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">Vencido</span>
                    @endif
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex w-48 font-medium text-gray-500 dark:text-gray-400">Rol:</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ data_get($this->user, 'role.name', '—') }}</span>
                </div>
            </div>
        </x-filament::section>

        
        <br>

        {{-- RUTINAS --}}
        <x-filament::section>
            <x-slot name="heading">Rutinas</x-slot>
        <div class="text-sm">
            @forelse ($this->user?->routines as $routine)
                <a
                    href="{{ RoutineResource::getUrl('view', ['record' => $routine]) }}"
                    class="group py-3 px-2 flex items-start justify-between gap-3 w-full rounded-lg transition hover:bg-white/5 focus-visible:bg-white/5 focus-visible:outline-none"
                >
                    <div class="min-w-0">
                        <div class="font-medium text-gray-100">
                            Rutina: {{ $routine->name }}
                        </div>
                        <div class="text-gray-400">
                            Comienzo: {{ $routine->start_date }} — Finalizacion: {{ $routine->end_date ?? '—' }}
                        </div>
                    </div>
                    <x-filament::icon
                        icon="heroicon-m-arrow-top-right-on-square"
                        class="w-5 h-5 text-primary-400 opacity-0 transition group-hover:opacity-100"
                    />
                </a>

                @unless($loop->last)
                    <hr class="my-2 border-t-2 border-white/70 dark:border-white/70">
                @endunless
            @empty
                <div class="text-gray-400">Sin rutinas</div>
            @endforelse
        </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
