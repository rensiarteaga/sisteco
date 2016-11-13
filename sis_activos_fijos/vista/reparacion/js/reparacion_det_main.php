<?php
/**
 * Nombre:		  	    servicio_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		20/07/2010
 *
 */
session_start();
?>
//<script>
var paginaReparacion;

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
var maestro={id_activo_fijo:<?php echo $m_id_activo_fijo;?>,
			codigo:decodeURIComponent('<?php echo $m_codigo;?>'),
			descripcion:'<?php echo $m_descripcion;?>',
			descripcion_larga:'<?php echo $m_descripcion_larga;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_reparacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_reparacion_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				avq
 * Fecha creación:		20/07/2010
 */
function pagina_reparacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reparacion/ActionListaReparacion.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_reparacion',
			totalRecords: 'TotalCount' 

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_reparacion',
		{name: 'fecha_desde', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		{name: 'fecha_hasta', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'problema', 
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'observaciones',
		'estado',
		'id_activo_fijo',
		'id_persona',
		'id_institucion',
		'des_activo_fijo',
		'des_persona',
		'des_institucion'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: maestro.id_activo_fijo
		},
		callback:cargar_maestro
		
	});
	function cargar_maestro(){
		
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,
			EstehtmlMaestro([['Código Activo Fijo',maestro.codigo],
							['Descripción',maestro.descripcion],
							['Descripción larga',maestro.descripcion_larga]]));
		}
	
ds_persona = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'

		}, ['id_persona','desc_per'])

	});
	
	
	ds_institucion = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'

		}, ['id_institucion','nombre'])

	});
	////////////////FUNCIONES RENDER ////////////
	function renderPersona(value, p, record){return String.format('{0}', record.data['des_persona']);}
	function renderInstitucion(value, p, record){return String.format('{0}', record.data['des_institucion']);}
	
	// DEFINICIÓN DATOS DEL MAESTRO
var dataMaestro = [
	//['ID',$("maestro_id_activo_fijo").value],
	['Código Activo Fijo',maestro.codigo],
	['Descripción',maestro.descripcion],
	['Descripción larga',maestro.descripcion_larga]
	];

	/*var dsMaestro = new Ext.data.Store({
		proxy: new Ext.data.MemoryProxy(dataMaestro),
		reader: new Ext.data.ArrayReader({id: 0}, [
		{name: 'atributo'},
		{name: 'valor'}

		])
	});
	dsMaestro.load();*/

	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);

	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>' + value + '</i>';
	}

	// create the Grid
	/*var gridMaestro = new Ext.grid.Grid('maestro', {
		ds: dsMaestro,
		cm: cmMaestro
	});

	gridMaestro.render();*/


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");


	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_reparacion
	//en la posición 0 siempre esta la llave primaria
 
	
	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_reparacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_reparacion'
	};
	Atributos[1]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_activo_fijo',
		defecto:maestro.id_activo_fijo
	};
	Atributos[2] = {
		validacion:{
			name: 'fecha_desde',
			fieldLabel: 'Fecha Inicio',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_desde',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	Atributos[3]  = {
		validacion:{
			name: 'fecha_hasta',
			fieldLabel: 'Fecha Fin',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:70 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_hasta',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	
	Atributos[4] = {
		validacion:{
			name: 'problema',
			fieldLabel: 'Problema',
			allowBlank: false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_problema'
	}

	
	
	
	Atributos[5]= {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.observaciones',
		save_as:'txt_observaciones'
	}
	
	
	Atributos[6] = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['activo', 'inactivo', 'eliminado'],
				data : Ext.reparacionCombo.estado // from states.js
			}),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.estado',
		save_as:'txt_estado'
	}


	/*******/


	
	

///////////////////////
	
		
	
 Atributos[7]= {
		validacion:{
			fieldLabel: 'persona',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Persona...',
			name: 'id_persona',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'des_persona', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField:'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'genero',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderPersona,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		
		tipo: 'ComboBox',
		save_as:'hidden_id_persona'
	}
	
				
	Atributos[8]= {
		validacion:{
			fieldLabel: 'Institucion',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Institucion...',
			name: 'id_institucion',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'des_institucion', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderInstitucion,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_institucion'
	}
	
	
	Atributos[9] = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'rep.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	


	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro:"Activo Fijo Maestro",
		titulo_detalle:"Reparacion de Activos Fijos",
		grid_maestro:"maestro",
		grid_detalle:"ext-grid"
	};
	var config={titulo_maestro:"Activo Fijo Maestro",
				titulo_detalle:"Reparacion de Activos Fijos",
				grid_maestro:'grid-'+idContenedor};
	var layout_reparacion = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_reparacion.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_reparacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	
	
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
		btnEliminar:{

			url:"../../../sis_activos_fijos/control/reparacion/ActionEliminaReparacion.php"
		},
		Save:{
			url:"../../../sis_activos_fijos/control/reparacion/ActionGuardarReparacion.php"
		},
		ConfirmSave:{
			url:"../../../sis_activos_fijos/control/reparacion/ActionGuardarReparacion.php"
		},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:'80%',minWidth:'80%',minHeight:200,	closable:true,titulo:'reparacions'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.btnNew = function()
	{
		get_fecha_bd();
		ClaseMadre_btnNew()
	};
	
	  function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}
	
	function cargar_fecha_bd(resp)
	{   
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			componentes[9].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			
			
		}
	}
	
	
	
	var ds_maestro = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reparacion/ActionListaReparacion.php?id_activo_fijo='+maestro.id_activo_fijo
		}),

		//proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/tipo_reparacion/ActionListarTiporeparacion.php?id_tipo_reparacion='+maestro.id_tipo_reparacion}),
	
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_reparacion',totalRecords: 'TotalCount'},['id_tipo_reparacion',
		'nombre',
		'codigo',
		'descripcion',
		'desc_tipo_adq','nombre_cuenta','nombre_partida'
		])
		});
		
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_activo_fijo:maestro.id_activo_fijo

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,
			EstehtmlMaestro([['Código Activo Fijo',maestro.codigo],
							['Descripción',maestro.descripcion],
							['Descripción larga',maestro.descripcion_larga]]));
		}
	
	
		this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
    		maestro.codigo=datos.maestro_codigo;
    		maestro.descripcion=datos.maestro_descripcion;
    		maestro.descripcion_larga=datos.maestro_descripcion_larga;
			ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_activo_fijo:maestro.id_activo_fijo
				},
				callback:cargar_maestro
			});
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_activo_fijo:maestro.id_activo_fijo
					}
			};
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_activo_fijo;
	/*	paramFunciones.btnEliminar.parametros='&m_id_tipo_reparacion='+maestro.id_tipo_reparacion;
		paramFunciones.Save.parametros='&m_id_tipo_reparacion='+maestro.id_tipo_reparacion+'&m_codigo='+maestro.codigo;
		paramFunciones.ConfirmSave.parametros='&m_id_tipo_reparacion='+maestro.id_tipo_reparacion+'&m_codigo='+maestro.codigo;
	*/	this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		for(i=0;i<Atributos.length;i++)
		{
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}
		combo_persona = ClaseMadre_getComponente('id_persona');
		combo_institucion = ClaseMadre_getComponente('id_institucion');
		
		function limpia_institucion()
		{
			if(combo_persona.getValue() != "")
			{
				combo_institucion.setValue("");
			}
			
		}
		
		function limpia_persona()
		{
			if(combo_institucion.getValue() != "")
			{
				combo_persona.setValue("");
			}
			
		}
		
		combo_persona.on('valid',limpia_institucion);
		combo_institucion.on('valid',limpia_persona);

	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_reparacion.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_reparacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}