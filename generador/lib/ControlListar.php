<?php
function crearArchivo_ControlListar($direccion,$db,$sistema,$table,$prefijo,$codigo,$meta){
	
	
	$codigo = $prefijo."_"."$codigo";
	$table_fjava = FormatPhpToJava($table);
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$table = "t".strtolower($prefijo)."_".$table;
	
	
	$fp_handler=fopen("$direccion/ActionListar".$table_fjava.".php","w+");
	$fecha=date("Y-m-d H:i:s");
	
	$sql = "<?php
/**
**********************************************************
Nombre de archivo:	    ActionListar".$table_fjava.".php
Propósito:				Permite realizar el listado en ".$table."
Tabla:					t".strtolower($prejilo)."_".$table."
Parámetros:				\$cant
						\$puntero
						\$sortcol
						\$sortdir
						\$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		$fecha
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModelo".ucwords($sistema).".php');

\$Custom = new cls_CustomDB".ucwords($sistema)."();
\$nombre_archivo = 'ActionListar$table_fjava .php';

if (!isset(\$_SESSION['autentificado']))
{
	\$_SESSION['autentificado']='NO';
}
if(\$_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if(\$limit == '') \$cant = 15;
	else \$cant = \$limit;

	if(\$start == '') \$puntero = 0;
	else \$puntero = \$start;

	if(\$sort == '') \$sortcol = '".$meta[0]["campo"]."';
	else \$sortcol = \$sort;

	if(\$dir == '') \$sortdir = 'asc';
	else \$sortdir = \$dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de \$cod -> 'si', 'no'
	
	switch (\$cod)
	{
		case 'si':
			\$decodificar = true;
			break;
		case 'no':
			\$decodificar = false;
			break;
		default:
			\$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if(\$CantFiltros=='') \$CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	\$cond = new cls_criterio_filtro(\$decodificar);
	for(\$i=0;\$i<\$CantFiltros;\$i++)
	{
		\$cond->add_condicion_filtro(\$_POST[\"filterCol_\$i\"], \$_POST[\"filterValue_\$i\"], \$_POST[\"filterAvanzado_\$i\"]);
	}
	\$criterio_filtro = \$cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	\$crit_sort = new cls_criterio_sort(\$sortcol,\$sortdir,'$table_fjava');
	\$sortcol = \$crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	\$res = \$Custom -> Contar".$table_fjava."(\$cant ,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$hidden_ep_id_financiador,\$hidden_ep_id_regional,\$hidden_ep_id_programa,\$hidden_ep_id_proyecto,\$hidden_ep_id_actividad);

	if(\$res) \$total_registros= \$Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	\$res = \$Custom->Listar".$table_fjava."(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$hidden_ep_id_financiador,\$hidden_ep_id_regional,\$hidden_ep_id_programa,\$hidden_ep_id_proyecto,\$hidden_ep_id_actividad);
	
	if(\$res)
	{
		\$xml = new cls_manejo_xml('ROOT');
		\$xml->add_nodo('TotalCount',\$total_registros);

		foreach (\$Custom->salida as \$f)
		{
			\$xml->add_rama('ROWS');\n";
			
		
	
	for($i=0;$i<=$num_campos -1; $i ++){
		$sql.= "\t\t\t\$xml->add_nodo('".$meta[$i]["campo"]."',\$f[\"".$meta[$i]["campo"]."\"]);\n";
		
		if($meta[$i]["referenciado"]!=null){
			$vec_ref = $meta[$i]["referenciado"];
			$table_ref = $vec_ref[0];//tabla referenciada por el campo $i
			$id_table_ref = $vec_ref[1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);
			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$sistema_ref =$sistema;
			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla
			$sql.= "\t\t\t\$xml->add_nodo('desc_".$table_ref_sp."',\$f[\"desc_".$table_ref_sp."\"]);\n";
		}
	
	}
		$sql.="
			\$xml->fin_rama();
		}
		\$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		\$resp = new cls_manejo_mensajes(true,'406');
		\$resp->mensaje_error = \$Custom->salida[1];
		\$resp->origen = \$Custom->salida[2];
		\$resp->proc = \$Custom->salida[3];
		\$resp->nivel = \$Custom->salida[4];
		\$resp->query = \$Custom->query;
		echo \$resp->get_mensaje();
		exit;
	}
}
else
{
	\$resp = new cls_manejo_mensajes(true, \"401\");
	\$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	\$resp->origen = \"ORIGEN = \$nombre_archivo\";
	\$resp->proc = \"PROC = \$nombre_archivo\";
	\$resp->nivel = 'NIVEL = 3';
	echo \$resp->get_mensaje();
	exit;

}?>";
	
	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>