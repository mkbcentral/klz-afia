<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-success" id="my-modal-title">
                <span style="font-size: 20px;">LISTE DES FACTURES ABONNES</span>
            </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between">
                    <div class="mt-2 ml-5">
                        <div class="card-tools">
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

                    @else
                        <div class="d-flex justify-content-center p-2">
                            <div class="mt-2">
                                <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-info">{{$factures->count()  }} Facture(s) </span>
                            </div>
                        </div>
                    @endif
                    <div>
                        <div class="input-group mb-3 mt-2 ml-">
                            <input type="date" class="form-control" wire:keydown.enter='getByDate' wire:keydown.escape='getCurrentDate' placeholder="" wire:model.defer='searchDate' aria-describedby="button-addon1">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary"  wire:click='getByDate' type="button" id="button-addon1"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
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
                                            <td class="text-right">
                                                <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                            Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                            Courier New, monospace, serif">
                                                    {{ number_format($facture->getTotalAbonne($facture->id),1) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showdDetailFactureAbonneModal" class="btn btn-info btn-sm" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('create.facture.abonne',$facture) }}" class="btn btn-danger btn-sm"><i class="fab fa-telegram"></i></a>
                                                <a href="" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
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
        <!-- /.card -->
      </div>
      <!-- /.col -->
      @include('livewire.factures.facturation.show-fact-abonne')
</div>
