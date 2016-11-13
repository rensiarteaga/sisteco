<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<title>Insertar archivos en un campo blob de PostgreSQL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link rel="stylesheet" type="text/css" media="screen" href="main.css" />-->
</head>
<body>
<div id="contenedor">
        <div id="cabecera"><h1>Insertar y recuperar un campo BLOB con PHP y PostgreSQL</h1></div>
        <span class="msg"><?=$msg?></span>
        Subir archivo:
        <div id="postform">
                <form name="frmblob" id="frmblob" method="post" 
                        enctype="multipart/form-data" action="frmblob.php">
                        <fieldset>
                                <label for="desc" accesskey="e">D<span class="key">e</span>scripción</label><br />
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
                        <th>Descripción</th>
                        <th>Mostrar</th>
                </tr>
                        <?=$lista?>
                </table>
        </div>
       
</div>
</body>
</html>

