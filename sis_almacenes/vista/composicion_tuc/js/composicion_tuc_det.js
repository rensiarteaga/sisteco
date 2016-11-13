/**
* Nombre:		  	    PaginaComposicionTuc.js
* Propósito: 			pagina objeto principal
* Autor:				Anacleto Rojas
* Fecha creación:		2007-11-06
*/
function PaginaComposicionTuc(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/composicion_tuc/ActionListarComposicionTuc_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_composicion_tuc',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_composicion_tuc',
		'cantidad',
		'opcional',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tuc_hijo',
		'desc_tipo_unidad_constructiva',
		'desc_tuc_hijo',
		'id_tipo_unidad_constructiva'

		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_tipo_unidad_constructiva:maestro.id_tipo_unidad_constructiva
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO
		/*var dataMaestro=[
		['ID',maestro.id_tipo_unidad_constructiva],
		['Codigo',maestro.codigo],
		['Nombre',maestro.nombre]
		];

		var dsMaestro = new Ext.data.Store({
			proxy: new Ext.data.MemoryProxy(dataMaestro),
			reader: new Ext.data.ArrayReader({id:0},[
			{name:'atributo'},
			{name:'valor'}
			])
		});
		dsMaestro.load();*/
		
		var cmMaestro = new Ext.grid.ColumnModel([
		{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
		{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}
		]);

		function negrita(value){
			return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';
		}
		function italic(value){
			return '<i>'+value+'</i>';
		}

		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
			ds:new Ext.data.SimpleStore({
				fields: ['atributo','valor'],
				data :[['ID',maestro.id_tipo_unidad_constructiva],
						['Codigo',maestro.codigo],
						['Nombre',maestro.nombre]]
			}),
			cm:cmMaestro
		});

		gridMaestro.render();


		//DATA STORE COMBOS//////////////////

		ds_tipo_unidad_constructiva = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_tipo_unidad_constructiva',
				totalRecords: 'TotalCount'

			}, ['id_tipo_unidad_constructiva','codigo','nombre'])
		});


		ds_composicion_tuc = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_tipo_unidad_constructiva',
				totalRecords: 'TotalCount'

			}, ['id_tipo_unidad_constructiva','codigo','nombre','desc_tipo_unidad_constructiva'])
		});

		//FUNCIONES RENDER

		function render_id_tipo_unidad_constructiva(value, p, record){return String.format('{0}', record.data['nombre']);};
		function render_composicion_hijo(value, p, record){return String.format('{0}', record.data['desc_tipo_unidad_constructiva']);};
		
		//desc_tipo_unidad_constructiva
		
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_composicion_tuc
		//en la posición 0 siempre esta la llave primaria

		vectorAtributos[0] = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_composicion_tuc',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_composicion_tuc'
		};
		// txt id_tuc_hijo
		vectorAtributos[1]= {
			validacion:{
				fieldLabel:'Composicion TUC',
				allowBlank:false,
				emptyText:'Composicion TUC Hijo...',
				name:'id_tuc_hijo',
				desc: 'desc_tipo_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_composicion_tuc,
				valueField: 'id_tipo_unidad_constructiva',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'TIPOUC.nombre',
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:450,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_composicion_hijo,
				grid_visible:true,
				grid_editable:false,
				width_grid:120 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TIPOUC.nombre',
			save_as:'txt_id_tuc_hijo'
		};
		// txt cantidad
		vectorAtributos[2]= {
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				align:'center',
				allowDecimals:false,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:60
			},
			tipo: 'NumberField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPTUC.cantidad',
			save_as:'txt_cantidad'
		};
		// txt opcional
		vectorAtributos[3]= {
			validacion: {
				name:'opcional',
				fieldLabel:'Opcional',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				align:'center',
				triggerAction: 'all',
				//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.composicion_tuc_combo.opcional}),
				store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['si','si'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPTUC.opcional',
			defecto:'si',
			save_as:'txt_opcional'
		};
		// txt fecha_reg
		vectorAtributos[4]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				width_grid:100,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPTUC.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
		// txt id_tipo_unidad_constructiva
		vectorAtributos[5]= {
			validacion:{
				name:'id_tipo_unidad_constructiva',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_tipo_unidad_constructiva,
			save_as:'txt_id_tipo_unidad_constructiva'
		};
		

				//////////////////////////////////////////////////////////////
		//----------- FUNCIONES RENDER---------------------------////
		/////////////////////////////////////////////////////////////
		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : '';
		};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={
			titulo_maestro:' Tipo Unidad Constructiva(Maestro)',
			titulo_detalle:'Composicion de Unidades Constructivas (Detalle)',
			grid_maestro:'grid-'+idContenedor
		};
		layout_composicion_tuc = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_composicion_tuc.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_composicion_tuc,idContenedor);
		
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;
		
		//-------- DEFINICIÓN DE LA BARRA DE MENÚ


		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};



		//--------- DEFINICIÓN DE FUNCIONES
		//aquí se parametrizan las funciones que se ejecutan en la clase madre

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/composicion_tuc/ActionEliminarComposicionTuc.php'},
			Save:{url:direccion+'../../../control/composicion_tuc/ActionGuardarComposicionTuc.php'},
			ConfirmSave:{url:direccion+'../../../control/composicion_tuc/ActionGuardarComposicionTuc.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,	height:340,	width:480, minWidth:150, minHeight:200,	closable:true, titulo: 'Composicion de Unidad Constructiva'	}
		};

		this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_unidad_constructiva=datos.m_id_tipo_unidad_constructiva;
		maestro.codigo=datos.m_codigo;
		maestro.nombre= datos.m_nombre;		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_unidad_constructiva:maestro.id_tipo_unidad_constructiva }
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Tipo Unidad',maestro.id_tipo_unidad_constructiva],['Codigo',maestro.codigo],['Nombre',maestro.nombre]]);
		vectorAtributos[5].defecto=maestro.id_tipo_unidad_constructiva;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/composicion_tuc/ActionEliminarComposicionTuc.php'},
			Save:{url:direccion+'../../../control/composicion_tuc/ActionGuardarComposicionTuc.php'},
			ConfirmSave:{url:direccion+'../../../control/composicion_tuc/ActionGuardarComposicionTuc.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,	height:340,	width:480, minWidth:150, minHeight:200,	closable:true, titulo: 'Composicion de Unidad Constructiva'	}
		};
		this.InitFunciones(paramFunciones)
	};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		
		this.btnNew = function()
		{	//dialog.resizeTo('50%','70%');
			/*CM_mostrarGrupo('Institución');
			CM_mostrarGrupo('Identificación de la Institución');
			CM_mostrarGrupo('Dirección Telefono');
			CM_mostrarGrupo('Dirección Correo - Web');
			CM_mostrarGrupo('Hora y Fecha Registro');
			CM_ocultarGrupo('Hora y Fecha Modificación');
			*/
			ClaseMadre_btnNew();
			get_fecha_bd();
			//get_hora_bd();
		};
		function get_fecha_bd()
		{
			Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
				method:'GET',
				success:cargar_fecha_bd,
				failure:ClaseMadre_conexionFailure,
				timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
		function cargar_fecha_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(componentes[4].getValue()=="")
				{

					componentes[4].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				}
				//   	componentes[14].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}

		//Para manejo de eventos
		function iniciarEventosFormularios()
		{
			//para iniciar eventos en el formulario
			
			txt_id_tipo_unidad_constructiva = ClaseMadre_getComponente ('id_tipo_unidad_constructiva');
			
			combo_id_tuc_hijo =	ClaseMadre_getComponente ('id_tuc_hijo');
			
			var onIdReemplazoSelect = function(e) {
				var reemp = combo_id_tuc_hijo.getValue();
				var id = txt_id_tipo_unidad_constructiva.getValue();
				if(reemp == id)
				{
					combo_id_tuc_hijo.setValue('');
					Ext.MessageBox.alert('Error!!!!!!','La Composicion  no puede ser el mismo');
				}

			};
			combo_id_tuc_hijo.on('select', onIdReemplazoSelect);
			combo_id_tuc_hijo.on('change', onIdReemplazoSelect);
			
			for(i=0;i<vectorAtributos.length;i++)
				{componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
				}
			sm=getSelectionModel();
		}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_composicion_tuc.getLayout();
		};



		//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
			var tam_elementos=elementos.length;
			for(i=0;i<tam_elementos;i++){
				if(elementos[i].idContenedor==idContenedorHijo){
					return elementos[i];
				}
			}
		};
		this.getElementos=function(){return elementos;};
		this.setPagina=function(elemento){elementos.push(elemento);};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_composicion_tuc.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}