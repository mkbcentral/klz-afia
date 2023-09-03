<div wire:ignore.self id="nursingModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">NURSING & AUTRES</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                   <label for="">Désignation</label>
                   <input  class="form-control" type="text" wire:model.defer="name_nursing">
                   @error('name_nursing') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                <label for="">Prix USD</label>
                <input  class="form-control" type="text" wire:model.defer="price_nursing">
                @error('price_nursing') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="">NoMBRE</label>
                <input  class="form-control" type="text" wire:model.defer="qty_nursing">
                @error('qty_nursing') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
            </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" type="button" wire:click='addNursing'>Ajouter</button>
            </div>
        </div>
    </div>
</div>
