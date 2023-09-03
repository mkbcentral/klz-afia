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
<body>
    <div class="entete" style="margin-left: 100px">
        <img  src="entete.png" alt="">
    </div>
    <div style="text-align: center;padding: 15px;font-size: 25px"><span>LISTE DES PRODUITS</span></div>
    <div>
        <table class="">
            <thead class="">
                <tr style="padding: 10px">
                    <th>QTE</th>
                    <th style="text-align: left">DESIGNATION</th>
                    <th>REQ 1</th>
                    <th>REQ 2</th>
                    <th>REQ 3</th>
                    <th>REQ 4</th>
                    <th>REQ 5</th>
                    <th>REQ 6</th>
                    <th>STOCK</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr>
                        <td style="text-align: center"></td>
                        <td>{{ $product->name }}</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
