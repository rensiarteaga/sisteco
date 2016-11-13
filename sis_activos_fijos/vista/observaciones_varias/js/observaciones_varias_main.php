<?php
/**
 * Nombre:		  	    servicio_det_main.php
 * Propï¿½sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creaciÃ³n:		28082015
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
			descripcion:'<?php echo $m_descripcion;?>'};
			
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_observavciones(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_observavciones.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				unknow
 * Fecha creaciï¿½n:		28082015
 */
function pagina_observavciones(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/observaciones_varias/ActionListarObservacionesVarias.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_observaciones_varias',
			totalRecords: 'TotalCount' 

		}, ['id_observaciones_varias',
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'desc_observacion', type: 'string'},
		'fecha_reg', //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado', 
		'usuario_reg',
		'id_activo_fijo',
		'desc_activo','id_usuario_reg','desc_persona'
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
		}
	});
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 450,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['ID Activo Fijo',maestro.id_activo_fijo],['Codigo Activo Fijo',maestro.codigo],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	 
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
	
	// DEFINICIï¿½N DATOS DEL MAESTRO
var dataMaestro = [
	['Código Activo Fijo',maestro.codigo],
	['Descripción',maestro.descripcion]
	];


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

	//////////////////////////////////////////////////////////////
	// ------------------  PARï¿½METROS --------------------------//
	// Definiciï¿½n de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//FUNCIONES RENDER
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_reparacion
	//en la posiciï¿½n 0 siempre esta la llave primaria
 
	
	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_observaciones_varias',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'h_id_obs_var'
	};
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_activo_fijo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'h_id_activo_fijo',
		defecto:maestro.id_activo_fijo
	};
	Atributos[2]= {
		validacion:{
			name: 'desc_observacion',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:700,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width : 285,
			width_grid:300 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.observaciones',
		save_as:'txt_observaciones'
	},
	
	
	Atributos[3] = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			mode : "local",
			store: new Ext.data.SimpleStore({
				fields : [ 'valor', 'nombre' ],
				data : [ [ 'activo', 'Activo' ],
							[ 'inactivo', 'Inactivo' ] ] }),
			valueField:'valor',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100// ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.estado',
		save_as:'txt_estado',
		defecto:'activo'
	},
	Atributos[4] = {
		validacion : {
			name :'desc_persona',
			fieldLabel : 'Responsable Registro',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 150
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'al.usuario_reg',
		form : false
	},
	Atributos[5] ={
		validacion : {
		name :'fecha_reg',
		fieldLabel : 'Fecha Registro',
		format : 'd/m/Y',
		minValue : '01/01/1900',
		grid_visible : true,
		grid_editable : false,
		//renderer : formatDate,
		align : 'center',
		width_grid : 120
	},
	tipo : 'TextField',
	form : false,
	filtro_0 : false,
	filterColValue : 'al.fecha_reg',
	dateFormat : 'm-d-Y'
	};

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro:"Activo Fijo Maestro",
		titulo_detalle:"Observaciones Varias Activos Fijos",
		grid_maestro:"maestro",
		grid_detalle:"ext-grid"
	};
	var config={titulo_maestro:"Activo Fijo Maestro",
				titulo_detalle:"Observaciones Varias Activos Fijos",
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
//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIï¿½N DE FUNCIONES
	
	var paramFunciones={
		btnEliminar:{
			url:"../../../sis_activos_fijos/control/observaciones_varias/ActionEliminarObservacionesVarias.php"
		},
		Save:{
			url:"../../../sis_activos_fijos/control/observaciones_varias/ActionGuardarObservacionesVarias.php"
		},
		ConfirmSave:{
			url:"../../../sis_activos_fijos/control/observaciones_varias/ActionGuardarObservacionesVarias.php"
		},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:'30%',minWidth:'30%',minHeight:200,	closable:true,titulo:'Observaciones varias'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.btnNew = function()
	{
		ClaseMadre_btnNew()
	};
	
		this.reload=function(params)
		{
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
    		maestro.codigo=datos.maestro_codigo;
    		maestro.descripcion=datos.maestro_descripcion;
    	
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_activo_fijo:maestro.id_activo_fijo
				}
			});
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['ID Activo Fijo',maestro.id_activo_fijo],['Codigo Activo Fijo',maestro.codigo],['Descripcion',maestro.descripcion]]);
		
		Atributos[1].defecto=maestro.id_activo_fijo;
		paramFunciones.btnEliminar.parametros='&m_id_activo='+maestro.id_activo_fijo;
		paramFunciones.Save.parametros='&m_id_activo='+maestro.id_activo_fijo;
		paramFunciones.ConfirmSave.parametros='&m_id_activo='+maestro.id_activo_fijo;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		for(i=0;i<Atributos.length;i++)
		{
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}
		
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
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