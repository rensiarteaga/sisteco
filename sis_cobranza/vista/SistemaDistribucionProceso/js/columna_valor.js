/**
 * Nombre:		  	    pagina_registro_documento.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
 */
function pagina_ColumnaValor(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{   
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var componentes_grid=new Array();
	var grid;	
	var var_record;	
	 
	var var_id_concepto_factura;
	var var_id_presupuesto;
	var var_id_partida_cuenta;
	var var_id_partida;
	var	var_id_cuenta;
	var var_id_auxiliar;
	 
	/////////////////
	//  DATA STORE //
	/////////////////
  	var Documento = Ext.data.Record.create(['id_columna_valor','id_concepto_factura','nombre_concepto','id_tipo_facturacion_cobranza','nombre_proceso',
  	'id_cuenta','nombre_cuenta','id_partida','nombre_partida','id_auxiliar','nombre_auxiliar','id_presupuesto','desc_presupuesto','sw_presto','sw_fecha_separativa','sw_estado','id_usuario','nombre_completo','fecha_reg','nombre_columna','calculo_conta','calculo_presto','sw_debe_haber']);
	var ds = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ColumnaValor/ActionListarColumnaValor.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_documento',	totalRecords: 'TotalCount'}, Documento),remoteSort:true});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Nombre Concepto ',maestro.nombre_concepto,'Tipo Concepto',maestro.tipo_concepto],
					  ['Lugar',maestro.nombre_lugar],
					  ['Categoria',maestro.nombre_categoria_cliente]];
	
	//DATA STORE GRILLA
	ds.load({params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_concepto_factura:maestro.id_concepto_factura
					}
			});	
    //FUNCIONES DE LOS COMBOS
	var ds_id_tipo_facturacion_cobranza = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/TipoFacturacionCobranza/ActionListarTipoFacturacionCobranza.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_facturacion_cobranza',totalRecords: 'TotalCount'},['id_tipo_facturacion_cobranza','nombre_proceso','sw_periodo','sw_banco'])});
 	var tpl_id_tipo_facturacion_cobranza=new Ext.Template('<div class="search-item">','<b>Tipo Proceso de Facturacion o cobranza: </b><FONT COLOR="#B5A642">{nombre_proceso}</FONT> ></FONT>','</div>');
	function render_id_tipo_facturacion_cobranza(value, p, record){return String.format('{0}', record.data['nombre_proceso']);}
	
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres','estado_pres','id_fuente_financiamiento','nombre_fuente_financiamiento','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad','id_parametro','gestion_pres' ])});
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}} 
    var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestión: </b> <FONT COLOR="#0000ff">{gestion_pres} </FONT> ',
		'<b>Tipo Presupuesto: </b> <FONT COLOR="#0000ff">{tipo_pres} </FONT> ',
		'<br><b>Fuente de Financiamineto: </b><FONT COLOR="#0000ff">{sigla}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#0000ff">{nombre_unidad}</FONT>',
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#0000ff">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#0000ff">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_actividad}</FONT>',
		'</div>');
    var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});	 
	function render_id_auxiliar(value, p, record){return String.format('{0}',record.data['nombre_auxiliar'])}
    var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');	 
	var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarCuentaPartida.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_cuenta','id_partida','partida_cuenta','sw_deha','sw_rega', 'id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida','id_gestion','id_moneda','desc_moneda','sw_movimiento'])});
	function render_id_partida_cuenta(value, p, record){return String.format('{0}', record.data['nombre_partida']+" - "+record.data['nombre_cuenta'])};
	var tpl_id_partida_cuenta=new Ext.Template('<div class="search-item">','<b>Partida: </b><FONT COLOR="#0000ff">{codigo_partida}</FONT> - ','<FONT COLOR="#0000ff">{nombre_partida}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_sw_presto(value, p, record){	if(value=='si'){return 'SI';}if(value=='no'){return 'NO';}}
	function render_sw_fecha_separativa(value, p, record){	if(value=='si'){return 'SI';}if(value=='no'){return 'NO';}}
	function render_sw_estado(value, p, record){	if(value=='activo'){return 'ACTIVO';}if(value=='inactivo'){return 'INACTIVO';}}
	function render_sw_debe_haber(value, p, record){	if(value=='debe'){return 'DEBE';}if(value=='haber'){return 'HABER';}}
	
	var ds_nombre_columna = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/DatosEstructura/ActionListarDatosEstructura.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'nombre_columna',totalRecords: 'TotalCount'},['nombre_columna','tipo'])});	 
	function render_nombre_columna(value, p, record){return String.format('{0}',record.data['nombre_columna'])}
    var tpl_nombre_columna=new Ext.Template('<div class="search-item">','<b>Columna: </b><FONT COLOR="#0000ff">{nombre_columna}</FONT>','</div>');	 
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_documento
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_columna_valor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_columna_valor'
	};

		Atributos[1]={
		validacion:{
			name:'id_concepto_factura',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_concepto_factura,
		id_grupo:0,
		save_as:'id_concepto_factura'
	};	
 //  tipo_facturacion_cobranza
 Atributos[2]={
			validacion:{
			name:'id_tipo_facturacion_cobranza',
			fieldLabel:'Proceso',
			allowBlank:false,			
			emptyText:'proceso...',
			desc: 'nombre_proceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_tipo_facturacion_cobranza,
			valueField: 'id_tipo_facturacion_cobranza',
			displayField: 'nombre_proceso',
			queryParam: 'filterValue_0',
			filterCol:'nombre_proceso',
			typeAhead:false,
			tpl:tpl_id_tipo_facturacion_cobranza,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_facturacion_cobranza,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'id_tipo_facturacion_cobranza',
 		save_as:'id_tipo_facturacion_cobranza'
	};	
// txt id_presupuesto
Atributos[3]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.desc_presupuesto#PRESUP.desc_epe',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:false,
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
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'desc_presupuesto'
		 
	};
// txt id_orden_trabajo
	Atributos[4]={
		validacion:{
				fieldLabel:'Partida - Cuenta',
				allowBlank:false,
				emptyText:'Partida Cueta...',
				name:'id_partida_cuenta',
				desc:'desc_partida_cuenta',
				store:ds_partida_cuenta,
				valueField:'id_partida_cuenta',
				displayField:'partida_cuenta',
				queryParam:'filterValue_0',
				filterCol:'nro_cuenta#nombre_cuenta#codigo_partida#nombre_partida#partida_cuenta',
				tpl:tpl_id_partida_cuenta,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_id_partida_cuenta,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:2,
			form: true,
	 		filterColValue:'desc_partida_cuenta',
	  		save_as:'id_partida_cuenta'
	};

// txt id_auxiliar
	Atributos[5]={
			validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			tpl:tpl_id_auxiliar,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'desc_auxiliar',
		save_as:'id_auxiliar'
	};
Atributos[6]={
			validacion:{
				name:'sw_presto',
				fieldLabel:'SW Presupuesto',
				allowBlank:false,
				align:'left',
				emptyText:'Presupuesto...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_presto,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:2,
			save_as:'sw_presto'
		};
Atributos[7]={
			validacion:{
				name:'sw_fecha_separativa',
				fieldLabel:'Fecha Separacion',
				allowBlank:false,
				align:'left',
				emptyText:'Fecha...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_fecha_separativa,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			save_as:'sw_fecha_separativa'
		};
Atributos[8]={
			validacion:{
				name:'sw_estado',
				fieldLabel:'Estado',
				allowBlank:false,
				align:'left',
				emptyText:'Estado...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['activo','ACTIVO'],['inactivo','INACTIVO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_estado,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			defecto:'activo',
			id_grupo:1,
			save_as:'sw_estado'
		};
	
		// txt conexion
		Atributos[9]={
			validacion:{
				name:'nombre_completo',
				fieldLabel:'Usuario',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'usu.nombre_completo',
			save_as:'nombre_completo'
		};
					// txt conexion
		Atributos[10]={
			validacion:{
				name:'fechareg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'sis.fechareg' 
		};	
	
// txt id_auxiliar
	Atributos[11]={
			validacion:{
			name:'nombre_columna',
			fieldLabel:'Columna',
			allowBlank:true,			
			emptyText:'Columna...',
			desc: 'nombre_columna', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_nombre_columna,
			valueField: 'nombre_columna',
			displayField: 'nombre_columna',
			queryParam: 'filterValue_0',
			filterCol:'attname',
			typeAhead:false,
			tpl:tpl_nombre_columna,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_nombre_columna,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'nombre_columna',
		save_as:'nombre_columna'
	};		
	Atributos[12]={
			validacion:{
				name:'sw_debe_haber',
				fieldLabel:'SW Debe o Haber',
				allowBlank:false,
				align:'left',
				emptyText:'Debe Haber...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['debe','DEBE'],['haber','HABER']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_debe_haber,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:2,
			save_as:'sw_debe_haber'
		};
		// txt calculo_conta
		Atributos[13]={
			validacion:{
				name:'calculo_conta',
				fieldLabel:'Cálculo Contabilidad',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'calculo_conta',
			save_as:'calculo_conta'
		};	
		// txt calculo_conta
		Atributos[14]={
			validacion:{
				name:'calculo_presto',
				fieldLabel:'Cálculo Presupuesto',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'calculo_presto',
			save_as:'calculo_presto'
		};
	
		 Atributos[15]={
			validacion:{
				name:'id_partida',
				fieldLabel:'Partida',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'',
			save_as:'id_partida'
		};  
	 Atributos[16]={
				validacion:{
					name:'id_cuenta',
					fieldLabel:'Cuenta',
					allowBlank:true,
					align:'right', 
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					allowNegative:false,
					minValue:0,
					grid_visible:false,
					grid_editable:false,
					width_grid:100,
					width:100,
					disabled:false		
				},
				tipo: 'NumberField',
				form: true,
				filtro_0:true,
				id_grupo:0,
				filterColValue:'',
				save_as:'id_cuenta'
			}; 	
			//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Transsación (Maestro)',titulo_detalle:'Documento con Credito Fiscal (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_documento = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_registro_documento.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_registro_documento,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var getCM=this.getColumnModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit =this.btnEdit;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_ocultarGrupo=this.ocultarGrupo;
	
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/ColumnaValor/ActionEliminarColumnaValor.php',parametros:'&id_concepto_factura='+maestro.id_concepto_factura},
	Save:{url:direccion+'../../../control/ColumnaValor/ActionGuardarColumnaValor.php',parametros:'id_concepto_factura='+maestro.id_concepto_factura},
	ConfirmSave:{url:direccion+'../../../ColumnaValor/documento/ActionGuardarColumnaValor.php',parametros:'id_concepto_factura='+maestro.id_concepto_factura},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'registro columna',
	grupos:[
				{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Columna:',columna:0,id_grupo:1},
				{tituloGrupo:'Datos Contabilidad:',columna:0,id_grupo:2}
				]
	}};

		function 	 MaestroJulio(data){
		
		var mayor=0;		
		var j;
		
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		 
		return html
	};		
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
	console.log(params);
	var datos=Ext.urlDecode(decodeURIComponent(params));
	console.log(params);
	maestro.id_concepto_factura=datos.m_id_concepto_factura;
	maestro.nombre_concepto=datos.m_nombre_concepto;
	maestro.id_lugar=datos.m_id_lugar;
	maestro.id_sistema_distribucion=datos.m_id_sistema_distribucion;
	maestro.tipo_concepto=datos.m_tipo_concepto;
	maestro.id_categoria_cliente=datos.m_id_categoria_cliente;
	maestro.nombre_lugar=datos.m_nombre_lugar;
	maestro.nombre_categoria_cliente=datos.m_nombre_categoria_cliente;
	maestro.id_depto_conta=datos.m_id_depto_conta;
	maestro.id_gestion=datos.m_id_gestion;
	

   

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_concepto_factura:maestro.id_concepto_factura			
			}
			
		};
		this.btnActualizar();
			
		var data_maestro=[['Nombre Concepto ',maestro.nombre_concepto,'Tipo Concepto',maestro.tipo_concepto],
					  ['Lugar',maestro.nombre_lugar],
					  ['Categoria',maestro.nombre_categoria_cliente]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		paramFunciones.btnEliminar.parametros='&id_columna_valor='+maestro.id_columna_valor;
		paramFunciones.Save.parametros='&id_concepto_factura='+maestro.id_concepto_factura;
		paramFunciones.ConfirmSave.parametros='&id_concepto_factura='+maestro.id_concepto_factura;
		var_id_concepto_factura.setValue(maestro.var_id_concepto_factura);
		var_id_presupuesto.store.baseParams={sw_reg_columna_valor:'si',m_id_depto:maestro.id_depto_conta,m_id_gestion:maestro.id_gestion};
		var_id_presupuesto.modificado=true;
	

		this.InitFunciones(paramFunciones)
	
	};
	
	
	
	
 

function InitRegistroDocumento()
{		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		
		var_id_concepto_factura=ClaseMadre_getComponente('id_concepto_factura');
		var_id_presupuesto=ClaseMadre_getComponente('id_presupuesto');
		var_id_partida_cuenta=ClaseMadre_getComponente('id_partida_cuenta');
		var_id_partida=ClaseMadre_getComponente('id_partida');
		var_id_cuenta=ClaseMadre_getComponente('id_cuenta');
		var_id_auxiliar=ClaseMadre_getComponente('id_auxiliar');
		
		var_id_presupuesto.on('select',f_filtrar_partida);	
		var_id_partida_cuenta.on('select',f_filtrar_auxiliar);	
};

	function f_filtrar_partida( combo, record, index ){
		var_id_partida_cuenta.setValue('');
		var_id_partida.setValue('');
		var_id_cuenta.setValue('');
		var_id_auxiliar.setValue('');
		var_id_partida_cuenta.setDisabled(false);
		var_id_auxiliar.setDisabled(true);
	 	var_id_partida_cuenta.store.baseParams={sw_reg_columna_valor:'si',m_id_presupuesto:record.data.id_presupuesto };	
		var_id_partida_cuenta.modificado=true;	 
	}
	function f_filtrar_auxiliar( combo, record, index ){
		
			var_id_partida.setValue(record.data.id_partida);
			var_id_cuenta.setValue(record.data.id_cuenta);
			
			var_id_auxiliar.setValue('');
			var_id_auxiliar.setDisabled(false);
			var_id_auxiliar.store.baseParams={sw_reg_columna_valor:'si',m_id_cuenta:record.data.id_cuenta};
			var_id_auxiliar.modificado=true;	
	}
 
	



/********************************************************/

	this.getLayout=function(){return layout_registro_documento.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	InitRegistroDocumento();
	
	CM_ocultarGrupo('Oculto:');
	layout_registro_documento.getLayout().addListener('layout',this.onResize);
	layout_registro_documento.getVentana().addListener('beforehide',function(){ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar()})
	var_id_presupuesto.store.baseParams={sw_reg_columna_valor:'si',m_id_depto:maestro.id_depto_conta,m_id_gestion:maestro.id_gestion};
	var_id_presupuesto.modificado=true;

}