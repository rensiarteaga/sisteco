/**
* Nombre:		  	    pagina_tipo_unidad_medida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-17 15:00:19
*/
function pagina_tipo_unidad_medida(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_tipo_unidad_medida,txt_fecha_reg;
	var elementos=new Array();
	var sw=0;
	var txt_fecha_reg;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_unidad_medida/ActionListarTipoUnidadMedida.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_unidad_medida',
			totalRecords:'TotalCount'
		},[
		'id_tipo_unidad_medida',
		'nombre',
		'descripcion',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros	}
	});
	// hidden id_tipo_unidad_medida
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_unidad_medida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_unidad_medida'
	};
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre de la magnitud',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'85%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMED.nombre',
		save_as:'txt_nombre'
	};
	// txt descripcion
	vectorAtributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:'85%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMED.descripcion',
		save_as:'txt_descripcion'
	};
	// txt observaciones
	vectorAtributos[3]={
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
			width_grid:250,
			width:'85%'
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMED.observaciones',
		save_as:'txt_observaciones'
	};
 // txt fecha_reg
	vectorAtributos[4]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMED.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------
	var config={titulo_maestro:'tipo_unidad_medida',grid_maestro:'grid-'+idContenedor};
	layout_tipo_unidad_medida=new DocsLayoutMaestro(idContenedor);
	layout_tipo_unidad_medida.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_unidad_medida,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/tipo_unidad_medida/ActionEliminarTipoUnidadMedida.php'},
		Save:{url:direccion+'../../../control/tipo_unidad_medida/ActionGuardarTipoUnidadMedida.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_unidad_medida/ActionGuardarTipoUnidadMedida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:450,minWidth:150,minHeight:200,closable:true,titulo:'Tipo de Unidad Medida'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_unidad_medida_base(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tipo_unidad_medida='+SelectionsRecord.data.id_tipo_unidad_medida;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_estado_registro='+SelectionsRecord.data.estado_registro;
			var ParamVentana={Ventana:{width:'68%',height:'60%'}}
			layout_tipo_unidad_medida.loadWindows(direccion+'../../unidad_medida_base/unidad_medida_base_det.php?'+data,'Medida Base',ParamVentana);
			layout_tipo_unidad_medida.getVentana().on('resize',function(){layout_tipo_unidad_medida.getLayout().layout()})
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg')
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_unidad_medida.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Unidad de Medida Base',btn_unidad_medida_base,true,'unidad_medida_base','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_unidad_medida.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}