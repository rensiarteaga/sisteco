<?php 
/**
 * Nombre:		  	    tipo_unidad_constructiva_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-07 15:46:18
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
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>
};
var elemento={pagina:new pagina_tipo_unidad_constructiva(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_tipo_unidad_constructiva_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Anacleto Rojas Veizaga
 * Fecha creación:		06-11-2007
 */
function pagina_tipo_unidad_constructiva(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConstructiva.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_unidad_constructiva',
		'codigo',
		'nombre',
		'tipo',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}

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

	//FUNCIONES RENDER
	
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_unidad_constructiva
	//en la posición 0 siempre esta la llave primaria

	var param_id_tipo_unidad_constructiva = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_unidad_constructiva',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_unidad_constructiva'
	};
	vectorAtributos[0] = param_id_tipo_unidad_constructiva;
// txt codigo
	var param_codigo= {
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[1] = param_codigo;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[2] = param_nombre;
// txt tipo
	var param_tipo= {
			validacion: {
			name:'tipo',
			fieldLabel:'Tipo Unidad',
			allowBlank:false,
			align: 'center',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.tipo_unidad_constructiva_combo.tipo}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [
			                                                        		['Hoja','Hoja'],
			                                                        		['Rama','Rama'],
			                                                        		['Raiz','Raiz']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.tipo',
		defecto:'Hoja',
		save_as:'txt_tipo'
	};
	vectorAtributos[3] = param_tipo;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[4] = param_descripcion;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[5] = param_observaciones;
// txt fecha_reg
	var param_fecha_reg= {
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
			width_grid:100,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[6] = param_fecha_reg;

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Tipo Unidad Constructiva',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tipo_unidad_constructiva=new DocsLayoutMaestro(idContenedor);
	layout_tipo_unidad_constructiva.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_unidad_constructiva,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;

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
		btnEliminar:{
			url:direccion+'../../../control/tipo_unidad_constructiva/ActionEliminarTipoUnidadConstructiva.php'
		},
		Save:{
			url:direccion+'../../../control/tipo_unidad_constructiva/ActionGuardarTipoUnidadConstructiva.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/tipo_unidad_constructiva/ActionGuardarTipoUnidadConstructiva.php'
		},
		
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:430,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Tipo Unidad Constructiva'
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.btnNew = function()
	{	
		ClaseMadre_btnNew();
		get_fecha_bd();
		//get_hora_bd();
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
				
				componentes[6].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		//   	componentes[14].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
		}
	}
	
	
	function btn_composicion_tuc()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();//recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='maestro_id_tipo_unidad_constructiva='+SelectionsRecord.data.id_tipo_unidad_constructiva;
			data=data+'&maestro_codigo='+SelectionsRecord.data.codigo;
			data=data+'&maestro_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={
				ventana:{
					width:'90%',
					height:'70%'
				}
			};
			layout_tipo_unidad_constructiva.loadWindows(direccion+'../../../vista/composicion_tuc/composicion_tuc_det.php?'+data,'Composicion',ParamVentana);
			layout_tipo_unidad_constructiva.getVentana().on('resize',function(){
			layout_tipo_unidad_constructiva.getLayout().layout();
				})
		}
	else
		{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	/*function btn_tipo_unidad_cons_reemp()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();//recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='maestro_id_tipo_unidad_constructiva='+SelectionsRecord.data.id_tipo_unidad_constructiva;
			data=data+'&maestro_codigo='+SelectionsRecord.data.codigo;
			data=data+'&maestro_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={
				ventana:{
					width:'90%',
					height:'70%'
				}
			};
			layout_tipo_unidad_constructiva.loadWindows(direccion+'../../../vista/tipo_unidad_cons_reemp/tipo_unidad_cons_reemp_det.php?'+data,'Unidad Constructiva Reemplazo',ParamVentana);
			layout_tipo_unidad_constructiva.getVentana().on('resize',function(){
			layout_tipo_unidad_constructiva.getLayout().layout();
				})
		}
	else
		{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}*/
	
	function btn_componente()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();//recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='maestro_id_tipo_unidad_constructiva='+SelectionsRecord.data.id_tipo_unidad_constructiva;
			data=data+'&maestro_codigo='+SelectionsRecord.data.codigo;
			data=data+'&maestro_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={
				ventana:{
					width:'90%',
					height:'70%'
				}
			}
			layout_tipo_unidad_constructiva.loadWindows(direccion+'../../../vista/componente/componente_det.php?'+data,'Componente',ParamVentana);
			layout_tipo_unidad_constructiva.getVentana().on('resize',function(){
			layout_tipo_unidad_constructiva.getLayout().layout();
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
	for(i=0;i<vectorAtributos.length;i++)
		{componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
		sm=getSelectionModel();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_unidad_constructiva.getLayout();
		};
		
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
		        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_composicion_tuc,true,'composicion_tuc','Composicion Unidad Constructiva');
		        //this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_tipo_unidad_cons_reemp,true,'tipo_unidad_cons_reemp','Reemplazo Unidad Constructiva');
		        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_componente,true,'componente','Componentes de la Unidad');

				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_tipo_unidad_constructiva.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}