<?php
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
 
//llamada a librería nusoap
require_once('../../../lib/nusoap/lib/nusoap.php');
//require_once('lib/nusoap.php');

//generar instancia de soap_server
$servidor = new soap_server;
 
//funcion para los usuarios según el sexo
function consultaUsuarios($sexo) {
  $arreglo = array(); //arreglo para guardar los datos
  /*-----------------------------llamada a BD---------------------------------*/
  
  $dbconn = pg_connect("host=10.10.0.12 dbname=dbendesis user=webservice password=webservice")
  or die('No se ha podido conectar: ' . pg_last_error());
  
  // Realizando una consulta SQL
  $query = 'SELECT  us.nombre_completo,
                                   us.id_usuario ,
                                   us.id_persona ,
                                   us.login ,
                                   us.contrasenia ,
                                   us.fecha_registro,
                                   us.hora_registro ,
                                   us.estado_usuario ,
                                   us.fecha_expiracion,
                                   us.autentificacion ,
                                   us.usuario_reg ,
                                   us.fecha_inactivacion,
                                   us.id_rol,
  		                           us.apellido_paterno,
  		                           us.apellido_materno,
  		                           us.nombre
                               FROM comunidad.vcom_usuario us
  		                       WHERE '.$sexo;
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  
  while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

  	$login=$line['login'];
  	$nombre_completo=$line['nombre_completo'];
  	$contrasenia=$line['contrasenia'];
  	$autentificacion=$line['autentificacion'];
  	$id_rol=$line['id_rol'];
  	$id_usuario=$line['id_usuario'];
  	$apellido_paterno=$line['apellido_paterno'];
  	$apellido_materno=$line['apellido_materno'];
  	$nombre=$line['nombre'];
  	//$apellido=$line['login'];
  	$arreglo[] = array('Nombre_completo'=>$nombre_completo,'Login'=>$login, 'Contrasenia'=>$contrasenia,'Autentificacion'=>$autentificacion, 'ID_rol'=>$id_rol,'ID_usuario'=>$id_usuario,
  			           'Apellido_paterno'=>$apellido_paterno,'Apellido_materno'=>$apellido_materno,'Nombre'=>$nombre
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
          	'Nombre_completo' => array('name' => 'Nombre_completo', 'type' => 'xsd:string'),
            'Login' => array('name' => 'Login', 'type' => 'xsd:string'),
            'Contrasenia'=>array('name' => 'Contrasenia', 'type' => 'xsd:string'),
          		'Autentificacion'=>array('name' => 'Autentificacion', 'type' => 'xsd:string'),
          		'ID_rol'=>array('name' => 'ID_rol', 'type' => 'xsd:string'),
          		'ID_usuario'=>array('name' => 'ID_usuario', 'type' => 'xsd:string'),
          		'Apellido_paterno'=>array('name' => 'Apellido_paterno', 'type' => 'xsd:string'),
          		'Apellido_materno'=>array('name' => 'Apellido_materno', 'type' => 'xsd:string'),
          		'Nombre'=>array('name' => 'Nombre', 'type' => 'xsd:string')
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
$servidor->register('consultaUsuarios',
      array('sexo'=>'xsd:string'), //tipo de dato entrada
      array('return'=>'tns:ArregloDeEstructuras'), //tipo de dato salida
      $ns, false,
      'rpc', //tipo documento
      'UTF8',//'literal', //tipo codificacion
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