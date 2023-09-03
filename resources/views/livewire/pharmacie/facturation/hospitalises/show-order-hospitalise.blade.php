<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showdHospitaliseFacturerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                            </div>
                            <div>

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
                                $total_general=0;
                                $total_product=0;
                                $total_medication=0;

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
                                        @if ($demande->products->isEmpty() and $demande->medications->isEmpty())

                                        @else
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
                                                <td class="border border-dark text-right p-2 text-danger text-bold">Total: {{number_format($total_product+$total_medication,1)}}</td>
                                            </tr>
                                        @endif
                                    </div>
                               </tbody>
                           </table>
                        </div>
                    </div>
                    @php
                        $total_general+=$total_product;
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
