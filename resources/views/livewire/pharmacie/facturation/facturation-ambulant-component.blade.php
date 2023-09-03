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
                    <div>
                        <div class="input-group input-group-sm">
                            <input wire:model.defer='keySearch' type="date" wire:keydown.enter='getByDate' class="form-control">
                            <div class="input-group-append">
                              <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info" data-toggle='modal' data-target="#newFactureModal" type="button"><i class="far fa-calendar-plus"></i> Nouvelle facture</button>
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
                                    @if ($facture->is_valided==true)
                                        <tr class="text-success">
                                            <td><i class="fas fa-folder-open text-info"></i></td>
                                            <td>{{ (new DateTime($facture->created_at))->format('d/m/Y') }}</td>
                                            <td class="">{{ $facture->numero }}</td>
                                            <td class="text-center">{{ $facture->name }}</td>
                                            <td class="text-center">{{ $facture->products->count() }}</td>
                                            <td  style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                Courier New, monospace, serif" class="text-right">{{number_format($facture->getTotal($facture->id))}}
                                            </td>
                                            <td>{{$facture->getTotal($facture->id)}}</td>
                                            <td>{{ $facture->user->name }}</td>
                                            <td class="text-center">
                                                <button wire:click='showOrder({{ $facture->id }})' data-toggle="modal"
                                                        data-target="#showOrderProductModal" class="btn btn-link btn-sm" type="button">
                                                    <i class="fa fa-eye text-secondary" aria-hidden="true"></i>
                                                </button><i class="fa fa-check" aria-hidden="true"></i>

                                            </td>
                                            @php
                                                $total+=$facture->getTotal($facture->id);
                                            @endphp
                                        </tr>
                                    @else
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
                                            @if ($facture->user->id==Auth::user()->id)
                                                <td class="text-center">
                                                    <button wire:click='show({{ $facture->id }})' data-toggle="modal" data-target="#orderProductModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                                    <button wire:click='edit({{ $facture->id }})' data-toggle="modal" data-target="#editFactureModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-edit"></i></button>
                                                    <button wire:click='showOrder({{ $facture->id }})' data-toggle="modal" data-target="#showOrderProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                                    <button wire:click='showDeletefacturePharma1Dialog({{ $facture->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                                    <a target="_blank" href="{{ route('print.receipt.ambulant',$facture->id) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                </td>
                                            @else
                                                <td class="text-center text-danger">
                                                    Unautorized
                                                    <button wire:click='show({{ $facture->id }})' data-toggle="modal" data-target="#orderProductModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                                    <button wire:click='edit({{ $facture->id }})' data-toggle="modal" data-target="#editFactureModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-edit"></i></button>
                                                    <button wire:click='showOrder({{ $facture->id }})' data-toggle="modal" data-target="#showOrderProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                                    <button wire:click='showDeletefacturePharma1Dialog({{ $facture->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                                    <a target="_blank" href="{{ route('print.receipt.ambulant',$facture->id) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                </td>
                                            @endif
                                            @php
                                                $total+=$facture->getTotal($facture->id);
                                            @endphp
                                        </tr>
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end p-2">
                            <div style="font-size: 22px;margin-right: 400px;
                            font-family:Consolas, Menlo, Monaco, Lucida Console,
                            Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                            Courier New, monospace, serif">Total:{{number_format($total,1)}} Fc</div>
                        </div>
                   @endif

                </div>
            </div>
          </div>

        </div>
        @include('livewire.pharmacie.facturation.add-new-facture')
        @include('livewire.pharmacie.facturation.add-order-product')
        @include('livewire.pharmacie.facturation.show-order-product')
        @include('livewire.pharmacie.facturation.edit-pharma-fact')
    </div>

<!-- /.col -->
</div>
