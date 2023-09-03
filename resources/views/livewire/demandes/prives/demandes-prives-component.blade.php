<div>
    <x-loading-indicator />
    <div class="card">
       <div class="d-flex justify-content-between">
        <div class="card-header">
            <h3 class="card-title">LISTE DES DEMANDES</h3>
        </div>
        <div>
            @if ($factures->isEmpty())

            @else
                <div class="mt-2">
                    <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-success">{{$factures->count()  }} Demande(s) réalisée(s)</span>
                </div>
            @endif
        </div>
        <div class="p-3">
            <a target="_blank" href="{{ route('print.reception.month', $currentDate) }}">Imprimer</a>
        </div>
       </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Année</label>
                        <select id="my-select" class="form-control" wire:model="currentYear">
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Mois</label>
                        <select id="my-select" class="form-control" wire:model="currentDate">
                            <option>{{ $currentDate }}</option>
                            @foreach ($mois as $moi)
                                <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi,10)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Selectionner le type</label>
                        <select id="my-select" class="form-control" wire:model="type_data">
                            <option>Tous</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
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
                    @if ($factures->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th># Date</th>
                                    <th class="">NUMERO DE LA FACTURE</th>
                                    <th>NOM DU PATIENT</th>
                                    <th>STATUS</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)
                                    <tr>
                                        <td scope="row">
                                            <span class="text-primary">
                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                                {{(new DateTime($facture->created_at))->format('d/m/Y')}}
                                            </span>
                                        </td>
                                        <td class="text-primary">{{$facture->numero}}</td>
                                        @if ($facture->is_inteneted==true)
                                            <td>{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}} <span class="text-danger">[Hospitalisé]</span></td>
                                        @else
                                            <td>{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}} [Ambulant]</td>
                                        @endif

                                        <td>
                                            @if ($facture->is_completed==true)
                                                <span class="text-success">Completé</span>
                                            @else
                                                <span class="text-danger">Non complété</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (Auth::user()->role->name=="Admin" or Auth::user()->role->name=="Nursing")
                                                <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showEncodageDetailModal" class="btn btn-info btn-sm" type="button">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <a href="{{ route('create.facture',$facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                @if ($facture->is_inteneted==true)
                                                    <button wire:click='unhospitaliser({{$facture->id}})' class="btn btn-danger btn-sm" type="button"><i class="far fa-times-circle"></i></button>
                                                @else
                                                    <button wire:click='hospitaliser({{$facture->id}})' class="btn btn-primary btn-sm" type="button"><i class="fas fa-house-user"></i></button>
                                                @endif
                                                @if ($facture->is_completed==false)
                                                    <button wire:click='completed({{$facture->id}})' class="btn btn-secondary btn-sm" type="button"><i class="fas fa-check-double"></i></button>
                                                @endif
                                            @elseif (Auth::user()->role=='radio')
                                                <a href="{{ route('create.facture',$facture) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showEncodageDetailModal" class="btn btn-info btn-sm" type="button">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                                @elseif (Auth::user()->role->name=="Medecin")
                                                <a class="btn btn-primary btn-sm"href="{{ route('create.facture',$facture) }}"><i class="fab fa-telegram"></i></a>
                                                <button wire:click='getInfos({{$facture->id}})'
                                                    data-toggle="modal" data-target="#swoLaboInfos"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                               </button>
                                                @elseif (Auth::user()->role->name=="Labo")
                                                <button wire:click='getInfos({{$facture->id}})'
                                                     data-toggle="modal" data-target="#swoLaboInfos"
                                                     class="btn btn-danger btn-sm">
                                                     <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            @elseif (Auth::user()->role->name=="Infirmier")
                                                <button wire:click='getInfos({{$facture->id}})'
                                                    data-toggle="modal" data-target="#addSigneVitauxPvModal"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <span>Ok !</span>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div style="">
                            <div>{{ $factures->links('pagination::bootstrap-4') }}</div>
                        </div>
                        <div style="margin-right: 30px;" >
                            <div class="row">
                                <div class="col-auto ml-auto mb-4">
                                    Afficher
                                    <select wire:model.lazy='page_number'  class="custom-select w-auto" name="">
                                        @for ($i=10;$i<=200;$i+=10))
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                    par page
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.demandes.prives.detail-demande-prives')
    @include('livewire.nursing.modal.add-signes-demande')
    @include('livewire.nursing.modal.show-labos-info')
</div>
