<div>
    <x-loading-indicator />
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">DETAILS PATIENTS</h3>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-controls">
                <div class="d-flex justify-content-between p-2">
                    <div>
                        <div><span class="text-bold">N° Facture:</span> {{$facture->numero}}</div>
                        <div><span class="text-bold">Noms:</span> {{$facture->name}}</div>
                        <div><span class="text-bold">Type:</span> <span class="text-danger">{{$facture->type}}</span></div>
                    </div>
                    <div>

                    </div>
                    <div>
                        <div><span class="text-bold">Emise le:</span> {{(new DateTime($facture->created_at))->format('d/m/Y')}}</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (Auth::user()->role=='pharma')
                            <button data-toggle="modal" data-target="#productModal" class="btn btn-danger" type="button">Prescription</button>
                        @elseif (Auth::user()->role=='radio')
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                        @elseif (Auth::user()->is_to="Ville")
                            <button data-toggle="modal" data-target="#ActesModal" class="btn btn-danger" type="button" >Actes</button>
                            <button data-toggle="modal" data-target="#detailLaboModal" class="btn btn-dark" type="button">Examen labo</button>
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                            <button data-toggle="modal" data-target="#detailEchoModal" class="btn btn-success" type="button">Echographie</button>
                            <button data-toggle="modal" data-target="#sejourModal" class="btn btn-secondary" type="button">Sejour</button>
                            <button data-toggle="modal" data-target="#productModal" class="btn btn-danger" type="button">Prescription</button>
                            <button data-toggle="modal" data-target="#detailAutresModal" class="btn btn-primary" type="button">Autres</button>
                            <button data-toggle="modal" data-target="#nursingModal" class="btn btn-warning" type="button">Nursing</button>

                        @else
                        <button data-toggle="modal" data-target="#ActesModal" class="btn btn-danger" type="button" >Actes</button>
                            <button data-toggle="modal" data-target="#detailLaboModal" class="btn btn-dark" type="button">Examen labo</button>
                            <button data-toggle="modal" data-target="#detailRadioModal" class="btn btn-info" type="button">Examen radio</button>
                            <button data-toggle="modal" data-target="#detailEchoModal" class="btn btn-success" type="button">Echographie</button>
                            <button data-toggle="modal" data-target="#sejourModal" class="btn btn-secondary" type="button">Sejour</button>
                            <button data-toggle="modal" data-target="#detailAutresModal" class="btn btn-primary" type="button">Autres</button>
                            <button data-toggle="modal" data-target="#nursingModal" class="btn btn-warning" type="button">Nursing</button>

                        @endif
                    </div>
                </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
      </div>
      @include('livewire.facturation.modals.examen-labo')
      @include('livewire.facturation.modals.exemen-radio')
      @include('livewire.facturation.modals.echographie')
      @include('livewire.facturation.modals.sejour')
      @include('livewire.facturation.modals.products')
      @include('livewire.facturation.modals.autres')
      @include('livewire.facturation.modals.nursing')
      @include('livewire.facturation.modals.medication-service')
      @include('livewire.facturation.modals.actes')
</div>
