<?php
/**
 * Nombre:		  	    orden_ubicacion_item_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:false};

var maestro={ m_id_almacen:<?php echo $m_id_almacen;?>,
			  m_id_item:<?php echo $m_id_item;?>,
			  m_desc_item:'<?php echo $desc_item;?>',
			  m_desc_almacen:'<?php echo $desc_almacen;?>',
			};
			  
var elemento={idContenedor:idContenedor,pagina:new pagina_orden_ubicacion_item(idContenedor,direccion,paramConfig,maestro),idContenedorPadre:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_orden_ubicacion_item(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{

	var Atributos=new Array;
	var ds;

	
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creaci�n del Data Store

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/ubicacion_item/ActionListarOrdenUbicacion.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_ubicacion_item_detalle',
			totalRecords: 'TotalCount'

		}, 
		['id_ubicacion_item_detalle',
		// define el mapeo de XML a las etiqutas (campos)
		'id_ubicacion',
		'orden',
		'codigo',  
		'nombre',
		'id_almacen','id_item','usuario_reg',{
			name : 'fecha_reg',
			type : 'date',
			dateFormat : 'd-m-Y'
		}
		,'saldo_item_ubicacion','cant_max_ing','cant_max_sal','TotalCount'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_almacen: maestro.m_id_almacen,
			maestro_id_item:maestro.m_id_item,
			}
	});

	
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 450,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Almacen : ',maestro.m_desc_almacen],['Item : ',maestro.m_desc_item]]}),cm:cmMaestro});
	gridMaestro.render();
	
	


	
	// DEFINICI�N DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		
	//////////////////////////////////////////////////////////////
	// ------------------  PAR�METROS --------------------------//
	// Definici�n de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posici�n 0 siempre tiene que estar la llave primaria

	Atributos[0] ={
		validacion:{
			labelSeparator:'',
			name: 'id_ubicacion_item_detalle',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:200

		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'h_id_ubicacion_item'
	};

	Atributos[1] =
	{
			validacion:{
				fieldLabel: 'Orden Ubicaciones',
				allowBlank : false,
				allowNegative: false,
				name: 'orden',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'center',
				width_grid : 110,
				grid_indice:1
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'ord.orden',
			form: true,
			save_as:'txt_orden'
	};
	Atributos[2] =
	{
			validacion:{
				fieldLabel: 'Codigo Ubicacion',
				name: 'codigo',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'left',
				width_grid : 130,
				grid_indice:2
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'ub.codigo',
			form: false
	};
	Atributos[3] =
	{
			validacion:{
				fieldLabel: 'Nombre Ubicacion',
				name: 'nombre',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'left',
				width_grid : 180,
				grid_indice:3
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'ub.nombre',
			form: false
	};

	Atributos[4] =
	{
			validacion:{
				fieldLabel: 'Cantidad Ingresos Ubicacion',
				allowBlank : false,
				allowNegative: false,
				name: 'cant_max_ing',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'center',
				width_grid : 110,
				grid_indice:4
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'ord.orden',
			form: true,
			save_as:'txt_maxing'
	};
	Atributos[5] =
	{
			validacion:{
				fieldLabel: 'Cantidad Salidas Ubicacion',
				allowBlank : false,
				allowNegative: false,
				name: 'cant_max_sal',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'center',
				width_grid : 110,
				grid_indice:5
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'ord.orden',
			form: false,
			save_as:'txt_maxsal'
	};
	Atributos[6] =
	{
		validacion : {
			name : 'usuario_reg',
			fieldLabel : 'Responsable Registro',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 200,
			grid_indice:6
		},
		tipo : 'TextField',
		filtro_0 : false,
		form : false
	};
	Atributos[7] =
	{
		validacion : {
			name : 'fecha_reg',
			fieldLabel : 'Fecha Registro',
			format : 'd/m/Y',
			minValue : '01/01/1900',
			grid_visible : true,
			grid_editable : false,
			renderer : formatDate,
			align : 'center',
			grid_indice:7,
			width_grid : 95
		},
		tipo : 'TextField',
		form : false,
		filtro_0 : false,
		dateFormat : 'm-d-Y'
	};
	Atributos[8] ={
			validacion:{
				labelSeparator:'',
				name: 'orden_anterior',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid
			
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'txt_orden_anterior'
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


	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Orden Ubicacion Items (Maestro)",
		titulo_detalle:"Detalle Orden Ubicacion (Detalle)",
		grid_maestro:'grid-'+idContenedor
	};
	var layout_orden_ubicacion= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_orden_ubicacion.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_orden_ubicacion,idContenedor);
	var EstehtmlMaestro=this.htmlMaestro; 

	var cm_btnEdit=this.btnEdit;
	var cm_getComponente = this.getComponente;
	
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICI�N DE LA BARRA DE MEN� ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		actualizar:{
			crear :true,
			separador:false
		}
	};



	this.btnEdit = function()
	{
		cm_btnEdit();

		var txt_orden = cm_getComponente('orden');
		txt_orden.on("change",ordenChange,this);

		function ordenChange(field,newValue,oldValue)
		{
				
			if ( Number(newValue) > Number(ds.getCount()) ||  Number(newValue)<=0)
			{
				Ext.MessageBox.alert('Estado','El numero ingresado esta fuera del rango');
				field.setValue(oldValue);		
			}
			else if(Number(newValue) > 0 && Number(newValue)<= Number(ds.getCount()))
			{
				cm_getComponente('orden_anterior').setValue(oldValue);
			}
		}
		
		/*var ingreso = cm_getComponente('cant_max_ing');
		var salida = cm_getComponente('cant_max_sal');
		ingreso.on("change",changeSalida,this);
		ingreso.on("select",changeSalida,this);
		
		function changeSalida(field,newValue,oldValue)
		{
			if(Number(newValue) > 0)
			{
				cm_getComponente('cant_max_sal').setValue(oldValue);
			}
		}*/
		
	}
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	var paramFunciones = {
		btnEliminar:{
			
			url:direccion+'../../../control/ubicacion_item/ActionEliminaUbicacionOrden.php'},
		
		Save:{
			url:direccion+'../../../control/ubicacion_item/ActionGuardarOrdenUbicacion.php',parametros:'&h_id_almacen='+maestro.m_id_almacen+'&h_id_item='+maestro.m_id_item},
		ConfirmSave:{
			url:direccion+'../../../control/ubicacion_item/ActionGuardarOrdenUbicacion.php'},
		
		Formulario:{
			titulo:'Orden de ubicacion de los items del Almacen',
			html_apply:"dlgInfo",
			width:500,
			height:220,
			minWidth:190,
			minHeight:200,
			closable:true
		}
	}
		
		this.reload=function(params)
		{
		
			var datos=Ext.urlDecode(decodeURIComponent(params));
			
			maestro.m_id_almacen=datos.m_id_almacen;
			maestro.m_id_item=datos.m_id_item;
			maestro.m_desc_item=datos.m_desc_item;
			maestro.m_desc_almacen=datos.m_desc_almacen;

		
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_almacen: maestro.m_id_almacen,
					maestro_id_item:maestro.m_id_item
					}
			});

		this.btnActualizar();	
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Almacen : ',maestro.m_desc_almacen],['Item : ',maestro.m_desc_item]]);

	
		paramFunciones.Save.parametros='&h_id_almacen='+maestro.m_id_almacen+'&h_id_item='+maestro.m_id_item;
		paramFunciones.ConfirmSave.parametros='&h_id_almacen='+maestro.m_id_almacen+'&h_id_item='+maestro.m_id_item;
		this.InitFunciones(paramFunciones)
	
	};
	
	//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.getLayout=function(){return layout_orden_ubicacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	

	this.iniciaFormulario();
	layout_orden_ubicacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
} 

