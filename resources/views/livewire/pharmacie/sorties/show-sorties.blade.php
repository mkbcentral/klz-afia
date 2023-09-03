<div wire:ignore.self id="showSortieProductModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                    <span style="font-size: 20px;">LISTE DES SORTIES</span>
                </h3>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($sortie_orders == null)

                @else
                    @if ($sortie_orders->products->isEmpty())
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
                                    <th class="text-right">P.U CDF</th>
                                    <th class="text-right">P.T CDF</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sortie_orders->products as $order)
                                    <tr>
                                        <td><i class="fas fa-capsules"></i></td>
                                        <td>{{ $order->name }}</td>
                                        @if ($sortie_id_to_edit != $order->pivot->id)
                                            <td class="text-center">{{ $order->pivot->qty }}</td>
                                            <td class="text-right">{{ $order->price }}</td>
                                        @else
                                            <td class="text-center">
                                                <div class="form-group ml-4" style="width: 60px">
                                                    <input wire:keydown.enter='updateOrder({{$order->pivot->id }},{{$sortie_orders->id }})' class="form-control" type="text" wire:model.defer="qtToEdit">
                                                </div>
                                            </td>
                                        @endif

                                        <td class="text-right">{{ $order->pivot->qty*$order->price }}</td>
                                       @if ($sortie_orders->is_valided==true)
                                            <td class="text-center">
                                               <i class="fa fa-check text-success" aria-hidden="true"></i>
                                            </td>
                                       @else
                                            @if ($sortie_orders->user->id==Auth::user()->id)
                                                <td class="text-center">
                                                    <button wire:click='activeEditsortie({{ $order->pivot->id }})'  class="btn btn-link" type="button"><i class="fas fa-edit    "></i></button>
                                                    <button wire:click='deleteOrder({{$order->pivot->id }},{{$sortie_orders->id }})' class="btn btn-link" type="button"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                                </td>
                                            @else
                                                <td class="text-center text-danger">
                                                    Unautorized
                                                </td>
                                            @endif

                                       @endif
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
            <div class="modal-footer mr-4">
               @if ($sortie_orders != null)
                    @if ($sortie_orders->is_valided==true)
                        <div>
                            <i class="fa fa-check-circle text-success" aria-hidden="true"> Validé !</i>
                            <button wire:click='unValidateOrder({{ $sortie_orders->id }})' class="btn btn-link" type="button"><i class="fas fa-times-circle text-danger"></i></button>
                        </div>
                    @else
                        <button wire:click='validateOrder({{ $sortie_orders->id }})' class="btn btn-info" type="button">
                            <i class="fa fa-check" aria-hidden="true"></i>Valider</button>
                    @endif
               @endif
            </div>
        </div>
    </div>
</div>
