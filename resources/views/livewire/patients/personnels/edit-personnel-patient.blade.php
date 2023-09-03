<div>
    <div wire:ignore.self class="modal fade" id="EditAyantDroitModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                        <span style="font-size: 20px;">EDITION D'UN NOUVEAU PATIENT PERSONNEL</span>
                    </h3>
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
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Nom du patient</label>
                                    <input class="form-control" type="text" wire:model.defer="nom"
                                        autocomplete="nom" autofocus>
                                    @error('nom')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Postnom du pateint</label>
                                    <input class="form-control" type="text" wire:model.defer="postnom"
                                        autocomplete="postnom" autofocus>
                                    @error('postnom')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Prénom du patient</label>
                                    <input class="form-control" type="text" wire:model.defer="prenom"
                                        autocomplete="prenom" autofocus>
                                    @error('prenom')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Sexe pateint</label>
                                    <select class="custom-select form-control" wire:model.defer="sexe">
                                        <option>Choisir le sexe</option>
                                        <option>M</option>
                                        <option>F</option>
                                    </select>
                                    @error('sexe')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Date de naissance</label>
                                    <input class="form-control" type="date" wire:model.defer="dateNaissance"
                                        autocomplete="dateNaissance" autofocus>
                                    @error('dateNaissance')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">N° téléphone</label>
                                    <input class="form-control" type="text" wire:model.defer="telephone"
                                        autocomplete="telephone" autofocus>
                                    @error('telephone')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Autre numéro téléphone</label>
                                    <input class="form-control" type="text" wire:model.defer="autreTelephone"
                                        autocomplete="autreTelephone" autofocus>
                                    @error('autreTelephone')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Commune</label>
                                    <select class="custom-select form-control" wire:model.defer="commune">
                                        <option>Choisir la commune</option>
                                        <option>Inconnue</option>
                                        <option>DILALA</option>
                                        <option>MANIKA</option>
                                        <option>FUNGURUME</option>
                                    </select>
                                    @error('commune')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Quartier</label>
                                    <input class="form-control" type="text" wire:model.defer="quartier"
                                        autocomplete="quartier" autofocus>
                                    @error('quartier')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Avenue</label>
                                    <input class="form-control" type="text" wire:model.defer="avenue"
                                        autocomplete="avenue" autofocus>
                                    @error('avenue')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Numéro</label>
                                    <input class="form-control" type="text" wire:model.defer="numero"
                                        autocomplete="numero" autofocus>
                                    @error('numero')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Service</label>
                                    <select class="custom-select form-control" wire:model.defer="serviceId">
                                        <option>Choisir le service</option>
                                        @foreach ($services as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('serviceId')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="my-input">Choisir le type de patient</label>
                                    <select class="custom-select form-control" wire:model.defer="type_agent">
                                        <option>Choisir le type</option>
                                        <option>Agent</option>
                                        <option>Fils agent</option>
                                        <option>Fille agent</option>
                                        <option>Marie agent</option>
                                        <option>Femme agent</option>
                                    </select>
                                    @error('type_agent')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-sm-between">
                            <div class="row">

                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-primary"
                                    wire:click="update()">Sauvegarder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
