<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">CONSOMMATION PAR SERVICE</span>
            </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div class="input-group input-group-sm">
                            <input wire:model.defer='keySearch' type="date" wire:keydown.enter='getByDate' class="form-control">
                            <div class="input-group-append">
                              <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info" data-toggle='modal' data-target="#newConsModal" type="button"><i class="far fa-calendar-plus"></i> Nouvelle facture</button>
                </div>
                @php
                    $total=0;
                @endphp
                <div class="p-2">
                   @if ($consommations->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                   @else
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th class="">CODE</th>
                                    <th class="text-center">PRODUITS</th>
                                    <th class="text-center">UTILISATEUR</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consommations as $consommation)
                                <tr>
                                    <td><i class="fas fa-folder-open text-info"></i></td>
                                    <td>{{ $consommation->week }}</td>
                                    <td class="">{{ $consommation->code }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('consommation.week', $consommation->id) }}">
                                            {{ $consommation->getProductsWeek($consommation->id) }} Utilisé(s)
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $consommation->user->name }}</td>
                                    @if ($consommation->user->id==Auth::user()->id)
                                        <td class="text-center">
                                            <button wire:click='edit({{ $consommation->id }})' data-toggle="modal" data-target="#editConsModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-edit"></i></button>
                                            <button wire:click='showDeleteconsommationPharma1Dialog({{ $consommation->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                        </td>
                                    @else
                                        <td class="text-center text-danger">
                                            Unautorized
                                        </td>
                                    @endif

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   @endif

                </div>
            </div>
          </div>

        </div>
    </div>
    @include('livewire.consommation.modals.create-consommation-prod')
    @include('livewire.consommation.modals.edit-consommation-prod')
<!-- /.col -->
</div>
