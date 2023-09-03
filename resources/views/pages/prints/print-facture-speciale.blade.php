<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Impression-Facture</title>
    <link rel="stylesheet" href="css/print.css">
</head>

<body>
    <div class="logo">
        <div class="">
            <img class="img-fluid" src="entete.png" alt="">
        </div>
    </div>
    </div>
    <div class="entete">
        <div class="gauche">
            <div><Span><strong>Noms: </strong>{{ $demande->name }}</Span></div>
            <div><Span><strong>Type </strong> {{ $demande->type }}</Span><br></div>
            <div><Span><strong>Tél: </strong> +243 85 39 51 763</Span></div>

        </div>
        <div class="droit">


        </div>
    </div>
    <div class="fact">
        <div><span>Facture N°: {{ $demande->numero }}</span></div>
    </div>
    <div class="contenu">
        @php
            $total_labo = 0;
            $total_radio = 0;
            $total_cons = 0;
            $net_a_payer = 0;
            $total_medication = 0;
            $total_chirurgie = 0;
            $total_oreille = 0;
            $total_dentisterie = 0;
            $total_autres = 0;
            $total_sejours = 0;
            $total_echo = 0;
            $total_gyneco = 0;
            $total_nursing = 0;
            $total_acte = 0;
        @endphp
        <!-- ELEMENTS DES CONSULTATION  -->
        <!-- ELEMENTS DES ACTES  -->
        @if ($demande->actes->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>LABORATOIRE</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ELEMENTS DES EXAMENS LABO -->
                    @foreach ($demande->actes as $acte)
                        <tr>
                            <td class="des2">
                                -{{ $acte->name }}
                            </td>
                            <td class="des">{{ $acte->pivot->qty }}</td>
                            @if ($demande->type == 'Privé')
                                <td class="m-price2">
                                    {{ $acte->price_prive * $valeur_taux }}
                                </td>
                                <td class="m-price2">
                                    {{ $acte->price_prive * $valeur_taux * $acte->pivot->qty }}
                                </td>
                            @else
                                <td class="m-price2">
                                    {{ $acte->price_abonne * $valeur_taux }}
                                </td>
                                <td class="m-price2">
                                    {{ $acte->price_abonne * $valeur_taux * $acte->pivot->qty }}
                                </td>
                            @endif
                        </tr>
                        @if ($demande->type == 'Privé')
                            Total: {{ $total_acte += $acte->price_prive * $valeur_taux * $acte->pivot->qty }} CDF
                        @else
                            Total: {{ $total_acte += $acte->price_abonne * $valeur_taux * $acte->pivot->qty }} CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none; border-left: none"></td>
                        <td>
                        <td class="des" style="border-left: none:border-right: none">
                            Total:
                        </td>
                        <td class="m-price" style="border-left: none">
                            {{ $total_acte }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- ELEMENTS DES EXAMENS LABO  -->
        @if ($demande->examenLabos->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>LABORATOIRE</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ELEMENTS DES EXAMENS LABO -->
                    @foreach ($demande->examenLabos as $labo)
                        <tr>
                            <td class="des2">
                                @if ($labo->abreviation == 'Aucune')
                                    -{{ $labo->name }}
                                @else
                                    -{{ $labo->abreviation }}
                                @endif
                            </td>
                            <td class="des">{{ $labo->pivot->qty }}</td>
                            @if ($demande->type == 'Privé')
                                <td class="m-price2">
                                    {{ $labo->price_prive * $valeur_taux }}
                                </td>
                                <td class="m-price2">
                                    {{ $labo->price_prive * $valeur_taux * $labo->pivot->qty }}
                                </td>
                            @else
                                <td class="m-price2">
                                    {{ $labo->price_abonne * $valeur_taux }}
                                </td>
                                <td class="m-price2">
                                    {{ $labo->price_abonne * $valeur_taux * $labo->pivot->qty }}
                                </td>
                            @endif
                        </tr>
                        @if ($demande->type == 'Privé')
                            Total: {{ $total_labo += $labo->price_prive * $valeur_taux * $labo->pivot->qty }} CDF
                        @else
                            Total: {{ $total_labo += $labo->price_abonne * $valeur_taux * $labo->pivot->qty }} CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none; border-left: none"></td>
                        <td>
                        <td class="des" style="border-left: none:border-right: none">
                            Total:
                        </td>
                        <td class="m-price" style="border-left: none">
                            {{ $total_labo }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        <!-- ELEMENTS DES EXAMENS RADIO  -->
        @if ($demande->examenRadios->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>RADIOLOGIE</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->examenRadios as $data_radio)
                        <tr>
                            <td class="des2">
                                -{{ $data_radio->name }}
                            </td>
                            <td class="des">{{ $data_radio->pivot->qty }}</td>
                            @if ($demande->type == 'Privé')
                                <td class="m-price">
                                    {{ $data_radio->price_prive * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_radio->price_prive * $valeur_taux * $data_radio->pivot->qty }}
                                </td>
                            @else
                                <td class="m-price">
                                    {{ $data_radio->price_abonne * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_radio->price_abonne * $valeur_taux * $data_radio->pivot->qty }}
                                </td>
                            @endif
                        </tr>
                        @if ($demande->type == 'Privé')
                            {{ $total_radio += $data_radio->price_prive * $valeur_taux * $data_radio->pivot->qty }} CDF
                        @else
                            {{ $total_radio += $data_radio->price_abonne * $valeur_taux * $data_radio->pivot->qty }} CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_radio }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- ELEMENTS MEDICATIONS  -->
        @if ($demande->products->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>MEDICATION</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->products as $data_mecation)
                        <tr>
                            <td class="des2">
                                -{{ $data_mecation->name }}
                            </td>
                            <td class="des">
                                {{ $data_mecation->pivot->qty }}
                            </td>
                            <td class="m-price">
                                {{ $data_mecation->price }}
                            </td>
                            <td class="m-price">
                                {{ $data_mecation->price * $data_mecation->pivot->qty }}
                            </td>
                        </tr>
                        {{ $total_medication += $data_mecation->price * $data_mecation->pivot->qty }}
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_medication }} Fc
                        </td>
                    </tr>

                </tbody>
            </table>
        @endif
        <!-- ELEMENTS ECHO-->
        @if ($demande->echographies->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>ECHOGRAPHIE</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->echographies as $echo)
                        <tr>
                            <td class="des2">
                                -{{ $echo->name }}
                            </td>
                            <td class="des">1</td>
                            @if ($demande->type == 'Privé')
                                <td class="m-price">
                                    {{ $echo->price_prive * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $echo->price_prive * $valeur_taux * 1 }}
                                </td>
                            @else
                                <td class="m-price">
                                    {{ $echo->price_abonne * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $echo->price_abonne * $valeur_taux * 1 }}
                                </td>
                            @endif
                        </tr>
                        @if ($demande->type == 'Privé')
                            {{ $total_echo += $echo->price_prive * $valeur_taux }} CDF
                        @else
                            {{ $total_echo += $echo->price_abonne * $valeur_taux }} CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_echo }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        <!-- ELEMENTS AUTRE-->
        @if ($demande->autres->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>AUTRES</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">SEANCE</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->autres as $data_autres)
                        <tr>
                            <td class="des2">
                                -{{ $data_autres->name }}
                            </td>
                            <td class="des">{{ $data_autres->pivot->qty }}</td>
                            @if ($demande->type == 'Prive')
                                <td class="m-price">
                                    {{ $data_autres->price_prive * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_autres->price_prive * $valeur_taux * $data_autres->pivot->qty }}
                                </td>
                            @else
                                <td class="m-price">
                                    {{ $data_autres->price_abonne * $valeur_taux }}
                                </td>
                                <td class="m-price">
                                    {{ $data_autres->price_abonne * $valeur_taux * $data_autres->pivot->qty }}
                                </td>
                            @endif
                        </tr>
                        @if ($demande->type == 'Prive')
                            {{ $total_autres += $data_autres->price_prive * $valeur_taux * $data_autres->pivot->qty }} CDF
                        @else
                            {{ $total_autres += $data_autres->price_abonne * $valeur_taux * $data_autres->pivot->qty }} CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_autres }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- ELEMENTS AUTRE-->
        @if ($demande->nursings->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>NURSINGS</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->nursings as $nursings)
                        <tr>
                            <td class="des2">
                                {{ $nursings->name }}
                            </td>
                            <td class="des">{{ $nursings->qty }}</td>
                            <td class="m-price">
                                {{ $nursings->price * $valeur_taux }}
                            </td>
                            <td class="m-price">
                                {{ $nursings->price * $valeur_taux * $nursings->qty }}
                            </td>
                        </tr>
                        @php
                            $total_nursing += $nursings->price * $valeur_taux * $nursings->qty;
                        @endphp
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_nursing }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        <!-- ELEMENTS SEJOUR-->
        @if ($demande->sejours->isEmpty())
        @else
            <table>
                <thead>
                    <tr>
                        <th>SEJOUR</th>
                        <th class="price"></th>
                        <th class="price"></th>
                        <th class="price"></th>
                    </tr>
                    <tr>
                        <th>DESIGNATION</th>
                        <th class="price">QT</th>
                        <th class="price">PU CDF</th>
                        <th class="price">PT CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demande->sejours as $data_sejour)
                        <tr>
                            <td class="des2">
                                -{{ $data_sejour->name }}
                            </td>
                            <td class="des">{{ $data_sejour->pivot->qty }}</td>
                            <td class="m-price">
                                @if ($demande->type == 'Privé')
                                    {{ $data_sejour->price_prive * $valeur_taux }}
                                @else
                                    {{ $data_sejour->price_abonne * $valeur_taux }}
                                @endif
                            </td>
                            <td class="m-price">
                                @if ($demande->type == 'Privé')
                                    {{ $data_sejour->price_prive * $valeur_taux * $data_sejour->pivot->qty }}
                                @else
                                    {{ $data_sejour->price_abonne * $valeur_taux * $data_sejour->pivot->qty }}
                                @endif
                            </td>
                        </tr>
                        @if ($demande->type == 'Privé')
                            {{ $total_sejours += $data_sejour->price_prive * $valeur_taux * $data_sejour->pivot->qty }}CDF
                        @else
                            {{ $total_sejours += $data_sejour->price_abonne * $valeur_taux * $data_sejour->pivot->qty }}
                            CDF
                        @endif
                    @endforeach
                    <tr class="row">
                        <td class="des" style="border-right: none;"></td>
                        <td></td>
                        <td> Total: </td>
                        <td class="m-price">
                            {{ $total_sejours }} Fc
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        @php
            $net_a_payer = $total_acte + $total_labo + $total_radio + $total_medication + $total_chirurgie + $total_autres + $total_oreille + $total_dentisterie + $total_sejours + $total_echo + $total_nursing;
        @endphp
        <div style="text-align: right;margin-top: 10px;">
            <table>
                <tbody style="font-size: 15px;font-weight: bold">
                    <tr>
                        <td>Total CDF:</td>
                        <td>{{ number_format($net_a_payer, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Total USD:</td>
                        <td>{{ number_format($net_a_payer / $valeur_taux, 1) }} $</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="consigne">
        <div class="">
            <div>Fait à Lubumbashi, le {{ date('d-m-Y') }}</div>
        </div>
        <div style="font-size: 20px;margin-top: 25px;">
            <span style="font-weight: bold;margin-right: 500px">INFO</span>

            <span style="font-weight: bold">A.G</span>
        </div>
    </div>
</body>

</html>
