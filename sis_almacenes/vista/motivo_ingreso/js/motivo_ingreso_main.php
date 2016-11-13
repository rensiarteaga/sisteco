<?php 
/**
 * Nombre:		  	    motivo_ingreso_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 15:49:42
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
var elemento={pagina:new pagina_motivo_ingreso(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_motivo_ingreso_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-17 15:49:42
*/
function pagina_motivo_ingreso(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_motivo_ingreso,txt_codigo,txt_fecha_reg,txt_nombre;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngreso.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_motivo_ingreso',
			totalRecords:'TotalCount'
		},[
		'id_motivo_ingreso',
		'nombre',
		'descripcion',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'codigo',
		'tipo'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_motivo_ingreso',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_motivo_ingreso'
	};
	// txt nombre
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'55%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MOTING.nombre',
		save_as:'txt_nombre'
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
			width:'30%',
			disabled:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:50
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MOTING.codigo',
		save_as:'txt_codigo'
	};
	// txt descripcion
	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false, 
			width_grid:300
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'MOTING.descripcion',
		save_as:'txt_descripcion'
	};
	// txt estado_registro
	vectorAtributos[4]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado de Registro',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.motivo_ingreso_combo.estado_registro}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MOTING.estado_registro',
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
			grid_editable:false,
			renderer:formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'MOTING.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// txt tipo
	vectorAtributos[6]={
		validacion:{
			name:'tipo',
			fieldLabel:'Tipo de Ingreso',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.motivo_ingreso_combo.tipo}),
			store:new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Compra local','Compra Local'],['Baja','Baja'],['Obsolescecia','Obsolescencia'],['Transferencia','Transferencia'],['Importacion','Importación'],['Extraordinario','Extraordinario'],['Devolucion','Devolución'],['Sobrante','Sobrante'],['Prestamo','Prestamo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false, 
			width_grid:110
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MOTING.tipo',
		defecto:'Compra local',
		save_as:'txt_tipo'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Motivo de Ingreso',grid_maestro:'grid-'+idContenedor};
	layout_motivo_ingreso=new DocsLayoutMaestro(idContenedor);
	layout_motivo_ingreso.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_motivo_ingreso,idContenedor);
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
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/motivo_ingreso/ActionEliminarMotivoIngreso.php'},
		Save:{url:direccion+'../../../control/motivo_ingreso/ActionGuardarMotivoIngreso.php'},
		ConfirmSave:{url:direccion+'../../../control/motivo_ingreso/ActionGuardarMotivoIngreso.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Motivo de Ingreso'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_motivo_ingreso_cuenta(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_motivo_ingreso='+SelectionsRecord.data.id_motivo_ingreso;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_motivo_ingreso.loadWindows(direccion+'../../motivo_ingreso_cuenta/motivo_ingreso_cuenta_det.php?'+data,'Cuentas Motivo Ingreso',ParamVentana);
			layout_motivo_ingreso.getVentana().on('resize',function(){
				layout_motivo_ingreso.getLayout().layout()
			})
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')}
	}
	function btn_firma_autorizada(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_motivo_ingreso='+SelectionsRecord.data.id_motivo_ingreso;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_motivo_ingreso.loadWindows(direccion+'../../firma_autorizada_ing/firma_autorizada_det.php?'+data,'Firmas Autorizadas para el Ingreso',ParamVentana);
			layout_motivo_ingreso.getVentana().on('resize',function(){layout_motivo_ingreso.getLayout().layout()})
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')}
	}
	function iniciarEventosFormularios(){
		txt_codigo=ClaseMadre_getComponente('codigo');	
		txt_nombre=ClaseMadre_getComponente('nombre');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg')
    }
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_motivo_ingreso.getLayout()
	};
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
	//para el manejo de hijos
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
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_motivo_ingreso_cuenta,true,'motivo_ingreso_cuenta','Cuentas - Estructura Programática');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_firma_autorizada,true,'firma_autorizada','Funcionarios para Autorización');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_motivo_ingreso.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}