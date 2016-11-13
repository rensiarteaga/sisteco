/**
* Nombre:		  	    pagina_tipo_sector_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-10 18:26:18
*/
function pagina_tipo_sector(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_tipo_sector,h_txt_fecha_reg,h_txt_estado_registro;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_sector/ActionListarTipoSector.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_sector',totalRecords:'TotalCount'},
		['id_tipo_sector',
		'codigo',
		'descripcion',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_sector',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_sector'
	};
	vectorAtributos[1]={
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
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TIPSEC.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'85%'
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TIPSEC.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[3]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'85%'
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'TIPSEC.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[4]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado de Registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.tipo_sector_combo.estado_registro}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:110
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'TIPSEC.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	vectorAtributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer:formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'TIPSEC.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'tipo_sector',grid_maestro:'grid-'+idContenedor};
	layout_tipo_sector=new DocsLayoutMaestro(idContenedor);
	layout_tipo_sector.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_sector,idContenedor);
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
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_sector/ActionEliminarTipoSector.php'},
		Save:{url:direccion+'../../../control/tipo_sector/ActionGuardarTipoSector.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_sector/ActionGuardarTipoSector.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:280,minWidth:150,minHeight:200,closable:true,titulo:'Tipo de Sector'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		h_txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		h_txt_estado_registro=ClaseMadre_getComponente('estado_registro')
	}
	function btn_tipo_sector_sg(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tipo_sector='+SelectionsRecord.data.id_tipo_sector;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_tipo_sector.loadWindows(direccion+'../../tipo_sector_sg/tipo_sector_sg_det.php?'+data,'Super Grupos del Sector',ParamVentana);
			layout_tipo_sector.getVentana().on('resize',function(){layout_tipo_sector.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	function iniciarPaginaTipo_sector(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}
	this.btnNew=function(){
		CM_ocultarComponente(h_txt_fecha_reg);
		CM_ocultarComponente(h_txt_estado_registro);
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(h_txt_fecha_reg);
		CM_mostrarComponente(h_txt_estado_registro);
		ClaseMadre_btnEdit()
	};
	this.getLayout=function(){
		return layout_almacen_sector.getLayout()
	};
	this.getLayout=function(){
		return layout_tipo_sector.getLayout()
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
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Super Grupos por Sector',btn_tipo_sector_sg,true,'tipo_sector_sg','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_sector.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}