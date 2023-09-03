<div>
    <x-loading-indicator />
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">SORTIE EN STCOK </h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                   <div>
                        <div class="input-group">
                            <select class="custom-select" wire:model='service_id' >
                            <option selected>Choisir le service...</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                            </select>

                        </div>
                   </div>
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
                            <div class="input-group-append">
                                <a target="_blank" href="{{ route('print.rapp.mens.pharmacie.sortie', [$service_id,$currentDate]) }}" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                        </div>
                        </div>
                    </div>
                </div>
                @php
                    $total=0;
                @endphp
                <div class="p-2">
                    @if ($sorties->isEmpty())
                        <div class="text-center mt-4 p-4">
                            <h3 class="text-success"><i class="fa fa-database" aria-hidden="true"></i> Aunce donnée trouvée</h3>
                        </div>
                    @else
                        <table class="table table-light table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">Q.T</th>
                                    <th>UTILISATEUR</th>
                                    <th>SERVICE</th>
                                    <th class="text-right">MONTANT</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sorties as $sortie)
                                    <tr>
                                        <td><i class="fas fa-folder-open text-info"></i></td>
                                        <td>{{ (new DateTime($sortie->created_at))->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ $sortie->code }}</td>
                                        <td class="text-center">{{ $sortie->products()->count() }}</td>
                                        <td>{{ $sortie->user->name }}</td>
                                        <td>{{ $sortie->service->name }}</td>
                                        <td class="text-right">{{ number_format($sortie->getToatl($sortie->id),1) }}</td>
                                        <td class="text-center">
                                            <a target="_blank" href="" class="btn-link"><i class="fa fa-print" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $total+=$sortie->getToatl($sortie->id);
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card">
                            <div class="card-body text-right ">
                                <h2 class="ml-4">{{number_format($total,1)}} Fc</h2>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
          </div>
        </div>
    </div>
<!-- /.col -->
</div>
