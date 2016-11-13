<?php
session_start();
//clase q heredare fpdf
require_once(dirname(__FILE__).'/../fpdf/fpdf.php');
//algunas funciones necesarias
require_once(dirname(__FILE__).'/../funciones.inc.php');
require_once(dirname(__FILE__).'/../configuracion.log.php');
//require_once('mem_image.php');


class Reporte extends FPDF 
{
	//variable que contiene el tipo de reporte
	 private $forma_reporte;
	 //arreglo de graficos para el reporte
	 private $graficos=array();
	 private $orientacion_logo; 
	 private $cabecera=array();
	 private $titulo;
	 private $orientacion;
	 private $pagina;
	 private $alto_pagina;
	 private $ancho_pagina;
	 private $par_linea;
	 private $titulo_col=array();
	 private $titulo_maestro=array();
	 private $align_maestro;
	 private $tipo_reporte;
	
	function __construct($tipo,$forma,$pagina,$orientacion){
		//constructor, llama al constructor del padre e inicializa datos principales del reporte
		$this->tipo_reporte=$tipo;
		$this->forma_reporte=$forma;
		$this->orientacion=$orientacion;
		$this->pagina=$pagina;
		//llama al constructor de su padre
		parent::FPDF($orientacion,'mm',$pagina);
		$this->getTamanosPagina();
		$this->SetAutoPageBreak(true,25);
		$this->AliasNbPages();
		
		
	}
	
	function Footer()
	{
		//pie de pagina generico para todos los reportes
	      //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    $ip = captura_ip();
	    
	   
		 //Número de página
	    $fecha=date("d-m-Y");
		//hora
	    $hora=date("H:i:s");
		$ancho_celda=$this->ancho_pagina/3;
	    $this->Cell($ancho_celda,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell($ancho_celda,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');     
	    $this->Cell($ancho_celda,10,'Fecha: '.$fecha ,0,0,'C');
	    $this->ln(3);
	    $this->Cell($ancho_celda,10,'',0,0,'L'); 
	    $this->Cell($ancho_celda,10,'',0,0,'L');
	    $this->Cell($ancho_celda,10,'Hora: '.$hora ,0,0,'C');
	    //fecha
	   
	}
	
	function defineMaestro($eti_maestro,$alineacion){
		if($this->forma_reporte=='maestro-detalle'){
			$this->align_maestro=$alineacion;
			$this->titulo_maestro=$eti_maestro;
		}
		
	}
	function datoMaestro($maestro){
		if($this->forma_reporte=='maestro-detalle'){
			$this->SetFont('Arial','B',7);
			
			$suma_total=array_sum($this->widths);
			$ancho_col=$suma_total/count($this->titulo_maestro);
			$inicio=(($this->ancho_pagina-5)-$suma_total)/2;
			//echo $inicio;
			if($inicio>0){
				$this->Cell($inicio);
			}
				
			$this->Fila1($this->titulo_maestro,$maestro,0,$ancho_col,$this->align_maestro);
		}
		
	}
	private function getTamanosPagina(){
		//Llena datos de tamaño de pagina alto y ancho de acuerdo al tipo de pagina y la orientacion
		//p normal y l apaisado
		if($this->pagina=='A4' && $this->orientacion=='L'){
			$this->alto_pagina=210;
			$this->ancho_pagina=297;
		}
		elseif ($this->pagina=='A4' && $this->orientacion=='P'){
			$this->alto_pagina=297;
			$this->ancho_pagina=210;
		}
		elseif ($this->pagina=='Letter' && $this->orientacion=='L'){
			$this->alto_pagina=215.9;
			$this->ancho_pagina=279.4;
			
		}
		elseif ($this->pagina=='Letter' && $this->orientacion=='P'){
			
			$this->alto_pagina=279.4;
			$this->ancho_pagina=215.9;
			
			
		}
		elseif ($this->pagina=='Legal' && $this->orientacion=='L'){
			$this->alto_pagina=612;
			$this->ancho_pagina=1008;
		}
		elseif ($this->pagina=='Legal' && $this->orientacion=='P'){
			$this->alto_pagina=1008;
			$this->ancho_pagina=612;
		}
		
		
	}
	function Header(){
		//Header generico, tiene que ser sobreescrito en la clase q hereda
		//Logo
		if($this->orientacion_logo=='L'){
	    	$this->Image('../images/logo_reporte.jpg',5,5);
		}
		else{
	    	
			$this->Image('../images/logo_reporte.jpg',$this->ancho_pagina-80,5);
		}
	    //Arial bold 15
	    $this->ln(7);
	    $this->SetFont('Arial','B',12);
	    //Movernos a la derecha
		$ancho_celda=$this->GetStringWidth($this->titulo)+10;
		$this->Cell(($this->ancho_pagina-$ancho_celda)/2);
		$this->Cell($ancho_celda,13,$this->titulo,0,0,'C');
		$this->ln(6);
		$this->SetFont('Arial','I',10);
		
		
	}
	function ArmaHeader($titulo,$par_linea,$orientacion_logo){
		//inicializa algunos datos del header
		$this->titulo=$titulo;
		$this->par_linea=$par_linea;
		$this->orientacion_logo=$orientacion_logo;
	}
	function addParametro($nombre_campo,$valor,$alineacion){
		//añade un parametro al header de acuerdo a la cantidad de datos q tiene y el tamañod e la hoja
		array_push($this->cabecera,"$nombre_campo: $valor");
		
		if(count($this->cabecera)%$this->par_linea==1||$this->par_linea==1){
			
			$this->ln(5);
		}
		$ancho_cel=$this->ancho_pagina/$this->par_linea;
		$this->Cell($ancho_cel,13,"$nombre_campo: $valor",0,0,$alineacion);
	}
	function lineaHor(){
		//Dibuja una linea horizontal de acuerdo al anchod e la pagina en la posicion actual
		$this->ln();
		$this->SetLineWidth(0.4); 
		$this->line(8,$this->GetY()-3,$this->ancho_pagina-8,$this->GetY()-3);
		$this->SetLineWidth(0.2); 
	}
	function cabeceraColDet($anchos,$nombres,$dibuja){
		$this->SetFont('Arial','B',8);
		$this->SetWidths($anchos);
		
		$this->titulo_col=$nombres;
		$suma_total=array_sum($anchos);
		$inicio=(($this->ancho_pagina-5)-$suma_total)/2;
		//echo $inicio;
		if($inicio>0){
			$this->Cell($inicio);
		}
			
		$this->Fila($nombres,$dibuja);
	}
	function dibujaTabla($matriz,$dibuja){
		$this->SetFont('Arial','',7);
		$this->SetLineWidth(.1);
		$this->SetFillColor(224,235,255);
    	$this->SetTextColor(0);
		$suma_total=array_sum($this->widths);
		$inicio=(($this->ancho_pagina-5)-$suma_total)/2;
		//echo $inicio;
		
		foreach ($matriz as $data)
		{
			if($inicio>0){
				$this->Cell($inicio);
			}
			$this->Fila($data,$dibuja);
			
		}	
			//var_dump($matriz[0]);
			//exit;
			//$this->fill=!$this->fill;
			//exit
		//}
		
	}
	//
    // FUNCIONES PARA IMAGENES DE JPGRAPH
    //
    function _readstr($var, &$pos, $n)
    {
        //Read some bytes from string
        $string = substr($var, $pos, $n);
        $pos += $n;
        return $string;
    }
    
    function _readstr_int($var, &$pos)
    {
        //Read a 4-byte integer from string
        $i =ord($this->_readstr($var, $pos, 1))<<24;
        $i+=ord($this->_readstr($var, $pos, 1))<<16;
        $i+=ord($this->_readstr($var, $pos, 1))<<8;
        $i+=ord($this->_readstr($var, $pos, 1));
        return $i;
    }

    function _parsemempng($var)
    {
        $pos=0;
        //Check signature
        $sig = $this->_readstr($var,$pos, 8);
        if($sig != chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
            $this->Error('Not a PNG image');
        //Read header chunk
        $this->_readstr($var,$pos,4);
        $ihdr = $this->_readstr($var,$pos,4);
        if( $ihdr != 'IHDR')
            $this->Error('Incorrect PNG Image');
        $w=$this->_readstr_int($var,$pos);
        $h=$this->_readstr_int($var,$pos);
        $bpc=ord($this->_readstr($var,$pos,1));
        if($bpc>8)
            $this->Error('16-bit depth not supported: '.$file);
        $ct=ord($this->_readstr($var,$pos,1));
        if($ct==0)
            $colspace='DeviceGray';
        elseif($ct==2)
            $colspace='DeviceRGB';
        elseif($ct==3)
            $colspace='Indexed';
        else
            $this->Error('Alpha channel not supported: '.$file);
        if(ord($this->_readstr($var,$pos,1))!=0)
            $this->Error('Unknown compression method: '.$file);
        if(ord($this->_readstr($var,$pos,1))!=0)
            $this->Error('Unknown filter method: '.$file);
        if(ord($this->_readstr($var,$pos,1))!=0)
            $this->Error('Interlacing not supported: '.$file);
        $this->_readstr($var,$pos,4);
        $parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>';
        //Scan chunks looking for palette, transparency and image data
        $pal='';
        $trns='';
        $data='';
        do
        {
            $n=$this->_readstr_int($var,$pos);
            $type=$this->_readstr($var,$pos,4);
            if($type=='PLTE')
            {
                //Read palette
                $pal=$this->_readstr($var,$pos,$n);
                $this->_readstr($var,$pos,4);
            }
            elseif($type=='tRNS')
            {
                //Read transparency info
                $t=$this->_readstr($var,$pos,$n);
                if($ct==0)
                    $trns=array(ord(substr($t,1,1)));
                elseif($ct==2)
                    $trns=array(ord(substr($t,1,1)),ord(substr($t,3,1)),ord(substr($t,5,1)));
                else
                {
                    $p=strpos($t,chr(0));
                    if(is_int($p))
                        $trns=array($p);
                }
                $this->_readstr($var,$pos,4);
            }
            elseif($type=='IDAT')
            {
                //Read image data block
                $data.=$this->_readstr($var,$pos,$n);
                $this->_readstr($var,$pos,4);
            }
            elseif($type=='IEND')
                break;
            else
                $this->_readstr($var,$pos,$n+4);
        }
        while($n);
        if($colspace=='Indexed' and empty($pal))
            $this->Error('Missing palette in '.$file);
        return array('w'=>$w,
                     'h'=>$h,
                     'cs'=>$colspace,
                     'bpc'=>$bpc,
                     'f'=>'FlateDecode',
                     'parms'=>$parms,
                     'pal'=>$pal,
                     'trns'=>$trns,
                     'data'=>$data);
    }
  
    /********************/
    /* PUBLIC FUNCTIONS */
    /********************/
    function MemImage($data, $x, $y, $w=0, $h=0, $link='')
    {
        //Put the PNG image stored in $data
        $id = md5($data);
        if(!isset($this->images[$id]))
        {
            $info = $this->_parsemempng( $data );
            $info['i'] = count($this->images)+1;
            $this->images[$id]=$info;
        }
        else
            $info=$this->images[$id];
    
        //Automatic width and height calculation if needed
        if($w==0 and $h==0)
        {
            //Put image at 72 dpi
            $w=$info['w']/$this->k;
            $h=$info['h']/$this->k;
        }
        if($w==0)
            $w=$h*$info['w']/$info['h'];
        if($h==0)
            $h=$w*$info['h']/$info['w'];
        $this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
        if($link)
            $this->Link($x,$y,$w,$h,$link);
    }
    
    function GDImage($im, $x, $y, $w=0, $h=0, $link='')
    {
        //Put the GD image $im
        ob_start();
        imagepng($im);
        $data = ob_get_contents();      
        ob_end_clean();
        $this->MemImage($data, $x, $y, $w, $h, $link);
    }
}





?>