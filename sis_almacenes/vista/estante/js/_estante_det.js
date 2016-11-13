/**
* Nombre:		  	    pagina_estante_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-11 15:23:31
*/
function pagina_estante_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,txt_estado_registro,txt_fecha_reg,txt_filas,txt_columnas;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estante/ActionListarEstante_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_estante',totalRecords: 'TotalCount'},
		['id_estante',
		'codigo',
		'descripcion',
		'nivel_max',
		'via_fil',
		'via_col',
		'estado_registro',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_almacen_sector',
		'id_almacen_sector'
		]),remoteSort:true});
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_sector:maestro.id_almacen_sector
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO
		var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
		function italic(value){return '<i>'+value+'</i>'}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Sector por Almacenes',maestro.id_almacen_sector],['Superficie',maestro.superficie],['Altura',maestro.altura]]}),cm:cmMaestro});
		gridMaestro.render();
		//en la posición 0 siempre esta la llave primaria
		vectorAtributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_estante',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_estante'
		};
		// txt codigo
		vectorAtributos[1]={
			validacion:{
				name:'codigo',
				fieldLabel:'Codigo',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'ESTANT.codigo',
			save_as:'txt_codigo'
		};
		vectorAtributos[2]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'TextField',
			filtro_0:false,
			filterColValue:'ESTANT.descripcion',
			save_as:'txt_descripcion'
		};
		// txt nivel_max
		vectorAtributos[3]={
			validacion:{
				name:'nivel_max',
				fieldLabel:'Nivel Maximo',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'ESTANT.nivel_max',
			save_as:'txt_nivel_max'
		};
		// txt via_fil
		vectorAtributos[4]={
			validacion:{
				name:'via_fil',
				fieldLabel:'Via-Fila (Cercana)',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				maxValue:maestro.via_fil_max,
				minValue:1,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:110
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'ESTANT.via_fil',
			save_as:'txt_via_fil'
		};
		// txt via_col
		vectorAtributos[5]={
			validacion:{
				name:'via_col',
				fieldLabel:'Via-Columna (Cercana)',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision :2,//para numeros float
				allowNegative: false,
				maxValue:maestro.via_col_max,
				minValue:1,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:130
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'ESTANT.via_col',
			save_as:'txt_via_col'
		};
		// txt estado_registro
		vectorAtributos[6]={
			validacion:{
				name:'estado_registro',
				fieldLabel:'Estado de Registro',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : Ext.estante_combo.estado_registro
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:false,
				width_grid:110 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:false,
			filterColValue:'ESTANT.estado_registro',
			defecto:'activo',
			save_as:'txt_estado_registro'
		};
		// txt id_almacen_sector
		vectorAtributos[7]={
			validacion:{
				name:'id_almacen_sector',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_almacen_sector,
			save_as:'txt_id_almacen_sector'
		};
		// txt fecha_reg
		vectorAtributos[8]={
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
				width_grid:110,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'ESTANT.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
		//----------- FUNCIONES RENDER
		function formatDate(value){
			return value?value.dateFormat('d/m/Y'):'';
		};
		//---------- INICIAMOS LAYOUT DETALLE
		var config={
			titulo_maestro:'Sectores del Almacen (Maestro)',
			titulo_detalle:'Estantería (Detalle)',
			grid_maestro:'grid-'+idContenedor
		};
		layout_estante=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_estante.init(config);
		//---------- INICIAMOS HERENCIA
		this.pagina=Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_estante,idContenedor);
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_save=this.Save;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_ocultarTodosComponente=this.ocultarTodosComponente;
		var CM_mostrarTodosComponente=this.mostrarTodosComponente;
		var ClaseMadre_btnEdit=this.btnEdit;
		var ClaseMadre_btnEliminar=this.btnEliminar;
		var ClaseMadre_btnActualizar=this.btnActualizar;
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
		parametrosFiltro='&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/estante/ActionEliminarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
			Save:{url:direccion+'../../../control/estante/ActionGuardarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
			ConfirmSave:{url:direccion+'../../../control/estante/ActionGuardarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'Estantes del Sector'}
		};
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_almacen_sector=datos.m_id_almacen_sector;
			maestro.superficie=datos.m_superficie;
			maestro.altura=datos.m_altura;
			maestro.via_fil_max=datos.vfm;
			maestro.via_col_max=datos.vcm;
			gridMaestro.getDataSource().removeAll();
			gridMaestro.getDataSource().loadData([['Id Sector por Almacenes',maestro.id_almacen_sector],['Superficie',maestro.superficie],['Altura',maestro.altura]]);
			vectorAtributos[7].defecto=maestro.id_almacen_sector;
			paramFunciones={
				btnEliminar:{url:direccion+'../../../control/estante/ActionEliminarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
				Save:{url:direccion+'../../../control/estante/ActionGuardarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
				ConfirmSave:{url:direccion+'../../../control/estante/ActionGuardarEstante.php',parametros:'&m_id_almacen_sector='+maestro.id_almacen_sector},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'Estantes del Sector'}
			};
			this.InitFunciones(paramFunciones);
			txt_filas.maxValue=datos.vfm;
			txt_columnas.maxValue=datos.vcm;
			ds.lastOptions={params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_sector:maestro.id_almacen_sector
			}};
			this.btnActualizar()
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function btn_item_ubicacion(){
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_estante='+SelectionsRecord.data.id_estante;
				data=data+'&m_codigo='+SelectionsRecord.data.codigo;
				data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
				data=data+'&m_nivel_max='+SelectionsRecord.data.nivel_max;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}};
				layout_estante.loadWindows(direccion+'../../item_ubicacion/item_ubicacion_det.php?'+data,'Ubicación de Items',ParamVentana);
				layout_estante.getVentana().on('resize',function(){layout_estante.getLayout().layout()})
			}
			else{Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
			}
		}
		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			txt_filas = ClaseMadre_getComponente('via_fil');
			txt_columnas = ClaseMadre_getComponente('via_col');
			txt_estado_registro = ClaseMadre_getComponente('estado_registro');
			txt_fecha_reg = ClaseMadre_getComponente('fecha_reg')
		}
		this.btnNew=function(){
			CM_ocultarComponente(txt_estado_registro);
			CM_ocultarComponente(txt_fecha_reg);
			ClaseMadre_btnNew()
		};
		this.btnEdit=function(){
			CM_ocultarComponente(txt_estado_registro);
			CM_ocultarComponente(txt_fecha_reg);
			ClaseMadre_btnEdit()
		};

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_estante.getLayout()
		};
		//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
			var tam_elementos=elementos.length;
			for(i=0;i<tam_elementos;i++){
				if(elementos[i].idContenedor==idContenedorHijo){
					return elementos[i]
				}
			}
		};
		this.getElementos=function(){return elementos};
		this.setPagina=function(elemento){elementos.push(elemento)};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.AdicionarBoton('../../../lib/imagenes/report.png','Ubicación de Items',btn_item_ubicacion,true,'item_ubicacion','');
		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_estante.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}