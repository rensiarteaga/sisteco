function EjecucionInstitucional(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var componentes=new Array();
	var g_tipo_reporte='';
		
	//var fecha_fin;	
	
	
	//DATA STORE 		
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
			
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti',
																																										'id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro',
																																										'desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador',
																																										'nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional',
																																										'codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto',
																																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad','cp_cod_organismo_fin',
																																										'cp_cod_fuente_financiamiento','codigo_sisin'
																																										])
	});	
	
	
	//render
	
		function renderTipoPresupuesto(value, p, record)
		{						
			if(value == 1)
			{return "Recurso"}
			if(value == 2)
			{return "Gasto"}
			if(value == 3)
			{return "Inversión"}
			if(value=='2,3')
			{return "Gasto - Inversión"}
			if(value == 4)
			{return "PNO - Recurso"}
			if(value == 5)
			{return "PNO - Gasto"}
			if(value == 6)
			{return "PNO - Inversión"}
			
			return '';
		}	
		
	
		function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
						
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
		
		
	
	//function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{desc_unidad_organizacional}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',	 	
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{codigo_financiador}-{codigo_regional}-{codigo_programa}-{codigo_proyecto}-{codigo_actividad}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_actividad}</FONT>',		
		'<br><FONT COLOR="#B5A642">{denominacion}</FONT>',
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
		'</div>');
		
			
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
			
		
				
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	}; 
	
	vectorAtributos[1]={
		validacion:{
			name:'id_tipo_pres',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_pres_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	}; 
	
	// txt tipo_pres  
	 /*vectorAtributos[1]  = {
		validacion: {
			name:'tipo_pres',			
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
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
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:250			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'tipo_pres'
	};*/  

	vectorAtributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupue...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',			
			typeAhead:false,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:true,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,		
		filterColValue:'UNIORG.nombre_unidad#FUNFIN.denominacion#FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'id_presupuesto'
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'sub_programa',
			fieldLabel:'Sub Programa',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:true,					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false				
	};
	
	vectorAtributos[4]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width:250,			
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 
	
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha desde',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_desde',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha hasta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_hasta',
		id_grupo:0
	};
	
	

	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'tipo_reporte',
			fieldLabel:'Generar Archivo Texto:',
			allowBlank:true,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Checkbox',
		filtro_0:false,
		save_as:'tipo_reporte',
		id_grupo:0
	};	
	
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'gestion_pres',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion_pres'
	};
	
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'desc_pres',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_pres'
	};
	
	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'desc_presupuesto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_presupuesto'
	};
	
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'financiador',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'financiador'
	};
	
	vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name:'regional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'regional'
	};
	
	vectorAtributos[13]={
		validacion:{
			labelSeparator:'',
			name:'programa',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'programa'
	};
	
	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name:'proyecto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'proyecto'
	};
	
	vectorAtributos[15]={
		validacion:{
			labelSeparator:'',
			name:'actividad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'actividad'
	};
	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name:'unidad_organizacional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'unidad_organizacional'
	};
	vectorAtributos[17]={
		validacion:{
			labelSeparator:'',
			name:'fuente_financiamiento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'fuente_financiamiento'
	};
	
	vectorAtributos[18]={
		validacion:{
			labelSeparator:'',
			name:'desc_moneda',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_moneda'
	};
	
	vectorAtributos[19]=
	{
			validacion:{
				name: 'reporte',
				fieldLabel:'Tipo Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF'],['2','Excel']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				emptyText:'Seleccione una opción...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'no',
			save_as:'reporte'
		};
	

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Consolidación Presupuesto"
	};
	layout_ejecucion_reporte=new DocsLayoutProceso(idContenedor);
	layout_ejecucion_reporte.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ejecucion_reporte,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../control/ejecucion/ActionPDFEjecucionInstitucional.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			}]
		}
	
	
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
				
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
				
		componentes[0].on('select',evento_parametro);		//parametro		
		componentes[1].on('select',evento_tipo_presupuesto);	//tipo_pres	
		componentes[2].on('select',evento_presupuesto);		//presupuesto
		componentes[4].on('select',evento_moneda);		//moneda
		componentes[19].on('select',evento_reporte);		//tipo reporte
	}
	
	function evento_parametro( combo, record, index )
	{
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){
			
			var intGestion=componentes[0].store.getById(id).data.gestion_pres;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[5].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[5].maxValue=dte_fecha_fin_valid;
			componentes[6].minValue=dte_fecha_ini_valid;
			componentes[6].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[5].setValue(dte_fecha_ini_valid);
			componentes[6].setValue(dte_fecha_fin_valid);
			
		}
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'si'};
		componentes[1].modificado=true;
		componentes[1].setValue('');
			
		
		componentes[2].store.baseParams={sw_reporte_ejecucion:'si',id_parametro_ei:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].modificado=true;			
		componentes[2].setValue('');
		
		componentes[8].setValue(record.data.gestion_pres);
		
		if(componentes[1].getValue()!=undefined && componentes[1].getValue()!=''){
			componentes[2].setDisabled(false);
		}		
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{		
		componentes[9].setValue(renderTipoPresupuesto(componentes[1].getValue()), '', '');
		//componentes[2].store.baseParams={sw_reporte_ejecucion:'si',id_parametro_ei:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].store.baseParams={vista:'ejecucion_institucional',id_parametro_ei:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		
		componentes[2].modificado=true;
		componentes[2].setValue('');
		if(componentes[0].getValue()!=undefined && componentes[0].getValue()!='')
		{
			componentes[2].setDisabled(false);
		}			
	}
	
	function evento_presupuesto( combo, record, index )
	{
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[10].setValue(record.data.desc_presupuesto);
		componentes[12].setValue(record.data.nombre_regional);
	 	componentes[11].setValue(record.data.nombre_financiador);
	 	componentes[13].setValue(record.data.nombre_programa);
	 	componentes[14].setValue(record.data.nombre_proyecto);
	 	componentes[15].setValue(record.data.nombre_actividad);
	 	componentes[16].setValue(record.data.desc_unidad_organizacional);
	 	componentes[17].setValue(record.data.denominacion);
	 		
		
		componentes[3].setValue(record.data.nombre_proyecto);
	}
	
	function evento_moneda( combo, record, index )
	{
		componentes[18].setValue(record.data.nombre);
				
		componentes[19].modificado=true;			
		componentes[19].setValue('');	
	}
	
	function evento_reporte( combo, record, index )
	{
		g_tipo_reporte=record.data.id;
	}
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
