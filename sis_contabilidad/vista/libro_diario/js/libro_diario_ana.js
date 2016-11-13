/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function pagina_libro_diario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	//var	g_id_parametro=1;
	//var	g_id_parametro_desc='Ninguno';
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
	//para las fechas
	//var d = new Date(Date.parse(“May 25, 2004”));
	var fi=new Date(maestro.fecha_inicio);
	var ff=new Date(maestro.fecha_fin);
	
	
	var g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
	var g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();

			//function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		
		
 
	
	/****************/
	
	/****************/
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		//proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff/ActionListarEEFF.php'}),
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarLibroMayor.php?m_id_cuenta'+maestro.id_cuenta}),
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
		'importe_debe',
		'importe_haber',
		'saldo'
		 
		]),remoteSort:true});
 
	
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		id_moneda:maestro.id_moneda,
		id_cuenta:maestro.id_cuenta,
		fecha_inicio:g_fecha_inicio,
		fecha_fin:g_fecha_fin,
		tipo_auxiliar:g_tipo_auxiliar
		}});

	
	/*crea los data store*/
	var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
	var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacion.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});

 
	var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
	var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
	var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
	var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
	var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
	
	
	
	
	
	
	config_fuente_financiamiento={nombre:'Fuente Finan.',descripcion:'denominacion',id:'id_fuente_financiamiento',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_unidad_organizacional={nombre:'Unidad Org.',descripcion:'desc_unidad_organizacional',id:'id_unidad_organizacional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_financiador={nombre:'Financiado',descripcion:'nombre_financiador',id:'id_financiador',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_regional={nombre:'Regional',descripcion:'nombre_regional',id:'id_regional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_programa={nombre:'Programa',descripcion:'nombre_programa',id:'id_programa',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_proyecto={nombre:'SubPrograma',descripcion:'nombre_proyecto',id:'id_proyecto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_actividad={nombre:'Actividad',descripcion:'nombre_actividad',id:'id_actividad',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	
	
		function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
	 
   
	 	g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente Finan.').menuBoton.getSelecion();
	 	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSelecion();
	 	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSelecion();
	 	g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
	 	g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
	 	g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
	 	g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
	 	
	 	
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente Finan.').menuBoton.getSeleccionadosDesc();
		//g_tipo_auxiliar=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
	
		ds.baseParams={start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			
		//	id_parametro:g_id_parametro,
			id_reporte_eeff:g_id_eeff,
			fecha_trans:g_fecha,
			id_moneda:g_id_moneda,
			nivel:g_nivel,
			id_cuenta:maestro.id_cuenta,
			fecha_inicio:g_fecha_inicio,
		    fecha_fin:g_fecha_fin,
		    tipo_auxiliar:g_tipo_auxiliar,
			
			ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			ids_u_o:g_ids_u_o,
			ids_financiador:g_ids_financiador,
			ids_regional:g_ids_regional,
			ids_programa:g_ids_programa,
			ids_proyecto:g_ids_proyecto,
			ids_actividad:g_ids_actividad};
	

	
	if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
	if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
	if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
	if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
	if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
	/***********/
 
	if(epe==" "){epe="Todos"}
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
	
	
	
	 
	/*alert("asdfsdfj"+maestro.id_cuenta);
	exit;*/
	
	 var data_maestro=[ ['Cuenta ',maestro.nro_cuenta+' '+ maestro.nombre_cuenta,'Moneda',g_desc_moneda],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente Financiamiento',g_Fuente_financiamiento],
					   ['Fecha Inicio',g_fecha_inicio,'Fecha Fin',g_fecha_fin,'Tipo de Reporte',g_tipo_auxiliar]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
function 	 MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
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
		/*if(j%2!=0){
			html=html+"<td></td><td></td></tr>";
		}*/
		//html=html+'</table>';
		
	 
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
	
	var data_maestro=[ ['Cuenta ',maestro.nro_cuenta+' '+ maestro.nombre_cuenta,'Moneda',g_desc_moneda],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente Financiamiento',g_Fuente_financiamiento],
					   ['Fecha Inicio',g_fecha_inicio,'Fecha Fin',g_fecha_fin,'Tipo de Reporte',g_tipo_auxiliar]
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
		{		if(store.getAt(row).data['sw_transaccional'] == 1){
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
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'tipo',
		save_as:'tipo'
	};
	
	Atributos[3]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Numero Comprobante',
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
			//renderer: renderSwTranssacional,
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
			grid_editable:true,
			width_grid:400,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'concepto_cbte',
		save_as:'concepto_cbte'
	};
 
	 
	 
		

// txt mes_01
	Atributos[5]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo de Cambio',
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
			//renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'tipo_cambio',
		save_as:'tipo_cambio'
	};
	
// importe_debe
	Atributos[6]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe',
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
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_debe',
		save_as:'importe_debe'
	};

// importe_debe
	Atributos[7]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
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
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_haber',
		save_as:'importe_haber'
	};
	// importe_debe
	Atributos[8]={
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
			//renderer: renderSwTranssacional,
			width_grid:120,
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
	var config={titulo_maestro:'libro_diario',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/libro_diario/libro_diario_transaccion.php'};
		var layout_libro_diario=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_libro_diario.init(config);
		
/*	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Libro Mayor (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_libro_diario = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_libro_diario.init(config);*/
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_libro_diario,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//	var ClaseMadre_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false}
	};
	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	//btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	//Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	//ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
	
	//-------------- Sobrecarga de funciones --------------------//


function btn_imprimir(){
	
		 
	
  			/*parametros reporte */	
			var data='start=0';
			 data+='&limit=1000';
			 data+='&CantFiltros='+g_CantFiltros;
			 
			 //data+='&id_parametro='+g_id_parametro;
			 //data+='&id_reporte_eeff='+g_id_eeff;
			 //data+='&fecha_trans='+g_fecha;
			 data+='&fecha_inicio='+g_fecha_inicio;
			 data+='&fecha_fin='+g_fecha_fin;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&id_cuenta='+maestro.id_cuenta;
			 //data+='&nivel='+g_nivel;
			 
			 
			 /*data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;
			 data+='&ids_u_o='+g_ids_u_o;*/
			 data+='&ids_financiador='+g_ids_financiador;
			 data+='&ids_regional='+g_ids_regional;
			 data+='&ids_programa='+g_ids_programa;
			 data+='&ids_proyecto='+g_ids_proyecto;
			 data+='&ids_actividad='+g_ids_actividad;
			 data+='&tipo_auxiliar='+g_tipo_auxiliar;
	
 
 
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
 
					   
	/*data+='&EEFF='+g_id_cuenta;					   
	data+='&nivel='+g_nivel;
	data+='&desc_moneda='+g_id_moneda_desc;
	data+='&gestion='+g_id_parametro_desc;
	data+='&fecha='+g_fecha;
	data+='&regional='+g_regional;
	data+='&financiador='+g_financiador;
	data+='&programa='+g_programa;
	data+='&proyecto='+g_proyecto;
	data+='&actividad='+g_actividad;
	data+='&unidad_organizacional='+g_unidad_organizacional;
	data+='&Fuente_financiamiento='+g_Fuente_financiamiento;
	
	*/	
 	if(g_tipo_auxiliar=="Todos"){
 	window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayor.php?'+data);	
 	}else{
 	window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayorPorAuxiliar.php?'+data);
 	}
	
	
	
	}
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_libro_diario.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	ds_fuente_financiamiento.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_fuente_financiamiento,config_fuente_financiamiento);}
									});

	//if(maestro.sw_vista=="formulacion"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'si'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})
	//}
	/*if(maestro.sw_vista=="aprobacion"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'no'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})}					*/
									
ds_financiador.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros
							 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_financiador,config_financiador);}
									});				
ds_regional.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros 
							 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_regional,config_regional);}
									});		
ds_programa.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros 
								 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_programa,config_programa);}
									});		
ds_proyecto.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros 
								 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_proyecto,config_proyecto);}
									});		
ds_actividad.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros 
								 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_actividad,config_actividad);}
									});		

 
		
	 
	
var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
/*var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
*/
var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:true});
var tpl_id_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
	

//monedas
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
var auxiliar =new Ext.form.ComboBox({
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Todos','Todos'],['Auxiliar','Por Auxiliar']]}),
            valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccione...',
			selectOnFocus:true,
			width:100,
			//valueField: 'tipo_rep_auxiliar',
			//tpl:tpl_id_moneda_reg
			
		});		
		
		
	/*	// txt estado_reg
	Atributos[5]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado Registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:6
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.estado_reg',
		defecto:'activo',
		save_as:'txt_estado_reg',
		id_grupo:2
	};*/
		
		
		
		
		
//parametro
/*var parametro =new Ext.form.ComboBox({
			store: ds_parametro,
			displayField:'gestion_conta',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'gestión...',
			selectOnFocus:true,
			width:60,
			valueField: 'id_parametro',
			tpl:tpl_id_parametro_reg
			
		});*/
/*var eeff =new Ext.form.ComboBox({
			store: ds_eeff,
			displayField:'nombre_eeff',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'EEFF...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_reporte_eeff',
			tpl:tpl_id_eeff
			
		});		*/
/*var fecha=	new Ext.form.DateField({
			name:'fecha',
			fieldLabel:'Fecha EEFF',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			//maxValue: '30/11/2008',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:55,
			disabled:false});*/		
var nivel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4']]}),	typeAhead: true,mode: 'local',triggerAction: 'all',	emptyText:'nivel...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
		//ds_parametro.load({params:{start:0,limit: 1000000}});
	 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	 	//ds_eeff.load({params:{start:0,limit: 1000000}});
		
		//parametro.on('select',function (combo, record, index){g_id_parametro=parametro.getValue();g_id_parametro_desc=record.data['desc_gestion'];menuBotones()});
		//eeff.on('select',function (combo, record, index){g_id_eeff=eeff.getValue();g_id_cuenta=record.data['nombre_eeff'];menuBotones()});		
	//	fecha.on('change',function (){g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';	menuBotones()});
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_desc_moneda=record.data['nombre'];menuBotones()});
		auxiliar.on('select',function (combo, record, index){g_tipo_auxiliar=auxiliar.getValue();menuBotones()});

	//	nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();menuBotones()});

 
//parametro.setValue(1);
//eeff.setValue(1);
//fecha.setValue('01/01/2008');
monedas.setValue(1);
nivel.setValue(2);
		
	
								
padre.AdicionarBoton('../../../lib/imagenes/print.gif',' ',btn_imprimir,true,'imprimir','');	
//this.AdicionarBotonCombo(parametro,'gestion');		
//this.AdicionarBotonCombo(eeff,'EEFF');		
//this.AdicionarBotonCombo(fecha,'Fecha');		
this.AdicionarBotonCombo(monedas,'monedas');	
this.AdicionarBotonCombo(auxiliar,'auxiliar');													
//this.AdicionarBotonCombo(nivel,'nivel');														
														
layout_libro_diario.getLayout().addListener('layout',this.onResize);
	//layout_libro_diario.getVentana(idContenedor).on('resize',function(){layout_libro_diario.getLayout().layout()})
	
}