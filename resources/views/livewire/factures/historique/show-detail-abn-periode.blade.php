<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showdDetailHistorikAbonnePEriodeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>DETAIL DE LA FACTURE</strong></h5>
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
                                <div><span class="text-bold">Societé:</span> <span class="text-danger">{{$demande->fiche->patientAbonne->abonnement->name}}</span></div>

                            </div>
                            <div>

                            </div>
                            <div>
                                <div><span class="text-bold">Emise le:</span> {{(new DateTime($demande->created_at))->format('d/m/Y')}}</div>
                                <div><span class="text-bold">Sexe:</span> {{$demande->Sexe}}</div>
                                <div><span class="text-bold">Age:</span> <span class="">{{$demande->fiche->patientAbonne->getAge($demande->fiche->patientAbonne->id)}} ans</span></div>
                                <div><span class="text-bold">Est:</span> <span class="text-danger">{{$demande->fiche->patientAbonne->Type}}</span></div>
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
                                $total_nursing=0;$total_medication=0;
                            @endphp
                           <table class="table table-sm">
                               <thead class="thead-dark">
                                   <tr>
                                       <th>DESINGATION</th>
                                       <th class="text-center">NOMBRE</th>
                                       <th class="text-right">P.U (CDF)</th>
                                       <th class="text-right">P.T (CDF)</th>
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
                                                <td class="text-right">{{number_format($demande->consultation->price_abonne*$valeur_taux,1)}}</td>
                                                <td class="text-right">{{number_format($demande->consultation->price_abonne*1*$valeur_taux,1)}}</td>
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
                                                <td class="text-right">{{number_format($demande->consultation->price_abonne*$valeur_taux,1)}}</td>
                                                <td class="text-right">{{number_format($demande->consultation->price_abonne*1*$valeur_taux,1)}}</td>
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

                                            @php
                                                $total_cons=+$demande->consultation->price_abonne*1*$valeur_taux;
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($demande->consultation->price_abonne*1*$valeur_taux,1)}}</td>
                                            </tr>
                                    </div>

                                    <div>
                                        @if ($demande->examenLabos->isEmpty())

                                        @else
                                                <tr class="bg-dark">
                                                    <td>LABORATOIRE</td>
                                                    <td></td>
                                                    <td></td>
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

                                                        <td class="text-right">{{number_format($labo->price_abonne*$valeur_taux,1)}}</td>
                                                        <td class="text-right">{{number_format($labo->price_abonne * $labo->pivot->qty*$valeur_taux,1)}}</td>
                                                        <td class="text-center">
                                                            <button wire:click='deleteLabo({{$labo->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                                <i class="far fa-window-close text-danger"></i>
                                                            </button>
                                                            <button wire:click='getItemIdLabo({{ $labo->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                                <i class="fas fa-pen text-info"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $total_labo+=$labo->price_abonne * $labo->pivot->qty*$valeur_taux;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_labo,1)}}</td>
                                                </tr>
                                        @endif
                                    </div>

                                    <div>

                                            <tr class="bg-dark">
                                                <td>MEDICATION</td>
                                                <td></td>
                                                <td></td>
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
                                                    <td class="text-right">{{number_format($product->price,1)}}</td>
                                                    <td class="text-right">{{number_format($product->price * $product->pivot->qty,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteProduct({{$product->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdProduct({{ $product->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_product+=$product->price * $product->pivot->qty;
                                                @endphp
                                            @endforeach


                                            @foreach ($demande->medications as $medication)
                                                <tr>
                                                    <td>{{$medication->product->name}}</td>
                                                    @if ($itemMedication != $medication->id)
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

                                                    <td class="text-right">{{number_format($medication->product->price,1)}}</td>
                                                    <td class="text-right">{{number_format($medication->product->price*$medication->qty)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteMedicatio({{$medication->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemMedication({{ $medication->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_medication+=$medication->product->price * $medication->qty;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_product+ $total_medication,1)}}</td>
                                            </tr>


                                    </div>

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
                                                    <td class="text-right">{{number_format($radio->price_abonne*$valeur_taux,1)}}</td>
                                                    <td class="text-right">{{number_format($radio->price_abonne * $radio->pivot->qty*$valeur_taux,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteRadio({{$radio->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdRadio({{ $radio->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_radio+=$radio->price_abonne * $radio->pivot->qty*$valeur_taux;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>

                                                </td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_radio,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->echographies->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>ECHOGRAPHIE</td>
                                                <td></td>
                                                <td></td>
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

                                                    <td class="text-right">{{number_format($echo->price_abonne*$valeur_taux,1)}}</td>
                                                    <td class="text-right">{{number_format($echo->price_abonne * $echo->pivot->qty*$valeur_taux,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteEcho({{$echo->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdEcho({{ $echo->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_echo+=$echo->price_abonne * $echo->pivot->qty*$valeur_taux;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_echo,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->autres->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>AUTRES DETAILS</td>
                                                <td></td>
                                                <td></td>
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
                                                                    type="text" wire:model.defer='newQtAutres'
                                                                    wire:keydown.enter='changeQtAutres({{$autre->pivot->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="text-right">{{number_format($autre->price_abonne*$valeur_taux,1)}}</td>
                                                    <td class="text-right">{{number_format($autre->price_abonne * $autre->pivot->qty*$valeur_taux,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteAutres({{$autre->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdAutres({{ $autre->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_autre+=$autre->price_abonne * $autre->pivot->qty*$valeur_taux;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_autre,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->nursings->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>NURSING & AUTRES</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach ($demande->nursings as $nursing)
                                                <tr>

                                                    @if ($itemIdNursing != $nursing->id)
                                                        <td>{{$nursing->name}}</td>
                                                        <td class="text-center">{{$nursing->qty}}</td>
                                                    @else
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                    type="text" wire:model.defer='newNameNursing'
                                                                    wire:keydown.enter='changeQtNursing({{$nursing->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input  class="form-control"
                                                                    type="text" wire:model.defer='newQtNursing'
                                                                    wire:keydown.enter='changeQtNursing({{$nursing->id}},{{$demande->id}})'>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="text-right">{{number_format($nursing->price*$valeur_taux,1)}}</td>
                                                    <td class="text-right">{{number_format($nursing->price * $nursing->qty*$valeur_taux,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteNursing({{$nursing->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdNursing({{ $nursing->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_nursing+=$nursing->price * $nursing->qty*$valeur_taux;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_nursing,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($demande->sejours->isEmpty())

                                        @else
                                            <tr class="bg-dark">
                                                <td>SEJOUR</td>
                                                <td></td>
                                                <td></td>
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
                                                    <td class="text-right">{{number_format($sejour->price_abonne*$valeur_taux,1)}}</td>
                                                    <td class="text-right">{{number_format($sejour->price_abonne * $sejour->pivot->qty*$valeur_taux,1)}}</td>
                                                    <td class="text-center">
                                                        <button wire:click='deleteSejour({{$sejour->pivot->id}},{{$demande->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="far fa-window-close text-danger"></i>
                                                        </button>
                                                        <button wire:click='getItemIdSejour({{ $sejour->pivot->id }})' class="btn btn-light btn-sm" type="button">
                                                            <i class="fas fa-pen text-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_sejour+=$sejour->price_abonne * $sejour->pivot->qty*$valeur_taux;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_sejour,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>
                               </tbody>
                           </table>
                        </div>
                        <div class="p-2">
                           @if ($demande->is_valided==false)
                                <button wire:click='marquerFini({{$demande->id}})' class="btn btn-primary btn-sm" type="button">Marquer fini</button>
                           @else
                                <button wire:click='annulerMarquerFini({{$demande->id}})' class="btn btn-danger btn-sm" type="button">Annuler fini</button>
                           @endif
                        </div>
                    </div>
                    @php
                        $total_general+=$total_cons+$total_labo+$total_radio+$total_echo+$total_sejour+
                                        $total_product+$total_autre+$total_nursing+$total_medication;
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <div></div>
                                <div></div>
                                <div>
                                    <div class="d-flex justify-content-between p-2 border border-dark text-bold text-primary" style="font-size: 18px">
                                        <div class="mr-4 ">Total général:</div>
                                        <div>             </div>
                                        <div class="ml-4">{{number_format($total_general,1)}} Fc</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
      </div>
    </div>
</div>
