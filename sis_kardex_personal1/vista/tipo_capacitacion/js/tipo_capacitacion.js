/**
 * Nombre:		  	    pagina_tipo_capacitacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
 */
function pagina_tipo_capacitacion(idContenedor,direccion,paramConfig,tipo){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_capacitacion/ActionListarTipoCapacitacion.php?carrera='+tipo}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_capacitacion',totalRecords:'TotalCount'
		},[		
		'id_tipo_capacitacion',
		'nombre',
		'descripcion',
		
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},'carrera'
		
		
		]),remoteSort:true});

	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna_tipo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_capacitacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};

// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'capaci.nombre'
		
	};
	
	
	
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'capaci.descripcion'
		
	};

	
	Atributos[3]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['activo','Activo'],['inactivo','Inactivo']
						]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_tipo_capacitacion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		form:true,
		filtro_1:false,
		filterColValue:'capaci.estado_reg',
		save_as:'estado_reg'
		};
		
	Atributos[4]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};	
	
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name: 'carrera',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		defecto:tipo.substr(0, 2),
		filtro_0:false
		
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var titulo_tipcap;
	titulo_tipcap ='Capacitaciones';
	if(tipo.substr(0, 2)=='si'){
		titulo_tipcap='Registro de Carreras';
	} 
	var config={titulo_maestro:titulo_tipcap,grid_maestro:'grid-'+idContenedor};
	var layout_capacitacion=new DocsLayoutMaestro(idContenedor);
	layout_capacitacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_capacitacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_capacitacion/ActionEliminarTipoCapacitacion.php'},
		Save:{url:direccion+'../../../control/tipo_capacitacion/ActionGuardarTipoCapacitacion.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_capacitacion/ActionGuardarTipoCapacitacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:titulo_tipcap}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	   
	}
	
  //27/06/2011	para utlizar combo trigguer 
  if(tipo.substr(0, 2)=='si'){

	  this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						carrera:'si'
					}
				});
				
		if(tipo.substr(0, 2)=='si'){
			Atributos[5].defecto='si';
			
			
		}else{
			Atributos[5].defecto='no';
			
		}
		
	};
  }
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_capacitacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_capacitacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}