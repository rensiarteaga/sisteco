<?php 
/**
 * Nombre:		  	    salida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:08:17
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
	}?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_salida_finalizada(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_salida_finalizada(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var url;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida/ActionListarSalidaFinalizada.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_salida',totalRecords: 'TotalCount'},
		[
		// define el mapeo de XML a las etiquetas (campos)
		'id_salida',
		'correlativo_sal',
		'correlativo_vale',
		{name: 'fecha_entregado',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'contabilizar',
		'contabilizado',
		'estado_salida',
		'tipo_entrega',
		'estado_registro',
		'motivo_cancelacion',
		'id_responsable_almacen',
		'desc_responsable_almacen',
		'id_almacen_logico',
		'desc_almacen_logico',
		'id_empleado',
		'desc_empleado',
		'id_firma_autorizada',
		'desc_firma_autorizada',
		'id_contratista',
		'desc_contratista',
		'id_tipo_material',
		'desc_tipo_material',
		'id_institucion',
		'desc_institucion',
		'desc_subactividad',
		'id_subactividad',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',
		'nro_cuenta',
		'emergencia',
		'desc_motivo_salida',
		'tipo_pedido',
		'tipo_entrega'
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

	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name:'id_salida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
	};

	vectorAtributos[1]={
		validacion:{
			name:'correlativo_vale',
			fieldLabel:'Corr. Vale',
			grid_visible:false,
			grid_editable:true,
			width_grid:70,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.correlativo_vale',
		save_as:'txt_correlativo_vale'
	};

	vectorAtributos[2]= {
		validacion:{
			name:'fecha_entregado',
			fieldLabel:'Fecha de Entrega',
			width_grid:130,
			grid_indice:11
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.fecha_entregado',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_entregado'
	};

	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:180
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Almacen Lógico',
			name:'desc_almacen_logico',
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
		save_as:'txt_id_almacen_logico'
	};

	vectorAtributos[5]= {
		validacion: {
			fieldLabel:'Funcionario',
			name:'desc_empleado',
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'EMPLEA.id_persona',
		save_as:'txt_id_empleado'
	};

	vectorAtributos[6]= {
		validacion: {
			name:'desc_contratista',
			fieldLabel:'Contratista',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CONTRA.codigo',
		save_as:'txt_id_contratista'
	};

	vectorAtributos[7]= {
		validacion: {
			name:'desc_institucion',
			fieldLabel:'Institución',
			grid_visible:true,
			grid_editable:false,
			grid_indice:5,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		save_as:'txt_id_institucion'
	};

	vectorAtributos[8]= {
		validacion: {
			name:'desc_tipo_material',
			fieldLabel:'Tipo Material',
			grid_visible:true,
			grid_indice:8,
			grid_editable:false,
			width_grid:110
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'TIPMAT.nombre',
		save_as:'txt_id_tipo_material'
	};

	vectorAtributos[9]= {
		validacion: {
			name:'desc_motivo_salida_cuenta',
			fieldLabel:'Cuenta',
			grid_visible:true,
			grid_indice:7,
			grid_editable:false,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'MOSACU.descripcion',
		save_as:'txt_id_motivo_salida_cuenta'
	};

	vectorAtributos[10]= {
		validacion: {
			fieldLabel:'Firma Autorizada',
			name: 'desc_firma_autorizada',
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'FIRAUT.descripcion',
		save_as:'txt_id_firma_autorizada'
	};

	vectorAtributos[11]={
		validacion:{
			name:'estado_salida',
			fieldLabel:'Estado',
			grid_visible:false,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:false,
		filterColValue:'SALIDA.estado_salida',
		save_as:'txt_codigo'
	};

	vectorAtributos[12]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado registro',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.estado_registro',
		save_as:'txt_estado_registro'
	};

	vectorAtributos[13]={
		validacion:{
			name:'emergencia',
			fieldLabel:'Emergencia',
			grid_visible:true,
			grid_editable:false,
			grid_indice:9,
			align:'center',
			width_grid:80
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.emergencia',
		save_as:'txt_emergencia'
	};

	vectorAtributos[14]={
		validacion: {
			fieldLabel:'Motivo Salida',
			name: 'desc_motivo_salida',
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'MOTSAL.nombre'
	};

	vectorAtributos[15]={
		validacion: {
			fieldLabel:'Tipo Pedido',
			name: 'tipo_pedido',
			grid_visible:true,
			grid_editable:false,
			grid_indice:16,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.tipo_pedido'
	};

	vectorAtributos[16]={
		validacion: {
			fieldLabel:'Tipo Entrega',
			name: 'tipo_entrega',
			grid_visible:true,
			grid_editable:false,
			grid_indice:17,
			width_grid:200
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.tipo_entrega'
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
		titulo_maestro:'Finalización de Salida',
		grid_maestro:'grid-'+idContenedor
	};
	layout_salida_finalizada=new DocsLayoutMaestro(idContenedor);
	layout_salida_finalizada.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_finalizada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var Cm_Destroy=this.Destroy;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={actualizar:{crear:true,separador:false}};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/salida/ActionEliminarSalida.php'},
		Save:{url:direccion+'../../../control/salida/ActionGuardarSalida.php'},
		ConfirmSave:{url:direccion+'../../../control/salida/ActionGuardarSalida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,minWidth:150,minHeight:200,closable:true,titulo:'Finalización de Salida'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_detalle_entregado(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_estado_reg='+SelectionsRecord.data.estado_registro;

			var ParamVentana={Ventana:{width:'70%',height:'60%'}}

			if(SelectionsRecord.data.tipo_pedido=='Item'){
				url='../../salida_finalizada_detalle/salida_finalizada_detalle_det.php?';
			}else{
				if(SelectionsRecord.data.tipo_pedido=='Tipo Unidad Constructiva'){
					url='../../salida_pendiente_detalle/salida_pendiente_det_tuc.php?';///cambiar!!!!
				}
				else{//Unidad Constructiva
					url:'../../salida_pendiente_detalle/salida_pendiente_detalle_det2.php?';//cambiar...
				}
			}

			layout_salida_finalizada.loadWindows(direccion+url+data,'Detalles de Entrega de Materiales',ParamVentana);
			layout_salida_finalizada.getVentana().on('resize',function(){
				layout_salida_finalizada.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	function btn_finalizar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(componentes[10].getValue()=='Entregado'){
				if(confirm("¿Está seguro de Finalizar la Salida?"))
				{
					var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
					var data = "cantidad_ids=1&hidden_id_salida_0=" + SelectionsRecord.data.id_salida;
					Ext.Ajax.request({url:direccion+"../../../control/salida/ActionFinalizarSalida.php",
					params:data,
					method:'POST',
					success:finalizado,
					failure:ClaseMadre_conexionFailure,
					timeout:100000})
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'El material no tiene estado Entregado.')
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	function finalizado(resp)
	{
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Salida Finalizada Satisfactoriamente.<br>');
		ClaseMadre_btnActualizar()
	}

	function iniciarPaginaSalidaFinalizada()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_salida_finalizada.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.Destroy=function(){delete this.pagina;	Cm_Destroy()};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle del Pedido',btn_detalle_entregado,true,'det_ped','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finaliza el Pedido',btn_finalizar,true,'fin_ped','');
	this.iniciaFormulario();

	iniciarPaginaSalidaFinalizada()
	layout_salida_finalizada.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}