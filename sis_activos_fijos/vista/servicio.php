<?php
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");

include_once("../LibModeloAdministracionComunidad.php");

$Custom = new cls_CustomDBCOM();
//llamada a librería nusoap
require_once('../../../lib/nusoap/lib/nusoap.php');

//generar instancia 
<?php
// Deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");

//llamada a librería nusoap
require_once('../../lib/nusoap/lib/nusoap.php');

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
    /*$id=$fila['ID'];   
    $nombre=$fila['NOMBRE']; 
    $apellido=$fila['APELLIDO'];*/
    $id=1;
    $nombre='ana';
    $apellido='villegas';
    
    //cada registro de información se introduce en un arreglo asociativo
    $arreglo[] = array('Id'=>$id, 'Nombre'=>$nombre, 'Apellido'=>$apellido);
  //}    

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
            'Id' => array('name' => 'Id', 'type' => 'xsd:string'),
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
?>de soap_server
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
    /*$id=$fila['ID'];   
    $nombre=$fila['NOMBRE']; 
    $apellido=$fila['APELLIDO'];*/
    $res = $Custom->ListarUsuarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
    $arreglo=$Custom->salida;
    print_r($arreglo);
    exit;
   /* $id=1;
    $nombre='ana';
    $apellido='villegas';
    */
    //cada registro de información se introduce en un arreglo asociativo
    //$arreglo[] = array('Id'=>$id, 'Nombre'=>$nombre, 'Apellido'=>$apellido);
    
  //}    

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
            'nombre_completo' => array('name' => 'nombre_completo', 'type' => 'xsd:string'),
            'login'=>array('name' => 'login', 'type' => 'xsd:string'),
            'contrasenia'=>array('name' => 'contrasenia', 'type' => 'xsd:string'),
          	'autentificacion'=>array('name' => 'autentificacion', 'type' => 'xsd:string'),
          	'id_rol'=>array('name' => 'id_rol', 'type' => 'xsd:integer')
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