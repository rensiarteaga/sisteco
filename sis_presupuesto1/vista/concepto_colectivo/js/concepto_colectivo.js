/**
 * Nombre:		  	    pagina_concepto_colectivo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-15 16:55:37
 */
function pagina_concepto_colectivo(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'
		},[		
				'id_concepto_colectivo',
		'estado_colectivo',
		'id_usuario',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'desc_usuario',
		'desc_colectivo'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuarioEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','desc_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion','cargo'])
	});

	//FUNCIONES RENDER
	
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Cargo: </b>{cargo}</FONT>','</div>');
	
	function renderEstado(value, p, record){
		if(value == 1)
		{return  "Activo"}
		if(value == 2)
		{return "Inactivo"}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_concepto_colectivo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_colectivo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_colectivo'
	};
	Atributos[1]={
		validacion:{
			name:'id_usuario',
			fieldLabel:'Responsable',
			allowBlank:false,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_2.apellido_paterno#PERSON_2.apellido_materno#PERSON_2.nombre',
		save_as:'id_usuario'
	};
// txt desc_colectivo
	Atributos[2]={
		validacion:{
			name:'desc_colectivo',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CONCOL.desc_colectivo',
		save_as:'desc_colectivo'
	};
// txt estado_colectivo
	Atributos[3]={
		validacion:{
			name:'estado_colectivo',
			fieldLabel:'Estado',
			vtype:'texto',
			emptyText:'Estado...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.estadoPresupuestoColectivo.estado // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderEstado,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150
		},
		tipo:'ComboBox',
		filtro_0:false,
		defecto: '1',
		form: true,
		save_as:'estado_colectivo',
		id_grupo: 0
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Conceptos de Presupuesto Colectivo',grid_maestro:'grid-'+idContenedor};
	var layout_concepto_colectivo=new DocsLayoutMaestro(idContenedor);
	layout_concepto_colectivo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_concepto_colectivo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	function btn_detalle_partida(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
			data='m_id_concepto_colectivo='+SelectionsRecord.data.id_concepto_colectivo;
		 	data+='&m_estado_colectivo='+renderEstado(SelectionsRecord.data.estado_colectivo);
			data+='&m_id_usuario='+SelectionsRecord.data.id_usuario;
		 	data+='&m_desc_usuario='+SelectionsRecord.data.desc_usuario;
		 	data+='&m_desc_colectivo='+SelectionsRecord.data.desc_colectivo;
		 	var ParamVentana={Ventana:{width:'50%',height:'70%'}}
			layout_concepto_colectivo.loadWindows(direccion+'../../../../sis_presupuesto/vista/partida/partida.php?'+data,'Detalle de Partidas Colectivas',ParamVentana);
			sm.clearSelections()
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/concepto_colectivo/ActionEliminarPresupuestoColectivo.php'},
		Save:{url:direccion+'../../../control/concepto_colectivo/ActionGuardarPresupuestoColectivo.php'},
		ConfirmSave:{url:direccion+'../../../control/concepto_colectivo/ActionGuardarPresupuestoColectivo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Conceptos de Presupuesto Colectivo'}};
	
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_concepto_colectivo.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Detalle de Partidas Colectivas',btn_detalle_partida,true,'detalle_partida_colectiva','Detalle de Partidas Colectivas');
	layout_concepto_colectivo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}