$(document).ready(function () {
    $('#dtDynamicVerticalScrollExample').DataTable({
        "scrollY": "5vh",
        "scrollCollapse": true,
    });
    $('.dataTables_length').addClass('bs-select');
});
