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
            padding: 5px;
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
    <div style="text-align: center;padding: 15px;font-size: 22px"><span>RAPPORT FINANCIER MENSUEL DE LA PHARMACIE</span></div>
    <div style="padding: 5px;font-size: 19px">
        <span><span style="font-weight: bold">Pour le service</span> : PHARMACIE</span>
    </div>
    @php
        $total=0;;
    @endphp
    <div>
        <table class="" style="margin-left: 10px">
            <thead class="">
                <tr>
                    <th style="text-align: left">MOIS</th>
                    <th style="text-align: center">TYPE</th>
                    <th style="text-align: right">MONTANT CDF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</td>
                    <td style="text-align: center">PRIVES HOSPITALISES</td>
                    <td style="text-align: right">{{number_format($prive,0, ',', ' ')}}</td>
                </tr>
                <tr>
                    <td>{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</td>
                    <td style="text-align: center">AMBULANTS</td>
                    <td style="text-align: right">{{number_format($ambulant,0, ',', ' ')}}</td>
                </tr>
                <tr>
                    <td>{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</td>
                    <td style="text-align: center">ABONNES</td>
                    <td style="text-align: right">{{number_format($abonne,0, ',', ' ')}}</td>
                </tr>
                <tr>
                    <td>{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</td>
                    <td style="text-align: center">MATERNITE ET AUTRES</td>
                    <td style="text-align: right">{{number_format($special,0, ',', ' ')}}</td>
                </tr>
            </tbody>
            <div style="text-align: right;padding: 5px;font-size: 25px">
                <span style="font-weight: bold">Total: </span><span>{{number_format(
                    $prive+$abonne+$ambulant+$special
                    ,0, ',', ' ') }} Fc</span>
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
