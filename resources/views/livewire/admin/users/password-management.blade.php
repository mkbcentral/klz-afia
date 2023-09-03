<div wire:ignore.self id="passwordModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">GESTION DU MOT PASSE</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                   <label for="my-input">Mot de passe</label>
                    <textarea class="form-control"  id="" cols="30" rows="2" wire:model.defer='password_show'></textarea>
               </div>
               <div class="form-group">
                   <label for="my-input" class="text-danger">Resultat: {{$password_result}}</label>

               </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="button" wire:click='unCriptPassword'>Decripter</button>
            </div>
        </div>
    </div>
</div>
