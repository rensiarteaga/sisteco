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
var elemento={pagina:new ReporteActivacioGestion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    rep_dep_detalle.js
 * Propósito: 			Generar reportes de acuerdo a la depreciacion de un activo
 * Autor:				Boris Claros Olivera
 * Fecha creación:		12/01/2010
 */

function ReporteActivacioGestion(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var Atributos=new Array;
	var componentes= new Array();	
	var desc_larga;	
		
	 ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'
	
		}, ['id_financiador','nombre_financiador'])	
	})
	
	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'	
		}, ['id_regional','nombre_regional'])//,
	})
	
	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'	
		}, ['id_programa','nombre_programa'])//,
	})
	
	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'	
		}, ['id_proyecto','nombre_proyecto'])//,
	})
	
	
	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
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
	ds_gestion = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/gestion/ActionListarGestion.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',	
			id: 'id_gestion',	
			totalRecords: 'TotalCount'
		}, ['id_gestion','gestion'])
	})
	
	vectorAtributos[0] = {
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
					componentes[0].setValue(record.data.id_financiador); 
					componentes[7].setValue(record.data.nombre_financiador); 
					componentes[0].collapse(); 					
					
					var id = componentes[0].getValue()
					componentes[1].filterValues[0] =  id;
					componentes[1].modificado = true;
					componentes[2].filterValues[0] =  id;
					componentes[2].modificado = true;
					componentes[3].filterValues[0] =  id;
					componentes[3].modificado = true;
					componentes[4].filterValues[0] =  id;
					componentes[4].modificado = true;
								
					if(id=='%')
					{
						//Carga el valor por defecto de la regional
						var  params0 = new Array();
						params0['id_regional'] = '%';
						params0['nombre_regional'] = 'Todos las Regionales';
						var aux0 = new Ext.data.Record(params0,'%');
						componentes[1].store.add(aux0)
						componentes[1].setValue('%');
						///////			
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = 'Todos los Programas';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[2].store.add(aux1)
						componentes[2].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');
										
					}
					else
					{
						//Carga el valor por defecto de la regional
						var  params0 = new Array();
						params0['id_regional'] = '%';
						params0['nombre_regional'] = '';
						var aux0 = new Ext.data.Record(params0,'%');
						componentes[1].store.add(aux0)
						componentes[1].setValue('%');
						///////			
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[2].store.add(aux1)
						componentes[2].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');
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

		vectorAtributos[1] = {
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
					componentes[1].setValue(record.data.id_regional); 
					componentes[8].setValue(record.data.nombre_regional); 
					componentes[1].collapse(); 
					
					var id = componentes[1].getValue()
					componentes[2].filterValues[1] =  id;
					componentes[2].modificado = true;
					componentes[3].filterValues[1] =  id;
					componentes[3].modificado = true;
					componentes[4].filterValues[1] =  id;
					componentes[4].modificado = true;
					
					if(id=='%')
					{
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = 'Todos los Programas';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[2].store.add(aux1)
						componentes[2].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
					}
					else
					{
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_programa'] = '%';
						params1['nombre_programa'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[2].store.add(aux1)
						componentes[2].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
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

		vectorAtributos[2]= {
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
					componentes[2].setValue(record.data.id_programa); 
					componentes[9].setValue(record.data.nombre_programa); 
					componentes[2].collapse(); 
					
					var id = componentes[2].getValue()
					componentes[3].filterValues[2] =  id;
					componentes[3].modificado = true;
					componentes[4].filterValues[2] =  id;
					componentes[4].modificado = true;
					
					if(id=='%')
					{
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = 'Todos los Proyectos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
					}
					else
					{
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_proyecto'] = '%';
						params2['nombre_proyecto'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[3].store.add(aux2)
						componentes[3].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
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

		vectorAtributos[3]= {
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
					componentes[3].setValue(record.data.id_proyecto); 
					componentes[10].setValue(record.data.nombre_proyecto); 
					componentes[3].collapse(); 
					
					var id = componentes[3].getValue()					
					componentes[4].filterValues[2] =  id;
					componentes[4].modificado = true;
					
					if(id=='%')
					{						
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = 'Todos las Actividades';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
					}
					else
					{									
						//Carga el valor por defecto de la actividad
						var  params3 = new Array();
						params3['id_actividad'] = '%';
						params3['nombre_actividad'] = '';
						var aux3 = new Ext.data.Record(params3,'%');
						componentes[4].store.add(aux3)
						componentes[4].setValue('%');	
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

		vectorAtributos[4] = {
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
					componentes[4].setValue(record.data.id_actividad); 
					componentes[11].setValue(record.data.nombre_actividad); 
					componentes[4].collapse();
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
				
		vectorAtributos[5] = {
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
					componentes[5].setValue(record.data.id_tipo_activo); 
					componentes[12].setValue(record.data.descripcion); 
					componentes[5].collapse(); 
					
					var id = componentes[5].getValue();
					componentes[6].filterValues[0] =  id;
					componentes[6].modificado = true;
					componentes[23].filterValues[0] =  id;
					componentes[23].modificado = true;
									
					if(id=='%')
					{	
						//Carga el valor por defecto del programa
						var  params1 = new Array();
						params1['id_sub_tipo_activo'] = '%';
						params1['descripcion'] = 'Todos los Subtipos de Activos';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[6].store.add(aux1)
						componentes[6].setValue('%');
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = 'Todos los Activos Fijos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[23].store.add(aux2)
						componentes[23].setValue('%');
					}
					
					else
					{
						//Carga el valor por defecto del proyecto
						var  params1 = new Array();
						params1['id_sub_tipo_activo'] = '%';
						params1['descripcion'] = '';
						var aux1 = new Ext.data.Record(params1,'%');
						componentes[6].store.add(aux1)
						componentes[6].setValue('%');			
						///////
						//Carga el valor por defecto de la actividad
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[23].store.add(aux2)
						componentes[23].setValue('%');	
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

		vectorAtributos[6] = {
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
					componentes[6].setValue(record.data.id_sub_tipo_activo); 
					componentes[13].setValue(record.data.descripcion); 
					componentes[6].collapse();
					
					var id = componentes[6].getValue();					
					componentes[23].filterValues[0] =  id;
					componentes[23].modificado = true;
									
					if(id=='%')
					{	
						///////			
						//Carga el valor por defecto del proyecto
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = 'Todos los Activos Fijos';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[23].store.add(aux2)
						componentes[23].setValue('%');
					}
					
					else
					{			
						///////
						//Carga el valor por defecto de la actividad
						var  params2 = new Array();
						params2['id_activo_fijo'] = '%';
						params2['codigo'] = '';
						var aux2 = new Ext.data.Record(params2,'%');
						componentes[23].store.add(aux2)
						componentes[23].setValue('%');	
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
	
	vectorAtributos[7] = {
		validacion:{
			labelSeparator:'',
			name: 'financiador',
			inputType:'hidden'
		},
		tipo: 'Field',
		save_as:'txt_financiador'
	};		

	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name: 'regional',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_regional'
	};
	
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'programa',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_programa'
	};
		
	vectorAtributos[10]={		
		validacion:{
			labelSeparator:'',
			name: 'proyecto',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_proyecto'
	};
		
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name: 'actividad',
			inputType:'hidden'
		},
		tipo: 'Field',			
		save_as:'txt_actividad'
	};
		
	vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_tipo'
	};
		
	vectorAtributos[13]={
		validacion:{
			labelSeparator:'',
			name: 'subtipo',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_subtipo'
	};
		
	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name: 'descripcion',
			inputType:'hidden'
		},
		tipo: 'Field',	
		save_as:'txt_descripcion'
	};
	
	vectorAtributos[15]={
			validacion:{
				labelSeparator:'',
				name: 'codigo',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_codigo'
		};
	
	vectorAtributos[16]={
			validacion:{
				labelSeparator:'',
				name: 'descripcion_larga',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_descripcion_larga'
		};
	
	vectorAtributos[17]={
			validacion:{
				labelSeparator:'',
				name: 'monto_compra',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_monto_compra'
		};
	
	vectorAtributos[18]={
			validacion:{
				labelSeparator:'',
				name: 'vida_util_original',
				inputType:'hidden'
			},
			tipo: 'Field',	
			save_as:'txt_vida_util_original'
		};
	
	vectorAtributos[19]={
			validacion:{
				labelSeparator:'',
				name: 'fecha_ini_dep',
				inputType:'hidden'
			},
			tipo:'Field',			
			save_as:'txt_fecha_ini_dep'
		};
	vectorAtributos[20]={
			validacion:{
				labelSeparator:'',
				name: 'gestion',
				inputType:'hidden'
			},
			tipo:'Field',			
			save_as:'txt_gestion'
		};
		vectorAtributos[21] = {
			validacion:{
				fieldLabel: 'Gestion',
				allowBlank: false,
				//vtype:"texto",
				emptyText:'Gestion...',
				name: 'id_gestion',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'gestion', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_gestion,
				onSelect: function(record)
				{
					componentes[21].setValue(record.data.id_gestion); 
					componentes[20].setValue(record.data.gestion); 
					componentes[21].collapse(); 
					
								
				},
				valueField: 'id_gestion',
				displayField: 'gestion',
				queryParam: 'filterValue_0',
				filterCol:'gestion',
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
			save_as:'txt_id_gestion',
			tipo: 'ComboBox'
		};
		
		//filterCols_sub_tipo = new Array();
		//filterValues_sub_tipo = new Array();
		//filterCols_sub_tipo[0] = 'sub.id_tipo_activo';
		//filterValues_sub_tipo[0] = '%';
		
		vectorAtributos[22]={
			validacion:{
				name:'formato_reporte',
				fieldLabel:'Formato Reporte',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Pdf'],['1','Excel']]}),
				onSelect: function(record)
				{	
					
					ClaseMadre_getComponente('formato_reporte').setValue(record.data.id);
				    ClaseMadre_getComponente('formato_reporte').collapse();
				           if (record.data.id==0){
								CM_mostrarGrupo('Pdf');
								CM_ocultarGrupo('Excel');
								SiBlancosGrupo(2);
								NoBlancosGrupo(1);
					
							}else{
								CM_mostrarGrupo('Excel');
								CM_ocultarGrupo('Pdf');
								SiBlancosGrupo(1);
								NoBlancosGrupo(2);
								
							}
				
				
				},
						
				valueField:'id',
				displayField:'valor',
				lazyRender:true,
				grid_visible:true,
				grid_editable:false,
				forceSelection:true,
				width_grid:50,
				width:'50%'
				
			},
			tipo:'ComboBox',
			save_as:'txt_tipo_reporte',
			id_grupo:1
			};
			
			
		vectorAtributos[23] = {
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
					componentes[23].setValue(record.data.id_activo_fijo); 
					componentes[14].setValue(record.data.descripcion); 
					componentes[15].setValue(record.data.codigo);
					componentes[16].setValue(record.data.descripcion_larga);
					componentes[17].setValue(record.data.monto_compra);
					componentes[18].setValue(record.data.vida_util_original);
					componentes[19].setValue(record.data.fecha_ini_dep);					
					componentes[23].collapse(); 
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
			
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){ return value ? value.dateFormat('d/m/Y') : '';	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={titulo_maestro:'Reporte Activacion de Activos Fijos por Gestion'};
	
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
		var titulo = "Reporte Activacion de Activos Fijos por Gestion";
		return titulo;
	}	
	
	//datos necesarios para el filtro
	var paramFunciones = {		
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/activacion_gestion/ActionPDFActivacionGestion.php',
	    //url:direccion+'../../../../control/_reportes/activo_fijo_asignacion/ActionPDFActivoFijoAsigancion.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,		
		fileUpload:false,
		width:'60%',
		columnas:[350,350],		
		minWidth:150, minHeight:200, closable:true, titulo:'Reporte Activacion de Activos Fijos por Gestion',
		
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
