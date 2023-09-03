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
        <div><span> SUTUATION DES RECETTES JOURNALIERES</span></div>

    </div>
     <div class="contenu">
        <div><span>Date: {{ $datePrinter }}</span></div>
        <table style="margin-top: 10px">
            <thead>
                <tr>
                   <th>DATE</th>
                      <th>N° FACTURE</th>
                    <th>NOMS PATIENTS</th>
                    <th>MT PAR FACTURE</th>
                </tr>
            </thead>
            <tbody>

                    @foreach ($speciales as $speciale)
                        <tr>
                            <td class="des2">
                            {{(new DateTime($speciale->created_at))->format('d/m/Y') }}
                            </td>
                            <td class="des2">
                            {{ $speciale->numero }}/<span>{{ $speciale->is_inteneted==true?"Hospitalisé":"Ambulant" }}</span>
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

                <tr class="row">
                    <td></td>
                    <td></td>
                    <td> Total CDF: </td>
                    <td class="m-price">
                       {{ number_format($total_special,0,',', ' ') }}
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
        <div class="consigne">
            <div class="">
                <div>Fait à Lubumbashi, le {{ $datePrinter }}</div>
            </div>
            <div style="font-size: 20px;margin-top: 25px;">
                <span style="font-weight: bold;margin-right: 350px">PERCEPTION</span>
                <span style="font-weight: bold;margin-right: 0px">CAISSE PRINCIPALE</span>
            </div>

        </div>
    </div>


  </body>
</html>
