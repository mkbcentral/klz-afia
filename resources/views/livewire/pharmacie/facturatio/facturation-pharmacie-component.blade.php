<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h2 class="m-0 text-danger"><i class="fas fa-tablets"></i> FACTURATION PHARMACIE</h2>
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
                    <li class="nav-item"><a class="nav-link active" href="#product" data-toggle="tab"><i class="fas fa-tablets"></i> Ambuluants</a></li>
                    <li class="nav-item"><a class="nav-link" href="#entrees" data-toggle="tab"><i class="far fa-copy"></i> Hospitalisés privés</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sorties" data-toggle="tab"><i class="fas fa-file-upload"></i> Liste patient abonnés</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                        <div class="active tab-pane" id="product">
                           @livewire('pharmacie.facturation.facturation-ambulant-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="entrees">
                           @livewire('pharmacie.facturation.hospitalises.facture-pharma-hospitalises-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="sorties">
                            @livewire('pharmacie.facturation.abonnes.facture-pharma-abonnes-component')
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
