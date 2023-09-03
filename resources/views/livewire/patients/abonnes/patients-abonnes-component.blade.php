<div class="col-md-12">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="modal-title text-bold text-primary" id="my-modal-title">
                <span style="font-size: 20px;">LISTE DES PATIENTS ABONNES</span>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-controls mt-2">
                <div class="d-flex justify-content-between">
                    <div class="w-25">
                        <div class="card-tools w-100 ml-2">
                            <div class="input-group input-group-sm">
                                <input wire:model='keySearch' type="text" class="form-control"
                                    placeholder="Recheche ici...">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-auto ml-auto mb-4">
                                Afficher
                                <select wire:model.lazy='page_number' class="custom-select w-auto" name="">
                                    @for ($i = 10; $i <= 100; $i += 10)
                                        )
                                        <option>{{ $i }}</option>
                                    @endfor
                                </select>
                                par page
                            </div>
                        </div>
                    </div>
                    <div class="mr-2">
                        @if (Auth::user()->role->name == 'Admin' or Auth::user()->role->name == 'Receptioniste')
                            <button data-toggle="modal" data-target="#AddPatientAbonneModal"
                                class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"
                                    aria-hidden="true"></i> Nouveau</button>
                        @endif

                    </div>
                </div>
            </div>

            <div class="mt-2">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>{{ session('message') }}
                    </div>
                @endif
                @if ($patients->isEmpty())
                    <div class="text-center mt-4 p-4">
                        <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée
                        </h3>
                    </div>
                @else
                    <table class="table table-striped table-sm">
                        <thead class="thead-dark">
                            <tr>
                            <tr>
                                <th>#</th>
                                <th>NUM FICHE</th>
                                <th>NOM COMPLET DU PATIENT</th>
                                <th class="text-center">GENRE</th>
                                <th class="text-center">AGE</th>
                                <th class="text-center">SOCIETE</th>
                                <th class="text-center">TYPE</th>
                                <th class="text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $index => $patient)
                                @if ($patient->fiche == null)
                                @else
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $patient->fiche->numero }}</td>
                                        <td>{{ $patient->Nom . ' ' . $patient->Postnom . ' ' . $patient->Prenom }} /
                                            <span class="text-danger">{{ $patient->Matricule }}</span></td>
                                        <td class="text-center">{{ $patient->Sexe }}</td>
                                        <td class="text-center">{{ $patient->getAge($patient->id) }}</td>
                                        <td class="text-center">{{ $patient->abonnement->name }}</td>
                                        <td class="text-center">{{ $patient->Type }}</td>

                                        <td class="text-right">
                                            @if (Auth::user()->role->name == 'Admin')
                                                <button wire:click='show({{ $patient->id }})' data-toggle="modal"
                                                    data-target="#DmdConsDModal" class="btn btn-link btn-sm"
                                                    type="button">

                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='edit({{ $patient->id }})'
                                                    class="btn btn-link btn-sm" data-toggle="modal"
                                                    data-target="#EditPatientAbonneModal" type="button">

                                                    <i class="fas fa-edit    "></i>
                                                </button>
                                                <button wire:click='showDestroy({{ $patient->id }})'
                                                    class="btn btn-link btn-sm text-danger" type="button">

                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='getData({{ $patient->id }})'
                                                    class="btn btn-link btn-sm text-dark" data-toggle="modal"
                                                    data-target="#updateModal" type="button">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                            @elseif(Auth::user()->role->name == 'Receptioniste')
                                                <button wire:click='show({{ $patient->id }})' data-toggle="modal"
                                                    data-target="#DmdConsDModal" class="btn btn-link btn-sm"
                                                    type="button">

                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='edit({{ $patient->id }})'
                                                    class="btn btn-link btn-sm" data-toggle="modal"
                                                    data-target="#EditPatientAbonneModal" type="button">

                                                    <i class="fas fa-edit    "></i>
                                                </button>
                                                <button wire:click='getData({{ $patient->id }})'
                                                    class="btn btn-link btn-sm text-dark" data-toggle="modal"
                                                    data-target="#updateModal" type="button">
                                                    <i class="fas fa-cogs"></i>
                                                    <button wire:click='showDestroy({{ $patient->id }})'
                                                        class="btn btn-link btn-sm text-danger" type="button">

                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </button>
                                            @else
                                                <button wire:click='show({{ $patient->id }})' data-toggle="modal"
                                                    data-target="#DmdConsDModal" class="btn btn-link btn-sm"
                                                    type="button">

                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>

        </div>
        @include('livewire.patients.abonnes.create-patient')
        @include('livewire.patients.abonnes.modals.demande-abonne')
        @include('livewire.patients.abonnes.edit-patient-abonne')
        @include('livewire.patients.abonnes.modals.update-infos')
    </div>
</div>
