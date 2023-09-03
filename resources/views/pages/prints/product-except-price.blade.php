
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
            font-size: 14px;
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
    <div style="text-align: center;padding: 15px;font-size: 20px;text-align: center;font-weight: bold"><span>REQUISITION EN URGENCE POUR LES PRODUITS PHARMACEUTIQUES</span></div>
    <div>
        <table class="" style="margin-left: 25px">
            <thead class="">
                <tr>
                    <th>N°</th>
                    <th>PRODUITS</th>
                    <th>FORME</th>
                    <th>QT DISP</th>
                    <th>QT DMD</th>
                    <th>PRIX UNITAIRE</th>
                    <th>PRIX TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr>
                        <td style="text-align: center">{{ $key+1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
