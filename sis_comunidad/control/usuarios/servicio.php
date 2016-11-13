<?php
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");

//include_once("../LibModeloAdministracionComunidad.php");

//$Custom = new cls_CustomDBComunidad();
//llamada a librería nusoap
require_once('../../../lib/nusoap/lib/nusoap.php');
//include_once("../../../sis_seguridad/control/auten/control.php");
//generar instancia de soap_server
$servidor = new soap_server;


//funcion para los usuarios según el sexo
function consultaUsuarios($sexo) {
  $arreglo = array(); //arreglo para guardar los datos
  /*-----------------------------llamada a BD---------------------------------*/
  //$conn=mysql_connect("servidor", "usuario", "contrasena");
  //mysql_select_db("base de datos", $conn);

  //$sql="SELECT ID, NOMBRE, APELLIDO FROM usuarios WHERE SEXO='$sexo'";

  //$result=mysql_query($sql);

  //while ($fila= mysql_fetch_array($result)){
  /*  $id=$fila['ID'];   
    $nombre_completo=$fila['NOMBRE']; 
    $apellido=$fila['APELLIDO'];
    */
    /*$res = $Custom->ListarUsuarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
    $arreglo=$Custom->salida;
    */
    //print_r($arreglo);
  //  exit;
   /* $id=1;
    */$nombre_completo='ana';
   /* $apellido='villegas';
    
   */
	/*echo "funciona";
	exit;*/
	echo"ingresa?";
	 $_SESSION["ss_id_usuario"]=131;
	//$this->ip_origen = "'200.87.181.201'";
     $_SESSION["ss_ip"]='100.10.23.0';
     //acceso al usuario
     
    
     // Conectando y seleccionado la base de datos
  /*   $dbconn = pg_connect("host=10.10.0.12 dbname=dbendesis user=webservice password=webservice")
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
                                   us.login_anterior , 
                                   us.usuario_reg , 
                                   us.fecha_inactivacion,
                                   us.id_rol 
                               FROM comunidad.vcom_usuario us';
     $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
     */
   
   //  while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
     //	echo "\t<tr>\n";
     	/*$id=$line['id_usuario'];
     	$nombre=$line['id_persona'];
     	$apellido=$line['login'];
     	*/
     	//cada registro de información se introduce en un arreglo asociativo
     	$arreglo[] = array('Id'=>'a', 'Nombre'=>'b', 'Apellido'=>'d');
     		//echo "\t</tr>\n";
//}

     	//	pg_free_result($result);
     
     		// Cerrando la conexión
     		//pg_close($dbconn);
     	
   /*  print_r($arreglo);
     exit;*/

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
		array( 'Id' => array('name' => 'Id', 'type' => 'xsd:string'),
            'Nombre'=>array('name' => 'Nombre', 'type' => 'xsd:string'),
           	'Apellido'=>array('name' => 'Apellido', 'type' => 'xsd:string')
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
		'literal', //tipo codificacion
		'Documentacion de consultaUsuarios') ; //documentacion



//Establecer servicio
if (isset($HTTP_RAW_POST_DATA)) {
	$input = $HTTP_RAW_POST_DATA;
}else{
	$input = implode("\r\n", file('php://input'));
}

$servidor->service($input);
?>





















