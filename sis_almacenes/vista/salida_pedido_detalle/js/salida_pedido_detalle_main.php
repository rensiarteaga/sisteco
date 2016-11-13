<?php
/**
 * Nombre:		  	    salida_detalle_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 09:38:41
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
	}?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var maestro={id_salida:<?php echo $m_id_salida;?>,descripcion:'<?php echo $m_descripcion;?>',id_almacen_logico:'<?php echo $m_id_almacen_logico;?>'};
	var	elemento={idContenedor:idContenedor,pagina:new pagina_salida_pedido_detalle(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_salida_detalle_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 09:38:50
*/
function pagina_salida_pedido_detalle(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var cantMaxNuevo=0;
	var cantMaxUsado=0;
	var txt_cant_sol,cmb_estado_item,cmb_Item,txt_nombre,txt_descripcion,txt_super_grupo,txt_grupo;
	var	txt_sub_grupo,txt_id1,txt_id2,txt_id3,txt_unidad_medida;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/salida_detalle/ActionListarSalidaDetalle_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id: 'id_salida_detalle',totalRecords:'TotalCount'},[
		'id_salida_detalle',
		'costo',
		'costo_unitario',
		'precio_unitario',
		'cant_solicitada',
		'cant_entregada',
		'cant_consolidada',
		{name: 'fecha_solicitada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_entregada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_consolidada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'codigo_item',
		'id_salida',
		'desc_salida',
		'desc_unidad_constructiva',
		'id_unidad_constructiva',
		'estado_item',
		'nombre',
		'descripcion',
		'nombre_supg',
		'nombre_grupo',
		'nombre_subg',
		'nombre_id1',
		'nombre_id2',
		'nombre_id3',
		'unidad_medida'
		]),remoteSort:true});

		//carga datos XML
		ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_salida:maestro.id_salida}});
		// DEFINICIÓN DATOS DEL MAESTRO

		var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
		function italic(value){return '<i>'+value+'</i>'}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Salida',maestro.id_salida],['Almacen Logico',maestro.id_almacen_logico],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
		gridMaestro.render();
		//DATA STORE COMBOS

		ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',
		id:'id_item',
		totalRecords: 'TotalCount'
		}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','costo_almacen','stock_min','stock_total','observaciones','nivel_convertido','estado_item','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
		});


		//FUNCIONES RENDER
		function render_id_item(value, p, record){return String.format('{0}', record.data['codigo_item'])}

		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_salida_detalle
		//en la posición 0 siempre esta la llave primaria

		vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_salida_detalle',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_salida_detalle'
		};

		// txt estado item
		vectorAtributos[1]={
			validacion:{
				name:'estado_item',
				fieldLabel:'Estado material',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_pedido_detalle_combo.estado_item}),
				store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Nuevo','Nuevo'],['Usado','Usado']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width:100,
				grid_indice:12,
				width_grid:100 // ancho de columna en el grid
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'SALDET.estado_item',
			defecto:'Nuevo',
			save_as:'txt_estado_item',
			id_grupo:1
		};
		// txt cant_solicitada
		vectorAtributos[2]={
			validacion:{
				name:'cant_solicitada',
				fieldLabel:'Cantidad Solicitada',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				minValue:1,
				vtype:'texto',
				maxText:'Existencias insuficientes',
				width:'95%',
				grid_visible:true,
				grid_editable:true,
				width_grid:120,
				align:'right',
				grid_indice:3
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'SALDET.cant_solicitada',
			save_as:'txt_cant_solicitada',
			id_grupo:1
		};

		// txt unidad medida
		vectorAtributos[3]= {
			validacion:{
				name:'unidad_medida',
				fieldLabel:'Unidad Medida',
				grid_visible:true,
				grid_editable:false,
				grid_indice:4,
				disabled:true,
				width:'95%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_unidad_medida',
			id_grupo:1
		};


		fC= new Array();
		fV= new Array();
		fC[0]='id_almacen_logico';
		fV[0]=maestro.id_almacen_logico;

		//txt Desc del empleado
		vectorAtributos[4]={
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
				grid_visible:false, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:120, // ancho de columna en el grid
				width:200,
				pageSize:10,
				direccion:direccion,
				renderer:render_id_item,
				grid_indice:1
			},
			tipo:'LovItemsAlm',
			filtro_0:true,
			filterColValue:'ITEM.codigo',
			save_as:'txt_id_item'
		};

		vectorAtributos[5]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:2,
			},
			tipo:'TextField',
			filtro_0:false,
			save_as:'txt_nombre',
			id_grupo:0
		};


		// txt descripcion
		vectorAtributos[6]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'300%',
				grid_indice:5
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_descripcion',
			id_grupo:0
		};

		// txt super grupo
		vectorAtributos[7]={
			validacion:{
				name:'nombre_supg',
				fieldLabel:'SuperGrupo',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:6
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_super_grupo',
			id_grupo:0
		};
		// txt grupo
		vectorAtributos[8]={
			validacion:{
				name:'nombre_grupo',
				fieldLabel:'Grupo',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:7
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_grupo',
			id_grupo:0
		};
		// txt sub grupo
		vectorAtributos[9]={
			validacion:{
				name:'nombre_subg',
				fieldLabel:'SubGrupo',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:8
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_sub_grupo',
			id_grupo:0
		};

		// txt id1
		vectorAtributos[10]={
			validacion:{
				name:'nombre_id1',
				fieldLabel:'Identificador 1',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:9
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id1',
			id_grupo:0
		};


		// txt id2
		vectorAtributos[11]={
			validacion:{
				name:'nombre_id2',
				fieldLabel:'Identificador 2',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:10
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id2',
			id_grupo:0
		};
		// txt id3
		vectorAtributos[12]={
			validacion:{
				name:'nombre_id3',
				fieldLabel:'Identificador 3',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:11
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id3',
			id_grupo:0
		};

		//----------- FUNCIONES RENDER

		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : ''
		};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={
			titulo_maestro:'Solicitar Material (Maestro)',
			titulo_detalle:'Detalle Solicitud de Material',
			grid_maestro:'grid-'+idContenedor
		};
		layout_salida_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_salida_detalle.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_salida_detalle,idContenedor);
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
		var ClaseMadre_btnEliminar=this.btnEliminar;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var Cm_Destroy=this.Destroy;
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
			btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaPedidoDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaPedidoDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:'80%',
			columnas:['60%','34%'],
			grupos:[
			{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Pedido',columna:1,id_grupo:1}
			],
			minWidth:150,minHeight:200,closable:true,titulo: 'Pedido - Materiales'}
		};


		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_salida=datos.m_id_salida;
			maestro.almacen_fisico=datos.m_almacen_fisico;
			maestro.id_almacen_logico=datos.m_id_almacen_logico;
			maestro.descripcion=datos.m_descripcion;
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_salida:maestro.id_salida
				}
			});
			gridMaestro.getDataSource().removeAll()
			gridMaestro.getDataSource().loadData([['Salida',maestro.id_salida],['Almacén Lógico',maestro.id_almacen_logico],['Descripción',maestro.descripcion]]);
			//vectorAtributos[9].defecto=maestro.id_ingreso;
			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
				Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaPedidoDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
				ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaPedidoDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:'80%',
				columnas:['60%','34%'],
				grupos:[
				{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Pedido',columna:1,id_grupo:1}
				],
				minWidth:150,minHeight:200,closable:true,titulo: 'Pedido - Materiales'}
			};
			this.InitFunciones(paramFunciones)
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			txt_cant_sol=ClaseMadre_getComponente('cant_solicitada');
			cmb_estado_item=ClaseMadre_getComponente('estado_item');
			cmb_Item=ClaseMadre_getComponente('id_item');
			txt_nombre=ClaseMadre_getComponente('nombre');
			txt_descripcion=ClaseMadre_getComponente('descripcion');
			txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
			txt_grupo=ClaseMadre_getComponente('nombre_grupo');
			txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
			txt_id1=ClaseMadre_getComponente('nombre_id1');
			txt_id2=ClaseMadre_getComponente('nombre_id2');
			txt_id3=ClaseMadre_getComponente('nombre_id3');
			txt_unidad_medida=ClaseMadre_getComponente('unidad_medida');

			var onItemSelect=function(e){
				rec=cmb_Item.lov.getSelect();
				//alert(rec["usado"]+ "  "+rec["nombre"]+" "+rec["nuevo"])
				txt_nombre.setValue(rec["nombre"]);
				txt_descripcion.setValue(rec["descripcion"]);
				txt_super_grupo.setValue(rec["nombre_supg"]);
				txt_grupo.setValue(rec["nombre_grupo"]);
				txt_sub_grupo.setValue(rec["nombre_subg"]);
				txt_id1.setValue(rec["nombre_id1"]);
				txt_id2.setValue(rec["nombre_id2"]);
				txt_id3.setValue(rec["nombre_id3"]);
				txt_unidad_medida.setValue(rec["nombre_unid_base"]);

				//obtiene las cantidades máximas y mínimas
				cantMaxNuevo=rec["nuevo"];
				cantMaxUsado=rec["usado"];

				//Define la cantidad máxima a solicitar
				if(cmb_estado_item.getValue()=='Nuevo')
				{txt_cant_sol.maxValue=cantMaxNuevo}
				else
				{txt_cant_sol.maxValue=cantMaxUsado}

				//Verifica si la cantidad está disponible o no
				txt_cant_sol.validate();
			};

			var onEstadoChange=function(e){
				if(cmb_estado_item.getValue()=='Nuevo')
				{
					txt_cant_sol.maxValue=cantMaxNuevo
				}
				else
				{txt_cant_sol.maxValue=cantMaxUsado}

				//Verifica si la cantidad está disponible o no
				txt_cant_sol.validate();
			};


			cmb_Item.on('change',onItemSelect);
			cmb_estado_item.on('select',onEstadoChange);
		}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_salida_detalle.getLayout()
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

		this.Destroy=function(){delete this.pagina;	Cm_Destroy()};
		this.getElementos=function(){return elementos};
		this.setPagina=function(elemento){elementos.push(elemento)};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_salida_detalle.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)

}