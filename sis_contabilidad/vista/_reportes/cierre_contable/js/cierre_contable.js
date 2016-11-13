function ReporteCierreContable(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_lib_may_ban, h_txt_gestion, h_txt_mes, ds_linea;
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_depto = new Ext.data.Store(
			{
				proxy :new Ext.data.HttpProxy(
						{
							url :direccion + '../../../../../sis_parametros/control/depto/ActionListarDepartamento.php'
						}),
				reader :new Ext.data.XmlReader( {
					record :'ROWS',
					id :'id_depto',
					totalRecords :'TotalCount'
				}, [ 'id_depto', 'codigo_depto', 'nombre_depto', 'estado',
						'id_subsistema', 'nombre_corto', 'nombre_largo' ]),
				baseParams : {
					m_id_subsistema :9
				}
			});
	ds_depto.load();
	var data_deptos=new Array();
	var indice=0;
	
	
	 
	
	function render_id_moneda(value, p, record) {
		return String.format('{0}', record.data['desc_moneda'])
	}
	var tpl_id_moneda = new Ext.Template('<div class="search-item">',
			'<b><i>{nombre}</i></b>',
			'<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>',
			'</div>');

	var resultTplDepto = new Ext.Template('<div class="search-item">',
			'<b><i>{nombre_depto}</i></b>',
			'<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>', '</div>');

	// ///////// txt gerencia//////
	var data_dep = [ [ '1', 'Planta' ], [ '2', 'Consultoría' ],
			[ '3', 'Servicio' ] ]; // Ext.proc_existenciasCombo.estado,
	//console.log('--'+ data_dep);
	// txt id_unidad_organizacional
	// /////// fecha_ini /////////
	/*vectorAtributos[8] = {
			validacion : {
				fieldLabel :'Departamento',
				allowBlank :false,
				vtype :"texto",
				emptyText :'Depto...',
				name :'departamento2',
				desc :'nombre_depto',
				store :ds_depto,
				valueField :'id_depto',
				displayField :'nombre_depto',
				queryParam :'filterValue_0',
				filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
				typeAhead :false,
				forceSelection :true,
				tpl :resultTplDepto,
				mode :'remote',
				queryDelay :50,
				pageSize :10,
				minListWidth :300,
				resizable :true,
				minChars :0,
				triggerAction :'all',
				editable :true
			},
			id_grupo :0,
			save_as :'departamento',
			tipo :'ComboBox'
		};*/
	
	vectorAtributos[0] = {
		validacion : {
			name :'fecha_ini',
			fieldLabel :'Fecha Inicio',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_ini',
		dateFormat :'m/d/Y',
		defecto :""
	};
	// /////// fecha /////////
	vectorAtributos[1] = {
		validacion : {
			name :'fecha_fin',
			fieldLabel :'Fecha Fin',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_fin',
		dateFormat :'m/d/Y',
		defecto :""
	};

	vectorAtributos[2] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_ini',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_ini'
	};

	vectorAtributos[3] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_fin',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_fin'
	};
	vectorAtributos[4] = {
		validacion : {
			labelSeparator :'',
			name :'nombre_departamento',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'nombre_departamento'
	};

		vectorAtributos[5] = {
				validacion : {
					name :'departamento',
					fieldLabel :'Deptos.',
					store:ds_depto,
					valueField :'id_depto',
					displayField :'nombre_depto',
					width :150,
					height :150,
					allowBlank :false,
					width :250
				},
				tipo :'Multiselect',
				save_as :'deptos_ids'

			};
		  
		vectorAtributos[6]=
		{
				validacion:{
					name: 'tipo_reporte',
					fieldLabel:'Tipo Reporte',
					allowBlank:false,
					typeAhead:true,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF'],['2','Excel']]}),				
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
				save_as:'tipo_reporte'
			};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Cierre Contable"
	};
	layout_lib_may_ban = new DocsLayoutProceso(idContenedor);
	layout_lib_may_ban.init(config);
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_lib_may_ban, idContenedor);
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	// ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {

		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		// componentes[0].on('select', evento_departamento); // tipo_pres
		componentes[0].on('change', evento_fecha_inicio); //
		componentes[1].on('change', evento_fecha_fin); //
		// componentes[6].on('select', evento_moneda); //
		
	}

	function evento_fecha_inicio(combo, record, index) {
		var fecha_inicio_val = componentes[0].getValue();
		componentes[1].minValue = fecha_inicio_val;
		componentes[2].setValue(formatDate(componentes[0].getValue()));
	}
	function evento_fecha_fin(combo, record, index) {
		var fecha_fin_val = componentes[1].getValue();
		componentes[3].setValue(formatDate(componentes[1].getValue()));

	}

	function evento_departamento(combo, record, index) {
		// Se añade los valores a los campos hidden para mandar la descripción
		// al pdf
		componentes[4].setValue(record.data.codigo_depto + '-'
				+ record.data.nombre_depto);

	}

	/*
	 * function evento_moneda(combo, record, index) { // Se añade los valores a
	 * los campos hidden para mandar la descripción // al pdf
	 * componentes[6].setValue(record.data.nombre);
	 *  }
	 */

	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Cierre Contable " + ContPes;
		ContPes++;
		return titulo
	}
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	// //
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../../../sis_contabilidad/control/_reportes/cierre_contable/ActionPDFCierreContable.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 420, 420 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ],
			parametros :''
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario)
}