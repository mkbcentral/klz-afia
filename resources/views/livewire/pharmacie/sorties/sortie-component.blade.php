<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mt-2">SORTIE EN STCOK </h3></div>
                <div class="w-50">
                    <div class="form-group ">
                        <div class="input-group mb-3 mt-2 ml-">
                            <select id="my-select" class="form-control" wire:model="monthName">
                                @foreach ($mois as $moi)
                                    <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-prepend">
                                <button   class="btn btn-primary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
               @if (Auth::user()->role->name=="Admin")
                <div class="d-flex justify-content-end p-2">
                    <div class="input-group">
                        <select class="custom-select" wire:model.defer='service_id' >
                        <option selected>Choisir le service...</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                        </select>
                        <div class="input-group-append">
                        <button class="btn btn-info" wire:click='showDialog' type="button">
                            <i class="far fa-calendar-plus"> Nouvelle sortie</i>
                        </button>
                        </div>
                        @error('service_id') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                    </div>
                </div>
               @endif

                <div class="p-2">
                   @if ($sorties->isEmpty())
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
                                    <th>SERVICE</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sorties as $sortie)
                                    @if ($sortie->is_valided==true)
                                        <tr class="text-success">
                                            <td><i class="fas fa-folder-open text-info"></i></td>
                                            <td>{{ (new DateTime($sortie->created_at))->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $sortie->code }}</td>
                                            <td class="text-center">{{ $sortie->products()->count() }}</td>
                                            <td>{{ $sortie->user->name }}</td>
                                            <td>{{ $sortie->service->name }}</td>
                                            <td class="text-center">
                                                <button wire:click='showOrder({{ $sortie->id }})' data-toggle="modal"
                                                        data-target="#showSortieProductModal" class="btn btn-link btn-sm" type="button">
                                                    <i class="fa fa-eye text-secondary" aria-hidden="true"></i>
                                                </button><i class="fa fa-check" aria-hidden="true"></i>
                                                <a target="_blank" href="{{ route('product.sortie.service', $sortie) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><i class="fas fa-folder-open text-info">{{$sortie->id}}</i></td>
                                            <td>{{ (new DateTime($sortie->created_at))->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $sortie->code }}</td>
                                            <td class="text-center">{{ $sortie->products()->count() }}</td>
                                            <td>{{ $sortie->user->name }}</td>
                                            <td>{{ $sortie->service->name }}</td>
                                            @if ($sortie->user->id==Auth::user()->id)
                                                <td class="text-center">
                                                    <button wire:click='show({{ $sortie->id }})' data-toggle="modal" data-target="#sortieModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                                    <button wire:click='showOrder({{ $sortie->id }})' data-toggle="modal" data-target="#showSortieProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                                    <button wire:click='showDeletesortie1Dialog({{ $sortie->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                                    <a target="_blank" href="{{ route('product.sortie.service', $sortie) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <button wire:click='showOrder({{ $sortie->id }})' data-toggle="modal" data-target="#showSortieProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                                    <a target="_blank" href="{{ route('product.sortie.service', $sortie) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                </td>
                                            @endif
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
        </div>
        <!-- /.card -->
        @include('livewire.pharmacie.sorties.add-product-to-sortie')
        @include('livewire.pharmacie.sorties.show-sorties')
    </div>

<!-- /.col -->
</div>
