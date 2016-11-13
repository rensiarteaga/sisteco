function pagina_ndc_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{        
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;
	var comp_id_factura_det, comp_ndc_importe, comp_desc_ppto;
	
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ndc_fac_det/ActionListarNdcDet.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_factura_det',totalRecords:'TotalCount'
		},[
		'id_ndc_det',
		'id_ndc',
		'id_factura',
		'id_factura_det',
		'desc_presupuesto',
		'desc_gasto',
		'desc_ingas',
		'despar',
		'descta',
		'desaux',
		'ndc_importe',
		'usuario_reg',
		'fecha_reg'
		]),remoteSort:true
	});
	
	var ds_factura_det = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/factura_det/ActionListarFacturaDet.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_factura_det',totalRecords:'TotalCount'},
			['id_factura_det','id_factura','id_presupuesto','desc_presupuesto','id_ppto_gasto','desc_gasto','id_concepto_ingas','desc_ingas','id_partida','despar',
			'id_cuenta','descta','id_auxiliar','desaux','fac_importe','fac_descuento','fac_obsdesc','usuario_reg','fecha_reg'])
		,baseParams:{m_id_factura:-1}
	});
	
	//FUNCIONES RENDER
	function render_id_factura_det(value, p, record){return String.format('{0}', record.data['desc_ingas']);}
	var tpl_id_factura_det=new Ext.Template('<div class="search-item">',
		'<b>{desc_presupuesto}</b>',
		'<br>Concepto de venta: <FONT COLOR="#B50000"><b>{desc_ingas}</b></FONT>',
		'<br>Importe: <FONT COLOR="#B50000"><b>{fac_importe}</b></FONT>',	
		'</div>');	
	
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
			name: 'id_ndc_det',
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
			name: 'id_ndc',
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
	
	Atributos[3]={
		validacion:{
			name:'id_factura_det',
			fieldLabel:'Concepto de Venta',
			allowBlank:true,			
			emptyText:'Concepto de Venta ...',
			desc:'desc_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_factura_det,
			valueField:'id_factura_det',
			displayField:'desc_ingas',
			queryParam:'filterValue_0',
			filterCol:'DET.desc_presupuesto#DET.desc_ingas#DET.id_presupuesto',
			typeAhead:false,
			tpl:tpl_id_factura_det,
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
			renderer:render_id_factura_det,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'DET.desc_presupuesto#DET.id_presupuesto',
		save_as:'id_factura_det',
		id_grupo:0
	};

	Atributos[4]={
		validacion:{
			name:'ndc_importe',
			fieldLabel:'Importe',
			allowBlank:false,
			maxLength:150,
			minLength:1,
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
	
	Atributos[5]={
		validacion:{
			name:'desc_presupuesto',
			fieldLabel:'Ppto. Recurso',
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
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'PRE.desc_presupuesto',
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
			name:'desc_gasto',
			fieldLabel:'Ppto. Gasto',
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
		filterColValue:'PGA.desc_presupuesto',
		id_grupo:0
	};
	
	Atributos[7]={
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
	
	Atributos[8]={
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

	Atributos[9]={
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
	
	Atributos[10]={
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
	
	Atributos[11]={
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
	layout_ndc_det= new DocsLayoutMaestro(idContenedor);
	layout_ndc_det.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_ndc_det,idContenedor);
	
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
		btnEliminar:{url:direccion+'../../../control/ndc_fac_det/ActionEliminarNdcDet.php'},
		Save:{url:direccion+'../../../control/ndc_fac_det/ActionGuardarNdcDet.php'},
		ConfirmSave:{url:direccion+'../../../control/ndc_fac_det/ActionGuardarNdcDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:350,width:510,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Detalle NDC',
			grupos:[{
				tituloGrupo:'Datos a registar',
					columna:0,
					id_grupo:0
			}]}
		};
	
	 function iniciarEventosFormularios() {
		comp_id_factura_det=getComponente('id_factura_det');
		comp_ndc_importe=getComponente('ndc_importe');
		comp_desc_ppto=getComponente('desc_presupuesto');
		
		comp_id_factura_det.on('select',f_factura);	
	}
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_ndc:maestro.id_ndc
			}
		};
		
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_ndc;
		
		paramFunciones.btnEliminar.parametros='&m_id_ndc='+maestro.id_ndc;
		paramFunciones.ConfirmSave.parametros='&m_id_ndc='+maestro.id_ndc;
		paramFunciones.Save.parametros='&m_id_ndc='+maestro.id_ndc;
		
		comp_id_factura_det.store.baseParams={m_id_factura:maestro.id_factura};
		comp_id_factura_det.modificado=true;
		
		this.InitFunciones(paramFunciones)
	};
	
	/*this.btnEdit = function(){
		comp_id_concepto_ingas.store.baseParams={sw_tesoro:8, m_id_presupuesto:comp_id_presupuesto.getValue()};
		comp_id_concepto_ingas.modificado=true;
		
		cm_btnEdit();
	}*/
	
	function f_factura(combo, record, index ){
		comp_ndc_importe.setValue(record.data.fac_importe);
		comp_desc_ppto.setValue(record.data.desc_presupuesto);
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
	layout_ndc_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}