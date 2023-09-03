<x-app-layout>
<div>
    <!-- Main content -->
<section class="content">
    <div class="error-page mt-4">
      <h2 class="headline text-danger mt-4"> 404</h2>

      <div class="error-content">
        <h3 class="mt-4"><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page introuvable.</h3>

        <p class="mt-4">
         La page que vous essayez de charger n'existe pas SVP !
         Pour retourner cliquer <a href="{{ route('dashboard') }}">ici</a> Ou bien contacter l'Admin.
        </p>


      </div>
      <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
  <!-- /.content -->
</div>
</x-app-layout>
