function GenerarReporteDetalleIndicesTramites(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array();
	var id_parametro,id_periodo_subsistema,desc_periodo,desc_usuario,desc_depto,cmb_depto,intGestion,cmb_gestion,cmb_periodo,cmb_usuario,chkComprobante,id_gestion,cmb_tipo_reporte,id_usuario;
	var desc_gestion,tipo_documento;
	
	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE
	ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_facturacion/control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_param',
			totalRecords: 'TotalCount'
		}, ['id_param','ciudad','representante'])
	});
	
	var	ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'}, ['id_parametro','id_gestion','desc_gestion','estado_gestion','gestion_conta'])});
    var ds_periodo_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoGestionSubsis.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'}, ['id_periodo_subsistema','id_periodo','desc_periodo','estado_periodo','periodo'])});

	
    var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>Gestion</i></b>','<br><FONT COLOR="#B5A642">{desc_gestion}</FONT>','</div>');
	   
	
	var f=new Date();
	var anio=f.getFullYear();
	var mes=f.getMonth();
	var paramIdComprobante = {
			validacion: {
				name: 'txt_id_transaccion',
				fieldLabel: 'Id Comprob.',
				align:'left', 
				allowBlank: true,
				maxLength:7,
				minLength:0,
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				minValue: 0,
				vtype:"texto",
				grid_visible:true, 
				grid_editable:false, 
				width_grid:60, 
				disabled: false 
				
			},
			tipo: 'TextField',
			save_as:'txt_id_transaccion'
		};
	vectorAtributos[0] = paramIdComprobante;
	// txt codigo
	var paramId_parametro={
			validacion: {
		name: 'subsistema',
		fieldLabel: 'Sub Sistema',
		allowBlank: false,
		typeAhead: true,
		loadMask: true,
		triggerAction: 'all',
		store: new Ext.data.SimpleStore({
			fields: ['ID', 'valor'],
			data : [
				      ['aroma', 'Aroma'],
				      ['cobija', 'Cobija'],
				      ['moxos', 'Moxos'],
				      ['reyes', 'Reyes'],
				      ['rurrenabaque', 'Rurrenabaque'],
				      ['sanborja', 'San Borja'],
				      ['santarosa', 'Santa Rosa'],
				      ['trinidad', 'Trinidad'],
				      ['yucumo', 'Yucumo'],
				      ['uyuni', 'Uyuni'],
				      ['camargo', 'Camargo'],
				      ['santaana', 'Santa Ana'],
				      ['sena', 'SENA']
				  ] // from states.js
		}),
		valueField:'ID',
		displayField:'valor',
		align: 'center',			
		lazyRender:true,
		forceSelection:true,
		grid_visible:true, // se muestra en el grid
		grid_editable:false, //es editable en el grid
		width_grid:60, // ancho de columna en el grid
		width:120
		},
		id_grupo:0,
		save_as:'txt_subsistema',
		tipo:'ComboBox'
	};
	vectorAtributos[1] = paramId_parametro;
	// txt codigo
	var paramId_parametro={
			validacion: {
		name: 'subsistema',
		fieldLabel: 'Sub Sistema',
		allowBlank: false,
		typeAhead: true,
		loadMask: true,
		triggerAction: 'all',
		store: new Ext.data.SimpleStore({
			fields: ['ID', 'valor'],
			data : [
				      ['aroma', 'Aroma'],
				      ['cobija', 'Cobija'],
				      ['moxos', 'Moxos'],
				      ['reyes', 'Reyes'],
				      ['rurrenabaque', 'Rurrenabaque'],
				      ['sanborja', 'San Borja'],
				      ['santarosa', 'Santa Rosa'],
				      ['trinidad', 'Trinidad'],
				      ['yucumo', 'Yucumo'],
				      ['uyuni', 'Uyuni'],
				      ['camargo', 'Camargo'],
				      ['santaana', 'Santa Ana'],
				      ['sena', 'SENA']
				  ] // from states.js
		}),
		valueField:'ID',
		displayField:'valor',
		align: 'center',			
		lazyRender:true,
		forceSelection:true,
		grid_visible:true, // se muestra en el grid
		grid_editable:false, //es editable en el grid
		width_grid:60, // ancho de columna en el grid
		width:120
		},
		id_grupo:0,
		save_as:'txt_subsistema',
		tipo:'ComboBox'
	};
	//vectorAtributos[2] = paramTipoActualizacion;
	var paramTipoActualizacion={
			validacion: {
		name: 'tipo_actualizacion',
		fieldLabel: 'Actualizacion Libros',
		allowBlank: false,
		typeAhead: true,
		loadMask: true,
		triggerAction: 'all',  
		store: new Ext.data.SimpleStore({
			fields: ['ID', 'valor'],
			data : [['libro_venta','Libro Ventas'],['libro_compra','Libro Compras']] // from states.js
		}),
		valueField:'ID',
		displayField:'valor',
		align: 'center',			
		lazyRender:true,
		forceSelection:true,
		grid_visible:true, // se muestra en el grid
		grid_editable:false, //es editable en el grid
		width_grid:60, // ancho de columna en el grid
		width:120
		},
		id_grupo:0,
		save_as:'txt_tipo_actualizacion',
		tipo:'ComboBox'
	};
	vectorAtributos[2] = paramTipoActualizacion;
	/*var filterCols_parametro=new Array();
	var filterValues_parametro=new Array();
	filterCols_parametro[0]='estado_gestion';
	filterValues_parametro[0]='2';
	*/
	
	
	/*var paramId_Gestion= {
		validacion: {
			name: 'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'gestion',
			store:ds_gestion,
			valueField: 'id_parametro',
			displayField: 'desc_gestion',
			queryParam: 'filterValue_0',
			filterCols:filterCols_parametro,
			filterValues:filterValues_parametro,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:250,
			grow:true,
			width:150,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_parametro'
	};

	vectorAtributos[1] = paramId_Gestion;

	var filterCols_periodo=new Array();
	var filterValues_periodo=new Array();
	filterCols_periodo[0]='PERIOD.id_gestion';
	filterValues_periodo[0]='x';
	filterCols_periodo[1]='PERSIS.estado_periodo';
	filterValues_periodo[1]='abierto';
	filterCols_periodo[2]='PERSIS.id_subsistema';
	filterValues_periodo[2]='12';
	//filterCols_periodo[4]='PERIOD.estado_peri_gral';
	//filterValues_periodo[4]='abierto';

	paramPeriodo_subsistema= {
		validacion: {
			name: 'id_periodo_subsis',
			fieldLabel:'Período',
			allowBlank:false,
			emptyText:'Período...',
			desc: 'desc_periodo',
			store:ds_periodo_subsis,
			valueField: 'id_periodo_subsistema',
			displayField: 'desc_periodo',
			filterCols:filterCols_periodo,
			filterValues:filterValues_periodo,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:250,
			grow:true,
			width:150,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_periodo_subsis'
	};
	vectorAtributos[2] = paramPeriodo_subsistema;*/
	var paramGestion = {
		validacion: {
			name: 'gestion',
			fieldLabel: 'Gestion',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : [
						['2008', '2008'],
				        ['2009', '2009'],
				        ['2010', '2010'],
				        ['2011', '2011'],
				        ['2012', '2012'],
				        ['2013', '2013'],
				        ['2014', '2014'],
				        ['2015', '2015'],
				        ['2016', '2016'],
				        ['2017', '2017'],
				        ['2018', '2018'],
				        ['2019', '2019'],
				        ['2020', '2020']      
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			align: 'center',			
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:60, // ancho de columna en el grid
			width:120
		},
		tipo:'ComboBox',
		filterColValue:'gestion',
		save_as:'txt_gestion'
			
	};
	vectorAtributos[3] = paramGestion;	 
	
	var paramPeriodo = {
		validacion: {
			name: 'periodo',
			fieldLabel: 'Periodo',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : [
				        ['1', 'Enero'],
				        ['2', 'Febrero'],
				        ['3', 'Marzo'],
				        ['4', 'Abril'],
				        ['5', 'Mayo'],
				        ['6', 'Junio'],
				        ['7', 'Julio'],
				        ['8', 'Agosto'],
				        ['9', 'Septiembre'],
				        ['10', 'Octubre'],
				        ['11', 'Noviembre'],
				        ['12', 'Diciembre']
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			align: 'center',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:60, // ancho de columna en el grid
			width:120
		},
		tipo:'ComboBox',
		filterColValue:'periodo',
		save_as:'txt_periodo'
			
	};
	vectorAtributos[4] = paramPeriodo;	
	 
	

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Actualización Información Libros Contables"
	};
	layout_detalle_indices_tramites=new DocsLayoutProceso(idContenedor);
	layout_detalle_indices_tramites.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_detalle_indices_tramites,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;

	ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		combo_parametro = ClaseMadre_getComponente('id_param');
		/*cmb_gestion = ClaseMadre_getComponente('gestion');	
		cmb_periodo = ClaseMadre_getComponente('id_periodo_subsis');
		*/
		/*var onGestionSelect = function(e) {
			var id = cmb_gestion.getValue();
			if(cmb_gestion.store.getById(id)!=undefined){
				id_gestion=cmb_gestion.store.getById(id).data.id_gestion;
				
				intGestion=cmb_gestion.store.getById(id).data.desc_gestion;
				
				cmb_periodo.filterValues[0]=id_gestion;
				cmb_periodo.modificado = true;
				cmb_periodo.setValue('');
			}
		};*/
		
		/*function set_periodo(combo,record, index)
		{
			id_periodo=record.data.id_periodo_subsistema;
		    desc_periodo=record.data.desc_periodo;
		}
		cmb_gestion.on('select',onGestionSelect);
		cmb_gestion.on('change',onGestionSelect);
		cmb_periodo.on('select',set_periodo);
		
		*/
		//gestion.setValue(anio);
		//periodo.setValue(mes);
		/*var onParametroSelect = function(e) {
			var id = combo_parametro.getValue()
			alert("llega aqui su para metro es "+id);
		}
		var onGestion = function(e) {
			var ges = gestion.getValue()
			alert("llega aqui su para metro es "+ges);
			
		};
		var onPeriodo = function(e) {
			var per = periodo.getValue()
			alert("llega aqui su para metro es "+per);
			
		};
		combo_parametro.on('select', onParametroSelect);
		combo_parametro.on('change', onParametroSelect);
		gestion.on('change', onGestion);
		periodo.on('change',onPeriodo)	*/
	}
	


	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
/*	function obtenerTitulo()
	{
		var lov_empleado = ClaseMadre_getComponente('des_empleado');
		var aux = lov_empleado.lov.recuperar_valoresSelecionados();

		return aux["nombre"] + " " +aux["apellido_paterno"] + " " + aux["apellido_materno"];
	}*/


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../control/actualizar_libros/ActionActualizarLibros.php',
			abrir_pestana:false, //abrir pestana
		//	titulo_pestana:obtenerTitulo,
			titulo_pestana:'Actualizar Información Libros',
			fileUpload:false,
			columnas:[450,305],   
			grupos:[
			{
				tituloGrupo:'Datos Para Actualizar Información',
				columna:0,
				id_grupo:0
			}],
			parametros: ''
		}
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