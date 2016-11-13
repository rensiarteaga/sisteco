/**
 * Nombre:		  	    pagina_parametro_kardex.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-13 09:27:55
 */
function pagina_parametro_kardex(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_kardex/ActionListarParametroKardex.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_parametro_kardex',totalRecords:'TotalCount'
		},[		
				'id_parametro_kardex',
		'id_gestion',
		'desc_gestion','salario_min_nacional','id_moneda','porcen_fijo_cooperativa','aporte_fijo_min_cooperativa','estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
				'desc_moneda','porcen_max_quincena','id_moneda_cooperativa','desc_moneda_coop','horas_mes_laboral',
				{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});

	
		ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/moneda/ActionListarMoneda.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo'])});
	//FUNCIONES RENDER
	
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
		function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda'])}
		function render_id_moneda_coop(value,p,record){return String.format('{0}',record.data['desc_moneda_coop'])}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}<br>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro_kardex
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_parametro_kardex',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt id_gestion
	Atributos[1]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'id_gestion...',
			desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		id_grupo:0
		
	};
	
	Atributos[3]={
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
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:render_id_moneda,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:230,
			width:130,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:150
		},
		save_as:'id_moneda',
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:0
	};

	Atributos[2]={
		validacion:{
			name:'salario_min_nacional',
			fieldLabel:'Salario Min. Nacional (Bs.)',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARKAR.salario_min_nacional',
		id_grupo:0
	};
	
	
	Atributos[4]={
		validacion:{
			name:'porcen_fijo_cooperativa',
			fieldLabel:'% Cooperativa (Básico)',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARKAR.porcen_fijo_cooperativa',
		id_grupo:1
	};
	
	Atributos[5]={
		validacion:{
			name:'aporte_fijo_min_cooperativa',
			fieldLabel:'Aporte Min. Cooperativa',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARKAR.aporte_fijo_min_cooperativa',
		id_grupo:1
	};
	
	
	
	Atributos[6]={
		validacion:{
			name:'porcen_max_quincena',
			fieldLabel:'% Max.Anticipo (Básico)',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARKAR.porcen_max_quincena',
		id_grupo:0
	};
	
	Atributos[7]={
		validacion:{
			fieldLabel:'Moneda Coop.',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Moneda...',
			name:'id_moneda_cooperativa',
			desc:'desc_moneda_coop',
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:render_id_moneda_coop,
			mode:'remote',
			queryDelay:50,
			pageSize:100,
			minListWidth:230,
			width:150,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		save_as:'id_moneda_coop',
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:1
	};
	
	
	Atributos[8]={
		validacion:{
			name:'horas_mes_laboral',
			fieldLabel:'Horas Mes Laboral',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			//maxValue:,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARKAR.horas_mes_laboral',
		id_grupo:0
	};
	
	Atributos[9]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['activo','Activo'],['inactivo','Inactivo']
						]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_tipo_capacitacion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width:150,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		form:true,
		filtro_1:false,
		filterColValue:'PARKAR.estado_reg',
		save_as:'estado_reg',
		id_grupo:0
		};
		
	Atributos[10]= {
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
			width_grid:100,
			width:150,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARKAR.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
	};
	
	Atributos[11]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio de Aplicación',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			width:150,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARKAR.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetros Generales Kardex',grid_maestro:'grid-'+idContenedor};
	var layout_parametro_kardex=new DocsLayoutMaestro(idContenedor);
	layout_parametro_kardex.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro_kardex,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro_kardex/ActionEliminarParametroKardex.php'},
		Save:{url:direccion+'../../../control/parametro_kardex/ActionGuardarParametroKardex.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro_kardex/ActionGuardarParametroKardex.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'45%',width:'55%',minWidth:350,minHeight:200,	
		columnas:['47%','47%'],
			grupos:[
			{
				tituloGrupo:'Parametros de Kardex',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Inf. Cooperativa',
				columna:1,
				id_grupo:1
			}],
		
		closable:true,titulo:'Parámetros Generales Kardex'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		txt_sal_min_nal=getComponente('salario_min_nacional');
		txt_id_moneda=getComponente('id_moneda');
		txt_porcen_fijo_cooperativa=getComponente('porcen_fijo_cooperativa');
		txt_aporte_fijo_min_cooperativa=getComponente('aporte_fijo_min_cooperativa');
		txt_porcen_max_quincena=getComponente('porcen_max_quincena');
		txt_id_moneda_cooperativa=getComponente('id_moneda_cooperativa');
	
		
		
		var onCambio=function(e,n,o){
			
			if(n!=o){
				getComponente('fecha_inicio').setValue('');
			}
		}
		txt_sal_min_nal.on('change',onCambio);
		txt_id_moneda.on('change',onCambio);
		txt_porcen_fijo_cooperativa.on('change',onCambio);
		txt_aporte_fijo_min_cooperativa.on('change',onCambio);
		txt_porcen_max_quincena.on('change',onCambio);
		txt_id_moneda_cooperativa.on('change',onCambio);
		
		
	}
	


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_parametro_kardex.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_parametro_kardex.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}