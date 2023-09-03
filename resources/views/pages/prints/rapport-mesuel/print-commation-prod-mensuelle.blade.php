<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impression liste des prduits</title>
    <style>
        .center {
            text-align: center;
        }
        table, td, th {
            border: 1px solid black;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="entete" style="margin-left: 100px">
        <img  src="entete.png" alt="">
    </div>
    <div style="text-align: center;padding: 15px;font-size: 20px"><span>CONSOMMATION JOURNALIERE PRODUITS </span></div>
    <div>
        <table class="">
            <thead class="">
                <tr>
                    <th>DESIGNATION</th>
                    <th style="text-align: center">QTE SORTIE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    @php
                        $output=$product->getSortieAmbulantDate($product->id,$currentDate)+
                        $product->getSortieDemandeDate($product->id,$currentDate);
                    @endphp
                     @if ($output>0)
                     <tr>
                       <td style="text-align: left">{{$product->name}}</td>

                       <td style="text-align: center">
                           {{
                               $product->getSortieAmbulantDate($product->id,$currentDate)+
                               $product->getSortieDemandeDate($product->id,$currentDate)
                           }}
                       </td>

                   </tr>
                     @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="text-align: right;font-size: 20px;margin-top: 15px">
        <span >Fait à Lubumbashi, le {{(new DateTime($currentDate))->format('d-m-M')}}</span>
    </div>
    <div style="text-align: right;font-size: 20px;margin-top: 10px">
        <span style="font-weight: bold">PHARMACIE</span>
    </div>
</body>
</html>
