function trans_ingreso_salida(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_rep_llamadas_funcionario,combo_empleado,combo_tipo_llamada,combo_gerencia,h_txt_fecha_ini,h_txt_fecha_fin,ds_empleado,ds_gerencia,txt_id_gerencia,txt_nombre,txt_descripcion_gerencia;
	// ------------------  PARÁMETROS --------------------------//
	ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado_extension/ActionListarEmpleadoExtensionGerente_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado_extension','codigo_telefonico','id_empleado','id_persona','desc_empleado','id_gerencia','desc_gerencia'])
	});
	var resultTplEmp=new Ext.Template('<div class="search-item">','<b><i>{desc_empleado}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_telefonico}</FONT>','</div>');
	//// txt_id_empleado
	var filterCols_funcionario=new Array();
	var filterValues_funcionario=new Array();
	filterCols_funcionario[0]='EMPEXT.id_gerencia';
	filterValues_funcionario[0]='%';
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'desc_empleado',
			desc:'desc_empleado',
			store:ds_empleado,
			valueField:'id_persona',
			displayField:'desc_empleado',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			filterCols:filterCols_funcionario,
			filterValues:filterValues_funcionario,
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplEmp,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'txt_codigo_empleado',
		tipo:'ComboBox'
	};

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Transferencia Ingreso Salida"};
	layout_trans_ing_sal=new DocsLayoutProceso(idContenedor);
	layout_trans_ing_sal.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_trans_ing_sal,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	ds_empleado.addListener('loadexception',ClaseMadre_conexionFailure);
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_empleado=ClaseMadre_getComponente('desc_empleado');
		
	}
	
	var InitFunciones=this.InitFunciones;
	var iniciaFormulario=this.iniciaFormulario;
	function obtenerTitulo(){
		var titulo="Transferencia Ingreso Salida "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		function gerencia(resp){
		var paramFunciones={
		Formulario:{labelWidth:75,url:direccion+'../../../../../sis_almacenes/control/_reportes/transferencia_ingreso_salida/ActionReporteTransferenciaIngresoSalida.php',abrir_pestana:true,titulo_pestana:obtenerTitulo,fileUpload:false,columnas:[320,280],
			        grupos:[{tituloGrupo:'Datos Funcionario',columna:0,id_grupo:0}],parametros:'id_gerencia='+txt_id_gerencia+'&nombre_gerencia='+txt_nombre+'&descripcion='+txt_descripcion_gerencia}
	};
		InitFunciones(paramFunciones);
		iniciaFormulario();
		iniciarEventosFormularios();
	}
	this.Init();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}