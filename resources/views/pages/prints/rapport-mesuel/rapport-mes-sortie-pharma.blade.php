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
    <div class="entete" style="margin-left: 250px">
        <img  src="entete.png" alt="">
    </div>
    <div style="text-align: center;padding: 15px;font-size: 22px"><span>RAPPORT DES SORTIES DE LA PHARMACIE DU MOIS NOVEMBRE 2021</span></div>
    <div style="padding: 5px;font-size: 19px">
        <span><span style="font-weight: bold">Pour le service</span> : {{ $name_service }}</span>
    </div>
    @php
        $total=0;;
    @endphp
    <div>
        <table class="" style="margin-left: 10px">
            <thead class="">
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: right">DATE</th>
                    <th>CODE</th>
                    <th>QUANTITE</th>
                    <th style="text-align: right">MONTANT CDF</th>
                    <th class="text-right">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rapports as $key=>$rapport)
                <tr>
                    <td style="text-align: center">{{$key+1}}</td>
                    <td style="text-align: right">{{ (new DateTime($rapport->created_at))->format('d/m/Y') }}</td>
                    <td style="text-align: center">{{ $rapport->code }}</td>
                    <td style="text-align: center">{{ $rapport->products()->count() }}</td>
                    <td style="text-align: right">{{number_format($rapport->getToatl($rapport->id), 2, '.', ' ')  }}</td>
                    <td style="text-align: center">{{ $name_service  }}</td>
                </tr>
                @php
                    $total+=$rapport->getToatl($rapport->id);
                @endphp
            @endforeach
            </tbody>
            <div style="text-align: right;padding: 5px;font-size: 25px">
                <span style="font-weight: bold">Total: </span><span>{{number_format($total, 2, '.', ' ') }} Fc</span>
            </div>
        </table>
    </div>
    <div style="text-align: right;font-size: 20px;margin-top: 15px">
        <span >Fait à Lubumbashi, le {{date('d/m/Y')}}</span>
    </div>
    <div style="text-align: right;font-size: 20px;margin-top: 10px">
        <span style="font-weight: bold">PHARMACIE</span>
    </div>
</body>
</html>
