<?php 
/**
 * Nombre:		  	    subsistema_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:42:22
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
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	     	id_subsistema:<?php echo $m_id_subsistema;?>,nombre_corto:'<?php echo $m_nombre_corto;?>',descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_procedimiento_db(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_procdb_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:42:31
 */
function pagina_procedimiento_db(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/procedimiento_db/ActionListarProcedimiento_db.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'codigo_procedimiento',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'codigo_procedimiento',
		'id_subsistema',
		'nombre_funcion',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'habilitar_log'		
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_subsistema:maestro.id_subsistema
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
//var dataMaestro=[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]];

	//var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_prodb
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			fieldLabel: 'Codigo Procedimiento',
			labelSeparator:'',
			name: 'codigo_procedimiento',
			grid_visible:true, 
			grid_editable:false,
			width_grid:150, // ancho de columna en el gris
			width:'50%'
		},
		tipo: 'Field',
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROCDB.codigo_procedimiento',
		save_as:'codigo_procedimiento'
	};
	
// txt id_subsistema
	vectorAtributos[1]= {
		validacion:{
			name:'id_subsistema',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_subsistema,
		save_as:'id_subsistema'
	};
 
   // txt nombre
	vectorAtributos[2]={
		validacion:{
			name:'nombre_funcion',
			fieldLabel:'Nombre Función',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROCDB.nombre_funcion',
		save_as:'nombre_funcion'
	};
	
// txt nombre_achivo
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid: 350,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROCDB.descripcion',
		save_as:'descripcion'
	};
	
// txt ruta_archivo
	vectorAtributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PROCDB.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};
	
// txt habilitar_log
	vectorAtributos[4]={
			validacion: {
			name:'habilitar_log',
			fieldLabel:'Habilitar Log',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data :[['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			align:'center',
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PROCDB.habilitar_log',
		defecto:'si',
		save_as:'habilitar_log'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Subsistema (Maestro)',
		titulo_detalle:'Procedimientos Base de Datos (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_procdb = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_procdb.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_procdb,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/procedimiento_db/ActionEliminarProcedimiento_db.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
	Save:{url:direccion+'../../../control/procedimiento_db/ActionGuardarProcedimiento_db.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
	ConfirmSave:{url:direccion+'../../../control/procedimiento_db/ActionGuardarProcedimiento_db.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
	Formulario:{
			titulo:'Procedimientos DB',
			html_apply:"dlgInfo-"+idContenedor,
			width:'30%',
			height:'30%',
			minWidth:200,
			minHeight:150,
			columnas:['98%'],
			closable:true,
			grupos:[
			{	tituloGrupo:'Datos Lógicos',
				columna:0,
				id_grupo:0
			}
			
			]
		}
	};
	
	
	this.reload=function(params){
		
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.codigo_procedimiento=datos.codigo_procedimiento;
		maestro.id_subsistema=datos.m_id_subsistema;
		maestro.nombre_corto=datos.m_nombre_corto;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_subsistema:maestro.id_subsistema
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]);
		
		vectorAtributos[1].defecto=maestro.id_subsistema;
		
		 
		paramFunciones.btnEliminar.parametros='&m_id_subsistema='+maestro.id_subsistema;
		paramFunciones.Save.parametros='&m_id_subsistema='+maestro.id_subsistema;
		paramFunciones.ConfirmSave.parametros='&m_id_subsistema='+maestro.id_subsistema;	
		this.InitFunciones(paramFunciones)
	};




	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_procdb.getLayout();
	};

	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	//para agregar botones	
	layout_procdb.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}