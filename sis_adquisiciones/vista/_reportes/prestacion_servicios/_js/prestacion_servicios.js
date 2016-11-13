/**
* Nombre:		  	    pagina_orden_compra_np.js
* Propósito: 			pagina objeto principal
* Autor:				AMVQ
* Fecha creación:		08/03/2010
*/
function pagina_prestacion_servicios(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
	var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=compro&oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
	var ds_proveedor=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','mail_proveedor','telefono1_proveedor','desc_insti_per'])
	});
	
	 var ds_tipo_adq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_adq/ActionListarTipoAdq.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_adq',
			totalRecords: 'TotalCount'
		}, ['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion','fecha_reg','codigo','estado'])
	});
	
	var ds_tipo_servicio= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_servicio/ActionListarTipoServicio.php?origen=filtro&oc=si'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_servicio',
			totalRecords: 'TotalCount'
		}, ['id_tipo_servicio','nombre','descripcion','fecha_reg','id_tipo_adq','desc_tipo_adq'])
	});
	

    	
	//FUNCIONES RENDER
	
		
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	function renderTipoAdq(value, p, record){return String.format('{0}', record.data['nombre']);}
	function renderTipoServicio(value, p, record){return String.format('{0}', record.data['nombre']);}
	
   var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
   var resultTplProv=new Ext.Template('<div class="search-item">','<b><i>{desc_insti_per}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo}</FONT>','<br><FONT COLOR="#B5A642">Email:{mail_proveedor}</FONT>','<br><FONT COLOR="#B5A642">Teléfono:{telefono1_proveedor}</FONT>','</div>');

  
vectorAtributos[0]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			width:200,
			editable:true
		},
		id_grupo:0,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	vectorAtributos[1]={
		validacion:{
			labelSeparator:'',
			name:'desc_depto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_depto'
	};
	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Proveedor',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Proveedor...',
			name:'desc_insti_per',
			desc:'desc_insti_per',
			store:ds_proveedor,
			valueField:'id_proveedor',
			displayField:'desc_insti_per',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplProv,
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
		save_as:'proveedor',
		tipo:'ComboBox'
	};
	vectorAtributos[3]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	///////// fecha /////////
	vectorAtributos[4]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Tipo Adquisición',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Tipo Adquisicion...',
			name:'id_tipo_adq',
			desc:'nombre',
			store:ds_tipo_adq,
			valueField:'id_tipo_adq',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:renderTipoAdq,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
			
		},
		
		save_as:'id_tipo_adq',
		tipo:'ComboBox',
		id_grupo:1
	};
	//vectorAtributos[0] = param_id_supergrupo;
	filterCols_tipo_servicio=new Array();
	filterValues_tipo_servicio=new Array();
	filterCols_tipo_servicio[0]='TIPADQ.id_tipo_adq';
	filterValues_tipo_servicio[0]='%';
	

	vectorAtributos[6]={
		validacion:{
			fieldLabel:'Tipo Servicio',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Tipo Servicio...',
			name:'id_tipo_servicio',
			desc:'nombre',
			store:ds_tipo_servicio,
			valueField:'id_tipo_servicio',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'TIPSER.nombre',
			filterCols:filterCols_tipo_servicio,
			filterValues:filterValues_tipo_servicio,
			typeAhead:true,
			forceSelection:true,
			renderer:renderTipoServicio,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		save_as:'id_tipo_servicio',
		tipo:'ComboBox',
		id_grupo:1
	};
	vectorAtributos[7]={
		validacion:{
			name              :  'estado',
			fieldLabel        :  'Estados',
			dataFields        :  ['code', 'desc'],
			data              :   Ext.proc_prestacionCombo.estado,
			valueField        :  'code',
			displayField      :  'desc',
			width             :  140,
			height            :  120,
			allowBlank        :  false
		},
		tipo:'Multiselect',
		save_as:'estado',
		id_grupo:2
	};
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'desc_proveedor',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_proveedor'
	};
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'desc_tipo_adq',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_tipo_adq'
	};
vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'desc_tipo_servicio',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_tipo_servicio'
	};
	
	
vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_ini',
			inputType:'hidden',
			//format:'d/m/Y',
			//renderer:formatDate,
			grid_visible:false,
			grid_editable:false
		},
		
		filtro_0:false,
		tipo:'DateField',
		save_as:'rep_fecha_ini',
		dateFormat:'d/m/Y'
		//defecto:""
	};
vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_fin',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_fin'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Parametros de Reporte Prestacion de Servicios'

	};
	layout=new DocsLayoutProceso(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Reporte Orden de Compra";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/_reportes/prestacion_servicios/ActionPDFPrestacionServicios.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'nose donde sale',
		grupos:[
		{
			tituloGrupo:'Departamento',
			columna:0,
			id_grupo:0},
		{
			tituloGrupo:'Clasificación Servicios',
			columna:0,
			id_grupo:1
		},
		{tituloGrupo:'Tipo de Reporte',columna:0,id_grupo:2}
		
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		combo_tipo_adq= ClaseMadre_getComponente('id_tipo_adq');
		combo_tipo_adq.enable();	
		combo_tipo_servicio= ClaseMadre_getComponente('id_tipo_servicio');
		combo_fecha_inicio=ClaseMadre_getComponente('fecha_ini');
		combo_fecha_fin=ClaseMadre_getComponente('fecha_fin');	
		combo_rep_fecha_ini=ClaseMadre_getComponente('rep_fecha_ini');
		combo_rep_fecha_fin=ClaseMadre_getComponente('rep_fecha_fin');
		componentes[0].on('select',evento_departamento);		//departamento
		componentes[2].on('select',evento_proveedor);		//proveedor
		componentes[6].on('select',evento_tipo_servicio);		//tipo_servicio
		
		
		function funComboTipoAdq(e){
			combo_tipo_adq.setValue(e.value);
			combo_tipo_servicio.filterValues[0] =e.value;
			combo_tipo_servicio.modificado = true;
			
		}
		combo_tipo_adq.on('select',funComboTipoAdq);
		//Validación por la fecha.
		var onFecha_inicioSelect = function(e) {
			var fecha_inicio_val=combo_fecha_inicio.getValue();
				combo_fecha_fin.minValue=fecha_inicio_val;
				
				combo_rep_fecha_ini.setValue(formatDate(combo_fecha_inicio.getValue()));
				
				
			
		};
		var onFecha_finSelect = function(e) {
			var fecha_fin_val=combo_fecha_fin.getValue();
				combo_rep_fecha_fin.setValue(formatDate(combo_fecha_fin.getValue()));
			
		};
		
		combo_fecha_inicio.on('select',onFecha_inicioSelect);
		combo_fecha_inicio.on('change',onFecha_inicioSelect);
		combo_fecha_fin.on('change',onFecha_finSelect);
		
	
	}
	
	function evento_departamento( combo, record, index )
		{		
			componentes[1].setValue(record.data.codigo_depto+'-'+record.data.nombre_depto);
		}
		
	function evento_proveedor( combo, record, index )
		{		
			componentes[8].setValue(record.data.desc_insti_per);
		}
	function evento_tipo_servicio( combo, record, index )
		{		
			componentes[9].setValue(record.data.desc_tipo_adq);
			componentes[10].setValue(record.data.descripcion);
		}
	       

	
	
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
  
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
