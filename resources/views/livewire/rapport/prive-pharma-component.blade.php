<div>
    <x-loading-indicator />
    <div class="col-md-12">
        <div class="card card-secondary card-outline">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                  <div>
                      <h3 class="card-title">SITUATION PHARMACIE PRIVES</h3>
                  </div>
                  <div>
                      <a target="_blank" href="{{ route('pharma.prives.hosp', $currentDate) }}">Imprimer</a>
                  </div>
              </div>
            </div>
            <div class="card-body">
                <div class="mailbox-controls">
                    <div class="card-body">

                        @php
                            $toatl_general=0;
                            $toatl_general_spec=0;
                        @endphp
                        <div class="d-flex justify-content-between">
                            <div class="mt-2 ml-5 w-25">
                                <div class="form-group">
                                    <label for="">Mois</label>
                                    <select id="my-select" class="form-control" wire:model="currentDate">
                                        @foreach ($mois as $moi)
                                            <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="card-tools w-50 mb-4">
                                        <div class="input-group input-group-sm">
                                        <input wire:model='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                                        <div class="input-group-append">
                                            <div class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($factures->isEmpty())
                                    <div class="text-center mt-4 p-4">
                                        <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                                    </div>
                                @else
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th># Date</th>
                                                <th class="text-center">NUMERO DE LA FACTURE</th>
                                                <th>NOM DU PATIENT</th>
                                                <th class="text-right">MONTANT CDF</th>
                                                <th class="text-center">ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($factures as $facture)
                                                @if ($facture->getTotalPrive($facture->id)>20000)
                                                <tr>
                                                    <td scope="row">
                                                        <span class="text-primary">
                                                            <i class="fa fa-folder" aria-hidden="true"></i>
                                                            {{(new DateTime($facture->created_at))->format('d/m/Y')}}
                                                        </span>
                                                        @if ($facture->source=="Golf")
                                                            <span class="text-danger">[Golf]</span>
                                                        @else
                                                            <span class="text-success">[Ville]</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-primary text-center">{{$facture->numero}}</td>

                                                    <td>
                                                        {{$facture->Nom.' '.$facture->Postnom.' '.$facture->Prenom}}
                                                        @if ($facture->reduction !=null)
                                                            | <span class="text-success">Sous reduction</span>
                                                        @endif
                                                        @if ($facture->accompte !=null)
                                                        | <span class="text-info">Sous accompte</span>
                                                    @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                    Courier New, monospace, serif">
                                                            {{number_format($facture->getTotalPrivePhamra($facture->id),1)}}
                                                        </span>

                                                    </td>
                                                    <td class="text-center">
                                                        Ok !
                                                    </td>
                                                </tr>
                                                @php
                                                    $toatl_general+=$facture->getTotalPrivePhamra($facture->id);
                                                @endphp
                                                @endif

                                            @endforeach

                                            @foreach ($specials as $specials)
                                                @if ($specials->getTotalPharmaSpecial($specials->id)!=0)
                                                    <tr>
                                                        <td scope="row">
                                                            <span class="text-primary">
                                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                                                {{(new DateTime($facture->created_at))->format('d/m/Y')}}
                                                            </span>
                                                            @if ($facture->source=="Golf")
                                                                <span class="text-danger">[Golf]</span>
                                                            @else
                                                                <span class="text-success">[Ville]</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-primary text-center">{{$specials->numero}}</td>

                                                        <td>
                                                            {{$specials->name}}
                                                        </td>
                                                        <td class="text-right">
                                                            <span style="font-family:Consolas, Menlo, Monaco, Lucida Console,
                                                                        Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                                                        Courier New, monospace, serif">
                                                                {{number_format($specials->getTotalPharmaSpecial($specials->id),1)}}
                                                            </span>

                                                        </td>
                                                        <td class="text-center">
                                                            Ok !
                                                        </td>
                                                    </tr>
                                                    @php
                                                    $toatl_general_spec+=$specials->getTotalPharmaSpecial($specials->id);
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex justify-content-between">
                                    <div style="margin-right: 30px;font-size: 30px;font-weight: bold">
                                        <span>Total USD: {{ number_format(($toatl_general+ $toatl_general_spec)/$valeur_taux,1) }} </span>
                                    </div>
                                    <div style="margin-right: 30px;font-size: 30px;font-weight: bold" >
                                        <span>Total CDF: {{ number_format($toatl_general+ $toatl_general_spec,1) }} </span>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
