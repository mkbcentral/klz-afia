<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
          <div class="card-header">

            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="card-title">HISTORIQUE FACTURES PRIVES</h3>
                </div>
                <div>
                      @if ($factures->isEmpty())

                      @else
                          <div class="mt-2">
                              <span style="font-size: 18px;padding: 4px" class="badge
                              rounded-pill bg-success"><i class="far fa-bell"></i> {{$factures->count()  }} Facture(s) établie(s)</span>
                          </div>
                      @endif
                </div>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="card-body">

                    @php
                        $toatl_general=0;
                    @endphp
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
                                                        <span class="text-danger">[Golf | <span class="text-secondary">{{$facture->getHospitalises($facture->id)}}</span> ]</span>
                                                    @else
                                                        <span class="text-success">[Ville]</span>
                                                    @endif
                                                </td>
                                                <td class="text-primary text-center">{{$facture->numero}}</td>

                                                <td>
                                                    {{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}}
                                                    @if ($facture->reduction !=null)
                                                        | <span class="text-success">Sous reduction</span>
                                                    @endif
                                                    @if ($facture->accompte !=null)
                                                    | <span class="text-info">Sous accompte</span>
                                                @endif
                                                </td>
                                                <td class="text-right">
                                                    <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                Courier New, monospace, serif">
                                                        {{number_format($facture->getTotalPrive($facture->id),1)}}
                                                    </span>

                                                </td>
                                                <td class="text-center">
                                                    @if (Auth::user()->role->name=="Medecin chef")
                                                        <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailHistikPvrModal" class="btn btn-info btn-sm" type="button">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('create.facture', $facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                    @else
                                                        <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailHistikPvrModal" class="btn btn-info btn-sm" type="button">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button wire:click='edit({{$facture->id}})' data-toggle="modal" data-target="#editNumAndDateModalPv" class="btn btn-primary btn-sm" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="{{ route('create.facture', $facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                        <a target="_blank" href="{{ route('print.fact.prives',$facture) }}" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                                                        <button wire:click='shuwDeleteDialogAbn({{$facture->id}})' class="btn btn-danger btn-sm" type="button">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $toatl_general+=$facture->getTotalPrive($facture->id);
                                            @endphp
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

                                </div>
                                <div style="margin-right: 30px;" >
                                    <div class="row">
                                        <div class="col-auto ml-auto mb-4">
                                            Afficher
                                            <select wire:model.lazy='page_number'  class="custom-select w-auto" name="">
                                                @for ($i=10;$i<=100;$i+=10))
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
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex justify-content-between">
                                <div style="margin-right: 30px;font-size: 30px;font-weight: bold">
                                    <span>Total USD: {{ number_format($toatl_general/$valeur_taux,1) }} </span>
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
        </div>
        </div>
        <!-- /.card -->
        @include('livewire.factures.facturation.modals.edit-date-and-number-pv')
        <!-- /.col -->
        @include('livewire.factures.historique.show-detail-pv')
      </div>
</div>
