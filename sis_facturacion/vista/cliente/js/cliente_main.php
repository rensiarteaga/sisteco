<?php 
/**
 * Nombre:		  	    eeff_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 16:28:12
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
	var elemento={pagina:new pagina_cliente(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_cliente(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	
	var dialog;
	var habilita_hijo='si';
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cliente/ActionListarCliente.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cliente',totalRecords:'TotalCount'
		},[
		'id_cliente',
		'razon_social', 
		'nro_nit', 
		'direccion', 
		'telefono', 
		'repre_legal', 
		'docid_legal', 
		'nomb_fact',		
		'usuario_reg',
		'fecha_reg'
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	/*FUNCIONES RENDER*/
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cliente',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	   
	Atributos[1]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.razon_social',
		id_grupo:0
	};
	   
	Atributos[2]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.nro_nit',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'repre_legal',
			fieldLabel:'Representante Legal',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.repre_legal',
		id_grupo:0
	};
	   
	Atributos[4]={
		validacion:{
			name:'docid_legal',
			fieldLabel:'CI',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.docid_legal',
		id_grupo:0
	};
	   
	Atributos[5]={
		validacion:{
			name:'nomb_fact',
			fieldLabel:'Factura',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.nomb_fact',
		id_grupo:0
	};
	   
	Atributos[6]={
		validacion:{
			name:'telefono',
			fieldLabel:'Teléfono(s)',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.telefono',
		id_grupo:0
	};
	
	Atributos[7]={
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'CLIE.direccion',
		id_grupo:0
	};
	
	Atributos[8]={
		validacion:{			
			name:'usuario_reg',
			fieldLabel:'Responsable Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.usuario_reg'
	};
	
	Atributos[9]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:110		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.fecha_reg'
	};
	
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cliente',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_facturacion/vista/cliente/clie_cta.php'};
    layout_cliente = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_cliente.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_cliente,idContenedor);
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/cliente/ActionEliminarCliente.php'},
		Save:{url:direccion+'../../../control/cliente/ActionGuardarCliente.php'},
		ConfirmSave:{url:direccion+'../../../control/cliente/ActionGuardarCliente.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:350,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Clientes',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		dialog=Cm_getDialog();
		getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_cliente.getIdContentHijo()).pagina.limpiarStore()){}
		})
	}
	
	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_cliente.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_cliente.getIdContentHijo()).pagina.bloquearMenu();
	    _CP.getPagina(layout_cliente.getIdContentHijo()).pagina.desbloquearMenu();
	    
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();
	    _CP.getPagina(idContenedor).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cliente.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cliente.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}