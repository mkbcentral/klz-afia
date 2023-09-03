<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">FACTURATION AMBULANTS</span>
            </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div class="input-group w-75">
                        <select class="custom-select" wire:model='currentDate' >
                            @foreach ($mois as $moi)
                                <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="mr-4 mt-2">
                        <a target="_bank" href="{{ route('ventes.pharma.month', $currentDate) }}">Imprimer</a>
                    </div>
                </div>
                @php
                    $total=0;
                @endphp
                <div class="p-2">
                   @if ($factures->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                   @else
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th class="">CODE</th>
                                    <th class="Ttext-center">DESIGNATION</th>
                                    <th class="text-center">PRODUITS</th>
                                    <th class="text-center">M.T</th>
                                    <th class="text-center">UTILISATEUR</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)
                                <tr>
                                    <td><i class="fas fa-folder-open text-info"></i></td>
                                    <td>{{ (new DateTime($facture->created_at))->format('d/m/Y') }}</td>
                                    <td class="">{{ $facture->numero }}</td>
                                    <td clasproducts="text-center">{{ $facture->name }}</td>
                                    <td class="text-center">{{ $facture->products->count() }}</td>
                                    <td  style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                        Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                        Courier New, monospace, serif" class="text-right">{{number_format($facture->getTotal($facture->id))}}
                                    </td>
                                    <td class="text-center">{{ $facture->user->name }}</td>
                                    <td class="text-center">
                                        Ok !
                                    </td>
                                    @php
                                        $total+=$facture->getTotal($facture->id);
                                    @endphp
                                </tr>

                                @endforeach
                            </tbody>
                        </table>

                   @endif

                </div>
            </div>
            <div class="d-flex justify-content-end p-2">
                <div style="font-size: 22px;margin-right: 400px;
                font-family:Consolas, Menlo, Monaco, Lucida Console,
                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                Courier New, monospace, serif">Total:{{number_format($total,1)}} Fc</div>
            </div>
          </div>

        </div>
    </div>

<!-- /.col -->
</div>
