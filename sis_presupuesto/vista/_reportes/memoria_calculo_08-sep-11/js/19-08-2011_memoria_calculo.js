function ReporteMemoriaCalculo(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	var id_moneda , id_parametro, id_presupuesto, id_partida, id_tipo_presupuesto, f_f,e_p_e,u_o;
		
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
	/*var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;*/
	var g_id_presupuesto='';
	var g_id_partida='';
	var g_formato_reporte='';
	var g_tipo_memoria='';	
	var g_memoria='';	
	var g_cod_partida='';
	var g_desc_partida='';
	
	//DATA STORE 		
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			});
			
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo'])
	});	
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/partida/ActionListarPartida.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });

    
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
			if(value == 11){return "noviembre"}
			if(value == 12){return "Diciembre"}
			if(value == 13){return "Gestión"}
		}
		
		function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
						
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
				
		
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
																													'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																													'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');	
																													
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{codigo_partida} - {nombre_partida}</FONT></b><br>',
	                                                                  '<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>',
	                                                                  '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>','</div>');
																																																						
																							
				
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
	
	vectorAtributos[1]={
		validacion:{
			name:'id_tipo_pres',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
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
			renderer:render_id_tipo_pres_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	}; 
	
	// txt tipo_pres  
	/* vectorAtributos[1]  = {
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
	};  */

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
 			name:'id_partida',
			fieldLabel:'Partida ',
			allowBlank:false,			
			//emptyText:'Partida ',
			desc: 'desc_partida', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			//renderer:render_id_partida_origen,
 			grid_visible:true,
 			grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:250,
			disabled:false,
			grid_indice:9		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//id_grupo:2,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};	
	
	vectorAtributos[5]={
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
		defecto: '1',
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 
	
	/*vectorAtributos[6]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha desde',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
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
	vectorAtributos[7]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha hasta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};*/
	
	vectorAtributos[6]={
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
		
	vectorAtributos[7]=
	{
			validacion:{
				name: 'tipo_memoria',
				fieldLabel:'Tipo de Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Resumen General'],['2','Detalle Por Periodo']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opción...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			save_as:'tipo_memoria'
		};
	
		
	vectorAtributos[8]=
	{
			validacion:{
				name: 'formato_reporte',
				fieldLabel:'Formato Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF']]}),				//,['2','Excel']
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opción...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'no',
			save_as:'formato_reporte'
		};
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Detalle Ejecución Partida"
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
	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
				{
					tituloGrupo:'Filtros para Reporte Memoria Cálculo',
					columna:0,
					id_grupo:0
				}			
			],

			submit:function ()
			{					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";}; 
				if(id_tipo_presupuesto.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio";};
				if(id_presupuesto.getValue()==""){mensaje+=" El campo Presupuesto esta vacio";};
				if(id_partida.getValue()==""){mensaje+=" El campo Partida esta vacio";};
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				//if(cmbReporte.getValue()==""){mensaje+=" El campo Tipo Reporte esta vacio";};
				/*if(fecha_desde.getValue()==""){mensaje+=" El campo fecha desde esta vacio";};
				if(fecha_hasta.getValue()==""){mensaje+=" El campo fecha hasta esta vacio";};
				*///if(fecha_fin.getValue()==""){mensaje+=" El campo Fecha Final  esta vacio";};
				//if(periodo.getValue()==""){mensaje+=" El campo Periodo esta vacio";};
				
				if(mensaje=="")
				{							
					var data='start=0';
					 data+='&limit=1000';
					 data+='&CantFiltros='+g_CantFiltros;
					 data+='&id_tipo_pres='+g_id_tipo_pres;	//listo
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
					 /*data+='&fecha_desde='+formatDate(dteFechaDesde.getValue());
					 data+='&fecha_hasta='+formatDate(dteFechaHasta.getValue());*/	
					 data+='&id_presupuesto='+g_id_presupuesto;//listo
					 data+='&id_partida='+g_id_partida;//listo
					 data+='&desc_partida='+g_desc_partida;	//listo
					 data+='&cod_partida='+g_cod_partida;	//listo
					 data+='&formato_reporte='+g_formato_reporte;	//listo
					 data+='&tipo_memoria='+g_tipo_memoria;
					 data+='&memoria='+g_memoria;
				    
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
					
					//alert(data);
					window.open(direccion+'../../../../control/_reportes/memoria_calculo/ActionPDFMemoriaCalculo.php?'+data);					
				}
				else
				{
					alert(mensaje);
				}
			}
	/*	}*/
	}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_presupuesto = ClaseMadre_getComponente('id_tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		id_partida = ClaseMadre_getComponente('id_partida');	
		id_moneda = ClaseMadre_getComponente('id_moneda');		
		/*dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');*/
		gestion=ClaseMadre_getComponente('gestion');
		cmbGestion=ClaseMadre_getComponente('id_parametro');
		cmbReporte=ClaseMadre_getComponente('formato_reporte');
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		var onGestionSelect = function(e) 
		{
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined)
			{
				intGestion=cmbGestion.store.getById(id).data.gestion_pres;
			
				/*dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);*/
				
				//Aplica la validación en la fecha
				/*dteFechaDesde.minValue=dte_fecha_ini_valid;
				dteFechaDesde.maxValue=dte_fecha_fin_valid;
				dteFechaHasta.minValue=dte_fecha_ini_valid;
				dteFechaHasta.maxValue=dte_fecha_fin_valid;*/
				
				//Define un valor por defecto
				/*dteFechaDesde.setValue(dte_fecha_ini_valid);
				dteFechaHasta.setValue(dte_fecha_fin_valid);
				gestion.setValue(cmbGestion.store.getById(id).data.gestion_pres);*/
				//alert(gestion.getValue());
			}
		};		
		
		cmbGestion.on('select',onGestionSelect);
		componentes[0].on('select',evento_parametro);		//parametro		
		componentes[1].on('select',evento_tipo_presupuesto);	//tipo_pres	
		componentes[2].on('select',evento_presupuesto);		//presupuesto
		componentes[4].on('select',evento_partida);		//partida
		componentes[5].on('select',evento_moneda);		//moneda
		componentes[7].on('select',evento_memoria);		//tipo memoria
		componentes[8].on('select',evento_reporte);		//tipo reporte
	}
	
	function evento_parametro( combo, record, index )
	{
		//alert(componentes[0].getValue())
		
		g_id_parametro=record.data.id_parametro;		
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'no'};
		componentes[1].modificado=true;
		componentes[1].setValue('');
		
		componentes[2].store.baseParams={sw_reporte_ejecucion:'si',m_id_parametro:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].modificado=true;			
		componentes[2].setValue('');	
				
		componentes[3].modificado=true;			
		componentes[3].setValue('');	
		
		componentes[4].modificado=true;			
		componentes[4].setValue('');	
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		g_id_tipo_pres=componentes[1].getValue();		
		g_desc_pres=renderTipoPresupuesto(g_id_tipo_pres, '', '');
		
		componentes[2].store.baseParams={sw_reporte_ejecucion:'si',m_id_parametro:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
		componentes[2].modificado=true;			
		componentes[2].setValue('');	
				
		componentes[3].modificado=true;			
		componentes[3].setValue('');	
		
		componentes[4].modificado=true;			
		componentes[4].setValue('');	
	}
	
	function evento_presupuesto( combo, record, index )	
	{
		
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
		
		componentes[4].store.baseParams={sw_traspaso:'si',m_id_presupuesto:record.data.id_presupuesto,m_id_tipo_pres:g_id_tipo_pres,m_id_parametro:g_id_parametro};
		componentes[4].modificado=true;		
		componentes[4].setValue('');
		componentes[4].setDisabled(false);			
	}
	
	function evento_moneda( combo, record, index )
	{
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;
		
		componentes[7].modificado=true;			
		componentes[7].setValue('');	
	}

	function evento_partida( combo, record, index )
	{
		g_id_partida=record.data.id_partida;
		g_desc_partida=record.data.desc_par;
		g_cod_partida = record.data.codigo_partida;
		g_tipo_memoria=record.data.tipo_memoria;
	}
	
	function evento_reporte( combo, record, index )
	{
		g_formato_reporte=record.data.id;
	}
	
	function evento_memoria( combo, record, index )
	{
		g_memoria = record.data.id;
	}
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
