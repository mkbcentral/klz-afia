<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-danger card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">CREATION D'UN PATIENT PAR FORFAIT</span>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls mb-2">
                <div class="d-flex justify-content-between">
                    <div class="w-25">
                        <div class="card-tools">
                            <div class="input-group">
                                <select wire:model.defer='socity_name' class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                  <option selected>Choisir la société...</option>
                                  @foreach ($societes as $societe)
                                    <option wire:click='selectSocieteItem' value="{{$societe->name}}">{{$societe->name}}</option>
                                  @endforeach
                                </select>
                                <div class="input-group-append">
                                  <button wire:click='selectSocieteItem' class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                                </div>
                              </div>
                        </div>
                    </div>
                    @if ($isSelected==true)
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
                            <button data-toggle="modal" data-target="#addPatientForfait" class="btn btn-dark btn-sm" type="button">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Nouveau
                            </button>
                        </div>
                    @endif

                </div>
                <div class="mt-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>{{ session('message') }}
                        </div>
                    @endif
                </div>
                @if ($isSelected==true)
                    <div class="d-flex justify-content-center">
                        <div class="w-50">
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                <input wire:model.debounce.500ms='keySearch'
                                    type="text" class="form-control" placeholder="Recheche ici...">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if ($famillies->isEmpty())
                            <div class="text-center mt-4 p-4">
                                <h3 class="text-success"><i class="fa fa-database"
                                     aria-hidden="true"></i> Aunce donnée trouvée</h3>
                            </div>
                        @else
                            <table class="table table-light table-striped table-sm mt-4">
                                <thead class="thead-light">
                                    <tr>
                                        <th>NOM FAMILLE</th>
                                        <th class="text-center">MATRICULE</th>
                                        <th class="text-center">SOCIETE</th>
                                        <th class="text-center">NOMBRE</th>
                                        <th class="text-center">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>

                                       @foreach ($famillies as $familly)
                                            <tr>
                                                <td class="text-left"><i class="fas fa-user-friends text-info"></i>  {{' '.$familly->name}}</td>
                                                <td class="text-center">{{$familly->matricule}}</td>
                                                <td class="text-center">{{$familly->society->name}}</td>
                                                <td class="text-center">{{$familly->membres->count()}}</td>
                                                <td class="text-center">
                                                    <button wire:click='edit({{$familly->id}})'
                                                         class="btn btn-info btn-sm" type="button"
                                                         data-toggle="modal" data-target="#editPatientForfait">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                    <button wire:click='show({{$familly->id}})'
                                                        class="btn btn-secondary btn-sm" type="button"
                                                        data-toggle="modal" data-target="#addInFamilyModal">
                                                        <i class="fas fa-user-plus"></i>
                                                    </button>
                                                    <button wire:click='getMemberFamilly({{$familly->id}})'
                                                        class="btn btn-success btn-sm" type="button"
                                                        data-toggle="modal" data-target="#showMemberModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button wire:click='showDestroyFamillyDialog({{$familly->id}})'
                                                        class="btn btn-danger btn-sm" type="button">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                       @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif

          </div>
        </div>
        </div>
        <!-- /.card -->
        {{ $famillies->links('pagination::bootstrap-4') }}
    </div>
      <!-- /.col -->
@include('livewire.patients.forfait.create-patient-forfait')
@include('livewire.patients.forfait.edit-patient-forfait')
@include('livewire.patients.forfait.add-in-famally')
@include('livewire.patients.forfait.show-memember')
</div>
