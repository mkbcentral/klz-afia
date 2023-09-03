<div style="background: #f2f3f3dd">
    <div class="d-flex justify-content-between mr-4 p-1">
        <div>
            <div class="row">
                <div class="col-md-12 offset-md-1">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group input-group-sm">
                                    <input wire:model.defer='dateSearch' type="date" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Type :</label>
                                <select class="select2" style="width: 100%;" wire:model='typeSearch'>
                                    <option selected>Privé</option>
                                    @foreach ($types as $type)
                                        <option>{{$type->name}}</option>
                                    @endforeach
                                    <option>Personnels</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
           @if (Auth::user()->role->name=="Labo")
           <button data-toggle="modal" data-target="#addNewResultatModal" class="btn btn-secondary" type="button" ><i class="fas fa-plus-circle"></i> Nouveau</button>
           <button wire:click='$refresh' class="btn btn-secondary" type="button" > Actualiser</button>
           @endif
        </div>
    </div>

    <div class="card  mt-2">
        <div class="card-body">
            <div class="row">
                @foreach ($resultats as $resultat)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                        <a style="cursor: pointer" wire:click='show({{$resultat->id}})'
                            class="mailbox-attachment-name" data-target="#editResultatModal" data-toggle="modal">
                            <i class="fas fa-pencil-alt"></i>
                            {{$resultat->name}}
                        </a>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <span class="text-bold text-danger">{{$resultat->type}}</span> |
                                      Du {{(new DateTime($resultat->created_at))->format('d/m/Y')}}
                                </span>
                                <a target="_blank" href="{{Storage::url($resultat->location)}}" class="btn btn-default btn-sm float-right"><i class="fas fa-eye"></i></a>
                                <a style="cursor: pointer" wire:click='showDeleteDialog({{$resultat->id}})' class="btn btn-default btn-sm float-right text-danger"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('livewire.labo.add-new-resultat')
    @include('livewire.labo.edit-resultat')
</div>
