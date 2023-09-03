<!DOCTYPE html>
    @php
        $total=0;
         $total_special=0;
    @endphp
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
    <div class="fact">
        <div><span> {{$entete}}</span></div>
    </div>
     <div class="contenu">
        <table>
            <thead>
                <tr>
                   <th>DATE</th>
                      <th>N° FACTURE</th>
                    <th>NOMS PATIENTS</th>
                    <th>MT PAR FACTURE</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($demandes as $demande)
                    <tr>
                        <td class="des2">
                         {{(new DateTime($demande->created_at))->format('d/m/Y') }}
                         </td>
                        <td class="des2">
                           {{ $demande->numero }}
                         </td>
                        <td class="des2">
                            @if ($demande->isInterneted==true)
                            {{ $demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom }} /Hospitalisé
                            @else
                            {{ $demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom }}
                            @endif
                        </td>
                        <td class="m-price">
                            {{ number_format($demande->getTotalAbonne($demande->id),0,',', ' ') }}
                        </td>
                    </tr>

                    @php
                        $total+=$demande->getTotalAbonne($demande->id);
                    @endphp
                @endforeach
                @if ($speciales==null)

                @else
                    @foreach ($speciales as $speciale)
                        <tr>
                            <td class="des2">
                            {{(new DateTime($speciale->created_at))->format('d/m/Y') }}
                            </td>
                            <td class="des2">
                            {{ $speciale->numero }}
                            </td>
                            <td class="des2">
                                {{ $speciale->name }}
                            </td>
                            <td class="m-price">
                                {{ number_format($speciale->getTotal($speciale->id),0,',', ' ') }}
                            </td>
                        </tr>

                        @php
                            $total_special+=$speciale->getTotal($speciale->id);
                        @endphp
                    @endforeach
                @endif

                <tr class="row">
                    <td></td>
                    <td></td>
                    <td> Total CDF: </td>
                    <td class="m-price">
                       {{ number_format($total+$total_special,0,',', ' ') }}
                    </td>
                </tr>
                <tr class="row">
                    <td></td>
                    <td  ></td>
                    <td> Total USD: </td>
                    <td class="m-price">

                        {{ number_format(($total + $total_special) / $valeur_taux,0,',', ' ')}}
                    </td>

                </tr>
            </tbody>
        </table>
        <h5><strong>NB: </strong>{{$mtLetter}}</h5>
        <div class="consigne">
            <div class="">
                <div>Fait à Lubumbashi, le {{ $datePrinter }}</div>
            </div>
            <div style="font-size: 20px;margin-top: 10px;">
                <span style="font-weight: bold;margin-right: 450px">COM & INFO</span>
                <span style="font-weight: bold;margin-right: 0px">A.G</span>
            </div>

        </div>
        <div class="consigne">
            <div style="font-size: 16px">
                <span style="font-weight: bold;margin-right: 380px">John KABWIT</span>
                <span style="font-weight: bold">Dady KALMERY</span>
            </div>
        </div>
    </div>


  </body>
</html>
