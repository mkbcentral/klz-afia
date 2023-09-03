
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showEncodageDetailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>DETAIL DE LA DEMANDE</strong></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($demande ==null)

            @else
                <div class="card">
                    <div class="card-header">
                        <h2 style="font-size: 20px"><div class="text-center"><span class="text-bold">N° FACTURE: </span ><span class="text-danger">{{$demande->numero}}</span></div></h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div><span class="text-bold">N° Fiche:</span> {{$demande->fiche->numero}}</div>
                                <div><span class="text-bold">Noms:</span> {{$demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom}}</div>
                                <div><span class="text-bold">Type:</span> <span class="text-danger">{{$demande->fiche->type}}</span></div>

                            </div>
                            <div>
                                @if (Auth::user()->role=='infirmerie' or Auth::user()->role=='Admin')
                                    @if ($demande->signeVito != null)
                                        <div><span class="text-bold">Poids:</span> {{$demande->signeVito->poids }}</div>
                                        <div><span class="text-bold">Tem °:</span> {{$demande->signeVito->temperature}}</div>
                                        <div><span class="text-bold">Taille:</span> {{$demande->signeVito->taille}}</div>
                                        <div><span class="text-bold">Tension</span> {{$demande->signeVito->taille}}</div>
                                    @endif
                                @endif
                            </div>
                            <div>
                                <div><span class="text-bold">Emise le:</span> {{(new DateTime($demande->created_at))->format('d/m/Y')}}</div>
                                <div><span class="text-bold">Sexe:</span> {{$demande->Sexe}}</div>
                                <div><span class="text-bold">Age:</span> <span class="">{{$demande->fiche->patientPrive->getAge($demande->fiche->patientPrive->id)}} ans</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="text-center text-primary" style="font-size: 22px">DETAIL FACTURES</div>
                        </div>
                        <div class="card-body">
                            @php
                                $total_general=0;$total_cons=0;$total_labo=0;$total_radio=0;
                                $total_echo=0;$total_sejour=0;$total_product=0;$total_autre=0;
                                $total_nursing=0;
                            @endphp
                           <table class="table table-sm">
                               <thead class="thead-dark">
                                   <tr>
                                       <th>DESINGATION</th>
                                       <th class="text-center">NOMBRE</th>
                                       <th class="text-center">ACTIONS</th>
                                   </tr>
                               </thead>
                               <tbody>
                                    <div>
                                        @if ($demande->is_valided==true)
                                            <tr class="text-success">
                                                @if ($consultation_id_edit!=$demande->id)
                                                    <td>{{$demande->consultation->name}}</td>
                                                @else
                                                   <td>
                                                    <div class="form-group">
                                                        <select id="my-select" class="form-control" wire:model.defer="cons_id">
                                                            <option>Choisir le type</option>
                                                            @foreach ($consultation as $cons)
                                                                <option value="{{ $cons->id }}">{{ $cons->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                   </td>
                                                @endif

                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <button wire:click='cancelPaiedCons({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="far fa-window-close text-danger"></i>
                                                    </button>
                                                    <button wire:click='getConsid({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="fas fa-pen text-info"></i>
                                                    </button>
                                                    <button wire:click='changeCons({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                @if ($consultation_id_edit!=$demande->id)
                                                    <td>{{$demande->consultation->name}}</td>
                                                @else
                                                   <td>
                                                    <div class="form-group">
                                                        <select class="form-control" wire:model.defer='cons_id'>
                                                            <option>Choisir le type</option>
                                                            @foreach ($consultations as $cons)
                                                                <option value="{{ $cons->id }}">{{ $cons->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                   </td>
                                                @endif
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <button wire:click='makePaiedCons({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="fas fa-check text-success"></i>
                                                    </button>
                                                    <button wire:click='getConsid({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="fas fa-pen text-info"></i>
                                                    </button>
                                                    <button wire:click='changeCons({{ $demande->id }})' class="btn btn-light btn-sm" type="button">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->examenLabos->isEmpty())

                                        @else
                                                <tr class="bg-dark">
                                                    <td>LABORATOIRE</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach ($demande->examenLabos as $labo)
                                                    <tr>
                                                        @if ($labo->abreviation=="Aucune")
                                                            <td>{{$labo->name}}</td>
                                                        @else
                                                            <td>{{$labo->abreviation}}</td>
                                                        @endif
                                                        @if ($itemLaboId != $labo->pivot->id)
                                                            <td class="text-center">{{$labo->pivot->qty}}</td>
                                                        @else
                                                           <td>
                                                                <div class="form-group">
                                                                    <input  class="form-control"
                                                                     type="text" wire:model.defer='newQtLabo'
                                                                     wire:keydown.enter='changeQtLabo({{$labo->pivot->id}},{{$demande->id }})'>
                                                                </div>
                                                           </td>
                                                        @endif
                                                        <td class="text-center">
                                                            <button wire:click='deleteLabo({{$labo->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                                <i class="far fa-window-close text-danger"></i>
                                                            </button>
                                                            <button wire:click='getItemIdLabo({{ $labo->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                                <i class="fas fa-pen text-info"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        @endif
                                    </div>

                                    <tr class="bg-dark">
                                        <td>MEDICATION</td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    @foreach ($demande->products as $product)
                                        <tr>
                                            <td>{{$product->name}}</td>
                                            @if ($itemProduct != $product->pivot->id)
                                                <td class="text-center">{{$product->pivot->qty}}</td>
                                            @else
                                                <td>
                                                    <div class="form-group">
                                                        <input  class="form-control"
                                                            type="text" wire:model.defer='newQtProduct'
                                                            wire:keydown.enter='changeQtProduc({{$product->pivot->id}},{{$demande->id}})'>
                                                    </div>
                                                </td>
                                            @endif

                                            <td class="text-center">
                                                <button wire:click='deleteProduct({{$product->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                    <i class="far fa-window-close text-danger"></i>
                                                </button>
                                                <button wire:click='getItemIdProduct({{ $product->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                    <i class="fas fa-pen text-info"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    @endforeach
                                    @foreach ($demande->medications as $medication)
                                        <tr>
                                            <td>{{$medication->product->name}}</td>
                                            @if ($itemMedicationPv != $medication->id)
                                                <td class="text-center">{{$medication->qty}}</td>
                                            @else
                                                <td>
                                                    <div class="form-group">
                                                        <input  class="form-control"
                                                            type="text" wire:model.defer='nweQtMedication'
                                                            wire:keydown.enter='changeQtMedication({{$medication->id}},{{$demande->id}})'>
                                                    </div>
                                                </td>
                                            @endif


                                            <td class="text-center">
                                                <button wire:click='deleteMedicatio({{$medication->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                    <i class="far fa-window-close text-danger"></i>
                                                </button>
                                                <button wire:click='getItemMedication({{ $medication->id }})' class="btn btn-light btn-sm" type="button">
                                                    <i class="fas fa-pen text-info"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <div>
                                        @if ($demande->examenRadios->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>RADIOLOGIE</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($demande->examenRadios as $radio)
                                                <tr>
                                                    <td>{{$radio->name}}</td>

                                                    @if ($itemRadioId != $radio->pivot->id)
                                                        <td class="text-center">{{$radio->pivot->qty}}</td>
                                                    @else
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                     type="text" wire:model.defer='newQtRadio'
                                                                     wire:keydown.enter='changeQtRadio({{$radio->pivot->id}},{{$demande->id }})'>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <button wire:click='deleteRadio({{$radio->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdRadio({{ $radio->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->echographies->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>ECHOGRAPHIE</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($demande->echographies as $echo)
                                                <tr>
                                                    <td>{{$echo->name}}</td>
                                                    @if ($itemIdEcho != $echo->pivot->id)
                                                        <td class="text-center">{{$echo->pivot->qty}}</td>
                                                    @else
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                    type="text" wire:model.defer='newQtEcho'
                                                                    wire:keydown.enter='changeQtEcho({{$echo->pivot->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <button wire:click='deleteEcho({{$echo->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdEcho({{ $echo->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->autres->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>AUTRES</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($demande->autres as $autre)
                                                <tr>
                                                    <td>{{$autre->name}}</td>
                                                    @if ($itemIdAutres != $autre->pivot->id)
                                                        <td class="text-center">{{$autre->pivot->qty}}</td>
                                                    @else
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                    type="text" wire:model.defer='newQtEcho'
                                                                    wire:keydown.enter='changeQtAutres({{$autre->pivot->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <button wire:click='deleteAutres({{$autre->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdAutres({{ $autre->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </div>



                                    <div>
                                        @if ($demande->nursings->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>NURSING & AUTRES</td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            @foreach ($demande->nursings as $nursing)
                                                <tr>
                                                    <td>{{$nursing->name}}</td>
                                                    @if ($itemIdNursing != $nursing->id)
                                                        <td class="text-center">{{$nursing->qty}}</td>
                                                    @else
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                    type="text" wire:model.defer='newQtNursing'
                                                                    wire:keydown.enter='changeQtNursing({{$nursing->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                    @endif

                                                    <td class="text-center">
                                                        <button wire:click='deleteNursing({{$nursing->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdNursing({{ $nursing->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->sejours->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>SEJOUR</td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                            @foreach ($demande->sejours as $sejour)
                                                <tr>

                                                    @if ($itemIdSejour != $sejour->pivot->id)
                                                        <td>{{$sejour->name}}</td>
                                                        <td class="text-center">{{$sejour->pivot->qty}}</td>
                                                    @else
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" wire:model.defer="sejour_id">
                                                                <option value="{{$sejour->pivot->id}}">{{ $sejour->name }}</option>
                                                                @foreach ($sejours as $sej)
                                                                    <option value="{{ $sej->id }}">{{ $sej->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                     type="text" wire:model.defer='newQtsejour'
                                                                     wire:keydown.enter='changeQtSejour({{$sejour->pivot->id}},{{$demande->id }})'>
                                                            </div>
                                                        </td>
                                                    @endif

                                                    <td class="text-center">
                                                        <button wire:click='deleteSejour({{$sejour->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdSejour({{ $sejour->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </div>
                               </tbody>
                           </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
      </div>
    </div>
</div
