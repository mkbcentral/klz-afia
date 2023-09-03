<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">LISTE PATIENTS PERSONNELS</span>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls p-2">
                <div class="d-flex justify-content-between">
                    <div class="w-25 ">
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                              <input wire:model='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
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
                                <select wire:model.lazy='page_number'  class="custom-select w-auto" name="">
                                    @for ($i=10;$i<=100;$i+=10))
                                        <option>{{$i}}</option>
                                    @endfor
                                </select>
                                par page
                            </div>
                        </div>
                    </div>
                    <div>
                        @if (Auth::user()->role->name=='Admin' or Auth::user()->role->name=='Receptioniste')
                            <button data-toggle="modal" data-target="#addAyantDroitModal" class="btn btn-info btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nouveau</button>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>{{ session('message') }}
                        </div>
                    @endif
                    @if ($personnels->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                        <table class="table table-striped table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NUM FICHE</th>
                                    <th>NOM COMPLET DU PATIENT</th>
                                    <th class="text-center">GENRE</th>
                                    <th class="text-center">AGE</th>
                                    <th class="text-center">TYPE</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personnels as $index => $personnel)
                                   @if ($personnel->fiche==null)

                                   @else
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$personnel->fiche->numero}}</td>
                                        <td>{{$personnel->Nom.' '.$personnel->Postnom.' '.$personnel->Prenom}}</td>
                                        <td class="text-center">{{$personnel->Sexe}}</td>
                                        <td class="text-center">{{$personnel->getAge($personnel->id)}}</td>
                                        <td class="text-center">{{$personnel->Type}}</td>
                                        <td class="text-right">
                                            @if (Auth::user()->role->name=='Admin')
                                                <button wire:click='show({{$personnel->id}})' data-toggle="modal"
                                                    data-target="#DmdConsPersonnelDModal" class="btn btn-link btn-sm" type="button">

                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='edit({{$personnel->id}})' class="btn btn-link btn-sm" data-toggle="modal"
                                                    data-target="#EditAyantDroitModal" type="button">

                                                    <i class="fas fa-edit    "></i>
                                                </button>
                                                <button wire:click='showDestroy({{$personnel->id}})' class="btn btn-link btn-sm text-danger" type="button">

                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='getData({{$personnel->id}})' class="btn btn-link btn-sm text-dark"
                                                    data-toggle="modal" data-target="#updatPersonnelInfoeModal" type="button">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                            @elseif (Auth::user()->role->name=='Receptioniste')
                                                <button wire:click='show({{$personnel->id}})' data-toggle="modal"
                                                    data-target="#DmdConsPersonnelDModal" class="btn btn-link btn-sm" type="button">

                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <button wire:click='edit({{$personnel->id}})' class="btn btn-link btn-sm" data-toggle="modal"
                                                    data-target="#EditAyantDroitModal" type="button">

                                                    <i class="fas fa-edit    "></i>
                                                </button>
                                                <button wire:click='getData({{$personnel->id}})' class="btn btn-link btn-sm text-dark"
                                                    data-toggle="modal" data-target="#updatPersonnelInfoeModal" type="button">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                                <button wire:click='showDestroy({{$personnel->id}})' class="btn btn-link btn-sm text-danger" type="button">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <button wire:click='show({{$personnel->id}})' data-toggle="modal"
                                                    data-target="#DmdConsPersonnelDModal" class="btn btn-link btn-sm" type="button">

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

        </div>

        </div>
        <!-- /.card  -->
      </div>
    @include('livewire.patients.personnels.create-personne-patient')
    @include('livewire.patients.personnels.edit-personnel-patient')
    @include('livewire.patients.personnels.modals.demande-personnel')
    @include('livewire.patients.personnels.modals.update-personnel-inofs')
</div>
