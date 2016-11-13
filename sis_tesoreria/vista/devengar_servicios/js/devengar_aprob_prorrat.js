/**
* Nombre:		  	    pagina_devengar_servicios.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:59:44
*/
function pagina_devengar_aprob_prorrat(idContenedor,direccion,paramConfig,tipoFormDev){
	var Atributos=new Array,sw=0;
	var v_importe_devengado;

	//tipoFormDev-> dev, pag, detpag, fin

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado/ActionListarAprobProrrateo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_devengado_detalle',totalRecords:'TotalCount'
		},[
		'id_devengado',
		'id_devengado_detalle',
		'desc_concepto_ingas',
		'desc_proveedor',
		'desc_moneda',
		'importe_devengado',
		'porcentaje_devengado',
		'fecha_devengado',
		'observaciones',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'desc_unidad_organizacional',
		'aprobado',
		'responsable_aprob',
		'partida'
		]),remoteSort:true
	});


	//DATA STORE COMBOS

	//FUNCIONES RENDER

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado
	//en la posición 0 siempre esta la llave primaria


	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado'
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'id_devengado_detalle',
			name: 'id_devengado_detalle',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado_detalle'
	};

	Atributos[2]={
		validacion:{
			fieldLabel:'Concepto Gasto',
			name: 'desc_concepto_ingas',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:4
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'desc_concepto_ingas'
	};

	Atributos[3]={
		validacion:{
			fieldLabel:'Proveedor',
			name: 'desc_proveedor',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:5
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'desc_proveedor'
	};

	Atributos[4]={
		validacion:{
			fieldLabel:'Importe',
			name: 'importe_devengado',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			grid_indice:7
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'importe_devengado'
	};
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Porcentaje %',
			name: 'porcentaje_devengado',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			width_grid:80,
			grid_indice:6
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'porcentaje_devengado'
	};

	Atributos[6]={
		validacion:{
			fieldLabel:'Moneda',
			name: 'desc_moneda',
			grid_visible:true,
			grid_editable:false,
			grid_indice:8
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'desc_moneda'
	};

	Atributos[7]={
		validacion:{
			fieldLabel:'Fecha',
			name: 'fecha_devengado',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			grid_indice:2
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'fecha_devengado'
	};

	Atributos[8]={
		validacion:{
			fieldLabel:'Observaciones',
			name: 'observaciones',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			grid_indice:9
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'observaciones'
	};

	Atributos[9]={
		validacion:{
			fieldLabel:'Financiador',
			name: 'nombre_financiador',
			grid_visible:true,
			grid_editable:false,
			grid_indice:12
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'nombre_financiador'
	};

	Atributos[10]={
		validacion:{
			fieldLabel:'Regional',
			name: 'nombre_regional',
			grid_visible:true,
			grid_editable:false,
			grid_indice:13
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'nombre_regional'
	};

	Atributos[11]={
		validacion:{
			fieldLabel:'Programa',
			name: 'nombre_programa',
			grid_visible:true,
			grid_editable:false,
			grid_indice:14
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'nombre_programa'
	};

	Atributos[12]={
		validacion:{
			fieldLabel:'Proyecto',
			name: 'nombre_proyecto',
			grid_visible:true,
			grid_editable:false,
			grid_indice:15
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'nombre_proyecto'
	};

	Atributos[13]={
		validacion:{
			fieldLabel:'Actividad',
			name: 'nombre_actividad',
			grid_visible:true,
			grid_editable:false,
			grid_indice:16
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'nombre_actividad'
	};

	Atributos[14]={
		validacion:{
			fieldLabel:'Unidad_organizacional',
			name: 'desc_unidad_organizacional',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:11
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'desc_unidad_organizacional'
	};

	Atributos[15]={
		validacion:{
			name:'aprobado',
			fieldLabel:'Aprobado',
			checked:false,
			renderer:formatValida,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			grid_indice:1
		},
		tipo:'Checkbox',
		form:false,
		save_as:'aprobado'
	};

	Atributos[16]={
		validacion:{
			fieldLabel:'Responsable',
			name: 'responsable_aprob',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:3
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'responsable_aprob'
	};
	
	Atributos[17]={
		validacion:{
			fieldLabel:'Partida',
			name: 'partida',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:10
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'partida'
	};



	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatValida(value){
		if (value==1) return 'Si';
		else return 'No'
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Aprobar Prorrateo',grid_maestro:'grid-'+idContenedor};
	var layout_devengar_servicios=new DocsLayoutMaestro(idContenedor);
	layout_devengar_servicios.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_devengar_servicios,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnEdit=this.btnEdit;
	var CM_btnActualizar = this.btnActualizar;
	var CM_conexionFailure = this.conexionFailure

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false},
		guardar:{crear:true,separador:false}
	};



	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		ConfirmSave:{url:direccion+'../../../control/devengado_detalle/ActionAprobarDevengadoDetalle.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:270,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Aprobar Prorrateo'}
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//Captura los elementos del formulario
		//v_importe_devengado=getComponente("importe_devengado")

		//Define formato inicial
		//v_importe_devengado.getEl().setStyle("text-align","right")
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengar_servicios.getLayout()};
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

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_devengar_servicios.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}