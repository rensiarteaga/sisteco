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
var elemento={pagina:new RepDetalleActivoFijo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    rep_dep_detalle.js
 * Propósito: 			Generar reportes de acuerdo a la depreciacion de un activo
 * Autor:				Marcos A. Flores Valda
 * Fecha creación:		12/01/2010
 */

function RepDetalleActivoFijo(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var Atributos=new Array;
	var componentes=new Array;
		
	 ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/financiador/ActionListaFinanciadorDepto.php?origen=filtro'}), //ActionListaFinanciadorEP
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'
	
		}, ['id_financiador','nombre_financiador','codigo_financiador'])	
	})
	
	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/regional/ActionListaRegionalDepto.php?origen=filtro'}), //ActionListaRegionalEP
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'	
		}, ['id_regional','nombre_regional'])//,
	})
	
	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/programa/ActionListaProgramaDepto.php?origen=filtro'}), //ActionListaProgramaEP
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'	
		}, ['id_programa','nombre_programa'])//,
	})
	
	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/proyecto/ActionListaProyectoDepto.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'	
		}, ['id_proyecto','nombre_proyecto'])//,
	})
	
	
	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/actividad/ActionListaActividadDepto.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'	
		}, ['id_actividad','nombre_actividad'])//,
	})
	
	
	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_activo/ActionListaTipoActivoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'	
		}, ['id_tipo_activo','descripcion'])
	
	})
	
	ds_sub_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',	
			id: 'id_sub_tipo_activo',	
			totalRecords: 'TotalCount'
		}, ['id_sub_tipo_activo','descripcion'])
	})
		 
	ds_unidad_organizacional = new Ext.data.Store({
		 proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?origen=filtro'}),
		 reader:new Ext.data.XmlReader({
			 record:'ROWS',
			 id:'id_unidad_organizacional',
			 totalRecords: 'TotalCount'},
			 ['id_unidad_organizacional','nombre_unidad'])
		 })
	 
	 ds_estado_funcional = new Ext.data.Store({
			// asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/estado_funcional/ActionListaEstadoFuncional.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_estado_funcional',
				totalRecords: 'TotalCount'}, 
				['id_estado_funcional','descripcion'])//,
		});

	////////// txt fecha_ini//////
	
	vectorAtributos[0] = {
			validacion:{
				fieldLabel: 'Financiador',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Financiador...',
				name: 'id_financiador',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_financiador', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_financiador,
				onSelect: function(record){componentes[0].setValue(record.data.id_financiador)	; componentes[14].setValue(record.data.nombre_financiador); componentes[0].collapse(); },
				valueField: 'id_financiador',
				displayField: 'nombre_financiador',
				queryParam: 'filterValue_0',
				filterCol:'FRPPA.nombre_financiador',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_financiador',
			tipo: 'ComboBox'
		};

		filterCols_regional = new Array();
		filterValues_regional = new Array();
		filterCols_regional[0] = 'FRPPA.id_financiador';
		filterValues_regional[0] = '%';

		vectorAtributos[1] = {
			validacion:{
				fieldLabel: 'Regional',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Regional...',
				name: 'id_regional',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_regional', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_regional,
				onSelect: function(record){componentes[1].setValue(record.data.id_regional)	; componentes[15].setValue(record.data.nombre_regional); componentes[1].collapse(); },
				valueField: 'id_regional',
				displayField: 'nombre_regional',
				queryParam: 'filterValue_0',
				filterCol:'FRPPA.nombre_regional',
				filterCols:filterCols_regional,
				filterValues:filterValues_regional,
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_regional',
			tipo: 'ComboBox'
		};

		filterCols_programa= new Array();
		filterValues_programa= new Array();
		filterCols_programa[0] = 'FRPPA.id_financiador';
		filterValues_programa[0] = '%';
		filterCols_programa[1] = 'FRPPA.id_regional';
		filterValues_programa[1] = '%';

		vectorAtributos[2]= {
			validacion:{
				fieldLabel: 'Programa',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Programa...',
				name: 'id_programa',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_programa', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_programa,
				onSelect: function(record){componentes[2].setValue(record.data.id_programa)	; componentes[16].setValue(record.data.nombre_programa); componentes[2].collapse(); },
				valueField: 'id_programa',
				displayField: 'nombre_programa',
				queryParam: 'filterValue_0',
				filterCol:'FRPPA.nombre_programa',
				filterCols:filterCols_programa,
				filterValues:filterValues_programa,
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_programa',
			tipo: 'ComboBox'
		};
		
		filterCols_proyecto= new Array();
		filterValues_proyecto= new Array();
		filterCols_proyecto[0] = 'FRPPA.id_financiador';
		filterValues_proyecto[0] = '%';
		filterCols_proyecto[1] = 'FRPPA.id_regional';
		filterValues_proyecto[1] = '%';
		filterCols_proyecto[2] = 'FRPPA.id_programa';
		filterValues_proyecto[2] = '%';

		vectorAtributos[3]= {
			validacion:{
				fieldLabel: 'Proyecto',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Proyecto...',
				name: 'id_proyecto',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_proyecto', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_proyecto,
				onSelect: function(record){componentes[3].setValue(record.data.id_proyecto)	; componentes[17].setValue(record.data.nombre_proyecto); componentes[3].collapse(); },
				valueField: 'id_proyecto',
				displayField: 'nombre_proyecto',
				queryParam: 'filterValue_0',
				filterCol:'FRPPA.nombre_proyecto',
				filterCols:filterCols_proyecto,
				filterValues:filterValues_proyecto,
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_proyecto',
			tipo: 'ComboBox'
		};
		
		filterCols_actividad= new Array();
		filterValues_actividad= new Array();
		filterCols_actividad[0] = 'FRPPA.id_financiador';
		filterValues_actividad[0] = '%';
		filterCols_actividad[1] = 'FRPPA.id_regional';
		filterValues_actividad[1] = '%';
		filterCols_actividad[2] = 'FRPPA.id_programa';
		filterValues_actividad[2] = '%';
		filterCols_actividad[3] = 'FRPPA.id_proyecto';
		filterValues_actividad[3] = '%';

		vectorAtributos[4] = {
			validacion:{
				fieldLabel: 'Actividad',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Actividad...',
				name: 'id_actividad',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_actividad', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_actividad,
				onSelect: function(record){componentes[4].setValue(record.data.id_actividad); componentes[18].setValue(record.data.nombre_actividad); componentes[4].collapse(); },
				valueField: 'id_actividad',
				displayField: 'nombre_actividad',
				queryParam: 'filterValue_0',
				filterCol:'FRPPA.nombre_actividad',
				filterCols:filterCols_actividad,
				filterValues:filterValues_actividad,
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_actividad',
			tipo: 'ComboBox'
		};
		
		/////////// txt tipo_activo//////
		filterCols_tipo_activo= new Array();
		filterValues_tipo_activo= new Array();
		filterCols_tipo_activo[0] = 'FINAN.id_financiador';
		filterValues_tipo_activo[0] = '%';
		filterCols_tipo_activo[1] = 'REGIO.id_regional';
		filterValues_tipo_activo[1] = '%';
		filterCols_tipo_activo[2] = 'PROG.id_programa';
		filterValues_tipo_activo[2] = '%';
		filterCols_tipo_activo[3] = 'PROY.id_proyecto';
		filterValues_tipo_activo[3] = '%';
		filterCols_tipo_activo[4] = 'ACTI.id_actividad';
		filterValues_tipo_activo[4] = '%';
		filterCols_tipo_activo[5] = 'tipo.id_tipo_activo';
		filterValues_tipo_activo[5] = '%';
		
		vectorAtributos[5] = {
			validacion:{
				fieldLabel: 'Tipo Activo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Tipo Activo...',
				name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_tipo,
				onSelect: function(record){componentes[5].setValue(record.data.id_tipo_activo); componentes[19].setValue(record.data.descripcion); componentes[5].collapse(); },
				valueField: 'id_tipo_activo',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'tipo.descripcion',
				filterCols:filterCols_tipo_activo,
				filterValues:filterValues_tipo_activo,
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
				triggerAction: 'all',
				editable : true
			},
			id_grupo:1,
			save_as:'txt_id_tipo_activo',
			tipo: 'ComboBox'
		};
		
		filterCols_sub_tipo= new Array();
		filterValues_sub_tipo= new Array();
		filterCols_sub_tipo[5] = 'tip.id_tipo_activo';
		filterValues_sub_tipo[5] = '%';
		filterCols_sub_tipo[6] = 'sub.id_sub_tipo_activo';
		filterValues_sub_tipo[6] = '%';
		
		vectorAtributos[6] = {
			validacion:{
				fieldLabel: 'Subtipo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Subtipo Activo...',
				name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
				store:ds_sub_tipo,
				onSelect: function(record){componentes[6].setValue(record.data.id_sub_tipo_activo); componentes[20].setValue(record.data.descripcion); componentes[6].collapse(); },
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
				minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true,
				width: 200
			},
			id_grupo:1,
			save_as:'txt_id_sub_tipo_activo',
			tipo: 'ComboBox'
		};		
				
		vectorAtributos[7] = {
			validacion:{
				fieldLabel: 'Unidad Organizacional',
				allowBlank: true,
				vtype:"texto",
				emptyText:'Unidad Organizacional...',
				name: 'id_unidad_organizacional',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_unidad', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_unidad_organizacional,
				onSelect: function(record){componentes[7].setValue(record.data.id_unidad_organizacional); componentes[21].setValue(record.data.nombre_unidad); componentes[7].collapse(); },
				valueField: 'id_unidad_organizacional',
				displayField: 'nombre_unidad',
				queryParam: 'filterValue_0',
				filterCol:'descripcion',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 200,
				resizable: true,
				minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true
			},
		    id_grupo:1,
		    tipo: 'ComboBox',
			save_as:'txt_id_unidad_organizacional'				
		}
		
		vectorAtributos[8] = {
			validacion:{
				fieldLabel: 'Estado Funcional',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Estado Funcional...',
				name: 'id_estado_funcional',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_estado_funcional',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_estado_funcional,
				onSelect: function(record){componentes[8].setValue(record.data.id_estado_funcional); componentes[22].setValue(record.data.descripcion); componentes[8].collapse(); },
				valueField: 'id_estado_funcional',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'descripcion',
				typeAhead: true,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:200 // ancho de columna en el gris
					
		},
		id_grupo:1,
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'txt_id_estado_funcional'				
	}
		
	vectorAtributos[9] = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			emptyText:'Estado...',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['%', 'Todos los estados'],['alta', 'alta'],['registrado', 'registrado'],['eliminado', 'eliminado']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:150,
			grid_visible:true,			
			disabled:false
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_estado',
		defecto:'en uso',
		id_grupo:1
	};		
		
	vectorAtributos[10] ={
		validacion:{
			name:'fecha_compra1',
			fieldLabel:'Fecha de Compra (Inicio)',
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
		id_grupo:1,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_compra1'
	};
		
	
	////////// txt fecha_fin//////
	vectorAtributos[11]={
		validacion:{
			name:'fecha_compra2',
			fieldLabel:'Fecha de Compra (Fin)',
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
		id_grupo:1,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_compra2'
	};

	vectorAtributos[12]={
		validacion:{
			name: 'ubicacion_fisica',
			fieldLabel: 'Ubicación',
			allowBlank: true,
			width:200 // ancho de columna en el gris
			
		},
		tipo: 'TextField',
		save_as:'txt_ubicacion_fisica',
		id_grupo:1
	};
	
	vectorAtributos[13]={
		validacion: {
			name: 'nombre_descripcion',
			fieldLabel: 'Nombre/Descripc',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			emptyText:'Nombre/Descripción...',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['Nombre', 'Nombre'],['Descripcion', 'Descripcion']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:150,
			grid_visible:true,			
			disabled:false
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_nombre_descripcion',
		id_grupo:1
	};
		
	vectorAtributos[14] = {
		validacion:{
			labelSeparator:'',
			name: 'financiador',
			inputType:'hidden'
		},
		tipo: 'Field',
		save_as:'txt_financiador'
	};		

	vectorAtributos[15]={
		validacion:{
			labelSeparator:'',
			name: 'regional',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_regional'
	};
	
	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'programa',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_programa'
	};
		
	vectorAtributos[17]={		
		validacion:{
			labelSeparator:'',
			name: 'proyecto',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_proyecto'
	};
		
	vectorAtributos[18]={
		validacion:{
			labelSeparator:'',
			name: 'actividad',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_actividad'
	};
		
	vectorAtributos[19]={
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_tipo'
	};
		
	vectorAtributos[20]={
		validacion:{
			labelSeparator:'',
			name: 'subtipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_subtipo'
	};
	
	vectorAtributos[21]={
		validacion:{
			labelSeparator:'',
			name: 'uni_org',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_uni_org'
	};
	
	vectorAtributos[22]={
		validacion:{
			labelSeparator:'',
			name: 'estado_func',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_estado_funcional'
	};
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){ return value ? value.dateFormat('d/m/Y') : '';	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={titulo_maestro:'Reporte Detalle de Activos Fijos'};
	
	layout_rep_detalle_activo_fijo = new DocsLayoutProceso(idContenedor);
	layout_rep_detalle_activo_fijo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_detalle_activo_fijo,idContenedor);
	
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
		
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////			
	function obtenerTitulo()
	{		
		var titulo = "Reporte Detalle Activo Fijo";
		return titulo;
	}	
	
	//datos necesarios para el filtro
	var paramFunciones = {		
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/activo_fijo_detalle/ActionPDFDetalleActivoFijo.php',
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,		
		fileUpload:false,
		width:'60%',
		columnas:[350,350],		
		minWidth:150, minHeight:200, closable:true, titulo:'Reporte Detalle Activo Fijo',
		
		grupos:[
			{
				tituloGrupo:'Estructura Programática',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Ingreso de filtros para el reporte',
				columna:1,
				id_grupo:1
			}]
		}	
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	
	function iniciarEventosFormularios()
	{				
		combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');
		combo_tipo = ClaseMadre_getComponente('id_tipo_activo');
		combo_sub_tipo = ClaseMadre_getComponente('id_sub_tipo_activo');	
		
		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
	    combo_actividad.on('select', onActividadSelect);
		combo_actividad.on('change', onActividadSelect);
		combo_tipo.on('select', onTipoSelect);
		combo_tipo.on('change', onTipoSelect);		
				
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	}	
	
	function onFinanciadorSelect(com,rec,ind) 
	{
		var id = combo_financiador.getValue()
		combo_regional.filterValues[0] =  id;
		combo_regional.modificado = true;
		combo_programa.filterValues[0] =  id;
		combo_programa.modificado = true;
		combo_proyecto.filterValues[0] =  id;
		combo_proyecto.modificado = true;
		combo_actividad.filterValues[0] =  id;
		combo_actividad.modificado = true;
		
		if(id=='%')
		{
			//Carga el valor por defecto de la regional
			var  params0 = new Array();
			params0['id_regional'] = '%';
			params0['nombre_regional'] = 'Todas las Regionales';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_regional.store.add(aux0)
			combo_regional.setValue('%');

			///////			
			//Carga el valor por defecto del programa
			var  params1 = new Array();
			params1['id_programa'] = '%';
			params1['nombre_programa'] = 'Todos los Programas';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_programa.store.add(aux1)
			combo_programa.setValue('%');
			///////			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todas las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
		}
		else
		{
			//Carga el valor por defecto de la regional
			var  params0 = new Array();
			params0['id_regional'] = '%';
			params0['nombre_regional'] = '';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_regional.store.add(aux0)
			combo_regional.setValue('%');
			///////			
			//Carga el valor por defecto del programa
			var  params1 = new Array();
			params1['id_programa'] = '%';
			params1['nombre_programa'] = '';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_programa.store.add(aux1)
			combo_programa.setValue('%');
			///////			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = '';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = '';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
		}							
	}

	function onRegionalSelect(com,rec,ind)  
		{
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			
			if(id=='%')
			{
				//Carga el valor por defecto del programa
				var  params1 = new Array();
				params1['id_programa'] = '%';
				params1['nombre_programa'] = 'Todos los Programas';
				var aux1 = new Ext.data.Record(params1,'%');
				combo_programa.store.add(aux1)
				combo_programa.setValue('%');
				///////			
				//Carga el valor por defecto del proyecto
				var  params2 = new Array();
				params2['id_proyecto'] = '%';
				params2['nombre_proyecto'] = 'Todos los Proyectos';
				var aux2 = new Ext.data.Record(params2,'%');
				combo_proyecto.store.add(aux2)
				combo_proyecto.setValue('%');			
				///////
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = 'Todas las Actividades';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}
			else
			{
				//Carga el valor por defecto del programa
				var  params1 = new Array();
				params1['id_programa'] = '%';
				params1['nombre_programa'] = '';
				var aux1 = new Ext.data.Record(params1,'%');
				combo_programa.store.add(aux1)
				combo_programa.setValue('%');
				///////			
				//Carga el valor por defecto del proyecto
				var  params2 = new Array();
				params2['id_proyecto'] = '%';
				params2['nombre_proyecto'] = '';
				var aux2 = new Ext.data.Record(params2,'%');
				combo_proyecto.store.add(aux2)
				combo_proyecto.setValue('%');			
				///////
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = '';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}			
		}
		
		function onProgramaSelect(com,rec,ind) 
		{
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			
			if(id=='%')
			{
				//Carga el valor por defecto del proyecto
				var  params2 = new Array();
				params2['id_proyecto'] = '%';
				params2['nombre_proyecto'] = 'Todos los Proyectos';
				var aux2 = new Ext.data.Record(params2,'%');
				combo_proyecto.store.add(aux2)
				combo_proyecto.setValue('%');			
				///////
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = 'Todas las Actividades';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}
			else
			{
				//Carga el valor por defecto del proyecto
				var  params2 = new Array();
				params2['id_proyecto'] = '%';
				params2['nombre_proyecto'] = '';
				var aux2 = new Ext.data.Record(params2,'%');
				combo_proyecto.store.add(aux2)
				combo_proyecto.setValue('%');			
				///////
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = '';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}			
		}
		
		function onProyectoSelect(com,rec,ind) 
		{
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			
			if(id=='%')
			{
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = 'Todas las Actividades';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}
			else
			{
				//Carga el valor por defecto de la actividad
				var  params3 = new Array();
				params3['id_actividad'] = '%';
				params3['nombre_actividad'] = '';
				var aux3 = new Ext.data.Record(params3,'%');
				combo_actividad.store.add(aux3)
				combo_actividad.setValue('%');	
			}			
		}
		
		function onActividadSelect(com,rec,ind)  
		{
			var id = combo_actividad.getValue()			
		}
		
		
		function onTipoSelect(com,rec,ind)  
		{		
			var id = combo_tipo.getValue()			
			combo_sub_tipo.filterValues[5] =  id;
			combo_sub_tipo.modificado = true;
						
			if(id=='%')
			{
				//Carga el valor por defecto del proyecto
				var  params5 = new Array();
				params5['id_sub_tipo_activo'] = '%';
				params5['descripcion'] = 'Todos los Subtipos de Activos';			
				var aux5 = new Ext.data.Record(params5,'%');
				combo_sub_tipo.store.add(aux5)
				combo_sub_tipo.setValue('%');				
			}
			else
			{
				var  params5 = new Array();
				params5['id_sub_tipo_activo'] = '%';
				params5['descripcion'] = '';			
				var aux5 = new Ext.data.Record(params5,'%');
				combo_sub_tipo.store.add(aux5)
				combo_sub_tipo.setValue('%');				
			}			
		}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){			
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
	this.getLayout=function(){return layout_reporte_detalle_dep.getLayout();};
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
				
	this.InitFunciones(paramFunciones);
	//para agregar botones
				
	this.iniciaFormulario();				
	iniciarEventosFormularios();				
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}