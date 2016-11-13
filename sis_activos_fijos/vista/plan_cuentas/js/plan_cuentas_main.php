<?php
/**
 * Nombre:		  	    plan_cuentas_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				UNKNOW
 * Fecha creación:		12-05-2015
 */
session_start();
?>
//<script>

function main(){
	 	<?php
			// obtenemos la ruta absoluta
			$host = $_SERVER['HTTP_HOST'];
			$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$dir = "http://$host$uri/";
			echo "\nvar direccion='$dir';";
			echo "var idContenedor='$idContenedor';";
			?>
	var fa=false;
	<?php
	
if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:fa};
var elemento={pagina:new pagina_cuentas_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento); 
}
Ext.onReady(main,main);

 
function pagina_cuentas_arb(idContenedor, direccion, paramConfig)
{
	
	var DatosNodo = new Array('id', 'id_p', 'tipo');
	var componentes=new Array();
	var DatosDefecto = {};
	var Dialog;
	var id_gestion;

	var config = {
			titulo : 'Plan de cuentas'
		};

	var ds_tipo = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_activo/ActionListaTipoActivo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'
		}, ['id_tipo_activo','descripcion','codigo'])
	});

	var tpl_tipo=new Ext.Template('<div class="search-item">','<b>{descripcion}<br>','<b>Código: </b><FONT COLOR="#0000ff">{codigo}</FONT><br>','</div>');
	function renderTipoActivo(value, p, record){return String.format('{0}', record.data['desc_tipo_activo']);}

	//ds cuenta
	var ds_cuenta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta','nivel_cuenta','gestion','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])});	
	
	var tpl_cuenta=new Ext.Template('<div class="search-item">','<b><i>{desc_cta}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestion: {gestion}</FONT>','</div>');
	
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
	var tpl_cta_aux=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');
	function render_id_cta_activo_auxiliar(value, p, record){return String.format('{0}', record.data['desc_aux_activo'])};
	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['desc_aux_activo']);}

	var ds_detalle_plan = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/detalle_plan_ctas/ActionListarDetallePlanCtas.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_detalle_plan_ctas',
			totalRecords: 'TotalCount'
		}, ['id_detalle_plan_ctas','descripcion','codigo','programa','tension','tipo_bien_adt','tipo_bien_gen','desc_tension'])
	});

	var tpl_det_plan=new Ext.Template('<div class="search-item">','<b>{descripcion}','<FONT COLOR="#B5A642"></br><b>Código: </b>{codigo}','</br><b>Programa: {programa}</b>','</br><b>Tensión :{tension}</b>','</br><b>Tipo Bien: {tipo_bien_adt}{tipo_bien_gen}</b></FONT>','</div>');
	function renderDetallePlan(value, p, record){return String.format('{0}', record.data['desc_det_plan_ctas']);}
	

	function renderTesion(value)
	{
		var res;
		if(value=='alta') res = 'ALTA';
		else if(value=='media')res='MEDIA';
		else if (value =='baja')res ='BAJA';
		return res;
	}

	function renderBienPropOtros(value)
	{
		var res;
		switch(value)
		{
			case 'bienes_produccion': res = 'BIENES EN PRODUCCIÓN';return res;
			case 'bienes_produccion_aereo': res = 'BIENES EN PRODUCCIÓN AÉREO';return res; 
			case 'bienes_produccion_subt': res = 'BIENES EN PRODUCCIÓN SUBTERRÁNEO';return res; 
			case 'propiedad_general': res = 'PROPIEDAD GENERAL';return res; 
			case 'propiedad_general_tra': res = 'PROPIEDAD GENERAL DE TRANSMISIÓN';return res;  
		}

	}
	function renderBienPropGeneracion(value)
	{
			var res;
			switch(value)
			{
				case 'hidraulica':res ='HIDRAÚLICA';return res;
				case 'otra_generacion':res ='OTRA GENERACION (DIESEL OTROS)';return res;
				case 'propiedad_general':res ='PROPIEDAD GENERAL';return res;
				case 'turbina':res ='CON TURBINA';return res;
				case 'vapor':res ='A VAPOR';return res;
				case 'fotovoltaje':res ='GENERACION FOTOVOLTAICA';return res;
			}
	}


	
	var Atributos = [ {
		validacion : {
			labelSeparator : '',
			name : 'id_plan_cuentas',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'h_id_plan_cuentas' 
	}, {
		validacion : {
			labelSeparator : '',
			name : 'id_plan_cuentas_fk',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'h_id_plan_cuentas_fk'
	},
	{
		validacion : {
			name : 'codigo',
			fieldLabel : 'Código',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		id_grupo:0,
		save_as : 'txt_codigo'
	},
	{
		validacion : {
			name : 'descripcion',
			fieldLabel : 'Descripción',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextArea',
		form : true,
		id_grupo:0,
		save_as : 'txt_descripcion'
	},
	{
		validacion : {
			name : 'estado',
			fieldLabel : 'Estado',
			emptyText : 'Estado....',
			allowBlank : false,
			typeAhead : true,
			loadMask : true,
			triggerAction : 'all',
			mode : "local",
			store : new Ext.data.SimpleStore({
				fields : [ 'valor', 'nombre' ],
				data : [ [ 'activo', 'Activo' ],
						[ 'inactivo', 'Inactivo' ] ]
			}),
			valueField : 'valor',
			displayField : 'nombre',
			align : 'left',
			lazyRender : true,
			forceSelection : true,
			width : 160
		},
		form : true,
		tipo : 'ComboBox',
		id_grupo:0,
		defecto:'activo',
		save_as : 'txt_estado'
	},
	{
		validacion:{
			name: 'id_tipo_activo',
			desc: 'desc_tipo_activo', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel: 'Tipo Activo',
			vtype:"texto",
			allowBlank: false,
			emptyText:'Tipo Activo...',
			store:ds_tipo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'tip.descripcion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			tpl:tpl_tipo,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',  
			renderer: renderTipoActivo,
			editable:true,
			width:250,
			//vtype:"alphaLatino",	
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:110 ,// ancho de columna en el grid
			disabled:false
		},
		form:true,
		tipo: 'ComboBox',
		id_grupo:1,
		save_as:'h_id_tipo_activo'
	},
	{
		validacion: {
				name: 'programa',
				fieldLabel: 'Programa',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Programa...',
				store:new Ext.data.SimpleStore({fields:['id_programa','cod_programa'],data:[['GEN','Generación'],['TRA', 'Transmisión'],['DIS', 'Distribución'],['ADM', 'Bienes de uso Administración Central']]}),
				valueField:'id_programa',
				displayField:'cod_programa',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				width:250,
				grid_visible:true,			
				disabled:false
			},
			form:true,
			id_grupo:2,
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'det.programa',
			defecto:' ',
			save_as:'txt_programa'
	},
	{
		validacion: {
				name: 'tension',
				fieldLabel: 'Tensión',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Tensión...',
				store:new Ext.data.SimpleStore({fields:['id_tension','cod_tension'],data:[['alta','ALTA'],['media', 'MEDIA'],['baja', 'BAJA']]}),
				valueField:'id_tension',
				displayField:'cod_tension',
				mode:'local',
				renderer:renderTesion, 
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				width:250,
				grid_visible:true,			
				disabled:false
			},
			form:true,
			id_grupo:2,
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'det.tension',
			//defecto:' ',
			save_as:'txt_tension'
	},
	{
		validacion: {
				name:'tipo_bien_adt',//ADMINISTRACION,TRANSMISION Y DISTRIBUCION
				fieldLabel: 'Bien/Propiedad Otros',
				allowBlank:true,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Tipo Bien Propiedad...',
				store:new Ext.data.SimpleStore({	fields:['cod_tipo_bien','desc_tipo_bien'],
													data:[
													      ['bienes_produccion','BIENES EN PRODUCCIóN'],
													      ['bienes_produccion_aereo', 'BIENES EN PRODUCCIóN AÉREO'],
													      ['bienes_produccion_subt', 'BIENES EN PRODUCCIÓN SUBTERRÁNEO'],
													      ['propiedad_general', 'PROPIEDAD GENERAL'],
													      ['propiedad_general_tra', 'PROPIEDAD GENERAL DE TRANSIMISIÓN'],
													       ]
												}),
				valueField:'cod_tipo_bien',
				displayField:'desc_tipo_bien',
				mode:'local',
				renderer:renderBienPropOtros,
				lazyRender:true,
				forceSelection:false,
				width_grid:250,
				triggerAction:'all',
				width:250,
				grid_visible:true,			
				disabled:false
			},
			form:true,
			id_grupo:2,
			tipo:'ComboBox',
			filtro_0:false,
			save_as:'txt_tipo_bien_adt',
			//defecto:' '
	},
	{
		validacion: {
				name:'tipo_bien_gen',//generacion
				fieldLabel: 'Tipo Bien/Propiedad Generación',
				allowBlank:true,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Tipo Bien Propiedad...',
				store:new Ext.data.SimpleStore({	fields:['cod_tipo_bien','desc_tipo_bien'],
													data:[
													      ['hidraulica','HIDRAÚLICA'],
													      ['otra_generacion', 'OTRA GENERACION (DIESEL OTROS)'],
													      ['propiedad_general', 'PROPIEDAD GENERAL'],
													      ['turbina', 'CON TURBINA'],
													      ['vapor', 'A VAPOR'],
													      ['fotovoltaje','GENERACION FOTOVOLTAICA']
													       ]}),
				valueField:'cod_tipo_bien',
				displayField:'desc_tipo_bien',
				mode:'local',
				renderer:renderBienPropGeneracion,
				lazyRender:true,
				forceSelection:false,
				width_grid:250,
				triggerAction:'all',
				width:250,
				grid_visible:true,			
				disabled:false
			},
			form:true,
			id_grupo:2,
			tipo:'ComboBox',
			filtro_0:false,
			save_as:'txt_tipo_bien_gen',
			//defecto:' '
	},
	{
		validacion:{
			name:'id_cta_activo',
			desc:'desc_cta_activo',
			fieldLabel:'Cuenta Contable Activo',
			vtype:'texto',
			emptyText:'Cuenta Contable Activo...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_cuenta,
			loadMask:true,
			triggerAction:'all',
			store:ds_cuenta,
			mode:'remote',
			valueField:'id_cuenta',
			displayField:'desc_cta',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			width:300
		},
		tipo:'ComboBox',
		form: true,
		save_as:'h_id_activo',
		id_grupo: 2
	},
	{
		validacion:{
		name:'id_aux_activo',
		desc:'desc_aux_activo',
		fieldLabel:'Auxiliar Activo',
		allowBlank:true,
		emptyText:'Auxiliar Activo',
		store:ds_auxiliar,
		valueField:'id_auxiliar',
		displayField:'nombre_auxiliar',
		queryParam:'filterValue_0',
		filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
		tpl:tpl_cta_aux,
		typeAhead:false,
		forceSelection:false,
		mode:'remote',
		queryDelay:250,
		pageSize:10,
		minListWidth:'100%',
		grow:false,
		resizable:true,
		minChars:3,
		renderer:renderAuxiliar,
		triggerAction:'all',
		grid_visible:false,
		grid_editable:true,
		width:300,
		width_grid:250 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'aux_dep_acum.codigo_auxiliar#aux_dep_acum.nombre_auxiliar',
		form: true,
		save_as:'h_aux_activo',	
		id_grupo:2
	},
	{
		validacion:{
			name:'id_cta_dep_acumulada',
			desc:'desc_cta_depacum',
			fieldLabel:'Cuenta Deprecion Acumulada',
			vtype:'texto',
			emptyText:'Cuenta Depreciación Acumulada...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_cuenta,
			loadMask:true,
			triggerAction:'all',
			store:ds_cuenta,
			mode:'remote',
			valueField:'id_cuenta',
			displayField:'desc_cta',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			width:300
		},
		tipo:'ComboBox',
		form: true,
		save_as:'h_id_depacum',
		id_grupo: 2
	},
	{
		validacion:{
		name:'id_aux_depacum',
		desc:'desc_aux_depacum',
		fieldLabel:'Auxiliar Depreciación Acumulada',
		allowBlank:true,
		emptyText:'Auxiliar Depreciación Acumulada',
		store:ds_auxiliar,
		valueField:'id_auxiliar',
		displayField:'nombre_auxiliar',
		queryParam:'filterValue_0',
		filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
		tpl:tpl_cta_aux,
		typeAhead:false,
		forceSelection:false,
		mode:'remote',
		queryDelay:250,
		pageSize:10,
		minListWidth:'100%',
		grow:false,
		resizable:true,
		minChars:3,
		renderer:renderAuxiliar,
		triggerAction:'all',
		grid_visible:false,
		grid_editable:true,
		width:300,
		width_grid:250 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'aux_dep_acum.codigo_auxiliar#aux_dep_acum.nombre_auxiliar',
		form: true,
		save_as:'h_aux_depacum',
		id_grupo:2	
	},
	{
		validacion:{
			name:'id_cta_gasto',
			desc:'desc_cta_gasto',
			fieldLabel:'Cuenta Gasto',
			vtype:'texto',
			emptyText:'Cuenta Gasto...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_cuenta,
			loadMask:true,
			triggerAction:'all',
			store:ds_cuenta,
			mode:'remote',
			valueField:'id_cuenta',
			displayField:'desc_cta',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			width:300
		},
		tipo:'ComboBox',
		save_as:'h_id_gasto',
		id_grupo: 2
	},
	{
		validacion:{
		name:'id_aux_cta_gasto',
		desc:'desc_aux_gasto',
		fieldLabel:'Auxiliar Cuenta Gasto',
		allowBlank:true, 
		emptyText:'Auxiliar Cuenta Gasto',
		store:ds_auxiliar,
		valueField:'id_auxiliar',
		displayField:'nombre_auxiliar',
		queryParam:'filterValue_0',
		filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
		tpl:tpl_cta_aux,
		typeAhead:false,
		forceSelection:false,
		mode:'remote',
		queryDelay:250,
		pageSize:10,
		minListWidth:'100%',
		grow:false,
		resizable:true,
		minChars:3,
		renderer:renderAuxiliar,
		triggerAction:'all',
		grid_visible:false,
		grid_editable:true,
		width:300,
		width_grid:250 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'aux_dep_acum.codigo_auxiliar#aux_dep_acum.nombre_auxiliar',
		form: true,
		save_as:'h_aux_gasto',
		id_grupo:2	
	},
	{
		validacion : {
			labelSeparator : '',
			name : 'id_gestion',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'h_id_gestion'
	},
	{
		validacion : {
			labelSeparator : '',
			name : 'nivel',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'h_nivel'
	}
	];

	var layout_clasificacion_arb = new DocsLayoutArb(idContenedor);
	layout_clasificacion_arb.init(config);
	// Se hereda la clase vista Arbol
	this.pagina = PaginaArb;
	this.pagina(paramConfig, Atributos, layout_clasificacion_arb, idContenedor,DatosNodo, DatosDefecto);
	
	// funciones heredadas
	var cm_getSelectionModel = this.getSm;
	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	var cm_ocultarFormulario = this.ocultarFormulario;
	var cm_btnActualizar = this.btnActualizar;
	var cm_EnableSelect = this.EnableSelect;
	var cm_btnEdit = this.btnEdit;
	var getSelectionModel = this.getSelectionModel;
	
	var cm_mostrarComponente=this.mostrarComponente;
	var cm_ocultarComponente=this.ocultarComponente;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	var cm_DesbloquearMenu = this.DesbloquearMenu;

	var getSm=this.getSm;
	
	var cm_ocultarGrupo=this.ocultarGrupo;
	var cm_mostrarGrupo=this.mostrarGrupo;

	
	this.btnEdit=function()
	{
		cm_btnEdit();
		
		var selectedNode = cm_getSelectionModel().getSelectedNode();

		if( selectedNode.attributes.id_plan_cuentas_fk == '' || selectedNode.attributes.id_plan_cuentas_fk == undefined  )
		{		
			cm_mostrarGrupo('Datos Cuentas');
			cm_ocultarGrupo('Detalle Plan de Cuentas')
			cm_ocultarGrupo('Cuentas Contables - Auxiliares');

			siBlancosGrupo(1);
			siBlancosGrupo(2);
		}
		else
		{
			cm_getComponente('codigo').disable();
			cm_getComponente('codigo').allowBlank=true;
			
			if(selectedNode.attributes.nivel == 2)
			{
				//manejoGrupos('rama','edit');
				cm_mostrarGrupo('Datos Cuentas');
				
				cm_mostrarGrupo('Detalle Plan de Cuentas')
				cm_ocultarGrupo('Cuentas Contables - Auxiliares');

				
				siBlancosGrupo(2);
			}
			else if(selectedNode.attributes.nivel == 3)
			{
				//ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
				
				cm_ocultarGrupo('Datos Cuentas');
				cm_ocultarGrupo('Detalle Plan de Cuentas');
				
 				cm_mostrarGrupo('Cuentas Contables - Auxiliares');

 				if(selectedNode.attributes.programa=='DIS')
 				{	
 					cm_mostrarComponente(cmb_tipo_bien_adt); 
 					cm_mostrarComponente(cmb_tension);
 					
 					cm_ocultarComponente(cmb_tipo_bien_gen);
 					
 					cmb_tension.allowBlank = true;
 					cmb_tipo_bien_adt.allowBlank = true;
 					cmb_tipo_bien_gen.allowBlank = true;

 					cmb_tipo_bien_gen.setValue('');
 				}
 	 			else if(selectedNode.attributes.programa =='TRA' || selectedNode.attributes.programa=='ADM')
 	 			{
 	 				cm_mostrarComponente(cmb_tipo_bien_adt);
 					
 					cm_ocultarComponente(cmb_tipo_bien_gen);
 					cm_ocultarComponente(cmb_tension);

 					cmb_tension.allowBlank = true;
 					cmb_tipo_bien_adt.allowBlank = true;
 					cmb_tipo_bien_gen.allowBlank = true;

 					cmb_tension.setValue('');
 					cmb_tipo_bien_gen.setValue('');
 	 	 		}
 	 	 		else if(selectedNode.attributes.programa == 'GEN')
 	 	 		{
 	 	 			cm_mostrarComponente(cmb_tipo_bien_gen);
 					cm_ocultarComponente(cmb_tipo_bien_adt);
 					cm_ocultarComponente(cmb_tension);

 					cmb_tension.allowBlank = true;
 					cmb_tipo_bien_adt.allowBlank = true;
 					cmb_tipo_bien_gen.allowBlank = true;

 					cmb_tension.setValue('');
 					cmb_tipo_bien_adt.setValue('');
 	 	 	 	}
 				siBlancosGrupo(0);
 				siBlancosGrupo(1);

 				ds_detalle_plan.baseParams={	m_id_tipo_af:selectedNode.attributes.id_tipo_activo,filtro_param:'si'};
			}
		}
		
	};
	
	this.btnNewRaiz = function()
	{
		btnNewRaiz();

		cm_getComponente('codigo').enable();
		cm_getComponente('id_gestion').setValue(id_gestion);
		
		cm_mostrarGrupo('Datos Cuenta');
		cm_ocultarGrupo('Detalle Plan de Cuentas')
		cm_ocultarGrupo('Cuentas Contables - Auxiliares');

		cm_getComponente('nivel').setValue(1);
		siBlancosGrupo(1);
		siBlancosGrupo(2);
		noBlancosGrupo(0);
	};
	
	this.guardarSuccess = function(httpResponse) {
		Ext.MessageBox.hide();
		cm_ocultarFormulario();
		if (httpResponse.argument.nodo == null) {
			cm_btnActualizar();
		} else if (httpResponse.argument.proc == "add") {
			httpResponse.argument.nodo.reload();
		} else if (httpResponse.argument.proc == "upd") {
			httpResponse.argument.nodo.parentNode.reload();
		} else if (httpResponse.argument.proc == "del") {
			httpResponse.argument.nodo.parentNode.reload();
		}
	}
	this.btnEliminar=function()
	{
		btnEliminar();
		cm_btnActualizar();
	};

	this.btnNew = function() 
	{
		var selectedNode = cm_getSelectionModel().getSelectedNode();

		if (selectedNode == null || selectedNode == undefined)
		{
			cm_btnNew();
			ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
		}
		else
		{
			cm_btnNew()
			if(selectedNode.attributes.nodo == 'raiz')
			{
				cm_getComponente('nivel').setValue(2);
				manejoGrupos(selectedNode.attributes.nodo,'new');
			}
			else if(selectedNode.attributes.nivel == 2)
			{
				cm_getComponente('nivel').setValue(3);
				manejoGrupos('rama','new');
				cm_getComponente('id_tipo_activo').setValue(selectedNode.attributes.id_tipo_activo);

				ds_detalle_plan.baseParams={	m_id_tipo_af:selectedNode.attributes.id_tipo_activo,filtro_param:'si'};

			}

			cm_getComponente('id_plan_cuentas_fk').setValue(selectedNode.attributes.id_plan_cuentas);
			cm_getComponente('id_gestion').setValue(id_gestion);

			cm_getComponente('codigo').disable(); 
			cm_getComponente('codigo').allowBlank=true;
			
		}		
	};
	
	function manejoGrupos(tipo_nodo,accion)
	{	
		if(accion=='new')
		{
			if(tipo_nodo == 'raiz')
			{			
				cm_mostrarGrupo('Datos Cuenta');
					
				cm_mostrarGrupo('Detalle Plan de Cuentas');
				cm_ocultarGrupo('Cuentas Contables - Auxiliares');

				siBlancosGrupo(2);
			}
			else if(tipo_nodo == 'rama')
			{
				cm_mostrarGrupo('Cuentas Contables - Auxiliares');
				
				cm_ocultarGrupo('Datos Cuenta');
				cm_ocultarGrupo('Detalle Plan de Cuentas')

				siBlancosGrupo(0);
				siBlancosGrupo(1);
			}
		}
		else if(accion =='edit')
		{
			if(tipo_nodo == 'raiz')
			{
				cm_mostrarGrupo('Datos Cuentas');
				
				cm_ocultarGrupo('Detalle Plan de Cuentas')
				cm_ocultarGrupo('Cuentas Contables - Auxiliares');

				siBlancosGrupo(1);
				siBlancosGrupo(2);
			}
			else if(tipo_nodo == 'rama')
			{
				cm_mostrarGrupo('Datos Cuentas');
				cm_mostrarGrupo('Detalle Plan de Cuentas');

				cm_ocultarGrupo('Cuentas Contables - Auxiliares');
				siBlancosGrupo(2);
			}
			else if(tipo_nodo == 'hoja')
			{
				cm_mostrarGrupo('Cuentas Contables - Auxiliares');

				cm_ocultarGrupo('Datos Cuentas');
				cm_ocultarGrupo('Detalle Plan de Cuentas');

				siBlancosGrupo(0);
				siBlancosGrupo(1);
			}
		}	
	};

	function siBlancosGrupo(grupo)
	{
		for(var i=0;i<Atributos.length;i++)
		{
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=true;
		}
		
	}

	function noBlancosGrupo(grupo)
	{
		for(var i=0;i<Atributos.length;i++)
		{
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}

	var paramMenu = {
			actualizar : {crear : true,separador : true},
			nuevoRaiz : {crear : true,separador : false,tip : 'Nueva Clasificacion Raiz',img : 'org_add.png'},
			nuevo : {crear : true,separador : true,tip : 'Nuevo',img : 'org_uni_add.png'},
			editar : {crear : true,separador : false,tip : 'Editar',img : 'org_edit.png'},
			eliminar : {crear : true,separador : false,tip : 'Eliminar',img : 'org_uni_del.png'}
		};
	var paramFunciones = {
			Basicas : {
				url : direccion
						+ '../../../control/plan_cuentas/ActionGuardarPlanCuentas.php',
				add_success : this.guardarSuccess,
				edit : this.btnEdit,
				esCopia : true
			},
			Formulario : {
				height : 415,
				width : 480,
				minWidth : 150,
				minHeight : 200,
				closable : true,
				titulo : 'Plan de Cuentas',
				grupos:[
						{
							tituloGrupo:'Datos Cuenta',
							columna:0,
							id_grupo:0
						},
						{
							tituloGrupo:'Detalle Plan de Cuentas',
							columna:0,
							id_grupo:1
						},
						{
							tituloGrupo:'Cuentas Contables - Auxiliares',
							columna:0,
							id_grupo:2
						}
					]
			},
			Listar : {
				url : direccion+ '../../../control/plan_cuentas/ActionListarPlanCuentas.php',
				baseParams : {},
				clearOnLoad : true,
				enableDD : true
			},
			Eliminar : {url : direccion+ "../../../control/plan_cuentas/ActionEliminarPlanCuentas.php"}
		};

	// Para manejo de eventos
	function iniciarEventosFormularios() 
	{
		for (var i=0;i<Atributos.length;i++){componentes[i]=cm_getComponente(Atributos[i].validacion.name);}
		//cuenta activos
		cmb_cta_activo = cm_getComponente('id_cta_activo');

		function cmb_cta_activo_onSelect()
		{
			ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
			cm_getComponente('id_aux_activo').store.baseParams={	m_id_cuenta: cmb_cta_activo.getValue(), 
																	sw_reg_comp:'si'};
			cm_getComponente('id_aux_activo').reset();				
			
			cm_getComponente('id_aux_activo').modificado=true;
			
		}
		cmb_cta_activo.on('select',cmb_cta_activo_onSelect);
		cmb_cta_activo.on('change',cmb_cta_activo_onSelect);

		//cuentas depreciacion acumulada
		cmb_cta_depacum = cm_getComponente('id_cta_dep_acumulada');

		function cmb_cta_depacum_onSelect()
		{
			ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
			cm_getComponente('id_aux_depacum').store.baseParams={	m_id_cuenta: cmb_cta_depacum.getValue(), 
																	sw_reg_comp:'si'};
			cm_getComponente('id_aux_depacum').reset();				
			
			cm_getComponente('id_aux_depacum').modificado=true;
			
		}
		cmb_cta_depacum.on('select',cmb_cta_depacum_onSelect);
		cmb_cta_depacum.on('change',cmb_cta_depacum_onSelect);

		//cuenta gasto
		cmb_cta_gasto = cm_getComponente('id_cta_gasto');
		function cmb_cta_gasto_onSelect()
		{
			ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
			cm_getComponente('id_aux_cta_gasto').store.baseParams={	m_id_cuenta: cmb_cta_gasto.getValue(), 
																	sw_reg_comp:'si'};
			cm_getComponente('id_aux_cta_gasto').reset();				
			
			cm_getComponente('id_aux_cta_gasto').modificado=true;
			
		}
		cmb_cta_gasto.on('select',cmb_cta_gasto_onSelect);
		cmb_cta_gasto.on('change',cmb_cta_gasto_onSelect);
		
		//aóadido 12-05-2015
		cmb_programa = cm_getComponente('programa');
		cmb_tension = cm_getComponente('tension');
		cmb_tipo_bien_adt = cm_getComponente('tipo_bien_adt');
		cmb_tipo_bien_gen = cm_getComponente('tipo_bien_gen');
		
		cm_ocultarComponente(cmb_tipo_bien_adt);
		cm_ocultarComponente(cmb_tipo_bien_gen);
		cm_ocultarComponente(cmb_tension);
		
		function combo_programa_onSelect()
		{
			var prog = cmb_programa.getValue();
			
			if(prog == 'DIS')
			{ 
				cm_mostrarComponente(cmb_tipo_bien_adt);
				cm_mostrarComponente(cmb_tension);
				
				cm_ocultarComponente(cmb_tipo_bien_gen);
				
				cmb_tension.allowBlank = true;
				cmb_tipo_bien_adt.allowBlank = true;
				cmb_tipo_bien_gen.allowBlank = true;

				cmb_tipo_bien_gen.setValue('');
			}
			else if(prog == 'TRA' || prog == 'ADM')
			{
				cm_mostrarComponente(cmb_tipo_bien_adt);
				
				cm_ocultarComponente(cmb_tipo_bien_gen);
				cm_ocultarComponente(cmb_tension);

				cmb_tension.allowBlank = true;
				cmb_tipo_bien_adt.allowBlank = true;
				cmb_tipo_bien_gen.allowBlank = true;

				cmb_tension.setValue('');
				cmb_tipo_bien_gen.setValue('');
			}
			else if(prog = 'GEN')
			{
				cm_mostrarComponente(cmb_tipo_bien_gen);
				cm_ocultarComponente(cmb_tipo_bien_adt);
				cm_ocultarComponente(cmb_tension);

				cmb_tension.allowBlank = true;
				cmb_tipo_bien_adt.allowBlank = true;
				cmb_tipo_bien_gen.allowBlank = true;

				cmb_tension.setValue('');
				cmb_tipo_bien_adt.setValue('');
			}	
		}
		cmb_programa.on('change',combo_programa_onSelect);
		cmb_programa.on('select',combo_programa_onSelect);
		
	}
	this.getLayout = function() {
		return layout_clasificacion_arb.getLayout();
	};
	//combo gestion
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda'])}); 
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var gestion =new Ext.form.ComboBox({
				store: ds_gestion,
				displayField:'gestion',
				typeAhead: true,
				mode: 'remote',
				triggerAction: 'all',
				emptyText:'gestion...',
				selectOnFocus:true,
				width:100,
				valueField: 'id_gestion',
				tpl:tpl_gestion
			});
	 gestion.on('select',function (combo, record, index)
	 {
		 cm_DesbloquearMenu();
		 id_gestion=gestion.getValue();
		 treeLoader.baseParams.id_gestion = id_gestion;
		 
		 combo.modificado = true;
		 ds_cuenta.baseParams={	m_id_gestion:id_gestion,sw_transaccional:1	};
		 cm_btnActualizar()	
	 });

	 function btn_det_planctas()
	 {
var n = getSm().getSelectedNode();
		 
		 if(!n || n.attributes.nivel !=2 )
			 Ext.MessageBox.alert('...', 'Seleccione un nodo del tipo rama (nodo que contenga el tipo del activo fijo)');
		 else
		 {
			 var data='m_codigo='+n.attributes.desc_tipo_activo;
				data=data+'&m_id_tipo_activo='+n.attributes.id_tipo_activo;
				data=data+'&m_descripcion='+n.attributes.desc_tipo_activo;
				data=data+'&m_nivel='+n.attributes.nivel;
				
				var Param={Ventana:{width:'50%',height:'60%'}};
				layout_clasificacion_arb.loadWindows(direccion+'../../../vista/detalle_plan_ctas/detalle_plan_ctas.php?'+data,'Auxiliar de Cuentas',Param)
				layout_clasificacion_arb.getVentana().on('resize',function(){
				layout_clasificacion_arb.getLayout().layout(); })
		 } 
	 }
	
	//fin combo gestion
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu); 

 
	this.Init();
	this.iniciaFormulario();
	
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	
	//this.AdicionarBoton("../../../lib/imagenes/bricks.png",'<b>Detalle Plan Ctas.<b>',btn_det_planctas,true,'det_plan_ctas','Detalle Plan Cuentas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte',btn_reporte_plan_ctas,true,'reporte_plna_ctas','');
	cm_BloquearMenu();

	function btn_reporte_plan_ctas()
	{
		var data='m_id_gestion='+id_gestion;
		window.open(direccion+'../../../control/_reportes/plan_cuentas/ActionPlanCuentasXLS.php?'+data)
	}

	
	this.AdicionarBotonCombo(gestion,'gestion');


	var treeLoader = this.getLoader();
	treeLoader.on("beforeload", function(treeL, node, a) {
		treeL.baseParams.tipo_nodo = node.attributes.tipo_nodo;
		treeL.baseParams.id_nodo = node.attributes.id;
		treeL.baseParams.id_gestion = id_gestion;
		treeL.baseParams.id_plan_cuentas = node.attributes.id_plan_cuentas;
		//treeL.baseParams.id_plan_cuentas_fk = node.attributes.id_plan_cuentas_fk;
	}, this);

	var cmGetBoton = this.getBoton;
	iniciarEventosFormularios();
	
	layout_clasificacion_arb.getLayout().addListener('layout',this.onResize);// aregla la forma en que se ve el grid dentro del

	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}