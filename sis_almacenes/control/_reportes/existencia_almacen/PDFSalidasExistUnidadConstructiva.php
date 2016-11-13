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

	function Header()
	{
		global $title;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',140,2);
		//Arial bold 15
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,$_SESSION['nombre_cabecera'],0,0,'C');
		$this->Ln(13);

	}

	//Pie de página
	function Footer()
	{

	}

	function LoadData($node,$tipo)
	{
		//Recorre todo el árbol
		$cant=50;
		$puntero=0;
		$sortcol='codigo';
		$sortdir='asc';
		$criterio_filtro='0=0';

		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$CustomItem=new cls_CustomDBAlmacenes();

		//Obtiene las unidades constructivas de la raíz
		if($tipo=='raiz')
		{
			//Obtiene las UC directas que tiene la raíz
			$Custom->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
			//Obtiene los items de la UC si es que tiene
			$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
		}
		else
		{
			//Obtiene las UC directas que tiene la rama
			//$Custom->ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
			/*print("<pre>");
			print_r($Custom->salida);
			print("</pre>");
			exit;*/


			//Obtiene los items de la UC si es que tiene
			//$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
			
			/*print("<pre>");
			print_r($CustomItem->salida);
			print("</pre>");
			exit;*/
		}

		foreach ($Custom->salida as $uc)
		{
			$aux=count($this->items);
			$this->items[$aux]['id_tipo_unidad_constructiva']=$uc['id_tipo_unidad_constructiva'];
			$this->items[$aux]['nombre']=$uc['nombre'];
			$this->items[$aux]['id_tuc_padre']=$uc['id_tuc_padre'];
			$this->items[$aux]['nombre_padre']=$uc['nombre_padre'];
			$this->items[$aux]['cantidad']=$uc['cantidad'];

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

				/*if(!in_array($item['id_item'],$this->items_gral))
				{
				$this->items_gral[count($this->items_gral)]['id_item']=$item['id_item'];
				}*/
			}
			$this->items[$aux]['items']=$vaux;

			//Verifica si tiene Reemplazos
			$composicion=$uc["id_composicion_tuc"]=='' ? 0:$uc["id_composicion_tuc"];
			//echo "composi: ".$composicion;
			$filtro="TUCREEM.id_composicion_tuc=$composicion";
			$sort="TIPOUC.codigo";
			$dir="ASC";
			$CustomReemp=new cls_CustomDBAlmacenes();
			$CustomReemp->ListarTipoUnidadConsReemplazo(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			$nodes_reemp=$CustomReemp->salida;

			foreach ($CustomReemp->salida as $reemp)
			{
				$aux1=count($this->items);
				$this->items[$aux1]['id_tipo_unidad_constructiva']=$reemp['id_tipo_unidad_constructiva'];
				$this->items[$aux1]['nombre']=$reemp['nombre'];
				$this->items[$aux1]['id_tuc_padre']=$uc[9];
				$this->items[$aux1]['nombre_padre']=$uc[10];
				$this->items[$aux1]['cantidad']=$uc[7];

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
					/*if(!in_array($item['id_item'],$this->items_gral))
					{
					$this->items_gral[count($this->items_gral)]['id_item']=$item['id_item'];
					}*/

				}
				$this->items[$aux1]['items']=$vaux;
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

		/*foreach ($this->items_gral as $item)
		{
		$filtro="INGDET.id_item=".$item['id_item'];
		$CustomItem=new cls_CustomDBAlmacenes();
		$CustomItem->ObtenerIngresoItem(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//Agrega la cantidad del item
		$this->items_gral[$cont]['existencia']=$CustomItem->salida[0][0];
		$this->items_gral[$cont]['saldo']=$CustomItem->salida[0][0];
		$cont++;
		}*/

		//Obtiene todos los items de la UC incluidos de los reemplazos y sus existencias
		$CustomItem=new cls_CustomDBAlmacenes();
		$CustomItem->ListarExistenciaItemUC(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		foreach ($CustomItem->salida as $item)
		{
			$aux=count($this->items_gral);
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
			//while ($sw==1)
			//{
			//if($mat['saldo']>0)
			//{
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
							if($mat['cant_repetida']>1)
							{
								$rep=$mat['repartir'] + ($mat['resto']>0 ? 1:0);
								$this->items[$cont_uc]['items'][$cont_item]['cant_repartida']+=$rep;
								$this->items_gral[$cont_mat]['saldo']-=$rep;
								$this->items_gral[$cont_mat]['resto']-=($mat['resto']>0 ? 1:0);
							}
							else
							{
								$this->items[$cont_uc]['items'][$cont_item]['cant_repartida']+=$mat['saldo'];
								$this->items_gral[$cont_mat]['saldo']=0;
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
			//}

			//Verifica que si el saldo es mayor a cero para seguir repartiendo las existencias
			//echo "saldo: ".$this->items_gral[$cont_mat]['saldo'];
			//if($this->items_gral[$cont_mat]['saldo']<=0)
			//{
			//	$sw=0;
			//}
			//}
			$cont_mat++;
		}
		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/

	}

	function CalcularExistencias()
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

	function DefinirExistencias()
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

		//Obtiene todos los items de la UC incluidos de los reemplazos y sus existencias
		$CustomSalida=new cls_CustomDBAlmacenes();
		$CustomSalida->ListarSalidaUCOrigen(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		foreach ($CustomSalida->salida as $salida)
		{
			if(!in_array($salida['origen'],$this->origen))
			{
				$this->origen[]=$salida['origen'];
			}
		}
		//Ordena por orden alfabético a los orígenes
		sort($this->origen);

		//Asigna los datos de las salidas a una variable local
		$this->salidas=$CustomSalida->salida;

		/*print("<pre>");
		print_r($this->items);
		print("</pre>");
		exit;*/
	}

	//Tabla coloreada
	function FancyTable($header,$data,$tipo)
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
}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('PARTE DE LA ESTRUCTURA','INGRESOS');
$header_item=array('Código','Material','Descripción','Cantidad');
//Carga de datos
$tipo=$tipo_maestro;
//$pdf->LoadData($node,$tipo);
$pdf->LoadData($node,'raiz');
$pdf->ObtenerIngresos($node);
$pdf->RepartirExistencias();
$pdf->CalcularExistencias();
$pdf->DefinirExistencias();
$pdf->ObtenerSalidasUCOrigen($node);


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