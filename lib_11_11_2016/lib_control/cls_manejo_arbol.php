<?php
/**
 * Nombre clase:	cls_manejo_arbol.php
 * Propósito:		Permite crear cadenas en formato html para generar un arbol basico
 * Autor:			Enzo Rojas
 * Fecha creación:	12-06-2007
 *
 */
header("content-type: text/html; charset=ISO-8859-15");
class cls_manejo_arbol
{
	var $html;//Variable que contendrá el html
	var $raiz_arbol;
	var $pagina_inicio; //pagina a la que enlazara la raiz
	var $func; //instancia de la clase funciones para acceder a sus métodos
	//	var $array_etiquetas_rama = array();//Array que contendrá las etiquetas de todas las ramas temporalmente
	var $id_rama = 0;
	/*var $encoding; //Codificación que se utilizará para el despliegue
	var $version_html;//Versión del html*/

	public function __construct($raiz_arbol,$pagina_inicio)
	{
		/*$this->encoding = $encoding;
		$this->version_html = $version_html;*/
		$this->raiz_arbol = $raiz_arbol;
		$this->pagina_inicio = $pagina_inicio;
		$this->func = new cls_funciones();

		//Crea el encabezado del html para el arbol
		//$this->html = "<div id=\"classes\" class=\"ylayout-inactive-content\">\n<!-- Inicio Arbol -->\n<a id=\"welcome-link\" href=\"$this->pagina_inicio\">$this->raiz_arbol</a>\n";
		$this->html = "\n<!-- Inicio Arbol -->\n<a id=\"welcome-link\" href=\"$this->pagina_inicio\">$this->raiz_arbol</a>\n";
	}
 
	//Añade un nodo
	public function add_nodo($etiqueta_nodo, $enlace,$tipo, $descripcion)
	{
		//tipo "ex", engranajes
		$tipo = $this->func->iif(isset($tipo),$tipo,"");
		$enlace = $this->func->iif((isset($enlace) && trim($enlace)!=""),$enlace,"sis_seguridad/vista/administracion/default.html");
		//onmouseout="window.status='';return true;" onmouseover="window.status='Descripcion del nodo';return true;"

		$this->html .= "\t<a title=\"$descripcion\" class=\"$tipo\" href=\"../../../$enlace\">$etiqueta_nodo</a>\n";
	}

	//Añade una rama
	public function add_rama($etiqueta_rama)
	{
		//Coloca temporalmente la etiqueta de la rama, hasta que se cierre (al cerrar se borrará el elemento de la etiqueta)
		//		array_push($this->array_etiquetas_rama,$etiqueta_rama);
		global $id_rama;
		$nombreid="aid".($id_rama++);
		$this->html .= "<div class=\"pkg\" name=\"$nombreid\"><h3>$etiqueta_rama</h3>\n  <div class=\"pkg-body\">\n";
	}

	public function fin_rama()
	{
		//		$aux = array_pop($this->array_etiquetas_rama);
		$this->html .= "  </div>\n</div>\n";
	}

	public function cadena_html()
	{
		return $this->html .= "
		      												    		                       
							   <a id=\"help-forums\" href=\"../../vista/preferencia/preferencia.php\" target=\"_parent\">Preferencias</a>
		                       \n
		                       <a id=\"help-forums1\" href=\"../../\" target=\"_parent\"target=\"_parent\">Eventos</a>\n
		                       <!--<a id=\"help-forums2\" href=\"../../\" target=\"_parent\"target=\"_parent\">Tareas Pendientes</a>\n-->
		                       <!-- salir -->\n
		                       <a id=\"log-out\" href=\"../../control/auten/cerrar.php\" target=\"_parent\">Salir</a>
		                       \n<!-- Fin Arbol -->\n
		                       
		                      	<script type='text/javascript'>
	                       		Ext.onReady(function(){
		                      	var classes = Ext.get('classes');
								classes.on('click', this.classClicked, null, {delegate: 'a', stopEvent:true});
								classes.select('h3').each(function(el){
								var c = new NavNode(el.dom);
								//comentar lo siguiente para hacer que todo el arbol se despliegue al inicio
								if(!/^\s*(?:ACTIF|ALMIN|SICOMP|KARD|SSS|PM|SAJ|SCI|Facturación y Ventas \(FACTUR\)|Gestión de Almacenes \(ALMIN\))\s*$/.test(el.dom.innerHTML)){
								c.collapse();
								}});
								});
		                       </script>";


	}
}
?>