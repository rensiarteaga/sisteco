<?php 
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
 
//llamada a librería nusoap
require_once('../../../lib/nusoap/lib/nusoap.php');
//require_once('lib/nusoap.php');
 
//generar instancia de soap_server
$servidor = new soap_server;
 
//funcion para los usuarios según el sexo
function consultaFuncionarios($criterio_filtro) {
  $arreglo = array(); //arreglo para guardar los datos
  /*-----------------------------llamada a BD---------------------------------*/
//  echo 'llega'; exit;
  
  $dbconn = pg_connect("host=10.10.0.12 dbname=dbendesis user=webservice password=webservice")
  or die('No se ha podido conectar: ' . pg_last_error());
  // Realizando una consulta SQL
  $query = 'SELECT    id_persona_endesis,
   					  fecha_nacimiento,
    				  correo_electronico_ende,
    				  desc_persona,
    				  jefe_inmediato,
                      unidad_organizacional,
                      cargo_trabajo,
                      telefono_domicilio,
                      celular,
                      correo_personal,
                      profesion,
    				  ubicacion_lugar,
                      telefono_interno,
                      ruta_foto,
                      estado,
                      fecha_registro
             FROM comunidad.vcom_funcionario us
  		                       WHERE '.$criterio_filtro;
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  
  while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

  	$id_persona_endesis=$line['id_persona_endesis'];
  	$fecha_nacimiento=$line['fecha_nacimiento'];
  	$correo_electronico_ende=$line['correo_electronico'];
  	$desc_persona=$line['desc_persona'];
  	$jefe_inmediato=$line['jefe_inmediato'];
  	$unidad_organizacional=$line['unidad_organizacional'];
  	$cargo_trabajo=$line['cargo_trabajo'];
  	$telefono_domicilio=$line['telefono_domicilio'];
  	$celular=$line['celular'];
  	$correo_personal=$line['correo_personal'];
  	$profesion=$line['profesion'];
  	$ubicacion_lugar=$line['ubicacion_lugar'];
  	$telefono_interno=$line['telefono_interno'];
  	$ruta_foto=$line['ruta_foto'];
  	$estado=$line['estado'];
  	$fecha_registro=$line['fecha_registro'];
  	
  	
  
  	//$apellido=$line['login'];
  	$arreglo[] = array(	'id_persona_endesis'=>$id_persona_endesis,
  	'fecha_nacimiento'=>$fecha_nacimiento,
  	'correo_electronico_ende'=>$correo_electronico,
  	'desc_persona'=>$desc_persona,
  	'jefe_inmediato'=>$jefe_inmediato,
  	'unidad_organizacional'=>$unidad_organizacional,
  	'cargo_trabajo'=>$cargo_trabajo,
  	'telefono_domicilio'=>$telefono_domicilio,
  	'celular'=>$celular,
  	'correo_personal'=>$correo_personal,
  	'profesion'=>$profesion,
  	'ubicacion_lugar'=>$ubicacion_lugar,
  	'telefono_interno'=>$telefono_interno,
  	'ruta_foto'=>$ruta_foto,
  	'estado'=>$estado,
  	'fecha_registro'=>$fecha_registro
  			
  	);
  	
  }

  /*----------------------------fin llamada a BD-------------------------------*/
 
  return $arreglo;
}
 
//namespace del servicio
$ns = "http://garabatoslinux.net";
 
//establecer nombre y namespace al servicio
$servidor->configureWSDL('Garabatos Linux',$ns);
 
//configurar la estructura de los datos, 
//este arreglo es de tipo asociativo y contiene el nombre y tipo de dato.
$servidor->wsdl->addComplexType(
        'Estructura',
        'complexType',
        'struct',
        'all',
        '',
          array(
          		'id_persona_endesis'=> array('name' => 'id_persona_endesis', 'type' => 'xsd:string'),
          		'fecha_nacimiento'=> array('name' => '$fecha_nacimiento', 'type' => 'xsd:string'),
          		'correo_electronico_ende'=> array('name' => 'correo_electronico', 'type' => 'xsd:string'),
          		'desc_persona'=> array('name' => 'desc_persona', 'type' => 'xsd:string'),
          		'jefe_inmediato'=> array('name' => 'jefe_inmediato', 'type' => 'xsd:string'),
          		'unidad_organizacional'=> array('name' => 'unidad_organizacional', 'type' => 'xsd:string'),
          		'cargo_trabajo'=> array('name' => 'cargo_trabajo', 'type' => 'xsd:string'),
          		'telefono_domicilio'=> array('name' => 'telefono_domicilio', 'type' => 'xsd:string'),
          		'celular'=> array('name' => 'celular', 'type' => 'xsd:string'),
          		'correo_personal'=> array('name' => 'correo_personal', 'type' => 'xsd:string'),
          		'profesion'=> array('name' => 'profesion', 'type' => 'xsd:string'),
          		'ubicacion_lugar'=> array('name' => 'ubicacion_lugar', 'type' => 'xsd:string'),
          		'telefono_interno'=> array('name' => 'telefono_interno', 'type' => 'xsd:string'),
          		'ruta_foto'=> array('name' => 'ruta_foto', 'type' => 'xsd:string'),
          		'estado'=> array('name' => 'estado', 'type' => 'xsd:string'),
          		'fecha_registro'=> array('name' => 'fecha_registro', 'type' => 'xsd:string')
                  )
          		 );
 
//configurar arreglo de la estructura
$servidor->wsdl->addComplexType(
      'ArregloDeEstructuras',
      'complexType',
      'array',
      'sequence',
      'http://schemas.xmlsoap.org/soap/encoding/:Array',
      array(),
      array(
        array('ref' => 'http://schemas.xmlsoap.org/soap/encoding/:arrayType',
          'wsdl:arrayType' => 'tns:Estructura[]'
        )
      ),'tns:Estructura');
 
//registrar la funcion de consulta de usuarios
$servidor->register('consultaFuncionarios',
      array('criterio_filtro'=>'xsd:string'), //tipo de dato entrada
      array('return'=>'tns:ArregloDeEstructuras'), //tipo de dato salida
      $ns, false,
      'rpc', //tipo documento
      'literal', //tipo codificacion
      'Documentacion de consultaUsuarios') ; //documentacion
 
//Ver más tipos de datos
//http://dcx.sybase.com/1200/en/dbprogramming/datatypes-http.html
 
//Ver más sobre documento/codificación
//http://www.ibm.com/developerworks/webservices/library/ws-whichwsdl/
 
//Establecer servicio        
if (isset($HTTP_RAW_POST_DATA)) { 
  $input = $HTTP_RAW_POST_DATA; 
}else{ 
  $input = implode("\r\n", file('php://input')); 
}
 
$servidor->service($input);
?>