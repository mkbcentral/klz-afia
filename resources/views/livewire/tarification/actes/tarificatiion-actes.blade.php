<div class="p-0">
    <x-loading-indicator />
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-2">
                    <table class="table table-striped table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Examen</th>
                                <th class="text-center">Prix privé</th>
                                <th class="text-center">Prix abonné</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actes as $acte)
                                <tr>
                                    <td>{{$acte->name}}</td>
                                    <td class="text-center">{{$acte->price_prive}} $</td>
                                    <td class="text-center">{{$acte->price_abonne}} $</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm"
                                         data-toggle="modal" data-target="#editActesTarif"
                                         wire:click='edit({{$acte->id}})'
                                         type="button"><i class="fas fa-edit"></i></button>
                                        @if ($acte->is_changed==false)
                                            <button class="btn btn-danger btn-sm" wire:click='unActivate({{$acte->id}})' type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        @else
                                            <button class="btn btn-success btn-sm" wire:click='activate({{$acte->id}}})' type="button"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="my-input">Nom exame</label>
                        <input id="my-input" class="form-control" type="text" wire:model.defer='name' >
                        @error('name')
                            <span class="error text-danger">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="my-input">Prix privé</label>
                        <input id="my-input" class="form-control" type="text" wire:model.defer='price_prive' >
                        @error('price_prive')
                            <span class="error text-danger">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="my-input">Prix abonné</label>
                        <input id="my-input" class="form-control" type="text" wire:model.defer='price_abonne'>
                        @error('price_abonne')
                            <span class="error text-danger">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-secondary" type="button" wire:click='save'>Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.tarification.actes.edit-actes-tartif')
</div>
