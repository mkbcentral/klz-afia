<div>
    <div class="card">
        <div class="card-header">
            RAPPORT DE LA PHARMACIE POUR BAC
        </div>
        <div class="d-flex justify-content-between p-4">
            <div>
                <div class="input-group mb-3 mt-2 ml-">
                    <input type="date" class="form-control"
                        wire:keydown.enter='getByDate'
                        wire:keydown.escape='getCurrentDate'
                        wire:model.defer='searchDate' aria-describedby="button-addon1">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary"  wire:click='getByDate' type="button" id="button-addon1"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>

                </div>
            </div>
            <div>

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
                                <td></td>
                                <td>{{ $rapport->numero }}</td>
                                <td>{{ $rapport->name }}</td>
                                <td>
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>DESIGNATION</th>
                                                <th class="text-center">Q.T</th>
                                                <th class="text-center">P.U</th>
                                                <th class="text-right">P.T</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rapport->products as $product)
                                                <tr>
                                                    <td >{{ $product->name }}</td>
                                                    <td class="text-center">{{ $product->pivot->qty }}</td>
                                                    <td class="text-center">{{ $product->price }}</td>
                                                    <td class="text-right">{{ $product->pivot->qty*$product->price }}</td>
                                                </tr>
                                                @php
                                                    $total_fact+=$product->pivot->qty*$product->price;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div>

                    </div>
                    <div>
                        <span style="font-size: 25px;margin-right: 8px" class="text-danger">Total général: {{ number_format($total_fact,1) }} Fc</span style="font-size: 18;margin-right: 8px" class="text-danger">
                    </div>
                </div>

                <div>
                    <a target="_black" href="{{ route('sitution.bac.print',$currentDate) }}" class="btn btn-primary">
                        <i class="fa fa-print" aria-hidden="true"></i> Tmprimer</a>
                </div>
            </div>
        @endif
    </div>
</div>
