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
                $desc = $_POST["desc"];
                $id_item = 1;
                $extension = "gif";
                /*$id_item = $_POST["id_item"];
                $extension = $_POST["extension"];
                */
                $tipo = $_FILES["archivo"]["type"];
                $tmp_name = $_FILES["archivo"]["tmp_name"];
                $size = $_FILES["archivo"]["size"];
                $nombre = basename($_FILES["archivo"]["name"]);
                # Contenido del archivo
          $fp = fopen($tmp_name, "rb");
        $buffer = fread($fp, filesize($tmp_name));
                fclose($fp);
                # Descripción de la foto
                $isoid=$_POST['tipo']=='oid'?true:false;
                if(!$isoid){
                        # Escapa el contenido del archivo para ingresarlo como bytea
                        $buffer=pg_escape_bytea($buffer);
                        $sql = "INSERT INTO tal_item_archivo(descripcion,tipo,archivo,extension,id_item)
                                                        VALUES ('$desc', 'Foto', '$buffer', '$extension',$id_item)";
                }
                else{
                        # Inicia una transacción
                        pg_query($link, "begin");
                        # Crea un objeto blob y retorna el oid
                        $oid=pg_lo_create($link);
                      $sql = "INSERT INTO tal_item_archivo(descripcion,tipo,archivo,extension,fecha_reg,id_item)
                                                        VALUES ('$descripcion', '$tipo', '$buffer', '$extension','$fecha_reg',$id_item)";
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
        $sql = "select id_item_archivo, descripcion, coalesce(archivo,'-1') as archivo_bytea from tal_item_archivo;";
        $result = pg_query($link, $sql);
        $lista = "";
        if($result){
                while ($row=pg_fetch_array($result)){
                        $lista .= "<tr>";
                        $lista .= "<td>$row[descripcion]</td>";
                        $lista .= "<td><a href='download.php?id=$row[id_item_archivo]' title='Intentará mostrar el contenido del archivo'>Ver</a> | 
                        <a href='download.php?id=$row[id_item_archivo]&f=1' title='Baja el archivo'>Bajar</a></td>";
                        $lista .= "</tr>";
                } 
        }
        pg_free_result($result);        
        pg_close($link);
?>