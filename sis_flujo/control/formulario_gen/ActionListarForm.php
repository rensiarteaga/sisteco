<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarTipoNodo.php
Propósito:				Permite realizar el listado en tfl_tipo_nodo
Tabla:					tfl_tipo_nodo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-16 14:58:47
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarForm.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	//Obtiene el criterio de orden de columnas
	if($sort == '') $sortcol = 'id_atributo_tipo_nodo';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	/////////////////Ariel Ayaviri Omonte	
	//OBTENEMOS EL ID DEL FORMULARIO QUE SE MOSTRARÁ.
	
	$res = $Custom->ListarTipoProceso(1,0,'id_tipo_proceso asc','asc'," TIPPRO.id_tipo_proceso = $m_id_tipo_proceso and TIPPRO.estado = ''finalizado'' ",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res){
		foreach($Custom->salida as $f){
			$id_tipo_nodo_inicio = intval($f['id_nodo_inicio']);
			$id_tipo_formulario = intval($f['id_formulario_inicio']);
		}
	}
	if(!isset($id_tipo_nodo_inicio)&& !isset($id_tipo_formulario)){
		//El proceso no esta finalizado
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = "El proceso no está finalizado.";
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
	//Obtenemos el id del empleado a partir del id de usuario
	$res = $Custom->ObtenerIdEmpleado(1,0,'id_empleado asc','asc'," and 0=0");
	
	if($res){
			foreach($Custom->salida as $f){
				$id_empleado = intval($f['id_empleado']);
			}
	}
	
	//booleano que controla los botones del menu
	$flagMenu = 'false'; //para definir si el usuario puede iniciar un proceso o no.
	
	//Obtenemos los id de los nodos que le corresponden a este empleado
	$res = $Custom->ListarTipoNodoEmpleado(1000,0,'id_tipo_nodo asc','asc'," TINOEM.id_empleado = ".$id_empleado);  
	if($res){
		$id_tipo_nodo = array();
		$i = 0;
		foreach($Custom->salida as $f){
			$id_tipo_nodo[$i] = intval($f['id_tipo_nodo']);
			if($id_tipo_nodo[$i]==$id_tipo_nodo_inicio){
				$flagMenu = 'true';
			}
			$i++;
		}
	}
	if(count($id_tipo_nodo)==0){
		//El proceso no esta finalizado
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = "El usuario no tiene permisos para este proceso.";
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}

	if(!isset($criterio_filtro)){
		$criterio_filtro = ' 0=0 ';
	}
	if(isset($id_tipo_formulario)&&(count($id_tipo_nodo)>0)&&isset($id_empleado)){
		//obtenemos el id del nodo que tenga mayor cantidad de atributos para mostrarlo
		$total_registros=0;
		for($k=0;$k<count($id_tipo_nodo);$k++){
			$crit_filtro_aux=" TIPATR.id_tipo_formulario = $id_tipo_formulario and ATRTIPNOD.id_tipo_nodo = $id_tipo_nodo[$k] and ATRTIPNOD.visible = ''si'' ";
			$res = $Custom->ContarAtributoTipoNodoForm($cant ,$puntero,$sortcol,$sortdir,$crit_filtro_aux);
			if($res){
				if(intval($Custom->salida)>$total_registros) {
					$total_registros = intval($Custom->salida);
					$id_tipo_nodo_mayor = $id_tipo_nodo[$k];
				}
			}
			else{
				//ocurrió un error
				$resp = new cls_manejo_mensajes(true,'406');
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		
		$criterio_filtro.=" and TIPATR.id_tipo_formulario = $id_tipo_formulario and ATRTIPNOD.id_tipo_nodo = $id_tipo_nodo_mayor";
		
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarAtributoTipoNodoForm($cant,$puntero,'id_atributo asc','asc',$criterio_filtro);
		
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
			$i = 0;
			$j = 0;
			foreach ($Custom->salida as $f)
			{
				$varJson[$i]->validacion->name="ids_adicional_$j";
				$varJson[$i]->validacion->labelSeparator='';
				$varJson[$i]->validacion->inputType='hidden';
				$varJson[$i]->validacion->grid_visible=false;
				$varJson[$i]->validacion->grid_editable=false;
				
				$varJson[$i]->tipo='Field';
				$varJson[$i]->form = true;
				//$varJson[$i]->filtro_0=true;
				//$varJson[$i]->filterColValue='TIPNOD.nombre';
				$varJson[$i]->save_as = "ids_adicional_$j";
				
				$i++;
				
				$varJson[$i]->tipo=$f['tipo_field'];
				if($varJson[$i]->tipo == "ComboBox"){
					$auxValores = explode("#",$f['valores_combo']);
					if(count($auxValores)>0){
						$store = "new Ext.data.SimpleStore({
						fields: ['".$f['valor']."', '".$f['display']."'],
						data : [";
						
						$store.="['".$auxValores[0]."','".$auxValores[1]."']";
						for ($k=2;$k<count($auxValores);$k++){
							$store .= ",['".$auxValores[$k]."'";
							$k++;
							$store.=",'".$auxValores[$k]."']";
						}
						
						$store.="]})";
						$varJson[$i]->validacion->valueField=$f['valor'];
						$varJson[$i]->validacion->displayField=$f['display'];
						$varJson[$i]->validacion->triggerAction='all';
						$varJson[$i]->validacion->store=$store;
						$varJson[$i]->lazyRender= true;
						$varJson[$i]->forceSelection = (mb_strtolower($f['opcional'])=='si')? true : false;
						$varJson[$i]->typeAhead= true;
						$varJson[$i]->loadMask= true;
					}
				}
				
				$varJson[$i]->validacion->name=$f['nombre'];
				$varJson[$i]->validacion->fieldLabel=$f['label'];
				$varJson[$i]->validacion->allowBlank=(mb_strtolower($f['opcional'])=='si')? true : false;
				$varJson[$i]->validacion->maxLength=200;
				$varJson[$i]->validacion->minLength=0;
				$varJson[$i]->validacion->selectOnFocus=true;
				//$varJson[$i]->validacion->vtype=$f['tipo_datos'];
				$varJson[$i]->validacion->grid_visible=(mb_strtolower($f['visible'])=='si')?true:false;
				$varJson[$i]->validacion->grid_editable=false;
				$varJson[$i]->validacion->width_grid=200;
				$varJson[$i]->validacion->width='85%';
				$varJson[$i]->validacion->disabled=(mb_strtolower($f['editable'])=='no')? true:false;
				$varJson[$i]->validacion->grid_indice=$f['orden'];
				
				$varJson[$i]->_id_atributo=$f["id_atributo"];
				$varJson[$i]->form = (mb_strtolower($f['visible'])=='si')?true:false;
				//$varJson[$i]->filtro_0=true;
				//$varJson[$i]->filterColValue='TIPNOD.nombre';
				$varJson[$i]->defecto = $f['valor_defecto'];
				$varJson[$i]->save_as = "valor_$j";
//				var_dump($varJson[$i]->_id_atributo);
//				var_dump($varJson[$i]->tipo);
//				var_dump($varJson[$i]->validacion->name);
				$i++;
				$j++;
			}

			//los atributos adicionales se tienen que poner al final de los generados
			$varJson[$i]->validacion->name='id_formulario';
			$varJson[$i]->validacion->labelSeparator='';
			$varJson[$i]->validacion->inputType='hidden';
			$varJson[$i]->validacion->grid_visible=false;
			$varJson[$i]->validacion->grid_editable=false;
			$varJson[$i]->tipo='Field';
			$varJson[$i]->form = true;
			$varJson[$i]->save_as = "id_formulario";
			
			$i++;
			
			//id del proceso
			$varJson[$i]->validacion->name='id_proceso';
			$varJson[$i]->validacion->labelSeparator='';
			$varJson[$i]->validacion->inputType='hidden';
			$varJson[$i]->validacion->grid_visible=false;
			$varJson[$i]->validacion->grid_editable=false;
			$varJson[$i]->tipo='Field';
			$varJson[$i]->form = true;
			$varJson[$i]->save_as = "id_proceso";	

			$i++;
			
			//id del tipo_nodo
			$varJson[$i]->validacion->name='id_tipo_nodo';
			$varJson[$i]->validacion->labelSeparator='';
			$varJson[$i]->validacion->inputType='hidden';
			$varJson[$i]->validacion->grid_visible=false;
			$varJson[$i]->validacion->grid_editable=false;
			$varJson[$i]->tipo='Field';
			$varJson[$i]->form = true;
			$varJson[$i]->save_as = "id_tipo_nodo";
			
			$i++;
			
			//estado del proceso
			$varJson[$i]->validacion->name='estado';
			$varJson[$i]->validacion->fieldLabel='';
			$varJson[$i]->validacion->grid_visible=true;
			$varJson[$i]->validacion->grid_editable=false;
			$varJson[$i]->tipo='TextField';
			$varJson[$i]->form = false;
			$varJson[$i]->save_as = "estado";
			

			$sJson=json_encode($varJson);
			
			//Se envían los resultados al main de la vista, separadosp or el simbolo #
			echo($sJson."@#@".$id_tipo_formulario."@#@".$id_tipo_nodo_inicio."@#@".$id_empleado."@#@".$flagMenu);
			//$xml->mostrar_xml();
			
			exit;
		}
		else
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true,'406');
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}
	else {
			//El proceso no esta finalizado
			$resp = new cls_manejo_mensajes(true,'406');
			$resp->mensaje_error = "El tipo proceso no está finalizado.";
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>