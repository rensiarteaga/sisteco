<?php 
/**
 * Nombre:		  	    tipo_planilla_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-19 11:11:04
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_tipo_planilla(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tipo_planilla.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-19 10:28:39
 */
function pagina_tipo_planilla(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_planilla/ActionListarTipoPlanilla.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_planilla',totalRecords:'TotalCount'
		},[		
				'id_tipo_planilla',
		'nombre',
		'descripcion',
		'estado_reg',
		'fecha_reg',
		'id_usuario',
		'usuario',
		'id_depto',
		'codigo_depto','tipo','basica'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	var ds_depto = new Ext.data.Store(
			{
				proxy: new Ext.data.HttpProxy(
					{url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php'}
			),
			baseParams:{subsistema:'kard'},
			reader:new Ext.data.XmlReader(
					{record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},
					['id_depto','codigo_depto','nombre_depto'])
	});

	//FUNCIONES RENDER
	
	function render_id_usuario(value, p, record){return String.format('{0}',record.data['usuario'])};
	function render_id_depto(value, p, record){return String.format('{0}',record.data['codigo_depto'])};
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b>Código: {codigo_depto}</b><br>','<FONT COLOR="#B5A642">Nombre: {nombre_depto}</FONT>','</div>');

	function render_tipo(value,p,record){
		if(value=='sueldo'){
			return 'Planilla Sueldos y Salarios';
		}
		if(value=='impositiva'){
			   return 'Planilla Impositiva';
		}
		if(value=='aguinaldo'){
		   	   return 'Planilla de Aguinaldo';
		}if(value=='aguinaldo2'){
			   	   return 'Planilla 2° Aguinaldo';//18dic13
		}if(value=='aguinaldo_cons2'){
			   	   return 'Planilla 2° Aguinaldo Consultores';//18dic13
		}
		if(value=='general'){
		       	 return 'Planilla de Sueldo';
		}if(value=='reposicion'){
	       	 return 'Planilla de Reposicion';
		}
		else{
		   	   	return 'Planilla Auxiliar';
		       }
		   
	}
	/////////
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_planilla
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_planilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPLA.nombre'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPLA.descripcion'
	};
// txt estado_reg
	Atributos[3]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPLA.estado_reg',
		defecto:'activo'
	};
// txt fecha_reg
	Atributos[4]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:4		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'TIPPLA.fecha_reg',
	};
// txt id_usuario
	Atributos[5]={
		validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			grid_indice:5,
			renderer:render_id_usuario
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'USUARI.login'
	};
	
	Atributos[6]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'codigo_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'codigo_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codigo_depto'
	};
	
	
	Atributos[7]={
			validacion: {
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['sueldo','Planilla Sueldos y Salarios'],['impositiva','Planilla Impositiva'],['aguinaldo','Planilla de Aguinaldo'],['auxiliar','Planilla Auxiliar'],['general','Planilla de Sueldos'],['aguinaldo2','Planilla 2° Aguinaldo'],['reposicion','Planilla de Reposicion'],['aguinaldo_cons2','Planilla 2° Aguinaldo Consultores']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			renderer:render_tipo,
			width_grid:100,
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPLA.tipo',
		defecto:'tipo'
	};

	Atributos[8]={
			validacion: {
			name:'basica',
			fieldLabel:'Básica',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPPLA.basica',
		defecto:'no'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'tipo_planilla',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'Tipo Planilla',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/columna/columna.php?idSub='+decodeURI('Detalle de Columnas')+'&'};
	var layout_tipo_planilla=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_tipo_planilla.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_planilla,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var cm_EnableSelect=this.EnableSelect;

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
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_planilla/ActionEliminarTipoPlanilla.php'},
		Save:{url:direccion+'../../../control/tipo_planilla/ActionGuardarTipoPlanilla.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_planilla/ActionGuardarTipoPlanilla.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'tipo_planilla'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_columna(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_tipo_planilla='+SelectionsRecord.data.id_tipo_planilla;
			data=data+'&nombre='+SelectionsRecord.data.nombre;
			data=data+'&descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_tipo_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/columna/columna.php?'+data,'Columnas',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_tipo_planilla.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_tipo_planilla.getIdContentHijo()).pagina.desbloquearMenu();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_planilla.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_planilla.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}