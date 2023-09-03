<x-app-layout>
    @if (Auth::user()->role->name == 'Super-Admin' or Auth::user()->role->name == 'Medecin chef')
        <div>
            @livewire('dashboard-component')
        </div>
    @elseif(Auth::user()->role->name == 'Pharma')
        <div>
            @livewire('dashboard-pharma-component')
        </div>
    @else
        <div>
            @livewire('dashboard-demande-component')
        </div>
    @endif
</x-app-layout>
