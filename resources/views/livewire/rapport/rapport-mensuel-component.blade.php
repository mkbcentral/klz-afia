<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger"><i class="fas fa-folder-open"></i> RAPPORT MENSUEL </h1>
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
                      @if (Auth::user()->role->name=="Admin")
                        <li class="nav-item"><a class="nav-link active" href="#prive" data-toggle="tab"><i class="fas fa-user-shield"></i> Requisition stock</a></li>
                        <li class="nav-item"><a class="nav-link " href="#personnel" data-toggle="tab"><i class="fas fa-users"></i> Consommation produits pharmacie</a></li>
                        <li class="nav-item"><a class="nav-link" href="#forfait " data-toggle="tab"><i class="fas fa-user-friends"></i> Situtation pharma privés</a></li>
                        <li class="nav-item"><a class="nav-link " href="#vente" data-toggle="tab"><i class="fas fa-user-friends"></i> Ventes cash</a></li>
                        <li class="nav-item"><a class="nav-link  " href="#vente-abonnes" data-toggle="tab"><i class="fas fa-user-friends"></i> Ventes abonnés</a></li>
                        <li class="nav-item "><a class="nav-link" href="#stock" data-toggle="tab"><i class="fas fa-user-tag"></i> Stock</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link " href="#personnel" data-toggle="tab"><i class="fas fa-users"></i> Consommation produits pharmacie</a></li>
                        <li class="nav-item active"><a class="nav-link" href="#abonnes" data-toggle="tab"><i class="fas fa-user-tag"></i> Situation abonnés/mois</a></li>

                      @endif

                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                      @if (Auth::user()->role->name=="Admin")
                        <div class=" tab-pane active" id="prive">
                            @livewire('rapport.rapport-sortie-pharma-mensuel')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="personnel">
                            @livewire('rapport.consommation-pharma-component')
                        </div>
                        <div class="tab-pane" id="forfait">
                            @livewire('rapport.prive-pharma-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="vente">
                           @livewire('rapport.rapport-ventes-component')
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="vente-abonnes">
                            @livewire('rapport.rapport-ventes-abonnes-component')
                         </div>
                         <!-- /.tab-pane -->
                      @else
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="personnel">
                            @livewire('rapport.consommation-pharma-component')
                        </div>
                        <div class="tab-pane active" id="forfait">
                            @livewire('rapport.rapport-fin-abonnes-pharma-compoenent')
                        </div>
                        <!-- /.tab-pane -->
                      @endif
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="stock">
                        stock
                    </div>
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
