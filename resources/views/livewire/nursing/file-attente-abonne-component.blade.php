<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="card-title">LISTE DES DEMANDES</h3>
                </div>
                <div>
                    @if ($demandes->isEmpty())

                    @else
                        <div class="mt-2">
                            <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-success">{{$demandes->count()  }} Demande(s) réalisée(s)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Nom société</label>
                        <select id="my-select" class="form-control" wire:model="abonnement_data">
                            <option>Choisir la société ici...</option>
                            @foreach ($abonnements as $abonnement)
                                <option value="{{ $abonnement->id }}">{{ $abonnement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2 ml-5 w-25">

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="card-tools w-50 mb-4">
                            <div class="input-group input-group-sm">
                            <input wire:model='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                            <div class="input-group-append">
                                <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    @if ($demandes->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th># Date</th>
                                    <th class="">NUMERO DE LA FICHE</th>
                                    <th>NOM DU PATIENT</th>
                                    <th>STATUS</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandes as $demande)
                                    <tr>
                                        <td scope="row">
                                            <span class="text-primary">
                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                                {{(new DateTime($demande->created_at))->format('d/m/Y')}}
                                            </span>
                                        </td>
                                        <td class="text-primary">{{$demande->fiche->numero}}</td>
                                        @if ($demande->is_inteneted==true)
                                            <td>{{$demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom}} <span class="text-danger">[Hospitalisé]</span></td>
                                        @else
                                            <td>{{$demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom}} [Ambulant]</td>
                                        @endif

                                        <td>
                                           @if (Auth::user()->role->name=="Medecin")
                                                @if ($demande->signeVito==null)
                                                    <span class="text-succes">En attente infirmerie</span>
                                                @else
                                                    <span class="text-danger">Dans le cabinet</span>
                                                @endif
                                           @else
                                                @if ($demande->signeVito==null)
                                                    Non completé
                                                @else
                                                    Dans le cabinet
                                                @endif
                                           @endif
                                        </td>

                                        <td class="text-center">
                                            @if (Auth::user()->role->name=="Medecin")
                                            <a class="btn btn-danger btn-sm"href="{{ route('create.facture.abonne',$demande) }}"><i class="fab fa-telegram"></i></a>
                                            @elseif (Auth::user()->role->name=="Labo")
                                                <button wire:click='getInfos({{$demande->id}})'
                                                     data-toggle="modal" data-target="#swoLaboAbonneInfos"
                                                     class="btn btn-danger btn-sm">
                                                     <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            @else
                                            <button wire:click='getInfos({{$demande->id}})' data-toggle="modal" data-target="#addSigneVitauxAbnModal" class="btn btn-primary btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('livewire.nursing.modal.show-labos-abonnes-info')
</div>

