/**
 * Nombre:		  	    pagina_descuento_bono.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		11-08-2010
 */
function pagina_descuento_bono(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/descuento_bono/ActionListarDescuentoBono.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_descuento_bono',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_descuento_bono','id_tipo_descuento_bono',
		'id_empleado',
		'id_moneda',
		'monto_total','num_cuotas','monto_faltante','valor_por_cuota',
		{name:'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg','desc_tipo_descuento_bono','desc_empleado','desc_moneda'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_empleado:maestro.id_empleado
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    var dataMaestro=[['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	
	ds_tipo_descuento_bono=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_descuento_bono/ActionListarTipoDescuentoBono.php?estado=activo"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_descuento_bono',totalRecords:'TotalCount'},['id_tipo_descuento_bono','nombre','tipo','codigo','descripcion','modalidad'])});
	
		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_moneda',totalRecords: 'TotalCount'	}, ['id_moneda','nombre'])//,
	});
	
	//FUNCIONES RENDER
	function render_id_tipo_descuento_bono(value,p,record){return String.format('{0}',record.data['desc_tipo_descuento_bono'])}
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_descuento_bono',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'id_empleado'
	};
	
	vectorAtributos[2]={
	validacion:{
		fieldLabel:'Descuento/Bono',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Descuento/Bono...',
		name:'id_tipo_descuento_bono',
		desc:'desc_tipo_descuento_bono',
		store:ds_tipo_descuento_bono,
		valueField:'id_tipo_descuento_bono',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'DESBONO.nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_tipo_descuento_bono,
		
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200
	},
	save_as:'id_tipo_descuento_bono',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'DESBONO.nombre'
};
    
vectorAtributos[3]={
	validacion:{
		fieldLabel:'Moneda',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Moneda...',
		name:'id_moneda',
		desc:'desc_moneda',
		store:ds_moneda,
		valueField:'id_moneda',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'MONEDA.nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_moneda,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200
	},
	save_as:'id_moneda',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'MONEDA.nombre'
};

vectorAtributos[4]={
		validacion:{
			name: 'monto_total',
			
			fieldLabel: 'Monto Total',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto",
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:115 // ancho de columna en el grid
		
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'EMPBONO.monto_total',
		filtro_1:true,
		save_as:'monto_total'
	};
	
	vectorAtributos[5]={
		validacion:{
			name: 'num_cuotas',
			
			fieldLabel: 'Nº Cuotas',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 0,
			vtype:"texto",
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:115
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'EMPBONO.num_cuotas',
		filtro_1:true,
		save_as:'num_cuotas'
	};
	
	vectorAtributos[6]={
		validacion:{
			name: 'monto_faltante',
			
			fieldLabel: 'Monto Faltante',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto",
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:115 // ancho de columna en el grid
		
			
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'EMPBONO.monto_faltante',
		filtro_1:true,
		save_as:'monto_faltante'
	};
	
	
	vectorAtributos[7]={
		validacion:{
			name: 'valor_por_cuota',
			fieldLabel: 'Valor x Cuota',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			vtype:"texto",
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:115 // ancho de columna en el grid
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'EMPBONO.valor_por_cuota',
		filtro_1:true,
		save_as:'valor_por_cuota'
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPBONO.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini'
	};	
	// txt fecha_registro
	vectorAtributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPBONO.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};	
	
	vectorAtributos[10]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPBONO.estado_reg',
		save_as:'estado_reg'
		};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Empleados Bono/Descuento(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_descuento_bono=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_descuento_bono.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_descuento_bono,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/descuento_bono/ActionEliminarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/descuento_bono/ActionGuardarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/descuento_bono/ActionGuardarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Bono/Descuento'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_empleado=datos.m_id_empleado;
		maestro.id_persona=datos.m_id_persona;
		maestro.codigo_empleado=datos.m_codigo_empleado;
		maestro.desc_persona=datos.m_desc_persona;
		maestro.email1=datos.m_email1;
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]]);
		vectorAtributos[1].defecto=maestro.id_empleado;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/descuento_bono/ActionEliminarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/descuento_bono/ActionGuardarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/descuento_bono/ActionGuardarDescuentoBono.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Bono/Descuento'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		cmb_tipo=getComponente('id_tipo_descuento_bono');
		
		var onTipo=function(e,r,o){
			if(r.data.modalidad=='porcentual'){
				ocultarComponente(getComponente('monto_total'));
				ocultarComponente(getComponente('num_cuotas'));
				ocultarComponente(getComponente('monto_faltante'));
				ocultarComponente(getComponente('valor_por_cuota'));
				ocultarComponente(getComponente('monto_total'));
				
				getComponente('monto_total').reset();
				getComponente('num_cuotas').reset();
				getComponente('monto_faltante').reset();
				getComponente('valor_por_cuota').reset();
				getComponente('monto_total').reset();
				
				
				getComponente('monto_total').allowBlank=true;
				getComponente('num_cuotas').allowBlank=true;
				getComponente('monto_faltante').allowBlank=true;
				getComponente('valor_por_cuota').allowBlank=true;
				getComponente('monto_total').allowBlank=true;
			}else{
				mostrarComponente(getComponente('monto_total'));
				mostrarComponente(getComponente('num_cuotas'));
				mostrarComponente(getComponente('monto_faltante'));
				mostrarComponente(getComponente('valor_por_cuota'));
				mostrarComponente(getComponente('monto_total'));
				
				getComponente('monto_total').allowBlank=false;
				getComponente('num_cuotas').allowBlank=false;
				getComponente('monto_faltante').allowBlank=false;
				getComponente('valor_por_cuota').allowBlank=false;
				getComponente('monto_total').allowBlank=false;
				
				
			}
		}
		
		cmb_tipo.on('select',onTipo);
		
	}
	this.btnNew=function(){
		ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			mostrarComponente(getComponente('fecha_reg'));
			ClaseMadre_btnEdit()
		}else{
			alert("Antes debe seleccionar un item");
		}
	
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_descuento_bono.getLayout()
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
	layout_descuento_bono.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}