<?php
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
 
//llamada a librería nusoap
require_once('../../../lib/nusoap/lib/nusoap.php');

/*
include_once('../LibModeloFlujo.php');
$Custom = new cls_CustomDBFlujo();


$res = $Custom->ListarCorrespondenciaENDE();

if($res)
{
	$xml = new cls_manejo_xml('ROOT');
	//$xml->add_nodo('TotalCount',$total_registros);

	foreach ($Custom->salida as $f)
	{   
		$arreglo[] = array('CodigoCorrespondencia'=>$f["codigo"], 'NumeroCorrespondencia'=>$f["numero_correspondencia"],
		'CodigoTipoDocumento'=>$f["codigo_tipo_documento"], 
		'DescripcionTipoDocumento'=>$f["descripcion_tipo_documento"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		
		'NombreTipoCorrespondencia'=>$f["nombre_tipo_correspondencia"],
		'CodigoInstitucion'=>$f["codigo_institucion"],
		'NombreInstitucion'=>$f["nombre_institucion"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		'TipoCorrespondencia'=>$f["tipo_correspondencia"],
		);
		
		$xml->add_rama('Correspondencia');
//	$xml->add_nodo('CodigoCorrespondencia',$f["codigo"]);
//		$xml->add_nodo('NumeroCorrespondencia',$f["numero_correspondencia"]);
//		$xml->add_nodo('CodigoTipoDocumento',$f["codigo_tipo_documento"]);
//		$xml->add_nodo('DescripcionTipoDocumento',$f["descripcion_tipo_documento"]);
//		$xml->add_nodo('TipoCorrespondencia',$f["tipo_correspondencia"]);
//		$xml->add_nodo('NombreTipoCorrespondencia',$f["nombre_tipo_correspondencia"]);
//		$xml->add_nodo('CodigoInstitucion',$f["codigo_institucion"]);
		$xml->add_nodo('NombreInstitucion',$f["nombre_institucion"]);
		$xml->add_nodo('Referencia',$f["referencia"]);
		$xml->add_nodo('Descripcion',$f["descripcion|"]);
		$xml->add_nodo('Emisor',$f["emisor"]);
		$xml->add_nodo('NombreEmisor',$f["nombre_emisor"]);
		$xml->add_nodo('Receptor',$f["receptor"]);
		$xml->add_nodo('NombreReceptor',$f["nombre_receptor"]);
		$xml->add_nodo('FechaRecepcion',$f["fecha_recepcion"]);
		$xml->add_nodo('CantidadHojas',$f["cantidad_hojas"]);
		$xml->add_nodo('NombreArchivo',$f["nombre_archivo"]);


		$xml->fin_rama();
	}
	$xml->mostrar_xml();
}


 */
//generar instancia de soap_server
$servidor = new soap_server;
 
//funcion para los usuarios según el sexo
function consultaUsuarios($sexo) {
  $arreglo = array(); //arreglo para guardar los datos
  /*-----------------------------llamada a BD---------------------------------*/
  $dbconn = pg_connect("host=10.10.0.12 dbname=dbendesis user=avillegas password=Daliarashel1978")
  or die('No se ha podido conectar: ' . pg_last_error());
   
  // Realizando una consulta SQL
  $query = 'SELECT  us.nombre_completo,
                                   us.id_usuario ,
                                   us.id_persona ,
                                   us.login ,
                                   us.contrasenia ,
                                   us.fecha_registro,
                                   us.hora_registro ,
                                   us.fecha_ultima_modificacion ,
                                   us.hora_ultima_modificacion ,
                                   us.estado_usuario ,
                                   us.estilo_usuario ,
                                   us.filtro_avanzado ,
                                   us.fecha_expiracion,
                                   us.autentificacion ,
                                   us.id_nivel_seguridad ,
                                   us.login_nuevo ,
                                   us.login_anterior,
                                   us.usuario_reg ,
                                   us.fecha_inactivacion,
                                   us.id_rol
                               FROM comunidad.vcom_usuario us
  		                       WHERE '.$sexo;
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  
  while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

  	$login=$line['login'];
  	$contrasenia=$line['contrasenia'];
  	$autentificacion=$line['autentificacion'];
  	$id_rol=$line['id_rol'];
  	$id_usuario=$line['id_usuario'];
  	//$apellido=$line['login'];
  	$arreglo[] = array('Login'=>$login, 'Contrasenia'=>$contrasenia,'Autentificacion'=>$autentificacion, 'ID_rol'=>$id_rol,'ID_usuario'=>$id_usuario);
  	
  }

  /*----------------------------fin llamada a BD-------------------------------*/
 
  return $arreglo;
}
 
//namespace del servicio
$ns = "";
 
//establecer nombre y namespace al servicio
$servidor->configureWSDL('ENDESIS',$ns);
 
//configurar la estructura de los datos, 
//este arreglo es de tipo asociativo y contiene el nombre y tipo de dato.
$servidor->wsdl->addComplexType(
        'Estructura',
        'complexType',
        'struct',
        'all',
        '',
          array(
            'Login' => array('name' => 'Login', 'type' => 'xsd:string'),
            'Contrasenia'=>array('name' => 'Contrasenia', 'type' => 'xsd:string'),
          		'Autentificacion'=>array('name' => 'Autentificacion', 'type' => 'xsd:string'),
          		'ID_rol'=>array('name' => 'ID_rol', 'type' => 'xsd:string'),
          		'ID_usuario'=>array('name' => 'ID_usuario', 'type' => 'xsd:string')
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
$servidor->register('Correspondencia Archivada ENDE',
      array('sexo'=>'xsd:string'), //tipo de dato entrada
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