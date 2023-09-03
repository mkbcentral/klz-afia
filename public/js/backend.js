/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/backend.js ***!
  \*********************************/
window.$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true
  };
  window.addEventListener('data-added', function (event) {
    toastr.success(event.detail.message, 'Validation');
    $('#addNewUserModal').modal('hide');
    $('#addNewResultatModal').modal('hide');
    $('#AddPatientPriveModal').modal('hide');
    $('#addAyantDroitModal').modal('hide');
    $('#AddPatientAbonneModal').modal('hide');
    $('#addPatientForfait').modal('hide');
    $('#addInFamilyModal').modal('hide');
    $('#DmdPriveConsDModal').modal('hide');
    $('#DmdConsDModal').modal('hide');
    $('#addAyantDroitModal').modal('hide');
    $('#addInFamilyModal').modal('hide');
    $('#addPatientForfait').modal('hide');
    $('#addDemandeModal').modal('hide');
    $('#sejourModal').modal('hide');
    $('#detailEchoModal').modal('hide');
    $('#detailLaboModal').modal('hide');
    $('#detailRadioModal').modal('hide');
    $('#nursingModal').modal('hide');
    $('#productModal').modal('hide');
    $('#sejourModal').modal('hide');
    $('#detailAutresModal').modal('hide');
    $('#EditNumAndDateModalAbn').modal('hide');
    $('#EditNumAndDateModal').modal('hide');
    $('#sortieModal').modal('hide');
    $('#entreModal').modal('hide');
    $('#addNewModal').modal('hide');
    $('#showUpdateProductModal').modal('hide');
    $('#showOrderProductModal').modal('hide');
    $('#newFactureModal').modal('hide');
    $('#showOrderProductModal').modal('hide');
    $('#ActesModal').modal('hide');
  });
  window.addEventListener('data-add-faild', function (event) {
    toastr.error(event.detail.message, 'Validation');
    $('#DmdPriveConsDModal').modal('hide');
    $('#DmdConsDModal').modal('hide');
  });
  window.addEventListener('data-updated', function (event) {
    toastr.success(event.detail.message, 'Validation');
    $('#editUserModal').modal('hide');
    $('#editResultatModal').modal('hide');
    $('#EditPatientPriveModal').modal('hide');
    $('#EditPatientAbonneModal').modal('hide');
    $('#EditAyantDroitModal').modal('hide');
    $('#updateModal').modal('hide');
    $('#updatPersonnelInfoeModal').modal('hide');
    $('#updatePriveModal').modal('hide');
    $('#editFactureModal').modal('hide');
    $('#editNumAndDateModalPv').modal('hide');
    $('#editPatientForfait').modal('hide');
    $('#editDemandeSpecialModdal').modal('hide');
  });
  window.addEventListener('data-deleted', function (event) {
    toastr.info(event.detail.message, 'Validation');
  });
});
/******/ })()
;