<?php 
/**
 * Nombre:		  	    servicio_propuesto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 10:57:39
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
var elemento={pagina:new pagina_servicio_propuesto(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_servicio_propuesto_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 10:57:39
 */
function pagina_servicio_propuesto(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio_propuesto/ActionListarServicioPropuesto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_servicio_propuesto',totalRecords:'TotalCount'
		},[		
				'id_servicio_propuesto',
		'nombre',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'monto',
		'id_proveedor',
		'desc_proveedor',
		'id_moneda',
		'desc_moneda',
		'desc_usuario',
		'id_usuario'

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

    var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion'])
	});

	//FUNCIONES RENDER
	
		function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
		var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{nombre_proveedor}</i></b>','<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b><i>{id_persona}</i></b>','<br><FONT COLOR="#B5A642">{apellido_paterno}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_servicio_propuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_servicio_propuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_servicio_propuesto'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SERPRO.nombre',
		save_as:'txt_nombre'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'SERPRO.descripcion',
		save_as:'txt_descripcion'
	};
// txt fecha_reg
	Atributos[3]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:100,
			disabled:true,
			grid_indice:8
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SERPRO.fecha_reg',
		dateFormat:'m-d-Y'
	};
// txt monto
	Atributos[4]={
		validacion:{
			name:'monto',
			fieldLabel:'Monto',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SERPRO.monto',
		save_as:'txt_monto'
	};
// txt id_proveedor
	Atributos[5]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:false,			
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROVEE.codigo#PROVEE.id_persona#PROVEE.id_institucion#PROVEE.desc_proveedor',
			typeAhead:true,
			tpl:tpl_id_proveedor,
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
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'50%',
			disable:false,
			grid_indice:6
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PROVEE.codigo',
		save_as:'txt_id_proveedor'
	};
// txt id_moneda
	Atributos[6]={
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
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:5
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda'
	};
// txt id_usuario
	Atributos[7]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:true,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
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
			renderer:render_id_usuario,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disable:false,
			grid_indice:7
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		filterColValue:'PERSON_7.apellido_paterno#PERSON_7.apellido_materno#PERSON_7.nombre',
		save_as:'txt_id_usuario'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Servicio Propuesto',grid_maestro:'grid-'+idContenedor};
	var layout_servicio_propuesto=new DocsLayoutMaestro(idContenedor);
	layout_servicio_propuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_servicio_propuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

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
		btnEliminar:{url:direccion+'../../../control/servicio_propuesto/ActionEliminarServicioPropuesto.php'},
		Save:{url:direccion+'../../../control/servicio_propuesto/ActionGuardarServicioPropuesto.php'},
		ConfirmSave:{url:direccion+'../../../control/servicio_propuesto/ActionGuardarServicioPropuesto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'servicio_propuesto'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_servicio_propuesto='+SelectionsRecord.data.id_servicio_propuesto;
			data=data+'&m_id_solicitud_compra_det=-1';
			data=data+'&m_id_item_propuesto=-1';
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_servicio_propuesto.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Características Servicio',ParamVentana);
layout_servicio_propuesto.getVentana().on('resize',function(){
			layout_servicio_propuesto.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_servicio_propuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	//	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Características Servicio',btn_caracteristica,true,'caracteristica','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_servicio_propuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}