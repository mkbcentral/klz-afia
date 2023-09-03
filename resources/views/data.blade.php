<!DOCTYPE html>
@php
    $total = 0;
    $total_special = 0;
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
            <img class="img-fluid" src="entete.png" alt="">
        </div>
    </div>
    </div>
    <div class="fact">
        <div><span> SUTUATION DES SORTIE</span></div>
    </div>
    <div>
        <div><span>Mois: {{ $month }}</span></div>
        <div><span>Mois: {{ $year }}</span></div>
    </div>
    <div class="contenu">
        <table style="margin-top: 10px; border: 1px solide black">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>QT</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($pproducts as $product)
                @if ($product->getSortieDemandeMontnAndYear($product->id, $month, $year)+
                $product->getSortieAmbulantMonthAndYear($product->id, $month, $year)+
                $product->getSortieDemandeSpecMontnAndYear($product->id, $month, $year)
                     > 0)
                <tr >
                    <td class="des2" style="text-align: left">{{ $product->name }}</td>
                    <td class="des2">
                        {{
                            $product->getSortieDemandeMontnAndYear($product->id, $month, $year)+
                            $product->getSortieAmbulantMonthAndYear($product->id, $month, $year)+
                            $product->getSortieDemandeSpecMontnAndYear($product->id, $month, $year)
                        }}
                    </td>
                </tr>
                @endif

                @endforeach
            </tbody>
        </table>
        <div class="consigne">
            <div class="">
                <div>Fait à Lubumbashi, le {{ date('d-m-Y') }}</div>
            </div>
        </div>
    </div>


</body>

</html>
