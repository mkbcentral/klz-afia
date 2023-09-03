<div wire:ignore.self id="showFactPhamaAbnProductModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">LISTE DES ENTRES</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @if ($facture_orders == null)

                @else
                    @if ($facture_orders->products->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                    @php
                        $total=0;
                    @endphp
                        <table class="table table-sm">
                            <thead class="thead-dardk">
                                <tr>
                                    <th>#</th>
                                    <th>PRODUIT</th>
                                    <th class="text-center">Q.T</th>
                                    <th class="text-right">P.A CDF</th>
                                    <th class="text-right">P.T CDF</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facture_orders->products as $order)
                                    <tr>
                                        <td><i class="fas fa-capsules"></i></td>
                                        <td>{{ $order->name }}</td>
                                        @if ($facture_id_to_edit != $order->pivot->id)
                                            <td class="text-center">{{ $order->pivot->qty }}</td>
                                            <td class="text-right">{{ $order->price }}</td>
                                        @else
                                            <td class="text-center">
                                                <div class="form-group ml-4" style="width: 60px">
                                                    <input wire:keydown.enter='updateOrder({{$order->pivot->id }},{{$facture_orders->id }})' class="form-control" type="text" wire:model.defer="qtToEdit">
                                                </div>
                                            </td>
                                        @endif

                                        <td class="text-right">{{ $order->pivot->qty*$order->price }}</td>
                                        <td class="text-center">
                                            <button wire:click='activeEditfacture({{ $order->pivot->id }})'  class="btn btn-link" type="button"><i class="fas fa-edit    "></i></button>
                                            <button wire:click='deleteOrder({{$order->pivot->id }},{{$facture_orders->id }})' class="btn btn-link" type="button"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    @php
                                        $total+=$order->pivot->qty*$order->price ;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end mr-6">
                                   <div style="font-size: 18px;font-weight: bold">
                                        <span>Total: </span><span>{{ number_format($total,1)}} Fc</span>
                                   </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
