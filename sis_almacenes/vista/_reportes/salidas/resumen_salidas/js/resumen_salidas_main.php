//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new pagina_resumen_salidas(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_ingresos_fisico_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:00:48
 */
function pagina_resumen_salidas(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var ds_almacen,layout_resumen_salidas;		
	ds_almacen=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen/ActionListarAlmacenEP.php?origen=filtro'}),
		reader:new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'
		}, ['id_almacen','nombre','descripcion'])
		});
	//FUNCIONES RENDER
	var resultTplAlmacen=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria
	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	vectorAtributos[0]={
			validacion: {
				name:'id_almacen',
				fieldLabel:'Almacén Físico',
				allowBlank:true,
				emptyText:'Almacén Físico...',
				desc:'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_almacen,
				valueField:'id_almacen',
				displayField:'nombre',
				filterCol:'ALMACE.nombre#ALMACE.descripcion',
				filterCols:filterCols_almacen,
				filterValues:filterValues_almacen,
				typeAhead:true,
				forceSelection:false,
				tpl:resultTplAlmacen,
				mode:'remote',
				queryDelay:150,
				pageSize:100,
				minListWidth:200,
				grow:true,
				width:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_almacen,
				grid_visible:false,
				grid_editable:false,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:false,
			filterColValue:'ALMACE.nombre',
			defecto:'',
			save_as:'txt_id_almacen',
			id_grupo:0
			};
		vectorAtributos[1]={
			validacion:{
				name:'fecha_inicio',
				fieldLabel:'Desde',
				allowBlank:false,
				format:'d/m/Y',
				minValue:'01/01/1900',
				renderer:formatDate,
				disabled:false
			},
			tipo:'DateField',
			dateFormat:'m/d/Y',
			defecto:'',
			save_as:'txt_fecha_inicio',
			id_grupo:1
		};
		vectorAtributos[2]={
			validacion:{
				name:'fecha_fin',
				fieldLabel:'Hasta',
				allowBlank:false,
				format:'d/m/Y',
				minValue:'01/01/1900',
				renderer:formatDate,
				disabled:false
			},
			tipo:'DateField',
			dateFormat:'m/d/Y',
			defecto:'',
			save_as:'txt_fecha_fin',
			id_grupo:1
		};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Salida de Material'};
	layout_resumen_salidas=new DocsLayoutProceso(idContenedor);
	layout_resumen_salidas.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,vectorAtributos,layout_resumen_salidas,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
    var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	function obtenerTitulo(){
		var titulo="Salida de Material";
		return titulo
	}
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'70%',url:direccion+'../../../../../control/_reportes/resumen_salidas/ActionRptResumenSalidas.php',abrir_pestana:true,titulo_pestana:obtenerTitulo,fileUpload:false,
		            width:'70%',columnas:['50%'],minWidth:150,minHeight:200,closable:true,titulo:'Almacén',grupos:[{tituloGrupo:'Almacén',columna:0,id_grupo:0},{tituloGrupo:'Rango de fechas',columna:0,id_grupo:1}]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
    this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}
