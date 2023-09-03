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
    <div style="text-align: center;padding: 15px;font-size: 32px; font-weight: bold;color: black"><span>GRILLE TARIFAIRE</span></div>


    <div>
        @if ($consultations->isEmpty())

        @else
            <h3>1. CONSULTATION ET AUTRE</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultations as $key=>$consultation)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>

                        <td style="">{{ $consultation->name }} </td>
                        <td style="text-align: right">{{$consultation->price_prive  }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

        @if ($labos->isEmpty())

        @else
            <h3>2. LABORATOIRE</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labos as $key=>$labo)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>
                        @if ($labo->abreviation=="Aucune")
                            <td>{{$labo->name}}</td>
                        @else
                            <td>{{$labo->abreviation}}</td>
                        @endif
                        <td style="text-align: right">{{$labo->price_prive  }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

        @if ($radios->isEmpty())

        @else
            <h3>3. RADIOLOGIE</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($radios as $key=>$radio)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>

                        <td style="">{{ $radio->name }} </td>

                        <td style="text-align: right">{{$radio->price_prive  }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

        @if ($echos->isEmpty())

        @else
            <h3>4. ECHOGRAPHIE</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($echos as $key=>$echo)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>
                        <td style="">{{ $echo->name }} </td>
                        <td style="text-align: right">{{$echo->price_prive  }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

        @if ($echos->isEmpty())

        @else
            <h3>5. ACTES ET ACCOUCHEMENT</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actes as $key=>$acte)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>
                        <td style="">{{ $acte->name }} </td>
                        <td style="text-align: right">{{$acte->price_prive  }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif


        @if ($echos->isEmpty())

        @else
            <h3>6. AUTRES DETAILS</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($autres as $key=>$autre)
                    <tr>
                        <td style="text-align: center">{{$key+1}} </td>

                        <td style="">{{ $autre->name }} </td>

                        <td style="text-align: right">{{$autre->price_prive  }}</td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

        @if ($echos->isEmpty())

        @else
            <h3>7. HOSPITALISATION PAR JOUR</h3>
            <table class="" style="margin-left: 10px;margin-top: 10px">
                <thead class="">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th>DESIGNATION</th>
                        <th style="text-align: right">PRIX PRIVE USD</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($sejours as $key=>$sejour)
                    <tr>
                        <td style="">{{$key+1}} </td>

                        <td style="">{{ $sejour->name }} </td>

                        <td style="text-align: right">{{$sejour->price_prive  }}</td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif

    </div>
</body>
</html>
