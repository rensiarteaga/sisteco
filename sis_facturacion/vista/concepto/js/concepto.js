/**
* Nombre:		  	    pagina_concepto.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2014.05
*/
function pagina_concepto(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	var dialog;
	var habilita_hijo='si';
	var comp_desc_ingas_item_serv, comp_id_concepto_ingas, comp_id_partida;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_concepto_ingas',totalRecords:'TotalCount'
		},[
		'id_concepto_ingas',
		'desc_ingas',
		'id_partida',
		'desc_partida',
		'id_item',
		'desc_item',
		'id_servicio',
		'desc_servicio',
		'desc_ingas_item_serv',
		'id_partida',
		'desc_partida',
		'sw_tesoro'
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_tesoro:8,
			id_gestion:0
		}
	});
	
	//DATA STORE COMBOS
  	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}}); 
	
  	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
  	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?tipo_partida=+2'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria'])
	});
	
	var ds_concepto_ingas=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',	id:'id_concepto_ingas',	totalRecords:'TotalCount'},['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv','id_partida','desc_partida','id_cuenta','desc_cuenta','sw_tesoro'])
	});
	
	//FUNCIONES RENDER		
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
    var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');
	
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_ingas_item_serv']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>{desc_ingas_item_serv}</b>','<br><FONT COLOR="#B50000"><b>Partida: </b>{desc_partida}</FONT>','<br><FONT COLOR="#B5A642"><b>Tesoro: </b>{sw_tesoro}</FONT>','</div>');  
		
	function render_concepto_ingas(value){
		if(value==8){value='Venta'	}
		return value
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false
	};

	Atributos[1]={
		validacion:{
			name:'desc_ingas_item_serv',
			fieldLabel:'Concepto de Venta',
			allowBlank:true,			
			desc: 'desc_ingas_item_serv', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'desc_ingas_item_serv',//valor que agarra o guarda
			displayField: 'desc_ingas_item_serv',//el que muestra
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas_item_serv',
			typeAhead:false,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,//tiempo de retardo para buscar en el combo
			pageSize:15,//tamaï¿½o de registros que hay en combo (paginacion)
			maxLength:150,//tamaï¿½o de max de caracteres
			grow:true,//
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:350,//tamaï¿½o del combo en el grid
			width:300,//tamaï¿½o del combo en el formulario
			minListWidth:300,//tamaï¿½o ANCHO de la lista en el formulario
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas_item_serv',
		save_as:'desc_ingas'
	};
	
	Atributos[2]={
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida',
			tipo:'partida',//determina el action a llamar
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_partida,
			width_grid:350,
			width:200,
			pageSize:10,
			direccion:direccion,
			disabled:false
		},
		tipo:'LovPartida',
		filtro_0:true,
		form:true,
		filterColValue:'PARTID.codigo_partida#PARTID.desc_partida'
	}; 
	
	Atributos[3]={
		validacion:{
			name:'sw_tesoro',
			fieldLabel:'Tesoreria',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.concepto_ingas_combo.sw_tesoro}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_concepto_ingas,
			grid_editable:false,
			forceSelection:true,
			align:'center',
			width_grid:150,
			width:200,
			minListWidth:100
		},
		tipo:'ComboBox',
		defecto:8,
		form:true
	};
		
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Concepto',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_facturacion/vista/concepto/concepto_cta.php'};
    layout_concepto = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_concepto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_concepto,idContenedor);
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;
	
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
		btnEliminar:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionEliminarConceptoIngas.php'},
		Save:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionGuardarConceptoIngas.php'},
        ConfirmSave:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionGuardarConceptoIngas.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Conceptos',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		dialog=Cm_getDialog();
		getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_concepto.getIdContentHijo()).pagina.limpiarStore()){}
		})
		comp_desc_ingas_item_serv=getComponente('desc_ingas_item_serv');
		comp_id_concepto_ingas=getComponente('id_concepto_ingas');
		comp_id_partida=getComponente('id_partida');
		
		CM_ocultarComponente(getComponente('id_partida'));
		CM_ocultarComponente(getComponente('sw_tesoro'));
		
		var onSelect=function(combo,record,index){
			comp_id_partida.setValue(record.data.id_partida);
			comp_id_concepto_ingas.setValue(record.data.id_concepto_ingas);
		};
		
		comp_desc_ingas_item_serv.on('select',onSelect);
	}
	
	
	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_concepto.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_concepto.getIdContentHijo()).pagina.bloquearMenu();
	    _CP.getPagina(layout_concepto.getIdContentHijo()).pagina.desbloquearMenu();
	    
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();
	    _CP.getPagina(idContenedor).pagina.desbloquearMenu();
	}
	
	var gestion = new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'gestion',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_gestion',
		tpl:tpl_gestion
	});

	gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();	
		ds_concepto_ingas.baseParams = {sw_tesoro:8, m_gestion:g_id_gestion};	
		comp_desc_ingas_item_serv.modificado=true;
			
		ds.load({
			params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_tesoro:8,
			id_gestion:g_id_gestion
			}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_concepto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBotonCombo(gestion,'gestion');
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_concepto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
