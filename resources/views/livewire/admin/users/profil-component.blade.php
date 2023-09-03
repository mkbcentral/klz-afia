<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger">  <i class="fas fa-users-cog"></i>MOM PROFIL UTILISATEUR</h1>
            </div>
        </div>
        </div>
    </div>
     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user shadow">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{Auth::user()->name}}</h3>
                    <h5 class="widget-user-desc">{{Auth::user()->role->name}}</h5>
                  </div>
                  <div class="widget-user-image">
                    @if (Auth::user()->avatar!=null)
                        <img class="img-circle elevation-2" src="{{Storage::url(Auth::user()->avatar)}}" alt="User Avatar">
                    @else
                        <img class="img-circle elevation-2" src="{{ asset('default-user.jpg') }}" alt="User Avatar">
                    @endif
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-6 border-right">
                        <div class="description-block">
                          <h5 class="description-header">0</h5>
                          <span class="description-text">Demandes</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6 border-right">
                        <div class="description-block">
                          <h5 class="description-header">0</h5>
                          <span class="description-text">Factures</span>
                        </div>
                        <!-- /.description-block -->
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                </div>
                <!-- /.widget-user -->
              </div>
              <!-- /.col -->
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li wire:ignore.self class="nav-item">
                        <a wire:ignore.self class="nav-link active" href="#infos" data-toggle="tab">
                            <i class="fas fa-user-alt"></i> Changer des infos
                        </a>
                    </li>
                    <li  class="nav-item">
                        <a wire:ignore.self class="nav-link" href="#password" data-toggle="tab">
                            <i class="fas fa-key"></i> Changer mot de passe
                        </a>
                    </li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div wire:ignore.self class="active tab-pane" id="infos">
                       <div >
                            <div>
                                <div class="form-group">
                                    <label>Nom de l'utilisateur</label>
                                    <input class="form-control" type="text" wire:model.defer="name">
                                    @error('name')
                                        <span class="error text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Pseudo</label>
                                    <input class="form-control" type="text" wire:model.defer="pseudo">
                                    @error('pseudo')
                                        <span class="error text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                   @if ($avatar)
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" style="width: 100px" src="{{ $avatar->temporaryUrl() }}" alt="User Avatar">
                                    </div>
                                   @endif
                                </div>
                                <div class="form-group mt-2">
                                    <label for="formFile" class="form-label">Chaoisir une phaoto</label>
                                    <input class="form-control" type="file" wire:model.defer='avatar'>
                                  </div>
                                @error('avatar') <span class="error">{{ $message }}</span> @enderror
                                <div class="d-flex justify-content-end">
                                    <button wire:click='update' class="btn btn-info" type="button">Changer</button>
                                </div>
                            </div>
                       </div>
                    </div>

                    <div wire:ignore.self class="tab-pane" id="password">
                        <div >
                             <div>
                                @if (session()->has('message'))
                                    <div class="alert alert-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ session('message') }}
                                    </div>
                                @endif
                                 <div class="form-group">
                                     <label >Ancien mot de passe</label>
                                     <input class="form-control" type="password" wire:model.defer="old_password">
                                     @error('old_password')
                                        <span class="error text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}
                                        </span>
                                    @enderror
                                 </div>
                                 <div class="form-group">
                                     <label >Nouveau mot de passe</label>
                                     <input class="form-control" type="password" wire:model.defer="password">
                                     @error('password')
                                        <span class="error text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}
                                        </span>
                                    @enderror
                                 </div>
                                 <div class="form-group">
                                    <label >Confirmer mot de passe</label>
                                    <input class="form-control" type="password" wire:model.defer="password_confirm">
                                    @error('password_confirm')
                                        <span class="error text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                 <div class="d-flex justify-content-end">
                                     <button class="btn btn-info" type="button" wire:click='updatePassword'>Changer</button>
                                 </div>
                             </div>
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
