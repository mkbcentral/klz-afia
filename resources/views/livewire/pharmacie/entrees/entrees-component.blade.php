<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">ENTREES EN STCOK </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <button class="btn btn-info" wire:click='showDialog' type="button"><i class="far fa-calendar-plus"></i> Nouvelle entrée</button>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="">Mois</label>
                            <select id="my-select" class="form-control" wire:model="currentMonth">
                                @foreach ($mois as $moi)
                                    <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="p-2">
                   @if ($entrees->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                   @else
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">Q.T</th>
                                    <th>UTILISATEUR</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrees as $entree)
                                    @if ($entree->is_valided==true)
                                        <tr class="text-success">
                                            <td><i class="fas fa-folder-open text-info"></i></td>
                                            <td>{{ (new DateTime($entree->created_at))->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $entree->code }}</td>
                                            <td class="text-center">{{ $entree->products()->count() }}</td>
                                            <td>{{ $entree->user->name }}</td>
                                            <td class="text-center">
                                                <button wire:click='showOrder({{ $entree->id }})' data-toggle="modal"
                                                        data-target="#showProductModal" class="btn btn-link btn-sm" type="button">
                                                    <i class="fa fa-eye text-secondary" aria-hidden="true"></i>
                                                </button><i class="fa fa-check" aria-hidden="true"></i>
                                                <a target="_blank" href="" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><i class="fas fa-folder-open text-info"></i></td>
                                            <td>{{ (new DateTime($entree->created_at))->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $entree->code }}</td>
                                            <td class="text-center">{{ $entree->products()->count() }}</td>
                                            <td>{{ $entree->user->name }}</td>
                                            <td class="text-center">
                                                <button wire:click='show({{ $entree->id }})' data-toggle="modal" data-target="#entreModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                                <button wire:click='showOrder({{ $entree->id }})' data-toggle="modal" data-target="#showProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                                <button wire:click='showDeleteEntree1Dialog({{ $entree->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                                <a target="_blank" href="" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                   @endif
                </div>
            </div>
          </div>

        </div>

        <!-- /.card -->
        @include('livewire.pharmacie.entrees.add-product-to-entree')
        @include('livewire.pharmacie.entrees.show-entree')
    </div>

<!-- /.col -->
</div>
