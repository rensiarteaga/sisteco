<?php
function crearModeloBD($direccion,$db,$sistema,$table,$prefijo,$codigo,$meta){

	$codigo = $prefijo."_"."$codigo";
	$table_fjava = FormatPhpToJava($table);
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$table = "t".strtolower($prefijo)."_".$table;

	//Crea los archivo del DB y el Custom
	$fp_handler=fopen("$direccion/cls_DB".$table_fjava.".php","w+");
	$fp_handler_custom=fopen("$direccion/cls_CustomDB$sistema". "_$table_fjava".".php","w+");

	$fecha=date("Y-m-d H:i:s");
	
/*	echo "<pre>";
	print_r($meta);
	echo "</pre>";*/


	//Genera el código para el archivo DB
	$sql = "<?php
/**
 * Nombre de la clase:	cls_DB".$table_fjava.".php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla t".strtolower($prefijo)."_".$table."
 * Autor:				(autogenerado)
 * Fecha creación:		$fecha
 */

class cls_DB$table_fjava
{
	var \$salida;
	var \$query;
	var \$var;
	var \$nombre_funcion;
	var \$codigo_procedimiento;
	var \$decodificar;
	
	function __construct()
	{
		\$this->decodificar=\$decodificar;
	}
	
	/**
	 * Nombre de la función:	Listar$table_fjava
	 * Propósito:				Desplegar los registros de $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Listar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad)
	{
		\$this->salida = \"\";
		\$this->nombre_funcion = 'f_$table"."_sel';
		\$this->codigo_procedimiento = \"'$codigo"."_SEL'\";

		\$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		\$this->var = new cls_middle(\$this->nombre_funcion,\$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		\$this->var->cant = \$cant;
		\$this->var->puntero = \$puntero;
		\$this->var->sortcol = \"'\$sortcol'\";
		\$this->var->sortdir = \"'\$sortdir'\";
		\$this->var->criterio_filtro = \"'\$criterio_filtro'\";

		//Carga los parámetros específicos de la estructura programática
		\$this->var->add_param(\$func->iif(\$id_financiador == '','NULL',\$id_financiador));//id_financiador
		\$this->var->add_param(\$func->iif(\$id_regional == '','NULL',\$id_regional));//id_regional
		\$this->var->add_param(\$func->iif(\$id_programa == '','NULL',\$id_programa));//id_programa
		\$this->var->add_param(\$func->iif(\$id_proyecto == '','NULL',\$id_proyecto));//id_proyecto
		\$this->var->add_param(\$func->iif(\$id_actividad == '','NULL',\$id_actividad));//id_actividad\n
		//Carga la definición de columnas con sus tipos de datos\n";

	for($i=0;$i<=$num_campos -1; $i ++)
	{
		$sql.="\t\t\$this->var->add_def_cols('".$meta[$i]["campo"] ."','".$meta[$i]["type"]."');\n";

		if($meta[$i]["referenciado"] != null){ //si es llave en otro lado sacamos la desripción de la tabla madre

			$vec_ref = $meta[$i]["referenciado"];
			$table_ref = $vec_ref[0];//tabla referenciada por el campo $i
			$id_table_ref = $vec_ref[1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);

			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$codigo_ref=$descripcion_tabla_ref["codigo"];
			$campo_ref=$descripcion_tabla_ref["dt_1"];
			$sistema_ref =$sistema;
			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla

			$aux_1="";
			foreach($meta_ref as $ref)
			{
				if($ref['campo']==$descripcion_tabla_ref['dt_1'])
				{
					$aux_1=$ref['type'];
					break;
				}
			}

			$sql.="\t\t\$this->var->add_def_cols('desc_$table_ref_sp','$aux_1');\n";

		}
	}



	//Ejecuta la función de consulta
	$sql.="\n\t\t//Ejecuta la función de consulta
		\$res = \$this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		\$this->salida = \$this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		\$this->query = \$this->var->query;
		return \$res;
	}
	
	/**
	 * Nombre de la función:	Contar$table_fjava
	 * Propósito:				Contar los registros de $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Contar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad)
	{
		\$this->salida = \"\";
		\$this->nombre_funcion = 'f_$table"."_sel';
		\$this->codigo_procedimiento = \"'$codigo"."_COUNT'\";

		\$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		\$this->var = new cls_middle(\$this->nombre_funcion,\$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		\$this->var->cant = \$cant;
		\$this->var->puntero = \$puntero;
		\$this->var->sortcol = \"'\$sortcol'\";
		\$this->var->sortdir = \"'\$sortdir'\";
		\$this->var->criterio_filtro = \"'\$criterio_filtro'\";

		//Carga los parámetros específicos de la estructura programática
		\$this->var->add_param(\$func->iif(\$id_financiador == '','NULL',\$id_financiador));//id_financiador
		\$this->var->add_param(\$func->iif(\$id_regional == '','NULL',\$id_regional));//id_regional
		\$this->var->add_param(\$func->iif(\$id_programa == '','NULL',\$id_programa));//id_programa
		\$this->var->add_param(\$func->iif(\$id_proyecto == '','NULL',\$id_proyecto));//id_proyecto
		\$this->var->add_param(\$func->iif(\$id_actividad == '','NULL',\$id_actividad));//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		\$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		\$res = \$this->var->exec_query();

		//Obtiene el array de salida de la función
		\$this->salida = \$this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if(\$res)
		{
			\$this->salida = \$this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		\$this->query = \$this->var->query;

		//Retorna el resultado de la ejecución
		return \$res;
	}
	
	/**
	 * Nombre de la función:	Insertar$table_fjava
	 * Propósito:				Permite ejecutar la función de inserción de la tabla $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Insertar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$sql.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$sql.="\$".$meta[$i]["campo"].")\n";
		}
	}

	$sql.= "\t{
		\$this->salida = \"\";
		\$this->nombre_funcion = 'f_$table"."_iud';
		\$this->codigo_procedimiento = \"'$codigo"."_INS'\";

		//Instancia la clase midlle para la ejecución de la función de la BD
		\$this->var = new cls_middle(\$this->nombre_funcion,\$this->codigo_procedimiento,\$this->decodificar);\n";

	$sql.="\t\t\$this->var->add_param(\"NULL\");\n";

	for($i=1;$i<=$num_campos -1; $i ++)
	{
		if($meta[$i]["type"]=='varchar'||$meta[$i]["type"]=='date'||$meta[$i]["type"]=='text'||$meta[$i]["type"]=='time'||$meta[$i]["type"]=='timestamp')
		{
			$sql.="\t\t\$this->var->add_param(\"'\$".$meta[$i]["campo"]."'\");\n";
		}
		else
		{
			$sql.="\t\t\$this->var->add_param(\$".$meta[$i]["campo"].");\n";
		}
	}

	$sql.="\n\t\t//Ejecuta la función
		\$res = \$this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		\$this->salida = \$this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		\$this->query = \$this->var->query;

		return \$res;
	}
	
	/**
	 * Nombre de la función:	Modificar$table_fjava
	 * Propósito:				Permite ejecutar la función de modificación de la tabla $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Modificar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$sql.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$sql.="\$".$meta[$i]["campo"].")\n";
		}
	}

	$sql.="\t{
		\$this->salida = \"\";
		\$this->nombre_funcion = 'f_$table"."_iud';
		\$this->codigo_procedimiento = \"'$codigo"."_UPD'\";

		//Instancia la clase midlle para la ejecución de la función de la BD
		\$this->var = new cls_middle(\$this->nombre_funcion,\$this->codigo_procedimiento,\$this->decodificar);\n";

	for($i=0;$i<=$num_campos -1; $i ++)
	{
		if($meta[$i]["type"]=='varchar'||$meta[$i]["type"]=='date'||$meta[$i]["type"]=='text'||$meta[$i]["type"]=='time'||$meta[$i]["type"]=='timestamp')
		{
			$sql.="\t\t\$this->var->add_param(\"'\$".$meta[$i]["campo"]."'\");\n";
		}
		else
		{
			$sql.="\t\t\$this->var->add_param(\$".$meta[$i]["campo"].");\n";
		}
	}


	$sql.="\n\t\t//Ejecuta la función
		\$res = \$this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		\$this->salida = \$this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		\$this->query = \$this->var->query;

		return \$res;
	}
	
	/**
	 * Nombre de la función:	Eliminar$table_fjava
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Eliminar$table_fjava(\$".$meta[0]["campo"].")";

	$sql.="\n\t{
		\$this->salida = \"\";
		\$this->nombre_funcion = 'f_$table"."_iud';
		\$this->codigo_procedimiento = \"'$codigo"."_DEL'\";

		//Instancia la clase midlle para la ejecución de la función de la BD
		\$this->var = new cls_middle(\$this->nombre_funcion,\$this->codigo_procedimiento,\$this->decodificar);\n";

	$sql.="\t\t\$this->var->add_param(\$".$meta[0]["campo"].");\n";

	for($i=1;$i<=$num_campos -1; $i ++)
	{
		$sql.="\t\t\$this->var->add_param(\"NULL\");\n";
	}

	$sql.="\n\t\t//Ejecuta la función
		\$res = \$this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		\$this->salida = \$this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		\$this->query = \$this->var->query;

		return \$res;
	}
	
	/**
	 * Nombre de la función:	Validar$table_fjava
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla $table
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		$fecha
	 */
	function Validar$table_fjava(\$operacion_sql,";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$sql.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$sql.="\$".$meta[$i]["campo"].")\n";
		}
	}

	$sql.="\t{
		\$this->salida = \"\";
		\$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		\$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if(\$operacion_sql=='insert' || \$operacion_sql=='update')
		{
			if(\$operacion_sql == 'update')
			{
				//Validar ".$meta[0]["campo"]." - tipo ".$meta[0]["type"]."
				\$tipo_dato->_reiniciar_valor();";

	if($meta[0]["modifier"]==-1)
	{
		$tam=10;
	}
	else 
	{
		$tam=$meta[0]["modifier"]-4;
	}

	$sql.="\n\t\t\t\t\$tipo_dato->set_MaxLength(".$tam.");
				\$tipo_dato->set_Columna(\"".$meta[0]["campo"]."\");

				if(!\$valid->verifica_dato(\$tipo_dato->TipoDatoInteger(), \"".$meta[0]["campo"]."\", \$".$meta[0]["campo"]."))
				{
					\$this->salida = \$valid->salida;
					return false;
				}
			}\n";
	for($i=1;$i<=$num_campos-1; $i++)
	{
		$tam=-1;
		if($meta[$i]["modifier"]>4)
		{
			$tam=$meta[$i]["modifier"]-4;
		}

		//Identifica el tipo de dato
		if($meta[$i]["type"]=='int4'||$meta[$i]["type"]=='int8')
		{
			$aux='TipoDatoInteger';
			if($tam==-1) $tam=10;
		}
		elseif($meta[$i]["type"]=='numeric')
		{
			$aux='TipoDatoReal';
			if($tam==-1) $tam=30;
		}
		elseif($meta[$i]["type"]=='date')
		{
			$aux='TipoDatoDate';
			if($tam==-1) $tam=10;
		}
		elseif($meta[$i]["type"]=='varchar')
		{
			$aux='TipoDatoText';
			if($tam==-1) $tam=200;
		}
		elseif($meta[$i]["type"]=='text')
		{
			$aux='TipoDatoText';
			if($tam==-1) $tam=300;
		}
		elseif($meta[$i]["type"]=='time')
		{
			$aux='TipoDatoTime';
			if($tam==-1) $tam=8;
		}
		else
		{
			$aux='TipoDatoText';
			if($tam==-1) $tam=100;
		}

		$sql.="\n\t\t\t//Validar ".$meta[$i]["campo"]." - tipo ".$meta[$i]["type"]."
			\$tipo_dato->_reiniciar_valor();
			\$tipo_dato->set_Columna(\"".$meta[$i]["campo"]."\");
			\$tipo_dato->set_MaxLength(".$tam.");\n";

		$sql.="\t\t\tif(!\$valid->verifica_dato(\$tipo_dato->".$aux."(), \"".$meta[$i]["campo"]."\", \$".$meta[$i]["campo"]."))
			{
				\$this->salida = \$valid->salida;
				return false;
			}\n";
	}

	//Genera la validación de datos que tiene CHECK en la base de datos
	$sw=0;
	for($i=1;$i<=$num_campos-1; $i++)
	{
		$aux = $meta[$i]["check"];
		if(sizeof($aux)>0)
		{
			if(!$sw)
			{
				$sw=1;
				$sql.="\n\t\t\t//Validación de reglas de datos\n\n";
			}
			$sql.="\t\t\t//Validar ".$meta[$i]["campo"]."
			\$check = array (";
			for($j=0;$j<=sizeof($aux)-1;$j++)
			{
				if($j==sizeof($aux)-1)
				{
					$sql.="\"".$aux[$j]."\");\n";
				}
				else
				{
					$sql.="\"".$aux[$j]."\",";
				}
			}
			$sql.="\t\t\tif(!in_array(\$".$meta[$i]["campo"].",\$check))
			{
				\$this->salida[0] = \"f\";
				\$this->salida[1] = \"Error de validación en columna '".$meta[$i]["campo"]."': El valor no está dentro del dominio definido\";
				\$this->salida[2] = \"ORIGEN = \$this->nombre_archivo\";
				\$this->salida[3] = \"PROC = Validar".$table_fjava."\";
				\$this->salida[4] = \"NIVEL = 3\";
				return false;
			}\n";

		}
	}


	$sql.="\t\t\t//Validación exitosa
			return true;
		}
		elseif (\$operacion_sql=='delete')
		{
			//Validar ".$meta[0]["campo"]." - tipo ".$meta[0]["type"]."
			\$tipo_dato->_reiniciar_valor();
			\$tipo_dato->set_Columna(\"".$meta[0]["campo"]."\");

			if(!\$valid->verifica_dato(\$tipo_dato->TipoDatoInteger(), \"".$meta[0]["campo"]."\", \$".$meta[0]["campo"]."))
			{
				\$this->salida = \$valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>";

	//Genera el código para el Custom

	$custom="<?php
/**
 * Nombre de la Clase:	    CustomDB$sistema
 * Propósito:				Interfaz del modelo del Sistema de $sistema
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		$fecha
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDB$sistema
{
	var \$salida = \"\";
	var \$query = \"\";
	var \$decodificar = false;

	function __construct()
	{
		include_once(\"cls_DB$table_fjava.php\");

	}
	
	/// --------------------- $table --------------------- ///

	function Listar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad)
	{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava ->Listar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad);
		\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	function Contar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad)
	{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava ->Contar$table_fjava(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad);
		\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	function Insertar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].")\n";
		}
	}
	$custom.="\t{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava ->Insertar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].");\n";
		}
	}

	$custom.="\t\t\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	function Modificar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].")\n";
		}
	}
	$custom.="\t{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava ->Modificar$table_fjava(";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].");\n";
		}
	}
	$custom.="\t\t\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	function Eliminar$table_fjava(\$".$meta[0]["campo"].")
	{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava -> Eliminar$table_fjava(\$".$meta[0]["campo"].");
		\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	function Validar$table_fjava(\$operacion_sql,";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].")\n";
		}
	}
	$custom.="\t{
		\$this->salida = \"\";
		\$db$table_fjava = new cls_DB$table_fjava(\$this->decodificar);
		\$res = \$db$table_fjava ->Validar$table_fjava(\$operacion_sql,";

	for($i=0;$i<=$num_campos-1; $i++)
	{
		if($i<$num_campos-1)
		{
			$custom.="\$".$meta[$i]["campo"].",";
		}
		else
		{
			$custom.="\$".$meta[$i]["campo"].");\n";
		}
	}
	$custom.="\t\t\$this->salida = \$db$table_fjava ->salida;
		\$this->query = \$db$table_fjava ->query;
		return \$res;
	}
	
	/// --------------------- fin $table --------------------- ///
}";



	//Guarda el código de los archivos
	fwrite($fp_handler,$sql);
	fwrite($fp_handler_custom,$custom);
	fclose($fp_handler);
	fclose($fp_handler_custom);
}
?>