/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function pagina_detalle_partida_formulacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	
	var monedas_for=new Ext.form.MonedaField(
		{
		name:'mes_01',
		fieldLabel:'Enero',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:false,
		decimalPrecision:0,
		allowNegative:false,
		minValue:0}	
	); 	
	
	var marcas_html,div_dlgFrm,dlgFrm;
	var Moneda,tipoReporte;
	var id_moneda_rep,tipoRep;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarDetallePartidaFormulacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_partida_presupuesto',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_partida_presupuesto',
		'fecha_elaboracion',
		'id_partida',
		'desc_partida',
		'id_presupuesto',
		'desc_presupuesto',
		'id_partida_detalle',
		'mes_01',
		'mes_02',
		'mes_03',
		'mes_04',
		'mes_05',
		'mes_06',
		'mes_07',
		'mes_08',
		'mes_09',
		'mes_10',
		'mes_11',
		'mes_12',
		'total',
		'id_partida_presupuesto',
		'desc_partida_presupuesto',
		'id_moneda',
		'desc_moneda',
		'codigo_partida',
		'tipo_memoria',
		'justificacion',
		'partida_descripcion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_presupuesto:maestro.id_presupuesto,
			id_moneda:maestro.id_moneda			
		}	
		
	});
	
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
	else return "  "
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]]; 
	
	//DATA STORE COMBOS
    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
	});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','fecha_presentacion','tipo_pres','estado_pres','id_unidad_organizacional','id_fuente_financiamiento','id_parametro','id_fina_regi_prog_proy_acti'])
	});

    var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});	
	

	//FUNCIONES RENDER
	/*function renderEstadoNumero(value,p,record){
		if((record.data['estado']=='registrado_recibido' && vista=='externo_derivado')|| 
		(record.data['estado']=='borrador_recibido' && vista=='externo_recibido')|| 
		(record.data['estado']=='borrador_enviado' && vista=='enviado')|| 
		(record.data['estado']=='recibido_derivacion' && vista=='recibido') 
		){
			return String.format('{0}', '<span style="color:brown;font-size:8pt;font-weight:bold;"  title="Notas: '+record.data['observaciones_estado']+'">'+record.data['numero']+'<br>'+record.data['desc_documento']+"</span>");
			
		}
		else if(vista=='recibido'&&record.data['estado']=='pendiente_recibido')
		{
			return String.format('{0}', '<span style="color:blue;font-size:8pt;font-weight:bold;" title="Notas: '+record.data['observaciones_estado']+'">'+record.data['numero']+'<br>'+record.data['desc_documento']+ "</span>");
			
		}
		else{
			return String.format('{0}','<span style="text-align:center" title="Notas: '+record.data['observaciones_estado']+'">'+record.data['numero']+'<br>'+record.data['desc_documento']+" </span>");
			
		}
	}*/
	function render_id_partida(value, p, record)
	{
		//return String.format('{0}', record.data['desc_partida']);
		//return String.format('{0}', '<span style="color:blue;font-size:8pt;font-weight:bold;" title="Notas: '+record.data['codigo_partida']+'">'+record.data['desc_partida']+'<br>'+record.data['codigo_partida']+ "</span>");
		
		return String.format('{0}', '<span title="Descripción Partida '+record.data['codigo_partida']+'  -  '+record.data['partida_descripcion']+'">'+record.data['desc_partida']+ "</span>");
	}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
	var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderTipoMemoria(value, p, record)
	{
		if(value == 1){return "Recursos"}
		if(value == 2){return "Gastos x Item"}
		if(value == 3){return "Inversión"}
		if(value == 4){return "Pasajes"}
		if(value == 5){return "Viajes"}
		if(value == 6){return "RRHH"}
		if(value == 7){return "Servicios"}
		if(value == 8){return "Otros Gastos"}
		if(value == 9){return "Combustibles"}
	}

	function render_moneda(value)
	{
		if(value == 1){return "Bolivianos"}
		if(value == 2){return "Dólares Americanos"}
		if(value == 3){return "Unidad de Fomento a la Vivienda"}
	}
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
			return monedas_for.formatMoneda(value)		 
	}
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_presupuesto',
		id_grupo:0
	};
	Atributos[1]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:100,
			disabled:true		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida',
		save_as:'codigo_partida',
		id_grupo:1
	};
	
	// txt id_partida
	Atributos[2]={
			validacion:{
			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida',	//busqueda en el formulario
			typeAhead:true,
			tpl:tpl_id_partida,
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
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.desc_partida',	//busqueda en la tabla
		save_as:'id_partida',
		id_grupo:1
	};
	
	// txt id_presupuesto
	Atributos[3]={
		validacion:{
			name:'id_presupuesto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_presupuesto,
		save_as:'id_presupuesto',
		id_grupo:0
	};
	// txt id_partida_detalle
	Atributos[4]={
		validacion:{
			name:'id_partida_detalle',
			fieldLabel:'id_partida_detalle',
			allowBlank:false,
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
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.id_partida_detalle',
		save_as:'id_partida_detalle',
		id_grupo:0
	};
	// txt mes_01
	Atributos[5]={
		validacion:{
			name:'mes_01',
			fieldLabel:'Enero',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,//100
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_01',
		save_as:'mes_01',
		id_grupo:0
	};
	// txt mes_02
	Atributos[6]={
		validacion:{
			name:'mes_02',
			fieldLabel:'Febrero',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_02',
		save_as:'mes_02',
		id_grupo:0
	};
	// txt mes_03
	Atributos[7]={
		validacion:{
			name:'mes_03',
			fieldLabel:'Marzo',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_03',
		save_as:'mes_03',
		id_grupo:0
	};
	// txt mes_04
	Atributos[8]={
		validacion:{
			name:'mes_04',
			fieldLabel:'Abril',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_04',
		save_as:'mes_04',
		id_grupo:0
	};
	// txt mes_05
	Atributos[9]={
		validacion:{
			name:'mes_05',
			fieldLabel:'Mayo',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_05',
		save_as:'mes_05',
		id_grupo:0
	};
	// txt mes_06
	Atributos[10]={
		validacion:{
			name:'mes_06',
			fieldLabel:'Junio',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_06',
		save_as:'mes_06',
		id_grupo:0
	};
	// txt mes_07
	Atributos[11]={
		validacion:{
			name:'mes_07',
			fieldLabel:'Julio',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_07',
		save_as:'mes_07',
		id_grupo:0
	};
	// txt mes_08
	Atributos[12]={
		validacion:{
			name:'mes_08',
			fieldLabel:'Agosto',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_08',
		save_as:'mes_08',
		id_grupo:0
	};
	
	// txt mes_09
	Atributos[13]={
		validacion:{
			name:'mes_09',
			fieldLabel:'Septiembre',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_09',
		save_as:'mes_09',
		id_grupo:0
	};
	
	// txt mes_10
	Atributos[14]={
		validacion:{
			name:'mes_10',
			fieldLabel:'Octubre',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_10',
		save_as:'mes_10',
		id_grupo:0
	};
	
	// txt mes_11
	Atributos[15]={
		validacion:{
			name:'mes_11',
			fieldLabel:'Noviembre',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_11',
		save_as:'mes_11',
		id_grupo:0
	};
	
	// txt mes_12
	Atributos[16]={
		validacion:{
			name:'mes_12',
			fieldLabel:'Diciembre',
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
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_12',
		save_as:'mes_12',
		id_grupo:0
	};
	
	// txt total
	Atributos[17]={
		validacion:{
			name:'total',
			fieldLabel:'Total Partida',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.total',
		save_as:'total',
		id_grupo:0
	};
	
	// txt id_partida_presupuesto
	Atributos[18]={
			validacion:{
			name:'id_partida_presupuesto',
			fieldLabel:'Partida Presupuesto',
			allowBlank:false,			
			emptyText:'Partida Presupuesto...',
			desc: 'desc_partida_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida_presupuesto,
			valueField: 'id_partida_presupuesto',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'PARPRE.',
			typeAhead:true,
			tpl:tpl_id_partida_presupuesto,
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
			renderer:render_id_partida_presupuesto,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'PARPRE.',
		save_as:'id_partida_presupuesto',
		id_grupo:0
	};
	
	// txt id_moneda
	Atributos[19]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:0
	};
	
	Atributos[20]={
		validacion:{
			name:'fecha_elaboracion',
			fieldLabel:'Fecha Elaboración Memoria',
			allowBlank:false,
			//maxLength:-5,
			//minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:80,
			width:100,
			disabled:false		
		},
		tipo:'Field',
		filtro_0:false,
		form:true,		
		filterColValue:'PARPRE.fecha_elaboracion',
		save_as:'fecha_elaboracion',
		id_grupo:1
	};
	
	Atributos[21] = {
		validacion: {
			name:'tipo_memoria',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo de Memoria',
			vtype:'texto',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],			
				data :Ext.tipo_memoria_combo.tipo_memoria // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoMemoria,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:80, // ancho de columna en el gris
			width:150,
			disabled:true		
		},
		tipo:'ComboBox',
		defecto:'1',		
		form: false,
		filtro_0:false,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres',
		id_grupo:0		
	};
	
	Atributos[22]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			allowBlank:true,
			width:300,
			maxLength:1000,
			minLength:0,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			selectOnFocus:true,
			vtype:'texto'
			},
		tipo:'TextArea',
		id_grupo:1
	};
	
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Presupuesto de Gasto (Maestro)',titulo_detalle:'Formulación - Partidas a Presupuestar (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_partida_formulacion = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_detalle_partida_formulacion.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_partida_formulacion,idContenedor);
	var CM_ocultarGrupo=this.ocultarGrupo;	
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnEdit=this.btnEdit;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		/*eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false}
	};	
	

	//DEFINICIÓN DE FUNCIONES
	function crearDialogMoneda()
	{
		 marcas_html="<div class='x-dlg-hd'>"+'Parametros de Reporte'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		 div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		 var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:50
		});
		
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:50,	
			width:400,		//anchura
			height:180,		//altura
			minWidth:paramFunciones.Formulario.minWidth,
			minHeight:paramFunciones.Formulario.minHeight,
			closable:paramFunciones.Formulario.closable
		});
		
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);
		dlgFrm.addButton('Generar',btn_imprimir_memoria_calculo);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		
		Moneda=new Ext.form.ComboBox({
			name:'id_moneda_reporte',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			store:ds_moneda,
			filterCol:'MONEDA.nombre',
			queryParam:'filterValue_0',
			valueField:'id_moneda',
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_moneda,
			displayField:'nombre',
			triggerAction:'all',
			minChars:1,
			mode:'remote',
			width:220
		});
		
		tipoReporte=new Ext.form.ComboBox({
			name:'tipo_reporte',
			fieldLabel:'Tipo Reporte',
			vtype:'texto',
			emptyText:'Tipo Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['General'],['Periodo']]}),
			valueField:'valor',
			displayField:'valor',
			width:180
		});
		
		Formulario.fieldset({legend:'Parametros de Reporte'},Moneda,tipoReporte);
		Formulario.render("form-ct2_"+idContenedor)
	}
	
	function ocultarFrm(){ dlgFrm.hide() }
	
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
		Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
		ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
			
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			columnas:['95%'],
			grupos:[
				{tituloGrupo:'Oculto',columna:0,id_grupo:0},
				{tituloGrupo:'Datos',columna:0,id_grupo:1}		
			],
			height:300,		//altura
			width:500,		//anchura
			minHeight:200,	//altura
			minWidth:150,	//anchura	
			closable:true,
			titulo:'Justificación por Partida'			
		}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(unescape(params)));
		maestro.id_presupuesto=datos.m_id_presupuesto;
		maestro.id_parametro=datos.m_id_parametro;
		maestro.nombre_financiador=datos.m_nombre_financiador;
		maestro.nombre_regional=datos.m_nombre_regional;
		maestro.nombre_programa=datos.m_nombre_programa;
		maestro.nombre_proyecto=datos.m_nombre_proyecto;
		maestro.nombre_actividad=datos.m_nombre_actividad;
	 	maestro.desc_moneda=datos.m_desc_moneda;
	 	maestro.tipo_pres=datos.m_tipo_pres;
	 	maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.tipo_vista=datos.m_tipo_vista;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				 id_presupuesto:maestro.id_presupuesto,
				 id_moneda:maestro.id_moneda
			}
		};
		prueba.setValue(maestro.id_moneda);
		
		this.btnActualizar();		
		data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[3].defecto=maestro.id_presupuesto;

		paramFunciones.btnEliminar.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		paramFunciones.Save.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		paramFunciones.ConfirmSave.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		this.InitFunciones(paramFunciones)
		
		if(maestro.tipo_vista==2)
		{
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();		
		}
		else
		{
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();		
		}	
		
	};
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{						
			CM_ocultarGrupo('Oculto');	
			CM_mostrarGrupo('Datos');			
			CM_btnEdit();			
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}				
	}
	
	function btnMoneda()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect!=0)
		{
			dlgFrm.show();
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una Partida.');
		}
	}
	
	function btn_memoria_calculo()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
		   if(SelectionsRecord.data.tipo_memoria==3){ //inversion
			   	var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
				data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
				data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
				data+='&m_id_presupuesto='+maestro.id_presupuesto;
				data+='&m_id_parametro='+maestro.id_parametro;
			 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
				data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
				data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
				data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
				data+='&m_tipo_vista='+escape(maestro.tipo_vista);
				var ParamVentana={Ventana:{width:'70%',height:'90%'}}
				var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_inversion/memoria_calculo_inversion.php?'+data;
				layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
				layout_detalle_partida_formulacion.getVentana().on('resize',function(){
				layout_detalle_partida_formulacion.getLayout().layout()  });
		   }
		   else{
		   	  if(SelectionsRecord.data.tipo_memoria==4){ //pasaje
		   	  	var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
				data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
				data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
				data+='&m_id_presupuesto='+maestro.id_presupuesto;
				data+='&m_id_parametro='+maestro.id_parametro;
			 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
				data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
				data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
				data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
				data+='&m_tipo_vista='+escape(maestro.tipo_vista);
				var ParamVentana={Ventana:{width:'70%',height:'90%'}}
				var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_pasajes/memoria_calculo_pasajes.php?'+data;
				layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
				layout_detalle_partida_formulacion.getVentana().on('resize',function(){
				layout_detalle_partida_formulacion.getLayout().layout()  });
		   	  }
		   	  else{
		   	  	if(SelectionsRecord.data.tipo_memoria==5){//viaje
		   	  	  var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
				data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
				data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
				data+='&m_id_presupuesto='+maestro.id_presupuesto;
				data+='&m_id_parametro='+maestro.id_parametro;
			 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
				data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
				data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
				data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
				data+='&m_tipo_vista='+escape(maestro.tipo_vista);
				var ParamVentana={Ventana:{width:'70%',height:'90%'}}
				var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_viajes/memoria_calculo_viajes.php?'+data;
				layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
				layout_detalle_partida_formulacion.getVentana().on('resize',function(){
				layout_detalle_partida_formulacion.getLayout().layout()  });	
		   	  	}
		   	  	else{
		   	  		if(SelectionsRecord.data.tipo_memoria==9){//combustible
		   	  			var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
				data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
				data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
				data+='&m_id_presupuesto='+maestro.id_presupuesto;
				data+='&m_id_parametro='+maestro.id_parametro;
			 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
				data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
				data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
				data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
				data+='&m_tipo_vista='+escape(maestro.tipo_vista);
				var ParamVentana={Ventana:{width:'70%',height:'90%'}}
				var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_combustible/memoria_calculo_combustible.php?'+data;
				layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
				layout_detalle_partida_formulacion.getVentana().on('resize',function(){
				layout_detalle_partida_formulacion.getLayout().layout()  });
		   	  		}
		   	  		else{
		   	  			if(SelectionsRecord.data.tipo_memoria==7){ //servicio
		   	  				var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
							    data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
								data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
								data+='&m_id_presupuesto='+maestro.id_presupuesto;
								data+='&m_id_parametro='+maestro.id_parametro;
			 					data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
								data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 					data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 					data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 					data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 					data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 					data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 					data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
								data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
								data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
								data+='&m_tipo_vista='+escape(maestro.tipo_vista);
								var ParamVentana={Ventana:{width:'70%',height:'90%'}}
								var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_servicio/memoria_calculo_servicio.php?'+data;
								layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
								layout_detalle_partida_formulacion.getVentana().on('resize',function(){
								layout_detalle_partida_formulacion.getLayout().layout()  });
		   	  			}
		   	  			else{
		   	  				if(SelectionsRecord.data.tipo_memoria==6 || SelectionsRecord.data.tipo_memoria==8){//RRHH u Otros Gastos
		   	  				    var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
               	  			  data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
							  data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
							  data+='&m_id_presupuesto='+maestro.id_presupuesto;
							  data+='&m_id_parametro='+maestro.id_parametro;
			 				  data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
							  data+='&m_nombre_regional='+escape(maestro.nombre_regional);
			 				  data+='&m_nombre_programa='+escape(maestro.nombre_programa);
			 				  data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
			 				  data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
			 				  data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
			 				  data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
			 				  data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
							  data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
							  data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
							  data+='&m_tipo_vista='+escape(maestro.tipo_vista);
							  var ParamVentana={Ventana:{width:'70%',height:'90%'}}
							  var dir = direccion+'../../../../sis_presupuesto/vista/memoria_calculo_rrhh_gasto/memoria_calculo_rrhh_gasto.php?'+data;
							  layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
							  layout_detalle_partida_formulacion.getVentana().on('resize',function(){
							  layout_detalle_partida_formulacion.getLayout().layout()  });		
		   	  				}
		   	  				else{
		   	  					if(SelectionsRecord.data.tipo_memoria==2 ){  //Gastos por Item
								   	var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
									data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
									data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
									data+='&m_id_presupuesto='+maestro.id_presupuesto;
									data+='&m_id_parametro='+maestro.id_parametro;
								 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
									data+='&m_nombre_regional='+escape(maestro.nombre_regional);
								 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
								 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
								 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
								 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
								 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
								 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
									data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
									data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
									data+='&m_tipo_vista='+escape(maestro.tipo_vista);
									var ParamVentana={Ventana:{width:'70%',height:'90%'}}
									var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_gasto/memoria_calculo_gasto.php?'+data;
									layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
									layout_detalle_partida_formulacion.getVentana().on('resize',function(){
									layout_detalle_partida_formulacion.getLayout().layout()  });
							   }
							   else{
								   if(SelectionsRecord.data.tipo_memoria==1 ){  //Recursos
									   	var data='m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
										data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
										data+='&m_desc_moneda='+escape(SelectionsRecord.data.desc_moneda);
										data+='&m_id_presupuesto='+maestro.id_presupuesto;
										data+='&m_id_parametro='+maestro.id_parametro;
									 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
										data+='&m_nombre_regional='+escape(maestro.nombre_regional);
									 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
									 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
									 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
									 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
									 	data+='&m_tipo_pres='+escape(maestro.tipo_pres);			
									 	data+='&m_tipo_memoria='+escape(SelectionsRecord.data.tipo_memoria);			
										data+='&m_id_partida='+escape(SelectionsRecord.data.id_partida);			
										data+='&m_desc_partida='+escape(SelectionsRecord.data.codigo_partida+' - '+SelectionsRecord.data.desc_partida.replace(/^\s+/, "").replace(/\s+$/, ""));			
										data+='&m_tipo_vista='+escape(maestro.tipo_vista);
										var ParamVentana={Ventana:{width:'70%',height:'90%'}}
										var dir=direccion+'../../../../sis_presupuesto/vista/memoria_calculo_recurso/memoria_calculo_recurso.php?'+data;
										layout_detalle_partida_formulacion.loadWindows(dir,'Memoria de Cálculo',ParamVentana);
										layout_detalle_partida_formulacion.getVentana().on('resize',function(){
										layout_detalle_partida_formulacion.getLayout().layout()  });
								   }	
							   }
		   	  				}
		   	  			}
		   	  		}		   	  	  	
		   	  	 }		   	  	
		   	  }
		   }						
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_imprimir_memoria_calculo()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		 id_moneda_rep=Moneda.getValue();
		 tipoRep=tipoReporte.getValue();
		 
		dlgFrm.hide();
		
		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.total==0)
			{
				Ext.MessageBox.alert('...', 'La Partida seleccionada no tiene Memorias de Cálculo.')
			}
			else{
				//memoria gasto=2 
				if(SelectionsRecord.data.tipo_memoria==2){
				
			       var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			       data+='&id_presupuesto='+maestro.id_presupuesto;
		 	       data+='&nombre_financiador='+maestro.nombre_financiador;
			   	   data+='&nombre_regional='+maestro.nombre_regional;
		 	   	   data+='&nombre_programa='+maestro.nombre_programa;
		 	   	   data+='&nombre_proyecto='+maestro.nombre_proyecto;
		 	       data+='&nombre_actividad='+maestro.nombre_actividad;
		 	   	   data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
		 	   	   data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
			   	   data+='&id_partida='+SelectionsRecord.data.id_partida;
			   	   data+='&id_moneda='+id_moneda_rep;
			   	   data+='&tipo_reporte='+tipoRep;
			   	   			   	   
			   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoGasto.php?'+data)	
			     }
			    else
			    {
			    	//memoria recursos humanos=6
			    	if(SelectionsRecord.data.tipo_memoria==6){			   
				       var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
				       data+='&id_presupuesto='+maestro.id_presupuesto;
			 	       data+='&nombre_financiador='+maestro.nombre_financiador;
				   	   data+='&nombre_regional='+maestro.nombre_regional;
			 	   	   data+='&nombre_programa='+maestro.nombre_programa;
			 	   	   data+='&nombre_proyecto='+maestro.nombre_proyecto;
			 	       data+='&nombre_actividad='+maestro.nombre_actividad;
			 	   	   data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
			 	   	   data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
				   	   data+='&id_partida='+SelectionsRecord.data.id_partida;
				   	   data+='&id_moneda='+id_moneda_rep;
			   	       data+='&tipo_reporte='+tipoRep;
				   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoRRHH.php?'+data)	
				     }
				    else{
					   //memoria otros=8
				    	if(SelectionsRecord.data.tipo_memoria==8){		
				    		
					       var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
					       data+='&id_presupuesto='+maestro.id_presupuesto;
				 	       data+='&nombre_financiador='+maestro.nombre_financiador;
					   	   data+='&nombre_regional='+maestro.nombre_regional;
				 	   	   data+='&nombre_programa='+maestro.nombre_programa;
				 	   	   data+='&nombre_proyecto='+maestro.nombre_proyecto;
				 	       data+='&nombre_actividad='+maestro.nombre_actividad;
				 	   	   data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
				 	   	   data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
					   	   data+='&id_partida='+SelectionsRecord.data.id_partida;
					   	   data+='&id_moneda='+id_moneda_rep;
			   	           data+='&tipo_reporte='+tipoRep;
					   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoOtros.php?'+data)	
					     }
					    else{
					    	//memoria servicios	7
						   if(SelectionsRecord.data.tipo_memoria==7){
						   	  var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
					          data+='&id_presupuesto='+maestro.id_presupuesto;
				 	          data+='&nombre_financiador='+maestro.nombre_financiador;
					   	      data+='&nombre_regional='+maestro.nombre_regional;
				 	   	      data+='&nombre_programa='+maestro.nombre_programa;
				 	   	      data+='&nombre_proyecto='+maestro.nombre_proyecto;
				 	          data+='&nombre_actividad='+maestro.nombre_actividad;
				 	   	      data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
				 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
					   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
					   	      data+='&id_moneda='+id_moneda_rep;
			   	              data+='&tipo_reporte='+tipoRep;
					   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoServicio.php?'+data)
						   }
						   else{
							   //memoria recursos 1
							   if(SelectionsRecord.data.tipo_memoria==1){
							   	  var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
						          data+='&id_presupuesto='+maestro.id_presupuesto;
					 	          data+='&nombre_financiador='+maestro.nombre_financiador;
						   	      data+='&nombre_regional='+maestro.nombre_regional;
					 	   	      data+='&nombre_programa='+maestro.nombre_programa;
					 	   	      data+='&nombre_proyecto='+maestro.nombre_proyecto;
					 	          data+='&nombre_actividad='+maestro.nombre_actividad;
					 	   	      data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
					 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
						   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
						   	      data+='&id_moneda='+id_moneda_rep;
			   	                  data+='&tipo_reporte='+tipoRep;
						   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoIngreso.php?'+data)
							   }
							   else{
								   //memoria pasaje 4
								   if(SelectionsRecord.data.tipo_memoria==4){
								   	  var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
							          data+='&id_presupuesto='+maestro.id_presupuesto;
						 	          data+='&nombre_financiador='+maestro.nombre_financiador;
							   	      data+='&nombre_regional='+maestro.nombre_regional;
						 	   	      data+='&nombre_programa='+maestro.nombre_programa;
						 	   	      data+='&nombre_proyecto='+maestro.nombre_proyecto;
						 	          data+='&nombre_actividad='+maestro.nombre_actividad;
						 	   	      data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
						 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
							   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
							   	      data+='&id_moneda='+id_moneda_rep;
			   	                      data+='&tipo_reporte='+tipoRep;
							   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoPasaje.php?'+data)
								   }
								   else{
									   //memoria viaje 5
									   if(SelectionsRecord.data.tipo_memoria==5){
									   	  var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
								          data+='&id_presupuesto='+maestro.id_presupuesto;
							 	          data+='&nombre_financiador='+maestro.nombre_financiador;
								   	      data+='&nombre_regional='+maestro.nombre_regional;
							 	   	      data+='&nombre_programa='+maestro.nombre_programa;
							 	   	      data+='&nombre_proyecto='+maestro.nombre_proyecto;
							 	          data+='&nombre_actividad='+maestro.nombre_actividad;
							 	   	      data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
							 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
								   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
								   	      data+='&id_moneda='+id_moneda_rep;
			   	                          data+='&tipo_reporte='+tipoRep;
								   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoViaje.php?'+data)
									   }
									   else{
									   		//memoria de inversion 3
									   		if(SelectionsRecord.data.tipo_memoria==3){
												//alert(id_moneda_rep);
										       var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
										       data+='&id_presupuesto='+maestro.id_presupuesto;
									 	       data+='&nombre_financiador='+maestro.nombre_financiador;
										   	   data+='&nombre_regional='+maestro.nombre_regional;
									 	   	   data+='&nombre_programa='+maestro.nombre_programa;
									 	   	   data+='&nombre_proyecto='+maestro.nombre_proyecto;
									 	       data+='&nombre_actividad='+maestro.nombre_actividad;
									 	   	   data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
									 	   	   data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
										   	   data+='&id_partida='+SelectionsRecord.data.id_partida;
										   	   data+='&id_moneda='+id_moneda_rep;
										   	   data+='&tipo_reporte='+tipoRep;
										   	   			   	   
										   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoInversion.php?'+data)	
										     }
									   		else{
									   	   		//memoria de combustibles 9
									   			if(SelectionsRecord.data.tipo_memoria==9){
												//alert(id_moneda_rep);
										       		var data='id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
										       		data+='&id_presupuesto='+maestro.id_presupuesto;										       		
									 	       		data+='&nombre_financiador='+maestro.nombre_financiador;
										   	   		data+='&nombre_regional='+maestro.nombre_regional;
									 	   	   		data+='&nombre_programa='+maestro.nombre_programa;
									 	   	   		data+='&nombre_proyecto='+maestro.nombre_proyecto;
									 	       		data+='&nombre_actividad='+maestro.nombre_actividad;
									 	   	   		data+='&desc_unidad_organizacional='+maestro.desc_unidad_organizacional;
									 	   	   		data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;			
										   	   		data+='&id_partida='+SelectionsRecord.data.id_partida;
										   	   		data+='&id_moneda='+id_moneda_rep;
										   	   		data+='&tipo_reporte='+tipoRep;
										   	   			   	   
										   	   		window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoCombustible.php?'+data)	
										     	}
									   			else{
									   	   				Ext.MessageBox.alert('...', 'Solo partidas de ingreso, inversión, gasto, recursos humanos, servicios, viajes, pasajes, combustibles y otros.')
									   			}
									   		}
									   }	
								   }
							   }
						   }					    	
					    }
			    	}			    	
			    }
			}		
		}
		else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar una Partida.')
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	var prueba=new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			editable:false,
			tpl:tpl_id_moneda			
		});

		ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
	);
	
	prueba.on('select',
		function(){		
			
			ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros: paramConfig.CantFiltros,
				 id_presupuesto: maestro.id_presupuesto,
				 id_moneda: prueba.getValue()
			}
		};	
		data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',prueba.getValue()+". "+render_moneda(prueba.getValue())+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		ClaseMadre_btnActualizar()		
	});	
	
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_partida_formulacion.getLayout()};
	//para el manejo de hijos
	
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);		
	
	//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto

	var CM_getBoton=this.getBoton;	
	if(maestro.tipo_vista==2)
	{
		CM_getBoton('guardar-'+idContenedor).disable();
		CM_getBoton('editar-'+idContenedor).disable();		
	}
	else
	{
		CM_getBoton('guardar-'+idContenedor).enable();
		CM_getBoton('editar-'+idContenedor).enable();		
	}	
		
//Fin codigo de bloqueo de botones	
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Cálculo',btn_memoria_calculo,true,'memoria_calculo','Memoria de Cálculo');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el Detalle de la Memoria de Cálculo',btnMoneda,true,'imp_mem_calculo','Formulario de Memoria');
	
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	crearDialogMoneda();
	layout_detalle_partida_formulacion.getLayout().addListener('layout',this.onResize);
	layout_detalle_partida_formulacion.getVentana(idContenedor).on('resize',function(){layout_detalle_partida_formulacion.getLayout().layout()})

	layout_detalle_partida_formulacion.getVentana().addListener('beforehide',salta)
}