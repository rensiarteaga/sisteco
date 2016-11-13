//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new ReporteDepreciacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_items_proveedores.js
 * Propósito: 			pagina objeto principal
 * Autor:				Grover Velasquez Colque
 * Fecha creación:		15/07/2010
 */
function ReporteDepreciacion(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
    var data_ep;

	var datax;
   //proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		
	/////DATA STORE////////////
	ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'

		}, ['id_financiador','nombre_financiador','codigo_financiador'])

	})


	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	})

	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'

		}, ['id_programa','nombre_programa'])//,
	})

	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'

		}, ['id_proyecto','nombre_proyecto'])//,
	})


	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'

		}, ['id_actividad','nombre_actividad'])//,
	})

	///////para el grupo de activo

	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/tipo_activo/ActionListaTipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_tipo_activo','descripcion'])

	})

	ds_sub_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_sub_tipo_activo','codigo','descripcion'])

	})



	ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/activo_fijo/ActionListaActivoFijo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'

		}, ['id_activo_fijo','codigo','descripcion'])

	})


	////////// txt fecha_ini//////
	vectorAtributos[0] ={
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Desde',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_desde'
	};
	 

	////////// txt fecha_fin//////
	vectorAtributos[1]={
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Hasta',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_hasta'
	};
	 
	// txt id_fina_regi_prog_proy_acti
	/*vectorAtributos[2]={
		validacion:{
			fieldLabel:'Estructura Programática',
			allowBlank:false,
			//emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false		
			//width:300
			},
			tipo:'epField',
			save_as:'txt_id_fina_regi_prog_proy_acti',
			id_grupo:1
		};*/
	
	vectorAtributos[2]= {
		validacion:{
			pregarga:false,
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			queryDelay:250,
			minChars: 1,
			triggerAction: 'all',
			grid_indice:14,
			width:100
		},
		tipo: 'epField',
		//save_as:'hidden_id_ep1',
		save_as:'txt_id_fina_regi_prog_proy_acti',
		id_grupo:1
	};

	/////////// txt codigo//////
	/*vectorAtributos[2] = {
		validacion:{
			fieldLabel: 'Financiador',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Financiador...',
			name: 'id_financiador',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_financiador', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_financiador,
			valueField: 'id_financiador',
			displayField: 'nombre_financiador',
			queryParam: 'filterValue_0',
			filterCol:'nombre_financiador',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_financiador',
		tipo: 'ComboBox'
	}
	 


	filterCols_regional = new Array();
	filterValues_regional = new Array();
	filterCols_regional[0] = 'frppa.id_financiador';
	filterValues_regional[0] = '%';

	vectorAtributos[3] = {
		validacion:{
			fieldLabel: 'Regional',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Regional...',
			name: 'id_regional',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_regional', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'nombre_regional',
			filterCols:filterCols_regional,
			filterValues:filterValues_regional,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_regional',
		tipo: 'ComboBox'
	}
	 


	filterCols_programa= new Array();
	filterValues_programa= new Array();
	filterCols_programa[0] = 'frppa.id_financiador';
	filterValues_programa[0] = '%';
	filterCols_programa[1] = 'frppa.id_regional';
	filterValues_programa[1] = '%';

	vectorAtributos[4] = {
		validacion:{
			fieldLabel: 'Programa',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Programa...',
			name: 'id_programa',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_programa', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'nombre_programa',
			filterCols:filterCols_programa,
			filterValues:filterValues_programa,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_programa',
		tipo: 'ComboBox'
	}
	

	filterCols_proyecto= new Array();
	filterValues_proyecto= new Array();
	filterCols_proyecto[0] = 'frppa.id_financiador';
	filterValues_proyecto[0] = '%';
	filterCols_proyecto[1] = 'frppa.id_regional';
	filterValues_proyecto[1] = '%';
	filterCols_proyecto[2] = 'ppa.id_programa';
	filterValues_proyecto[2] = '%';


	vectorAtributos[5]= {
		validacion:{
			fieldLabel: 'Proyecto',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Proyecto...',
			name: 'id_proyecto',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_proyecto', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'nombre_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'nombre_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_proyecto',
		tipo: 'ComboBox'
	}
	

	filterCols_actividad= new Array();
	filterValues_actividad= new Array();
	filterCols_actividad[0] = 'frppa.id_financiador';
	filterValues_actividad[0] = '%';
	filterCols_actividad[1] = 'frppa.id_regional';
	filterValues_actividad[1] = '%';
	filterCols_actividad[2] = 'ppa.id_programa';
	filterValues_actividad[2] = '%';
	filterCols_actividad[3] = 'ppa.id_proyecto';
	filterValues_actividad[3] = '%';


	vectorAtributos[6]= {
		validacion:{
			fieldLabel: 'Actividad',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Actividad...',
			name: 'id_actividad',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_actividad', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_actividad ,
			valueField: 'id_actividad',
			displayField: 'nombre_actividad',
			queryParam: 'filterValue_0',
			filterCol:'nombre_actividad',
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_actividad',
		tipo: 'ComboBox'
	}*/
	

	/////////// txt tipo_activo//////
	vectorAtributos[3] = {
		validacion:{
			fieldLabel: 'Tipo Activo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Tipo Activo...',
			name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'tip.descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:0,
		save_as:'txt_id_tipo_activo',
		tipo: 'ComboBox'
	}
	 

	filterCols_sub_tipo = new Array();
	filterValues_sub_tipo = new Array();
	filterCols_sub_tipo[0] = 'sub.id_tipo_activo';
	filterValues_sub_tipo[0] = '%';

	vectorAtributos[4] = {
		validacion:{
			fieldLabel: 'Subtipo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Subtipo...',
			name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_sub_tipo,
			valueField: 'id_sub_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'sub.descripcion',
			filterCols:filterCols_sub_tipo,
			filterValues:filterValues_sub_tipo,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:0,
		save_as:'txt_id_sub_tipo_activo',
		tipo: 'ComboBox'
	}
	



	/*filterCols_activo_fijo = new Array();
	filterValues_activo_fijo = new Array();
	filterCols_activo_fijo[0] = 'af.id_sub_tipo_activo';
	filterValues_activo_fijo[0] = '%';*/

	filterCols_activo_fijo = new Array();
	filterValues_activo_fijo = new Array();
	filterCols_activo_fijo[0] = 'TIP.id_tipo_activo';
	filterValues_activo_fijo[0] = '%';
	filterCols_activo_fijo[1] = 'SUB.id_sub_tipo_activo';
	filterValues_activo_fijo[1] = '%';
	vectorAtributos[5] = {
		validacion:{
			fieldLabel: 'Activo Fijo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Activo Fijo...',
			name: 'id_activo_fijo',     //indica la columna del store principal "ds" del que proviene el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_activo_fijo,
			valueField: 'id_activo_fijo',
			displayField: 'codigo',
			//displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'af.codigo',
			filterCols:filterCols_activo_fijo,
			filterValues:filterValues_activo_fijo,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:0,
		save_as:'txt_id_activo_fijo',
		tipo: 'ComboBox'
	}
	

	vectorAtributos[6] = {
		validacion: {
			name: 'tipo_data_rep',
			fieldLabel: 'Datos',
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['valor', 'desc'],data : Ext.proc_depreciacionCombo.tipo}),
			store: new Ext.data.SimpleStore({fields: ['valor', 'desc'],data : [
			                                                                   ['pri', 'Actual'],
			                                                                   ['sec', 'Histórico']
			                                                               ]}),
			valueField:'valor',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:70 // ancho de columna en el grid
		},
		id_grupo:0,
		tipo:'ComboBox',
		defecto: 'Actual',
		save_as:'txt_tipo_data_rep'

	}
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'txt_id_financiador',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_financiador'
	};
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'txt_id_regional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_regional'
	};
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'txt_id_programa',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_programa'
	};
	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'txt_id_proyecto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_proyecto'
	};
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'txt_id_actividad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_actividad'
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
		titulo_maestro:'Reporte Depreciaciones'		
	};
	
	layout_reporte_depreciacion=new DocsLayoutProceso(idContenedor);
	layout_reporte_depreciacion.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_reporte_depreciacion,idContenedor);
	
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
	var ClaseMadre_submit = this.submit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	
	/*ds_financiador.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_regional.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_programa.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_proyecto.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_actividad.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_sub_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//ds_unidad_constructiva.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_activo_fijo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	*/
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{
		
		var titulo = "Rep. Depreciación";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		
		
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/depreciacion/ActionPDFDetalleDepreciacion.php',
							
	    abrir_pestana:false, //abrir pestana  rensi
		titulo_pestana:obtenerTitulo,
		
		fileUpload:false,  //rensi
		width:'60%',
		columnas:[350,350],
		//columnas:['47%','47%'],
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Reporte Depreciación',
		
		grupos:[
			{
				tituloGrupo:'Activo Fijo',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Estructura Programática',
				columna:1,
				id_grupo:1
			}]
		}	
	};
		
	console.log(vectorAtributos[2]);
	//console.log(id_fina_regi_prog_proy_acti);
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	
	function iniciarEventosFormularios()
	{
		/*combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');*/
		
		
		
		combo_tipo = ClaseMadre_getComponente('id_tipo_activo');
		combo_sub_tipo = ClaseMadre_getComponente('id_sub_tipo_activo');
		combo_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
		v_fecha_desde = ClaseMadre_getComponente('fecha_desde');
		v_fecha_hasta = ClaseMadre_getComponente('fecha_hasta');
		cmbEp=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
		
		txt_id_financiador=ClaseMadre_getComponente('id_financiador');
		txt_id_regional=ClaseMadre_getComponente('id_regional');
		txt_id_programa=ClaseMadre_getComponente('id_programa');
		txt_id_proyecto=ClaseMadre_getComponente('id_proyecto');
		txt_id_actividad=ClaseMadre_getComponente('id_actividad');
		
		id_fina_regi_prog_proy_acti=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
		
		var onEpSelect = function(e){
			
			var ep=cmbEp.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			
			//ds_unidad_organizacional.baseParams.tipo_vista="reporte_solicitudes_uo";
			//ds_unidad_organizacional.baseParams.id_fina_regi_prog_proy_acti=ep['id_fina_regi_prog_proy_acti'];
			//combo_uo.modificado=true;
			
			//id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
			//codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));
			
			//id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
			txt_id_financiador.setValue(ep['txt_id_financiador']);
			txt_id_regional.setValue(ep['txt_id_regional']);
			txt_id_programa.setValue(ep['txt_id_programa']);
			txt_id_proyecto.setValue(ep['txt_id_proyecto']);
			txt_id_actividad.setValue(ep['txt_id_actividad']);
			
			codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));

			
		};


		/*var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0);
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params1 = new Array();
			params1['id_regional'] = '%';
			params1['nombre_regional'] = 'Todos las Regionales';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_regional.store.add(aux1);
			combo_regional.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');
			///////
			//combo_regional.setValue('');
			//combo_programa.setValue('');
			//combo_proyecto.setValue('');
			//combo_actividad.setValue('');

		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue();
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			var  params1 = new Array();


			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0);
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');

		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue();
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');
		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue();
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');

		};*/

		var onTipoSelect = function(e) {
			var id = combo_tipo.getValue();
			combo_sub_tipo.filterValues[0] =  id;
			combo_sub_tipo.modificado = true;
			combo_activo_fijo.filterValues[0] =  id;
			combo_activo_fijo.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params1 = new Array();
			params1['id_sub_tipo_activo'] = '%';
			params1['descripcion'] = 'Todos los Subtipos de Activos';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_sub_tipo.store.add(aux1);
			combo_sub_tipo.setValue('%');
			///////

			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos Fijos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');
			///////
		};

		var onSubtipoSelect = function(e) {
			var id = combo_sub_tipo.getValue();
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;

			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos Fijos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');
			///////
			//combo_activo_fijo.setValue('%');
		};

		var onFechaDesdeSelect=function(e){
			var fecha=v_fecha_desde.getValue();
			v_fecha_hasta.minValue=fecha;
		}

		/*combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);*/
		combo_tipo.on('select', onTipoSelect);
		combo_tipo.on('change', onTipoSelect);
		combo_sub_tipo.on('select', onSubtipoSelect);
		combo_sub_tipo.on('change', onSubtipoSelect);


		///para el manejo de gestion fin

		v_fecha_desde.on('select', onFechaDesdeSelect);
		v_fecha_desde.on('change', onFechaDesdeSelect);
		
		cmbEp.on('change',onEpSelect);
		cmbEp.on('select',onEpSelect);

	}	
		
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			//alert('Entra');
			if(vectorAtributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
		
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
				componentes[i].allowBlank=vectorAtributos[i].validacion.allowBlank;
		}
	}
	
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_reporte_depreciacion.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
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
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}