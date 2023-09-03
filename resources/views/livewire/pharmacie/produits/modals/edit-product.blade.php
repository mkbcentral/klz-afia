<!-- Modal -->
<x-loading-indicator />
<div wire:ignore.self class="modal fade" id="EditProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-tablets"></i> MISE A JOUR D4UN PRODUIT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if (session()->has('error_msg'))
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ session('error_msg') }}
                </div>
            @endif
            @if (Auth::user()->role->name=="Nursing")
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-input">Quantité stock</label>
                            <input class="form-control" type="text" wire:model.defer='qt_stock'>
                            @error('qt_stock') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>QWµ£+°w1q
                </div>
            @else
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Code </label>
                        <input class="form-control" type="text" wire:model.defer='code'>
                        @error('code') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Désignation</label>
                        <input class="form-control" type="text" wire:model.defer='name'>
                        @error('name') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Numéro Lot </label>
                        <input class="form-control" type="text" wire:model.defer='numLot'>
                        @error('numLot') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Conditionnement</label>
                        <input class="form-control" type="text" wire:model.defer='conditionnement'>
                        @error('conditionnement') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Stock initial</label>
                        <input class="form-control" type="text" wire:model.defer='quantity'>
                        @error('quantity') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
                @if (Auth::user()->role->name=='Admin')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Prix privé</label>
                        <input class="form-control" type="text" wire:model.defer='price'>
                        @error('price') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                @if (Auth::user()->role->name=='Admin')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-input">Prix abonné</label>
                            <input class="form-control" type="text" wire:model.defer='price_abonne'>
                            @error('price_abonne') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">Date d'expiration</label>
                        <input wire:keydown.enter="update" class="form-control" type="date" wire:model.defer='expirated_at'>
                        @error('price_abonne') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                @if (Auth::user()->role->name=='Admin')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-input">Quantité stock</label>
                            <input class="form-control" type="text" wire:model.defer='qt_stock'>
                            @error('qt_stock') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

            </div>
            @endif

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" wire:click.prevent='update'>
            <i class="fas fa-sync-alt"></i>
              Mettre à jour
            </button>
        </div>
      </div>
    </div>
  </div>
