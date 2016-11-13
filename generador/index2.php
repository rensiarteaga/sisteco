<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Generador de codigo</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="lib/ActionGenerarArbol.php">

<table width="45%" border="2" cellpadding="3" cellspacing="0">
  <tr>
   <!-- <td width="60%">&nbsp;</td>-->
    <td width="100%" colspan="0"><b><div align="center">Generador de Codigo v1.5</div></b></td>
  </tr>
  
  <tr bgcolor="#55D562">
    <td><b>NODO INICIO</b></td>
    <td><label>
      <div align="center">
        <input type="text" name="nodoInicio"/>
        </div>
    </label></td>
  </tr>  
  <tr>
  <td>SUBSISTEMA (Ej. ALMIN)</td>
    <td><label>
      <div align="center">
      	<select name="idSubSistema">		
		<option value="3">ALMIN</option>
      	<option value="2">ACTIF</option>		
		<option value="4">SICOMP</option>
		<option value="5">KARD</option>
		<option value="6">SSS</option>
		<option value="7">PARAM</option>
		<option value="9">SCI</option>
		<option value="10">Facturación y Ventas (FACTUR)</option>
		<option value="47">CASIS</option>
		</select>   
      <!--<input type="text" name="idSubSistema""/>-->
        </div>
    </label></td>
  </tr>
    <td>SISTEMA</td>
    <td><label>
      <div align="center">
        <input type="text" name="sistema" disabled="true" value="Definido en cada tabla"/>
        </div>
    </label></td>
  </tr>  
  <tr>
    <td>Nombre Logico de la Tabla (sin prefijo)</td>
    <td><label>
      <div align="center">
        <input type="text" name="tableName" disabled="true" value="Definido en cada tabla"/>
        </div>
    </label></td>
  </tr>
  <tr>
    <td>Codigo del Proceso </td>
    <td><div align="center">
      <input type="text" name="codigo" disabled="true" value="Definido en cada tabla"/>
    </div></td>
  </tr>
  <tr>
    <td>Prefijo (2 caracteres)</td>
    <td><div align="center">
      <input type="text" name="prefijo" disabled="true" value="Definido en cada tabla"/>
    </div></td>
  </tr>
  <tr>
    <td height="47">&nbsp;</td>
    <td><label>
      <div align="center">
        <input type="submit" name="Submit" value="Enviar"/>
        <input type="reset" name="Submit2" value="Reset"/>
        </div>
    </label></td>
  </tr>
</table>
</form>
</body>
</html>