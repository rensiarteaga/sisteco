<?php 
/**
 * Nombre:		  	    transferencia_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-21 08:59:18
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_transferencia_seg(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_transferencia_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-11-21 08:59:18
*/
function pagina_transferencia_seg(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var data_ep_origen;
	var data_ep_destino;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transferencia/ActionListarTransfSeguimiento.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transferencia',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_transferencia',
		'prestamo',
		'estado_transferencia',
		'motivo',
		'descripcion',
		'observaciones',
		{name: 'fecha_pendiente_sal',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_pendiente_ing',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_finalizado_anulado',type:'date',dateFormat:'Y-m-d'},
		'id_empleado',
		'desc_empleado',
		'id_firma_autorizada_transf',
		'desc_firma_autorizada',
		'id_almacen_logico',
		'desc_almacen_logico_orig',
		'id_almacen_logico_destino',
		'desc_almacen_logico_dest',
		'id_motivo_ingreso_cuenta',
		'desc_motivo_ingreso_cuenta',
		'desc_almacen_orig',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'desc_almacen_dest',
		'nombre_financiador_dest',
		'nombre_regional_dest',
		'nombre_programa_dest',
		'nombre_proyecto_dest',
		'nombre_actividad_dest',
		'id_financiador_dest',
		'id_regional_dest',
		'id_programa_dest',
		'id_proyecto_dest',
		'id_actividad_dest',
		'codigo_financiador_dest',
		'codigo_regional_dest',
		'codigo_programa_dest',
		'codigo_proyecto_dest',

		'codigo_actividad_dest',
		{name: 'fecha_borrador',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_pendiente',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_rechazado',type:'date',dateFormat:'Y-m-d'},
		'id_ingreso',
		'id_salida',
		'id_tipo_material',
		'desc_tipo_material',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',

		'desc_motivo_ingreso',
		'desc_motivo_salida',
		'correlativo_ing',
		'correlativo_sal'

		]),remoteSort:true
	});

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

	// hidden id_transferencia
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_transferencia',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		id_grupo:3,
		save_as:'hidden_id_transferencia'
	};

	vectorAtributos[1]= {
		validacion:{
			name:'desc_almacen_orig',
			fieldLabel:'Almacen Físico Origen',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:1
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMACE.nombre',
		save_as:'txt_desc_almacen_orig',
		id_grupo:0
	};

	vectorAtributos[2]= {
		validacion:{
			name:'desc_almacen_dest',
			fieldLabel:'Almacen Físico Destino',
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:100
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMACE1.nombre',
		save_as:'txt_desc_almacen_dest',
		id_grupo:1
	};

	vectorAtributos[3] = {
		validacion: {
			name:'desc_almacen_logico_orig',
			fieldLabel:'Almacén Lógico Origen',
			grid_visible:true,
			grid_editable:true,
			grid_indice:2,
			width_grid:150
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMLOG.nombre',
		defecto: '',
		save_as:'txt_desc_almacen_logico_orig',
		id_grupo:0
	};


	vectorAtributos[4]= {
		validacion: {
			name:'desc_almacen_logico_dest',
			fieldLabel:'Almacén Lógico Destino',
			grid_visible:true,
			grid_editable:true,
			grid_indice:4,
			width_grid:150
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMLOG1.nombre',
		save_as:'txt_desc_almacen_logico_dest',
		id_grupo:1
	};


	// txt prestamo
	vectorAtributos[5]= {
		validacion: {
			name:'prestamo',
			fieldLabel:'Préstamo',
			grid_visible:true,
			grid_editable:true,
			grid_indice:6,
			width_grid:60
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'TRANSF.prestamo',
		save_as:'txt_prestamo',
		id_grupo:2
	};

	// txt motivo
	vectorAtributos[6]= {
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			width_grid:120
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'TRANSF.motivo',
		save_as:'txt_motivo',
		id_grupo:2
	};

	// txt descripcion
	vectorAtributos[7]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			grid_visible:true,
			grid_editable:true,
			grid_indice:5,
			width_grid:150
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		filterColValue:'TRANSF.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
	};

	// txt observaciones
	vectorAtributos[8]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			grid_visible:true,
			grid_editable:true,
			grid_indice:9,
			width_grid:150
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		filterColValue:'TRANSF.observaciones',
		save_as:'txt_observaciones',
		id_grupo:2
	};

	// txt id_empleado
	vectorAtributos[9]= {
		validacion: {
			name:'desc_empleado',
			fieldLabel:'Empleado',
			grid_visible:true,
			grid_editable:true,
			grid_indice:11,
			width_grid:130
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'PERSON1.nombre#PERSON1.apellido_paterno#PERSON1.apellido_materno',
		save_as:'txt_desc_empleado',
		id_grupo:4
	};

	vectorAtributos[10]= {
		validacion:{
			name:'nombre_almacen',
			fieldLabel:'nombre_almacen',
			grid_visible:false,
			grid_editable:true,
			width_grid:150
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_almacen',
		id_grupo:3
	};

	vectorAtributos[11]= {
		validacion:{
			name:'desc_almacen_logico_orig',
			fieldLabel:'Nombre Almacen Logico',
			grid_visible:false,
			grid_editable:true,
			width_grid:150
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_almacen_logico',
		id_grupo:3
	};

	vectorAtributos[12]= {
		validacion:{
			name: 'nombre_financiador',
			fieldLabel: 'Financiador Origen',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_financiador',
		id_grupo:0
	};

	vectorAtributos[13]= {
		validacion:{
			name: 'nombre_regional',
			fieldLabel: 'Regional Origen',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_regional',
		id_grupo:0
	};

	vectorAtributos[14]= {
		validacion:{
			name: 'nombre_programa',
			fieldLabel: 'Programa Origen',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_programa',
		id_grupo:0
	};

	vectorAtributos[15]= {
		validacion:{
			name: 'nombre_proyecto',
			fieldLabel: 'Proyecto Origen',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_id_nombre_proyecto',
		id_grupo:0
	};

	vectorAtributos[16]= {
		validacion:{
			name: 'nombre_actividad',
			fieldLabel: 'Actividad Origen',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_actividad',
		id_grupo:0
	};

	vectorAtributos[17]= {
		validacion:{
			name: 'nombre_financiador_dest',
			fieldLabel: 'Financiador Destino',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_financiador_dest',
		id_grupo:0
	};

	vectorAtributos[18]= {
		validacion:{
			name: 'nombre_regional_dest',
			fieldLabel: 'Regional Destino',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_regional_dest',
		id_grupo:0
	};

	vectorAtributos[19]= {
		validacion:{
			name: 'nombre_programa_dest',
			fieldLabel: 'Programa Destino',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_programa_dest',
		id_grupo:0
	};

	vectorAtributos[20]= {
		validacion:{
			name: 'nombre_proyecto_dest',
			fieldLabel: 'Proyecto Destino',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_id_nombre_proyecto_dest',
		id_grupo:0
	};

	vectorAtributos[21]= {
		validacion:{
			name: 'nombre_actividad_dest',
			fieldLabel: 'Actividad Destino',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_nombre_actividad_dest',
		id_grupo:0
	};

	vectorAtributos[22]= {
		validacion:{
			name: 'desc_motivo_ingreso',
			fieldLabel: 'Motivo ingreso',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_desc_motivo_ingreso',
		id_grupo:0
	};

	vectorAtributos[23]= {
		validacion:{
			name: 'desc_motivo_ingreso_cuenta',
			fieldLabel: 'Cuenta ingreso',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_desc_motivo_ingreso_cuenta',
		id_grupo:0
	};

	vectorAtributos[24]= {
		validacion:{
			name: 'desc_motivo_salida',
			fieldLabel: 'Motivo salida',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_desc_motivo_salida',
		id_grupo:0
	};

	vectorAtributos[25]= {
		validacion:{
			name: 'desc_motivo_salida_cuenta',
			fieldLabel: 'Cuenta salida',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_desc_motivo_salida_cuenta',
		id_grupo:0
	};

	vectorAtributos[26]= {
		validacion:{
			name: 'desc_tipo_material',
			fieldLabel: 'Tipo material',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'TIPMAT.nombre',
		save_as:'txt_desc_tipo_material',
		id_grupo:0
	};

	vectorAtributos[27]= {
		validacion:{
			name: 'fecha_borrador',
			fieldLabel: 'Fecha borrador',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_borrador',
		id_grupo:0
	};

	vectorAtributos[28]= {
		validacion:{
			name: 'estado_transferencia',
			fieldLabel: 'Estado Transferencia',
			grid_visible:false,
			grid_indice:5,
			grid_editable:false
		},
		form:false,
		filtro_0:false,
		tipo: 'Field',
		save_as:'txt_estado_transferencia',
		id_grupo:0
	};

	vectorAtributos[29]= {
		validacion:{
			name: 'fecha_pendiente_sal',
			fieldLabel: 'Fecha pendiente salida',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_pendiente_sal',
		id_grupo:0
	};

	vectorAtributos[30]= {
		validacion:{
			name: 'fecha_pendiente_ing',
			fieldLabel: 'Fecha pendiente ingreso',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_pendiente_ing',
		id_grupo:0
	};

	vectorAtributos[31]= {
		validacion:{
			name: 'fecha_finalizado_anulado',
			fieldLabel: 'Fecha finalizado/anulado',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_finalizado_anulado',
		id_grupo:0
	};

	vectorAtributos[32]= {
		validacion:{
			name: 'desc_firma_autorizada',
			fieldLabel: 'Firma autorizada',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_desc_firma_autorizada',
		id_grupo:0
	};

	vectorAtributos[33]= {
		validacion:{
			name: 'fecha_pendiente',
			fieldLabel: 'Fecha pendiente aprobación',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_pendiente',
		id_grupo:0
	};

	vectorAtributos[34]= {
		validacion:{
			name: 'fecha_rechazado',
			fieldLabel: 'Fecha rechazado',
			renderer:formatDate,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_fecha_rechazado',
		id_grupo:0
	};
	
	vectorAtributos[35]= {
		validacion:{
			name: 'correlativo_sal',
			fieldLabel: 'Salida',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_correlativo_sal',
		id_grupo:0
	};
	
	vectorAtributos[36]= {
		validacion:{
			name: 'correlativo_ing',
			fieldLabel: 'Ingreso',
			grid_visible:true,
			grid_indice:21,
			grid_editable:false
		},
		form:false,
		tipo: 'Field',
		save_as:'txt_correlativo_ing',
		id_grupo:0
	};

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
		titulo_maestro:'transferencia',
		grid_maestro:'grid-'+idContenedor
	};
	layout_transferencia=new DocsLayoutMaestro(idContenedor);
	layout_transferencia.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_transferencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;

	var CM_ocultarComponente=this.ocultarComponente;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones = {
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'80%',
		width:'80%',
		minWidth:150,minHeight:200,	closable:true,titulo:'transferencia',
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


	function btn_transferencia_detalle(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_transferencia='+SelectionsRecord.data.id_transferencia;
			data=data+'&m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
			data=data+'&m_almacen_logico='+SelectionsRecord.data.desc_almacen_logico_orig;

			var ParamVentana={Ventana:{width:'70%',height:'60%'}}
			layout_transferencia.loadWindows(direccion+'../../../vista/transferencia_aprob_det/transferencia_aprob_det.php?'+data,'Detalle Transferencia',ParamVentana);
			layout_transferencia.getVentana().on('resize',function(){
				layout_transferencia.getLayout().layout();
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}


	function InitPaginaTransferencia()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}


		//CM_ocultarComponente(componentes[9]);//Id proveedor
	}

	this.btnNew=function(){

		CM_ocultarGrupo('Oculto');
		ClaseMadre_btnNew();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_transferencia.getLayout();};
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
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de la Transferencia',btn_transferencia_detalle,true,'transferencia_detalle','');
	this.iniciaFormulario();
	InitPaginaTransferencia();
	layout_transferencia.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

