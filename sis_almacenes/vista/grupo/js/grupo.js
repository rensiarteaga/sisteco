function PaginaGrupo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var txt_nombre,txt_descripcion, txt_fecha_reg, txt_codigo;
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name:'descripcion',type:'string'},
		'id_grupo',
		'codigo',
		'nombre',
		'descripcion',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat: 'Y-m-d'},
		'id_supergrupo',
		'desc_supergrupo'
		]),
		remoteSort:true // metodo de ordenacion remoto
	});
	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			registro:paramConfig.registro
		}
	});
	/////DATA STORE COMBOS////////////
	ds_supergrupo=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_supergrupo',
			totalRecords:'TotalCount'
		}, ['id_supergrupo','nombre','codigo'])
	});
	function renderSuperGrupo(value,p,record){return String.format('{0}',record.data['desc_supergrupo']);}
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');

	///importante el render agarra los valores del store principal.
	/////////// hidden id_grupo //////
	//en la posición 0 siempre tiene que estar la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_grupo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_grupo'
	};

	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='estado_registro';
	filterValues[0]='activo';
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Super Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'SuperGrupo...',
			name:'id_supergrupo',     //indica la columna del store principal "ds" del que proviane el id
			desc:'desc_supergrupo', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'supgru.nombre#supgru.codigo',
			filterCols:filterCols,
			filterValues:filterValues,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSupGru,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderSuperGrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'supgru.nombre#supgru.codigo',
		save_as:'hidden_id_supergrupo'
	};
	vectorAtributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank: false,
			maxLength:5,
			minLength:1,
			selectOnFocus:true,
			width:50,
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[3]={
		validacion:{
			name:'nombre',
			fieldLabel:'Grupo',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'60%',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:2
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[5] = {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[6]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id', 'valor'],data:Ext.grupoCombo.estado}),
			store:new Ext.data.SimpleStore({fields:['id', 'valor'],data:[
			                                                     		['activo', 'Activo'],        
			                                                            ['inactivo', 'Inactivo']     
			                                                        ]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			width:65,
			grid_indice:6
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.estado_registro',
		save_as:'txt_estado_registro',
		defecto:"activo"
	};
	vectorAtributos[7]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:90,
			disabled:true,
			grid_indice:7
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'g.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:""
	};
		// ----------            FUNCIONES RENDER    ---------------//
		function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Grupo",
		grid_maestro:"grid-"+idContenedor
	};
	layout_grupo=new DocsLayoutMaestro(idContenedor);
	layout_grupo.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_grupo,idContenedor);
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
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu={

		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//datos necesarios para el filtro
	parametrosFiltro="&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/grupo/ActionEliminarGrupo.php"},
		Save:{url:direccion+"../../../control/grupo/ActionGuardarGrupo.php"},
		ConfirmSave:{url:direccion+"../../../control/grupo/ActionGuardarGrupo.php"},
		Formulario:{
			guardar:overloadSave,
			html_apply:"dlgInfo"+idContenedor,
			width:'40%',
			height:'65%',
			minWidth:150,
			minHeight:200,
			labelWidth: 75,
			closable:true,
			titulo:'Grupo'
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		txt_nombre = ClaseMadre_getComponente('nombre');
		txt_descripcion = ClaseMadre_getComponente('descripcion');
		txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		txt_codigo = ClaseMadre_getComponente('codigo');

		var CopiarDescrip=function(e)
		{	if(txt_nombre.getValue()!='')
			{	if(txt_descripcion.getValue()=='')
				{	txt_descripcion.setValue(txt_nombre.getValue())
				}
			}
		}
	txt_nombre.on('blur',CopiarDescrip)
	}
	this.btnNew=function()
	{	CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()
	}
	this.btnEdit=function()
	{	h_txt_codigo=txt_codigo.getValue();
		//h_txt_cod=h_txt_codigo.substr(4,3);
		//alert(h_txt_cod);
		var editar = h_txt_codigo.split('.');
		txt_codigo.setValue(editar[1]);
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
	}
	function overloadSave(a,b){
		arr={registro:paramConfig.registro};
		ClaseMadre_save(a,b,arr);
	}
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_grupo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}