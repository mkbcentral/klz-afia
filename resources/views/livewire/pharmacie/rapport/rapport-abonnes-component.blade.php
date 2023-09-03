<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-header">
            RAPPORT DE LA PHARMACIE POUR LES ABONNES
        </div>
        <div class="d-flex justify-content-between p-4">
            <div>
                <div class="form-group w-100">
                    <select  class="form-control" wire:model="abonnement_id" >
                        @foreach ($abonnements as $abonnement)
                            <option wire:click='getByDate' value="{{$abonnement->id}}">{{$abonnement->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <div class="form-group mr-4">
                    <label for="">Mois</label>
                    <select id="my-select" class="form-control" wire:model="currentDate">
                        @foreach ($mois as $moi)
                            <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
            $total_fact=0;$total_general=0;
        @endphp
        @if ($rapports->isEmpty())
            <div class="text-center mt-4 p-4">
                <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
            </div>
        @else
            <div class="card-body">
                <table class="table table-light table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>NUM. FACTURE</th>
                            <th>NOM PATIENT</th>
                            <th>PRODUITS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rapports as $rapport)
                            <tr>
                                @if ($rapport->products->isEmpty())

                                @else
                                    <td></td>
                                    <td>{{ $rapport->numero }}</td>
                                    <td>{{ $rapport->Nom.' '. $rapport->Postnom.' '. $rapport->Prenom }}</td>
                                    <td>
                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>DESIGNATION</th>
                                                    <th class="text-center">Q.T</th>
                                                    <th class="text-right">P.U</th>
                                                    <th class="text-right">P.T</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rapport->products as $product)
                                                    <tr>
                                                        <td >{{ $product->name }}</td>
                                                        <td class="text-center">{{ $product->pivot->qty }}</td>
                                                        <td class="text-right">{{ $product->price }}</td>
                                                        <td class="text-right">{{ $product->pivot->qty*$product->price }}</td>
                                                    </tr>
                                                    @php
                                                        $total_fact+=$product->pivot->qty*$product->price;
                                                    @endphp
                                                     @php
                                                     $total_general= $total_fact;
                                                 @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </td>
                                @endif
                            </tr>

                        @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div>

                    </div>
                    <div>
                        <span style="font-size: 25px;margin-right: 8px" class="text-danger">Total général: {{ number_format($total_general,1) }} Fc</span style="font-size: 18;margin-right: 8px" class="text-danger">
                    </div>
                </div>
                <div>
                    <a target="_blank" class="btn btn-info" href="{{ route('sitution.abonnes',[$currentDate,$abonnement_id]) }}"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
                </div>
            </div>
        @endif
    </div>
</div>
