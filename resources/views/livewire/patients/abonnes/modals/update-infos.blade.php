<div wire:ignore.self id="updateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

               <div class="card">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>{{ session('message') }}
                        </div>
                    @endif
                    <div class="card-header">
                        <h3 class="text-center text-primary">
                            <i class="fas fa-cogs"></i>
                            <strong>MISE A JOUR AVANCEE</strong>
                        </h3>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                    href="#pills-home" role="tab" aria-controls="pills-home"
                                    aria-selected="true">
                                    <i class="fas fa-users-cog"></i> Mise à jour fiche
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                    href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="false">
                                    <i class="fas fa-tools"></i>
                                    Mise à jour société
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                @if ($patient_data_abonne_to_update_deep != null)
                                    <div><strong>Noms: </strong>{{$patient_data_abonne_to_update_deep->Nom.' '.$patient_data_abonne_to_update_deep->Prenom}}</div>
                                    <div><strong>Sexe: </strong>{{$patient_data_abonne_to_update_deep->Sexe}}</div>
                                    <div><strong>Age: </strong>{{$patient_data_abonne_to_update_deep->getAge($patient_data_abonne_to_update_deep->id)}}</div>
                                    <div><strong>Société: </strong>{{$patient_data_abonne_to_update_deep->abonnement->name}}</div>
                                    <hr>
                                    <div class="p-2">
                                        <label for="">Changer le num fiche</label>
                                        <div class="input-group mb-3">
                                            <input wire:keydown.enter='updateFicheNumber' wire:model.defer='fiche_to_update' type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button wire:click='updateFicheNumber' class="btn btn-info" type="button" id="button-addon2">
                                                    Mettre à jour
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="p-2 bg-secondary">
                                    @if ($patient_data_abonne_to_update_deep != null)
                                        <div class="card-body">
                                                <div class="text-white"><strong>N° Fiche: </strong>{{$patient_data_abonne_to_update_deep->fiche->numero}}</div>
                                                <div><strong>Noms: </strong>{{$patient_data_abonne_to_update_deep->Nom.' '.$patient_data_abonne_to_update_deep->Prenom}}</div>
                                                <div><strong>Sexe: </strong>{{$patient_data_abonne_to_update_deep->Sexe}}</div>
                                                <div><strong>Age: </strong>{{$patient_data_abonne_to_update_deep->getAge($patient_data_abonne_to_update_deep->id)}}</div>
                                                <div><strong>Societé: </strong>{{$patient_data_abonne_to_update_deep->abonnement->name}}</div>
                                        </div>
                                    @endif
                                    <hr>
                                    <label for="my-select">Changer la société</label>
                                    <div class="input-group p-2">
                                        <select class="custom-select" id="inputGroupSelect04" wire:model.defer='abonnement_id_to_change'>
                                            <option>Choisir le type...</option>
                                            @foreach ($abonnements as $abonnement)
                                                <option value="{{$abonnement->id}}">{{$abonnement->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button wire:click='updateSociety' class="btn btn-danger" type="button">
                                                Mettre à jour
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
