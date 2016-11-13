<?php 
/**
 * Nombre:		  	    subsistema_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:42:22
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
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
var elemento={pagina:new pagina_subsistema(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_subsistema_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:42:22
 */
function pagina_subsistema(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, [
			'id_subsistema',
			'nombre_corto',
			'nombre_largo',
			'descripcion',
			'version_desarrollo',
			'desarrolladores',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
			'hora_reg',
			{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
			'hora_ultima_modificacion',
			'observaciones',
			'codigo','codigo_procedimiento'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_subsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_subsistema'
	};
	 
// txt nombre_corto
	vectorAtributos[1]= {
		validacion:{
			name:'nombre_corto',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			grid_indice:1
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_corto',
		save_as:'txt_nombre_corto',
		id_grupo:0
	};
	
// txt nombre_largo
	vectorAtributos[2]= {
		validacion:{
			name:'nombre_largo',
			fieldLabel:'Nombre Largo',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'80%',
			grid_indice:3
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_largo',
		save_as:'txt_nombre_largo',
		id_grupo:0
	};
	
// txt descripcion
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			grid_indice:4
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.descripcion',
		save_as:'txt_descripcion',
		id_grupo:0
	};
	
// txt version_desarrollo
	vectorAtributos[4]= {
		validacion:{
			name:'version_desarrollo',
			fieldLabel:'Versión Desarrollo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:50,
			align:'center',
			width:'80%',
			grid_indice:5
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.version_desarrollo',
		save_as:'txt_version_desarrollo',
		id_grupo:1
	};
	
// txt desarrolladores
	vectorAtributos[5]= {
		validacion:{
			name:'desarrolladores',
			fieldLabel:'Desarrolladores',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			grid_indice:6
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.desarrolladores',
		save_as:'txt_desarrolladores',
		id_grupo:1
	};
	
// txt fecha_reg
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:2
	};
	
// txt hora_reg
	vectorAtributos[7]= {
		validacion:{
			name:'hora_reg',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			align:'center',
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.hora_reg',
		save_as:'txt_hora_reg',
		id_grupo:2
	};
	
// txt fecha_ultima_modificacion
	vectorAtributos[8]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[9]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:85,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
	};
	
// txt observaciones
	vectorAtributos[10]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			grid_indice:7
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};
	
	vectorAtributos[11]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Nombre Corto',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			grid_indice:2
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.codigo',
		save_as:'txt_codigo',
		id_grupo:1
	};
	
	
	vectorAtributos[12]={
		validacion:{
			name:'codigo_procedimiento',
			fieldLabel:'Código Procedimiento',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'50%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METAPR.codigo_procedimiento',
		save_as:'txt_codigo_procedimiento',
		id_grupo:1
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'subsistema',
		grid_maestro:'grid-'+idContenedor
	};
	layout_subsistema=new DocsLayoutMaestro(idContenedor);
	layout_subsistema.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_subsistema,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;


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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/subsistema/ActionEliminarSubsistema.php'},
		Save:{url:direccion+'../../../control/subsistema/ActionGuardarSubsistema.php'},
		ConfirmSave:{url:direccion+'../../../control/subsistema/ActionGuardarSubsistema.php'},
		Formulario:{
			titulo:'Subsistema',
			html_apply:"dlgInfo-"+idContenedor,
			width:'50%',
			height:'60%',
			minWidth:200,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos Subsistema',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Desarrollo',
				columna:0,
				id_grupo:1
			},
			
			{
				tituloGrupo:'Hora y Fecha Registro',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Hora y Fecha Modificación',
				columna:0,
				id_grupo:3
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_metaproceso(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_subsistema='+SelectionsRecord.data.id_subsistema;
			data=data+'&m_nombre_corto='+SelectionsRecord.data.nombre_corto;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_subsistema.loadWindows(direccion+'../../../vista/metaproceso/metaproceso_det.php?'+data,'Metaproceso',ParamVentana);
			layout_subsistema.getVentana().on('resize',function(){layout_subsistema.getLayout().layout()})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_procdb(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_subsistema='+SelectionsRecord.data.id_subsistema;
			data=data+'&m_nombre_corto='+SelectionsRecord.data.nombre_corto;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'60%',height:'65%'}}
			layout_subsistema.loadWindows(direccion+'../../../vista/procedimiento_db/procedimiento_db.php?'+data,'Metaproceso',ParamVentana);
			layout_subsistema.getVentana().on('resize',function(){layout_subsistema.getLayout().layout()})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.');
		}
	}
	
	function btn_relacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_subsistema='+SelectionsRecord.data.id_subsistema;
			data=data+'&m_nombre_corto='+SelectionsRecord.data.nombre_corto;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_subsistema.loadWindows(direccion+'../../../vista/relacion/relacion.php?'+data,'Relación',ParamVentana);
			layout_subsistema.getVentana().on('resize',function(){layout_subsistema.getLayout().layout()})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.');
		}
	}
	
	this.btnNew = function()
	{
		CM_mostrarGrupo('Datos Subsistema');
		CM_mostrarGrupo('Datos Desarrollo');
		CM_mostrarGrupo('Hora y Fecha Registro');
		CM_ocultarGrupo('Hora y Fecha Modificación');
		CM_ocultarComponente(ClaseMadre_getComponente('codigo_procedimiento'));
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnNew()
	};
	
	 this.btnEdit = function()
	{
		CM_mostrarGrupo('Datos Subsistema');
		CM_mostrarGrupo('Datos Desarrollo');
		CM_ocultarGrupo('Hora y Fecha Registro');
		CM_mostrarGrupo('Hora y Fecha Modificación');
		CM_ocultarComponente(ClaseMadre_getComponente('codigo_procedimiento'));
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit()
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
			if(componentes[6].getValue()=="")
			{
				componentes[6].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			}else{
		   		componentes[8].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			}
			
		}
	}
		
	function get_hora_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
			method:'GET',
			success:cargar_hora_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_hora_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(componentes[7].getValue()==""){
					componentes[7].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
				else{
				componentes[9].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
			}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		sm=getSelectionModel()
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_subsistema.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Metaproceso',btn_metaproceso,true,'metaproceso','Metaproceso');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Procesos Base de Datos',btn_procdb,true,'procdb','Procesos Base de Datos');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Tablas del subsistema',btn_relacion,true,'relacion','Tablas del subsistema');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_subsistema.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}