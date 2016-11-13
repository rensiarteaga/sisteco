/**
* Nombre:		  	    pagina_orden_compra_np.js
* Propósito: 			pagina objeto principal
* Autor:				
* Fecha creación:		
*/
function pagina_indice_solicitudes_uo(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
  var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});	
	
	
			
  var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?todos=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto',
			'codigo_depto','nombre_depto'])
	});	
	
	var ds_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_adquisiciones/control/categoria_adq/ActionListarCategoriaAdq.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_adq',totalRecords: 'TotalCount'},['id_categoria_adq','nombre','id_moneda'])});		
			
//			'fecha_reg','precio_min','precio_max','id_moneda','desc_moneda','norma','simplificada','defecto'])
	
	//FUNCIONES RENDER
	
		 
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</b></i>','</div>');
    var tpl_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','</div>');


vectorAtributos[0]={
		validacion:{
			name:'reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Por Unidades Organizacionales'],['2','Por Departamento']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'reporte'
	};
	
vectorAtributos[1]={
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
		defecto:"",
		id_grupo:0
	};
	///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		//id_grupo:2,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:"",
		id_grupo:0
	};
 vectorAtributos[3]={
			validacion:{
			name:'id_categoria_adq',
			fieldLabel:'Categoria',
			allowBlank:false,			
			emptyText:'Categorias ...',
			desc:'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria_adq,
			valueField:'id_categoria_adq',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'CATADQ.nombre',
			typeAhead:false,
			tpl:tpl_categoria_adq,
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
		save_as:'id_categoria_adq',
		id_grupo:0
	};
	vectorAtributos[4]={
		validacion:{
			name:'tipo_impresion',
			fieldLabel:'Tipo de Impresión',
			vtype:'texto',
			emptyText:'Elija el Tipo de Impresion...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','PDF'],['2','EXCEL'],['1','WORD']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
	    defecto:'Resumen Global',
		save_as:'tipo_impresion'
	};		
vectorAtributos[5]={
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
		id_grupo:1
	};
	vectorAtributos[6]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc:'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol:'DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
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
		save_as:'id_depto',
		id_grupo:2
	};
	

	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_ini',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'rep_fecha_ini'
	};

	vectorAtributos[8]={
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
	vectorAtributos[9]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','Resumen General'],['1','Resumen a Detalle']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:3,
	    defecto:'Resumen Global',
		save_as:'tipo_reporte'
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
		titulo_maestro:'Indice de solicitudes por Unidad Organizacional'

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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	
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
		var titulo = "Indice de solicitudes por Unidad Organizacional";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/_reportes/estadisticas_compro/ActionPDFRIndiceSolicitudesUo.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Indice de Solicitudes',
		grupos:[
		{
			tituloGrupo:'Datos de Consulta',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Unidad Organizacional',
			columna:1,
			id_grupo:1
		},
		{
			tituloGrupo:'Departamento',
			columna:1,
			id_grupo:2
		},
		
		
		{
			tituloGrupo:'Reporte',
			columna:1,
			id_grupo:3
		}
		
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		CM_ocultarGrupo('Reporte');
		CM_ocultarGrupo('Unidad Organizacional');
		CM_ocultarGrupo('Departamento');
		
		combo_fecha_inicio=ClaseMadre_getComponente('fecha_ini');
		combo_fecha_fin=ClaseMadre_getComponente('fecha_fin');	
		combo_rep_fecha_ini=ClaseMadre_getComponente('rep_fecha_ini');
		combo_rep_fecha_fin=ClaseMadre_getComponente('rep_fecha_fin');
		
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
		
		ClaseMadre_getComponente('reporte').on('select',evento_tipo_reporte);
		combo_fecha_inicio.on('select',onFecha_inicioSelect);
		combo_fecha_inicio.on('change',onFecha_inicioSelect);
		combo_fecha_fin.on('change',onFecha_finSelect);
		ClaseMadre_getComponente('id_unidad_organizacional').on('select',evento_unidad_organizacional);
		ClaseMadre_getComponente('id_depto').on('select',evento_depto);
	
	}
	function evento_tipo_reporte(combo,record,index){ 
		if (record.data.ID=='1'){
			CM_mostrarGrupo('Unidad Organizacional');
			CM_ocultarGrupo('Reporte');
			CM_ocultarGrupo('Departamento');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
			ClaseMadre_getComponente('id_depto').allowBlank=true;
		}else{
			CM_mostrarGrupo('Departamento');
			CM_ocultarGrupo('Reporte');
		    CM_ocultarGrupo('Unidad Organizacional');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
			ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
	
		}
	}
	
	function evento_unidad_organizacional( combo, record, index )
	{
		 ClaseMadre_getComponente('id_depto').reset();
		// ClaseMadre_getComponente('id_unidad_organizacional').reset();
		if (record.data.id_unidad_organizacional=='%'){
		   CM_mostrarGrupo('Reporte');	
		   ClaseMadre_getComponente('id_depto').allowBlank=true;
		  
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('id_depto').allowBlank=true;
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
		}
		
		
	}
    
	function evento_depto( combo, record, index )
	{
		 ClaseMadre_getComponente('id_unidad_organizacional').reset();
		// ClaseMadre_getComponente('id_depto').reset();
		if (record.data.id_depto=='%'){
		   CM_mostrarGrupo('Reporte');	
		   ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
			ClaseMadre_getComponente('id_unidad_organizacional').allowBlank=true;
		}
		
		
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
