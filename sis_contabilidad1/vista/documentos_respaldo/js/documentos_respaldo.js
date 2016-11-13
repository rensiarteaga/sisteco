function DocumentoRespaldo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;

	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE

	
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
		
		
var ds_departamento = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_conta/ActionListarDepartamentoConta.php'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto_conta',totalRecords:'TotalCount'},
	['id_depto_conta','id_depto','nombre_depto','desc_ep','nombre_unidad','desc_cta_aux']),
    baseParams:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,tipo_vista:'rep_balance'}
});
var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
			
	});

var ds_plantilla=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plantilla',totalRecords:'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo'])
			
	});	


		
	//FUNCIONES RENDER
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
    var tpl_id_depto=new Ext.Template('<div class="search-item">','<b>{nombre_depto}</b><br>','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{desc_ep}</FONT><br>','<FONT COLOR="#B5A642">{desc_cta_aux}</FONT>','</div>');

	var resultTplParametro = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion_conta}</b>','<br><FONT COLOR="#B5A642">Estado: {desc_estado}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','<br><FONT COLOR="#B5A642"><b>Tipo Plantilla: </b>{tipo_plantilla}</FONT>','</div>');
	
		
	
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
			tpl:resultTplParametro,
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
		save_as:'fecha_inicio',
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
		save_as:'fecha_fin',
		id_grupo:0
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento Contable',
			emptyText:'Departamento Contable...',
			store:ds_departamento,
			displayField: 'nombre_depto',
			valueField: 'id_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_depto',
		id_grupo:1
		};
	// txt id_moneda
		 vectorAtributos[4]={
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
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			//renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1
	};
	// txt id_plantilla
		 vectorAtributos[5]={
			validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Plantilla',
			allowBlank:false,			
			emptyText:'Plantilla...',
			desc: 'desc_plantilla', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_plantilla,
			valueField: 'tipo_plantilla',
			displayField: 'desc_plantilla',
			queryParam: 'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			typeAhead:false,
			tpl:tpl_id_plantilla,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		save_as:'tipo_plantilla',
		id_grupo:1
	};
	
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
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'moneda',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'moneda'
	};	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Parametros Documentos Respaldo"
	};
	layout_rep_documento_respaldo=new DocsLayoutProceso(idContenedor);
	layout_rep_documento_respaldo.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_documento_respaldo,idContenedor);
	
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
		cmbMoneda=ClaseMadre_getComponente('id_moneda');
		moneda=ClaseMadre_getComponente('moneda');

		
		
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
		
				 
		};
		
		var onMonedaSelect = function(e){
			var id =cmbMoneda.getValue();
			if(cmbMoneda.store.getById(id)!=undefined){
				moneda.setValue(cmbMoneda.store.getById(id).data.simbolo);
				
			}
		};
		
		
		cmbGestion.on('select',onGestionSelect);
		cmbMoneda.on('select',onMonedaSelect);
	}
	



	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../control/documento/reporte/ActionPDFDocumentosRespaldoComprobantes.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Reporte Documentos Respaldo',
			fileUpload:false,
			columnas:[505,305],
			parametros: '',
			grupos:[
		      {tituloGrupo:'Fechas',columna:0,id_grupo:0},
		      {tituloGrupo:'Departamento',columna:0,id_grupo:1}
		      ]}
		
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
