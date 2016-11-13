function FormulacionReporte(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	var id_moneda , id_parametro, id_presupuesto, id_tipo_pres, f_f,e_p_e,u_o;
		
	var	g_CantFiltros='';
	var	g_id_tipo_pres='';
	var	g_id_parametro='';
	var	g_id_moneda='';
	var	g_id_presupuesto='';
	var	g_id_unidad_organizacional='';
	var	g_id_proyecto='';
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
	//var g_fecha_fin='';
	
	
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
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto'])
	});	
	 var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});	
	
	
	 var ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/proyecto/ActionListarProyecto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords: 'TotalCount'},['id_proyecto',
			'codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro']), baseParams:{tipo_vista:'formulario_ejecucion'}
	});	
	
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','<br><FONT COLOR="#B50000"><b>{nombre_nivel}</b></FONT>','</div>');
	var tpl_proyecto=new Ext.Template('<div class="search-item">','<b><i>{nombre_proyecto}</b></i>','<br><FONT COLOR="#B50000"><b>{codigo_proyecto}</b></FONT>','</div>');


	
	
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
	
		

																													
	vectorAtributos[0]={
		validacion:{
			name:'reporte',
			fieldLabel:'Formulacion vs Ejecución',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Presupuesto'],['1','Unidad Organizacional'],['2','Proyecto']]}),
		
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		//defecto:'PDF',
		save_as:'reporte'
	};
																		
   vectorAtributos[1]={
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

	
	vectorAtributos[2]={
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
		id_grupo:0,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	}; 
	
	
	
	vectorAtributos[3]={
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
		id_grupo:1,	
		filterColValue:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
		save_as:'id_presupuesto'
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
	vectorAtributos[5]={
		validacion:{
			name:'tipo_impresion',
			fieldLabel:'Tipo de Impresión',
			vtype:'texto',
			emptyText:'Elija el Tipo de Impresion...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','PDF'],['1','Word'],['2','Excel']]}),
		
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		//defecto:'PDF',
		save_as:'tipo_impresion'
	};

		vectorAtributos[6]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Resumen Global'],['1','Resumen Global a Detalle']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:4,
	    defecto:'Resumen Global',
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[7]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc:'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_unidad_organizacional',
		id_grupo:2
	};
		vectorAtributos[8]={
			validacion:{
			name:'id_proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,			
			emptyText:'Proyecto...',
			desc:'nombre_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
		    filterCol:'PROYEC.codigo_proyecto#PROYEC.nombre_proyecto',
			typeAhead:false,
			tpl:tpl_proyecto,
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_proyecto',
		id_grupo:3
	};
	vectorAtributos[9]={
		validacion:{
			name:'tipo_grafico',
			fieldLabel:'Gráfico',
			vtype:'texto',
			emptyText:'Elija el Tipo de Gráfico...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Lineas'],['1','Barras']]}),
		
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		//defecto:'PDF',
		save_as:'tipo_grafico'
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
	layout_formulacion_reporte=new DocsLayoutProceso(idContenedor);
	layout_formulacion_reporte.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_formulacion_reporte,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:['40%','40%'],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			},
			
			{
				tituloGrupo:'Presupuesto',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Unidad Organizacional',
				columna:1,
				id_grupo:2
			},
			{
				tituloGrupo:'Proyecto',
				columna:1,
				id_grupo:3
			},
			{
				tituloGrupo:'Reporte',
				columna:1,
				id_grupo:4
			}
			
			
			
			
			],
			parametros: '',
			submit:function ()
			{					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";}; 
				if(id_tipo_pres.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio";};
				//if(id_presupuesto.getValue()==""){mensaje+=" El campo Presupuesto esta vacio";};
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				
				
				
				
				
				
				
				//if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				//if(fecha_fin.getValue()==""){mensaje+=" El campo Fecha Final  esta vacio";};
				//if(periodo.getValue()==""){mensaje+=" El campo Periodo esta vacio";};
				
				if(mensaje=="")
				{							
					var data='start=0';
					 data+='&limit=1000';
					 data+='&CantFiltros='+g_CantFiltros;
					 data+='&tipo_pres='+g_id_tipo_pres;	//listo
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
					 //data+='&fecha_fin='+formatDate(fecha_fin.getValue());	//listo
				 
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
					data+='&id_presupuesto='+g_id_presupuesto;	//listo
					data+='&id_unidad_organizacional='+g_id_unidad_organizacional;	//listo
					data+='&id_proyecto='+g_id_proyecto;	//listo
					data+='&tipo_reporte='+tipo_reporte.getValue();	//listo
					data+='&tipo_impresion='+tipo_impresion.getValue();	//listo
					data+='&tipo_grafico='+tipo_grafico.getValue();	//listo
					
					/*alert(id_presupuesto.getValue());
					alert(ClaseMadre_getComponente('id_presupuesto').getValue());
				*/	//window.open(direccion+'../../../control/ejecucion/ActionReporteEjecucion.php?'+data);
				//	window.open(direccion+'../../../../control/_reportes/formulacion_ejecucion/ActionReporteFormulacionEjecucion.php?'+data);	
				    if (ClaseMadre_getComponente('reporte').getValue()=='0'){
				        window.open(direccion+'../../../../control/_reportes/formulacion_ejecucion/ActionPDFFormulacionEjecucion.php?'+data);		
				    }else if(ClaseMadre_getComponente('reporte').getValue()=='1'){
				    	 window.open(direccion+'../../../../control/_reportes/formulacion_ejecucion/ActionPDFFormulacionEjecucion_x_uo.php?'+data);		
				    }else{
				    	 window.open(direccion+'../../../../control/_reportes/formulacion_ejecucion/ActionPDFFormulacionEjecucion_x_proy.php?'+data);		
				    }
					
					
					
					//window.open(direccion+'../../../../control/_reportes/formulacion_ejecucion/ActionPDFFormulacionEjecucionSumTotal.php?'+data);	
					
					
					
					
									
				}
				else{alert(mensaje);}
			}
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');	
		id_moneda = ClaseMadre_getComponente('id_moneda');	
		tipo_reporte = ClaseMadre_getComponente('tipo_reporte');	
        tipo_impresion = ClaseMadre_getComponente('tipo_impresion');
        tipo_grafico = ClaseMadre_getComponente('tipo_grafico');	 	 			
		//fecha_fin = ClaseMadre_getComponente('fecha_fin');
		tipo_grafico.setValue(0);
		tipo_grafico.setRawValue('Lineas');	
		
		tipo_impresion.setValue(0);
		tipo_impresion.setRawValue('PDF');	
		
		tipo_reporte.setValue(0);
		tipo_reporte.setRawValue('Resumen Global');	
		CM_ocultarGrupo('Reporte');
		CM_ocultarGrupo('Presupuesto');
		CM_ocultarGrupo('Unidad Organizacional');
		CM_ocultarGrupo('Proyecto');
		
		ClaseMadre_getComponente('id_unidad_organizacional').disabled=true;
		ClaseMadre_getComponente('id_proyecto').disabled=true;
		ClaseMadre_getComponente('id_presupuesto').disabled=true;
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		ClaseMadre_getComponente('id_parametro').on('select',evento_parametro);		//parametro		
		ClaseMadre_getComponente('id_tipo_pres').on('select',evento_tipo_presupuesto);	//tipo_pres	
		ClaseMadre_getComponente('id_presupuesto').on('select',evento_presupuesto);		//presupuesto
		ClaseMadre_getComponente('id_moneda').on('select',evento_moneda);		//moneda
		
		ClaseMadre_getComponente('reporte').on('select',evento_reporte);
		ClaseMadre_getComponente('id_unidad_organizacional').on('select',evento_unidad_organizacional);
		ClaseMadre_getComponente('id_proyecto').on('select',evento_proyecto);
	}
	
	  function evento_reporte(combo,record,index){
	  			//alert(ClaseMadre_getComponente('reporte').getValue());
	  			//alert(record.data.ID);
	  	if (record.data.ID=='0'){
	  		ClaseMadre_getComponente('id_unidad_organizacional').reset();
	  		ClaseMadre_getComponente('id_proyecto').reset();
		    CM_mostrarGrupo('Presupuesto');	
		    CM_ocultarGrupo('Proyecto');
		    CM_ocultarGrupo('Unidad Organizacional');
		    ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
	  		ClaseMadre_getComponente('id_proyecto').allowBlank=true;
	  		CM_ocultarGrupo('Reporte');
		}else if (record.data.ID=='1'){
			ClaseMadre_getComponente('id_presupuesto').reset();
	  		ClaseMadre_getComponente('id_proyecto').reset();
			CM_mostrarGrupo('Unidad Organizacional');
			  CM_ocultarGrupo('Proyecto');
		    CM_ocultarGrupo('Presupuesto');
		    ClaseMadre_getComponente('id_presupuesto').allowBlank=true;
	  		ClaseMadre_getComponente('id_proyecto').allowBlank=true;
	  			CM_ocultarGrupo('Reporte');
		}else if (record.data.ID=='2'){
			ClaseMadre_getComponente('id_unidad_organizacional').reset();
	  		ClaseMadre_getComponente('id_presupuesto').reset();
		  
		    CM_mostrarGrupo('Proyecto');
		    CM_ocultarGrupo('Presupuesto');
		    CM_ocultarGrupo('Unidad Organizacional');
		    ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
	  		ClaseMadre_getComponente('id_presupuesto').allowBlank=true;
	  		
	  			CM_ocultarGrupo('Reporte');
		}
			// componentes[6].reset();
			//CM_ocultarGrupo('Reporte');
			//componentes[6].allowBlank=true;
		}
	  //}
	function evento_parametro( combo, record, index )
	{
		g_id_parametro=record.data.id_parametro;
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		
		ClaseMadre_getComponente('id_tipo_pres').store.baseParams={m_id_parametro:ClaseMadre_getComponente('id_parametro').getValue(),m_incluir_dobles:'si'};
		ClaseMadre_getComponente('id_tipo_pres').modificado=true;
		ClaseMadre_getComponente('id_tipo_pres').setValue('');
		
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		g_id_tipo_pres=ClaseMadre_getComponente('id_tipo_pres').getValue();
		g_desc_pres=renderTipoPresupuesto(g_id_tipo_pres, '', '');
		
			
		ClaseMadre_getComponente('id_presupuesto').store.baseParams={vista:'rep_formulacion_ejecucion',m_tipo_pres_g:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro_g:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_presupuesto').modificado=true;
		ClaseMadre_getComponente('id_presupuesto').setValue('');
		
		
		
		ClaseMadre_getComponente('id_proyecto').store.baseParams={oc:'si',tipo_vista:'formulario_ejecucion',m_tipo_pres:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_proyecto').modificado=true;
		
		ClaseMadre_getComponente('id_unidad_organizacional').store.baseParams={oc:'si',tipo_vista:'formulario_ejecucion',m_tipo_pres_g:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro_g:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_unidad_organizacional').modificado=true;
		
		//para inhabilitar el combo correspondiente
         ClaseMadre_getComponente('id_unidad_organizacional').disabled=false;
		ClaseMadre_getComponente('id_proyecto').disabled=false;
		ClaseMadre_getComponente('id_presupuesto').disabled=false;		
		
	}
	

	
	function evento_presupuesto( combo, record, index )
	{
		
		
		/*g_ids_fuente_financiamiento=record.data.id_fuente_financiamiento;
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
	 	g_CantFiltros=1;	*/	
		
		//componentes[3].setValue(g_proyecto);
		g_id_presupuesto=record.data.id_presupuesto;
		if (record.data.id_presupuesto=='%'){
			//componentes[13].reset();
		    CM_mostrarGrupo('Reporte');	
		   
		   // componentes[6].allowBlank=false;
				
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
		}
		
		
	}
	
	function evento_unidad_organizacional( combo, record, index )
	{
		g_id_unidad_organizacional=record.data.id_unidad_organizacional;
		if (record.data.id_unidad_organizacional=='%'){
			 CM_mostrarGrupo('Reporte');	
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
		}
		
		
	}
	function evento_proyecto( combo, record, index )
	{
		g_id_proyecto=record.data.id_proyecto;
		if (record.data.id_proyecto=='%'){
			 CM_mostrarGrupo('Reporte');	
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
		}
		
		
	}
	
	function evento_moneda( combo, record, index )
	{
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;
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
