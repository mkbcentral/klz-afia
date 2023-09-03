<!DOCTYPE html>
    @php
        $total=0;
         $total_special=0;
    @endphp
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Impression-Facture</title>
    <link rel="stylesheet" href="css/print.css">
  </head>
  <body>
        <div class="logo">
            <div class="">
                <img class="img-fluid" src="entete.png" alt=""></div>
            </div>
        </div>
    <div class="fact">
        <div><span> RAPPORT DE FREQUENTATION MENSUELLE DES MALADES ABONNES</span></div>
    </div>
    <div style="margin-left: 25px;padding: 10px">
        <div ><span> <span style="font-weight: bold">Mois</span>:{{ strftime('%B', mktime(0, 0, 0, $mois)) }}</span></div>
        <div ><span> <span style="font-weight: bold">Nombre</span>:{{$demandes->count()}}</span></div>
        <div ><span> <span style="font-weight: bold">Société</span>:{{$societe_name}}</span></div>
        <div ><span> <span style="font-weight: bold">Service</span>:Reception</span></div>
    </div>
     <div class="contenu">
        <table>
            <thead>
                <tr>
                   <th>DATE</th>
                      <th style="text-align: center">NUMERO</th>
                    <th style="">NOMS PATIENTS</th>
                    <th style="">AGE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandes as $demande)
                    <tr>
                        <td class="des2">
                         {{(new DateTime($demande->created_at))->format('d/m/Y') }}
                         </td>
                        <td class="des2" style="text-align: center">
                           {{ $demande->fiche->numero }}
                         </td>
                         <td class="des2" style="">
                            @if ($demande->isInterneted==true)
                            {{ $demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom }} /Hospitalisé
                            @else
                            {{ $demande->Nom.' '.$demande->Postnom.' '.$demande->Prenom }}
                            @endif
                        </td>
                        <td class="des2">
                            {{ date('Y')-  (new DateTime($demande->DateNaissance))->format('Y')   }} An(s)
                        </td>
                    </tr>
                @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="consigne">
        <div class="">
            <div>Fait à Lubumbashi, le {{ date('d/m/Y') }}</div>
        </div>
    </div>

  </body>
</html>
