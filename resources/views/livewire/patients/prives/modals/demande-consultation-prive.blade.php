<div wire:ignore.self id="DmdPriveConsDModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @if (session()->has('problem'))
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>{{ session('problem') }}
                    </div>
                @endif

               <div class="card">
                <div class="card-header">
                    <h3 class="text-center text-primary"><strong><i class="fas fa-user-clock"></i> DEMANDE DE CONSULTATION</strong></h3>
                </div>

                @if ($patient_data != null)
                    <div class="card-body">
                            <div class="text-primary"><strong>N° Fiche: </strong>{{$patient_data->fiche->numero}}</div>
                            <div><strong>Noms: </strong>{{$patient_data->Nom.' '.$patient_data->Postnom.' '.$patient_data->Prenom}}</div>
                            <div><strong>Sexe: </strong>{{$patient_data->Sexe}}</div>
                            <div><strong>Age: </strong>{{$patient_data->getAge($patient_data->id)}}</div>
                    </div>
                @endif
               </div>
               <div class="form-group">
                <label for="my-select">Type de la demande</label>
                <select id="my-select" class="form-control" wire:model.defer='demande_id'>
                    <option>Choisir le type...</option>
                    @foreach ($consultations as $consultation)
                        <option value="{{$consultation->id}}">{{$consultation->name}}</option>
                    @endforeach
                </select>
            </div>

            </div>
            <div class="modal-footer">
                <div>
                    <button wire:click='demanderCons' class="btn btn-info btn-sm" type="button">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>
