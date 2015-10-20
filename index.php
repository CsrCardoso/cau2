<?php

	$i=0;
	// Conexión al servidor
	$mysqli = new mysqli("cau2.colmex.mx", "julio", "julius", "dbglpi");
	//$mysqli = new mysqli("localhost", "root", "", "dbglpi");
	
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


$query = "SELECT id, date, closedate, actiontime 
			FROM glpi_tickets
			WHERE 
				date >= '2015-09-01 00:32:06' AND 
				closedate <= '2015-10-05 23:32:24'
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
		$display_string = "<table id='tabla-papers' class='papersSB'>";
		$display_string .= "<thead>";
		$display_string .= "<tr>";
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

		$query2 = "SELECT users_id, type			
					FROM glpi_tickets_users
					WHERE tickets_id = ".$row['id']."
					;";
		//Execute query
		$tickets_user = $mysqli->query($query2);

		while($users = $tickets_user->fetch_assoc()){
			//var_dump($users);

			$query3 = "SELECT name			
						FROM glpi_users
						WHERE id = ".$users['users_id']."
						;";

			$datosusers = $mysqli->query($query3);
			$datos = $datosusers->fetch_assoc();

			 if($users['type'] == 1){
			 	$ingreso = $datos['name'];
			 }elseif ($users['type'] == 2) {
			 	$asignado = $datos['name'];
			 }elseif ($users['type'] == 3) {
			 	//$solicitante = $datos['name'];
			 }

			//var_dump($datos);

		}

		$resultado = array(
			'idticket' => $idticket,
			'inicio' => $inicio,
			'termino' => $termino,
			'tiemporeal' => $tiempo,//valor en segundos
			'register' => $ingreso,
			'asignado' => $asignado,
			'solicitante' => "solicitante"
			);

		array_push($final, $resultado);


}




foreach ($final as $value) {
	//var_dump($value);
	$display_string .= "<tr><td>".$value['idticket']."</td><td>".$value['inicio']."</td><td>".$value['termino']."</td><td>".$value['tiemporeal']."</td><td>".$value['register']."</td><td>".$value['asignado']."</td></tr>";
}

$display_string .= "</tbody>";
echo $display_string;

//https://sysengineers.wordpress.com/2013/10/28/update-glpi-tickets-with-requesters-group/



	
	mysqli_close($mysqli);
?>