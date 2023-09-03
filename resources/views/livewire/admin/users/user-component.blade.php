<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title">LISTE DES UTILISATEUR</h3>
          <div class="card-tools">
            <button class="btn btn-tool btn-sm" data-toggle='modal' data-target='#addNewUserModal' type="button">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </button>
            <button class="btn btn-tool btn-sm" type="button" wire:click='$refresh'>
                <i class="fas fa-sync-alt"></i>
            </button>

          </div>
        </div>
        <div class="card-body table-responsive p-0">
            <div class="d-flex justify-content-center">
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                      <input wire:model.debounce.500ms='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                      <div class="input-group-append">
                        <div class="btn btn-primary">
                          <i class="fas fa-search"></i>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          <table class="table table-striped table-sm table-valign-middle">
            <thead>
            <tr>
              <th>NOM UTILISATEUR</th>
              <th class="text-left">PSEUDO</th>
              <th>EMAIL</th>
              <th>ROLE</th>
              <th>STATUS</th>
              <th class="text-center">ACTION</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                     @if ($user->avatar != null)
                     <img src="{{Storage::url(Auth::user()->avatar)}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                     @else
                     <img src="{{ asset('default-user.jpg') }}" alt="Product 1" class="img-circle img-size-32 mr-2">
                     @endif
                        {{$user->name}}
                    </td>
                    <td class="text-left">
                        @if ($user->pseudo==null)
                            <span class="text-danger">nome</span>
                        @else
                            {{$user->pseudo}}
                        @endif
                    </td>
                    <td>
                        {{$user->email}}
                    </td>

                    <td>
                      {{$user->role->name}}
                    </td>
                    <td>
                        @if ($user->is_activate==false)
                            <span class="text-danger">Non actif</span>
                        @else
                            <span class="text-success">Actif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <a class="btn btn-link text-bold text-dark"
                                 href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li>
                                    <a style="cursor: pointer" data-toggle="modal"
                                     data-target="#editUserModal" class="dropdown-item"
                                     wire:click='show({{$user->id}})'>
                                        <i class="fas fa-user-edit"></i> Editer
                                    </a>
                                </li>
                                <li>
                                    @if ($user->is_activate==false)
                                        <a class="dropdown-item" style="cursor: pointer" wire:click='activeUuser({{$user->id}})'>
                                            <i class="fa fa-check" aria-hidden="true"></i> Activer
                                        </a>
                                    @else
                                        <a class="dropdown-item" style="cursor: pointer" wire:click='unActiveUuser({{$user->id}})'>
                                            <i class="far fa-times-circle"></i> Desactiver
                                        </a>
                                    @endif
                                </li>
                                <li>
                                    <a style="cursor: pointer" 
                                    class="dropdown-item" wire:click='upadatePassword({{$user}})'>
                                        <i class="fas fa-key"></i> Réinitialiser mot de passe
                                    </a>
                                </li>
                            </ul>
                          </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          <div class="p-2 mt-4 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-4') }}
          </div>
        </div>
      </div>

      @include('livewire.admin.users.add-new-user')
      @include('livewire.admin.users.edit-user')
        @include('livewire.admin.users.password-management')
</div>
