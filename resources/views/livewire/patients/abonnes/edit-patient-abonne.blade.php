<div wire:ignore.self id="EditPatientAbonneModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                    <span style="font-size: 20px;">EDITION D'UN NOUVEAU PATIENT ABONNE</span>
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Nom du patient</label>
                            <input wire:model.defer='nom' class="form-control" type="text">
                            @error('nom')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Postnom du patient</label>
                            <input wire:model.defer='postnom' class="form-control" type="text">
                            @error('postnom')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Prénom du patient</label>
                            <input wire:model.defer='prenom' class="form-control" type="text">
                            @error('prenom')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-select">Sexe du patient</label>
                            <select class="form-control" wire:model.defer='sexe'>
                                <option>{{ $sexe }}</option>
                                <option>M</option>
                                <option>F</option>
                            </select>
                        </div>
                        @error('sexe')
                            <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Date de naissance du patient</label>
                            <input class="form-control" type="date" wire:model.defer='date_naisssance'>
                            @error('date_naisssance')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Numéro de téléphone du patient</label>
                            <input class="form-control" type="text" wire:model.defer='telephone'>
                            @error('telephone')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
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
                            @error('avenue')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Numéro </label>
                            <input class="form-control" type="text" wire:model.defer='numero'>
                            @error('numero')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-select">Type du patient</label>
                            <select wire:keydown.enter="update" class="form-control" wire:model.defer='type'>
                                <option></option>
                                <option>Agent</option>
                                <option>Epoux</option>
                                <option>Epouse</option>
                                <option>Fils</option>
                                <option>Fille</option>
                            </select>
                            @error('type')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="my-input">Matricule</label>
                            <input class="form-control" type="text" wire:model.defer='matricule'>
                            @error('matricule')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div>
                    <button wire:click='update' class="btn btn-danger btn-sm" type="button">
                        <i class="fas fa-sync-alt"></i>
                        Metttre à jour
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
