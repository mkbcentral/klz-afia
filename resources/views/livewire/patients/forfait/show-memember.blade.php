<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showMemberModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><strong>LISTE MEMEBRE DE LA FAMILLE</strong></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($members_family==null)
            @else
                <div class="card">
                    <div class="card-body">
                        <div><strong>Famille</strong>: {{$members_family->name}}</div>
                        <div><strong>Nombre</strong>: {{$members_family->membres->count()}}</div>
                        <div><strong>Nombre</strong>: {{$members_family->society->name}}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                              <tr>
                                <th scope="col">NOMS COMPLE</th>
                                <th scope="col">DATE DE NAISSANCE</th>
                                <th scope="col">TYPE</th>
                                <th scope="col" class="text-center">ACTIONS</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($members_family->membres as $index => $member)
                                    <tr>
                                        <td>
                                            @if ($member_data_id !== $member->id)
                                                <i class="fas fa-user text-danger"></i>
                                                {{$member->noms}}
                                            @else
                                                <input wire:model.defer='member_name_to_edit' wire:keydown.enter='updateMember({{$members_family->id}})' class="form-control" type="text" name="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($member_data_id !== $member->id)
                                                {{$member->date_naissance}}
                                            @else
                                                <input wire:model.defer='member_date_naiss_to_edit' class="form-control" type="text" name="">
                                            @endif
                                        </td>
                                        <td>

                                            @if ($member_data_id !== $member->id)
                                                {{$member->type}}
                                            @else
                                                <input wire:keydown.enter='updateMember({{$members_family->id}})' wire:model.defer='member_type_to_edit' class="form-control" type="text" name="">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($member_data_id !== $member->id)
                                                <button wire:click='getMemeberData({{$member->id}})' class="btn btn-light btn-sm" type="button">
                                                    <i class="fas fa-pen text-info"></i>
                                                </button>
                                            @else
                                                <button wire:click='getMemeberData({{$member->id}})' class="btn btn-light btn-sm" type="button">
                                                   <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                </button>
                                            @endif

                                            <button wire:click='showDestroyMemberDialog({{$member->id}})' class="btn btn-light btn-sm" type="button">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                             </button>

                                        </td>
                                  </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
            @endif
        </div>
      </div>
    </div>
</div>
