<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
              <div class="d-flex justify-content-between">
                  <div><h3 class="card-title">ETAT DE STOCK</h3></div>
                  <div class="mr-4">
                        <a href="">Imprimer</a>
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
                    </div>
                </div>
                @php
                    $total_pv=0;
                    $total_abn=0;
                @endphp
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
                                    <th class="text-center">QT INITIAL</th>
                                    <th class="text-center">QT ACHAT</th>
                                    <th class="text-center">STOCK DISPO</th>
                                    <th class="text-right">PU. PRIVE</th>
                                    <th class="text-right">PU. ABONNE</th>
                                    <th class="text-right">MT A G PRIVE</th>
                                    <th class="text-right">MT A G ABONNES</th>
                                    <th class="text-right">DATE EXPI.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @php
                                        $stock_dispo=(0+
                                        $product->getAchat($product->id)) ;
                                    @endphp

                                    @if ($product->getAchat($product->id))
                                        <tr>
                                            @if ( $product->is_speciality==true)
                                                <td>{{$product->name}} <span class="text-danger">(Spec)</span></td>
                                            @else
                                                <td>{{$product->name}} <span class="text-success">(Gen)</span></td></td>
                                            @endif

                                            <td class="text-center">{{0}}</td>
                                            <td class="text-center">{{$product->getAchat($product->id)}}</td>
                                            <td class="text-center">{{$stock_dispo}}</td>
                                            <td class="text-right">{{$product->price}}</td>
                                            <td class="text-right">{{$product->price_abonne}}</td>
                                            <td class="text-right">{{$product->price*$stock_dispo}}</td>
                                            <td class="text-right">{{$product->price_abonne*$stock_dispo}}</td>
                                            <td class="text-right">{{(new DateTime($product->expirated_at))->format('M/Y')}}</td>
                                            @php
                                                $total_pv+=$product->price*$stock_dispo;
                                                $total_abn+=$product->price_abonne*$stock_dispo;
                                            @endphp
                                        </tr>
                                        @endif
                                @endforeach
                                <tr class="bg-dark">
                                    <td style="font-size: 18px" class="text-center text-bold">TOTAL CDF</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="font-size: 16px" class="text-right text-bold">{{number_format($total_pv,1)}}</td>
                                    <td style="font-size: 16px" class="text-right text-bold">{{number_format($total_abn,1)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
