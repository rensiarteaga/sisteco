<?php
/**
 * Nombre:		  	    tipo_unidad_cons_reemp_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Anacleto Rojas
 * Fecha creación:		2007-11-07 
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
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:fa
};
var maestro={
	id_padre:'<?php echo $maestro_id_padre;?>',
	id_cuenta:'<?php echo $maestro_id_cuenta;?>',
	nombre_cuenta:'<?php echo $maestro_nombre_cuenta;?>',
	nro_cuenta:'<?php echo $maestro_nro_cuenta;?>',
	estado_gestion:'<?php echo $maestro_estado_gestion;?>'
};
var elemento={idContenedor:idContenedor,pagina:new pagina_cuenta_auxiliar_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_tipo_unidad_cons_reemp_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio
 * Fecha creación:		2007-11-07 
 */
function pagina_cuenta_auxiliar_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var vectorAtributos=new Array;
	var ds,ds_auxiliar;
	var elementos=new Array();
	var componentes=new Array();
	var combo_auxiliar;
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_cuenta_auxiliar',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_auxiliar',
		'id_cuenta',
		'nombre_cuenta',
		'id_auxiliar',
		'nombre_auxiliar',
		'codigo_auxiliar'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_cuenta:maestro.id_cuenta
		}
	});	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
	{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}
	]);	
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'
	}
	function italic(value){
		return '<i>'+value+'</i>'
	}	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Nro. de Cuenta',maestro.nro_cuenta],['Cuenta',maestro.nombre_cuenta]]}),cm:cmMaestro});
	gridMaestro.render();		
	//DATA STORE COMBOS	
	ds_auxiliar=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({
				record:'ROWS',
				id:'id_auxiliar',
				totalRecords:'TotalCount'
			},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar']),baseParams:{m_estado_aux:1}
		});	
	var resultTpl=new Ext.Template(
		'<div class="search-item">',
		'<b><i>{nombre_auxiliar}</i></b>',
		'<b><br>Código: <i>{codigo_auxiliar}</i></b>',
		'<br><FONT COLOR="#B5A642">{email1}</FONT>',
		'</div>'
		);	
	//FUNCIONES RENDER
	function render_auxiliar(value,p,record){return String.format('{0}',record.data['nombre_auxiliar'])};
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cuenta_auxiliar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_cuenta_auxiliar'
	};
	// codigo_auxiliar
	vectorAtributos[1]={
		validacion:{
			name:'codigo_auxiliar',
			fieldLabel:'Código de Auxiliar',
			allowBlank:false,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
			
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar',
		save_as:'txt_codigo_auxiliar',
		form:false
		
	};
	// txt id_tipo_unidad_constructiva_reemplazo
	vectorAtributos[2]={
		validacion:{
				fieldLabel:'Auxiliar de Cuenta',
				allowBlank:false,
				emptyText:'Auxiliar...',
				name:'id_auxiliar',
				desc:'nombre_auxiliar',
				store:ds_auxiliar,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam:'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				tpl:resultTpl,
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'AUXILI.nombre_auxiliar',
			save_as:'txt_id_auxiliar'
	};
	
//	vectorAtributos[1] = param_nro_cuenta;			
  	vectorAtributos[3]={
		validacion:{
			name:'id_cuenta',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_cuenta,
		save_as:'txt_id_cuenta'
	};
	//----------- FUNCIONES RENDER-----------//	
	function formatDate(value){return value ? value.dateFormat('d-m-Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE-----------//
	var config={
		titulo_maestro:'Cuenta (Maestro)',
		titulo_detalle:'Auxiliar de Cuenta (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_cuenta_auxiliar=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cuenta_auxiliar.init(config);		
	//---------- INICIAMOS HERENCIA------------//
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_cuenta_auxiliar,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ------------//	
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};	
	//--------- DEFINICIÓN DE FUNCIONES------------------//
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_auxiliar/ActionEliminarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
		Save:{url:direccion+'../../../control/cuenta_auxiliar/ActionGuardarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
		ConfirmSave:{url:direccion+'../../../control/cuenta_auxiliar/ActionGuardarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:380,height:180,closable:true,titulo:'Auxiliar de Cuenta'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_padre=datos.maestro_id_padre;
		maestro.id_cuenta=datos.maestro_id_cuenta;
		maestro.nombre_cuenta=datos.maestro_nombre_cuenta;
		maestro.nro_cuenta=datos.maestro_nro_cuenta;
		maestro.estado_gestion=datos.maestro_estado_gestion;
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Nro. de Cuenta',maestro.nro_cuenta],['Cuenta',maestro.nombre_cuenta]]);
		vectorAtributos[3].defecto=maestro.id_cuenta;
		
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/cuenta_auxiliar/ActionEliminarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
			Save:{url:direccion+'../../../control/cuenta_auxiliar/ActionGuardarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
			ConfirmSave:{url:direccion+'../../../control/cuenta_auxiliar/ActionGuardarCuentaAuxiliar.php',parametros:'&id_cuenta='+maestro.id_cuenta},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:380,height:180,closable:true,titulo:'Auxiliar de Cuenta'}
		};
		this.InitFunciones(paramFunciones)
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_cuenta:maestro.id_cuenta
				}
			};
		this.btnActualizar()
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		combo_auxiliar=ClaseMadre_getComponente ('id_auxiliar')
	}
	this.btnNew=function(){
		if(maestro.estado_gestion!=3){
			ClaseMadre_btnNew()
		}
		else{
			alert("No se pueden añadir más datos debido a que la Gestión está Cerrada")
		}
	};
	this.btnEdit=function(){
		if(maestro.estado_gestion!=3){
			ClaseMadre_btnEdit()
		}
		else{
			alert("No se pueden modificar los datos debido a que la Gestión está Cerrada")
		}
	};
	this.btnEliminar=function(){
		if(maestro.estado_gestion!=3){
			ClaseMadre_btnEliminar()
		}
		else{
			alert("No se pueden eliminar los datos debido a que la Gestión está Cerrada")
		}
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_cuenta_auxiliar.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cuenta_auxiliar.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)	
}