/**
 * Nombre:		  	    pagina_archivos_normativas.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2013-05-16 11:47:23
 */
function pagina_archivos_normativas(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/archivos_normativas_internas/ActionListarArchivosNormativas.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_archivos_normativas',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_archivos_normativas',
		'nombre_archivo',
		'descripcion_archivo',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'ruta_archivo',
		'id_detalle_normativa',
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_detalle_normativa:maestro.id_detalle_normativa
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");


	//FUNCIONES RENDER
	
		function rutaEnlace(val) { if(val!="")

		{return '<a href="'+ direccion+"../../../../../comunidadEnde/vista/archivos/normativaInterna/"+val+'" target = "_blank">'+val+'</a>';}}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_servicio
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_archivos_normativas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_archivos_normativas'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre_archivo',
			fieldLabel:'NOMBRE ARCHIVO SSSSS',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'AN.nombre_archivo',
		save_as:'nombre_archivo'
	};
	

// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion_archivo',
			fieldLabel:'DESCRIPCION',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disable:false,
			grid_indice:4	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'AN.descripcion_archivo',
		save_as:'descripcion_archivo'
	};
// txt fecha_reg
	Atributos[3]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'FECHA REGISTRO',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:5	
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AN.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_registro'
	};
// txt id_tipo_servicio
	Atributos[4]={
			validacion:{
			name:'ruta_archivo',			
			fieldLabel:'ARCHIVO',
			//lazyRender:true,
			inputType:'file',
			maxLength:250,
			renderer:rutaEnlace,
			//forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		
		},
		tipo:'Field',
		form: true,
		save_as:'txt_archivo'
			
		};

	
	Atributos[5]={
		validacion:{
			name:'id_detalle_normativa',
			fieldLabel:'CODIGO DETALLE NORMATIVA ',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:40,
			disable:true,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'AN.id_detalle_normativa',
		save_as:'codigo'
	};

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={/*titulo_maestro:'TIPOS DE ARCHIVOS (Maestro)',*/titulo_detalle:'ARCHIVOS (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_servicio = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_servicio.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_servicio,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/archivos_normativas_internas/ActionEliminarNormativas.php',parametros:'&m_id_tipo_servicio='+maestro.id_tipo_servicio},
	Save:{url:direccion+'../../../control/archivos_normativas_internas/ActionGuardarNormativas.php',parametros:'&m_id_detalle_normativa='+maestro.id_detalle_normativa+'&m_codigo='+maestro.codigo},
	ConfirmSave:{url:direccion+'../../../control/archivos_normativas_internas/ActionGuardarNormativas.php',parametros:'&m_id_tipo_servicio='+maestro.id_tipo_servicio+'&m_codigo='+maestro.codigo},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:'80%',minWidth:'80%',minHeight:200, fileUpload:true, upload:true,	closable:true,titulo:'ARCHIVOS NORMATIVAS'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	/*var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/tipo_servicio/ActionListarTipoServicio.php?id_tipo_servicio='+maestro.id_tipo_servicio}),
	
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_servicio',totalRecords: 'TotalCount'},['id_tipo_servicio',
		'nombre',
		'codigo',
		'descripcion',
		'desc_tipo_adq','nombre_cuenta','nombre_partida'
		])
		});
		
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_detalle_normativa:maestro.id_detalle_normativa

			},
			callback:cargar_maestro
		});*/

		/*function cargar_maestro(){
		
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Nombre',ds_maestro.getAt(0).get('nombre')],['Tipo de Adquisicion',ds_maestro.getAt(0).get('desc_tipo_adq')],['Codigo',ds_maestro.getAt(0).get('codigo')],['Descripcion',ds_maestro.getAt(0).get('descripcion')],['Cuenta',ds_maestro.getAt(0).get('nombre_cuenta')],['Partida',ds_maestro.getAt(0).get('nombre_partida')]]));
		}*/
	
	
		this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_detalle_normativa=datos.m_id_detalle_normativa;
    		maestro.nombre_subcategoria=datos.m_nombre_subcategoria;
    		maestro.codigo=datos.m_codigo;
    		maestro.descripcion_subcategoria=datos.m_descripcion_subcategoria;
			alert ('lllll');
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_detalle_normativa:maestro.id_detalle_normativa,
					m_descripcion_subcategoria:maestro.descripcion_subcategoria,
					m_codigo:maestro.codigo
				}
			};
		this.btnActualizar();
		
		/*Atributos[6].defecto=maestro.id_detalle_normativa;
		paramFunciones.btnEliminar.parametros='&m_id_tipo_servicio='+maestro.id_detalle_normativa;
		paramFunciones.Save.parametros='&m_id_tipo_servicio='+maestro.id_detalle_normativa+'&m_codigo='+maestro.codigo;
		paramFunciones.ConfirmSave.parametros='&m_id_tipo_servicio='+maestro.id_detalle_normativa+'&m_codigo='+maestro.codigo;
		this.InitFunciones(paramFunciones)*/
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_servicio.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_servicio.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}