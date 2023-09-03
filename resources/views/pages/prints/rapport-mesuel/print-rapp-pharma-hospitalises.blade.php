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
    <div style="text-align: center;padding: 15px;font-size: 22px;font-weight: bold"><span>RAPPORT DES VENTES MENSUELLES DE LA PHARMACIE DES PRIVES HOSPITALISES</span></div>
    <div style="padding: 5px;font-size: 19px">
        <div><span><span style="font-weight: bold">Sservice</span> : PHARMACIE</span></div>
        <div>
            <span><span style="font-weight: bold">Mois: </span> <span style="text-transform: uppercase;">{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</span></span>
        </div>
    </div>
    @php
        $total=0;
        $total2=0;;
    @endphp
    <div>
        <table class="" style="margin-left: 10px;">
            <thead class="">
                <tr>
                    <th style="text-align: left; padding: 10px">DATE</th>
                    <th style="text-align: left; padding: 10px"> NUMERO FACTURE</th>
                    <th style="text-align: left; padding: 10px">NOM PATIENT</th>
                    <th style="text-align: right; padding: 10px">MONTANT CDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factures as $key=>$facture)
                   @if ($facture->getTotalPrive($facture->id)>20000)
                        <tr>
                            <td>{{(new DateTime($facture->created_at))->format('d/m/Y')}}</td>
                            <td style="text-align: left">{{$facture->numero}}</td>
                            <td style="text-align: left">{{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}}</td>
                            <td style="text-align: right">{{number_format($facture->getTotalPrivePhamra($facture->id),0, ',', ' ') }}</td>
                        </tr>
                        @php
                            $total+=$facture->getTotalPrivePhamra($facture->id);
                        @endphp
                   @endif
                @endforeach

                @foreach ($specials as $special)
                    @if ($special->getTotalPharmaSpecial($special->id))
                        <tr>
                            <td>{{(new DateTime($special->created_at))->format('d/m/Y')}}</td>
                            <td style="text-align: left">{{$special->numero}}</td>
                            <td style="text-align: left">{{$special->name}}</td>
                            <td style="text-align: right">{{number_format($special->getTotalPharmaSpecial($special->id),0, ',', ' ') }}</td>
                        </tr>
                        @php
                            $total2+=$special->getTotalPharmaSpecial($special->id);
                        @endphp
                    @endif
                @endforeach
            </tbody>
            <div style="text-align: right;padding: 5px;font-size: 25px">
                <span style="font-weight: bold">Total: </span><span>{{number_format($total+$total2,0, ',', ' ') }} Fc</span>
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
