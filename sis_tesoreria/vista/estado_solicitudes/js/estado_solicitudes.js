function EstadoSolicitudes(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();	
	var componentes=new Array(); 
	var	g_CantFiltros='';
	
	var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;
	
	var g_tipo_reporte='';
	
	var g_id_depto='';
	var g_id_usuario='';
	var g_id_empleado='';
	var g_id_unidad_organizacional='';
	
	var g_desc_depto='';
	var g_desc_unidad_organizacional='';
	var g_desc_usuario='';
	var g_desc_empleado='';
	var g_tipo_solicitud='';
	var g_estado_solicitud='';
	
	
	//DATA STORE 		
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});	
	
	var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuarioVista.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','nombre_completo'])
	});
	
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	
	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
 	
   
    function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

    function render_id_usuario(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','{nombre_completo}<br>','</div>');

	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

	
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','<br><FONT COLOR="#B50000"><b>{nombre_nivel}</b></FONT>','</div>');
	
	 
	vectorAtributos[0] = { 
		validacion: {
			name: 'tipo_reporte',
			fieldLabel: 'Filtrar por',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data : Ext.estado_solicitud_combo.tipo_reporte}),
			store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data : Ext.estado_solicitud_combo.tipo_reporte = [
			                                                                                                           
			                                                                                                   		['Por Responsable Registro', 'Por Responsable Registro'],
			                                                                                                   		['Por Funcionario Solicitante', 'Por Funcionario Solicitante'],
			                                                                                                   		['Por Unidad Organizacional', 'Por Unidad Organizacional'],
			                                                                                                   		['Por Departamento Contable', 'Por Departamento Contable']       
			                                                                                                   ]}),
			onSelect:function(record)
			{
				if(record.data.ID=='Por Responsable Registro') //por responsable registro
				{
					ClaseMadre_getComponente('tipo_reporte').setValue('Por Responsable Registro');
					ClaseMadre_getComponente('id_usuario').allowBlank=false;
					
					ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
					ClaseMadre_getComponente('id_depto').allowBlank=true;	
					ClaseMadre_getComponente('id_empleado').allowBlank=true;
									
					ClaseMadre_getComponente('id_unidad_organizacional').reset();
					ClaseMadre_getComponente('id_depto').reset();
					ClaseMadre_getComponente('id_empleado').reset();
					
					ClaseMadre_getComponente('id_unidad_organizacional').setValue('');
					ClaseMadre_getComponente('id_depto').setValue('');
					ClaseMadre_getComponente('id_empleado').setValue('');
					
					CM_mostrarGrupo('Responsable Registro');
					CM_ocultarGrupo('Unidad Organizacional');
					CM_ocultarGrupo('Departamento Contable');
					CM_ocultarGrupo('Funcionario Solicitante');
					g_tipo_reporte=componentes[0].getValue();
										
					ClaseMadre_getComponente('tipo_reporte').collapse();
				}
				else if(record.data.ID=='Por Funcionario Solicitante') //por funcionario solicitante
				{
					ClaseMadre_getComponente('tipo_reporte').setValue('Por Funcionario Solicitante');
					ClaseMadre_getComponente('id_empleado').allowBlank=false;
					
					ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
					ClaseMadre_getComponente('id_usuario').allowBlank=true;	
					ClaseMadre_getComponente('id_depto').allowBlank=true;	
									
					ClaseMadre_getComponente('id_unidad_organizacional').reset();
					ClaseMadre_getComponente('id_usuario').reset();
					ClaseMadre_getComponente('id_depto').reset();
					
					ClaseMadre_getComponente('id_unidad_organizacional').setValue('');
					ClaseMadre_getComponente('id_usuario').setValue('');
					ClaseMadre_getComponente('id_depto').setValue('');
					
					g_tipo_reporte=componentes[0].getValue();
					
					CM_ocultarGrupo('Responsable Registro');
					CM_ocultarGrupo('Unidad Organizacional');
					CM_mostrarGrupo('Funcionario Solicitante');	
					CM_ocultarGrupo('Departamento Contable');				
					
					ClaseMadre_getComponente('tipo_reporte').collapse();
				}
				else if (record.data.ID=='Por Unidad Organizacional') //por unidad organizacional
				{   
					ClaseMadre_getComponente('tipo_reporte').setValue('Por Unidad Organizacional');
					ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=false;
					
					ClaseMadre_getComponente('id_usuario').allowBlank=true;
					ClaseMadre_getComponente('id_depto').allowBlank=true;
					ClaseMadre_getComponente('id_empleado').allowBlank=true;
										
					ClaseMadre_getComponente('id_usuario').reset();
					ClaseMadre_getComponente('id_depto').reset();
					ClaseMadre_getComponente('id_empleado').reset();
					
					ClaseMadre_getComponente('id_usuario').setValue('');
					ClaseMadre_getComponente('id_depto').setValue('');
					ClaseMadre_getComponente('id_empleado').setValue('');
					
					CM_ocultarGrupo('Responsable Registro');
					CM_mostrarGrupo('Unidad Organizacional');
					CM_ocultarGrupo('Departamento Contable');
					CM_ocultarGrupo('Funcionario Solicitante');
					g_tipo_reporte=componentes[0].getValue();
					
					ClaseMadre_getComponente('tipo_reporte').collapse();				
				}
				else if(record.data.ID=='Por Departamento Contable') //por departamento contable
				{
					ClaseMadre_getComponente('tipo_reporte').setValue('Por Departamento Contable');
					ClaseMadre_getComponente('id_depto').allowBlank=false;
					
					ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
					ClaseMadre_getComponente('id_usuario').allowBlank=true;	
					ClaseMadre_getComponente('id_empleado').allowBlank=true;
									
					ClaseMadre_getComponente('id_unidad_organizacional').reset();
					ClaseMadre_getComponente('id_usuario').reset();
					ClaseMadre_getComponente('id_empleado').reset();
					
					ClaseMadre_getComponente('id_unidad_organizacional').setValue('');
					ClaseMadre_getComponente('id_usuario').setValue('');
					ClaseMadre_getComponente('id_empleado').setValue('');
					
					g_tipo_reporte=componentes[0].getValue();
					
					CM_ocultarGrupo('Responsable Registro');
					CM_ocultarGrupo('Unidad Organizacional');
					CM_mostrarGrupo('Departamento Contable');					
					CM_ocultarGrupo('Funcionario Solicitante');
					ClaseMadre_getComponente('tipo_reporte').collapse();
				}				
			},
			valueField:'ID',
			displayField:'valor',
			align: 'center',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:60, // ancho de columna en el grid
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	// txt tipo_solicitud 
	 vectorAtributos[1]  = {
		validacion: {
			name:'tipo_solicitud',			
			fieldLabel:'Tipo Solicitud',
			vtype:'texto',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data :[
			                                                                
			                                                                ['Todos', 'TODOS'],
			                                                           		['solicitud_viatico', 'Solicitud de Viaticos'],
			                                                           		['solicitud_avance', 'Fondos en Avance'],
			                                                           		['solicitud_efectivo', 'Solicitud de Efectivo']
			                                                        ]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:200			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'tipo_solicitud'		
	};
	
	// txt tipo_pres  
	 vectorAtributos[2]  = {
		validacion: {
			name:'estado_solicitud',			
			fieldLabel:'Estado Solicitud',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data : [       
			                                                 	            
			                                                                 ['Todos', 'Todos'],
			                                                                 ['anulado', 'Anulado'],
			                                                                 ['borrador', 'Borrador'],
			                                                                 ['pagado', 'Pagado'],
			                                                                 ['caja_fin', 'Caja Fin'],         
			                                                         		['solicitud_pago', 'Solicitud Pago'],
			                                                                 ['cheque_fin', 'Cheque Fin'],
			                                                                 ['comprometido', 'Comprometido'],
			                                                                 ['en_finaliz', 'En Finalizacion'],
			                                                                 ['conta_pago', 'Conta Pago'],
			                                                                 ['pago_cheque', 'Pago Cheque'],
			                                                                 ['pago_efectivo', 'Pago Efectivo'],
			                                                                 ['finalizado', 'Finalizado']   
			                                                         ]}),
			valueField:'ID',
			displayField:'valor',
			//renderer: renderEstadoSolicitud,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:200			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'estado_solicitud'		
	};
	
	vectorAtributos[3]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Desde Fecha',
			allowBlank:false,
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
	vectorAtributos[4]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Hasta Fecha',
			allowBlank:false,
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
	
	
	vectorAtributos[5]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Tesorería',
			allowBlank:false,			
			//emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:250,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'id_depto',
		id_grupo:1
	};
	
	vectorAtributos[6]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Responsable de Registro',
			allowBlank:false,			
			desc: 'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			//onSelect: function(record){ if(vista!='solicitud_efectivo'){  componentes[30].setValue(record.data.desc_persona)  ;} componentes[4].setValue(record.data.id);componentes[4].collapse(); },
			valueField: 'id_usuario',
			displayField: 'nombre_completo',
			queryParam: 'filterValue_0',
			filterCol:'nombre_completo',  //filtramos por el nombre
			typeAhead:false,
			tpl:tpl_id_usuario,
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
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//filterColValue: 'CUDOC.desc',
		id_grupo:2		
	};
	
	vectorAtributos[7]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			//emptyText:'Unidad Organizacional...',
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
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_unidad_organizacional',
		id_grupo:3
	};
	
	vectorAtributos[8]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Funcionario Solicitante',
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			//onSelect: function(record){ if(vista!='solicitud_efectivo'){  componentes[30].setValue(record.data.desc_persona)  ;} componentes[4].setValue(record.data.id_empleado);componentes[4].collapse(); },
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
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
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'CUDOC.desc_empleado',
		id_grupo:4		
	};
	
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Detalle del Estado de Solicitudes"
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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	//url:direccion+'../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle de Estado de Solicitudes',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
				{
					tituloGrupo:'Datos Para Generar el Reporte',
					columna:0,
					id_grupo:0
				},	
				{
					tituloGrupo:'Departamento Contable',
					columna:0,
					id_grupo:1
				},	
				{
					tituloGrupo:'Responsable Registro',
					columna:0,
					id_grupo:2
				},
				{
					tituloGrupo:'Unidad Organizacional',
					columna:0,
					id_grupo:3
				},
				{
					tituloGrupo:'Funcionario Solicitante',
					columna:0,
					id_grupo:4
				}		
			],

			submit:function()
			{	
				//g_desc_estado_rendicion=record.data.desc_estado_gral;
							
				var mensaje="";					
					
				if(mensaje=="")
				{							
					var data='start=0';
					 data+='&limit=1000';
					 data+='&CantFiltros='+g_CantFiltros;
					 
					 data+='&tipo_reporte='+g_tipo_reporte;
					 
					 data+='&id_depto='+g_id_depto;	//listo
					 data+='&id_usuario='+g_id_usuario;	//listo
					 data+='&id_empleado='+g_id_empleado;	//listo
					 data+='&id_unidad_organizacional='+g_id_unidad_organizacional;	//listo
					 
					 data+='&desc_depto='+g_desc_depto;	//listo
					 data+='&desc_unidad_organizacional='+g_desc_unidad_organizacional;	//listo
					 data+='&desc_usuario='+g_desc_usuario;	//listo
					 data+='&desc_empleado='+g_desc_empleado;	//listo
					 data+='&tipo_solicitud='+g_tipo_solicitud;	//listo	
					 data+='&estado_solicitud='+g_estado_solicitud;	//listo					 
					 				 
					 data+='&fecha_desde='+formatDate(dteFechaDesde.getValue());
					 data+='&fecha_hasta='+formatDate(dteFechaHasta.getValue());	
					
					 //alert(data);
					 window.open(direccion+'../../../control/_reportes/estado_solicitudes/ActionPDFEstadoSolicitudes.php?'+data);					
				}
				else
				{
					alert(mensaje);
				}
			}	
		}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_depto = ClaseMadre_getComponente('id_depto');
		id_usuario = ClaseMadre_getComponente('id_usuario');
		id_unidad_organizacional = ClaseMadre_getComponente('id_unidad_organizacional');
		
		desc_depto = ClaseMadre_getComponente('desc_depto');	
		tipo_solicitud = ClaseMadre_getComponente('tipo_solicitud');
		estado_solicitud = ClaseMadre_getComponente('estado_solicitud');		
		
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');		
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		componentes[1].on('select',evento_tipo_solicitud);
		componentes[2].on('select',evento_estado_solicitud);

		componentes[5].on('select',evento_departamento);		//departamento	
		componentes[6].on('select',evento_id_usuario);	
		componentes[7].on('select',evento_id_unidad_organizacional);
		componentes[8].on('select',evento_id_empleado);
		
		CM_ocultarGrupo('Departamento Contable');
		CM_ocultarGrupo('Responsable Registro');	
		CM_ocultarGrupo('Unidad Organizacional');
		CM_ocultarGrupo('Funcionario Solicitante');			
	}
	
	function evento_tipo_solicitud( combo, record, index )
	{
		g_tipo_reporte=componentes[0].getValue();
		g_tipo_solicitud=componentes[1].getValue();		
	}	
	
	function evento_estado_solicitud( combo, record, index )
	{
		g_tipo_reporte=componentes[0].getValue();
		g_estado_solicitud=componentes[2].getValue();		
	}
	
	function evento_id_usuario( combo, record, index )
	{
		g_id_usuario=componentes[6].getValue();
		g_desc_usuario=record.data.nombre_completo;
	}	
	
	function evento_id_unidad_organizacional( combo, record, index )
	{
		g_id_unidad_organizacional=componentes[7].getValue();
		g_desc_unidad_organizacional=record.data.nombre_unidad;
	}
		
	function evento_departamento( combo, record, index )
	{
		//g_id_depto=record.data.id_depto;	
		g_id_depto=componentes[5].getValue();
		g_desc_depto=record.data.nombre_depto;
	}

	function evento_id_empleado( combo, record, index )
	{
		g_id_empleado=componentes[8].getValue();
		g_desc_empleado=record.data.desc_persona;
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
