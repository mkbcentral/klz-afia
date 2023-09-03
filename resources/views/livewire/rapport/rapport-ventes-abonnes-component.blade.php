<div>
    <x-loading-indicator />
    @php
        $toatl_general =0;
    @endphp
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
            <div class="card-body p-0">
                <div class="mailbox-controls">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                      <h3 class="card-title">SITUATION PHARMACIE DES ABONNES</h3>
                                </div>

                                <div>
                                      @if ($factures->isEmpty())
                                      @else
                                          <div class="p-2 ml-4">
                                                <a target="_blank" href="{{ route('ventes.abonnes.pharma.month',[$currentDate,$abonnementData])}}"
                                               class="btn btn-primary btn-sm" type="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimer</a>
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
                                        <select id="my-select" class="form-control" wire:model="abonnementData">
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
                                            @foreach ($mois as $moi)
                                                <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
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
                                    <div>
                                        @if ($factures->isEmpty())
                                            <div class="text-center mt-4 p-4">
                                                <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                                            </div>
                                        @else
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th># Date</th>
                                                        <th class="text-center">N° FACTURE</th>
                                                        <th>NOM DU PATIENT</th>
                                                        <th class="text-right">MONTANT CDF</th>
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
                                                            @if ($facture->source=="Golf")
                                                                <span class="text-danger">[Golf]</span>
                                                            @else
                                                                <span class="text-success">[Ville]</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-primary text-center">{{$facture->numero}}</td>
                                                        <td>{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}}</td>
                                                        <td class="text-right">
                                                            <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                        Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                        Courier New, monospace, serif">
                                                                {{ number_format($facture->getTotalPharma($facture->id),1) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                        Ok !
                                                        </td>
                                                    </tr>
                                                        @php
                                                            $toatl_general+=$facture->getTotalPharma($facture->id);
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card p-1">
                                <div class="card-body">
                                   <div class="d-flex justify-content-between">
                                        <div style="margin-right: 30px;font-size: 30px;font-weight: bold">
                                            <span>Total USD: {{ number_format(($toatl_general)/$valeur_taux,1) }} </span>
                                        </div>
                                        <div>
                                            @if (Auth::user()->role->name=="Admin")
                                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#mtModal">Montant en lettre</button>
                                            @endif
                                        </div>
                                        <div style="margin-right: 30px;font-size: 30px;font-weight: bold" >
                                            <span>Total CDF: {{ number_format($toatl_general,1) }} </span>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $toatl_general=0;
                @endphp
            </div>
        </div>
    </div>
</div>
