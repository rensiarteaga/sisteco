/**
* Nombre:		  	    pagina_tarea_pendiente_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-30 12:00:35
*/
function pagina_tarea_pendiente(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tarea_pendiente/ActionListarTarea.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tarea_pendiente',
			totalRecords: 'TotalCount'

		}, [// define el mapeo de XML a las etiquetas (campos)
			'id_tarea_pendiente',
			'id_usuario',
			'desc_usuario',
			'id_subsistema',
			'desc_subsistema',
			'tarea',
			'descripcion',
			'codigo_procedimiento',
			'estado',
			'tipo',
			{name: 'fecha_concluido_anulado',type:'date',dateFormat:'Y-m-d'},
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
	
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

		ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario/ActionListarUsuario.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario',
			totalRecords: 'TotalCount'
		}, ['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado'])
		});

		ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, ['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones'])
		});

		//FUNCIONES RENDER

		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		vectorAtributos[0]= {
			validacion:{
				labelSeparator:'',
				name: 'id_tarea_pendiente',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_tarea_pendiente'
		};

		// txt id_usuario
		vectorAtributos[1]= {
			validacion: {
				name:'id_usuario',
				fieldLabel:'ID Usuario',
				allowBlank:false,
				emptyText:'ID Usuario...',
				desc: 'login', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_usuario,
				valueField: 'id_usuario',
				displayField: 'login',
				queryParam: 'filterValue_0',
				filterCol:'USUARI.id_persona#USUARI.apellido_paterno#USUARI.apellido_materno#USUARI.nombre',
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:450,
				grow:true,
				width:'100%',
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_usuario,
				grid_visible:true,
				grid_editable:true,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'USUARI.id_persona',
			defecto: '',
			save_as:'txt_id_usuario'
		};
		
		// txt id_subsistema
		vectorAtributos[2]= {
			validacion: {
				name:'id_subsistema',
				fieldLabel:'ID SubSistema',
				allowBlank:false,
				emptyText:'ID SubSistema...',
				desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_subsistema,
				valueField: 'id_subsistema',
				displayField: 'nombre_corto',
				queryParam: 'filterValue_0',
				filterCol:'SUBSIS.nombre_corto#SUBSIS.descripcion',
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:450,
				grow:true,
				width:'100%',
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_subsistema,
				grid_visible:true,
				grid_editable:true,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'SUBSIS.nombre_corto',
			defecto: '',
			save_as:'txt_id_subsistema'
		};
		
		// txt tarea
		vectorAtributos[3]= {
			validacion:{
				name:'tarea',
				fieldLabel:'Tarea',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo:'TextArea',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TARPEN.tarea',			
			save_as:'txt_tarea'
		};
		
		// txt descripcion
		vectorAtributos[4]= {
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'TextArea',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TARPEN.descripcion',
			save_as:'txt_descripcion'
		};
		
		// txt enlace
		vectorAtributos[5]= {
			validacion:{
				name:'codigo_procedimiento',
				fieldLabel:'Codigo procedimiento',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo: 'TextArea',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TARPEN.codigo_procedimiento',
			save_as:'txt_codigo_procedimiento'
		};
		
		// txt estado
		vectorAtributos[6]= {
			validacion: {
				name:'estado',
				fieldLabel:'Estado de la Tarea',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : Ext.tarea_pendiente_combo.estado
				}),
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
			filterColValue:'TARPEN.estado',
			defecto:'Pendiente',
			save_as:'txt_estado'
		};
		
		// txt fecha_concluido_anulado
		vectorAtributos[7]= {
			validacion:{
				name:'fecha_concluido_anulado',
				fieldLabel:'Fecha Concluida/Anulada',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TARPEN.fecha_concluido_anulado',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_concluido_anulado'
		};
		
		// txt fecha_reg
		vectorAtributos[8] = {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'TARPEN.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
		vectorAtributos[9]= {
			validacion: {
				name:'tipo',
				fieldLabel:'Tipo de Evento',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : Ext.tipo_combo.tipo
				}),
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
			filterColValue:'TARPEN.tipo',
			defecto:'Tarea',
			save_as:'txt_tipo'
		};
		

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : ''
		};

		//////////////////////////////////////////////////////////////
		//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		//////////////////////////////////////////////////////////////
		//Inicia Layout
		var config = {
			titulo_maestro:'tarea_pendiente',
			grid_maestro:'grid-'+idContenedor
		};
		layout_tarea_pendiente=new DocsLayoutMaestro(idContenedor);
		layout_tarea_pendiente.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		/// HEREDAMOS DE LA CLASE MADRE
		this.pagina = Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,vectorAtributos,ds,layout_tarea_pendiente,idContenedor);
		//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;

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
		var paramFunciones = {
			btnEliminar:{url:direccion+'../../../control/tarea_pendiente/ActionEliminarTareaPendiente.php'},
			Save:{url:direccion+'../../../control/tarea_pendiente/ActionGuardarTareaPendiente.php'},
			ConfirmSave:{url:direccion+'../../../control/tarea_pendiente/ActionGuardarTareaPendiente.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
			width:480,
			minWidth:150,minHeight:200,	closable:true,titulo:'tarea_pendiente'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_tarea_pendiente.getLayout()};
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

			//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.iniciaFormulario();
			layout_tarea_pendiente.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}