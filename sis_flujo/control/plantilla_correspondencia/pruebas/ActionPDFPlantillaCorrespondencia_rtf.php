<?php
	session_start();
	//Se valida la autentificación	
		
	include_once('../LibModeloFlujo.php');
	include("../../../lib/rtf_new/class_rtf_v2.php");

	$Custom = new cls_CustomDBFlujo();
	$nombre_archivo = 'ActionPDFPlantillaCorrespondencia.php';
		
	$inicial = explode(' ', $_GET['desc_empleado']);

	if($inicial[3] != '')
	{
		$aux = $inicial[0];
		$inicial[0] = $inicial[2];
		$inicial[2] = $aux;
		
		$aux = $inicial[1];
		$inicial[1] = $inicial[3];
		$inicial[3] = $aux;
		
		$nombre = $inicial[0].' '.$inicial[1].' '.$inicial[2].' '.$inicial[3];
	}
	else 
	{
		$aux = $inicial[1];
		$inicial[1] = $inicial[2];
		$inicial[2] = $aux;
		
		$aux = $inicial[1];
		$inicial[1] = $inicial[0];
		$inicial[0] = $aux;
		
		$nombre = $inicial[0].' '.$inicial[1].' '.$inicial[2];
	}
	
	for($i = 0; $i < (sizeof($inicial)); $i++)
	{
		$iniciales = $iniciales.substr($inicial[$i], 0, 1);	
	}
	
	$iniciales = strtolower($iniciales);						//iniciales
	$lugar=$_SESSION["ss_nombre_lugar"];						//lugar
	
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Parámetros del filtro
		if($limit == '') $cant = 15;
		else $cant = $limit;
	
		if($start == '') $puntero = 0;
		else $puntero = $start;
	
		if($sort == '') $sortcol = '0=0';
		else $sortcol = $sort;
	
		if($dir == '') $sortdir = 'asc';
		else $sortdir = $dir;
		
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
  			$referencia = $_POST['referencia'];					//asunto
  			$desc_empleado = $_POST['desc_empleado'];			//DE:
  			$numero = $_POST['numero'];							//numero
  			$empleado_remitente = $_POST['empleado_remitente'];		
  			$desc_documento = $_POST['desc_documento'];			//tipo documento
  			$id_empleado = $_POST['id_empleado'];			
			$id_correspondencia = $_POST['id_correspondencia'];
			$fecha_reg = $_POST['fecha_reg'];					//fecha
			$id_tipo_accion = $_POST['id_tipo_accion'];
			$nombre_tipo_accion = $_POST['nombre_tipo_accion'];
			$acciones = $_POST['acciones'];
			$mensaje = $_POST['mensaje'];
			$observaciones = $_POST['observaciones'];
			$cite = $_POST['cite'];										
  			
		} 
		else 
		{
  			$referencia = $_GET['referencia'];					//asunto
  			$desc_empleado = $_GET['desc_empleado'];			//DE:
  			$numero = $_GET['numero'];							//numero
  			$empleado_remitente = $_GET['empleado_remitente'];		
  			$desc_documento = $_GET['desc_documento'];			//tipo documento
  			$id_empleado = $_GET['id_empleado'];			
			$id_correspondencia = $_GET['id_correspondencia'];
			$fecha_reg = $_GET['fecha_reg'];					//fecha
			$id_tipo_accion = $_GET['id_tipo_accion'];
			$nombre_tipo_accion = $_GET['nombre_tipo_accion'];
			$acciones = $_GET['acciones'];
			$mensaje = $_GET['mensaje'];
			$observaciones = $_GET['observaciones'];
			$cite = $_GET['cite'];
							
  		}
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> 'si', 'no'
		
		switch ($cod)
		{
			case 'si':
				$decodificar = true;
				break;
			case 'no':
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
		
		$res = $Custom-> CargoEmpleadoRem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado);
		$cargo_rem = $Custom->salida[0]['nombre_cargo'];
	
		//Verifica si se manda la cantidad de filtros
		if($CantFiltros=='') $CantFiltros = 0;
	
		//Se obtiene el criterio del filtro con formato sql para mandar a la BD
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$CantFiltros;$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
			
		$criterio_filtro = $cond -> obtener_criterio_filtro();
				
		//Obtiene el criterio de orden de columnas
		$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_empleado');
		$sortcol = $crit_sort->get_criterio_sort();				

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom-> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var);				
		$tamanio = sizeof($Custom->salida);		
		
		for($i=0; $i < $tamanio; $i++)
		{		
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.$Custom->salida[$i]['empleado'].' - '.$Custom->salida[$i]['nombre_cargo'].chr(13).chr(10); 
		}	
				   	       	
       	$referencia = strtoupper($referencia);
       	$nombre = strtoupper($nombre);	       	
       	$empleado_remitente = strtoupper($empleado_remitente);
       	$desc_documento = strtoupper($desc_documento);
       	$destinatarios = strtoupper($destinatarios);
       	$cargo_rem = strtoupper($cargo_rem);
    	$Rtf = new Rtf();	    	
    				
		/*---------------- para dar formato al word -------------------*/
		
/*			{\rtf1{\fonttbl{\f0 Arial;}} 				\
		\f0\fs20 Texto del documento\par 			|
		}											|
													|
		{\rtf1{\fonttbl{\f0\ Arial;}{\f1 Verdana;}} |-	para la fuente en word
		\f0\fs20 Letra en Arial\par 				|
		\f1 Letra en Verdana\f0\par 				|
		} 											/

		//TIPO
		\b texto \b0 - Texto en negrita
		\i texto \i0 - Texto en cursiva
		\ul texto \ulnone - Texto subrayado
		\fs40 texto \fs20- Tamaño del texto, antes de empezar a escribir, definimos el tamaño de texto como 20 (\fs20 ), pues si queremos cambiarlo, usaremos '\ftXX ' donde XX es el tamaño y luego volveremos al tamaño por defecto con '\fs20 '
		\par - Final de línea

		//COLORES
		{\rtf1{\fonttbl{\f0 Arial;}} 
		{\colortbl ;\red255\green0\blue0;\red0\green0\blue255;} 
		\f0\fs20\cf1 Rojo\par 
		\cf2 Azul\par 
		\cf0 Automatico 
		}*/
		
		/*-------------------------------------------------------------*/
		$nombre_doc = 'documento.doc'; 			
		$contenido = '{\rtf\ansi
{\fonttbl{\f1 Arial}}
{\colortbl;\red0\green0\blue0;}
{\info {\creatim \yr2008 \mo\May \dy19 \hr16 \min02 \sec22} {\author Oracle Reports} {\title Actapreadjudicaciónimptermicas08.rtf}  }
\viewkind1
\paperw11520\paperh15840

{{\pard \phpg\pvpg\posx0\posy0\absw5000\absh-1\nowrap      {This file was created by Oracle Reports. Please view this document in Page Layout mode.}\par}
{\pard \pvpg\phpg\posx4753\posy224\absw1560\absh59650323 {\pict \picw78\pich100\dibitmap\wbmbitspixel8\wbmplanes1\wbmwidthbytes10\picwgoal1560\pichgoal2000
\picscalex88\picscaley88
280000004e00000064000000010008000000000000000000130b0000130b00000000000000000000
0000000000008000008000000080800080000000800080008080000080808000c0c0c0000000ff00
00ff000000ffff00ff000000ff00ff00ffff0000ffffff0000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000330000006600000099000000cc000000ff00000000330000333300006633000099330000
cc330000ff33000000660000336600006666000099660000cc660000ff6600000099000033990000
6699000099990000cc990000ff99000000cc000033cc000066cc000099cc0000cccc0000ffcc0000
00ff000033ff000066ff000099ff0000ccff0000ffff000000003300330033006600330099003300
cc003300ff00330000333300333333006633330099333300cc333300ff3333000066330033663300
6666330099663300cc663300ff66330000993300339933006699330099993300cc993300ff993300
00cc330033cc330066cc330099cc3300cccc3300ffcc330000ff330033ff330066ff330099ff3300
ccff3300ffff330000006600330066006600660099006600cc006600ff0066000033660033336600
6633660099336600cc336600ff33660000666600336666006666660099666600cc666600ff666600
00996600339966006699660099996600cc996600ff99660000cc660033cc660066cc660099cc6600
cccc6600ffcc660000ff660033ff660066ff660099ff6600ccff6600ffff66000000990033009900
6600990099009900cc009900ff00990000339900333399006633990099339900cc339900ff339900
00669900336699006666990099669900cc669900ff66990000999900339999006699990099999900
cc999900ff99990000cc990033cc990066cc990099cc9900cccc9900ffcc990000ff990033ff9900
66ff990099ff9900ccff9900ffff99000000cc003300cc006600cc009900cc00cc00cc00ff00cc00
0033cc003333cc006633cc009933cc00cc33cc00ff33cc000066cc003366cc006666cc009966cc00
cc66cc00ff66cc000099cc003399cc006699cc009999cc00cc99cc00ff99cc0000cccc0033cccc00
66cccc0099cccc00cccccc00ffcccc0000ffcc0033ffcc0066ffcc0099ffcc00ccffcc00ffffcc00
0000ff003300ff006600ff009900ff00cc00ff00ff00ff000033ff003333ff006633ff009933ff00
cc33ff00ff33ff000066ff003366ff006666ff009966ff00cc66ff00ff66ff000099ff003399ff00
6699ff009999ff00cc99ff00ff99ff0000ccff0033ccff0066ccff0099ccff00ccccff00ffccff00
00ffff0033ffff0066ffff0099ffff00ccffff00ffffff00ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffdbfefffffffefffffffffffffffffffffffffffffefffffff9ffffdbffffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffffefffffffffffffefffffffffefffffffffffffffff9ffffffdbfffffefffff9fffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
f9fffffffff9ffd5fffffffffffff9fea37e4c282828282828525af9ffffffffffffdbfffedbffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fefffff9dbfffffffffffff9fe4d2e282828282828282f282f284c282828d4fffff9fffffffff9ff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffffffeffffffd428292828282828282828282828282828282e282e282828d4ffdbffdbffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffff282e2828284c2e284c2828282828292e282e282828282828282828cefffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffef9fff9ff2e28282828292828284c2853a9dbffffffffa9a3282e282828282828282828fffff9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffdb282828282928282953d4f9ffdbffffffffffffffdbfffff95a28282828282828287eff
ffffffffffffffffffffffffffffffffffffffffffff0000fffffffffffffffffffffff9fffffeff
ffffff5328282828282828d3fffffffecdceafa9a9a9a9a9a9d3f9fffeffffd528282829282e2828
fffffffffeffffffffffffffffffffffffffffffffff0000ffffffffffffffffdbfffffffffffff9
ffdb282828282e284caaa829282828282e28282828282828282828282828287ed4d4282828282f28
28ffdbffffffffdbffffffffffffffffffffffffffff0000fffffffffffffffffffefffffef9ffff
ff4c284d2828282828282828282f2828282828282828282e282e2828282f2828284c2828284c282f
2828fffffefffeffffffffffffffffffffffffffffff0000ffffffffffffffffffffdbfeffffffd4
282928282828d4dbfe7f7d5a2e282828282828282828282828282828282828282828282853282828
282828ffdbffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffff4c
29284c28a3fffeffffffdbfff9ffffffffffffffffffdbffffffffffdbfffffffffffffffeffff28
2928284cfff8ffffffffffffffffffffffffffffffff0000ffffffffffffffffffdbfffffeff2828
284c28daffffdbced4a95229284d28282828282828282828282828282e282fa985afffffdbfff9ff
282e282828ffdbffffffffffffffffffffffffffffff0000ffffffffffffffffffffffdbff2f2829
2828292828284c2e2829282828282828282828282828282828282e28284c2828282828282828287d
f92828282828feffffffffffffffffffffffffffffff0000ffffffffffffffffffffffff7e282828
4d2e4d282829282828282828282828282828282828282828282828282828282e2828282828284c28
28282828282953ffffffffffffffffffffffffffffff0000ffffffffffffffffffffdbd428282828
28fffff9fffffff9ffffd45a7d7e28282828282828282e2828282828282828282829537ea284daff
fffe2828282828dbfffffffffffff9ffffffffffffff0000fffffffffffffffffefffe2828284c28
fffffeffffd4fffffffffffffff9feffffffffdbfffffff9ffffffffffffffffffffffffffffffdb
ffffff2828282828ffffdbffdbffffffffffffffffff0000ffffffffffffffffffdbd428292828ff
fffffefffffffff9feced453775a53532e282828282828282e2f532f5385d4d5fefffefffffffeff
ffffffff28282829feffffffffffffffffffffffffff0000ffffffffffffffffffff2828282885a3
522e28282828282e4c282928284c284c282828282828282828282852282828282828282928282985
affffff97e28282828ffdbf9fffffeffffffffffffff0000ffffffffffffffffff28282828a3f885
7828284d282828282828284c2828282828282828282828282828282828282828282828282e284c28
28282f28282928282852ffffffffffdbffffffffffff0000fffffffffffffff9fe2928284cffffff
fff9fffeffffffffd37faf28282828282828282828282828282828282828294c284c292828527fa9
a9fffffff9ff29282828fff9ffffffffffffffffffff0000fffffffffffffeff2828282ffeffffdb
fefffff9fffeffffffffffffffffffffffffffffffffffffffffffd5fffffffeffdbfeffffffffff
dbfffff9ffdbd452282828ffffffffffffffffffffff0000ffffffffffffffdb2e28284dfffeffff
ffdbffffffffffafaad3ce5352522f52292f4c2e4c2f29292e29284da9ceafa9fffffffffffffeff
ffffffffdbffff2828282ef9fffffeffffffffffffff0000feffffffffffff28292828ff7ea22828
28282828282829282828282828282828282828282828282828282828282828282828282828282828
537efffffffff9db2828284dffffffffffffffffffff0000fffffeffffdbff2e2828284d4d282828
282828282f28282828282828282828282828282828282828282828284c2828282828282828282828
2828282828282828282f2828fffffeffffffffffffff0000fff9ffffdbff28282928cefffffffeff
fffffef9da7e5a532828282828282828282828282828282828282e2828282828282828284d2e2828
2828282e537ea2782f2828287edbffffffffffffffff0000fefffffffffe28282829ffdbffffdbff
fff9ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffdbf9ffff
ffffffffffffffffd428284d2effffffffffffffffff0000fffffeffff5229282ed3ffffffdbfffe
ffdbffb0ceaf292e2e285228282828282828282828282828282828294c282fcea9b0f8fffffffffe
dbffffdbffffffffff4c282828f9feffffffffffffff0000ffffffffff282828287e292829284c28
292828282928282828282828284c2828282828282828282829282828282828282828282828282828
2852785af8f9ffdbff8528282e4dffffffffffffffff0000ffffffdbff28282878d4b04c4d282852
2828285228282f282828282828282828282828282828282828282828282e4c282828282828282828
282828282828284c28282e282828ffffffffffffffff0000ffffffff4c282828fffffeffffffffff
ffffffffdbff777d785928282828284c28282828282828282e282829282828282828282828282828
284c2829597d7e77fff953292828ffffffffffffffff0000ffffffff29282928ffffffffffffffff
ffffffffffffffdbfffffffffffffffffffefffffffffffefffffffffeffffffdbffffffffffffff
ffdbfffffffff9fffffffe282e287dffffffffffffff0000fefffffe28282877fffffff9ffffffff
ffffffdbdadba9a87e7e7e7e7e7e7e7e5a4d282828537d7d785a787e787da3f9dbf9fefff9ffffff
fffff9fffffeffffffffff28282828ffffffffffffff0000ffffffa22928285a53534d2f28282828
282e28282828282828282828282828282928282828282828282e2828282828282828284c2828284c
285352aacef8ffdbfff9fe2f292828ffffffffffffff0000fff9ff28282828534c2e282828282828
2828282852284c282828285228282828282828282828282828282828282e28282828282828282828
2828282e282e284c2829282e28282ffeffffffffffff0000ffdbff28282852fffffffff9ffffffff
fff9ffffd5d5d4f97e785a532e282e28282828284c28282828282828284c282e2828282828282828
2877787d78537ff8daf9feff292828a2ffffffffffff0000ffffff282829d4dbffffffffdbfffff9
ffffffffffffffdbfffff9fffffefffffffffff9fffffffff8ffffffffffffffdbffffffffffffff
fffffedbffffffffffdbf9ff282e2828ffffffffffff0000ffdbff4c2828ffffffffffffffffffff
fffe7e5a7e547e2829284c2e2828282828284c2828282829284c547e5a7d7ed4feffffffffffffff
f9fffffffffffefffffeffff284c2828ffffffffffff0000ffffff28282828282828282828282828
282828282828282828282828282828282e2828282828282828282828282828292828282828282828
5228524c2eced4fffffffffe2e282828ffffffffffff0000ffffff282e287e4c28282828284c2828
282828282928282828282828282828282828282828282828282828282828282e28282828282f2828
28282828282828282828284c28282828ffffffffffff0000fff9a9282829ffffffffffffffdbf9fe
aab0cd2f4c2e282e282828282828282828282828282828284c2828282828282828282e284c282828
2828284c282828282852284d28282828ffffffffffff0000f9db53282828dbfffffffffffffffff9
fffffffffff9fff9fffff9daf8fedaf9dbfefed5dbfedbdadbdbf9daf9dbd5dbf8ffd5fed5dbf9db
ffffffffffffffffdbffffffb0282828ffffffffffff0000ffff28282953ffffdbffffffffffffff
ffffdbceafcda9cdafaad3b0b0ced3b0cea9cea9a9a9cdaaafcdd3b0fefffffffffffeffffffffff
ffdbffffffffdbfffffffffed3282828ffffffffffff0000ffff2828282852282828282828282828
282828282828282f2828282828282828282e29282828282828282828284d28282828292e28282828
284c282828297885cefffff97f2e2828ffffffffffff0000ffdb282828282928282e282828282828
2828282e28284c28282e28282828284c2828282828282828294c282828282828282e282828282829
2828282828282828284d285228282828ffffffffffff0000ffff2828282828282828282828282828
28282828282828fffffeceb0cecd5428294c2f292e4d2e28522e292f29524d2f4d287e7eb0282828
28282828282828282828282828284c28ffffffffffff0000ffff28282828282e2828282828282828
2828282828282884f9fffffffffff9ffffffffffffffffffffffffffffffffffffdbffff2e282928
28284c28282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
282828282e282828ffffffffffdbfffffff9ffffffffffffdbfffff9fffffff9ffffffdb282e2828
28282828282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
28282e282928282828282828282e28284c282828282e2852522f53535353282f5328282828282828
28282828282828282828282828282828ffffffffffff0000ffdb2828282828292828282828282828
2828282f2828285228282852282829282828282829284c28282829282828284c2e28292828282928
28282828282828282828282828282828ffffffffffff0000fff92828282828282828282828282828
282828284d282828fffffffffffefffffffffffffffffefffefffff9fffffffff9ffff2e28282828
28282828282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
282828282828285af9ffdbfffffffffffffffefff9fff9fffffffffffffffffeffffdba928282828
28282828282828282828282828282828ffffffffffff0000ffff4c28282828282828282828282828
28282e28282f28ffffff4c2f28284c28282828294d537e5a7e54537d7d535353d4ffffff28282e28
28282828282828282828282828282828ffffffffffff0000ffff4c28282828282828282828282828
282828284d28fffff9af2828282828282f282e292828282828284d28282828282ef9ffffd4282828
28282828282828282828282828282828ffffffffffff0000ffff2f28282828282828282828282828
28cdffffffffffffff2828284c2928ffffff28ffffffff28ffd4fe28282828282828ffffffff282e
28282828282828282828282828282828ffffffffffff0000ffffaf2828284c282828282828282828
29a9ffffffffffffff282828282828feffff28d5ffff7e28fffff928282828282828ffffffffffdb
ffff4c28282828282828292828284c28ffffffffffff0000fffeff282e2828282828282828282828
282828282828282828284c284d2828dbffff2884ffff2f28ffff7e282828282829282f2e2e4c5353
52532828282828282828282828282977ffffffffffff0000ffffff28282828282828282828282828
2828282829282828282829282828287dffff284cf9ff2828dbff28284c282828284c28282e282828
2828282828282828282e2828282828b0ffffffffffff0000fffff92828284c282828282828282828
28282828282828285228282828282e28fff92828ffff28287eff282928282828282f282928282828
2f28292828282828282828282e2828ffffffffffffff0000dbffff2828282e282828282828282828
4c2e282828282828282828284c28284dffa22828ffff29284ddb2828282828284c28282828282828
282828282828282828282e28282828ffffffffffffff0000ffffff28282928282828282828282828
282828282e282828284c28282e282828ff292828fffe282828fe2e282828282828284c2828282828
285228282828282828282828282e53dbffffffffffff0000fff9ff5328284c282828282828282828
2e4c2828282828282828282828282828ff285228fff928284cff292828282828282829282828284c
2828282829282828282828282828ceffffffffffffff0000ffffffd42e2828282828282828282828
28282828295228282829282e28282828ff292828f9d4282828db2828282828282828282828282828
2828282828282928282828282828ffffffffffffffff0000ffffffff282828282828282828282828
28282828282828282828284c2828282eff282828d4a8282828ff28282828282e2828282828282828
2828282828282828284c28282928f9ffffffffffffff0000fff9ffff282828282828282828282828
28282828282828282829282828282828ff282e28db5a282828db2828282828282828282828282828
282828282828282828282828287effffffffffffffff0000ffffffffa92e29282828282828282828
2828282828282828282e28284d282828f9282828f853282828db2829282828282828282828282828
28282828282828282828282828ffffffffffffffffff0000ffffdbffff2828282828282828282828
2828282828282828284c28282828282eff282828d4534c2828ff282828282f282828282828282828
282828282828282828282e2828ffffffffffffffffff0000fff9ffffff2928282828282828282828
2828282828282828282828284c282928ff282828d5532e2828ff28282828282e2828282828282828
28282828282828282828282885ffffffffffffffffff0000ffffffffffd328282828282828282828
28282828282828282828282828282828ff282828f95228284df92828282828282828282828282828
282828282828282828282828ffffffffffffffffffff0000fffffffeffff2e282828282828282828
282828282828282828284c282828285aff532928db542828a8ff2828282828282828282828282828
282828282828282828282853ffffffdbffffffffffff0000ffffffffffdb7d282828282828282828
2828282828282828282828282f2828d5ffa92828ffa22828ffff2828284c28282828282828282828
282828282828282828282ffeffffffffffffffffffff0000ffffffffffffff28285228284c282828
282828282828282828282828282828ffffff2828ff852828ffff2828282928282828282828282828
28284c2828282828282828ffffffffffffffffffffff0000fffffffffffff95a2828292829282828
28282828282828282828284d2e2828feffff284cffd52828fef92928282828282828282828282828
282852282828284c2f28ffdbffffffffffffffffffff0000ffffffdbfffffffe2828282828282828
282828282828282828282828284c53fff9ff2828ffff28d4ffff7d282828284c2828282828282828
282828282e282828284cfff9ffffffffffffffffffff0000fffeffffffffffff4d2e282828292828
2828282828282828282f28282828282e4c28527efff92e2828282828282828282828282828282828
282828284c28282829f9fffffefffff9ffffffffffff0000ffffffffdbfff9ffff28282e28282928
282828282828282828282828284c2828282828ffffff282e28282828282852282828282828282828
2828282e28284c287effffdbf9fffeffffffffffffff0000ffffffffffffffffffd5522828282828
28282828282828282828282828282828284d2efeffdb282e28282828282828282828282828282828
2e28282828282828fffefffffffffeffffffffffffff0000fffffffffffffff9ffdb28284c28282f
28282828282828284c28282828282829282828d4d4ce2828282828282e2828282828282828282828
2828282828282853ffffffffffffffffffffffffffff0000ffffffdbffffffffffffff2928282828
2828282828282828282828282828282828282e2828282e2828292828282828282828282828282828
4c28282828284ddbf9fffff9ffdbffffffffffffffff0000ffffffffffffffffffffff53284c2828
28d42e284c2f2828284c2828282828282828282828282828282828292828282828284c2829282828
77282e282828ffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffff28282928
284cff29282828284c282828282e2828282928282828294c292828282828292828282828282828a3
2828282828ceffffffffffffffffffffffffffffffff0000ffffffffffffffffffdbffffff282828
2829a3f9ff4c28282828282828284c28282828284c282828282828282828282828282928287eff28
28284c287dfffff9ffffffffffffffffffffffffffff0000ffffffffffffffffffffdbffffff2828
28282953fffff9522828282829282828282828282828282828282e28282828282828287edbff2828
2828282ff9fffeffffffffffffffffffffffffffffff0000fffffffffffffffffff9fffffeffff28
2828282828d4fffffeff28284c2828282829284c282828282828282829282e287dffffff52282828
5228a9ffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffdbffdafffffffff9
28292828282852ffffffffffce2852292828282828282829282828282853fefffeffd4284d292828
28a8fffffffeffffffffffffffffffffffffffffffff0000fffffffffffffffffffffffffff9ffff
ff28284c2828282885ffffdbfefffff9a97e53292e4c282853a9fffffffefff8ff282f2828282828
aaffffdbfffffff8ffffffffffffffffffffffffffff0000ffffffffffffffffffdbffffffffffff
fffe282828284c284c28ffffffffffffffffffffffffffffffffffdbffdbff5a28282828284c2878
fffefffff9fffeffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
dbffff284c28282828282e28d3fffffefffffffff9fffeffffdbffffff522828282828282828d4f9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffff542828282828282828282ea9ffffdbffffffdbf9ffa92828282828282828282828ffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
dbffdbffffff28284d282828282828282829282828282828282828284c282829282828cefff9fff9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffefffffefff92829282828282828282828292828524c284c4c2e2852282e2878fffeffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fff9fffffffff8fffff97e2829282828282828282828282828282828282853dbfefffffffffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
f9fffffffffffff9fffffffeff532828282828285228282828282e4dd4ffffffffffdbfffffff9ff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fefffff9fff9fefff9fffffffff9ffffffa9a8772852a9a3dbffffffffffdbfffffffeffffffffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffefffffffffffffffffffffffffffffffffff9fffff9fffffff9ffffffdbfffffff9ffffff
ffffffffffffffffffffffffffffffffffffffffffff0000} \par}
{\pard \qc \pvpg\phpg\posx643\posy2718\absw10127 \absh-274 {\f1\fs24 \cf1 DICTAMEN DE EVALUACIÓN DE OFERTAS Nº 530 / 2008\par}}
{\pard \qc \sl163 \pvpg\phpg\posx3803\posy15075\absw3915 \absh-405 {{\f1\fs18 \cf1 Pág. }{\f1\fs18 \cf1 1}{\f1\fs18 \cf1  de }{\f1\fs18 \cf1 2\par}}
}
{\do\dobxpage\dobypage\dprect
\dpx678\dpy3774\dpxsize9998\dpysize297
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\pard \ql \pvpg\phpg\posx3959\posy3814\absw6697 \absh-238 {\f1\fs16 \cf1 SSATCIU\par}}
{\pard \ql \pvpg\phpg\posx698\posy3815\absw3296 \absh-237 {\f1\fs16 \cf1 Unidad Operativa de adquisiciones (UOA) \par}}
{\do\dobxpage\dobypage\dprect
\dpx680\dpy5989\dpxsize10014\dpysize302
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\do\dobxpage\dobypage\dprect
\dpx680\dpy6360\dpxsize10014\dpysize334
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\do\dobxpage\dobypage\dprect
\dpx688\dpy4624\dpxsize9980\dpysize867
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx9974 \dppty0 \dpx683 \dpy4916 \dpxsize9974 \dpysize0
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx9972 \dppty0 \dpx685 \dpy5199 \dpxsize9972 \dpysize0
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx0 \dppty825 \dpx2091 \dpy4646 \dpxsize0 \dpysize825
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx0 \dppty240 \dpx5991 \dpy4646 \dpxsize0 \dpysize240
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx0 \dppty240 \dpx8383 \dpy4644 \dpxsize0 \dpysize240
}
{\pard \ql \pvpg\phpg\posx2108\posy4649\absw3855 \absh-230 {\f1\fs16 \cf1 CONTRATACION DIRECTA\par}}
{\pard \ql \pvpg\phpg\posx698\posy4649\absw1023 \absh-270 {\f1\fs16 \cf1 \b  Tipo:\par}}
{\pard \ql \pvpg\phpg\posx6915\posy4649\absw1452 \absh-270 {\f1\fs16 \cf1 591\par}}
{\pard \ql \pvpg\phpg\posx6050\posy4649\absw1098 \absh-270 {\f1\fs16 \cf1  Número:\par}}
{\pard \ql \pvpg\phpg\posx9285\posy4649\absw1373 \absh-270 {\f1\fs16 \cf1 2008\par}}
{\pard \ql \pvpg\phpg\posx8380\posy4649\absw1216 \absh-270 {\f1\fs16 \cf1 \b  Ejercicio:\par}}
{\pard \ql \pvpg\phpg\posx2108\posy4926\absw8550 \absh-285 {\f1\fs16 \cf1 ETAPA UNICA\par}}
{\pard \ql \pvpg\phpg\posx698\posy4926\absw1038 \absh-285 {\f1\fs16 \cf1 \b  \par}}
{\do\dobxpage\dobypage\dprect
\dpx680\dpy5644\dpxsize9999\dpysize278
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\pard \ql \pvpg\phpg\posx2153\posy5211\absw8505 \absh-270 {\f1\fs16 \cf1 LEY Nº 2.095 ART. 38º\par}}
{\pard \ql \pvpg\phpg\posx705\posy5211\absw1373 \absh-270 {\f1\fs16 \cf1 \b  Encuadre Legal:\par}}
{\pard \ql \pvpg\phpg\posx3219\posy5681\absw7451 \absh-209 {\f1\fs16 \cf1 SDYPC - EXP - 14753 / 2008\par}}
{\pard \ql \pvpg\phpg\posx724\posy5680\absw1959 \absh-209 {\f1\fs16 \cf1 \b  Actuado Nro:\par}}
{\pard \ql \pvpg\phpg\posx3199\posy6028\absw7436 \absh-193 {\f1\fs16 \cf1 Equipos y Suministros para Computación\par}}
{\pard \ql \pvpg\phpg\posx724\posy6021\absw2190 \absh-193 {\f1\fs16 \cf1 \b  Rubro Comercial:\par}}
{\pard \ql \pvpg\phpg\posx3158\posy6435\absw7462 \absh-210 {\f1\fs16 \cf1 Adquisición de Impresoras Térmicas para sistema de turnos\par}}
{\pard \ql \pvpg\phpg\posx690\posy6435\absw2310 \absh-210 {\f1\fs16 \cf1 \b  Objeto de la contratación:\par}}
{\pard \qc \pvpg\phpg\posx668\posy3476\absw10080 \absh-225 {\f1\fs20 \cf1 \par}}
{\pard \ql \pvpg\phpg\posx727\posy4258\absw3780 \absh-270 {\f1\fs20 \cf1 \b \ul PROCEDIMIENTO DE SELECCION\par}}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx0 \dppty255 \dpx3780 \dpy3797 \dpxsize0 \dpysize255
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty270 \dpptx0 \dppty0 \dpx3109 \dpy6011 \dpxsize0 \dpysize270
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty244 \dpptx0 \dppty0 \dpx3124 \dpy5668 \dpxsize0 \dpysize244
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx0 \dppty302 \dpx3109 \dpy6382 \dpxsize0 \dpysize302
}
{\do\dobxpage\dobypage\dprect
\dpx686\dpy9439\dpxsize10079\dpysize836
\dplinew20 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\do\dobxpage\dobypage\dprect
\dpx708\dpy9454\dpxsize10047\dpysize251
\dpfillfgcr255\dpfillfgcg255\dpfillfgcb255
\dpfillbgcr192\dpfillbgcg192\dpfillbgcb192\dpfillpat1
\dplinew0 \dplinesolid\dplinecor0\dplinecog0\dplinecob0
}
{\pard \qc \pvpg\phpg\posx1924\posy9479\absw2907 \absh-215 {\f1\fs16 \cf1 \b Firmas Preadjudicatarias \par}}
{\pard \qc \pvpg\phpg\posx8903\posy9479\absw1807 \absh-215 {\f1\fs16 \cf1 \b Encuadre Legal\par}}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty792 \dpptx0 \dppty0 \dpx1857 \dpy9459 \dpxsize0 \dpysize792
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty792 \dpptx0 \dppty0 \dpx4857 \dpy9463 \dpxsize0 \dpysize792
}
{\pard \qc \pvpg\phpg\posx4917\posy9479\absw939 \absh-215 {\f1\fs16 \cf1 \b Cantidad \par}}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty792 \dpptx0 \dppty0 \dpx5857 \dpy9459 \dpxsize0 \dpysize792
}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty792 \dpptx0 \dppty0 \dpx7122 \dpy9463 \dpxsize0 \dpysize792
}
{\pard \qc \pvpg\phpg\posx5885\posy9479\absw1222 \absh-215 {\f1\fs16 \cf1 \b Precio Unitario \par}}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty791 \dpptx0 \dppty0 \dpx8849 \dpy9460 \dpxsize0 \dpysize791
}
{\pard \qc \pvpg\phpg\posx7155\posy9479\absw1665 \absh-215 {\f1\fs16 \cf1 \b Importe Total\par}}
{\pard \qc \pvpg\phpg\posx907\posy9772\absw686 \absh-215 {\f1\fs16 \cf1 1\par}}
{\pard \ql \pvpg\phpg\posx1922\posy9772\absw2915 \absh-158 {\f1\fs14 \cf1 EPSON ARGENTINA SRL\par}}
{\pard \ql \pvpg\phpg\posx4905\posy9772\absw902 \absh-215 {\f1\fs14 \cf1 20 Unidad\par}}
{\pard \qr \pvpg\phpg\posx5940\posy9772\absw1112 \absh-215 {\f1\fs14 \cf1  1.254,860000\par}}
{\pard \qr \pvpg\phpg\posx7177\posy9772\absw1605 \absh-215 {\f1\fs14 \cf1  25.097,20\par}}
{\pard \ql \pvpg\phpg\posx696\posy10640\absw1423 \absh-170 {\f1\fs16 \cf1 \b Observaciones:\par}}
{\pard \qc \pvpg\phpg\posx696\posy9479\absw1114 \absh-215 {\f1\fs16 \cf1 \b Renglón Nº\par}}
{\pard \ql \pvpg\phpg\posx8910\posy9773\absw1755 \absh-215 {\f1\fs14 \cf1 UNICO OFERENTE\par}}
{\pard \qj \sl149 \pvpg\phpg\posx1275\posy10890\absw9412 \absh-374 {{\f1\fs16 \cf1 DONDE DICE SECRETARIA DE DESCENTRALIZACION Y PARTICIPACION CIUDADANA DEBE DECIR SUBSECRETARIA DE} }
{{\f1\fs16 \cf1 ATENCION CIUDADANA \par}}
}
{\pard \ql \pvpg\phpg\posx731\posy7210\absw2355 \absh-242 {\f1\fs16 \cf1 \b Fecha de Apertura:\par}}
{\pard \ql \pvpg\phpg\posx2577\posy7226\absw1644 \absh-215 {\f1\fs14 \cf1 17/05/2008 14:00\par}}
{\pard \ql \pvpg\phpg\posx703\posy8656\absw652 \absh-242 {\f1\fs16 \cf1 \b Objeto:\par}}
{\pard \ql \pvpg\phpg\posx703\posy8942\absw9900 \absh-242 {\f1\fs16 \cf1 recibidas para la presente contratación y según surge de lo manifestado precedentemente, han resuelto adjudicar a favor de:\par}}
{\pard \ql \pvpg\phpg\posx1511\posy8656\absw9155 \absh-233 {\f1\fs16 \cf1 Reunidos en Comisión los que suscriben, en la fecha indicada "ut-supra" con el objeto de considerar las propuestas\par}}
{\pard \ql \pvpg\phpg\posx736\posy7829\absw9555 \absh-227 {\f1\fs16 \cf1 del Cuadro Comparativo de Precios que ordena la Reglamentación en vigencia, fueron analizadas las ofertas de las firmas:\par}}
{\pard \ql \pvpg\phpg\posx733\posy8116\absw10042 \absh-182 {\f1\fs16 \cf1 EPSON ARGENTINA SRL\par}}
{\pard \ql \pvpg\phpg\posx697\posy7548\absw1860 \absh-242 {\f1\fs16 \cf1 \b Ofertas presentadas:\par}}
{\pard \ql \pvpg\phpg\posx2475\posy7548\absw6993 \absh-219 {\f1\fs16 \cf1 1 - ( UNO) De acuerdo a lo manifestado en el Acta de Apertura Nro.580/2008 y a lo evaluado a través  \par}}
{\pard \qr \pvpg\phpg\posx7177\posy10027\absw1605 \absh-215 {\f1\fs14 \cf1 \b  25.097,20\par}}
{\pard \qc \pvpg\phpg\posx5884\posy10036\absw1222 \absh-202 {\f1\fs16 \cf1 \b Total: \par}}
{\do \dobxpage\dobypage \dpline \dplinew20 \dpptx0 \dppty0 \dpptx10038 \dppty0 \dpx707 \dpy9713 \dpxsize10038 \dpysize0
}
{\pard \qr \pvpg\phpg\posx676\posy3132\absw9532 \absh-274 {\f1\fs24 \cf1 Buenos Aires, 19 de Mayo de 2008\par}}
{\pard \qc \pvpg\phpg\posx645\posy2294\absw10072 \absh-285 {\f1\fs24 \cf1 \b GOBIERNO DE LA CIUDAD AUTONOMA DE BUENOS AIRES\par}}
{\pard \ql \pvpg\phpg\posx729\posy6770\absw2078 \absh-187 {\f1\fs16 \cf1 \b Repartición Solicitante:\par}}
{\pard \ql \pvpg\phpg\posx2858\posy6777\absw4515 \absh-173 {\f1\fs16 \cf1 \par}}
}
{\sect \sbkpage
{\pard \pvpg\phpg\posx4753\posy224\absw1560\absh59650323 {\pict \picw78\pich100\dibitmap\wbmbitspixel8\wbmplanes1\wbmwidthbytes10\picwgoal1560\pichgoal2000
\picscalex88\picscaley88
280000004e00000064000000010008000000000000000000130b0000130b00000000000000000000
0000000000008000008000000080800080000000800080008080000080808000c0c0c0000000ff00
00ff000000ffff00ff000000ff00ff00ffff0000ffffff0000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000000000000000000000000000000000000000000000000000000000000000000000000000
00000000330000006600000099000000cc000000ff00000000330000333300006633000099330000
cc330000ff33000000660000336600006666000099660000cc660000ff6600000099000033990000
6699000099990000cc990000ff99000000cc000033cc000066cc000099cc0000cccc0000ffcc0000
00ff000033ff000066ff000099ff0000ccff0000ffff000000003300330033006600330099003300
cc003300ff00330000333300333333006633330099333300cc333300ff3333000066330033663300
6666330099663300cc663300ff66330000993300339933006699330099993300cc993300ff993300
00cc330033cc330066cc330099cc3300cccc3300ffcc330000ff330033ff330066ff330099ff3300
ccff3300ffff330000006600330066006600660099006600cc006600ff0066000033660033336600
6633660099336600cc336600ff33660000666600336666006666660099666600cc666600ff666600
00996600339966006699660099996600cc996600ff99660000cc660033cc660066cc660099cc6600
cccc6600ffcc660000ff660033ff660066ff660099ff6600ccff6600ffff66000000990033009900
6600990099009900cc009900ff00990000339900333399006633990099339900cc339900ff339900
00669900336699006666990099669900cc669900ff66990000999900339999006699990099999900
cc999900ff99990000cc990033cc990066cc990099cc9900cccc9900ffcc990000ff990033ff9900
66ff990099ff9900ccff9900ffff99000000cc003300cc006600cc009900cc00cc00cc00ff00cc00
0033cc003333cc006633cc009933cc00cc33cc00ff33cc000066cc003366cc006666cc009966cc00
cc66cc00ff66cc000099cc003399cc006699cc009999cc00cc99cc00ff99cc0000cccc0033cccc00
66cccc0099cccc00cccccc00ffcccc0000ffcc0033ffcc0066ffcc0099ffcc00ccffcc00ffffcc00
0000ff003300ff006600ff009900ff00cc00ff00ff00ff000033ff003333ff006633ff009933ff00
cc33ff00ff33ff000066ff003366ff006666ff009966ff00cc66ff00ff66ff000099ff003399ff00
6699ff009999ff00cc99ff00ff99ff0000ccff0033ccff0066ccff0099ccff00ccccff00ffccff00
00ffff0033ffff0066ffff0099ffff00ccffff00ffffff00ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffffffdbfefffffffefffffffffffffffffffffffffffffefffffff9ffffdbffffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffffefffffffffffffefffffffffefffffffffffffffff9ffffffdbfffffefffff9fffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
f9fffffffff9ffd5fffffffffffff9fea37e4c282828282828525af9ffffffffffffdbfffedbffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fefffff9dbfffffffffffff9fe4d2e282828282828282f282f284c282828d4fffff9fffffffff9ff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffffffeffffffd428292828282828282828282828282828282e282e282828d4ffdbffdbffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffffffffff282e2828284c2e284c2828282828292e282e282828282828282828cefffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffef9fff9ff2e28282828292828284c2853a9dbffffffffa9a3282e282828282828282828fffff9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffffdb282828282928282953d4f9ffdbffffffffffffffdbfffff95a28282828282828287eff
ffffffffffffffffffffffffffffffffffffffffffff0000fffffffffffffffffffffff9fffffeff
ffffff5328282828282828d3fffffffecdceafa9a9a9a9a9a9d3f9fffeffffd528282829282e2828
fffffffffeffffffffffffffffffffffffffffffffff0000ffffffffffffffffdbfffffffffffff9
ffdb282828282e284caaa829282828282e28282828282828282828282828287ed4d4282828282f28
28ffdbffffffffdbffffffffffffffffffffffffffff0000fffffffffffffffffffefffffef9ffff
ff4c284d2828282828282828282f2828282828282828282e282e2828282f2828284c2828284c282f
2828fffffefffeffffffffffffffffffffffffffffff0000ffffffffffffffffffffdbfeffffffd4
282928282828d4dbfe7f7d5a2e282828282828282828282828282828282828282828282853282828
282828ffdbffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffff4c
29284c28a3fffeffffffdbfff9ffffffffffffffffffdbffffffffffdbfffffffffffffffeffff28
2928284cfff8ffffffffffffffffffffffffffffffff0000ffffffffffffffffffdbfffffeff2828
284c28daffffdbced4a95229284d28282828282828282828282828282e282fa985afffffdbfff9ff
282e282828ffdbffffffffffffffffffffffffffffff0000ffffffffffffffffffffffdbff2f2829
2828292828284c2e2829282828282828282828282828282828282e28284c2828282828282828287d
f92828282828feffffffffffffffffffffffffffffff0000ffffffffffffffffffffffff7e282828
4d2e4d282829282828282828282828282828282828282828282828282828282e2828282828284c28
28282828282953ffffffffffffffffffffffffffffff0000ffffffffffffffffffffdbd428282828
28fffff9fffffff9ffffd45a7d7e28282828282828282e2828282828282828282829537ea284daff
fffe2828282828dbfffffffffffff9ffffffffffffff0000fffffffffffffffffefffe2828284c28
fffffeffffd4fffffffffffffff9feffffffffdbfffffff9ffffffffffffffffffffffffffffffdb
ffffff2828282828ffffdbffdbffffffffffffffffff0000ffffffffffffffffffdbd428292828ff
fffffefffffffff9feced453775a53532e282828282828282e2f532f5385d4d5fefffefffffffeff
ffffffff28282829feffffffffffffffffffffffffff0000ffffffffffffffffffff2828282885a3
522e28282828282e4c282928284c284c282828282828282828282852282828282828282928282985
affffff97e28282828ffdbf9fffffeffffffffffffff0000ffffffffffffffffff28282828a3f885
7828284d282828282828284c2828282828282828282828282828282828282828282828282e284c28
28282f28282928282852ffffffffffdbffffffffffff0000fffffffffffffff9fe2928284cffffff
fff9fffeffffffffd37faf28282828282828282828282828282828282828294c284c292828527fa9
a9fffffff9ff29282828fff9ffffffffffffffffffff0000fffffffffffffeff2828282ffeffffdb
fefffff9fffeffffffffffffffffffffffffffffffffffffffffffd5fffffffeffdbfeffffffffff
dbfffff9ffdbd452282828ffffffffffffffffffffff0000ffffffffffffffdb2e28284dfffeffff
ffdbffffffffffafaad3ce5352522f52292f4c2e4c2f29292e29284da9ceafa9fffffffffffffeff
ffffffffdbffff2828282ef9fffffeffffffffffffff0000feffffffffffff28292828ff7ea22828
28282828282829282828282828282828282828282828282828282828282828282828282828282828
537efffffffff9db2828284dffffffffffffffffffff0000fffffeffffdbff2e2828284d4d282828
282828282f28282828282828282828282828282828282828282828284c2828282828282828282828
2828282828282828282f2828fffffeffffffffffffff0000fff9ffffdbff28282928cefffffffeff
fffffef9da7e5a532828282828282828282828282828282828282e2828282828282828284d2e2828
2828282e537ea2782f2828287edbffffffffffffffff0000fefffffffffe28282829ffdbffffdbff
fff9ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffdbf9ffff
ffffffffffffffffd428284d2effffffffffffffffff0000fffffeffff5229282ed3ffffffdbfffe
ffdbffb0ceaf292e2e285228282828282828282828282828282828294c282fcea9b0f8fffffffffe
dbffffdbffffffffff4c282828f9feffffffffffffff0000ffffffffff282828287e292829284c28
292828282928282828282828284c2828282828282828282829282828282828282828282828282828
2852785af8f9ffdbff8528282e4dffffffffffffffff0000ffffffdbff28282878d4b04c4d282852
2828285228282f282828282828282828282828282828282828282828282e4c282828282828282828
282828282828284c28282e282828ffffffffffffffff0000ffffffff4c282828fffffeffffffffff
ffffffffdbff777d785928282828284c28282828282828282e282829282828282828282828282828
284c2829597d7e77fff953292828ffffffffffffffff0000ffffffff29282928ffffffffffffffff
ffffffffffffffdbfffffffffffffffffffefffffffffffefffffffffeffffffdbffffffffffffff
ffdbfffffffff9fffffffe282e287dffffffffffffff0000fefffffe28282877fffffff9ffffffff
ffffffdbdadba9a87e7e7e7e7e7e7e7e5a4d282828537d7d785a787e787da3f9dbf9fefff9ffffff
fffff9fffffeffffffffff28282828ffffffffffffff0000ffffffa22928285a53534d2f28282828
282e28282828282828282828282828282928282828282828282e2828282828282828284c2828284c
285352aacef8ffdbfff9fe2f292828ffffffffffffff0000fff9ff28282828534c2e282828282828
2828282852284c282828285228282828282828282828282828282828282e28282828282828282828
2828282e282e284c2829282e28282ffeffffffffffff0000ffdbff28282852fffffffff9ffffffff
fff9ffffd5d5d4f97e785a532e282e28282828284c28282828282828284c282e2828282828282828
2877787d78537ff8daf9feff292828a2ffffffffffff0000ffffff282829d4dbffffffffdbfffff9
ffffffffffffffdbfffff9fffffefffffffffff9fffffffff8ffffffffffffffdbffffffffffffff
fffffedbffffffffffdbf9ff282e2828ffffffffffff0000ffdbff4c2828ffffffffffffffffffff
fffe7e5a7e547e2829284c2e2828282828284c2828282829284c547e5a7d7ed4feffffffffffffff
f9fffffffffffefffffeffff284c2828ffffffffffff0000ffffff28282828282828282828282828
282828282828282828282828282828282e2828282828282828282828282828292828282828282828
5228524c2eced4fffffffffe2e282828ffffffffffff0000ffffff282e287e4c28282828284c2828
282828282928282828282828282828282828282828282828282828282828282e28282828282f2828
28282828282828282828284c28282828ffffffffffff0000fff9a9282829ffffffffffffffdbf9fe
aab0cd2f4c2e282e282828282828282828282828282828284c2828282828282828282e284c282828
2828284c282828282852284d28282828ffffffffffff0000f9db53282828dbfffffffffffffffff9
fffffffffff9fff9fffff9daf8fedaf9dbfefed5dbfedbdadbdbf9daf9dbd5dbf8ffd5fed5dbf9db
ffffffffffffffffdbffffffb0282828ffffffffffff0000ffff28282953ffffdbffffffffffffff
ffffdbceafcda9cdafaad3b0b0ced3b0cea9cea9a9a9cdaaafcdd3b0fefffffffffffeffffffffff
ffdbffffffffdbfffffffffed3282828ffffffffffff0000ffff2828282852282828282828282828
282828282828282f2828282828282828282e29282828282828282828284d28282828292e28282828
284c282828297885cefffff97f2e2828ffffffffffff0000ffdb282828282928282e282828282828
2828282e28284c28282e28282828284c2828282828282828294c282828282828282e282828282829
2828282828282828284d285228282828ffffffffffff0000ffff2828282828282828282828282828
28282828282828fffffeceb0cecd5428294c2f292e4d2e28522e292f29524d2f4d287e7eb0282828
28282828282828282828282828284c28ffffffffffff0000ffff28282828282e2828282828282828
2828282828282884f9fffffffffff9ffffffffffffffffffffffffffffffffffffdbffff2e282928
28284c28282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
282828282e282828ffffffffffdbfffffff9ffffffffffffdbfffff9fffffff9ffffffdb282e2828
28282828282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
28282e282928282828282828282e28284c282828282e2852522f53535353282f5328282828282828
28282828282828282828282828282828ffffffffffff0000ffdb2828282828292828282828282828
2828282f2828285228282852282829282828282829284c28282829282828284c2e28292828282928
28282828282828282828282828282828ffffffffffff0000fff92828282828282828282828282828
282828284d282828fffffffffffefffffffffffffffffefffefffff9fffffffff9ffff2e28282828
28282828282828282828282828282828ffffffffffff0000ffff2828282828282828282828282828
282828282828285af9ffdbfffffffffffffffefff9fff9fffffffffffffffffeffffdba928282828
28282828282828282828282828282828ffffffffffff0000ffff4c28282828282828282828282828
28282e28282f28ffffff4c2f28284c28282828294d537e5a7e54537d7d535353d4ffffff28282e28
28282828282828282828282828282828ffffffffffff0000ffff4c28282828282828282828282828
282828284d28fffff9af2828282828282f282e292828282828284d28282828282ef9ffffd4282828
28282828282828282828282828282828ffffffffffff0000ffff2f28282828282828282828282828
28cdffffffffffffff2828284c2928ffffff28ffffffff28ffd4fe28282828282828ffffffff282e
28282828282828282828282828282828ffffffffffff0000ffffaf2828284c282828282828282828
29a9ffffffffffffff282828282828feffff28d5ffff7e28fffff928282828282828ffffffffffdb
ffff4c28282828282828292828284c28ffffffffffff0000fffeff282e2828282828282828282828
282828282828282828284c284d2828dbffff2884ffff2f28ffff7e282828282829282f2e2e4c5353
52532828282828282828282828282977ffffffffffff0000ffffff28282828282828282828282828
2828282829282828282829282828287dffff284cf9ff2828dbff28284c282828284c28282e282828
2828282828282828282e2828282828b0ffffffffffff0000fffff92828284c282828282828282828
28282828282828285228282828282e28fff92828ffff28287eff282928282828282f282928282828
2f28292828282828282828282e2828ffffffffffffff0000dbffff2828282e282828282828282828
4c2e282828282828282828284c28284dffa22828ffff29284ddb2828282828284c28282828282828
282828282828282828282e28282828ffffffffffffff0000ffffff28282928282828282828282828
282828282e282828284c28282e282828ff292828fffe282828fe2e282828282828284c2828282828
285228282828282828282828282e53dbffffffffffff0000fff9ff5328284c282828282828282828
2e4c2828282828282828282828282828ff285228fff928284cff292828282828282829282828284c
2828282829282828282828282828ceffffffffffffff0000ffffffd42e2828282828282828282828
28282828295228282829282e28282828ff292828f9d4282828db2828282828282828282828282828
2828282828282928282828282828ffffffffffffffff0000ffffffff282828282828282828282828
28282828282828282828284c2828282eff282828d4a8282828ff28282828282e2828282828282828
2828282828282828284c28282928f9ffffffffffffff0000fff9ffff282828282828282828282828
28282828282828282829282828282828ff282e28db5a282828db2828282828282828282828282828
282828282828282828282828287effffffffffffffff0000ffffffffa92e29282828282828282828
2828282828282828282e28284d282828f9282828f853282828db2829282828282828282828282828
28282828282828282828282828ffffffffffffffffff0000ffffdbffff2828282828282828282828
2828282828282828284c28282828282eff282828d4534c2828ff282828282f282828282828282828
282828282828282828282e2828ffffffffffffffffff0000fff9ffffff2928282828282828282828
2828282828282828282828284c282928ff282828d5532e2828ff28282828282e2828282828282828
28282828282828282828282885ffffffffffffffffff0000ffffffffffd328282828282828282828
28282828282828282828282828282828ff282828f95228284df92828282828282828282828282828
282828282828282828282828ffffffffffffffffffff0000fffffffeffff2e282828282828282828
282828282828282828284c282828285aff532928db542828a8ff2828282828282828282828282828
282828282828282828282853ffffffdbffffffffffff0000ffffffffffdb7d282828282828282828
2828282828282828282828282f2828d5ffa92828ffa22828ffff2828284c28282828282828282828
282828282828282828282ffeffffffffffffffffffff0000ffffffffffffff28285228284c282828
282828282828282828282828282828ffffff2828ff852828ffff2828282928282828282828282828
28284c2828282828282828ffffffffffffffffffffff0000fffffffffffff95a2828292829282828
28282828282828282828284d2e2828feffff284cffd52828fef92928282828282828282828282828
282852282828284c2f28ffdbffffffffffffffffffff0000ffffffdbfffffffe2828282828282828
282828282828282828282828284c53fff9ff2828ffff28d4ffff7d282828284c2828282828282828
282828282e282828284cfff9ffffffffffffffffffff0000fffeffffffffffff4d2e282828292828
2828282828282828282f28282828282e4c28527efff92e2828282828282828282828282828282828
282828284c28282829f9fffffefffff9ffffffffffff0000ffffffffdbfff9ffff28282e28282928
282828282828282828282828284c2828282828ffffff282e28282828282852282828282828282828
2828282e28284c287effffdbf9fffeffffffffffffff0000ffffffffffffffffffd5522828282828
28282828282828282828282828282828284d2efeffdb282e28282828282828282828282828282828
2e28282828282828fffefffffffffeffffffffffffff0000fffffffffffffff9ffdb28284c28282f
28282828282828284c28282828282829282828d4d4ce2828282828282e2828282828282828282828
2828282828282853ffffffffffffffffffffffffffff0000ffffffdbffffffffffffff2928282828
2828282828282828282828282828282828282e2828282e2828292828282828282828282828282828
4c28282828284ddbf9fffff9ffdbffffffffffffffff0000ffffffffffffffffffffff53284c2828
28d42e284c2f2828284c2828282828282828282828282828282828292828282828284c2829282828
77282e282828ffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffff28282928
284cff29282828284c282828282e2828282928282828294c292828282828292828282828282828a3
2828282828ceffffffffffffffffffffffffffffffff0000ffffffffffffffffffdbffffff282828
2829a3f9ff4c28282828282828284c28282828284c282828282828282828282828282928287eff28
28284c287dfffff9ffffffffffffffffffffffffffff0000ffffffffffffffffffffdbffffff2828
28282953fffff9522828282829282828282828282828282828282e28282828282828287edbff2828
2828282ff9fffeffffffffffffffffffffffffffffff0000fffffffffffffffffff9fffffeffff28
2828282828d4fffffeff28284c2828282829284c282828282828282829282e287dffffff52282828
5228a9ffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffdbffdafffffffff9
28292828282852ffffffffffce2852292828282828282829282828282853fefffeffd4284d292828
28a8fffffffeffffffffffffffffffffffffffffffff0000fffffffffffffffffffffffffff9ffff
ff28284c2828282885ffffdbfefffff9a97e53292e4c282853a9fffffffefff8ff282f2828282828
aaffffdbfffffff8ffffffffffffffffffffffffffff0000ffffffffffffffffffdbffffffffffff
fffe282828284c284c28ffffffffffffffffffffffffffffffffffdbffdbff5a28282828284c2878
fffefffff9fffeffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
dbffff284c28282828282e28d3fffffefffffffff9fffeffffdbffffff522828282828282828d4f9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
ffffffff542828282828282828282ea9ffffdbffffffdbf9ffa92828282828282828282828ffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
dbffdbffffff28284d282828282828282829282828282828282828284c282829282828cefff9fff9
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffefffffefff92829282828282828282828292828524c284c4c2e2852282e2878fffeffffffff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fff9fffffffff8fffff97e2829282828282828282828282828282828282853dbfefffffffffffeff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
f9fffffffffffff9fffffffeff532828282828285228282828282e4dd4ffffffffffdbfffffff9ff
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fefffff9fff9fefff9fffffffff9ffffffa9a8772852a9a3dbffffffffffdbfffffffeffffffffdb
ffffffffffffffffffffffffffffffffffffffffffff0000ffffffffffffffffffffffffffffffff
fffffffefffffffffffffffffffffffffffffffffff9fffff9fffffff9ffffffdbfffffff9ffffff
ffffffffffffffffffffffffffffffffffffffffffff0000} \par}
{\pard \qc \pvpg\phpg\posx643\posy2718\absw10127 \absh-274 {\f1\fs24 \cf1 DICTAMEN DE EVALUACIÓN DE OFERTAS Nº 530 / 2008\par}}
{\pard \qc \sl163 \pvpg\phpg\posx3803\posy15075\absw3915 \absh-405 {{\f1\fs18 \cf1 Pág. }{\f1\fs18 \cf1 2}{\f1\fs18 \cf1  de }{\f1\fs18 \cf1 2\par}}
}
{\pard \ql \pvpg\phpg\posx706\posy3740\absw1124 \absh-215 {\f1\fs16 \cf1 \b Aprobación:\par}}
{\pard \ql \sl149 \pvpg\phpg\posx711\posy6462\absw9786 \absh-1463 {{\f1\fs16 \cf1 \b Anuncio de preadjudicación: }{\f1\fs16 \cf1 Art. 48.1 del Decreto 408/GCBA/07 reglamentario de 108 de la Ley 2.095.-\par}}
{{\f1\fs16 \cf1 \b Exposición:\par}}
{{\f1\fs16 \cf1 \b Fecha Iniciación:\par}}
{{\f1\fs16 \cf1 \b Fecha Terminación:\par}}
{{\f1\fs16 \cf1 \b Publicación: }{\f1\fs16 \cf1  Art. 48.1 del Decreto 408/GCBA/07 reglamentario de 108 de la Ley 2.095.-\par}}
{{\f1\fs16 \cf1 \par}}
{{\f1\fs16 \cf1 \b Confeccionó:  \par}}
}
{\pard \ql \pvpg\phpg\posx709\posy3167\absw2524 \absh-213 {\f1\fs16 \cf1 \b Vencimiento validez de oferta: \par}}
{\pard \ql \pvpg\phpg\posx704\posy3450\absw968 \absh-215 {\f1\fs16 \cf1 \b Imputación: \par}}
{\pard \ql \pvpg\phpg\posx1793\posy3440\absw8602 \absh-187 {\f1\fs16 \cf1 El gasto que demande la presente contratación deberá imputarse a la partida presupuestaria del ejercicio en vigencia.\par}}
{\pard \ql \pvpg\phpg\posx1851\posy7617\absw1614 \absh-172 {\f1\fs16 \cf1 LINGRASSIA\par}}
{\pard \ql \pvpg\phpg\posx3249\posy3162\absw937 \absh-187 {\f1\fs16 \cf1 \par}}
}}';
											
		header( "Content-Type: application/octet-stream"); 
		header( "Content-Disposition: attachment; filename=".$nombre_doc.""); 			
		print($contenido);
	}
?>