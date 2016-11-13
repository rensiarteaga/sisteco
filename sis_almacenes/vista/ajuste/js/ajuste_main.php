//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new pagina_ajuste_inventario(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_ajuste_inventario(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;
	var combo_almacen,combo_almacen_logico,cmb_ep,cmb_Item;

	//DATA STORE COMBOS
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'idalmacen',
		totalRecords:'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_almacen_logico=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEP.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen_logico',
		totalRecords:'TotalCount'
	}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])
	});


	ds_motivo_salida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_salida/ActionListarMotivoSalidaEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_salida',
		totalRecords: 'TotalCount'
	}, ['id_motivo_salida','nombre','descripcion','fecha_reg'])
	});

	ds_motivo_salida_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_salida_cuenta/ActionListarMotivoSalidaCuenta.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_salida_cuenta',
		totalRecords: 'TotalCount'
	}, ['id_motivo_salida_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
	});

	ds_tipo_material = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_material/ActionListarTipoMaterial.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_tipo_material',
		totalRecords: 'TotalCount'
	}, ['id_tipo_material','nombre','descripcion','observaciones','fecha_reg'])
	});

	ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/../ActionListarItem.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_item',
		totalRecords: 'TotalCount'
	}, ['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});
	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function render_id_motivo_salida_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_salida_cuenta']);}
	function render_id_motivo_salida(value, p, record){return String.format('{0}', record.data['desc_motivo_salida']);}
	function render_id_tipo_material(value, p, record){return String.format('{0}', record.data['desc_tipo_material']);}
	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
	// Template combo
	var resultTplAlmacen = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
	//'<HR>',
	'</div>'
	);
	var resultTplAlmacenLogico = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}',
	'<br>{desc_tipo_almacen}</FONT>',
	//'<HR>',
	'</div>'
	);

	var resultTplTipoMaterial = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
	//'<HR>',
	'</div>'
	);
	var resultTplMotivoSalida = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
	//'<HR>',
	'</div>'
	);
	var resultTplMotivoSalidaCuenta = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{descripcion}</i></b>',
	'<br><FONT COLOR="#B5A642">{desc_cuenta}',
	'<br>{codigo_ep}</FONT>',
	//'<HR>',
	'</div>'
	);
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_salida
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_salida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
	};
	//txt almacen
	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	vectorAtributos[1] = {
		validacion:{
			fieldLabel:'Almacen Físico',
			allowBlank:true,
			emptyText:'Almacen Físico...',
			name:'id_almacen',     //indica la columna del store principal ds del que proviane el id
			desc:'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'50%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen',
		id_grupo:1
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';

	//txt almacen logico
	vectorAtributos[2] ={
		validacion:{
			fieldLabel:'Almacen Lógico',
			allowBlank:false,
			emptyText:'Almacen Lógico...',
			name:'id_almacen_logico',     //indica la columna del store principal ds del que proviane el id
			desc:'desc_almacen_logico', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_logico,
			valueField:'id_almacen_logico',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'80%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:1
	};

	//txt Solicitante
	vectorAtributos[3]= {
		validacion: {
			name:'tipo_ajuste',
			fieldLabel:'Tipo Ajuste',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.ajusteCombo.tipo}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['faltantes', 'Faltantes'],  ['sobrantes', 'Sobrantes']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'',
		save_as:'txt_tipo_ajuste',
		id_grupo:2
	};

	vectorAtributos[4] = {
		validacion:{
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',     //indica la columna del store principal "ds" del que proviane el id
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_visible:false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:14,
			width:'100%'
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:0
	}

	fC= new Array();
	fV= new Array();
	fC[0]='id_almacen_logico';
	fV[0]='%';

	vectorAtributos[5]={
		validacion:{
			name:'id_item',
			desc:'codigo_item',
			fieldLabel:'Código Material',
			valueField: 'id_item',
			displayField: 'codigo',
			tipo:'salida',//determina el action a llamar
			filterCols:fC,
			filterValues:fV,
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			width:200,
			pageSize:10,
			direccion:direccion,
			renderer:render_id_item,
			grid_indice:1
		},
		tipo:'LovItemsAlm',
		save_as:'txt_id_item',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		id_grupo:3
	};

	vectorAtributos[6]= {
		validacion: {
			name:'estado_item',
			fieldLabel:'Estado material',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.ajusteCombo.estado_item}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Nuevo','Nuevo'],['Usado','Usado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		id_grupo:3,
		filterColValue:'KARLOG.estado_item',
		defecto:'Nuevo',
		save_as:'txt_estado_item'
	};


	vectorAtributos[7]= {
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative: false,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		save_as:'txt_cantidad',
		id_grupo:3
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
	var config = {
		titulo_maestro:'Pedido'

	};
	layout_ajuste_inventario=new DocsLayoutProceso(idContenedor);
	layout_ajuste_inventario.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ajuste_inventario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;

	var CmGetComponente=this.getComponente;
	var Cm_Destroy=this.Destroy;
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
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Ajuste de Inventario";

		return titulo;
	}

	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',
		columnas:['47%','47%'],
		abrir_pestana:false, //abrir pestana
		url:direccion+'../../../control/ajuste/ActionAjusteInventario.php',
		titulo_pestana:obtenerTitulo,

		fileUpload:false,
		width:'90%',
		grupos:[
		{tituloGrupo:'Estructura Programática',columna:0,id_grupo:0},
		{tituloGrupo:'Almacén',columna:0,id_grupo:1},
		{tituloGrupo:'Tipo Ajuste',columna:1,id_grupo:2},
		{tituloGrupo:'Item',columna:1,id_grupo:3}


		],
		minWidth:150,minHeight:200,	closable:true,titulo:'Ajustes'}};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
		function iniciarEventosFormularios()
		{

			combo_almacen = ClaseMadre_getComponente('id_almacen');
			combo_almacen_logico = ClaseMadre_getComponente('id_almacen_logico');
			cmb_ep=ClaseMadre_getComponente('id_ep');
			cmb_Item=ClaseMadre_getComponente('id_item');
			/*txt_nombre=ClaseMadre_getComponente('nombre');
			txt_descripcion=ClaseMadre_getComponente('descripcion');
			txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
			txt_grupo=ClaseMadre_getComponente('nombre_grupo');
			txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
			txt_id1=ClaseMadre_getComponente('nombre_id1');
			txt_id2=ClaseMadre_getComponente('nombre_id2');
			txt_id3=ClaseMadre_getComponente('nombre_id3');*/


			var onItemSelect=function(e){

				var rec=cmb_Item.lov.getSelect();
				//				txt_nombre.setValue(rec["nombre"]);
				//				txt_descripcion.setValue(rec["descripcion"]);
				//				txt_super_grupo.setValue(rec["nombre_supg"]);
				//				txt_grupo.setValue(rec["nombre_grupo"]);
				//				txt_sub_grupo.setValue(rec["nombre_subg"]);
				//				txt_id1.setValue(rec["nombre_id1"]);
				//				txt_id2.setValue(rec["nombre_id2"]);
				//				txt_id3.setValue(rec["nombre_id3"]);
				//

			};



			var onAlmacenSelect = function(e) {
				var id = combo_almacen.getValue();
				if(id=='') id='x';
				combo_almacen_logico.filterValues[0] =  id;
				combo_almacen_logico.modificado = true;
				combo_almacen_logico.setValue('');
				combo_almacen.modificado=true;

			};


			var onAlmacenLogicoSelect = function(e) {
				var id = combo_almacen_logico.getValue();
				if(id=='') id='x';

				cmb_Item.filterValues[0] = id;
				cmb_Item.modificado=true;


			};


			var onEpSelect = function(e){
				var ep=cmb_ep.getValue();
				data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
				//Actualiza los datastore de los combos para filtrar por EP
				actualizar_ds_combos();
				//Limpia los valores de los combos
				combo_almacen.setValue('');
				combo_almacen_logico.setValue('');
				//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
				combo_almacen.modificado=true;
				combo_almacen_logico.modificado=true;

			};

			combo_almacen.on('select', onAlmacenSelect);
			combo_almacen.on('change', onAlmacenSelect);
			combo_almacen_logico.on('select',onAlmacenLogicoSelect);
			combo_almacen_logico.on('change',onAlmacenLogicoSelect);

			cmb_ep.on('change',onEpSelect);
			cmb_Item.on('change',onItemSelect);

		}

		function actualizar_ds_combos(){	//actualiza el data store de almacén y almacén lógico en función de la EP seleccionada
			var datos=Ext.urlDecode(decodeURIComponent(data_ep));
			Ext.apply(combo_almacen.store.baseParams,datos);
			Ext.apply(combo_almacen_logico.store.baseParams,datos);

		}

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		this.getLayout=function(){return layout_ajuste_inventario.getLayout();};
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
		//this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();

		//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}