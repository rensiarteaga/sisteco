<?php 
/**
 * Nombre:		  	    proyecto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 15:33:00
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_proyecto(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_proyecto_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 15:33:00
 */
function pagina_proyecto(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proyecto/ActionListarProyecto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_proyecto',
			'codigo_proyecto',
			'nombre_proyecto',
			'descripcion_proyecto',
			{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
			'hora_registro',
			{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
			'hora_ultima_modificacion',
			'login',
			'nombre_corto',
			'codigo_sisin'
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
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_proyecto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_proyecto',
		id_grupo:0
	};
	 
// txt codigo_proyecto
	vectorAtributos[1]= {
		validacion:{
			name:'codigo_proyecto',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'55%',
			grid_visible:true,
			grid_editable:true,
			width_grid:70
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.codigo_proyecto',
		save_as:'txt_codigo_proyecto',
		id_grupo:1
	};
	
// txt nombre_proyecto
	vectorAtributos[2]= {
		validacion:{
			name:'nombre_proyecto',
			fieldLabel:'Subprograma/ Proyecto',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:true,
			width_grid:300
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.nombre_proyecto',
		save_as:'txt_nombre_proyecto',
		id_grupo:1
	};
	
// txt descripcion_proyecto
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion_proyecto',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:500
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'PROYEC.descripcion_proyecto',
		save_as:'txt_descripcion_proyecto',
		id_grupo:1
	};
	
// txt fecha_registro
	vectorAtributos[4] = {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha de Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PROYEC.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};
	
// txt hora_registro
	vectorAtributos[5]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora de Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			width:'35%',
			grid_visible:false,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:false,
		filterColValue:'PROYEC.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};
	 
// txt fecha_ultima_modificacion
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha de Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PROYEC.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[7]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora de Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			width:'35%',
			grid_visible:false,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:false,
		filterColValue:'PROYEC.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
	};
	
	// txt descripcion_proyecto
	vectorAtributos[8]= {
		validacion:{
			name:'login',
			fieldLabel:'Usuario',
			allowBlank:true,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'USUARI.login',
		save_as:'txt_loguin',
		id_grupo:0
	};
	
	// txt descripcion_proyecto
	vectorAtributos[9]= {
		validacion:{
			name:'nombre_corto',
			fieldLabel:'Nombre Corto',
			allowBlank:true,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.nombre_corto',
		save_as:'txt_nombre_corto',
		id_grupo:1
	};
	
	// txt descripcion_proyecto
	vectorAtributos[10]= {
		validacion:{
			name:'codigo_sisin',
			fieldLabel:'Código SISIN',
			allowBlank:true,
			allowDecimals: false,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'PROYEC.codigo_sisin',
		save_as:'txt_codigo_sisin',
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
		titulo_maestro:'proyecto',
		grid_maestro:'grid-'+idContenedor
	};
	layout_proyecto=new DocsLayoutMaestro(idContenedor);
	layout_proyecto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_proyecto,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;

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
		btnEliminar:{url:direccion+'../../../control/proyecto/ActionEliminarProyecto.php'},
		Save:{url:direccion+'../../../control/proyecto/ActionGuardarProyecto.php'},
		ConfirmSave:{url:direccion+'../../../control/proyecto/ActionGuardarProyecto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'45%',
		width:'45%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'proyecto',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Proyecto',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Datos de Registro',
				columna:0,
				id_grupo:2},
				{
				tituloGrupo:'Datos de Modificación',
				columna:0,
				id_grupo:3}]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		h_txt_fecha_registro= ClaseMadre_getComponente('fecha_registro');
		h_txt_hora_registro= ClaseMadre_getComponente('hora_registro');
		h_txt_fecha_ultima_modificacion= ClaseMadre_getComponente('fecha_ultima_modificacion');
		h_txt_hora_ultima_modificacion= ClaseMadre_getComponente('hora_ultima_modificacion')
	}

	function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			})
		}

	 	function cargar_fecha_bd(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(h_txt_fecha_registro.getValue()=="")
				{
					h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					h_txt_fecha_registro.disable(true)
				}else{
				
					h_txt_fecha_ultima_modificacion.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					h_txt_fecha_ultima_modificacion.disable(true)	
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
			})
		}

	 	function cargar_hora_bd(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(h_txt_hora_registro.getValue()=="")
				{
					h_txt_hora_registro.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
					h_txt_hora_registro.disable(true)		
							
				}else{
				
					h_txt_hora_ultima_modificacion.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
					h_txt_hora_ultima_modificacion.disable(true)
				}
			}
	 	}
	 	
	this.btnNew = function(){	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Proyecto');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificación');
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
		dialog.resizeTo('45%','45%');
//		var SelectionsRecord  = sm.getSelected();
		get_fecha_bd();
		get_hora_bd();
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Proyecto');
		CM_mostrarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificación');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function(){ 	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Proyecto');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificación');
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Proyecto');
		CM_mostrarGrupo('Datos de Modificación');
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaProyecto(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		var sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_proyecto.getLayout()};
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
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				InitPaginaProyecto();
				layout_proyecto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}