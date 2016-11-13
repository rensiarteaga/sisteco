<?php 
/**
 * Nombre:		  	    motivo_salida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 10:10:18
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
var elemento={pagina:new pagina_motivo_salida(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_motivo_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 10:10:18
*/
function pagina_motivo_salida(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
    var ds;
	var elementos=new Array();
	var sw=0;
	var layout_motivo_salida,txt_fecha_reg,txt_nombre,txt_codigo;
//  DATA STORE //
ds=new Ext.data.Store({
	proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_salida/ActionListarMotivoSalida.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_motivo_salida',
		totalRecords:'TotalCount'
	},[
	'id_motivo_salida',
	'nombre',
	'descripcion',
	'estado_registro',
	{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
	'codigo'
	]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	// Definición de datos //
	// hidden id_motivo_salida
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_motivo_salida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_motivo_salida'
	};
	// txt codigo
	vectorAtributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:50
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MOTSAL.codigo',
		save_as:'txt_codigo'
	};
	// txt nombre
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:2,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MOTSAL.nombre',
		save_as:'txt_nombre'
	};
	// txt descripcion
	vectorAtributos[3]={
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
			grid_indice:3,
			width_grid:300
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'MOTSAL.descripcion',
		save_as:'txt_descripcion'
	};
	// txt estado_registro
	vectorAtributos[4]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado de Registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.motivo_salida_combo.estado_registro}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			grid_indice:4,
			width_grid:110
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MOTSAL.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	}; 
	// txt fecha_reg
	vectorAtributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:true,
			renderer:formatDate,
			width_grid:110,
			grid_indice:5,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'MOTSAL.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Motivo de Salida',grid_maestro:'grid-'+idContenedor};
	layout_motivo_salida=new DocsLayoutMaestro(idContenedor);
	layout_motivo_salida.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_motivo_salida,idContenedor);
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
	var ClaseMadre_btnEdit=this.btnEdit;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/motivo_salida/ActionEliminarMotivoSalida.php'},
		Save:{url:direccion+'../../../control/motivo_salida/ActionGuardarMotivoSalida.php'},
		ConfirmSave:{url:direccion+'../../../control/motivo_salida/ActionGuardarMotivoSalida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Motivo de Salida'}};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
	   txt_nombre=ClaseMadre_getComponente('nombre');
       txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
       txt_codigo=ClaseMadre_getComponente('codigo'); 
	}
	function btn_motivo_salida_cuenta(){
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_motivo_salida='+SelectionsRecord.data.id_motivo_salida;
				data=data+'&m_nombre='+SelectionsRecord.data.nombre;
				data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}}
				layout_motivo_salida.loadWindows(direccion+'../../motivo_salida_cuenta/motivo_salida_cuenta_det.php?'+data,'Cuentas del  Motivo Salida',ParamVentana);
				layout_motivo_salida.getVentana().on('resize',function(){
				layout_motivo_salida.getLayout().layout()
				})
			}
			else
			{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')}
		}
	function btn_firma_autorizada(){
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_motivo_salida='+SelectionsRecord.data.id_motivo_salida;
				data=data+'&m_nombre='+SelectionsRecord.data.nombre;
				data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}}
				layout_motivo_salida.loadWindows(direccion+'../../firma_autorizada_sal/firma_autorizada_sal_det.php?'+data,'Funcionarios para Autorización',ParamVentana);
				layout_motivo_salida.getVentana().on('resize',function(){
					layout_motivo_salida.getLayout().layout();
				})
			}
			else
			{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')}
		}
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_reg);
		txt_codigo.enable();
		txt_nombre.enable();
		ClaseMadre_btnNew()
		};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_fecha_reg);
		txt_codigo.disable();
		txt_nombre.disable();
		ClaseMadre_btnEdit()
		};
	this.getLayout=function(){return layout_motivo_salida.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_motivo_salida_cuenta,true,'motivo_salida_cuenta','Cuentas - Estructura Programática');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_firma_autorizada,true,'firma_autorizada','Funcionarios para Autorización');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_motivo_salida.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}