<?php
/**
 * Funcion:  MetaData
 * Proposito: obtener los campos de la tabla especificada
 * Autor: Rensi Arteaga Copari
 *
 * @param conexion postgres    $db              
 * @param  nombre de la tabla  $table          
 * @return array
 */

class cls_generar_codigo{
	var $dbName='dbendesis';
	var $dbUser='rodrigo';

	var $sistema;
	var $prefijo;
	var $codigo;
	var $tableName;

	var $db;
	var $meta;
	//var $campos;

	var $base;
	var $modelo;
	var $control;

	var $vista;
	//,$prefijo,$codigo,$tableName
	function __construct()
	{
		include("lib/BDSel.php");
		include("lib/BDIud.php");
		include("lib/ModeloBD.php");
		include("lib/ControlListar.php");
		include("lib/ControlGuardar.php");
		include("lib/ControlEliminar.php");
		include("lib/VistaMain.php");
		include("lib/Vista.php");
		include("lib/VistaCombo.php");
		include("lib/meta_funciones.php");
		include("lib/VistaJsPadre.php");
		include("lib/VistaJsHijo.php");
		include("lib/VistaMainHijo.php");
		include("lib/VistaHijo.php");
		include("lib/ControlListarHijo.php");

		$this->sistema = "";//strtolower($sistema);
		$this->prefijo = strtoupper($prefijo);
		$this->codigo = strtoupper($codigo);
		$this->tableName = strtolower($tableName);

		/*$this->base = "base/$this->tableName";
		$this->modelo = "modelo/$this->tableName";
		$this->control = "control/$this->tableName";
		$this->vista = "vista/$this->tableName";*/
	}

	function cargar_metadata($nombre_tabla,$prefijo){
		/*echo "TABLA=".$nombre_tabla."<br>";
		echo "PREFIJO=".$prefijo."<br>";*/

		$this->db = pg_connect('host=10.10.0.14 dbname='.$this->dbName.' user='.$this->dbUser." password='db_rcm' port=5432");
		$this->meta = metadata($this->db,$prefijo,$nombre_tabla);
	}

	function generar($array_nodo){
		/*echo "<pre>";
		print_r($array_nodo);
		echo "</pre>";*/

		$this->tableName = $array_nodo['nombre_tabla'];
		$this->prefijo = $array_nodo['prefijo'];
		$this->codigo = $array_nodo['codigo_base'];

		$this->cargar_metadata($array_nodo['nombre_tabla'],$array_nodo['prefijo']);

		/*		echo "<pre>META";
		print_r($this->meta);
		echo "</pre>";
		*/		//exit;

		$aux = $this->meta[0]["descripcion_tabla"];
		//echo "TTTTTTTTTTTTTTTTT:".$aux;
		//exit;
		$descripcion_tabla = decodificarForamto($aux);

		$this->sistema= strtolower($descripcion_tabla['sistema']);


		//Creación de las carpetas
		$this->base = "output/$this->sistema/base/$this->tableName";
		$this->modelo = "output/$this->sistema/modelo/$this->tableName";
		$this->control = "output/$this->sistema/control/$this->tableName";
		$this->vista = "output/$this->sistema/vista/$this->tableName";

		if(!file_exists("output/$this->sistema/"))
		mkdir("output/$this->sistema/");
		if(!file_exists("output/$this->sistema/base"))
		mkdir("output/$this->sistema/base");
		if(!file_exists("output/$this->sistema/base/$this->tableName"))
		mkdir("output/$this->sistema/base/$this->tableName");

		if(!file_exists("output/$this->sistema/modelo"))
		mkdir("output/$this->sistema/modelo");
		if(!file_exists("output/$this->sistema/modelo/$this->tableName"))
		mkdir("output/$this->sistema/modelo/$this->tableName");

		if(!file_exists("output/$this->sistema/control"))
		mkdir("output/$this->sistema/control");
		if(!file_exists("output/$this->sistema/control/$this->tableName"))
		mkdir("output/$this->sistema/control/$this->tableName");

		if(!file_exists("output/$this->sistema/vista"))
		mkdir("output/$this->sistema/vista");
		if(!file_exists("output/$this->sistema/vista/$this->tableName"))
		mkdir("output/$this->sistema/vista/$this->tableName");
		if(!file_exists("output/$this->sistema/vista/$this->tableName/js"))
		mkdir("output/$this->sistema/vista/$this->tableName/js");

	/*	echo "<pre>";
		print_r($this->meta);
		echo "</pre>";*/

		//Modelo BD: función SEL
		crearArchivo_BDSel($this->base,$this->db,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> BDSel<br>";

		//Modelo BD: función IUD
		crearArchivo_BDIud($this->base,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> BDIUd<br>";

		//Modelo SW
		crearModeloBD($this->modelo,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> BD<br>";

		//Control: Listar
		crearArchivo_ControlListar($this->control,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> BDListar<br>";

		//Control: Guardar
		crearArchivo_ControlGuardar($this->control,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> Guardar<br>";

		//Control: Eliminar
		crearArchivo_ControlEliminar($this->control,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> Eliminar<br>";

		//Vista
		crearArchivo_VistaCombo("$this->vista/js",$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
		echo "<b>Se ejecuto:</b> Vista Combo Padre<br>";

		if($array_nodo['tipo_vista']=='padre')
		{
			crearArchivo_Vista($this->vista,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta);
			echo "<b>Se ejecuto:</b> Vista Padre<br>";

			crearArchivo_VistaMain("$this->vista/js",$this->tableName,$this->prefijo,$this->codigo,$this->meta);
			echo "<b>Se ejecuto:</b> Vista Main Padre<br>";

			crearArchivo_VistaJsPadre("$this->vista/js",$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b>  Vista JS Padre<br>";
		}
		elseif ($array_nodo['tipo_vista']=='hijo')
		{
			crearArchivo_VistaHijo($this->vista,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> Vista Hijo<br>";

			crearArchivo_VistaMainHijo("$this->vista/js",$this->db,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> Vista Main Hijo<br>";

			crearArchivo_VistaJsHijo("$this->vista/js",$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b>  Vista JS Hijo<br>";

			//Control: ListarHijo
			crearArchivo_ControlListarHijo($this->control,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> BDListarHijo<br>";
		}
		elseif ($array_nodo['tipo_vista']=='padre_hijo')
		{
			crearArchivo_VistaHijo($this->vista,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> Vista Hijo<br>";

			crearArchivo_VistaMainHijo("$this->vista/js",$this->db,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> Vista Main Hijo<br>";

			crearArchivo_VistaJsHijo("$this->vista/js",$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b>  Vista JS Hijo<br>";
			
			//Control: ListarHijo
			crearArchivo_ControlListarHijo($this->control,$this->db,$this->sistema,$this->tableName,$this->prefijo,$this->codigo,$this->meta,$array_nodo);
			echo "<b>Se ejecuto:</b> BDListarHijo<br>";
		}
		else
		{
			echo "*****Tipo de Vista no definida";
		}


		/*print("<pre>");
		print_r($this->meta);
		print("</pre>");

		$cod="label=xxx&tipo=cmf";
		$resultado = decodificarForamto($cod);

		print("<pre>");
		print_r($resultado);
		print("</pre>");*/
	}



}
?> 
