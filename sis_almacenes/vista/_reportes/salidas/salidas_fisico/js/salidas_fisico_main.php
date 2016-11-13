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
var elemento={pagina:new pagina_salidas_fisico(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_salidas_fisico_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:00:48
 */
function pagina_salidas_fisico(idContenedor,direccion,paramConfig)
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

	
	//FUNCIONES RENDER
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
		var param_fecha_apertura= {
			validacion:{
				name:'fecha_apertura',
				fieldLabel:'Fecha de Apertura',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			//dateFormat:'m-d-Y',
			dateFormat:'m/d/Y',
			defecto:'',
			save_as:'txt_fecha_apertura',
			id_grupo:1
		};
		vectorAtributos[1] = param_fecha_apertura;
	var param_fecha_cierre= {
			validacion:{
				name:'fecha_cierre',
				fieldLabel:'Fecha de Cierre',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			dateFormat:'m/d/Y',
			defecto:'',
			save_as:'txt_fecha_cierre',
			id_grupo:1
		};
		vectorAtributos[2] = param_fecha_cierre;	


		
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
		titulo_maestro:'salidas de Almacenes'
		
	};
	layout_salidas_fisico=new DocsLayoutProceso(idContenedor);
	layout_salidas_fisico.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_salidas_fisico,idContenedor);
	
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
		var titulo = "salidass de Almacen";
		
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../../control/_reportes/salidas_fisico/ActionReporteSalidasFisico.php',
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
		},
		{	tituloGrupo:'Fecha de Cierre y Apertura',
			columna:0,
			id_grupo:1
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
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
