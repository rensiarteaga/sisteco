<?php 
/**
 * Nombre:		  	    tipo_cuenta_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-11-08 18:08:55
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
var elemento={pagina:new pagina_tipo_cuenta(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_tipo_cuenta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-11-08 18:08:55
 */
function pagina_tipo_cuenta(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_cuenta/ActionListarTipoCuenta.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_cuenta',totalRecords:'TotalCount'
		},[		
				'id_tipo_cuenta',
		'codigo',
		'descripcion'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_cuenta
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt codigo
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TICUEN.codigo'
		
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TICUEN.descripcion'
		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'tipo_cuenta',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_cuenta=new DocsLayoutMaestro(idContenedor);
	layout_tipo_cuenta.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_cuenta,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/tipo_cuenta/ActionEliminarTipoCuenta.php'},
		Save:{url:direccion+'../../../control/tipo_cuenta/ActionGuardarTipoCuenta.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_cuenta/ActionGuardarTipoCuenta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'tipo_cuenta'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	
	
	function btn_tipo_cuenta_cuenta()
	{
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0)
				{
					var SelectionsRecord=sm.getSelected();
					var data='id_tipo_cuenta='+SelectionsRecord.data.id_tipo_cuenta;
					data=data+'&tipo_cuenta='+SelectionsRecord.data.descripcion;
					
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
					layout_tipo_cuenta.loadWindows(direccion+'../../../../sis_activos_fijos/vista/tipo_cuenta_cuenta/tipo_cuenta_cuenta.php?'+data,'Asignación de Cuenta por Tipo de Cuenta',ParamVentana);
						
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
				}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_cuenta.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//Adición de botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Cuentas Asociadas',btn_tipo_cuenta_cuenta,true,'tipo_cuenta_cuenta','Cuentas Asociadas'); 
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_cuenta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}