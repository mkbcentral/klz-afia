<div>
    <x-loading-indicator />
    <!-- /.col <x-loading-indicator /> -->
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
                                      <div class="">
                                          <span style="font-size:
                                          18px;padding: 4px" class="badge rounded-pill bg-secondary">
                                          <i class="far fa-bell"></i>
                                          {{$factures->count() + $fac_speciales->count()}} Facture(s)</span>
                                      </div>

                                  @endif
                            </div>
                            <div>
                                  @if ($factures->isEmpty())

                                  @else
                                      <div class="p-2 ml-4">
                                            <button class="btn btn-secondary btn-sm"
                                            data-toggle="modal" data-target="#enteteModal" type="button">Ajouter l'entete</button>
                                            <a target="_blank"
                                                    href="{{ route('print.revele.month',
                                                    [$entete,$currentDate,$abonnementData,$mtLetter,$currentYear])}}"
                                                class="btn btn-primary btn-sm" type="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimer
                                            </a>
                                           <a target="_blank" href="{{ route('print.fact.abn.all',[$currentDate,$abonnementData,$currentYear])}}"
                                                class="btn btn-primary btn-sm" type="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimer tous</a>
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
                                                <th class="text-center">NUMERO DE LA FACTURE</th>
                                                <th>NOM DU PATIENT</th>
                                                <th>CORRECTION</th>
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
                                                    <td>
                                                        @if ($facture->is_valided==true)
                                                            <span class="text-success">Corrigé !</span>
                                                        @else
                                                            <span class="text-danger">En cours...</span>
                                                        @endif
                                                    </td>
                                                    @if ($facture->getTotalAbonne($facture->id) == 2000)
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
                                                        @if (Auth::user()->role->name=="Medecin chef")
                                                            <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailHistorikAbonneModal" class="btn btn-info btn-sm" type="button">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <a href="{{ route('create.facture.abonne',$facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                        @else
                                                            <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailHistorikAbonneModal" class="btn btn-info btn-sm" type="button">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#EditNumAndDateModalAbn" class="btn btn-primary btn-sm" type="button">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <a href="{{ route('create.facture.abonne',$facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                            <a target="_blank" href="{{ route('print.fact.abones', $facture) }}" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                                                            <button wire:click='shuwDeleteDialog({{$facture->id}})' class="btn btn-danger btn-sm" type="button">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @php
                                                    $toatl_general+=$facture->getTotalAbonne($facture->id);
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>

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
                                                                    {{(new DateTime($speciale->created_at))->format('d/m/Y')}}
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
        @include('livewire.factures.historique.show-detail-abn')
        @include('livewire.factures.facturation.modals.edit-fact-info-abn')
        @include('livewire.factures.historique.mt-letter')
        @include('livewire.factures.historique.entete-releve')
    </div>
</div>
