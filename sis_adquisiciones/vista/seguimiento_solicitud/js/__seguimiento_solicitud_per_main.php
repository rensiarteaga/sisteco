<?php 
/**
 * Nombre:		  	    seguimiento_solicitud_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
 *
 */
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
var elemento={pagina:new pagina_seguimiento_solicitud_per(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_seguimiento_solicitud.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
 */
function pagina_seguimiento_solicitud_per(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var observaciones='';
	var data='';
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
		'justificacion',
		'localidad',
		'siguiente_estado',
		'tipo_adjudicacion',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'desc_empleado_tpm_frppa',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_cuenta',
		'desc_cuenta',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'reformulacion',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','tipo_adq','num_solicitud','estado','numeracion_periodo','gestion'
,'transcriptor'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			vista:'seguimiento_solicitud_per'
		}
	});
	//DATA STORE COMBOS

    var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre'])
	});

    var ds_empleado_tpm_frppa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_categoria_adq'])
	});

    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','id_cuenta_padre'])
	});

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

	//FUNCIONES RENDER
	
		function render_id_tipo_categoria_adq(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_tipo_categoria_adq']+ '</span>';}else {return record.data['desc_tipo_categoria_adq'];}}
		var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');

		function render_id_empleado_frppa_solicitante(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_empleado_tpm_frppa']+ '</span>';}else {return record.data['desc_empleado_tpm_frppa'];}}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{id_empleado}</i></b>','<br><FONT COLOR="#B5A642">{id_fina_regi_prog_proy_acti}</FONT>','</div>');

		function render_id_moneda(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_moneda']+ '</span>';}else {return record.data['desc_moneda'];}}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_rpa(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_rpa']+ '</span>';}else {return record.data['desc_rpa'];}}
		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{id_empleado_frppa}</i></b>','<br><FONT COLOR="#B5A642">{id_empleado_frppa}</FONT>','</div>');

		function render_id_cuenta(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_cuenta']+ '</span>';}else {return record.data['desc_cuenta'];}}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_unidad_organizacional(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_unidad_organizacional']+ '</span>';}else {return record.data['desc_unidad_organizacional'];}}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642">{centro}</FONT>','</div>');
		
			
		
		function negrita(val,cell,record,row,colum,store){
			if(record.get('reformulacion')=='1'){
								
				if(colum=='4'){
					return '<span style="color:red;font-size:8pt">Reformulación Pendiente</span>';
				}
				else{
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
				}
			}
			else
			{
				return val;
			}
		}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_solicitud_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra'
	};
    
	
	Atributos[14]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			align:'right',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			disable:false,
			grid_indice:1,
			renderer:negrita 
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SEGSOL.gestion',
		save_as:'txt_gestion'
	};
Atributos[3]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Periodo/NºSolicitud',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:75,
			width:'30%',
			disable:false,
			grid_indice:2,
			renderer:negrita 
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo',
		save_as:'txt_num_solicitud'
	};
// txt id_empleado_frppa_solicitante
	Atributos[1]={
			validacion:{
			name:'id_empleado_frppa_solicitante',
			fieldLabel:'Solicitante',
			allowBlank:false,			
			emptyText:'Solicitante...',
			desc: 'desc_empleado_tpm_frppa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_tpm_frppa,
			valueField: 'id_empleado_frppa',
			displayField: 'desc_empleado_tpm_frppa',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_empleado_frppa_solicitante,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_frppa_solicitante,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre',
		save_as:'id_empleado_frppa_solicitante'
	};
	
	// txt id_unidad_organizacional
	Atributos[2]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Centro Autorizador',
			allowBlank:false,			
			emptyText:'Centro...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			width:'80%',
			disable:false,
			grid_indice:4	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
	
		// txt num_solicitud
	
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name: 'tipo_adq',
			fieldLabel:'Tipo de Adquisición',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			grid_indice:13
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		save_as:'tipo_adq'
	};
	// txt tipo_adjudicacion
	Atributos[5]={
		validacion:{
			name:'tipo_adjudicacion',
			fieldLabel:'Adjudicación',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'40%',
			disable:false,
			grid_indice:15,
			renderer:negrita 		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.tipo_adjudicacion',
		save_as:'tipo_adjudicacion'
	};
	
// txt id_tipo_categoria_adq
	Atributos[6]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Categoria',
			allowBlank:false,			
			emptyText:'Tipo Categoria...',
			desc: 'desc_tipo_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_categoria_adq,
			valueField: 'id_tipo_categoria_adq',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPCAT.nombre#TIPCAT.tipo',
			typeAhead:true,
			tpl:tpl_id_tipo_categoria_adq,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_categoria_adq,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:16		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPCAT.nombre',
		save_as:'id_tipo_categoria_adq'
	};

// txt id_rpa
	Atributos[7]={
			validacion:{
			name:'id_rpa',
			fieldLabel:'RPA',
			allowBlank:false,			
			emptyText:'RPA...',
			desc: 'desc_rpa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rpa,
			valueField: 'id_rpa',
			displayField: 'id_empleado_frppa',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_rpa,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_rpa,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:17 	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'EMPLEP_8.apellido_paterno#EMPLEP_8.apellido_materno#EMPLEP_8.nombre',
		save_as:'id_rpa'
	};


	
	// txt localidad
	Atributos[8]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:11,
			renderer:negrita 		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.nombre',
		save_as:'estado'
	};
	
	// txt estado_vigente_solicitud
	Atributos[9]={
		validacion:{
			name:'siguiente_estado',
			fieldLabel:'Siguiente Estado',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'40%',
			disable:false,
			grid_indice:9,
			renderer:negrita 		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'SEGSOL.siguiente_estado',
		save_as:'siguiente_estado'
	};
	
	
	// txt id_moneda
	Atributos[10]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
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
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disable:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	
	// txt localidad
	Atributos[11]={
		validacion:{
			name:'localidad',
			fieldLabel:'Localidad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:11,
			renderer:negrita 		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'SEGSOL.localidad',
		save_as:'localidad'
	};
	
	
	// txt observaciones
	Atributos[12]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:12,
			renderer:negrita 		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.observaciones',
		save_as:'observaciones'
	};
// txt id_fina_regi_prog_proy_acti
	Atributos[13]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,		
			width:300,
			renderer:negrita 
			},
			tipo:'epField',
			save_as:'id_ep'
		};
		
	
	
	Atributos[15]={
		validacion:{
			name:'transcriptor',
			fieldLabel:'Transcriptor',
			grid_visible:true,
			
			width_grid:100,
			grid_indice:10		
		},
		tipo: 'Field',
		form: false
		
	};
	
	
	
		// txt num_solicitud
	
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'seguimiento_solicitud',grid_maestro:'grid-'+idContenedor};
	var layout_seguimiento_solicitud_per=new DocsLayoutMaestro(idContenedor);
	layout_seguimiento_solicitud_per.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_seguimiento_solicitud_per,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_enableSelect=this.EnableSelect;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'seguimiento_solicitud'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_estado_proceso(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_desc_empleado_tpm_frppa='+SelectionsRecord.data.desc_empleado_tpm_frppa;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_desc_unidad_organizacional='+SelectionsRecord.data.desc_unidad_organizacional;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_seguimiento_solicitud_per.loadWindows(direccion+'../../../../sis_adquisiciones/vista/historial_solicitud/historial_solicitud.php?'+data,'Historial Solicitud',ParamVentana);
layout_seguimiento_solicitud_per.getVentana().on('resize',function(){
			layout_seguimiento_solicitud_per.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	function btn_solicitud_compra_det(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
			data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.tipo_adq=='Bien'){
				layout_seguimiento_solicitud_per.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_seguimiento_solicitud_bien/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
			else{
				layout_seguimiento_solicitud_per.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_seguimiento_solicitud_servicio/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
		
layout_seguimiento_solicitud_per.getVentana().on('resize',function(){
			layout_seguimiento_solicitud_per.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	function btn_rep_sol(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			 window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitud.php?'+data);
			
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	
	
	function btn_anular(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='cantidad_ids=1&hidden_id_solicitud_compra_0='+SelectionsRecord.data.id_solicitud_compra;
			
			Ext.MessageBox.show({
           title: 'Observaciones de Anulación',
           msg: 'Ingrese observaciones de anulación:',
           width:300,
           buttons: Ext.MessageBox.OK,
           multiline: true,
           fn: getObservaciones1
           
       });
					
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function showResult(btn){
			if(btn!='no'){
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	function getObservaciones(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones='+observaciones;
		data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
		
		
	}
	function getObservaciones1(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones_0='+observaciones;
		
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
		
		
	}
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}

	function btn_historial_rep(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
							
			window.open(direccion+'../../../control/estado_proceso/reporte/ActionPDFHistorial.php?'+data)	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.EnableSelect=function(x,z,y){
			
		enable(x,z,y);
		
		
	}	
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_seguimiento_solicitud_per.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		

		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','');
		this.AdicionarBoton('../../../lib/imagenes/gtuc/images/book.gif','Historial Solicitud',btn_estado_proceso,true,'estado_proceso','');
		this.AdicionarBoton('../../../lib/images/print.gif','Reporte de Solicitud',btn_rep_sol,true,'reporte_solicitud','Reporte de Solicitud');
		//this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Solicitud',btn_anular,true,'anular_solicitud','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Historial Reporte',btn_historial_rep,true,'historial_reporte','Historial');

	var CM_getBoton=this.getBoton;
	CM_getBoton('solicitud_compra_det-'+idContenedor).enable();
	CM_getBoton('estado_proceso-'+idContenedor).enable();
	CM_getBoton('reporte_solicitud-'+idContenedor).enable();
	//CM_getBoton('anular_solicitud-'+idContenedor).enable();
	CM_getBoton('historial_reporte-'+idContenedor).enable();		
	
	
	function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				       
        			   if(record.estado!='borrador' && record.estado!='pendiente_pre_aprobacion' && record.estado!='pre_aprobado' && record.estado!='anulado'){
        			       CM_getBoton('reporte_solicitud-'+idContenedor).enable();
        			   }else{
        			       CM_getBoton('reporte_solicitud-'+idContenedor).disable();
        			   }
					       if(record.reformulacion=='1' || record.estado=='finalizado' || record.estado=='anulado'){
					       		CM_getBoton('solicitud_compra_det-'+idContenedor).enable();
								CM_getBoton('estado_proceso-'+idContenedor).enable();
								//CM_getBoton('suspender_solicitud-'+idContenedor).disable();
								//CM_getBoton('anular_solicitud-'+idContenedor).disable();
								CM_getBoton('historial_reporte-'+idContenedor).enable();
								CM_getBoton('reporte_solicitud-'+idContenedor).disable();
					       }
					       
					       else{
					       		CM_getBoton('solicitud_compra_det-'+idContenedor).enable();
								CM_getBoton('estado_proceso-'+idContenedor).enable();
								//CM_getBoton('suspender_solicitud-'+idContenedor).enable();
								//CM_getBoton('anular_solicitud-'+idContenedor).enable();
								CM_getBoton('historial_reporte-'+idContenedor).enable();
								CM_getBoton('reporte_solicitud-'+idContenedor).enable();
					       }
				       		

				}
				CM_enableSelect(sel,row,selected);
				
			}	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_seguimiento_solicitud_per.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}