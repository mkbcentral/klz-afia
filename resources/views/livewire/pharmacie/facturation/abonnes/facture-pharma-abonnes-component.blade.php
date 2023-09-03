<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">LISTE FACTURE ABONNES</span>
            </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-center ">
                    <div class="d-flex justify-content-center p-3">
                        <div class="mt-2">
                            <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-info">{{$factures->count()  }} Facture(s) établie(s)</span>
                        </div>
                    </div>
                </div>
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
                    <div class="form-group ml-2">
                        <label for="">Nom société</label>
                        <select id="my-select" class="form-control" wire:model="abonnementData">
                            <option>Choisir la société ici...</option>
                            @foreach ($abonnements as $abonnement)
                                <option value="{{ $abonnement->id }}">{{ $abonnement->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($factures->isEmpty())

                    @else
                        <div class="mt-2 ">
                            <div >
                                <div class="card-tools">
                                    <label for="">Rechercher par nom</label>
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
                        </div>
                    @endif
                    <div>
                        <div class="form-group mr-4">
                            <label for="">Mois</label>
                            <select id="my-select" class="form-control" wire:model="currentDate">
                                @foreach ($mois as $moi)
                                    <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi,10)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @php
                    $total=0;
                @endphp
                <div class="card">
                    <div class="card-body">
                        @if ($factures->isEmpty())
                            <div class="text-center mt-4 p-4">
                                <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                            </div>
                        @else
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th># Date</th>
                                        <th class="text-center">NUMERO FACT.</th>
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
                                            <td>{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}} <span class="text-success">[Ambulant]</span></td>
                                            @if ($facture->getTotalPharma($facture->id)==0)
                                                <td class="text-right bg-danger">
                                                    <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                Courier New, monospace, serif">
                                                        {{ number_format($facture->getTotalPharma($facture->id),1) }}
                                                    </span>
                                                </td>
                                            @else
                                                <td class="text-right">
                                                    <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                Courier New, monospace, serif">
                                                        {{ number_format($facture->getTotalPharma($facture->id),1) }}
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <button wire:click='show({{$facture->id}})'
                                                    data-toggle="modal" data-target="#showOrderFacturePharmaAbonneModal"
                                                    class="btn btn-info btn-sm" type="button">
                                                   <i class="fas fa-eye"></i>
                                               </button>

                                                <a href="{{ route('create.order.facture',$facture) }}"  class="btn btn-danger btn-sm"><i class="fab fa-telegram"></i></a>
                                                @if ($facture->is_livred==false)
                                                    <button wire:click='livred({{$facture->id}})'
                                                        class="btn btn-success btn-sm" type="button">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                @else
                                                    <button wire:click='unlivred({{$facture->id}})'
                                                        class="btn btn-warning btn-sm" type="button">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $total+=$facture->getTotalPharma($facture->id);
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>

                        @endif
                        <div class="d-flex justify-content-end p-2">
                            <div style="font-size: 22px;margin-right: 180px">Total:{{number_format($total,1)}} Fc</div>
                        </div>
                    </div>
                </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      @include('livewire.pharmacie.facturation.abonnes.show-order-abonnes-proucts')
</div>
