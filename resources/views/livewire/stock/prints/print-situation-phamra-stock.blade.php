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
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
@php
     $total_pv=0;
                    $total_abn=0;
@endphp
<body>
    <div class="entete" style="margin-left: 100px">
        <img  src="entete.png" alt="">
    </div>
    <div style="text-align: center;padding: 15px;font-size: 20px"><span>SITUATION EN STOCK PHARMACIE</span></div>
    <div>
        <table class="">
            <thead class="">
                <tr style="padding: 5px">
                    <th style="text-align: left">DESIGNATION</th>
                    <th style="text-align: center">QT EN STOCK</th>
                    <th style="text-align: right">P.U CDF</th>
                    <th style="text-align: right">PRIX TOTAL CDF</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    @php
                        $stock_dispo=($product->quantity+
                                        $product->getEntrees($product->id)-
                                        $product->getSortieDemande($product->id)-
                                        $product->getSortieAmbulant($product->id)) ;
                    @endphp
                     @if ($stock_dispo>0)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td style="text-align: center">
                                {{ $stock_dispo }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format($product->price,0,',', ' ') }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format($product->price*$stock_dispo,0,',', ' ') }}
                            </td>
                            @php
                                $total_pv+=$product->price*$stock_dispo;
                                $total_abn+=$product->price_abonne*$stock_dispo;
                            @endphp
                        </tr>

                    @endif
                @endforeach
                <tr class="bg-dark" style="background: black; color: white">
                    <td style="font-size: 18px" class="text-center text-bold">TOTAL CDF</td>
                    <td></td>
                    <td style="font-size: 16px" class="text-right text-bold"></td>
                    <td style="font-size: 16px" class="text-right text-bold">{{number_format($total_pv,0,',', ' ')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
