<?php
/**
 * Nombre clase:	cls_middle
 * Propósito:		Clase que sirve de puente entre la conexión y la interfaz, para las llamadas a las funciones de la Base de Datos Postgres
 * Autor:			Rodrigo Chumacero Moscoso
 * Fecha creación:	22-05-2007
 *
 */
class cls_middle
{
	//variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;
	var $filtro_funcion='';//Filtro que se aumenta al final de la llamada de la función


	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Parámetros Fijos
	var $id_usuario;
	var $ip_origen;
	var $mac_maquina;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $proc_almacenado;
	var $parametros = array(); //array de parámetros específicos por tabla
	var $def_cols = array();//array de las definiciones de columnas en caso de que sea QUERY
	var $cols_def;

	//Parámetros para el filtro
	var $cant;
	var $puntero;
	var $sortcol;
	var $sortdir;
	var $criterio_filtro;
	

	//Variable que contendrá la conexión a la base de datos
	var $cnx;
	var $func; //Variable que contendrá las funciones generales del sistema

	//Variable que contiene el separador de cadenas usado en la BD
	var $sep = '#@@@#';

	//Variable que contiene el nombre del archivo
	var $nombre_archivo = "cls_middle.php";

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	var $criterio_funcion;
	
	//RCM 25/03/2011: para almacenar archivos en la base de datos
	var $byteArch='';
	var $nombreCampoArchivo='';
	var $parametrosArchivo = array();
	//RAC 21/05/2011: para manejo de datos bytea
	
	var $uploadFile=false;
	var $extencion;
	var $ruta_archivo;
	var $create_thumb=false;
	var $nombre_file;
	var $nombre_col;
	
	
	//FIN RCM

	/**
	 * Nombre función:	__construct
	 * Propósito:		Constructor de la clase cls_middle. Carga el nombre de la función y el código del procedimiento.
	 * 					Obtiene los parámetros fijos del usuario de la sesión (id_usuario, ip, macaddress)
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	22-05-2007
	 *
	 * @param unknown_type $nombre_funcion
	 * @param unknown_type $codigo_procedimiento
	 */
	function __construct($nombre_funcion, $codigo_procedimiento, $decodificar = false)
	{
		//Inicializa los parámetros fijos
		$this->id_usuario = "";
		$this->ip_origen = "";
		$this->mac_maquina = "";
		$this->nombre_funcion = "";
		$this->codigo_procedimiento = "";
		$this->proc_almacenado = "";

		//Inicializa los arrays de parámetros y de definición de columnas
		$this->parametros = array();
		$this->def_cols = array();

		//Inicializa los parámetros del filtro
		$this->cant = "15";
		$this->puntero = "";
		$this->sortcol = "";
		$this->sortdir = "asc";
		$this->criterio_filtro = "";

		//Obtiene los parámetros fijos de la sesión del usuario
		//$this->id_usuario = 10;
		$this->id_usuario = $_SESSION["ss_id_usuario"];
		//$this->ip_origen = "'200.87.181.201'";
		$this->ip_origen = $_SESSION["ss_ip"];
		$this->ip_origen = "'$this->ip_origen'";
		$this->mac_maquina = "'00:19:d1:09:22:7e'";

		//Añade el esquema a la funcion
		$this->nombre_funcion = $this->add_esquema($nombre_funcion);
		//$this->nombre_funcion = $nombre_funcion;


		$this->codigo_procedimiento = $codigo_procedimiento;
		$this->proc_almacenado = 'NULL';

		//Instancia la clase funciones que contiene las funciones generales para todo el sistema
		$this->func = new cls_funciones();

	}


	/**
	 * Nombre función:	exec_non_query
	 * Propósito:		Ejecuta las funciones de la base de datos que no sean querys (insert, update, delete),
	 * 					a partir del nombre de la función y de los parámetos necesarios de la función
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	22-05-2007
	 *
	 * @return unknown
	 */
	function exec_non_query()
	{
		//Array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función

		$this->query = "SELECT $this->nombre_funcion ($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concantena los parámetros específicos; sino existieran añade un paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= ','.implode(",", $this->parametros).')';
		}
		else
		{
			$this->query .=')';
		}

		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();
		$this->cnx->conectar_pg();

		// RAC:Incluimos la cadena de la noxeción en vez de la MAC
		//$consulta= "'".addcslashes($this->query)."'";

		
		
		//if(!$this->uploadFile){  ==> 22/08/2012 MZM comentado porque es importante q en todos los casos se envie en mac_maquina el contenido de la consulta completa
			
			
			$consulta=str_replace("'","''",$this->query);
		    $this->query=str_replace("'00:19:d1:09:22:7e'","'$consulta'",$this->query);
		
		
		//}==> 22/08/2012 MZM comentado porque es importante q en todos los casos se envie en mac_maquina el contenido de la consulta completa

		if(! $this -> verificarSesion())
		{
			//existen un problema co las vasrialbes de sesión
			$this->salida[0] = "f";
			$this->salida[1] = "MENSAJE ERROR = La sesión del usario ha sido duplicada";
			$this->salida[2] = "ORIGEN = $this->nombre_archivo";
			$this->salida[3] = "PROC = verificarSesion";
			$this->salida[4] = "NIVEL = 2";

			$this->cnx->desconectar_pg();

			return false;

		}

		else
		{

			//Ejecuta la función
			//echo 'query:'.$this->query;exit;
			if($result = pg_query($this->cnx->conexion_bd,$this->query))
			{
				//Carga el resultado en el array temporal de salida
				while ($row = pg_fetch_array($result))
				{
					array_push ($salida_temp, $row);
				}

				//Libera la memoria
				pg_free_result($result);

				//Cierra la conexión con postgres
				$this->cnx->desconectar_pg();

				//Verifica si se produjo algún error lógico en la función



				$resp_funcion = explode($this->sep, $salida_temp[0][0]);


				if(sizeof($resp_funcion)>0)
				{
					if($resp_funcion[0]==t)
					{
						//No existe error lógico
						$this->salida = $resp_funcion;
						return true;
					}
					elseif ($resp_funcion[0]==f)
					{
						//Existe error lógico
						$this->salida = $resp_funcion;
						return false;
					}
					else
					{
						//Si $resp_funcion no tiene ningún elemento, quiere decir que no hubo respuesta de la base de datos
						$this->salida[0] = "f";
						$this->salida[1] = "MENSAJE ERROR = No se obtuvo respuesta de la base de datos";
						$this->salida[2] = "ORIGEN = $this->nombre_archivo";
						$this->salida[3] = "PROC = exec_non_query";
						$this->salida[4] = "NIVEL = 2";
						return false;
					}
				}
				else
				{

					//Si $resp_funcion no tiene ningún elemento, quiere decir que no hubo respuesta de la base de datos
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = No se obtuvo respuesta de la base de datos";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = exec_non_query";
					$this->salida[4] = "NIVEL = 2";

					return false;

				}

			}
			else
			{
				//Se produjo un error a nivel de base de datos
				$resp_funcion = explode($this->sep, pg_last_error($this->cnx->conexion_bd));
				$this->salida[0] = "f";
				$this->salida[1] = $resp_funcion[1];
				$this->salida[2] = $resp_funcion[2];
				$this->salida[3] = $resp_funcion[3];
				$this->salida[4] = $resp_funcion[4];

				//Cierra la conexión con postgres
				$this->cnx->desconectar_pg();
				return false;
			}
		}

	}

	/**
	 * Nombre función:	exec_query
	 * Propósito:		Verifica la sesion del usuario logueado para detectar fraudes o robo de sesión
	 * Autor:			Rensi Arteaga Copari
	 * Fecha creación:	10-05-2010
	 *
	 * @return unknown
	 */
	function verificarSesion(){
		$salida_temp = array();
		$estado =true;
		
	

		if($this->nombre_funcion !='sss.f_tsg_sesion_iud'){


			$consulta = "SELECT sss.f_tsg_sesion_sel(".$_SESSION["ss_id_usuario"].",'".$_SERVER['REMOTE_ADDR']."','". session_id()."')";

			if($res_ses=pg_query($this->cnx->conexion_bd,$consulta)){


				//Carga el resultado en el array temporal de salida
				while ($row_ses = pg_fetch_array($res_ses))
				{
					array_push ($salida_temp, $row_ses);
				}

				/*echo "<pre>";
				print_r($salida_temp);
				echo "</pre>";
				exit;
				*/
				//Libera la memoria
				pg_free_result($res_ses);

				if($salida_temp[0][0]=='t'){

					return true;
				}
				else{
					return false;
				}


			}
			else {
				return false;

			}


		}

		return $estado;
	}
/**
	 * Nombre función:	exec_query
	 * Propósito:		Ejecuta las funciones de la base de datos de consultas (querys), a partir del nombre
	 * 					de la función y de los parámetos necesarios de la función
	 * Autor:			Julio Guarachi Lopez
	 * Fecha creación:	18/03/2011
	 * 

	 *
	 * @return unknown
	 */
	function exec_query_SQL($var='*',$tipo='both')
	{
		//Array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función con los parámetros fijos

		$this->query = "SELECT $var FROM $this->nombre_funcion($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concatena los parámetros del filtro
		$this->query .= ", $this->cant,$this->puntero,$this->sortcol,$this->sortdir";
		if($this->criterio_filtro != '')
		{
			$this->query .= ",".$this->esquema_filtro($this->criterio_filtro);
		}


		//Concatena los parámetros específicos si existieran, caso contrario cierra paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= ','.implode(",",$this->parametros) . ")";
		}
		else
		{
			$this->query.= ')';

		}

		//Concatena la lista de columnas con sus respectivos tipos de datos
		if(sizeof($this->def_cols)>0)
		{
			$this->query .= " AS (". implode(",",$this->def_cols).')';

			if($criterio_funcion)
			{
				$this->query .=$criterio_funcion;
			}

		}

		/*echo $this->query;
		exit();*/

		//RCM:18/11/2008 Verifica si está definido un criterio a nivel de llamada de función
		$this->add_filtro_funcion_llamada();
		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();
		$this->cnx->conectar_pg();

		if(! $this -> verificarSesion())
		{
			//existen un problema co las vasrialbes de sesión
			$this->salida[0] = "f";
			$this->salida[1] = "MENSAJE ERROR = La sesión del usario ha sido duplicada";
			$this->salida[2] = "ORIGEN = $this->nombre_archivo";
			$this->salida[3] = "PROC = verificarSesion";
			$this->salida[4] = "NIVEL = 2";

			$this->cnx->desconectar_pg();

			return false;

		}

		else
		{
			return $this->query ;
			$this->query='';
		}
	}
	
	
	
	/**
	 * Nombre función:	exec_query
	 * Propósito:		Ejecuta las funciones de la base de datos de consultas (querys), a partir del nombre
	 * 					de la función y de los parámetos necesarios de la función
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	22-05-2007
	 * HISTO MIDIFICACIONES
	 * AUTOR: Rensi Arteaga Copari
	 * Descripción: Se agrega funcionalidad adiconal para el manejode tipo de datos bytea
	 *              almacena los archivos generados en la carpeta indica 
	 *              solo soporta los siguientes formatos: JPG, GIF, JPEG
	 *
	 * @return unknown
	 */
	function exec_query($var='*',$tipo='both')
	{
		//Array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función con los parámetros fijos

		$this->query = "SELECT $var FROM $this->nombre_funcion($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concatena los parámetros del filtro
		$this->query .= ", $this->cant,$this->puntero,$this->sortcol,$this->sortdir";
		if($this->criterio_filtro != '')
		{
			$this->query .= ",".$this->esquema_filtro($this->criterio_filtro);
		}


		//Concatena los parámetros específicos si existieran, caso contrario cierra paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= ','.implode(",",$this->parametros) . ")";
		}
		else
		{
			$this->query.= ')';

		}

		//Concatena la lista de columnas con sus respectivos tipos de datos
		if(sizeof($this->def_cols)>0)
		{
			$this->query .= " AS (". implode(",",$this->def_cols).')';

			if($criterio_funcion)
			{
				$this->query .=$criterio_funcion;
			}

		}

		/*echo $this->query;
		exit();*/

		//RCM:18/11/2008 Verifica si está definido un criterio a nivel de llamada de función
		$this->add_filtro_funcion_llamada();


		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();
		$this->cnx->conectar_pg();

		//RAC:pregunta por la validez de lasesion


		if(! $this -> verificarSesion())
		{
			//existen un problema co las vasrialbes de sesión
			$this->salida[0] = "f";
			$this->salida[1] = "MENSAJE ERROR = La sesión del usario ha sido duplicada";
			$this->salida[2] = "ORIGEN = $this->nombre_archivo";
			$this->salida[3] = "PROC = verificarSesion";
			$this->salida[4] = "NIVEL = 2";

			$this->cnx->desconectar_pg();

			return false;

		}

		else
		{

			//Ejecuta la función
			//	echo($this->query);
			//		exit();

			if($result = pg_query($this->cnx->conexion_bd,$this->query))
			{
				
				
					
				
				
				//			echo "emtra";
				//			exit;
				//Carga el resultado en el array temporal de salida
				if($tipo=='both')
				{
					while ($row = pg_fetch_array($result))
					{
						array_push ($salida_temp, $row);
					}
				}
				elseif ($tipo=='numeral')
				{
					while ($row = pg_fetch_array($result,null,PGSQL_NUM))
					{
						array_push ($salida_temp, $row);
					}
				
				}
				else
				{
					while ($row = pg_fetch_array($result,null,PGSQL_ASSOC))
					{
						array_push ($salida_temp, $row);
					}
				}
				 pg_query($this->cnx->conexion_bd, "begin");
				
				if($this->uploadFile){
					
				 
				    //si la consulta contiene el tipo bytea
				    //recorres los resultados creando los archivos de la extencion correspondientes
				    //y los almacena en la carpeta indicada
				  $tam=0;
				  $tam=count($salida_temp);
				
					//var_dump($salida_temp);					
					
					//echo $tam;
				for($i=0;$i<=($tam-1);$i++)
				{
					if($salida_temp[$i][$this->extencion] != '')
					{						
						//RAC 19/05/2011
					   
		              	//mflores 03-10-2011 cambia la forma en q se crean los archivos en el servidor
		              	
						//crea un archivo fisico en el servidor
						$handle=fopen($this->ruta_archivo.$salida_temp[$i][$this->nombre_file].'.'.$salida_temp[$i][$this->extencion], "w+"); //abrir un enlace a la imagen de acuerdo al oid
			            $salida_temp[$i][$this->nombre_col]=pg_unescape_bytea($salida_temp[$i][$this->nombre_col]);
			            
			            //$salida_temp[$i][$this->nombre_col]=base64_decode(pg_unescape_bytea($salida_temp[$i][$this->nombre_col]));  //decodificar la imagen
				        fwrite($handle, $salida_temp[$i][$this->nombre_col]);
				        fclose($handle);
				        $salida_temp[$i][$this->nombre_col]=$salida_temp[$i][$this->nombre_file].'.'.$salida_temp[$i][$this->extencion];
				        
		              	$nom_arch=$salida_temp[$i][$this->nombre_file].'.'.$salida_temp[$i][$this->extencion];   
				         
				         //////////////
		              	
		              	 /*$oid=pg_lo_create($this->cnx->conexion_bd); 	//crear un oid para la imagen
						 $handle=pg_lo_open($this->cnx->conexion_bd,$oid,"w");	//abrir un enlace a la imagen de acuerdo al oid
						 $data=pg_lo_read_all($handle);	 //leer la imagen 
						
						 $salida_temp[$i][$this->nombre_col]=pg_unescape_bytea($salida_temp[$i][$this->nombre_col]); //decodificar la imagen
	
						 pg_lo_write($handle,$salida_temp[$i][$this->nombre_col]);	//escribir la imagen 
						pg_lo_close($handle);	//cerrar la conexion
						
						//arma nombre del archivo
						 $nom_arch=$salida_temp[$i][$this->nombre_file].'.'.$salida_temp[$i][$this->extencion];   
												
						pg_lo_export($this->cnx->conexion_bd,$oid,$this->ruta_archivo.$nom_arch);*/	//exportar la imagen a un archivo fisico												
										    
					    if($salida_temp[$i][$this->extencion] == 'jpg' || $salida_temp[$i][$this->extencion] == 'jpeg')
					    {
							
						    if($this->create_thumb){
							 	//$arc = new cls_archivos();
							 	//$arc->CreaThumb($this->ruta_archivo,$this->ruta_archivo,$nom_arch,'thumb_'.$nom_arch);
									
							 	$original = imagecreatefromjpeg($this->ruta_archivo.$nom_arch); //abrimos la imagen original
								$thumb = imagecreatetruecolor(70,70); // se crea una imagen pequeña de dimensiones 150 x 150
								
								$ancho = imagesx($original); //obtiene el ancho de la imagen
								$alto = imagesy($original); //obtiene el alto de la imagen
								imagecopyresampled($thumb,$original,0,0,0,0,70,70,$ancho,$alto); //sobre escribe la imagen original por el thumbnail
								
								//echo $carpeta_destino.$Custom->salida[$i]['numero'].'.'.$Custom->salida[$i]['extension']; exit;
								imagejpeg($thumb,$this->ruta_archivo.$nom_arch,90);// 90 es la calidad de compresión				
						
						    }
					    }
						//MFLORES 29-06-11
						    
						if($salida_temp[$i][$this->extencion] == 'gif')
					    {
							
						    if($this->create_thumb){
							 	//$arc = new cls_archivos();
							 	//$arc->CreaThumb($this->ruta_archivo,$this->ruta_archivo,$nom_arch,'thumb_'.$nom_arch);
									
							 	$original = imagecreatefromgif($this->ruta_archivo.$nom_arch); //abrimos la imagen original
								$thumb = imagecreatetruecolor(70,70); // se crea una imagen pequeña de dimensiones 150 x 150
								
								$ancho = imagesx($original); //obtiene el ancho de la imagen
								$alto = imagesy($original); //obtiene el alto de la imagen
								imagecopyresampled($thumb,$original,0,0,0,0,70,70,$ancho,$alto); //sobre escribe la imagen original por el thumbnail
								
								//echo $carpeta_destino.$Custom->salida[$i]['numero'].'.'.$Custom->salida[$i]['extension']; exit;
								imagegif($thumb,$this->ruta_archivo.$nom_arch,90);// 90 es la calidad de compresión				
						
						    }
					    }
					    
					    # creacion de thumbnail
						/*if($salida_temp[$i][$this->extencion] == 'png')
					    {
							
						    if($this->create_thumb)
						    {
								$original = imagecreatefrompng($this->ruta_archivo.$nom_arch); //abrimos la imagen original
								$thumb = imagecreatetruecolor(70,70); // se crea una imagen pequeña de dimensiones 150 x 150
								
								$ancho = imagesx($original); //obtiene el ancho de la imagen
								$alto = imagesy($original); //obtiene el alto de la imagen
								imagecopyresampled($thumb,$original,0,0,0,0,70,70,$ancho,$alto); //sobre escribe la imagen original por el thumbnail
								
								imagepng($thumb,$this->ruta_archivo.$nom_arch,5); // en png la compresión es de 0-9
							}
					    }*/
			         }
				}
		          
		          	
				//exit;
				
				
					
				}
			
				pg_query($this->cnx->conexion_bd,"commit");

				//Libera la memoria
				pg_free_result($result);

				//Cierra la conexión con postgres
				$this->cnx->desconectar_pg();

				//Define el array de salida
				$this->salida = $salida_temp;
				return true;
			}
			else
			{
				//			echo "else".$result = pg_query($this->cnx->conexion_bd,$this->query);
				//			exit;
				//Se produjo un error a nivel de base de datos (acá saltan los exceptions que definimos en postgres)
				$resp_funcion = explode($this->sep, pg_last_error($this->cnx->conexion_bd));
				$this->salida[0] = "f";
				$this->salida[1] = $resp_funcion[1];
				$this->salida[2] = $resp_funcion[2];
				$this->salida[3] = $resp_funcion[3];
				$this->salida[4] = $resp_funcion[4];

				//Cierra la conexión con postgres
				$this->cnx->desconectar_pg();

				return false;
			}
		}
	}
	
		
	
	

	/**
	 * Nombre función:	exec_query_sg
	 * Propósito:		Ejecuta las funciones de la base de datos que no sean querys (insert, update, delete),
	 * 					a partir del nombre de la función y de los parámetos necesarios de la función
	 * Autor:			Enzo Rojas
	 * Fecha creación:	22-05-2007
	 *
	 * @return unknown
	 */
	function exec_query_sss()
	{
		include_once("cls_conexion.php");

		//array que contendrá el resultado del query
		$salida_temp = array();
		//$this->query = "SELECT * FROM $this->nombre_funcion($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";
		//Forma la llamada a la función con los parámetros fijos
		$this->query = "SELECT * FROM $this->nombre_funcion(";


		//Concatena los parámetros del filtro-->no necesarion para el caso de login
		//$this->query .= ", $this->cant,$this->puntero,$this->sortcol,$this->sortdir,$this->criterio_filtro";

		//Concatena los parámetros específicos si existieran, caso contrario cierra paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= ''.implode(",",$this->parametros) . ")";
		}
		else
		{
			$this->query.= ')';
		}

		//Concatena la lista de columnas con sus respectivos tipos de datos
		if(sizeof($this->def_cols)>0)
		{
			$this->query .= " AS (". implode(",",$this->def_cols).')';
		}

		//Se abre la conexión a la base de datos


		$this->cnx = new cls_conexion();

		$this->cnx->conectar_pg();  //30.12.2014  temproalmente


		//Ejecuta la función
		if($result = pg_query($this->cnx->conexion_bd,$this->query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();

			//Define el array de salida
			$this->salida = $salida_temp;
			return true;
		}
		else
		{
			//Se produjo un error a nivel de base de datos (acá saltan los exceptions que definimos en postgres)
			$resp_funcion = explode($this->sep, pg_last_error($this->cnx->conexion_bd));
			$this->salida[0] = "f";
			$this->salida[1] = $resp_funcion[1];
			$this->salida[2] = $resp_funcion[2];
			$this->salida[3] = $resp_funcion[3];
			$this->salida[4] = $resp_funcion[4];

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();

			return false;

		}
	}
	function exec_non_query_sss()
	{
		//	include_once("cls_conexion.php");

		//Array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función
		$this->query = "SELECT * FROM $this->nombre_funcion(";

		//Concantena los parámetros específicos; sino existieran añade un paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= ''.implode(",", $this->parametros).')';
		}
		else
		{
			$this->query .=')';
		}

		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();

		$this->cnx->conectar_pg_login();




		//Ejecuta la función
		if($result = pg_query($this->cnx->conexion_bd,$this->query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg_login();

			//Verifica si se produjo algún error lógico en la función
			$resp_funcion = explode($this->sep, $salida_temp[0][0]);

			if(sizeof($resp_funcion)>0)
			{
				if($resp_funcion[0]==t)
				{
					//No existe error lógico

					$this->salida = $resp_funcion;
					return true;
				}
				elseif ($resp_funcion[0]==f)
				{
					//Existe error lógico
					$this->salida = $resp_funcion;
					return false;
				}
				else
				{
					//Si $resp_funcion no tiene ningún elemento, quiere decir que no hubo respuesta de la base de datos
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = No se obtuvo respuesta de la base de datos";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = exec_non_query";
					$this->salida[4] = "NIVEL = 2";
					return false;
				}
			}
			else
			{
				//Si $resp_funcion no tiene ningún elemento, quiere decir que no hubo respuesta de la base de datos
				$this->salida = 'No se obtuvo respuesta de la base de datos';
				return false;
			}
		}
		else
		{
			//Se produjo un error a nivel de base de datos
			$resp_funcion = explode($this->sep, pg_last_error($this->cnx->conexion_bd));
			$this->salida[0] = "f";
			$this->salida[1] = $resp_funcion[1];
			$this->salida[2] = $resp_funcion[2];
			$this->salida[3] = $resp_funcion[3];
			$this->salida[4] = $resp_funcion[4];

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg_login();
			return false;
		}
	}

	/**
	 * Nombre función: 	exec_function
	 * Propósito:		Ejecutar cualquier función de postgres que no necesite definición de columnas
	 * Autor:			Rodrigo Chumacero Moscoso
	 * Fecha creación:	28-06-2007
	 *
	 * @return unknown
	 */
	function exec_function()
	{
		//Array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función con los parámetros fijos
		$this->query = "SELECT $this->nombre_funcion(";

		//Concatena los parámetros específicos si existieran, caso contrario cierra paréntesis
		if(sizeof($this->parametros)>0)
		{
			$this->query .= implode(",",$this->parametros) . ")";
		}
		else
		{
			$this->query.= ')';
		}

		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();
		$this->cnx->conectar_pg();

		//Ejecuta la función
		if($result = pg_query($this->cnx->conexion_bd,$this->query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();

			//Define el array de salida
			$this->salida = $salida_temp;

			return true;
		}
		else
		{
			//Se produjo un error a nivel de base de datos (acá saltan los exceptions que definimos en postgres)
			$resp_funcion = explode($this->sep, pg_last_error($this->cnx->conexion_bd));
			$this->salida[0] = "f";
			$this->salida[1] = $resp_funcion[1];
			$this->salida[2] = $resp_funcion[2];
			$this->salida[3] = $resp_funcion[3];
			$this->salida[4] = $resp_funcion[4];

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();

			return false;
		}
	}

	//Función que verifica si la transacción efectuada requiere un envío de alerta
	function verifica_alerta($id_usuario, $ip_origen, $mac_maquina, $codigo_procedimiento, $proc_almacenado, $mensaje_alerta)
	{
		include_once("cls_conexion.php");

		//Define el nombre de la función de verificación de envío de alerta
		$this->nombre_funcion = 'f_pm_verifica_envio_alerta' ;

		//array que contendrá el resultado del query
		$salida_temp = array();

		//Forma la llamada a la función
		$this->query = "SELECT * FROM $this->nombre_funcion($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado,$mensaje_alerta)";

		//Se abre la conexión a la base de datos
		$this->cnx = new cls_conexion();
		$this->cnx->conectar_pg();

		//Ejecuta la función
		if($result = pg_query($this->cnx->conexion_bd, $this->query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();

			//Define el array de salida
			$this->salida = $salida_temp;

			//Si el array es mayor a cero devuelve true, caso contrario false
			if(sizeof($this->salida)>0) return true;
			else return false;

		}
		else
		{
			//Se produjo un error a nivel de base de datos
			$this->salida = pg_last_error($this->cnx->conexion_bd);

			//Cierra la conexión con postgres
			$this->cnx->desconectar_pg();
			return false;
		}
	}

	//Función que adiciona parámetros específicos para las funciones (aparte de los fijos y del filtro)
	function add_param($param)
	{
		//Valida sin son vacíos o solo tienen comillitas ("''")
		$aux = $this->func->iif($param == '','NULL',$param);
		$aux = $this->func->iif($aux == "''",'NULL',$aux);

		//Se verifica si se decodifica el dato o no
		if(!$this->decodificar)
		{	
			$aux = utf8_decode($aux);
		}
		
		array_push ($this->parametros, $aux);

	}
	
	/*
	 * Autor: Rensi Arteaga Copari
	 * Fecha: 1/12/2010
	 * Descripcion:se utiliza para madar archivos en formato bytea
	 * */
	
	function add_archivo($param)
	{
		//Valida sin son vacíos o solo tienen comillitas ("''")
	
		$data = file_get_contents($param);
		$foto = pg_escape_bytea($data);	
			
		$this->uploadFile=true;
		array_push ($this->parametros,"'$foto'");
	}
	
	
/*
	 * Autor: Rensi Arteaga Copari
	 * Fecha: 1/12/2010
	 * Descripcion:se utiliza para madar array como parametros a los procedimientos almacenados  
	 * */
	
	function add_param_array($param){
		//Valida sin son vacíos o solo tienen comillitas ("''")
		
		if($param!="NULL"){
			
			if(sizeof($param)>0){
				$param_array  = "'{". implode(",",$param)."}'";
			}
			else{
				$param_array  = "'{}'";
				
			}
			 
			array_push ($this->parametros,$param_array);
		}
		else{
			array_push ($this->parametros,$param);			
		}
		
		
		
	}
	
	

	//Función que adiciona definición de columnas para querys
	function add_def_cols($nombre_col,$tipo_dato,$nombre_file='',$extencion='jpg',$ruta_archivo='',$create_thumb=false)
	{
		if($tipo_dato=='bytea')
		{
			$this->uploadFile=true;
			$this->extencion=$extencion;
			$this->ruta_archivo=$ruta_archivo;
			$this->create_thumb=$create_thumb;
			$this->nombre_file=$nombre_file;
			$this->nombre_col=$nombre_col;			
		}
				
		$aux = $nombre_col . " ".$tipo_dato;
		array_push($this->def_cols, $aux);
	}
	
	function add_esquema($nom_fun){

		if(substr($nom_fun,0,5)=='f_al_'||substr($nom_fun,0,6)=='f_tal_'||substr($nom_fun,0,6)=='f_val_'){
			return "almin.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_af_'||substr($nom_fun,0,6)=='f_taf_'){
			return "actif.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_ad_'||substr($nom_fun,0,6)=='f_tad_'){
			return "compro.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_ca_'||substr($nom_fun,0,6)=='f_tca_'){
			return "casis.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_ct_'||substr($nom_fun,0,6)=='f_tct_'){
			return "sci.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_fv_'||substr($nom_fun,0,6)=='f_tfv_'){
			return "factur.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_kp_'||substr($nom_fun,0,6)=='f_tkp_'){
			return "kard.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_pm_'||substr($nom_fun,0,6)=='f_tpm_'){
			return "param.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_sg_'||substr($nom_fun,0,6)=='f_tsg_'){
			return "sss.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_st_'||substr($nom_fun,0,6)=='f_tst_'){
			return "gestel.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_pr_'||substr($nom_fun,0,6)=='f_tpr_'){
			return "presto.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_ts_'||substr($nom_fun,0,6)=='f_tts_'){
			return "tesoro.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_sp_'||substr($nom_fun,0,6)=='f_tsp_'){
			return "pspro.$nom_fun";
		}
		elseif (substr($nom_fun,0,5)=='f_si_'||substr($nom_fun,0,6)=='f_tsi_'){
			return "sigma.$nom_fun";
		} 
		elseif (substr($nom_fun,0,5)=='f_fl_'||substr($nom_fun,0,6)=='f_tfl_'){
			return "flujo.$nom_fun";
		} 
		elseif (substr($nom_fun,0,5)=='f_ai_'||substr($nom_fun,0,6)=='f_tai_'){
			return "alma.$nom_fun";
		}
		else{
			return $nom_fun;
		}
	}

	function esquema_filtro($filtro){
		$res="";
		$res=$filtro;
		//tablas
		$res=str_replace(" tad_"," compro.tad_",$res);
		$res=str_replace(" tal_"," almin.tal_",$res);
		$res=str_replace(" taf_"," actif.taf_",$res);
		$res=str_replace(" tca_"," casis.tca_",$res);
		$res=str_replace(" tct_"," sci.tct_",$res);
		$res=str_replace(" tfv_"," factur.tfv_",$res);
		$res=str_replace(" tkp_"," kard.tkp_",$res);

		$res=str_replace(" tpm_"," param.tpm_",$res);
		$res=str_replace(" tsg_"," sss.tsg_",$res);
		$res=str_replace(" tst_"," gestel.tst_",$res);
		$res=str_replace(" tpr_"," presto.tpr_",$res);
		$res=str_replace(" tts_"," tesoro.tts_",$res);
		$res=str_replace(" tsp_"," pspro.tsp_",$res);
		$res=str_replace(" tsi_"," sigma.tsi_",$res);
		$res=str_replace(" tfl_"," flujo.tfl_",$res);
		
		
		$res=str_replace(" tai_"," alma.tai_",$res);

		//vistas


		$res=str_replace(" vad_"," compro.vad_",$res);
		$res=str_replace(" val_"," almin.val_",$res);
		$res=str_replace(" vaf_"," actif.vaf_",$res);
		$res=str_replace(" vca_"," casis.vca_",$res);
		$res=str_replace(" vct_"," sci.vct_",$res);
		$res=str_replace(" vfv_"," factur.vfv_",$res);
		$res=str_replace(" vkp_"," kard.vkp_",$res);
		$res=str_replace(" vpm_"," param.vpm_",$res);
		$res=str_replace(" vsg_"," sss.vsg_",$res);
		$res=str_replace(" vst_"," gestel.vst_",$res);
		$res=str_replace(" vpr_"," presto.vpr_",$res);
		$res=str_replace(" vts_"," tesoro.vts_",$res);
		$res=str_replace(" vsp_"," pspro.vsp_",$res);
		$res=str_replace(" vsi_"," sigma.vsi_",$res);
		$res=str_replace(" vfl_"," flujo.vfl_",$res);

		$res=str_replace(" vai_"," alma.vai_",$res);
		return $res;

	}

	function get_query_iud(){
		//Forma la llamada a la función
		$sql="";
		$sql = "SELECT $this->nombre_funcion ($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concantena los parámetros específicos; sino existieran añade un paréntesis
		if(sizeof($this->parametros)>0){
			$sql .= ','.implode(",", $this->parametros).')';
		}
		else{
			$sql .=')';
		}

		return $sql;
	}

	function get_query_sel(){
		//Forma la llamada a la función
		$sql="";
		$sql = "SELECT * FROM $this->nombre_funcion($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";
		$sql .= ", $this->cant,$this->puntero,$this->sortcol,$this->sortdir";

		if($this->criterio_filtro != ''){
			$sql .= ",".$this->esquema_filtro($this->criterio_filtro);
		}

		//Concantena los parámetros específicos; sino existieran añade un paréntesis
		if(sizeof($this->parametros)>0){
			$sql .= ','.implode(",", $this->parametros).')';
		}
		else{
			$sql .=')';
		}

		//Concatena la lista de columnas con sus respectivos tipos de datos
		if(sizeof($this->def_cols)>0)
		{
			$sql .= " AS (". implode(",",$this->def_cols).')';

			if($criterio_funcion)
			{
				$sql .=$criterio_funcion;
			}

		}

		return $sql;
	}

	//RCM: 18/11/2008
	//Función que permite añadir un filtro a nivel de llamada de la función, sólo para el caso de Ejecutar Query
	function add_filtro_funcion($filtro){
		$this->filtro_funcion=$filtro;
	}

	//RCM: 18/11/2008
	//Función que agrega el filtro (si fue definido) a la cadena query a ejecutar
	private function add_filtro_funcion_llamada(){
		if($this->filtro_funcion!=''){
			$this->query.=" WHERE ".$this->filtro_funcion;
		}
	}
	
}
?>
