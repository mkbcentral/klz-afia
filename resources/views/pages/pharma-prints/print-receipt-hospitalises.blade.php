<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Impression recu</title>
  </head>
  <body style=" margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Consolas, monaco, monospace;
                font-size: 23px;">
   <div>
    <div><Span>POLYCLINQUE SHUKRANI (sarl)</Span></div>
    <div><span>Golf TSHAMALALE N°12</span></div>
    <div><span>Av. Christion KUNDA</span></div>
    <div><span>RCCM:CD/LUBUMBASHI/RCCM/19-B-00658</span></div>
    <div><span>N° Impôt A2029032E</span></div>
    <br>
        <div>----------------------------------------</div>
        <div><span>Num: {{ $facture->numero}}</span></div>
        <div><span>Nom: {{ $facture->Nom.' '.$facture->Prenom}}</span></div>
        <div><span>Date: Le {{(new DateTime( $facture->created_at))->format('d-m-Y')}}</span></div>
        <div>----------------------------------------</div>
        @php
            $total_product=0;
            $total_general=0;
        @endphp
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th style="margin-left: 2px">DESIGNATION</th>
                    <th style="margin-left: 25px">QTE</th>
                    <th style="margin-left: 25px">PU FC</th>
                    <th style="margin-left: 25px;text-align: center">PT</th>
                </tr>
            </thead>
            <tbody>
                @if ($facture->products->isEmpty())
                @else
                    @foreach ($facture->products as $product)
                        <tr style="text-align: left; ">
                            <td style="margin-left: 12px">
                                -{{ $product->name }}
                            </td>
                            <td style="margin-left: 12px">
                                {{ $product->pivot->qty }}
                            </td>
                            <td style="margin-left: 12px">
                                {{ $product->price }}
                            </td>
                            <td style="margin-left: 12px">
                                {{  $product->pivot->qty*$product->price }}
                            </td>
                        </tr>
                        @php
                            $total_product+=$product->pivot->qty*$product->price;
                        @endphp
                    @endforeach
                @endif
            </tbody>
        </table>
        <div><span>****************************************</span></div>
        <div >
           <strong style="margin-left: 190px"> <span>Net à payer: {{ number_format($total_product,0)}} Fc</span></strong>
        </div>
        <br>
        <div><span>*********** Santé pour tous ! **********</span></div><br><br>
   </div>
  </body>
</html>
