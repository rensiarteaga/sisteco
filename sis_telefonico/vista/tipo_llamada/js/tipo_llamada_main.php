<?php 
/**
 * Nombre:		  	    tipo_llamada_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:01
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_tipo_llamada(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tipo_llamada_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:01
 */
function pagina_tipo_llamada(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_tipo_llamada;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_llamada/ActionListarTipoLlamada.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_llamada',
			totalRecords:'TotalCount'
		},[
		'id_tipo_llamada',
		'nombre_tipo_llamada',
		'costo_minuto',
		'descripcion'
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_llamada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_llamada'
	};
// txt nombre_tipo_llamada
	vectorAtributos[1]={
			validacion:{
			name:'nombre_tipo_llamada',
			fieldLabel:'Nombre',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Local','Local'],['Celular','Celular'],['Nacional','Nacional'],['Internacional','Internacional'],['Fax','Fax']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:130
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TIPLLA.nombre_tipo_llamada',
		defecto:'Local',
		save_as:'txt_nombre_tipo_llamada'
	};
// txt costo_minuto
	vectorAtributos[2]={
		validacion:{
			labelSeparator:'',
			name:'costo_minuto',
			allowBlank:true,
			inputType:'hidden',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			minValue:0
			},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'TIPLLA.costo_minuto',
		save_as:'txt_costo_minuto'
	};
// txt descripcion
	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:195
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'TIPLLA.descripcion',
		save_as:'txt_descripcion'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'tipo_llamada',grid_maestro:'grid-'+idContenedor};
	layout_tipo_llamada=new DocsLayoutMaestro(idContenedor);
	layout_tipo_llamada.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_llamada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_llamada/ActionEliminarTipoLlamada.php'},
		Save:{url:direccion+'../../../control/tipo_llamada/ActionGuardarTipoLlamada.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_llamada/ActionGuardarTipoLlamada.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Tipo de Llamada'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_linea(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tipo_llamada='+SelectionsRecord.data.id_tipo_llamada;
			data=data+'&m_nombre_tipo_llamada='+SelectionsRecord.data.nombre_tipo_llamada;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			layout_tipo_llamada.loadWindows(direccion+'../../../vista/linea/linea_det.php?'+data,'Lineas',ParamVentana);
            layout_tipo_llamada.getVentana().on('resize',function(){layout_tipo_llamada.getLayout().layout()})
		}
	else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
	}
	}
	this.getLayout=function(){
		return layout_tipo_llamada.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
    this.AdicionarBoton('../../../lib/imagenes/telephone_add.png','Líneas Telefónicas',btn_linea,true,'linea','');
	this.iniciaFormulario();
	layout_tipo_llamada.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}