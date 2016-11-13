<?php
	include_once "sitedefs.php";
	# Muestra el mensaje de confirmación
	$msg="";
	# Verificamos que el formulario no ha sido enviado aun
	$postback = (isset($_POST["enviar"])) ? true : false;
	# Concexión a la base de datos
	$link = pg_connect("host=$dbhost user=$dbuser password=$dbpwd dbname=$dbname") or die(pg_last_error($link));

	if($postback){		
		# Variables del archivo
		$type = $_FILES["archivo"]["type"];
		$tmp_name = $_FILES["archivo"]["tmp_name"];
		$size = $_FILES["archivo"]["size"];
		$nombre = basename($_FILES["archivo"]["name"]);
		
		# Contenido del archivo
	  $fp = fopen($tmp_name, "rb");
  	  $buffer = fread($fp, filesize($tmp_name));
		fclose($fp);
		
		# Descripción de la foto
		$desc = $_POST["desc"];
			
		$isoid=$_POST['tipo']=='oid'?true:false;
		
		if(!$isoid){
			# Escapa el contenido del archivo para ingresarlo como bytea
			$buffer=pg_escape_bytea($buffer);
			$sql = "INSERT INTO imagen(nombre, descripcion, imagen, mime, size)
							VALUES ('$nombre', '$desc', '$buffer', '$type', $size)";
		}
		else{
			# Inicia una transacción
			pg_query($link, "begin");
			# Crea un objeto blob y retorna el oid
			$oid=pg_lo_create($link);
			$sql = "INSERT INTO imagen(nombre, descripcion, archivo_oid, mime, size)
			VALUES ('$nombre', '$desc', $oid, '$type', $size)";
		}
		# Ejecuta la sentencia SQL
		pg_query($link, $sql) or die(pg_last_error($link));
		if($isoid){
			# Abre el objeto blob
			$blob=pg_lo_open($link,$oid,"w");
			# Escribe el contenido del archivo
			pg_lo_write($blob,$buffer);
			# Cierra el objeto
			pg_lo_close($blob);
			# Compromete la transacción
			pg_query($link, "commit");
		}		
		$msg="Archivo guardado";
	}
	# Lista los archivos subidos a la base de datos
	$sql = "select id_imagen, nombre, descripcion, coalesce(imagen,'-1') as archivo_bytea from imagen;";
	$result = pg_query($link, $sql);
	$lista = "";
	if($result){
		while ($row=pg_fetch_array($result)){
			$lista .= "<tr>\n";
			$lista .= "<td>$row[nombre]</td>\n";
			$lista .= "<td>$row[descripcion]</td>\n";
			$lista .= "<td><a href=\"download.php?id_imagen=$row[id_imagen]\" title=\"Intentar&aacute; mostrar el contenido del archivo\">Ver</a> | 
			<a href=\"download.php?id_imagen=$row[id_imagen]&amp;f=1\" title=\"Baja el archivo\">Bajar</a></td>\n";
			$lista .= "</tr>\n";
		} 
	}
	pg_free_result($result);	
	pg_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<title>Insertar archivos en un campo blob de PostgreSQL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>
<div id="contenedor">
	<div id="cabecera"><h1>Insertar y recuperar un campo BLOB con PHP y PostgreSQL</h1></div>
	<span class="msg"><?=$msg?></span>
	Subir archivo:
	<div id="postform">
		<form name="frmblob" id="frmblob" method="post" 
			enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'];?>">
			<fieldset>
				<label for="desc" accesskey="e">D<span class="key">e</span>scripci&oacute;n</label><br />
				<input type="text" id="desc" name="desc" size="55" title="Descripci&oacute;n del archivo" /><br />
				<label for="archivo" accesskey="r">A<span class="key">r</span>chivo</label><br />
				<input type="file" id="archivo" name="archivo" title="Archivo a subir" size="40" /><br />
				<label for="tipo" accesskey="i">T<span class="key">i</span>po</label><br />
				<select name="tipo" id="tipo" title="Tipo de dato del campo en que se guardar&aacute; el archivo">
					<option value="bytea" title="bytea" selected>bytea</option>
					<option value="oid" title="oid">oid</option>					
				</select><br />
				<input type="submit" name="enviar" id="enviar" value="Guardar" />
			</fieldset>
		</form>
	</div>
	<div id="files">
		<table>
		<tr>
			<th>Nombre</th>
			<th>Descripci&oacute;n</th>
			<th>Mostrar</th>
		</tr>
			<?=$lista?>
		</table>
	</div>
	<div id="pie">
		<a href="http://www.buayacorp.com" title="Programaci&oacute;n y Dise&ntilde;o">BuayaCorp</a> &copy; 2005<br />
		<a href="http://creativecommons.org/licenses/by/2.0/">
			<img src="ccsomerights.gif" alt="Licencia de Creative Commons" border="0">
		</a>
	</div>
</div>
</body>
</html>
