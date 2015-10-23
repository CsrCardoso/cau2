
<?php

	
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

/*----------------------------------------------------*/

/**
* 
*/
class getInfo
{
	


//MODULO CONSULTAR GRUPOS SISTEMA GENERAL
function getgrupos(){

	// Conexión al servidor
	$mysqli = new mysqli("cau2.colmex.mx", "julio", "julius", "dbglpi");
	//$mysqli = new mysqli("localhost", "root", "", "dbglpi");
	
	/* check connection */ 
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	
	$mysqli->set_charset("utf8");

	$querygrups = "SELECT id, name FROM glpi_groups;";
	$grupsArray = $mysqli->query($querygrups);

	//SELECT GROUP
	$finalgrups = '<select name="getGroup" id="getGroup">';
		while($grups = $grupsArray->fetch_assoc()){
			  $finalgrups .= '<option value="'.$grups['id'].'">'.$grups['name'].'</option>';
		}
	$finalgrups .= "</select>";
	//FIN SELECT GROUP

	
	/*echo '<form id="search" action="" method="post">
			'.$finalgrups.'
			<input type="submit" value="Search">
			</form>';
	*/

	return $finalgrups;		

mysqli_close($mysqli);
//FIN MODULO GRUPOS
}

//CREAR LISTA DE ASESORIAS 
function getasesorias($fechaini, $fechafin, $grupo){

	// Conexión al servidor
	$mysqli = new mysqli("cau2.colmex.mx", "julio", "julius", "dbglpi");
	//$mysqli = new mysqli("localhost", "root", "", "dbglpi");
	
	/* check connection */ 
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	
	$mysqli->set_charset("utf8");

$inicio = $fechaini;
$final = $fechafin;
$grupoid = $grupo;
//var_dump($inicio);

$query = "SELECT T.id, T.date, T.closedate, T.actiontime, GT.groups_id
			FROM glpi_tickets T
			INNER JOIN glpi_groups_tickets GT ON GT.tickets_id = T.id 
			WHERE 
				date >= '$inicio'
				AND closedate <= '$final'
				AND GT.groups_id = $grupoid
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
			'tiemporeal' => $tiempo/60,//valor en segundos
			'autor_nom' => $nom_solicitante,
			'autor_ape' => $ape_solicitante,
			'asignado_nom' => $nom_asignado,
			'asignado_ape' => $ape_asignado,
			'groupid' => $groupid,
			);

		array_push($final, $resultado);


}



return $final;

//mysqli_close($mysqli);

}

//FIN CREAR LISTA ASESORIAS


//https://sysengineers.wordpress.com/2013/10/28/update-glpi-tickets-with-requesters-group/

}

	

?>
