<div wire:ignore.self id="updatePriveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
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
                    @if (session()->has('error_msg'))
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ session('error_msg') }}
                        </div>
                    @endif

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                href="#pills-home" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <i class="fas fa-users-cog"></i> Mise à jour fiche
                            </a>
                        </li>


                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @if ($patient_prive_data_to_update_deep != null)
                                <div><strong>Noms: </strong>{{$patient_prive_data_to_update_deep->Nom.' '.$patient_prive_data_to_update_deep->Prenom}}</div>
                                <div><strong>Sexe: </strong>{{$patient_prive_data_to_update_deep->Sexe}}</div>
                                <div><strong>Age: </strong>{{$patient_prive_data_to_update_deep->getAge($patient_prive_data_to_update_deep->id).' | '.$patient_prive_data_to_update_deep->fiche->type}}</div>
                                <hr>
                                <div class="p-2">
                                    <label for="">Changer le num fiche</label>
                                    <div class="input-group mb-3">

                                        <input wire:keydown.enter="updateFichePriveNumber" wire:model.defer='fiche_to_update' type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                        <button wire:click='updateFichePriveNumber' class="btn btn-info" type="button" id="button-addon2">
                                            Mettre à jour
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </div>
</div>
