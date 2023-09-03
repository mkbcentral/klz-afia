<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h2 class="m-0 text-danger"><i class="fas fa-tablets"></i> GESTIONNAIRE DE LA PHARMACIE</h2>
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
                        <a class="nav-link active" href="#product" data-toggle="tab"><i class="fas fa-tablets"></i> Produits</a></li>
                    <li class="nav-item">
                        <a class="nav-link " href="#personnel" data-toggle="tab">
                            <i class="fas fa-tablets"></i> Consommation journalière
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#entrees" data-toggle="tab">
                            <i class="far fa-copy"></i> Requisition
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#stock" data-toggle="tab">
                        <i class="fas fa-tablets"></i> Situation en stock</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#sortie" data-toggle="tab">
                        <i class="fas fa-tablets"></i> Sortie par service</a>
                    </li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                        <div class=" tab-pane active" id="product">
                            @livewire('pharmacie.produits.produit-pharmacie-component')
                        </div>
                         <!-- /.tab-pane -->
                         <div class="tab-pane " id="personnel">
                            @livewire('rapport.consommation-pharma-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="entrees">
                            @livewire('pharmacie.entrees.entrees-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="stock">
                            @livewire('produit.situation-pharma-stock-product')
                        </div>
                        <div class="tab-pane" id="sortie">
                            @livewire('pharmacie.sorties.sortie-component')
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
