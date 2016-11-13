<?php
/**
 * Nombre:		  	    concepto_ingas_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 15:19:34
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

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
var maestro={
	id_partida:<?php echo utf8_decode($m_id_partida);?>,
	codigo_partida:'<?php echo utf8_decode($m_codigo_partida);?>',
	nombre_partida:'<?php echo utf8_decode($m_nombre_partida);?>',
	nivel_partida:'<?php echo utf8_decode($m_nivel_partida);?>',
	tipo_partida:'<?php echo utf8_decode($m_tipo_partida);?>',
	estado_gral:'<?php echo utf8_decode($m_estado_gral)?>'};
	
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_concepto_ingas_ingreso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_concepto_ingas.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 15:19:34
 */
function pagina_concepto_ingas_ingreso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var txt_id_concepto_ingas,txt_desc_ingas;
	var combo_item,combo_servicio;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_ingas/ActionListarConceptoIngas.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_concepto_ingas',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_concepto_ingas',
		'desc_ingas',
		'id_partida',
		'desc_partida',
		'id_item',
		'desc_item',
		'id_servicio',
		'desc_servicio'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_partida:maestro.id_partida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Partida ',' ' + maestro.codigo_partida + ' - ' + maestro.nombre_partida]];
	//DATA STORE COMBOS
    var ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_almacenes/control/item/ActionListarItem.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});
	var ds_servicio=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_adquisiciones/control/servicio/ActionListarServicio.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre'])
	});
	//FUNCIONES RENDER
		function render_id_item(value,p,record){return String.format('{0}', record.data['desc_item'])}
		function render_id_servicio(value,p,record){return String.format('{0}', record.data['desc_servicio'])}
		var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
		var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','</div>');
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_ingas'
	};
// txt desc_ingas
	Atributos[1]={
		validacion:{
			name:'desc_ingas',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'75%',
			disable:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		save_as:'desc_ingas'
	};
// txt id_partida
	Atributos[2]={
		validacion:{
			name:'id_partida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_partida,
		save_as:'id_partida'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Clasificador Presupuestario de Recursos por Rubro (Maestro)',titulo_detalle:'Conceptos de Ingreso (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_concepto_ingas_ingreso=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_concepto_ingas_ingreso.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_concepto_ingas_ingreso,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/concepto_ingas/ActionEliminarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	Save:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	ConfirmSave:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:230,width:430,minWidth:150,minHeight:200,	closable:true,titulo:'Conceptos de Ingreso'}};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	   	maestro.id_partida=datos.m_id_partida;
       	maestro.codigo_partida=datos.m_codigo_partida;
       	maestro.nombre_partida=datos.m_nombre_partida;
       	maestro.nivel_partida=datos.m_nivel_partida;
       	maestro.tipo_partida=datos.m_tipo_partida;
       	maestro.estado_gral=datos.m_estado_gral;
		data_maestro=[['Partida ',maestro.codigo_partida + ' - ' + maestro.nombre_partida]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[2].defecto=maestro.id_partida;
	   	paramFunciones={
	   	btnEliminar:{url:direccion+'../../../control/concepto_ingas/ActionEliminarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	   	Save:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	   	ConfirmSave:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
       	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:230,width:430,minWidth:150,minHeight:200,	closable:true,titulo:'Conceptos de Ingreso'}};
	   	this.InitFunciones(paramFunciones);
	   	ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_partida:maestro.id_partida
			}
		};
		this.btnActualizar()
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	 txt_id_concepto_ingas=ClaseMadre_getComponente ('id_concepto_ingas');
	 txt_desc_ingas=ClaseMadre_getComponente ('desc_ingas')
	}
		this.btnNew=function(){
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnNew()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para añadir mas datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	this.btnEdit=function(){
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnEdit()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para modificar los datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	this.btnEliminar=function(){
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnEliminar()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para eliminar los datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_concepto_ingas_ingreso.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_concepto_ingas_ingreso.getLayout().addListener('layout',this.onResize);
	layout_concepto_ingas_ingreso.getVentana(idContenedor).on('resize',function(){layout_concepto_ingas.getLayout().layout()})
}