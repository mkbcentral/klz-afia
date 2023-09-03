<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impression liste des prduits</title>
    <style>sitution.bac.print
        .center {
            text-align: center;
        }
        table, td, th {
            border: 1px solid black;
            font-size: 12px;
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
    <div style="text-align: center;padding: 15px;font-size: 20px"><span>RAPPORT DE L'INVENTAIRE DU MOIS D'AVRIL SALLE D'OPERATION</span></div>

    @php
        $total_general=0;$pt=0;
    @endphp
    <div>
        <table class="">
            <thead class="">
                <tr>
                    <th style="text-align: center">PRODUIT</th>
                    <th style="text-align: center">QUANTITE</th>
                    <th style="text-align: center">MT</th>
                    <th style="text-align: center">MT TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
                    @foreach ($sortie->products as $product)
                         <tr>
                             <td>{{ $product->name }}</td>
                             <td style="text-align: center">{{ $product->pivot->qty }}</td>
                             <td style="text-align: right">{{ $product->price }}</td>
                             <td style="text-align: right">{{ $product->pivot->qty * $product->price }}</td>
                         </tr>
                         @php
                             $pt+=$product->pivot->qty * $product->price;
                         @endphp
                    @endforeach
                 </tbody>
            </tbody>
            <div style="text-align: right;font-size: 22px;margin-top: 30px;font-family:Consolas, Menlo, Monaco, Lucida Console,
                        Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                        Courier New, monospace, serif">
                <span style="font-weight: bold">Total: </span><span>{{ number_format($pt,1) }} Fc</span>
            </div>
        </table>
    </div>
    <div style="font-size: 20px;margin-top: 10px;margin-top: 10px">
        <span style="font-weight: bold;margin-right: 400px">PHARMACIEN</span>
        <span style="font-weight: bold">CAISSIERE</span>
    </div>
</body>
</html>
