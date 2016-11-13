/**
 * Nombre:		  	    pagina_servicio_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:47:23
 */
function pagina_servicio_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio/ActionListarServicio_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_servicio',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_servicio',
		'nombre',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_servicio',
		'id_tipo_servicio',
		'codigo_entero',
		'codigo','continuo','estado'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_servicio:maestro.id_tipo_servicio
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");


	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_servicio
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_servicio',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_servicio'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
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
		filterColValue:'SERVIC.nombre',
		save_as:'nombre'
	};
	
	
	Atributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:40,
			disable:false,
			grid_indice:5		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'TIPADQ.codigo',
		save_as:'codigo'
	};
	
	Atributos[3]={
		validacion:{
			name:'continuo',
			fieldLabel:'Contínuo',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:2,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:40,
			disable:true,
			grid_indice:3	
		},
		tipo: 'ComboBox',
		defecto:'si',
		form: false,
		filtro_0:true,
		filterColValue:'SERVIC.continuo',
		save_as:'continuo'
	};
// txt descripcion
	Atributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
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
		filterColValue:'SERVIC.descripcion',
		save_as:'descripcion'
	};
// txt fecha_reg
	Atributos[5]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
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
		filterColValue:'SERVIC.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};
// txt id_tipo_servicio
	Atributos[6]={
		validacion:{
			name:'id_tipo_servicio',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_servicio,
		save_as:'id_tipo_servicio'
	};

	
	Atributos[7]={
		validacion:{
			name:'codigo_entero',
			fieldLabel:'Codigo ',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:40,
			disable:true,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'TIPSER.codigo#SERVIC.codigo',
		save_as:'codigo'
	};
	Atributos[8]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:10,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:80,
			disable:true,
			grid_indice:7	
		},
		tipo: 'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.estado',
		save_as:'estado'
	};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipos de Servicio (Maestro)',titulo_detalle:'Servicios (Detalle)',grid_maestro:'grid-'+idContenedor};
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
	btnEliminar:{url:direccion+'../../../control/servicio/ActionEliminarServicio.php',parametros:'&m_id_tipo_servicio='+maestro.id_tipo_servicio},
	Save:{url:direccion+'../../../control/servicio/ActionGuardarServicio.php',parametros:'&m_id_tipo_servicio='+maestro.id_tipo_servicio+'&m_codigo='+maestro.codigo},
	ConfirmSave:{url:direccion+'../../../control/servicio/ActionGuardarServicio.php',parametros:'&m_id_tipo_servicio='+maestro.id_tipo_servicio+'&m_codigo='+maestro.codigo},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:'80%',minWidth:'80%',minHeight:200,	closable:true,titulo:'Servicios'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/tipo_servicio/ActionListarTipoServicio.php?id_tipo_servicio='+maestro.id_tipo_servicio}),
	
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
				id_tipo_servicio:maestro.id_tipo_servicio

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
		
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Nombre',ds_maestro.getAt(0).get('nombre')],['Tipo de Adquisicion',ds_maestro.getAt(0).get('desc_tipo_adq')],['Codigo',ds_maestro.getAt(0).get('codigo')],['Descripcion',ds_maestro.getAt(0).get('descripcion')],['Cuenta',ds_maestro.getAt(0).get('nombre_cuenta')],['Partida',ds_maestro.getAt(0).get('nombre_partida')]]));
		}
	
	
		this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_tipo_servicio=datos.m_id_tipo_servicio;
    		maestro.nombre=datos.m_nombre;
    		maestro.codigo=datos.m_codigo;
    		maestro.descripcion=datos.m_descripcion;
			ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_tipo_servicio:maestro.id_tipo_servicio
				},
				callback:cargar_maestro
			});
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_tipo_servicio:maestro.id_tipo_servicio,
					m_descripcion:maestro.descripcion,
					m_codigo:maestro.codigo
				}
			};
		this.btnActualizar();
		
		Atributos[6].defecto=maestro.id_tipo_servicio;
		paramFunciones.btnEliminar.parametros='&m_id_tipo_servicio='+maestro.id_tipo_servicio;
		paramFunciones.Save.parametros='&m_id_tipo_servicio='+maestro.id_tipo_servicio+'&m_codigo='+maestro.codigo;
		paramFunciones.ConfirmSave.parametros='&m_id_tipo_servicio='+maestro.id_tipo_servicio+'&m_codigo='+maestro.codigo;
		this.InitFunciones(paramFunciones)
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