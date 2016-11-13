<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCorrespondenciaNodo.php
Propósito:				Permite realizar el listado en tfl_tipo_circuito
Tabla:					tfl_tipo_circuito
Parámetros:				$id_tipo_circuito
						$id_tipo_nodo_inicio
						$nombre_nodo_inicio
						$id_tipo_nodo_fin
						$nombre_nodo_fin

Valores de Retorno:    	Listado de tipos de circuitos y total de registros listados
Fecha de Creación:		2010-12-27 16:28:47
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarTipoCircuito.php';

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

	if($sort == '') $sortcol = 'id_tipo_circuito';
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
	
	//aumenta un criterio de busqueda de acuerdo al id del maestro.
	if(isset($m_id_tipo_nodo)){
		$criterio_filtro.="and TIPCIR.id_tipo_nodo_inicio = $m_id_tipo_nodo";}
	if(isset($maestro_id_tipo_proceso)){
		$criterio_filtro.="and TIPNOD.id_tipo_proceso = $maestro_id_tipo_proceso";}
	
	if(isset($m_id_tipo_nodo_inicio)){
		$criterio_filtro.=" and TIPCIR.id_tipo_nodo_inicio = $m_id_tipo_nodo_inicio";
	}
	if(isset($m_id_tipo_nodo_fin)){
		$criterio_filtro.=" and TIPCIR.id_tipo_nodo_fin = $m_id_tipo_nodo_fin";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TipoCircuito');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCorrespondenciaCircuito($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
	/*
	 * 17-02-2011 (aayaviri) Se adicionó 2 atrib: nombre_inicio y nombre_fin para reconocer los nombre del nodo_inicio y nodo_fin
	 */

	if($res)
	{
		$auxArray = array(); // almacena los id de los nodos
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		$destinos;
		$origenes;
		$j =0;
		$k =0;
		foreach ($Custom->salida as $f)
		{
			$auxArray[$i] = $f['id_corr_origen'];
			$origenes[$j][0] = $f['id_corr_origen'];
			$origenes[$j][1] = $f['numero_origen'];
			$origenes[$j][2] = $f['desc_empleado_origen'];
			if($f['desc_instit_origen']!=""&&$f['desc_instit_destino']!='NULL'){
				$origenes[$j][3] = $f['desc_instit_origen'];
			}
			else{
				$origenes[$j][3] = $f['desc_persona_origen'];
			}
			$origenes[$j][4] = $f['desc_unidad_origen'];
			$origenes[$j][5] = $f['url_archivo_origen'];
			$origenes[$j][6] = $f['fecha_origen'];
			$origenes[$j][7] = $f['nivel_origen'];
			$j++;
			$i++;
			$auxArray[$i] = $f['id_corr_destino'];
			$destinos[$k][0]= $f['id_corr_destino'];
			$destinos[$k][1]= $f['numero_destino'];
			$destinos[$k][2]= $f['desc_empleado_destino'];
			if($f['desc_instit_destino']!=""&&$f['desc_instit_destino']!='NULL'){
				$destinos[$k][3]= $f['desc_instit_destino'];
			}
			else{
				$destinos[$k][3]= $f['desc_persona_destino'];
			}
			$destinos[$k][4]= $f['desc_unidad_destino'];
			$destinos[$k][5]= $f['url_archivo_destino'];
			$destinos[$k][6]= $f['fecha_destino'];
			$destinos[$k][7]= $f['nivel_destino'];
			$k++;
			$i++;
		}
		$cantOrigen=$j;
		$cantDestino=$k;
		
		$auxArray = array_unique($auxArray);
		$auxArray = array_values($auxArray);
		/*
		$origenes = array_unique($origenes);
		$origenes = array_values($origenes);
		
		$destinos = array_unique($destinos);
		$origenes = array_values($destinos);
		*/
		for($j=0;$j<count($auxArray);$j++){
			if(is_null($auxArray[$j])){
				unset($auxArray[$j]);
			}
		}
		
		$auxArray = array_values($auxArray);
		///////////Se hallan las posiciones de los nodos de forma circular
		////////// como centro al id_correspondencia dado.
		//posiciones finales del nodo
		//centro
		$cx=350;
		$cy=200;
		//opciones del incremento en y
		$dy1=100;
		$dy2=40;
		$dyizq=0;	
		$dyder=0;
		//opciones de radios
		$r1=300;
		$r2=100;
		$r;
		//auxiliar para alternar
		$i=0;
		$k=0;
		//operador
		$operador;
		
		for($j=0;$j<count($auxArray);$j++){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_correspondencia_nodo',$auxArray[$j]);
			$xOrigen = -1;
			$xDestino = -1;
			for($m=0;$m<$cantOrigen;$m++){
				if($auxArray[$j]==$origenes[$m][0]){
					$xOrigen = $m;
					break;
				}
			}
			for($m=0;$m<$cantDestino;$m++){
				if($auxArray[$j]==$destinos[$m][0]){
					$xDestino = $m;
					break;
				}
			}
			
			if($auxArray[$j]==$id_correspondencia){// es el centro
				$posx = $cx;
				$posy = $cy;
				if($xOrigen>=0){
					$xml->add_nodo('numero',$origenes[$xOrigen][1]);
					$xml->add_nodo('url_archivo',$origenes[$xOrigen][5]);
					if(count($origenes[$xOrigen][2])>0){
						$xml->add_nodo('desc_corr',$origenes[$xOrigen][2]."\n".$origenes[$xOrigen][4]."\n".$origenes[$xOrigen][6]."\nNivel ".$origenes[$xOrigen][7]);
					}
					else{
						$xml->add_nodo('desc_corr',$origenes[$xOrigen][3]."\n".$origenes[$xOrigen][6]."\nNivel ".$origenes[$xOrigen][7]);
					}
				}
				else{
					if($xDestino>=0){
						$xml->add_nodo('numero',$destinos[$xDestino][1]);
						$xml->add_nodo('url_archivo',$destinos[$xDestino][5]);
						if(count($destinos[$xDestino][2])>0){
							$xml->add_nodo('desc_corr',$destinos[$xDestino][2]."\n".$destinos[$xDestino][4]."\n".$destinos[$xDestino][6]."\nNivel ".$destinos[$xDestino][7]);
						}
						else{
							$xml->add_nodo('desc_corr',$destinos[$xDestino][3]."\n".$destinos[$xDestino][6]."\nNivel ".$destinos[$xDestino][7]);
						}
					}
				}
			}
			else{// entonces revisa si esta a la izquierda o a la derecha

				if($xOrigen>=0){
					$xml->add_nodo('numero',$origenes[$xOrigen][1]);
					$xml->add_nodo('url_archivo',$origenes[$xOrigen][5]);
					if(count($origenes[$xOrigen][2])>0){
						$xml->add_nodo('desc_corr',$origenes[$xOrigen][2]."\n".$origenes[$xOrigen][4]."\n".$origenes[$xOrigen][6]."\nNivel ".$origenes[$xOrigen][7]);
					}
					else{
						$xml->add_nodo('desc_corr',$origenes[$xOrigen][3]."\n".$origenes[$xOrigen][6]."\nNivel ".$origenes[$xOrigen][7]);
					}
					$operador = (-1);
					if($k>0){
						if($k%2!=0){
							$dyizq = abs($dyizq)+$dy1;
						}
						else{
							$dyizq = $dyizq *-1;
						}
					}
					$k++;
					$posy = $cy+$dyizq;
				}
				if($xDestino>=0){

					$xml->add_nodo('numero',$destinos[$xDestino][1]);
					$xml->add_nodo('url_archivo',$destinos[$Destino][5]);
					if(count($destinos[$xDestino][2])>0){
						$xml->add_nodo('desc_corr',$destinos[$xDestino][2]."\n".$destinos[$xDestino][4]."\n".$destinos[$xDestino][6]."\nNivel ".$destinos[$xDestino][7]);
					}
					else{
						$xml->add_nodo('desc_corr',$destinos[$xDestino][3]."\n".$destinos[$xDestino][6]."\nNivel ".$destinos[$xDestino][7]);
					}
					$operador = 1;
					if($i>0){
						if($i%2!=0){
							$dyder = abs($dyder)+$dy1;
						}
						else{
							$dyder = $dyder *-1;
						}
					}
					$i++;
					$posy = $cy+$dyder;
				}

				$posx = $cx + (round(sqrt(pow($r1,2)-pow(($posy-$cy),2)))*$operador);
			}

			$xml->add_nodo('posx',$posx);
			$xml->add_nodo('posy',$posy);
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