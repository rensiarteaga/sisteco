/**
* Nombre:		  	    pagina_proceso_compra_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_proceso_compra_mul(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0,cmpIdCategoria;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraMul.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[
		'id_proceso_compra',
		'observaciones',
		'codigo_proceso',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_categoria_adq',
		'desc_categoria_adq',
		'id_moneda',
		'desc_moneda',
		'num_cotizacion',
		'num_proceso',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_cotizacion_sis',
		'num_proceso_sis',
		{name: 'fecha_proc',type:'date',dateFormat:'Y-m-d'},

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

		var ds_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_adq/ActionListarCategoriaAdq.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_adq',totalRecords: 'TotalCount'},['id_categoria_adq','nombre','precio_min','precio_max','id_moneda','desc_moneda'])
		});

		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});

		//FUNCIONES RENDER

		function render_id_categoria_adq(value, p, record){	return String.format('{0}', record.data['desc_categoria_adq'])}
		var tpl_id_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">[{precio_min}  -  {precio_max}] {desc_moneda}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_proceso_compra
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra'
		};
		// txt id_tipo_categoria_adq
		Atributos[1]={
			validacion:{
				name:'id_categoria_adq',
				fieldLabel:'Categoria',
				emptyText:'Categoria...',
				desc: 'desc_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_categoria_adq,
				valueField: 'id_categoria_adq',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'CATADQ.nombre',
				disable:true,
				typeAhead:true,
				tpl:tpl_id_categoria_adq,
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
				renderer:render_id_categoria_adq,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		// txt codigo_proceso
		Atributos[2]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};
		// txt id_moneda
		Atributos[3]={
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
				typeAhead:true,
				tpl:tpl_id_moneda,
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
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
		// txt num_proceso
		Atributos[4]={
			validacion:{
				name:'num_proceso',
				fieldLabel:'Nº Proceso',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};
		// txt num_cotizacion
		Atributos[5]={
			validacion:{
				name:'num_cotizacion',
				fieldLabel:'Nº Cotización',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.num_cotizacion',
			save_as:'num_cotizacion'
		};

		// txt observaciones
		Atributos[6]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};

		// txt fecha_reg
		Atributos[7]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};

		// txt periodo
		Atributos[8]={
			validacion:{
				name:'periodo',
				fieldLabel:'Periodo',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.periodo',
			save_as:'periodo'
		};
		// txt gestion
		Atributos[9]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestion',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion',
			save_as:'gestion'
		};
		// txt estado_vigente
		Atributos[10]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};


		// txt siguiente_estado
		Atributos[11]={
			validacion:{
				name:'siguiente_estado',
				fieldLabel:'Siguiente Estado',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.siguiente_estado',
			save_as:'siguiente_estado'
		};

		// txt num_cotizacion_sis
		Atributos[12]={
			validacion:{
				name:'num_cotizacion_sis',
				fieldLabel:'Nº Cotización sis',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_cotizacion_sis',
			save_as:'num_cotizacion_sis'
		};
		// txt num_proceso_sis
		Atributos[13]={
			validacion:{
				name:'num_proceso_sis',
				fieldLabel:'Nº Proceso sis',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_proceso_sis',
			save_as:'num_proceso_sis'
		};
		// txt fecha_reg
		Atributos[14]= {
			validacion:{
				name:'fecha_proc',
				fieldLabel:'Fecha Proceso',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PROCOM.fecha_proc',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_proc'
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'proceso_compra',grid_maestro:'grid-'+idContenedor};
		var layout_proceso_compra=new DocsLayoutMaestro(idContenedor);
		layout_proceso_compra.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_proceso_compra,idContenedor);
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
			btnEliminar:{url:direccion+'../../../control/proceso_compra/ActionEliminarProcesoCompraMul.php'},
			Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
			ConfirmSave:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function btn_solicitud_proceso_compra(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;

					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/solicitud_proceso_compra/solicitud_proceso_compra_det.php?'+data,'Solicitudes de Compra',ParamVentana);
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_proceso_compra_det(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;

					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_det_det.php?'+data,'Procedimiento Detalle',ParamVentana);
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				cmpIdCategoria=getComponente('id_categoria_adq');
				ocultarComponente(cmpIdCategoria);
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Solicitudes de Compra',btn_solicitud_proceso_compra,true,'solicitud_proceso_compra','');

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Procedimiento Detalle',btn_proceso_compra_det,true,'proceso_compra_det','');

			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_proceso_compra.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}