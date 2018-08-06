    var table;
    $(document).ready(function() 
    {
        $('button#dialog-uang-masuk').on('click', function() 
        {
            $('input[name="mutation"]').val('masuk');

            $('span#laci-title').html('Uang Masuk');
               
            $('div#modal-form-laci').modal('show');
        
            $('#modal-select-laci').modal('hide');
        });

        $('button#dialog-uang-keluar').on('click', function() 
        {
            $('input[name="mutation"]').val('keluar');

            $('span#laci-title').html('Uang Keluar');
               
            $('div#modal-form-laci').modal('show');
        
            $('#modal-select-laci').modal('hide');
        });

        /* Insert Cash balance*/
        $('#form-cash_balance').submit(function( event ) {
            event.preventDefault();
            var form_asal  = $("#form-cash_balance");
            var form    = getFormData(form_asal);
            // Use Ajax to submit form data
            $.ajax({
                url: base_domain + '/transaksi/insert_cash_balance', 
                type:'POST',
                data: form,
                success: function(obj) {
                    if ( obj.status == true ) 
                    {
                         $.notify(obj.message, "info");

                         $('div#modal-form-laci').modal('hide');
                    } else {
                        $.notify(obj.message, "error");
                    } 
                    
                    $('#form-cash_balance').trigger("reset");
                }
            });
        });


        $(".btn-print").printPage();

        $('#dibayar, input[name="amount"]').maskMoney({prefix:'', allowNegative: false, thousands:',', affixesStay: false,  precision:0});

        $(".switch").bootstrapSwitch({
            onColor:'primary',
            offColor:'danger',
            onText:'Penjualan Umum',
            offText:'Penjualan Grosir',
            onSwitchChange:function(event, state) {
                if(state === false) {
                    $('input[name="selling_type"]').val('grosir');
                    $('input#selling_type1').val('grosir');
                } else {
                    $('input[name="selling_type"]').val('umum');
                    $('input#selling_type1').val('umum');
                }

                console.log( $('input[name="selling_type"]').val());
            }
        });

        //datatables
        table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "scrollCollapse": true,
            "paging":         true,
            "ordering": false,
            "info":     false,
            "bInfo": false,
            "bLengthChange": false,
            "searching": false,
            "responsive": true,
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_domain + "/transaksi/list_data",
            },
        });

        $('#table_ajax_product').DataTable( {
            "info":     false,
            "processing": true,             
            "ordering": false,
            "ajax": base_domain + "/product/data_list",
        } );
        //data total
        $.ajax({
            url : base_domain + "/transaksi/get_total/",
            type: "GET",
            success: function(data)
            {
                $('#total-atas').html(data.total);
                $('#total-bawah').html(data.total);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal!');
            }
        });

    });
    function reload_table()
    {
        table.ajax.reload(); //reload datatable ajax 
    }
    function reload_total() {
        //Ajax Load data from ajax
        $.ajax({
            url : base_domain + "/transaksi/get_total/",
            type: "GET",
            success: function(data)
            {
                $('#total-atas').html(data.total);
                $('#total-bawah').html(data.total);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal!');
            }
        });
    }
    function audio() {
        var audio = document.getElementById("audio");
        audio.play();
    }

$('#kode_barang').on('change', function() {
	if ($(this).val().length > 5) { 
        $.ajax({
        	url: base_domain + '/transaksi/get_data/' + $(this).val(), 
        	success: function(obj) {
            	if ( obj.status == true ) {
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

                    if (obj.result.stock==0) {
                        $('#message').html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-warning"></i> Stock tidak tersedia').addClass('alert-warning').slideUp(5000, function() {});
                    }
            		$('#qty').focus();
            	} else {
                    $('#modal-trans').modal('show');
                    $('#trans-title').html('Maaf! Data tidak tersedia.');
                    $('#trans-content').html('Mohon lakukan pengentrian data produk yang belum tersedia.')
                    $('#order_quantity').modal('hide');
                }
        	}
    	});
	};
});


function add_cart(id) {
    $.ajax({
        url: base_domain + '/transaksi/get_data/' + id,
        cache:false, 
        success: function(obj) {
            if (obj.status) {
                lanjutkan(id);
            }
        }
    });
}

function lanjutkan(id) {
    var form_asal  = $("#form-qty");
    var form    = getFormData(form_asal);
    $.ajax({
        url: base_domain + '/transaksi/add/' + id + '?selling_type=' + $(".switch").val(), 
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

function add_cart_cari(id) {
    $.ajax({
        url: base_domain + '/transaksi/get_data/' + id, 
        type:'GET',
        cache:false,
        success: function(obj) {
            if ( obj.status) {
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
        }
    });
}

$('#masukkan').click( function () {
    var kode_barang = $('#kode_barang').val();
    $('#form-qty').attr('onsubmit', add_cart(kode_barang));
    return false;
});

function batal_beli() {
	$('#order_quantity').modal('hide');
    $('#modal-hapus').modal('hide');
    $('#modal-edit').modal('hide');
    $('#modal-trans').modal('hide');
    $('#search_product').modal('hide');
	document.getElementById('form_order').reset();
	document.getElementById('kode_barang').focus();
}

function update_cart(id,id_barang) {
    $.ajax({
        url: base_domain + '/transaksi/get_cart/' + id, 
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
            url: base_domain + '/transaksi/update/' + id, 
            type:'POST',
            data: form,
            //dataType:'json',
            success: function(obj) {
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


$('#dibayar').on('change keyup', function()
{
    if ($(this).val().length >= 4) 
    { 
        $.ajax({
        	url: base_domain + '/transaksi/hitung/' + ($(this).val().replace(/[^\d]/g,'')), 
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


function delete_cart(id,id_barang) {
    $.ajax({
        url: base_domain + '/transaksi/get_cart/' + id, 
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
    $('#btn').html('<button type="button" id="iya_hapus" class="btn btn-danger">Iya</button>');
    $('#iya_hapus').click(function () {
        $.ajax({
            type :'POST',
            url  : base_domain + '/transaksi/delete/' + id,
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


function cari_product() {
   // $('#order_quantity').modal('show');
    return false;
}
/* Insert Transaction*/
$('#form-bayar').formValidation({
    fields: {
        bayar: {
            validators: { 
                decimalSeparator:',',
                thousandsSeparator: ',',
                notEmpty: { message: 'Harap isi terlebih dahulu kolom pada pembayaran untuk menyimpan transaksi dan mencetak stock.' },
            }
        },
    }
}).on('success.form.fv', function(e) {
    // Prevent form submission
    e.preventDefault();

    var form_asal  = $("#form-bayar");
    var form    = getFormData(form_asal);
    // Use Ajax to submit form data
    $.ajax({
        url: base_domain + '/transaksi/insert_transaction/', 
        type:'POST',
        data: form,
        success: function(obj) {
            if ( obj.status == true ) {
                // popup(obj.ref);
                newwindow=window.open(obj.ref,'name','height=600,width=800');
                if (window.focus) {
                   // newwindow.focus();
                    newwindow.onfocus=function(){ }
                }
                window.location.assign(base_domain + '/transaksi')
            } else {
                $.notify("Gagal! \nHarap isi terlebih dahulu kolom pada \npembayaran untuk menyimpan transaksi \ndan mencetak stock.", "error");
            } 
        }
    });
    function popup(url) 
    {
        audio();
        newwindow=window.open(url,'name','height=600,width=800');
        if (window.focus) {
            newwindow.focus()
        }
    }
});

function popup(id) {
    newwindow=window.open(base_domain + '/transaksi/print_transaction/' + id + '?print=yes','name','height=600,width=800');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}