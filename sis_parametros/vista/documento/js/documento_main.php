<?php 
/**
 * Nombre:		  	    documento_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-29 09:44:14
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
var elemento={pagina:new pagina_documento(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_documento.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-29 09:44:14
 */
function pagina_documento(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumento.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'
		},[		
				'id_documento',
		'codigo',
		'descripcion',
		'documento',
		'prefijo',
		'sufijo',
		'estado',
		'id_subsistema',
		'desc_subsistema',
		'num_firma',
		//modificación 23/03/2011
		'tipo_numeracion','id_tipo_proceso','tipo','desc_tipo_proceso'//--
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

    var ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','codigo'])
	});

	//FUNCIONES RENDER
	
		function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
		var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_corto}</FONT><br>','<FONT COLOR="#000000">{nombre_largo}</FONT>','</div>');

		//Modificación 23/03/2011
		 var ds_tipo_proceso= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_flujo/control/tipo_proceso/ActionListarTipoProceso.php'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_proceso',totalRecords: 'TotalCount'},['id_tipo_proceso',
				'codigo',
				'id_usuario_reg',
				'nombre_proceso',
				'fecha_reg',
				'estado_reg',
				'estado',
				'id_nodo_inicio',
				'id_formulario_inicio'])
		});
		 
		 
		//FUNCIONES RENDER
			
			function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
			var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_corto}</FONT><br>','<FONT COLOR="#000000">{nombre_largo}</FONT>','</div>');

			function render_id_tipo_proceso(value, p, record){return String.format('{0}', record.data['desc_tipo_proceso']);}
			var tpl_id_tipo_proceso=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo}</FONT><br>','<FONT COLOR="#000000">{nombre_proceso}</FONT>','</div>');

			
			function renderTipo(value, p, record){
				if(value=='interna'){
					return 'Correspondencia Interna';
				}else{
					if(value=='externa'){
					  	return 'Correspondencia Externa';
					}else{
						if(value=='emitida')
						 return 'Correspondencia Emitida';
					}
					
				}
			}
		//-------------
			
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_documento
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};
// txt codigo
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo',
		save_as:'codigo'
	};
	// txt documento
	Atributos[2]={
		validacion:{
			name:'documento',
			fieldLabel:'Documento',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.documento',
		save_as:'documento'
	};
// txt descripcion
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.descripcion',
		save_as:'descripcion'
	};

// txt prefijo
	Atributos[4]={
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.prefijo',
		save_as:'prefijo'
	};
// txt sufijo
	Atributos[5]={
		validacion:{
			name:'sufijo',
			fieldLabel:'Sufijo',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.sufijo',
		save_as:'sufijo'
	};
// txt estado
	Atributos[6]={
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			minListWidth:120,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.estado',
		defecto:'activo',
		save_as:'estado'
	};
// txt id_subsistema
	Atributos[7]={
			validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,			
			emptyText:'Subsistema...',
			desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.codigo#SUBSIS.nombre_corto',
			typeAhead:true,
			tpl:tpl_id_subsistema,
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
			renderer:render_id_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SUBSIS.codigo',
		save_as:'id_subsistema'
	};
Atributos[8]={
		validacion:{
			name:'num_firma',
			fieldLabel:'Nro de Firmas',
			allowBlank:false,
			maxLength:2,
			minLength:1,
			align:'right', 
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'93%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.num_firma',
		save_as:'num_firma'
	};

//modificación 23/03/2011
//adicion del campo tipo_numeracion
Atributos[9]={
		validacion:{
		name:'tipo_numeracion',
		fieldLabel:'Tipo Numeracion',
		allowBlank:false,
		typeAhead:true,
		loadMask:true,
		triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['depto','Depto'],['uo','Uo'],['depto_uo','Depto-Uo']]}),
		valueField:'id',
		displayField:'valor',
		lazyRender:true,
		grid_visible:true,
		grid_editable:false,
		forceSelection:true,
		width:100
	},
	tipo:'ComboBox',
	defecto:'depto',
	form: true,
	filtro_0:true,
	//filterColValue:'DEPFIR.estado'
	filterColValue:'tipo_numeracion'
	
};


Atributos[10]={
			validacion:{
			name:'id_tipo_proceso',
			fieldLabel:'Tipo Proceso',
			allowBlank:false,			
			emptyText:'Tipo Proceso...',
			desc: 'desc_tipo_proceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_proceso,
			valueField: 'id_tipo_proceso',
			displayField: 'nombre_proceso',
			queryParam: 'filterValue_0',
			filterCol:'TIPPRO.codigo#TIPPRO.nombre_proceso',
			typeAhead:true,
			tpl:tpl_id_tipo_proceso,
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
			renderer:render_id_tipo_proceso,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPRO.codigo#TIPPRO.nombre_proceso',
		save_as:'id_tipo_proceso'
	};


Atributos[11]={
		validacion: {
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['interna','Correspondencia Interna'],['externa','Correspondencia Externa'],['emitida','Correspondencia Emitida']]}),
			
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:renderTipo,
			width_grid:120
		},
		tipo:'ComboBox',
		save_as:'tipo',
		defecto:'interna'
};
//--------------
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Documento',grid_maestro:'grid-'+idContenedor};
	var layout_documento=new DocsLayoutMaestro(idContenedor);
	layout_documento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_documento,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	// MODIFICACIÓN 23/03/2011
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	//----------------------

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/documento/ActionEliminarDocumento.php'},
		Save:{url:direccion+'../../../control/documento/ActionGuardarDocumento.php'},
		ConfirmSave:{url:direccion+'../../../control/documento/ActionGuardarDocumento.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Documento'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_correlativo_rp(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_documento='+SelectionsRecord.data.documento;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_documento.loadWindows(direccion+'../../../../sis_parametros/vista/correlativo_rp/correlativo_rp.php?'+data,'Correlativo RP',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	function btn_correlativo_general(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
            data=data+'&m_documento='+SelectionsRecord.data.documento;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_documento.loadWindows(direccion+'../../../../sis_parametros/vista/correlativo_general/correlativo_general.php?'+data,'Correlativo General',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//MODIFICACION 23/03/2011
	this.btnNew=function()
	{		
		CM_ocultarComponente(getComponente('id_tipo_proceso'));
		CM_ocultarComponente(getComponente('tipo'));
		
			CM_btnNew();
	
			
		}
	
	
	
	this.btnEdit=function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
		
		
			CM_ocultarComponente(getComponente('id_tipo_proceso'));
			CM_ocultarComponente(getComponente('tipo'));
				if(SelectionsRecord.data.desc_subsistema=='FLUJO'){ 
					CM_mostrarComponente(getComponente('id_tipo_proceso'));
					CM_mostrarComponente(getComponente('tipo'));
					getComponente('id_tipo_proceso').allowBlank=false;
					getComponente('tipo').allowBlank=false;
				}
				else{
					CM_ocultarComponente(getComponente('id_tipo_proceso'));
					CM_ocultarComponente(getComponente('tipo'));
					
					
					getComponente('id_tipo_proceso').reset();
					getComponente('tipo').reset();
					getComponente('id_tipo_proceso').allowBlank=true;
					getComponente('tipo').allowBlank=true;
				}
				CM_btnEdit()
		}else{
			alert('Antes debe seleccionar un item');
		}
	};
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		cmb_subsistema=getComponente('id_subsistema');
		var onSubsistema=function(c,r,i){
			if(r.data.nombre_corto=='FLUJO'){
				CM_mostrarComponente(getComponente('id_tipo_proceso'));
				CM_mostrarComponente(getComponente('tipo'));
				
				getComponente('id_tipo_proceso').allowBlank=false;
				getComponente('tipo').allowBlank=false;
			}else{
				
				CM_ocultarComponente(getComponente('id_tipo_proceso'));
				CM_ocultarComponente(getComponente('tipo'));
				
				
				getComponente('id_tipo_proceso').reset();
				getComponente('tipo').reset();
				getComponente('id_tipo_proceso').allowBlank=true;
				getComponente('tipo').allowBlank=true;
				
			}
		}
		
		cmb_subsistema.on('select',onSubsistema);
	}

	//--------------------

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_documento.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
		//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Correlativo RP',btn_correlativo_rp,true,'correlativo_rp','');

		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Correlativo General',btn_correlativo_general,true,'Correlativo General','Correlativo');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_documento.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}