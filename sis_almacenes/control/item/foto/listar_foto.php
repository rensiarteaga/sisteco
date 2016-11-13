<?php
        # El par�metro f=1 indica que se va a forzar a bajar el archivo
        $f=isset($_REQUEST['f'])?$_REQUEST['f']:0;
        # Recupera el id pasado como par�metro
       // $id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
       $id=1;
      //  include_once "sitedefs.php";
      $dbhost='192.168.0.14';
      $dbuser='avillegas';
      $dbpwd='avillegas';
      $dbname='dbendesis';
      
        # Conexi�n a la base de datos
        $link = pg_connect("host=$dbhost user=$dbuser password=$dbpwd dbname=$dbname") or die(pg_last_error($link));

        # Recupera el archivo en base al ID
        $sql = "select id_item_archivo, descripcion,coalesce(archivo,'-1') as archivo_bytea from tal_item_archivo where id_item_archivo=4";
        $result=pg_query($link, $sql);
        # Si no existe, redirecciona a la p�gina principal
        if(!$result || pg_num_rows($result)<1){
                header("Location: index.php");
                exit();
        }
        # Recupera los atributos del archivo
        $row=pg_fetch_array($result,0);
        pg_free_result($result);
        # Para determinar si archivo a bajar fue ingresado al campo archivo_oid (es de tipo "oid")
        $isoid=false;
        if($row['archivo']==-1) $isoid=true;
        //if($row['archivo']==-1) $isoid=true;
        if($row['archivo']==-1 && $row['archivo']==-1) die('No existe el archivo para mostrar o bajar');
                 # Hace el proceso inverso a pg_escape_bytea, para que el archivo est� en su estado original
                $file=pg_unescape_bytea($row['archivo']);
        
        # Env�o de cabeceras
        header("Cache-control: private");
        header("Content-type: $row[mime]");
        if($f==1)
                header("Content-Disposition: attachment; filename='$row[nombre]'");
        header("Content-length: $row[size]");
        header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        
        if($isoid){
                # Imprime el contenido del objeto blob
                pg_lo_read_all($file);
                # Cierra el objeto
                pg_lo_close($file);
                # Compromete la transacci�n
                pg_query($link, "commit");
        }
        else{
                # Imprime el contenido del archivo
                print $file;
        }
        pg_close($link);        
?>
