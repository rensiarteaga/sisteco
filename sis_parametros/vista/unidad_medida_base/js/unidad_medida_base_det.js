/**
* Nombre:		  	    pagina_unidad_medida_base_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamented
* Fecha creación:		2007-10-17 15:00:28
*/
function pagina_unidad_medida_base_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_unidad_medida_base,txt_estado_registro,txt_fecha_reg;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_unidad_medida_base',
			totalRecords:'TotalCount'
		},[
		'id_unidad_medida_base',
		'nombre',
		'abreviatura',
		'descripcion',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_unidad_medida',
		'id_tipo_unidad_medida'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_unidad_medida:maestro.id_tipo_unidad_medida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Tipo Unidad de Medida',maestro.id_tipo_unidad_medida],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	// Definición de datos //
	// hidden id_unidad_medida_base
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_unidad_medida_base',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_unidad_medida_base'
	};
	// txt nombre
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'85%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNMEDB.nombre',
		save_as:'txt_nombre'
	};
	// txt abreviatura
	vectorAtributos[2]={
		validacion:{
			name:'abreviatura',
			fieldLabel:'Abreviatura',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'85%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNMEDB.abreviatura',
		save_as:'txt_abreviatura'
	};
	// txt descripcion
	vectorAtributos[3]={
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
			width_grid:200,
			width:'85%'
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'UNMEDB.descripcion',
		save_as:'txt_descripcion'
	};
	// txt observaciones
	vectorAtributos[4]={
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
			width_grid:200,
			width:'85%'
		},
		tipo:'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'UNMEDB.observaciones',
		save_as:'txt_observaciones'
	};
	// txt estado_registro
	vectorAtributos[5]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
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
		filtro_1:false,
		filterColValue:'UNMEDB.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	// txt id_tipo_unidad_medida
	vectorAtributos[6]={
		validacion:{
			name:'id_tipo_unidad_medida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_unidad_medida,
		save_as:'txt_id_tipo_unidad_medida'
	};
	// txt fecha_reg
	vectorAtributos[7]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNMEDB.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Unidades de Medida (Maestro)',titulo_detalle:'Medida Base (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_unidad_medida_base=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_unidad_medida_base.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_unidad_medida_base,idContenedor);
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
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/unidad_medida_base/ActionEliminarUnidadMedidaBase.php',parametros:'&m_id_tipo_unidad_medida='+maestro.id_tipo_unidad_medida},
		Save:{url:direccion+'../../../control/unidad_medida_base/ActionGuardarUnidadMedidaBase.php',parametros:'&m_id_tipo_unidad_medida='+maestro.id_tipo_unidad_medida},
		ConfirmSave:{url:direccion+'../../../control/unidad_medida_base/ActionGuardarUnidadMedidaBase.php',parametros:'&m_id_tipo_unidad_medida='+maestro.id_tipo_unidad_medida},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Unidad de Medida Base'}
	};
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_tipo_unidad_medida:datos.m_id_tipo_unidad_medida
				}
			});
			gridMaestro.getDataSource().removeAll();
			gridMaestro.getDataSource().loadData([['Id Tipo Unidad de Medida',datos.m_id_tipo_unidad_medida],['Nombre',datos.m_nombre],['Descripcion',datos.m_descripcion]]);
			vectorAtributos[6].defecto=datos.m_id_tipo_unidad_medida;
		}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_estado_registro=ClaseMadre_getComponente('estado_registro')
	}
	function btn_unidad_medida_sec(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(txt_estado_registro.getValue()=='activo'){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_unidad_medida_base='+SelectionsRecord.data.id_unidad_medida_base;
				data=data+'&m_nombre='+SelectionsRecord.data.nombre;
				data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
				var ParamVentana={Ventana:{width:'68%',height:'60%'}};
				layout_unidad_medida_base.loadWindows(direccion+'../../unidad_medida_sec/unidad_medida_sec_det.php?'+data,'Medidas secundarias',ParamVentana);
				layout_unidad_medida_base.getVentana().on('resize',function(){layout_unidad_medida_base.getLayout().layout()})
			}
			else{
				Ext.MessageBox.alert('Estado','Para Insertar Unidad de Secundaria Base el estado del registro tiene que ser ACTIVO.')
			}
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	//Para manejo de eventos
	this.btnNew=function(){
		CM_ocultarComponente(txt_estado_registro);//Estado registro
		CM_ocultarComponente(txt_fecha_reg);//Fecha_registro
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_mostrarComponente(txt_estado_registro);//Estado registro
		CM_ocultarComponente(txt_fecha_reg);//Fecha_registro
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_unidad_medida_base.getLayout()
	};
	//para el manejo de hijos
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
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_unidad_medida_sec,true,'unidad_medida_sec','Unidad de Medida Secundarias');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_unidad_medida_base.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}