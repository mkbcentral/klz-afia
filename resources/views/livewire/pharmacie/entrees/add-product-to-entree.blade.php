<div wire:ignore.self id="entreModal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                    <span style="font-size: 20px;">ELABORATION BON D'ENTREES</span>
                </h3>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mr-auto ml-auto">
                @foreach ($orderProducts as $index=>$orderProduct)
                    <div class="row">
                        <div class="Col-md-2">
                            <div class="form-group">
                                <label >Designation</label>
                                <select i class="form-control" wire:model.defer="orderProducts.{{ $index }}.product_id">
                                    <option>Choisir le produit</option>
                                    @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="Col-md-2">
                            <div class="form-group">
                                <label>Qt à payer</label>
                                <input class="form-control" wire:keydown.shift='addProductToOrder'
                                        wire:keydown.escape='removeOrderProduct({{ $index }})'
                                        wire:keydown.enter='addProduct'
                                        type="text" wire:model.defer="orderProducts.{{ $index }}.qty">
                            </div>
                        </div>
                        <div class="Col-md-2">
                            <div class="form-group">
                                <label for="my-input">Prix d'achat</label>
                                <input wire:keydown.shift='addProductToOrder' wire:keydown.escape='removeOrderProduct({{ $index }})'
                                        wire:keydown.enter='addProduct' class="form-control" type="text"
                                        wire:model.defer="orderProducts.{{ $index }}.price_to_by">
                            </div>
                        </div>

                        <div class="Col-md-1 mt-4 pt-2">
                            <div class="form-group">
                                <button wire:click='removeOrderProduct({{ $index }})' class="btn btn-light" type="button"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer d-flex justify-content-between mr-4 ml-4">
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
