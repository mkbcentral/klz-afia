<x-guest-layout>
    <div class="login-box">
        <!-- /.login-logo -->
        @if (session('status'))
            <div class="alert alert-danger" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>AFia</b>Sys</a>
        </div>
        <div class="card-body">
          
            <div class="text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="40px">
            </div>
            <p class="login-box-msg">Connexion</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Adresse mail"
                            name="email" :value="old('email')" required autofocus>
                <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Mot de passe"
                        name="password" required autocomplete="current-password">
                <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </div>
                <!-- /.col -->
            </div>
            </form>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-guest-layout>
