/**
* Nombre:		  	    pagina_devengado_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:43:29
*/
function pagina_devengado_detalle(idContenedor,direccion,paramConfig,pmaestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var v_porcentaje_devengado,v_importe_devengado,cmb_porc_mon,v_con_ep,v_ep='',cmbPresup,cmbUsuario;
	var maestro=pmaestro;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'valor',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000}	
	);

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado_detalle/ActionListarDevengadoDetalle.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_devengado_detalle',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_devengado_detalle',
		'id_devengado',
		'id_fina_regi_prog_proy_acti',
		'id_unidad_organizacional',
		'porcentaje_devengado',
		'importe_devengado',
		'desc_unidad_organizacional',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'nombre_completo',
		'aprobado',
		'id_presupuesto',
		'desc_presupuesto',
		'id_usuario',
		'disponibilidad',
		'id_partida_ejecucion',
		'estado_devengado'
		]),remoteSort:true
	});

	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}

	//Añade y dibuja Tabla del maestro si el formulario es de Pago o Finalización
	var div_grid_detalle,data_maestro;
	if(maestro.tipoFormDev=='pag'||maestro.tipoFormDev=='fin'){
		div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
		data_maestro=[['Concepto Ingreso Gasto',maestro.desc_concepto_ingas],['Moneda',maestro.desc_moneda],['Importe Devengado',maestro.importe_devengado],['Estado Devengado',maestro.estado_devengado],['Tipo Devengado',maestro.tipo_devengado]];
	}

	//DATA STORE COMBOS
	var ds_devengado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado/ActionListarDevengado.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_devengado',totalRecords: 'TotalCount'},['desc_partida','desc_ingas','nombre','importe_devengado','estado_devengado'])
	});

	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacionalEP.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	
	var ds_usuario_autorizado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarUsuarioAutorizadoPresup.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','nombre_completo']),
	baseParams:{id_presupuesto:0}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
	                                                                                              'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
	                                                                                              'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
	                                                                                              'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
	                                                                                              'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
	]),baseParams:{sw_inv_gasto:'si'}});

	//FUNCIONES RENDER
	function render_id_devengado(value, p, record){return String.format('{0}', record.data['desc_devengado']);}
	var tpl_id_devengado=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_partida}</FONT><br>','<FONT COLOR="#B5A642">{desc_ingas}</FONT><br>','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{importe_devengado}</FONT><br>','<FONT COLOR="#B5A642">{estado_devengado}</FONT>','</div>');

	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquía: </b>{nombre_nivel}</FONT>','</div>');
	
	function render_id_usuario_autorizado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	var tpl_id_usuario_autorizado=new Ext.Template('<div class="search-item">','<b>Usuario: </b><FONT COLOR="#B5A642">{nombre_completo}</FONT>','</div>');

	function render_porcentaje_devengado(value, p, record){
		if(record.data['porcentaje_devengado']!=''){
			return String.format('{0}', record.data['porcentaje_devengado']+'%');}
	}
	
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
	'<b>{nombre_unidad}</b>',
	'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
	'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
	'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
	'<br>  <b>EP: </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
	'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
	'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
	'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
	'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
	'</div>')
	
	function render_disponibilidad(value,p,record){
		if(record.data['estado_devengado']>3){
			return String.format('{0}', 'DISPONIBLE');
		} else{
			if(value=='DISPONIBLE'){
				return String.format('{0}', value);
			} else if(value=='NO DISPONIBLE'){
				return String.format('{0}','<FONT COLOR="#FF0000"><b>'+value+'</b></FONT>');
			} else{
				return String.format('{0}', value);
			}
		}
	}
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado_detalle
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado_detalle',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado_detalle'
	};
	// txt id_devengado
	Atributos[1]={
		validacion:{
			name:'id_devengado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_devengado,
		save_as:'id_devengado'
	};
	
	Atributos[2]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,
			emptyText:'Presupuesto....',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
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
			width:400,
			disabled:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'porc_monto',
			fieldLabel:'Por',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.devengado_detalleCombo.tipo_pago}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['porc', 'Porcentaje'],['mon', 'Monto Fijo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//width:'50%',
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			grid_indice:15,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		defecto: 'mon',
		save_as:'porc_monto',
		id_grupo:0
	};
	// txt porcentaje_devengado
	Atributos[4]={
		validacion:{
			name:'porcentaje_devengado',
			fieldLabel:'Porcentaje Devengado',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			renderer:render_porcentaje_devengado,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150,
			disabled:false,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'DEVDET.porcentaje_devengado',
		save_as:'porcentaje_devengado'
	};
	// txt importe_devengado
	Atributos[5]={
		validacion:{
			name:'importe_devengado',
			fieldLabel:'Importe Devengado',
			allowBlank:true,
			align:'right',
			renderer: render_total,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150,
			disabled:false,
			grid_indice:5,
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'DEVDET.importe_devengado',
		save_as:'importe_devengado'
	};
	
	Atributos[6]={
		validacion:{
			name:'saldo_dev',
			fieldLabel:'Saldo por Devengar',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo: 'Field',
		save_as:'saldo_dev'
	};

	Atributos[7]={
		validacion:{
			name:'saldo_porc_dev',
			fieldLabel:'Saldo Porcentaje por Devengar',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo: 'Field',
		save_as:'saldo_porc_dev'
	};

	Atributos[8]={
		validacion:{
			name:'nombre_completo',
			fieldLabel:'Responsable Aprobación',
			width_grid:150,
			grid_visible:false,
			grid_editable:false,
			width:300,
			disabled:true,
			grid_indice:6
		},
		tipo: 'Field',
		save_as:'nombre_completo'
	};

	/////////// txt aprobado //////
	Atributos[9]={
		validacion:{
			name:'aprobado',
			fieldLabel:'Aprobado',
			checked:false,
			renderer:formatValida,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:maestro.tipoFormDev=='aprob' ? true:false,
			width_grid:70,
			grid_indice:-1
		},
		tipo:'Checkbox',
		form:false,
		save_as:'aprobado'
	};
	
	Atributos[10]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Responsable Aprobación',
			allowBlank:false,
			emptyText:'Usuario...',
			desc: 'nombre_completo',
			store:ds_usuario_autorizado,
			valueField: 'id_usuario',
			displayField: 'nombre_completo',
			queryParam: 'filterValue_0',
			filterCol:'USUARI.nombre_completo',
			typeAhead:false,
			tpl:tpl_id_usuario_autorizado,
			forceSelection:false,
			mode:'remote',
			queryDelay:200,
			pageSize:20,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_autorizado,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_completo'
	};
	
	Atributos[11]={
		validacion:{
			name:'disponibilidad',
			fieldLabel:'Disponibilidad',
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			grid_indice:1,
			renderer:render_disponibilidad
		},
		tipo: 'Field',
		form:false
	};

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatValida(value){
		if (value==1) return 'Si';
		else return 'No'
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var layout_devengado_detalle = new DocsLayoutMaestro(idContenedor);
	layout_devengado_detalle.init({titulo_maestro:'Registro de Pagos',titulo_detalle:'Prorrateo del Gasto',grid_maestro:'grid-'+idContenedor});

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_devengado_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES

	//Añade y dibuja Tabla del maestro si el formulario es de Pago o Finalización
	if(maestro.tipoFormDev=='pag'||maestro.tipoFormDev=='fin'){
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	}

	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado_detalle/ActionEliminarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Save:{url:direccion+'../../../control/devengado_detalle/ActionGuardarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		ConfirmSave:{url:direccion+'../../../control/devengado_detalle/ActionAprobarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:360,columnas:['95%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}],width:600,minWidth:150,minHeight:200,closable:true,titulo:'Devengado Detalle'}
	};

	//-------------- Sobrecarga de funciones --------------------//
	this.btnNew=function(){
		//Obtiene el Saldo por devengar
		obtener_saldo_dev();
		//Por defecto oculta el Importe por Porcentaje
		v_porcentaje_devengado.setDisabled(true);
		v_importe_devengado.setDisabled(false);

		CM_btnNew();
	}

	this.btnEdit=function(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			//Obtiene el Saldo por devengar
			obtener_saldo_dev();
			var SelectionsRecord=sm.getSelected();
			var v_porc_dev=SelectionsRecord.data.porcentaje_devengado;
			if(v_porc_dev!=''){
				cmb_porc_mon.setValue('porc');
				v_importe_devengado.setDisabled(true);
				v_porcentaje_devengado.setDisabled(false);
			}else{
				cmb_porc_mon.setValue('mon');
				v_porcentaje_devengado.setDisabled(true);
				v_importe_devengado.setDisabled(false);
			}
			
			var id=cmbPresup.getValue();
			cmbUsuario.modificado=true;
			ds_usuario_autorizado.baseParams={id_presupuesto:id};
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
		CM_btnEdit();
	}
	
	this.reload=function(params){
		var datos=params;
		if(datos.id_devengado==undefined){
			datos=Ext.urlDecode(decodeURIComponent(params));
		}

		maestro.id_devengado=datos.id_devengado;
		maestro.importe_devengado=datos.importe_devengado;
		maestro.estado_devengado=datos.estado_devengado;
		maestro.tipoFormDev=datos.tipoFormDev;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_devengado:maestro.id_devengado
			}
		};
		this.btnActualizar();
		//Añade y dibuja Tabla del maestro si el formulario es de Pago o Finalización
		if(maestro.tipoFormDev=='pag'||maestro.tipoFormDev=='fin'){
			data_maestro=[['Concepto Ingreso Gasto',maestro.desc_concepto_ingas],['Moneda',maestro.desc_moneda],['Importe Devengado',maestro.importe_devengado],['Estado Devengado',maestro.estado_devengado],['Tipo Devengado',maestro.tipo_devengado]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		}
		Atributos[1].defecto=maestro.id_devengado;

		paramFunciones.btnEliminar.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.Save.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.ConfirmSave.parametros='&m_id_devengado='+maestro.id_devengado;

		//CM_getBoton('editar-'+idContenedor).disable();
		//CM_getBoton('eliminar-'+idContenedor).disable();//nuevo,guardar,actualizar

		if(maestro.tipoFormDev=='pag'||maestro.tipoFormDev=='fin'){
			//var paramMenu={actualizar:{crear:true,separador:false}};
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('guardar-'+idContenedor).hide();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
			CM_getBoton('actualizar-'+idContenedor).show();
			CM_getBoton('actualizar-'+idContenedor).enable();

		}else if(maestro.tipoFormDev=='aprob'){
			//var paramMenu={guardar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('guardar-'+idContenedor).show();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
			CM_getBoton('actualizar-'+idContenedor).show();

			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('actualizar-'+idContenedor).enable();
		}else{
			//var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
			CM_getBoton('nuevo-'+idContenedor).show();
			CM_getBoton('guardar-'+idContenedor).show();
			CM_getBoton('editar-'+idContenedor).show();
			CM_getBoton('eliminar-'+idContenedor).show();
			CM_getBoton('actualizar-'+idContenedor).show();
			CM_getBoton('actualizar-'+idContenedor).show()
		}
		//this.InitBarraMenu(paramMenu);
		if(maestro.tipoFormDev=='dev'){
			//this.AdicionarBoton('../../../lib/imagenes/eitem.png','Ajustar',btn_ajustar,true,'ajust_dev','');
			CM_getBoton('ajust_dev-'+idContenedor).show();
		}else{
			CM_getBoton('ajust_dev-'+idContenedor).hide();
		}

		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		v_porcentaje_devengado = getComponente('porcentaje_devengado');
		v_importe_devengado = getComponente('importe_devengado');
		cmb_porc_mon = getComponente('porc_monto');
		v_saldo_dev = getComponente('saldo_dev');
		v_saldo_porc_dev = getComponente('saldo_porc_dev');
		//v_ep= getComponente('id_fina_regi_prog_proy_acti');
		cmbUO=getComponente('id_unidad_organizacional');
		cmbPresup=getComponente('id_presupuesto');
		cmbUsuario=getComponente('id_usuario');

		//Definición de  formato inicial
		v_porcentaje_devengado.getEl().setStyle('text-align','right');
		v_importe_devengado.getEl().setStyle('text-align','right');
		v_saldo_dev.getEl().setStyle('text-align','right');
		v_saldo_porc_dev.getEl().setStyle('text-align','right');

		CM_ocultarComp[v_porcentaje_devengado];
		CM_mostrarComp[v_importe_devengado];

		//Definición de funciones para eventos
		var onCmbPorcMonModif = function(e) {
			if(cmb_porc_mon.getValue()=='mon'){
				//Dehabilita el porcentaje
				v_porcentaje_devengado.setDisabled(true);
				v_porcentaje_devengado.allowBlank=true;
				v_porcentaje_devengado.validate();
				//Habilita el importe
				v_importe_devengado.setDisabled(false);
				v_importe_devengado.allowBlank=false;
			}else if (cmb_porc_mon.getValue()=='porc'){
				//Dehabilita el porcentaje
				v_importe_devengado.setDisabled(true);
				v_importe_devengado.allowBlank=true;
				//Habilita el importe
				v_porcentaje_devengado.allowBlank=false;
				v_porcentaje_devengado.setDisabled(false);
			}
		}

		var onPorcentajeModif=function(){
			if(cmb_porc_mon.getValue()=='porc'){
				if(v_porcentaje_devengado.isValid()){
					aux=maestro.importe_devengado * v_porcentaje_devengado.getValue()/100;
					tot=Math.round(aux*100)/100;
					v_importe_devengado.setValue(tot);
				}
			}else{
				if(v_importe_devengado.isValid()){
					aux=v_importe_devengado.getValue()*100/maestro.importe_devengado;
					tot=Math.round(aux*100)/100;
					v_porcentaje_devengado.setValue(tot);
				}
			}
		};
		
		var onCmbPresupModif=function(){
			var id=cmbPresup.getValue();
			if(id!=''){
				cmbUsuario.modificado=true;
				cmbUsuario.setValue('');
				ds_usuario_autorizado.baseParams={id_presupuesto:id};
			}else{
				cmbUsuario.modificado=true;
				ds_usuario_autorizado.baseParams={id_presupuesto:0};
				cmbUsuario.setValue('');
			}
		};

		//Asignación de Eventos
		cmb_porc_mon.on('select',onCmbPorcMonModif);
		v_porcentaje_devengado.on('blur',onPorcentajeModif);
		v_importe_devengado.on('blur',onPorcentajeModif);
		//v_ep.on('change',onEPmodif);
		cmbPresup.on('select',onCmbPresupModif);
		cmbPresup.on('change',onCmbPresupModif);
	}

	function obtener_saldo_dev(){
		Ext.MessageBox.hide();//ocultamos el loading
		var id_devengado=maestro.id_devengado;
		Ext.Ajax.request({
			url:direccion+'../../../../sis_tesoreria/control/devengado/ActionObtenerSaldoDev.php?id_devengado='+id_devengado,
			method:'GET',
			success:ter,
			timeout:100000
		})
	}
	
	function ter(resp){
		var root = resp.responseXML.documentElement;
		var v_saldo = root.getElementsByTagName('saldo')[0].firstChild.nodeValue;
		var v_saldo_porc = root.getElementsByTagName('saldo_porc')[0].firstChild.nodeValue;
		v_saldo_dev.setValue(v_saldo);
		v_saldo_porc_dev.setValue(v_saldo_porc+'%');
	}

	function btn_ajustar(){
		if(confirm("¿Está seguro de realizar el Ajuste? \n\nNota: El Ajuste se lo realiza sobre el último registro.")){
			var id_devengado=maestro.id_devengado;
			Ext.Ajax.request({
				url:direccion+"../../../control/devengado_detalle/ActionAjustarDevengadoDetalle.php?cantidad_ids=1&id_devengado_0="+id_devengado,
				method:'GET',
				success:fin_ajust,
				failure:CM_conexionFailure,
				timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
	}

	function fin_ajust(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Ajuste Realizado satisfactoriamente<br>');
		CM_btnAct()
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengado_detalle.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_devengado:maestro.id_devengado
		}
	});

	//para agregar botones
	var CM_getBoton=this.getBoton;
	this.AdicionarBoton('../../../lib/imagenes/eitem.png','Ajustar',btn_ajustar,true,'ajust_dev','');

	//Oculta los botones que no se utilizaran
	if(maestro.tipoFormDev=='dev'){
		//this.AdicionarBoton('../../../lib/imagenes/eitem.png','Ajustar',btn_ajustar,true,'ajust_dev','');
		CM_getBoton('ajust_dev-'+idContenedor).show();
	}else{
		CM_getBoton('ajust_dev-'+idContenedor).hide();
	}

	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_devengado_detalle.getLayout().addListener('layout',this.onResize);
}