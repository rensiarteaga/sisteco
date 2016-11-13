 /**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaEjecucionPresupuesto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	
	var Atributos=new Array,sw=0;
	var	g_limit=paramConfig.TamanoPagina;
	var	g_CantFiltros='';
	var	g_tipo_pres=maestro.tipo_pres;
	var	g_id_parametro=maestro.id_parametro;
	var	g_id_moneda=maestro.id_moneda;
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';
	var	g_sw_vista=maestro.sw_vista;
	var	g_ids_concepto_colectivo='';
 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';
	var g_colectivo='';
	var g_desc_moneda=maestro.desc_moneda;
	var g_desc_pres=maestro.desc_pres;
	var g_desc_estado_gral=maestro.desc_estado_gral;
	var g_gestion_pres=maestro.gestion_pres;
	var g_fecha_fin=maestro.fecha_fin;
	var g_fecha_ini=maestro.fecha_ini;
	
	var v_regional='';
	var v_financiador='';
	var v_programa='';
	var v_proyecto='';
	var v_actividad='';
	var v_desc_unidad_organizacional='';
	
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
		minValue:0
		}	
	); 	
	
	var marcas_html,div_dlgFrm,dlgFrm;
	var marcas_html_ejecucion,div_dlgFrm_ejecucion,dlgFrmEjecucion;
	var Presupuesto,Moneda,tipoReporte;
	var id_presupuesto_rep,id_moneda_rep,tipoRep;
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ejecucion/ActionListarEjecucion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_partida',
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
		'sw_transaccional',
		'comprometido',
		'revertido',
		'saldo_por_comprometer',		
		'devengado',
		'pagado',
		'saldo_por_devengar',
		'saldo_por_ingresar',
		'traspaso',
		'saldo_por_devengar_ingreso',
		'reformulacion'
		]),remoteSort:true});
	
	//carga datos XML
	/*crea los data store*/
	var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
	var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});
	var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
	var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
	var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
	var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
	var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
	var ds_colectivo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','estado_colectivo','id_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona','desc_usuario','desc_colectivo']),remoteSort:true});
	
	config_fuente_financiamiento={id_menu:idContenedor+"-id_fuente_financiamiento" ,nombre:'Fuente de Financiamiento',descripcion:'denominacion',id:'id_fuente_financiamiento',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_unidad_organizacional={id_menu:idContenedor+"-id_unidad_organizacional",nombre:'Unidad Organizacional',descripcion:'desc_unidad_organizacional',id:'id_unidad_organizacional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_financiador={id_menu:idContenedor+"-id_financiador", nombre:'Financiador',descripcion:'nombre_financiador',id:'id_financiador',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_regional={id_menu:idContenedor+"-id_regional",nombre:'Regional',descripcion:'nombre_regional',id:'id_regional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_programa={id_menu:idContenedor+"-id_programa",nombre:'Programa',descripcion:'nombre_programa',id:'id_programa',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_proyecto={id_menu:idContenedor+"-id_proyecto",nombre:'SubPrograma',descripcion:'nombre_proyecto',id:'id_proyecto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_actividad={id_menu:idContenedor+"-id_actividad",nombre:'Actividad',descripcion:'nombre_actividad',id:'id_actividad',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	config_colectivo={id_menu:idContenedor+"-id_concepto_colectivo",nombre:'Concepto Colectivo',descripcion:'desc_colectivo',id:'id_concepto_colectivo',selectAceptar:true,selectTodo:true,selectLimpiar:false,funcion:menuBotones};
	
	function menuBotones()
	{
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	g_tipo_pres=maestro.tipo_pres;
	 	g_id_parametro=maestro.id_parametro;
	 	g_id_moneda=maestro.id_moneda;
	 	g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSelecion();
	 	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSelecion();
	 	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSelecion();
	 	g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
	 	g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
	 	g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
	 	g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
	 	g_sw_vista=maestro.sw_vista;
	 	g_fecha_fin= maestro.fecha_fin;
		g_fecha_ini= maestro.fecha_ini;
	 	g_ids_concepto_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSelecion();
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSeleccionadosDesc();
		g_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSeleccionadosDesc();
		
		
		ds.baseParams={start:0,
			limit: paramConfig.TamanoPagina,
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
			fecha_fin:g_fecha_fin,
			fecha_ini:g_fecha_ini,
			ids_concepto_colectivo:g_ids_concepto_colectivo};
		/*ds.load({
		params:{
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
			fecha_fin:g_fecha_fin,
			ids_concepto_colectivo:g_ids_concepto_colectivo
		}});*/
		var epe=" ";
		if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
		if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
		if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
		if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
		if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
		if(epe==" "){epe="Todos"}
		if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
		if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
		if(g_colectivo==""){g_colectivo="Todos"}
	
		//maestro.desc_pres
		var data_maestro=[['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(20-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(20-maestro.gestion_pres.length-maestro.desc_estado_gral.length),'Fecha Ini',maestro.fecha_ini+tabular(20-maestro.fecha_ini.length),'Fecha Fin',maestro.fecha_fin+tabular(20-maestro.fecha_fin.length)],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente de Financiamiento',g_Fuente_financiamiento],
					   ['Concepto Colectivo',g_colectivo]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}

	function MaestroJulio(data){
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
	{ 	if (n>=0)	{return "  "+tabular(n-1)}
		else return "  "
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(20-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(20-maestro.gestion_pres.length-maestro.desc_estado_gral.length),'Fecha Ini',maestro.fecha_ini+tabular(20-maestro.fecha_ini.length),'Fecha Fin',maestro.fecha_fin+tabular(20-maestro.fecha_fin.length)],
					   ['Estructura Programatica','Todos'] ,
					   ['Estructura Organizacional','Todos' ] ,
					   ['Fuente de Financiamiento','Todos'],
					   ['Concepto Colectivo','Todos']
					   ];
					   
    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
			});

	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'}		
			,['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad',
						'nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo']),
			baseParams:{sw_traspaso:'si',m_id_parametro:maestro.id_parametro,m_tipo_pres:maestro.tipo_pres}	//,m_id_unidad_organizacional:4
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
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');
	
		
		function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
		var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');
		
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
		function renderTipoMemoria(value, p, record){
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
		
		function renderSwTranssacional(value,cell,record,row,colum,store)
		{		
			if(store.getAt(row).data['sw_transaccional'] == 1)
			{
				return  '<span style="color:green;">' +monedas_for.formatMoneda(value)+'</span>'
			}	
			if(store.getAt(row).data['sw_transaccional'] == 2)
			{
				return monedas_for.formatMoneda(value)
			}
		}
		function renderSwTranssacionalText(value,cell,record,row,colum,store)
		{		
			if(store.getAt(row).data['sw_transaccional'] == 1)
			{
				return  '<span style="color:green;">' +value+'</span>'
			}	
			if(store.getAt(row).data['sw_transaccional'] == 2)
			{
				return (value)
			}
		}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
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
			fieldLabel:'Partida',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'50%',
			renderer: renderSwTranssacionalText,
			grid_indice:1,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'codigo_partida',
		save_as:'codigo_partida'
	};
// txt id_partida
	Atributos[2]={
			validacion:{
			name:'id_partida',
			fieldLabel:'Descripción',
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
			width_grid:370,
			width:'100%',
			grid_indice:2,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_partida',
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
			allowDecimals:true,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			grid_visible:false,
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
			fieldLabel:'Presupuestado',
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
			grid_indice:3,
			disabled:false		
		},
		tipo: 'MonedaField',
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
		filtro_0:false,
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
		filtro_0:false,
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
		filtro_0:false,
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
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150,
			disabled:true
		},
		tipo:'ComboBox',
		defecto:'1',
		form: false,
		save_as:'estado_pres'
		}; 
		
	Atributos[22] = {
		validacion: {
			name:'sw_transaccional',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Sw Transaccional',
			vtype:'texto',			
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
			//renderer: renderSwTranssacional,
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
		filtro_0:false,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'
	};
// txt total
	/**********/
	Atributos[23]={
		validacion:{
			name:'traspaso',
			fieldLabel:'Traspaso',
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
			grid_indice:4,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.traspaso',
		save_as:'total'
	};
	Atributos[24]={
		validacion:{
			name:'comprometido',
			fieldLabel:'Comprometido',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.comprometido',
		save_as:'total'
	};
	if(maestro.tipo_pres==1){Atributos[24].validacion.grid_visible=false}

	
	
	Atributos[25]={
		validacion:{
			name:'revertido',
			fieldLabel:'Revertido',
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
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.revertido',
		save_as:'revertido'
	};
	
	Atributos[26]={
		validacion:{
			name:'devengado',
			fieldLabel:'Devengado',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.devengado',
		save_as:'devengado'
	};

	Atributos[27]={
		validacion:{
			name:'pagado',
			fieldLabel:'Pagado',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.pagado',
		save_as:'pagado'
	};
	
	if(maestro.tipo_pres==1){Atributos[27].validacion.fieldLabel='Ingresado'}			 
		Atributos[28]={
		validacion:{
			name:'saldo_por_comprometer',
			fieldLabel:'Saldo Por Comprometer',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo_por_devengar',
		save_as:'saldo_por_comprometer'
	};	
	if(maestro.tipo_pres==1){Atributos[28].validacion.grid_visible=false}
	Atributos[29]={
		validacion:{
			name:'saldo_por_devengar',
			fieldLabel:'Saldo Por Devengar',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo_por_devengar',
		save_as:'saldo_por_devengar'
	};		
	Atributos[30]={
		validacion:{
			name:'saldo_por_devengar_ingreso',
			fieldLabel:'Saldo Por Devengar',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo_por_devengar',
		save_as:'saldo_por_devengar'
	};		
if(maestro.tipo_pres==1){Atributos[29].validacion.grid_visible=false};
if(maestro.tipo_pres!=1){Atributos[30].validacion.grid_visible=false};
	// txt 'saldo_por_ingresar'
	Atributos[31]={
		validacion:{
			name:'saldo_por_ingresar',
			fieldLabel:'Saldo Por Ingresar',
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
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo_por_ingresar',
		save_as:'saldo_por_ingresar'
	};

	Atributos[32]={
		validacion:{
			name:'reformulacion',
			fieldLabel:'Reformulación',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			//minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: renderSwTranssacional,
			width_grid:100,
			width:'100%',
			grid_indice:5,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.reformulacion',
		save_as:'total'
	};
	
	if(maestro.tipo_pres!=1){Atributos[31].validacion.fieldLabel='Saldo por Pagar'}		
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatDateBase(value){return value?value.dateFormat('m/d/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Ejecución Presupuesto (Detalle)',grid_maestro:'grid-'+idContenedor};
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

		
	function btn_imprimir(){
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
		 data+='&fecha_fin='+g_fecha_fin;
		 data+='&fecha_ini='+g_fecha_ini;
	 
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
		data+='&desc_pres='+g_desc_pres;
		data+='&desc_estado_gral='+g_desc_estado_gral;
		data+='&gestion_pres='+g_gestion_pres;
		window.open(direccion+'../../../control/ejecucion/ActionReporteEjecucion.php?'+data);
	}
	
	function crearDialogMoneda()
	{
		 marcas_html="<div class='x-dlg-hd'>"+'Parametros de Reporte'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		 div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		 var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:100
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:50,
			width:400,
			height:200,
			minWidth:paramFunciones.Formulario.minWidth,
			minHeight:paramFunciones.Formulario.minHeight,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);		
		
		dlgFrm.addButton('Generar',btn_imprimir_memoria_calculo);			
		dlgFrm.addButton('Cancelar',ocultarFrm);
		
		Presupuesto=new Ext.form.ComboBox({
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,
			emptyText:'Presupuesto...',
			store:ds_presupuesto,
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
			queryParam:'filterValue_0',
			valueField:'id_presupuesto',
			onSelect: function(record){v_financiador=record.data.nombre_financiador;
										v_regional=record.data.nombre_regional;
										v_programa=record.data.nombre_programa;
										v_proyecto=record.data.nombre_proyecto;
										v_actividad=record.data.nombre_actividad;
										v_desc_unidad_organizacional=record.data.desc_unidad_organizacional;
										Presupuesto.setValue(record.data.id_presupuesto);
										Presupuesto.collapse();},
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_presupuesto,
			displayField:'desc_unidad_organizacional',
			triggerAction:'all',
			pageSize:100,
			minChars:3,
			mode:'remote',
			width:220
		});
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
		Formulario.fieldset({legend:'Parametros de Reporte'},Presupuesto,Moneda,tipoReporte);
		Formulario.render("form-ct2_"+idContenedor)
	}
	
	function ocultarFrm(){dlgFrm.hide()}
	
	function crearDialogEjecucion()
	{
		 marcas_html_ejecucion="<div class='x-dlg-hd'>"+'Parametros de Reporte'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		 div_dlgFrm_ejecucion=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrmEjecucion'+idContenedor,html:marcas_html});
		 var FormularioEjec=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:150	//para aumentar el espacion del texto
		});
		dlgFrmEjecucion=new Ext.BasicDialog(div_dlgFrm_ejecucion,{
			modal:true,
			labelWidth:100,
			width:400,
			height:200,
			minWidth:paramFunciones.FormularioEjec.minWidth,
			minHeight:paramFunciones.FormularioEjec.minHeight,
			closable:paramFunciones.FormularioEjec.closable
		});
		dlgFrmEjecucion.addKeyListener(27,paramFunciones.FormularioEjec.cancelar);		
		
		dlgFrmEjecucion.addButton('Generar',btn_imprimir_ejecucion);			
		dlgFrmEjecucion.addButton('Cancelar',ocultarFrmEjecucion);
		
		Presupuesto=new Ext.form.ComboBox({
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,
			emptyText:'Presupuesto...',
			store:ds_presupuesto,
			filterCol:'UNIORG.nombre_unidad',
			queryParam:'filterValue_0',
			valueField:'id_presupuesto',
			onSelect: function(record){v_financiador=record.data.nombre_financiador;
										v_regional=record.data.nombre_regional;
										v_programa=record.data.nombre_programa;
										v_proyecto=record.data.nombre_proyecto;
										v_actividad=record.data.nombre_actividad;
										v_desc_unidad_organizacional=record.data.desc_unidad_organizacional;
										Presupuesto.setValue(record.data.id_presupuesto);
										Presupuesto.collapse();},
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_presupuesto,
			displayField:'desc_unidad_organizacional',
			triggerAction:'all',
			pageSize:100,
			minChars:3,
			mode:'remote',
			width:220
		});
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
		/*tipoReporte=new Ext.form.ComboBox({
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
		});*/
		FormularioEjec.fieldset({legend:'Parametros de Reporte'},Presupuesto,Moneda/*,tipoReporte*/);
		FormularioEjec.render("form-ct2_"+idContenedor)
	}
	
	function ocultarFrmEjecucion(){dlgFrmEjecucion.hide()}
	
	function btnMemoria()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		var sw=false;
		
		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.sw_transaccional==2){
				Ext.MessageBox.alert('...', 'La partida seleccionada no es una partida de movimiento.')
			}
			else{
				if(SelectionsRecord.data.total==0){
					Ext.MessageBox.alert('...', 'La partida seleccionada no tiene memorias de cálculo, el importe presupuestado es 0.')
				}
				else{
					dlgFrm.show()
				}	
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una partida de movimiento.')
		}
	}
	
	function btn_imprimir_memoria_calculo()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		id_presupuesto_rep=Presupuesto.getValue();
		id_moneda_rep=Moneda.getValue();
		tipoRep=tipoReporte.getValue();
		 
		dlgFrm.hide();
		
		if(NumSelect!=0){
			/*if(SelectionsRecord.data.sw_transaccional==2){
				Ext.MessageBox.alert('...', 'La Partida seleccionada no es una partida de movimiento.')
			}
			else{*/
				if(SelectionsRecord.data.total==0){
					Ext.MessageBox.alert('...', 'La Partida seleccionada no tiene Memorias de Cálculo.')
				}
				else{
					//memoria gasto=2 
					if(SelectionsRecord.data.tipo_memoria==2){
					
				      var data='&id_presupuesto='+id_presupuesto_rep;
		 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
		 	   	      data+='&nombre_financiador='+v_financiador;
				   	  data+='&nombre_regional='+v_regional;
			 	   	  data+='&nombre_programa='+v_programa;
			 	   	  data+='&nombre_proyecto='+v_proyecto;
			 	      data+='&nombre_actividad='+v_actividad;
			 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
			   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
			   	      data+='&id_moneda='+id_moneda_rep;
	   	              data+='&tipo_reporte='+tipoRep;
	   	              data+='&ejecucion='+1;
				   	   			   	   
				   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoGasto.php?'+data)	
				     }
				    else{
				    	//memoria recursos humanos=6
				    	if(SelectionsRecord.data.tipo_memoria==6){			   
					       var data='&id_presupuesto='+id_presupuesto_rep;
			 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
			 	   	      data+='&nombre_financiador='+v_financiador;
					   	  data+='&nombre_regional='+v_regional;
				 	   	  data+='&nombre_programa='+v_programa;
				 	   	  data+='&nombre_proyecto='+v_proyecto;
				 	      data+='&nombre_actividad='+v_actividad;
				 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
				   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
				   	      data+='&id_moneda='+id_moneda_rep;
		   	              data+='&tipo_reporte='+tipoRep;
		   	              data+='&ejecucion='+1;
					   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoRRHH.php?'+data)	
					     }
					    else{
						   //memoria otros=8
					    	if(SelectionsRecord.data.tipo_memoria==8){		
					    		
						       var data='&id_presupuesto='+id_presupuesto_rep;
				 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
				 	   	      data+='&nombre_financiador='+v_financiador;
						   	  data+='&nombre_regional='+v_regional;
					 	   	  data+='&nombre_programa='+v_programa;
					 	   	  data+='&nombre_proyecto='+v_proyecto;
					 	      data+='&nombre_actividad='+v_actividad;
					 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
					   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
					   	      data+='&id_moneda='+id_moneda_rep;
			   	              data+='&tipo_reporte='+tipoRep;
			   	              data+='&ejecucion='+1;
						   	   window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoOtros.php?'+data)	
						     }
						    else{
						    	//memoria servicios	7
							   if(SelectionsRecord.data.tipo_memoria==7){
							   	  var data='&id_presupuesto='+id_presupuesto_rep;
					 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
					 	   	      data+='&nombre_financiador='+v_financiador;
							   	  data+='&nombre_regional='+v_regional;
						 	   	  data+='&nombre_programa='+v_programa;
						 	   	  data+='&nombre_proyecto='+v_proyecto;
						 	      data+='&nombre_actividad='+v_actividad;
						 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
						   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
						   	      data+='&id_moneda='+id_moneda_rep;
				   	              data+='&tipo_reporte='+tipoRep;
				   	              data+='&ejecucion='+1;
						   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoServicio.php?'+data)
							   }
							   else{
								   //memoria recursos 1
								   if(SelectionsRecord.data.tipo_memoria==1){
								   	  var data='&id_presupuesto='+id_presupuesto_rep;
						 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
						 	   	      data+='&nombre_financiador='+v_financiador;
								   	  data+='&nombre_regional='+v_regional;
							 	   	  data+='&nombre_programa='+v_programa;
							 	   	  data+='&nombre_proyecto='+v_proyecto;
							 	      data+='&nombre_actividad='+v_actividad;
							 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
							   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
							   	      data+='&id_moneda='+id_moneda_rep;
					   	              data+='&tipo_reporte='+tipoRep;
					   	              data+='&ejecucion='+1;
							   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoIngreso.php?'+data)
								   }
								   else{
									   //memoria pasaje 4
									   if(SelectionsRecord.data.tipo_memoria==4){
									   	  var data='&id_presupuesto='+id_presupuesto_rep;
							 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
							 	   	      data+='&nombre_financiador='+v_financiador;
									   	  data+='&nombre_regional='+v_regional;
								 	   	  data+='&nombre_programa='+v_programa;
								 	   	  data+='&nombre_proyecto='+v_proyecto;
								 	      data+='&nombre_actividad='+v_actividad;
								 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
								   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
								   	      data+='&id_moneda='+id_moneda_rep;
						   	              data+='&tipo_reporte='+tipoRep;
						   	              data+='&ejecucion='+1;
								   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoPasaje.php?'+data)
									   }
									   else{
										   //memoria viaje 5
										   if(SelectionsRecord.data.tipo_memoria==5){
											  var data='&id_presupuesto='+id_presupuesto_rep;
								 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
								 	   	      data+='&nombre_financiador='+v_financiador;
										   	  data+='&nombre_regional='+v_regional;
									 	   	  data+='&nombre_programa='+v_programa;
									 	   	  data+='&nombre_proyecto='+v_proyecto;
									 	      data+='&nombre_actividad='+v_actividad;
									 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
									   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
									   	      data+='&id_moneda='+id_moneda_rep;
							   	              data+='&tipo_reporte='+tipoRep;
							   	              data+='&ejecucion='+1;
									   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoViaje.php?'+data)
										   }
										   else{
										   		//memoria de inversion 3
										   		if(SelectionsRecord.data.tipo_memoria==3){
													//alert(id_moneda_rep);
												      var data='&id_presupuesto='+id_presupuesto_rep;
										 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
										 	   	      data+='&nombre_financiador='+v_financiador;
												   	  data+='&nombre_regional='+v_regional;
											 	   	  data+='&nombre_programa='+v_programa;
											 	   	  data+='&nombre_proyecto='+v_proyecto;
											 	      data+='&nombre_actividad='+v_actividad;
											 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
											   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
											   	      data+='&id_moneda='+id_moneda_rep;
									   	              data+='&tipo_reporte='+tipoRep;
									   	              data+='&ejecucion='+1;
											   	   			   	   
											   	      window.open(direccion+'../../../control/_reportes/memoria_calculo/MemoriaCalculoInversion.php?'+data)	
											     }
										   		else{
										   	   		//memoria de combustibles 9
										   			if(SelectionsRecord.data.tipo_memoria==9){
													//alert(id_moneda_rep);
											       		  var data='&id_presupuesto='+id_presupuesto_rep;
											 	   	      data+='&tipo_memoria='+SelectionsRecord.data.tipo_memoria;							 	   	      
											 	   	      data+='&nombre_financiador='+v_financiador;
													   	  data+='&nombre_regional='+v_regional;
												 	   	  data+='&nombre_programa='+v_programa;
												 	   	  data+='&nombre_proyecto='+v_proyecto;
												 	      data+='&nombre_actividad='+v_actividad;
												 	   	  data+='&desc_unidad_organizacional='+v_desc_unidad_organizacional;							 	   	      			
												   	      data+='&id_partida='+SelectionsRecord.data.id_partida;
												   	      data+='&id_moneda='+id_moneda_rep;
										   	              data+='&tipo_reporte='+tipoRep;
										   	              data+='&ejecucion='+1;
											   	   			   	   
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
			//}
		}
		else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar una partida de movimiento.')
		}
	}
	
	function btnEjecucion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		var sw=false;
		
		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.sw_transaccional==2){
				Ext.MessageBox.alert('...', 'La partida seleccionada no es una partida de movimiento.')
			}
			else{
				if(SelectionsRecord.data.total==0){
					Ext.MessageBox.alert('...', 'La partida seleccionada aun no fue ejecutada, el importe ejecutado es 0.')
				}
				else{
					//dlgFrmEjecucion.show()
				}	
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una partida de movimiento.')
		}
	}
	
	function btn_imprimir_ejecucion()
	{}
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));					
		
	   	maestro.id_parametro=datos.m_id_parametro;
       	maestro.fecha_inicio=datos.m_fecha_inicio;       
       	maestro.id_moneda=datos.m_id_moneda;			       				       	
       	
       	maestro.desc_moneda=datos.m_desc_moneda;
		maestro.desc_pres=datos.m_desc_pres;
		maestro.desc_estado_gral=datos.m_desc_estado_gral;
		maestro.gestion_pres=datos.m_gestion_pres;
		maestro.fecha_fin=datos.m_fecha_fin;
		maestro.fecha_ini=datos.m_fecha_ini;
		
			/*g_tipo_pres=maestro.tipo_pres;
			g_id_parametro=maestro.id_parametro;
			g_id_moneda=maestro.id_moneda;
			g_sw_vista=maestro.sw_vista;
			g_desc_moneda=maestro.desc_moneda;
			g_desc_pres=maestro.desc_pres;
			g_desc_estado_gral=maestro.desc_estado_gral;
			g_gestion_pres=maestro.gestion_pres;
			g_fecha_fin=maestro.fecha_fin;
			g_fecha_ini=maestro.fecha_ini;*/
			
       		       	       	       	     	
		
		g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	g_tipo_pres=maestro.tipo_pres;
	 	g_id_parametro=maestro.id_parametro;
	 	g_id_moneda=maestro.id_moneda;
	 	g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSelecion();
	 	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSelecion();
	 	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSelecion();
	 	g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
	 	g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
	 	g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
	 	g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
	 	g_sw_vista=maestro.sw_vista;
	 	g_fecha_fin= maestro.fecha_fin;
		g_fecha_ini= maestro.fecha_ini;
	 	g_ids_concepto_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSelecion();
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSeleccionadosDesc();
		g_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSeleccionadosDesc();
		
		
		ds.baseParams={start:0,
			limit: paramConfig.TamanoPagina,
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
			fecha_fin:g_fecha_fin,
			fecha_ini:g_fecha_ini,
			ids_concepto_colectivo:g_ids_concepto_colectivo};
		
		epe=" ";
		if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
		if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
		if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
		if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
		if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
		if(epe==" "){epe="Todos"}
		if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
		if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
		if(g_colectivo==""){g_colectivo="Todos"}
		
		data_maestro=[['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(20-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(20-maestro.gestion_pres.length-maestro.desc_estado_gral.length),'Fecha Ini',maestro.fecha_ini+tabular(20-maestro.fecha_ini.length),'Fecha Fin',maestro.fecha_fin+tabular(20-maestro.fecha_fin.length)],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente de Financiamiento',g_Fuente_financiamiento],
					   ['Concepto Colectivo',g_colectivo]];
					   
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		//this.btnActualizar()
		//CM_btnActualizar()
	};
	
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	var sw =0;
	this.btnActualizar=function()
	{					
		//alert("ZZZZZZZZZZZ")
		if(sw==0)
		{
			ds.load({params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				tipo_pres:maestro.tipo_pres,
				id_parametro:maestro.id_parametro,
				id_moneda:maestro.id_moneda,
				sw_vista:maestro.sw_vista,
				fecha_fin: maestro.fecha_fin,
				fecha_ini: maestro.fecha_ini
			}})						
			sw=1;
		}
		else
		{
			CM_btnActualizar();
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_consolidacionPresupuesto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//alert(" creo la barra menu ");
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

	if(maestro.sw_vista=="unidad"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'si'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})}
	if(maestro.sw_vista=="general"){ 
	ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'no'},
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									})}					
									
	ds_financiador.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros
							 
								},
								//alert("cargo el data estore financiador");
								callback: function(){padre.AdicionarMenuBoton(ds_financiador,config_financiador);
//									alert("cargo el data estore financiador");
								}
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
/*
ds.baseParams={
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo_pres:maestro.tipo_pres,
			id_parametro:maestro.id_parametro,
			id_moneda:maestro.id_moneda,
			sw_vista:maestro.sw_vista,
			fecha_fin: maestro.fecha_fin,
			fecha_ini: maestro.fecha_ini 
		}	*/									
	/*ds.load({params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo_pres:maestro.tipo_pres,
			id_parametro:maestro.id_parametro,
			id_moneda:maestro.id_moneda,
			sw_vista:maestro.sw_vista,
			fecha_fin: maestro.fecha_fin 
		}
	});	*/																
									
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el listado de la pantalla',btn_imprimir,true,'imprimir','Imprimir');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el detalle de la Memoria de Cálculo',btnMemoria,true,'imp_mem_calculo','Memoria');
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el detalle de la ejecucion',btnEjecucion,true,'imp_ejecucion','Ejecución');
	crearDialogMoneda();
	//crearDialogEjecucion();
	layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);	
}