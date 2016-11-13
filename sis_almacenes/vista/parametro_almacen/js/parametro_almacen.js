/**
* Nombre:		  	    pagina_parametro_almacen_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 15:38:46
*/
function pagina_parametro_almacen(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_parametro_almacen;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro_almacen/ActionListarParametroAlmacen.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_almacen',totalRecords:'TotalCount'},
		['id_parametro_almacen',
		'dias_reserva',
		'cierre',
		'gestion',
		'bloqueado',
		'actualizar',
		'observaciones',
		'desc_cuenta',
		'id_cuenta',
		'demasia_porc'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
	ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','moneda','debe_bs','haber_bs','debe_us','haber_us','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	//FUNCIONES RENDER
	function render_id_cuenta(value,p,record){return String.format('{0}',record.data['desc_cuenta'])}
	var resultTplCuenta=new Ext.Template('<div class="search-item">','<b>{nombre_cuenta}</b>','<br><FONT COLOR="#B5A642">{nro_cuenta}</FONT>','</div>');
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_parametro_almacen',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_parametro_almacen'
	};
	vectorAtributos[1]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:1990,
			maxValue:2050,
			minText:'La fecha debe ser mayor a 1990',
			maxText:'La fecha debe ser menor a 2050',
			nanText:'Fecha no válida',
			minLengthText:'La fecha debe estar en formato yyyy',
			maxLengthText:'La fecha debe estar en formato yyyy',
			vtype:"texto",
			width:65,
			typeAhead:false,
			mode:'local',
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['v1'],data:Ext.parametro_almacen_combo.gestion}),
			store: new Ext.data.SimpleStore({fields: ['v1','v2'],data : 
				[
				 ['2000', '2000'],
			        ['2001', '2001'], 
			        ['2002', '2002'],
			        ['2003', '2003'],  
			        ['2004', '2004'], 
			        ['2005', '2005'],
			        ['2006', '2006'],
			        ['2007', '2007'],
			        ['2008', '2008'],
			        ['2009', '2009'],                                 
					['2010', '2010'],
			        ['2011', '2011'],
			        ['2012', '2012'],
			        ['2013', '2013'],
			        ['2014', '2014'],
			        ['2015', '2015'],
			        ['2016', '2016'],
			        ['2017', '2017'],
			        ['2018', '2018'],
			        ['2019', '2019'],
			        ['2020', '2020'],
			        ['2021', '2021'],
					['2022', '2022'],
					['2023', '2023'],
					['2024', '2024'],
					['2025', '2025']
				 ]}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			grid_visible:true,
			width_grid:60,
			forceSelection:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto:"1990",
		filterColValue:'PARALM.gestion',
		save_as:'txt_gestion'
	};
	vectorAtributos[2]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,
			emptyText:'Cuenta...',
			desc:'desc_cuenta',
			store:ds_cuenta,
			valueField:'id_cuenta',
			displayField:'nombre_cuenta',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplCuenta,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:true,
			width_grid:180
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
		defecto:'',
		save_as:'txt_id_cuenta'
	};
	vectorAtributos[3]={
		validacion:{
			name:'dias_reserva',
			fieldLabel:'Dias Maximo de Reservas',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'PARALM.dias_reserva',
		save_as:'txt_dias_reserva'
	};
	vectorAtributos[4]={
		validacion:{
			name:'bloqueado',
			fieldLabel:'Almacenes Bloqueados',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.parametro_almacen_combo.bloqueado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:135
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PARALM.bloqueado',
		defecto:'no',
		save_as:'txt_bloqueado'
	};
	vectorAtributos[5]={
		validacion:{
			name:'cierre',
			fieldLabel:'Gestión Cerrada',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.parametro_almacen_combo.cierre}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto:"no",
		filterColValue:'PARALM.cierre',
		save_as:'txt_cierre'
	};
	vectorAtributos[6]={
		validacion:{
			name:'actualizar',
			fieldLabel:'Actualización Valores',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.parametro_almacen_combo.actualizar}),
			store:new Ext.data.SimpleStore({fields: ['ID','valor'],data :[['si','Si'],['no','No']]}),
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
		filterColValue:'PARALM.actualizar',
		defecto:'si',
		save_as:'txt_actualizar'
	};
	vectorAtributos[7]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			forceSelection:false,
			width_grid:150
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'PARALM.observaciones',
		save_as:'txt_observaciones'
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'demasia_porc',
			fieldLabel:'% Demasía',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			forceSelection:false,
			width_grid:150
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'PARALM.demasia_porc',
		save_as:'txt_demasia_porc'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Parametros de Gestión',grid_maestro:'grid-'+idContenedor};
	layout_parametro_almacen=new DocsLayoutMaestro(idContenedor);
	layout_parametro_almacen.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_parametro_almacen,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro_almacen/ActionEliminarParametroAlmacen.php'},
		Save:{url:direccion+'../../../control/parametro_almacen/ActionGuardarParametroAlmacen.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro_almacen/ActionGuardarParametroAlmacen.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:380,width:500,minWidth:150,minHeight:200,	closable:true,titulo:'Parametros de Gestión'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_correlativo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro_almacen='+SelectionsRecord.data.id_parametro_almacen;
			data=data+'&m_dias_reserva='+SelectionsRecord.data.dias_reserva;
			data=data+'&m_cierre='+SelectionsRecord.data.cierre;
			var ParamVentana={Ventana:{width:'70%',height:'75%'}}
			layout_parametro_almacen.loadWindows(direccion+'../../correlativo/correlativo_det.php?'+data,'Correlativos',ParamVentana);
			layout_parametro_almacen.getVentana().on('resize',function(){layout_parametro_almacen.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')}
	}
	this.getLayout=function(){
		return layout_parametro_almacen.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Correlativos',btn_correlativo,true,'correlativo','');
	this.iniciaFormulario();
	layout_parametro_almacen.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}