<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" data-turbolinks-action="replace" class="brand-link">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>

    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @auth

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        @if (Auth::user()->role->name == 'Super-Admin')
                            <x-nav-link class="nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{ __('Dashboard') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('patients') }}" :active="request()->routeIs('patients')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Gestion des patients') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('demandes') }}" :active="request()->routeIs('demandes')">
                                <i class="far fa-newspaper"></i>
                                <p>
                                    {{ __('Historique demandes') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('facturation') }}" :active="request()->routeIs('facturation')">
                                <i class="fas fa-copy"></i>
                                <p>
                                    {{ __('Factures journalière') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('historique') }}" :active="request()->routeIs('historique')">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    {{ __('Historique factures') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('speciales') }}" :active="request()->routeIs('speciales')">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    {{ __('Demandes speciales') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('pharmacie') }}" :active="request()->routeIs('pharmacie')">
                                <i class="fas fa-capsules"></i>
                                <p>
                                    {{ __('Gestionaire pharmacie') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('pharmacie.facturation') }}" :active="request()->routeIs('pharmacie.facturation')">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    {{ __('Facturation pharmacie') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('pharmacie.rapport') }}" :active="request()->routeIs('pharmacie.rapport')">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    {{ __('Rapport pharmacie') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('stock.index') }}" :active="request()->routeIs('stock.index')">
                                <i class="fas fa-folder-open"></i>
                                <p>
                                    {{ __('Gestion de stock') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('labo') }}" :active="request()->routeIs('labo')">
                                <i class="fas fa-user-circle"></i>
                                <p>
                                    {{ __('Laboratoire') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('finance') }}" :active="request()->routeIs('finance')">
                                <i class="fas fa-coins"></i>
                                <p>
                                    {{ __('Ficnaces') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('admin') }}" :active="request()->routeIs('admin')">
                                <i class="fas fa-user-cog"></i>
                                <p>
                                    {{ __('Administration') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('rapport.mensuel') }}" :active="request()->routeIs('rapport.mensuel')">
                                <i class="fas fa-capsules"></i>
                                <p>
                                    {{ __('Rapport mensuel') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('pharmacie.trash') }}" :active="request()->routeIs('pharmacie.trash')">
                                <i class="fas fa-capsules"></i>
                                <p>
                                    {{ __('Ma corbeille') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('rdvs') }}" :active="request()->routeIs('rdvs')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Rendez-vous-medical') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('tarification') }}" :active="request()->routeIs('tarification')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Tarification') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('tarification.liste') }}" :active="request()->routeIs('tarification.liste')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Grille rarifaire') }}
                                </p>
                            </x-nav-link>
                        @elseif (Auth::user()->role->name == 'Admin')
                        <x-nav-link class="nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('Dashboard') }}
                            </p>
                        </x-nav-link>
                        <x-nav-link class="nav-link" href="{{ route('historique') }}" :active="request()->routeIs('historique')">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                {{ __('Historique factures') }}
                            </p>
                        </x-nav-link>
                        <x-nav-link class="nav-link" href="{{ route('speciales') }}" :active="request()->routeIs('speciales')">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                {{ __('Demandes speciales') }}
                            </p>
                        </x-nav-link>
                        <x-nav-link class="nav-link" href="{{ route('pharmacie') }}" :active="request()->routeIs('pharmacie')">
                            <i class="fas fa-capsules"></i>
                            <p>
                                {{ __('Gestionaire pharmacie') }}
                            </p>
                        </x-nav-link>
                       
                        <x-nav-link class="nav-link" href="{{ route('admin') }}" :active="request()->routeIs('admin')">
                            <i class="fas fa-user-cog"></i>
                            <p>
                                {{ __('Administration') }}
                            </p>
                        </x-nav-link>
                    
                        <x-nav-link class="nav-link" href="{{ route('tarification') }}" :active="request()->routeIs('tarification')">
                            <i class="fas fa-users"></i>
                            <p>
                                {{ __('Tarification') }}
                            </p>
                        </x-nav-link>
                        <x-nav-link class="nav-link" href="{{ route('tarification.liste') }}" :active="request()->routeIs('tarification.liste')">
                            <i class="fas fa-users"></i>
                            <p>
                                {{ __('Grille rarifaire') }}
                            </p>
                        </x-nav-link>
                        @elseif (Auth::user()->role->name == 'Receptioniste')
                            <x-nav-link class="nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{ __('Dashboard') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('patients') }}" :active="request()->routeIs('patients')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Gestion des patients') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('demandes') }}" :active="request()->routeIs('demandes')">
                                <i class="far fa-newspaper"></i>
                                <p>
                                    {{ __('Historique demandes') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('rdvs') }}" :active="request()->routeIs('rdvs')">
                                <i class="fas fa-users"></i>
                                <p>
                                    {{ __('Rendez-vous-medical') }}
                                </p>
                            </x-nav-link>
                        @elseif (Auth::user()->role->name == 'Medecin')
                            <x-nav-link class="nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{ __('Dashboard') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('file.attente') }}" :active="request()->routeIs('file.attente')">
                                <i class="fa fa-step-forward" aria-hidden="true"></i>
                                <p>
                                    {{ __("File d'attente") }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('demandes') }}" :active="request()->routeIs('demandes')">
                                <i class="far fa-newspaper"></i>
                                <p>
                                    {{ __('Historique demandes') }}
                                </p>
                            </x-nav-link>
                            <x-nav-link class="nav-link" href="{{ route('hospitalisation') }}" :active="request()->routeIs('hospitalisation')">
                                <i class="fas fa-hospital    "></i>
                                <p>
                                    {{ __('Hospitalisation') }}
                                </p>
                            </x-nav-link>
                        @endif
                        <x-nav-link class="nav-link" href="{{ route('user.profil') }}" :active="request()->routeIs('user.profil')">
                            <i class="fas fa-user-circle"></i>
                            <p>
                                {{ __('Mon profil') }}
                            </p>
                        </x-nav-link>
                    </li>
                </ul>
            @endauth
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
