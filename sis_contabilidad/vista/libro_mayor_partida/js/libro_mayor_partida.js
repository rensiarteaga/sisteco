/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaLibroMayorPartida(idContenedor,direccion,paramConfig,ma,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var maestro=new Array;
	maestro=ma;
	
	if(maestro.id_fina_regi_prog_proy_acti=='0'){
		maestro.id_fina_regi_prog_proy_acti='%';
	}	
	
	if(maestro.id_presupuesto=='0'){
		maestro.id_presupuesto='%';
	}
	
 	var componentes=new Array();
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_eeff=1;
	var	g_id_cuenta='Ninguno';
	var	g_fecha='01/01/2008';
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=2;
		
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';

 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';
	var g_tipo_auxiliar='Todos';

	var g_desc_moneda=maestro.desc_moneda;

	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	var fi=new Date(maestro.fecha_inicio);
	var ff=new Date(maestro.fecha_fin);
	
	var g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
	var g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();
	
	var monedas_for=new Ext.form.MonedaField(
		{
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/libro_mayor/ActionListarLibroMayorPartida.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
		//'fecha_cbte',
		'prefijo',
		'nro_cbte',
		'concepto_cbte',
		'tipo_cambio',
		'importe_gasto',
		'importe_recurso',
		'saldo'
		]),remoteSort:true}); 
	
	

	function menuBotones()
	{
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;

	 	ds.baseParams={start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			id_reporte_eeff:g_id_eeff,
			fecha_trans:g_fecha,
			id_moneda:g_id_moneda,
			nivel:g_nivel,
			id_cuenta:maestro.id_cuenta,
			fecha_inicio:g_fecha_inicio,
		    fecha_fin:g_fecha_fin,
		    tipo_auxiliar:g_tipo_auxiliar,
			id_depto:maestro.id_depto,
		   id_fina_regi_prog_proy_acti:maestro.id_fina_regi_prog_proy_acti,
		   id_presupuesto:maestro.id_presupuesto
		};
	
	 var data_maestro=[ ['Partida ',maestro.codigo_partida+' '+ maestro.nombre_partida],
	                     ['Moneda',g_desc_moneda],
					     ['Fecha Inicio',g_fecha_inicio],
					     ['Fecha Fin',g_fecha_fin],
					     ['Departamento',maestro.desc_depto],
					     ['Presupuesto',maestro.desc_presupuesto]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	}
	
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function MaestroHTML(data){
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

	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
		else return "  "
	}
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[  ['Partida ',maestro.codigo_partida+' '+ maestro.nombre_partida],
	                    ['Moneda',g_desc_moneda],
					     ['Fecha Inicio',g_fecha_inicio],
					     ['Fecha Fin',g_fecha_fin],
					     ['Departamento',maestro.desc_depto],
					     ['Presupuesto',maestro.desc_presupuesto]
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

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	function render_id_partida(value,cell,record,row,colum,store)
	{	if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:green;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
		}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre>')}
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
		 
	function render_moneda_7(c){return componentes[7].formatMoneda(c);}
	function render_moneda_6(c){return componentes[6].formatMoneda(c);}
	function render_moneda_5(c){return componentes[5].formatMoneda(c);}
	
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
			labelSeparator:'',
			name: 'id_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta'
	} ; 
	
	// txt fecha_cbte
	Atributos[1]= {
		validacion:{
				name:'fecha_cbte',
				fieldLabel:'Fecha',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'COMPROB.fecha_cbte',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_cbte'
	};

	Atributos[2]={
		validacion:{
			name:'prefijo',
			fieldLabel:'N° Cbte.',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'prefijo',
		save_as:'tipo'
	};
	
	Atributos[3]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Nro.',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'nro_cbte',
		save_as:'nro_cbte'
	};
	
	Atributos[4]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Concepto Comprobante',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:450,
			width:'50%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'concepto_cbte',
		save_as:'concepto_cbte'
	};
 
	Atributos[5]={
		validacion:{
			name:'importe_recurso',
			fieldLabel:'Importe Recurso',
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
			//renderer:render_moneda_5,
			renderer: render_total,
			width_grid:150,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_recurso',
		save_as:'importe_recurso'
	};
	
	// importe_debe
	Atributos[6]={
		validacion:{
			name:'importe_gasto',
			fieldLabel:'Importe Gasto',
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
			//renderer:render_moneda_6,
			renderer: render_total,
			width_grid:150,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_gasto',
		save_as:'importe_gasto'
	};

	Atributos[7]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
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
			//renderer:render_moneda_7,
			renderer: render_total,
			width_grid:200,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo',
		save_as:'saldo'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Libro Mayor (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_libro_mayor = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_libro_mayor.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_libro_mayor,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponente=this.getComponente;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
			actualizar:{crear:true,separador:false},
			excel:{crear:true,separador:false}
	};
	
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
		
	
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		//cargamos en la variable maestro los datos pasados por el parametro
		//console.log(params);
		maestro=datos;
		
		if(maestro.id_fina_regi_prog_proy_acti=='0'){
			maestro.id_fina_regi_prog_proy_acti='%';
		}	
		
		if(maestro.id_presupuesto=='0'){
			maestro.id_presupuesto='%';
		}
		
		//obtenemos todas las variables que serán mostradas en el maestro
		g_desc_moneda=maestro.desc_moneda;
		g_desc_estado_gral=maestro.desc_estado_gral;
		fi=new Date(maestro.fecha_inicio);
		ff=new Date(maestro.fecha_fin);
		g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
		g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();
		
		//Se vuleve a crear el data_maestro conlos nuevos datos
		data_maestro=[  ['Partida ',maestro.codigo_partida+' '+ maestro.nombre_partida],
	                    ['Moneda',g_desc_moneda],
					     ['Fecha Inicio',g_fecha_inicio],
					     ['Fecha Fin',g_fecha_fin],
					     ['Departamento',maestro.desc_depto],
					     ['Presupuesto',maestro.desc_presupuesto]
					    ];
		
		//Se coloca en el maestro los datos del data_maestro
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		
		
		ds.lastOptions={
			params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
					id_moneda:maestro.id_moneda,
					id_cuenta:maestro.id_cuenta,
					fecha_inicio:g_fecha_inicio,
					fecha_fin:g_fecha_fin,
					tipo_auxiliar:g_tipo_auxiliar,
					id_depto:maestro.id_depto,
					id_fina_regi_prog_proy_acti:maestro.id_fina_regi_prog_proy_acti,
					id_presupuesto:maestro.id_presupuesto,
					id_partida:maestro.id_partida
				}
		};
		this.btnActualizar();
		iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	function btn_imprimir(){
  			/*parametros reporte */	
		var data='start=0';
			 data+='&limit=1000';
			 data+='&CantFiltros='+g_CantFiltros;
			 data+='&fecha_inicio='+g_fecha_inicio;
			 data+='&fecha_fin='+g_fecha_fin;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&id_partida='+maestro.id_partida;
			 data+='&desc_moneda='+g_desc_moneda;
			 data+='&tipo_auxiliar='+g_tipo_auxiliar;
			 data+='&id_depto='+maestro.id_depto;
			 data+='&desc_depto='+maestro.desc_depto;
			 data+='&desc_ep='+maestro.desc_ep;
			 data+='&id_fina_regi_prog_proy_acti='+maestro.id_fina_regi_prog_proy_acti;
			 data+='&id_presupuesto='+maestro.id_presupuesto;
			 data+='&desc_presupuesto='+maestro.desc_presupuesto;
			 
 		window.open(direccion+'../../../control/libro_mayor/reporte/ActionPDFLibroMayorPartida.php?'+data);	
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	}
	
	function InitRegistroTransaccion(){
		for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_libro_mayor.getLayout()};
	
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	
	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'moneda...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_moneda',
			tpl:tpl_id_moneda_reg
	});
	
	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_desc_moneda=record.data['nombre'];menuBotones()});
	
	monedas.setValue(maestro.desc_moneda);
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro mayor ',btn_imprimir,true,'imprimir','');	
	this.AdicionarBotonCombo(monedas,'monedas');
	
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		id_moneda:maestro.id_moneda,
		id_cuenta:maestro.id_cuenta,
		fecha_inicio:g_fecha_inicio,
		fecha_fin:g_fecha_fin,
		tipo_auxiliar:g_tipo_auxiliar,
		id_depto:maestro.id_depto,
		id_fina_regi_prog_proy_acti:maestro.id_fina_regi_prog_proy_acti,
		id_presupuesto:maestro.id_presupuesto,
		id_partida:maestro.id_partida
	}});
	
	iniciarEventosFormularios();	
	InitRegistroTransaccion();
	layout_libro_mayor.getLayout().addListener('layout',this.onResize);
}