<div wire:ignore.self id="sejourModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">SAJOUR</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="my-select">Type d'hopitalisation</label>
                    <select class="form-control" wire:model.defer="sejour_id">
                        <option> Choisir le sejour</option>
                       @foreach ($sejours as $sejour)
                        <option value="{{$sejour->id}}">{{$sejour->name}}</option>
                       @endforeach
                    </select>
                    @error('sejour_id') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                </div>
               <div class="form-group">
                   <label for="">Nombre de jour</label>
                   <input  class="form-control" type="text" wire:model.defer="day_number">
                   @error('day_number') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
               </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" type="button" wire:click='addSejour'>Ajouter</button>
            </div>
        </div>
    </div>
</div>
