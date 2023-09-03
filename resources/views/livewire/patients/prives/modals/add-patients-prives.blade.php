<div wire:ignore.self id="AddPatientPriveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                    <span style="font-size: 20px;">CREATION D'UN NOUVEAU PATIENT PRIVE</span>
                </h3>
            </div>
            <div class="modal-body">
                @if (session()->has('error_msg'))
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        {{ session('error_msg') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Nom du patient</label>
                            <input wire:model.defer='nom' class="form-control" type="text">
                            @error('nom') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Postnom du patient</label>
                            <input  wire:model.defer='postnom'class="form-control" type="text">
                            @error('postnom') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-inp0ut">Prénom du patient</label>
                            <input wire:model.defer='prenom' class="form-control" type="text">
                            @error('prenom') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-select">Sexe du patient</label>
                            <select class="form-control" wire:model.defer='sexe'>
                                <option>Choisir ici...</option>
                                <option>M</option>
                                <option>F</option>
                            </select>
                        </div>
                        @error('sexe') <span class="text-danger error">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Date de naissance du patient</label>
                            <input class="form-control" type="date" wire:model.defer='date_naisssance'>
                            @error('date_naisssance') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Numéro de téléphone du patient</label>
                            <input class="form-control" type="text" wire:model.defer='telephone'>
                            @error('telephone') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Autre numéro de téléphone</label>
                            <input class="form-control" type="text" wire:model.defer='autre_tel'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-select">Commune</label>
                            <select class="form-control" wire:model.defer='commune'>
                                <option>Choisir la commune</option>
                                <option>Inconnue</option>
                                <option>DILALA</option>
                                <option>MANIKA</option>
                                <option>FUNGURUME</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Quartier</label>
                            <input class="form-control" type="text" wire:model.defer='quartier'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Avenue</label>
                            <input class="form-control" type="text" wire:model.defer='avenue'>
                            @error('avenue') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Numéro </label>
                            <input class="form-control" type="text" wire:model.defer='numero'>
                            @error('numero') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-select">Type de la demande</label>
                            <select class="form-control" wire:model.defer='demande_id'>
                                <option>Choisir le type...</option>
                                @foreach ($consultations as $consultation)
                                    <option value="{{$consultation->id}}">{{$consultation->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">Venu le</label>
                            <input wire:keydown.enter="store" class="form-control" type="date" wire:model.defer='date_venue'>
                            @error('date_venue') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div>
                </div>
                <div>
                    <button wire:click='store' class="btn btn-primary" type="button">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
