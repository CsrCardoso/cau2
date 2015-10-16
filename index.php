<?php
	$i=0;
	// Conexión al servidor
	$mysqli = new mysqli("cau2.colmex.mx", "julio", "julius", "dbglpi");
	
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

$query = "SELECT T.id, T.users_id_recipient, T.date, T.closedate, TU.users_id, TU.type, U.name, U2.name AS name2
	FROM glpi_tickets_users TU
	INNER JOIN glpi_tickets T ON TU.tickets_id = T.id 
	INNER JOIN glpi_users U ON TU.users_id = U.id
	INNER JOIN glpi_users U2 ON U2.id = TU.users_id 
	WHERE 
	T.date >= '2015-09-30 18:32:06' AND 
	T.closedate <= '2015-10-01 12:32:24'
		/*GROUP BY TU.users_id*/
	;";



	//Execute query
	$qry_result = $mysqli->query($query);

	//var_dump($qry_result->fetch_assoc());
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


	while($row = $qry_result->fetch_assoc()){
	//	var_dump($row);
		/*$i++;
		if($i % 2!=0){
			$display_string .= "<tr class='odd-row'>";
		}
		else{
			$display_string .= "<tr>";
		}*/




			foreach ($row as $arrayfila) {
			
			 //if($arrayfila['id'] == $row['id']){

			/*		if ($row['users_id_recipient'] == $row['users_id']) {
						//asesor designado
						$display_string .="<td>".$row['firstname']."</td>";
						$display_string .="<td>".$row['realname']."</td>";
					///	$display_string .= $asesorrealname;
					}


					else if ($row['users_id_recipient'] != $row['users_id']) {
						$display_string .="<td>".$row['tickets_id']."</td>";
						$display_string .="<td>".$row['date']."</td>";
						$display_string .="<td>".$row['closedate']."</td>";
						$display_string .="<td>".$row['closedate']."</td>";
						
						$display_string .="<td>".$row['firstname']."</td>";
						$display_string .="<td>".$row['realname']."</td>";
						//asesor designado


					}

					else{
						echo "otro caso";
					}
			*/

			//	}

			}

//if ($row['id'] == $arrayfila) {
	//var_dump($row['id']);

//}

/*$idrow = $row['id'];
//var_dump($idrow);
if ($row['id'] == $idrow) {
	var_dump($row);
	echo "alert";
}
*/
			/*$display_string .= "<td>".$row['firstname']."</td>";

			$display_string .= "<td>".$row['realname']."</td>";
		
		$display_string .= "<td>Abierta</td>";*/
		
		//$display_string .= "</tr>";
	




	}

$row2 = $qry_result;
//var_dump($row2);



foreach ($row2 as $key) {
			
	
	/*foreach ($row2 as $idev) {
			//var_dump("Hola".$idev['id']);
	}	
*/

	     foreach($row2 as $key=>$value){
            if (is_array($value)){
                //si es un array sigo recorriendo
              echo 'key:'. $key;
              echo '<br>';
           //  recorro($value);
          }else{  
             //si es un elemento lo muestro
             echo $key.': '.$value ;
             echo '<br>';
          }
 
       }

	var_dump($key['id']);
}





	//echo $display_string;


	/*foreach ($row as $valor) {
			echo $valor.'<br>';
	}*/
	
	mysqli_close($mysqli);
?>