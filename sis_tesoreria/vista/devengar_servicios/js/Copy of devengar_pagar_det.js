/**
 * Nombre: pagina_devengado_detalle.js
 * Propósito: pagina objeto principal
 * Autor: Generado Automaticamente 
 * Fecha creación: 2008-10-21 15:43:29
 */
function pagina_devengar_pagar_det(idContenedor,direccion,paramConfig,idContenedorPadre,idUsuario){
	var tipoFormDev='detpag';
	var Atributos=new Array,sw=0;
	var v_saldo_dev,v_importe_pagado;
	var g_sw_contabilizar;
	var v_ult_fila_selec=-1;
	var v_dcto_solo_lectura=0; // variable que define si abre los documentos
	var maestro=new Array;
	var componentes=new Array;
	var cmbTipoPlantilla, cmbCueBan;
	
	// como sólo lectura
	// 1: sólo lectura
	// 0: no de sólo lectura

	// ///////////////
	// DATA STORE //
	// ///////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado/ActionListarDevengarServicios.php?tipoFormDev='+tipoFormDev}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id: 'id_devengado',totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_devengado',
		'id_concepto_ingas',
		'id_moneda',
		'importe_devengado',
		'importe_pagado',
		'importe_saldo',
		'estado_devengado',
		'fk_devengado',
		'id_proveedor',
		'id_cheque',
		'id_comprobante',
		'tipo_devengado',
		{name: 'fecha_devengado',type:'date',dateFormat:'Y-m-d'},
		'desc_concepto_ingas',
		'desc_moneda',
		'desc_proveedor',
		'desc_tipo_devengado',
		'desc_estado_devengado',
		'nombre_pago',
		'nro_cheque',
		'fecha_cheque',
		'nombre_cheque',
		'estado_cheque',
		'desc_estado_cheque',
		'importe_multa',
		'id_plan_pago',
		'nivel_documento',
		'banco',
		'nit',
		'sw_contabilizar',
		'observaciones',
		'tipo_gen_pago',
		'desc_tipo_gen_pago',
		'id_cotizacion',
		'obs_contabilidad',
		'tipo_desembolso',
		'id_moneda_cueban',
		'tipo_plantilla',
		'liquido_pagable',
		'sw_pago_comprometido',
		'sw_solo_devengado',
		'id_comprobante_reg',
		'importe_otros_con'
		]),remoteSort:true
	});


	// DEFINICIÓN DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	// DATA STORE COMBOS
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro'])
	});
	
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro'])
		});
	
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco'])
    });

	// FUNCIONES RENDER
	function render_tipo_devengado(value, p, record){
		if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){
			return String.format('{0}', '<span style="color:red">'+record.data['desc_tipo_devengado']+'</span>');
		}else{
			return String.format('{0}', record.data['desc_tipo_devengado']);
			}
		}
	function render_estado_devengado(value, p, record){if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['desc_estado_devengado']+'</span>');}else{return String.format('{0}', record.data['desc_estado_devengado']);}}
	function render_estado_cheque(value, p, record){return String.format('{0}', record.data['desc_estado_cheque']);}
	function render_tipo_plantilla(value,p,record){return String.format('{0}',record.data['desc_tipo_plantilla']);};
	function render_sw_solo_devengado(value,p,record){
		var aux;
		if(record.data['id_cotizacion']!=''){
			if(value=='si'){
				aux='Sólo devengar';
			} else{
				aux='Devengar y Pagar';
			}	
		} else{
			aux='';
		}
		return aux;
	};
	
	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');

	// ///////////////////////
	// Definición de datos //
	// ///////////////////////

	// hidden id_devengado
	// en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado'
	};

	// txt importe_devengado
	Atributos[1]={
		validacion:{
			name:'importe_pagado',
			fieldLabel:'Importe Válido C.F.',
			allowBlank:false,
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
			// renderer:render_importe_pagado,
			width_grid:120,
			width:'50%',
			disabled:false,
			grid_indice:3,
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_pagado',
		save_as:'importe_pagado',
		id_grupo:0
	};


	// txt tipo_devengado
	Atributos[2]={
		validacion:{
			name:'tipo_devengado',
			fieldLabel:'Tipo Devengado',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			renderer:render_tipo_devengado,
			disabled:false,
			grid_indice:6
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'tipo_devengado',
		save_as:'tipo_devengado',
					id_grupo:0
	};

	// txt estado_devengado
	Atributos[3]={
		validacion:{
			name:'estado_devengado',
			fieldLabel:'Estado Devengado',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:'50%',
			disabled:false,
			grid_indice:4,
			renderer:render_estado_devengado
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'estado_devengado',
		save_as:'estado_devengado',
					id_grupo:0
	};

	// txt nombr pago
	Atributos[4]={
		validacion:{
			name:'nombre_pago',
			fieldLabel:'Nombre Cheque',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:7
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'nombre_cheque',
		form:false,
		save_as:'tipo_devengado',
					id_grupo:0
	};

	Atributos[5]={
		validacion:{
			name:'saldo_dev',
			fieldLabel:'Saldo',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo: 'Field',
		save_as:'saldo_dev',
					id_grupo:0
	};

	Atributos[6]={
		validacion:{
			labelSeparator:'',
			name: 'fk_devengado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'fk_devengado',
		defecto:maestro.id_devengado,
					id_grupo:0
	};

	// txt nro_cheque
	Atributos[7]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'Nro. Cheque',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:13
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'nro_cheque',
		save_as:'nro_cheque',
					id_grupo:0
	};

	// txt fecha_cheque
	Atributos[8]={
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'Fecha Cheque',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:12
		},
		tipo: 'Field',
		form: false,
		filtro_0:false,
		filterColValue:'fecha_cheque',
		save_as:'fecha_cheque',
					id_grupo:0
	};


	// txt estado_cheque
	Atributos[9]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Estado Cheque',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:8,
			renderer:render_estado_cheque
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'estado_cheque',
		save_as:'estado_cheque',
					id_grupo:0
	};

	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name: 'id_plan_pago',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_plan_pago',
					id_grupo:0
	};

	// txt tipo_documento
	Atributos[11]={
		validacion:{
			name:'nivel_documento',
			fieldLabel:'Documento Registrado',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			grid_indice:10
		},
		tipo: 'Field',
		form: false,
		save_as:'nivel_documento',
					id_grupo:0
	};

	// txt nombr pago
	Atributos[12]={
		validacion:{
			name:'banco',
			fieldLabel:'Banco',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:11
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'banco',
		save_as:'banco',
					id_grupo:0
	};

	Atributos[13]={
		validacion:{
			name:'nit',
			fieldLabel:'NIT',
			grid_visible:false,
			grid_editable:false,
		},
		tipo: 'Field',
		form: false,
		save_as:'nit',
					id_grupo:0
	};

	Atributos[14]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'Contabilizar',
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
			width:150,
			disabled:false
		},
		tipo: 'NumberField',
		form: true,
		save_as:'sw_contabilizar',
					id_grupo:0
	};

	// observaciones
	Atributos[15]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			grid_indice:8
		},
		tipo: 'Field',
		form: false,
		save_as:'observaciones',
					id_grupo:0
	};

	Atributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_comprobante',
					id_grupo:0
	};

	// observaciones
	Atributos[17]={
		validacion:{
			name:'desc_estado_devengado',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			grid_indice:8
		},
		tipo: 'Field',
		form: false,
		save_as:'desc_estado_devengado',
					id_grupo:0
	};

	Atributos[18]={
		validacion:{
			name:'tipo_gen_pago',
			fieldLabel:'Regularizar',
			grid_visible:false,
			grid_editable:false,
			width_grid:180,
			grid_indice:8
		},
		tipo: 'Field',
		form: false,
		save_as:'tipo_gen_pago',
					id_grupo:0
	};

	Atributos[19]={
		validacion:{
			name:'desc_tipo_gen_pago',
			fieldLabel:'Regularizar',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:8
		},
		tipo: 'Field',
		form: false,
		save_as:'desc_tipo_gen_pago',
					id_grupo:0
	};

	Atributos[20]= {
		validacion:{
			name:'fecha_devengado',
			fieldLabel:'Fecha',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			allowBlank:false,
			grid_indice:1
		},
		tipo:'DateField',
		form:true,
		filtro_0:true,
		filterColValue:'fecha_devengado',
		dateFormat:'m-d-Y',
		id_grupo:0
	};

	Atributos[21]={
		validacion:{
			fieldLabel:'Observaciones Contabilidad',
			name: 'obs_contabilidad',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		save_as:'obs_contabilidad',
					id_grupo:0
	};
	Atributos[22]={
		validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Tipo Documento.',
			allowBlank:true,
			//emptyText:'Tipo Documento...',
			store:ds_plantilla,
			valueField:'tipo_plantilla',
			displayField:'desc_plantilla',
			queryParam:'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			filterCols:filterCols,
			filterValues:filterValues,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200
		},
		tipo:'ComboBox',
		save_as:'tipo_plantilla',
		id_grupo:1
	};

	Atributos[23]={
		validacion:{
			name:'tipo_documento_regularizar',
			fieldLabel:'Tipo Documento..',
			allowBlank:true,
			//emptyText:'Tipo Documento...',
			store:ds_plantilla,
			valueField:'tipo_plantilla',
			displayField:'desc_plantilla',
			queryParam:'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			filterCols:filterCols,
			filterValues:filterValues,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200
		},
		tipo:'ComboBox',
		save_as:'tipo_documento_regularizar',
		id_grupo:2
	};
	
	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='PLANT.sw_tesoro';
	filterValues[0]='1';
	Atributos[24]={
		validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Tipo Documento...',
			allowBlank:true,
			emptyText:'Tipo Documento...',
			store:ds_plantilla,
			desc:'desc_tipo_plantilla',
			valueField:'tipo_plantilla',
			displayField:'desc_plantilla',
			queryParam:'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			filterCols:filterCols,
			filterValues:filterValues,
			grid_visible:true,
			grid_editable:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200,
			renderer:render_tipo_plantilla
		},
		tipo:'ComboBox',
		id_grupo:3
	};
	
	Atributos[25]={
			validacion:{
				name:'id_cuenta_bancaria',
				fieldLabel:'Cuenta Bancaria',
				allowBlank:true,
				emptyText:'Cuenta...',
				store:ds_cuenta_bancaria,
				valueField:'id_cuenta_bancaria',
				displayField:'nro_cuenta_banco',
				queryParam:'filterValue_0',
				filterCol:'CUEBAN.id_cuenta_bancaria',
				typeAhead:false,
				tpl:tpl_cuenta_bancaria,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				width:200
			},
			tipo:'ComboBox',
			id_grupo:3
		};
	
	Atributos[26]={
			validacion:{
				name:'liquido_pagable',
				fieldLabel:'Liquido Pagable',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				grid_indice:5,
				align:'right',
			},
			tipo: 'Field',
			form:false,
			id_grupo:0
		};
	
	// observaciones
	Atributos[27]={
		validacion:{
			name:'sw_solo_devengado',
			fieldLabel:'Adquisiciones',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:2,
			renderer:render_sw_solo_devengado
		},
		tipo: 'Field',
		form: false,
		id_grupo:0
	};
	
	Atributos[28]={
			validacion:{
				name: 'importe_otros_con',
				fieldLabel:'Importe No Válido C.F.',
				align:'right',
				grid_visible:true,
				grid_indice:4,
				width_grid:130
			},
			tipo: 'Field',
			filtro_0:false,
			form: false
		};


	// ----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	// ---------- INICIAMOS LAYOUT DETALLE
	var layout_devengar_servicios = new DocsLayoutMaestro(idContenedor);
	layout_devengar_servicios.init({titulo_maestro:'Registro de Pagos',titulo_detalle:'Pagos',grid_maestro:'grid-'+idContenedor});


	// ---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_devengar_servicios,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_btnActualizar = this.btnActualizar;
	var CM_conexionFailure=this.conexionFailure;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_deselectRow=this.DeselectRow;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarFormulario = this.mostrarFormulario;
	var CM_ocultarFormulario = this.ocultarFormulario;
	var CM_getFormulario=this.getFormulario;


	// DEFINICIÓN DE LA BARRA DE MENÚ

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	// DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado/ActionEliminarPago.php'},
		Save:{url:direccion+'../../../control/devengado/ActionGenerarPago.php'},
		ConfirmSave:{url:direccion+'../../../control/devengado/ActionGenerarPago.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:270,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Devengar Servicios',
		grupos:[{	
					tituloGrupo:'Datos',
					columna:0,
					id_grupo:0
				},
				{	
					tituloGrupo:'Documento',
					columna:0,
					id_grupo:1
				},
				{	
					tituloGrupo:'Regularizar',
					columna:0,
					id_grupo:2
				},
				{	
					tituloGrupo:'Tipo Documento',
					columna:0,
					id_grupo:3
				}]
		}
	};
	
	// Para manejo de eventos
	function iniciarEventosFormularios(){
		//Captura todos los componentes
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		v_saldo_dev = getComponente('saldo_dev');
		v_importe_pagado = getComponente('importe_pagado');
		cmbTipoPlantilla=getComponente('tipo_plantilla');
		cmbCueBan=getComponente('id_cuenta_bancaria');

		if(v_saldo_dev){
			v_saldo_dev.getEl().setStyle('text-align','right');
		}
		if(v_importe_pagado){
			v_importe_pagado.getEl().setStyle('text-align','right');
		}

		g_sw_contabilizar= ClaseMadre_getComponente('sw_contabilizar');
		g_sw_contabilizar.setVisible(false);

		// Oculta el campo contabilizar
		CM_ocultarComp(g_sw_contabilizar);
		
		//Oculta el grupo del tipo de documento
		CM_ocultarGrupo('Tipo Documento');
	}

	// -------------- Sobrecarga de funciones --------------------//

	this.reload=function(params){
		var datos=params;

		maestro.id_devengado=datos.id_devengado;
		maestro.importe_devengado=datos.importe_devengado;
		maestro.importe_pagado=datos.importe_pagado;
		maestro.importe_saldo=datos.importe_saldo;
		maestro.estado_devengado=datos.estado_devengado;
		maestro.tipoFormDev=datos.tipoFormDev;
		maestro.id_moneda=datos.id_moneda;
		maestro.tipo_desembolso=datos.tipo_desembolso;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_devengado:maestro.id_devengado
			}
		};
		this.btnActualizar();
		Atributos[6].defecto=maestro.id_devengado;// el fk_devengado
		
		iniciarEventosFormularios();

		paramFunciones.btnEliminar.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.Save.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.ConfirmSave.parametros='&m_id_devengado='+maestro.id_devengado;

		// Se verifica que botones se deben cargar
		if(maestro.tipoFormDev=='fin'||maestro.tipoFormDev=='desc'){
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('guardar-'+idContenedor).hide();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
			CM_getBoton('actualizar-'+idContenedor).show();
			// Ocultar botones
			CM_getBoton('btn_cont_pago-'+idContenedor).hide();
			// CM_getBoton('btn_cheque_descargo-'+idContenedor).hide();
			CM_getBoton('btn_cheque-'+idContenedor).hide();
		}
		else{
			// Visualiza los botones
			CM_getBoton('nuevo-'+idContenedor).show();
			CM_getBoton('guardar-'+idContenedor).show();
			CM_getBoton('editar-'+idContenedor).show();
			CM_getBoton('eliminar-'+idContenedor).show();
			CM_getBoton('actualizar-'+idContenedor).show();
			CM_getBoton('btn_cont_pago-'+idContenedor).show();
			// CM_getBoton('btn_cheque_descargo-'+idContenedor).show();
			CM_getBoton('btn_cheque-'+idContenedor).hide();
			// Deshabilita los botones
			CM_getBoton('btn_cont_pago-'+idContenedor).disable();
			// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
			CM_getBoton('btn_cheque-'+idContenedor).hide();
		}

		// Verifica el título del botón de Desembolso
		if(maestro.tipo_desembolso==2){
			//Caja
			CM_getBoton('btn_cont_pago-'+idContenedor).setText('Desembolsar por Caja');
		} else if(maestro.tipo_desembolso==1){
			//Cheque
			CM_getBoton('btn_cont_pago-'+idContenedor).setText('Enviar a Contabilidad');
		} else if(maestro.tipo_desembolso==3){
			//Transferencia Bancaria
			CM_getBoton('btn_cont_pago-'+idContenedor).setText('Desembolsar por Transferencia');
		}
		// Deshabilita en cualquier caso el botón de Documentos
		CM_getBoton('btn_docs-'+idContenedor).hide();

		this.InitFunciones(paramFunciones);
	};

	// Evento sobrecargado del EnableSelect
	this.EnableSelect=function(x,z,y){
		v_ult_fila_selec=z;
		enable(x,z,y);
	}

	// Evento al Seleccionar una fila
	function enable(sel,row,selected){
		// Habilita o deshabilita los botones dependiendo del tipo de la vista
		var record=selected.data;
		if(selected&&record!=-1){
			/*try{
				console.log(record);
			} catch(e){
			}*/
			
			if(record.tipo_plantilla!=3){
				// Validado
				CM_getBoton('btn_tipo_documento-'+idContenedor).disable();
			} else{
				CM_getBoton('btn_tipo_documento-'+idContenedor).enable();
			}	
			if(record.estado_devengado==14){
					// Validado
					CM_getBoton('btn_regularizar-'+idContenedor).enable();
			} else{
				CM_getBoton('btn_regularizar-'+idContenedor).disable();
			}
			
			if(maestro.tipoFormDev=='fin'){
				CM_getBoton('btn_docs-'+idContenedor).hide();
				v_dcto_solo_lectura=1;
			}
			else{
				if(record.estado_devengado==9){ 
					// Registrado
					//RCM 08/01/2010: Verificacion de SOLO devengados para habilitar el boton de Enviar a contabilidad
					if(record.sw_solo_devengado=='si'){
						CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					} else{
						CM_getBoton('btn_cont_pago-'+idContenedor).enable();
					}
					// CM_getBoton('btn_cheque_descargo-'+idContenedor).enable();
					CM_getBoton('btn_cheque-'+idContenedor).hide();
					CM_getBoton('btn_docs-'+idContenedor).hide();
					v_dcto_solo_lectura=0;
				}
				else if(record.estado_devengado==10||record.estado_devengado==13){
					// En contabilidad
					CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
					CM_getBoton('btn_cheque-'+idContenedor).hide();
					CM_getBoton('btn_docs-'+idContenedor).hide();
					v_dcto_solo_lectura=1;
				}
				else if(record.estado_devengado==11){
					// Validado
					CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
					CM_getBoton('btn_cheque-'+idContenedor).hide();
					CM_getBoton('btn_docs-'+idContenedor).hide();
					v_dcto_solo_lectura=1;
				}
				else if(record.estado_devengado==12){//&&record.tipo_gen_pago==2){
					// Validado
					
					//RCM: linea cambiada
					//CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					if(record.id_comprobante!=''&& record.tipo_plantilla==16){
						CM_getBoton('btn_cont_pago-'+idContenedor).enable();
					} else{
						CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					}
					//FIN LINEA CAMBIADA
					
					// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
					CM_getBoton('btn_cheque-'+idContenedor).hide();
					CM_getBoton('btn_docs-'+idContenedor).hide();
					v_dcto_solo_lectura=1;
				}
				else{
					CM_getBoton('btn_cont_pago-'+idContenedor).disable();
					// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
					CM_getBoton('btn_cheque-'+idContenedor).hide();
					CM_getBoton('btn_docs-'+idContenedor).hide();
					v_dcto_solo_lectura=1;
				}
			}
			
		}
		//RCM aumentado
		//CM_getBoton('btn_cont_pago-'+idContenedor).enable();
		CM_enableSelect(sel,row,selected);
	}

	// Evento sobrecargado al deseleccionar una fila
	this.DeselectRow=function(x,z){
		if(maestro.tipoFormDev=='fin'||maestro.tipoFormDev=='desc'){
			CM_getBoton('btn_docs-'+idContenedor).hide();
		}
		else{
			CM_getBoton('btn_cont_pago-'+idContenedor).disable();
			// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
			CM_getBoton('btn_cheque-'+idContenedor).hide();
		}
		CM_getBoton('btn_docs-'+idContenedor).hide();
	}

	
	
	
	
	
	
	function RegistrarTipoDocumento(tipo){
		//Cambiar action para guardar el tipo de documento
		CM_getFormulario().url=direccion+'../../../control/devengado/ActionContabilizarPago.php';
		//dev_prof, dev_doc, pago
		if(tipo=='pago'){
			//alert(tipo);
			CM_mostrarGrupo('Tipo Documento');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Documento');
			CM_ocultarGrupo('Regularizar');
			//Oculta cuenta bancaria
			CM_mostrarComp(cmbTipoPlantilla);
			CM_ocultarComp(cmbCueBan);
		} else if(tipo=='dev_prof'){
			//alert(tipo);
			CM_mostrarGrupo('Tipo Documento');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Documento');
			CM_ocultarGrupo('Regularizar');
			//Oculta cuenta bancaria
			CM_mostrarComp(cmbTipoPlantilla);
			CM_mostrarComp(cmbCueBan);
			
		}else if(tipo=='dev_doc'){
			//alert(tipo);
			CM_mostrarGrupo('Tipo Documento');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Documento');
			CM_ocultarGrupo('Regularizar');
			//Oculta cuenta bancaria
			CM_ocultarComp(cmbTipoPlantilla);
			CM_mostrarComp(cmbCueBan);
		} else if(tipo=='prof_reg'){
			//alert(tipo);
			CM_mostrarGrupo('Tipo Documento');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Documento');
			CM_ocultarGrupo('Regularizar');
			//Oculta cuenta bancaria
			CM_mostrarComp(cmbTipoPlantilla);
			CM_ocultarComp(cmbCueBan);
		}
		//Desplegar formulario
		CM_btnEdit();
		
		/*BlancosGrupo(0,0);
		BlancosGrupo(1,0);
		BlancosGrupo(2,0);
		BlancosGrupo(3,1);*/
		
		
		
		
		
	}
	
	function RegistrarDatos(){
		//Restituye los valores originales para almacenar los datos
		CM_getFormulario().url=direccion+'../../../control/devengado/ActionGenerarPago.php?';
		//Despliega los grupos correspondientes
		CM_ocultarGrupo('Tipo Documento');
		CM_mostrarGrupo('Datos');
		CM_ocultarGrupo('Documento');
		CM_ocultarGrupo('Regularizar');
		/*BlancosGrupo(0,1);
		BlancosGrupo(1,0);
		BlancosGrupo(2,0);
		BlancosGrupo(3,1);*/
	}


	function f_imprimir_cheque(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.id_cheque!=''){
				var id_devengado=sm.getSelected().data.id_devengado;
				Ext.Ajax.request({
					url:direccion+'../../../../sis_tesoreria/control/devengado/ActionFinalizarPago.php?id_devengado='+id_devengado,
					method:'POST',
					success:f_exito_impresion_cheque,
					failure:CM_conexionFailure,
					timeout:100000
				})
			}
			else{
				Ext.MessageBox.alert('Información','Cheque no generado');
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un Pago')
		}
	}
	
	function f_exito_impresion_cheque(resp){
		// Impresión del cheque
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		var data='m_id_moneda='+maestro.id_moneda+'&m_id_cheque='+SelectionsRecord.data.id_cheque+'&id_avance='+SelectionsRecord.data.id_devengado;
		var data='m_id_moneda='+SelectionsRecord.data.id_moneda_cueban+'&m_id_cheque='+SelectionsRecord.data.id_cheque+'&id_avance='+SelectionsRecord.data.id_devengado;
		// alert('Impresión del cheque: '+data);
		window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data)
		CM_btnActualizar();
	}



	function cont_pago(resp){
		var root = resp.responseXML.documentElement;
		var v_error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		// alert('tot: '+v_tot);
		if(v_error==0){
			// Impresión del cheque
			var sm=getSelectionModel();
			var SelectionsRecord=sm.getSelected();
			var data='m_id_moneda='+maestro.id_moneda+'&m_id_cheque='+SelectionsRecord.data.id_cheque+'&id_avance='+SelectionsRecord.data.id_devengado;
			// alert('Impresión del cheque: '+data);
			window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data)
			CM_btnActualizar();
		}
		else {
			Ext.MessageBox.alert('Información', 'No se pudo imprimir el Cheque, comuníquese con personal de Sistemas.');
		}
	}

	function exito_cont(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}
		else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			// Actualiza los datos
			CM_btnActualizar()
		}
	}

	
	
	function f_contabilizar() {
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		if(sm.getCount()!=0) {
			var id_devengado=SelectionsRecord.data.id_devengado;
			// Verificamos el tipo de desembolso: por caja o por cheque
			Ext.Ajax.request({
				url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarDevengadoPadrePago.php',
				params:{id_devengado:id_devengado},
				method:'POST',
				success: function(resp){
					var root = resp.responseXML.documentElement;
					var v_tipo_pago = root.getElementsByTagName('tipo_pago')[0].firstChild.nodeValue;
					var v_tipo_doc = root.getElementsByTagName('tipo_doc')[0].firstChild.nodeValue;
					
					if(v_tipo_pago=='pago'){
						//Desplegar formulario para registrar el tipo de documento
						RegistrarTipoDocumento('pago');
						//Llamar a función para Generación del comprobante
						//alert('PAGO: Registro del tipo de documento y Generación del comprobante');
					} else if(v_tipo_pago=='devengado'){
						//Verifica si el tipo de devengado
						if(v_tipo_doc=='proforma'){
							//Desplegar formulario para registrar el tipo de documento
							RegistrarTipoDocumento('dev_prof');
							//Llamar a función para Generación del comprobante
							//alert('DEVENGADO: Registro del tipo de documento y Generación del comprobante');
						} else if(v_tipo_doc=='proforma_reg'){
							//Desplegar formulario para registrar el tipo de documento para regularización de la proforma
							RegistrarTipoDocumento('prof_reg');
						}
						else{
							RegistrarTipoDocumento('dev_doc');
							//Llamar a función para Generación del comprobante
							//alert('Generación directamente del comprobante');
						}
					} else if(v_tipo_pago=='adquisiciones'){
						RegistrarTipoDocumento('dev_doc');
					}
					
				},
				failure:CM_conexionFailure,
				timeout:100000
			})
			return;
			
			
			
			if(SelectionsRecord.data.tipo_desembolso==1) {
				// Cheque o Transferencia Bancaria
				var id_devengado=SelectionsRecord.data.id_devengado;
				// RCM: 02/07/2009
				if(SelectionsRecord.data.tipo_devengado!=3){ // Cualquier tipo de pago menos Pago Adelantado
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarExistenciaDocumento.php?id_devengado='+id_devengado,
						method:'GET',
						success:exito_contabilizar,
						failure:CM_conexionFailure,
						timeout:100000
					})
				} else{ // Pago adelantado
					aux=SelectionsRecord.data.id_plan_pago!='' ? SelectionsRecord.data.id_plan_pago : 'NULL';
					var v_act_est="SELECT tesoro.f_ts_cheque_actualiz_dev("+SelectionsRecord.data.id_devengado+","+aux+","+idUsuario+",1)";
					var data='m_nombre_tabla=tesoro.tts_devengado';
					var importe=SelectionsRecord.data.importe_pagado - SelectionsRecord.data.importe_multa;
					// alert('pagado: '+SelectionsRecord.data.importe_pagado+
					// 'multa:'+SelectionsRecord.data.importe_multa);

					data=data+'&m_nombre_campo=id_devengado';
					data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
					data=data+'&m_nombre_cheque='+SelectionsRecord.data.nombre_pago;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_importe_cheque='+importe;
					data=data+'&m_sw_cuenta_bancaria=true';
					data=data+'&m_sw_nombre_cheque=true';
					data=data+'&m_sw_moneda=false';
					data=data+'&m_sw_importe_cheque=false';
					data=data+'&m_cambio_estado='+v_act_est;
					data=data+'&m_vista=2';
					var ParamVentana={Ventana:{width:370,height:255}};
					layout_devengar_servicios.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
				}
			} else if(SelectionsRecord.data.tipo_desembolso==2){ // Cajas
				if(SelectionsRecord.data.tipo_devengado!=3){ // Cualquier tipo de pago menos Pago Adelantado
					var id_devengado=SelectionsRecord.data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarExistenciaDocumento.php?id_devengado='+id_devengado,
						method:'POST',
						success:function f_gen_vale_caja(resp){
									var root = resp.responseXML.documentElement;
									var v_existe_doc = root.getElementsByTagName('existe')[0].firstChild.nodeValue;
									if(v_existe_doc == 1){
										Ext.Ajax.request({
											url:direccion+'../../../../sis_tesoreria/control/devengado/ActionGenerarValeCaja.php?id_devengado='+id_devengado,
											method:'POST',
											success:function f_exito_vale_caja(resp){
													    Ext.MessageBox.alert('Proceso concluido','Vale de Caja Generado')
													    //Imprime el Vale de Caja
													    var root = resp.responseXML.documentElement;
													    var v_id_caja_regis = root.getElementsByTagName('id_caja_regis')[0].firstChild.nodeValue;
													    var data='id_caja_regis='+v_id_caja_regis;
													    //alert('id_caja_regis:'+data);
													    window.open(direccion+'../../../../sis_tesoreria/control/caja_regis/Reportes/ActionReporteValeCaja.php?'+data);
											},
											failure:CM_conexionFailure,
											timeout:100000 });
									} else{
										if(v_existe_doc == 0){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: previamente debe registrar el/los Documento(s) de respaldo');
										}else if(v_existe_doc == 2){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: debe completar los datos del(os) Documento(s)');
										}else if(v_existe_doc == 3){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: El total de los documentos registrados no cubre con el pago');
										}else if(v_existe_doc == 4){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: El total de los documentos registrados supera al total del pago');
										}else if(v_existe_doc == 5){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: debe completar los datos del(os) Documento(s); el total de los documentos no cubre el con el pago');
										}else if(v_existe_doc == 6){
											Ext.MessageBox.alert('Estado', 'No es posible Generar Vale de Caja: debe completar los datos del(os) Documento(s); el total de los documentos excede el total del pago');
										}
									}
							
							},
						failure:CM_conexionFailure,
						timeout:100000
					})
				
			} else if(SelectionsRecord.data.tipo_desembolso==3) {
				//Transferencia Bancaria
				var id_devengado=SelectionsRecord.data.id_devengado;
				// RCM: 02/07/2009
				if(SelectionsRecord.data.tipo_devengado!=3){ //Cualquier tipo de pago menos Pago Adelantado
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarExistenciaDocumento.php?id_devengado='+id_devengado,
						method:'GET',
						success:exito_contabilizar,
						failure:CM_conexionFailure,
						timeout:100000
					})
				} else{ // Pago adelantado
					aux=SelectionsRecord.data.id_plan_pago!='' ? SelectionsRecord.data.id_plan_pago : 'NULL';
					var v_act_est="SELECT tesoro.f_ts_cheque_actualiz_dev("+SelectionsRecord.data.id_devengado+","+aux+","+maestro.id_usuario+",1)";
					var data='m_nombre_tabla=tesoro.tts_devengado';
					var importe=SelectionsRecord.data.importe_pagado - SelectionsRecord.data.importe_multa;
					// alert('pagado: '+SelectionsRecord.data.importe_pagado+
					// 'multa:'+SelectionsRecord.data.importe_multa);

					data=data+'&m_nombre_campo=id_devengado';
					data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
					data=data+'&m_nombre_cheque='+SelectionsRecord.data.nombre_pago;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_importe_cheque='+importe;
					data=data+'&m_sw_cuenta_bancaria=true';
					data=data+'&m_sw_nombre_cheque=true';
					data=data+'&m_sw_moneda=false';
					data=data+'&m_sw_importe_cheque=false';
					data=data+'&m_cambio_estado='+v_act_est;
					data=data+'&m_vista=2';
					var ParamVentana={Ventana:{width:370,height:255}};
					layout_devengar_servicios.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
				}
		} else{
			Ext.MessageBox.alert('Estado','Tipo de Desembolso no definido');
		}
		
	}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un Pago')
		}
	}
	}

	function exito_contabilizar(resp){
		var root = resp.responseXML.documentElement;
		var v_existe_doc = root.getElementsByTagName('existe')[0].firstChild.nodeValue;
		// alert('tot: '+v_tot);
		if(v_existe_doc == 1){
			// Permite generar el cheque
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				if(SelectionsRecord.data.id_comprobante!=''){
					Ext.MessageBox.alert('Información','Pago ya contabilizado')
				}
				else{
					if(SelectionsRecord.data.fk_devengado!=''){
						// var v_act_est="SELECT
						// tesoro.f_ts_definir_estados_dev("+SelectionsRecord.data.fk_devengado+",TS_DEVPAG_INS,NULL)";
						aux=SelectionsRecord.data.id_plan_pago!='' ? SelectionsRecord.data.id_plan_pago : 'NULL';
						var v_act_est="SELECT tesoro.f_ts_cheque_actualiz_dev("+SelectionsRecord.data.id_devengado+","+aux+","+idUsuario+",1)";
						var data='m_nombre_tabla=tesoro.tts_devengado';
						var importe=SelectionsRecord.data.importe_pagado - SelectionsRecord.data.importe_multa;
						// alert('pagado:
						// '+SelectionsRecord.data.importe_pagado+
						// 'multa:'+SelectionsRecord.data.importe_multa);

						data=data+'&m_nombre_campo=id_devengado';
						data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
						data=data+'&m_nombre_cheque='+SelectionsRecord.data.nombre_pago;
						data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
						data=data+'&m_importe_cheque='+importe;
						data=data+'&m_sw_cuenta_bancaria=true';
						data=data+'&m_sw_nombre_cheque=true';
						data=data+'&m_sw_moneda=false';
						data=data+'&m_sw_importe_cheque=false';
						data=data+'&m_cambio_estado='+v_act_est;
						data=data+'&m_vista=2';
						var ParamVentana={Ventana:{width:370,height:255}};
						layout_devengar_servicios.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
					}
					else{
						Ext.MessageBox.alert('Estado','El Devengado Padre no existe')
					}
				}
			}
			else{
				Ext.MessageBox.alert('Estado','Debe seleccionar un Pago')
			}
		}
		else {
			if(v_existe_doc == 0){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: previamente debe registrar el/los Documento(s) de respaldo');
			}else if(v_existe_doc == 2){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: debe completar los datos del(os) Documento(s)');
			}else if(v_existe_doc == 3){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: El total de los documentos registrados no cubre con el pago');
			}else if(v_existe_doc == 4){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: El total de los documentos registrados supera al total del pago');
			}else if(v_existe_doc == 5){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: debe completar los datos del(os) Documento(s); el total de los documentos no cubre el con el pago');
			}else if(v_existe_doc == 6){
				Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: debe completar los datos del(os) Documento(s); el total de los documentos excede el total del pago');
			}
		}
	}

	/*
	 * function f_cheque_descargo(){ var sm=getSelectionModel(); var
	 * NumSelect=sm.getCount(); if(NumSelect!=0){ alert('Esta opción está
	 * habilitada para generar Cheques para los pagos de los que no se cuenta
	 * con Facturas/Recibos de respaldo al momento de generar el cheque. Sin
	 * embargo, una vez se adquieran las facturas/recibos es necesario
	 * registrarlas por el total del pago realizado.'); if(confirm('¿Está seguro
	 * de continuar?')){ var SelectionsRecord=sm.getSelected();
	 * if(SelectionsRecord.data.id_comprobante!=''){
	 * Ext.MessageBox.alert('Información','Pago ya contabilizado') } else{
	 * if(SelectionsRecord.data.fk_devengado!=''){ //var v_act_est="SELECT
	 * tesoro.f_ts_definir_estados_dev("+SelectionsRecord.data.fk_devengado+",TS_DEVPAG_INS,NULL)";
	 * aux=SelectionsRecord.data.id_plan_pago!='' ?
	 * SelectionsRecord.data.id_plan_pago : 'NULL'; var v_act_est="SELECT
	 * tesoro.f_ts_cheque_actualiz_dev("+SelectionsRecord.data.id_devengado+","+aux+","+maestro.id_usuario+",0)";
	 * var data='m_nombre_tabla=tesoro.tts_devengado'; var
	 * importe=SelectionsRecord.data.importe_pagado -
	 * SelectionsRecord.data.importe_multa; //alert('pagado:
	 * '+SelectionsRecord.data.importe_pagado+
	 * 'multa:'+SelectionsRecord.data.importe_multa);
	 * 
	 * data=data+'&m_nombre_campo=id_devengado';
	 * data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
	 * data=data+'&m_nombre_cheque='+SelectionsRecord.data.nombre_pago;
	 * data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
	 * data=data+'&m_importe_cheque='+importe;
	 * data=data+'&m_sw_cuenta_bancaria=true';
	 * data=data+'&m_sw_nombre_cheque=true'; data=data+'&m_sw_moneda=false';
	 * data=data+'&m_sw_importe_cheque=false';
	 * data=data+'&m_cambio_estado='+v_act_est; data=data+'&m_vista=2'; var
	 * ParamVentana={Ventana:{width:370,height:255}};
	 * layout_devengar_servicios.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana) }
	 * else{ Ext.MessageBox.alert('Estado','El Devengado Padre no existe') } } } } }
	 */

	function btn_ajustar(){
		if(confirm("¿Está seguro de realizar el Ajuste? \n\nNota: El Ajuste se lo realiza sobre el último registro.")){
			var id_devengado=maestro.id_devengado;
			Ext.Ajax.request({
				url:direccion+"../../../control/devengado_detalle/ActionAjustarDevengadoDetalle.php?cantidad_ids=1&id_devengado_0="+id_devengado,
				method:'GET',
				success:fin_ajust,
				failure:CM_conexionFailure,
				timeout:100000// TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
	}

	function fin_ajust(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Ajuste Realizado satisfactoriamente<br>');
		CM_btnAct()
	}

	this.btnNew=function(){
		// Obtiene el Saldo por pagar
		/*CM_ocultarGrupo('Documento');
			CM_mostrarGrupo('Datos');*/
		RegistrarDatos();
		obtener_saldo_pag();
		CM_btnNew();
	}

	this.btnEdit=function(){
		// Obtiene el Saldo por pagar
		/*CM_ocultarGrupo('Documento');
			CM_mostrarGrupo('Datos');*/
		RegistrarDatos();
		obtener_saldo_pag();
		CM_btnEdit();
	}
	
	function BlancosGrupo(grupo,obligatorio){ //1: obligatorio   0: no obligatorio
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo){
				if(obligatorio==1){
					componentes[i].allowBlank=false;
				} else{
					componentes[i].allowBlank=true;
				}
			}
			
		}
	}

	function obtener_saldo_pag(){
		Ext.MessageBox.hide();// ocultamos el loading
		var id_devengado=maestro.id_devengado;
		Ext.Ajax.request({
			url:direccion+'../../../../sis_tesoreria/control/devengado/ActionObtenerSaldoPag.php?id_devengado='+id_devengado,
			method:'GET',
			success:ter,
			failure:CM_conexionFailure,
			timeout:100000
		})
	}
	function ter(resp){
		var root = resp.responseXML.documentElement;
		var v_saldo = root.getElementsByTagName('saldo')[0].firstChild.nodeValue;
		v_saldo_dev.setValue(v_saldo);
	}
	
	function f_documento(){
		CM_ocultarGrupo('Datos');
		CM_ocultarGrupo('Regularizar');
		CM_mostrarGrupo('Documento');
		CM_mostrarFormulario();
	}
	function f_regularizar(){
		CM_ocultarGrupo('Datos');
		CM_ocultarGrupo('Documento');
		CM_mostrarGrupo('Regularizar');
		CM_mostrarFormulario();
	}
	function btn_devengado_dcto(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_devengado='+SelectionsRecord.data.id_devengado;
			data=data+'&m_desc_concepto_ingas='+SelectionsRecord.data.desc_concepto_ingas;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_importe_devengado='+SelectionsRecord.data.importe_pagado;
			data=data+'&m_tipo_devengado='+SelectionsRecord.data.desc_tipo_devengado;
			data=data+'&m_estado_devengado='+SelectionsRecord.data.desc_estado_devengado;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&tipoFormDev='+maestro.tipoFormDev;
			data=data+'&m_nit='+SelectionsRecord.data.nit;
			data=data+'&m_proforma=2';// +SelectionsRecord.data.tipo_gen_pago;
			data=data+'&m_solo_lectura='+v_dcto_solo_lectura;// +SelectionsRecord.data.tipo_gen_pago;
			data=data+'&m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
			data=data+'&m_id_plan_pago='+SelectionsRecord.data.id_plan_pago;


			// Verifica si se podrá o no modificar el Tipo de Documento
			if(SelectionsRecord.data.id_cotizacion!=''){
				data=data+'&m_tipo_doc_fijo=si';
			}else{
				data=data+'&m_tipo_doc_fijo=';
			}

			var ParamVentana={Ventana:{width:'80%',height:'60%'}}
			layout_devengar_servicios.loadWindows(direccion+'../../../../sis_tesoreria/vista/devengado_dcto/devengado_dcto.php?'+data,'Detalle Devengado',ParamVentana);

		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_rec_pag(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			//if(SelectionsRecord.data.id_comprobante!=''||SelectionsRecord.data.id_comprobante!=''){
			if(SelectionsRecord.data.estado_devengado==11||SelectionsRecord.data.estado_devengado==17||SelectionsRecord.data.estado_devengado==12){
				window.open(direccion+'../../../../sis_tesoreria/control/_reportes/recibo_pago/ActionReciboPago.php?id_devengado='+SelectionsRecord.data.id_devengado);
			} else{
				Ext.MessageBox.alert('Información','El pago debe estar contabilizado');
			}
		} else{
			Ext.MessageBox.alert('Información','Debe seleccionar un registro');
		}
	}

	// para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengar_servicios.getLayout()};
	// para el manejo de hijos

	this.Init(); // iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	// para agregar botones
	var CM_getBoton=this.getBoton;
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Registro de Facturas y/o Recibos',btn_devengado_dcto,false,'btn_docs','Facturas/Recibos');
	this.AdicionarBoton("../../../lib/imagenes/det.ico",'Enviar a Contabilidad',f_contabilizar,false, 'btn_cont_pago','Enviar a Contabilidad');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Impresión del Cheque',f_imprimir_cheque,false,'btn_cheque','Imprimir Cheque');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Tipo Documento',f_documento,false,'btn_tipo_documento','Tipo Documento');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Regularizar',f_regularizar,false,'btn_regularizar','Regularizar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Recibo de Pago',btn_rec_pag,false,'btn_rec_pag','Recibo de Pago');

	// Define el título de Botón de Desembolso
	if(maestro.tipo_desembolso==2){ // Cajas
		CM_getBoton('btn_cont_pago-'+idContenedor).setText('Desembolsar por Caja');
	} else if(maestro.tipo_desembolso==3){
		CM_getBoton('btn_cont_pago-'+idContenedor).setText('Desembolsar por Transferencia');
	}
	
	//Esconde los botoones definitivamente
	CM_getBoton('btn_tipo_documento-'+idContenedor).hide();
	CM_getBoton('btn_regularizar-'+idContenedor).hide();

	if(maestro.tipoFormDev=='fin'){
		// Oculta los botones que no se utilizaran
		CM_getBoton('nuevo-'+idContenedor).hide();
		CM_getBoton('guardar-'+idContenedor).hide();
		CM_getBoton('editar-'+idContenedor).hide();
		CM_getBoton('eliminar-'+idContenedor).hide();
		CM_getBoton('btn_cont_pago-'+idContenedor).hide();
		// CM_getBoton('btn_cheque_descargo-'+idContenedor).hide();
		CM_getBoton('btn_cheque-'+idContenedor).hide();
	}
	else{
		CM_getBoton('btn_cont_pago-'+idContenedor).disable();
		// CM_getBoton('btn_cheque_descargo-'+idContenedor).disable();
		CM_getBoton('btn_cheque-'+idContenedor).hide();
	}
	// Deshabilita en cualquier caso el botón de Documentos
	CM_getBoton('btn_docs-'+idContenedor).hide();
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_devengar_servicios.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}