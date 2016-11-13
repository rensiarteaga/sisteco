<?php
/**
 * Nombre:		  	    ingreso_detalle_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 12:33:16
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
	var maestro={id_ingreso:<?php echo $m_id_ingreso;?>,almacen_fisico:'<?php echo $m_almacen_fisico;?>',almacen_logico:'<?php echo $m_almacen_logico;?>',descripcion:'<?php echo $m_descripcion;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_orden_ingreso_aprob_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_ingreso_detalle_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-17 12:33:25
*/
function pagina_orden_ingreso_aprob_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{

	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ingreso_detalle/ActionListarOrdenIngresoSolDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_ingreso_detalle',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_ingreso_detalle',
		'estado_item',
		'cantidad',
		'costo',
		'precio_venta',
		'costo_unitario',
		'precio_venta_unitario',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_ingreso',
		'desc_ingreso',
		'desc_item',
		'id_item',
		'nombre',
		'descripcion',
		'nombre_supg',
		'nombre_grupo',
		'nombre_subg',
		'nombre_id1',
		'nombre_id2',
		'nombre_id3'
		]),remoteSort:true
	});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_ingreso:maestro.id_ingreso
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	//var dataMaestro=[['Almacén Físico',maestro.almacen_fisico],['Almacén Lógico',maestro.almacen_logico],['Descripción',maestro.descripcion]];

	//var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Almacén Físico',maestro.almacen_fisico],['Almacén Lógico',maestro.almacen_logico],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_item',
		totalRecords: 'TotalCount'
	}, ['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});

	//FUNCIONES RENDER

	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_ingreso_detalle
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0] = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_ingreso_detalle',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				grid_indice:0
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_ingreso_detalle'
		};

		//txt estado_item
		vectorAtributos[1]= {
			validacion: {
				name:'estado_item',
				fieldLabel:'Estado Material',
				grid_visible:true,
				grid_editable:true,
				grid_indice:2,
				width_grid:90 // ancho de columna en el grid
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'INGDET.estado_item',
			save_as:'txt_estado_item',
			id_grupo:1
		};
		
		// txt cantidad
		vectorAtributos[2]= {
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				width:'95%',
				grid_visible:true,
				grid_editable:true,
				grid_indice:5,
				width_grid:100
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'INGDET.cantidad',
			save_as:'txt_cantidad',
			id_grupo:1
		};
		
		//txt Desc del empleado
		vectorAtributos[3]={
			validacion:{
				name:'id_item',
				desc:'desc_item',
				fieldLabel:'Código Material',
				renderer:render_id_item,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:90, // ancho de columna en el grid
				grid_indice:1
			},
			tipo:'NumberField',
			save_as:'txt_id_item',
			filtro_0:true,
			filterColValue:'ITEM.codigo',
		};

		// txt costo_unitario
		vectorAtributos[4]= {
			validacion:{
				name:'costo_unitario',
				fieldLabel:'Costo unitario',
				grid_visible:true,
				grid_editable:true,
				grid_indice:6,
				width_grid:100
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'INGDET.costo_unitario',
			save_as:'txt_costo_unitario',
			id_grupo:1
		};

		// txt costo
		vectorAtributos[5]= {
			validacion:{
				name:'costo',
				fieldLabel:'Costo total',
				grid_visible:true,
				grid_editable:false,
				grid_indice:7,
				width_grid:100
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'INGDET.costo',
			save_as:'txt_costo',
			id_grupo:1
		};

		// txt fecha_reg
		vectorAtributos[6]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:true,
				grid_indice:8,
				renderer: formatDate,
				width_grid:85
			},
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'INGDET.fecha_reg',
			dateFormat:'m-d-Y',
			save_as:'txt_fecha_reg',
			id_grupo:1
		};

		// txt id_ingreso
		vectorAtributos[7]= {
			validacion:{
				name:'id_ingreso',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_ingreso,
			save_as:'txt_id_ingreso'
		};
		
		// txt nombre
		vectorAtributos[8]= {
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				grid_indice:3,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:true,
			save_as:'txt_nombre',
			filterColValue:'ITEM.nombre',
			id_grupo:0
		};
		
		// txt descripcion
		vectorAtributos[9]= {
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				grid_visible:true,
				grid_editable:false,
				grid_indice:4,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_descripcion',
			filterColValue:'ITEM.descripcion',
			id_grupo:0
		};
		
		// txt super grupo
		vectorAtributos[10]= {
			validacion:{
				name:'nombre_supg',
				fieldLabel:'SuperGrupo',
				grid_visible:true,
				grid_editable:false,
				grid_indice:9,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_super_grupo',
			id_grupo:0
		};
		
		// txt grupo
		vectorAtributos[11]= {
			validacion:{
				name:'nombre_grupo',
				fieldLabel:'Grupo',
				grid_visible:true,
				grid_editable:false,
				grid_indice:10,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_grupo',
			id_grupo:0
		};
		
		// txt sub grupo
		vectorAtributos[12]= {
			validacion:{
				name:'nombre_subg',
				fieldLabel:'SubGrupo',
				grid_visible:true,
				grid_editable:false,
				grid_indice:11,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_sub_grupo',
			id_grupo:0
		};
		
		// txt id1
		vectorAtributos[13]= {
			validacion:{
				name:'nombre_id1',
				fieldLabel:'Identificador 1',
				grid_visible:true,
				grid_editable:false,
				grid_indice:12,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id1',
			id_grupo:0
		};
		
		// txt id2
		vectorAtributos[14]= {
			validacion:{
				name:'nombre_id2',
				fieldLabel:'Identificador 2',
				grid_visible:true,
				grid_editable:false,
				grid_indice:13,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id2',
			id_grupo:0
		};
		
		// txt id3
		vectorAtributos[15]= {
			validacion:{
				name:'nombre_id3',
				fieldLabel:'Identificador 3',
				grid_visible:true,
				grid_editable:false,
				grid_indice:14,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id3',
			id_grupo:0
		};
		




	//----------- FUNCIONES RENDER

	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Orden de Ingreso (Maestro)',
		titulo_detalle:'Detalle Orden Ingreso (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_ingreso_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_ingreso_detalle.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_ingreso_detalle,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var CmGetComponente=this.getComponente;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	
	
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ


	var paramMenu={
	
		actualizar:{crear:true,separador:false}
	};



	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ingreso_detalle/ActionEliminarIngresoDetalle.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		Save:{url:direccion+'../../../control/ingreso_detalle/ActionGuardarOrdenIngresoSolDet.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		ConfirmSave:{url:direccion+'../../../control/ingreso_detalle/ActionGuardarOrdenIngresoSolDet.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:'80%',
		columnas:['60%','34%'],
		grupos:[
		{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
		{tituloGrupo:'Datos Ingreso',columna:1,id_grupo:1}
		],
		minWidth:150,minHeight:200,closable:true,titulo: 'Detalle'}
	}

	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_ingreso=datos.m_id_ingreso;
		maestro.almacen_fisico=datos.m_almacen_fisico;
		maestro.almacen_logico=datos.m_almacen_logico;
		maestro.descripcion=datos.m_descripcion;
		maestro.contabilizar= datos.m_contabilizar_tipo_almacen;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_ingreso:maestro.id_ingreso
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Almacén Físico',maestro.almacen_fisico],['Almacén Lógico',maestro.almacen_logico],['Descripción',maestro.descripcion]]);
		vectorAtributos[9].defecto=maestro.id_ingreso;
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ingreso_detalle/ActionEliminarIngresoDetalle.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		Save:{url:direccion+'../../../control/ingreso_detalle/ActionGuardarOrdenIngresoSolDet.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		ConfirmSave:{url:direccion+'../../../control/ingreso_detalle/ActionGuardarOrdenIngresoSolDet.php',parametros:'&txt_id_ingreso='+maestro.id_ingreso},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:'80%',
		columnas:['60%','34%'],
		grupos:[
		{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
		{tituloGrupo:'Datos Ingreso',columna:1,id_grupo:1}
		],
		minWidth:150,minHeight:200,closable:true,titulo: 'Detalle'}
	};
		this.InitFunciones(paramFunciones)
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario
		txt_costo_total=ClaseMadre_getComponente('costo');
		txt_costo_unitario=ClaseMadre_getComponente('costo_unitario');
		txt_cantidad=ClaseMadre_getComponente('cantidad');
		cmb_Item=CmGetComponente('id_item');
		txt_nombre=ClaseMadre_getComponente('nombre');
		txt_descripcion=ClaseMadre_getComponente('descripcion');
		txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
		txt_grupo=ClaseMadre_getComponente('nombre_grupo');
		txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
		txt_id1=ClaseMadre_getComponente('nombre_id1');
		txt_id2=ClaseMadre_getComponente('nombre_id2');
		txt_id3=ClaseMadre_getComponente('nombre_id3');

		var onItemSelect=function(e){
			rec=cmb_Item.lov.getSelect();
			txt_nombre.setValue(rec["nombre"]);
			txt_descripcion.setValue(rec["descripcion"]);
			txt_super_grupo.setValue(rec["nombre_supg"]);
			txt_grupo.setValue(rec["nombre_grupo"]);
			txt_sub_grupo.setValue(rec["nombre_subg"]);
			txt_id1.setValue(rec["nombre_id1"]);
			txt_id2.setValue(rec["nombre_id2"]);
			txt_id3.setValue(rec["nombre_id3"])


		};

		var CalcularCostoTotal = function(e) {
			var unit = txt_costo_unitario.getValue();
			var cant = txt_cantidad.getValue();

			if(unit!=undefined && unit!=null && cant!=undefined && cant!=null)
			{
				txt_costo_total.setValue(unit*cant)
			}
			else
			{
				txt_costo_total.setValue('0')
			}
		};

		txt_costo_unitario.on('blur',CalcularCostoTotal);
		txt_cantidad.on('blur',CalcularCostoTotal);
		cmb_Item.on('change',onItemSelect)
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_ingreso_detalle.getLayout()
	};

	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_ingreso_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}