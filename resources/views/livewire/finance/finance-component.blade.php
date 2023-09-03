<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger">  <i class="fas fa-users-cog"></i>GESTIONNAIRE DES FINACES</h1>
            </div>
        </div>
        </div>
    </div>
     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li wire:ignore.self class="nav-item">
                        <a wire:ignore.self class="nav-link active" href="#infos" data-toggle="tab">
                            <i class="fas fa-user-alt"></i> Recettes journalières
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a wire:ignore.self class="nav-link" href="#password" data-toggle="tab">
                            <i class="fas fa-key"></i> Recttes mensuelles
                        </a>
                    </li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div wire:ignore.self class="active tab-pane" id="infos">
                        @livewire('finance.recettes-journalieres-component')
                    </div>

                    <div wire:ignore.self class="tab-pane" id="password">
                        <div >
                            Abn
                        </div>
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
