<?php
/**
 * Nombre:		  	    kardex_logico_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 15:20:24
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
	var maestro={id_almacen_logico:<?php echo $m_id_almacen_logico;?>,codigo:'<?php echo $m_codigo;?>',nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_kardex_logico_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_kardex_logico_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-26 15:20:26
*/
function pagina_kardex_logico_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_kardex_logico;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/kardex_logico/ActionListarKardexLogico_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_kardex_logico',
			totalRecords:'TotalCount'
		},[
		'id_kardex_logico',
		'estado_item',
		'stock_minimo',
		'cantidad',
		'costo_unitario',
		'costo_total',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'id_almacen_logico',
		'desc_almacen_logico',
		'reservado',
		'gestion'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina, 
			CantFiltros:paramConfig.CantFiltros,
			m_id_almacen_logico:maestro.id_almacen_logico
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Almacén Lógico',maestro.id_almacen_logico],['Codigo',maestro.codigo],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	// Definición de datos //

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_kardex_logico',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_kardex_logico'
	};

	vectorAtributos[1]={
		validacion:{
			name:'id_almacen_logico',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		form:false,
		tipo:'Field',
		filtro_0:false
	};

	vectorAtributos[2]={
		validacion:{
			name:'desc_item',
			fieldLabel:'Item',
			allowBlank:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ITEM.codigo'
	};

	vectorAtributos[3]={
		validacion:{
			name:'estado_item',
			fieldLabel:'Estado del Item',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.estado_item'
	};

	vectorAtributos[4]={
		validacion:{
			name:'stock_minimo',
			fieldLabel:'Stock Minimo',
			grid_visible:true,
			grid_editable:false,
			width_grid:90
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.stock_minimo'
	};

	vectorAtributos[5]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			grid_visible:true,
			grid_editable:false,
			width_grid:80
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.cantidad'
	};

	vectorAtributos[6]={
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Costo Unitario',
			allowBlank:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.costo_unitario'
	};

	vectorAtributos[7]={
		validacion:{
			name:'costo_total',
			fieldLabel:'Costo Total',
			grid_visible:true,
			grid_editable:false,
			width_grid:80
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.costo_total'
	};

	vectorAtributos[8]={
		validacion:{
			name:'reservado',
			fieldLabel:'Reservado',
			grid_visible:true,
			grid_editable:false,
			width_grid:80
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'KARDEX.reservado'
	};

	vectorAtributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:120,
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'KARDEX.fecha_reg',
		dateFormat:'m-d-Y'
	};

	vectorAtributos[10]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			grid_visible:true,
			grid_editable:false,
			width_grid:80
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'PARALM.gestion'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Almacenes Lógicos (Maestro)',titulo_detalle:'Kardex (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_kardex_logico=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_kardex_logico.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_kardex_logico,idContenedor);
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
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	var paramFunciones={Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:450,minWidth:150,minHeight:400,closable:true,titulo:'Kardex Lógico'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_almacen_logico=datos.m_id_almacen_logico
		maestro.codigo=datos.m_codigo;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_logico:maestro.id_almacen_logico
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Almacén Lógico',maestro.id_almacen_logico],['Codigo',maestro.codigo],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]);
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_kardex_logico.getLayout()
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
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	layout_kardex_logico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}