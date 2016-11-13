/**
 * Nombre: pagina_columna_valor.js Propï¿½sito: pagina objeto principal Autor:
 * Generado Automaticamente Fecha creaciï¿½n: 2010-08-30 15:43:31
 */
function pagina_columna_valor(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	// ///////////////
	// DATA STORE //
	// ///////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/columna_valor/ActionListarColumnaValor.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_columna_valor',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_columna_valor',
		'id_empleado_planilla',
		'id_columna',
		'valor',
		'valor_automatico',
		'usuario_reg',
		'fecha_reg',
		'estado_reg',
		'nombre_columna',
		'formula','tipo_dato'
		]),remoteSort:true});

	
	// DATA STORE COMBOS

	// FUNCIONES RENDER
	function render_id_columna(value, p, record){return String.format('{0}', record.data['nombre_columna']);}
	
	
	// ///////////////////////
	// Definiciï¿½n de datos //
	// ///////////////////////
	
	// hidden id_columna_valor
	// en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_columna_valor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	// txt id_empleado_planilla
	Atributos[1]={
		validacion:{
			name:'id_empleado_planilla',
			fieldLabel:'id_empleado_planilla',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'COLVAL.id_empleado_planilla'
	};
	// txt id_columna
	Atributos[2]={
		validacion:{
			name:'id_columna',
			fieldLabel:'Columna',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,	
			width:'100%',
			disabled:false,
			renderer:render_id_columna
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'TIPCOL.nombre'
	};
// txt valor
	Atributos[3]={
		validacion:{
			name:'valor',
			fieldLabel:'Valor',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,// para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'COLVAL.valor'
	};
// txt valor_automatico
	Atributos[4]={
		validacion:{
			name:'valor_automatico',
			fieldLabel:'Valor generado',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,// para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'COLVAL.valor_automatico'
	};
// txt usuario_reg
	Atributos[5]={
		validacion:{
			name:'usuario_reg',
			fieldLabel:'Usuario',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'COLVAL.usuario_reg'
	};
// txt fecha_reg
	Atributos[6]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:false,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'COLVAL.fecha_reg',
	};
	
	
	Atributos[7]={
			validacion:{
				name:'formula',
				fieldLabel:'Fórmula',
				grid_visible:true,
				grid_editable:false,
				width_grid:150		
			},
			tipo:'Field',
			filtro_0:true,
			form:false,		
			filterColValue:'COLUMN.formula',
		};
	
	// txt estado_reg
	Atributos[8]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'COLVAL.estado_reg'
	};

	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'tipo_dato',
			fieldLabel:'Tipo Dato',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	// ----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	// ---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Columna-Valor ',grid_maestro:'grid-'+idContenedor};
	var layout_columna_valor = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_columna_valor.init(config);
	
	
	
	// ---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_columna_valor,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var enableSelect=this.EnableSelect;
	var EstehtmlMaestro=this.htmlMaestro;
	// DEFINICIÓN DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	// DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/columna_valor/ActionEliminarColumnaValor.php'},
	Save:{url:direccion+'../../../control/columna_valor/ActionGuardarColumnaValor.php'},
	ConfirmSave:{url:direccion+'../../../control/columna_valor/ActionGuardarColumnaValor.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Columna - Valor'}};
	
	// -------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_empleado_planilla:maestro.id_empleado_planilla
			}
		};
		this.btnActualizar();
		// iniciarEventosFormularios();


		Atributos[1].defecto=maestro.id_empleado_planilla;

		paramFunciones.btnEliminar.parametros='&m_id_empleado_planilla='+maestro.id_empleado_planilla;
		paramFunciones.Save.parametros='&m_id_empleado_planilla='+maestro.id_empleado_planilla;
		paramFunciones.ConfirmSave.parametros='&m_id_empleado_planilla='+maestro.id_empleado_planilla;

		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones)
		
	};
	
	// Para manejo de eventos
	function iniciarEventosFormularios(){	
	// para iniciar eventos en el formulario

	}
	

	// para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_columna_valor.getLayout()};
	// para el manejo de hijos
	
	this.Init(); // iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	// para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	/*
	 * layout_columna_valor.getLayout().addListener('layout',this.onResize);
	 * layout_columna_valor.getVentana(idContenedor).on('resize',function(){layout_columna_valor.getLayout().layout()})
	 */
	
	layout_columna_valor.getLayout().addListener('layout',this.onResize);

	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}