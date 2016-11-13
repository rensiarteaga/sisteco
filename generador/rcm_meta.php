<?php
/**
 * Funcion:  MetaData
 * Proposito: obtener los campos de la tabla especificada
 * Autor: Rensi Arteaga Copari
 *
 * @param conexion postgres    $db              
 * @param  nombre de la tabla  $table          
 * @return array
 */

include("lib/BDSel.php");
include("lib/BDIud.php");
include("lib/ControlListar.php");
include("lib/ControlGuardar.php");
include("lib/ControlEliminar.php");
include("lib/VistaMain.php");
include("lib/Vista.php");
include("lib/VistaJsMaestro.php");
include("lib/VistaCombo.php");
include("lib/ModeloBD.php");


function FormatPhpToJava($nombre){
	$v_nombre=explode('_',$nombre);
	$cont=sizeof($v_nombre );
	$java_nombre="";
	for($i=0;$i<$cont;$i++){
		$java_nombre.=ucwords($v_nombre[$i]);
	}

	return $java_nombre;
}
function MetaData($db,$prefijo,$table){
	$table = "t".strtolower($prefijo)."_".$table;
	$rows    = 0;        // Number of rows
	$qid    = 0;        // Query result resource
	$meta    = array();    // Metadata array
	// See PostgreSQL developer manual (www.postgresql.org) for system table spec.
	// Get catalog data from system tables.
	$sql = 'SELECT a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef,pg_catalog.obj_description(c.oid) FROM pg_class as c, pg_attribute a, pg_type t WHERE a.attnum > 0 and a.attrelid = c.oid and c.relname = '."'$table'".' and a.atttypid = t.oid order by a.attnum';
	$qid = pg_Exec($db, $sql);

	// Check error
	if (!is_resource($qid)) {
		print('MetaData(): Query Error - table does not exist');
		return null;
	}

	$rows = pg_NumRows($qid);
	// Store meta data
	for ($i = 0; $i < $rows; $i++) {
		$field_name                     = pg_Result($qid,$i,1);        // Field Name
		// $meta[$field_name]['id']          = pg_Result($qid,$i,0);        // Attrbute ID
		// $meta[$field_name]['type']         = pg_Result($qid,$i,2);        // Data type name
		//$meta[$field_name]['len']        = pg_Result($qid,$i,3);        // Length: -1 for variable length
		// $meta[$field_name]['modifier']    = pg_Result($qid,$i,4);        // Modifier
		// $meta[$field_name]['notnull']     = (pg_Result($qid,$i,5) === 't' ? TRUE : FALSE);        // Not NULL?
		// $meta[$field_name]['hasdefault'] = (pg_Result($qid,$i,6) === 't' ? TRUE : FALSE);    // Has default value?

		$meta[$i]["campo"]=$field_name;
		$meta[$i]['id']   = pg_Result($qid,$i,0);        // Attrbute ID
		$meta[$i]['type']         = pg_Result($qid,$i,2);        // Data type name
		$meta[$i]['len']        = pg_Result($qid,$i,3);        // Length: -1 for variable length
		$meta[$i]['modifier']    = pg_Result($qid,$i,4);        // Modifier
		$meta[$i]['notnull']     = (pg_Result($qid,$i,5) === 't' ? TRUE : FALSE);        // Not NULL?
		$meta[$i]['hasdefault'] = (pg_Result($qid,$i,6) === 't' ? TRUE : FALSE);    // Has default value?

		$nombre_constraint = tiene_check($field_name,$table);
		if( $nombre_constraint != ""){
			$meta[$i]['check'] = get_valores_check($nombre_constraint,$table);
		}else{
			$meta[$i]['check'] = null;
		}
		$meta[$i]['descripción_tabla']    = pg_Result($qid,$i,7);

	}

	// Clean up. PHP4 reference count code would be smart enough to do this, though.
	pg_FreeResult($qid);

	$vec = obtener_desc_col($table,$db);
	for ($i = 0; $i < $rows; $i++) {
		$meta[$i]['descripcion'] = $vec[$i][5];
	}
	return $meta;
}
/**
 * Funcion:  getCamposTabla
 * Proposito: obtener los campos de la tabla especificada
 * Autor: Rensi Arteaga Copari
 *
 * @param unknown_type $db
 * @param unknown_type $table
 * @return unknown
 */

function getCamposTabla($db, $table){
	$rows    = 0;        // Number of rows
	$qid    = 0;        // Query result resource
	$campos    = array();    // Metadata array - return value

	// See PostgreSQL developer manual (www.postgresql.org) for system table spec.
	// Get catalog data from system tables.
	$sql = 'SELECT a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef FROM pg_class as c, pg_attribute a, pg_type t WHERE a.attnum > 0 and a.attrelid = c.oid and c.relname = '."'$table'".' and a.atttypid = t.oid order by a.attnum';
	$qid = pg_Exec($db, $sql);

	// Check error
	if (!is_resource($qid)) {
		print('MetaData(): Query Error - table does not exist');
		return null;
	}

	$rows = pg_NumRows($qid);
	// Store meta data
	for ($i = 0; $i < $rows; $i++){
		$field_name = pg_Result($qid,$i,1);        // Field Name
		$campos[$i] = $field_name;
	}

	// Clean up. PHP4 reference count code would be smart enough to do this, though.
	pg_FreeResult($qid);
	return $campos;
}




/**
 * Funcion:  getTiposDatosTabla
 * Proposito: obtener los tipos de datos de la tabla especificada
 * Autor: Rensi Arteaga Copari
 *
 * @param unknown_type $db
 * @param unknown_type $table
 * @return unknown
 */

function getTiposDatosTabla($db,$table){
	$rows    = 0;        // Number of rows
	$qid    = 0;        // Query result resource
	$tipos   = array();    // Metadata array - return value

	// See PostgreSQL developer manual (www.postgresql.org) for system table spec.
	// Get catalog data from system tables.
	$sql = 'SELECT a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef FROM pg_class as c, pg_attribute a, pg_type t WHERE a.attnum > 0 and a.attrelid = c.oid and c.relname = '."'$table'".' and a.atttypid = t.oid order by a.attnum';
	$qid = pg_Exec($db, $sql);

	// Check error
	if (!is_resource($qid)) {
		print('MetaData(): Query Error - table does not exist');
		return null;
	}

	$rows = pg_NumRows($qid);
	// Store meta data
	for ($i = 0; $i < $rows; $i++){

		$tipos[$i]=pg_Result($qid,$i,2);        // Data type name
	}

	// Clean up. PHP4 reference count code would be smart enough to do this, though.
	pg_FreeResult($qid);
	return $tipos;
}

/**
 * Funcion:  obtener_desc_col
 * Proposito: Obtiene la descripción de los campos de una tabla
 * Autor: Rodrigo Chumacero Moscoso
 *
 * @param unknown_type $tabla
 * @return unknown
 */
function obtener_desc_col($tabla,$db)
{

	$query="SELECT * FROM f_gen_obtener_desc_col('$tabla') AS (columna name,tipo_dato text,valor_defecto text,nulo boolean,atnum smallint,descripcion text)";
	$salida=array();

	if($result = pg_query($db,$query))
	{
		while ($row = pg_fetch_array($result))
		{
			array_push ($salida, $row);
		}
		//Libera la memoria
		pg_FreeResult($result);
	}
	else
	{
		print('Error al ejecutar función. '.pg_last_error($db));
	}
	return $salida;
}

/**
* Funcion:  tiene_check
* Proposito: Verificar si un campo (columna) tiene restricciones (constraints) del tipo CHECK
* Autor: Enzo Rojas Heredia
*
* @param unknown_type $campo
* @param unknown_type $tabla
* @return unknown
*/
function tiene_check($campo,$tabla){
	global $db;
	$respuesta = "";
	$sql = "SELECT constraint_name, constraint_type FROM information_schema.table_constraints WHERE table_name = '$tabla' and constraint_type='CHECK';";
	$qid = pg_exec($db, $sql);

	if (!is_resource($qid)) {
		print('MetaData(): Query Error - table does not exist');
		return null;
	}
	$rows = pg_NumRows($qid);
	for ($i = 0; $i < $rows; $i++){
		$nombre_constraint = pg_Result($qid,$i,0);
		if(stripos($nombre_constraint,$campo) !== false){
			$respuesta = $nombre_constraint;
		}
	}

	// Clean up. PHP4 reference count code would be smart enough to do this, though.
	pg_FreeResult($qid);
	return $respuesta;
}


/**
 * Funcion:  get_valores_check
 * Proposito: Obtener y devolver la lista de los valores de una restriccion (constraint)
 * Autor: Enzo Rojas Heredia
 *
 * @param unknown_type $nombre_constraint
 * @param unknown_type $tabla
 * @return unknown
 */
function get_valores_check($nombre_constraint,$tabla){
	global $db;
	$sql="SELECT c.conname AS constraint_name, c.consrc AS restriccion FROM pg_constraint c LEFT JOIN pg_class t ON c.conrelid = t.oid LEFT JOIN pg_class t2 ON c.confrelid = t2.oid WHERE t.relname = '$tabla' AND c.conname = '$nombre_constraint'";
	$res =  array();

	$qid = pg_exec($db, $sql);
	if (!is_resource($qid)) {
		print('MetaData(): Query Error - table does not exist');
		return null;
	}
	$rows = pg_NumRows($qid);
	for ($i = 0; $i < $rows; $i++){
		$constraint_name = pg_Result($qid,$i,0);
		if($nombre_constraint  == $constraint_name){
			$constraint = pg_Result($qid,$i,1);
			$trozos = explode("'", $constraint);

			$tam = count($trozos);
			$valores;
			for($i = 0;$i <$tam;$i++){
				$num = (int)($i/2);
				if(($i/2) != $num){
					array_push ($res, $trozos[$i]);
				}
			}
		}
	}

	// Clean up. PHP4 reference count code would be smart enough to do this, though.
	pg_FreeResult($qid);
	return $res;
}






//// Test code ////
$dbName     = 'dbendesis';    // Change this to your db name
$dbUser        = 'rodrigo';    // Change this to your db user name
$codigo='ITEM';
$prefijo='AL';
$sistema="almacenes";
$tableName ='item';    // Change this to your table name
$db = pg_connect('host=192.168.0.8 dbname='.$dbName.' user='.$dbUser." password='db_rcm' port=5432");
$meta = metadata($db,$prefijo,$tableName);
$campos = getCamposTabla($db,$tableName);

//crearArchivo_BDSel("base",$tableName,$prefijo,$codigo,$meta);
//crearArchivo_BDIud("base",$tableName,$prefijo,$codigo,$meta);
crearModeloBD("modelo",$sistema,$tableName,$prefijo,$codigo,$meta);
/*crearArchivo_ControlListar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_ControlGuardar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_ControlEliminar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaMain("vista",$tableName,$prefijo,$codigo,$meta);
crearArchivo_Vista("vista",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaCombo("vista",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaJsMaestro("vista",$sistema,$tableName,$prefijo,$codigo,$meta);*/




print("<pre>");
print_r($meta);
print("</pre>");



?> 
