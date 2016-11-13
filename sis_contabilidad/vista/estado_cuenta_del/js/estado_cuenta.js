function GenerarReporteEstadoCuenta(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;

	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE

	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	 var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion'])
	});

	 var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			   reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	           });
	 var ds_ep=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuario.php.XML.php'}),
			   reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords:'TotalCount'},['id_fina_regi_prog_proy_acti',	'id_financiador', 'codigo_financiador', 'nombre_financiador', 'id_regional', 'codigo_regional', 'nombre_regional', 'id_programa',
		'codigo_programa', 'nombre_programa', 'id_proyecto', 'codigo_proyecto', 'nombre_proyecto', 'id_actividad', 'codigo_actividad', 'nombre_actividad', 'desc_frppa'])
	           });       	
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	var ds_parametro_conta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'}, ['id_parametro','estado_gestion','id_gestion','gestion_conta','desc_estado'])});
	function render_estado_gestion(value, p, record){
			if (value==1) {
				return 'Pre Abierto';
			}else if(value==2){
				return 'Abierto';
			}else if(value==3){
				return 'Pre Cerrado';
			}else if(value==4){
				return 'Cerrado';
			}
		
		}
		
		
		
	//FUNCIONES RENDER
		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b>{nombre_cuenta}</b>','<br><FONT COLOR="#B5A642"><b>Nombre:</b> {nombre_cuenta}</FONT>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta:</b> {nro_cuenta}</FONT>','</div>');
	
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</i>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
		
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
		function render_id_ep(value, p, record){return String.format('{0}', record.data['desc_frppa']);}
		var tpl_id_ep=new Ext.Template('<div class="search-item">','<b><i>{desc_frppa}</i></b>','</div>');	
		
		function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
		
		var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#B5A642">{nombre_auxiliar}</FONT><br>','</div>');
		
		var resultTplParAdq = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion_conta}</b>','<br><FONT COLOR="#B5A642">Estado: {desc_estado}</FONT>','</div>');
	
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro',
			desc:'gestion_conta',
			store:ds_parametro_conta,
			valueField:'id_parametro',
			displayField:'gestion_conta',
			filterCol:'PARAM.gestion_conta',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300
			//renderer:render_estado_gestion	
			//grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'id_parametro',
		id_grupo:0
	};
	
	// txt fecha_inicio
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Del',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			value:'01/01/2008',
			grid_indice:3			
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PERIOD.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
	};
	// txt fecha_inicio
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Al',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:3			
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PERIOD.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha',
		id_grupo:0
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			emptyText:'Cuenta...',
			store:ds_cuenta,
			displayField: 'nombre_cuenta',
			valueField: 'id_cuenta',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nombre_cuenta',
			typeAhead:false,
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:100,
			pageSize:10,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_cuenta',
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
		id_grupo:1
		};
	// txt id_auxiliar
	vectorAtributos[4]={
			validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.nombre_auxiliar',
			typeAhead:false,
			tpl:tpl_id_auxiliar,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'AUXILI.nombre_auxiliar',
		save_as:'id_auxiliar',
		id_grupo:1
	};

	vectorAtributos[5]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:true,			
			emptyText:'Unidad Organizacional...',
			//desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			desc: 'nombre_unidad',
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_uo',
		id_grupo:2
	};
	
	vectorAtributos[6]= {
		validacion:{
			pregarga:false,
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name:'id_ep',
			queryDelay:250,
			minChars: 1,
			triggerAction: 'all',
			grid_indice:14,
			width:300
		},
		tipo: 'epField',
		save_as:'id_ep',
		id_grupo:2
	};
	
	
	// txt id_fina_regi_prog_proy_acti
/*	vectorAtributos[6]={
		validacion:{
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'Estructura Programatica',
			allowBlank:true,			
			emptyText:'Estructura Programatica...',
			desc: 'desc_frppa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_ep,
			valueField: 'id_fina_regi_prog_proy_acti',
			displayField: 'desc_frppa',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_ep,
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
			renderer:render_id_ep,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:'50%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		//filtro_0:true,
		//filterColValue:'MONEDA.nombre',
		save_as:'id_ep',
		id_grupo:2
			
		};*/
	vectorAtributos[7]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
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
			width_grid:150,
			width:'50%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:2
	};
	
/*	vectorAtributos[8]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro',
			desc:'gestion_conta',
			store:ds_parametro_conta,
			valueField:'id_parametro',
			displayField:'gestion_conta',
			filterCol:'PARAM.gestion_conta',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300
			//grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'id_parametro'
		id_grupo:2
	};
	
	// txt fecha_inicio
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Del',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			value:'01/01/2008',
			grid_indice:3			
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PERIOD.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:''
	};
	// txt fecha_inicio
	vectorAtributos[7]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Al',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:3			
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PERIOD.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha'
	};*/
	
	vectorAtributos[8]={
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
	 vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti'
	};
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Estado Cuenta"
	};
	layout_rep_estado_cuenta=new DocsLayoutProceso(idContenedor);
	layout_rep_estado_cuenta.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_estado_cuenta,idContenedor);
	
	var paramMenu={actualizar:{crear:true,separador:false}};

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure=this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente=this.getComponente;
		
		
	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		
		cmbGestion=ClaseMadre_getComponente('id_parametro');
		dteFechaDesde=ClaseMadre_getComponente('fecha_inicio');
		dteFechaHasta=ClaseMadre_getComponente('fecha_fin');
		gestion=ClaseMadre_getComponente('gestion');
		combo_cuenta=ClaseMadre_getComponente('id_cuenta');
		combo_auxiliar=ClaseMadre_getComponente('id_auxiliar');
		cmbEp=ClaseMadre_getComponente('id_ep');
		id_fina_regi_prog_proy_acti=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
		
		var onEpSelect = function(e){
			var ep=cmbEp.getValue();
			id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
		};

		
		
		var onGestionSelect = function(e) {
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined){
				intGestion=cmbGestion.store.getById(id).data.gestion_conta;
			
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				dteFechaDesde.minValue=dte_fecha_ini_valid;
				dteFechaDesde.maxValue=dte_fecha_fin_valid;
				dteFechaHasta.minValue=dte_fecha_ini_valid;
				dteFechaHasta.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				dteFechaDesde.setValue(dte_fecha_ini_valid);
				dteFechaHasta.setValue(dte_fecha_fin_valid);
				gestion.setValue(cmbGestion.store.getById(id).data.gestion_conta);
			}
		
			 ds_cuenta.baseParams.id_gestion=cmbGestion.store.getById(id).data.id_gestion;
			 ds_cuenta.baseParams.sw_transaccional=1;
			 combo_cuenta.modificado=true;
			 
		};
		
		var onCuentaSelect = function(e) {
			var id = combo_cuenta.getValue();
			
			
			if(combo_cuenta.store.getById(id)!=undefined){
			 ds_auxiliar.baseParams.cuenta=combo_cuenta.store.getById(id).data.id_cuenta;
			  combo_auxiliar.modificado=true;
			}
		
			
			 
		};
		
		
		cmbGestion.on('select',onGestionSelect);
		combo_cuenta.on('select',onCuentaSelect);
		cmbEp.on('change',onEpSelect);
		
	}
	



	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../control/estado_cuenta/ActionReporteEstadoCuenta.php',
			abrir_pestana:true, //abrir pestana
		//	titulo_pestana:obtenerTitulo,
			//submit:reporte_est,
			titulo_pestana:'Reporte Estado Cuenta',
			fileUpload:false,
			columnas:[505,305],
			//submit:abrirReportes,
			parametros: '',
			grupos:[
		      {tituloGrupo:'Fechas',columna:0,id_grupo:0},
		      {tituloGrupo:'Cuentas',columna:0,id_grupo:1},
		      {tituloGrupo:'Unidades Organizacionales',columna:0,id_grupo:2}
		]}
		//}
	}
	function reporte_est(){
		window.open(direccion+'../../../control/estado_cuenta/ActionReporteEstadoCuenta.php?hidden_id_param='+combo_parametro.getValue()+'&txt_gestion='+gestion.getValue()+'&txt_periodo='+periodo.getValue());
	}

	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
