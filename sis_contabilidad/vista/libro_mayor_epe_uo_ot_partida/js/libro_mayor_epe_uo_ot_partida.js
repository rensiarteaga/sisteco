/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2008-07-18 11:04:06
 */
function paginaMayorEpeUpOtPartida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
	var	g_id_eeff=1;
	var	g_id_eeff_desc='Ninguno';
	var	g_id_depto=1;
	var	g_id_codigo_depto='Ninguno';
	
	var	g_fecha=new Date();
	var	g_fecha_rep=new Date();
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=2;
	var g_id_eeff_desc ='Ninguno';
	
	var	g_ids_depto='';
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';

 	var g_depto='';
 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';

	var g_desc_moneda=maestro.desc_moneda;

	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	var g_departamento='';
	
	/****************/
	var var_desc_id_gestion='';	
	var var_desc_id_depto='';	
	var var_desc_fecha_inicio='';	
	var var_desc_fecha_final='';	
	var var_desc_sw_partida='';	
	var var_desc_sw_epe='';	
	var var_desc_sw_uo='';	
	var var_desc_sw_ot='';	
	var var_desc_id_partida_inicial='';	
	var var_desc_id_partida_final='';	
	var var_desc_id_epe_inicial='';	
	var var_desc_id_epe_final='';	
	var var_desc_id_uo_inicial='';	
	var var_desc_id_uo_final='';	
	var var_desc_id_ot_inicial='';	
	var var_desc_id_ot_final='';	
	var var_desc_estado_cbte='';
	var var_desc_sw_actualizacion='';
	var var_desc_moneda='';
	
	var var_id_gestion;	
	var var_id_depto;
	var var_fecha_inicio;
	var var_fecha_final;
	var var_sw_partida;
	var var_sw_epe;
	var var_sw_uo;
	var var_sw_ot;
	var var_id_partida_inicial;
	var var_id_partida_final;
	var var_id_epe_inicial;
	var var_id_epe_final;
	var var_id_uo_inicial;
	var var_id_uo_final;
	var var_id_ot_inicial;
	var var_id_ot_final;
	var var_estado_cbte;
	var var_sw_actualizacion='';	
	var var_id_moneda='';	
	
	var comp_id_gestion;	
	
	var comp_id_depto;
	var comp_fecha_inicio;
	var comp_fecha_final;
	var comp_estado_cbte;
	var comp_sw_actualizacion;
	var comp_id_moneda;
	var comp_sw_partida;
	var comp_sw_epe;
	var comp_sw_uo;
	var comp_sw_ot;
	var comp_id_partida_inicial;
	var comp_id_partida_final;
	var comp_id_epe_inicial;
	var comp_id_epe_final;
	var comp_id_uo_inicial;
	var comp_id_uo_final;
	var comp_id_ot_inicial;
	var comp_id_ot_final;
	/****************/
	 
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/mayorEpeUoOtPartida/mayorEpeUoOtPartida.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tt_tct_reporte_uo_epe_ot_par',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_tt_tct_reporte_uo_epe_ot_par', 
		'id_reporte', 
		'id_transaccion', 
		{name: 'fecha_cbte',type:'date',dateFormat:'d-m-Y'},
		//'fecha_cbte',
		'nro_cbte', 
		'concepto_cbte', 
		'desc_componentes', 
		'importe_debe', 
		'importe_haber', 
		'importe_gasto', 
		'importe_recurso',
		'saldo',
		//formulario
		'id_gestion',
		'id_depto',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
		'sw_partida',
		'sw_epe',
		'sw_uo',
		'sw_ot',
		'id_partida_inicial',
		'id_partida_final',
		'id_epe_inicial',
		'id_epe_final',
		'id_uo_inicial',
		'id_uo_final',
		'id_ot_inicial',
		'id_ot_final',
		'sw_estado_cbte',
		'sw_listado',
		'id_moneda',
		'estado_cbte'
		 
		]),remoteSort:true});
 
	//carga datos XML

	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_gestion',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta','desc_gestion',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
		});
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestion: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Esatdo: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda_cbte']);}
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
		});
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
				
	
	function render_tipo(value, p, record)
	{	if(value=='rango'){return 'RANGO';}
		if(value=='detalle'){return 'DETALLE';}
		if(value=='cabecera'){return 'CABECERA';}
	}

	var ds_componete_partida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mayorEpeUoOtPartida/mayorComponentes.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_uo_epe_ot_par',totalRecords:'TotalCount'},['id_uo_epe_ot_par','codigo','nombre','codigo_nombre'])});
	function render_componente_partida(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_partida=new Ext.Template('<div class="search-item">','<b>Componente: </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	var ds_componete_epe=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mayorEpeUoOtPartida/mayorComponentes.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_uo_epe_ot_par',totalRecords:'TotalCount'},['id_uo_epe_ot_par','codigo','nombre','codigo_nombre'])});
	function render_componente_epe(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_epe=new Ext.Template('<div class="search-item">','<b>Componente: </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	var ds_componete_uo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mayorEpeUoOtPartida/mayorComponentes.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_uo_epe_ot_par',totalRecords:'TotalCount'},['id_uo_epe_ot_par','codigo','nombre','codigo_nombre'])});
	function render_componente_uo(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_uo=new Ext.Template('<div class="search-item">','<b>Componente: </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	var ds_componete_ot=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mayorEpeUoOtPartida/mayorComponentes.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_uo_epe_ot_par',totalRecords:'TotalCount'},['id_uo_epe_ot_par','codigo','nombre','codigo_nombre'])});
	function render_componente_ot(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_ot=new Ext.Template('<div class="search-item">','<b>Componente: </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
 	//carga datos XML
	
	// DEFINICI�N DATOS DEL MAESTRO
	function MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;

		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};

		var  html="";
		for(j=0;j<data.length;j++){
			html=html+"<table class='izquierda_auto'>";
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
			
			for(i=0;i<data[j].length;i++){
				if(data[j])
					{
					if(i%2!=0){html=html+"<td class='izquierda_auto'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
					}
					}
			html=html+"</tr>";
			html=html+"</table>";
		}
	 
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

	var data_maestro=[ ['Departamento','',
	 					'Gestion','',
	 					'Fecha Inicio','',
	 					'Fecha Fin','',],
					   ['Partida','','Inicial','','Final',''] ,
					   ['E.P.E.','','Inicial','','Final','','U.O.','','Inicial','','Final','','O.T.','','Inicial','','Final','']
					    ];

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

   
	//FUNCIONES RENDER
	
	function render_id_partida(value,cell,record,row,colum,store)
	{	if(store.getAt(row).data['sw_transaccional'] == 1){
		return  '<span style="color:green;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
		}
		
		if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre>')}
 	};

	function renderSwCabecera(value,cell,record,row,colum,store)
	{	if(store.getAt(row).data['nro_cbte'] == 0){
		return  '<span style="color:green;"><pre><font face="Arial">'+record.data['id_reporte']+'</font></pre></span>'
		}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['id_reporte']+'</font></pre>')}
	};
	
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
	var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

	function renderTipoMemoria(value, p, record){
		if(value == 1){return  "Recursos"}
		if(value == 2){return "Gastos"}
		if(value == 3){return "Inversiones"}
		if(value == 4){return "Viajes"}
		if(value == 5){return "RRHH"}
		if(value == 6){return "OTROS"}
	}		
	
	function renderSwTranssacional(value,cell,record,row,colum,store){
		if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:green;">' +value+'</span>'}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return value}
	}	
		 
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posici�n 0 siempre esta la llave primaria

    var var_fecha=new Date();
    var fecha =var_fecha?var_fecha.dateFormat('m/d/Y'):'';
	var_fecha_inicio=fecha;
	var_fecha_final=fecha;
	var_estado_cbte=1;
 	var_sw_actualizacion='si';
 	var_id_moneda=1;
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tt_tct_reporte_uo_epe_ot_par',
			inputType:'hidden',
			allowBlank:true,
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		id_grupo:0,
		save_as:'id_tt_tct_reporte_uo_epe_ot_par'
	} ; 
		
	Atributos[1]={
		validacion:{
			labelSeparator:'id_transaccion',
			name: '',
			inputType:'hidden',
			allowBlank:true,
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		id_grupo:0,
		form: false,
		filtro_0:false,
		save_as:'id_transaccion'
	} ;
 
	
	Atributos[2]={
		validacion:{
			name:'id_reporte',
			fieldLabel:'Reporte',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			renderer: renderSwCabecera,
			disable:false		
		},
		tipo: 'TextField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'id_reporte',
		save_as:'id_reporte'
	};

    Atributos[3]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha Transaccion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:80,
			disabled:false
		},
		form:false,
		tipo:'DateField',
		id_grupo:0,
		dateFormat:'m-d-Y',
		defecto:'',
		filtro_0:true,
		filterColValue:'fecha_cbte',
		save_as:'fecha_cbte'
	};
	
	Atributos[4]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Nro. Comprobante',
			allowBlank:true,
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
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'nro_cbte',
		save_as:'nro_cbte'
	};	
		
	Atributos[5]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Comprobante',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'50%',
			disable:false		
		},
		tipo: 'TextField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'concepto_cbte',
		save_as:'concepto_cbte'
	};	
	Atributos[6]={
		validacion:{
			name:'desc_componentes',
			fieldLabel:'Componentes',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'desc_componentes',
		save_as:'desc_componentes'
	};
 
	Atributos[7]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'DEBE',
			allowBlank:true,
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
			//renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'importe_debe',
		save_as:'importe_debe'
	};	
	
	Atributos[8]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'HABER',
			allowBlank:true,
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
			//renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'importe_haber',
		save_as:'importe_haber'
	};
// txt mes_02
	Atributos[9]={
		validacion:{
			name:'saldo',
			fieldLabel:'Importe',
			allowBlank:true,
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
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		id_grupo:0,
		form: false,
		filtro_0:true,
		filterColValue:'saldo',
		save_as:'saldo'
	};
	
	// txt id_parametro
		Atributos[10]={
			validacion:{
				name:'id_parametro',
				fieldLabel:'Gestion',
				allowBlank:true,
				emptyText:'Gestion...',
				desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_parametro,
				valueField: 'id_gestion',
				displayField: 'gestion_conta',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:true,
				tpl:tpl_id_parametro,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_parametro,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:3

			},
			tipo:'ComboBox',
			id_grupo:1,
			form: true,
			filtro_0:false,
			save_as:'id_parametro'
		};
	
		Atributos[11]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Departamento Contable',
				allowBlank:false,
				emptyText:'Departamento...',
				desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:'80%',
				//	onSelect:function(record){},
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto,
				grid_visible:false,
				grid_editable:false,
				width_grid:220,
				width:300,
				disabled:false,
				grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			filtro_0:false,
			save_as:'id_depto',
		};
		// txt fecha_inicio
		Atributos[12]= {
			validacion:{
				name:'fecha_inicio',
				fieldLabel:'Fecha Inicio',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				disabledDaysText: 'D�a no v�lido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			id_grupo:1,
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			defecto:new Date(),
			save_as:'fecha_inicio'
		};
		// txt fecha_final
		Atributos[13]= {
			validacion:{
				name:'fecha_final',
				fieldLabel:'Fecha Final',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				disabledDaysText: 'D�a no v�lido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			id_grupo:1,
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			defecto:new Date(),
			save_as:'fecha_final'
		};
		Atributos[14]={
			validacion:{
				name:'estado_cbte',
				fieldLabel:'Estado Comprobante',
				allowBlank:false,
				align:'left',
				emptyText:'Esta...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','VALIDADO'],['2','BORRADOR'],['3','EDICION']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:1,
			defecto:1,
			form: true,
			save_as:'estado_cbte'
	 };		
	 Atributos[15]={
			validacion:{
				name:'sw_partida',
				fieldLabel:'SW Partida',
				allowBlank:false,
				align:'left',
				emptyText:'Ran...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:2,
			form: true,
			save_as:'sw_partida'
		};
		Atributos[16]={
			validacion:{
				name:'sw_auxiliar',
				fieldLabel:'SW Auxiliar',
				allowBlank:false,
				align:'left',
				emptyText:'Ran...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:3,
			form: true,
			save_as:'sw_auxiliar'
		};
		 Atributos[17]={
			validacion:{
				name:'sw_epe',
				fieldLabel:'SW EPE',
				allowBlank:false,
				align:'left',
				emptyText:'Ran...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:4,
			form: true,
			save_as:'sw_epe'
		};
		Atributos[18]={
			validacion:{
				name:'sw_uo',
				fieldLabel:'SW UO',
				allowBlank:false,
				align:'left',
				emptyText:'Ran...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:5,
			form: true,
			save_as:'sw_uo'
		};
		Atributos[19]={
			validacion:{
				name:'sw_ot',
				fieldLabel:'SW OT',
				allowBlank:false,
				align:'left',
				emptyText:'Ran...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:6,
			form: true,
			save_as:'sw_ot'
		};
		
	Atributos[20]={
		validacion:{
				fieldLabel:'Inicial',
				allowBlank:true,
				emptyText:'Partida Inicial...',
				name:'id_partida_inicial',
				desc:'nombre',
				store:ds_componete_partida,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_partida,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_partida,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:2,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_partida_inicial'
	};	
	Atributos[21]={
		validacion:{
				fieldLabel:'Final',
				allowBlank:true,
				emptyText:'Partida final...',
				name:'id_partida_final',
				desc:'nombre',
				store:ds_componete_partida,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_partida,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_partida,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:2,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_partida_final'
	};	
	
	Atributos[22]={
		validacion:{
				fieldLabel:'Inicial',
				allowBlank:true,
				emptyText:'Auxiliar Inicial...',
				name:'id_auxiliar_inicial',
				desc:'nombre',
				store:ds_componete_auxiliar,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_auxiliar,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_auxiliar,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:3,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_auxiliar_inicial'
	};	
	Atributos[23]={
		validacion:{
				fieldLabel:'Final',
				allowBlank:true,
				emptyText:'Auxliar final...',
				name:'id_auxiliar_final',
				desc:'nombre',
				store:ds_componete_auxiliar,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_auxiliar,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_auxiliar,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:3,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_auxiliar_final'
	};
	Atributos[24]={
		validacion:{
				fieldLabel:'Inicial',
				allowBlank:true,
				emptyText:'EPE Inicial...',
				name:'id_epe_inicial',
				desc:'nombre',
				store:ds_componete_epe,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_epe,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_epe,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:4,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_epe_inicial'
	};	
	Atributos[25]={
		validacion:{
				fieldLabel:'Final',
				allowBlank:true,
				emptyText:'EPE final...',
				name:'id_epe_final',
				desc:'nombre',
				store:ds_componete_epe,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_epe,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_epe,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:4,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_epe_final'
	};	
	Atributos[26]={
		validacion:{
				fieldLabel:'Inicial',
				allowBlank:true,
				emptyText:'UO Inicial...',
				name:'id_uo_inicial',
				desc:'nombre',
				store:ds_componete_uo,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_uo,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_uo,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:5,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_uo_inicial'
	};	
	Atributos[27]={
		validacion:{
				fieldLabel:'Final',
				allowBlank:true,
				emptyText:'UO final...',
				name:'id_uo_final',
				desc:'nombre',
				store:ds_componete_uo,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_uo,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_uo,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:5,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_uo_final'
	};
		Atributos[28]={
		validacion:{
				fieldLabel:'Inicial',
				allowBlank:true,
				emptyText:'OT Inicial...',
				name:'id_ot_inicial',
				desc:'nombre',
				store:ds_componete_ot,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_ot,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_ot,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:6,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_ot_inicial'
	};	
	Atributos[29]={
		validacion:{
				fieldLabel:'Final',
				allowBlank:true,
				emptyText:'OT final...',
				name:'id_ot_final',
				desc:'nombre',
				store:ds_componete_ot,
				valueField:'id_uo_epe_ot_par',
				displayField:'codigo_nombre',
				queryParam:'filterValue_0',
				filterCol:'codigo#nombre',
				tpl:tpl_componente_ot,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:5,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_componente_ot,
				grid_visible:false,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			id_grupo:6,
			filtro_0:false,
	 		form: true,
	 		save_as:'id_ot_final'
	};
	Atributos[30]={
			validacion:{
				name:'sw_actualizacion',
				fieldLabel:'SW Actualizaci�n',
				allowBlank:false,
				align:'left',
				emptyText:'Esta...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','CON ACTUALIZACI�N'],['no','SIN ACTUALIZACION']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				grid_visible:false,
				renderer:render_tipo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:1,
			defecto:'si',
			form: true,
			save_as:'sw_actualizacion'
	 };	
		Atributos[31]={
			validacion:{
				name:'id_moneda',
				fieldLabel:'Moneda',
				allowBlank:true,
				emptyText:'Moneda...',
				desc: 'nombre_moneda_cbte', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:false,
				tpl:tpl_id_moneda_reg,
				forceSelection:true,
				mode:'remote',
				queryDelay:200,
				pageSize:10,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_moneda,
				grid_visible:false,
				grid_editable:false,
				width_grid:150,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			defecto:1,
			filterColValue:'',
			id_grupo:1,
			save_as:'id_moneda'
		};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Libro Mayor (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	var getComponente=this.getComponente;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
 	var ClaseMadre_btnActualizar=this.btnActualizar;

	//DEFINICI�N DE LA BARRA DE MEN�
	var paramMenu={
		/*guarar:{crear:true,separador:false},*/
		nuevo:{crear:true,separador:true},
		/*editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	 
	//DEFINICI�N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	
	var paramFunciones={
	Save:{url:direccion+'../../../control/mayorEpeUoOtPartida/mayorEpeUoOtPartida.php'},
	
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:600,minWidth:150,minHeight:200,	closable:true,titulo:'Libro Mayor',
	 
	grupos:[{tituloGrupo:'Datos Ocultos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Cabecera',columna:0,id_grupo:1},
			{tituloGrupo:'partida',columna:0,id_grupo:2},
			{tituloGrupo:'Auxiliar',columna:0,id_grupo:3},
			{tituloGrupo:'E.P.E.',columna:0,id_grupo:4},
			{tituloGrupo:'U.O.',columna:0,id_grupo:5},
			{tituloGrupo:'O.T.',columna:0,id_grupo:6}]}};
	 
	
	//-------------- Sobrecarga de funciones --------------------//
 
	function initMayorEpeUpOtPartida(){
	
		comp_id_gestion=ClaseMadre_getComponente('id_parametro');
		comp_id_depto=ClaseMadre_getComponente('id_depto');
		comp_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		comp_fecha_final=ClaseMadre_getComponente('fecha_final');
		comp_estado_cbte=ClaseMadre_getComponente('estado_cbte');
		comp_sw_actualizacion=ClaseMadre_getComponente('sw_actualizacion');
		comp_id_moneda=ClaseMadre_getComponente('id_moneda');
			
		comp_sw_partida=ClaseMadre_getComponente('sw_partida');
		comp_sw_epe=ClaseMadre_getComponente('sw_epe');
		comp_sw_uo=ClaseMadre_getComponente('sw_uo');
		comp_sw_ot=ClaseMadre_getComponente('sw_ot');
		
		comp_id_partida_inicial=ClaseMadre_getComponente('id_partida_inicial');
		comp_id_partida_final=ClaseMadre_getComponente('id_partida_final');
			
		comp_id_epe_inicial=ClaseMadre_getComponente('id_epe_inicial');
		comp_id_epe_final=ClaseMadre_getComponente('id_epe_final');
	
		comp_id_uo_inicial=ClaseMadre_getComponente('id_uo_inicial');
		comp_id_uo_final=ClaseMadre_getComponente('id_uo_final');
		
		comp_id_ot_inicial=ClaseMadre_getComponente('id_ot_inicial');
		comp_id_ot_final=ClaseMadre_getComponente('id_ot_final');

		comp_id_gestion.on('select',f_almacenar_gestion);	
		comp_id_depto.on('select',f_almacenar_depto);	
		comp_fecha_inicio.on('blur',f_almacenar_inicio);
		comp_fecha_final.on('blur',f_almacenar_final);
		comp_estado_cbte.on('select',f_almacenar_estado_cbte);	
		comp_sw_actualizacion.on('select',f_almacenar_sw_actualizacion);	
		comp_id_moneda.on('select',f_almacenar_id_moneda);	
				
		comp_sw_partida.on('select',f_almacenar_sw_partida);	
		comp_id_partida_inicial.on('select',f_almacenar_partida_inicial);	
		comp_id_partida_final.on('select',f_almacenar_partida_final);	
		
		comp_sw_auxiliar.on('select',f_almacenar_sw_auxiliar);	
		comp_id_auxiliar_inicial.on('select',f_almacenar_auxiliar_inicial);	
		comp_id_auxiliar_final.on('select',f_almacenar_auxiliar_final);	
		
		comp_sw_epe.on('select',f_almacenar_sw_epe);	
		comp_id_epe_inicial.on('select',f_almacenar_epe_inicial);	
		comp_id_epe_final.on('select',f_almacenar_epe_final);	
		
		comp_sw_uo.on('select',f_almacenar_sw_uo);	
		comp_id_uo_inicial.on('select',f_almacenar_uo_inicial);	
		comp_id_uo_final.on('select',f_almacenar_uo_final);	
		
		comp_sw_ot.on('select',f_almacenar_sw_ot);	
		comp_id_ot_inicial.on('select',f_almacenar_ot_inicial);	
		comp_id_ot_final.on('select',f_almacenar_ot_final);	
		
		CM_getDialog().buttons[2].hide();
		CM_getDialog().buttons[1].hide();
		CM_getDialog().buttons[1].setText("");
		CM_getDialog().buttons[2].setText("");
		CM_getDialog().buttons[0].setText("Enviar");
		CM_getDialog().buttons[0].handler=function (){
									ds.baseParams={
												start:0,
												limit: paramConfig.TamanoPagina,
												CantFiltros:paramConfig.CantFiltros,
												id_gestion: var_id_gestion,
												id_depto: var_id_depto,
												fecha_inicio: var_fecha_inicio,
												fecha_final: var_fecha_final,
												sw_partida: var_sw_partida,
												sw_auxiliar: var_sw_auxiliar,
												sw_epe: var_sw_epe,
												sw_uo: var_sw_uo,
												sw_ot: var_sw_ot,
												id_partida_inicial: var_id_partida_inicial,
												id_partida_final: var_id_partida_final,
												id_auxiliar_inicial: var_id_auxiliar_inicial,
												id_auxiliar_final: var_id_auxiliar_final,
												id_epe_inicial: var_id_epe_inicial,
												id_epe_final: var_id_epe_final,
												id_uo_inicial: var_id_uo_inicial,
												id_uo_final: var_id_uo_final,
												id_ot_inicial: var_id_ot_inicial,
												id_ot_final: var_id_ot_final,
												sw_estado_cbte: var_estado_cbte,
												sw_actualizacion: var_sw_actualizacion,
												id_moneda: var_id_moneda
											};
									CM_getDialog().hide(); 
		}
	}

	this.btnNew=function(){
		CM_ocultarGrupo('Datos Ocultos');
		
		CM_mostrarComponente(comp_sw_partida);
		CM_mostrarComponente(comp_sw_epe);
		CM_mostrarComponente(comp_sw_uo);
		CM_mostrarComponente(comp_sw_ot);
		ClaseMadre_btnNew();
		
		comp_id_gestion.setValue(var_id_gestion);	
		comp_id_depto.setValue(var_id_depto);

		comp_fecha_inicio.setValue(var_desc_fecha_inicio);
		comp_fecha_final.setValue(var_desc_fecha_final);
		 
		var_id_partida_inicial='';
		var_id_partida_final='';
		var_id_epe_inicial='';
		var_id_uo_inicial='';
		var_id_uo_final='';
		var_id_ot_inicial='';
		var_id_ot_final='';	 
	};

	this.btnActualizar=function(){
		if (sw==0){ 
			ds.load({params:ds.baseParams });
			sw =1;
			}
		else{  
			ClaseMadre_btnActualizar(); 
			}
	}

	function limpiarCamposEPE_UO_OT_Partida(){
		comp_sw_partida.setValue('');
		comp_sw_epe.setValue('');
		comp_sw_uo.setValue('');
		comp_sw_ot.setValue('');
		
	 	CM_ocultarComponente(comp_id_partida_inicial);
	 	comp_id_partida_inicial.setValue('');
		comp_id_partida_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_partida_final);
		comp_id_partida_final.setValue('');
		comp_id_partida_final.allowBlank=true;

		CM_ocultarComponente(comp_id_epe_inicial);
		comp_id_epe_inicial.setValue('');
		comp_id_epe_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_epe_final);
		comp_id_epe_final.setValue('');
		comp_id_epe_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_uo_inicial);
		comp_id_uo_inicial.setValue('');
		comp_id_uo_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_uo_final);
		comp_id_uo_final.setValue('');
		comp_id_uo_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_ot_inicial);
		comp_id_ot_inicial.setValue('');
		comp_id_ot_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_ot_final);
		comp_id_ot_final.setValue('');
		comp_id_ot_final.allowBlank=true;
		
		var_sw_partida='';
		var_sw_epe='';
		var_sw_uo='';
		var_sw_ot='';
		var_id_partida_inicial='';
		var_id_partida_final='';
		var_id_epe_inicial='';
		var_id_epe_final='';
		var_id_uo_inicial='';
		var_id_uo_final='';
		var_id_ot_inicial='';
		var_id_ot_final=''; 		
	}

	function f_actualizarMaestro(){
	
	 	var data_maestro=[ ['Departamento',var_desc_id_depto,
	 					'Gestion',var_desc_id_gestion,
	 					'Fecha Inicio',var_desc_fecha_inicio,
	 					'Fecha Fin',var_desc_fecha_final],
					   ['Partida',var_desc_sw_partida,'Inicial',var_desc_id_partida_inicial,'Final',var_desc_id_partida_final ],
					   ['E.P.E.',var_desc_sw_epe,'Inicial',var_desc_id_epe_inicial,'Final',var_desc_id_epe_final,'U.O.',var_desc_sw_uo,'Inicial',var_desc_id_uo_inicial,'Final',var_desc_id_epe_final,'O.T.',var_desc_sw_ot,'Inicial',var_desc_id_ot_inicial,'Final',var_desc_id_ot_final]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));	
	}
	
	function f_almacenar_gestion( combo, record, index ){
		var_id_gestion=record.data.id_gestion;
		limpiarCamposEPE_UO_OT_Partida();
		
		var_desc_id_gestion=record.data.desc_gestion;
		f_actualizarMaestro();
	}
	
	function f_almacenar_depto( combo, record, index ){
		var_id_depto=record.data.id_depto;
		limpiarCamposEPE_UO_OT_Partida();
		var_desc_id_depto=record.data.nombre_depto;
		f_actualizarMaestro();
	}
	
	function f_almacenar_inicio(comboData){
		var fecha =comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('m/d/Y'):'';
		var_fecha_inicio=fecha;
		limpiarCamposEPE_UO_OT_Partida();
		var_desc_fecha_inicio=comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('d/m/Y'):'';
		f_actualizarMaestro();
	}
	
	function f_almacenar_final(comboData){
		var fecha =comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('m/d/Y'):'';
		var_fecha_final=fecha;
		limpiarCamposEPE_UO_OT_Partida();
		var_desc_fecha_final=comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('d/m/Y'):'';
		f_actualizarMaestro();
	}
	
	function f_almacenar_estado_cbte( combo, record, index ){
		var_estado_cbte=record.data.ID;
		limpiarCamposEPE_UO_OT_Partida();
		
		var_desc_estado_cbte=record.data.ID;
		f_actualizarMaestro();	
	}
	
	function f_almacenar_sw_actualizacion( combo, record, index ){
		var_sw_actualizacion=record.data.ID;
		limpiarCamposEPE_UO_OT_Partida();
		var_desc_sw_actualizacion=record.data.ID;
		f_actualizarMaestro();	
	}
	
	function f_almacenar_id_moneda( combo, record, index ){ 
		var_id_moneda=record.data.id_moneda;
		 
		limpiarCamposEPE_UO_OT_Partida();
		var_desc_moneda=record.data.simbolo;
		f_actualizarMaestro();
	}
	
	function f_almacenar_sw_partida( combo, record, index ){
		var_sw_partida=record.data.ID;
	
		var_desc_sw_partida=record.data.ID;
		var_desc_id_partida_inicial='';
		var_desc_id_partida_final='';
		
		f_actualizarMaestro(); 
		
		if(var_sw_partida=='rango'){
			 comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'partida',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final};
		 	comp_id_partida_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_partida_inicial);
			CM_mostrarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=false;
			comp_id_partida_final.allowBlank=false;
		}
		else{
			CM_ocultarComponente(comp_id_partida_inicial);
			CM_ocultarComponente(comp_id_partida_final);
			comp_id_partida_inicial.setValue('');
			var_id_partida_inicial='';
			
			comp_id_partida_final.setValue('');
			var_id_partida_final='';
			
			comp_id_partida_inicial.allowBlank=true;
			comp_id_partida_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_epe( combo, record, index ){
		var_sw_epe=record.data.ID;
		
		var_desc_sw_epe=record.data.ID;
		var_desc_id_epe_inicial='';
		var_desc_id_epe_final='';
		
		f_actualizarMaestro(); 
		
		if(var_sw_epe=='rango'){
			 comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'epe',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
			 };
		 	comp_id_epe_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_epe_inicial);
			CM_mostrarComponente(comp_id_epe_final);
			comp_id_epe_inicial.allowBlank=false;
			comp_id_epe_final.allowBlank=false;
		}
		else{
			CM_ocultarComponente(comp_id_epe_inicial);
			CM_ocultarComponente(comp_id_epe_final);
			comp_id_epe_inicial.setValue('');
			var_id_epe_inicial='';
			comp_id_epe_final.setValue('');
			var_id_epe_final='';
			comp_id_epe_inicial.allowBlank=true;
			comp_id_epe_final.allowBlank=true;
		}
	}

	function f_almacenar_sw_uo( combo, record, index ){
	var_sw_uo=record.data.ID;
	
	var_desc_sw_uo=record.data.ID;
	var_desc_id_uo_inicial='';
	var_desc_id_uo_final='';
	
	f_actualizarMaestro(); 
	
	if(var_sw_uo=='rango'){
		 comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'uo',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	 	comp_id_uo_inicial.modificado=true;
	 	CM_mostrarComponente(comp_id_uo_inicial);
		CM_mostrarComponente(comp_id_uo_final);
		comp_id_uo_inicial.allowBlank=false;
		comp_id_uo_final.allowBlank=false;
		
	}
	else{
		CM_ocultarComponente(comp_id_uo_inicial);
		CM_ocultarComponente(comp_id_uo_final);
		comp_id_uo_inicial.setValue('');
		var_id_uo_inicial='';
		comp_id_uo_final.setValue('');
		var_id_uo_final='';
		comp_id_uo_inicial.allowBlank=true;
		comp_id_uo_final.allowBlank=true;
	}
	
}
function f_almacenar_sw_ot( combo, record, index ){
	var_sw_ot=record.data.ID;
	
	var_desc_sw_ot=record.data.ID;
	var_desc_id_ot_inicial='';
	var_desc_id_ot_final='';
	
	f_actualizarMaestro(); 
	
	if(var_sw_ot=='rango'){
		 comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'ot',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	 	comp_id_ot_inicial.modificado=true;
	 	CM_mostrarComponente(comp_id_ot_inicial);
		CM_mostrarComponente(comp_id_ot_final);
		comp_id_ot_inicial.allowBlank=false;
		comp_id_ot_final.allowBlank=false;
	}
	else{
		CM_ocultarComponente(comp_id_ot_inicial);
		CM_ocultarComponente(comp_id_ot_final);
		comp_id_ot_inicial.setValue('');
		var_id_ot_inicial='';
		comp_id_ot_final.setValue('');
		var_id_ot_final='';
		comp_id_ot_inicial.allowBlank=true;
		comp_id_ot_final.allowBlank=true;
	}
}
function f_almacenar_partida_inicial( combo, record, index ){
	var_id_partida_inicial=record.data.id_uo_epe_ot_par;
	
	var_desc_id_partida_inicial=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	
	comp_id_partida_final.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'partida',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 //id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_partida_final.modificado=true;										
}
function f_almacenar_partida_final( combo, record, index ){
	var_id_partida_final=record.data.id_uo_epe_ot_par;
	
	var_desc_id_partida_final=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'partida',
											 
											 //id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_partida_inicial.modificado=true;
}

function f_almacenar_auxiliar_inicial( combo, record, index ){
	var_id_auxiliar_inicial=record.data.id_uo_epe_ot_par;
	
	var_desc_id_auxiliar_inicial=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_auxiliar_final.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'auxiliar',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 //id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_auxiliar_final.modificado=true;										
}
function f_almacenar_auxiliar_final( combo, record, index ){
	var_id_auxiliar_final=record.data.id_uo_epe_ot_par;
	
	var_desc_id_auxiliar_final=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_auxiliar_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'auxiliar',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 //id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_auxiliar_inicial.modificado=true;											
}


function f_almacenar_epe_inicial( combo, record, index ){
	var_id_epe_inicial=record.data.id_uo_epe_ot_par;
	
	var_desc_id_epe_inicial=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_epe_final.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'epe',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 //id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_epe_final.modificado=true;										
}
function f_almacenar_epe_final( combo, record, index ){
	var_id_epe_final=record.data.id_uo_epe_ot_par;
	
	var_desc_id_epe_final=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'epe',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 //id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_epe_inicial.modificado=true;											
}


function f_almacenar_uo_inicial( combo, record, index ){
	var_id_uo_inicial=record.data.id_uo_epe_ot_par;
	
	var_desc_id_uo_inicial=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_uo_final.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'uo',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 //id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_uo_final.modificado=true;										
}
function f_almacenar_uo_final( combo, record, index ){
	var_id_uo_final=record.data.id_uo_epe_ot_par;
	
	var_desc_id_uo_final=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'uo',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 //id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_uo_inicial.modificado=true;											
}



function f_almacenar_ot_inicial( combo, record, index ){
	var_id_ot_inicial=record.data.id_uo_epe_ot_par;
	
	var_desc_id_ot_inicial=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_ot_final.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'ot',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 id_ot_inicial:var_id_ot_inicial,
											 //id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_ot_final.modificado=true;										
}
function f_almacenar_ot_final( combo, record, index ){
	var_id_ot_final=record.data.id_uo_epe_ot_par;
	
	var_desc_id_ot_final=record.data.codigo_nombre;
   	f_actualizarMaestro(); 
	
	comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion,
											 id_depto:var_id_depto,
											 fecha_inicio:var_fecha_inicio,
											 fecha_final:var_fecha_final,
											 
											 sw_partida:var_sw_partida,
											 sw_auxiliar:var_sw_auxiliar,
											 sw_epe:var_sw_epe,
											 sw_uo:var_sw_uo,
											 sw_ot:var_sw_ot,

											 sw_estado_cbte:var_estado_cbte,
											 sw_actualizacion:var_sw_actualizacion,
											 sw_listado:'ot',
											 
											 id_partida_inicial:var_id_partida_inicial,
											 id_partida_final:var_id_partida_final,
											 
											 id_auxiliar_inicial:var_id_auxiliar_inicial,
											 id_auxiliar_final:var_id_auxiliar_final,
											 
											 id_epe_inicial:var_id_epe_inicial,
											 id_epe_final:var_id_epe_final,
											 
											 id_uo_inicial:var_id_uo_inicial,
											 id_uo_final:var_id_uo_final,
											 
											 //id_ot_inicial:var_id_ot_inicial,
											 id_ot_final:var_id_ot_final,
											 
		 
		 };
	comp_id_ot_inicial.modificado=true;											
}
function btn_imprimir(){
	var data='start=0';
		 data+='&limit=1000000';
		 data+='&CantFiltros='+g_CantFiltros;
		 data+='&id_gestion='+var_id_gestion;
		 data+='&id_depto='+var_id_depto;
		 data+='&fecha_inicio='+var_fecha_inicio;
		 data+='&fecha_final='+var_fecha_final;
		 
		 data+='&fecha_inicio='+var_fecha_inicio;
		 data+='&fecha_final='+var_fecha_final;
		  
		 
		 data+='&fecha_inicio_rep='+var_desc_fecha_inicio;
		 data+='&fecha_final_rep='+var_desc_fecha_final;
		 
		 data+='&sw_partida='+var_sw_partida;
		 data+='&sw_auxiliar='+var_sw_auxiliar;
		 data+='&sw_epe='+var_sw_epe;
		 data+='&sw_uo='+var_sw_uo;
		 data+='&sw_ot='+var_sw_ot;
		 data+='&id_partida_inicial='+var_id_partida_inicial;
		 data+='&id_partida_final='+var_id_partida_final;
		 data+='&id_auxiliar_inicial='+var_id_auxiliar_inicial;
		 data+='&id_auxiliar_final='+var_id_auxiliar_final;
		 data+='&id_epe_inicial='+var_id_epe_inicial;
		 data+='&id_epe_final='+var_id_epe_final;
		 data+='&id_uo_inicial='+var_id_uo_inicial;
		 data+='&id_uo_final='+var_id_uo_final;
		 data+='&id_ot_inicial='+var_id_ot_inicial;
		 data+='&id_ot_final='+var_id_ot_final;
		 data+='&sw_estado_cbte='+var_estado_cbte;
		 data+='&sw_actualizacion='+var_sw_actualizacion;
		 data+='&id_moneda='+var_id_moneda;
		 data+='&desc_moneda='+var_desc_moneda;
		// alert(direccion+'../../../control/mayorEpeUoOtpartidaAuxiliar/ActionMayorEpeUoOtpartidaAuxiliar.php?'+data);
		//console.log(direccion+'../../../control/mayorEpeUoOtpartidaAuxiliar/ActionMayorEpeUoOtpartidaAuxiliar.php?'+data);
		window.open(direccion+'../../../control/mayorEpeUoOtPartida/ActionMayorEpeUoOtPartida.php?'+data);
	}
	function btn_imprimir_simple(){
	var data='start=0';
		 data+='&limit=1000000';
		 data+='&CantFiltros='+g_CantFiltros;
		 data+='&id_gestion='+var_id_gestion;
		 data+='&id_depto='+var_id_depto;
		 data+='&fecha_inicio='+var_fecha_inicio;
		 data+='&fecha_final='+var_fecha_final;
		 
		 data+='&fecha_inicio='+var_fecha_inicio;
		 data+='&fecha_final='+var_fecha_final;
		  
		 
		 data+='&fecha_inicio_rep='+var_desc_fecha_inicio;
		 data+='&fecha_final_rep='+var_desc_fecha_final;
		 
		 data+='&sw_partida='+var_sw_partida;
		 data+='&sw_auxiliar='+var_sw_auxiliar;
		 data+='&sw_epe='+var_sw_epe;
		 data+='&sw_uo='+var_sw_uo;
		 data+='&sw_ot='+var_sw_ot;
		 data+='&id_partida_inicial='+var_id_partida_inicial;
		 data+='&id_partida_final='+var_id_partida_final;
		 data+='&id_auxiliar_inicial='+var_id_auxiliar_inicial;
		 data+='&id_auxiliar_final='+var_id_auxiliar_final;
		 data+='&id_epe_inicial='+var_id_epe_inicial;
		 data+='&id_epe_final='+var_id_epe_final;
		 data+='&id_uo_inicial='+var_id_uo_inicial;
		 data+='&id_uo_final='+var_id_uo_final;
		 data+='&id_ot_inicial='+var_id_ot_inicial;
		 data+='&id_ot_final='+var_id_ot_final;
		 data+='&sw_estado_cbte='+var_estado_cbte;
		 data+='&sw_actualizacion='+var_sw_actualizacion;
		 data+='&id_moneda='+var_id_moneda;
		 data+='&desc_moneda='+var_desc_moneda;

		window.open(direccion+'../../../control/mayorEpeUoOtPartida/ActionMayorReporteFormatoSimpleEpeUoOtPartida.php?'+data);
	}
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_consolidacionPresupuesto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();

	ds.lastOptions ={params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_primer_listado:'si'	 
		}}	
	initMayorEpeUpOtPartida()														
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el Libro Mayor',btn_imprimir,true,'imprimir','');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el Libro Mayor en formato simple',btn_imprimir_simple,true,'imprimir','Formato simple');
	layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);

}