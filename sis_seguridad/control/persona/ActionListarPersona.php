<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPersona.php
Propósito:				Permite realizar el listado en tsg_persona
Tabla:					t_tsg_persona
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-26 17:06:33
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarPersona.php';

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

	if($sort == '') $sortcol = 'apellido_paterno';
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
	
	if($txt_id_persona==1){
				
		$criterio_filtro= $criterio_filtro. " AND PERSON.id_persona not in(select id_persona from tsg_usuario)";
	}
	if($txt_empleado_persona==1){
		$criterio_filtro= $criterio_filtro. " AND PERSON.id_persona not in (select id_persona from tkp_empleado)";
	}
	
	//24jun11 -> adicion para gestion_hora_vida(KARD)
	if($empleado==1){
		if($_SESSION['ss_id_empleado']!='' && $_SESSION['ss_id_empleado']!=null && $_SESSION['ss_id_empleado']!=undefined){
			$id_e=$_SESSION['ss_id_empleado'];
		}else{
			$id_e=0;
		}
		$criterio_filtro= $criterio_filtro. " AND PERSON.id_persona in (select id_persona from tkp_empleado where id_empleado=$id_e)";
	}
	
	// adicion de filtro para busqueda de personas de acuerdo a la carrera estudiada (29jun11)
	if(isset($id_carrera) && $id_carrera!=''){ 
		$mi_join;
		$cons;
		if($id_carrera<=0){//listar todos
			
			/*if($id_carrera==0){
				$mi_join='is not null';
				$cons='in';
			}else{
				$mi_join='is null';
				$cons='not in';
			}
			
			$criterio_filtro=$criterio_filtro. " and (PERSON.id_persona ".$cons." (select e.id_persona from kard.tkp_empleado e inner join kard.tkp_empleado_capacitacion ec
on e.id_empleado=ec.id_empleado where ec.id_carrera ".$mi_join.")
or (
PERSON.id_persona ".$cons." (select ecc.id_persona from kard.tkp_empleado_capacitacion ecc where ecc.id_carrera ".$mi_join.")

))";		*/
			$criterio_filtro=$criterio_filtro;
	}else{
		$criterio_filtro=$criterio_filtro. " and (PERSON.id_persona in (select e.id_persona from kard.tkp_empleado e inner join kard.tkp_empleado_capacitacion ec
 on e.id_empleado=ec.id_empleado where ec.id_carrera=$id_carrera)
or (
PERSON.id_persona in (select ecc.id_persona from kard.tkp_empleado_capacitacion ecc where ecc.id_carrera=$id_carrera)

))";}
		
	}
	
	
	if(isset($id_uo) && $id_uo!=''){
		
		if($id_uo<=0){//todos o ninguno
			if($id_uo==0){//todos
				$criterio_filtro=$criterio_filtro. " AND PERSON.id_persona in (select id_persona from kard.tkp_empleado where kard.f_kp_obtener_gerencia_x_funcionario(id_empleado,null)>0)";
			}else{//externo - no pertenece a la empresa
				$criterio_filtro=$criterio_filtro. " AND PERSON.id_persona not in (select id_persona from kard.tkp_empleado where estado_reg='''activo')";
			}
		}else{
		 $criterio_filtro=$criterio_filtro. " AND PERSON.id_persona in (select id_persona from kard.tkp_empleado where   kard.f_kp_obtener_gerencia_x_funcionario(id_empleado,null)=$id_uo)";
		}
	}
	
	
	//filtro de personal/candidato/todos en busqueda de gestion de hoja de vida [13jul11]
	if(isset($es_empleado) && $es_empleado!=''){
		if($es_empleado=='empleado'){
			 $criterio_filtro=$criterio_filtro."  and PERSON.id_persona in
		                   						(select id_persona from kard.tkp_empleado where estado_reg=''activo'')";
		}elseif ($es_empleado=='candidato'){
			$criterio_filtro=$criterio_filtro."  and (PERSON.id_persona not in
                           
                           (select id_persona from kard.tkp_empleado)
                           
                           and PERSON.id_persona in (select id_persona from kard.tkp_empleado_capacitacion ))";
		}elseif ($es_empleado=='todos'){
			$criterio_filtro=$criterio_filtro;
		}
	}
	
	
	/*listar personas que figuren en relacion familiar*/
	if(isset($relacion_familiar) && $relacion_familiar!=''){
		if($relacion_familiar=='si'){
			$criterio_filtro=$criterio_filtro. " and PERSON.id_persona in (select id_persona from kard.tkp_relacion_familiar where estado_reg=''activo'')";
		}
	}
	
	/*filtrado de personas que tienen relacion con la persona identificada en relacion familiar*/
	if(isset($id_pariente) && $id_pariente!=''){
		if($id_pariente>0){
			$criterio_filtro=$criterio_filtro. " and PERSON.id_persona = (select e.id_persona  from kard.tkp_empleado e inner join kard.tkp_relacion_familiar r
                            on r.id_empleado=e.id_empleado  where r.id_persona=$id_pariente)";
		}else{
			$criterio_filtro=$criterio_filtro;
		}
	}
	
	
	/*filtrado por tipo de contrato*/
	if(isset($tipo_ctto) && $tipo_ctto!=''){
		if($tipo_ctto!='todos'){
			$criterio_filtro=$criterio_filtro. " and PERSON.id_persona in (select e.id_persona  from kard.tkp_empleado e inner join kard.tkp_contrato c
                            on c.id_empleado=e.id_empleado  where c.tipo_contrato=''$tipo_ctto'' and c.estado_reg=''activo'')"; 
		}else{
			$criterio_filtro=$criterio_filtro;
		}
	}
	
	
	 /* instituciones en las que trabajo*/
	 if(isset($id_institucion_trabajo) && $id_institucion_trabajo!=''){
	 	if($id_institucion_trabajo>0){
	 		$criterio_filtro=$criterio_filtro." AND (PERSON.id_persona in (select e.id_persona  from kard.tkp_empleado e inner join kard.tkp_empleado_trabajo et
                            on et.id_empleado=e.id_empleado  where et.id_institucion=$id_institucion_trabajo)
                            or (PERSON.id_persona in (select id_persona from kard.tkp_empleado_trabajo where id_institucion=$id_institucion_trabajo))
                            )"; 
	 	}else{
	 		$criterio_filtro=$criterio_filtro;
	 	}
	 }

	//Obtiene el total de los registros
	$res = $Custom -> ContarPersona($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		if(isset($relacion_familiar)){
	
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_persona',0);
			$xml->add_nodo('apellido_paterno','Ninguno');
			$xml->add_nodo('apellido_materno','');
			$xml->add_nodo('nombre','');
			$xml->fin_rama();
		}
       if($oc == 'si'){
		    $xml->add_rama('ROWS');
			$xml->add_nodo('id_persona','%');
			$xml->add_nodo('apellido_paterno','Todos');
			$xml->add_nodo('apellido_materno','Todos');
			$xml->add_nodo('nombre','Todos');
			$xml->add_nodo('fecha_nacimiento','Todos');
		//	$xml->add_nodo('foto_persona', $f["foto_persona"]);
			$xml->add_nodo('doc_id','Todos');
			$xml->add_nodo('genero','Todos');
			$xml->add_nodo('casilla','Todos');
			$xml->add_nodo('telefono1','Todos');
			$xml->add_nodo('telefono2','Todos');
			$xml->add_nodo('celular1','Todos');
			$xml->add_nodo('celular2','Todos');
			$xml->add_nodo('pag_web','Todos');
			$xml->add_nodo('email1','Todos');
			$xml->add_nodo('email2','Todos');
			$xml->add_nodo('email3','Todos');
			$xml->add_nodo('fecha_registro','Todos');
			$xml->add_nodo('hora_registro','Todos');
			$xml->add_nodo('fecha_ultima_modificacion','Todos');
			$xml->add_nodo('hora_ultima_modificacion','Todos');
			$xml->add_nodo('observaciones','Todos');
			$xml->add_nodo('id_tipo_doc_identificacion','%');
			$xml->add_nodo('desc_tipo_doc_identificacion','Todos');
			$xml->add_nodo('desc_per','Todos');			
			$xml->add_nodo('direccion','Todos');	
			$xml->add_nodo('nro_registro','Todos');	
			$xml->add_nodo('nombre_foto','Todos');					
			$xml->add_nodo('extension','Todos');
			$xml->add_nodo('numero','Todos');
			
			$xml->add_nodo('id_empleado','%');	
			$xml->add_nodo('expedicion','Todos');

			$xml->add_nodo('usuario_reg','Todos');
			
			
			//24.04.2014: adicion de 2 campos para atender req de rrhh 
			/*
			 $xml->add_nodo('apellido_casada','Todos');
			 $xml->add_nodo('libreta_militar','Todos');
			 * */
			$xml->fin_rama();
		}
//$xml->add_nodo('foto_persona',$f["foto_persona"]);
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('apellido_paterno',$f["apellido_paterno"]);
			$xml->add_nodo('apellido_materno',$f["apellido_materno"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('fecha_nacimiento',$f["fecha_nacimiento"]);
		//	$xml->add_nodo('foto_persona', $f["foto_persona"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('genero',$f["genero"]);
			$xml->add_nodo('casilla',$f["casilla"]);
			$xml->add_nodo('telefono1',$f["telefono1"]);
			$xml->add_nodo('telefono2',$f["telefono2"]);
			$xml->add_nodo('celular1',$f["celular1"]);
			$xml->add_nodo('celular2',$f["celular2"]);
			$xml->add_nodo('pag_web',$f["pag_web"]);
			$xml->add_nodo('email1',$f["email1"]);
			$xml->add_nodo('email2',$f["email2"]);
			$xml->add_nodo('email3',$f["email3"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('hora_registro',$f["hora_registro"]);
			$xml->add_nodo('fecha_ultima_modificacion',$f["fecha_ultima_modificacion"]);
			$xml->add_nodo('hora_ultima_modificacion',$f["hora_ultima_modificacion"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('id_tipo_doc_identificacion',$f["id_tipo_doc_identificacion"]);
			$xml->add_nodo('desc_tipo_doc_identificacion',$f["desc_tipo_doc_identificacion"]);
			$xml->add_nodo('desc_per',$f["desc_per"]);			
			$xml->add_nodo('direccion',$f["direccion"]);	
			$xml->add_nodo('nro_registro',$f["nro_registro"]);	
			$xml->add_nodo('nombre_foto',$f["nombre_foto"]);					
			$xml->add_nodo('extension',$f["extension"]);
			$xml->add_nodo('numero',$f["numero"]);
			
			$xml->add_nodo('id_empleado',$f["id_empleado"]);	
			$xml->add_nodo('expedicion',$f["expedicion"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);

			//24.04.2014: adicion de 2 campos para atender req de rrhh 
			
			 $xml->add_nodo('apellido_casada',$f["apellido_casada"]);
			 $xml->add_nodo('libreta_militar',$f["libreta_militar"]);
			 $xml->add_nodo('num_complementario_doc_identif',$f["num_complementario_doc_identif"]);
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
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