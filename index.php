<?php

	$i=0;
	// Conexión al servidor
	//$mysqli = new mysqli("cau2.colmex.mx", "julio", "julius", "dbglpi");
	$mysqli = new mysqli("localhost", "root", "", "dbglpi");
	
	/* check connection */ 
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	
	$mysqli->set_charset("utf8");
	
	//Primero las que tienen convocatoria abierta
	//$query = "SELECT * FROM glpi_users WHERE deadline IS NULL ORDER BY deadline DESC;";
	/*$query = "SELECT glpi_tickets.id, glpi_tickets.users_id_recipient, glpi_tickets.date, glpi_tickets.closedate, glpi_users.firstname, glpi_users.realname, glpi_tickets_users.tickets_id, glpi_tickets_users.users_id FROM glpi_tickets, glpi_tickets_users, glpi_users WHERE glpi_tickets.date >= '2015-09-30 18:32:06' AND glpi_tickets.closedate <= '2015-10-01 12:32:24' AND glpi_tickets_users.tickets_id = glpi_tickets.id AND glpi_users.id = glpi_tickets_users.users_id;";
	*/

	/*$query = "SELECT glpi_tickets.id, glpi_tickets.users_id_recipient, glpi_tickets.date, glpi_tickets.closedate, glpi_users.firstname, glpi_users.realname, glpi_tickets_users.tickets_id, glpi_tickets_users.users_id FROM glpi_tickets, glpi_tickets_users, glpi_users WHERE glpi_tickets.date >= '2015-09-30 18:32:06' AND glpi_tickets.closedate <= '2015-10-01 12:32:24' AND glpi_tickets_users.tickets_id = glpi_tickets.id AND glpi_users.id = glpi_tickets_users.users_id;";


*/

/*$query = "SELECT T.id, T.users_id_recipient, T.date, T.closedate, TU.users_id, TU.type, U.name, U2.name AS name2
	FROM glpi_tickets_users TU
	INNER JOIN glpi_tickets T ON TU.tickets_id = T.id 
	INNER JOIN glpi_users U ON TU.users_id = U.id
	INNER JOIN glpi_users U2 ON U2.id = TU.users_id */
	/*WHERE 
	T.date >= '2015-09-30 18:32:06' AND 
	T.closedate <= '2015-10-17 23:32:24'*/
		/*GROUP BY TU.users_id*/
	/*;";*/


//MODULO CONSULTAR GRUPOS SISTEMA GENERAL

	$querygrups = "SELECT id, name FROM glpi_groups;";

	$grupsArray = $mysqli->query($querygrups);

	$finalgrups = '<select name="getGroup">';

	while($grups = $grupsArray->fetch_assoc()){
		  $finalgrups .= '<option value="'.$grups['id'].'">'.$grups['name'].'</option>';
	}

	$finalgrups .= "</select>";

	

	echo '<form id="search" action="" method="post" >
			'.$finalgrups.'
			<input type="submit" value="Search">
			</form>';

//FIN MODULO GRUPOS


//CREAR LISTA DE ASESORIAS 
$query = "SELECT T.id, T.date, T.closedate, T.actiontime, GT.groups_id
			FROM glpi_tickets T
			INNER JOIN glpi_groups_tickets GT ON GT.tickets_id = T.id 
			WHERE 
				date >= '2015-09-30 00:32:06' 
				/*AND closedate <= '2015-15-22 10:23:48' */
				/*AND GT.groups_id = 2;*/
			;";

	//Execute query
	$qry_result = $mysqli->query($query);

	//var_dump($qry_result);
	//$row = $qry_result->fetch_assoc();

	if($qry_result->num_rows==0){
		$display_string = "No se encontró ningún resultado.";
	}
	
	else{
	//Build Result String
	//
		$display_string = "<table class='.tab_cadrehov'>";
		$display_string .= "<thead>";
		$display_string .= "<tr class='tab_bg_2'>";
		$display_string .= "<th style='cursor:pointer'>ID</th>";
		$display_string .= "<th style='cursor:pointer'>Fecha de Inicio</th>";
		$display_string .= "<th style='cursor:pointer'>Fecha de Termino</th>";
		$display_string .= "<th style='cursor:pointer'>Tiempo Real</th>";
		$display_string .= "<th style='cursor:pointer'>Nombre del Autor</th>";
		$display_string .= "<th style='cursor:pointer'>Apellidos del Autor</th>";
		$display_string .= "<th style='cursor:pointer'>Nombre del Asignado</th>";
		$display_string .= "<th style='cursor:pointer'>Apellidos del asignado</th>";
		$display_string .= "</tr>";
		$display_string .= "</thead>";
		$display_string .= "<tbody>";

		//$display_string .= $qry_result->fetch_assoc();
		//var_dump($qry_result->fetch_assoc());
	}

//$row2 = $qry_result->fetch_assoc();

$final = array();

while($row = $qry_result->fetch_assoc()){
	//var_dump($row);

		$idticket = $row['id'];
		$inicio = $row['date'];
		$termino = $row['closedate'];
		$tiempo = $row['actiontime'];
		$groupid = $row['groups_id'];

		$query2 = "SELECT users_id, type			
					FROM glpi_tickets_users
					WHERE tickets_id = ".$row['id']."
					;";
		//Execute query
		$tickets_user = $mysqli->query($query2);

		while($users = $tickets_user->fetch_assoc()){
			//var_dump($users);

			$query3 = "SELECT name, realname, firstname		
						FROM glpi_users
						WHERE id = ".$users['users_id']."
						;";

			$datosusers = $mysqli->query($query3);
			$datos = $datosusers->fetch_assoc();

			 if($users['type'] == 1){
			 	//persona que solicita
			 	$nick_solicitante = $datos['name'];
			 	$nom_solicitante = $datos['firstname'];
			 	$ape_solicitante = $datos['realname'];
			 }elseif ($users['type'] == 2) {
			 	//personal Asignado
			 	$nick_asignado = $datos['name'];
			 	$nom_asignado = $datos['firstname'];
			 	$ape_asignado = $datos['realname'];
			 }elseif ($users['type'] == 3) {
			 	//$solicitante = $datos['name'];
			 }

			//var_dump($datos);

		}

		$resultado = array(
			'idticket' => $idticket,
			'fecha_ini' => $inicio,
			'fecha_term' => $termino,
			'tiemporeal' => $tiempo,//valor en segundos
			'autor_nom' => $nom_solicitante,
			'autor_ape' => $ape_solicitante,
			'asignado_nom' => $nom_asignado,
			'asignado_ape' => $ape_asignado,
			'groupid' => $groupid,
			);

		array_push($final, $resultado);


}




foreach ($final as $value) {
	//var_dump($value);
	$display_string .= "<tr>
							<td valign='top'>".$value['idticket']."</td>
							<td valign='top'>".$value['fecha_ini']."</td>
							<td valign='top'>".$value['fecha_term']."</td>
							<td valign='top'>".$value['tiemporeal']."</td>
							<td valign='top'>".$value['autor_nom']."</td>
							<td valign='top'>".$value['autor_ape']."</td>
							<td valign='top'>".$value['asignado_nom']."</td>
							<td valign='top'>".$value['asignado_ape']."</td>
						</tr>";
}

$display_string .= "</tbody>";
echo $display_string;

//FIN CREAR LISTA ASESORIAS


	$searchtable = '<table class="tab_cadre_fixe">
		<tbody>
			<tr class="tab_bg_1">
				<td width="10" class="center">

						
				</td>
				<td class="left">
					<div id="SearchSpanTicket0">
						<table width="100%">
							<tbody>
								<tr class="">
									<td width="20%">
										<div class="select2-container" id="s2id_dropdown_criteria_0__searchtype_75902895">
										<a href="javascript:void(0)" class="select2-choice" tabindex="-1">   
											<span class="select2-chosen" id="select2-chosen-2">es</span>
											<abbr class="select2-search-choice-close"></abbr>   
											<span class="select2-arrow" role="presentation"><b role="presentation"></b></span>
										</a>
										<label for="s2id_autogen2" class="select2-offscreen"></label>
										<input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-2" id="s2id_autogen2">
										<div class="select2-drop select2-display-none select2-with-searchbox">   
										<div class="select2-search">       
										<label for="s2id_autogen2_search" class="select2-offscreen"></label>       
										<input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" aria-owns="select2-results-2" id="s2id_autogen2_search" placeholder="">   
										</div>   
										<ul class="select2-results" role="listbox" id="select2-results-2">   
										</ul>
										</div>
										</div>
										<select name="criteria[0][searchtype]" id="dropdown_criteria_0__searchtype_75902895" size="1" tabindex="-1" title="" style="display: none;">
										<option value="equals" selected="">es</option></select>
									</td>
									<td width="80%"><span id="spansearchtypecriteriaTicket0">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
	</table>';

echo $searchtable;

//https://sysengineers.wordpress.com/2013/10/28/update-glpi-tickets-with-requesters-group/



	
	mysqli_close($mysqli);
?>

<style type="text/css">

.tab_cadrehov {
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

.tab_bg_2 {
    background-color: #FFF;
}

.tab_cadrehov th {
    background-color: #F8F8F8;
    color: #2E2E2E;
    font-size: 11px;
    border-bottom: 1px solid #EEE;
}

</style>