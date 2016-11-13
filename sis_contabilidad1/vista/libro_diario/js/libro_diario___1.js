/**
* Nombre:		  	    pagina_libro_diario.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function pagina_libro_diario(idContenedor,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var filtro;
	
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

	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarLibroDiario.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[
		'id_comprobante',
		'nro_cbte',
		{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
		'prefijo',
		'nombre_acreedor',
		'aprobacion',
		'concepto_cbte',
		'desc_clase'
		]),remoteSort:true});

		//carga datos XML
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_clase_cbte:maestro.id_clase_cbte,
		m_id_moneda:1,
		m_fecha_inicio:maestro.fecha_inicio,
		m_fecha_fin:maestro.fecha_fin,
		m_tipo_vista:'libro_diario'}});
		//DATA STORE COMBOS

		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
		});

		var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['PERSON_15.apellido_paterno','PERSON_15.apellido_materno','PERSON_15.nombre'])
		});

	/*	var ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','codigo'])
		});*/
		var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
	var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacion.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});

 
	var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
	var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
	var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
	var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
	var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
	var ds_cbte_clase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'},[	'id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento'])});
	var ds_periodo_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema',
		'id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','estado_periodo'])});

	
	
	
	
	padre=this;
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

	function menuBotones()
		{

			g_limit= paramConfig.TamanoPagina;
			g_CantFiltros=paramConfig.CantFiltros;
		//	g_tipo_pres=maestro.tipo_pres;
		//	g_id_parametro=maestro.id_parametro;
			//g_id_moneda=maestro.id_moneda;
			g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSelecion();
	     	g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSelecion();
        	g_ids_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSelecion();
			g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
			g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
			g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
			g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
			//g_id_moneda=padre.getBotonMenuBotonNombre('prueba').menuBoton.getSelecion();
			g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
			g_financiador=padre.getBotonMenuBotonNombre('Financiado').menuBoton.getSeleccionadosDesc();
			g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
			g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
			g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
			g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSeleccionadosDesc();
		    g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSeleccionadosDesc();
		
		//g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
			ds.load({
				params:{
					start:0,
					limit: g_limit,
					CantFiltros:g_CantFiltros,
					//tipo_pres:g_tipo_pres,
				//	id_parametro:g_id_parametro,
				    ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			        ids_u_o:g_ids_u_o,
			    	ids_financiador:g_ids_financiador,
					ids_regional:g_ids_regional,
					ids_programa:g_ids_programa,
					ids_proyecto:g_ids_proyecto,
					ids_actividad:g_ids_actividad,
					m_id_clase_cbte:maestro.id_clase_cbte,
		            m_id_moneda:maestro.id_moneda,
					m_fecha_inicio:maestro.fecha_inicio,
					m_fecha_fin:maestro.fecha_fin,
					m_tipo_vista:'libro_diario'

				}});
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
				




				/*maestro.desc_pres
				var data_maestro=[ ['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(44-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(44-maestro.gestion_pres.length-maestro.desc_estado_gral.length)],
				['Estructura Programatica',epe] ,
				['Estructura Organizacional',g_unidad_organizacional ] ,
				['Fuente de Financiamiento',g_Fuente_financiamiento],
				['Concepto Colectivo',g_colectivo]];
				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));*/
		}



		//FUNCIONES RENDER

	/*	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Esatdo: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
*/
		function render_id_moneda_reg(value, p, record){return String.format('{0}', record.data['desc_moneda']);}




		var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');



		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{PERSON_15.apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.nombre}</FONT>','</div>');

		function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
		var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<b>Código:</b><FONT COLOR="#B5A642">{codigo}</FONT>','<b>Subsistema:</b><FONT COLOR="#B5A642">{nombre_corto}</FONT>','</div>');

		function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clases']);}
		var tpl_id_cbte_clase=new Ext.Template('<div class="search-item">','<b>Calse Cbte: </b><FONT COLOR="#B5A642">{desc_clase}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_clase}</FONT>','</div>');


		/**************/
		function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['periodo_sub']);}

		var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Subsistema: </b><FONT COLOR="#B5A642">{desc_subsistema}</FONT><br>','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo}</FONT>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','</div>');


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_comprobante
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprobante',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_comprobante'
		};
		
		Atributos[1]={
			validacion:{
				name:'prefijo',
				fieldLabel:' ',
				allowBlank:false,
				align:'right',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:30,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			defecto:0,
			form: false,
			filtro_0:true,
			filterColValue:'COMPROB.nro_cbte',
			save_as:'nro_cbte'
		};
		
		// txt nro_cbte
		Atributos[2]={
			validacion:{
				name:'nro_cbte',
				fieldLabel:'Nro.',
				allowBlank:false,
				align:'right',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			defecto:0,
			form: false,
			filtro_0:true,
			filterColValue:'COMPROB.nro_cbte',
			save_as:'nro_cbte'
		};
		
		// txt fecha_cbte
		Atributos[3]= {
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
				width_grid:80,
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
		
		//concepto_cbte
		Atributos[4]={
			validacion:{
				name:'concepto_cbte',
				fieldLabel:'Concepto',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:350,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'COMPRO.concepto_cbte',
			save_as:'concepto_cbte'
		};

		// txt acreedor
		Atributos[5]={
			validacion:{
				name:'nombre_acreedor',
				fieldLabel:'Acreedor',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'COMPROB.nombre_acreedor',
			save_as:'acreedor'
		};
		// txt aprobacion
		Atributos[6]={
			validacion:{
				name:'aprobacion',
				fieldLabel:'Aprobación',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'COMPROB.aprobacion',
			save_as:'aprobacion'
		};
		
		Atributos[7]={
			validacion:{
				name:'desc_clase',
				fieldLabel:'Comprobante',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'COMPRO.concepto_cbte',
			save_as:'desc_clase'
		};
		// txt id_moneda_reg
		Atributos[8]={
			validacion:{
				name:'id_moneda_reg',
				fieldLabel:'Moneda Registro',
				allowBlank:false,
				emptyText:'Moneda Registro...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:true,
				tpl:tpl_id_moneda_reg,
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
				renderer:render_id_moneda_reg,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda_reg'
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'libro_diario',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/libro_diario/libro_diario_transaccion.php'};
		var layout_libro_diario=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_libro_diario.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_libro_diario,idContenedor);
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		//this.pagina(paramConfig,Atributos,ds,layout_solser,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_saveSuccess=this.saveSuccess;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;

		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			//	guardar:{crear:true,separador:false},
			//	nuevo:{crear:true,separador:true},
			//	editar:{crear:true,separador:false},
			//	eliminar:{crear:true,separador:false},
			//	actualizar:{crear:true,separador:false}
		};

		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		this.btnNew=function(){
			g_comprobante='';

			ClaseMadre_btnNew();

		};
		function mostrarActual(resp)
		{


			if(g_comprobante=='')
			{
				alert ("llega a new ");
				ds.load({
					params:{
						start:0,
						limit:paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_sw_maximo:'si'
					}
				})
			}
			else{
				alert ("llega a edit ");
				ds.load({
					params:{
						start:0,
						limit:paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_comprobante:g_comprobante
					}
				});}

				CM_saveSuccess(resp);
		}
		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/comprobante/ActionEliminarRegistroComprobante.php'},
			Save:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php',
			success:mostrarActual
			},
			ConfirmSave:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'libro_diario'}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
		function iniciarEventosFormularios(){
			getSelectionModel().on('rowdeselect',function(){_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.bloquearMenu();});
		}
		function btn_todos(){

			ds.load({
				params:{
					start:0,
					limit:paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			})
		}

		this.EnableSelect=function(sm,row,rec){
			cm_EnableSelect(sm,row,rec);
			_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload(rec.data,prueba.getValue());
			_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.desbloquearMenu();
		}

		/*this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.bloquearMenu();
		//	_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.desbloquearMenu();
		g_comprobante=rec.data.id_comprobante;

		}
		*/
		function btn_reporte_libro_diario(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			//if(NumSelect!=0){

			//	var SelectionsRecord=sm.getSelected();
				//var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;

				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroDiario.php')

			
			/*else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}*/
		}
		function btn_reporte_libro_mayor(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
		
				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayor.php')

		}
		
	 ds_fuente_financiamiento.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_fuente_financiamiento,config_fuente_financiamiento);}
									});
	  ds_unidad_organizacional.load({params:{
	  	                            start:0,
	                                limit: paramConfig.TamanoPagina,
	                                CantFiltros:paramConfig.CantFiltros
	                                },
									callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
									});
		
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
		




		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_libro_diario.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
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
			//  renderer:render_id_moneda
			tpl:tpl_id_moneda_reg
			
		});

		ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
		);
	  /* ds_financiador.load({
		params:{
		start:0,
		limit: 1000000
		//CantFiltros:paramConfig.CantFiltros

		}
		}
		);
*/

		//  padre.AdicionarBotonCombo(prueba,true,'prueba','12');
		// prueba.on('change',_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload(rec.data,prueba.getValue()))
//esto es para el combo y mandarle datos al hijo
		prueba.on('select',

		function(){
			var sm=getSelectionModel();
			var rec=sm.getSelected();
			
			

			if(_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload &&rec){

				_CP.getPagina(layout_libro_diario.getIdContentHijo()).pagina.reload(rec.data,prueba.getValue())

			}

		});


		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		//
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Todos',btn_todos,true,'todos','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
		//this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Mayor',btn_reporte_libro_mayor,true,'reporte_libro_mayor','');
		// this.AdicionarBotonCombo(prueba,'prueba_','prueba_');
		this.AdicionarBotonCombo(prueba,'prueba');
		//this.AdicionarMenuBoton(ds_financiador,config_financiador);


		layout_libro_diario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
