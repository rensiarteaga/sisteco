<?php
/**
 * Nombre:		  	    salida_detalle_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:09:31
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
var maestro={id_salida:<?php echo $m_id_salida;?>,estado_reg:'<?php echo $m_estado_reg;?>',emergencia:'<?php echo $m_emergencia;?>'};
var elemento={idContenedor:idContenedor,pagina:new pagina_salida_pendiente_detalle_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/** 
 * Nombre:		  	    pagina_salida_detalle_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:09:50
 */
function pagina_salida_pendiente_detalle_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida_detalle/ActionListarSalidaDetalle_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_salida_detalle',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
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
		'id_salida',
		'desc_salida',
		'desc_unidad_constructiva',
		'id_unidad_constructiva',
		'emergencia'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_salida:maestro.id_salida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
//var dataMaestro=[['Salida',maestro.id_salida],['Estado Registro',maestro.estado_reg]];

	 
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Id Salida',maestro.id_salida],['Estado Registro',maestro.estado_reg]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item',
			totalRecords: 'TotalCount'
		}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','costo_almacen','stock_min','stock_total','observaciones','nivel_convertido','estado_item','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
	});
  ds_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_unidad_constructiva','codigo','direccion','fecha_reg','id_tipo_unidad_constructiva','id_subactividad'])
	});
  

	//FUNCIONES RENDER
	
			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item'])};
			function render_id_salida(value, p, record){return String.format('{0}', record.data['desc_salida'])};
	        function render_id_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_unidad_constructiva'])};
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_salida_detalle
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_salida_detalle',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_salida_detalle',
		id_grupo:0
	};
	

// txt cant_solicitada
	vectorAtributos[1]= {
		validacion:{
			name:'cant_solicitada',
			fieldLabel:'Cantidad Solicitada',
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
			grid_editable:false,
			grid_indice:3,
			align:'right',
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'SALDET.cant_solicitada',
		save_as:'txt_cant_solicitada',
		id_grupo:1
	};
	
	// txt cant_solicitada
	vectorAtributos[2]= {
		validacion:{
			name:'cant_entregada',
			fieldLabel:'Cantidad Entregada',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			align:'right',
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'SALDET.cant_entregada',
		save_as:'txt_cant_entregada',
		id_grupo:1
	};
	


// txt id_item
	vectorAtributos[3]= {
			validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank:true,			
			emptyText:'Item...',
			desc: 'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item,
			valueField: 'id_item',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ITEM.codigo#ITEM.nombre#ITEM.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_item,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		defecto: '',
		save_as:'txt_id_item',
		id_grupo:0
	};
	
// txt id_salida
	vectorAtributos[4]= {
		validacion:{
			name:'id_salida',
			fieldLabel:'Pedido',
			allowBlank:true,			
			desc: 'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			queryParam: 'filterValue_0',
			filterCol:'ITEM.codigo#ITEM.nombre#ITEM.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_salida,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_salida,
		save_as:'txt_id_salida',
		id_grupo:0
	};
	
	// txt costo
	vectorAtributos[5]= {
		validacion:{
			name:'costo',
			fieldLabel:'Costo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.costo',
		save_as:'txt_costo',
		id_grupo:0
	};
	
// txt costo_unitario
	vectorAtributos[6]= {
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Costo Unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.costo_unitario',
		save_as:'txt_costo_unitario',
		id_grupo:0
	};
	
// txt precio_unitario
	vectorAtributos[7]= {
		validacion:{
			name:'precio_unitario',
			fieldLabel:'Precio Unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.precio_unitario',
		save_as:'txt_precio_unitario',
		id_grupo:0
	};
	
	// txt cant_consolidada
	vectorAtributos[8]= {
		validacion:{
			name:'cant_consolidada',
			fieldLabel:'Cantidad Consolidada',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			align:'right',
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.cant_consolidada',
		save_as:'txt_cant_consolidada',
		id_grupo:0
	};
	
	// txt fecha_solicitada
	vectorAtributos[9]= {
		validacion:{
			name:'fecha_solicitada',
			fieldLabel:'Fecha Solicitada',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_solicitada',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_solicitada',
		id_grupo:0
	};
	
// txt fecha_entregada
	vectorAtributos[10]= {
		validacion:{
			name:'fecha_entregada',
			fieldLabel:'Fecha Entregada',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_entregado',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_entregada',
		id_grupo:0
	};
	
// txt fecha_consolidada
	vectorAtributos[11]= {
		validacion:{
			name:'fecha_consolidada',
			fieldLabel:'Fecha Consolidada',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_consolidada',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_consolidada',
		id_grupo:0
	};
	
// txt fecha_reg
	vectorAtributos[12]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fehca registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:0
	};
	
	// txt id_unidad_constructiva
	vectorAtributos[13]= {
			validacion: {
			name:'id_unidad_constructiva',
			fieldLabel:'Unidad Constructiva',
			allowBlank:true,			
			emptyText:'Unidad Constructiva...',
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
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_constructiva,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'UNICONS.codigo',
		defecto: '',
		save_as:'txt_id_unidad_constructiva',
		id_grupo:0
	};
	
		
	
	vectorAtributos[14]={
			validacion:{
				name:'emergencia',
				fieldLabel:'Emergencia',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:true,
				align:'center',
				width_grid:100
			},
			tipo:'TextField',
			defecto:'Si',
			filterColValue:'SALIDA.emergencia',
			save_as:'txt_emergencia',
			id_grupo:0
		};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Salida Pendiente de Material (Maestro)',
		titulo_detalle:'Detalles de Salida Pendiente de Material (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_salida_pendiente_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_salida_pendiente_detalle.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_pendiente_detalle,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	//var ClaseMadre_conexionFailure=this.conexionFailure;
	//var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	//var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	//var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	//var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	//var ClaseMadre_btnEliminar = this.btnEliminar;
	//var ClaseMadre_btnActualizar = this.btnActualizar;
	var Cm_Destroy=this.Destroy;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ

	var paramMenu={actualizar:{crear:true,separador:false}};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
	Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetallePendiente.php',parametros:'&m_id_salida='+maestro.id_salida},
	ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetallePendiente.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',width:'45%',minWidth:100,minHeight:200,closable:true,titulo: 'Salida Detalle',
	grupos:[
	{
		tituloGrupo:'Oculto',
		columna:0,
		id_grupo:0
	},
	{
		tituloGrupo:'Detalle de Salida Pendiente de Material',
		columna:0,
		id_grupo:1
	}
	
	]}	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	
		this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_salida=datos.m_id_salida;
		maestro.estado_reg=datos.m_estado_reg;
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_salida:maestro.id_salida
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Id Salida',maestro.id_salida],['Estado',maestro.estado_reg]]);
		vectorAtributos[4].defecto=maestro.id_salida;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Salida Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
	
	 function btn_cantidad_entregada(){
	 	
	 	CM_ocultarGrupo('Oculto');
	 	
	 	
	 	if(componentes[13].getValue()=='Si'){ 	  	
	  		CM_mostrarComponente(componentes[1]);
	  		CM_ocultarComponente(componentes[0]);
	  		componentes[1].disable()
	 	}
	  	else{
	 		CM_mostrarComponente(componentes[0]);
	  		componentes[0].disable();
//	  		componentes[1].setValue(componentes[0].getValue());
	  		CM_mostrarComponente(componentes[1])
	  	 }	
	  	 
	  	 if(componentes[1].getValue()<=componentes[0].getValue() && componentes[1].getValue()>0)
	  	 {
	  	 	ClaseMadre_btnEdit()
	  	 }
	  	 else{
	  	 	
	  	 	Ext.MessageBox.alert('Cantidad a Entregar', 'La cantidad a entregar debe ser Menor o Igual a la Cantidad Solicitada')
	  	 }
	 }
	function iniciarEventosFormularios()
	{	
	  txt_cant_solicitada = ClaseMadre_getComponente('cant_solicitada');
	  txt_cant_entregada = ClaseMadre_getComponente('cant_entregada');
	  function onCantidadSelect () 
	  {
		  var cantidad=txt_cant_entregada.getValue(); 
			if(cantidad<=0)
			{
				Ext.MessageBox.alert('Cantidad a Entregar', 'La cantidad a entregar debe ser mayor o igual a 1')
			}
			else
			{
				if(cantidad > componentes[0].getValue())
				{
					Ext.MessageBox.alert('Cantidad a Entregar', 'La cantidad a entregar debe ser Menor o Igual a la Cantidad Solicitada')
				}			
			}	
	   }
		 txt_cant_entregada.on('select', onCantidadSelect);
		 txt_cant_entregada.on('change', onCantidadSelect);
		 txt_cant_entregada.on('blur', onCantidadSelect)
	}
	 function iniciarPaginaSalidaPendienteDetalle()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	} 
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_salida_pendiente_detalle.getLayout()
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
	 this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_cantidad_entregada,true,'Cantidad Entregada','Cantidad Entregada');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	iniciarPaginaSalidaPendienteDetalle();
	layout_salida_pendiente_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}