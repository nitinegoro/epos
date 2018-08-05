$(document).ready(function(argument) {

	$('#masuk-box, #keluar-box').slimScroll({
    	height: '250px'
	});

	$('input[name="amount"]').maskMoney({prefix:'', allowNegative: false, thousands:',', affixesStay: false,  precision:0});

    $('button.update-cash').on('click', function() 
    {
        var ID = $(this).data('id');

        $('div#modal-form-cash').modal('show');

        $.get(base_domain + '/main/getsaldo/' + ID, function(response) 
        {
	        $('#get-amount').val(response.amount);

	        $('#get-desc').val(response.description);
        })

        $('#form-cash_balance').submit(function( event ) {
            event.preventDefault();
            
            $.post(base_domain + '/main/updatecash/' + ID, {
            	amount: $('#get-amount').val(),
            	description:$('#get-desc').val()
            }, function(response) 
            {
				if(response.status =='success') 
				{
					$('strong#set-amount-'+ ID).html('Rp. ' + $('#get-amount').val());

					$('small#set-desc-'+ ID).html($('#get-desc').val());

					$.notify(response.message, "info");
				} else {
					$.notify(response.message, "danger");
				}

				$('div#modal-form-cash').modal('hide');
            })
        });
    })

    $('button.delete-cash').on('click', function() 
    {
        var ID = $(this).data('id');

        $('div#modal-delete').modal('show');

        $('a#btn-delete').on('click', function() 
        {
           	$.get(base_domain + '/main/deletecash/' + ID, function(response) 
            {
				if(response.status =='success') 
				{
					$('div#modal-delete').modal('hide');
					$('tr#masuk-'+ ID + ', tr#keluar-'+ ID).fadeOut(300, function() {
						$(this).remove();
					});

					$.notify(response.message, "info");
				} else {
					$.notify(response.message, "danger");
				}
            })
        })
    })
});


function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
}

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)


    var areaChartData = {};

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.02)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : true,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 3,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 4,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
     //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true,
    }

         $.get(base_domain + '/main/getchartdata/', function(response) 
        {
	        areaChart.Line(response, areaChartOptions)
        })

    //Create the line chart
    