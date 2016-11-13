/**
 * Nombre:		  	    pagina_epe_inv.js
 * Autor:				Generado Automaticamente
 * Fecha creacion:	2014.07
 */
function pagina_epe_inv(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var id_ep;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'importe',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:1,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0
	});
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/epe_inv/ActionListarEpeInv.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_epe_inv',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_epe_inv',
		'id_epe',
		'id_gestion',
		'gestion',
		'id_moneda',
		'nombre',
		'importe_inv'
		]),remoteSort:true});
	
	// DEFINICION DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Proyecto ',maestro.desc_epe],[' ID ',maestro.id_epe],
	                  ['Codigo ',maestro.codigo_epe,],
	                 ];
	
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=cobra_sis'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});

	//FUNCIONES RENDER
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['nombre']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderFormatNumber(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)
	}
	
	/////////////////////////
	// Definicion de datos //
	/////////////////////////
	
	// hidden id_epe_inv
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_epe_inv',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	// txt id_epe
	Atributos[1]={
		validacion:{
			name:'id_epe',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_epe
	};

	Atributos[2]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión Inicial',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GES.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			align:'center',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GES.gestion',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0
	};

	Atributos[4]={
		validacion:{
			name:'importe_inv',
			fieldLabel:'Importe',
			allowBlank:false,
			maxLength:150,
			minLength:1,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			width_grid:150,
			width:200,
			grid_visible:true,
			grid_editable:false,
			renderer: renderFormatNumber
		},
		tipo:'NumberField',
		form:true,
		filtro_1:false,
		id_grupo:0
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'EPE (Maestro)',titulo_detalle:'Inversión (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_epe_inv = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_epe_inv.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_epe_inv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	
	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	
	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/epe_inv/ActionEliminarEpeInv.php',parametros:'&id_epe='+maestro.id_epe},
	Save:{url:direccion+'../../../control/epe_inv/ActionGuardarEpeInv.php',parametros:'&id_epe='+maestro.id_epe},
	ConfirmSave:{url:direccion+'../../../control/epe_inv/ActionGuardarEpeInv.php',parametros:'&id_epe='+maestro.id_epe},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:380,minWidth:150,minHeight:200,	closable:true,titulo:'Inversión EP'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_epe:maestro.id_epe
			}
		};
		
		this.btnActualizar();
		
		data_maestro=[['Proyecto ',maestro.desc_epe],[' ID ',maestro.id_epe],
	                  ['Codigo ',maestro.codigo_epe,]];
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_epe;

		paramFunciones.btnEliminar.parametros='&id_epe='+maestro.id_epe;
		paramFunciones.Save.parametros='&id_epe='+maestro.id_epe;
		paramFunciones.ConfirmSave.parametros='&id_epe='+maestro.id_epe;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_epe_inv.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_epe:maestro.id_epe
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_epe_inv.getLayout().addListener('layout',this.onResize);
	layout_epe_inv.getVentana(idContenedor).on('resize',function(){layout_epe_inv.getLayout().layout()})
}