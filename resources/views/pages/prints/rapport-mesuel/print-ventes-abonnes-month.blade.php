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
    <div style="text-align: center;padding: 15px;font-size: 22px"><span>RAPPORT DES VENTES MENSUELLES DE LA PHARMACIE DES ABONNES <span style="font-weight: bold"> {{$societe}}</span></span></div>
    <div style="padding: 5px;font-size: 19px">
        <div><span><span style="font-weight: bold">Service</span> : PHARMACIE</span></div>
        <div>
            <span><span style="font-weight: bold">Mois: </span> <span style="text-transform: uppercase;">{{ strftime('%B', mktime(0, 0, 0, $mois)) }}  </span></span>
        </div>
    </div>
    @php
        $total=0;;
    @endphp
    <div>
        <table class="" style="margin-left: 10px">
            <thead class="">
                <tr>
                    <th style="text-align: left">DATE</th>
                    <th style="text-align: left"> NUMERO</th>
                    <th style="text-align: left">NOM PATIENT</th>
                    <th style="text-align: right">MONTANT CDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandes as $key=>$vente)
                @if (number_format($vente->getTotalPharma($vente->id)!=0))

                <tr>
                    <td>{{(new DateTime($vente->created_at))->format('d/m/Y')}}</td>
                    <td style="text-align: left">{{$vente->numero}}</td>
                    <td style="text-align: left">{{$vente->Nom.' '.$vente->Postnom.' '.$vente->Prenom}}</td>
                    <td style="text-align: right">{{number_format($vente->getTotalPharma($vente->id),0, ',', ' ') }}</td>
                </tr>
            @php
                $total+=$vente->getTotalPharma($vente->id);
            @endphp

                @endif

            @endforeach
            </tbody>
            <div style="text-align: right;padding: 5px;font-size: 25px">
                <span style="font-weight: bold">Total: </span><span>{{number_format($total,0, ',', ' ') }} Fc</span>
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
