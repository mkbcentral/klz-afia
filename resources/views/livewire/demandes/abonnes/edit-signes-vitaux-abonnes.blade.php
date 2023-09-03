<!-- Modal -->
<div wire:ignore.self class="modal fade" id="signeVitauxAbnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-tablets"></i> AJOUTER LEZS SIGNE VITAUX</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($demande != null)
                <div class="p-2 text-right">
                    <div><span>Nom:</span> {{$demande->Nom.' '.$demande->Prenom}} </div>
                </div>
            @endif
           <div class="form-group">
               <label for="my-input">Poids (Kg)</label>
               <input id="my-input" class="form-control" type="text" wire:model.defer="poids">
               @error('poids') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
           </div>
            <div class="form-group">
                <label for="my-input">Température (°)</label>
                <input id="my-input" class="form-control" type="text" wire:model.defer="temperature">
                @error('temperature') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="my-input">Taille (m)</label>
                <input id="my-input" class="form-control" type="text" wire:model.defer="taille">
                @error('taille') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="my-input">Tensons (*)</label>
                <input id="my-input" class="form-control" type="text" wire:model.defer="tension">
                @error('tension') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" wire:click='addSigneVitaux'><i class="fas fa-hdd"></i> Sauvegarder</button>
        </div>
      </div>
    </div>
  </div>
