<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">CONSOMMATION JOURNALIERE</span>
            </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="p-2 d-flex justify-content-between">
                <div>
                    <div><span class="text-bold">Semaiane</span>: {{$consommation->week}}</div>
                    <div><span class="text-bold">Service</span>: {{$consommation->service->name}}</div>
                </div>
                <div class="mr-4">
                    <button data-toggle="modal" data-target="#newDayModal" class="btn btn-primary btn-sm" type="button">Nouveau jour</button>
                </div>
            </div>

            <div>
                <div class="row p-2">
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header">
                                LISTE DES JOURS
                            </div>
                            <div class="card-body">
                                <table class="table table-light table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>JOUR</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($days as $item)
                                            <tr>
                                                <td>
                                                    <button wire:click='getDayName({{$item->id}})' class="btn btn-link btn-sm" type="button">{{$item->day}}</button>
                                                </td>
                                                <td class="text-right"><button wire:click='show({{$item->id}})' data-toggle="modal" data-target="#showProducts" class="btn btn-light btn-sm" type="button"><i class="fa fa-plus-circle text-primary" aria-hidden="true"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                DETAIL PAR JOUR
                            </div>
                            <div class="card-body">
                                @if ($day_products->isEmpty())
                                    <div class="text-center">
                                        <span class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aucune donnée</span>
                                    </div>
                                @else
                                    <table class="table table-light table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>PRODUIT</th>
                                                <th>DETAILS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($day_products as $day)
                                                <tr>
                                                    <td>
                                                        <button wire:click='showDay({{$day->id}})' data-toggle="modal" data-target="#orderDayModal" class="btn btn-light btn-sm" type="button"><i class="fa fa-plus text-danger" aria-hidden="true"></i></button>
                                                    </td>
                                                    <td>{{$day->product->name}}</td>
                                                    <td>
                                                        @if ($day->getOrder($day->id)->isEmpty())
                                                            <div class="text-center">
                                                                <span class=" text-success"><i class="fa fa-database" aria-hidden="true"></i> Aucune donnée</span>
                                                            </div>
                                                        @else
                                                        <table class="table table-light">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>TYPE</th>
                                                                    <th class="text-center">QUANTITE</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($day->getOrder($day->id) as $order)
                                                                    <tr>
                                                                        <td>{{$order->type}}</td>
                                                                        <td class="text-center">{{$order->qty}}</td>
                                                                        <td><button wire:click='deleteOrder({{$order->id}})' class="btn btn-light" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>

                                                        </table>
                                                        @endif

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
          </div>

        </div>
    </div>

    @include('livewire.consommation.modals.add-day-week')
    @include('livewire.consommation.modals.show-products')
    @include('livewire.consommation.modals.add-day-order')
<!-- /.col -->
</div>
