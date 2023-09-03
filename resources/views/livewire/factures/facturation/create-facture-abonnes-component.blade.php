<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">DETAILS PATIENTS PRIVES</h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div><span class="text-bold">N° Fiche:</span> {{$facture_data->fiche->numero}}</div>
                        <div><span class="text-bold">Noms:</span> {{$facture_data->fiche->patientAbonne->Nom.' '.$facture_data->fiche->patientAbonne->Postnom.' '.$facture_data->fiche->patientAbonne->Prenom}}</div>
                        <div><span class="text-bold">Type:</span> <span class="text-danger">{{$facture_data->fiche->type}}</span></div>
                        <div><span class="text-bold">Societé:</span> <span class="text-danger">{{$facture_data->fiche->patientAbonne->abonnement->name}}</span></div>
                    </div>
                    <div>

                    </div>
                    <div>
                        <div><span class="text-bold">Emise le:</span> {{(new DateTime($facture_data->created_at))->format('d/m/Y')}}</div>
                        <div><span class="text-bold">Sexe: </span> {{$facture_data->fiche->patientAbonne->Sexe}}</div>
                        <div><span class="text-bold">Age: </span> <span class="">{{$facture_data->fiche->patientAbonne->getAge($facture_data->fiche->patientAbonne->id)}} ans</span></div>
                        <div><span class="text-bold">Est: </span> <span class="">{{$facture_data->fiche->patientAbonne->Type}}</span></div>
                        <button wire:click.prevent="makeRate"  class="btn btn-primary mt-4" type="button"Medication >Fixer au taux actuel</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (Auth::user()->role->name=='pharma')
                            <button data-toggle="modal" data-target="#productModal" class="btn btn-danger" type="button">Prescription</button>
                        @elseif (Auth::user()->role->name=='radio')
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                        @elseif (Auth::user()->is_to="Ville")
                            <button data-toggle="modal" data-target="#detailLaboModal" class="btn btn-dark" type="button">Examen labo</button>
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                            <button data-toggle="modal" data-target="#detailEchoModal" class="btn btn-success" type="button">Echographie</button>
                            <button data-toggle="modal" data-target="#sejourModal" class="btn btn-secondary" type="button">Sejour</button>
                            <button data-toggle="modal" data-target="#detailAutresModal" class="btn btn-primary" type="button">Autres</button>
                            <button data-toggle="modal" data-target="#nursingModal" class="btn btn-warning" type="button">Nursing</button>
                            <button data-toggle="modal" data-target="#productServiceModal" class="btn btn-danger" type="button"Medication >Medication</button>
                        @else
                            <button data-toggle="modal" data-target="#detailLaboModal" class="btn btn-dark" type="button">Examen labo</button>
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                            <button data-toggle="modal" data-target="#detailEchoModal" class="btn btn-success" type="button">Echographie</button>
                            <button data-toggle="modal" data-target="#sejourModal" class="btn btn-secondary" type="button">Sejour</button>
                            <button data-toggle="modal" data-target="#detailAutresModal" class="btn btn-primary" type="button">Autres</button>
                            <button data-toggle="modal" data-target="#nursingModal" class="btn btn-warning" type="button">Nursing</button>
                            <button data-toggle="modal" data-target="#productServiceModal" class="btn btn-danger" type="button"MEdication >Medication</button>
                        @endif
                    </div>
                </div>
                @if (Auth::user()->role->name=='Medecin')
                    <div class="card">
                        <div class="p=mt-2 mr-2 text-center">
                            <button  data-toggle="modal" data-target="#paternsLaboModal" class="btn btn-primary" type="button"Medication >Autres plantes</button>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Autres détails</label>
                                <textarea wire:model.defer='infos' class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                @error('infos') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                            <div class="p-2 text-right">
                                <button class="btn btn-success" type="button" wire:click='addInfo' >Terminer</button>
                            </div>
                        </div>
                    </div>
                @endif
          </div>
        </div>
        </div>
        <!-- /.card -->
      </div>
      @include('livewire.factures.facturation.modals.examen-labo')
      @include('livewire.factures.facturation.modals.exemen-radio')
      @include('livewire.factures.facturation.modals.echographie')
      @include('livewire.factures.facturation.modals.sejour')
      @include('livewire.factures.facturation.modals.products')
      @include('livewire.factures.facturation.modals.autres')
      @include('livewire.factures.facturation.modals.nursing')
      @include('livewire.factures.facturation.modals.medication-service')
      @include('livewire.factures.facturation.modals.paternsModal')
     <div class="card">
         <div class="card-body">
             <a href="{{ url()->previous() }}" class="btn-link"><i class="fas fa-arrow-circle-left"></i> Retour</a>
         </div>
     </div>
</div>
