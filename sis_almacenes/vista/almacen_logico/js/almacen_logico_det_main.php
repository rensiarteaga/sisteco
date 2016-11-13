<?php
/**
 * Nombre:		  	    almacen_logico_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 18:53:05
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
	var maestro={ 	id_almacen_ep:decodeURIComponent(<?php echo $m_id_almacen_ep;?>),descripcion:decodeURIComponent('<?php echo $m_descripcion;?>'),observaciones:decodeURIComponent('<?php echo $m_observaciones;?>')};
	var elemento={idContenedor:idContenedor,pagina:new pagina_almacen_logico_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento)
}
Ext.onReady(main,main);
 
/**
* Nombre:		  	    pagina_almacen_logico_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 18:53:07
*/
function pagina_almacen_logico_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_almacen_logico,combo_bloqueado,combo_cerrado,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_logico/ActionListarAlmacenLogico_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen_logico',totalRecords:'TotalCount'},
		['id_almacen_logico',
		'codigo',
		'bloqueado',
		'nombre',
		'descripcion',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'obsevaciones',
		'id_almacen_ep',
		'desc_almacen_ep',
		'id_tipo_almacen',
		'desc_tipo_almacen',
		'cerrado',
		'id_unidad_organizacional',
		'desc_unidad_organizacional'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_almacen_ep:maestro.id_almacen_ep
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Almacen EP',maestro.id_almacen_ep],['Descripción',maestro.descripcion],['Observaciones',maestro.observaciones]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	var ds_tipo_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_almacen/ActionListarTipoAlmacen.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_almacen',totalRecords:'TotalCount'},['id_tipo_almacen','nombre','descripcion','tipo_almacen'])
	});
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	//FUNCIONES RENDER
	function render_id_tipo_almacen(value,p,record){return String.format('{0}',record.data['desc_tipo_almacen'])};
	var resultTplTipoAlm=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquía: </b>{nombre_nivel}</FONT>','</div>');

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_almacen_logico',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_logico'
	};

	vectorAtributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo',
		save_as:'txt_codigo'
	};

	vectorAtributos[2]={
		validacion:{
			name:'id_tipo_almacen',
			fieldLabel:'Tipo Almacén',
			allowBlank:false,
			emptyText:'Tipo Almacén...',
			desc:'desc_tipo_almacen',
			store:ds_tipo_almacen,
			valueField:'id_tipo_almacen',
			displayField:'nombre',
			filterCol:'TIPALM.nombre#TIPALM.descripcion',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplTipoAlm,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			width:'85%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'85%',
			grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPALM.nombre#TIPALM.descripcion',
		defecto: '',
		save_as:'txt_id_tipo_almacen'
	};

	vectorAtributos[3]={
		validacion:{
			name:'cerrado',
			fieldLabel:'Cerrado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.almacen_logico_combo.cerrado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Gestion','Gestion'],['No','No'],['Definitivo','Definitivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			grid_indice:3
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.cerrado',
		defecto:'No',
		save_as:'txt_cerrado'
	};

	vectorAtributos[4]={
		validacion:{
			name:'bloqueado',
			fieldLabel:'Bloqueado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.almacen_logico_combo.bloqueado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.bloqueado',
		defecto:'no',
		save_as:'txt_bloqueado'
	};

	vectorAtributos[5]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'85%',
			grid_indice:5
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'ALMLOG.nombre',
		save_as:'txt_nombre'
	};

	vectorAtributos[6]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'85%',
			grid_indice:6
		},
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'ALMLOG.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[7]={
		validacion:{
			name:'obsevaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'85%',
			grid_indice:8
		},
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'ALMLOG.obsevaciones',
		save_as:'txt_obsevaciones'
	};

	vectorAtributos[8]={
		validacion:{
			name:'id_almacen_ep',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_almacen_ep,
		save_as:'txt_id_almacen_ep'
	};

	vectorAtributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer:formatDate,
			width_grid:100,
			disabled:true,
			grid_indice:9
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ALMLOG.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	
		// txt id_unidad_organizacional
	vectorAtributos[10]={
		validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:true,
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional',
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false,
			grid_indice:7
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'txt_id_unidad_organizacional'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Almacenes - Estructura Programática (Maestro)',titulo_detalle:'Almacenes Lógicos (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_almacen_logico=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_almacen_logico.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen_logico,idContenedor);
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
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/almacen_logico/ActionEliminarAlmacenLogico.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
		Save:{url:direccion+'../../../control/almacen_logico/ActionGuardarAlmacenLogico.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
		ConfirmSave:{url:direccion+'../../../control/almacen_logico/ActionGuardarAlmacenLogico.php',parametros:'&m_id_almacen_ep='+maestro.id_almacen_ep},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Almacen Lógico'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_almacen_ep=datos.m_id_almacen_ep;
		maestro.descripcion=datos.m_descripcion;
		maestro.observaciones=datos.m_observaciones;
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Almacen EP',maestro.id_almacen_ep],['Descripción',maestro.descripcion],['Observaciones',maestro.observaciones]]);
		vectorAtributos[8].defecto=maestro.id_almacen_ep;
		paramFunciones.btnEliminar.parametros='&m_id_almacen_ep='+maestro.id_almacen_ep;
		paramFunciones.Save.parametros='&m_id_almacen_ep='+maestro.id_almacen_ep;
		paramFunciones.ConfirmSave.parametros='&m_id_almacen_ep='+maestro.id_almacen_ep;
		this.InitFunciones(paramFunciones);
		 ds.lastOptions={params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_ep:maestro.id_almacen_ep
			}
		};
		this.btnActualizar()
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------///
	function btn_kardex_logico(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			layout_almacen_logico.loadWindows(direccion+'../../../vista/kardex_logico/kardex_logico_det.php?'+data,'Kardex',ParamVentana);
			layout_almacen_logico.getVentana().on('resize',function(){
				layout_almacen_logico.getLayout().layout()
			})
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_bloqueado=ClaseMadre_getComponente('bloqueado');
		combo_cerrado=ClaseMadre_getComponente('cerrado');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		function onCerradoSelect(){
			var cerrado=combo_cerrado.getValue();
			if(cerrado=='si'){
				combo_bloqueado.setValue('si');
				combo_bloqueado.disable()
			}
			else{combo_bloqueado.enable()}
		}
		combo_cerrado.on('select', onCerradoSelect);
		combo_cerrado.on('change', onCerradoSelect)
	}
	this.btnNew=function(){
		CM_ocultarComponente(combo_bloqueado);
		CM_ocultarComponente(combo_cerrado);
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(combo_bloqueado);
		CM_ocultarComponente(combo_cerrado);
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
	};
	this.getLayout=function(){
		return layout_almacen_logico.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/book_open.png','Kardex',btn_kardex_logico,true,'kardex_logico','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_almacen_logico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}