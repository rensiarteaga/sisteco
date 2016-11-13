/*** Nombre:		  	    pagina_tipo_adq.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creación:		2010-06-23 11:47:21
*/
function pagina_tipo_activo(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var h_txt_fecha_reg,combo_metodo_depreciacion,combo_flag_depreciacion;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_activo/ActionListaTipoActivo.php'}),


		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_tipo_activo',
		'codigo',
		'descripcion',
		'flag_depreciacion',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado',
		'id_metodo_depreciacion',
		'desc_metodo_depreciacion'
		]),remoteSort:true});

		//STORE COMBOS


		ds_metodo_depreciacion = new Ext.data.Store({
			// asigna url de donde se cargaran los datos

			proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/metodo_depreciacion/ActionListaMetodoDepreciacion.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_metodo_depreciacion',
				totalRecords: 'TotalCount'

			}, ['id_metodo_depreciacion','descripcion'])

		});

		////////////////FUNCIONES RENDER ////////////
		function renderMetodoDepreciacion(value, p, record){return String.format('{0}', record.data['desc_metodo_depreciacion']);}



		//DATA STORE COMBOS

		//FUNCIONES RENDER


		/////////////////////////
		// Definición de datos //
		/////////////////////////


		Atributos[0]= {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_tipo_activo',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_tipo_activo'
		}


		/////////// txt codigo//////
		Atributos[1] = {
			validacion:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: false,
				maxLength:2,
				minLength:2,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:50 // ancho de columna en el gris
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			save_as:'txt_codigo'
		}

		/////////// txt descripcion//////
		Atributos[2] = {
			validacion:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				allowBlank: false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				width: 300,
				grow: true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:260 // ancho de columna en el gris
			},
			tipo: 'TextArea',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'tip.descripcion',
			save_as:'txt_descripcion'
		}


		/////////// combo flag_depreciacion//////

		Atributos[3] =  {
			validacion: {
				name: 'flag_depreciacion',
				fieldLabel: 'Depreciable',
				typeAhead: true,
				loadMask: true,
				allowBlank: false,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['valor', 'flag_depreciacion'],
					data : [['si', 'Si'],['no', 'No']]
				}),
				valueField:'valor',
				displayField:'flag_depreciacion',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:70 // ancho de columna en el grid
			},

			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto: 'si',
			save_as:'txt_flag_depreciacion'

		}


		/////////// combo estado//////

		Atributos[4] = {
			validacion: {
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['activo', 'Activo'],['inactivo','Inactivo']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto: 'activo',
			save_as:'txt_estado'
		}


		/////////// hidden_id_metodo_depreciacion//////

		Atributos[5] = {
			validacion:{
				fieldLabel: 'Método Depreciación',
				allowBlank: true,
				vtype:"texto",
				emptyText:'Método depreciación...',
				name: 'id_metodo_depreciacion',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_metodo_depreciacion', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_metodo_depreciacion,
				valueField: 'id_metodo_depreciacion',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'descripcion',
				typeAhead: true,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true,
				renderer: renderMetodoDepreciacion,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo: 'ComboBox',
			defecto: '1',
			save_as:'hidden_id_metodo_depreciacion'
		}



		/////////// fecha_reg//////
		Atributos[6] = {
			validacion:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha Registro',
				allowBlank: true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				renderer: formatDate,
				width_grid:85, // ancho de columna en el gris
				disabled: true
			},
			tipo: 'DateField',
			filtro_0:true,
			filtro_1:true,
			filtro_2:true,
			save_as:'txt_fecha_reg',
			dateFormat:'m-d-Y', //formato de fecha que envía para guardar
			defecto:"" // valor por default para este campo
		};





		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'TipoActivo',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/sub_tipo_activo/sub_tipo_activo_det.php'};
		var layout_tipo_activo=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_tipo_activo.init(config);
	
		
		
		
		
		
	
		

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_tipo_activo,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
		var ClaseMadre_btnEdit=this.btnEdit;
		var Cm_conexionFailure=this.conexionFailure;
		var ClaseMadre_ocultarComponente=this.ocultarComponente;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_enableSelect=this.EnableSelect;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////




		var paramMenu = {
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear :true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////


		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/tipo_activo/ActionEliminaTipoActivo.php'},
			Save:{url:direccion+'../../../control/tipo_activo/ActionSaveTipoActivo.php'},
			ConfirmSave:{url:direccion+'../../../control/tipo_activo/ActionSaveTipoActivo.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,
			closable:true,titulo:'Tipos Activo',grupos:[
			{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			}]}};
			
			


	/*this.EnableSelect=function(x,z,y){
			 enable(x,z,y);
			    _CP.getPagina(layout_tipo_activo.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_tipo_activo.getIdContentHijo()).pagina.desbloquearMenu();
		    }
		  */  


			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			function get_fecha_bd()
			{

				Ext.Ajax.request({
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					method:'GET',
					success:  cargar_fecha_bd,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_fecha_bd(resp)
			{
				Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
				{
					var root = resp.responseXML.documentElement;
					if(h_txt_fecha_reg.getValue()=="")
					{
						h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					}
				}
			}


			//Abre la ventana de Subtipos de Activos
			function btnSubtipos()
			{
				var sm = getSelectionModel();
				var filas = ds.getModifiedRecords();
				var cont = filas.length;
				var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
				//sm.clearSelections() ;//limpiar las selecciones realizadas

				if(NumSelect != 0)//Verifica si hay filas seleccionadas
				{
					var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					var data = "m_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
					data = data + "&m_codigo=" + SelectionsRecord.data.codigo;
					data = data + "&m_descripcion=" + SelectionsRecord.data.descripcion;
					data = data + "&m_flag_depreciacion=" + SelectionsRecord.data.flag_depreciacion;
					//alert(data);
					
					//Abre la pestaña del detalle
				//	window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFCotizacion_x_Proveedor.php?'+data)
					layout_tipo_activo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/sub_tipo_activo/sub_tipo_activo_det.php?'+data,'Detalle de Solicitud',ParamVentana);
					
				
					//Docs.loadTab('../sub_tipo_activo/sub_tipo_activo_det.php?'+data, "Subtipos de Activos Fijos ["+ SelectionsRecord.data.codigo +"]");
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}


			//Abre la ventana de TipoActivoProceso
			function btnTipoActivoProceso()
			{
				var sm = getSelectionModel();
				var filas = ds.getModifiedRecords();
				var cont = filas.length;
				var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
				//sm.clearSelections() ;//limpiar las selecciones realizadas

				if(NumSelect != 0)//Verifica si hay filas seleccionadas
				{
					var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado

					var data = "maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
					data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
					data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;

					//Abre la pestaña del detalle
					Docs.loadTab('../tipo_activo_proceso/tipo_activo_proceso_det.php?'+data, "Procesos/Cuentas Contables ["+ SelectionsRecord.data.codigo +"]");
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		_CP.getPagina(layout_tipo_activo.getIdContentHijo()).pagina.desbloquearMenu()
		_CP.getPagina(layout_tipo_activo.getIdContentHijo()).pagina.reload(rec.data);
			
	}	
	
	function enable(sm,row,rec){
		CM_enableSelect(sm,row,rec);
	}

		this.btnNew = function()
			{
				ClaseMadre_btnNew();
				get_fecha_bd();

				if (sw==0)
				{
					//Carga el valor por defecto al método de Depreciación Lineal
					var  params = new Array();
					params['id_metodo_depreciacion'] = 1;
					params['descripcion'] = 'Depreciación Lineal';
					var aux = new Ext.data.Record(params,1);
					combo_metodo_depreciacion.store.add(aux)
					combo_metodo_depreciacion.setValue(1);
					sw=1;
				}



			}

			this.SaveAndOther = function()
			{
				alert ("sobrecarga");
				ClaseMadre_SaveAndOther();
				get_fecha_bd();
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				combo_flag_depreciacion = getComponente('flag_depreciacion');
				combo_metodo_depreciacion = getComponente('id_metodo_depreciacion');
				h_txt_fecha_reg = getComponente('fecha_reg');

				//Verifica si se escogió 'No depreciable'
				function opcion_deprec()
				{
					if(combo_flag_depreciacion.getValue() == 'si')
					{
						combo_metodo_depreciacion.allowBlank = false;
						combo_metodo_depreciacion.enable();
					}
					else
					{
						combo_metodo_depreciacion.allowBlank = true;////true
						combo_metodo_depreciacion.disable();
						combo_metodo_depreciacion.setValue('');
					}
				}


				//Define los eventos de los componentes para ejecutar acciones
				combo_flag_depreciacion.on('change',opcion_deprec);
				combo_flag_depreciacion.on('select',opcion_deprec);

			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_tipo_activo.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);


			/*this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnSubtipos,true, 'subtipos','Subtipos de Activos Fijos');
			this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnTipoActivoProceso,true, 'procesos_cuentas', 'Procesos/Cuentas contables');*/


			//SOBRE CARGA DE FUNCIONES


	       function  enable(sel,row,selected){
				var record=selected.data; 			
				CM_enableSelect(sel,row,selected)
			}	


			this.iniciaFormulario();
			iniciarEventosFormularios();

			layout_tipo_activo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);


			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});

}


