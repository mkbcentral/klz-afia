<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-danger"> <i class="fas fa-users-cog"></i>GESTION DE LA TARIFICATION</h1>
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
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#prive" data-toggle="tab"><i
                                            class="fas fa-user-shield"></i> Consultation</a></li>
                                <li class="nav-item"><a class="nav-link" href="#abonnes" data-toggle="tab"><i
                                            class="fas fa-user-tag"></i> Labo</a></li>
                                <li class="nav-item"><a class="nav-link" href="#personnel" data-toggle="tab"><i
                                            class="fas fa-users"></i> Radio</a></li>
                                <li class="nav-item"><a class="nav-link" href="#forfait" data-toggle="tab"><i
                                            class="fas fa-user-friends"></i> Echo</a></li>
                                <li class="nav-item"><a class="nav-link" href="#actes" data-toggle="tab"><i
                                            class="fas fa-user-friends"></i> Actes</a></li>
                                <li class="nav-item"><a class="nav-link" href="#autres" data-toggle="tab"><i
                                            class="fas fa-user-friends"></i> Autres</a></li>
                                <li class="nav-item"><a class="nav-link" href="#sejour" data-toggle="tab"><i
                                            class="fas fa-user-friends"></i> Sejour</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="prive" wire:ignore.self>
                                    @livewire('tarification.cons.tarificatiion-conusltation')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="abonnes" wire:ignore.self>
                                    @livewire('tarification.labo.tarificatiion-labo')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="personnel" wire:ignore.self>
                                    @livewire('tarification.radio.tarificatiion-radio')
                                </div>
                                <div class="tab-pane" id="forfait" wire:ignore.self>
                                    @livewire('tarification.echo.tarificatiion-echo')
                                </div>
                                <div class="tab-pane" id="actes" wire:ignore.self>
                                    @livewire('tarification.actes.tarificatiion-actes')
                                </div>
                                <div class="tab-pane" id="autres" wire:ignore.self>
                                    @livewire('tarification.autres.tarificatiion-autres')
                                </div>
                                <div class="tab-pane" id="sejour" wire:ignore.self>
                                    @livewire('tarification.sejour.tarificatiion-sejour')
                                </div>
                                <!-- /.tab-pane -->
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
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
