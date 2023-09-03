<div wire:ignore.self id="productModal" class="modal fade" >
    <div class="modal-dialog modal-xl">
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
                        <div class="Col-md-3">
                            <div class="form-group">
                                <label >Medicament</label>
                                <select i class="form-control" wire:model.defer="orderProducts.{{ $index }}.product_id">
                                    <option>Choisir le produit</option>
                                    @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="Col-md-3">
                            <div class="form-group">
                                <label>Qt prescrite</label>
                                <input class="form-control" wire:keydown.shift='addProductToOrder'
                                        wire:keydown.escape='removeOrderProduct({{ $index }})'
                                        wire:keydown.enter='addProduct'
                                        type="text" wire:model.defer="orderProducts.{{ $index }}.qty">
                            </div>
                        </div>
                        <div class="Col-md-3">
                            <div class="form-group">
                                <label for="my-input">Posologie</label>
                                <input wire:keydown.shift='addProductToOrder' wire:keydown.escape='removeOrderProduct({{ $index }})'
                                        wire:keydown.enter='addProduct' class="form-control" type="text"
                                        wire:model.defer="orderProducts.{{ $index }}.posology">
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
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='addProduct' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
