<?php 
/**
 * Nombre:		  	    gestion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 14:49:32
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
var elemento={pagina:new pagina_gestion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_gestion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 14:49:32
 */
function pagina_gestion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'
		},[		
		'id_gestion',
		'gestion',
		'estado_ges_gral',
		'id_empresa',
		'desc_empresa',
		'id_moneda_base',
		'desc_moneda',
		'estado_vigente'
		]),remoteSort:true});
	
	//DATA STORE COMBOS

    var ds_empresa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/empresa/ActionListarEmpresa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empresa',totalRecords: 'TotalCount'},['id_empresa','razon_social','denominacion','nro_nit','codigo'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
	function render_id_empresa(value, p, record){return String.format('{0}', record.data['desc_empresa']);}
	var tpl_id_empresa=new Ext.Template('<div class="search-item">','<b><i>{denominacion}</b></i>','</div>');

	function render_id_moneda_base(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda_base=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','</div>');
	
	function render_sino(value, p, record){	
		if(value=='no'){return 'NO';}
		if(value=='si'){return 'SI';}		
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_gestion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt gestion
	Atributos[1]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			maxLength:4,
			minLength:4,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion'
		
	};
// txt estado_ges_gral
	Atributos[2]={
			validacion: {
			name:'estado_ges_gral',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			grid_indice:4		
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'GESTIO.estado_ges_gral',
		defecto:'abierto'
	};
// txt id_empresa
	Atributos[3]={
			validacion:{
			name:'id_empresa',
			fieldLabel:'Empresa',
			allowBlank:false,			
			emptyText:'Empresa...',
			desc: 'desc_empresa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empresa,
			valueField: 'id_empresa',
			displayField: 'denominacion',
			queryParam: 'filterValue_0',
			filterCol:'EMPRES.denominacion',
			typeAhead:true,
			tpl:tpl_id_empresa,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empresa,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPRES.denominacion'
		
	};
// txt id_moneda_base
	Atributos[4]={
			validacion:{
			name:'id_moneda_base',
			fieldLabel:'Moneda Base',
			allowBlank:false,			
			emptyText:'Moneda Base...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda_base,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda_base,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre'
	};
	
	Atributos[5]={
		validacion:{
			name:'estado_vigente',
			fieldLabel:'Permitir Registro',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['no','NO'],['si','SI']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:true,
			width_grid:150,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'estado_vigente'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'gestion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/gestion/gestion_firma.php'};
	var layout_gestion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_gestion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_gestion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var cm_btnNew=this.btnNew;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/gestion/ActionEliminarGestion.php'},
		Save:{url:direccion+'../../../control/gestion/ActionGuardarGestion.php'},
		ConfirmSave:{url:direccion+'../../../control/gestion/ActionGuardarGestion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'gestion'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_periodo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_gestion='+SelectionsRecord.data.id_gestion;
			data=data+'&gestion='+SelectionsRecord.data.gestion;
			data=data+'&desc_empresa='+SelectionsRecord.data.desc_empresa;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_gestion.loadWindows(direccion+'../../../../sis_contabilidad/vista/periodo/periodo.php?'+data,'Periodo',ParamVentana);

		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_nuevo(){
		cm_btnNew();
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function(){
			if(_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.limpiarStore()){
				_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.bloquearMenu()
			}
		})
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_gestion.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Periodo',btn_periodo,true,'periodo','Periodos');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Empresa',btn_nuevo,true,'empresa','Iniciar Empresa');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_gestion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}