<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rcm_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página
	var $items=array();//UC con todos sus UC hijos y reemplazos más sus items correspondientes
	var $items_gral=array();//Solamente todos los items (sin repetir ninguno) de toda la UC
	var $origen=array();//Origen de los pedidos:contratista, instituciones, empleados
	var $salidas=array();//todas las salidas uc por origen de una UC

	var $ff=array();

	function Header()
	{
		global $title;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logoTDE.jpg',140,2,0,0);
		//$this->Image('../../../../lib/images/logoTDE.png',0,0,0,0,'PNG');
		//Arial bold 15
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,'VERIFICACIÓN DE EXISTENCIAS',0,0,'C');
		$this->Ln(13);

	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',6);
		//ip
		$ip = captura_ip();

		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(100,10,'',0,0,'C');
		$this->Cell(100,10,'Hora: '.$hora ,0,0,'L');
	}
	
	
	function loadDetalle()
	{
			
			
		//Parámetros del filtro
		$cant = 15;
		$puntero = 0;	
		$sortcol = 'OSUCDE.id_tipo_unidad_constructiva,OSUCDE.descripcion,OSUCDE.id_unidad_constructiva,OSUCDE.id_item';
		$sortdir = 'asc';
		
			
		$Custom=new cls_CustomDBAlmacenes();
		//Verifica si se manda la cantidad de filtros
		if($CantFiltros=='') $CantFiltros = 0;
	
		//Se obtiene el criterio del filtro con formato sql para mandar a la BD
		$cond = new cls_criterio_filtro($decodificar);
		$cond->add_criterio_extra("OSUCDE.id_salida",$_SESSION['rep_mat_id_salida']);
	
		
		$criterio_filtro = $cond -> obtener_criterio_filtro();
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);


		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				
				//Forma la cadena de la cantidad solicitada
				$cantidad=" [".utf8_encode($f["cantidad"]."]");

				if($f['id_item'] != "")
				{
					//Configura el nodo tipo item
					$tmp['leaf'] = true;
					$tmp['text'] = utf8_encode($f["codigo"]).' - '.utf8_encode($f["nombre"]) . "<b>$cantidad</b>";
					$tmp['icon'] = "../../../lib/imagenes/item.png";
					$tmp['tipo'] = "item";
					$tmp['id'] = utf8_encode($f["id_item"]);
					$tmp['id_item'] = utf8_encode($f["id_item"]);
				}
				else
				{	//Configura el nodo tipo tipo unidad constructiva
					$tmp['leaf'] = false;
					$tmp['text'] = utf8_encode($f["codigo"]).' - '.utf8_encode($f["nombre"]) . "<b>$cantidad</b>";
					$tmp['icon'] = "../../../lib/imagenes/tucr.png";
					$tmp['tipo'] = "raiz";
					$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
					$tmp['id_tipo_unidad_constructiva'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
					
				}

				$tmp['repeticion'] = utf8_encode($f["repeticion"])=='si' ? 'true':'false';
				$tmp['id_reg'] = utf8_encode($f["id_orden_salida_uc_detalle"]);
				$tmp['cls']	= 'folder';
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				$tmp['allowDrag']	= false;
				$tmp['codigo'] = utf8_encode($f["codigo"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];
				
				

				$nodes[] = $tmp;
			}



		}

		return $nodes;
	}

	function LoadData()
	{
		//Recorre todo el árbol
		$cant=50;
		$puntero=0;
		$sortdir='asc';
		$criterio_filtro='0=0';

		/*print ("<pre>");
		print_r ($this->ff);
		print ("</pre>");
		exit;*/

		$aux=0;
		foreach ($this->ff as $tuc)
		{
			$Custom=new cls_CustomDBAlmacenes();
			$CustomItem=new cls_CustomDBAlmacenes();
			$sortcol='TIPOUC.codigo';
			
			/*print ("<pre>");
		print_r ($tuc);
		print ("</pre>");
		exit;*/
			
		

			if($tuc['tipo']=='raiz')
			{
					
				
				//Obtiene las UC directas que tiene la raíz
				$Custom->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);
				//Obtiene los items de la UC si es que tiene
				$sortcol='ITEM.codigo';
				$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);
				//Obtiene datos del padre
				$CustomUc=new cls_CustomDBAlmacenes();
				$CustomUc->ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);
				//Código del padre
				$codigo_padre = $CustomUc->salida[0]['codigo'];
				
				/*print ("<pre>");
				print_r ($CustomUc->salida);
				print ("</pre>");
				exit;*/

				//Carga los datos en el array interno
				foreach ($Custom->salida as $uc)
				//foreach ($CustomUc->salida as $uc)
				
				{
					//$aux=count($this->items);
					//echo "aux: ".$aux."<br>";
					$this->items[$aux]['id_tipo_unidad_constructiva']=$uc['id_tipo_unidad_constructiva'];
					$this->items[$aux]['nombre']=$uc['nombre'];
					$this->items[$aux]['codigo']=$uc['codigo'];
					$this->items[$aux]['id_tuc_padre']=$uc['id_tuc_padre'];
					$this->items[$aux]['nombre_padre']=$uc['nombre_padre'];
					$this->items[$aux]['codigo_padre']=$codigo_padre;
					$this->items[$aux]['cantidad']=$uc['cantidad'];
					$this->items[$aux]['cantidad_sol']=$tuc['cantidad'];

					//Verifica si los componentes directos tienen items
					$CustomItem=new cls_CustomDBAlmacenes();
					$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$uc[0]);

					$vaux=array();
					foreach ($CustomItem->salida as $item)
					{
						$tam=count($vaux);
						$vaux[$tam]['id_item']=$item['id_item'];
						$vaux[$tam]['cantidad']=$item['cantidad'];
						$vaux[$tam]['nombre_item']=$item['nombre_item'];
						$vaux[$tam]['id_item']=$item['id_item'];
						$vaux[$tam]['codigo_item']=$item['codigo_item'];
						$vaux[$tam]['cant_repartida']=0;
					}
					$this->items[$aux]['items']=$vaux;

					//Verifica si tiene Reemplazos
					$composicion=$uc["id_composicion_tuc"]=='' ? 0:$uc["id_composicion_tuc"];
					$filtro="TUCREEM.id_composicion_tuc=$composicion";
					$sort="TIPOUC.codigo";
					$dir="ASC";
					$CustomReemp=new cls_CustomDBAlmacenes();
					$CustomReemp->ListarTipoUnidadConsReemplazo(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
					$nodes_reemp=$CustomReemp->salida;
					$aux++;

					foreach ($CustomReemp->salida as $reemp)
					{
						//$aux1=count($this->items);
						$this->items[$aux]['id_tipo_unidad_constructiva']=$reemp['id_tipo_unidad_constructiva'];
						$this->items[$aux]['nombre']=$reemp['nombre'];
						$this->items[$aux]['codigo']=$reemp['codigo'];
						$this->items[$aux]['id_tuc_padre']=$uc[9];
						$this->items[$aux]['nombre_padre']=$uc[10];
						$this->items[$aux]['codigo_padre']=$codigo_padre;
						$this->items[$aux]['cantidad']=$uc[7];
						$this->items[$aux]['cantidad_sol']=$tuc['cantidad'];

						//Verifica si los reemplazos tienen Items
						$CustomItem=new cls_CustomDBAlmacenes();
						$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$reemp['id_tipo_unidad_constructiva']);
						
						$vaux=array();
						foreach ($CustomItem->salida as $item)
						{
							$tam=count($vaux);
							$vaux[$tam]['id_item']=$item['id_item'];
							$vaux[$tam]['cantidad']=$item['cantidad'];
							$vaux[$tam]['nombre_item']=$item['nombre_item'];
							$vaux[$tam]['id_item']=$item['id_item'];
							$vaux[$tam]['codigo_item']=$item['codigo_item'];
							$vaux[$tam]['cant_repartida']=0;
						}
						$this->items[$aux]['items']=$vaux;
						$aux++;
					}

				}
			}
			else
			{
				
		
		
		
				$Custom=new cls_CustomDBAlmacenes();
				$CustomItem=new cls_CustomDBAlmacenes();
				$sortcol='TIPOUC.codigo';
				//Obtiene la información del UC
				$Custom->ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);
				//Obtiene los items de la unidad constructiva
				$sortcol='ITEM.codigo';
				$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);

				//Carga los datos en el array interno
				foreach ($Custom->salida as $uc)
				{
					$this->items[$aux]['id_tipo_unidad_constructiva']=$uc['id_tipo_unidad_constructiva'];
					$this->items[$aux]['nombre']=$uc['nombre'];
					$this->items[$aux]['codigo']=$uc['codigo'];
					$this->items[$aux]['id_tuc_padre']=$uc['id_tuc_padre'];
					$this->items[$aux]['nombre_padre']=$uc['nombre_padre'];
					$this->items[$aux]['cantidad']=$uc['cantidad'];
					$this->items[$aux]['codigo_padre']=$uc['codigo_padre'];
					$this->items[$aux]['cantidad_sol']=$tuc['cantidad'];
				}

				$vaux=array();
				foreach ($CustomItem->salida as $item)
				{
					$tam=count($vaux);
					$vaux[$tam]['id_item']=$item['id_item'];
					$vaux[$tam]['cantidad']=$item['cantidad'];
					$vaux[$tam]['nombre_item']=$item['nombre_item'];
					$vaux[$tam]['id_item']=$item['id_item'];
					$vaux[$tam]['codigo_item']=$item['codigo_item'];
					$vaux[$tam]['cant_repartida']=0;
				}
				$this->items[$aux]['items']=$vaux;
				$aux++;
			}
		}

		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/
	}

	function ObtenerIngresos($node)
	{
		//Obtiene los ingresos de todos los materiales de las unidades constructivas
		$sort="COMPON.id_item";
		$dir="ASC";
		$filtro="0=0";

		$cont=0;

		//Obtiene todos los items de la UC incluidos de los reemplazos y sus existencias
		foreach ($this->ff as $tuc)
		{
			if($tuc['tipo']=='raiz')
			{
				$CustomItem=new cls_CustomDBAlmacenes();
				$CustomItem->ListarExistenciaItemUC(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva'],$_SESSION['rep_mat_id_almacen_logico']);
			}
			else
			{
				$CustomItem=new cls_CustomDBAlmacenes();
				$CustomItem->ListarExistenciaItemUCRama(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva'],$_SESSION['rep_mat_id_almacen_logico']);
			}
		/*
		print("<pre>  ");
		print_r($_SESSION['rep_mat_id_almacen_logico']);
		print_r($tuc['tipo']);
		
		
		print("</pre>");
		
		
		print("<pre>");
		print_r($CustomItem->salida);
		print("</pre>");
		exit;
*/

			foreach ($CustomItem->salida as $item)
			{
				$aux=count($this->items_gral);

				//Verifica que no exista ya en el array de los items en general
				$existe=0;
				foreach ($this->items_gral as $it_gral)
				{
					if($item['id_item']==$it_gral['id_item'])
					{
						$existe=1;
						break;
					}
				}

				//Solo aumenta el item en el array si es que no existe antes
				if($existe==0)
				{
					$this->items_gral[$aux]['id_item']=$item['id_item'];
					$this->items_gral[$aux]['existencia']=$item['cantidad'];
					$this->items_gral[$aux]['saldo']=$item['cantidad'];
					$this->items_gral[$aux]['cant_repetida']=$item['cant_repetida'];
					if($item['cant_repetida']>1)
					{
						$this->items_gral[$aux]['repartir']=intval($item['cantidad']/$item['cant_repetida']);
						$this->items_gral[$aux]['resto']=$item['cantidad']%$item['cant_repetida'];
					}
					else
					{
						$this->items_gral[$aux]['repartir']=$item['cantidad'];
						$this->items_gral[$aux]['resto']=0;
					}
				}
			}
		}

		/*print("<pre>");
		print_r($this->items_gral);
		print("</pre>");
		exit;*/
	}

	function RepartirExistencias()
	{
		//En base a las existencias, va repartiendo por UC
		$cont_mat=0;
		foreach ($this->items_gral as $mat)
		{
			$cont_uc=0;
			$sw=1;
			foreach ($this->items as $uc)
			{
				$cont_item=0;
				foreach ($uc['items'] as $item)
				{
					if($mat['id_item']==$item['id_item'])
					{
						/*echo "saldo".$mat['saldo'];
						echo "cantidad".$mat['cantidad'];*/
						if($mat['saldo']>=$item['cantidad'])
						{

							if($item['cantidad']*$uc['cantidad_sol']<=$mat['saldo'])
							{
								$this->items[$cont_uc]['items'][$cont_item]['cant_repartida']+=$item['cantidad']*$uc['cantidad_sol'];
								$this->items_gral[$cont_mat]['saldo']-=$item['cantidad']*$uc['cantidad_sol'];
							}
							else
							{
								$this->items[$cont_uc]['items'][$cont_item]['cant_repartida']+=$mat['saldo'];
								$this->items_gral[$cont_mat]['saldo']-=$mat['saldo'];
							}
						}
						else
						{
							$this->items[$cont_uc]['items'][$cont_item]['cant_repartida']+=$mat['saldo'];
							$this->items_gral[$cont_mat]['saldo']-=$mat['saldo'];
						}
					}
					$cont_item++;
				}
				$cont_uc++;
			}
			$cont_mat++;
		}

		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/

	}

	function CalcularExistenciasUC()
	{
		//Recorre todas las UC
		$cont_uc=0;
		foreach ($this->items as $uc)
		{
			$cont_item=0;
			foreach ($uc['items'] as $item)
			{
				$aux=$item['cantidad']==0 ? 1:$item['cantidad'];
				//$this->items[$cont_uc]['items'][$cont_item]['exist_uc']=$item['cant_repartida']/$item['cantidad'];
				$this->items[$cont_uc]['items'][$cont_item]['exist_uc']=intval($item['cant_repartida']/$aux);
				$cont_item++;
			}
			$cont_uc++;
		}
		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/
	}

	function DefinirExistenciasUC()
	{
		$cont_uc=0;
		foreach ($this->items as $uc)
		{
			$tot_exist=9999999999;
			foreach ($uc['items'] as $item)
			{
				if($item['exist_uc']<$tot_exist)
				{
					$tot_exist=$item['exist_uc'];
				}
			}
			$this->items[$cont_uc]['existencia']=$tot_exist;
			$cont_uc++;
		}
		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/
	}

	function ObtenerSalidasUCOrigen($node)
	{
		//Obtiene los ingresos de todos los materiales de las unidades constructivas
		$sort="SALIDA.id_salida";
		$dir="ASC";
		$filtro="0=0";

		foreach ($this->ff as $tuc)
		{
			//Obtiene todos los items de la UC incluidos de los reemplazos y sus existencias
			$CustomSalida=new cls_CustomDBAlmacenes();
			$CustomSalida->ListarSalidaUCOrigen(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tuc['id_tipo_unidad_constructiva']);

			foreach ($CustomSalida->salida as $salida)
			{
				//Carga el array del origen
				if(!in_array($salida['origen'],$this->origen))
				{
					$this->origen[]=$salida['origen'];
				}

				//Une todas las salidas
				$this->salidas[]=$salida;
			}
		}

		//Ordena por orden alfabético a los orígenes
		sort($this->origen);

		/*print("<pre>");
		print_r($this->salidas);
		print("</pre>");
		exit;*/
	}

	//Tabla coloreada
	function FancyTable1($header,$data,$tipo)
	{
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,33,91);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',7);
		//Cabecera
		$w=array(55,15);
		$wi=array(35,60,60,30);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//Títulos de las Columnas
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);

		//Contratistas
		foreach ($this->origen as $orig)
		{
			$this->Cell(strlen($orig)*2.5,7,$orig,1,0,'C',1);
		}
		//Incluye el título de la columna de saldo
		$this->Cell(20,7,'SALDO',1,1,'C',1);

		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',7);
		//Datos
		$fill=0;
		//$CustomCantidad= new rcm_cls_CustomDBAlmacenes();

		foreach($this->items as $row)
		{
			$this->Cell($w[0],6,$row['nombre'],'LTRB',0,'L',$fill);
			$this->Cell($w[1],6,$row['existencia'],'LTRB',0,'R',$fill);
			$saldo=$row['existencia'];

			//Despliega el pedido por el Origen
			foreach ($this->origen as $orig)
			{
				$sw=0;
				foreach ($this->salidas as $salida)
				{
					if($salida['origen']==$orig)
					{
						if($salida['nombre']==$row['nombre'])
						{
							$this->Cell(strlen($orig)*2.5,6,$salida['cantidad'],'LTRB',0,'R',$fill);
							$sw=1;
							//Actualiza el saldo
							$saldo-=$salida['cantidad'];
							break;
						}
					}
				}
				//Si no encontró una salida de ese origen y ese tipo de unidad constructiva, escribe cero
				if($sw==0)
				{
					$this->Cell(strlen($orig)*2.5,6,'','LTRB',0,'R',$fill);
				}
			}
			//Despliega el saldo
			$this->Cell(20,6,$saldo,'LTRB',0,'R',$fill);

			$this->Ln();
		}

		/*print("<pre>");
		print_r($this->items);
		print("</pre>");*/
	}

	function FancyTable($header,$data,$tipo)
	{
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,33,91);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',7);
		//Cabecera
		$w=array(55,30,30);
		$wi=array(35,60,60,30);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',7);
		//Datos
		$fill=0;

		$nombre_padre='';
		$codigo_padre='';
		$sw=0;

		foreach($this->items as $row)
		{
			if($nombre_padre!=$row['nombre_padre'] || $codigo_padre!=$row['codigo_padre'])
			{
				//echo "DIFERENTE -> nombre padre: ".$nombre_padre . ' && tuc_codigo_padre: '.$row['codigo_padre'].'<br>';

				if($sw==1)
				{
					//$this->AddPage();
					$this->Ln();
				}
				//Título
				$this->Cell(50,3,$row['codigo_padre'].' - '.$row['nombre_padre'],0,1,'L',0);
				$this->Cell(50,4,'Cantidad: '.$row['cantidad_sol'],0,1,'L',0);

				//Columnas
				for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
				$this->Ln();

				//Guarda el último título
				$nombre_padre=$row['nombre_padre'];
				$codigo_padre=$row['codigo_padre'];
			}
			else 
			{
				//echo "IGUAL -> nombre padre: ".$nombre_padre . ' && tuc_codigo_padre: '.$row['codigo_padre'].'<br>';
			}

			$this->Cell($w[0],6,$row['nombre'],'LTRB',0,'L',$fill);
			$this->Cell($w[1],6,$row['cantidad_sol'],'LTRB',0,'R',$fill);
			if($row['existencia']<$row['cantidad_sol'])
			{
				//$this->SetFillColor(255,50,0);
				//$this->SetFillColor(192,192,192);
				$this->Cell($w[1],6,$row['existencia'],'LTRB',1,'R',1);
			}
			else
			{
				$this->Cell($w[1],6,$row['existencia'],'LTRB',1,'R',0);
			}
			//$this->SetFillColor(224,235,255);
			$sw=1;
		}

		/*print("<pre>");
		print_r($this->items);
		print("</pre>");*/
	}

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->ff=array();

$pdf->ff = $pdf->loadDetalle();

/*$pdf->ff[0]['id_tipo_unidad_constructiva']=14;
$pdf->ff[0]['cantidad']=310;
$pdf->ff[0]['tipo']='raiz';
$pdf->ff[1]['id_tipo_unidad_constructiva']=60;
$pdf->ff[1]['cantidad']=100;
$pdf->ff[1]['tipo']='raiz';*/


//$pdf->ff=$_SESSION[verif_exist_uc];
/*
print ("<pre>");
print_r ($pdf->ff);
print ("</pre>");

exit;*/







//Títulos de las columnas
$header=array('PARTE DE LA ESTRUCTURA','CANTIDAD SOLICITADA','CANTIDAD DISPONIBLE');
$header_item=array('Código','Material','Descripción','Cantidad');
//Carga de datos
$tipo=$tipo;
if(count($pdf->ff)>0)
{
	$pdf->LoadData();
	$pdf->ObtenerIngresos($node);
	$pdf->RepartirExistencias();
	$pdf->CalcularExistenciasUC();
	$pdf->DefinirExistenciasUC();
	//$pdf->ObtenerSalidasUCOrigen($node);
}

//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();

$pdf->FancyTable($header,$data,$tipo);
$pdf->Output();
?>