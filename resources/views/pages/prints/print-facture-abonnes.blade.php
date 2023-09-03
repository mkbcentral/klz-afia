<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Impression-Facture</title>
    <link rel="stylesheet" href="css/print.css">
  </head>
  <body>
        <div class="logo">
            <div class="">
                <img class="img-fluid" src="entete.png" alt=""></div>
            </div>
        </div>
    <div class="entete">
        <div class="gauche">
            <div><Span><strong>Noms: </strong>{{ $demande->Nom." ".$demande->Postnom." ".$demande->Prenom }}</Span></div>
            @if ($demande->isInterneted==true)
                <div><Span><strong>Type </strong> {{ $demande->fiche->type }}</Span><br></div>
            @else
                <div><Span><strong>Type </strong> {{ $demande->fiche->type }}</Span><br></div>
            @endif
            <div><Span><strong>Tél: </strong> +243 85 39 51 763</Span></div>
            <div><Span><strong>Admise:</strong>Le {{(new DateTime( $demande->created_at))->format('d/m/Y') }}</Span></div>
        </div>
        <div class="droit">


        </div>
    </div>
    <div class="fact">
        <div><span>Facture N°: {{ $demande->numero }}</span></div>
    </div>
    <div class="contenu">
        @php
            $total_labo=0;
            $total_radio=0;
            $total_cons=0;
            $net_a_payer=0;
            $total_medication=0;
            $total_chirurgie=0;
            $total_oreille=0;
            $total_dentisterie=0;
            $total_autres=0;
            $total_sejours=0;
            $total_echo=0;
            $total_gyneco=0;
            $total_nursing=0;
            $total_prod=0;
        @endphp
         <!-- ELEMENTS DES CONSULTATION  -->
         @if($demande->consultation->price_abonne==0 and $demande->consultation->price_abonne==0)

         @else
            <table>
                <thead>
                    <tr style="background-color: rgb(105, 104, 104)">
                            <th>DESIGNATION</th>
                            <th class="price">PRIX CDF</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="des2">{{ $demande->consultation->name}}</td>
                            <td class="m-price2" style="">{{ ($demande->consultation->price_abonne*$valeur_taux)}} </td>
                        </tr>
                        <tr class="row">
                            <td ></td>
                            <td class="m-price" style=" ">Total: {{ number_format($demande->consultation->price_abonne*$valeur_taux, 0, ',', '') }}</td>
                                {{ $total_cons+=$total_cons+$demande->consultation->price_abonne*$valeur_taux }}
                        </tr>
                </tbody>
            </table>
         @endif

            <!-- ELEMENTS DES EXAMENS LABO  -->
            @if ($demande->examenLabos->isEmpty())
            @else
                <table>
                    <thead>
                        <tr>
                            <th>LABORATOIRE</th>
                            <th class="price"></th>
                            <th class="price"></th>
                            <th class="price"></th>
                        </tr>
                        <tr>
                            <th>DESIGNATION</th>
                            <th class="price">QT</th>
                            <th class="price">PU CDF</th>
                            <th class="price">PT CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ELEMENTS DES EXAMENS LABO -->
                        @foreach ($demande->examenLabos as $labo)
                            <tr>
                                <td class="des2">
                                    @if ($labo->abreviation=="Aucune")
                                        -{{ $labo->name }}
                                    @else
                                            -{{ $labo->abreviation }}
                                    @endif
                                </td>
                                <td class="des">{{$labo->pivot->qty}}</td>
                                <td class="m-price2">
                                    {{ $labo->price_abonne*$valeur_taux }}
                                </td>
                                <td class="m-price2">
                                    {{ $labo->price_abonne*$valeur_taux*$labo->pivot->qty }}
                                </td>
                            </tr>
                            Total: {{$total_labo+= $labo->price_abonne*$valeur_taux*$labo->pivot->qty }} CDF
                        @endforeach
                            <tr class="row">
                                <td class="des" style="border-right: none; border-left: none"></td>
                                <td>
                                <td class="des" style="border-left: none:border-right: none">
                                    Total:
                                </td>
                                <td class="m-price" style="border-left: none">
                                    {{ $total_labo }} Fc
                                </td>
                            </tr>
                    </tbody>
                </table>
            @endif
            <!-- ELEMENTS DES EXAMENS RADIO  -->
            @if ($demande->examenRadios->isEmpty())
            @else
                <table>
                    <thead>
                        <tr>
                            <th>RADIOLOGIE</th>
                            <th class="price"></th>
                            <th class="price"></th>
                            <th class="price"></th>
                        </tr>
                        <tr>
                            <th>DESIGNATION</th>
                            <th class="price">QT</th>
                            <th class="price">PU CDF</th>
                            <th class="price">PT CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demande->examenRadios as $data_radio)
                            <tr>
                                <td class="des2">
                                    -{{ $data_radio->name }}
                                </td>
                                <td class="des">{{$data_radio->pivot->qty}}</td>
                                <td class="m-price">
                                    {{ $data_radio->price_abonne*$valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_radio->price_abonne*$valeur_taux*$data_radio->pivot->qty }}
                                </td>
                            </tr>
                            {{$total_radio+= $data_radio->price_abonne*$valeur_taux*$data_radio->pivot->qty }} CDF
                        @endforeach
                            <tr class="row">
                                <td class="des"  style="border-right: none;" ></td>
                                <td></td>
                                <td> Total: </td>
                                <td class="m-price">
                                    {{ $total_radio }} Fc
                                </td>
                            </tr>
                    </tbody>
                </table>
            @endif
             <!-- ELEMENTS MEDICATIONS  -->
             @if ($demande->products->isEmpty(

             ) and $demande->medications->isEmpty() )

             @else
             <table>
                <thead>
                    <tr>
                        <th>MEDICATION</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->products as $data_mecation)
                        <tr>
                            <td class="des2">
                                -{{  $data_mecation->name }}
                            </td>
                            <td class="des">
                                {{ $data_mecation->pivot->qty }}
                            </td>
                            <td class="m-price">
                                {{ $data_mecation->price }}
                            </td>
                            <td class="m-price">
                                {{ $data_mecation->price*$data_mecation->pivot->qty }}
                            </td>
                        </tr>
                            {{ $total_prod+= $data_mecation->price*$data_mecation->pivot->qty }}
                    @endforeach

                    @foreach ($demande->medications as $medication)
                        <tr>
                            <td class="des2">{{$medication->product->name}}</td>
                            <td class="des">{{$medication->qty}}</td>
                            <td class="m-price">{{($medication->product->price)}}</td>
                            <td class="m-price">{{($medication->product->price*$medication->qty)}}</td>
                        </tr>
                        @php
                            $total_medication+=$medication->product->price * $medication->qty;
                        @endphp
                    @endforeach

                        <tr class="row">
                            <td class="des"  style="border-right: none;" ></td>
                            <td></td>
                            <td>Total: </td>
                            <td class="m-price">
                                {{  number_format($total_medication+$total_prod) }} Fc
                            </td>
                        </tr>
                </tbody>
            </table>

             @endif

            <!-- ELEMENTS ECHO-->
            @if ($demande->echographies->isEmpty())
            @else
                <table>
                    <thead>
                        <tr>
                            <th>ECHOGRAPHIE</th>
                            <th class="price"></th>
                            <th class="price"></th>
                            <th class="price"></th>
                        </tr>
                        <tr>
                            <th>DESIGNATION</th>
                            <th class="price">QT</th>
                            <th class="price">PU CDF</th>
                            <th class="price">PT CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demande->echographies as $echo)
                            <tr>
                                <td class="des2">
                                    -{{ $echo->name }}
                                </td>
                                <td class="des">1</td>
                                <td class="m-price">
                                    {{ $echo->price_abonne*$valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $echo->price_abonne*$valeur_taux*1 }}
                                </td>
                            </tr>
                            {{$total_echo+= $echo->price_abonne*$valeur_taux }} CDF
                        @endforeach
                            <tr class="row">
                                <td class="des"  style="border-right: none;" ></td>
                                <td></td>
                                <td> Total: </td>
                                <td class="m-price">
                                    {{ $total_echo }} Fc
                                </td>
                            </tr>
                    </tbody>
                </table>
            @endif
            <!-- ELEMENTS AUTRE-->
            @if ($demande->autres->isEmpty())
            @else
                <table>
                    <thead>
                        <tr>
                            <th>AUTRES</th>
                            <th class="price"></th>
                            <th class="price"></th>
                            <th class="price"></th>
                        </tr>
                        <tr>
                            <th>DESIGNATION</th>
                            <th class="price">QT</th>
                            <th class="price">PU CDF</th>
                            <th class="price">PT CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demande->autres as $data_autres)
                            <tr>
                                <td class="des2">
                                    -{{ $data_autres->name }}
                                </td>
                                <td class="des">{{ $data_autres->pivot->qty}}</td>
                                <td class="m-price">
                                    {{ $data_autres->price_abonne*$valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_autres->price_abonne*$valeur_taux*$data_autres->pivot->qty }}
                                </td>
                            </tr>
                            {{$total_autres+= $data_autres->price_abonne*$valeur_taux*$data_autres->pivot->qty }} CDF
                        @endforeach
                            <tr class="row">
                                <td class="des"  style="border-right: none;" ></td>
                                <td></td>
                                <td> Total: </td>
                                <td class="m-price">
                                    {{ $total_autres }} Fc
                                </td>
                            </tr>
                    </tbody>
                </table>
            @endif

             <!-- ELEMENTS AUTRE-->
             @if ($demande->nursings->isEmpty())
             @else
                 <table>
                     <thead>
                         <tr>
                             <th>NURSINGS</th>
                             <th class="price"></th>
                             <th class="price"></th>
                             <th class="price"></th>
                         </tr>
                         <tr>
                             <th>DESIGNATION</th>
                             <th class="price">QT</th>
                             <th class="price">PU CDF</th>
                             <th class="price">PT CDF</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($demande->nursings as $nursings)
                            <tr>
                                <td class="des2">
                                    {{$nursings->name }}
                                </td>
                                <td class="des">{{$nursings->qty }}</td>
                                <td class="m-price">
                                {{$nursings->price*$valeur_taux }}
                                </td>
                                <td class="m-price">
                                {{$nursings->price*$valeur_taux*$nursings->qty}}
                                </td>
                            </tr>
                            @php
                                $total_nursing+= $nursings->price*$valeur_taux*$nursings->qty
                             @endphp
                         @endforeach
                             <tr class="row">
                                 <td class="des"  style="border-right: none;" ></td>
                                 <td></td>
                                 <td> Total: </td>
                                 <td class="m-price">
                                     {{ $total_nursing }} Fc
                                 </td>
                             </tr>
                     </tbody>
                 </table>
             @endif
            <!-- ELEMENTS SEJOUR-->
            @if ($demande->sejours->isEmpty())
            @else
                <table>
                    <thead>
                        <tr>
                            <th>SEJOUR</th>
                            <th class="price"></th>
                            <th class="price"></th>
                            <th class="price"></th>
                        </tr>
                        <tr>
                            <th>DESIGNATION</th>
                            <th class="price">QT</th>
                            <th class="price">PU CDF</th>
                            <th class="price">PT CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demande->sejours as $data_sejour)
                            <tr>
                                <td class="des2">
                                    -{{ $data_sejour->name }}
                                </td>
                                <td class="des">{{  $data_sejour->pivot->qty }}</td>
                                <td class="m-price">
                                    @if ($demande->fiche->type=="Abonné")
                                        {{ $data_sejour->price_abonne*$valeur_taux }}
                                    @else
                                        {{ $data_sejour->price_abonne*$valeur_taux }}
                                    @endif
                                </td>
                                <td class="m-price">
                                    @if ($demande->fiche->type=="Abonné")
                                        {{ $data_sejour->price_abonne*$valeur_taux*$data_sejour->pivot->qty }}
                                    @else
                                        {{ $data_sejour->price_abonne*$valeur_taux*$data_sejour->pivot->qty }}
                                    @endif
                                </td>
                            </tr>
                            @if ($demande->fiche->type=="Abonné")
                                {{$total_sejours += $data_sejour->price_abonne*$valeur_taux*$data_sejour->pivot->qty }}CDF
                            @else
                                {{$total_sejours += $data_sejour->price_abonne*$valeur_taux*$data_sejour->pivot->qty }} CDF
                            @endif
                        @endforeach
                            <tr class="row">
                                <td class="des"  style="border-right: none;" ></td>
                                <td></td>
                                <td> Total: </td>
                                <td class="m-price">
                                    {{ $total_sejours }} Fc
                                </td>
                            </tr>
                    </tbody>
                </table>
            @endif
         @php
            $net_a_payer=$total_cons+$total_labo+$total_radio+$total_prod+ $total_medication+$total_chirurgie+$total_autres+$total_oreille+$total_dentisterie+$total_sejours+$total_echo+$total_gyneco+$total_nursing
        @endphp
        <div style="text-align: right;margin-top: 10px;">
            <div style="border: 1px solid black; padding: 10px">
                <span style="font-size: 22px;font-weight: bold">Total à payer: {{$net_a_payer }} Fc</span>
            </div>
        </div>
    </div>
    <div class="consigne">
        <div class="">
            <div>Fait à Lubumbashi, le {{date('d-m-Y') }}</div>
        </div>
        <div style="font-size: 20px;margin-top: 25px;">
            <span style="font-weight: bold;margin-right: 500px">INFO</span>

            <span style="font-weight: bold">A.G</span>
        </div>
    </div>
  </body>
  </body>
</html>
