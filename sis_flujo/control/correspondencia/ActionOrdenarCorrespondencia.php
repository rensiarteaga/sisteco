<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCorrespondencia.php
Prop�sito:				Permite realizar el listado en tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2011-02-11 10:52:59
Versi�n:				1.0.0
Autor:					mflores
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionOrdenarCorrespondencia.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{

//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;
	
	//-----------------------
	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
		if ($reporte_excel=='si')
	    {	
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
	    }
	    else{
	    $cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);	
	    	
	    }
		
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'correspondencia-'.$vista);
	
	//$sortcol = $crit_sort->get_criterio_sort();
	//Obtiene el total de los registros
	//$res = $Custom -> ContarCorresOrdenada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);		
	
	//if($res) $total_registros= $Custom->salida;
		
	$carpeta_origen = '../../control/correspondencia/arch_adjuntos/';
	$carpeta_destino = '../../control/correspondencia/ordenada/';
	
	$cant = 100000;
	//Obtiene el conjunto de datos de la consulta
//	$res = $Custom->OrdenarCorrespondencia($cant,$puntero,'corres.numero','desc',$criterio_filtro); //listar 
	$res = $Custom->OrdenarCorrespondencia($cant,$puntero,'corres.numero','desc'," corres.numero like ''%-UPG-%'' or corres.id_institucion = 2234 or corres.id_institucion = 2266 or corres.id_institucion = 2292 "); //listar
	$corresp = $Custom->salida; //vector
	
	//var_dump($corresp); exit;
	
	$tamanio = sizeof($corresp);
	$cont = 0;
	
	//$vec_areas = array(0 => "DAL", 1 => "UL");
	
	$vec_areas = array(0 => "UPG");
	
	/*$vec_areas = array(0 => "AI", 1 => "ARO", 2 => "COB", 3 => "DAL", 4 => "DBS", 
	5 => "DCT", 6 => "DFI", 7 => "DPE", 8 => "GAF", 9 => "GDS", 10 => "GGN", 
	11 => "GGR", 12 => "GOP", 13 => "GPI", 14 => "GTR", 15 => "PGLC", 16 => "PHM", 
	17 => "PITS", 18 => "TRD", 19 => "UC", 20 => "UGS", 21 => "UP", 22 => "UTI", 
	23 => "GTI", 24 => "GFA", 25 => "GSA", 26 => "GPL", 27 => "PLC", 28 => "DRD", 
	29 => "COM", 30 => "UL", 31 => "UAI", 32 => "DAD", 33 => "FIN", 34 => "PMI", 35 => "CON");*/
	//echo 'llega'; exit;
	
	$vec_tipos = array(0 => "AC", 1 => "ACR", 2 => "AT", 3 => "AX", 4 => "CA", 5 => "CI", 6 => "CIR", 7 => "CM", 8 => "CT", 9 => "ET", 
	10 => "EVT", 11 => "IC", 12 => "IL", 13 => "IN", 14 => "ITR", 15 => "IV", 16 => "ME", 17 => "RD", 18 => "RES", 19 => "RT", 20 => "RVE"); 
		
	for($i = 0; $i <= $tamanio; $i++)
	{
		//echo $corresp[$i]['url_archivo'].'<br/>';
		$extension = explode('.', $corresp[$i]['url_archivo']);
		$ext = $extension[1];
		
		if(file_exists($carpeta_origen.$corresp[$i]['url_archivo']))
		{		
			if($corresp[$i]['url_archivo'] != NULL)
			{
				if($corresp[$i]['tipo'] == 'interna')
				{
					for($a = 0; $a <= sizeof($vec_areas); $a++)
					{
						$area = strpos($corresp[$i]['numero'],'-'.$vec_areas[$a].'-');
						if ($area !== false) 
						{
							for($m = 1; $m <= 12; $m++)
							{							
								$mes = strpos($corresp[$i]['numero'],'-'.$m.'/');	
								if($mes !== false)
								{
									for($d = 0; $d <= sizeof($vec_tipos); $d++)
									{					
										$doc = strpos($corresp[$i]['numero'],'-'.$vec_tipos[$d].'-');	
										if($doc !== false) 
										{						
											$corresp[$i]["numero"] = str_replace("/","_",$corresp[$i]["numero"]); 
											if($m < 10)
											{
												if(file_exists($carpeta_destino.'Interna/'.$vec_areas[$a].'/0'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext))
												{
													//
												}
												else 
												{
													if($vec_areas[$a] == 'CON')
													{
														copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Interna/CON1/0'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext);
													}
													else 
													{
														copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Interna/'.$vec_areas[$a].'/0'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext);	
													}												
												}											
											}									
											else 
											{
												if(file_exists($carpeta_destino.'Interna/'.$vec_areas[$a].'/'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext))
												{
													//
												}
												else 
												{
													if($vec_areas[$a] == 'CON')
													{
														copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Interna/CON1/'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext);
													}	
													else
													{
														copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Interna/'.$vec_areas[$a].'/'.$m.'/'.$vec_tipos[$d].'/'.$corresp[$i]['numero'].'.'.$ext);
													}										
												}
											}										
										}
									}																
								}
							}								
						}
					}
				}
			
				elseif ($corresp[$i]['tipo'] == 'emitida') //externa emitida 
				{
					for($a = 0; $a <= sizeof($vec_areas); $a++)
					{
						//echo '-- entra1 --';	
						$area = strpos($corresp[$i]['numero'],'-'.$vec_areas[$a].'-'); //gerencia
						if ($area !== false) 
						{							
							for($m = 1; $m <= 12; $m++)
							{							
								$mes = strpos($corresp[$i]['numero'],'-'.$m.'/');	//mes
								if($mes !== false)
								{
									$corresp[$i]["numero"] = str_replace("/","_",$corresp[$i]["numero"]);
									if($m < 10)
									{
										if(file_exists($carpeta_destino.'Externa/Emitida/'.$vec_areas[$a].'/0'.$m.'/'.$corresp[$i]['numero'].'.'.$ext))
										{
											//
										}
										else 
										{	 
											if($vec_areas[$a] == 'CON')
											{
												copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/CON1/0'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);
											}
											else
											{
												copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/'.$vec_areas[$a].'/0'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);
											}
											
										}
									}
									else 
									{
										if(file_exists($carpeta_destino.'Externa/Emitida/'.$vec_areas[$a].'/'.$m.'/'.$corresp[$i]['numero'].'.'.$ext))
										{
											//
										}
										else 
										{
											if($vec_areas[$a] == 'CON')
											{
												copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/CON1/'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);
											}
											else		
											{
												//echo $carpeta_origen.$corresp[$i]['url_archivo']; exit;
												copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/'.$vec_areas[$a].'/'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);
											}
										}	
									}																															
								}
							}								
						}
						//copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/AI/01/AC/'.$corresp[$i]['numero'].'.'.$ext);
					}				
				}
				elseif ($corresp[$i]['tipo'] == 'externa') //externa recibida
				{
					//echo '-- entra2';
					for($a = 0; $a <= sizeof($vec_areas); $a++)
					{
						/*$area = strpos($corresp[$i]['numero'],'-'.$vec_areas[$a].'-');
						if ($area !== false) 
						{*/
							for($m = 1; $m <= 12; $m++)
							{							
								$mes = strpos($corresp[$i]['numero'],'-'.$m.'/');	
								if($mes !== false)
								{
									$corresp[$i]["numero"] = str_replace("/","_",$corresp[$i]["numero"]); 
									if($m < 10)
									{
										if(file_exists($carpeta_destino.'Externa/Recibida/0'.$m.'/'.$corresp[$i]['numero'].'.'.$ext))
										{
											//
										}
										else 
										{									
											copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Recibida/0'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);										
										}											
									}
									else 
									{
										if(file_exists($carpeta_destino.'Externa/Recibida/'.$m.'/'.$corresp[$i]['numero'].'.'.$ext))
										{
											//
										}
										else 
										{								
											copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Recibida/'.$m.'/'.$corresp[$i]['numero'].'.'.$ext);										
										}
									}
																																	
								}
							}								
						/*}
						copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Externa/Emitida/AI/01/AC/'.$corresp[$i]['numero'].'.'.$ext);*/
					}
				}
				else 
				{				
					//$corresp[$i]["numero"] = str_replace("/","_",$corresp[$i]["numero"]);
					//copy($carpeta_origen.$corresp[$i]['url_archivo'], $carpeta_destino.'Otros/'.$corresp[$i]['numero'].'.'.$ext);
					//echo $corresp[$i]['numero'].'<BR>'.$carpeta_origen.$corresp[$i]['url_archivo'].'<BR>'.$carpeta_destino.'Externa/Emitida/AI/01/AC/'.$corresp[$i]['numero'].'.'.$ext; exit; 				
				}
			}
		}
	}

	//exit;
		
	$cont = 1;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('cont', $cont);
			$xml->add_nodo('numero',$f["numero"]);
			$xml->add_nodo('url_archivo',$f["url_archivo"]);			
			
			$xml->fin_rama();
			$cont++;			
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