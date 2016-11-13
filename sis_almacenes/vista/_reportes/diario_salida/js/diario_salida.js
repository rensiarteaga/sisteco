/**
* Nombre:		  	    pagina_existencia_almacen_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 21:00:48
*/
function pagina_diario_salida(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;
	var componentes=new Array();

	/*var ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen/ActionListarAlmacen.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen',
		totalRecords: 'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});*/
	
	var ds_almacen=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen/ActionListarAlmacenEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen',
		totalRecords: 'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});
	var ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen_logico/ActionListarAlmacenLogicoFisEPM.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen_logico',
		totalRecords: 'TotalCount'
	}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])
	});

		
	var ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro_almacen/ActionListarParametroAlmacen.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_parametro_almacen',
		totalRecords: 'TotalCount'
	}, ['id_parametro_almacen','cierre','gestion','estado'])
	});

	ds_supergrupo=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_supergrupo',
			totalRecords:'TotalCount'
		}, ['id_supergrupo','nombre','codigo'])
	});
	
	var ds_contratista = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/contratista/ActionListarContratista.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_contratista',
			totalRecords: 'TotalCount'
		},  ['id_contratista','codigo','observaciones','estado_registro','fecha_reg','id_institucion','id_persona','nombre_contratista','pagina_web','email','direccion'])});
	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'}, ['id_empleado','id_persona','codigo_empleado','desc_persona'])});
	var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_institucion',totalRecords: 'TotalCount'}, ['id_institucion','direccion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])});
	
 
	function render_id_almacen_ep(value, p, record){return String.format('{0}', record.data['desc_almacen_ep']);}
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	function renderSuperGrupo(value,p,record){return String.format('{0}',record.data['desc_supergrupo']);}
	
	
	function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista'])}
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado'])}
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion'])}
	
	
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplParAlm = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
    
	
	var resultTplContratista = new Ext.Template('<div class="search-item">','<b><i>{nombre_contratista}</i></b>','<br><FONT COLOR="#B5A642">Código: {codigo}','<br>Email: {email}','<br>Dirección: {direccion}</FONT>','</div>');
	var resultTplInstitucion = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">Página web: {pag_web}','<br>Dirección: {direccion}</FONT>','</div>');
	var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b><i>{codigo_empleado}</i></b>','<br><FONT COLOR="#B5A642">Nombre: {desc_persona}</FONT>','</div>');
	
	
	// Definición de datos //
	/////////////////////////
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro_almacen',
			desc:'gestion',
			store:ds_parametro_almacen,
			valueField:'id_parametro_almacen',
			displayField:'gestion',
			filterCol:'PARALM.gestion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAlm,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			//renderer:renderParAlm,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:200,
			grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'txt_id_parametro_almacen',
		id_grupo:0
	};
	
	// txt fecha_desde
	vectorAtributos[1]={
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha Desde',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:90,
			disabled:false
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_desde',
		id_grupo:0
	};

	// txt fecha_hasta
	vectorAtributos[2]={
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha Hasta',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:90,
			disabled:false
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};

	vectorAtributos[3]= {
		validacion:{
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:14,
			//width:300
			width:200
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:1
	}

	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	vectorAtributos[4]= {
		validacion: {
			fieldLabel:'Almacén Físico',
			allowBlank:true,
			emptyText:'Almacén Físico...',
			name: 'id_almacen',
			desc: 'desc_almacen',
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.nombre',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width:200,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMACE.nombre',
		defecto: '',
		save_as:'txt_id_almacen',
		id_grupo:1
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';
	vectorAtributos[5]= {
		validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:false,
			emptyText:'Almacén Lógico...',
			name: 'id_almacen_logico',
			desc: 'desc_almacen_logico',
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width:200,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:1
	};
	

	vectorAtributos[6]={
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
			typeAhead:true,
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
			width:200,
			grid_indice:4
		},
		tipo:'ComboBox',
		save_as:'txt_id_supergrupo',
		id_grupo:2
	};

	
	
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'desc_almacen',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_desc_almacen'
	};

	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'desc_almacen_logico',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_desc_almacen_logico'
	};

vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'codigo_ep',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'codigo_ep'
	};
vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion'
	};	

	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti'
	};	

	vectorAtributos[12]= {
		validacion: {
			name:'solicitante',
			fieldLabel:'Solicitante',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.diario_salidaCombo.solicitante}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [
			                                                                ['contratista','Contratista'],
			                                                                ['empleado','Funcionario'],
			                                                                ['institucion','Institución']
			                                                                ]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:200,
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'',
		defecto:'constratista',
		save_as:'',
		id_grupo:2
	};

	vectorAtributos[13]= {
		validacion: {
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:true,
			emptyText:'Funcionario...',
			desc: 'desc_empleado',
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno#EMPLEA.codigo_empleado',
			tpl:resultTplEmpleado,
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.id_persona#PERSON.nombre#PERSOn.apellido_paterno#PERSON.apellido_materno',
		defecto: '',
		save_as:'txt_id_empleado',
		id_grupo:2
	};

	vectorAtributos[14]= {
		validacion: {
			name:'id_contratista',
			fieldLabel:'Contratista',
			allowBlank:true,
			emptyText:'Contratista...',
			desc: 'desc_contratista',
			store:ds_contratista,
			valueField: 'id_contratista',
			displayField: 'nombre_contratista',
			queryParam: 'filterValue_0',
			filterCol:'CONTRA.codigo#INSTIT.nombre#INSTIT.pag_web#INSTIT.email1#INSTIT.direccion#PERSON.pag_web#INSTIT.email1',
			tpl:resultTplContratista,
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_contratista,
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.codigo',
		defecto: '',
		save_as:'txt_id_contratista',
		id_grupo:2
	};

	vectorAtributos[15]= {
		validacion: {
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,
			emptyText:'Institución...',
			desc: 'desc_institucion',
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			tpl:resultTplInstitucion,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		defecto: '',
		save_as:'txt_id_institucion',
		id_grupo:2
	};
	
	
	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name:'nombre_institucion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_institucion'
	};	
	vectorAtributos[17]={
		validacion:{
			labelSeparator:'',
			name:'nombre_contratista',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_contratista'
	};	
	vectorAtributos[18]={
		validacion:{
			labelSeparator:'',
			name:'nombre_funcionario',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'nombre_funcionario'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Resumen de Salidas'

	};
	layout_existencia_almacen=new DocsLayoutProceso(idContenedor);
	layout_existencia_almacen.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_existencia_almacen,idContenedor);

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
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Resumen de Salidas";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/diario_salida/ActionDiarioSalida.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,

		fileUpload:false,
		width:'70%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Datos',
		grupos:[
		{	tituloGrupo:'Datos Gestión',
		columna:0,
		id_grupo:0
		},
		{	tituloGrupo:'Datos Almacén',
		columna:0,
		id_grupo:1
		},
		{	tituloGrupo:'Datos Solicitante',
		columna:0,
		id_grupo:2
		}


		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		cmbEp=ClaseMadre_getComponente('id_ep');
		cmbAlmacen = ClaseMadre_getComponente('id_almacen');
		cmbAlmacenLogico = ClaseMadre_getComponente('id_almacen_logico');
		
		cmbGestion=ClaseMadre_getComponente('id_parametro_almacen');
		
		combo_solicitante = ClaseMadre_getComponente('solicitante');
		combo_contratista = ClaseMadre_getComponente('id_contratista');
		combo_empleado = ClaseMadre_getComponente('id_empleado');
		combo_institucion = ClaseMadre_getComponente('id_institucion');
		
		
		txt_desc_almacen=ClaseMadre_getComponente('desc_almacen');
		txt_desc_almacen_logico=ClaseMadre_getComponente('desc_almacen_logico');
		codigo_ep=ClaseMadre_getComponente('codigo_ep');
		
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
		
		gestion=ClaseMadre_getComponente('gestion');
		id_fina_regi_prog_proy_acti=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
		
		nombre_institucion=ClaseMadre_getComponente('nombre_institucion');
        nombre_contratista=ClaseMadre_getComponente('nombre_contratista');
        nombre_funcionario=ClaseMadre_getComponente('nombre_funcionario');
		
		var onEpSelect = function(e){
			var ep=cmbEp.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			cmbAlmacen.setValue('');
			cmbAlmacenLogico.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			cmbAlmacen.modificado=true;
			cmbAlmacenLogico.modificado=true;
			//Carga los datos en variables ocultas
			id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
			codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));
			//alert(codigo_ep.getValue());
			
		};

		var onAlmacenSelect = function(e) {
			var id = cmbAlmacen.getValue();
			//alert(id);
			if(id=='') id='x';
			cmbAlmacenLogico.filterValues[0] =  id;
			cmbAlmacenLogico.modificado = true;
			cmbAlmacenLogico.setValue('');
			cmbAlmacenLogico.modificado=true;
			
			//Obtiene la descripción del almacén
			if(cmbAlmacen.store.getById(id)!=undefined){
				txt_desc_almacen.setValue(cmbAlmacen.store.getById(id).data.nombre);
			}
		};
		
		var onAlmacenLogicoSelect = function(e) {
			var id = cmbAlmacenLogico.getValue();
			
			//Obtiene la descripción del almacén
			if(cmbAlmacenLogico.store.getById(id)!=undefined){
				txt_desc_almacen_logico.setValue(cmbAlmacenLogico.store.getById(id).data.nombre);
			}
		};
        
        
		var onGestionSelect = function(e) {
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined){
				intGestion=cmbGestion.store.getById(id).data.gestion;
			
				//Define límites de la fecha
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				
				//Instancia un objeto fecha con los datos obtenidos para que el DateFIeld los acepte sin problema
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				dteFechaDesde.minValue=dte_fecha_ini_valid;
				dteFechaDesde.maxValue=dte_fecha_fin_valid;
				dteFechaHasta.minValue=dte_fecha_ini_valid;
				dteFechaHasta.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				dteFechaDesde.setValue(dte_fecha_ini_valid);
				dteFechaHasta.setValue(dte_fecha_fin_valid);
				gestion.setValue(cmbGestion.store.getById(id).data.gestion);
			}
		};
		
		var onInstitucionSelect = function(e) {
			var id = combo_institucion.getValue();
			if(combo_institucion.store.getById(id)!=undefined){
				nombre_institucion.setValue(combo_institucion.store.getById(id).data.nombre);
			//	alert(nombre_institucion.getValue());
			}
		};
		
		var onContratistaSelect = function(e) {
			var id = combo_contratista.getValue();
			if(combo_contratista.store.getById(id)!=undefined){
				nombre_contratista.setValue(combo_contratista.store.getById(id).data.nombre_contratista);
			//	alert(nombre_institucion.getValue());
			}
		};
		var onFuncionarioSelect = function(e) {
			var id = combo_empleado.getValue();
			if(combo_empleado.store.getById(id)!=undefined){
				nombre_funcionario.setValue(combo_empleado.store.getById(id).data.desc_persona);
			//	alert(nombre_institucion.getValue());
			}
		};
			var onSolicitanteSelect=function(e){
			var valor = combo_solicitante.getValue();
			componentes[13].enable();//empleado
			componentes[14].enable();//contratista
			componentes[15].enable();//institucion
			if(valor == 'empleado'){

				CM_mostrarComponente(componentes[13]);//empleado
				CM_ocultarComponente(componentes[14]);//contratista
				CM_ocultarComponente(componentes[15])//institucion
			}else if (valor == 'contratista'){
				CM_ocultarComponente(componentes[13]);//empleado
				CM_mostrarComponente(componentes[14]);//contratista
				CM_ocultarComponente(componentes[15])//institucion
			}else if(valor == 'institucion'){
				CM_ocultarComponente(componentes[13]);//empleado
				CM_ocultarComponente(componentes[14]);//contratista
				CM_mostrarComponente(componentes[15])//institucion
			};
		}

		var onSolicitanteChange = function(e){
			var valor = combo_solicitante.getValue();
			if(valor == 'contratista'){
				combo_empleado.reset();
				combo_institucion.reset()
				nombre_funcionario.setValue('');
				nombre_institucion.setValue('');
			}else if(valor == 'empleado'){
				combo_contratista.reset();
				combo_institucion.reset()
				nombre_contratista.setValue('');
				nombre_institucion.setValue('');
			}else if(valor == 'institucion'){
				combo_empleado.setValue('');
				combo_contratista.setValue('')
				nombre_contratista.setValue('');
				nombre_funcionario.setValue('');
			}
		};
                cmbEp.on('change',onEpSelect)
			    cmbAlmacen.on('select',onAlmacenSelect);
		        cmbAlmacenLogico.on('select',onAlmacenLogicoSelect);
                cmbGestion.on('select',onGestionSelect);
                combo_solicitante.on('select', onSolicitanteSelect);
		        combo_solicitante.on('change', onSolicitanteSelect);
		        
		        combo_contratista.on('change',onSolicitanteChange);
		        combo_contratista.on('select',onContratistaSelect);
		        combo_institucion.on('change',onSolicitanteChange);
		        combo_institucion.on('select',onInstitucionSelect);
		        combo_empleado.on('change',onSolicitanteChange);
	            combo_empleado.on('select',onFuncionarioSelect);

	}
	 function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep));
		Ext.apply(cmbAlmacen.store.baseParams,datos);
		Ext.apply(cmbAlmacenLogico.store.baseParams,datos)
	    }
	
	function InitPaginaDiarioSalidas(){
		/*grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		*/
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		CM_ocultarComponente(componentes[13]);//empleado
		CM_ocultarComponente(componentes[15])//institución
	}

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaDiarioSalidas(); 
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
