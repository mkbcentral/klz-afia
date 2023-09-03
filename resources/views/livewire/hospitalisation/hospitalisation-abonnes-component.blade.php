<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                      <h3 class="card-title">LISTE DES PATIENTS PRIVES</h3>
                </div>
                @if (!$factures->isEmpty())
                    <div>
                        <div class="mt-2">
                            <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-success">{{$factures->count()  }} Demande(s) réalisée(s)</span>
                        </div>
                    </div>

                @endif
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
                    <div class="form-group">
                        <label for="">Mois</label>
                        <select id="my-select" class="form-control" wire:model="currentDate">
                            <option>{{ $currentDate }}</option>
                            @foreach ($mois as $moi)
                                <option value="{{ $moi }}">{{ $moi }}</option>
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
                                    <th class="">N° DE LA FICHE</th>
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
                                                @if ($facture->source=="Golf")
                                                    <span class="text-danger">[Golf]</span>
                                                @else
                                                    <span class="text-success">[Ville]</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-primary">{{$facture->fiche->numero}}</td>
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
                                            <a href="{{ route('hospitalisation.details.abpnnes', $facture) }}" class="btn btn-primary btn-sm"><i class="fab fa-telegram" aria-hidden="true"></i></a>
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

</div>
