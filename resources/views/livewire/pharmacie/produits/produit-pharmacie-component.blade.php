<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
              <div class="d-flex justify-content-between">
                  <div><h3 class="card-title">ETAT DE STOCK PRODUITS</h3></div>
                  <div class="mr-4">
                    <div class="dropdown">
                        <button id="my-dropdown" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print" aria-hidden="true"></i></button>
                        @if (Auth::user()->role->name=='Admin')
                            <div class="dropdown-menu" aria-labelledby="my-dropdown">
                                <a target="_blank" class="dropdown-item" href="{{ route('product.except.price') }}">Liste sans prix</a>
                                <a target="_blank" class="dropdown-item" href="{{ route('product.with.price') }}">Liste avec prix</a>
                                <a target="_blank" class="dropdown-item" href="{{ route('product.inventaire') }}">Fiche iventaire</a>
                            </div>
                        @endif
                    </div>
                  </div>
              </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between">
                    <div>
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
                    <div>
                        <button data-toggle="modal" data-target="#AddProductModal" class="btn btn-info btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>Nouveau</button>
                        <button wire:click='$refresh' class="btn btn-secondary btn-sm" type="button"><i class="fas fa-sync"></i> Actualiser</button>

                    </div>
                </div>
                <div class="mt-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>{{ session('message') }}
                        </div>
                    @endif
                    @if ($products->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                        <table class="table table-striped table-sm">
                            <thead class="thead-dark">
                                <tr><th>NOM PRODUIT</th>
                                    <th>STK INITIAL</th>
                                    <th class="text-center">QT ENTTREE</th>
                                    <th class="text-center">QT SORTIE</th>
                                    <th class="text-right">STOCK DISPO</th>
                                    <th class="text-right">PU. PRIVE</th>
                                    <th class="text-right">PU. ABONNE</th>
                                    <th class="text-right">DATE D'EXP.</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @php
                                        $stock_dispo=($product->quantity+
                                                        $product->getEntrees($product->id)-

                                                        $product->getSortieAmbulant($product->id)) ;
                                    @endphp
                                    <tr>
                                        @if ( $product->is_speciality==true)
                                            <td>{{$product->name}} <span class="text-danger">(Spec)</span></td>
                                        @else
                                            <td>{{$product->name}} <span class="text-success">(Gen)</span></td></td>
                                        @endif

                                        @if ($product->quantity==0)
                                            <td class="text-center text-success text-bold">{{$product->quantity}}</td>
                                        @else
                                            <td class="text-center text-success text-bold bg-info">{{$product->quantity}}</td>
                                        @endif

                                        @if ($product->getEntrees($product->id)==0)
                                            <td class="text-center text-primary">{{ $product->getEntrees($product->id) }}</td>
                                        @else
                                            <td class="text-center text-primary bg-dark">{{ $product->getEntrees($product->id) }}</td>
                                        @endif


                                        <td class="text-center">0</td>

                                        <td class="text-center">
                                            @if ($stock_dispo<=0)
                                                <span class="text-danger">Vide</span>
                                            @elseif ($stock_dispo<=5)
                                                <span class="text-secondary">{{$stock_dispo}} | Faible</span>
                                            @else
                                                <span class="text-success text-bold">{{$stock_dispo}}</span>
                                            @endif

                                        </td>
                                        <td class="text-right">{{$product->price}}</td>
                                        @if ($product->price_abonne==$product->price)
                                            <td class="text-right text-danger text-bold">{{$product->price_abonne}}</td>
                                        @else
                                            <td class="text-right">{{$product->price_abonne}}</td>
                                        @endif

                                        @if ((new DateTime($product->expirated_at))->format('m-Y') == date('m-Y'))
                                           <td class="text-right text-danger"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>{{(new DateTime($product->expirated_at))->format('M/Y')}}</td>
                                        @else
                                            <td class="text-right">{{(new DateTime($product->expirated_at))->format('M/Y')}}</td>
                                        @endif

                                        <td class="text-center">

                                            <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#EditProductModal" wire:click='edit({{$product->id}})' type="button"><i class="fas fa-edit    "></i></button>
                                            @if (Auth::user()->role->name=='Admin')
                                                <button class="btn btn-link btn-sm text-danger" type="button" wire:click='show({{$product->id}})'><i class="fas fa-trash    "></i></button>
                                            @endif
                                            @if ( $product->is_speciality==true)
                                            <button class="btn  btn-sm text-warning" type="button" wire:click='unmakSpaciality({{$product->id}})'><i class="fab fa-google"></i></button>
                                            @else
                                                <button class="btn  btn-sm text-success" type="button" wire:click='makSpaciality({{$product->id}})'><i class="fab fa-stripe-s"></i></button>

                                            @endif
                                            <button class="btn btn-link btn-sm text-danger" type="button" wire:click='show({{$product->id}})'><i class="fas fa-trash    "></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
          </div>
          <div class="card">
              <div class="d-flex justify-content-between">
                <div class="card-body">
                    {{$products->links('pagination::bootstrap-4')}}
                 </div>
                <div class="rown mt-4 mr-4">
                    <div class="col-auto ml-auto mb-4">
                        Afficher
                        <select wire:model.lazy='pageNumber'  class="custom-select w-auto" name="">
                            @for ($i=10;$i<=1000;$i+=100))
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
        <!-- /.card -->
    </div>
<!-- /.col -->

@include('livewire.pharmacie.produits.modals.add-product')
@include('livewire.pharmacie.produits.modals.edit-product')
</div>
