/**
 * Nombre:		  	    pagina_servicio_propuesto_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-05 12:16:12
 */
function pagina_servicio_propuesto_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio_propuesto/ActionListarServicioPropuesto_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_servicio_propuesto',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_servicio_propuesto',
		'nombre',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'monto',
		'id_proveedor',
		'desc_proveedor',
		'desc_moneda',
		'id_moneda'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_:maestro.
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['',maestro.],['',maestro.]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','nombre_pago','id_persona','id_institucion'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">usuario</FONT>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">nombre</FONT>','</div>');
;
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_servicio_propuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_servicio_propuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_servicio_propuesto'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'SPROPU.nombre',
		save_as:'txt_nombre'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'descripcion',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'SPROPU.descripcion',
		save_as:'txt_descripcion'
	};
// txt fecha_reg
	Atributos[3]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'fecha_reg',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SPROPU.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt monto
	Atributos[4]={
		validacion:{
			name:'monto',
			fieldLabel:'monto',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'SPROPU.monto',
		save_as:'txt_monto'
	};
// txt id_proveedor
	Atributos[5]= {
			validacion: {
			name:'id_proveedor',
			fieldLabel:'id_proveedor',
			allowBlank:false,			
			emptyText:'id_proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROVEE.codigo#PROVEE.usuario#PROVEE.codigo#PROVEE.id_institucion#PROVEE.id_persona',
			typeAhead:true,
			tpl:tpl_id_proveedor,
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
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PROVEE.codigo',
		save_as:'txt_id_proveedor'
	};
// txt id_moneda
	Atributos[6]= {
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
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Clasificación de Servicios (Maestro)',titulo_detalle:'Servicios Propuestos (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_servicio_propuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_servicio_propuesto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_servicio_propuesto,idContenedor);
	var getComponente=this.getComponente;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/servicio_propuesto/ActionEliminarServicioPropuesto.php',parametros:'&m_='+maestro.},
	Save:{url:direccion+'../../../control/servicio_propuesto/ActionGuardarServicioPropuesto.php',parametros:'&m_='+maestro.},
	ConfirmSave:{url:direccion+'../../../control/servicio_propuesto/ActionGuardarServicioPropuesto.php',parametros:'&m_='+maestro.},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'servicio_propuesto'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.=datos.m_;

		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_:maestro.
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['',maestro.],['',maestro.]]);
		
		paramFunciones.btnEliminar.parametros='&m_='+maestro.;
		paramFunciones.Save.parametros='&m_='+maestro.;
		paramFunciones.ConfirmSave.parametros='&m_='+maestro.;
		this.InitFunciones(paramFunciones)
	};
	function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_servicio_propuesto='+SelectionsRecord.data.id_servicio_propuesto;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_servicio_propuesto.loadWindows(direccion+'../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Caracteristicas',ParamVentana);
layout_servicio_propuesto.getVentana().on('resize',function(){
			layout_servicio_propuesto.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_servicio_propuesto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Caracteristicas',btn_caracteristica,true,'caracteristica','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_servicio_propuesto.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}