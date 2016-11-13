/**
 * Nombre:		  	    pagina_arqueo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-23 15:28:03
 */
function pagina_arqueo(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_arqueo/ActionListarArqueo.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_arqueo',totalRecords:'TotalCount'
		},[		
				'id_caja_arqueo',
		'id_caja',
		'nombre_unidad_unidad_organizacional',
		'desc_caja',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'estado_cajero_cajero',
		'desc_cajero',
		{name: 'fecha_arqueo',type:'date',dateFormat:'Y-m-d'},
		'sw_resultado',
		'obs_arqueo',
		'tipo_caja'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
 var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php?tipo=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});

	//FUNCIONES RENDER
	
		function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');

	function renderTipo(value, p, record){
		if(value == 1){return "Caja"}
		if(value == 2){return "Caja Chica"}
		if(value == 3){return "Fondo Rotatorio"}
		
	}	
	
	function renderResultado(value, p, record){
		if(value == 1){return "Sin Diferencia"}
		if(value == 2){return "Con diferencia"}
				
	}	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_arqueo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_arqueo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_arqueo'
	};
// txt id_caja
	Atributos[1]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG_1.nombre_unidad',
		save_as:'id_caja'
	};
// txt id_cajero
	Atributos[2]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			emptyText:'Cajero...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:true,
			tpl:tpl_id_cajero,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_2.apellido_paterno#PERSON_2.apellido_materno#PERSON_2.nombre',
		save_as:'id_cajero'
	};
// txt fecha_arqueo
	Atributos[3]= {
		validacion:{
			name:'fecha_arqueo',
			fieldLabel:'Fecha Arqueo',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:4		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJARQ.fecha_arqueo',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_arqueo'
	};
// txt sw_resultado
	Atributos[4]={
		validacion:{
			name:'sw_resultado',
			fieldLabel:'Resultado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Sin Diferencia'],['2','Con Diferencia']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			minListWidth:'100%',
			disable:false,
			grid_indice:5,
			renderer:renderResultado		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:'1',
		save_as:'sw_resultado'
	};
// txt obs_arqueo
	Atributos[5]={
		validacion:{
			name:'obs_arqueo',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false,
			grid_indice:6		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJARQ.obs_arqueo',
		save_as:'obs_arqueo'
	};
// txt tipo_caja
	Atributos[6]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo Caja',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:1,
			renderer:renderTipo		
		},
		tipo: 'TextField',
		form: false,
		save_as:'tipo_caja'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'arqueo',grid_maestro:'grid-'+idContenedor};
	var layout_arqueo=new DocsLayoutMaestro(idContenedor);
	layout_arqueo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_arqueo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_arqueo/ActionEliminarArqueo.php'},
		Save:{url:direccion+'../../../control/caja_arqueo/ActionGuardarArqueo.php'},
		ConfirmSave:{url:direccion+'../../../control/caja_arqueo/ActionGuardarArqueo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'arqueo'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_detalle_cortes(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_caja_arqueo='+SelectionsRecord.data.id_caja_arqueo;
			data=data+'&m_desc_caja='+SelectionsRecord.data.desc_caja;
			data=data+'&m_desc_cajero='+SelectionsRecord.data.desc_cajero;
			data=data+'&m_fecha_arqueo='+SelectionsRecord.data.fecha_arqueo;
			data=data+'&m_sw_resultado='+SelectionsRecord.data.sw_resultado;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_arqueo.loadWindows(direccion+'../../../../sis_tesoreria/vista/detalle_cortes/detalle_cortes.php?'+data,'Detalle de Cortes',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_arqueo.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Detalle de Cortes',btn_detalle_cortes,true,'detalle_cortes','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_arqueo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}