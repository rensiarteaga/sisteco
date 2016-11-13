/**
* Nombre:		  	    pagina_detalle_compremetido_sol_uo
* Propósito: 			pagina objeto principal
* Autor:				
* Fecha creación:		
*/
function pagina_detalle_comprometido_sol_uo(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
	//departamentos
  var ds_departamento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});	
	
		
	//FUNCIONES RENDER
	
		 
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto}-{nombre_depto}</b></i>','</div>');
vectorAtributos[0]={
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
	vectorAtributos[1]={
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
	
vectorAtributos[2]={
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

	vectorAtributos[3]={
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
vectorAtributos[4]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc:'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
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
		id_grupo:0
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
		id_grupo:1,
	    defecto:'Resumen Global',
		save_as:'tipo_reporte'
	};
	vectorAtributos[7]={
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
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('m/d/Y') : '';
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
		url:direccion+'../../../../control/_reportes/estadisticas_compro/ActionPDFDetalleComprometidoSolUo.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'',
		grupos:[
		{
			tituloGrupo:'Datos de Consulta',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Reporte',
			columna:0,
			id_grupo:1
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
		
		combo_fecha_inicio=ClaseMadre_getComponente('fecha_ini');
		combo_fecha_fin=ClaseMadre_getComponente('fecha_fin');	
		combo_rep_fecha_ini=ClaseMadre_getComponente('rep_fecha_ini');
		combo_rep_fecha_fin=ClaseMadre_getComponente('rep_fecha_fin');
		tipo_reporte = ClaseMadre_getComponente('tipo_reporte');	
        tipo_impresion = ClaseMadre_getComponente('tipo_impresion');
        tipo_grafico = ClaseMadre_getComponente('tipo_grafico');
        
		tipo_grafico.setValue(0);
		tipo_grafico.setRawValue('Lineas');	
		
		tipo_impresion.setValue(0);
		tipo_impresion.setRawValue('PDF');	
		
		tipo_reporte.setValue(0);
		tipo_reporte.setRawValue('Resumen Global');	
			//Validación por la fecha.
		var onFecha_inicioSelect = function(e) {
			var fecha_inicio_val=combo_fecha_inicio.getValue();
				combo_fecha_fin.minValue=fecha_inicio_val;
				combo_rep_fecha_ini.setValue(formatDate(combo_fecha_inicio.getValue()));
				ClaseMadre_getComponente('id_depto').store.baseParams={sw_vista:'rep_detalle_op_sel',fecha_ini:formatDate(combo_fecha_inicio.getValue()),fecha_fin:formatDate(combo_fecha_fin.getValue()),todos:'si'};
				
		ClaseMadre_getComponente('id_depto').modificado=true;
		ClaseMadre_getComponente('id_depto').setValue('');
		
				
		};
		var onFecha_finSelect = function(e) {
			var fecha_fin_val=combo_fecha_fin.getValue();
				combo_rep_fecha_fin.setValue(formatDate(combo_fecha_fin.getValue()));
				
				ClaseMadre_getComponente('id_depto').store.baseParams={sw_vista:'rep_detalle_op_sel',fecha_ini:formatDate(combo_fecha_inicio.getValue()),fecha_fin:formatDate(combo_fecha_fin.getValue()),todos:'si'};
				
		ClaseMadre_getComponente('id_depto').modificado=true;
		ClaseMadre_getComponente('id_depto').setValue('');
		
			
		};
		
		combo_fecha_inicio.on('select',onFecha_inicioSelect);
		combo_fecha_inicio.on('change',onFecha_inicioSelect);
		combo_fecha_fin.on('change',onFecha_finSelect);
		ClaseMadre_getComponente('id_depto').on('select',evento_departamento);
	
	}
	
	function evento_departamento( combo, record, index )
	{
		
		if (record.data.id_depto=='%'){
		   CM_mostrarGrupo('Reporte');	
		}else{
			ClaseMadre_getComponente('tipo_reporte').reset();
			CM_ocultarGrupo('Reporte');
			ClaseMadre_getComponente('tipo_reporte').allowBlank=true;
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
