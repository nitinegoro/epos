
$(document).ready(function(argument) 
{
    $(".btn-print").printPage();

    $('button.delete-transaksi').on('click', function() 
    {
        var ID = $(this).data('id');

        $('div#modal-delete').modal('show');

        $('a#btn-delete').on('click', function() {
            window.location.href = base_domain + '/data_transaksi/delete_transaksi/' + ID;
        })
    });

	$('#tgl-dari').daterangepicker({
		singleDatePicker: true,
		format:'YYYY-MM-DD', 
	});
	$('#tgl-sampai').daterangepicker({
		singleDatePicker: true,
		format:'YYYY-MM-DD', 
	});
})