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
include("lib/ModeloBD.php");
include("lib/ControlListar.php");
include("lib/ControlGuardar.php");
include("lib/ControlEliminar.php");
include("lib/VistaMain.php");
include("lib/Vista.php");
include("lib/VistaJsMaestro.php");
include("lib/VistaCombo.php");


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
    $sql = 'SELECT a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef FROM pg_class as c, pg_attribute a, pg_type t WHERE a.attnum > 0 and a.attrelid = c.oid and c.relname = '."'$table'".' and a.atttypid = t.oid order by a.attnum';
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
        
    }

    // Clean up. PHP4 reference count code would be smart enough to do this, though.
    pg_FreeResult($qid); 

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




//// Test code ////
$dbName     = 'dbendesis';    // Change this to your db name
$dbUser        = 'rodrigo';    // Change this to your db user name
$codigo='UNMEDB';
$prefijo='PM';
$sistema="almacenes";
$tableName ='unidad_medida_base';    // Change this to your table name
$db = pg_connect('host=192.168.0.8 dbname='.$dbName.' user='.$dbUser." password='db_rcm' port=5432");
$meta = metadata($db,$prefijo,$tableName);
$campos = getCamposTabla($db,$tableName);


crearArchivo_BDSel("base",$tableName,$prefijo,$codigo,$meta);
crearArchivo_BDIud("base",$tableName,$prefijo,$codigo,$meta);
crearModeloBD("modelo",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_ControlListar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_ControlGuardar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_ControlEliminar("control",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaMain("vista",$tableName,$prefijo,$codigo,$meta);
crearArchivo_Vista("vista",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaCombo("vista",$sistema,$tableName,$prefijo,$codigo,$meta);
crearArchivo_VistaJsMaestro("vista",$sistema,$tableName,$prefijo,$codigo,$meta);


print("<pre>");
print_r($meta);
print("</pre>");    



?> 
