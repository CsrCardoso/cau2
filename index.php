<!DOCTYPE html>
<html>
<head>
	<title>Estadisticas por Grupo / Area</title>

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  

</head>
<body>

<?php 
include 'getinfoclass.php';

?>

<div id="page">
	<div class="center">
		<form id="search" action="" name="form" method="post">
			<table border="0" class="tab_cadrehov">
				<tbody>
					<tr class="tab_bg_2">
						<td rowspan="2" align="center">
							<?php 
							 $finalgrups = new getInfo(); 
							 echo $finalgrups->getgrupos();
							?>
						</td>
						<td align="right">
							Fecha inicial :
						</td>
						<td id="ext-gen6">
							<div id="dateinicio" class="input-append date buscar">
								<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="fechaini" id="fechaini">
							      <span class="add-on">
							        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
							      </span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right">
							Fecha final :
						</td>
						<td id="ext-gen20">
							<div id="datefinal" class="input-append date buscar">
								<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="fechafin" id="fechafin">
							      <span class="add-on">
							        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
							      </span>
							</div>
						</td>
						<td>
							<input type="button" value="Search" id="buscar" class="buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>

<div class="center">
<a href="#" class="export">Exportar a excel</a>
</div>

	<div class="center" id="maintabla">

		<table class='tab_cadrehov'>
			<thead>
				<tr class='tab_bg_2'>
					<th style='cursor:pointer'>ID</th>
					<th style='cursor:pointer'>Fecha de Inicio</th>
					<th style='cursor:pointer'>Fecha de Termino</th>
					<th style='cursor:pointer'>Tiempo Real</th>
					<th style='cursor:pointer'>Nombre del Autor</th>
					<th style='cursor:pointer'>Apellidos del Autor</th>
					<th style='cursor:pointer'>Nombre del Asignado</th>
					<th style='cursor:pointer'>Apellidos del asignado</th>
				</tr>
			</thead>
			<tbody id="aqui">

				

			</tbody>
		</table>

		<?php// echo $display_string; ?>
	</div>
</div>



    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <script type="text/javascript">
     $('#dateinicio').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss'
      });
     $('#datefinal').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss'
      });
/*

     		var dataString = 'date='+selectedDate;
			$.ajax({
				type: "POST",
				url: "save.php",
				data: dataString,
				success: function(data) {
					$('#result').empty();
					$('#result').html(data);
				}
			});
*/
    </script>




<script src="http://www.eyecon.ro/bootstrap-datepicker/js/jquery.js"></script>
<script type="text/javascript" src="http://www.eyecon.ro/bootstrap-datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>


	<style type="text/css">


table {
    display: table;
    border-collapse: separate;
    border-spacing: 2px;
    border-color: grey;
}

	.tab_cadre {
    margin: 0 auto;
    -moz-border-radius: 4px;
    border: 1px solid #cccccc;
    z-index: 1;
    text-align: left;
    font-size: 11px;
    background-color: #ffffff;
}
.tab_bg_2 {
    background-color: #e4e4e2;
}

.tab_cadre td, .tab_cadre_fixe td, .tab_cadre_fixehov td, .tab_cadrehov td, .tab_cadrehov_pointer td, .tab_cadre_report td {
    padding-left: 5px;
}

select {
    font-size: 11px;
    border: 1px solid #888888;
    color: black;
    background-color: white;
}

.center {
    text-align: center;
}


.tab_cadrehov, .tab_cadrehov_pointer {
    margin: 0 auto;
    -moz-border-radius: 4px;
    border: 1px solid #cccccc;
    text-align: left;
    font-size: 11px;
    background-color: #ffffff;
}

.tab_bg_2 {
    background-color: #e4e4e2;
}

.tab_cadre th, .tab_cadre_fixe th, .tab_cadre_fixehov th, .tab_cadrehov th, .tab_cadrehov_pointer th, .tab_cadre_report th {
    font-size: 11px;
    font-weight: bold;
    background-color: #fccc6f;
    text-align: center;
    background: url("../pics/fond_th.png") repeat-x;
    border-bottom: 1px solid #cccccc;
}

.tab_cadre td, .tab_cadre_fixe td, .tab_cadre_fixehov td, .tab_cadrehov td, .tab_cadrehov_pointer td, .tab_cadre_report td {
    padding-left: 5px;
}


#page form {
    font-size: 12px;
    margin: 0;
    margin-bottom: 5px;
    padding: 0;
}


	thead {
	    margin: 10px auto;
	    border: 0;
	    text-align: left;
	    font-size: 11px;
	    width: 95%;
	    background-color: #ffffff;
	    -moz-box-shadow: 0px 1px 2px 1px #D2D2D2;
	    -webkit-box-shadow: 0px 1px 2px 1px #D2D2D2;
	    box-shadow: 0px 1px 2px 1px #D2D2D2;
	    border-spacing: 0;
	}

	.tab_cadrehov th {
	    background-color: #F8F8F8;
	    color: #2E2E2E;
	    font-size: 11px;
	    border-bottom: 1px solid #EEE;
	}

	#aqui img{
		margin: 0 auto;
	}

	</style>

<script type="text/javascript">
 jQuery(document).ready(function() {

    $('.buscar').on("click", function(){
    		$('#aqui').empty();

			$('#aqui').append('<img src="img/ajax-loader.gif"/>');

        	fechaini = $('#fechaini').val();
        	fechafin = $('#fechafin').val();

			grupo = $('select#getGroup').val();

            var dataString = 'accion=getasesorias&fechaini='+fechaini+'&fechafin='+fechafin+'&grupo='+grupo;


            $.ajax({
                type: "POST",
                url: "getajax.php",
                data: dataString,
                success: function(data) {
                	//$('#aqui img').remove();
                	console.log(data);
                   	$('#aqui').empty();
                    $('#aqui').html(data);
                }
            });
     

    });





        function exportTableToCSV($table, filename) {

        var $rows = $table.find('tr:has(td)'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td');

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();

                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',

            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename,
                'href': csvData,
                'target': '_blank'
        });
    }

    // This must be a hyperlink
    $(".export").on('click', function (event) {
        // CSV
        exportTableToCSV.apply(this, [$('#maintabla>table'), 'export.csv']);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });

  });

</script>
</body>
</html>