
$(document).ready(function(argument) 
{
    $(".btn-print").printPage();

    $('button.delete-produk').on('click', function() 
    {
        var ID = $(this).data('id');

        $('div#modal-delete').modal('show');

        $('a#btn-delete').on('click', function() {
            window.location.href = base_domain + '/product/delete/' + ID;
        })
    })
})