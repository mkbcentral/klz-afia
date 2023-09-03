<div>
    <div class="card">
        <x-loading-indicator />
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Année</label>
                        <select id="my-select" class="form-control" wire:model="currentYear">
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2 ml-5 w-25">
                    <div class="form-group">
                        <label for="">Mois</label>
                        <select id="my-select" class="form-control" wire:model="currentMonth">
                            @foreach ($months as $month)
                                <option value="{{ $month }}">{{ strftime('%B', mktime(0, 0, 0, $month, 10)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <a target="_blank" href="{{ route('print.data.pharma', [$currentMonth,$currentYear]) }}">Imprimer</a>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Product</th>
                        <th>Months</th>
                        <th class="text-center">Qt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        @if ($product->getSortieDemandeMontnAndYear($product->id, $currentMonth, $currentYear)+
                        $product->getSortieAmbulantMonthAndYear($product->id, $currentMonth, $currentYear)+
                        $product->getSortieDemandeSpecMontnAndYear($product->id, $currentMonth, $currentYear)
                             > 0
                             )
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $currentMonth.'-'.$currentYear }}</td>
                                <td class="text-center">
                                    {{
                                    $product->getSortieDemandeMontnAndYear($product->id, $currentMonth, $currentYear)+
                                    $product->getSortieAmbulantMonthAndYear($product->id, $currentMonth, $currentYear)+
                                    $product->getSortieDemandeSpecMontnAndYear($product->id, $currentMonth, $currentYear)
                                    }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
