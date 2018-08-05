$(document).ready(function() {
    $('button.delete-user').on('click', function() 
    {
        var ID = $(this).data('id');

        $('div#modal-delete').modal('show');

        $('a#btn-delete').on('click', function() {
            window.location.href = base_domain + '/users/delete/' + ID;
        })
    });
});
