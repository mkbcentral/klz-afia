<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="modal-title text-bold text-danger" id="my-modal-title">
                <span style="font-size: 20px;">FACTURATION AMBULANTS</span>
            </h3>
            <!-- /.card-tools -->
          </div>

          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div class="input-group input-group-sm">
                            <input wire:model.defer='keySearch'
                                 type="date" wire:keydown.enter='getByDate' class="form-control">
                            <div class="input-group-append">
                              <div class="btn btn-primary">
                                <i class="fas fa-search"></i>
                              </div>
                            </div>
                          </div>
                    </div>
                    <button class="btn btn-info" data-toggle='modal'
                         data-target="#addNewRecette" type="button">
                            <i class="far fa-calendar-plus"></i> Nouvelle recette</button>
                </div>
                @php
                    $total_cdf=0;
                    $total_usd=0;
                @endphp
                <div class="p-2">
                   @if ($recettes->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                   @else
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th class="">CODE</th>
                                    <th class="text-right bg-danger">ENT. CDF</th>
                                    <th class="text-right bg-warning">ENT. USD</th>
                                    <th class="text-right bg-danger">DEP. CDF</th>
                                    <th class="text-right bg-warning">DEP. USD</th>
                                    <th class="text-left">LIBELLES</th>
                                    <th class="text-right">RESTE CDF</th>
                                    <th class="text-right">RESTE USD</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recettes as $recette)
                                    <tr style=" font-family:Consolas, Menlo, Monaco, Lucida Console,
                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                    Courier New, monospace, serif">
                                        <td><i class="fa fa-folder" aria-hidden="true"></i></td>
                                        <td>{{(new DateTime($recette->created_at))->format('d/m/Y')}}</td>
                                        <td>{{$recette->numero}}</td>
                                        @if ($recette->mt_cdf==0)
                                         <td class="text-right bg-secondary ">{{number_format($recette->mt_cdf,2)}}</td>
                                        @else
                                            <td class="text-right text-primary">{{number_format($recette->mt_cdf,2)}}</td>
                                        @endif
                                        @if ($recette->mt_usd==0)
                                            <td class="text-right bg-secondary">{{number_format($recette->mt_usd,2)}}</td>
                                        @else
                                            <td class="text-right ">{{number_format($recette->mt_usd,1)}}</td>
                                        @endif
                                        <td class="text-right text-danger">{{number_format($recette->getDepensesCDF($recette->id),2)}}</td>
                                        <td class="text-right">{{number_format($recette->getDepensesUSD($recette->id),2)}}</td>
                                        <td>Aucune</td>
                                        @if ($recette->mt_cdf-$recette->getDepensesCDF($recette->id)<1)
                                            <td class="text-right">{{number_format(0,2)}}</td>
                                        @else
                                            <td class="text-right">{{number_format($recette->mt_cdf-$recette->getDepensesCDF($recette->id),2)}}</td>
                                            @php
                                                $total_cdf+=$recette->mt_cdf-$recette->getDepensesCDF($recette->id);
                                            @endphp
                                        @endif
                                        @if ($recette->mt_usd-$recette->getDepensesUSD($recette->id)<0)
                                            <td class="text-right">{{number_format(0,1)}}</td>
                                        @else
                                            <td class="text-right">{{number_format($recette->mt_usd-$recette->getDepensesUSD($recette->id),1)}}</td>
                                            @php
                                                $total_usd+=$recette->mt_usd-$recette->getDepensesUSD($recette->id);
                                            @endphp
                                        @endif

                                        <td class="text-right">
                                            <button wire:click='show({{$recette->id}})' data-toggle="modal" data-target="#addNewDepense" class="btn btn-link btn-sm" type="button"><i class="fas fa-plus-circle"></i></button>
                                            <button wire:click='show({{$recette->id}})'  data-toggle="modal" data-target="#editNewRecette" class="btn btn-link btn-sm" type="button"><i class="fas fa-edit"></i></button>
                                            <button  class="btn btn-link btn-sm" type="button"><i class="fas fa-trash text-danger"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                    <tr class="bg-dark" style="font-size: 20px; font-family:Consolas, Menlo, Monaco, Lucida Console,
                                    Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono,
                                    Courier New, monospace, serif">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right ml-2">CDF {{number_format($total_cdf,2)}} | </td>
                                        <td class="text-right">USD {{number_format($total_usd,1)}}</td>
                                        <td></td>
                                    </tr>
                            </tbody>
                        </table>

                   @endif

                </div>
            </div>
          </div>

        </div>

    </div>
    @include('livewire.finance.modals.add-new-recettes')
    @include('livewire.finance.modals.edit-recette')
    @include('livewire.finance.modals.add-new-depense')
<!-- /.col -->
</div>
