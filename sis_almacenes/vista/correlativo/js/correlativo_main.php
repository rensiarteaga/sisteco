<?php 
/**
 * Nombre:		  	    correlativo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-16 08:51:58
 *
 */
session_start();
?>
//<script>

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
var elemento={pagina:new pagina_correlativo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_correlativo_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-16 08:51:58
*/
function pagina_correlativo(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/correlativo/ActionListarCorrelativo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_correlativo',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_correlativo',
		'codigo',
		'prefijo',
		'sufijo',
		'valor_actual',
		'valor_siguiente',
		'incremento',
		'desc_parametro_almacen',
		'id_parametro_almacen'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
	ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_almacen/ActionListarParametroAlmacen.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_parametro_almacen',
		totalRecords: 'TotalCount'
	}, ['id_parametro_almacen','dias_reserva','cierre','gestion','bloqueado','actualizar','observaciones','id_cuenta'])
	});
	//FUNCIONES RENDER
	function render_id_parametro_almacen(value, p, record){return String.format('{0}', record.data['desc_parametro_almacen']);}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_correlativo
	//en la posición 0 siempre esta la llave primaria
	var param_id_correlativo = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_correlativo',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_correlativo'
	};
	vectorAtributos[0] = param_id_correlativo;
	// txt codigo
	var param_codigo= {
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[1] = param_codigo;
	// txt prefijo
	var param_prefijo= {
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.prefijo',
		save_as:'txt_prefijo'
	};
	vectorAtributos[2] = param_prefijo;
	// txt sufijo
	var param_sufijo= {
		validacion:{
			name:'sufijo',
			fieldLabel:'Sufijo',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.sufijo',
		save_as:'txt_sufijo'
	};
	vectorAtributos[3] = param_sufijo;
	// txt valor_actual
	var param_valor_actual= {
		validacion:{
			name:'valor_actual',
			fieldLabel:'Valor Actual',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.valor_actual',
		save_as:'txt_valor_actual'
	};
	vectorAtributos[4] = param_valor_actual;
	// txt valor_siguiente
	var param_valor_siguiente= {
		validacion:{
			name:'valor_siguiente',
			fieldLabel:'Siguiente Valor',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.valor_siguiente',
		save_as:'txt_valor_siguiente'
	};
	vectorAtributos[6] = param_valor_siguiente;
	// txt incremento
	var param_incremento= {
		validacion:{
			name:'incremento',
			fieldLabel:'Incremento',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CORREL.incremento',
		save_as:'txt_incremento'
	};
	vectorAtributos[5] = param_incremento;
	// txt id_parametro_almacen
	var param_id_parametro_almacen= {
		validacion: {
			name:'id_parametro_almacen',
			fieldLabel:'Parametros de Almacen',
			allowBlank:false,
			emptyText:'Parametros de Almacen...',
			name: 'id_parametro_almacen',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_parametro_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro_almacen,
			valueField: 'id_parametro_almacen',
			displayField: 'dias_reserva',
			queryParam: 'filterValue_0',
			filterCol:'PARALM.dias_reserva#PARALM.cierre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PARALM.dias_reserva',
		defecto: '',
		save_as:'txt_id_parametro_almacen'
	};
	vectorAtributos[7] = param_id_parametro_almacen;
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
	var config = {
		titulo_maestro:'Correlativo',
		grid_maestro:'grid-'+idContenedor
	};
	layout_correlativo=new DocsLayoutMaestro(idContenedor);
	layout_correlativo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_correlativo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones = {
		//btnEliminar:{url:direccion+'../../../control/correlativo/ActionEliminarCorrelativo.php'},
		Save:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php'},
		ConfirmSave:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,
		minWidth:150,minHeight:200,	closable:true,titulo:'Correlativo'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{	h_txt_valor_actual = ClaseMadre_getComponente('valor_actual');
	h_txt_incremento = ClaseMadre_getComponente('incremento');
	h_txt_valor_siguiente = ClaseMadre_getComponente('valor_siguiente');

	function cargar_valor_sig()
	{	h_txt_valor_siguiente.setValue(h_txt_valor_actual.getValue()+h_txt_incremento.getValue());
	}
	h_txt_incremento.on('change',cargar_valor_sig);
	h_txt_valor_actual.on('change',cargar_valor_sig);
	}
	//Para manejo de
	//par que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_correlativo.getLayout();
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_correlativo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}