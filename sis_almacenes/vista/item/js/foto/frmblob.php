<?php
       // include_once "sitedefs.php";
        # Muestra el mensaje de confirmación
        $msg="";
        # Verificamos que el formulario no ha sido enviado aun
        $postback = (isset($_POST["enviar"])) ? true : false;
        # Concexión a la base de datos
        $dbhost='192.168.0.14';
      $dbuser='avillegas';
      $dbpwd='avillegas';
      $dbname='dbendesis';
     
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
                        $sql = "INSERT INTO foo(nombre, descripcion, archivo_bytea, mime, size)
                                                        VALUES ('$nombre', '$desc', '$buffer', '$type', $size)";
                }
                else{
                        # Inicia una transacción
                        pg_query($link, "begin");
                        # Crea un objeto blob y retorna el oid
                        $oid=pg_lo_create($link);
                        $sql = "INSERT INTO foo(nombre, descripcion, archivo_oid, mime, size)
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
        $sql = "select id, nombre, descripcion, coalesce(archivo_oid,-1) as archivo_oid, 
                coalesce(archivo_bytea,'-1') as archivo_bytea from foo;";
        $result = pg_query($link, $sql);
        $lista = "";
        if($result){
                while ($row=pg_fetch_array($result)){
                        $lista .= "<tr>";
                        $lista .= "<td>$row[nombre]</td>";
                        $lista .= "<td>$row[descripcion]</td>";
                        $lista .= "<td><a href='download.php?id=$row[id]' title='Intentará mostrar el contenido del archivo'>Ver</a> | 
                        <a href='download.php?id=$row[id]&f=1' title='Baja el archivo'>Bajar</a></td>";
                        $lista .= "</tr>";
                } 
        }
        pg_free_result($result);        
        pg_close($link);
?>