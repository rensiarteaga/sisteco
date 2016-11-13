<?php
/**
 * Nombre:		  	    eeff_opera_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				MTSLC
 * Fecha creación:		2013-03-07 
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
		id_eeff_linea:'<?php echo $m_id_eeff_linea;?>',
		id_eeff:'<?php echo $m_id_eeff;?>',
		linea_desope:'<?php echo $m_linea_desope;?>'
	};
	var elemento={idContenedor:idContenedor,pagina:new pagina_eeff_opera(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_eeff_opera.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_eeff_opera(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var vectorAtributos=new Array;
	var ds,ds_auxiliar;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_compara/ActionListarEeffOpera.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_eeff_opera',
			totalRecords:'TotalCount'
		},[
		'id_eeff_opera',
		'id_eeff_linea',
		'id_cuenta_act',
		'descta_act',
		'id_cuenta_uno',
		'descta_ant',
		'linea_opera'
		]),remoteSort:true});
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_eeff_linea:maestro.id_eeff_linea
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
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Título de Linea:',maestro.linea_desope]]}),cm:cmMaestro});
	gridMaestro.render();
	
	//DATA STORE COMBOS	
	var ds_cuenta_act = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux']),baseParams:{m_id_eeff:maestro.id_eeff,m_vigente:'si'}});
	
	var ds_cuenta_ant = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux']),baseParams:{m_id_eeff:maestro.id_eeff,m_vigente:'no'}});
	
	//FUNCIONES RENDER
	function render_id_cuenta_act(value, p, record){return String.format('{0}', record.data['descta_act']);}
	var tpl_id_cuenta_act=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_cuenta_ant(value, p, record){return String.format('{0}', record.data['descta_ant']);}
	var tpl_id_cuenta_ant=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_dato(value, p, record){	
		if(value==1){return 'SUMA';}
		if(value==2){return 'RESTA';}
	}
	
	// Definición de datos //
	//en la posicion 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_eeff_opera',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_eeff_opera'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'id_eeff_linea',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_eeff_linea,
		save_as:'id_eeff_linea'
	};
	
	vectorAtributos[2]={
		validacion:{
 			name:'id_cuenta_act',
			fieldLabel:'Cuenta Vigente',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'descta_act', 		
			store:ds_cuenta_act,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta_act,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta_act,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:300,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_cuenta_act'
	};
	
	vectorAtributos[3]={
		validacion:{
 			name:'id_cuenta_uno',
			fieldLabel:'Cuenta Anterior',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'descta_ant', 		
			store:ds_cuenta_ant,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta_ant,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta_ant,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:300,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		save_as:'id_cuenta_uno'
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'linea_opera',
			fieldLabel:'Operación',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'SUMA'],[2,'RESTA']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_dato,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_opera'
	};
	   	
	//----------- FUNCIONES RENDER-----------//	
	function formatDate(value){return value ? value.dateFormat('d-m-Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE-----------//
	var config={
		titulo_maestro:'EEFF Comparativo (Maestro)',
		titulo_detalle:'Operación de Lineas (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_eeff_opera=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_eeff_opera.init(config);	
	
	//---------- INICIAMOS HERENCIA------------//
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_eeff_opera,idContenedor);
	
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
		btnEliminar:{url:direccion+'../../../control/eeff_compara/ActionEliminarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
		Save:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
		ConfirmSave:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:500,height:250,closable:true,titulo:'Registro de Operaciones'}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_eeff = datos.m_id_eeff;
		maestro.id_eeff_linea = datos.m_id_eeff_linea;
		maestro.linea_desope = datos.m_linea_desope;
		
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Título de Linea:',maestro.linea_desope]]);
		
		ds_cuenta_act.baseParams={
				m_id_eeff:maestro.id_eeff,
				m_vigente:'si'
		}
		ds_cuenta_ant.baseParams={
				m_id_eeff:maestro.id_eeff,
				m_vigente:'no'
		}
		
		vectorAtributos[1].defecto=maestro.id_eeff_linea;
		
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/eeff_compara/ActionEliminarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
				Save:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
				ConfirmSave:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffOpera.php',parametros:'&id_eeff='+maestro.id_eeff},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,width:500,height:250,closable:true,titulo:'Registro de Operaciones'}
		};
		this.InitFunciones(paramFunciones)
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_eeff_linea:maestro.id_eeff_linea
		}};
		
		this.btnActualizar()
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	//para iniciar eventos en el formulario
	function iniciarEventosFormularios(){}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_eeff_opera.getLayout()
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
	layout_eeff_opera.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)	
}