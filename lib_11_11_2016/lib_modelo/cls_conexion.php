<?php
/**
 * Nombre clase:	cls_conexion
 * Propósito:		Clase que contiene las funcionalidades para la conexión a la base de datos
 * Autor:			Rodrigo Chumacero Moscoso
 * Fecha Creación:	18-05-2007
 *
 */
session_start();
class cls_conexion
{
	var $host; //Host de la base de datos
	var $dbname; //Nombre de la base de datos
	var $usr; //Usuario de conexión a la base de datos
	var $pwd; //Password del usuario de conexión
	var $conexion_bd; //Conexión a la base de datos

	/**
	 * Nombre función:	__construct
	 * Propósito:		Constructor de la clase cls_conexion, que carga los datos de conexión de archivo de configuración
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha Creación:	18-05-2007
	 * 
	 */
	function __construct()
	{
		$this->host = $_SESSION["HOST"];
		//$this->dbname = $_SESSION["BASE_DATOS"];
		//echo "baseantes: ".trim($_SESSION["ss_nombre_basedatos"])."<br>";
		$this->dbname = trim($_SESSION["BASE_DATOS"]);
		//echo "base datos: ".$this->dbname;
		//$this->usr = addslashes(htmlentities($_SESSION["ss_usuario"],ENT_QUOTES));
		$this->usr = addslashes(htmlentities($_SESSION["BASE_DATOS"],ENT_QUOTES))."_".addslashes(htmlentities($_SESSION["ss_usuario"],ENT_QUOTES));
		$this->pwd='null';

		//echo addslashes(htmlentities($_SESSION["CONTRASENA"],ENT_QUOTES));

		$this->pwd = trim(addslashes(htmlentities($_SESSION["ss_contrasenia"],ENT_QUOTES)));
	}



	/**
	 * Nombre función:	conectar_pg
	 * Propósito:		Permite abrir una conexión con una base de datos postges en base a los parámetros de configuración
	 * Autor:			Rensi Arteaga Copari
	 * Fecha Creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function conectar_pg ()
	{
		//error_reporting(0);
	


		$this->conexion_bd = pg_connect("host=".$this->host." dbname=".$this->dbname." user=".$this->usr." password=".$this->pwd." port=5432");

		

	


		if($this->conexion_bd!=""){

			

			return $this->conexion_bd;
		}else{
			
			//echo pg_last_error($this->conexion_bd);exit;
			$_SESSION["EXITO_CNX__DB"]='NO';
			echo $this->usr;
			echo "fallo";
			exit;
			//echo "{success:false}";
			//exit;

		}
	

	}


	/**
	 * Nombre función:	desconectar_pg
	 * Propósito:		Cerrar una conexión abierta con una base de datos postgres
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function desconectar_pg()
	{


		if($this->conexion_bd){

			if(!pg_close($this->conexion_bd))
			{
				echo "Error al cerrar la conexión:".pg_last_error();
				return -1 ;
			}
			else
			{
				return $this->conexion_bd;
			}
		}
	}
	
	
	/**
	 * Nombre función:	conectar_pg_login
	 * Propósito:		Permite abrir una conexión con una base de datos postges en base a los parámetros de configuración
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	29-04-2010
	 *
	 * @return unknown
	 */
	function conectar_pg_login ()
	{
	

		$this->conexion_bd = pg_connect("host=".$this->host." dbname=".$this->dbname." user=".$_SESSION["CON_USUARIO"]." password=".$_SESSION["CON_CONTRASENA"]." port=5432");

	

		if($this->conexion_bd!=""){

			return $this->conexion_bd;
		}else{
			//$_SESSION["EXITO_CNX__DB"]='NO';
			//echo pg_last_error($this->conexion_bd);exit;
			echo $this->usr;
			echo "fallo";
			exit;
			//echo "{success:false}";
			//exit;

		}
		

	}


	/**
	 * Nombre función:	desconectar_pg_login
	 * Propósito:		Cerrar una conexión abierta con una base de datos postgres
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	29-04-2010
	 *
	 * @return unknown
	 */
	function desconectar_pg_login()
	{

		if($this->conexion_bd){
			
			if(!pg_close($this->conexion_bd))
			{
				echo "Error al cerrar la conexión:".pg_last_error();
				return -1 ;
			}
			else
			{
				return $this->conexion_bd;
			}
		}
	}


	/**
	 * Nombre función:	conectar_mysql
	 * Propósito:		Permite abrir una conexión con una base de datos mysql en base a los parámetros de configuración
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function conectar_mysql()
	{
		if (!($id_conexion = @mysql_connect($HOST, $USUARIO, $CONTRASENA)))
		{
			return -1 ;
		}
		elseif ( ! @mysql_select_db ($BASE_DATOS, $id_conexion) )
		{
			return -1 ;
		}
		else
		return $id_conexion ;
	}

	//Cierra la conexión abierta con la base de datos Mysql

	/**
	 * Nombre función:	desconectar_mysql
	 * Propósito:		Cerrar una conexión abierta con una base de datos postgres
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function desconectar_mysql()
	{
		if(!@mysql_close($this->conexion_bd) )
		{
			echo "Error al cerrar la conexión:" . mysql_errno() . " Error: " . mysql_error() ;
			return -1 ;
		}
		else
		{
			return $this->conexion_bd;
		}
	}


	/**
	 * Nombre función:	NombreBD
	 * Propósito:		Devuelve el nombre de la Base de Datos de la configuración
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function NombreBD ()
	{
		return $this->dbname;
	}


	/**
	 * Nombre función:	Host
	 * Propósito:		Devuelve el nombre del Host de la configuración
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function Host ()
	{
		return $this->host;
	}


	/**
	 * Nombre función:	Usuario
	 * Propósito:		Devuelve el usuario para la conexión a la base de datos
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	18-05-2007
	 *
	 * @return unknown
	 */
	function Usuario()
	{
		return $this->usr;

	}

}
?>