/**
 * Nombre:		  	    pagina_item_proveedor_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-02 09:03:14
 */
function pagina_item_proveedor_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_proveedor/ActionListarItemProveedor_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item_proveedor',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_item_proveedor',
		'precio_ult',
		{name: 'fecha_ult_mod',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		'id_item',
		'desc_item',
		'id_moneda',
		'desc_moneda',
		'id_item_propuesto',
		'desc_item_propuesto',
		'desc_proveedor',
		'id_proveedor'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_proveedor:maestro.id_proveedor
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//DATA STORE COMBOS

    var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../sis_almacenes/control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_item_propuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_propuesto/ActionListarItemPropuesto.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item_propuesto',totalRecords:'TotalCount'},['id_item_propuesto','codigo','nombre','descripcion','costo_estimado','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_proveedor'])
	});

	//FUNCIONES RENDER
	
	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	function render_id_item_propuesto(value, p, record){return String.format('{0}', record.data['desc_item_propuesto']);}
	var tpl_id_item_propuesto=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion }</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_item_proveedor
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_item_proveedor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_item_proveedor'
	};
	
	
// txt id_item
	Atributos[1]= {
			validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Item',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			store:ds_item,
			renderer:render_id_item,
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:200,
			pageSize:10,
			direccion:direccion,
			grid_indice:1
			},
		tipo:'LovItemsAlm',
		filtro_0:true,
		filterColValue:'ITEM.codigo#ITEM.nombre',
		save_as:'txt_id_item'
	};
	
	
// txt precio_ult
	Atributos[2]={
		validacion:{
			name:'precio_ult',
			fieldLabel:'Precio',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			align:'right',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:2,
			width_grid:75
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'IPROVE.precio_ult',
		save_as:'txt_precio_ult'
	};
		
// txt id_moneda
	Atributos[3]= {
			validacion: {
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
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
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			grid_indice:3,
			width_grid:115 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda'
	};
	
// txt fecha_ult_mod
	Atributos[4]={
		validacion:{
			name:'fecha_ult_mod',
			fieldLabel:'Fecha Ultima Actualización',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			grid_indice:5,
			renderer: formatDate,
			align:'center',
			width_grid:160,
			disabled:false
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'IPROVE.fecha_ult_mod',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ult_mod'
	};
	
	// txt observaciones
	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:4,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'IPROVE.observaciones',
		save_as:'txt_observaciones'
	};
	
// txt fecha_reg
	Atributos[6]={
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
			width_grid:90,
			align:'center',
			grid_indice:6,
			disabled:true
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'IPROVE.fecha_reg',
		dateFormat:'m-d-Y',
		//defecto:'',
		save_as:'txt_fecha_reg'
	};


// txt id_item_propuesto
	Atributos[7]= {
			validacion: {
			name:'id_item_propuesto',
			fieldLabel:'Item Propuesto',
			allowBlank:false,			
			emptyText:'Item Propuesto...',
			desc: 'desc_item_propuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item_propuesto,
			valueField: 'id_item_propuesto',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'IPROPU.nombre#IPROPU.descripcion',
			typeAhead:true,
			tpl:tpl_id_item_propuesto,
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
			renderer:render_id_item_propuesto,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'IPROPU.nombre',
		save_as:'txt_id_item_propuesto'
	};
// txt id_proveedor
	Atributos[8]={
		validacion:{
			name:'id_proveedor',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_proveedor,
		save_as:'txt_id_proveedor'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Proveedores (Maestro)',titulo_detalle:'Productos (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_item_proveedor = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_item_proveedor.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_item_proveedor,idContenedor);
	var getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/item_proveedor/ActionEliminarItemProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	Save:{url:direccion+'../../../control/item_proveedor/ActionGuardarItemProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	ConfirmSave:{url:direccion+'../../../control/item_proveedor/ActionGuardarItemProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'item_proveedor'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php?id_proveedor='+maestro.id_proveedor}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor',
		'observaciones',
		'codigo',
		'nombre_proveedor',
		'nombre_cuenta',
		'nombre_auxiliar'
		])
		});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_proveedor:maestro.id_proveedor

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			data1=[['Codigo',ds_maestro.getAt(0).get('codigo')],['Proveedor',ds_maestro.getAt(0).get('nombre_proveedor')],['Cuenta',ds_maestro.getAt(0).get('nombre_cuenta')],['Auxiliar',ds_maestro.getAt(0).get('nombre_auxiliar')],['Observaciones',ds_maestro.getAt(0).get('observaciones')]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
		}
	
	this.reload=function(params){
	var datos=Ext.urlDecode(decodeURIComponent(params));
	
 		maestro.id_proveedor=datos.m_id_proveedor;
		maestro.codigo=datos.m_codigo
		maestro.nombre_proveedor=datos.m_nombre_proveedor
		maestro.codigo=datos.m_codigo
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_proveedor:maestro.id_proveedor

				},
				callback:cargar_maestro
			});

		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proveedor:maestro.id_proveedor
			}
		});
		Atributos[8].defecto=maestro.id_proveedor;
		paramFunciones.btnEliminar.parametros='&m_id_proveedor='+maestro.id_proveedor;
		paramFunciones.Save.parametros='&m_id_proveedor='+maestro.id_proveedor;
		paramFunciones.ConfirmSave.parametros='&m_id_proveedor='+maestro.id_proveedor;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	cmb_Item=getComponente('id_item');
			txt_precio=getComponente('precio_ult');
			
		var onItemSelect=function(e){
				rec=cmb_Item.lov.getSelect();
				txt_precio.setValue(rec["costo_estimado"]);
				
		}
	cmb_Item.on('change',onItemSelect);
	
	}

	this.btnNew=function(){
		
		CM_ocultarComponente(getComponente('id_item_propuesto'));
		getComponente('id_item_propuesto').allowBlank=true;
		CM_ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnNew();
	};
	
	this.btnEdit=function(){
		CM_ocultarComponente(getComponente('id_item_propuesto'));
		getComponente('id_item_propuesto').allowBlank=true;
		CM_ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnEdit();
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_item_proveedor.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item_proveedor.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}