<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger"><i class="fas fa-folder-open"></i> GESTIONNAIRE DES PATIENTS</h1>
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
                    <li class="nav-item"><a class="nav-link active" href="#prive" data-toggle="tab"><i class="fas fa-user-shield"></i> Privés</a></li>
                    <li class="nav-item"><a class="nav-link" href="#abonnes" data-toggle="tab"><i class="fas fa-user-tag"></i> Abonnés</a></li>
                    <li class="nav-item"><a class="nav-link" href="#personnel" data-toggle="tab"><i class="fas fa-users"></i> Patient porsonnel</a></li>
                    @if (Auth::user()->role->name=='Admin' or Auth::user()->role->name=='receptioniste')
                        <li class="nav-item"><a class="nav-link" href="#forfait" data-toggle="tab"><i class="fas fa-user-friends"></i> Par forfat</a></li>
                    @endif

                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="prive">
                       @livewire('patients.prives.patient-prives-compnent')
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="abonnes">
                       @livewire('patients.abonnes.patients-abonnes-component')
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="personnel">
                       @livewire('patients.personnels.patients-personnels-component')
                    </div>
                    <div class="tab-pane" id="forfait">
                        @livewire('patients.forfait.patients-forfait-component')
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
