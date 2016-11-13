function FormulacionReporteVerificacion(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	
	var g_id_usuario='';
	var g_nombre_usuario='';
	var g_id_depto='';
	var g_id_presupuesto='';
	var g_desc_presupuesto='';
	
	
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
/*	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},[	'id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
		                                                                                            	'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
		                                                                                            	'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
		                                                                                            	'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
		                                                                                            	'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
});
*/
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto'])
	});	
	var ds_usuario=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_usuario','desc_persona','login'])
	});
//Depto
	
	var ds_depto=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?todos=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','codificacion'])
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
		function renderUsuario(value, p, record){return String.format('{0}', record.data['desc_persona']);}
		function render_id_depto(value,cell,record,row,colum,store){return String.format('{0}', record.data['nombre_depto']);}	
		
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
		
		
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{id_presupuesto}-{desc_unidad_organizacional}</i></b>',
																													'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																													'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Identificador: </b>{id_presupuesto}</FONT>',
		'</div>');																									
	
		

	
	
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{desc_persona}</I></B></FONT><br>','<FONT COLOR="#B5A642">{login}  </FONT>','</div>');
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{nombre_depto}</I></B></FONT><br>','<FONT COLOR="#B5A642">{codigo_depto}  </FONT>','</div>');
		
		
	vectorAtributos[0]={
		validacion:{
			name:'reporte',
			fieldLabel:'Reporte',
			vtype:'texto',
			emptyText:'Elija el Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Asignación Estructuras'],['1','Asignación de Departamentos'],['2','Asignación de Departamentos y Estructuras']]}),
		
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
		id_grupo:1,
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
		id_grupo:1,
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
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.id_presupuesto#PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',			
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
		filterColValue:'PRESUP.id_presupuesto#PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
		save_as:'id_presupuesto'
	};
	
	
	vectorAtributos[4]={
			validacion:{
				fieldLabel:'Usuario',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Usuario...',
				name:'id_usuario',
				desc:'desc_persona',
				store:ds_usuario,
				valueField:'id_usuario',
				displayField:'desc_persona',
				queryParam:'filterValue_0',
				filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#USUARI.login',
				typeAhead:false,
				forceSelection:true,
				tpl:tpl_id_usuario,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				resizable:true,
				minChars:0,
				triggerAction:'all',
				editable:true
			},
			id_grupo:1,
			save_as:'id_usuario',
			tipo:'ComboBox'
		};

	vectorAtributos[5]={
			validacion:{
				fieldLabel:'Departamento',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Departamento...',
				name:'id_depto',
				desc:'nombre_depto',
				store:ds_depto,
				valueField:'id_depto',
				displayField:'nombre_depto',
				queryParam:'filterValue_0',
				filterCol :'DEPTO.codigo_depto#DEPTO.nombre_depto#DEPTO.estado',
				typeAhead:false,
				forceSelection:true,
				tpl:tpl_id_depto,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				resizable:true,
				minChars:0,
				triggerAction:'all',
				editable:true
			},
			id_grupo:2,
			save_as:'id_depto',
			tipo:'ComboBox'
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
			labelWidth: 85, //ancho del label
		 	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Verificación de Asignaciones',
			fileUpload:false,
			columnas:['40%','40%'],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Asignación de Estructuras',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Asignación de Departamentos',
				columna:0,
				id_grupo:2
			}
			
			],
			parametros: '',
			submit:function ()
			{					
										
					var data='start=0';
					 data+='&id_presupuesto='+g_id_presupuesto;	//ID_PRESUPUESTO
					 data+='&id_usuario='+g_id_usuario;//ID_USUARIO
					 data+='&nombre_usuario='+g_nombre_usuario; //NOMBRE USUARIO
					 data+='&id_depto='+g_id_depto; //NOMBRE USUARIO
					 data+='&desc_presupuesto='+g_desc_presupuesto; //NOMBRE USUARIO
					
					  if (ClaseMadre_getComponente('reporte').getValue()=='0'){
						  window.open(direccion+'../../../../control/_reportes/verificacion_presto/ActionPDFRepVerificarPresto.php?'+data);		
					    }else if(ClaseMadre_getComponente('reporte').getValue()=='1'){
					    	 window.open(direccion+'../../../../control/_reportes/verificacion_presto/ActionPDFRepVerificarDepto.php?'+data);		
					    }else{
					    	 window.open(direccion+'../../../../control/_reportes/verificacion_presto/ActionPDFRepVerificarDeptoEP.php?'+data);	
					    }
					
					
						
				   				
				
			}
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');	
	
		ClaseMadre_getComponente('id_presupuesto').disabled=true;
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		ClaseMadre_getComponente('id_parametro').on('select',evento_parametro);		//parametro		
		ClaseMadre_getComponente('id_tipo_pres').on('select',evento_tipo_presupuesto);	//tipo_pres	
		ClaseMadre_getComponente('id_presupuesto').on('select',evento_presupuesto);		//presupuesto
		ClaseMadre_getComponente('id_usuario').on('select',evento_usuario);		//moneda
		ClaseMadre_getComponente('reporte').on('select',evento_reporte); //reporte
		ClaseMadre_getComponente('id_depto').on('select',evento_depto); //reporte
		 CM_ocultarGrupo('Asignación de Departamentos');	
		 CM_ocultarGrupo('Asignación de Estructuras');
	}
	
	  function evento_reporte(combo,record,index){
			
	if (record.data.ID=='0'){
		ClaseMadre_getComponente('id_parametro').reset();
		ClaseMadre_getComponente('id_tipo_pres').reset();
		ClaseMadre_getComponente('id_presupuesto').reset();
		ClaseMadre_getComponente('id_usuario').reset();
	    CM_mostrarGrupo('Asignación de Estructuras');	
	    CM_ocultarGrupo('Asignación de Departamentos');
	    ClaseMadre_getComponente('id_depto').allowBlank=true;
		
	   }else if (record.data.ID=='1') { 
		ClaseMadre_getComponente('id_depto').reset();
		CM_mostrarGrupo('Asignación de Departamentos');
		CM_ocultarGrupo('Asignación de Estructuras');
	     ClaseMadre_getComponente('id_parametro').allowBlank=true;
		ClaseMadre_getComponente('id_tipo_pres').allowBlank=true;
		ClaseMadre_getComponente('id_presupuesto').allowBlank=true;
			ClaseMadre_getComponente('id_usuario').allowBlank=true;
	}else{
		//ClaseMadre_getComponente('id_depto').reset();
		ClaseMadre_getComponente('id_parametro').reset();
		ClaseMadre_getComponente('id_tipo_pres').reset();
		ClaseMadre_getComponente('id_presupuesto').reset();
		ClaseMadre_getComponente('id_usuario').disabled=true;
		CM_ocultarGrupo('Asignación de Departamentos');
		CM_mostrarGrupo('Asignación de Estructuras');
	     /*ClaseMadre_getComponente('id_parametro').allowBlank=true;
		ClaseMadre_getComponente('id_tipo_pres').allowBlank=true;*/
		ClaseMadre_getComponente('id_depto').allowBlank=true;
			ClaseMadre_getComponente('id_usuario').allowBlank=true;
		
	}
	/*}else if (record.data.ID=='2'){
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
		//componentes[6].allowBlank=true;*/
	}
	
	function evento_parametro( combo, record, index )
	{
		ClaseMadre_getComponente('id_tipo_pres').store.baseParams={m_id_parametro:ClaseMadre_getComponente('id_parametro').getValue(),m_incluir_dobles:'si'};
		ClaseMadre_getComponente('id_tipo_pres').modificado=true;
		ClaseMadre_getComponente('id_tipo_pres').setValue('');
		
	}	
	function evento_usuario( combo, record, index )
	{
		g_id_usuario=record.data.id_usuario;
		g_nombre_usuario=record.data.desc_persona;
		
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		ClaseMadre_getComponente('id_presupuesto').store.baseParams={m_tipo_pres_g:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro_g:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_presupuesto').modificado=true;
		ClaseMadre_getComponente('id_presupuesto').setValue('');
		
		ClaseMadre_getComponente('id_presupuesto').disabled=false	
		
	}
	

	
	function evento_presupuesto( combo, record, index )
	{
		g_id_presupuesto=record.data.id_presupuesto;
		g_desc_presupuesto=record.data.desc_presupuesto;
	
	}
	
	function evento_depto( combo, record, index )
	{
		g_id_depto=record.data.id_depto;
		
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
