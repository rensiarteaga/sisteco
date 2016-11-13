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
var elemento={pagina:new ReporteMovimientos(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    kardex_items_main.js
 * Proposito: 			pagina objeto principal
 * Autor:				UNKNOW
 * Fecha creacion:		03082015
 */
function ReporteMovimientos(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
	var datax,combo_tipo_mov;	

	ds_almacen = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../control/almacen/ActionListarAlmacen.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'

		}, ['id_almacen','nombre_lugar','nombre_depto','codigo','nombre','direccion'])	});	

	var tpl_almacen=new Ext.Template('<div class="search-item">','<b><font face ="univers" size ="2" style="text-transform: uppercase;">{nombre}</font></b></br>','<b><font color="#BDB76B">{codigo} - ','{direccion}</FONT></b>','</div>');

	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/item/ActionListarItem.php?todos=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion','nombre_medida'])});
	var tpl_item=new Ext.Template('<div class="search-item">','<font face="univers" size="2"><b>{nombre}</b><br></font>','<FONT COLOR="#B5A642" face="univers">{codigo} - ','{descripcion}</FONT>','</div>');
	
	
	vectorAtributos[0] = 
	{
			validacion:{
				fieldLabel: 'Almacen',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Almacen...',
				name: 'id_almacen',     //indica la columna del store principal "ds" del que proviene el id
				desc: 'nombre', //indica la columna del store principal "ds" del que proviene la descripcion
				store:ds_almacen,
				valueField: 'id_almacen',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				tpl: tpl_almacen,
				minChars : 2, ///caracteres mï¿½nimos requeridos para iniciar la bï¿½squeda
				width : 320,
				triggerAction: 'all',				 
				editable: true
			},
			id_grupo:0,
			save_as:'h_id_almacen',
			tipo: 'ComboBox'
	};
	vectorAtributos[1]	= 
	{
	validacion:{
		name:'fecha_desde',
		fieldLabel:'Desde',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/2000',
		disabledDaysText: 'Dia no valido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width : 125,
		disabled:false
	},
	id_grupo:0,
	tipo:'DateField',
	filtro_0:true,
	dateFormat:'m/d/Y',
	defecto:'',
	save_as:'txt_fecha_desde'
	};	 
	////////// txt fecha_fin//////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Hasta',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText:  'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width : 125,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		filtro_0:true,
		dateFormat:'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_hasta'
	};
	vectorAtributos[3]={
			validacion:{
				fieldLabel: 'Item',
						allowBlank: false,
						vtype:"texto",
						emptyText:'Item...',
						name: 'id_item',     //indica la columna del store principal "ds" del que proviane el id
						desc: 'desc_item', //indica la columna del store principal "ds" del que proviane la descripcion
						store: ds_item,
						valueField: 'id_item',
						displayField: 'nombre',//campo del store q se mostrara
						queryParam: 'filterValue_0',
						filterCol:'al.nombre#al.codigo',
						typeAhead: false,
						forceSelection : true,
						mode: 'remote',
						queryDelay: 50,
						pageSize: 10,
						minListWidth : 300,
						resizable: true,
						queryParam: 'filterValue_0',
						minChars : 1, ///caracteres m�nimos requeridos para iniciar la busqueda
						triggerAction: 'all',
						grid_visible:true, // se muestra en el grid
						grid_editable:false, //es editable en el grid,
						width_grid:220, // ancho de columna en el gris
						width:320,
						tpl: tpl_item
			},
			tipo:'ComboBox',
			filtro_0:true,
			form: true,
			filterColValue:'itm.codigo#itm.nombre',
			save_as:'txt_id_item'
	}

	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//Inicia Layout
	var config={
		titulo_maestro:'Reporte Depreciaciones'		
	};

	layout_reporte_depreciacion=new DocsLayoutProceso(idContenedor);
	layout_reporte_depreciacion.init(config);

	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_reporte_depreciacion,idContenedor);
	
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
	var ClaseMadre_submit = this.submit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	function obtenerTitulo()
	{
		
		var titulo = "Rep. Tipo de Movimientos";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/kardex_items/ActionPDFKardexItems.php',
							
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:false,  //rensi
		width:'80%',
		columnas:[480],
		//columnas:['47%','47%'],
		minWidth:800,
		minHeight:400,	
		closable:true,
		titulo:'Reporte Tipos de Movimientos',
		
		grupos:[
				{tituloGrupo:'Detalle Movimiento',columna:0,id_grupo:0}
				//,{tituloGrupo:'Solicitante',columna:0,id_grupo:1},
			]
		}	
	};

	function iniciarEventosFormularios()
	{		
		for(var i=0;i<vectorAtributos.length;i++){componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);}

		var combo_almacen = ClaseMadre_getComponente('id_almacen');
		var cmb_item = ClaseMadre_getComponente('id_item');
		cmb_item.disable();
		
		combo_almacen.on('select', onAlmacenSelect);
		combo_almacen.on('change', onAlmacenSelect);

		function onAlmacenSelect(com,rec,ind)	
		{
			if(combo_almacen.getValue() > 0)
			{
				cmb_item.enable();
				componentes[3].store.baseParams = {	filtro_stock:'si',id_almacen:ClaseMadre_getComponente('id_almacen').getValue()};				
				componentes[3].modificado=true;
			}

		}	
	}

	function InitPaginaSolicitudes()
	{
		 for(i=0;i<vectorAtributos.length;i++){
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
			}
	}
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	
	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
				
	this.InitFunciones(paramFunciones);
	//para agregar botones
				
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSolicitudes();

	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}