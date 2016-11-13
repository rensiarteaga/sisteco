/**
 * Nombre:		  	    rep_detalle_activo_fijo.js
 * Propósito: 			Generar Reportes Detallados de los Activos Fijos
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		08/04/2013
 */

function RepDetalleActivoFijo(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var Atributos=new Array;
	var componentes=new Array;
	
	var cabecera_1 = [['Codigo','DISTINCT ACTIVO.codigo'],['Nombre','ACTIVO.descripcion'],['Descripcion','ACTIVO.descripcion_larga'],['Tipo','taf.descripcion'],['Subtipo','saf.descripcion'],
	                 ['Estado','ACTIVO.estado'],['Estado Funcional','EF.descripcion'],['Fecha Compra','to_char(ACTIVO.fecha_compra, \'\'dd-mm-yyyy\'\')as fecha_compra'],
	                 ['Fecha Ini Dep','to_char(ACTIVO.fecha_ini_dep, \'\'dd-mm-yyyy\'\')as fecha_inicio_depreciacion'],['Monto Compra','ACTIVO.monto_compra'],
	                 ['Numero factura','ACTIVO.num_factura'],['Orden de Compra','ACTIVO.orden_compra']]; //size 12
	
	var cabecera_2 = [['Monto Actual','ACTIVO.monto_actual'],['Monto Actualizado','ACTIVO.monto_actualiz'],['Ubicacion','UBICACION.ubicacion'],
		              ['Vida Util','ACTIVO.vida_util_original'],['Vida Util Restante','ACTIVO.vida_util_restante'],['Revalorizado','ACTIVO.flag_revaloriz'],['Proyecto','ACTIVO.proyecto'],
		              ['Observaciones','ACTIVO.observaciones'],['Origen','ACTIVO.origen']];//size 9
	
	var cabecera_3 = [['Responsable','EMPLEA.nombre_completo'],['Custodio','COALESCE(person.apellido_paterno,\'\'\'\')||\'\' \'\' ||COALESCE(person.apellido_materno,\'\' \'\')|| COALESCE(person.nombre,\'\' \'\')'],
	                  ['Unidad Organizacional','(SELECT uo.nombre_unidad from kard.tkp_unidad_organizacional uo where uo.id_unidad_organizacional = (select kard.f_kp_obtener_gerencia_x_funcionario(emplea.id_empleado,NULL))) as unidad_organizacional'],
		              ['Financiador','frppa.nombre_financiador'],['Regional','frppa.nombre_regional'],['Programa','frppa.nombre_programa'],['Proyecto','frppa.nombre_proyecto'],
		              ['Actividad','frppa.nombre_actividad'],['Ep','frppa.desc_epe'],
		              ['Departamento AF','depto.nombre_depto'],['ID Cbte.Alta','comp.id_comprobante'],['Fecha Cbte.','comp.fecha_cbte']]; //size 12
	
	
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
		 proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?origen=filtro&oc=si'}),
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
	 
	 var ds_depto = new Ext.data.Store({
		 proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?reporteActif=si&todos=si'}),		
		 reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','nombre_corto','nombre_largo','codificacion'])
		});
	 
	 var ds_ubicacion = new Ext.data.Store({
			// asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/ubicacion/ActionListarUbicacionFisica.php?origen=filtro'}), 
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_ubicacion',
				totalRecords: 'TotalCount'

			}, ['id_ubicacion','codigo','ubicacion'])
		});
	 
	function render_ubicacion(value, p, record){return String.format('{0}', record.data['ubicacion']);}
	var tpl_ubicacion=new Ext.Template('<div class="search-item">','{ubicacion}','</div>');

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
			onSelect: function(record){componentes[0].setValue(record.data.id_financiador)	; componentes[15].setValue(record.data.nombre_financiador); componentes[0].collapse(); },
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
		id_grupo:1,
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
			onSelect: function(record){componentes[1].setValue(record.data.id_regional)	; componentes[16].setValue(record.data.nombre_regional); componentes[1].collapse(); },
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
		id_grupo:1,
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
			onSelect: function(record){componentes[2].setValue(record.data.id_programa)	; componentes[17].setValue(record.data.nombre_programa); componentes[2].collapse(); },
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
		id_grupo:1,
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
			onSelect: function(record){componentes[3].setValue(record.data.id_proyecto)	; componentes[18].setValue(record.data.nombre_proyecto); componentes[3].collapse(); },
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
		id_grupo:1,
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
			onSelect: function(record){componentes[4].setValue(record.data.id_actividad); componentes[19].setValue(record.data.nombre_actividad); componentes[4].collapse(); },
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
		id_grupo:1,
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
			onSelect: function(record){componentes[5].setValue(record.data.id_tipo_activo); componentes[20].setValue(record.data.descripcion); componentes[5].collapse(); },
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
			editable : true,
			width: 300
		},
		id_grupo:0,
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
			onSelect: function(record){componentes[6].setValue(record.data.id_sub_tipo_activo); componentes[21].setValue(record.data.descripcion); componentes[6].collapse(); },
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
			width: 300
		},
		id_grupo:0,
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
			onSelect: function(record){componentes[7].setValue(record.data.id_unidad_organizacional); componentes[22].setValue(record.data.nombre_unidad); componentes[7].collapse(); },
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
			editable : true,
			width: 300
		},
	    id_grupo:0,
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
			onSelect: function(record){componentes[8].setValue(record.data.id_estado_funcional); componentes[23].setValue(record.data.descripcion); componentes[8].collapse(); },
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
			width_grid:200, // ancho de columna en el gris
			width: 300
		},
		id_grupo:0,
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
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['%', 'Todos los estados'],['no_eliminados', 'Todos excepto eliminados'],['no_elim_bajas', 'Todos excepto eliminados y bajas'],['alta', 'alta'],['baja', 'baja'],['registrado', 'registrado'],['codificado', 'codificado'],['eliminado', 'eliminado']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:200,
			grid_visible:true,			
			disabled:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_estado',
		defecto:'en uso',
		id_grupo:0
	};
		
	vectorAtributos[10] = {
		validacion: {
			name: 'proyecto_af',
			fieldLabel: 'Proyecto AF',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			emptyText:'Proyecto...',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['%', 'Todos'],['si', 'Si Proyecto'],['no', 'No Proyecto']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:200,
			grid_visible:true,			
			disabled:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_activo_proyecto',
		defecto:'Todos',
		id_grupo:0
	};
		
	vectorAtributos[11] = {
		validacion: {
			name: 'activo_bien',
			fieldLabel: 'Activo-Bien',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			emptyText:'Activo-Bien...',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['%', 'Todos'],['activo', 'Activo Fijo'],['bien_resp', 'Bien Bajo Resp']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:200,
			grid_visible:true,			
			disabled:false
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_activo_bien',
		defecto:'Todos',
		id_grupo:0
	};			
		
	vectorAtributos[12] ={
		validacion:{
			name:'fecha_compra1',
			fieldLabel:'Fecha Inicio',
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
		id_grupo:2,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_compra1'
	};
	
	////////// txt fecha_fin//////
	vectorAtributos[13]={
		validacion:{
			name:'fecha_compra2',
			fieldLabel:'Fecha Fin',
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
		id_grupo:2,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_compra2'
	};
	
	vectorAtributos[14] = {
		validacion:{
			fieldLabel: 'Ubicacion',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Ubicacion...',
			name: 'id_ubicacion',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'ubicacion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_ubicacion,
			onSelect: function(record){componentes[14].setValue(record.data.id_ubicacion); componentes[67].setValue(record.data.ubicacion); componentes[14].collapse(); },
			valueField: 'id_ubicacion',
			displayField: 'ubicacion',
			queryParam: 'filterValue_0',
			filterCol:'ubi.ubicacion', 
			//filterCols:filterCols_tipo_activo,
			//filterValues:filterValues_tipo_activo,
			tpl:tpl_ubicacion,
			renderer:render_ubicacion,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50, 
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true,
			width: 300
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ubi.id_ubicacion',
		save_as:'txt_ubicacion_fisica',
		id_grupo:0
	};
		
	vectorAtributos[15] = { 
		validacion:{
			labelSeparator:'',
			name: 'financiador',
			inputType:'hidden'
		},
		tipo: 'Field',
		save_as:'txt_financiador',
		id_grupo:1
	};		

	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'regional',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_regional',
		id_grupo:1
	};
	
	vectorAtributos[17]={
		validacion:{
			labelSeparator:'',
			name: 'programa',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_programa',
		id_grupo:1
	};
		
	vectorAtributos[18]={		
		validacion:{
			labelSeparator:'',
			name: 'proyecto',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_proyecto',
		id_grupo:1
	};
		
	vectorAtributos[19]={
		validacion:{
			labelSeparator:'',
			name: 'actividad',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_actividad',
		id_grupo:1
	};
		
	vectorAtributos[20]={
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_tipo',
		id_grupo:1
	};
		
	vectorAtributos[21]={
		validacion:{
			labelSeparator:'',
			name: 'subtipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_subtipo',
		id_grupo:1
	};
	
	vectorAtributos[22]={
		validacion:{
			labelSeparator:'',
			name: 'uni_org',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_uni_org',
		id_grupo:1
	};
	
	vectorAtributos[23]={
		validacion:{
			labelSeparator:'',
			name: 'estado_func',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_estado_funcional',
		id_grupo:1
	};
	
	vectorAtributos[24]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Unidad AF',
			allowBlank:false,
			emptyText:'Unidad Activos Fijos...',
			desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			onSelect: function(record){componentes[24].setValue(record.data.id_depto)	; componentes[65].setValue(record.data.nombre_depto); componentes[24].collapse(); },
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:220,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:300,
			disabled:false,
			grid_indice:19				
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filtro_1:true,
		filterColValue:'depto.nombre_depto',
		save_as:'txt_departamento_activos',
		id_grupo:0	
	};
	
	vectorAtributos[25] ={
		validacion:{
			name:'fecha_depre_ini',
			fieldLabel:'Fecha Inicio',
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
		id_grupo:3,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_deprec1'
	};
		
	////////// txt fecha_fin//////
	vectorAtributos[26]={
		validacion:{
			name:'fecha_depre_fin',
			fieldLabel:'Fecha Fin',
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
		id_grupo:3,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:"",
		save_as:'txt_fecha_deprec2'
	};

    vectorAtributos[27]={
		validacion:{
			name: 'estructura',
			fieldLabel: 'Estructura Programática',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){							
				if(this.getValue()){
					CM_mostrarGrupo('Estructura Programática');
					NoBlancosGrupo(1);								
				}else{
					CM_ocultarGrupo('Estructura Programática');
					SiBlancosGrupo(1);			
				}	   
			},		
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_ep',
		id_grupo:0
	};
	    
	vectorAtributos[28]={
		validacion:{
			name: 'chk_fecha_compra',
			fieldLabel: 'Fecha de Compra',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){	
				if(this.getValue()){
					CM_mostrarGrupo('Ingresar Rango Fecha de Compra');
					NoBlancosGrupo(2);
					if(componentes[29].getValue()){
						componentes[31].enable();
					}
				}else{
					CM_ocultarGrupo('Ingresar Rango Fecha de Compra');
					SiBlancosGrupo(2);
					componentes[31].disable();
					componentes[31].setValue('');
				}	   
			},		
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_fecha_compra',
		id_grupo:0
	};
		
	vectorAtributos[29]={
		validacion:{
			name: 'chk_fecha_deprec',
			fieldLabel: 'Fecha Inicio Depreciacion',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){							
				if(this.getValue()){
					CM_mostrarGrupo('Ingresar Rango Fecha de Inicio Depreciacion');
					NoBlancosGrupo(3);
					if(componentes[28].getValue()){
					  componentes[31].enable();
					}
				}else{
					CM_ocultarGrupo('Ingresar Rango Fecha de Inicio Depreciacion');
					SiBlancosGrupo(3);
					componentes[31].disable();
					componentes[31].setValue('');
				}   
			},		
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_fecha_deprec',
		id_grupo:0
	};
		
	vectorAtributos[30]={
		validacion:{
			name: 'chk_kbeceras',
			fieldLabel: 'Seleccionar Cabeceras',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			disabled:true,
			onClick: function(record){							
				if(this.getValue()){
					CM_mostrarGrupo('Cabeceras a Mostrar 1');
					CM_mostrarGrupo('Cabeceras a Mostrar 2');
					CM_mostrarGrupo('Cabeceras a Mostrar 3');
				}else{
					CM_ocultarGrupo('Cabeceras a Mostrar 1');
					CM_ocultarGrupo('Cabeceras a Mostrar 2');
					CM_ocultarGrupo('Cabeceras a Mostrar 3');
				}	   
			},
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_kbeceras',
		id_grupo:0
	};
		
	vectorAtributos[31]={
		validacion:{
			name:'condicion',
			fieldLabel:'Condicion Fechas',
			emptyText:'Condicion...',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['and','Fecha Compra Y Fecha Ini Deprec'],['or','Fecha Compra O Fecha Ini Deprec']]}),
			lazyRender:true,
			valueField:'id',
			displayField:'valor',
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			width:'50%',
			disabled: true
		},
		tipo:'ComboBox',
		save_as:'txt_cmb_condicion',
		id_grupo:0
	};
		
	vectorAtributos[32]={
		validacion:{
			name:'nombre_descripcion',
			fieldLabel:'Nombre/Descrip',
			emptyText:'Nombre/Descrip...',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Ambos'],['1','Nombre'],['2','Descripcion']]}),							
			lazyRender:true,
			valueField:'id',
			displayField:'valor',
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			disabled : true,
			width:150
		},
		tipo:'ComboBox',
		save_as:'txt_nombre_descripcion',
		id_grupo:0
	};
	    
	vectorAtributos[33]={
		validacion:{
			name:'tipo reporte',
			fieldLabel:'Tipo de Reporte',
			emptyText:'Tipo de Reporte...',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','XLS'],['1','PDF']]}),
			onSelect: function(record){
				ClaseMadre_getComponente('tipo reporte').setValue(record.data.id);
			    ClaseMadre_getComponente('tipo reporte').collapse();
			    if(record.data.id == 0){
			    	componentes[30].enable(); 
			    	componentes[32].disable();
			    }else{
			    	componentes[30].setValue(false);
			    	componentes[30].disable();					    		   
			    	componentes[32].enable(); 
			    	CM_ocultarGrupo('Cabeceras a Mostrar 1');
			    	CM_ocultarGrupo('Cabeceras a Mostrar 2');
			    	CM_ocultarGrupo('Cabeceras a Mostrar 3'); 
			    }  
			},		
			lazyRender:true,
			valueField:'id',
			displayField:'valor',
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:50,
			width:150
		},
		tipo:'ComboBox',
		save_as:'txt_criterio_reporte',
		id_grupo:0
	};
	    
	vectorAtributos[34]={
		 validacion:{
			name: 'chk_todos_1',
			fieldLabel: 'Todos',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){							
				if(this.getValue()){
					for(i = 35 ; i< 47; i++ ){
						componentes[i].setValue(true);
					}			
				}else{
					for(i = 35 ; i< 47; i++ ){
						if(i!=35)
						 componentes[i].setValue(false);
					}										
				}   
			},	
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_todos_1',
		id_grupo:4
	};
	    
    valor = 34;
    var intervalo = 0;
    
    for(i = 0; i< 12 ; i++){
		 valor++;
		 var tikeado = false;
		 if((i>=1 && i<=2) || (i>=5 && i<=9)){
			 tikeado = true;	    		 
		 }
    	 
       if(valor==35){
    	   vectorAtributos[valor]={
    			 validacion:{
 					name: 'chk_cabecera_1_'+i,
 					fieldLabel: cabecera_1[i][0],
 					value:cabecera_1[i][1],
 					allowBlank: true,
 					disabled:true,
 					checked: true,
 					width:20 // ancho de columna en el gris
 				},
 				tipo: 'Checkbox',
 				save_as:'txt_chk_cabecera_'+intervalo,
 				id_grupo:4
			};
		}else{
			vectorAtributos[valor]={
    			 validacion:{
 					name: 'chk_cabecera_1_'+i,
 					fieldLabel: cabecera_1[i][0],
 					value:cabecera_1[i][1],
 					allowBlank: true,		 					
 					width:20, // ancho de columna en el gris
 					checked: tikeado,
 					onClick: function(record){							
						if(this.getValue()){				
						}else{
							componentes[34].setValue(false);									
						}   
					}
 				},
 				tipo: 'Checkbox',
 				save_as:'txt_chk_cabecera_'+intervalo,
 				id_grupo:4
			};
		}
    	intervalo++;
    }
	    	
    vectorAtributos[47]={
		 validacion:{
			name: 'chk_todos_2',
			fieldLabel: 'Todos',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){							
				if(this.getValue()){
					for(i = 48 ; i< 57; i++ ){
						componentes[i].setValue(true);
					}					
				}else{
					for(i = 48 ; i< 57; i++ ){
						componentes[i].setValue(false);
					}										
				}	   
			},	
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_todos_2',
		id_grupo:5
	};
		
	valor = 47;
	
	for(i = 0; i< 9 ; i++){
    	 valor++;
    	 var tikeado = false;
    	 if(i == 2){
    		 tikeado = true;	    		 
    	 }
    	 vectorAtributos[valor]={
			 validacion:{
				name: 'chk_cabecera_2_'+i,
				fieldLabel: cabecera_2[i][0],
				allowBlank: true,
				value:cabecera_2[i][1],
				width:20, // ancho de columna en el gris
				checked:tikeado,
				onClick: function(record){							
					if(this.getValue()){					
					}else{
					       componentes[46].setValue(false);									
					}   
				}
			},
			tipo: 'Checkbox',
			save_as:'txt_chk_cabecera_'+intervalo,
			id_grupo:5
		};
    	intervalo++; 
    }
	    	
	vectorAtributos[57]={
		 validacion:{
			name: 'chk_todos_3',
			fieldLabel: 'Todos',
			allowBlank: true,
			width:20, // ancho de columna en el gris
			onClick: function(record){							
				if(this.getValue()){
					for(i = 58 ; i< 70; i++ ){
						componentes[i].setValue(true);
					}				
				}else{
					for(i = 58 ; i< 70; i++ ){
						componentes[i].setValue(false);
					}										
				}	   
			},	
		},
		tipo: 'Checkbox',
		save_as:'txt_chk_todos_3',
		id_grupo:6
	};
	    
    valor = 57;
    for(i = 0; i< 12; i++){
    	 valor++;
    	 var tikeado = false;
    	 if(i == 0 || i == 2){
    		 tikeado = true;	    		 
    	 }
    	 vectorAtributos[valor]={
			 validacion:{
				name: 'chk_cabecera_3_'+i,
				fieldLabel: cabecera_3[i][0],
				allowBlank: true,
				value:cabecera_3[i][1],
				width:20, // ancho de columna en el gris
				checked: tikeado,
				onClick: function(record){							
					if(this.getValue()){			
					}else{
						componentes[57].setValue(false);									
					}	   
				}
			},
			tipo: 'Checkbox',
			save_as:'txt_chk_cabecera_'+intervalo,
			id_grupo:6
		};
    	intervalo++;
    }
	
    vectorAtributos[70]={
		validacion:{
			labelSeparator:'',
			name: 'depto_af',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_depto_af',
		id_grupo:1
	};    
  
    vectorAtributos[71]={
		validacion:{
			labelSeparator:'',
			name: 'ubicacion_af',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_ubicacion',
		id_grupo:1
	};   
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}','</div>');
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	
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
	function obtenerTitulo(){		
		var titulo = "Reporte Detalle Activo Fijo";
		return titulo;
	}	
	
	//datos necesarios para el filtro
	var paramFunciones = {		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		labelWidth :100,
		height:'70%',
		url:direccion+'../../../../control/_reportes/activo_fijo_detalle/ActionReporteDetalleActivoFijo.php',
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,		
		fileUpload:false,
		width:'60%',
		columnas:[450,350,175,175,175],		
		minWidth:150, minHeight:200, closable:true, titulo:'Reporte Detalle Activo Fijo',
		grupos:[
			{
				tituloGrupo:'Ingreso de filtros para el reporte',
				columna:0,
				id_grupo:0
			},    
			{
				tituloGrupo:'Estructura Programática',
				columna:1,
				id_grupo:1
			},			
			{
				tituloGrupo:'Ingresar Rango Fecha de Compra',
				columna:1,
				id_grupo:2
			},
			{
				tituloGrupo:'Ingresar Rango Fecha de Inicio Depreciacion',
				columna:1,
				id_grupo:3
			},
			{
				tituloGrupo:'Cabeceras a Mostrar 1',
				columna:2,
				id_grupo:4
			},
			{
				tituloGrupo:'Cabeceras a Mostrar 2',
				columna:3,
				id_grupo:5
			},
			{
				tituloGrupo:'Cabeceras a Mostrar 3',
				columna:4,
				id_grupo:6
			}
			]
		}	
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){				
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
				
		for(var i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
		
		CM_ocultarGrupo('Ingresar Rango Fecha de Inicio Depreciacion');
		CM_ocultarGrupo('Ingresar Rango Fecha de Compra');
		CM_ocultarGrupo('Estructura Programática');
		CM_ocultarGrupo('Cabeceras a Mostrar 1');
		CM_ocultarGrupo('Cabeceras a Mostrar 2');
		CM_ocultarGrupo('Cabeceras a Mostrar 3');
	
		SiBlancosGrupo(1);
		SiBlancosGrupo(2);
		SiBlancosGrupo(3);
	}
	
	function onFinanciadorSelect(com,rec,ind){
		var id = combo_financiador.getValue()
		combo_regional.filterValues[0] =  id;
		combo_regional.modificado = true;
		combo_programa.filterValues[0] =  id;
		combo_programa.modificado = true;
		combo_proyecto.filterValues[0] =  id;
		combo_proyecto.modificado = true;
		combo_actividad.filterValues[0] =  id;
		combo_actividad.modificado = true;
		
		if(id=='%'){
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
		}else{
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

	function onRegionalSelect(com,rec,ind){
		var id = combo_regional.getValue()
		combo_programa.filterValues[1] =  id;
		combo_programa.modificado = true;
		combo_proyecto.filterValues[1] =  id;
		combo_proyecto.modificado = true;
		combo_actividad.filterValues[1] =  id;
		combo_actividad.modificado = true;
		
		if(id=='%'){
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
		}else{
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
	
	function onProgramaSelect(com,rec,ind){
		var id = combo_programa.getValue()
		combo_proyecto.filterValues[2] =  id;
		combo_proyecto.modificado = true;
		combo_actividad.filterValues[2] =  id;
		combo_actividad.modificado = true;
		
		if(id=='%'){
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
		}else{
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
	
	function onProyectoSelect(com,rec,ind){
		var id = combo_proyecto.getValue()
		combo_actividad.filterValues[3] =  id;
		combo_actividad.modificado = true;
		
		if(id=='%'){
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todas las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	
		}else{
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = '';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	
		}			
	}
	
	function onActividadSelect(com,rec,ind){
		var id = combo_actividad.getValue()			
	}
	
	function onTipoSelect(com,rec,ind){		
		var id = combo_tipo.getValue()			
		combo_sub_tipo.filterValues[5] =  id;
		combo_sub_tipo.modificado = true;
					
		if(id=='%'){
			//Carga el valor por defecto del proyecto
			var  params5 = new Array();
			params5['id_sub_tipo_activo'] = '%';
			params5['descripcion'] = 'Todos los Subtipos de Activos';			
			var aux5 = new Ext.data.Record(params5,'%');
			combo_sub_tipo.store.add(aux5)
			combo_sub_tipo.setValue('%');				
		}else{
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