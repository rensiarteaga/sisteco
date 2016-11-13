function EjecucionReporteFecha(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	var id_moneda , id_parametro, id_presupuesto, tipo_presupuesto, f_f,e_p_e,u_o;
		
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
	var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;
	var g_id_presupuesto='';
	//var fecha_fin;	
	
	
	//DATA STORE 		
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo'])
	});	
	
	
	//render
	
		function renderTipoPresupuesto(value, p, record)
		{						
			if(value == 1)
			{return "Recurso"}
			if(value == 2)
			{return "Gasto"}
			if(value == 3)
			{return "Inversión"}
			if(value == 4)
			{return "PNO - Recurso"}
			if(value == 5)
			{return "PNO - Gasto"}
			if(value == 6)
			{return "PNO - Inversión"}
			
			return '';
		}	
		
		function renderPeriodo(value, p, record)
		{
			if(value == 1) {return "Enero"}
			if(value == 2) {return "Febrero"}
			if(value == 3) {return "Marzo"}
			if(value == 4) {return "Abril"}
			if(value == 5) {return "Mayo"}
			if(value == 6) {return "Junio"}
			if(value == 7) {return "Julio"}
			if(value == 8) {return "Agosto"}
			if(value == 9) {return "Septiembre"}
			if(value == 10){return "Octubre"}
			if(value == 11){return "Noviembre"}
			if(value == 12){return "Diciembre"}
			if(value == 13){return "Gestión"}
		}
		
		function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
						
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');																									
	
		
				
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	}; 
	
	// txt tipo_pres  
	 vectorAtributos[1]  = {
		validacion: {
			name:'tipo_pres',			
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:250			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'tipo_pres'		
	};  

	vectorAtributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupue...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',			
			typeAhead:true,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,		
		filterColValue:'UNIORG.nombre_unidad#FUNFIN.denominacion#FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'id_presupuesto'
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'sub_programa',
			fieldLabel:'Sub Programa',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:true,					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false				
	};
	
	vectorAtributos[4]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
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
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width:250,			
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 
	
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha desde',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_desde',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha hasta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion'
	};	
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Consolidación Presupuesto"
	};
	layout_ejecucion_reporte=new DocsLayoutProceso(idContenedor);
	layout_ejecucion_reporte.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ejecucion_reporte,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			}
			
			]
		,
	//};			parametros: '',
			submit:function ()
			{					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";}; 
				if(tipo_presupuesto.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio";};
				if(id_presupuesto.getValue()==""){mensaje+=" El campo Presupuesto esta vacio";};
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				/*if(fecha_desde.getValue()==""){mensaje+=" El campo fecha desde esta vacio";};
				if(fecha_hasta.getValue()==""){mensaje+=" El campo fecha hasta esta vacio";};
				*///if(fecha_fin.getValue()==""){mensaje+=" El campo Fecha Final  esta vacio";};
				//if(periodo.getValue()==""){mensaje+=" El campo Periodo esta vacio";};
				
				if(mensaje=="")
				{							
					var data='start=0';
					 data+='&limit=1000';
					 data+='&CantFiltros='+g_CantFiltros;
					 data+='&tipo_pres='+g_tipo_pres;	//listo
					 data+='&id_parametro='+g_id_parametro;	//listo
					 data+='&id_moneda='+g_id_moneda;	//listo
					 data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;	//listo
					 data+='&ids_u_o='+g_ids_u_o;	//listo
					 data+='&ids_financiador='+g_ids_financiador;	//listo
					 data+='&ids_regional='+g_ids_regional;		//listo
					 data+='&ids_programa='+g_ids_programa;		//listo
					 data+='&ids_proyecto='+g_ids_proyecto;		//listo
					 data+='&ids_actividad='+g_ids_actividad;	//listo
					 data+='&sw_vista='+configConsolidacion.sw_vista;	//lista
					 data+='&ids_concepto_colectivo='+g_ids_concepto_colectivo;
					data+='&fecha_desde='+formatDate(dteFechaDesde.getValue());
					 data+='&fecha_hasta='+formatDate(dteFechaHasta.getValue());	
					 data+='&id_presupuesto='+g_id_presupuesto;//listo
				     //data+='&fecha_hasta='+formatDate(fecha_hasta.getValue());*/
					if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
					if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
					if(g_colectivo==""){g_colectivo="Todos"}
					
					data+='&regional='+g_regional;	//listo
					data+='&financiador='+g_financiador;	//listo
					data+='&programa='+g_programa;	//listo
					data+='&proyecto='+g_proyecto;	//listo
					data+='&actividad='+g_actividad;	//listo
					data+='&unidad_organizacional='+g_unidad_organizacional;	//listo
					data+='&Fuente_financiamiento='+g_Fuente_financiamiento;	//listo
					data+='&colectivo='+g_colectivo;
					data+='&desc_moneda='+g_desc_moneda;	//listo
					data+='&desc_pres='+g_desc_pres;		//listo
					data+='&desc_estado_gral='+g_desc_estado_gral;	//listo
					data+='&gestion_pres='+g_gestion_pres;	//listo
					//data+='&fecha_desde='+g_fecha_desde;
					//alert(data);
					window.open(direccion+'../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php?'+data);					
				}
				else{alert(mensaje);}
			}
	/*	}*/
	}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		tipo_presupuesto = ClaseMadre_getComponente('tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');	
		id_moneda = ClaseMadre_getComponente('id_moneda');	
		//fecha_fin = ClaseMadre_getComponente('fecha_fin');	
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
		gestion=ClaseMadre_getComponente('gestion');
		cmbGestion=ClaseMadre_getComponente('id_parametro');
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
			
		// cmbGestion.on('select',onGestionSelect);
		componentes[0].on('select',evento_parametro);		//parametro		
		componentes[1].on('select',evento_tipo_presupuesto);	//tipo_pres	
		componentes[2].on('select',evento_presupuesto);		//presupuesto
		componentes[4].on('select',evento_moneda);		//moneda
	}
	
	function evento_parametro( combo, record, index )
	{
		g_id_parametro=record.data.id_parametro;
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		
		componentes[2].store.baseParams={sw_reporte_ejecucion:'si',m_id_parametro:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].modificado=true;			
		componentes[2].setValue('');
		
		componentes[3].setValue('');
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		g_tipo_pres=componentes[1].getValue();
		g_desc_pres=renderTipoPresupuesto(g_tipo_pres, '', '');
		
		componentes[2].store.baseParams={sw_reporte_ejecucion:'si',m_id_parametro:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].modificado=true;			
		componentes[2].setValue('');

		componentes[3].setValue('');	
	}
	
	function evento_presupuesto( combo, record, index )
	{
		/*['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
		'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
		'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo'])
		});*/		
		g_id_presupuesto=componentes[2].getValue();
		g_ids_fuente_financiamiento=record.data.id_fuente_financiamiento;
		g_ids_u_o=record.data.id_unidad_organizacional;
		g_ids_financiador=g_proyecto=record.data.id_financiador;
		g_ids_regional=record.data.id_regional;
		g_ids_programa=record.data.id_programa;
		g_ids_proyecto=record.data.id_proyecto;
		g_ids_actividad=record.data.id_actividad;		
 	
	 	g_regional=record.data.nombre_regional;
	 	g_financiador=record.data.nombre_financiador;
	 	g_programa=record.data.nombre_programa;
	 	g_proyecto=record.data.nombre_proyecto;
	 	g_actividad=record.data.nombre_actividad;
	 	g_unidad_organizacional=record.data.desc_unidad_organizacional;
	 	g_Fuente_financiamiento=record.data.denominacion;
	 	g_CantFiltros=1;		
		
		componentes[3].setValue(g_proyecto);
	}
	
	function evento_moneda( combo, record, index )
	{
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;
	}
	/*function evento_fecha_desde( combo, record, index )
	{
		g_fecha_desde=record.data.fecha_desde;
		//g_desc_moneda=record.data.nombre;
	}*/
	/*function cargarPresupuesto()
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
	 	g_ids_concepto_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSelecion();
		g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
		g_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSeleccionadosDesc();
		g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
		g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
		g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
		g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSeleccionadosDesc();
		g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSeleccionadosDesc();
		g_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSeleccionadosDesc();		
	}*/	

	
	/*function btn_imprimir(){
  		
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
	}*/
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
