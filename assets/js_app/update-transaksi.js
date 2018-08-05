$(document).ready(function() 
{

    $('#dibayar, input[name="amount"]').maskMoney({prefix:'', allowNegative: false, thousands:',', affixesStay: false,  precision:0});

    var table, table2;

	table = $('#table-update-transaction').DataTable({ 
    	"processing": true,
    	"scrollCollapse": true,
    	"paging": true,
    	"ordering": false,
    	"info":     false,
    	"bInfo": false,
    	"bLengthChange": false,
    	"searching": false,
    	"responsive": true,
    	"ajax": {
        	"url": base_domain + "/data_transaksi/getdataupdate/" + $('#table-update-transaction').data('id'),
    	},
	});

	table2 = $('#table_ajax_product').DataTable( {
    	"info": false,
    	"processing": true,             
    	"ordering": false,
    	"ajax": base_domain + "/product/data_list",
	});

	window.batal_beli = function() 
	{
		$('#order_quantity').modal('hide');
	    
	    $('#modal-hapus').modal('hide');
	    
	    $('#modal-edit').modal('hide');
	    
	    $('#modal-trans').modal('hide');
	    
	    $('#search_product').modal('hide');
		
		document.getElementById('form_order').reset();
		
		document.getElementById('kode_barang').focus();
	}

	window.add_cart_cari = function(id) 
	{
		$.get(base_domain + '/transaksi/get_data/' + id, function(obj) 
		{
			if ( obj.status) 
			{
	        	var kode_barang = $('#kode_barang').val(id);
	        	$('#order_quantity').modal('show');
	        	$('#modal-trans').modal('hide');
	        	$('#search_product').modal('hide');
	        	$('#result').html(
	            	'<td>' + obj.result.ID_product + '</td>' + 
	            	'<td>' + obj.result.product_name + '</td>' + 
	            	'<td>' + obj.result.stock + '</td>' + 
	            	'<td>' + obj.result.unit + '</td>' +
	            	'<td>' + obj.result.general_price + '</td>' + 
	            	'<td>' + obj.result.seller_price + '</td>' 
	        	);

	        	$('#qty').focus();
			} else {
	        	$('#modal-trans').modal('show');
	        	$('#trans-title').html('Maaf! Data tidak tersedia.');
	        	$('#trans-content').html('Mohon lakukan pengentrian data produk yang belum tersedia.')
	        	$('#order_quantity').modal('hide');
			}
		});
	}

	$('#masukkan').click( function () 
	{
	    var kode_barang = $('#kode_barang').val();
	    $('#form-qty').attr('onsubmit', add_cart(kode_barang));
	    return false;
	});

	$('#kode_barang').on('change keyup', function() 
	{
		if ($(this).val().length > 5) 
		{ 
			$.get(base_domain + '/transaksi/get_data/' + $(this).val(), function(obj) 
			{
				if ( obj.status == true ) 
				{
	            	$('#order_quantity').modal('show');
	                  	$('#modal-trans').modal('hide');
	            	$('#result').html(
	            		'<td>' + obj.result.ID_product + '</td>' + 
	            		'<td>' + obj.result.product_name + '</td>' + 
	            		'<td>' + obj.result.stock + '</td>' + 
	            		'<td>' + obj.result.unit + '</td>' +
	            		'<td>' + obj.result.general_price + '</td>' + 
	            		'<td>' + obj.result.seller_price + '</td>' 
	            	);

	        		if (obj.result.stock==0) 
	        		{
	            		$('#message').html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-warning"></i> Stock tidak tersedia').addClass('alert-warning').slideUp(5000, function() {});
	        		}
	  				$('#qty').focus();
				} else {
	        		$('#modal-trans').modal('show');
	        		$('#trans-title').html('Maaf! Data tidak tersedia.');
	        		$('#trans-content').html('Mohon lakukan pengentrian data produk yang belum tersedia.')
	        		$('#order_quantity').modal('hide');
	   			}
			});
		};
	});

    window.reload_table = function ()
    {
        table.ajax.reload(); 
        table2.ajax.reload(); 

	    $.ajax({
	     	url: base_domain + '/data_transaksi/hitung/' + ($('#dibayar').val().replace(/[^\d]/g,'')),
	     	method:'POST',
	     	data: {
	      		transaksi:$('#table-update-transaction').data('id')
	     	}, 
	     	beforeSend: function () {
	      		$('#kembali').html('<i class="fa fa-spinner fa-spin"></i> Sedang menghitung..');
	     	},
	     	success: function(obj) {
	         	if ( obj.status == true ) {
	          		$('#kembali').html('Rp. '+obj.kembali);
	          		return false;
	         	} else {
	                $('#kembali').html("Uang kurang Rp. " + obj.kurang);
	            }
	     	}
	 	});
    }
    
    window.reload_total = function () {
        $.ajax({
            url : base_domain + "/data_transaksi/get_total/",
            type: "POST",
            data: {
            	transaksi : $('#table-update-transaction').data('id')
            },
            success: function(data)
            {
                $('#total-atas').html(data.total);
                $('#total-bawah').html(data.total);
            },
            error: function (jqXHR, textStatus, errorThrown) { alert('Gagal!'); }
        });
    }
    
    window.audio = function() {
        var audio = document.getElementById("audio");
        audio.play();
    }

    $.ajax({
        url : base_domain + "/data_transaksi/get_total/",
        type: "POST",
        data: {
         transaksi : $('#table-update-transaction').data('id')
        },
        success: function(data)
        {
            $('#total-atas').html(data.total);
            $('#total-bawah').html(data.total);
        },
        error: function (jqXHR, textStatus, errorThrown) { alert('Gagal!'); }
    });


	$('#dibayar').on('change keyup', function()
	{
	    if ($(this).val().length >= 4) 
	    { 
	        $.ajax({
	        	url: base_domain + '/data_transaksi/hitung/' + ($(this).val().replace(/[^\d]/g,'')),
	        	method:'POST',
	        	data: {
	        		transaksi:$('#table-update-transaction').data('id')
	        	}, 
	        	beforeSend: function () {
	        		$('#kembali').html('<i class="fa fa-spinner fa-spin"></i> Sedang menghitung..');
	        	},
	        	success: function(obj) {
	            	if ( obj.status == true ) {
	            		$('#kembali').html('Rp. '+obj.kembali);
	            		return false;
	            	} else {
	                    $('#kembali').html("Uang tidak mencukupi!");
	                }
	        	}
	    	});
		}
	});
});

	function add_cart(id) 
	{
	    $.ajax({
	        url: base_domain + '/transaksi/get_data/' + id,
	        cache:false, 
	        success: function(obj) 
	        {
	            if (obj.status)  lanjutkan(id);
	        }
	    });
	}

	function lanjutkan(id) 
	{
	    var form_asal  = $("#form-qty");
	    var form    = getFormData(form_asal);

	    $.ajax({
	        url: base_domain + '/data_transaksi/addedcart/' + id + '?selling_type=' + $('#table-update-transaction').data('selling'), 
	        type:'POST',
	        data: form,
	        dataType:'json',
	        success: function(ok) {
	            if ( ok.status) {
	                reload_table();
	                reload_total();
	                audio();
	                $('#order_quantity').modal('hide');
	                document.getElementById('form_order').reset();
	                document.getElementById('kode_barang').focus();
	            } else {
	                $('#modal-trans').modal('show');
	                $('#trans-content').html(ok.message);  
	            } 
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            document.getElementById('form-qty').reset();
	        }
	    });  
	    return false;
	}

function delete_cart(id,id_barang) 
{
    $.ajax({
        url: base_domain + '/data_transaksi/get_cart/' + id, 
        success: function(obj) {
            if ( obj.status == true ) {
                $('#modal-hapus').modal('show');
                $('#data-cart').html(
                    '<td>' + obj.result.ID_product + '</td>' + 
                    '<td>' + obj.result.product_name + '</td>' + 
                    '<td>' + obj.result.qty + '</td>' + 
                    '<td>' + obj.result.unit + '</td>' +
                    '<td>Rp. ' + obj.result.price + '</td>' + 
                    '<td>Rp. ' + obj.result.total + '</td>'
                );
            }
        }
    });
    $('#btn').html('<button type="button" id="iya_hapus" class="btn btn-danger">Iya Hapus</button>');
    $('#iya_hapus').click(function () {
        $.ajax({
            type :'POST',
            url  : base_domain + '/data_transaksi/delete_item/' + id,
            success: function (msg) {
                $('#modal-hapus').modal('hide');
                reload_table();
                reload_total();
                audio();
                document.getElementById('form_order').reset();
                 document.getElementById('kode_barang').focus();
            }
        });
    });
}

function update_cart(id) 
{
    $.ajax({
        url: base_domain + '/data_transaksi/get_cart/' + id + '/code', 
        success: function(obj) {
            if ( obj.status == true ) {
                $('#modal-edit').modal('show');
                $('#get-cart').html(
                    '<td>' + obj.result.ID_product + '</td>' + 
                    '<td>' + obj.result.product_name + '</td>' + 
                    '<td>' + obj.result.qty + '</td>' + 
                    '<td>' + obj.result.unit + '</td>' +
                    '<td>Rp. ' + obj.result.price + '</td>' + 
                    '<td>Rp. ' + obj.result.total + '</td>'
                );
                $('#qty-edit').val(obj.result.qty);
            }
        }
    });
    $('#iya_edit').click( function () {
        var form_asal  = $("#form-edit");
        var form    = getFormData(form_asal);
        $.ajax({
            url: base_domain + '/data_transaksi/updatecart/' + id + '?selling_type=' + $('#table-update-transaction').data('selling'), 
            type:'POST',
            data: form,
            dataType:'json',
            success: function(obj) 
            {
            	if ( obj.status) {
                    reload_table();
                    reload_total();
                    audio();
                    $('#modal-edit').modal('hide');
                    document.getElementById('form_order').reset();
                    document.getElementById('kode_barang').focus();
                } else {
                    $('#modal-edit').modal('hide');
                    $('#modal-trans').modal('show');
                    $('#trans-content').html(obj.message); 
                } 
            }
        }); 
        return false;
    });
}

