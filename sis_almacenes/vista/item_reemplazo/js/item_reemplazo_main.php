<?php 
session_start();
?>
//<script>
var PaginaItemReemplazo;

function main(){
	<?php
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";\n";
	echo "var idContenedor='$idContenedor';\n";
	?>
var paramConfig={
		TamanoPagina:20,
		TiempoEspera:10000,
		CantFiltros:1,
		FiltroEstructura:false,
		FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>
};
var maestro={
	id_item:'<?php echo $maestro_id_item;?>',
	nombre:'<?php echo $maestro_nombre;?>',
	descripcion:'<?php echo $maestro_descripcion;?>',
	};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

	var elemento={idContenedor:idContenedor,pagina:new PaginaItemReemplazo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_item_reemplazo_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Susana Castro
 * Fecha creación:		2007-10-03 21:10:27
 */
function PaginaItemReemplazo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_reemplazo/ActionListarItemReemplazo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item_reemplazo',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_item_reemplazo',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'id_item_reemplazante',
		'desc_item',
		'desc_item_reemplazante'
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
	function renderItemReemplazante(value, p, record){return String.format('{0}', record.data['desc_item_reemplazante']);}
	var resultTplItemReemp=new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>',
	'</div>'
	);
	/////////////////////////
	// Definición de datos //
	/////////////////////////	
	// hidden id_item_reemplazo
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_item_reemplazo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_item_reemplazo'
	};
	
	/////////// hidden id_item //////
	vectorAtributos[1]= {
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
	// hidden id_item_reemplazante
	vectorAtributos[2]= {
		validacion:{
			fieldLabel: 'Item Reemplazo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Item Reemplazo...',
			name: 'id_item_reemplazante',   //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_item_reemplazante', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_item,
			valueField: 'id_item',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			typeAhead: true,
			forceSelection : false,
			tpl:resultTplItemReemp,
			mode: 'remote',
			queryDelay: 50,
			pageSize:10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderItemReemplazante,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:110 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'iter.nombre',
		save_as:'txt_id_item_reemplazante'   
	};

// txt descripcion
	vectorAtributos[3]= {
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
		filterColValue:'ir.descripcion',
		save_as:'txt_descripcion'
	};

// txt observaciones
	vectorAtributos[4]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ir.observaciones',
		save_as:'txt_observaciones'
	};
	
// txt fecha_reg
	vectorAtributos[5]={
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
		titulo_detalle:"Reemplazos del Item (Detalle)"
	};
	layout_item_reemplazo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_item_reemplazo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	///////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_item_reemplazo,idContenedor);
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
			url:direccion+'../../../control/item_reemplazo/ActionEliminarItemReemplazo.php'
		},
		Save:{
			url:direccion+'../../../control/item_reemplazo/ActionGuardarItemReemplazo.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/item_reemplazo/ActionGuardarItemReemplazo.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:'40%',
			height:'60%',
			minWidth:150,
			minHeight:200,
			labelWidth: 90,
			closable:true,
			titulo: 'Reemplazo del Item'
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
	txt_id_item = ClaseMadre_getComponente ('id_item');
	combo_id_reemplazo=ClaseMadre_getComponente ('id_item_reemplazante');
	
	  var onIdReemplazoSelect=function(e){
			var reemp = combo_id_reemplazo.getValue();
			var id = txt_id_item.getValue();
			if(reemp == id){
				combo_id_reemplazo.setValue('');
				Ext.MessageBox.alert('Error!!!!!!','El Item reemplazo no puede ser el mismo');
			}	
			
			};
		
		combo_id_reemplazo.on('select', onIdReemplazoSelect);		
		combo_id_reemplazo.on('change', onIdReemplazoSelect);
		}
		

function iniciarPaginaItemReemplazo()
	{	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
	    componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}
   this.btnNew = function()
	{	CM_ocultarComponente(componentes[4]);
	    ClaseMadre_btnNew();
	}
	this.btnEdit = function()
	{   CM_ocultarComponente(componentes[4]);
		ClaseMadre_btnEdit();
	}	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_item_reemplazo.getLayout();
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
				//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btnSubtipos,true, 'subtipos','Subtipos de Activos Fijos');
				this.iniciaFormulario();
				iniciarPaginaItemReemplazo();
				iniciarEventosFormularios();
				layout_item_reemplazo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}