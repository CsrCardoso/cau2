<?php 
include 'getinfoclass.php';

if ($_POST['accion'] == "getasesorias") {
	getajax_asesorias();
	//echo "hola mundo";
}

function getajax_asesorias(){

	$fechaini = $_POST['fechaini'];
	$fechafin = $_POST['fechafin'];
	$grupo = $_POST['grupo'];


	$final = new getInfo();
	$final2 = $final->getasesorias($fechaini, $fechafin, $grupo);

	$tabla = "";
			foreach ($final2 as $value) {
				//var_dump($value);
				$tabla .= "<tr class='tab_bg_2'>
						<td valign='top'>".$value['idticket']."</td>
						<td valign='top'>".$value['fecha_ini']."</td>
						<td valign='top'>".$value['fecha_term']."</td>
						<td valign='top'>".$value['tiemporeal']." min.</td>
						<td valign='top'>".$value['autor_nom']."</td>
						<td valign='top'>".$value['autor_ape']."</td>
						<td valign='top'>".$value['asignado_nom']."</td>
						<td valign='top'>".$value['asignado_ape']."</td>
					</tr>";
			}

	echo $tabla;

}


?>