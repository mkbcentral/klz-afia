<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h2 class="m-0 text-danger"><i class="fa fa-trash" aria-hidden="true"></i> MA CORBEILLE DES PRODUITS</h2>
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
                    <li class="nav-item"><a class="nav-link active" href="#product" data-toggle="tab"><i class="fas fa-tablets"></i> Produits</a></li>

                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                        <div class="active tab-pane" id="product">
                            @livewire('pharmacie.trash-product-component')
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
