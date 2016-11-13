function PaginaActivoFijoComponentes(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array
	var ds;
	var dlgTransfe=false;
	var Formulario1;
	var fecha;
	var idAcOr;
	var desAcOr
	var desAcOrLa;
	var codCom;
	var desCom;

	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_componentes/ActionListaActivoFijoComponentes.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_componente',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_componente',
		'codigo',
		'descripcion',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado_funcional',
		'estado',
		'id_activo_fijo',
		'desc_activo_fijo'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	


//	ds_activo = new Ext.data.Store({
//		proxy: new Ext.data.HttpProxy({url: '../../control/activo_fijo/ActionListaActivoFijo.php'}),
//		reader: new Ext.data.XmlReader({
//			record: 'ROWS',
//			id: 'id_activo_fijo',
//			totalRecords: 'TotalCount'
//
//		}, ['id_activo_fijo','codigo','descripcion'])//,
//	});
//	function renderActivo(value, p, record){return String.format('{0}', record.data['codigo']);}
//
//
//
//	/*****************************/
//	ds_activo_destino = new Ext.data.Store({
//		proxy: new Ext.data.HttpProxy({url: '../../control/activo_fijo/ActionListaActivoFijo.php?maestro_id_tipo_activo='+maestro.id_tipo_activo}),
//		reader: new Ext.data.XmlReader({
//			record: 'ROWS',
//			id: 'id_activo_fijo',
//			totalRecords: 'TotalCount'
//
//		}, ['id_activo_fijo','codigo','descripcion'])//,
//	});
//	function renderActivoDestino(value, p, record){return String.format('{0}', record.data['codigo']);}

	/******************************/

	//////////////////////////////////////////////////////////////
	//        DEFINICIÓN DATOS DEL MAESTRO                     //
	//////////////////////////////////////////////////////////////

	////////// INICIA MAESTRO ///////////////////////
//	var dataMaestro = [
//	//['ID',maestro.id_activo_fijo],
//	['Código Activo Fijo',maestro.codigo],
//	['Descripción',maestro.descripcion],
//	['Descripción larga',maestro.descripcion_larga]
//	];
//
//	var dsMaestro = new Ext.data.Store({
//		proxy: new Ext.data.MemoryProxy(dataMaestro),
//		reader: new Ext.data.ArrayReader({id: 0}, [
//		{name: 'atributo'},
//		{name: 'valor'}
//
//		])
//	});
//	dsMaestro.load();
//
//	var cmMaestro = new Ext.grid.ColumnModel([
//	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
//	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
//	]);
//
//	function negrita(value){
//		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
//	}
//	function italic(value){
//		return '<i>' + value + '</i>';
//	}
//
//	// create the Grid
//	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
//	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
//		ds:dsMaestro,
//		cm:cmMaestro
//	});
//	gridMaestro.render();

	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_sub_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria

	Atributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_componente',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_componente'
	};

	/////////// txt codigo//////

	Atributos[1] = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'comp.codigo',
		filtro_1:true,
		save_as:'txt_codigo',
		id_grupo: 0
	};

	/////////// txt descripcion//////
	Atributos[2] = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			width: 250
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'comp.descripcion',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_descripcion'
	};


	/////////// combo estado_funcional//////
	Atributos[3]= {
		validacion: {
			name: 'estado_funcional',
			fieldLabel: 'Estado funcional',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID', 'nombre'],data : Ext.activo_fijo_componentesCombo.estado_funcional }),
			store: new Ext.data.SimpleStore({fields: ['ID', 'nombre'],data : [
			                                                                  ['bueno', 'Bueno'],
			                                                                  ['regular', 'Regular'],
			                                                                  ['malo', 'Malo']
			                                                              ] }),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'comp.estado_funcional',
		save_as:'txt_estado_funcional'

	};

	/////////// combo estado//////
	Atributos[4]= {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['activo', 'inactivo', 'eliminado'],data : Ext.activo_fijo_componentesCombo.estado }),
			store: new Ext.data.SimpleStore({fields: ['activo', 'inactivo', 'eliminado'],data : [
			                                                                                     ['activo', 'Activo'],
			                                                                                     ['inactivo', 'Inactivo']
			                                                                                 ] }),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'comp.estado',
		save_as:'txt_estado'

	};


	///////////////txt id_activo///////////
	Atributos[5]= {
		validacion:{
			name: 'id_activo_fijo',
			//fieldLabel: 'Id Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo',
		defecto: maestro.id_activo_fijo
	};



//
//	var combo_Id_activo = new Ext.form.ComboBox({
//		fieldLabel: 'Activo Destino:',
//		displayField: 'codigo',
//		typeAhead: true,
//		mode: 'remote',
//		triggerAction: 'all',
//		emptyText:'Activo...',
//		selectOnFocus:true,
//		renderer: renderActivoDestino,
//		name: 'id_activo_fijo_destino',
//		store: ds_activo_destino,
//		queryParam: 'filterValue_0',
//		filterCol:'codigo',
//		typeAhead: true,
//		forceSelection : true,
//		queryDelay: 50,
//		pageSize: 10,
//		minListWidth : 300,
//		resizable: true,
//		minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
//		triggerAction: 'all',
//		editable : false,
//		renderer: renderActivoDestino,
//		valueField:'id_activo_fijo',
//		save_as:'hidden_id_activo_fijo_destino',
//
//	});
//	combo_Id_activo.on('select', onId_activoSelect);
//	combo_Id_activo.on('change', onId_activoSelect);
//
//	var param_Hidden_activo = new Ext.form.Field({
//		labelSeparator:'',
//		name: 'id_activo_destino',
//		inputType:'hidden',
//		grid_visible:false, // se muestra en el grid
//		grid_editable:false
//	});
//
//	function onId_activoSelect()
//	{
//		param_Hidden_activo.Value=combo_Id_activo.getValue();
//
//	}

	Atributos[6]= {
		validacion:{
			name: 'id_sub_tipo_activo',
			//fieldLabel: 'Id Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'id_sub_tipo_activo',
		defecto: maestro.id_sub_tipo_activo
	};


	/////////// fecha_reg//////
	Atributos[7] = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDays: [0, 6],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el grid
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'comp.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Activo Fijo Maestro",
		titulo_detalle:"Componentes del Activo Fijo"
	};
	
	var config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_comp_caract/activo_fijo_comp_caract_det.php'};

	layout_activo_fijo_comp =new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout_activo_fijo_comp.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_activo_fijo_comp,idContenedor);

	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var enableSelect=this.EnableSelect;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},

		actualizar:{
			crear :true,
			separador:false
		}

	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////





	//datos necesarios para ell filtro
	//parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/activo_fijo_componentes/ActionEliminaActivoFijoComponentes.php',parametros:'&maestro_id_activo_fijo='+maestro.id_activo_fijo},
		Save:{url:direccion+'../../../control/activo_fijo_componentes/ActionSaveActivoFijoComponentes.php',parametros:'&maestro_id_activo_fijo='+maestro.id_activo_fijo},
		ConfirmSave:{url:direccion+'../../../control/activo_fijo_componentes/ActionSaveActivoFijoComponentes.php',parametros:'&maestro_id_activo_fijo='+maestro.id_activo_fijo
		},
		Formulario:{
			width:430,
			height:250,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[400],
			grupos:[
			{
				tituloGrupo:'Datos generales',
				columna:0,
				id_grupo:0
			}
			]
		}
	}

	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		h_txt_id_componente=ClaseMadre_getComponente('id_componente');
		h_txt_id_activo_fijo=ClaseMadre_getComponente('id_activo_fijo');
		h_txt_id_activo_fijo_destino=ClaseMadre_getComponente('id_activo_fijo_destino');
		h_txt_id_sub_tipo_activo = ClaseMadre_getComponente('id_sub_tipo_activo');

	}

	function get_fecha_bd()
	{
		Ext.Ajax.request({url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
		method:'GET',
		success:cargar_fecha_bd,
		failure:ClaseMadre_conexionFailure,
		timeout:100000});
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}


	//sobrecarga


	this.btnNew = function()
	{

		ClaseMadre_btnNew()
		get_fecha_bd()
	}



//	function ocultar()
//	{
//		dlgTransfe.hide();
//		Ext.form.Field.prototype.msgTarget = 'qtip';
//
//	}

	//Transferencia de componentes
//	function transferir()
//	{
//		var codcom=ClaseMadre_getComponente('id_componente');
//		var h_txt_id_activo_fijo=ClaseMadre_getComponente('id_activo_fijo');
//		var h_txt_id_activo_fijo_destino=ClaseMadre_getComponente('id_activo_fijo_destino');
//		var postData = "hidden_id_componente=" + codcom.getValue();
//		
//		postData = postData + "&hidden_id_activo_fijo=" + idActivor;
//		postData = postData + "&hidden_id_activo_fijo_destino=" + param_Hidden_activo.Value;
//
//		/*-----loading----*/
//		Ext.MessageBox.show({
//			title: 'Espere Por Favor...',
//			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Transfiriendo...</div>",
//			width:150,
//			height:200,
//			closable:false
//		});
//
//		Ext.Ajax.request({url:'../../control/activo_fijo_componentes/ActionTransfiereComponentes.php',
//		method:'POST',
//		success:resp_transferencia,
//		failure:ClaseMadre_conexionFailure,
//		timeout:100000});
//	}
//
//
//	function resp_transferencia()
//	{
//		Ext.MessageBox.hide();
//		//Ext.MessageBox.alert("Transferencia efectuada", "Transferencia realizada con éxito");
//		Ext.Msg.show({
//			title: 'Transferencia efectuada',
//			msg: "Transferencia realizada con éxito",
//			minWidth:300,
//			buttons: Ext.Msg.OK
//		});
//
//		//Hace un refresh de los datos
//		ClaseMadre_btnActualizar();
//		dlgTransfe.hide();
//		Ext.form.Field.prototype.msgTarget = 'qtip';
//
//	}
//
//	var idActivor=maestro.id_activo_fijo;
//	var desActivor=maestro.descripcion;
//	var desActivorLar=maestro.descripcion_larga;
//	var idTipo=maestro.id_tipo_activo;


	//Abre la ventana de Características de Componentes
//	function btnCaracteristicasComp()
//	{
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//
//		if(NumSelect != 0)//Verifica si hay filas seleccionadas
//		{
//			var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado
//
//			var data = "maestro_id_componente=" + SelectionsRecord.data.id_componente;
//			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
//			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
//			data = data + "&maestro_estado_funcional=" + SelectionsRecord.data.estado_funcional;
//			data = data + "&maestro_id_tipo_activo=" + maestro.id_tipo_activo;
//
//			//Abre la pestaña del detalle
//			Docs.loadTab('../activo_fijo_comp_caract/activo_fijo_comp_caract_det.php?'+data, "Características [" + SelectionsRecord.data.codigo + "]");
//		}
//		else
//		{
//			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
//		}
//	}


	//Abre el formulario para la transferencia de componentes
//	function btnTransferencia()
//	{
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		//sm.clearSelections() ;//limpiar las selecciones realizadas
//
//		if(NumSelect != 0)//Verifica si hay filas seleccionadas
//		{
//			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
//			if(SelectionsRecord.data.estado=="activo")
//			{
//				//var idComponente=SelectionsRecord.data.id_componente;
//				var idCompo=SelectionsRecord.data.id_componente;
//				var codCompo=SelectionsRecord.data.codigo;
//				var desCompo=SelectionsRecord.data.descripcion;
//				//alert(idActivor+" "+desActivor+" "+idComponente);
//
//
//
//				if(!dlgTransfe)
//				{
//					Formulario1 = new Ext.form.Form({
//						id: 'formulario1',
//						//labelAlign: 'top',
//						labelWidth: 100, // label settings here cascade unless overridden
//						//legend:'Contratista',
//						method:'post',
//						//waitMsgTarget: 'box-bd', //DEFINE EL TIPO DE LOADING QUE SE VERA AL CARGAR
//						url: '../../../control/activo_fijo_componentes/ActionEliminaActivoFijoComponentes',
//						fileUpload: false,
//						success: this.saveSuccess ,
//						failure: this.conexionFailure
//					});
//
//					dlgTransfe = new Ext.BasicDialog("dlgTransfe", {
//						modal:true,
//						autoTabs:false,
//						width:400,
//						height:450,
//						shadow:false,
//						minWidth:200,
//						minHeight:300,
//						fixedcenter:true,
//						constraintoviewport:true,
//						draggable:true,
//						proxyDrag:true,
//						closable:ocultar
//					});
//
//					dlgTransfe.addKeyListener(27, ocultar);//tecla escape
//					dlgTransfe.addButton('Guardar',transferir);
//					dlgTransfe.addButton('Cancelar',ocultar);
//
//					idAcOr=new Ext.form.TextField({
//						fieldLabel: 'ID Activo',
//						name: 'idActivor',
//						allowBlank:true,
//						width:'40%',
//						disabled:true
//					});
//
//					desAcOr=new Ext.form.TextField({
//						fieldLabel: 'Descripción',
//						name: 'desActivor',
//						allowBlank:true,
//						width:'60%',
//						disabled:true
//					});
//
//					desAcOrLa=new Ext.form.TextArea({
//						fieldLabel: 'Descripción Larga',
//						name: 'desActivorLar',
//						allowBlank:true,
//						width:'100%',
//						disabled:true
//					});
//
//					codCom=new Ext.form.TextField({
//						fieldLabel: 'Codigo Componente',
//						name: 'codCompo',
//						allowBlank:true,
//						width:'40%',
//						disabled:true
//					});
//
//					desCom=new Ext.form.TextArea({
//						fieldLabel: 'Descripción',
//						name: 'desCompo',
//						allowBlank:true,
//						width:'100%',
//						disabled:true
//					});
//
//					Formulario1.fieldset({legend:"Datos Activo Origen"});
//					Formulario1.add(idAcOr,desAcOr,desAcOrLa);
//					Formulario1.end();
//					Formulario1.fieldset({legend:"Datos Componente"});
//					Formulario1.add(codCom,desCom);
//					Formulario1.end();
//					Formulario1.fieldset({legend:"Transferir a:"});
//					Formulario1.add(combo_Id_activo,param_Hidden_activo);
//					Formulario1.end();
//
//					///---------------  declaraciÓn de los parÁmetros y variables del formulario	 --------------//
//
//				}
//
//				idAcOr.setValue(idActivor);
//				desAcOr.setValue(desActivor);
//				//alert(desActivor);
//				desAcOrLa.setValue(desActivorLar);
//				codCom.setValue(codCompo);
//				desCom.setValue(desCompo);
//				//llenarCombo();
//				Formulario1.render("form-ct3");//dibuja el formulario
//				dlgTransfe.show("container");
//			}
//			else
//			{
//				Ext.MessageBox.alert('Estado', 'El estado del componente debe ser Activo.');
//			}
//
//		}
//		else
//		{
//			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
//		}
//	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
				maestro.codigo=datos.maestro_codigo;
				//maestro.num_proceso=datos.m_num_proceso;
				maestro.descripcion=datos.maestro_descripcion;
				
				maestro.descripcion_larga=datos.maestro_descripcion_larga;
				
				
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						maestro_id_activo_fijo:maestro.id_activo_fijo
						
					}
				};
				
				_CP.getPagina(layout_activo_fijo_comp.getIdContentHijo()).pagina.limpiarStore();
				
				this.btnActualizar();
				iniciarEventosFormularios();

				//gridMaestro.getDataSource().removeAll();

				//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
				Atributos[5].defecto=maestro.id_activo_fijo;
				paramFunciones.btnEliminar.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
				paramFunciones.Save.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
				paramFunciones.ConfirmSave.parametros='&maestro_id_activo_fijo='+maestro.id_activo_fijo;
				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones);
			};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.EnableSelect=function(sm,row,rec){
				_CP.getPagina(layout_activo_fijo_comp.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_activo_fijo_comp.getIdContentHijo()).pagina.desbloquearMenu();
				enableSelect(sm,row,rec);
			}

	this.getLayout=function(){return layout_activo_fijo_comp.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Características de Componente<b>',btnCaracteristicasComp,true,'caracteristicas_comp','Características de Componente');
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Transferencia de Componente<b>',btnTransferencia,true,'transferir','Transferencia de Componente');
	this.iniciaFormulario();
	ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_activo_fijo:maestro.id_activo_fijo
				}
			});
	iniciarEventosFormularios();

	layout_activo_fijo_comp.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}