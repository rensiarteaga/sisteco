/**
 * Nombre:		  	    pagina_viatico_calculo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-04-16 11:37:06
 */
function pagina_viatico_calculo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var bandera = 0;	//inicializamos la bandera que controla los calculos del 70% y 100% 
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/viatico_calculo/ActionListarViaticoCalculo.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_viatico_calculo',totalRecords:'TotalCount'
		},[		
		'id_viatico_calculo',
		'id_viatico',
		'id_origen',
		'lugar_origen',
		'id_destino',
		'lugar_destino',
		'tipo_destino',
		'id_cobertura',
		'desc_cobertura',
		'id_entidad',
		'nombre_entidad',
		{name: 'fecha_inicio',type:'date',dateFormat:'m-d-Y'},
		{name: 'fecha_final',type:'date',dateFormat:'m-d-Y'}, //Y-m-d
		'hora_inicio',
		'hora_final',
		'nro_dias',
		'importe_pasaje',
		'importe_viatico',
		'importe_hotel',
		'importe_otros',
		'total_pasaje',
		'total_viaticos',
		'total_hotel',
		'total_general',
		'tipo_transporte',
		'importe_retencion',
		'tipo_registro',
		'detalle_viaticos',
		'detalle_otros',
		'tipo_viaje'
		]),remoteSort:true});

		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_viatico:maestro.id_viatico
		}
	});
	
	
	// DEFINICIÓN DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
		
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[	['Empleado',maestro.desc_empleado],
						['Categoría',maestro.desc_categoria],
						['Moneda',maestro.desc_moneda]	];
	
		
	//DATA STORE COMBOS
	var ds_entidad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/entidad/ActionListarEntidad.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_entidad',totalRecords: 'TotalCount'},['id_entidad','desc_institucion'])
	});
	
	var ds_origen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar','tipo_destino','desc_tipo','desc_categoria'])//,
			//baseParams: {m_id_categoria : maestro.id_categoria}			
	});
	
	var ds_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar','tipo_destino','desc_tipo','desc_categoria'])//,
			//baseParams: {m_id_categoria : maestro.id_categoria}			
	});	
	
    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','sw_dias','incluye_hotel','descripcion'])
	});

	//FUNCIONES RENDER
	function renderTipoDestino(value, p, record)
	{
		if(value == 1)
		{return "Ciudad Tipo A"}
		if(value == 2)
		{return "Ciudad Tipo B"}
		if(value == 3)
		{return "Campo"}
		if(value == 4)
		{return "País Tipo A"}
		if(value == 5)
		{return "País Tipo B"}		
		//return 'Otro';
	}
	
	function render_id_origen(value, p, record){return String.format('{0}', record.data['lugar_origen']);}
	var tpl_id_origen=new Ext.Template('<div class="search-item">','<b><i>{desc_lugar}</i></b>','<br><FONT COLOR="#B5A642"><b>Tipo: </b>{desc_tipo}</FONT>','<br><FONT COLOR="#B5A642"><b>Categoría: </b>{desc_categoria}</FONT>','</div>');
	
	function render_id_destino(value, p, record){return String.format('{0}', record.data['lugar_destino']);}
	var tpl_id_destino=new Ext.Template('<div class="search-item">','<b><i>{desc_lugar}</i></b>','<br><FONT COLOR="#B5A642"><b>Tipo: </b>{desc_tipo}</FONT>','<br><FONT COLOR="#B5A642"><b>Categoría: </b>{desc_categoria}</FONT>','</div>');
	
	function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','<b><i>{descripcion} </i></b>','<br><FONT COLOR="#B5A642"><b>Incluye Hotel: {incluye_hotel}</b></FONT>','</div>');
	
	/*
	function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','<b><i>{porcentaje}</b></i><br>','</div>');
	*/
	
	function render_id_entidad(value, p, record){return String.format('{0}', record.data['nombre_entidad']);}
	var tpl_id_entidad=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i>','</div>');
	
	function renderTipoTransporte(value, p, record)
	{
		if(value == 1)
		{return "Aéreo"}
		if(value == 2)
		{return "Terrestre"}
		if(value == 3)
		{return "Fluvial"}	
		if(value == 4)
		{return "Ninguno"}	
		//return 'Otro';
	}
	
	function renderTipoDestino(value, p, record)
	{
		if(value == 1)
		{return "Ciudad Tipo A"}
		if(value == 2)
		{return "Ciudad Tipo B"}
		if(value == 3)
		{return "Campo"}
		if(value == 4)
		{return "País Tipo A"}
		if(value == 5)
		{return "País Tipo B"}		
		//return 'Otro';
	}
	
	function renderTipoRegistro(value, p, record)
	{
		if(value == 1)
		{return "Detallado"}
		if(value == 2)
		{return "Global"}		
		//return 'Otro';
	}
	
	function renderTipoViaje(value, p, record)
	{
		if(value == 1)
		{return "Ida y Vuelta"}
		if(value == 2)
		{return "Solo Ida"}		
		//return 'Otro';
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_viatico_calculo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_viatico_calculo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt id_viatico
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_viatico',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		defecto:maestro.id_viatico,
		filtro_0:false	
 	};
// txt id_origen	
	Atributos[2]={
			validacion:{
			name:'id_origen',
			fieldLabel:'Origen',
			allowBlank:false,			
			//emptyText:'Origen...',
			desc: 'lugar_origen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_origen,			
			valueField: 'id_destino',
			displayField: 'desc_lugar',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead:true,
			tpl:tpl_id_origen,
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
			renderer:render_id_origen,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			//grid_indice:6,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGARR1.nombre',
		save_as:'id_origen',
		id_grupo:1
	};
// txt id_destino
	Atributos[3]={
			validacion:{
			name:'id_destino',
			fieldLabel:'Destino',
			allowBlank:false,			
			//emptyText:'Destino...',
			desc: 'lugar_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_destino,
			valueField: 'id_destino',
			displayField: 'desc_lugar',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead:true,
			tpl:tpl_id_destino,
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
			renderer:render_id_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false
			//grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGARR2.nombre',
		save_as:'id_destino',
		id_grupo:1
	};
	
	Atributos[4]={
		validacion:{
			name:'tipo_destino',
			fieldLabel:'Tipo Destino',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Ciudad Tipo A'],['2','Ciudad Tipo B'],['3','Campo'],['4','País Tipo A'],['5','País Tipo B']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoDestino,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_editable:false, 
			disabled:false
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form:false,
		filtro_0:false,
		filterColValue:'DESTIN.tipo_destino'		
	};
	
// txt fecha_inicio
	Atributos[5]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Salida',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			//minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
			//grid_indice:10		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio',
		id_grupo:1
	};
//hora de inspeccion
	Atributos[6]={
		validacion:{
			name: 'hora_inicio',
			fieldLabel: 'Hora Salida',
			allowBlank: true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'center',
			width: 70,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:110, 
			vtype:'time'
		},
		tipo: 'TextField',
		filtro_0:false,	
		save_as:'hora_inicio',
		id_grupo:1
	};
// txt fecha_final
	Atributos[7]= {
		validacion:{
			name:'fecha_final',
			fieldLabel:'Fecha Final',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			//minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
			//grid_indice:11		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_final',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_final',
		id_grupo:1
	};
	//hora de inspeccion
	Atributos[8]={
		validacion:{
			name: 'hora_final',
			fieldLabel: 'Hora Final',
			allowBlank: true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'center',
			width: 70,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:110, 
			vtype:'time'
		},
		tipo: 'TextField',
		filtro_0:false,		
		save_as:'hora_final',
		id_grupo:1
	};	
// txt nro_dias
	Atributos[9]={
		validacion:{
			name:'nro_dias',
			fieldLabel:'Nro Días',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:1,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:'50%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.nro_dias',
		id_grupo:1		
	};
	// txt tipo_transporte
	Atributos[10]={
		validacion:{
			name:'tipo_transporte',
			fieldLabel:'Tipo Transporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Aéreo'],['2','Terrestre'],['3','Fluvial'],['4','Ninguno']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoTransporte,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			//width:150,
			grid_visible:true,
			//grid_indice:14,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:1,
		filtro_0:false,
		filterColValue:'VIACAL.tipo_transporte'		
	};
	// txt id_entidad
	Atributos[11]={
			validacion:{
			name:'id_entidad',
			fieldLabel:'Empresa',
			allowBlank:false,			
			//emptyText:'Empresa...',
			desc: 'nombre_entidad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_entidad,
			valueField: 'id_entidad',
			displayField: 'desc_institucion',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_entidad,
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
			renderer:render_id_entidad,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false
			//grid_indice:15		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		save_as:'id_entidad',
		id_grupo:1
	};
// txt id_cobertura
	Atributos[12]={
			validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura (%)',
			allowBlank:false,	
			align:'right',		
			//emptyText:'Cobertura...',
			desc: 'desc_cobertura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,
			valueField: 'id_cobertura',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.descripcion',		
			onSelect:function(record)
					 {							
						if(valida_datos())
						{
							componentes[12].setValue(record.data.id_cobertura);
							componentes[12].collapse();
							
							if(componentes[24].getValue()==1)		//tipo de registro DETALLADO
							{
								get_importes();
							}
							
							if(record.data.descripcion=='70% y 100%')
							{	
								bandera = 1;	//colocamos la bandera en 1 para que se hagan los calculos del 70 y 100%
							}
							else
							{
								bandera = 0;  	//colocamos la bandera en 0 para que no se hagan calculos normales
							}
							
							if(record.data.sw_hotel==2)
							{	
								componentes[17].setDisabled(true);	//importe hotel
							}
							else
							{
								componentes[17].setDisabled(false);	//importe hotel
							} 
						}
						else
						{
							componentes[12].collapse();
							Ext.MessageBox.alert('Estado', 'Inserte los campos anteriores que son obligatorios primero');
						}						
						validarDias();
						habilitarTotales();
					},
			typeAhead:true,
			tpl:tpl_id_cobertura,
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
			renderer:render_id_cobertura,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',		
			disabled:false					
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.descripcion',
		save_as:'id_cobertura',
		id_grupo:2
	};
	
// txt importe_pasaje
	Atributos[13]={
		validacion:{
			name:'importe_pasaje',
			fieldLabel:'Importe Pasaje',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'VIACAL.importe_pasaje',
		id_grupo:2		
	};
	// txt total_pasaje
	Atributos[14]={
		validacion:{
			name:'total_pasaje',
			fieldLabel:'Total Pasaje',
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'VIACAL.total_pasaje',
		id_grupo:2
	};
// txt importe_viatico
	Atributos[15]={
		validacion:{
			name:'importe_viatico',
			fieldLabel:'Importe Viático',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.importe_viatico',
		id_grupo:2		
	};
	// txt total_viaticos
	Atributos[16]={
		validacion:{
			name:'total_viaticos',
			fieldLabel:'Total Viático',
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.total_viaticos',
		id_grupo:2		
	};
// txt importe_hotel
	Atributos[17]={
		validacion:{
			name:'importe_hotel',
			fieldLabel:'Importe Hotel',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.importe_hotel',
		id_grupo:2
	};
	// txt total_hotel
	Atributos[18]={
		validacion:{
			name:'total_hotel',
			fieldLabel:'Total Hotel',
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.total_hotel',
		id_grupo:2		
	};
// txt importe_otros
	Atributos[19]={
		validacion:{
			name:'importe_otros',
			fieldLabel:'Importe Otros',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,	
		filterColValue:'VIACAL.importe_otros',
		id_grupo:2
	};
// txt total_general
	Atributos[20]={
		validacion:{
			name:'total_general',
			fieldLabel:'TOTAL GENERAL',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:1,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.total_general',
		id_grupo:2		
	};
	
	// txt importe_viatico
	Atributos[21]={
		validacion:{
			name:'importe_retencion',
			fieldLabel:'Imp. Retención',
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIACAL.importe_retencion',
		id_grupo:2		
	};
	
	// txt justificacion
	Atributos[22]={
		validacion:{
			name:'detalle_viaticos',
			fieldLabel:'Detalle Viáticos',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:3,
		filtro_0:true,
		filterColValue:'VIATIC.detalle_viaticos',
		save_as:'detalle_viaticos'
	};
	
	// txt detalle otros
	Atributos[23]={
		validacion:{
			name:'detalle_otros',
			fieldLabel:'Detalle Otros',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:3,
		filtro_0:false,
		filterColValue:'VIATIC.detalle_otros',
		save_as:'detalle_otros'
	};
	
	// txt tipo_registro
	Atributos[24]={
		validacion:{
			name:'tipo_registro',
			fieldLabel:'Tipo de Registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Detallado'],['2','Global']]}),			
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoRegistro,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			//width:150,
			grid_visible:true,
			//grid_indice:14,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:0,
		filtro_0:false,
		filterColValue:'VIACAL.tipo_registro'		
	};
	
	// txt tipo_viaje
	Atributos[25]={
		validacion:{
			name:'tipo_viaje',
			fieldLabel:'Tipo de Viaje',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Ida y Vuelta'],['2','Solo Ida']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoViaje,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			//width:150,
			grid_visible:true,
			//grid_indice:14,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:0,
		filtro_0:false,
		filterColValue:'VIACAL.tipo_viaje'		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'Cálculo de Viático',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'Viático (Maestro)',titulo_detalle:'Cálculo de Viático (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_viatico_calculo=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_viatico_calculo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_viatico_calculo,idContenedor);
	
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
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
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/viatico_calculo/ActionEliminarViaticoCalculo.php'},
		Save:{url:direccion+'../../../control/viatico_calculo/ActionGuardarViaticoCalculo.php'},
		ConfirmSave:{url:direccion+'../../../control/viatico_calculo/ActionGuardarViaticoCalculo.php'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:'90%',	//alto	
			width:'45%',	//ancho
			minWidth:150,
			minHeight:200,	
			closable:true,
			grupos:[
			{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},			
			{tituloGrupo:'Datos del Viaje',columna:0,id_grupo:1},
			{tituloGrupo:'Importes',columna:0,id_grupo:2},
			{tituloGrupo:'Descripción',columna:0,id_grupo:3},
			{tituloGrupo:'Oculto',columna:0,id_grupo:4}			
						
			],
			titulo:'Cálculo Viáticos'
		}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_viatico=datos.m_id_viatico;
		maestro.desc_empleado=datos.m_desc_empleado;
		maestro.id_categoria=datos.m_id_categoria;
		maestro.desc_categoria=datos.m_desc_categoria;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.sw_retencion=datos.m_sw_retencion;
		maestro.detalle_otros=datos.m_detalle_otros;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_viatico:maestro.id_viatico
			}
		};
		
		ds_origen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar','tipo_destino']),
			baseParams: {m_id_categoria : maestro.id_categoria}			
		});
	
		ds_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar','tipo_destino']),
			baseParams: {m_id_categoria : maestro.id_categoria}			
		});
		
		this.btnActualizar();
		var data_maestro=[	['Empleado',maestro.desc_empleado],
							['Categoría',maestro.desc_categoria],
							['Moneda',maestro.desc_moneda]	];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		Atributos[1].defecto=maestro.id_viatico;

		paramFunciones.btnEliminar.parametros='&m_id_viatico='+maestro.id_viatico;
		paramFunciones.Save.parametros='&m_id_viatico='+maestro.id_viatico;
		paramFunciones.ConfirmSave.parametros='&m_id_viatico='+maestro.id_viatico;
		this.InitFunciones(paramFunciones)
	};	
	
	function InitPaginaViaticoCalculo()
	{
		//para iniciar eventos en el formulario		
		for (var i=0; i<Atributos.length; i++)
		{			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		componentes[5].on('change',fechas);		//fecha_inicial
		componentes[7].on('change',fechas);		//fecha_final		
		
		//componentes[2].on('change',resetComponentes);//id_origen
		componentes[3].on('change',resetComponentes);//id_destino
		componentes[10].on('change',resetComponentesEmpresa);//tipo_transporte				
		
		componentes[13].on('change',totalPasaje);	//importe_pasaje
		componentes[15].on('change',totalViatico);	//importe_viatico
		componentes[17].on('change',totalHotel);	//importe_hotel
		componentes[19].on('change',totalGeneral);	//importe_otros
		componentes[10].on('change',evento_empresa);//tipo_transporte
		//componentes[9].on('change',validarDias);	//nro_dias
		
		componentes[14].on('change',totalGeneral);	//total_pasajes
		componentes[16].on('change',totalGeneral);	//total_viaticos
		componentes[18].on('change',totalGeneral);	//total_hotel
		componentes[24].on('change',eventoTipoRegistro);//tipo de registro
		
		CM_ocultarGrupo('Oculto');
	}
	
	this.btnNew = function()
	{
		CM_btnNew();		
				
		/*delete componentes[5].maxValue;
		delete componentes[7].minValue;*/
		componentes[5].reset();
		componentes[7].reset();		
		componentes[23].setValue(maestro.detalle_otros);
	}
	
	function resetComponentes()
	{		
		for(var i=12; i<22; i++)
		{
			componentes[i].reset();
			//componentes[i].setValue('0');
		}
	}
	
	function resetComponentesEmpresa()
	{		
		resetComponentes();
		componentes[11].reset();		
	}
	
	function validarDias()
	{
		var recordCobertura;
		if(componentes[12].getValue()!='')			//cobertura
		{
			if(componentes[9].getValue()!='')		//numero de dias
			{
				recordCobertura=ds_cobertura.getById(componentes[12].getValue());		//cobertura
				
				if(recordCobertura.data.sw_dias==1 && componentes[9].getValue()>1)		//numero de dias
				{
					Ext.MessageBox.alert('Estado', 'La cobertura seleccionada solo permite viajes de un solo día.\nLa fecha final sera Eliminada');
					componentes[7].reset();	//fecha final
					componentes[9].reset();	//numero de dias
				}			
			}			
		}
	}
	
	function eventoTipoRegistro()
	{
		resetComponentes();
		
		componentes[2].store.baseParams={m_id_categoria : maestro.id_categoria};
		componentes[2].modificado=true;
		
		componentes[3].store.baseParams={m_id_categoria : maestro.id_categoria};
		componentes[3].modificado=true;
		//habilitarTotales();
	}

	
	function habilitarTotales()
	{		
		//si el tipo de registro es DETALLADO
		if(componentes[24].getValue()==1)		
		{			
			componentes[14].setDisabled(true);	//total pasajes
			componentes[16].setDisabled(true);	//total viaticos
			componentes[18].setDisabled(true);	//total hotel
			componentes[21].setDisabled(true);	//importe retencion
			
			//mostramos los importes
			CM_mostrarComponente(componentes[13]);
			CM_mostrarComponente(componentes[15]);
			CM_mostrarComponente(componentes[17]);
			
			//componentes[22].setDisabled(true);	//descripcion viaticos
			CM_ocultarComponente(componentes[22]);
			
		}
		//si el tipo de registro es Global
		else									//tipo de registro GLOBAL
		{
			for(var i=13; i<22; i++) //colocamo en 0 todos los importes
			{
				//componentes[i].reset();
				componentes[i].setValue(0);
			}
			
			componentes[14].setDisabled(false);	//total pasajes
			componentes[16].setDisabled(false);	//total viaticos
			componentes[18].setDisabled(false);	//total hotel
			componentes[21].setDisabled(false);	//importe retencion	
			
			//ocultamos los campos de importes
			CM_ocultarComponente(componentes[13]);
			CM_ocultarComponente(componentes[15]);
			CM_ocultarComponente(componentes[17]);
			
			//componentes[22].setDisabled(false);	//descripcion viaticos
			CM_mostrarComponente(componentes[22]);									
		}		
	}
	
	function fechas()
	{
		//alert('llega');
		//componentes[5].maxValue=componentes[7].getValue();		//fecha inicial
		//componentes[7].minValue=componentes[5].getValue();		//fecha final
		
		if(componentes[5].getValue() && componentes[7].getValue())
		{	
			var fecha1=new Date(componentes[5].getValue());			//fecha inicial
			var fecha2=new Date(componentes[7].getValue());			//fecha final
			var dias=(fecha2-fecha1)/86400000;
			componentes[9].setValue(dias+1);						//numero de dias
			//validarDias();
		}
		resetComponentes();		
		
		//alert('componentes[5].maxValue  '+componentes[5].maxValue+'    componentes[7].minValue  = ' +componentes[7].minValue);
	}

	function evento_empresa()
	{							
		//componentes[11].store.baseParams={m_tipo_entidad:record.data.tipo_entidad};	//empresa
		componentes[11].store.baseParams={m_tipo_entidad:componentes[10].getValue()};	//empresa
		componentes[11].modificado=true;
		
		if(componentes[10].getValue()==1) //tipo de viaje es aereo
		{
			componentes[13].setDisabled(true);	//importe pasajes
		}
		else
		{
			componentes[13].setDisabled(false);	//importe pasajes
		}
	}
	
	function valida_datos()
	{
		var res=true;
		for (var i=1;i<12;i++)
		{	
			if(i!=6 && i!=7 && i!=8)	//permitimos que los campos hora_ini, fecha_fin y hora_fin esten en blanco
			{					
				if(componentes[i]!= undefined && componentes[i].getValue()=='')
				{
					res=false;				
				}
			}
		}

		//controlamos que los campos tipo_registro y tipo_viaje no esten en blanco
		if(componentes[24]!= undefined && componentes[24].getValue()=='')
		{
			res=false;				
		}
		if(componentes[25]!= undefined&&componentes[25].getValue()=='')
		{
			res=false;				
		}	
		return res;
	}
	
	function get_importes()
	{
		var data="id_destino="+componentes[3].getValue();		//id_destino
		data=data+"&cobertura="+componentes[12].getValue();		//cobertura
		data=data+"&id_moneda="+maestro.id_moneda;				//id_moneda
		
		Ext.Ajax.request({
			url:direccion+"../../../control/viatico/ActionListarMontoViatico.php?"+data,
			method:'GET',
			success:cargar_importes,
			failure:conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		})
	}
		
	function cargar_importes(resp)
	{		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;			
			
			//tipo_transporte es aereo o ninguno
			if(componentes[10].getValue()==1 || componentes[10].getValue()==4)	
			{	
				componentes[13].setValue(0);	//importe pasaje			
			}
			//tipo_transporte es terrestre o fluvial
			else
			{
				componentes[13].setValue(root.getElementsByTagName('importe_pasaje')[0].firstChild.nodeValue);	//importe_pasaje
			}	
			
			//con retencion al personal de contrato
			if(maestro.sw_retencion==1)		
			{
				//componentes[21].setValue((((root.getElementsByTagName('importe_viaticos')[0].firstChild.nodeValue)*15.5)/100) * parseFloat(componentes[9].getValue()));//importe total de la retencion
				componentes[15].setValue(((root.getElementsByTagName('importe_viaticos')[0].firstChild.nodeValue)*84.5)/100);//importe_viatico con retencion para un dia				
				
			}
			//sin retencion al solicitante
			else
			{
				//componentes[21].setValue(0);//inporte retencion
				componentes[15].setValue(root.getElementsByTagName('importe_viaticos')[0].firstChild.nodeValue);//importe_viatico sin retencion					
				
			}
			
			componentes[17].setValue(root.getElementsByTagName('importe_hotel')[0].firstChild.nodeValue);	//importe_hotel
			
			componentes[19].setValue(0);			//importe_otros
			componentes[13].fireEvent('change');	//importe_pasaje
			componentes[15].fireEvent('change');	//importe_viatico
			componentes[17].fireEvent('change');	//importe_hotel					
		}
	}
	
	function conexionFailure(resp1,resp2,resp3,resp4)
	{
		resetComponentes();
		ClaseMadre_conexionFailure(resp1,resp2,resp3,resp4);
	}
	
	function totalPasaje()
	{
		if(componentes[24].getValue()==1) //tipo de registro detallado
		{		
			componentes[14].setValue(componentes[13].getValue() );//total_viatico
		}	
		
		totalGeneral();		
	}	
	
	function totalViatico()
	{
		//tipo de registro detallado
		if(componentes[24].getValue()==1) 
		{
			componentes[16].setValue( ( Math.round( parseFloat( componentes[15].getValue() ) * ( parseFloat( componentes[9].getValue() ) ) * 100 ) ) / 100 );//importe viatico * numero de dias = total_viatico
			
			//si la cobertura seleccionada es 70% y 100% 
			if(bandera == 1)
			{
				componentes[16].setValue( componentes[16].getValue() - componentes[15].getValue() + ( ( componentes[15].getValue() * 100 ) / 70 ) ); // cuando la cobertura es 70% y el ultimo dia es 100%
			}
				
			//con retencion al personal de contrato
			if(maestro.sw_retencion==1)		
			{
				componentes[21].setValue(((componentes[16].getValue()*100)/84.5)-componentes[16].getValue());//importe total de la retencion
				//componentes[21].setValue((((root.getElementsByTagName('importe_viaticos')[0].firstChild.nodeValue)*15.5)/100) * parseFloat(componentes[9].getValue()));//importe total de la retencion
			}
			//sin retencion al los viaticos del solcicitante
			else
			{
				componentes[21].setValue(0);//inporte retencion
			}
		}		
		
		totalGeneral();
	}
	
	function totalHotel()
	{
		//importe total hotel									importe hotel								nro_dias
		
		if(componentes[24].getValue()==1) //tipo de registro detallado
		{
			
			//el viaje es ida y vuelta
			if(componentes[25].getValue()==1) 
			{
				//descontamos un dia de hotel
				componentes[18].setValue( ( Math.round ( parseFloat ( componentes[17].getValue() ) * ( parseFloat( componentes[9].getValue() ) - 1 ) * 100) ) / 100);//total_hotel descontanto un dia
			}
			//el viaje es solo ida
			else					
			{
				//solo ida no descontamos 1 dia de hotel
				componentes[18].setValue( ( Math.round ( parseFloat ( componentes[17].getValue() ) * ( parseFloat( componentes[9].getValue() ) ) * 100) ) / 100);//total_hotel por el total de dias de viaje
			}
		}	
			
		totalGeneral();		
	}
	
	function totalGeneral()
	{		
		componentes[20].setValue(parseFloat(componentes[14].getValue())+parseFloat(componentes[16].getValue())+parseFloat(componentes[18].getValue())+parseFloat(componentes[19].getValue())); //total general
	}
	
	/*function btn_global()
	{
		CM_btnNew();
			
	}*/
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{		
	}	
	
	function salta()
	{
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar(); //para actualizar la pantalla del padre
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_viatico_calculo.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);	
	
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Registro de importes totales del viaje',btn_global,true,'registro_global','Registro Global');
	
	this.iniciaFormulario();
	InitPaginaViaticoCalculo();
	iniciarEventosFormularios();
	layout_viatico_calculo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
	layout_viatico_calculo.getVentana().addListener('beforehide',salta)  //Para actualizar la pantalla del padre
}