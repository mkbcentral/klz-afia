<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showProducts" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>LISTE DES PRODUITS</strong></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="w-100 p-4">
                <div class="d-flex justify-content-center">
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
            </div>
            <div>
                <table class="table table-light table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>DESIGNATION</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td></td>
                                <td>{{$product->name}}</td>
                                <td>
                                    <button wire:click='saveProds({{$product->id}})' class="btn btn-light btn-sm" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>
