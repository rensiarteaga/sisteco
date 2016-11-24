<?php
/**
 * Nombre:		  	    transferencia_det_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				
 * Fecha creación:		2007-11-21 08:53:05
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
	var maestro={id_transferencia:<?php echo $m_id_transferencia;?>,id_almacen_logico:<?php echo $m_id_almacen_logico;?>,desc_almacen_logico:'<?php echo $m_almacen_logico;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_transferencia_det_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_transferencia_gen_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-11-21 08:53:40
*/
function pagina_transferencia_det_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var cantMaxNuevo=0;
	var cantMaxUsado=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transferencia_det/ActionListarTransferenciaDet_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transferencia_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_transferencia_det',
		'cantidad',
		'estado_item',
		'costo',
		'costo_unitario',
		'precio_unitario',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'id_transferencia',
		'desc_transferencia',
		'desc_unidad_constructiva',
		'id_unidad_constructiva',
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
			m_id_transferencia:maestro.id_transferencia
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
//	var dataMaestro=[['transferencia',maestro.id_transferencia],['id_almacen_fisico',maestro.id_almacen_fisico],['almacen_logico',maestro.desc_almacen_logico]];

	//var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Transferencia',maestro.id_transferencia],['Almacen Logico Id',maestro.id_almacen_logico],['Almacen Logico',maestro.desc_almacen_logico]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_item',
		totalRecords: 'TotalCount'
	}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
	});

	ds_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_unidad_constructiva',
		totalRecords: 'TotalCount'
	}, ['id_unidad_constructiva','codigo','direccion','fecha_reg','id_tipo_unidad_constructiva','id_subactividad'])
	});

	//FUNCIONES RENDER

	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	function render_id_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_unidad_constructiva']);};

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_transferencia_det
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_transferencia_det',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_transferencia_det'
	};

	vectorAtributos[1]= {
		validacion: {
			name:'estado_item',
			fieldLabel:'Estado material',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.transferencia_gen_det_combo.estado_item}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Nuevo','Nuevo'],['Usado','Usado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TLODET.estado_item',
		defecto:'Nuevo',
		save_as:'txt_estado_item',
		id_grupo:2
	};

	vectorAtributos[2]= {
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			maxText:'Existencias insuficientes',
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TLODET.cantidad',
		save_as:'txt_cantidad',
		id_grupo:2
	};
	
	vectorAtributos[3]= {
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Costo unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TLODET.costo_unitario',
		save_as:'txt_costo_unitario',
		id_grupo:2
	};

	vectorAtributos[4]= {
		validacion:{
			name:'costo',
			fieldLabel:'Costo total',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TLODET.costo',
		save_as:'txt_costo',
		id_grupo:2
	};

	

	vectorAtributos[5]= {
		validacion:{
			name:'precio_unitario',
			fieldLabel:'Precio unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TLODET.precio_unitario',
		save_as:'txt_precio_unitario',
		id_grupo:0
	};

	vectorAtributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			width:'80%'
		},
		tipo:'DateField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'TLODET.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:0
	};

	fC= new Array();
	fV= new Array();
	fC[0]='id_almacen_logico';
	fV[0]=maestro.id_almacen_logico;
	// txt id_item
	vectorAtributos[7]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Código Material',
			valueField: 'id_item',
			displayField: 'codigo',
			tipo:'salida',//determina el action a llamar
			filterCols:fC,
			filterValues:fV,
			allowBlank:false,
			maxLength:100,
			renderer:render_id_item,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:90, // ancho de columna en el grid
			pageSize:10,
			direccion:direccion,
			width:'90%',
			//indice_id:3,
			grid_indice:1
		},
		tipo:'LovItemsAlm',
		save_as:'txt_id_item',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		id_grupo:1
	};

	vectorAtributos[8]= {
		validacion:{
			name:'id_transferencia',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_transferencia,
		save_as:'txt_id_transferencia'
	};

	vectorAtributos[9]= {
		validacion: {
			name:'id_unidad_constructiva',
			fieldLabel:'Id Unidad Constructiva',
			allowBlank:true,
			emptyText:'Id Unidad Constructiva...',
			desc: 'desc_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_constructiva,
			valueField: 'id_unidad_constructiva',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'UNICONS.codigo#UNICONS.direccion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:'100%',
			renderer:render_id_unidad_constructiva,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'UNICONS.codigo',
		defecto: '',
		save_as:'txt_id_unidad_constructiva',
		id_grupo:3
	};

	vectorAtributos[10]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Item',
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
		id_grupo:1
	};

	vectorAtributos[11]= {
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
		id_grupo:1
	};

	vectorAtributos[12]= {
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
		filtro_0:true,
		filterColValue:'SUPGRU.nombre',
		save_as:'txt_super_grupo',
		id_grupo:1
	};

	vectorAtributos[13]= {
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
		filtro_0:true,
		filterColValue:'GRUPO.nombre',
		save_as:'txt_grupo',
		id_grupo:1
	};

	vectorAtributos[14]= {
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
		filtro_0:true,
		filterColValue:'SUBGRU.nombre',
		save_as:'txt_sub_grupo',
		id_grupo:1
	};

	vectorAtributos[15]= {
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
		filtro_0:true,
		filterColValue:'IDENT1.nombre',
		save_as:'txt_id1',
		id_grupo:1
	};

	vectorAtributos[16]= {
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
		filtro_0:true,
		filterColValue:'IDENT2.nombre',
		save_as:'txt_id2',
		id_grupo:1
	};

	vectorAtributos[17]= {
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
		filtro_0:true,
		filterColValue:'IDENT3.nombre',
		save_as:'txt_id3',
		id_grupo:1
	};


	//----------- FUNCIONES RENDER

	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Entre Almacenes lógicos (Maestro)',
		titulo_detalle:'Detalle de Transferencia (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_transferencia_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_transferencia_det.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_transferencia_det,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CmGetComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
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
		btnEliminar:{url:direccion+'../../../control/transferencia_det/ActionEliminarTransferenciaDet.php',parametros:'&m_id_transferencia='+maestro.id_transferencia},
		Save:{url:direccion+'../../../control/transferencia_det/ActionGuardarTransferenciaDet.php',parametros:'&m_id_transferencia='+maestro.id_transferencia},
		ConfirmSave:{url:direccion+'../../../control/transferencia_det/ActionGuardarTransferenciaDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',
		width:'80%',


		minWidth:150,minHeight:200,closable:true,titulo: 'Detalle de Transferencia',
		columnas:['47%','47%'],
		grupos:[
		{
			tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Datos de Material',
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Datos para Transferencia',
			columna:1,
			id_grupo:2
		},
		{
			tituloGrupo:'Unidad Constructiva',
			columna:1,
			id_grupo:3
		}
		]}

	}

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_transferencia=datos.m_id_transferencia;
		maestro.id_almacen_logico=datos.m_id_almacen_logico;
		maestro.desc_almacen_logico= datos.m_almacen_logico;		
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_transferencia:maestro.id_transferencia
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Transferencia',maestro.id_transferencia],['Almacen Logico Id',maestro.id_almacen_logico],['Almacen Logico',maestro.desc_almacen_logico]]);
		vectorAtributos[8].defecto=maestro.id_transferencia;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/transferencia_det/ActionEliminarTransferenciaDet.php',parametros:'&m_id_transferencia='+maestro.id_transferencia},
			Save:{url:direccion+'../../../control/transferencia_det/ActionGuardarTransferenciaDet.php',parametros:'&m_id_transferencia='+maestro.id_transferencia},
			ConfirmSave:{url:direccion+'../../../control/transferencia_det/ActionGuardarTransferenciaDet.php',parametros:'&m_id_transferencia='+maestro.id_transferencia},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Transferencia Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
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
		cmb_estado_item=ClaseMadre_getComponente('estado_item');

		var onItemSelect=function(e){
			rec=cmb_Item.lov.getSelect();
			txt_nombre.setValue(rec["nombre"]);
			txt_descripcion.setValue(rec["descripcion"]);
			txt_super_grupo.setValue(rec["nombre_supg"]);
			txt_grupo.setValue(rec["nombre_grupo"]);
			txt_sub_grupo.setValue(rec["nombre_subg"]);
			txt_id1.setValue(rec["nombre_id1"]);
			txt_id2.setValue(rec["nombre_id2"]);
			txt_id3.setValue(rec["nombre_id3"]);

			//obtiene las cantidades máximas y mínimas
			cantMaxNuevo=rec["nuevo"];
			cantMaxUsado=rec["usado"];

			//Define la cantidad máxima a solicitar
			if(cmb_estado_item.getValue()=='Nuevo')
			{txt_cantidad.maxValue=cantMaxNuevo}
			else
			{txt_cantidad.maxValue=cantMaxUsado}
			
			//Verifica si la cantidad está disponible o no
			txt_cantidad.validate();
		};

		var onEstadoChange=function(e){
			if(cmb_estado_item.getValue()=='Nuevo')
			{
				txt_cantidad.maxValue=cantMaxNuevo
			}
			else
			{
				txt_cantidad.maxValue=cantMaxUsado
			}
			//Verifica si la cantidad está disponible o no
			txt_cantidad.validate();
		};


		var CalcularCostoTotal = function(e) {
			var unit = txt_costo_unitario.getValue();
			var cant = txt_cantidad.getValue();

			if(unit!=undefined && unit!=null && cant!=undefined && cant!=null)
			{
				txt_costo_total.setValue(unit*cant);
			}
			else
			{
				txt_costo_total.setValue('0');
			}
		};

		txt_costo_unitario.on('blur',CalcularCostoTotal);
		txt_cantidad.on('blur',CalcularCostoTotal);
		cmb_Item.on('change',onItemSelect);
		cmb_estado_item.on('select',onEstadoChange);
	}


	this.btnNew=function(){

		CM_ocultarGrupo('Oculto');
		ClaseMadre_btnNew();
		cmb_Item.modificado = true;
		
		
	}


	this.btnEdit=function(){

		CM_ocultarGrupo('Oculto');
		ClaseMadre_btnEdit();
		cmb_Item.modificado = true;
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_transferencia_det.getLayout();
	};

	function InitPaginaTransferenciaDet()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}

		CM_ocultarComponente(componentes[3]);//Costo total
		CM_ocultarComponente(componentes[4]);//precio unitario
		//CM_ocultarComponente(componentes[9]);//precio unitario 
		CM_ocultarGrupo('Unidad Constructiva');
	}



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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaTransferenciaDet();
	layout_transferencia_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}