<?php
/**
 * Nombre:		  	    componente_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Anacleto Rojas
 * Fecha creación:		2007-11-07 
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
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:fa
};
var maestro={
	     	id_tipo_unidad_constructiva:'<?php echo $maestro_id_tipo_unidad_constructiva;?>',
	     	codigo:'<?php echo $maestro_codigo;?>',
	     	nombre:'<?php echo $maestro_nombre;?>'
};
var elemento={idContenedor:idContenedor,pagina:new pagina_componente_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
 
/**
 * Nombre:		  	    pagina_componente_det.js
 * Propósito: 			pagina objeto principal
 * Autor:			    Anacleto Rojas
 * Fecha creación:		2007-11-07 16:22:55
 */
function pagina_componente_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/componente/ActionListarComponente_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_componente',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_componente',
		'cantidad',
		'estado_registro',
		'cosiderar_repeticion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'id_item',
		'desc_item',
		'codigo_item',
		'desc_tipo_unidad_constructiva',
		'id_tipo_unidad_constructiva'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_tipo_unidad_constructiva:maestro.id_tipo_unidad_constructiva
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
		
	var cmMaestro = new Ext.grid.ColumnModel([
	{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
	{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}
	]);
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';
	}
	function italic(value){
		return '<i>'+value+'</i>';
	}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
				fields: ['atributo','valor'],
				data :[['ID',maestro.id_tipo_unidad_constructiva],
						['Codigo',maestro.codigo],
						['Nombre',maestro.nombre]]
			}),
		cm:cmMaestro
	});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item',
			totalRecords: 'TotalCount'
		}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
	});

    ds_tipo_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_tipo_unidad_constructiva','codigo','nombre','tipo','descripcion','observaciones','fecha_reg'])
	});
	//FUNCIONES RENDER
			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
			function render_id_tipo_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_tipo_unidad_constructiva']);};
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_componente',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_componente'
	};
	/////////// txt codigo_item //////
	vectorAtributos[1] = {
		validacion: {
			name: 'codigo_item',
			fieldLabel: 'Codigo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			disabled: true,
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		save_as:'txt_codigo_item'

	};
		fC= new Array();
		fV= new Array();
		fC[0]='id_almacen_logico';
		fV[0]=maestro.id_almacen_logico;
	
		// txt id_item
	vectorAtributos[2]= {
			validacion: {
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Código Material',
			valueField: 'id_item',
			displayField: 'codigo',
			tipo:'ingreso',
			filterCols:fC,
			filterValues:fV,
			allowBlank:false,
			maxLength:100,
			renderer:render_id_item,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
			
		},
		tipo:'LovItemsAlm',
		save_as:'txt_id_item',
		filtro_0:true,
		filterColValue:'ITEM.nombre',
	};
	// txt cantidad
	vectorAtributos[3]= {
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :0,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:70
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMP.cantidad',
		save_as:'txt_cantidad'
	};
	// txt id_tipo_unidad_constructiva
	vectorAtributos[4]= {
			validacion: {
			name:'id_tipo_unidad_constructiva',
			fieldLabel:'Tipo de Unidad Constructiva',
			allowBlank:false,			
			emptyText:'Tipo de UC...',
			desc: 'desc_tipo_unidad_constructiva',
			store:ds_tipo_unidad_constructiva,
			valueField: 'id_tipo_unidad_constructiva',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPOUC.codigo#TIPOUC.nombre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_unidad_constructiva,
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			disabled:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.nombre',
		defecto: maestro.id_tipo_unidad_constructiva,
		save_as:'txt_id_tipo_unidad_constructiva'
	};
	// txt descripcion
	vectorAtributos[5]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMP.descripcion',
		save_as:'txt_descripcion'
	};
	// txt estado_registro
	vectorAtributos[6] = {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			align:'center',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.componente_combo.estado_registro}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['activo','activo'],
			                                                    			['inactivo','inactivo'],
			                                                    			['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMP.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	// txt cosiderar_repeticion
	vectorAtributos[7]={
			validacion: {
			name:'cosiderar_repeticion',
			fieldLabel:'Considerar Repetición',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			align:'center',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.componente_combo.cosiderar_repeticion}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['si','si'],
			                                                    			['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:130 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMP.cosiderar_repeticion',
		defecto:'si',
		save_as:'txt_cosiderar_repeticion'
	};
	// txt fecha_reg
	vectorAtributos[8]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y',
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:100,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMP.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:' (Maestro)',
		titulo_detalle:'Componente (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_componente = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_componente.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_componente,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
		
	btnEliminar:{url:direccion+'../../../control/componente/ActionEliminarComponente.php'},
	Save:{url:direccion+'../../../control/componente/ActionGuardarComponente.php'},
	ConfirmSave:{url:direccion+'../../../control/componente/ActionGuardarComponente.php'},
	Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:340,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'Componente'}
	};
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_unidad_constructiva=datos.maestro_id_tipo_unidad_constructiva;
		maestro.codigo=datos.maestro_codigo;
		maestro.nombre= datos.maestro_nombre;		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_tipo_unidad_constructiva:maestro.id_tipo_unidad_constructiva }
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Tipo Unidad',maestro.id_tipo_unidad_constructiva],['Codigo',maestro.codigo],['Nombre',maestro.nombre]]);
		vectorAtributos[4].defecto=maestro.id_tipo_unidad_constructiva;
		var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/componente/ActionEliminarComponente.php'},
		Save:{url:direccion+'../../../control/componente/ActionGuardarComponente.php'},
		ConfirmSave:{url:direccion+'../../../control/componente/ActionGuardarComponente.php'},
		Formulario:{
				html_apply:'dlgInfo-'+idContenedor,
				height:340,
				width:480,
				minWidth:150,
				minHeight:200,
				closable:true,
				titulo: 'Componente'}
		};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.btnNew = function()
		{	dialog.resizeTo(450,380);
		
			CM_ocultarTodosComponente();
			//CM_mostrarComponente(componentes[1]);
			CM_mostrarComponente(componentes[2]);
			CM_mostrarComponente(componentes[3]);
			//CM_mostrarComponente(componentes[4]);
			CM_mostrarComponente(componentes[5]);
			CM_mostrarComponente(componentes[6]);
			CM_mostrarComponente(componentes[7]);
			CM_mostrarComponente(componentes[8]);
			
			ClaseMadre_btnNew();
			get_fecha_bd();
			//get_hora_bd();
		};
		function get_fecha_bd()
		{
			Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
				method:'GET',
				success:cargar_fecha_bd,
				failure:ClaseMadre_conexionFailure,
				timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
		function cargar_fecha_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(componentes[8].getValue()=="")
				{

					componentes[8].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				}
				//   	componentes[14].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	//para iniciar eventos en el formulario
		
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_componente.getLayout();
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
	
	function iniciaPaginaComponente()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciaPaginaComponente();
	iniciarEventosFormularios();
	layout_componente.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}