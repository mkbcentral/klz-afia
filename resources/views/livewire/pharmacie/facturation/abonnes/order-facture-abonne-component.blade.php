<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">DETAILS PATIENTS ABONNES</h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div><span class="text-bold">N° Fiche:</span> {{$facture_data->fiche->numero}}</div>
                        <div><span class="text-bold">Noms:</span> {{$facture_data->fiche->patientAbonne->Nom.' '.$facture_data->fiche->patientAbonne->Postnom.' '.$facture_data->fiche->patientAbonne->Prenom}}</div>
                        <div><span class="text-bold">Type:</span> <span class="text-danger">{{$facture_data->fiche->type}}</span></div>
                        <div><span class="text-bold">Societé:</span> <span class="text-danger">{{$facture_data->fiche->patientAbonne->abonnement->name}}</span></div>
                    </div>
                    <div>

                    </div>
                    <div>
                        <div><span class="text-bold">Emise le:</span> {{(new DateTime($facture_data->created_at))->format('d/m/Y')}}</div>
                        <div><span class="text-bold">Sexe: </span> {{$facture_data->fiche->patientAbonne->Sexe}}</div>
                        <div><span class="text-bold">Age: </span> <span class="">{{$facture_data->fiche->patientAbonne->getAge($facture_data->fiche->patientAbonne->id)}} ans</span></div>
                        <div><span class="text-bold">Est: </span> <span class="">{{$facture_data->fiche->patientAbonne->Type}}</span></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
          </div>

          <div class="d-flex justify-content-end p-2">
            <button class="btn btn-info" wire:click='showDialog' type="button">
                <i class="far fa-calendar-plus"></i> Nouvelle facture</button>
        </div>
        @if ($facture_data->facturePharmaAbn->isEmpty())

        @else
        <div class="p-2">
            @if ($factures->isEmpty())
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

                             <th class="text-right">UTILISATEUR</th>
                             <th class="text-right">ACTIONS</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($factures as $facture)
                             <tr>
                                 <td><i class="fas fa-folder-open text-info"></i></td>
                                 <td>{{ (new DateTime($facture->created_at))->format('d/m/Y') }}</td>
                                 <td class="text-center">{{ $facture->code }}</td>
                                 <td class="text-center">{{ $facture->products()->count() }}</td>

                                 <td class="text-right">{{ $facture->user->name }}</td>
                                 <td class="text-right">
                                     <button wire:click='show({{ $facture->id }})' data-toggle="modal" data-target="#factPharmaAbnModal" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                     <button wire:click='showOrder({{ $facture->id }})' data-toggle="modal" data-target="#showFactPhamaAbnProductModal" class="btn btn-link btn-sm" type="button"><i class="fa fa-eye text-secondary" aria-hidden="true"></i></button>
                                     <button wire:click='showDeleteFactDialog({{ $facture->id }})' class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
            @endif
         </div>
        @endif
        </div>
        </div>
        <!-- /.card -->
      </div>
     <div class="card">
         <div class="card-body">
             <a href="{{ url()->previous() }}" class="btn-link"><i class="fas fa-arrow-circle-left"></i> Retour</a>
         </div>
     </div>
    @include('livewire.pharmacie.facturation.abonnes.add-order-abn')
    @include('livewire.pharmacie.facturation.abonnes.show-order-abn')

</div>
