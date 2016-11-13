<?php 
session_start();
?>
//<script>
var PaginaCodigoFabricante;

function main(){
	<?php
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";\n";
	echo "var idContenedor='$idContenedor';\n";
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
	id_item:<?php echo $maestro_id_item;?>,
	nombre:'<?php echo $maestro_nombre;?>',
    descripcion:'<?php echo $maestro_descripcion;?>',
};
idContenedorPadre='<?php echo $idContenedorPadre;?>';


	var elemento={idContenedor:idContenedor,pagina:new PaginaCodigoFabricante(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_codigo_fabricante_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-02 12:04:24
 */
function PaginaCodigoFabricante(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds, txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/codigo_fabricante/ActionListarCodigoFabricante.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_codigo_fabricante',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_codigo_fabricante',
		'codigo',
		'estado_registro',
		'nombre',
		'anio',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_item:maestro.id_item
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO//
	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>'+value+'</i>';
	}
	// create the Grid
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{		
		ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['ID',maestro.id_item],['Item',maestro.nombre],['Descripción',maestro.descripcion]]}),
		cm:cmMaestro
	});
	gridMaestro.render();
	
	/////DATA STORE COMBOS////////////
	ds_item=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
	proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id: 'id_item',
			totalRecords:'TotalCount'

		}, ['id_item','nombre'])
	});
	function renderItem(value, p, record){return String.format('{0}', record.data['desc_item']);}
	///importante el render agarra los valores del store principal.
	// Definición de datos //
	// hidden id_codigo_fabricante
	//en la posición 0 siempre esta la llave primaria
vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_codigo_fabricante',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_codigo_fabricante'
	};
	
	// hidden id_item 
		vectorAtributos[1]={
		validacion:{
			name:'id_item',
			labelSeparator:'',
			inputType:'hidden',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			disabled:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_id_item',
		defecto:maestro.id_item
	};
	
// txt codigo
	vectorAtributos[2]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'cf.codigo',
		save_as:'txt_codigo'
	};
	
// txt nombre
	vectorAtributos[3]= {
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
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'cf.nombre',
		save_as:'txt_nombre'
	};
	
// txt anio
	vectorAtributos[4]={
		validacion:{
			name: 'anio',
			fieldLabel: 'Año',
			allowBlank: true,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1900,
			maxValue: 2050,
			minText: 'La fecha debe ser mayor a 1900',
			maxText: 'La fecha debe ser menor a 2050',
			nanText : 'Fecha no válida',
			minLengthText :'La fecha debe estar en formato yyyy',
			maxLengthText :'La fecha debe estar en formato yyyy',
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 80,
			typeAhead: false,
			//editable:true,
			mode: 'local',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['v1'],data : Ext.codigo_fabricanteCombo.anos}),
			store: new Ext.data.SimpleStore({fields: ['v1','v2'],data : 
				[
				 ['2000', '2000'],
			        ['2001', '2001'], 
			        ['2002', '2002'],
			        ['2003', '2003'],  
			        ['2004', '2004'], 
			        ['2005', '2005'],
			        ['2006', '2006'],
			        ['2007', '2007'],
			        ['2008', '2008'],
			        ['2009', '2009'],                                 
					['2010', '2010'],
			        ['2011', '2011'],
			        ['2012', '2012'],
			        ['2013', '2013'],
			        ['2014', '2014'],
			        ['2015', '2015'],
			        ['2016', '2016'],
			        ['2017', '2017'],
			        ['2018', '2018'],
			        ['2019', '2019'],
			        ['2020', '2020'],
			        ['2021', '2021'],
					['2022', '2022'],
					['2023', '2023'],
					['2024', '2024'],
					['2025', '2025']
				 ]}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			grid_visible:true,
			forceSelection:true
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'cf.anio',
		save_as:'txt_anio',
		
	}
	
// txt descripcion
	vectorAtributos[5]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'cf.descripcion',
		save_as:'txt_descripcion'
	};

// txt observaciones
	vectorAtributos[6]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			//forceSelection:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'cf.observaciones',
		save_as:'txt_observaciones'
	};

	/////////// txt estado_registro //////
	vectorAtributos[7]= {
		validacion: {
			name: 'estado_registro',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : Ext.codigo_fabricanteCombo.estado }),
			store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : [
			                                                         		['activo', 'activo'],        
			                                                                ['inactivo', 'inactivo'],
			                                                                ['eliminado', 'eliminado']
			                                                                
			                                                            ] }),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:65, // ancho de columna en el grid
			width:65
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'cf.estado_registro',
		save_as:'txt_estado_registro',
		defecto:"activo"	
	};
	
// txt fecha_reg
	vectorAtributos[8]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'cf.fecha_reg',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	var config={
		titulo_maestro:"Item (Maestro)",
		titulo_detalle:"Codigos del Fabricante (Detalle)"
	};
	layout_codigo_fabricante = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_codigo_fabricante.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_codigo_fabricante,idContenedor);
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
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//datos necesarios para el filtro
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;
	var paramFunciones = {
		btnEliminar:{
			url:direccion+'../../../control/codigo_fabricante/ActionEliminarCodigoFabricante.php'
		},
		Save:{
			url:direccion+'../../../control/codigo_fabricante/ActionGuardarCodigoFabricante.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/codigo_fabricante/ActionGuardarCodigoFabricante.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:'45%',
			height:'60%',
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'Codigo Fabricante'
		}
	}
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_item:datos.maestro_id_item
				}
			});

			gridMaestro.getDataSource().removeAll()
			gridMaestro.getDataSource().loadData([
			['ID',datos.maestro_id_item],
			['Item',datos.maestro_nombre],
			['Descripción',datos.maestro_descripcion]
			]);
			vectorAtributos[1].defecto=datos.maestro_id_item
		}
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
	}
 this.btnNew = function()
	{	CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()
	};
this.btnEdit = function()
	{	CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_activo.getLayout();
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				this.iniciaFormulario();
				iniciarEventosFormularios();
				layout_codigo_fabricante.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}