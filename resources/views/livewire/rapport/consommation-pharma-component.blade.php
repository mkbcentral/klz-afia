<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="input-group input-group-sm">
                        <input wire:model.defer='myDate' type="date" wire:keydown.enter='getByDate' class="form-control">
                            <div class="input-group-append">
                              <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                              </div>
                            </div>
                          </div>
                </div>
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
                <div>
                    <a target="_blank" href="{{ route('commations.prods',[$currentDate,$currentMonth]) }}">Imprimer</a>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-stripped">
                <thead class="thead-light">
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Stock initail</th>
                        <th class="text-center">Qté sortie</th>
                        <th class="text-center">Qté entrée</th>
                        <th class="text-center">Stock disponible</th>
                    </tr>
                </thead >
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
