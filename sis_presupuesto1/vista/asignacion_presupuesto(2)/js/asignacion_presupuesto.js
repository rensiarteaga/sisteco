/**
 * Nombre:		  	    pagina_formulacion_presupuesto.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-08 11:37:54
 */
function pagina_asignacion_presupuesto(idContenedor,direccion,paramConfig,pr_estado_gral){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_presupuesto',totalRecords:'TotalCount'},
		[		
		'id_presupuesto',
		'tipo_pres',
		'estado_pres',
		'id_financiador','id_regional','id_programa',
		'id_proyecto','id_actividad','nombre_financiador',
		'nombre_regional','nombre_programa','nombre_proyecto',
		'nombre_actividad','codigo_financiador','codigo_regional',
		'codigo_programa','codigo_proyecto','codigo_actividad',
		'id_unidad_organizacional',		
		'desc_unidad_organizacional',
		'id_fuente_financiamiento',
		'denominacion',
		'id_parametro',
		'desc_parametro',
	 	'id_concepto_colectivo', 
 		'desc_colectivo',
 		
 		'cod_prg',
 		'cod_proy',
 		'cod_act',
 		'cod_fin',
 		'desc_usr_reg',
		'fecha_reg', 
		
		
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			estado_gral:pr_estado_gral,
			estado_pres:pr_estado_gral,
			id_moneda:'1'			
		}
	});
	
	
	//DATA STORE COMBOS

 /*var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
 reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional'])
 });*/
 
 var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?m_sw_presupuesto=si'}),
 reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad'])
 });

 var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion'])
	});

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	var ds_concepto_colectivo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','desc_colectivo'])
	});
	//FUNCIONES RENDER
 
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','</div>');

		function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['denominacion']);}
		var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">', '<b><i>{denominacion}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo_fuente}</FONT>','</div>');

		function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		
		function render_id_concepto_colectivo(value, p, record){return String.format('{0}', record.data['desc_colectivo']);}
		var tpl_id_concepto_colectivo=new Ext.Template('<div class="search-item">', '<b><i>{desc_colectivo}</i></b></FONT>','</div>');
		
		function renderTipoPresupuesto(value, p, record)
		{
			if(value == 0)
			{return "0. Administrativo"}
			if(value == 1)
			{return "1. Recurso"}
			if(value == 2)
			{return "2. Gasto"}
			if(value == 3)
			{return "3. Inversión"}
			if(value == 4)
			{return "4. PNO - Recurso"}
			if(value == 5)
			{return "5. PNO - Gasto"}
			if(value == 6)
			{return "6. PNO - Inversión"}
		}
		function renderEstadoPresupuesto(value, p, record){
			if(value == 1){return "1. Formulación"}
			if(value == 2){return "2. Verificación Previa"}
			if(value == 3){return "3. Revisión Final"}
			if(value == 4){return "4. Anteproyecto"}
			if(value == 5){return "5. Aprobado"}
		}	
	  
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_presupuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_presupuesto'
	};
// txt id_parametro
	Atributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Gestión...',
			desc: 'gestion_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#desc_estado_gral',
			typeAhead:true,
			align:'center',
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.gestion_pres',
		save_as:'id_parametro'
	};	
	
// txt tipo_pres
	 Atributos[2] = {
		validacion: {
			name:'tipo_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Presupuesto...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:80, // ancho de columna en el gris
			width:200,
			filterCol:'PRESUP.tipo_pres',
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		defecto: '1',
		save_as:'tipo_pres',
		filterColValue:'PRESUP.tipo_pres',
		id_grupo: 0
	};


	// txt tipo_pres
	 Atributos[3] = {
		validacion: {
			name:'estado_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Etapa',
			vtype:'texto',
			fieldLabel:'Etapa',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				
				data :Ext.tipo_presupuesto_combo.estado_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderEstadoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150, // ancho de columna en el gris
			width:200,
			disabled:true		
		},
		tipo:'ComboBox',
		defecto:'1',
		form: true,
		filtro_0:false,
		filtro_1:false,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'		
	};
 
	Atributos[4]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			//emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
	
	// txt id_fina_regi_prog_proy_acti
	Atributos[5]={
		validacion:{
			fieldLabel:'Estructura Programática',
			allowBlank:false,
			//emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,		
			width:300,
			editable:true
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};
	
	// txt id_fuente_financiamiento
	Atributos[6]={
			validacion:{
			name:'id_fuente_financiamiento',
			fieldLabel:'Fuente Financiamiento',
			allowBlank:false,			
			//emptyText:'Fuente Financiamiento...',
			desc: 'denominacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'denominacion',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.codigo_fuente#FUNFIN.denominacion',
			typeAhead:true,
			tpl:tpl_id_fuente_financiamiento,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.nombre_fuente_financiamiento',
		save_as:'id_fuente_financiamiento',
		id_grupo:2
	};

	Atributos[7]={
		validacion:{
			labelSeparator:'',
			name: 'sw_generacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'sw_generacion'
	};
 
	// txt id_concepto_colectivo
	Atributos[8]={
			validacion:{
			name:'id_concepto_colectivo',
			fieldLabel:'Presupuesto Colectivo',
			allowBlank:false,			
			//emptyText:'Colectivo ...',
			desc:'desc_colectivo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_colectivo,
			valueField:'id_concepto_colectivo',
			displayField:'desc_colectivo',
			queryParam: 'filterValue_0',
			filterCol:'CONCOL.desc_colectivo',
			typeAhead:true,
			tpl:tpl_id_concepto_colectivo,
	 		forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:6,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_colectivo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'concol.desc_colectivo',
		save_as:'id_concepto_colectivo'
	};
	
	Atributos[9]={
		validacion:{
			name:'cod_fin',
			fieldLabel:'Cod. Organismo Fin.',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.cod_fin',
		save_as:'cod_fin',
		id_grupo:2
	};
	
	Atributos[10]={
		validacion:{
			name:'cod_prg',
			fieldLabel:'Cod. Programa',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.cod_prg',
		save_as:'cod_prg',
		id_grupo:2
	};
	
	Atributos[11]={
		validacion:{
			name:'cod_proy',
			fieldLabel:'Cod. Proyecto',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disable:false,
			id_grupo:2	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.cod_proy',
		save_as:'cod_proy',
		id_grupo:2
	};
	
	Atributos[12]={
		validacion:{
			name:'cod_act',
			fieldLabel:'Cod. Actividad',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESUP.cod_act',
		save_as:'cod_act',
		id_grupo:2
	};		
	
	Atributos[13]={
		validacion:{			
			name:'desc_usr_reg',
			fieldLabel:'Usuario Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		form:false,		
		filterColValue:'PRESUP.desc_usr_reg'
	};
	
	Atributos[14]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Modificación',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		form:false,		
		filterColValue:'PRESUP.fecha_reg'
	};
		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Asignación de Partidas Presupuestarias',grid_maestro:'grid-'+idContenedor};
	var layout_formulacion_presupuesto=new DocsLayoutMaestroEP(idContenedor);
	
	layout_formulacion_presupuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_formulacion_presupuesto,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_actualizar=this.btnActualizar;
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
		btnEliminar:{url:direccion+'../../../control/presupuesto/ActionEliminarFormulacionPresupuesto.php'},
		Save:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php'},
		ConfirmSave:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php'},
		Formulario:
		{html_apply:'dlgInfo-'+idContenedor,
		height:400,
		width:400,
		columnas:['90%'],
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},
				{tituloGrupo:'Estructura Programática',columna:0,id_grupo:1},
				{tituloGrupo:'Categoría Programática',columna:0,id_grupo:2}
				],width:'50%',
				minWidth:150,
				minHeight:200,	
				closable:true,
				titulo:'Datos Generales del Presupuesto'
	 	 }
		};
		
	//console.log(Atributos[5]);	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.btnNew = function()
	{
		componentes[2].setDisabled(false);
		ClaseMadre_btnNew();
		ClaseMadre_actualizar();
	};
	this.btnEdit = function()
	{ 
		componentes[2].setDisabled(true);
	 	componentes[3].setDisabled(true);
		ClaseMadre_btnEdit();
		ClaseMadre_actualizar();
	};
	
	function btn_crear_con_plantilla()	
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var id_presupuesto;
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			
			/*if(SelectionsRecord.data.tipo_pres!=0)
			{*/
				id_presupuesto=SelectionsRecord.data.id_presupuesto;
				tipo_pres=SelectionsRecord.data.tipo_pres;
			 	
			 	ClaseMadre_btnNew();
			 	
			 	componentes[0].setValue(id_presupuesto);
			 	componentes[7].setValue(1);
			 	componentes[2].setValue(tipo_pres);
			 	componentes[2].setDisabled(false);
			 	ClaseMadre_actualizar();
		
		 	/*}
		 	else
		 	{
		 		Ext.MessageBox.alert('Atención', 'El registro seleccionado es un Presupuesto Administrativo');
			}*/
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}
	
	function btn_detalle_asignacion_presupuesto()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			/*if(SelectionsRecord.data.tipo_pres!=0)
			{*/
				var data='m_id_presupuesto='+SelectionsRecord.data.id_presupuesto;
			 	data+='&m_nombre_financiador='+SelectionsRecord.data.nombre_financiador;
				data+='&m_nombre_regional='+SelectionsRecord.data.nombre_regional;
			 	data+='&m_nombre_programa='+SelectionsRecord.data.nombre_programa;
			 	data+='&m_nombre_proyecto='+SelectionsRecord.data.nombre_proyecto;
			 	data+='&m_nombre_actividad='+SelectionsRecord.data.nombre_actividad;
			 	data+='&m_id_parametro='+SelectionsRecord.data.id_parametro;
			 	data+='&m_estado_gral='+pr_estado_gral;
			 	
			 	var partida;
			 	if(SelectionsRecord.data.tipo_pres==1 || SelectionsRecord.data.tipo_pres==4)
			 	{			 		
			 		partida= 1  //solo cuando el tipo de presupuesto es recurso o pno-recurso llamamos al clasdificador de recursos
				}
			 	else
			 	{
			 		partida= 2
			 	}
				 	data+='&m_tipo_presupuesto='+partida;
				 	data+='&m_tipo_pres='+SelectionsRecord.data.desc_unidad_organizacional+" ("+renderTipoPresupuesto(SelectionsRecord.data.tipo_pres,'','')+") ";
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_formulacion_presupuesto.loadWindows(direccion+'../../../../sis_presupuesto/vista/detalle_partida_asignacion/detalle_partida_asignacion.php?'+data,'Detalle de Partida Gasto',ParamVentana);
					layout_formulacion_presupuesto.getVentana().on('resize',function(){layout_formulacion_presupuesto.getLayout().layout();})
			/*}
			else
			{
				Ext.MessageBox.alert('Atención', 'El registro seleccionado es un Presupuesto Administrativo');
			}*/
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	function InitAsignacionPresupuesto()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
			
		}
/*	 	componentes[6].on('select',filtrar);	
		componentes[6].on('change',filtrar);*/
		//componentes[1].store.baseParams={estado_gral : pr_estado_gral};
		componentes[4].store.baseParams={filtroUsuario:'no'};
		
	};
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_formulacion_presupuesto.getLayout()};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Detalle de Partidas a Asignar',btn_detalle_asignacion_presupuesto,true,'detalle_parida_formulacion','Asignar Partidas');
	this.AdicionarBoton('../../../lib/imagenes/list-proce.bmp','Copiar la Asignación de Partidas',btn_crear_con_plantilla,true,'detalle_parida_formulacion_con_plantilla','Reproducir Asigación');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitAsignacionPresupuesto();
	layout_formulacion_presupuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}