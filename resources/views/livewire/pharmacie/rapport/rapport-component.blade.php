<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h2 class="m-0 text-danger"><i class="fas fa-tablets"></i>SORTIES JOURNALIERES PHARMACIE</h2>
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
                    <li class="nav-item">
                        <a class="nav-link active" href="#product" data-toggle="tab">
                            <i class="fas fa-tablets"></i> Rapport ambuluants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#entrees" data-toggle="tab">
                            <i class="fas fa-tablets"></i> Rapport abonnés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sorties" data-toggle="tab">
                            <i class="fas fa-tablets"></i> Rapport hospitalisés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bac" data-toggle="tab">
                            <i class="fas fa-tablets"></i> Rapport BAC
                        </a>
                    </li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                        <div class="active tab-pane" id="product">
                           @livewire('pharmacie.rapport.rapport-ambulant-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="entrees">
                            @livewire('pharmacie.rapport.rapport-abonnes-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="sorties">
                            @livewire('pharmacie.rapport.rapport-hospitalises-component')
                        </div>

                        <div class="tab-pane" id="bac">
                           @livewire('pharmacie.rapport.rapport-bac-component')
                        </div>
                  </div>     <!-- /.tab-content -->
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
