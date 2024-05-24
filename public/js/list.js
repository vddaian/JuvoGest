function changeToUpdateForm(idRecurso, idSala, nombre, tipo) {
    if ($('#updateForm').attr('hidden')) {
        $('#updateForm').prop("hidden", false);
        $('#createForm').prop("hidden", true);
    }
    $('#upRecurso').val(idRecurso);
    $('#upSala').val(idSala);
    $('#upNombre').val(nombre);
    $('#upTipo').val(tipo);
}

function changeToCreateForm() {
    if ($('#createForm').attr('hidden')) {
        $('#createForm').prop("hidden", false);
        $('#updateForm').prop("hidden", true);
    }
}