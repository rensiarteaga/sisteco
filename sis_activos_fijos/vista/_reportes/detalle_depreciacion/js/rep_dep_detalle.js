/**
 * Nombre:		  	    rep_dep_detalle.js
 * Propósito: 			Generar reportes de acuerdo a la depreciacion de un activo
 * Autor:				Marcos A. Flores Valda
 * Fecha creación:		12/01/2010
 */

function ReporteDepreciacion(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var Atributos=new Array;
	var componentes= new Array();	
	var desc_larga;	
		
	 ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/financiador/ActionListaFinanciadorDepto.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'
	
		}, ['id_financiador','nombre_financiador'])	
	})
	
	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/regional/ActionListaRegionalDepto.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'	
		}, ['id_regional','nombre_regional'])//,
	})
	
	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/programa/ActionListaProgramaDepto.php?origen=filtro'}),
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
	
	ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/activo_fijo/ActionListaActivoFijo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'	
		}, ['id_activo_fijo','codigo','descripcion','descripcion_larga','vida_util_original','monto_compra','fecha_ini_dep'])	
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
		id_grupo:1,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
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
		id_grupo:1,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_hasta'
	};

	vectorAtributos[2] = {
			validacion:{
				fieldLabel: 'Financiador',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Financiador...',
				name: 'id_financiador',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_financiador', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_financiador,
				onSelect: function(record)
				{
					componentes[2].setValue(record.data.id_financiador); 
					componentes[10].setValue(record.data.nombre_financiador); 
					componentes[2].collapse(); 					
					
					var id = componentes[2].getValue()
					componentes[3].filterValues[0] =  id;
					componentes[3].modificado = true;
					componentes[4].filterValues[0] =  id;
					componentes[4].modificado = true;
					componentes[5].filterValues[0] =  id;
					componentes[5].modificado = true;
					componentes[6].filterValues[0] =  id;
					componentes[6].modificado = true;
								
					if(id=='%')
					{
						//Carga el valor por defecto de la regional
						var  params0 = new Array();
						params0['id_regional'] = '%';
						params0['nombre_regional'] = 'Todos las Regionales';
						var aux0 = new Ext.data.Record(params0,'%');
						componentes[3].store.add(aux0)
						componentes[3].setValue('%');
						///////			
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = 'Todos los Programas';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[4].store.add(aux1)
						componentes[4].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');
										
					}
					else
					{
						componentes[10].setValue(record.data.nombre_financiador); 
						
						//Carga el valor por defecto de la regional
						var  params0 = new Array();
						params0['id_regional'] = '%';
						params0['nombre_regional'] = '';
						var aux0 = new Ext.data.Record(params0,'%');
						componentes[3].store.add(aux0)
						componentes[3].setValue('%');
						///////			
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[4].store.add(aux1)
						componentes[4].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');
					}
				},
				valueField: 'id_financiador',
				displayField: 'nombre_financiador',
				queryParam: 'filterValue_0',
				filterCol:'nombre_financiador',
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
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_financiador',
			tipo: 'ComboBox'
		};

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
				onSelect: function(record)
				{
					componentes[3].setValue(record.data.id_regional); 
					componentes[11].setValue(record.data.nombre_regional); 
					componentes[3].collapse(); 
					
					var id = componentes[3].getValue()
					componentes[4].filterValues[1] =  id;
					componentes[4].modificado = true;
					componentes[5].filterValues[1] =  id;
					componentes[5].modificado = true;
					componentes[6].filterValues[1] =  id;
					componentes[6].modificado = true;
					
					if(id=='%')
					{
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = 'Todos los Programas';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[4].store.add(aux1)
						componentes[4].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}
					else
					{
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[4].store.add(aux1)
						componentes[4].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}	
				},
				valueField: 'id_regional',
				displayField: 'nombre_regional',
				queryParam: 'filterValue_0',
				filterCol:'nombre_regional',
				filterCols:filterCols_regional,
				filterValues:filterValues_regional,
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
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_regional',
			tipo: 'ComboBox'
		};

		filterCols_programa= new Array();
		filterValues_programa= new Array();
		filterCols_programa[0] = 'frppa.id_financiador';
		filterValues_programa[0] = '%';
		filterCols_programa[1] = 'frppa.id_regional';
		filterValues_programa[1] = '%';

		vectorAtributos[4]= {
			validacion:{
				fieldLabel: 'Programa',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Programa...',
				name: 'id_programa',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_programa', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_programa,
				onSelect: function(record)
				{
					componentes[4].setValue(record.data.id_programa); 
					componentes[12].setValue(record.data.nombre_programa); 
					componentes[4].collapse(); 
					
					var id = componentes[4].getValue()
					componentes[5].filterValues[2] =  id;
					componentes[5].modificado = true;
					componentes[6].filterValues[2] =  id;
					componentes[6].modificado = true;
					
					if(id=='%')
					{
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}
					else
					{
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[5].store.add(aux2)
						componentes[5].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}
				},
				valueField: 'id_programa',
				displayField: 'nombre_programa',
				queryParam: 'filterValue_0',
				filterCol:'nombre_programa',
				filterCols:filterCols_programa,
				filterValues:filterValues_programa,
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
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_programa',
			tipo: 'ComboBox'
		};
		
		filterCols_proyecto= new Array();
		filterValues_proyecto= new Array();
		filterCols_proyecto[0] = 'frppa.id_financiador';
		filterValues_proyecto[0] = '%';
		filterCols_proyecto[1] = 'frppa.id_regional';
		filterValues_proyecto[1] = '%';
		filterCols_proyecto[2] = 'PGPYAC.id_programa';
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
				onSelect: function(record)
				{
					componentes[5].setValue(record.data.id_proyecto); 
					componentes[13].setValue(record.data.nombre_proyecto); 
					componentes[5].collapse(); 
					
					var id = componentes[5].getValue()					
					componentes[6].filterValues[2] =  id;
					componentes[6].modificado = true;
					
					if(id=='%')
					{						
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}
					else
					{									
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[6].store.add(aux3)
						componentes[6].setValue('%');	
					}
				},
				valueField: 'id_proyecto',
				displayField: 'nombre_proyecto',
				queryParam: 'filterValue_0',
				filterCol:'nombre_proyecto',
				filterCols:filterCols_proyecto,
				filterValues:filterValues_proyecto,
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
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_proyecto',
			tipo: 'ComboBox'
		};
		
		filterCols_actividad= new Array();
		filterValues_actividad= new Array();
		filterCols_actividad[0] = 'frppa.id_financiador';
		filterValues_actividad[0] = '%';
		filterCols_actividad[1] = 'frppa.id_regional';
		filterValues_actividad[1] = '%';
		filterCols_actividad[2] = 'PGPYAC.id_programa';
		filterValues_actividad[2] = '%';
		filterCols_actividad[3] = 'PGPYAC.id_proyecto';
		filterValues_actividad[3] = '%';

		vectorAtributos[6] = {
			validacion:{
				fieldLabel: 'Actividad',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Actividad...',
				name: 'id_actividad',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre_actividad', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_actividad,
				onSelect: function(record)
				{
					componentes[6].setValue(record.data.id_actividad); 
					componentes[14].setValue(record.data.nombre_actividad); 
					componentes[6].collapse();
				},
				valueField: 'id_actividad',
				displayField: 'nombre_actividad',
				queryParam: 'filterValue_0',
				filterCol:'nombre_actividad',
				filterCols:filterCols_actividad,
				filterValues:filterValues_actividad,
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
				editable : true
			},
			id_grupo:0,
			save_as:'txt_id_actividad',
			tipo: 'ComboBox'
		};
				
		vectorAtributos[7] = {
			validacion:{
				fieldLabel: 'Tipo Activo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Tipo Activo...',
				name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_tipo,
				onSelect: function(record)
				{
					componentes[7].setValue(record.data.id_tipo_activo); 
					componentes[15].setValue(record.data.descripcion); 
					componentes[7].collapse(); 
					
					var id = componentes[7].getValue();
					componentes[8].filterValues[0] =  id;
					componentes[8].modificado = true;
					componentes[9].filterValues[0] =  id;
					componentes[9].modificado = true;
									
					if(id=='%')
					{	
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_sub_tipo_activo'] = '%';
						params1['descripcion'] = 'Todos los Subtipos de Activos';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[8].store.add(aux1)
						componentes[8].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = 'Todos los Activos Fijos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[9].store.add(aux2)
						componentes[9].setValue('%');
					}
					
					else
					{
						//Carga el valor por defecto del proyecto
						var  params1 = new Array();
						params1['id_sub_tipo_activo'] = '%';
						params1['descripcion'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[8].store.add(aux1)
						componentes[8].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[9].store.add(aux2)
						componentes[9].setValue('%');	
					}					
				},
				valueField: 'id_tipo_activo',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'tipo.descripcion',
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
				editable : true
			},
			id_grupo:1,
			save_as:'txt_id_tipo_activo',
			tipo: 'ComboBox'
		};
		
		filterCols_sub_tipo = new Array();
		filterValues_sub_tipo = new Array();
		filterCols_sub_tipo[0] = 'sub.id_tipo_activo';
		filterValues_sub_tipo[0] = '%';
		vectorAtributos[8] = {
			validacion:{
				fieldLabel: 'Subtipo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Subtipo Activo...',
				name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
				store:ds_sub_tipo,
				onSelect: function(record)
				{
					componentes[8].setValue(record.data.id_sub_tipo_activo); 
					componentes[16].setValue(record.data.descripcion); 
					componentes[8].collapse();
					
					var id = componentes[8].getValue();					
					componentes[9].filterValues[0] =  id;
					componentes[9].modificado = true;
									
					if(id=='%')
					{	
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = 'Todos los Activos Fijos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[9].store.add(aux2)
						componentes[9].setValue('%');
					}
					
					else
					{			
						///////
						//Carga el valor por defecto de la actividad
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[9].store.add(aux2)
						componentes[9].setValue('%');	
					}			
				},
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
			id_grupo:1,
			save_as:'txt_id_sub_tipo_activo',
			tipo: 'ComboBox'
		};		
		
		filterCols_activo_fijo = new Array();
		filterValues_activo_fijo = new Array();
		filterCols_activo_fijo[0] = 'sub.id_tipo_activo';
		filterValues_activo_fijo[0] = '%';
		filterCols_activo_fijo[1] = 'af.id_sub_tipo_activo';
		filterValues_activo_fijo[1] = '%';		
			
		vectorAtributos[9] = {
			validacion:{
				fieldLabel: 'Activo Fijo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Activo Fijo...',
				name: 'id_activo_fijo',     //indica la columna del store principal "ds" del que proviene el id
				desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
				store:ds_activo_fijo,
				onSelect: function(record)
				{
					componentes[9].setValue(record.data.id_activo_fijo); 
					componentes[17].setValue(record.data.descripcion); 
					componentes[18].setValue(record.data.codigo);
					componentes[19].setValue(record.data.descripcion_larga);
					componentes[20].setValue(record.data.monto_compra);
					componentes[21].setValue(record.data.vida_util_original);
					componentes[22].setValue(record.data.fecha_ini_dep);					
					componentes[9].collapse(); 
				},
				valueField: 'id_activo_fijo',
				displayField: 'codigo',
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
				editable: true
			},
			id_grupo:1,
			save_as:'txt_id_activo_fijo',
			tipo: 'ComboBox'
		};
		
	vectorAtributos[10] = {
		validacion:{
			labelSeparator:'',
			name: 'financiador',
			inputType:'hidden'
		},
		tipo: 'Field',
		save_as:'txt_financiador'
	};		

	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name: 'regional',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_regional'
	};
	
	vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'programa',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_programa'
	};
		
	vectorAtributos[13]={		
		validacion:{
			labelSeparator:'',
			name: 'proyecto',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_proyecto'
	};
		
	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name: 'actividad',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_actividad'
	};
		
	vectorAtributos[15]={
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_tipo'
	};
		
	vectorAtributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'subtipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_subtipo'
	};
		
	vectorAtributos[17]={
		validacion:{
			labelSeparator:'',
			name: 'descripcion',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_descripcion'
	};
	
	vectorAtributos[18]={
			validacion:{
				labelSeparator:'',
				name: 'codigo',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_codigo'
		};
	
	vectorAtributos[19]={
			validacion:{
				labelSeparator:'',
				name: 'descripcion_larga',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_descripcion_larga'
		};
	
	vectorAtributos[20]={
			validacion:{
				labelSeparator:'',
				name: 'monto_compra',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_monto_compra'
		};
	
	vectorAtributos[21]={
			validacion:{
				labelSeparator:'',
				name: 'vida_util_original',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_vida_util_original'
		};
	
	vectorAtributos[22]={
			validacion:{
				labelSeparator:'',
				name: 'fecha_ini_dep',
				inputType:'hidden'
			},
			tipo:'Field',			
			save_as:'txt_fecha_ini_dep'
		};	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){ return value ? value.dateFormat('d/m/Y') : '';	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={titulo_maestro:'Reporte Detalle Depreciacion'};
	
	layout_reporte_detalle_dep=new DocsLayoutProceso(idContenedor);
	layout_reporte_detalle_dep.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_reporte_detalle_dep,idContenedor);
	
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
		var titulo = "Reporte Detalle Depreciación";
		return titulo;
	}	
	
	//datos necesarios para el filtro
	var paramFunciones = {		
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/detalle_depreciacion/ActionPDFDetalleDepreciacion.php',
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,		
		fileUpload:false,
		width:'60%',
		columnas:[350,350],		
		minWidth:150, minHeight:200, closable:true, titulo:'Reporte Depreciación',
		
		grupos:[
			{
				tituloGrupo:'Estructura Programática',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Activos Fijos',
				columna:1,
				id_grupo:1
			}]
		}	
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	
	function iniciarEventosFormularios()
	{				
//		combo_financiador = ClaseMadre_getComponente('id_financiador');
//		combo_regional = ClaseMadre_getComponente('id_regional');
//		combo_programa = ClaseMadre_getComponente('id_programa');
//		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
//		combo_actividad = ClaseMadre_getComponente('id_actividad');
//		combo_tipo = ClaseMadre_getComponente('id_tipo_activo');
//		combo_sub_tipo = ClaseMadre_getComponente('id_sub_tipo_activo');	
//										
//						
//		combo_financiador.on('select', onFinanciadorSelect);
//		combo_financiador.on('change', onFinanciadorSelect);
//		combo_regional.on('select', onRegionalSelect);
//		combo_regional.on('change', onRegionalSelect);
//		combo_programa.on('select', onProgramaSelect);
//		combo_programa.on('change', onProgramaSelect);
			
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
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

/*
	function entityToHtml(txt_descripcion_larga) {
		for (var i in entity_table) {
			if (i != 193) 
			{
				txt_descripcion_larga = txt_descripcion_larga.replace(new RegExp(entity_table[i], "g"), String.fromCharCode(i));
			}
		}
		txt_descripcion_larga = txt_descripcion_larga.replace(new RegExp("&#(x?)(\\d+);", "g"), String.fromCharCode(((p1 == 'x') ? parseInt(p2, 16) : p2)));
		txt_descripcion_larga = txt_descripcion_larga.replace(new RegExp(entity_table[38], "g"), String.fromCharCode(38));
		return txt_descripcion_larga;
	}
	
	var entity_table = {
	  //	34: "&quot;",		// Quotation mark. Not required
	  38: "&amp;",		// Ampersand. Applied before everything else in the application
	  60: "&lt;",		// Less-than sign
	  62: "&gt;",		// Greater-than sign
	  //	63: "&#63;",		// Question mark
	  //	111: "&#111;",		// Latin small letter o
	  160: "&nbsp;",		// Non-breaking space
	  161: "&iexcl;",		// Inverted exclamation mark
	  162: "&cent;",		// Cent sign
	  163: "&pound;",		// Pound sign
	  164: "&curren;",	// Currency sign
	  165: "&yen;",		// Yen sign
	  166: "&brvbar;",	// Broken vertical bar
	  167: "&sect;",		// Section sign
	  168: "&uml;",		// Diaeresis
	  169: "&copy;",		// Copyright sign
	  170: "&ordf;",		// Feminine ordinal indicator
	  171: "&laquo;",		// Left-pointing double angle quotation mark
	  172: "&not;",		// Not sign
	  173: "&shy;",		// Soft hyphen
	  174: "&reg;",		// Registered sign
	  175: "&macr;",		// Macron
	  176: "&deg;",		// Degree sign
	  177: "&plusmn;",	// Plus-minus sign
	  178: "&sup2;",		// Superscript two
	  179: "&sup3;",		// Superscript three
	  180: "&acute;",		// Acute accent
	  181: "&micro;",		// Micro sign
	  182: "&para;",		// Pilcrow sign
	  183: "&middot;",	// Middle dot
	  184: "&cedil;",		// Cedilla
	  185: "&sup1;",		// Superscript one
	  186: "&ordm;",		// Masculine ordinal indicator
	  187: "&raquo;",		// Right-pointing double angle quotation mark
	  188: "&frac14;",	// Vulgar fraction one-quarter
	  189: "&frac12;",	// Vulgar fraction one-half
	  190: "&frac34;",	// Vulgar fraction three-quarters
	  191: "&iquest;",	// Inverted question mark
	  192: "&Agrave;",	// A with grave
	  193: "&Aacute;",	// A with acute
	  194: "&Acirc;",		// A with circumflex
	  195: "&Atilde;",	// A with tilde
	  196: "&Auml;",		// A with diaeresis
	  197: "&Aring;",		// A with ring above
	  198: "&AElig;",		// AE
	  199: "&Ccedil;",	// C with cedilla
	  200: "&Egrave;",	// E with grave
	  201: "&Eacute;",	// E with acute
	  202: "&Ecirc;",		// E with circumflex
	  203: "&Euml;",		// E with diaeresis
	  204: "&Igrave;",	// I with grave
	  205: "&Iacute;",	// I with acute
	  206: "&Icirc;",		// I with circumflex
	  207: "&Iuml;",		// I with diaeresis
	  208: "&ETH;",		// Eth
	  209: "&Ntilde;",	// N with tilde
	  210: "&Ograve;",	// O with grave
	  211: "&Oacute;",	// O with acute
	  212: "&Ocirc;",		// O with circumflex
	  213: "&Otilde;",	// O with tilde
	  214: "&Ouml;",		// O with diaeresis
	  215: "&times;",		// Multiplication sign
	  216: "&Oslash;",	// O with stroke
	  217: "&Ugrave;",	// U with grave
	  218: "&Uacute;",	// U with acute
	  219: "&Ucirc;",		// U with circumflex
	  220: "&Uuml;",		// U with diaeresis
	  221: "&Yacute;",	// Y with acute
	  222: "&THORN;",		// Thorn
	  223: "&szlig;",		// Sharp s. Also known as ess-zed
	  224: "&agrave;",	// a with grave
	  225: "&aacute;",	// a with acute
	  226: "&acirc;",		// a with circumflex
	  227: "&atilde;",	// a with tilde
	  228: "&auml;",		// a with diaeresis
	  229: "&aring;",		// a with ring above
	  230: "&aelig;",		// ae. Also known as ligature ae
	  231: "&ccedil;",	// c with cedilla
	  232: "&egrave;",	// e with grave
	  233: "&eacute;",	// e with acute
	  234: "&ecirc;",		// e with circumflex
	  235: "&euml;",		// e with diaeresis
	  236: "&igrave;",	// i with grave
	  237: "&iacute;",	// i with acute
	  238: "&icirc;",		// i with circumflex
	  239: "&iuml;",		// i with diaeresis
	  240: "&eth;",		// eth
	  241: "&ntilde;",	// n with tilde
	  242: "&ograve;",	// o with grave
	  243: "&oacute;",	// o with acute
	  244: "&ocirc;",		// o with circumflex
	  245: "&otilde;",	// o with tilde
	  246: "&ouml;",		// o with diaeresis
	  247: "&divide;",	// Division sign
	  248: "&oslash;",	// o with stroke. Also known as o with slash
	  249: "&ugrave;",	// u with grave
	  250: "&uacute;",	// u with acute
	  251: "&ucirc;",		// u with circumflex
	  252: "&uuml;",		// u with diaeresis
	  253: "&yacute;",	// y with acute
	  254: "&thorn;",		// thorn
	  255: "&yuml;",		// y with diaeresis
	  264: "&#264;",		// Latin capital letter C with circumflex
	  265: "&#265;",		// Latin small letter c with circumflex
	  338: "&OElig;",		// Latin capital ligature OE
	  339: "&oelig;",		// Latin small ligature oe
	  352: "&Scaron;",	// Latin capital letter S with caron
	  353: "&scaron;",	// Latin small letter s with caron
	  372: "&#372;",		// Latin capital letter W with circumflex
	  373: "&#373;",		// Latin small letter w with circumflex
	  374: "&#374;",		// Latin capital letter Y with circumflex
	  375: "&#375;",		// Latin small letter y with circumflex
	  376: "&Yuml;",		// Latin capital letter Y with diaeresis
	  402: "&fnof;",		// Latin small f with hook, function, florin
	  710: "&circ;",		// Modifier letter circumflex accent
	  732: "&tilde;",		// Small tilde
	  913: "&Alpha;",		// Alpha
	  914: "&Beta;",		// Beta
	  915: "&Gamma;",		// Gamma
	  916: "&Delta;",		// Delta
	  917: "&Epsilon;",	// Epsilon
	  918: "&Zeta;",		// Zeta
	  919: "&Eta;",		// Eta
	  920: "&Theta;",		// Theta
	  921: "&Iota;",		// Iota
	  922: "&Kappa;",		// Kappa
	  923: "&Lambda;",	// Lambda
	  924: "&Mu;",		// Mu
	  925: "&Nu;",		// Nu
	  926: "&Xi;",		// Xi
	  927: "&Omicron;",	// Omicron
	  928: "&Pi;",		// Pi
	  929: "&Rho;",		// Rho
	  931: "&Sigma;",		// Sigma
	  932: "&Tau;",		// Tau
	  933: "&Upsilon;",	// Upsilon
	  934: "&Phi;",		// Phi
	  935: "&Chi;",		// Chi
	  936: "&Psi;",		// Psi
	  937: "&Omega;",		// Omega
	  945: "&alpha;",		// alpha
	  946: "&beta;",		// beta
	  947: "&gamma;",		// gamma
	  948: "&delta;",		// delta
	  949: "&epsilon;",	// epsilon
	  950: "&zeta;",		// zeta
	  951: "&eta;",		// eta
	  952: "&theta;",		// theta
	  953: "&iota;",		// iota
	  954: "&kappa;",		// kappa
	  955: "&lambda;",	// lambda
	  956: "&mu;",		// mu
	  957: "&nu;",		// nu
	  958: "&xi;",		// xi
	  959: "&omicron;",	// omicron
	  960: "&pi;",		// pi
	  961: "&rho;",		// rho
	  962: "&sigmaf;",	// sigmaf
	  963: "&sigma;",		// sigma
	  964: "&tau;",		// tau
	  965: "&upsilon;",	// upsilon
	  966: "&phi;",		// phi
	  967: "&chi;",		// chi
	  968: "&psi;",		// psi
	  969: "&omega;",		// omega
	  977: "&thetasym;",	// Theta symbol
	  978: "&upsih;",		// Greek upsilon with hook symbol
	  982: "&piv;",		// Pi symbol
	  8194: "&ensp;",		// En space
	  8195: "&emsp;",		// Em space
	  8201: "&thinsp;",	// Thin space
	  8204: "&zwnj;",		// Zero width non-joiner
	  8205: "&zwj;",		// Zero width joiner
	  8206: "&lrm;",		// Left-to-right mark
	  8207: "&rlm;",		// Right-to-left mark
	  8211: "&ndash;",	// En dash
	  8212: "&mdash;",	// Em dash
	  8216: "&lsquo;",	// Left single quotation mark
	  8217: "&rsquo;",	// Right single quotation mark
	  8218: "&sbquo;",	// Single low-9 quotation mark
	  8220: "&ldquo;",	// Left double quotation mark
	  8221: "&rdquo;",	// Right double quotation mark
	  8222: "&bdquo;",	// Double low-9 quotation mark
	  8224: "&dagger;",	// Dagger
	  8225: "&Dagger;",	// Double dagger
	  8226: "&bull;",		// Bullet
	  8230: "&hellip;",	// Horizontal ellipsis
	  8240: "&permil;",	// Per mille sign
	  8242: "&prime;",	// Prime
	  8243: "&Prime;",	// Double Prime
	  8249: "&lsaquo;",	// Single left-pointing angle quotation
	  8250: "&rsaquo;",	// Single right-pointing angle quotation
	  8254: "&oline;",	// Overline
	  8260: "&frasl;",	// Fraction Slash
	  8364: "&euro;",		// Euro sign
	  8472: "&weierp;",	// Script capital
	  8465: "&image;",	// Blackletter capital I
	  8476: "&real;",		// Blackletter capital R
	  8482: "&trade;",	// Trade mark sign
	  8501: "&alefsym;",	// Alef symbol
	  8592: "&larr;",		// Leftward arrow
	  8593: "&uarr;",		// Upward arrow
	  8594: "&rarr;",		// Rightward arrow
	  8595: "&darr;",		// Downward arrow
	  8596: "&harr;",		// Left right arrow
	  8629: "&crarr;",	// Downward arrow with corner leftward. Also known as carriage return
	  8656: "&lArr;",		// Leftward double arrow. ISO 10646 does not say that lArr is the same as the 'is implied by' arrow but also does not have any other character for that function. So ? lArr can be used for 'is implied by' as ISOtech suggests
	  8657: "&uArr;",		// Upward double arrow
	  8658: "&rArr;",		// Rightward double arrow. ISO 10646 does not say this is the 'implies' character but does not have another character with this function so ? rArr can be used for 'implies' as ISOtech suggests
	  8659: "&dArr;",		// Downward double arrow
	  8660: "&hArr;",		// Left-right double arrow
	  // Mathematical Operators
	  8704: "&forall;",	// For all
	  8706: "&part;",		// Partial differential
	  8707: "&exist;",	// There exists
	  8709: "&empty;",	// Empty set. Also known as null set and diameter
	  8711: "&nabla;",	// Nabla. Also known as backward difference
	  8712: "&isin;",		// Element of
	  8713: "&notin;",	// Not an element of
	  8715: "&ni;",		// Contains as member
	  8719: "&prod;",		// N-ary product. Also known as product sign. Prod is not the same character as U+03A0 'greek capital letter pi' though the same glyph might be used for both
	  8721: "&sum;",		// N-ary summation. Sum is not the same character as U+03A3 'greek capital letter sigma' though the same glyph might be used for both
	  8722: "&minus;",	// Minus sign
	  8727: "&lowast;",	// Asterisk operator
	  8729: "&#8729;",	// Bullet operator
	  8730: "&radic;",	// Square root. Also known as radical sign
	  8733: "&prop;",		// Proportional to
	  8734: "&infin;",	// Infinity
	  8736: "&ang;",		// Angle
	  8743: "&and;",		// Logical and. Also known as wedge
	  8744: "&or;",		// Logical or. Also known as vee
	  8745: "&cap;",		// Intersection. Also known as cap
	  8746: "&cup;",		// Union. Also known as cup
	  8747: "&int;",		// Integral
	  8756: "&there4;",	// Therefore
	  8764: "&sim;",		// tilde operator. Also known as varies with and similar to. The tilde operator is not the same character as the tilde, U+007E, although the same glyph might be used to represent both
	  8773: "&cong;",		// Approximately equal to
	  8776: "&asymp;",	// Almost equal to. Also known as asymptotic to
	  8800: "&ne;",		// Not equal to
	  8801: "&equiv;",	// Identical to
	  8804: "&le;",		// Less-than or equal to
	  8805: "&ge;",		// Greater-than or equal to
	  8834: "&sub;",		// Subset of
	  8835: "&sup;",		// Superset of. Note that nsup, 'not a superset of, U+2283' is not covered by the Symbol font encoding and is not included.
	  8836: "&nsub;",		// Not a subset of
	  8838: "&sube;",		// Subset of or equal to
	  8839: "&supe;",		// Superset of or equal to
	  8853: "&oplus;",	// Circled plus. Also known as direct sum
	  8855: "&otimes;",	// Circled times. Also known as vector product
	  8869: "&perp;",		// Up tack. Also known as orthogonal to and perpendicular
	  8901: "&sdot;",		// Dot operator. The dot operator is not the same character as U+00B7 middle dot
	  // Miscellaneous Technical
	  8968: "&lceil;",	// Left ceiling. Also known as an APL upstile
	  8969: "&rceil;",	// Right ceiling
	  8970: "&lfloor;",	// left floor. Also known as APL downstile
	  8971: "&rfloor;",	// Right floor
	  9001: "&lang;",		// Left-pointing angle bracket. Also known as bra. Lang is not the same character as U+003C 'less than'or U+2039 'single left-pointing angle quotation mark'
	  9002: "&rang;",		// Right-pointing angle bracket. Also known as ket. Rang is not the same character as U+003E 'greater than' or U+203A 'single right-pointing angle quotation mark'
	  // Geometric Shapes
	  9642: "&#9642;",	// Black small square
	  9643: "&#9643;",	// White small square
	  9674: "&loz;",		// Lozenge
	  // Miscellaneous Symbols
	  9702: "&#9702;",	// White bullet
	  9824: "&spades;",	// Black (filled) spade suit
	  9827: "&clubs;",	// Black (filled) club suit. Also known as shamrock
	  9829: "&hearts;",	// Black (filled) heart suit. Also known as shamrock
	  9830: "&diams;"   // Black (filled) diamond suit
	}
	*/