<?php 
session_start();
?>
//<script>
var PaginaItemArchivo;

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
	id_item:'<?php echo $maestro_id_item;?>',
	nombre:'<?php echo $maestro_nombre;?>',
	descripcion:'<?php echo $maestro_descripcion;?>',
	};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

	var elemento={idContenedor:idContenedor,pagina:new PaginaItemArchivo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_item_archivo_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				
 * Fecha creación:		
 */
function PaginaItemArchivo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_archivo/ActionListarItemArchivo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item_archivo',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_item_archivo',
		'descripcion',
		'tipo',
		'archivo',
		'extension',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item'
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
     /////////////////////////////////
	// DEFINICIÓN DATOS DEL MAESTRO//
	/////////////////////////////////
	
	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	// create the Grid
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
				fields: ['atributo','valor'],
				data :[['ID',maestro.id_item],['Item',maestro.nombre],['Descripción',maestro.descripcion]]
			}),
		cm:cmMaestro
	});
	gridMaestro.render();
	
	/////DATA STORE COMBOS////////////
	
	ds_item=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id: 'id_item',
			totalRecords:'TotalCount'
		}, ['id_item','nombre','codigo'])
	});
	
	function renderItem(value, p, record){return String.format('{0}', record.data['desc_item']);}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////	
	// hidden id_item_reemplazo
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_item_archivo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_item_archivo'
	};
	
	//hidden id_item
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
			disabled:false,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		save_as:'txt_id_item',
		defecto:maestro.id_item
	};
	
// txt descripcion
	vectorAtributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEARC.descripcion',
		save_as:'txt_descripcion'
	};
	
// txt observaciones
	vectorAtributos[3]= {
		validacion:{
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		defecto:'Foto',
		filterColValue:'ITEARC.tipo',
		save_as:'txt_tipo'
	};
	
	// txt archivo
	vectorAtributos[4]= {
		validacion:{
			name:'archivo',
			fieldLabel:'Archivo',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEARC.archivo',
		save_as:'txt_archivo'
	};
	
	// txt extension
	vectorAtributos[5]= {
		validacion:{
			name:'extension',
			fieldLabel:'Extension',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEARC.extension',
		save_as:'txt_extension'
	};
	
	
// txt fecha_reg
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ir.fecha_reg ',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	 var config={
		titulo_maestro:"Item (Maestro)",
		titulo_detalle:"Archivo del Item (Detalle)"
	};
	layout_item_archivo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_item_archivo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	///////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_item_archivo,idContenedor);
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
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;
	var paramFunciones = {
		btnEliminar:{
			url:direccion+'../../../control/item_archivo/ActionEliminarItemArchivo.php'
		},
		Save:{
			url:direccion+'../../../control/item_archivo/ActionGuardarItemArchivo.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/item_archivo/ActionGuardarItemArchivo.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:'40%',
			height:'60%',
			minWidth:150,
			minHeight:200,
			labelWidth: 90,
			closable:true,
			titulo: 'Archivo del Item'
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
			vectorAtributos[1].defecto=datos.maestro_id_item;
		}
	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}
function iniciarPaginaItemArchivo()
	{	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
	    componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	}
   this.btnNew = function()
	{	
	    ClaseMadre_btnNew();
	}
	this.btnEdit = function()
	{   
		ClaseMadre_btnEdit();
	}	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_item_archivo.getLayout();
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
				iniciarPaginaItemArchivo();
				iniciarEventosFormularios();
				layout_item_archivo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}