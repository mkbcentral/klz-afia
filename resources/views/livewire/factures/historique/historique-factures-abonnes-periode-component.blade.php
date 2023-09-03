<div>
    <x-loading-indicator />
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                  <h3 class="card-title">HISTORIQUE FACTURES ABONNES</h3>
                            </div>
                            <div>
                                  @if ($factures->isEmpty())

                                  @else
                                      <div class="mt-2">
                                          <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-success">{{$factures->count()  }} Facture(s) établie(s)</span>
                                      </div>
                                      <div class="p-2 ml-4">
                                        <button class="btn btn-secondary btn-sm"
                                        data-toggle="modal" data-target="#entetePeriodeModal" type="button">Ajouter l'entete</button>
                                        <a target="_blank" href="{{ route('print.revele.periode',[$searchDateFrom,$searchDateTo,$abonnement_data,$mtLetter,$entete])}}" class="btn btn-primary" type="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimer</a>
                                        <a target="_blank" href="{{ route('print.fact.abn.all.periode',[$searchDateFrom,$searchDateTo,$abonnement_data])}}" class="btn btn-primary" type="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimer Tout</a>
                                    </div>

                                  @endif
                            </div>
                        </div>
                    </div>
                    @php
                    $toatl_general=0;$toatl_speciale=0;
                    @endphp
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="my-select" class="ml-2">Trier entre duex dates</label>
                                <div class="input-group mb-3">
                                   Du <input type="date" class="form-control mr-2 ml-2" wire:model="searchDateFrom"  aria-label="Recipient's username" aria-describedby="button-addon2">
                                   Au <input type="date" class="form-control ml-2" wire:model="searchDateTo"  aria-label="Recipient's username" aria-describedby="button-addon2">
                                   <button class="btn btn-secondary" wire:click.prevent="getBytBetweenDate()" type="button" id="button-addon2"><i class="fa fa-search""></i></button>
                                 </div>
                            </div>
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
                                                <th class="text-center">NUMERO DE LA FACTURE</th>
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
                                                    </td>
                                                    <td class="text-primary text-center">{{$facture->numero}}</td>
                                                    <td>{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}}</td>
                                                    @if ($facture->getTotalAbonne($facture->id) == 20000)
                                                    <td class="text-right bg-danger">
                                                        <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                    Courier New, monospace, serif">
                                                            {{ number_format($facture->getTotalAbonne($facture->id),1) }}
                                                        </span>
                                                    </td>
                                                    @else
                                                    <td class="text-right">
                                                        <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                    Courier New, monospace, serif">
                                                            {{ number_format($facture->getTotalAbonne($facture->id),1) }}
                                                        </span>
                                                    </td>
                                                    @endif

                                                    <td class="text-center">
                                                        <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailHistorikAbonnePEriodeModal" class="btn btn-info btn-sm" type="button">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#EditNumAndDateModalAbnPeriode" class="btn btn-primary btn-sm" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <a href="{{ route('create.facture.abonne',$facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                        <a target="_blank" href="{{ route('print.fact.abones', $facture) }}" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                                                        <button wire:click='shuwDeleteDialog({{$facture->id}})' class="btn btn-danger btn-sm" type="button">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $toatl_general+=$facture->getTotalAbonne($facture->id);
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <span>Total CDF: {{ number_format(($toatl_general),1) }} </span>

                                    @if ($fac_speciales->isEmpty())

                                    @else
                                    <div class="card">
                                        <div class="card-header">
                                             <h5 class="card-title">DEMANDES SPECIALES</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th># Date</th>
                                                        <th class="text-center">NUMERO DE LA FACTURE</th>
                                                        <th>NOM DU PATIENT</th>
                                                        <th class="text-right">MONTANT CDF</th>
                                                        <th class="text-center">ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($fac_speciales as $speciale)
                                                        <tr>
                                                            <td scope="row">
                                                                <span class="text-primary">
                                                                    <i class="fa fa-folder" aria-hidden="true"></i>
                                                                    {{(new DateTime($speciale->date_venue))->format('d/m/Y')}}
                                                                </span>
                                                            </td>
                                                            <td class="text-primary text-center">{{$speciale->numero}}</td>
                                                            <td>{{$speciale->name}}</td>
                                                            <td class="text-right">
                                                                <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                            Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                            Courier New, monospace, serif">
                                                                    {{ number_format($speciale->getTotal($speciale->id),1) }}
                                                                </span>
                                                            </td>

                                                            <td class="text-center">
                                                                <a target="_blank" href="{{ route('print.fact.speciale', $speciale ) }}" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $toatl_speciale+=$speciale->getTotal($speciale->id);
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <span>Total CDF 2: {{ number_format(($toatl_speciale),1) }} </span>
                                        </div>
                                    </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                           <div class="d-flex justify-content-between">
                                <div style="margin-right: 30px;font-size: 30px;font-weight: bold">
                                    <span>Total USD: {{ number_format(($toatl_general+ $toatl_speciale)/$valeur_taux,1) }} </span>
                                </div>
                                <div>
                                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#mtPeriodeModal">Montant en lettre</button>
                                </div>
                                <div style="margin-right: 30px;font-size: 30px;font-weight: bold" >
                                    <span>Total CDF: {{ number_format(($toatl_general+ $toatl_speciale),1) }} </span>
                                </div>
                           </div>
                        </div>
                    </div>

                </div>
            </div>
          </div>
        </div>
        @include('livewire.factures.historique.show-detail-abn-periode')
        @include('livewire.factures.facturation.modals.edit-fact-info-abn-periode')
        @include('livewire.factures.historique.mt-letter-periode')
        @include('livewire.factures.historique.entete-releve-periode')
    </div>
</div>
