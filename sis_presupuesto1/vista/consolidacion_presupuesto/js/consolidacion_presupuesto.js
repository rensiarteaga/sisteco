function paginaConsolidacionPresupuesto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 	var monedas_for=new Ext.form.MonedaField({name:'mes_01',fieldLabel:'Enero',	allowBlank:false,align:'right', maxLength:50,minLength:0,selectOnFocus:true,allowDecimals:true,	decimalPrecision:2,allowNegative:false,minValue:0,}); 
	
 	var	g_limit='';
	var	g_CantFiltros='';
	var	g_tipo_pres='';
	var	g_id_parametro='';
	var	g_id_moneda='';
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';
	var	g_sw_vista='';
	var	g_ids_concepto_colectivo='';
 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';
	var g_colectivo='';
	
	var g_desc_moneda='';
	var g_desc_pres='';
	var g_desc_estado_gral='';
	var g_gestion_pres='';
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/consolidacion/ActionListarConsolidacion.php'}),
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
		'nombre_partida',
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
		'sw_transaccional'
		]),remoteSort:true});

	//carga datos XML
	/*ds.load({params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo_pres:maestro.tipo_pres,
			id_parametro:maestro.id_parametro,
			id_moneda:maestro.id_moneda,
			sw_vista:maestro.sw_vista
		} 

	
	});*/
	
	/*crea los data store*/
	var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
	var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});

 
	var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
	var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
	var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
	var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
	var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
	
	var ds_colectivo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','estado_colectivo','id_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona','desc_usuario','desc_colectivo']),remoteSort:true});
	
	
	
	
	config_fuente_financiamiento={nombre:'Fuente de Financ.',descripcion:'denominacion',id:'id_fuente_financiamiento',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_unidad_organizacional={nombre:'Unidad Org.',descripcion:'desc_unidad_organizacional',id:'id_unidad_organizacional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_financiador={nombre:'Financiador',descripcion:'nombre_financiador',id:'id_financiador',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_regional={nombre:'Regional',descripcion:'nombre_regional',id:'id_regional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_programa={nombre:'Programa',descripcion:'nombre_programa',id:'id_programa',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_proyecto={nombre:'SubPrograma',descripcion:'nombre_proyecto',id:'id_proyecto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_actividad={nombre:'Actividad',descripcion:'nombre_actividad',id:'id_actividad',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_colectivo={nombre:'Concepto Colec.',descripcion:'desc_colectivo',id:'id_concepto_colectivo',selectAceptar:true,selectTodo:true,selectLimpiar:false,funcion:menuBotones};
	
	function menuBotones()
	{
		
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;	 	
	 	
	 	g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financ.').menuBoton.getSelecion();
	 	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSelecion();
	 	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSelecion();
	 	g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
	 	g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
	 	g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
	 	g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
	 	g_sw_vista=maestro.sw_vista;
	 	g_ids_concepto_colectivo=padre.getBotonMenuBotonNombre('Concepto Colec.').menuBoton.getSelecion();
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Org.').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financ.').menuBoton.getSeleccionadosDesc();
		g_colectivo=padre.getBotonMenuBotonNombre('Concepto Colec.').menuBoton.getSeleccionadosDesc();
	
			ds.baseParams={
			start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			tipo_pres:g_tipo_pres,
			id_parametro:g_id_parametro,
			id_moneda:g_id_moneda,
			ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			ids_u_o:g_ids_u_o,
			ids_financiador:g_ids_financiador,
			ids_regional:g_ids_regional,
			ids_programa:g_ids_programa,
			ids_proyecto:g_ids_proyecto,
			ids_actividad:g_ids_actividad,
			sw_vista:g_sw_vista,
			ids_concepto_colectivo:g_ids_concepto_colectivo
			};
		 
	var epe=" ";
	
	if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
	if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
	if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
	if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
	if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
	/***********/
 
	if(epe==" "){epe="Todos"}
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
	if(g_colectivo==""){g_colectivo="Todos"}
	

//
	 var data_maestro=[ ['Presupuesto de ',renderTipoPresupuesto(g_tipo_pres)+tabular(44-renderTipoPresupuesto(g_tipo_pres).length),'Moneda',g_desc_moneda+tabular(44-g_desc_moneda.length),'Gestión',maestro.gestion_pres+" "+g_gestion_pres+tabular(44-g_gestion_pres.length-0)],
					   ['Estructura Programatica',epe] ,
					   ['Unidad Organizacional',g_unidad_organizacional ] ,
					   ['Fuente de Financiamiento',g_Fuente_financiamiento],
					   ['Concepto Colectivo',g_colectivo]];
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
	
	function tabular(n){ if (n>=0)	{return "  "+tabular(n-1)}else return "  "};
	function renderTipoPresupuesto(value){if(value == 1){return  "Recurso"}if(value == 2){return "Gasto"}if(value == 3){return "Inversión"} return '';};

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
		var data_maestro=[ ['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(44-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(44-maestro.gestion_pres.length-maestro.desc_estado_gral.length)],
					   ['Estructura Programatica','Todos'] ,
					   ['Estructura Organizacional','Todos' ] ,
					   ['Fuente de Financ.','Todos'],
					   ['Concepto Colectivo','Todos']
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
			return  '<span style="color:blue;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
	 
		
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
			return  '<span style="color:blue;">' +monedas_for.formatMoneda(value)+'</span>'}	
			if(store.getAt(row).data['sw_transaccional'] == 2){return monedas_for.formatMoneda(value)}
		 
		}
		function renderSwTranssacionalText(value,cell,record,row,colum,store){
		
			if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:blue;">' + value +'</span>'}	
			if(store.getAt(row).data['sw_transaccional'] == 2){return  value }
		 
		}	
		 
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria

/*	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_presupuesto'
	};*/

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
		save_as:'id_partida_presupuesto'
	} ;
 
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
			grid_editable:true,
			width_grid:60,
			width:'50%',
			renderer: renderSwTranssacionalText,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida',
		save_as:'codigo_partida'
	};

// txt id_partida
	Atributos[2]={
			validacion:{
			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'nombre_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.nombre_partida',
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
			width_grid:350,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.desc_partida',
		save_as:'id_partida'
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
		save_as:'id_presupuesto'
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
		save_as:'id_partida_detalle'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_01',
		save_as:'mes_01'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_02',
		save_as:'mes_02'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_03',
		save_as:'mes_03'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_04',
		save_as:'mes_04'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_05',
		save_as:'mes_05'
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
			renderer: renderSwTranssacional,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_06',
		save_as:'mes_06'
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
			renderer: renderSwTranssacional,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_07',
		save_as:'mes_07'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_08',
		save_as:'mes_08'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_09',
		save_as:'mes_09'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_10',
		save_as:'mes_10'
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
			renderer: renderSwTranssacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_11',
		save_as:'mes_11'
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.mes_12',
		save_as:'mes_12'
	};
// txt total
	Atributos[17]={
		validacion:{
			name:'total',
			fieldLabel:'Total Gestión',
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.total',
		save_as:'total'
	};
// txt id_partida_presupuesto
	Atributos[18]={
			validacion:{
			name:'id_partida_presupuesto',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
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
		filtro_0:true,
		filterColValue:'PARPRE.',
		save_as:'id_partida_presupuesto'
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
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	Atributos[20]={
		validacion:{
			name:'fecha_elaboracion',
			fieldLabel:'Fecha Elaboración',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disable:true		
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'PARPRE.fecha_elaboracion',
		save_as:'fecha_elaboracion'
	};
	
	
	 Atributos[21] = {
		validacion: {
			name:'tipo_memoria',
			//desc: 'tipo_conex_literal',
			fieldLabel:'tipo_memoria',
			vtype:'texto',
			fieldLabel:'tipo_memoria',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				
				data :[
				       
				        ['1', 'Recursos'],
				        ['2', 'Gastos'],
				        ['3', 'Inversiones'],
				        ['4', 'Viajes'],
				        ['5', 'RRHH'],
				        ['6', 'OTROS'],
				        ] // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoMemoria,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150,
			disabled:true
		
		},
		tipo:'ComboBox',
		defecto:'1',
		
		form: false,
		filtro_0:true,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'
		
	}; 
	Atributos[22] = {
		validacion: {
			name:'sw_transaccional',
			//desc: 'tipo_conex_literal',
			fieldLabel:'sw_transaccional',
			vtype:'texto',
			fieldLabel:'sw_transaccional',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				
				data :[['1','Movimiento'],['2','Titular']]  
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderSwTranssacionalText,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150,
			disabled:true
		
		},
		tipo:'ComboBox',
		defecto:'1',
		
		form: false,
		filtro_0:true,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'
		
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Consolidación Presupuesto (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	 
	/****************/
	function btn_imprimir()
	{
			/*parametros reporte */	
		var data='start=0';
		 data+='&limit=1000';
		 data+='&CantFiltros='+g_CantFiltros;
		 data+='&tipo_pres='+g_tipo_pres;
		 data+='&id_parametro='+g_id_parametro;
		 data+='&id_moneda='+g_id_moneda;
		 data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;
		 data+='&ids_u_o='+g_ids_u_o;
		 data+='&ids_financiador='+g_ids_financiador;
		 data+='&ids_regional='+g_ids_regional;
		 data+='&ids_programa='+g_ids_programa;
		 data+='&ids_proyecto='+g_ids_proyecto;
		 data+='&ids_actividad='+g_ids_actividad;
		 data+='&sw_vista='+g_sw_vista;
		 data+='&ids_concepto_colectivo='+g_ids_concepto_colectivo; 
		 
 
		if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
		if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
		if(g_colectivo==""){g_colectivo="Todos"}
		
		data+='&regional='+g_regional;
		data+='&financiador='+g_financiador;
		data+='&programa='+g_programa;
		data+='&proyecto='+g_proyecto;
		data+='&actividad='+g_actividad;
		data+='&unidad_organizacional='+g_unidad_organizacional;
		data+='&Fuente_financiamiento='+g_Fuente_financiamiento;
		data+='&colectivo='+g_colectivo;
		data+='&desc_moneda='+g_desc_moneda;
		data+='&desc_pres='+renderTipoPresupuesto(g_tipo_pres);  //g_desc_pres
		data+='&desc_estado_gral='+g_desc_estado_gral;
		data+='&gestion_pres='+g_gestion_pres;
	 	
		//alert(data);
		
		window.open(direccion+'../../../control/consolidacion/ActionReporteConsolidacion.php?'+data);
	}
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
	
	ds_fuente_financiamiento.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_fuente_financiamiento,config_fuente_financiamiento);}
									});

	if(maestro.sw_vista=="formulacion"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'si'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})}
	if(maestro.sw_vista=="aprobacion"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'no'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})}					
									
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
ds_colectivo.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros, 
								estado_colectivo:1,
								sw_combo_consolidacion:'si' 
								},
								callback: function(){padre.AdicionarMenuBoton(ds_colectivo,config_colectivo);}
									});
 
	
//var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
//var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
//var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
//var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
//var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:true});
//var tpl_id_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
//	
var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			,baseParams:{sw_vista:maestro.sw_vista}});
	
var ds_moneda_consulta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
//monedas
var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Moneda...',
			selectOnFocus:true,
			width:78,
			valueField: 'id_moneda',
			tpl:tpl_id_moneda_reg,
			pageSize:5,
			resizable:true,
			minChars:1,
			minListWidth:'255%'
			
		});
//parametro
var parametro =new Ext.form.ComboBox({
			store:ds_parametro,
			displayField: 'gestion_pres',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Gestion...',
			selectOnFocus:true,			
			width:78, 
			valueField:'id_parametro',
			tpl:tpl_id_parametro,
			pageSize:5,
			resizable:true,
			minChars:1,
			minListWidth:'255%'
 		});
 	
 		
var presupuesto_sel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1', 'Recurso'],['2', 'Gasto'],['3', 'Inversión']]}),	typeAhead: true,mode: 'local',triggerAction: 'all',	emptyText:'Presupuesto...',selectOnFocus:true,width:70,valueField:'ID',displayField:'valor',mode:'local'});		
		ds_parametro.load({params:{start:0,limit: 1000000}});
	 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	
		
		parametro.on('select',function (combo, record, index){g_id_parametro=parametro.getValue();g_gestion_pres=record.data['gestion_pres'];menuBotones()});
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_desc_moneda=record.data['nombre'];menuBotones()});
		presupuesto_sel.on('select',function (combo, record, index){g_tipo_pres=presupuesto_sel.getValue();menuBotones()});

	
parametro.setValue(1);
monedas.setValue(1);
presupuesto_sel.setValue(2);


	var sw =0;
	this.btnActualizar=function()
	{					
		//alert("ZZZZZZZZZZZ")
		if(sw==0)
		{
			//console.log('llega .... ')
			ds.load(ds.baseParams)	

			
					
			sw=1;
		}
		else
		{
			CM_btnActualizar();
		}
	}

	
	ds.lastOptions={
			params:{
										
				start:0,
				limit: paramConfig.TamanoPagina,
				//CantFiltros:paramConfig.CantFiltros,
				//tipo_pres:maestro.tipo_pres,
				//id_parametro:maestro.id_parametro,
				//id_moneda:maestro.id_moneda,
				//sw_vista:maestro.sw_vista,
				////fecha_ini:maestro.fecha_ini,
				//fecha_fin:maestro.fecha_fin
			}
	}
	
								
padre.AdicionarBoton('../../../lib/imagenes/print.gif',' ',btn_imprimir,true,'imprimir','');	
this.AdicionarBotonCombo(parametro,'gestion');		
this.AdicionarBotonCombo(presupuesto_sel,'presupuesto_sel');														
this.AdicionarBotonCombo(monedas,'monedas');			
layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})
	
}
