$('#tgl-dari').daterangepicker({
	singleDatePicker: true,
	format:'YYYY-MM-DD', 
});
$('#tgl-sampai').daterangepicker({
	singleDatePicker: true,
	format:'YYYY-MM-DD', 
});

$("#sel_category").select2();
$("#sel_supplier").select2();

// DASHBOARD
$(document).ready(function() {

});



// Menghapus Data Transaksi
function delete_dtrans(id) {
    $('#modal-del_trans').modal('show');
    $('#hapus-del_trans').click( function () {
        $.ajax({
            type: 'GET',
            url: base_domain + '/data_transaksi/delete_transaksi/' + id,
            success: function(data) {
               if (data.status) {
                    /*$('#modal-del_trans').modal('hide');
                    $('#record-' + id).remove();
                    $('#record2-' + id).remove();*/
                    window.location = base_domain + '/data_transaksi';
               } else {
                    $.notify("Gagal!\nmenghapus "+content, "error");
               }
            }
        });
    });
    return false;
}
