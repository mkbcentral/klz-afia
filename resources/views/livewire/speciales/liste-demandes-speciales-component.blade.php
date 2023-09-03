<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
          <div class="card-header">

            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                        <span style="font-size: 20px;">DEMANDES SPECIALES</span>
                    </h3>
                </div>
                <div>
                      @if ($factures->isEmpty())

                      @else
                          <div class="mt-2">
                              <span style="font-size: 18px;padding: 4px" class="badge rounded-pill bg-success">{{$factures->count()  }} Facture(s) établie(s)</span>
                          </div>
                      @endif
                </div>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="card-body">

                    @php
                        $toatl_general=0;
                    @endphp
                    <div class="d-flex justify-content-between">
                        <div class="mt-2 ml-5 w-25">
                            <div class="form-group">
                                <label for="">Année</label>
                                <select id="my-select" class="form-control" wire:model="currentYear">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 ml-5 w-25">
                            <div class="form-group">
                                <label for="">Mois</label>
                                <select id="my-select" class="form-control" wire:model="currentDate">
                                    @foreach ($mois as $moi)
                                        <option selected value="{{ $moi }}">{{ $moi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 ml-5 w-25">
                            <label for="">Type</label>
                            <select id="my-select" class="form-control" wire:model="myType">
                                <option >Choisir le type</option>
                                @foreach ($abonnements as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4 ml-5 w-25 text-right p-4">
                            <button data-toggle="modal" data-target="#addDemandeModal" class="btn btn-primary" type="button">Nouveau</button>
                            <a target="_blank" href="{{ route('print.recettes.speciale', [$currentDate,$myType,$currentYear]) }}">Imprimer</a>
                        </div>
                    </div>
                    @php
                        $total=0;
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="card-tools w-50 mb-4">
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
                            @if ($factures->isEmpty())
                                <div class="text-center mt-4 p-4">
                                    <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                                </div>
                            @else
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th># Date</th>
                                            <th class="text-center">NUMERO DE LA FACTURE</th>
                                            <th>NOM DU PATIENT</th>
                                            <th>TYPE</th>
                                            <th class="text-right">MONTANT CDF</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            <tr>
                                                <td scope="row">
                                                    <span class="text-primary">
                                                        <i class="fa fa-folder" aria-hidden="true"></i>
                                                        {{(new DateTime($facture->created_at))->format('d/m/Y')}}
                                                    </span>
                                                </td>
                                                <td class="text-primary text-center">{{$facture->numero}}</td>
                                                <td>
                                                    {{$facture->name}}

                                                </td>
                                                <td>
                                                    {{$facture->type}}

                                                </td>
                                                <td class="text-right">
                                                    <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                Courier New, monospace, serif">
                                                        {{number_format($facture->getTotal($facture->id),1)}}
                                                    </span>

                                                </td>
                                                <td class="text-center">
                                                    <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#showSpecialModal" class="btn btn-info btn-sm" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button wire:click='show({{$facture->id}})' data-toggle="modal" data-target="#editDemandeSpecialModdal" class="btn btn-primary btn-sm" type="button">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ route('create.facture.speciale', $facture) }}" class="btn btn-warning btn-sm"><i class="fab fa-telegram"></i></a>
                                                    <a target="_blank" href="{{ route('print.fact.speciale', $facture) }}" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                                                    <button wire:click='shuwDeleteDialogSpecial({{$facture->id}})' class="btn btn-danger btn-sm" type="button">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                    @if ($facture->is_inteneted==false)
                                                        <button wire:click='internate({{$facture->id}})' class="btn btn-danger btn-sm" type="button">I</button>
                                                    @else
                                                    <button wire:click='internate({{$facture->id}})' class="btn btn-primary btn-sm" type="button">X</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $total=+$total+$facture->getTotal($facture->id);
                                            @endphp
                                        @endforeach
                                    </tbody>

                                </table>
                            @endif
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end p-2">
                                    <h3 class="text-bold mr-4">Total: {{number_format($total,1)}} CDF</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </div>
        @include('livewire.speciales.add-new-demande')
        @include('livewire.speciales.show-speciale')
        @include('livewire.speciales.edit-epecial')
      </div>

</div>
