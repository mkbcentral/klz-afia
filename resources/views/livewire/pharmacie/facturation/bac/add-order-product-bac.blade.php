<div wire:ignore.self id="orderProductBacModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">PRESCRIPTION MEDICALE</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($orderProducts as $index=>$orderProduct)
                    <div class="row">
                        <div class="Col-md-5">
                            <div class="form-group">
                                <label >Produist pharmaceutiques</label>
                                <select i class="form-control" wire:model.defer="orderProducts.{{ $index }}.product_id">
                                    <option>Choisir le produit</option>
                                    @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="Col-md-5">
                            <div class="form-group">
                                <label>Qt prescrite</label>
                                <input class="form-control" wire:keydown.shift='addProductToOrder'
                                        wire:keydown.escape='removeOrderProduct({{ $index }})'
                                        wire:keydown.enter='addProduct'
                                        type="text" wire:model.defer="orderProducts.{{ $index }}.qty">
                            </div>
                        </div>
                        <div class="Col-md-2 mt-4 pt-2">
                            <div class="form-group">
                                <button wire:click='removeOrderProduct({{ $index }})' class="btn btn-light" type="button"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer d-flex justify-content-between">
               <div>
                    <button class="btn btn-primary" wire:click='addProductToOrder' type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
               </div>
               <div>
                    <button class="btn btn-info btn-sm" wire:click='addProduct' type="button">Valider</button>
               </div>
            </div>
        </div>
    </div>
</div>
