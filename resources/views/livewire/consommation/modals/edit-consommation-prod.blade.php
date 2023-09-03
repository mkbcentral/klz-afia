<div wire:ignore.self id="editConsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-bold text-primary" id="my-modal-title">
                    <span style="font-size: 20px;">MODIFIER LA CONSOMMATION</span>
                </h3>
                <button
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Semaine allant du:</label>
                    <input wire:keydown.enter='store'  class="form-control" type="text" wire:model.defer="week">
                    @error('week') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Votre service service</label>
                    <select id="my-select" class="form-control" wire:model.defer='service_id'>
                        @foreach ($services as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('service_id') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
                @error('name') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='store' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
