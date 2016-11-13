<?php 
/**
 * Nombre:		  	    rpa_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 17:40:13
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_rpa(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);



/**
 * Nombre:		  	    pagina_rpa_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 17:40:13
 */
function pagina_rpa(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_rpa',totalRecords:'TotalCount'
		},[		
				'id_rpa',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado',
		'id_empleado_frppa',
		'desc_empleado_tpm_frppa',
		'desc_categoria_adq',
		'id_categoria_adq',
		'desc_frppa', 'desc_financiador','id_regional','id_programa','id_proyecto','id_actividad','id_financiador','desc_regional','desc_programa','desc_proyecto','desc_actividad'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
    /* estructura ep */
     ds_financiador= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'
		}, ['id_financiador','codigo_financiador','nombre_financiador','descripcion_financiador','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
	ds_regional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'
		}, ['id_regional','codigo_regional','nombre_regional','descripcion_regional','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
	
	ds_programa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'
		}, ['id_programa','codigo_programa','nombre_programa','descripcion_programa','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
	
	ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
	
	ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'
		}, ['id_actividad','codigo_actividad','nombre_actividad','descripcion_actividad','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
//	ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen/ActionListarAlmacenEP.php'}),
//		reader: new Ext.data.XmlReader({
//			record: 'ROWS',
//			id: 'id_almacen',
//			totalRecords: 'TotalCount'
//		}, ['id_almacen','nombre','descripcion'])
//		});
		
	 var ds_empleado_tpm_frppa1 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoUsuarioTpmFrppaEP.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti','desc_nombrecompleto','desc_frppa','desc_financiador','desc_regional','desc_programa','desc_proyecto','desc_actividad'])
	});	
	/* fin estructura ep*/
    var ds_empleado_tpm_frppa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti','desc_nombrecompleto','desc_frppa','desc_financiador','desc_regional','desc_programa','desc_proyecto','desc_actividad','codigo_frppa'])
	});

    var ds_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_adq/ActionListarCategoriaAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_adq',totalRecords: 'TotalCount'},['id_categoria_adq','nombre','observaciones','descripcion','fecha_reg','id_tipo_adq','precio_min','precio_max','id_moneda'])
	});

	//FUNCIONES RENDER
	function renderFinanciador(value, p, record){return String.format('{0}', record.data['nombre_financiador']);}
	function renderPrograma(value, p, record){return String.format('{0}', record.data['nombre_programa']);}
	function renderProyecto(value, p, record){return String.format('{0}', record.data['nombre_proyecto']);}
	function renderActividad(value, p, record){return String.format('{0}', record.data['nombre_actividad']);}
	function renderRegional(value, p, record){return String.format('{0}', record.data['desc_regional']);}
	
	var resultTplRegional=new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre_regional}</i></b>',
	'<br><FONT COLOR="#B5A642">{codigo_regional}</FONT>',
	'</div>'
	);
	
	var tpl_id_financiador=new Ext.Template('<div class="search-item">','<b><i>{nombre_financiador}</i></b>','<br><FONT COLOR="#B5A642">{codigo_financiador}</FONT>','</div>');
	var tpl_id_regional=new Ext.Template('<div class="search-item">','<b><i>{nombre_regional}</i></b>','<br><FONT COLOR="#B5A642">{codigo_regional}</FONT>','</div>');
	var tpl_id_programa=new Ext.Template('<div class="search-item">','<b><i>{nombre_programa}</i></b>','<br><FONT COLOR="#B5A642">{codigo_programa}</FONT>','</div>');
	var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{nombre_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{codigo_proyecto}</FONT>','</div>');
	var tpl_id_actividad=new Ext.Template('<div class="search-item">','<b><i>{nombre_actividad}</i></b>','<br><FONT COLOR="#B5A642">{codigo_actividad}</FONT>','</div>');
	
		function render_id_empleado_frppa(value, p, record){return String.format('{0}', record.data['desc_empleado_tpm_frppa']);}
		var tpl_id_empleado_frppa=new Ext.Template('<div class="search-item">','<b><i>{desc_nombrecompleto}</i></b>','<br><FONT COLOR="#B5A642">{codigo_frppa}</FONT>','</div>');

		function render_desc_frppa(value, p, record){return String.format('{0}', record.data['desc_frppa']);}
		//var tpl_id_empleado_frppa=new Ext.Template('<div class="search-item">','<b><i>{desc_nombrecompleto}</i></b>','<br><FONT COLOR="#B5A642">{desc_frppa}</FONT>','</div>');

		function render_id_categoria_adq(value, p, record){return String.format('{0}', record.data['desc_categoria_adq']);}
		var tpl_id_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_rpa
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_rpa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_rpa'
	};
/* Estructura Programatica */
	Atributos[2]={
		validacion:{
			fieldLabel:'Financiador',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Financiador...',
			name:'id_financiador',
			desc:'desc_financiador',
			store:ds_financiador,
			valueField:'id_financiador',
			displayField:'nombre_financiador',
			queryParam:'filterValue_0',
			filterCol:'nombre_financiador#codigo_financiador',
			typeAhead:true,
			forceSelection:true,
			renderer:renderFinanciador,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			tpl:tpl_id_financiador,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'txt_id_financiador',
		tipo:'ComboBox',
		id_grupo:0
	};
	filterCols_regional=new Array();
	filterValues_regional=new Array();
	filterCols_regional[0]='frppa.id_financiador';
	filterValues_regional[0]='%';
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Regional',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Regional...',
			name:'id_regional',
			desc:'desc_regional',
			store:ds_regional,
			valueField:'id_regional',
			displayField:'nombre_regional',
			queryParam:'filterValue_0',
			filterCol:'REGION.codigo_regional#REGION.nombre_regional',
			filterCols:filterCols_regional,
			filterValues:filterValues_regional,
			typeAhead:true,
			forceSelection:true,
			renderer:renderRegional,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150
		},
		
		save_as:'txt_id_regional',
		tipo:'ComboBox',
		id_grupo:0
	};
	filterCols_programa=new Array();
	filterValues_programa=new Array();
	filterCols_programa[0]='frppa.id_financiador';
	filterValues_programa[0]='%';
	filterCols_programa[1]='frppa.id_regional';
	filterValues_programa[1]='%';
	
	Atributos[4]={
		validacion:{
			fieldLabel:'Programa',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Programa...',
			name:'id_programa',
			desc:'desc_programa',
			store:ds_programa,
			valueField:'id_programa',
			displayField:'nombre_programa',
			queryParam:'filterValue_0',
			filterCol:'nombre_programa#codigo_programa',
			filterCols:filterCols_programa,
			filterValues:filterValues_programa,
			typeAhead:true,
			forceSelection:true,
			renderer:renderPrograma,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:110
		},
		
		save_as:'txt_id_programa',
		tipo:'ComboBox',
		id_grupo:0
	};
	
    filterCols_proyecto=new Array();
	filterValues_proyecto=new Array();
	filterCols_proyecto[0]='frppa.id_financiador';
	filterValues_proyecto[0]='%';
	filterCols_proyecto[1]='frppa.id_regional';
	filterValues_proyecto[1]='%';
	filterCols_proyecto[2]='PGPYAC.id_programa';
	filterValues_proyecto[2]='%';
	
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Proyecto',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Proyecto...',
			name:'id_proyecto',
			desc:'desc_proyecto',
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
			filterCol:'nombre_proyecto#codigo_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead:true,
			forceSelection:true,
			renderer:renderProyecto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:260
		},
		
		save_as:'txt_id_proyecto',
		tipo:'ComboBox',
		id_grupo:0
	};

	filterCols_actividad=new Array();
	filterValues_actividad=new Array();
	filterCols_actividad[0]='frppa.id_financiador';
	filterValues_actividad[0]='%';
	filterCols_actividad[1]='frppa.id_regional';
	filterValues_actividad[1]='%';
	filterCols_actividad[2]='PGPYAC.id_programa';
	filterValues_actividad[2]='%';
	filterCols_actividad[3]='PGPYAC.id_proyecto';
	filterValues_actividad[3]='%';
	

	Atributos[6]={
		validacion:{
			fieldLabel:'Actividad',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Actividad...',
			name:'id_actividad',
			desc:'desc_actividad',
			store:ds_actividad ,
			valueField:'id_actividad',
			displayField:'nombre_actividad',
			queryParam:'filterValue_0',
			filterCol:'nombre_actividad#codigo_actividad',
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad,
			typeAhead:true,
			forceSelection:true,
			renderer:renderActividad,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:110
		},
		
		save_as:'txt_id_actividad',
		tipo:'ComboBox',
		id_grupo:0
	};
	filterCols_empleado=new Array();
	filterValues_empleado=new Array();
	filterCols_empleado[0]='frppa.id_financiador';
	filterValues_empleado[0]='%';
	filterCols_empleado[1]='frppa.id_regional';
	filterValues_empleado[1]='%'
	filterCols_empleado[2]='PGPYAC.id_programa';
	filterValues_empleado[2]='%';
	filterCols_empleado[3]='PGPYAC.id_proyecto';
	filterValues_empleado[3]='%';
	filterCols_empleado[4]='PGPYAC.id_actividad';
	filterValues_empleado[4]='%';
/* fin estructura programática */
// txt fecha_reg
	

// txt id_empleado_frppa
	Atributos[7]={
			validacion:{
			name:'id_empleado_frppa',
			fieldLabel:'Autorizador',
			allowBlank:false,			
			emptyText:'Empleado EP...',
			desc: 'desc_empleado_tpm_frppa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_tpm_frppa,
			valueField: 'id_empleado_frppa',
			displayField: 'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			typeAhead:true,
			tpl:tpl_id_empleado_frppa,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			filterCol:'PER.nombre#PER.apellido_paterno#PER.apellido_materno',
			filterCols:filterCols_empleado,
			filterValues:filterValues_empleado,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_frppa,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP.id_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
		save_as:'txt_id_empleado_frppa'
	};
	Atributos[8]={
			validacion:{
			name:'desc_frppa',
			fieldLabel:'Estructura Programática',
			allowBlank:true,			
			emptyText:'Empleado EP...',
			desc: 'desc_nombrecompleto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_tpm_frppa1,
			//valueField: 'id_empleado_frppa',
			displayField: 'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEP.id_empleado#PERSON.nombre',
			typeAhead:true,
			//tpl:tpl_id_empleado_frppa,
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
			renderer:render_desc_frppa,
			grid_visible:true,
			grid_editable:false,
			width_grid:500,
			width:'50%',
			disable:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'txt_desc_frppa'
	};
// txt id_categoria_adq
	Atributos[1]={
			validacion:{
			name:'id_categoria_adq',
			fieldLabel:'Categoria para Autorización',
			allowBlank:false,			
			emptyText:'Categoria Adquisición...',
			desc: 'desc_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria_adq,
			valueField: 'id_categoria_adq',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'CATADQ.nombre',
			typeAhead:true,
			tpl:tpl_id_categoria_adq,
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
			renderer:render_id_categoria_adq,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disable:false,
			grid_indice:1
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.nombre',
		save_as:'txt_id_categoria_adq'
	};
	// txt estado
	Atributos[9]={
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			align:'center',
			pageSize:100,
			minListWidth:'50%',
			disabled:true,
			grid_indice:5
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'RESCON.estado',
		defecto:'activo',
		save_as:'txt_estado'
	};
	
	Atributos[10]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:6
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'RESCON.fecha_reg',
		dateFormat:'m-d-Y'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Responsable del proceso de contratación	',grid_maestro:'grid-'+idContenedor};
	var layout_rpa=new DocsLayoutMaestro(idContenedor);
	layout_rpa.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_rpa,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
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
		btnEliminar:{url:direccion+'../../../control/rpa/ActionEliminarRpa.php'},
		Save:{url:direccion+'../../../control/rpa/ActionGuardarRpa.php'},
		ConfirmSave:{url:direccion+'../../../control/rpa/ActionGuardarRpa.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'rpa'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		combo_financiador = getComponente('id_financiador');
		combo_regional = getComponente('id_regional');
		combo_programa = getComponente('id_programa');
		combo_proyecto = getComponente('id_proyecto');
		combo_actividad = getComponente('id_actividad');
		combo_empleado = getComponente('id_empleado_frppa');
	

		var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  id;
			combo_actividad.modificado = true;
			combo_empleado.filterValues[0] =  id;
			combo_empleado.modificado = true;
			
			combo_regional.setValue('');
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');
			combo_empleado.setValue('');
			var  params1 = new Array();
			params1['id_regional'] = '%';
			params1['nombre_regional'] = 'Todas las Regionales';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_regional.store.add(aux1)
			combo_regional.setValue('%');
			///////
			//Carga el valor por defecto del programa
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0)
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
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
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
			
		
		};
		
		
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
		
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			combo_empleado.filterValues[1] =  id;
			combo_empleado.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue(''); 
			combo_empleado.setValue('');
			
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0)
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
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
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
		
		};
		
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			combo_empleado.filterValues[2] =  id;
			combo_empleado.modificado = true;
			
			combo_proyecto.setValue('');
			combo_actividad.setValue('');
			combo_empleado.setValue('');
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
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
		};
		
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_empleado.filterValues[3] =  id;
			combo_empleado.modificado = true;
			combo_empleado.setValue('');
			combo_actividad.setValue('');
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');
		};

		var onActividadSelect= function(e) {
			var id = combo_actividad.getValue()
			combo_empleado.filterValues[4] =  id;
			combo_empleado.modificado = true;
			combo_empleado.setValue('');
			data_ep='id_financiador='+ getComponente('id_financiador').getValue() +	'&id_regional='+ getComponente('id_regional').getValue()  +'&id_programa='+  getComponente('id_programa').getValue() +  '&id_proyecto='+ getComponente('id_proyecto').getValue() +'&id_actividad='+ getComponente('id_actividad').getValue();
			verificar_ep();
		};
		
	
		
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
					
	}
	
	
	this.btnEdit=function(){
		CM_mostrarComponente(getComponente('estado'));
		getComponente('estado').enable();
		CM_btnEdit();
	}
	
	
	this.btnNew=function(){
		CM_ocultarComponente(getComponente('estado'));
		getComponente('estado').disable();
		CM_btnNew();
	}
	function verificar_ep(){	
		if(getComponente('id_financiador').getValue()>0 &&getComponente('id_regional').getValue()>0 &&getComponente('id_programa').getValue()>0 &&getComponente('id_proyecto').getValue()>0 &&getComponente('id_actividad').getValue()>0 )
			  combo_empleado.store.proxy = new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php?origen=filtro&id_categoria_adq='+getComponente('id_categoria_adq').getValue()+'&'+data_ep})
	}
			


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rpa.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_rpa.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}