<div>
    <div wire:ignore.self class="modal fade" id="detailLaboModal">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-dark">
              <h4 class="modal-title"> <i class="fa fa-microscope" aria-hidden="true"></i> DETAIL EXAMENS LABORATOIRE</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if (session('erreurs'))
                    <div class="alert alert-light">
                        <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> {{ session('erreurs') }}</span>
                    </div>
                @elseif(session('msg'))
                    <div class="alert alert-light">
                        <span class="text-success"><i class="fa fa-check-circle"></i> {{ session('msg') }}</span>
                    </div>
                @endif
                <div class="p-3">
                    <div class="row">
                        @foreach ($labos as $labo)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" value="{{ $labo->id }}" wire:model.defer="itemLabo" type="checkbox" >
                                        <label class="form-check-label">
                                            @if ($labo->abreviation=="Aucune")
                                                {{ $labo->name }}
                                            @else
                                                {{ $labo->abreviation }}
                                            @endif
                                        </label>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-dark mt-2" type="button"  wire:click="addLaboDtail()">
                        Ajouter à la consultation
                    </button>
                </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</div>
