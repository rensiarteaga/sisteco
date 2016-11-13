<?php 
/**
 * Nombre:		  	    compra_rapida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-01 16:50:46
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_compra_rapida(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_compra_rapida.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-01 16:50:46
 */
function pagina_compra_rapida(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra/ActionListarCompraRapida.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
				'num_solicitud',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_empleado_frppa_solicitante',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'descripcion_programa_programa',
		'codigo_programa_programa',
		'descripcion_proyecto_proyecto',
		'codigo_proyecto_proyecto',
		'descripcion_actividad_actividad',
		'codigo_actividad_actividad',
		'desc_empleado_tpm_frppa',
		'id_cuenta',
		'desc_cuenta',
		'id_rpa',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'descripcion_programa_programa',
		'codigo_programa_programa',
		'descripcion_proyecto_proyecto',
		'codigo_proyecto_proyecto',
		'descripcion_actividad_actividad',
		'codigo_actividad_actividad',
		'desc_rpa',
		'localidad',
		'id_moneda',
		'desc_moneda',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'tipo_adjudicacion',
		'tipo_adq',
		'observaciones',
		'nombre',
		'num_solicitud_peri',
		'gestion'
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

    var ds_empleado_tpm_frppa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti'])
	});

    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','id_cuenta_padre'])
	});

    var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_categoria_adq'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre'])
	});

	//FUNCIONES RENDER
	
		function render_id_empleado_frppa_solicitante(value, p, record){return String.format('{0}', record.data['desc_empleado_tpm_frppa']);}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{id_empleado}</i></b>','<br><FONT COLOR="#B5A642">{id_fina_regi_prog_proy_acti}</FONT>','</div>');

		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_rpa(value, p, record){return String.format('{0}', record.data['desc_rpa']);}
		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{id_empleado_frppa}</i></b>','<br><FONT COLOR="#B5A642">{id_empleado_frppa}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

		function render_id_tipo_categoria_adq(value, p, record){return String.format('{0}', record.data['desc_tipo_categoria_adq']);}
		var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');

	
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
// txt id_fina_regi_prog_proy_acti
	Atributos[1]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:true,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,		
			width:300
			},
			form:false,
			tipo:'epField',
			save_as:'id_ep'
		};
// txt id_empleado_frppa_solicitante
	Atributos[2]={
			validacion:{
			name:'id_empleado_frppa_solicitante',
			fieldLabel:'Solicitante',
			allowBlank:true,			
			emptyText:'Solicitante...',
			desc: 'desc_empleado_tpm_frppa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_tpm_frppa,
			valueField: 'id_empleado_frppa',
			displayField: 'id_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
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
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'80%',
			disable:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEP_2.apellido_paterno#EMPLEP_2.apellido_materno#EMPLEP_2.nombre#EMPLEP_2.codigo_empleado',
		save_as:'id_empleado_frppa_solicitante'
	};

// txt id_rpa
	Atributos[3]={
			validacion:{
			name:'id_rpa',
			fieldLabel:'RPA',
			allowBlank:true,			
			emptyText:'RPA...',
			desc: 'desc_rpa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rpa,
			valueField: 'id_rpa',
			displayField: 'id_empleado_frppa',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
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
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEP_4.apellido_paterno#EMPLEP_4.apellido_materno#EMPLEP_4.nombre#EMPLEP_4.codigo_empleado',
		save_as:'id_rpa'
	};
// txt localidad
	Atributos[4]={
		validacion:{
			name:'localidad',
			fieldLabel:'Localidad',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:6		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'SOLCOM.localidad',
		save_as:'localidad'
	};
// txt id_moneda
	Atributos[5]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
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
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
// txt id_unidad_organizacional
	Atributos[6]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Centro',
			allowBlank:true,			
			emptyText:'Centro...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
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
			width_grid:120,
			width:'80%',
			disable:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
// txt id_tipo_categoria_adq
	Atributos[7]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Tipo Categoria',
			allowBlank:true,			
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
			grid_indice:9		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'TIPCAT.nombre',
		save_as:'id_tipo_categoria_adq'
	};
// txt tipo_adjudicacion
	Atributos[8]={
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
			grid_indice:5		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'SOLCOM.tipo_adjudicacion',
		save_as:'tipo_adjudicacion'
	};
// txt tipo_adq
	Atributos[9]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo Adquisición',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		save_as:'tipo_adq'
	};
// txt observaciones
	Atributos[10]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones Estado',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disable:false,
			grid_indice:11		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'ESTPRO.observaciones',
		save_as:'observaciones'
	};
// txt nombre
	Atributos[11]={
		validacion:{
			name:'nombre',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:10		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'ESTCOM.nombre',
		save_as:'nombre'
	};
	
	// txt nombre
	Atributos[12]={
		validacion:{
			name:'codigo_proceso',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:false,
			width:'50%'		
		},
		tipo: 'TextField',
		save_as:'codigo_proceso'
	};
	
	// txt observaciones
	Atributos[13]={
		validacion:{
			name:'observaciones_proceso',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			width:'100%',
			disable:false		
		},
		tipo: 'TextArea',
		save_as:'observaciones_proceso'
	};
	
	// txt nombre
	Atributos[14]={
		validacion:{
			name:'num_solicitud_peri',
			fieldLabel:'Periódo / Nº',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'50%',
			grid_indice:1	
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'SOLCOM.num_solicitud#SOLCOM.periodo',
		save_as:'num_solicitud_peri'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'compra_rapida',grid_maestro:'grid-'+idContenedor};
	var layout_compra_rapida=new DocsLayoutMaestroEP(idContenedor);
	layout_compra_rapida.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_compra_rapida,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;

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
		Save:{url:direccion+'../../../control/solicitud_compra/ActionGuardarCompraRapida.php'},
		Formulario:{
			titulo:'Proceso',
			html_apply:"dlgInfo-"+idContenedor,
			width:'45%',
			height:'30%',
			minWidth:80,
			minHeight:10,
			columnas:['95%'],
			closable:true,
			grupos:[{
				tituloGrupo:'Datos Proceso',
				columna:0,
				id_grupo:0
			}
		]
		}
	}
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	
	function btn_fin_pro_rap(){
				var sm=getSelectionModel(), NumSelect=sm.getCount();
				if(NumSelect!=0){
	
						Ext.Ajax.request({
							url:direccion+"../../../control/solicitud_compra/ActionVerificarDetalleProceso.php",
							success:cargar_respuesta,
							params:{'id_solicitud_compra':sm.getSelected().data.id_solicitud_compra},
							failure:ClaseMadre_conexionFailure,
							timeout:paramConfig.TiempoEspera
						})
						
				}
				else{
					Ext.MessageBox.alert('Estado','Debe seleccionar una Solicitud.')
				}
			}
	function cargar_respuesta(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			var mensaje='¿Está seguro de Iniciar el Proceso?';
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='existe'){
				mensaje='Esta solicitud tiene detalles en uno o mas procesos. ¿Desea continuar?'
			}
			if(confirm(mensaje)){
						 CM_btnEdit();
					}
			
						
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
				layout_compra_rapida.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_solicitud_bien/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
			else{
				layout_compra_rapida.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_solicitud_servicio/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
		
layout_compra_rapida.getVentana().on('resize',function(){
			layout_compra_rapida.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_compra_rapida.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Solicitud Detalle',btn_solicitud_compra_det,true,'solcomdet','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Iniciar Proceso Rápido',btn_fin_pro_rap,true,'finprora','');
		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_compra_rapida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}