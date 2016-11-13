<?php
/**
 * Nombre:		  	    lectura_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-17 15:14:26
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
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:24,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaLecturaDepurada(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_gerencia_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-17 15:14:26
 */
function PaginaLecturaDepurada(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_lectura_depurada,ds_empleado;
	var elementos=new Array();
	var combo_empleado;
	var combo_observaciones;
	var combo_tipo_movimiento;
	var combo_turno;
	var h_txt_hora;
	var h_txt_fecha;
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/lectura_depurada/ActionListarLecturaDepurada.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lectura_depurada',totalRecords:'TotalCount'},
		[
		'id_lectura_depurada',
		'id_empleado',
		'desc_empleado',
		'codigo_empleado',
		{name:'fecha', type:'date', dateFormat:'Y-m-d'},
		'hora',
		'tipo_movimiento',
		'observaciones',
		'turno','aprobado']),remoteSort:true});		
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
	/////DATA STORE COMBOS////////////
	ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/lectura_depurada/ActionListarLecturaDepuradaEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_empleado','email1'])
	});
	//FUNCIONES RENDER
	function render_id_empleado(value,p,record){return String.format('{0}',record.data['desc_empleado'])}
	var resultTplEmp=new Ext.Template('<div class="search-item">','<b><i>{desc_empleado}</i></b>','<br><FONT COLOR="#B5A642">Email:{email1}</FONT>','</div>');
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_lectura_depurada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_depurada'
	};
	// txt id_empleado
	vectorAtributos[1]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc:'desc_empleado',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_empleado',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplEmp,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width:200,
			width_grid:230,
			grid_indice:1
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'EMPLEA.nombre_completo',
		defecto:'',
		save_as:'txt_id_empleado'
	};
///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:70,
			disabled:false,
			grid_indice:2
			},
		tipo:'DateField',
		filtro_0:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y',
		defecto:""
	};
	 /////////// txt observaciones //////
	vectorAtributos[3]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Vacacion','Vacacion'],['Comision de Viaje','Comision de Viaje'],['Comision Sindical','Comision Sindical'],['Baja Medica','Baja Medica'],['Capacitacion','Capacitacion'],['Otro','Otro'],['Ninguna','Ninguna']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:5
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'observaciones',
		save_as:'txt_observaciones',
		defecto:""
	};
		/////////// txt turno //////
	vectorAtributos[4]={
		validacion:{
			name:'turno',
			fieldLabel:'Turno',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			disabled:true,
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Mañana','Mañana'],['Tarde','Tarde'],['Jornada Completa','Jornada Completa']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:150
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'turno',
		save_as:'txt_turno',
		defecto:""
	};
		/////////// txt hora //////
	vectorAtributos[5]={
		validacion:{
			name:'hora',
			fieldLabel:'Hora',
			emptyText:'Hora...',
			allowBlank:true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		save_as:'txt_hora',
		defecto:""
	};
   ///////// txt tipo_movimiento //////
	vectorAtributos[6]={
		validacion:{
			name:'tipo_movimiento',
			fieldLabel:'Tipo Movimiento',
			typeAhead:true,
			emptyText:'Movimiento...',
			loadMask:true,
			allowBlank:true,
			disabled:false,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Entrada','Entrada'],['Salida','Salida']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'tipo_movimiento',
		save_as:'txt_tipo_movimiento',
		defecto:""
	};
	/////////// txt aprobado //////
	vectorAtributos[7]={
		validacion:{
			name:'aprobado',
			fieldLabel:'Aprobado',
			checked:false,
			renderer:formatBoolean,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:70,
			grid_indice:6	
		},
		tipo:'Checkbox',
		save_as:'txt_aprobado'
		};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	function formatBoolean(value){
		if(value==true){
			value='si'
		}
		else{
			value='no'
		}
		return value
	}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Depuracion Registros',grid_maestro:'grid-'+idContenedor};
	layout_lectura_depurada=new DocsLayoutMaestro(idContenedor);
	layout_lectura_depurada.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_lectura_depurada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/lectura_depurada/ActionEliminarLecturaDepurada.php"},
		Save:{url:direccion+"../../../control/lectura_depurada/ActionGuardarLecturaDepurada.php"},
		ConfirmSave:{url:direccion+"../../../control/lectura_depurada/ActionGuardarLecturaDepurada.php"},
		Formulario:{html_apply:"dlgInfo"+idContenedor,width:485,height:295,minWidth:150,minHeight:200,fileUpload:false,labelWidth:78,closable:true}
	};
	this.btnNew=function(){
		combo_tipo_movimiento.store.reload();
		combo_observaciones.store.reload();
		combo_tipo_movimiento.store.reload();
		combo_turno.store.reload();
	    h_txt_hora.enable();
		combo_empleado.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnNew()
	};
this.btnEdit=function(){
	    combo_tipo_movimiento.store.reload();
		combo_observaciones.store.reload();
		combo_tipo_movimiento.store.reload();
		combo_turno.store.reload();
	   	combo_empleado.disable();
		h_txt_hora.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnEdit()
	};
	this.SaveAndOther=function(){
	combo_tipo_movimiento.store.reload();
	combo_observaciones.store.reload();
	combo_tipo_movimiento.store.reload();
	combo_turno.store.reload();
	ClaseMadre_SaveAndOther()
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_empleado=ClaseMadre_getComponente('id_empleado');
		combo_observaciones=ClaseMadre_getComponente('observaciones');
		combo_tipo_movimiento=ClaseMadre_getComponente('tipo_movimiento');
		combo_turno=ClaseMadre_getComponente('turno');
		h_txt_hora=ClaseMadre_getComponente('hora');
		h_txt_fecha=ClaseMadre_getComponente('fecha');		
		function opcion_obs(){
			if(combo_observaciones.getValue()=='Vacacion' || combo_observaciones.getValue()=='Comision de Viaje' || combo_observaciones.getValue()=='Comision Sindical' || combo_observaciones.getValue()=='Baja Medica' || combo_observaciones.getValue()=='Capacitacion' || combo_observaciones.getValue()=='Otro'){
				combo_tipo_movimiento.allowBlank=true;
				combo_tipo_movimiento.disable();
				combo_turno.enable();
				h_txt_hora.allowBlank=true;
				h_txt_hora.disable()
			}
			else{
			if (combo_observaciones.getValue()=='Ninguna'){
				combo_tipo_movimiento.allowBlank=false;
				combo_tipo_movimiento.enable();
				combo_tipo_movimiento.setValue('');
				combo_observaciones.setValue('');
				combo_turno.disable();
				h_txt_hora.allowBlank=false;
				h_txt_hora.enable();
				h_txt_hora.setValue('')
			}
			}
		}
		//Define los eventos de los componentes para ejecutar acciones
		combo_observaciones.on('change',opcion_obs);
		combo_observaciones.on('select',opcion_obs)
	}
	this.getLayout=function(){return layout_lectura_depurada.getLayout()};
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
   	this.iniciaFormulario();
   	iniciarEventosFormularios();
	layout_lectura_depurada.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}