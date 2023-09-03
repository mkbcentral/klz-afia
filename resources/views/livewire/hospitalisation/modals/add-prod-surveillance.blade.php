<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addSurveillanceProd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>LISTE DES PRODUITS</strong></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center">
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
            </div>
            <table class="table table-light table-sm mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th>Nom produit</th>
                        <th>
                            QUANTITE
                        </th>
                        <th>HEURE</th>
                        <th class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $prod)
                        <tr>
                            <td>{{$prod->name}}</td>
                            <td>
                                @if ($idProdSelect!=$prod->id)
                                    -
                                @else
                                    <div class="form-group">
                                        <input wire:model.defer='qty' class="form-control" type="text"
                                            wire:keydown.enter='validedData({{$prod->id}})'>
                                    </div>
                                @endif

                            </td>
                            <td>
                                @if ($idProdSelect!=$prod->id)
                                    -
                                @else
                                    <div class="form-group">
                                        <input class="form-control" type="text"  wire:model.defer='time_data'
                                        wire:keydown.enter='validedData({{$prod->id}})'>
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">
                                <button class="btn btn-primary btn-sm" wire:click='activeWriter({{$prod->id}})' type="button"><i class="fas fa-edit    "></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
      </div>
    </div>
</div

