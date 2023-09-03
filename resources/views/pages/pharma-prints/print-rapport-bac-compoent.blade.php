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
            font-size: 18px;
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
    <div style="text-align: center;padding: 15px;font-size: 22px"><span>SITUATION DES SORTIE BAC</span></div>
    <div style="padding: 5px;font-size: 19px;">
        <span><span style="font-weight: bold;text-align: left">Date</span> :{{ (new DateTime($d))->format('d/m/Y') }} </span><br>
    </div>
    @php
        $total_general=0;$pt=0;
    @endphp
    <div>
        <table class="">
            <thead class="">
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: center">NOMS PATIENTS</th>
                    <th style="text-align: center">PRODUITS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($situations as $key => $situation)
                    <tr style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                    Courier New, monospsituationace, serif">
                        <td style="text-align: center">{{ $key+1 }}</td>
                        <td>{{ $situation->name }}</td>
                        <td style="padding: 5px">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="text-align: left">DESIGNATION</th>
                                        <th style="text-align: center;width: 50px">Q.T</th>
                                        <th style="text-align: right;width: 80px">P.U</th>
                                        <th style="text-align: right;width: 100px">P.T</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($situation->products as $product)
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
                            </table>
                        </td>
                    </tr>
            @endforeach
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
