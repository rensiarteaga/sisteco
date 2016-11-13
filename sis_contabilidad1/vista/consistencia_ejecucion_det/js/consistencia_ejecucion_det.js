/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaConsistenciaEjecucionDetalle(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	

	var g_fecha_inicio= formatDate(new Date());
	var g_fecha_fin =formatDate(new Date());
	 
	
	
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Bolivianos';
	var	g_tipo_partida=3;
	var g_tipo_partida_desc='Todos';
	var	g_sw_movimiento=3;
	var	g_sw_movimiento_desc='Todos';
	var	g_momento=9;
	var	g_momento_desc='Todos';
	
	var g_desc_moneda=maestro.desc_moneda;

	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	var g_departamento='';
	
	var sw=0;	
			
		 
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/consistencia_ejecucion_det/ActionListarConsistenciaEjecucion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_comprobante',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'nombre_depto',
		'fecha_cbte',
		'id_comprobante',
		'nro_cbte',
		'concepto_cbte',
		'nro_cuenta',
		'nombre_cuenta',
		'codigo_partida',
		'nombre_partida',
		'codigo_auxiliar',
		'nombre_auxiliar',
		'importe_debe',
		'importe_haber',
		'importe_gasto',
		'importe_recurso',
		'momento_cbte'
		 
		
		]),remoteSort:true});
 
	//carga datos XML
 	/*crea los data store*/
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?m_id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo','despliegue_rep']),remoteSort:true});	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto}</i></b>','</div>');	
	config_depto={nombre:'Depto',descripcion:'despliegue_rep',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	function renderMomento(value, p, record)
	{
		if(value == 0)
		{return "Contable"}
		if(value == 1)
		{return "Devengado"}
		if(value == 2)//valor no utilizado en el combo de momento pero si para la opcion de Todos
		{return "Recursos Percibidos"}
		if(value == 3)//valor no utilizado en el combo de momento pero si para la opcion de Todos
		{return "Devengado de Gastos o Inversion"}
		if(value == 4)
		{return "Pagado o Percibido"}
		if(value == 5)
		{return "Reversión Devengado"}
		if(value == 6)
		{return "Reversión o Percibido"}
		if(value == 7)
		{return "Ajustar Devengado"}
		if(value == 8)
		{return "Ajustar Pagado o Percibido"}
		return '';
			
	}
	function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 
   		
		ds.baseParams={
			start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,

			fecha_inicio:g_fecha_inicio,
			fecha_final:g_fecha_fin,
			
			id_moneda:g_id_moneda,
			
			tipo_partida:g_tipo_partida,
			sw_movimiento:g_sw_movimiento,
			momento:g_momento,
		 
		};
		
	 
	
	//maestro seleccion
	 var data_maestro=[ ['Tipo partida',g_tipo_partida_desc,'Fecha de Inicio',g_fecha_inicio],
	 					 ['SW Mov',g_sw_movimiento_desc,'Fecha de Fin',g_fecha_fin],
	 					 ['Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length),'Momento',g_momento_desc]
					    
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
function 	 MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
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
function tabular(n)
{ if (n>=0)	{return "  "+tabular(n-1)}
else return "  "
}

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	////maestro inicio

		  var data_maestro=[ ['Tipo partida',g_tipo_partida_desc,'Fecha de Inicio',g_fecha_inicio],
	 					 ['SW Mov',g_sw_movimiento_desc,'Fecha de Fin',g_fecha_fin],
	 					 ['Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length),'Momento',g_momento_desc]
					    
					    ];
	//DATA STORE COMBOS

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','tipo_partida_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
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

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	Atributos[0]={
		validacion:{
			name:'nombre_depto',
			fieldLabel:'Nombre Depto',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:1,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_depto',
		filtro_1:true,
		
		save_as:'nombre_depto'
	};
	
// fecha_cbte
	Atributos[1]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha Cbte',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			//renderer:formatDate,
			width_grid:85,
			disabled:false
			
		},
		form:true,
		tipo:'DateField',
		
		filtro_0:true,
		filtro_1:true,
		filterColValue:'cbte.fecha_cbte',
		dateFormat:'d-m-Y',
		defecto:'',
		save_as:'fecha_cbte'
	};
	
	Atributos[2]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			fieldLabel:'ID Comprobante',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			grid_indice:3
		},
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false,
		save_as:'id_comprobante'
	} ; 
	//nro_cbte
	Atributos[3]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Nro Cbte',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:4,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'nro_cbte',
		save_as:'nro_cbte'
	};
	
	
	//concepto_cbte
	Atributos[4]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Concepto Cbte',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:5,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'concepto_cbte',
		save_as:'concepto_cbte'
	};
	//nro_cuenta
	Atributos[5]={
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'Nro Cuenta',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:6,		
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'nro_cuenta',
		save_as:'nro_cuenta'
	};
	
	
	//nombre_cuenta
	Atributos[6]={
		validacion:{
			name:'nombre_cuenta',
			fieldLabel:'Nombre Cuenta',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:7,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'nombre_cuenta',
		save_as:'nombre_cuenta'
	};
	//codigo_partida
	Atributos[7]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Codigo Partida',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:8,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'codigo_partida',
		save_as:'codigo_partida'
	};
	//nombre_partida
	Atributos[8]={
		validacion:{
			name:'nombre_partida',
			fieldLabel:'Nombre Partida',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:9,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'nombre_partida',
		save_as:'nombre_partida'
	};
	//codigo_auxiliar
	Atributos[9]={
		validacion:{
			name:'codigo_auxiliar',
			fieldLabel:'Codigo Auxiliar',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:10,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'codigo_auxiliar',
		save_as:'codigo_auxiliar'
	};
	//nombre_auxiliar
	Atributos[10]={
		validacion:{
			name:'nombre_auxiliar',
			fieldLabel:'Nombre Auxliar',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:11,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'nombre_auxiliar',
		save_as:'nombre_auxiliar'
	};
	//  importe_debe
	Atributos[11]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe',
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
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			grid_indice:12,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'trv.importe_debe',
		save_as:'importe_debe'
	};
	//  importe_haber
	Atributos[12]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
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
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			grid_indice:13,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'trv.importe_haber',
		save_as:'importe_haber'
	};
	//  importe_gasto
	Atributos[13]={
		validacion:{
			name:'importe_gasto',
			fieldLabel:'Importe Gasto',
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
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			grid_indice:14,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'trv.importe_gasto',
		save_as:'importe_gasto'
	};
	//  importe_recurso
	Atributos[14]={
		validacion:{
			name:'importe_recurso',
			fieldLabel:'Importe Recurso',
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
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			grid_indice:15,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'trv.importe_recurso',
		save_as:'importe_recurso'
	};
	//nombre_auxiliar
	Atributos[15]={
		validacion:{
			name:'momento_cbte',
			fieldLabel:'Momento',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			renderer:renderMomento,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			grid_indice:16,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'momento_cbte',
		save_as:'momento_cbte'
	};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Consistencia de Ejecucion (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
		
	};
	this.btnActualizar=function(){ 
		if (sw==0){ 
			ds.load({params:ds.baseParams});
			sw =1;
		}
		else{ 
			ClaseMadre_btnActualizar();
			}
	}

	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
	
	//-------------- Sobrecarga de funciones --------------------//


	/*******************/
	
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
	
 
var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_tipo_partida','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:true});
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
 	
 
var fecha_inicio=	new Ext.form.DateField({
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
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
			
var fecha_fin=	new Ext.form.DateField({
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
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
						
var tipo_partida =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'Recurso'],[2,'Gasto'],[3,'Todos']]}),	
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',	
			emptyText:'Partida..',
			selectOnFocus:true,
			width:80,
			valueField:'ID',
			displayField:'valor',
			mode:'local'});		
var sw_movimiento =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'Presupuestario'],[2,'Flujo'],[3,'Todos']]}),	
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',	
			emptyText:'SW...',
			selectOnFocus:true,
			width:100,
			valueField:'ID',
			displayField:'valor',
			mode:'local'});		

var momento =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[0,'Contable'],[3,'Devengado de Gastos o Inversion'],[4,'Pagado o Percibido'],[5,'Reversión Devengado'],[6,'Reversión o Percibido'],[7,'Ajustar Devengado'],[8,'Ajustar Pagado o Percibido'] ,[9,'Todos']]}),	
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',	
			emptyText:'Momento..',
			selectOnFocus:true,
			width:200,
			valueField:'ID',
			displayField:'valor',
			mode:'local'});
		
			
		fecha_inicio.on('change',function (){
								g_fecha_inicio=fecha_inicio.getValue()?fecha_inicio.getValue().dateFormat('m/d/Y'):'';
								 
		                        menuBotones()}
		                        
		                        
		        );
		fecha_fin.on('change',function (){
								g_fecha_fin=fecha_fin.getValue()?fecha_fin.getValue().dateFormat('m/d/Y'):'';
								
		                        menuBotones()}
		        );
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
		
		tipo_partida.on('select',function (combo, record, index){g_tipo_partida=tipo_partida.getValue();g_tipo_partida_desc=record.data['valor'];menuBotones()});
		
		
		sw_movimiento.on('select',function (combo, record, index){g_sw_movimiento=sw_movimiento.getValue();g_sw_movimiento_desc=record.data['valor']; menuBotones()});

		momento.on('select',function (combo, record, index){g_momento=momento.getValue();g_momento_desc=record.data['valor']; menuBotones()});	

 ds_moneda_consulta.load({params:{start:0,limit: 1000}});

fecha_inicio.setValue(new Date);
fecha_fin.setValue(new Date);
monedas.setValue('');
tipo_partida.setValue('');
sw_movimiento.setValue('');
//momento.setValue('Seleccionar');

function btn_reporte_comprobante(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				
				var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
				data=data+'&m_id_moneda='+g_id_moneda;
				//data=data+'&m_simbolo='+g_simbolo;
				//data=data+'&m_desc_clases='+SelectionsRecord.data.titulo_cbte;
				data=data+'&m_momento_cbte='+SelectionsRecord.data.momento;

				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
			
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}	

						
//padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte ',btn_imprimir,true,'imprimir','');	
//this.AdicionarBotonCombo(parametro,'gestion');		
//this.AdicionarBotonCombo(eeff,'EEFF');		
padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_reporte_comprobante,true,'imprimir','');	
this.AdicionarBotonCombo(fecha_inicio,'Fecha Inicio');		
this.AdicionarBotonCombo(fecha_fin,'Fecha');		
this.AdicionarBotonCombo(monedas,'monedas');														
this.AdicionarBotonCombo(tipo_partida,'tipo_partida');														
this.AdicionarBotonCombo(sw_movimiento,'Actualización');
this.AdicionarBotonCombo(momento,'Momento');														


														
layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})
	
}