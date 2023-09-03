<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header text-center">
            <h1 class="card-title  text-danger text-bold">FICHE DE SURVEILLANCE</h1>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div><span class="text-bold">N° Fiche:</span> {{$facture_data->fiche->numero}}</div>
                        <div><span class="text-bold">Noms:</span> {{$facture_data->fiche->patientPrive->Nom.' '.$facture_data->fiche->patientPrive->Postnom.' '.$facture_data->fiche->patientPrive->Prenom}}</div>
                        <div><span class="text-bold">Type:</span> <span class="text-danger">{{$facture_data->fiche->type}}</span></div>
                    </div>
                    <div>

                    </div>
                    <div>
                        <div><span class="text-bold">Emise le:</span> {{(new DateTime($facture_data->created_at))->format('d/m/Y')}}</div>
                        <div><span class="text-bold">Sexe:</span> {{$facture_data->fiche->patientPrive->Sexe}}</div>
                        <div><span class="text-bold">Age:</span> <span class="">{{$facture_data->fiche->patientPrive->getAge($facture_data->fiche->patientPrive->id)}} ans</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                               <span> Médication et paracliniques</span>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        Médication
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Médication</th>
                                                    <th class="text-center">Q.T Prescrite</th>
                                                    <th class="text-center">Q.T Administrée</th>
                                                    <th class="text-center">Reste</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($facture_data->products as $key => $product)
                                                    <tr>
                                                        <td>{{$product->name}}</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center">0</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><button wire:click='show({{$medication->product->id}})' data-toggle="modal" data-target="#addSurProductsModal" class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></td>


                                                    </tr>
                                                @endforeach
                                                @foreach ($facture_data->medications as $medication)
                                                    <tr>
                                                        <td>{{$medication->product->name}}</td>
                                                        <td class="text-center">{{$medication->qty}}</td>
                                                        <td class="text-center">{{$medication->product->getQtSurvTotal($medication->product->id)}}</td>
                                                        <td class="text-center">{{$medication->qty-$medication->product->getQtSurvTotal($medication->product->id)}}</td>
                                                        <td>
                                                            @if ($medication->qty==$medication->product->getQtSurvTotal($medication->product->id))
                                                                    <span class="text-danger">Finis !</span>
                                                            @else
                                                                <button wire:click='show({{$medication->product->id}})'
                                                                    data-toggle="modal" data-target="#addSurProductsModal"
                                                                    class="btn btn-primary btn-sm" type="button">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                        </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($facture_data->examenLabos->isEmpty())
                            @else
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        Examens lde labo
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Examen</th>
                                                    <th class="text-center">Résultat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($facture_data->examenLabos as $labo)
                                                    <tr>
                                                        @if ($labo->abreviation=="Aucune")
                                                            <td>{{$labo->name}}</td>
                                                        @else
                                                            <td>{{$labo->abreviation}}</td>
                                                        @endif
                                                        <td class="text-center">{{$labo->getResult($labo->id,$facture_data->id)}}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($facture_data->echographies->isEmpty())
                            @else
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        ECHO
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Examen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($facture_data->echographies as $echo)
                                                    <tr>
                                                        <td>{{$echo->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if ($facture_data->examenRadios->isEmpty())
                            @else
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        RX
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Examen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($facture_data->examenRadios as $radio)
                                                    <tr>
                                                        <td>{{$radio->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($facture_data->examenRadios->isEmpty())
                            @else
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        ACTES ET AUTRE
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-light table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($facture_data->autres as $autre)
                                                    <tr>
                                                        <td>{{$autre->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                               <span> Suivi journaliser</span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div class="form-group">
                                            <input id="my-input" wire:keydown.enter='getByDay' wire:model.defer='dateToSearch' class="form-control" type="date" name="">
                                        </div>
                                    </div>
                                    <div>

                                    </div>
                                </div>
                                <div>
                                    <table class="table table-light table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Medicament</th>
                                                <th>Qty</th>
                                                <th>Heure</th>
                                                <th>User</th>
                                                <th>Actions</th>*
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($infos as $info)
                                                <tr>
                                                    <td>{{$info->product->name}}</td>
                                                    <td>{{$info->qty}}</td>
                                                    <td>{{$info->time_add}}</td>
                                                    <td>{{$info->user->name}}</td>
                                                    <td><button wire:click='delete({{$info->id}})' class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
      </div>

     <div class="card">
         <div class="card-body">
             <a href="{{ url()->previous() }}" class="btn-link"><i class="fas fa-arrow-circle-left"></i> Retour</a>
         </div>
     </div>
     @include('livewire.hospitalisation.modals.add-prod-surveillance2')
</div>

