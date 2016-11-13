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
var elemento={pagina:new pagina_existencia_almacen(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_existencia_almacen_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:00:48
 */
function pagina_existencia_almacen(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var data_ep;
	
   
	ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen/ActionListarAlmacenEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'
		}, ['id_almacen','nombre','descripcion'])
		});

		ds_almacen_ep = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen_ep/ActionListarAlmacenepFisEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_ep',
			totalRecords: 'TotalCount'
		}, ['id_almacen_ep','nombre','descripcion','desc_tipo_almacen'])
		});

	
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_ep(value, p, record){return String.format('{0}', record.data['desc_almacen_ep']);}
		
	// Definición de datos //
	/////////////////////////
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria
	
	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	
	
	var param_id_almacen= {
			validacion: {
				name:'id_almacen',
				fieldLabel:'Almacén Físico',
				allowBlank:true,
				emptyText:'Almacén Físico...',
				name: 'id_almacen',     //indica la columna del store principal ds del que proviane el id
				desc: 'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_almacen,
				valueField: 'id_almacen',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'ALMACE.nombre#ALMACE.descripcion',
				filterCols:filterCols_almacen,
				filterValues:filterValues_almacen,
				typeAhead:true,
				forceSelection:false,
				//tpl: resultTplAlmacen,
				mode:'remote',
				queryDelay:150,
				pageSize:100,
				minListWidth:200,
				grow:true,
				width:200,//'100%',
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_almacen,
				grid_visible:false,
				grid_editable:false,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'ALMACE.nombre',
			defecto: '',
			save_as:'txt_id_almacen',
			id_grupo:0
			
		};
		vectorAtributos[0] = param_id_almacen;

		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Existencia de Almacenes'
		
	};
	layout_existencia_almacen=new DocsLayoutProceso(idContenedor);
	layout_existencia_almacen.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_existencia_almacen,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
    var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Existencias de Almacen";
		
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../../control/_reportes/existencia_almacen/ActionReporteExistenciaAlmacen.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:false,
		width:'70%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Almacen',
		grupos:[
		{	tituloGrupo:'Almacén',
			columna:0,
			id_grupo:0
		}
		
		
		]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		combo_almacen = ClaseMadre_getComponente('id_almacen');
		
		
	}
	
    this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				//this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
