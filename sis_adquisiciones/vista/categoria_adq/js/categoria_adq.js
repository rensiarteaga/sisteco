/**
 * Nombre:		  	    pagina_categoria_adq_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-14 16:23:16
 */
function pagina_categoria_adq(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_adq/ActionListarCategoriaAdq.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_categoria_adq',totalRecords:'TotalCount'
		},[		
				'id_categoria_adq',
		'nombre',
		'observaciones',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'precio_min',
		'precio_max',
		'desc_moneda',
		'id_moneda',
		'norma',
		'simplificada',
		'defecto','doc_respaldo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_categoria_adq
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_categoria_adq'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Modalidad',
			allowBlank:false,
			maxLength:80,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.nombre',
		save_as:'nombre'
	};
// txt observaciones
	Atributos[2]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'100%',
			disable:false,
			grid_indice:4		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.observaciones',
		save_as:'observaciones'
	};
// txt descripcion
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:80,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disable:false,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.descripcion',
		save_as:'descripcion'
	};
// txt fecha_reg
	Atributos[4]= {
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
			grid_indice:8		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CATADQ.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};
// txt precio_min
	Atributos[5]={
		validacion:{
			name:'precio_min',
			fieldLabel:'Precio Mínimo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			align:'right',
			disable:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.precio_min',
		save_as:'precio_min'
	};
// txt precio_max
	Atributos[6]={
		validacion:{
			name:'precio_max',
			fieldLabel:'Precio Máximo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:6		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CATADQ.precio_max',
		save_as:'precio_max'
	};
// txt id_moneda
	Atributos[7]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
// txt descripcion
	Atributos[8]={
		validacion:{
			name:'norma',
			fieldLabel:'Norma',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['SABS','SABS'],['EPNE','EPNE'],['BID','BID'],['OTRO','OTRO']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			width:100,
			minListWidth:100,
			disable:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATADQ.norma',
		save_as:'norma'
	};
	// txt descripcion
	Atributos[9]={
		validacion:{
			name:'simplificada',
			fieldLabel:'Simplificada',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','No'],['1','Si']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			width:100,
			minListWidth:100,
			disable:false,
			renderer:simplificada		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATADQ.simplificada',
		save_as:'simplificada'
	};
	// txt descripcion
	Atributos[10]={
		validacion:{
			name:'defecto',
			fieldLabel:'Defecto',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','No'],['1','Si']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100,
			minListWidth:100,
			disable:false,
			renderer:simplificada	
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATADQ.defecto',
		save_as:'defecto'
	};
	
		Atributos[11]={
		validacion:{
			name:'doc_respaldo',
			fieldLabel:'Doc. Respaldo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['no','No'],['si','Si']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			width:100,
			minListWidth:100,
			disable:false
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATADQ.doc_respaldo',
		save_as:'doc_respaldo'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
    function simplificada(value){
    	if(value==0) return 'No';
    	else return 'Si'
    };
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'categoria_adq',grid_maestro:'grid-'+idContenedor};
	var layout_categoria_adq=new DocsLayoutMaestro(idContenedor);
	layout_categoria_adq.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_categoria_adq,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var Cm_conexionFailure=this.conexionFailure;

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
		btnEliminar:{url:direccion+'../../../control/categoria_adq/ActionEliminarCategoriaAdq.php'},
		Save:{url:direccion+'../../../control/categoria_adq/ActionGuardarCategoriaAdq.php'},
		ConfirmSave:{url:direccion+'../../../control/categoria_adq/ActionGuardarCategoriaAdq.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:350,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Categoria de Adquisición'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_tipo_categoria_adq(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_categoria_adq='+SelectionsRecord.data.id_categoria_adq;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_categoria_adq.loadWindows(direccion+'../../../../sis_adquisiciones/vista/tipo_categoria_adq/tipo_categoria_adq_det.php?'+data,'Tipo Categoría',ParamVentana);
layout_categoria_adq.getVentana().on('resize',function(){
			layout_categoria_adq.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	
	function btn_clon(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_categoria_adq='+SelectionsRecord.data.id_categoria_adq+'&clon=si';
			
			if(confirm("Está seguro de Clonar la Categoria?")){

							Ext.MessageBox.show({
								title: 'Espere por favor...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
								width:150,
								height:200,
								closable:false
							});

							Ext.Ajax.request({
								url:direccion+"../../../control/categoria_adq/ActionGuardarCategoriaAdq.php?"+data,
								method:'GET',
								success:terminado,
								failure:Cm_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							})
			}
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	function terminado(resp){
				Ext.MessageBox.hide();
				

				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('error')[0].firstChild.nodeValue)=='false'){
						ds.load({
							params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
								
							}
						});
					}
				}
			}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_categoria_adq.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Tipo Categoría',btn_tipo_categoria_adq,true,'tipo_categoria_adq','');
		
		this.AdicionarBoton('../../../lib/imagenes/copy.png','Clonar',btn_clon,true,'clon','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_categoria_adq.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}