<?php
session_start();
?>
//<script>
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
var maestro={
	id_activo_fijo:<?php echo $maestro_id_activo_fijo;?>,
	codigo:'<?php echo $maestro_codigo;?>',
	descripcion:'<?php echo $maestro_descripcion;?>',
	descripcion_larga:'<?php echo $maestro_descripcion_larga;?>',
	id_sub_tipo_activo:'<?php echo $maestro_id_sub_tipo_activo;?>',
	};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_estructura_programatica_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_sub_tipo_activo_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 11:47:22
*/
function pagina_estructura_programatica_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;

	var combo_financiador,combo_regional ,combo_programa ,combo_proyecto,combo_actividad;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds =  new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_tpm_frppa/ActionListaActivoFijoTpmFrppa.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_frppa',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_activo_fijo_frppa',
		'id_activo_fijo',
		'id_financiador',
		'nombre_financiador',
		'id_regional',
		'nombre_regional',
		'id_programa',
		'nombre_programa',
		'id_proyecto',
		'nombre_proyecto',
		'id_actividad',
		'nombre_actividad',
		'desc_epe',
		'id_unidad_organizacional',
		'desc_uo',
		'id_gestion',
		'gestion',
		'id_presupuesto',
		'estado',
		'tipo_pres',
		'tipo_ppto',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),
		remoteSort: true // metodo de ordenacion remoto
	});


	// DEFINICIÓN DATOS DEL MAESTRO




	var ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'

		}, ['id_financiador','nombre_financiador','codigo_financiador'])

	})
	var ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	})
	var ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'
		}, ['id_programa','nombre_programa'])//,
	})
	var ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','nombre_proyecto'])//,
	})
	var ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'

		}, ['id_actividad','nombre_actividad'])//,
	})
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])
	
	});
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion'])
	});
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});	
	
	
	function render_id_estructura(value, p, record){return String.format('{0}', record.data['desc_estructura']);}
	
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  <FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br> <b><FONT COLOR="#B5A642">{desc_presupuesto}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_uo']);}
	
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');

 
	////////////////FUNCIONES RENDER ////////////
	function renderFinanciador(value, p, record){return String.format('{0}', record.data['nombre_financiador']);}
	function renderRegional(value, p, record){return String.format('{0}', record.data['nombre_regional']);}
	function renderPrograma(value, p, record){return String.format('{0}', record.data['nombre_programa']);}
	function renderProyecto(value, p, record){return String.format('{0}', record.data['nombre_proyecto']);}
	function renderActividad(value, p, record){return String.format('{0}', record.data['nombre_actividad']);}
	function renderTipoPresupuesto(value, p, record){
		if(value == 1)
		{return  "Recurso"}
		if(value == 2)
		{return "Gasto"}
		if(value == 3)
		{return "Inversión"}
		if(value == 4)
		{return "PNO - Recurso"}
		if(value == 5)
		{return "PNO - Gasto"}
		if(value == 6)
		{return "PNO - Inversión"}
		
		return '';
	}


	/////////////////////////
	// Definición de datos //
	/////////////////////////


	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo_frppa',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		//filtro_0:true,
		save_as:'hidden_id_activo_fijo_frppa'
	}

	/////////// txt codigo//////
	Atributos[1] = {
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
			forceSelection :true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderFinanciador,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'FRPPA.nombre_financiador',
		save_as:'hidden_id_financiador'
	}

	var filterCols_regional = new Array();
	var filterValues_regional = new Array();
	filterCols_regional[0] = 'frppa.id_financiador';
	filterValues_regional[0] = '%';
	Atributos[2] = {
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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderRegional,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:2
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'FRPPA.nombre_regional',
		save_as:'hidden_id_regional'
	}


	var filterCols_programa= new Array();
	var filterValues_programa= new Array();
	filterCols_programa[0] = 'frppa.id_financiador';
	filterValues_programa[0] = '%';
	filterCols_programa[1] = 'frppa.id_regional';
	filterValues_programa[1] = '%';

	Atributos[3]= {
		validacion:{
			fieldLabel: 'Programa',
			allowBlank: false,
			//vtype:"texto",
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
			forceSelection :true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderPrograma,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:3
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'FRPPA.nombre_programa',
		save_as:'hidden_id_programa'
	}

	var filterCols_proyecto= new Array();
	var filterValues_proyecto= new Array();
	filterCols_proyecto[0] = 'frppa.id_financiador';
	filterValues_proyecto[0] = '%';
	filterCols_proyecto[1] = 'frppa.id_regional';
	filterValues_proyecto[1] = '%';
	filterCols_proyecto[2] = 'PGPYAC.id_programa';
	filterValues_proyecto[2] = '%';

	Atributos[4] = {
		validacion:{
			fieldLabel:'Proyecto',
			allowBlank:false,
			//vtype:"texto",
			emptyText:'Proyecto...',
			name:'id_proyecto',     //indica la columna del store principal "ds" del que proviane el id
			desc:'nombre_proyecto', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
			filterCol:'nombre_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead:true,
			forceSelection :true,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable: true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable:true,
			renderer:renderProyecto,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:4
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'FRPPA.nombre_proyecto',
		save_as:'hidden_id_proyecto'
	}


	var filterCols_actividad= new Array();
	var filterValues_actividad= new Array();
	filterCols_actividad[0] = 'frppa.id_financiador';
	filterValues_actividad[0] = '%';
	filterCols_actividad[1] = 'frppa.id_regional';
	filterValues_actividad[1] = '%';
	filterCols_actividad[2] = 'PGPYAC.id_programa';
	filterValues_actividad[2] = '%';
	filterCols_actividad[3] = 'PGPYAC.id_proyecto';
	filterValues_actividad[3] = '%';


	Atributos[5]={
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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderActividad,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:5
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'FRPPA.nombre_actividad',
		save_as:'hidden_id_actividad'
	}
	

	Atributos[6]= {
		validacion:{
			name: 'id_activo_fijo',
			//fieldLabel: 'Id Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo',
		defecto: maestro.id_activo_fijo
	};
	Atributos[7]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestion',
				allowBlank:true,
				emptyText:'Gestion...',
				desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField:'id_gestion',
				displayField:'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:false,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:6
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_gestion',
			id_grupo:0  //1
		};
	Atributos[8]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_estructura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_epe',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			renderer:render_id_estructura,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			width_grid:100,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width:'100%',
			disabled:true,
			grid_indice:7	
		},
		tipo:'ComboBox',
		form:true,
		filterColValue:'ESTPRO.desc_epe',
		filtro_0:false,
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
Atributos[9]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc:'desc_uo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			disabled:false,
			grid_indice:8,
			renderer:render_id_unidad_organizacional,
			width_grid:250	
		},
		tipo:'ComboBox',
		save_as:'id_unidad_organizacional'
	};
	
	Atributos[10]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:80,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:9		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'estado',
		save_as:'estado'
	};
	
	Atributos[11] = {
		validacion: {
			name:'tipo_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
		/*	store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.tipo_pres // from states.js
			}),*/
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150,
			grid_indice:10		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'tipo_pres',
		defecto: '1',
		form: false,
		save_as:'presup.tipo_pres',
		id_grupo:0
	};
	
	
	/*Atributos[11]={
		validacion:{
			name:'tipo_pres',
			fieldLabel:'Tipo Presupuestado',
			allowBlank:false,
			maxLength:80,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			render:renderTipoPresupuesto,
			forceSelection:true,
			disable:false,
			grid_indice:10		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'tipo_pres',
		save_as:'tipo_pres'
	};*/
// txt fecha_reg
	Atributos[12]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:11		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};
	
	
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' Activo Fijo (Maestro)',titulo_detalle:'Estructura Programatica (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_estructura_programatica = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_estructura_programatica.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_estructura_programatica,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getDialog=this.getDialog;
	var CM_enableSelect=this.EnableSelect;

	ds_financiador.addListener('loadexception',  CM_conexionFailure); //se recibe un error
	ds_regional.addListener('loadexception',  CM_conexionFailure); //se recibe un error
	ds_programa.addListener('loadexception',  CM_conexionFailure); //se recibe un error
	ds_proyecto.addListener('loadexception',  CM_conexionFailure); //se recibe un error
	ds_actividad.addListener('loadexception',  CM_conexionFailure); //se recibe un error


	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={/*guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},*/
	actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES

	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/activo_fijo_tpm_frppa/ActionEliminaActivoFijoTpmFrppa.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		Save:{url:direccion+'../../../control/activo_fijo_tpm_frppa/ActionSaveActivoFijoTpmFrppa.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		ConfirmSave:{url:direccion+'../../../control/activo_fijo_tpm_frppa/ActionSaveActivoFijoTpmFrppa.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:650,minWidth:150,minHeight:150,	closable:true,titulo:'Tipo de Servicio',
		grupos:[{
			tituloGrupo:'Datos',
			columna:0,
			id_grupo:0
		}]
		}};

		//-------------- Sobrecarga de funciones --------------------//


		
		this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
				maestro.codigo=datos.maestro_codigo;
				maestro.descripcion=datos.maestro_descripcion;
				maestro.descripcion_larga=datos.maestro_descripcion_larga;
				
				
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						hidden_id_activo_fijo:maestro.id_activo_fijo
						
					}
				};
				
				this.btnActualizar();
				iniciarEventosFormularios();

				//gridMaestro.getDataSource().removeAll();

				//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
				Atributos[6].defecto=maestro.id_activo_fijo;
				paramFunciones.btnEliminar.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
				paramFunciones.Save.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
				paramFunciones.ConfirmSave.parametros='&maestro_id_activo_fijo='+maestro.id_activo_fijo;
				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones);
		};



		this.EnableSelect = function(selModel, row, selected){
			
			
			CM_enableSelect(selModel, row, selected)
			var SelectionsRecord  = selModel.getSelected(); //es el primer registro selecionado
			
				
				//------------ parametriza los valores iniciales para la estructura programatica ------------//
				//--actualiza el id de financiador --/
				combo_regional.filterValues[0] =  SelectionsRecord.data['id_financiador'];
				combo_regional.modificado = true;
				combo_programa.filterValues[0] =  SelectionsRecord.data['id_financiador'];
				combo_programa.modificado = true;
				combo_proyecto.filterValues[0] =  SelectionsRecord.data['id_financiador'];
				combo_proyecto.modificado = true;
				combo_actividad.filterValues[0] =  SelectionsRecord.data['id_financiador'];
				combo_actividad.modificado = true;
				//--actualiza el id de regional--/
				combo_programa.filterValues[1] =  SelectionsRecord.data['id_regional'];
				combo_programa.modificado = true;
				combo_proyecto.filterValues[1] =  SelectionsRecord.data['id_regional'];
				combo_proyecto.modificado = true;
				combo_actividad.filterValues[1] =  SelectionsRecord.data['id_regional'];
				combo_actividad.modificado = true;
				//--actualiza el id de programa--/
				combo_proyecto.filterValues[2] =  SelectionsRecord.data['id_programa'];
				combo_proyecto.modificado = true;
				combo_actividad.filterValues[2] =  SelectionsRecord.data['id_programa'];
				combo_actividad.modificado = true;
				//--actualiza el id de proyecto--/
				combo_actividad.filterValues[3] =  SelectionsRecord.data['id_proyecto'];
				combo_actividad.modificado = true;
			
		}


		this.ActualizarEP = function(id){
			ds.lastOptions.params.filterValue_0=id;
			ds.lastOptions.params.hidden_id_activo_fijo=id;
			ClaseMadre_btnActualizar();
			//alert(this.getBarra().buttons)
			var boton_nuevo = this.getBoton('nuevo_ext-grid_ep')
			var boton_editar = this.getBoton('editar_ext-grid_ep')
			var boton_eliminar = this.getBoton('eliminar_ext-grid_ep')
			if(id==" "){
				boton_nuevo.disable()
				boton_editar.disable()
				boton_eliminar.disable()
			}
			else{
				boton_nuevo.enable()
				boton_editar.enable()
				boton_eliminar.enable()
			}
		}



		//Para manejo de eventos
		function iniciarEventosFormularios(){
			combo_financiador = getComponente('id_financiador');
			combo_regional = getComponente('id_regional');
			combo_programa = getComponente('id_programa');
			combo_proyecto = getComponente('id_proyecto');
			combo_actividad = getComponente('id_actividad');
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
				combo_regional.setValue('');
				combo_programa.setValue('');
				combo_proyecto.setValue('');
				combo_actividad.setValue('');
			};
			var onRegionalSelect = function(e) {
				var id = combo_regional.getValue()
				combo_programa.filterValues[1] =  id;
				combo_programa.modificado = true;
				combo_proyecto.filterValues[1] =  id;
				combo_proyecto.modificado = true;
				combo_actividad.filterValues[1] =  id;
				combo_actividad.modificado = true;
				combo_programa.setValue('');
				combo_proyecto.setValue('');
				combo_actividad.setValue('');
			};
			var onProgramaSelect = function(e) {
				var id = combo_programa.getValue()
				combo_proyecto.filterValues[2] =  id;
				combo_proyecto.modificado = true;
				combo_actividad.filterValues[2] =  id;
				combo_actividad.modificado = true;
				combo_proyecto.setValue('');
				combo_actividad.setValue('');
			};
			var onProyectoSelect = function(e) {
				var id = combo_proyecto.getValue()
				combo_actividad.filterValues[3] =  id;
				combo_actividad.modificado = true;
				combo_actividad.setValue('');
			};
			combo_financiador.on('select', onFinanciadorSelect);
			combo_financiador.on('change', onFinanciadorSelect);
			combo_regional.on('select', onRegionalSelect);
			combo_regional.on('change', onRegionalSelect);
			combo_programa.on('select', onProgramaSelect);
			combo_programa.on('change', onProgramaSelect);
			combo_proyecto.on('select', onProyectoSelect);
			combo_proyecto.on('change', onProyectoSelect);

		}







		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_estructura_programatica.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					hidden_id_activo_fijo:maestro.id_activo_fijo
				}
			});
		iniciarEventosFormularios();
		layout_estructura_programatica.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}