<?php 
/**
 * Nombre:		  	    almacen_ep_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 18:52:52
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
	var paramConfig={TamanoPagina:30,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_almacen_ep(idContenedor,direccion,paramConfig),idContenedor:idContenedor};ContenedorPrincipal.setPagina(elemento)
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_almacen_ep_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 18:52:52
*/
function pagina_almacen_ep(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_almacen_ep,txt_fecha_reg,txt_bloqueado,txt_cerrado;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_ep/ActionListarAlmacenEp.php'}),
		//aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen_ep',totalRecords:'TotalCount'},
		['id_almacen_ep',
		'descripcion',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_almacen',
		'desc_almacen',
		'bloqueado',
		'cerrado',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad'
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
	var ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen',
		totalRecords:'TotalCount'
	}, ['id_almacen','codigo','nombre','descripcion','direccion','via_fil_max','via_col_max','bloqueado','cerrado','nro_prest_pendientes','nro_ing_no_finalizados','nro_sal_no_finalizadas','observaciones','fecha_ultimo_inventario','fecha_reg','id_regional'])
	});
	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
	// Template combo
	var resultTplAlm=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	// Definición de datos //

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_almacen_ep',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_ep'
	};

	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='cerrado';
	filterValues[0]='no';
	filterCols[1]='bloqueado';
	filterValues[1]='no';
	vectorAtributos[1]={
		validacion:{
			name:'id_almacen',
			fieldLabel:'Almacén Físico',
			allowBlank:false,
			emptyText:'Almacén Físico...',
			desc:'desc_almacen',
			store:ds_almacen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			typeAhead:true,
			filterCols:filterCols,
			filterValues:filterValues,
			forceSelection:true,
			tpl:resultTplAlm,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:1
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen'
	};

	vectorAtributos[2]={
		validacion:{
			name:'cerrado',
			fieldLabel:'Cerrado',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'95%',
			grid_indice:5
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ALMAEP.cerrado',
		defecto:'No',
		save_as:'txt_cerrado'
	};

	vectorAtributos[3]={
		validacion:{
			name:'bloqueado',
			fieldLabel:'Bloqueado',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'95%',
			grid_indice:6
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ALMAEP.bloqueado',
		defecto:'no',
		save_as:'txt_bloqueado'
	};

	vectorAtributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:180,
			width:'95%',
			grid_indice:2
		},
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'ALMAEP.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'95%',
			grid_indice:3
		},
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'ALMAEP.observaciones',
		save_as:'txt_observaciones'
	};

	vectorAtributos[6]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue: '01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true,
			//grid_indice:7
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ALMAEP.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	
	vectorAtributos[7]={
		validacion:{
			fieldLabel:'EP',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name:'id_ep',
			minChars:1,
			triggerAction:'all',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width:300
		},
		tipo:'epField',
		save_as:'hidden_id_ep1',
		id_grupo:1
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Almacen-EP',grid_maestro:'grid-'+idContenedor};
	layout_almacen_ep=new DocsLayoutMaestroEP(idContenedor);
	layout_almacen_ep.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen_ep,idContenedor);
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
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/almacen_ep/ActionEliminarAlmacenEp.php'},
		Save:{url:direccion+'../../../control/almacen_ep/ActionGuardarAlmacenEp.php'},
		ConfirmSave:{url:direccion+'../../../control/almacen_ep/ActionGuardarAlmacenEp.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['95%','95%'],grupos:[{tituloGrupo:'Almacen',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:1,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,closable:true,titulo:'Almacen-EP'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------///
	function iniciarEventosFormularios(){
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_cerrado=ClaseMadre_getComponente('cerrado');
		txt_bloqueado=ClaseMadre_getComponente('bloqueado')
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(txt_cerrado);
		CM_ocultarComponente(txt_bloqueado);
		ClaseMadre_btnNew()
	}
	this.btnEdit=function(){
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(txt_cerrado);
		CM_ocultarComponente(txt_bloqueado);
		ClaseMadre_btnEdit()
	}
	function btn_almacen_logico(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_ep='+SelectionsRecord.data.id_almacen_ep;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
			var ParamVentana={Ventana:{width:'90%',height:'80%'}}
			layout_almacen_ep.loadWindows(direccion+'../../../vista/almacen_logico/almacen_logico_det.php?'+data,'Almacenes Lógicos',ParamVentana);
			layout_almacen_ep.getVentana().on('resize',function(){layout_almacen_ep.getLayout().layout()})
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_firma_autorizada(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_ep='+SelectionsRecord.data.id_almacen_ep;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
			data=data+'&m_id_financiador='+SelectionsRecord.data.id_financiador;
			data=data+'&m_id_regional='+SelectionsRecord.data.id_regional;
			data=data+'&m_id_programa='+SelectionsRecord.data.id_programa;
			data=data+'&m_id_proyecto='+SelectionsRecord.data.id_proyecto;
			data=data+'&m_id_actividad='+SelectionsRecord.data.id_actividad;
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_almacen_ep.loadWindows(direccion+'../../../vista/firma_autorizada_almep/firma_autorizada_almep.php?'+data,'Firmas Autorizadas de Almacenes',ParamVentana);
			layout_almacen_ep.getVentana().on('resize',function(){layout_almacen_ep.getLayout().layout()})
		}
		else{Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
		//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_almacen_ep.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Almacenes Lógicos',btn_almacen_logico,true,'almacen_logico','');
	this.AdicionarBoton('../../../lib/imagenes/user_add.png','Funcionarios para Autorización',btn_firma_autorizada,true,'fun_autor','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_almacen_ep.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}