<div>
    <x-loading-indicator />
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">SITUATION FINANCIERE PHARMACIE</P> </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div class="input-group">
                            <select class="custom-select" wire:model='currentDate' >
                              <option selected>Choisir le mois...</option>
                                    @foreach ($mois as $moi)
                                        <option value="{{ $moi }}">{{ strftime('%B', mktime(0, 0, 0, $moi)) }}</option>
                                    @endforeach
                            </select>

                        </div>
                    </div>
                    <div>
                        <div class="input-group-append">
                            <a class="btn btn-info" target="_blank" href="{{ route('parrot.fin.abones.abonnes',$currentDate) }}">
                                <i class="fa fa-print" aria-hidden="true"></i> Imprimer le rapport
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <table class="table table-stripped">
                        <thead class="thead-light">
                            <tr>
                                <th>MOIS</th>
                                <th class="text-center">TYPE</th>
                                <th class="text-right">MONTANT CDF</th>
                            </tr>
                        </thead>
                        @php
                            $total=0;
                        @endphp
                        <tbody>
                            @foreach ($abonnements as $abonnement)
                                <tr>
                                    <td>{{$abonnement->getCount($currentDate,$abonnement->id)}}</td>
                                    <td class="text-center">{{$abonnement->name}}</td>
                                    <td class="text-right">{{number_format($abonnement->getData($currentDate,$abonnement->id),1)}} Fc</td>
                                </tr>
                                @php
                                    $total+=$abonnement->getData($currentDate,$abonnement->id);
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td class="text-right text-bold" style="font-size: 25px">Total CDF: {{number_format($total,1)}} Fc</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
<!-- /.col -->
</div>
