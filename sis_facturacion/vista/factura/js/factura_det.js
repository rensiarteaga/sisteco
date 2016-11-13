function pagina_factura_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{        
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;
	var comp_id_presupuesto, comp_id_ppto_gasto, comp_id_concepto_ingas;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'importe',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0
	}); 
	
	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/factura_det/ActionListarFacturaDet.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_factura_det',totalRecords:'TotalCount'
		},[
		'id_factura_det',
		'id_factura',
		'id_presupuesto',
		'desc_presupuesto',
		'id_ppto_gasto',
		'desc_gasto',
		'id_concepto_ingas',
		'desc_ingas',
		'id_partida',
		'despar',
		'id_cuenta',
		'descta',
		'id_auxiliar',
		'desaux',
		'fac_importe',
		'fac_descuento',
		'fac_obsdesc',
		'usuario_reg',
		'fecha_reg'
		]),remoteSort:true
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},
				['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
				'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
				'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
				'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
				'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
				'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
		//,baseParams:{sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas}
	});
	
	var ds_ppto_gasto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},
				['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
				'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
				'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
				'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
				'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
				'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
		//,baseParams:{sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas}
	});
	
	var ds_concepto_ingas=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',	id:'id_concepto_ingas',	totalRecords:'TotalCount'},
				['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv','id_partida','desc_partida','id_cuenta','desc_cuenta','sw_tesoro'])
	});
	
	//FUNCIONES RENDER
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
		'<br>  <FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br>  <FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');	
	
	function render_id_ppto_gasto(value, p, record){return String.format('{0}', record.data['desc_gasto']);}
	var tpl_id_ppto_gasto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
		'<br>  <FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br>  <FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
	
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['descta']);}
	var tpl_id_cuenta=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>{desc_ingas_item_serv}</b>','<br><FONT COLOR="#B50000"><b>Partida: </b>{desc_partida}</FONT>','<br><FONT COLOR="#B5A642"><b>Tesoro: </b>{sw_tesoro}</FONT>','</div>');  
	
	function renderFormatNumber(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)
	}
	
	///////////////////////
	// Definicion de datos //
	/////////////////////////
	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_factura_det',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_factura',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[2]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Ppto. Recurso',
			allowBlank:true,			
			emptyText:'Presupuesto Recurso ...',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto#presup.id_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};

	Atributos[3]={
		validacion:{
			name:'id_ppto_gasto',
			fieldLabel:'Ppto. Gasto',
			allowBlank:true,			
			emptyText:'Presupuesto Gasto ...',
			desc:'desc_gasto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_ppto_gasto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_ppto_gasto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_ppto_gasto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto#presup.id_presupuesto',
		save_as:'id_ppto_gasto',
		id_grupo:0
	};
	
	Atributos[4]={
		validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto de Venta',
			allowBlank:true,			
			desc: 'desc_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',//valor que agarra o guarda
			displayField: 'desc_ingas_item_serv',//el que muestra
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas_item_serv',
			typeAhead:false,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			maxLength:150,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			minListWidth:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CON.desc_ingas'
	};
	
	Atributos[5]={
		validacion:{
			name:'fac_importe',
			fieldLabel:'Importe',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			width:200,
			grid_visible:true,
			grid_editable:false,
			renderer: renderFormatNumber
		},
		tipo:'NumberField',
		form:true,
		filtro_1:false,
		id_grupo:0
	};

	Atributos[6]={
		validacion:{
			name:'fac_descuento',
			fieldLabel:'Descuento',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			width:200,
			grid_visible:true,
			grid_editable:false,
			renderer: renderFormatNumber
		},
		tipo:'NumberField',
		form:true,
		filtro_1:false,
		id_grupo:0
	};
	
	Atributos[7]={
		validacion:{
			name:'fac_obsdesc',
			fieldLabel:'Obs. Descuento',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false
		},
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'DET.fac_obsdesc',
		id_grupo:0
	};
	
	Atributos[8]={
		validacion:{
			name:'despar',
			fieldLabel:'Partida',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'PAR.codigo_partida',
		id_grupo:0
	};
	
	Atributos[9]={
		validacion:{
			name:'descta',
			fieldLabel:'Cuenta',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'CTA.nombre_cuenta',
		id_grupo:0
	};

	Atributos[10]={
		validacion:{
			name:'desaux',
			fieldLabel:'Auxiliar',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'AUX.codigo_auxiliar',
		id_grupo:0
	};
	
	Atributos[11]={
		validacion:{			
			name:'usuario_reg',
			fieldLabel:'Responsable Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[12]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:110		
		},
		tipo:'Field',
		filtro_0:false,
		form:false
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cuenta',grid_maestro:'grid-'+idContenedor};
	layout_factura_det= new DocsLayoutMaestro(idContenedor);
	layout_factura_det.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_factura_det,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	var cm_btnEdit=this.btnEdit;
	
	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICION DE FUNCIONES
	 var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/factura_det/ActionEliminarFacturaDet.php'},
		Save:{url:direccion+'../../../control/factura_det/ActionGuardarFacturaDet.php'},
		ConfirmSave:{url:direccion+'../../../control/factura_det/ActionGuardarFacturaDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:350,width:510,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Detalle Factura',
			grupos:[{
				tituloGrupo:'Datos a registar',
					columna:0,
					id_grupo:0
			}]}
		};
	
	 function iniciarEventosFormularios() {
		comp_id_presupuesto=getComponente('id_presupuesto');
		comp_id_ppto_gasto=getComponente('id_ppto_gasto');
		comp_id_concepto_ingas=getComponente('id_concepto_ingas');
		
		comp_id_presupuesto.on('select',f_presupuesto);	
	}
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//Ext.MessageBox.alert('Estado', 'llega');
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_factura:maestro.id_factura
			}
		};
		
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_factura;
		
		paramFunciones.btnEliminar.parametros='&m_id_factura='+maestro.id_factura;
		paramFunciones.ConfirmSave.parametros='&m_id_factura='+maestro.id_factura;
		paramFunciones.Save.parametros='&m_id_factura='+maestro.id_factura;
		
		comp_id_presupuesto.store.baseParams={m_id_factura:maestro.id_factura, m_tipo_press:1};
		comp_id_presupuesto.modificado=true;
		
		comp_id_ppto_gasto.store.baseParams={m_id_factura:maestro.id_factura, m_tipo_press:2};
		comp_id_ppto_gasto.modificado=true;
		
		this.InitFunciones(paramFunciones)
	};
	
	this.btnEdit = function(){
		comp_id_concepto_ingas.store.baseParams={sw_tesoro:8, m_id_presupuesto:comp_id_presupuesto.getValue()};
		comp_id_concepto_ingas.modificado=true;
		
		cm_btnEdit();
	}
	
	function f_presupuesto(combo, record, index ){
		comp_id_concepto_ingas.store.baseParams={sw_tesoro:8, m_id_presupuesto:record.data.id_presupuesto};
		comp_id_concepto_ingas.modificado=true;
		
		comp_id_concepto_ingas.setValue('');
	}
	
	ds.lastOptions={
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
	}};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_factura_det.getLayout()};
	
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_factura_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}