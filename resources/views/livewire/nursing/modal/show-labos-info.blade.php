<!-- Modal -->
<div wire:ignore.self class="modal fade" id="swoLaboInfos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>LISTE DES EXAMENS</strong></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            @if ($demade_select==null)

            @else
            <table class="table table-light table-sm mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th>Examen</th>
                        <th class="text-center">
                            RESULTAT
                        </th>
                        <th class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demade_select->examenLabos as $labo)
                        <tr>
                            <td>
                                @if ($labo->abreviation==null)
                                    {{$labo->name}}
                                @else
                                    {{$labo->abreviation}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($idLaboSelect!=$labo->id)
                                    <span>{{$labo->getResult($labo->id,$demade_select->id)}}</span>
                                @else
                                    @if ($labo->getResult($labo->id,$demade_select->id)=="Aucun")
                                    <div class="form-group">
                                        <input placeholder="Entrez le resultat ici...." wire:model.defer='result' class="form-control" type="text"
                                            wire:keydown.enter='saveResult({{$labo->id}})'>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <input placeholder="Entrez le resultat ici...." wire:model.defer='result' class="form-control" type="text"
                                            wire:keydown.enter='updateResult()'>
                                    </div>
                                    @endif

                                @endif

                            </td>
                            <td class="text-right">
                                @if ($labo->getResult($labo->id,$demade_select->id)=="Aucun")
                                <button class="btn btn-primary btn-sm" wire:click='activeWriter({{$labo->id}})'
                                     type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                @else
                                <button class="btn btn-danger btn-sm" wire:click='editResult({{$labo->id}})'
                                     type="button"><i class="fas fa-edit    "></i></button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            @endif

        </div>
      </div>
    </div>
</div>

