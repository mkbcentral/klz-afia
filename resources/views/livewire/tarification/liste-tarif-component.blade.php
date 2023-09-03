<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                 <h1 class="m-0 text-danger">  <i class="fas fa-users-cog"></i>GRILLE TARIFAIRE</h1>
            </div>
            <div class="d-flex justify-cnetent-end">
                <div class="dropdown">
                    <button id="my-dropdown" class="btn btn-primary dropdown-toggle"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Impression</button>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                        <a target="_blank" class="dropdown-item" href="{{ route('grille.ptint.all') }}">Tous</a>
                        <a target="_blank" class="dropdown-item" href="{{ route('grille.ptint.prive') }}">Privés</a>
                        <a target="_blank" class="dropdown-item" href="{{ route('grille.ptint.abonne') }}">Abonnés</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                        @if ($consultations->isEmpty())
                        @else
                            <h3>1. CONSULTATION ET AUTRE</h3>
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-striped table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Désignation</th>
                                                    <th class="text-center">Prix privé</th>
                                                    <th class="text-center">Prix abonné</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($consultations as $consultation)
                                                    <tr>
                                                        <td>{{$consultation->name}}</td>
                                                        <td class="text-center">{{$consultation->price_prive}} $</td>
                                                        <td class="text-center">{{$consultation->price_abonne}} $</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($labos->isEmpty())

                        @else
                            <h3>2. LABORATOIRE</h3>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Désignation</th>
                                                <th class="text-center">Prix privé</th>
                                                <th class="text-center">Prix abonné</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($labos as $labo)
                                                <tr>
                                                    @if ($labo->abreviation=="Aucune")
                                                        <td>{{$labo->name}}</td>
                                                    @else
                                                    <td>{{$labo->abreviation}}</td>
                                                    @endif

                                                    <td class="text-center">{{$labo->price_prive}} $</td>
                                                    <td class="text-center">{{$labo->price_abonne}} $</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if ($labos->isempty())

                        @else
                            <h3>3. RADIOLOGIE</h3>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Examen</th>
                                                <th class="text-center">Prix privé</th>
                                                <th class="text-center">Prix abonné</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($radios as $radio)
                                                <tr>
                                                    <td>{{$radio->name}}</td>
                                                    <td class="text-center">{{$radio->price_prive}} $</td>
                                                    <td class="text-center">{{$radio->price_abonne}} $</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if ($echos->isempty())

                        @else
                            <h3>4. ECHOGRAPHIE</h3>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Désignation</th>
                                                <th class="text-center">Prix privé</th>
                                                <th class="text-center">Prix abonné</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($echos as $echo)
                                                <tr>
                                                    <td>{{$echo->name}}</td>
                                                    <td class="text-center">{{$echo->price_prive}} $</td>
                                                    <td class="text-center">{{$echo->price_abonne}} $</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if ($actes->isempty())

                        @else
                            <h3>5. ACTES ET ACCOUCHEMENT</h3>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Examen</th>
                                                <th class="text-center">Prix privé</th>
                                                <th class="text-center">Prix abonné</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($actes as $acte)
                                                <tr>
                                                    <td>{{$acte->name}}</td>
                                                    <td class="text-center">{{$acte->price_prive}} $</td>
                                                    <td class="text-center">{{$acte->price_abonne}} $</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if ($autres->isempty())

                        @else
                            <h3>6. AUTRES DETAILS</h3>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Désignatio</th>
                                                <th class="text-center">Prix privé</th>
                                                <th class="text-center">Prix abonné</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($autres as $autre)
                                                <tr>
                                                    <td>{{$autre->name}}</td>
                                                    <td class="text-center">{{$autre->price_prive}} $</td>
                                                    <td class="text-center">{{$autre->price_abonne}} $</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if ($sejours->isempty())

                        @else
                            <h3>7.HOSPITALISATION PAR JOUR</h3>
                            <div class="card">
                            <table class="table table-striped table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Désignation</th>
                                        <th class="text-center">Prix privé</th>
                                        <th class="text-center">Prix abonné</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sejours as $sejour)
                                        <tr>
                                            <td>{{$sejour->name}}</td>
                                            <td class="text-center">{{$sejour->price_prive}} $</td>
                                            <td class="text-center">{{$sejour->price_abonne}} $</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->
</div>
