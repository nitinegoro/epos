var tb_ds;
var data_supplier;
$(document).ready(function() {
    //datatables
    data_supplier = $('#tb_ds').data('id'); //tb.getAttribute('data-id'); jika tidak berfungsi
    //console.log(data_supplier); // Cek ID_supplier
    tb_ds = $('#tb_ds').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "scrollCollapse": true,
        "paging":         true,
        "ordering": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_domain + "/supplier/get_product/" + data_supplier,
        },
    });
    tb_all_p = $('#tb_all_p').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "scrollCollapse": true,
        "paging":         true,
        "ordering": false,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_domain + "/supplier/all_product/" + data_supplier,
        },
    });
});

function reload_tb_ds() {
    tb_ds.ajax.reload();
}

/* add product supplier*/
function add_product_supplier(id_product, id_supplier) {
    $.ajax({
        url: base_domain + '/supplier/add_product/' + id_product + '/' + id_supplier, 
        type:'POST',
        dataType:'json',
        success: function(ok) {
            if ( ok.status) {
                reload_tb_ds();
                $('#modal-data_product').modal('hide');
            } else {
                 $.notify("Gagal!\nmenambahkan produk.", "error");
                 $('#modal-data_product').modal('hide');
            } 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $.notify("Gagal!\nmenambahkan produk.", "error");
            $('#modal-data_product').modal('hide');
        }
    });
    return false;
}
/* de product supplier */
function del_product_supplier(id_product,name) {
    $('#modal-del_product').modal('show');
    $('#content-delete').html(name);
    $('#hapus-product_supplier').click( function() {
        $.ajax({
            url: base_domain + '/supplier/del_product/' + id_product, 
            type:'POST',
            dataType:'json',
            success: function(ok) {
                if ( ok.status) {
                    reload_tb_ds();
                    $('#modal-del_product').modal('hide');
                } else {
                     $.notify("Gagal!\nmenghapus produk.", "error");
                     $('#modal-del_product').modal('hide');
                } 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $.notify("Gagal!\nmenghapus produk.", "error");
                $('#modal-del_product').modal('hide');
            }
        });  
    });
    return false;
}
/*Supplier Add*/
function add_supplier() {
	$('#supplier-add').modal('show');
	$('#form-add-supplier').formValidation({
	    fields: {
	        nama: {
	            validators: { notEmpty: { message: 'Mohon isi Nama Supplier.' } }
	        }, 
	        email: { 
	        	validators: { emailAddress: { message: 'Masukkan E-mail dengan benar.' }, }
	        },
	    }
	}).on('success.form.fv', function(e) {
         // Prevent form submission
        e.preventDefault();
        var form_asal  = $("#form-add-supplier");
        var form    = getFormData(form_asal);
        // Use Ajax to submit form data
        $.ajax({
            url: base_domain + '/supplier/insert_supplier',
            type: 'POST',
            data: form,
            success: function(obj) {
            	if ( obj.status == true) {
            		$('#supplier-add').modal('hide');
            		window.location = obj.ref;
            	} else {
            		$('#supplier-add').modal('hide');
            		$.notify("Gagal!\nmenambahkan Supplier Baru.", "error");
            	}
            }
        });
	});
}

/*Supplier Update*/
function update_supplier(id) {
	$('#supplier-update').modal('show');
    $.ajax({
        type :'GET',
        url  : base_domain + '/supplier/get/' + id,
        success: function (obj) {
            if(obj.status == true ) {
            	$('#name').val(obj.result.name);
            	$('#telp').val(obj.result.phone);
            	$('#email').val(obj.result.email);
            	$('#alamat').val(obj.result.address);
            } else {
                $('#supplier-update').modal('hide');
                $.notify("Maaf!!\nData Supplier tidak ditemukan.", "warm");
            }
        }
    });
	$('#form-update-supplier').formValidation({
	    fields: {
	        nama: {
	            validators: { notEmpty: { message: 'Mohon isi Nama Supplier.' } }
	        }, 
	        email: { 
	        	validators: { emailAddress: { message: 'Masukkan E-mail dengan benar.' }, }
	        },
	    }
	}).on('success.form.fv', function(e) {
         // Prevent form submission
        e.preventDefault();
        var form_asal  = $("#form-update-supplier");
        var form    = getFormData(form_asal);
        // Use Ajax to submit form data
        $.ajax({
            url: base_domain + '/supplier/update_supplier/' + id,
            type: 'POST',
            data: form,
            success: function(obj) {
            	if ( obj.status == true) {
            		$('#supplier-update').modal('hide');
            		window.location = obj.ref;
            	} else {
            		$('#supplier-update').modal('hide');
            		$.notify("Gagal!\nMengubah Data Supplier.", "error");
            	}
            }
        });
	});
}
/*Supplier Delete*/
function delete_supplier(id, content) {
	$('#modal-delete').modal('show');
	$('#content-delete').html( content );
	$('#hapus-supplier').click( function () {
        $.ajax({
            type :'GET',
            url  : base_domain + '/supplier/delete_supplier/' + id,
            success: function (msg) {
                if(msg.status == true ) {
                    $('#supplier-record-'+id).remove();
                    $('#modal-delete').modal('hide');
                    $.notify("Terhapus\n"+content, "success");
                } else {
                    $('#modal-delete').modal('hide');
                    $.notify("Gagal!\nmenghapus "+content, "error");
                }
            }
        });
	})
	return false;
}