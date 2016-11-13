<?php 
/**
 * Nombre:		  	    item_ubicacion_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-11 11:17:26
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
	var maestro={id_estante:<?php echo $m_id_estante;?>,codigo:'<?php echo $m_codigo;?>',descripcion:'<?php echo $m_descripcion;?>',nivel_max:'<?php echo $m_nivel_max;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_item_ubicacion_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_item_ubicacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-11 11:17:27
*/
function pagina_item_ubicacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0,txt_nivel,cmb_Item,txt_nombre,txt_descripcion_item,txt_super_grupo,txt_grupo,txt_sub_grupo,txt_id1,txt_id2,txt_id3;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_ubicacion/ActionListarItemUbicacion_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item_ubicacion',
			totalRecords: 'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_item_ubicacion',
		'nivel',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'nombre_item',
		'desc_estante',
		'id_estante',
		'nombre_supg',
		'nombre_grupo',
		'nombre_subg',
		'nombre_id1',
		'nombre_id2',
		'nombre_id3',
		'desc_item',
		'codigo_item'
		]),remoteSort:true});
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_estante:maestro.id_estante
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO
		var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
		function italic(value){return '<i>'+value+'</i>'}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Estante',maestro.id_estante],['Codigo',maestro.codigo],['Estado Registro',maestro.descripcion]]}),cm:cmMaestro});
		gridMaestro.render();
		//DATA STORE COMBOS
		var ds_item=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item',
			totalRecords: 'TotalCount'
		},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','costo_almacen','stock_min','stock_total','observaciones','nivel_convertido','estado_item','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])});
		//FUNCIONES RENDER
		function render_id_item(value, p, record){return String.format('{0}', record.data['codigo_item'])};
		// Template combo
		var resultTplItem=new Ext.Template(
		'<div class="search-item">',
		'<b><i>{nombre}</i></b>',
		'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
		'</div>'
		);
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		// hidden id_item_ubicacion
		//en la posición 0 siempre esta la llave primaria
		vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name:'id_item_ubicacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_item_ubicacion'
		};
		//txt Desc del empleado
		vectorAtributos[1]={
			validacion:{
				name:'id_item',
				desc:'codigo_item',
				fieldLabel:'Código Material',
				valueField: 'id_item',
				displayField: 'codigo',
				tipo:'ingreso',//determina el action a llamar
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:200,
				pageSize:10,
				direccion:direccion,
				renderer:render_id_item,
				grid_indice:1
			},
			tipo:'LovItemsAlm',
			filtro_0:true,
			filterColValue:'ITEM.codigo',
			save_as:'txt_id_item',
			id_grupo:0
		};

		// txt nivel
		vectorAtributos[2]={
			validacion:{
				name:'nivel',
				fieldLabel:'Nivel',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				maxValue:maestro.nivel_max,
				minValue:1,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:60,
				width:50
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'ITEUBI.nivel',
			save_as:'txt_nivel',
			id_grupo:1
		};

		// txt descripcion
		vectorAtributos[3]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:180,
				width:'100%'
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'ITEUBI.descripcion',
			save_as:'txt_descripcion',
			id_grupo:1
		};
		// txt observaciones
		vectorAtributos[4]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:180,
				width:'100%'
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'ITEUBI.observaciones',
			save_as:'txt_observaciones',
			id_grupo:1
		};
		// txt id_estante
		vectorAtributos[5]={
			validacion:{
				name:'id_estante',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_estante,
			save_as:'txt_id_estante'
		};

		// txt fecha_reg
		vectorAtributos[6]={
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
				width_grid:95,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'ITEUBI.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg',
			id_grupo:1
		};

		vectorAtributos[7]={
			validacion:{
				name:'nombre_item',
				fieldLabel:'Nombre',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'TextField',
			filtro_0:false,
			save_as:'txt_nombre',
			id_grupo:0
		};

		vectorAtributos[8]={
			validacion:{
				name:'desc_item',
				fieldLabel:'Descripción',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_desc_item',
			id_grupo:0
		};

		vectorAtributos[9]={
			validacion:{
				name:'nombre_supg',
				fieldLabel:'SuperGrupo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_super_grupo',
			id_grupo:0
		};

		vectorAtributos[10]={
			validacion:{
				name:'nombre_grupo',
				fieldLabel:'Grupo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_grupo',
			id_grupo:0
		};

		vectorAtributos[11]={
			validacion:{
				name:'nombre_subg',
				fieldLabel:'SubGrupo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_sub_grupo',
			id_grupo:0
		};

		vectorAtributos[12]={
			validacion:{
				name:'nombre_id1',
				fieldLabel:'Identificador 1',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id1',
			id_grupo:0
		};

		vectorAtributos[13]={
			validacion:{
				name:'nombre_id2',
				fieldLabel:'Identificador 2',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%'
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id2',
			id_grupo:0
		};

		vectorAtributos[14]={
			validacion:{
				name:'nombre_id3',
				fieldLabel:'Identificador 3',
				grid_visible:false,
				grid_editable:false,
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
			return value?value.dateFormat('d/m/Y') : '';
		};
		//---------- INICIAMOS LAYOUT DETALLE
		var config={
			titulo_maestro:'Estantería (Maestro)',
			titulo_detalle:'Ubicación de Items (Detalle)',
			grid_maestro:'grid-'+idContenedor
		};
		layout_item_ubicacion=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_item_ubicacion.init(config);
		//---------- INICIAMOS HERENCIA
		this.pagina=Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_item_ubicacion,idContenedor);
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_btnNew=this.btnNew;
		var CM_ocultarComponente=this.ocultarComponente;
		var ClaseMadre_btnEdit=this.btnEdit;
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
		parametrosFiltro='&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/item_ubicacion/ActionEliminarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
			Save:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
			ConfirmSave:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:370,width:'80%',minHeight:200,closable:true,titulo: 'Ubicación del Item',
			columnas:['45%','51%'],
			grupos:[
			{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
			{tituloGrupo:'Datos ubicación',columna:1,id_grupo:1}
			]}
		};
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_estante=datos.m_id_estante;
			maestro.codigo=datos.m_codigo;
			maestro.descripcion=datos.m_descripcion;
			maestro.nivel_max=datos.m_nivel_max;
			gridMaestro.getDataSource().removeAll();
			gridMaestro.getDataSource().loadData([['Id Estante',maestro.id_estante],['Codigo',maestro.codigo],['Estado Registro',maestro.descripcion]]);
			vectorAtributos[5].defecto=maestro.id_estante;
			paramFunciones={
				btnEliminar:{url:direccion+'../../../control/item_ubicacion/ActionEliminarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
				Save:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
				ConfirmSave:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php',parametros:'&m_id_estante='+maestro.id_estante},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'Ubicación del Item'}
			};
			this.InitFunciones(paramFunciones);
			txt_nivel.maxValue=maestro.nivel_max;
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_estante:maestro.id_estante
				}

			};
			this.btnActualizar()
		};

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			txt_nivel=ClaseMadre_getComponente('nivel');
			cmb_Item=ClaseMadre_getComponente('id_item');
			txt_nombre=ClaseMadre_getComponente('nombre_item');
			txt_descripcion_item=ClaseMadre_getComponente('desc_item');
			txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
			txt_grupo=ClaseMadre_getComponente('nombre_grupo');
			txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
			txt_id1=ClaseMadre_getComponente('nombre_id1');
			txt_id2=ClaseMadre_getComponente('nombre_id2');
			txt_id3=ClaseMadre_getComponente('nombre_id3');

			var onItemSelect=function(e){
				rec=cmb_Item.lov.getSelect();
				txt_nombre.setValue(rec["nombre"]);
				txt_descripcion_item.setValue(rec["descripcion"]);
				txt_super_grupo.setValue(rec["nombre_supg"]);
				txt_grupo.setValue(rec["nombre_grupo"]);
				txt_sub_grupo.setValue(rec["nombre_subg"]);
				txt_id1.setValue(rec["nombre_id1"]);
				txt_id2.setValue(rec["nombre_id2"]);
				txt_id3.setValue(rec["nombre_id3"]);
			};
			cmb_Item.on('change',onItemSelect)
		}
		function iniciarPaginaUbicacionItem(){
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();
			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
			for(i=0;i<vectorAtributos.length-1;i++){
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
			}
		}
		this.btnNew = function(){
			CM_ocultarComponente(componentes[5]);
			ClaseMadre_btnNew()
		};
		this.btnEdit=function(){
			CM_ocultarComponente(componentes[5]);
			ClaseMadre_btnEdit()
		};
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_item_ubicacion.getLayout()
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
		this.getElementos=function(){return elementos};
		this.setPagina=function(elemento){elementos.push(elemento)};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones
		this.iniciaFormulario();
		iniciarEventosFormularios();
		iniciarPaginaUbicacionItem();
		layout_item_ubicacion.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}