//<script>
function PaginaActivoFijoEmpleado()
{
	var vectorAtributos = new Array;
	var ds;
		
	/******************************************************************/
	var dlgTransfe=false;
	var Formulario1;
	var fecha;

	//a donde va a ser transferido
	var idAfEmp;
	var idEmpOr;//empleado_origen
	var desEmpOr;
	
	//que cosa se va a transferir
	var codAct;//activo
	var desAct;
	
	//de donde se va a transferir
	var idActEmp;//empleado_nuevo
	var desActEmp;
	/******************************************************************/
    //var nombre_completo= no;
	
	//Configuración página
	
		var paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		//FormularioEstructura:true,//indica si se tiene el los 5 combos de la estructura programatica en los formulario para que sean incluidos en las modificaciiones e iliminaciones
		FiltroAvanzado:true,
		grid_html:'ext-grid'
	};
	//  DATA STORE      		//
	// creación del Data Store

	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	?>

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleado.php'}),

		
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_empleado',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'id_activo_fijo_empleado',
		'estado',
		'id_activo_fijo',
		'id_empleado',
		'des_activo_fijo',
		'desc_empleado',
		{name: 'fecha_asig', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: $("maestro_id_activo_fijo").value
		}
	});
	
	/////DATA STORE COMBOS////////////
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','desc_nombrecompleto'])

	});
	
	////////////////FUNCIONES RENDER ////////////
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	
	
	/*para el combo en la transferencia*/
	
	ds_empleado_transferencia = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: '../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','desc_nombrecompleto'])
	});
	function renderEmpleadoTransferencia(value, p, record){return String.format('{0}', record.data['desc_empleado']);}

	

	//////////////////////////////////////////////////////////////
	//        DEFINICIÓN DATOS DEL MAESTRO                     //
	//////////////////////////////////////////////////////////////

	////////// INICIA MAESTRO ///////////////////////
	var dataMaestro = [
	//['ID',$("maestro_id_activo_fijo").value],
	['Código Activo Fijo',$("maestro_codigo").value],
	['Descripcion',$("maestro_descripcion").value],
	['Descripcion Larga',$("maestro_descripcion_larga").value]
	];

		var dsMaestro = new Ext.data.Store({
		proxy: new Ext.data.MemoryProxy(dataMaestro),
		reader: new Ext.data.ArrayReader({id: 0}, [
		{name: 'atributo'},
		{name: 'valor'}

		])
	});
	dsMaestro.load();
	
      var cmMaestro = new Ext.grid.ColumnModel([
			{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
			{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
		]);
		
		function negrita(value){
            return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
        }
        function italic(value){
            return '<i>' + value + '</i>';
        }

        // create the Grid
        var gridMaestro = new Ext.grid.Grid('maestro', {
            ds: dsMaestro,
            cm: cmMaestro
        });
        
        gridMaestro.render();



	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_activo_fijo_empleado//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_activo_fijo_empleado = {
		validacion:{
			labelSeparator:'',
			name: 'id_activo_fijo_empleado',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_activo_fijo_empleado'
	}
	vectorAtributos[0] = paramId_activo_fijo_empleado;

	var paramId_activo_fijo = {
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
		defecto: $("maestro_id_activo_fijo").value
	}
	vectorAtributos[1] = paramId_activo_fijo;
	
	
	/////////// hidden_id_empleado//////

	var paramId_empleado = {
		validacion:{
			fieldLabel: 'Funcionario',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Empleado...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField:'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'apellido_paterno',
			//filterCol:'apellido_paterno',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderEmpleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
	}
	vectorAtributos[2] = paramId_empleado;
	
	
	
	/////////// combo estado//////
	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['activo', 'inactivo', 'eliminado'],
				data : Ext.activo_fijo_empleadoCombo.estado // from states.js
			}),
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
		filterColValue:'afe.estado',
		save_as:'txt_estado',
		defecto: 'activo'
	}
	vectorAtributos[3] = paramEstado;
	
	var paramFecha_asig = {
		validacion:{
			name: 'fecha_asig',
			fieldLabel: 'Fecha de Asignación',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'afe.fecha_asig',
		save_as:'txt_fecha_asig',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[4] = paramFecha_asig;

	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha de registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'afe.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[5] = paramFecha_reg;

 /*****para la transferencia******/
	var combo_Id_empleado = new Ext.form.ComboBox({
		fieldLabel: 'Empleado Destino:',
		displayField: 'desc_nombrecompleto',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'Empleado...',
		selectOnFocus:true,
		renderer: renderEmpleadoTransferencia,
		name: 'id_empleado_destino',
		store: ds_empleado_transferencia,
		queryParam: 'filterValue_0',
		filterCol:'desc_empleado',
		typeAhead: true,
		forceSelection : true,
		queryDelay: 50,
		pageSize: 10,
		minListWidth : 300,
		resizable: true,
		minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
		triggerAction: 'all',
		editable : false,
		renderer: renderEmpleadoTransferencia,
		valueField:'id_empleado',
		save_as:'hidden_id_empleado_destino'
	});
	combo_Id_empleado.on('select', onId_empleadoSelect);
	combo_Id_empleado.on('change', onId_empleadoSelect);

	var param_Hidden_empleado = new Ext.form.Field({
		labelSeparator:'',
		name: 'id_empleado_destino',
		inputType:'hidden',
		grid_visible:false, // se muestra en el grid
		grid_editable:false
	});

	function onId_empleadoSelect()
	{
		param_Hidden_empleado.Value=combo_Id_empleado.getValue();

	}
	
	/*para obtener la informacion del empleado actual**/
	var paramDatos_empleado = {
		validacion:{
			fieldLabel: 'Empleado',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Empleado...',
			name: 'desc_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField:'desc_empleado',
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
			renderer: renderEmpleado,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		
		tipo: 'ComboBox',
		save_as:'datos_id_empleado'
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
		titulo_maestro:"Informacion de Activo Fijo",
		titulo_detalle:"Responsable de Activo Fijo",
		grid_maestro:"maestro",
		grid_detalle:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);
	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnActualizar = this.btnActualizar;

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
function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		h_txt_id_empleado=ClaseMadre_getComponente('id_empleado');//origen
		h_txt_id_empleado_destino=ClaseMadre_getComponente('id_empleado_destino');//destino

	}


	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:"../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado.php"
		},
		Save:{
			url:"../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		ConfirmSave:{
			url:"../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:450,
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
	////////////////////////////////////	

		
	function get_fecha_bd()
	{
		var postData;
		var hcallback =
		{
			success:  cargar_fecha_bd,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};

		YAHOO.util.Connect.asyncRequest('POST', '../../../lib/lib_control/action/ActionObtenerFechaBD.php', hcallback, postData);
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

	this.btnNew = function()
	{
		
		ClaseMadre_btnNew()
		get_fecha_bd()
	}
	
	function ocultar()
	{
		dlgTransfe.hide();
		Ext.form.Field.prototype.msgTarget = 'qtip';

	}
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function transferir()
	{
	
		var codactivo=ClaseMadre_getComponente('id_activo_fijo');//lo que se va a transferir
		var h_txt_id_empleado=ClaseMadre_getComponente('id_empleado');//origen
		var h_txt_datos_empleado=ClaseMadre_getComponente('desc_empleado');
		var h_txt_id_empleado_destino=ClaseMadre_getComponente('id_empleado_destino');//destino
		var h_txt_id_activo_fijo_empleado=ClaseMadre_getComponente('id_activo_fijo_empleado');//destino

		
		var postData = "hidden_id_activo_fijo=" + codactivo.getValue();
		postData = postData + "&hidden_id_empleado=" + h_txt_id_empleado.getValue();
		postData = postData + "&hidden_id_empleado_destino=" + param_Hidden_empleado.Value;
		postData = postData + "&hidden_id_activo_fijo_empleado=" + h_txt_id_activo_fijo_empleado.getValue();

		var hcallback =
		{
			success:  resp_transferencia,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};

		/*-----loading----*/
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Transfiriendo...</div>",
			width:150,
			height:200,
			closable:false
		});


		YAHOO.util.Connect.asyncRequest('POST', '../../control/activo_fijo_empleado/ActionTransfiereActivos.php', hcallback, postData);
	}
	
	
	
	function resp_transferencia()
	{
		Ext.MessageBox.hide();
		//Ext.MessageBox.alert("Transferencia efectuada", "Transferencia realizada con éxito");
		Ext.Msg.show({
			title: 'Transferencia efectuada',
			msg: "Transferencia realizada con éxito",
			minWidth:300,
			buttons: Ext.Msg.OK
		});

		//Hace un refresh de los datos
		ClaseMadre_btnActualizar();
		dlgTransfe.hide();
		Ext.form.Field.prototype.msgTarget = 'qtip';

	}
	//aqui deberia estar los datos del empleado actual
	
	var codA = $("maestro_codigo").value; // aui esta el codigo del activo 
	var desA=$("maestro_descripcion").value; //descripc
	
	//Abre el formulario para la transferencia de componentes
function btnTransferencia()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			if(SelectionsRecord.data.estado=="activo")
			{
		
				var IdE=SelectionsRecord.data.id_empleado;
				var desE=SelectionsRecord.data.desc_empleado;
				var AfE=SelectionsRecord.data.id_activo_fijo_empleado;				
				if(!dlgTransfe)
				{
					Formulario1 = new Ext.form.Form({
						id: 'formulario1',
						//labelAlign: 'top',
						labelWidth: 100, // label settings here cascade unless overridden
						//legend:'Contratista',
						method:'post',
						//waitMsgTarget: 'box-bd', //DEFINE EL TIPO DE LOADING QUE SE VERA AL CARGAR
						url: '../../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado',
						fileUpload: false,
						success: this.saveSuccess ,
						failure: this.conexionFailure
					});

					dlgTransfe = new Ext.BasicDialog("dlgTransfe", {
						modal:true,
						autoTabs:false,
						width:400,
						height:450,
						shadow:false,
						minWidth:200,
						minHeight:300,
						fixedcenter:true,
						constraintoviewport:true,
						draggable:true,
						proxyDrag:true,
						closable:ocultar
						
					});
alert('gggggg');
					dlgTransfe.addKeyListener(27, ocultar);//tecla escape
					dlgTransfe.addButton('Guardar',transferir);
					dlgTransfe.addButton('Cancelar',ocultar);

					
					/*INFORMACION DEL EMPLEADO ACTUAL*/
					idAfEmp=new Ext.form.TextField({
						fieldLabel: 'Id Activo Fijo Empleado',
						name: 'IdE',
						allowBlank:true,
						width:'40%',
						disabled:true
					});

					
					
					
					idEmpOr=new Ext.form.TextField({
						fieldLabel: 'Id Empleado',
						name: 'IdE',
						allowBlank:true,
						width:'40%',
						disabled:true
					});

					desEmpOr=new Ext.form.TextField({
						fieldLabel: 'Descripción',
						name: 'desE',
						allowBlank:true,
						width:'60%',
						disabled:true
					});
					
					
				//*para el activo****
						codAct=new Ext.form.TextField({
						fieldLabel: 'Codigo Activo',
						name: 'codA',
						allowBlank:true,
						width:'40%',
						disabled:true
					});

					desAct=new Ext.form.TextArea({
						fieldLabel: 'Descripción',
						name: 'desA',
						allowBlank:true,
						width:'100%',
						disabled:true
					});

					Formulario1.fieldset({legend:"Datos Empleado Origen"});
					Formulario1.add(idEmpOr,desEmpOr);
					Formulario1.end();
					Formulario1.fieldset({legend:"Datos Activo"});
					Formulario1.add(codAct,desAct);
					Formulario1.end();
					Formulario1.fieldset({legend:"Transferir a:"});
					Formulario1.add(combo_Id_empleado,param_Hidden_empleado);
					Formulario1.end();

					///---------------  declaraciÓn de los parÁmetros y variables del formulario	 --------------//

				}

				idEmpOr.setValue(IdE);
				idAfEmp.setValue(AfE);
				desEmpOr.setValue(desE);
				codAct.setValue(codA);
				desAct.setValue(desA);
			
				//llenarCombo();
				Formulario1.render("form-ct3");//dibuja el formulario
				dlgTransfe.show("container");
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'El estado del componente debe ser Activo.');
			}

		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	
	/**********************************************************/
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Transferencia de Activo Fijo<b>',btnTransferencia,true,'transferir','Transferencia de Activo Fijo');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

}


var obj_pagina;
function main ()
{
	
	obj_pagina = new PaginaActivoFijoEmpleado();
	
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo