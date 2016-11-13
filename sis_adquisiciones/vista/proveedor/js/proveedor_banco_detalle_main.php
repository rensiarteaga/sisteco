<?php
/**
 * Nombre:		  	    proveedor_banco_detalle_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-16 16:05:58
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


var elemento={idContenedor:idContenedor,pagina:new pagina_proveedor_banco_detalle(idContenedor,direccion,paramConfig)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_proveedor_banco_detalle.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-16 16:05:58
 */
function pagina_proveedor_banco_detalle(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var maestro=new Array();
	var componentes=new Array();
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor_cuenta_bancaria/ActionListarProveedorCuentaBancaria.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proveedor_cuenta_bancaria',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_proveedor_cuenta_bancaria',
				'id_institucion',
				'nro_cuenta',
		'desc_institucion',
		'estado_reg'
		]),remoteSort:true});

	 
	// DEFINICIÓN DATOS DEL MAESTRO

	
	
	
	//DATA STORE COMBOS

    ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});

	//FUNCIONES RENDER
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_proveedor_cuenta_auxiliar
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_proveedor_cuenta_bancaria',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_proveedor
	Atributos[1]={
		validacion:{
			name:'id_proveedor',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_proveedor
	};
	Atributos[2]= {
			validacion: {
			name:'id_institucion',
			fieldLabel:'Banco',
			allowBlank:false,			
			emptyText:'Banco...',
			name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:150,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:false,
			width_grid:150 // ancho de columna en el gris
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		defecto: ''
	};
	
	// txt usuario
	Atributos[3]={
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'No Cuenta',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:130
			
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'nro_cuenta'
		
	};
	
	
	
	
	Atributos[4]= {
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store: new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:110, // ancho de columna en el gris
			disabled:false
			
		},
		tipo:'ComboBox'
		
	};
	
	

	 
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Proveedor-Cuenta Bancaria (Maestro)',titulo_detalle:'proveedor_cuenta_bancaria (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_proveedor_banco_detalle = new DocsLayoutMaestro(idContenedor);
	layout_proveedor_banco_detalle.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_proveedor_banco_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponente=this.getComponente;
	var cm_btnNew=this.btnNew;
	var getDialog=this.getDialog;
	var getForm=this.getFormulario;
	var mostrarFormulario=this.mostrarFormulario;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/proveedor_cuenta_bancaria/ActionEliminarProveedorCuentaBancaria.php',parametros:'&id_proveedor='+maestro.id_proveedor},
	Save:{url:direccion+'../../../control/proveedor_cuenta_bancaria/ActionGuardarProveedorCuentaBancaria.php',parametros:'&id_proveedor='+maestro.id_proveedor},
	ConfirmSave:{url:direccion+'../../../control/proveedor_cuenta_bancaria/ActionGuardarProveedorCuentaBancaria.php',parametros:'&id_proveedor='+maestro.id_proveedor},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proveedor_cuenta_bancaria'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_proveedor:maestro.id_proveedor
			}
		};
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_proveedor;

		paramFunciones.btnEliminar.parametros='&id_proveedor='+maestro.id_proveedor;
		paramFunciones.Save.parametros='&id_proveedor='+maestro.id_proveedor;
		paramFunciones.ConfirmSave.parametros='&id_proveedor='+maestro.id_proveedor;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		
		dialog=getDialog();
		form=getForm();
	}

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_proveedor_banco_detalle.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	
	
	
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_proveedor_banco_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}