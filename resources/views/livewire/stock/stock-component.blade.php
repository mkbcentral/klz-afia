<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h2 class="m-0 text-danger"><i class="fas fa-tablets"></i> GESTIONNAIRE DE STOICK</h2>
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
                    <li class="nav-item"><a class="nav-link  " href="#product" data-toggle="tab"><i class="fas fa-tablets"></i> Stock central</a></li>
                    <li class="nav-item"><a class="nav-link" href="#achat" data-toggle="tab">
                        <i class="far fa-copy"></i> Achats stock</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="#cons" data-toggle="tab">
                        <i class="far fa-copy"></i> Consommation service</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#service" data-toggle="tab">
                        <i class="far fa-copy"></i> Requisition service</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#cons" data-toggle="tab">
                        <i class="far fa-copy"></i> Consommation service</a>
                    </li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                        <div class=" tab-pane " id="product">
                            @livewire('stock.stock-products-component')
                        </div>
                        <div class="tab-pane active" id="cons">
                            @livewire('consommation.product.consommation-product-component')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="achat">
                            @livewire('stock.achat-component')
                        </div>
                        <div class="tab-pane" id="service">
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
