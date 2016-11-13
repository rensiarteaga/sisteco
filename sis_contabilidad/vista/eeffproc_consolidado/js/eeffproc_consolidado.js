/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaEEFFPeriodo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
	
	var	g_id_depto=1;
	var	g_id_codigo_depto='Ninguno';
	var g_departamento='';
	var	g_ids_depto='';
	var g_depto='';
	
	var	g_fecha=new Date();
	var g_fecha_ini=new Date();
	
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	
	var	g_nivel=2;
	var	g_sw_actualizacion='si';
	
	var	g_id_eeff=1;
	var g_id_eeff_desc ='Ninguno'

	var sw=0;	
	var g_mensaje= "";
			
	var monedas_for=new Ext.form.MonedaField({
		name:'mes_01',
		fieldLabel:'Enero',	
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
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff/ActionListarEEFFConsolidado.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nro_cuenta',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'nro_cuenta',
		'nombre_cuenta',
		'nro_cuenta_sigma',
		'nombre_cuenta_sigma',
		'depto_0',
		'depto_1',
		'depto_2',
		'depto_3',
		'depto_4',
		'depto_5',
		'depto_6',
		'depto_7',
		'depto_8',
		'depto_9',
		'depto_10',
		'depto_11',
		'depto_12',
		'depto_13',
		'depto_14',
		'depto_15',
		'depto_16',
		'depto_17',
		'depto_18',
		'depto_19',
		'depto_20',
		'depto_21',
		'depto_22',
		'depto_23',
		'depto_24',
		'depto_25',
		'depto_26',
		'depto_27',
		'depto_28',
		'depto_29',
		'depto_30',
		'total'
		]),remoteSort:false});
 
	//carga datos XML
 	/*crea los data store*/
	var ds_depto = 		new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?m_id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo','despliegue_rep']),remoteSort:true});	

	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto}</i></b>','</div>');	
	
	config_depto={nombre:'Depto',descripcion:'despliegue_rep',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	
	function menuBotones(){
	 	g_limit=paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
   		g_ids_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSelecion();
   		g_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSeleccionadosDesc();

		ds.baseParams={//start:0,
			limit: 10000,
			CantFiltros:g_CantFiltros,			
			id_parametro:g_id_parametro,
			id_reporte_eeff:g_id_eeff,
			fecha_trans:g_fecha,
			fecha_trans_ini:g_fecha_ini,
			id_moneda:g_id_moneda,
			nivel:g_nivel,
			sw_actualizacion:g_sw_actualizacion,
			ids_depto:g_ids_depto	
		};

		var data_maestro=[ ['EEFF ',g_id_eeff_desc ,'Detalle Nivel',g_nivel],
		                   ['Moneda',g_id_moneda_desc,'Actualización',g_sw_actualizacion],
		                   ['Gestión',g_id_parametro_desc,'Fecha','Del: '+g_fecha_ini+tabular(5)+' Al: '+g_fecha],
		                   ['Dpto(s)', g_depto]
						    ];
		// +tabular(44-g_id_parametro_desc.length)
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	// DEFINICIÓN DATOS DEL MAESTRO
	function  MaestroJulio(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
			for(i=0;i<data[j].length;i++){
				if(data[j]){
					if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
			}
			html=html+"</tr>";
		}
		html=html+"</table>";
		return html
	};
	
	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
		else return "  "
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[ ['EEFF ',g_id_eeff_desc ,'Detalle Nivel',g_nivel],
	                   ['Moneda',g_id_moneda_desc,'Actualización',g_sw_actualizacion],
	                   ['Gestión',g_id_parametro_desc,'Fecha','Del: '+g_fecha_ini+tabular(5)+' Al: '+g_fecha],
	                   ['Dpto(s)', g_depto]
					    ];
	
	//DATA STORE COMBOS
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
		 
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'Nro.Cuenta',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			//renderer: render_total,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nro_cuenta',
		save_as:'nro_cuenta'
	};
		
	Atributos[1]={
		validacion:{
			name:'nombre_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_cuenta',
		save_as:'nombre_cuenta'
	};
	
	Atributos[2]={
		validacion:{
			name:'nro_cuenta_sigma',
			fieldLabel:'Código SIGMA',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nro_cuenta_sigma',
		save_as:'nro_cuenta_sigma'
	};
	
	Atributos[3]={
		validacion:{
			name:'nombre_cuenta_sigma',
			fieldLabel:'Cuenta SIGMA',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:200,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_cuenta_sigma',
		save_as:'nombre_cuenta_sigma'
	};
	
	// txt depto_0
	Atributos[4]={
		validacion:{
			name:'depto_0',
			fieldLabel:'depto_0',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_0'
	}; 
	// txt depto_1
	Atributos[5]={
		validacion:{
			name:'depto_1',
			fieldLabel:'depto_1',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_1'
	};  
// txt depto_2
	Atributos[6]={
		validacion:{
			name:'depto_2',
			fieldLabel:'depto_2',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_2'
	}; 
// txt depto_3
	Atributos[7]={
		validacion:{
			name:'depto_3',
			fieldLabel:'depto_3',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_3'
	};
// txt depto_4
	Atributos[8]={
		validacion:{
			name:'depto_4',
			fieldLabel:'depto_4',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_4'
	};
 
// txt depto_5
	Atributos[9]={
		validacion:{
			name:'depto_5',
			fieldLabel:'depto_5',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_5'
	};
// txt depto_6
	Atributos[10]={
		validacion:{
			name:'depto_6',
			fieldLabel:'depto_6',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_6'
	};
// txt depto_7
	Atributos[11]={
		validacion:{
			name:'depto_7',
			fieldLabel:'depto_7',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_7'
	};
// txt depto_8
	Atributos[12]={
		validacion:{
			name:'depto_8',
			fieldLabel:'depto_8',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_8'
	};
// txt depto_9
	Atributos[13]={
		validacion:{
			name:'depto_9',
			fieldLabel:'depto_9',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_9'
	};
// txt depto_10
	Atributos[14]={
		validacion:{
			name:'depto_10',
			fieldLabel:'depto_10',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		 
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_10'
	};
// txt depto_11
	Atributos[15]={
		validacion:{
			name:'depto_11',
			fieldLabel:'depto_11',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_11'
	};
// txt depto_12
	Atributos[16]={
		validacion:{
			name:'depto_12',
			fieldLabel:'depto_12',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_12'
	};
// txt depto_13
	Atributos[17]={
		validacion:{
			name:'depto_13',
			fieldLabel:'depto_13',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_13'
	};
// txt depto_14
	Atributos[18]={
		validacion:{
			name:'depto_14',
			fieldLabel:'depto_14',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_14'
	};
	// txt depto_15
	Atributos[19]={
		validacion:{
			name:'depto_15',
			fieldLabel:'depto_15',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_15'
	};
 
	// txt depto_16
	Atributos[20]={
		validacion:{
			name:'depto_16',
			fieldLabel:'depto_16',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_16'
	};
	
	// txt depto_17
	Atributos[21]={
		validacion:{
			name:'depto_17',
			fieldLabel:'depto_17',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_17'
	};
	
	// txt depto_18
	Atributos[22]={
		validacion:{
			name:'depto_18',
			fieldLabel:'depto_18',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_18'
	};
	
	// txt depto_19
	Atributos[23]={
		validacion:{
			name:'depto_19',
			fieldLabel:'depto_19',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_19'
	};
	
	// txt depto_20
	Atributos[24]={
		validacion:{
			name:'depto_20',
			fieldLabel:'depto_20',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		 
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_20'
	};
	// txt depto_21
	Atributos[25]={
		validacion:{
			name:'depto_21',
			fieldLabel:'depto_21',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_21'
	};
	// txt depto_22
	Atributos[26]={
		validacion:{
			name:'depto_22',
			fieldLabel:'depto_22',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_22'
	};
	// txt depto_23
	Atributos[27]={
		validacion:{
			name:'depto_23',
			fieldLabel:'depto_23',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_23'
	};
	// txt depto_24
	Atributos[28]={
		validacion:{
			name:'depto_24',
			fieldLabel:'depto_24',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_24'
	};
	// txt depto_25
	Atributos[29]={
		validacion:{
			name:'depto_25',
			fieldLabel:'depto_25',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_25'
	};
	// txt depto_26
	Atributos[30]={
		validacion:{
			name:'depto_26',
			fieldLabel:'depto_26',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_26'
	};
	// txt depto_27
	Atributos[31]={
		validacion:{
			name:'depto_27',
			fieldLabel:'depto_27',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_27'
	};
	
	// txt depto_28
	Atributos[32]={
		validacion:{
			name:'depto_28',
			fieldLabel:'depto_28',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_28'
	};
	
	// txt depto_29
	Atributos[33]={
		validacion:{
			name:'depto_29',
			fieldLabel:'depto_29',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_29'
	};
	// txt depto_30
	Atributos[34]={
		validacion:{
			name:'depto_30',
			fieldLabel:'depto_30',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		 
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'depto_30'
	};
	//total
	Atributos[35]={
		validacion:{
			name:'total',
			fieldLabel:'TOTAL',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'total'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Estados Financieros - Consolidado',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	//var getComponente=this.getComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getColumnNum=this.getColumnNum;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	
	this.btnActualizar=function(){
		g_mensaje="";
		if (g_id_parametro_desc=="Ninguno"){g_mensaje += ' -Gestión'};
		if (g_id_eeff_desc=="Ninguno"){g_mensaje += ' -Estado Financiero'};
		if (g_id_moneda_desc=="Ninguno"){g_mensaje += ' -Moneda'};
		if (g_ids_depto==""){g_mensaje += ' -Departamento(s)'};
		
		if (g_mensaje==""){
			if (sw==0){ 
				ds.load({params:ds.baseParams,
						callback: ds_callback});
				sw =1;
			}else{ 
				ds.rejectChanges()//vacia el vector de records modificados
				ds.lastOptions.callback=ds_callback;
				ds.load(ds.lastOptions);//actualizar
				//ClaseMadre_btnActualizar(); 
			}
		}else{
			Ext.MessageBox.alert("Falta indicar: ", g_mensaje);
		}
	}
	
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	function btn_imprimir(){
		/*parametros reporte */	
		var data='start=0';
		data+='&limit=100000';
		data+='&CantFiltros='+g_CantFiltros;
		data+='&id_parametro='+g_id_parametro;
		data+='&id_reporte_eeff='+g_id_eeff;
		data+='&ids_depto='+g_ids_depto;
		data+='&fecha_trans='+g_fecha;
		data+='&fecha_trans_ini='+g_fecha_ini;
		data+='&id_moneda='+g_id_moneda;
		data+='&nivel='+g_nivel;
		data+='&sw_actualizacion='+g_sw_actualizacion;
		data+='&fecha_rep='+g_fecha;
		data+='&fecha_rep_ini='+g_fecha_ini;
		data+='&EEFF='+g_id_eeff_desc;					   
		data+='&desc_moneda='+g_id_moneda_desc;
		data+='&gestion='+g_id_parametro_desc;
		data+='&departamento='+g_depto;
		
		g_mensaje="";
		if (g_id_parametro_desc=="Ninguno"){g_mensaje += ' -Gestión'};
		if (g_id_eeff_desc=="Ninguno"){g_mensaje += ' -Estado Financiero'};
		if (g_id_moneda_desc=="Ninguno"){g_mensaje += ' -Moneda'};
		if (g_ids_depto==""){g_mensaje += ' -Departamento(s)'};
		
		if (g_mensaje==""){
			window.open(direccion+'../../../control/eeff/ActionEEFFConsolidado.php?'+data);
		}else{
			Ext.MessageBox.alert("Falta indicar: ", g_mensaje);
		}
 	}
	
	function ds_callback(){
		var record_inicio=ds.getAt(0);
		ds.remove(ds.getAt(0));
		
		for(i=0;i<record_inicio.fields.length-3;i++){
			if('no_definido'!==record_inicio.data["depto_"+i] ){
				ClaseMadre_getGrid().getColumnModel().setColumnHeader(ClaseMadre_getColumnNum("depto_"+i),record_inicio.data["depto_"+i]);
			}else{
				ClaseMadre_getGrid().getColumnModel().setHidden(ClaseMadre_getColumnNum("depto_"+i),true)
			}				
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_consolidacionPresupuesto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ds_depto.load({
		params:{
		start:0,
		limit: 1000000, //paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,
 		},
		callback: function(){padre.AdicionarMenuBoton(ds_depto,config_depto);}
	});
	
	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
	var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
	
	var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:false});
	var tpl_id_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
	
	//monedas
	var monedas =new Ext.form.ComboBox({
		store: ds_moneda_consulta,
		displayField:'nombre',
		typeAhead: false,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'moneda...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_moneda',
		tpl:tpl_id_moneda_reg
	});
	//parametro
	var parametro =new Ext.form.ComboBox({
		store: ds_parametro,
		displayField:'gestion_conta',
		typeAhead: false,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'gestión...',
		selectOnFocus:true,
		width:60,
		valueField: 'id_parametro',
		tpl:tpl_id_parametro_reg
	});
	
	var eeff =new Ext.form.ComboBox({
		store: ds_eeff,
		displayField:'nombre_eeff',
		typeAhead: false,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'EEFF...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_reporte_eeff',
		tpl:tpl_id_eeff
	});		
 
	var fecha=	new Ext.form.DateField({
		name:'fecha',
		fieldLabel:'Fecha EEFF',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '31/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Día no válido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});		

	var fecha_ini=	new Ext.form.DateField({
		name:'fecha_ini',
		fieldLabel:'Fecha Inicial EEFF ',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '31/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Día no válido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});	
						
	var nivel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4'],['5','N - 5'],['6','N - 6'],['7','N - 7'],['8','N - 8']]}),typeAhead: false,mode: 'local',triggerAction: 'all',emptyText:'nivel...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
	var sw_actualizacion =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','Con Actualización'],['no','Sin Actualización']]}),typeAhead: false,mode: 'local',triggerAction: 'all',emptyText:'SW...',selectOnFocus:true,width:100,valueField:'ID',displayField:'valor',mode:'local'});		
	
	ds_parametro.load({params:{start:0,limit: 1000000}});
 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
 	ds_eeff.load({params:{start:0,limit: 1000000}});

	parametro.on('select',function (combo, record, index){
		g_id_parametro=parametro.getValue();
		g_id_parametro_desc=record.data['desc_gestion'];
		var dte_fecha_ini_valid=new Date('01/01/'+g_id_parametro_desc+' 00:00:00');
		var dte_fecha_fin_valid=new Date('12/31/'+g_id_parametro_desc+' 00:00:00');
		
		fecha_ini.minValue=dte_fecha_ini_valid; //Fecha inicio
		fecha_ini.maxValue=dte_fecha_fin_valid;
		fecha.minValue=dte_fecha_ini_valid;
		fecha.maxValue=dte_fecha_fin_valid;
			
		//Define un valor por defecto
		fecha_ini.setValue(dte_fecha_ini_valid);
		fecha.setValue(dte_fecha_fin_valid);
		g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
		g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
		menuBotones()
	});
	
	eeff.on('select',function (combo, record, index){g_id_eeff=eeff.getValue();g_id_eeff_desc=record.data['nombre_eeff'];menuBotones()});		
	
	fecha.on('change',function (){
		g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
        menuBotones()});
	
	fecha_ini.on('change',function (){
		g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
        menuBotones()});
	
	monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
	nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();menuBotones()});
	sw_actualizacion.on('select',function (combo, record, index){g_sw_actualizacion=sw_actualizacion.getValue();menuBotones()});
		
	parametro.setValue(1);
	eeff.setValue(1);
	fecha.setValue(new Date);
	fecha_ini.setValue(new Date);
	monedas.setValue(1);
	nivel.setValue(2);
	sw_actualizacion.setValue('con_actualizacion');
									
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte ',btn_imprimir,true,'imprimir','');	
	this.AdicionarBotonCombo(parametro,'gestion');		
	this.AdicionarBotonCombo(eeff,'EEFF');		
	this.AdicionarBotonCombo(fecha_ini,'Fecha Inicio');		
	this.AdicionarBotonCombo(fecha,'Fecha');		
	this.AdicionarBotonCombo(monedas,'monedas');														
	this.AdicionarBotonCombo(nivel,'nivel');														
	this.AdicionarBotonCombo(sw_actualizacion,'Actualización');														
																												
	layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
}