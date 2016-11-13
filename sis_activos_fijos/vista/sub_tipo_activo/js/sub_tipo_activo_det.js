/**
* Nombre:		  	    pagina_sub_tipo_activo_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 11:47:22
*/
function pagina_sub_tipo_activo_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var maestro=new Array;
	var h_txt_ini_correlativo,h_txt_correlativo_act,h_txt_codigo,h_txt_fecha_reg,h_txt_vida_util,h_txt_tasa_depreciacion,v_flag_depreciacion;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_sub_tipo_activo',
		'codigo',
		'descripcion',
		'vida_util',
		'tasa_depreciacion',
		'ini_correlativo',
		'correlativo_act',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado',
		'id_tipo_activo',
		'desc_tipo_activo'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_activo:maestro.id_tipo_activo
		}
	});*/
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");



	/*ds_auxiliar = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../control/auxiliar/ActionListaAuxiliarCom.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id',
			totalRecords: 'TotalCount'

		}, ['id','id_auxiliar','descrip','operativo','transac','valido','grupo','desc_auxiliar'])

	});*/

	/*function renderAuxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}

*/

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_sub_tipo_activo_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_sub_tipo_activo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_sub_tipo_activo'
	}

	/////////// txt codigo//////
	Atributos[1] = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:3,
			minLength:3,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sub.codigo',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_codigo'
	}


	/////////// txt descripcion//////
	Atributos[2]  = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:300, // ancho de columna en el gris
			width: 220
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'sub.descripcion',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_descripcion'
	}


	/////////// txt vida_util//////
	Atributos[3] = {
		validacion:{
			name: 'vida_util',
			fieldLabel: 'Vida útil (meses)',
			allowBlank: false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1,
			minText:3,
			len:3,
			validationDelay:3,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:90 // ancho de columna en el gris

		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'vida_util',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_vida_util'
	}


	/////////// txt tasa_depreciacion//////
	Atributos[4] = {
		validacion:{
			name: 'tasa_depreciacion',
			fieldLabel: '% Tasa depreciación (mensual)',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:160, // ancho de columna en el gris
			disabled: true,
			width: 60
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'tasa_depreciacion',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_tasa_depreciacion'
	}

	/////////// txt ini_correlativo//////
	Atributos[5] = {
		validacion:{
			name: 'ini_correlativo',
			fieldLabel: 'Inicio Correlativo',
			allowBlank: false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ini_correlativo',//  XX.descripcion
		filtro_1:true,
		defecto:1,
		save_as:'txt_ini_correlativo'
	}


	/////////// txt correlativo_act//////
	Atributos[6] = {
		validacion:{
			name: 'correlativo_act',
			fieldLabel: 'Correlativo Actual',
			allowBlank: false,
			maxLength:6,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'correlativo_act',//  XX.descripcion
		filtro_1:true,
		defecto:1,
		save_as:'txt_correlativo_act'
	}


	///////////////txt id_tipo_activo///////////
	Atributos[7] = {
		validacion:{
			name: 'id_tipo_activo',
			//fieldLabel: 'Id Tipo Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'txt_id_tipo_activo'
	}


	/////////// combo estado//////
	Atributos[8] = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['activo', 'inactivo', 'eliminado'],
				data : [['activo', 'Activo'],['inactivo','Inactivo']]
			}),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:70 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.estado',
		defecto:'activo',
		save_as:'txt_estado'

	}


	/////////// fecha_reg//////
	Atributos[9] = {
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
			width_grid:85, // ancho de columna en el grid
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto: '' // valor por default para este campo
	};


	/////////// txt_id_auxiliar//////
/*	Atributos[10] = {
		validacion:{
			fieldLabel: 'Auxiliar',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Auxiliar...',
			name: 'id_auxiliar_tmp',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_auxiliar',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id',
			displayField: 'desc_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'id_auxiliar',
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
			renderer: renderAuxiliar,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'txt_id_auxiliar_tmp',
		filterColValue:'descrip'
	}
*/
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'tipo_activo_fijo',grid_maestro:'grid-'+idContenedor};
	var layout_sub_tipo_activo_det=new DocsLayoutMaestro(idContenedor);
	layout_sub_tipo_activo_det.init(config);

	
	

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_sub_tipo_activo_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getDialog=this.getDialog;
	var Cm_getDialog=this.getDialog;
	var CM_enableSelect=this.EnableSelect;
	


	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES

	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/sub_tipo_activo/ActionEliminaSubtipoActivo.php'},
		Save:{url:direccion+'../../../control/sub_tipo_activo/ActionSaveSubtipoActivo.php'},
		ConfirmSave:{url:direccion+'../../../control/sub_tipo_activo/ActionSaveSubtipoActivo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:650,minWidth:150,minHeight:150,	closable:true,titulo:'Tipo de Servicio',
		grupos:[{
			tituloGrupo:'Datos',
			columna:0,
			id_grupo:0
		}]
		}};

		//-------------- Sobrecarga de funciones --------------------//


		this.reload=function(params){
			var datos=params;
			//console.log(datos);
		    maestro.id_tipo_activo=datos.id_tipo_activo;
		    //console.log(maestro);
    		ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_tipo_activo:maestro.id_tipo_activo
					//maestro.id_tipo_adq=datos.m_id_tipo_adq;
				}
			};
			this.btnActualizar();
			
			v_flag_depreciacion=datos.flag_depreciacion;

			Atributos[7].defecto=maestro.id_tipo_activo;

			paramFunciones.btnEliminar.parametros='&m_id_tipo_activo='+maestro.id_tipo_activo;
			paramFunciones.Save.parametros='&m_id_tipo_activo='+maestro.id_tipo_activo;
			paramFunciones.ConfirmSave.parametros='&m_id_tipo_activo='+maestro.id_tipo_activo;

			this.InitFunciones(paramFunciones)



		};


		
		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			h_txt_ini_correlativo = getComponente('ini_correlativo');
			h_txt_correlativo_act = getComponente('correlativo_act');
			h_txt_codigo = getComponente('codigo');
			h_txt_fecha_reg = getComponente('fecha_reg');
			h_txt_vida_util = getComponente('vida_util');
			h_txt_tasa_depreciacion = getComponente('tasa_depreciacion');

			//Copia el mismo valor de ini_correlativo a correlativo_act
			function copiar_ini_correlativo(resp)
			{
				h_txt_correlativo_act.setValue(h_txt_ini_correlativo.getValue());
			}


			//Calcula la tasa de depreciación en función de la vida útil introducida
			function calcular_tasa_dep()
			{
				
				if(h_txt_vida_util.getValue() != undefined && h_txt_vida_util.getValue() != null)
				{
					if(h_txt_vida_util.getValue() != "")
					{
						h_txt_tasa_depreciacion.setValue(redondear(100/h_txt_vida_util.getValue(),2));
					}
					else
					{
						h_txt_tasa_depreciacion.setValue("");
					}
				}
				else
				{
					h_txt_tasa_depreciacion.setValue("");
				}
			}

			//Define los eventos de los componentes para ejecutar acciones
			//h_txt_codigo.on('valid', get_fecha_bd);
			h_txt_ini_correlativo.on('change',copiar_ini_correlativo);
			h_txt_vida_util.on('valid',calcular_tasa_dep);

		}

		
		function subtip_deprec()
		{
			if(v_flag_depreciacion == "no")
			{
				h_txt_vida_util.allowBlank = true;
				h_txt_vida_util.setValue("");
				h_txt_vida_util.disable();
			}
			else
			{
				h_txt_vida_util.allowBlank = false;
				h_txt_vida_util.enable();
			}
		}

		//sobrecarga


		this.btnNew = function()
		{
			CM_btnNew();
			get_fecha_bd();
			subtip_deprec();
		}

		this.btnEdit = function()
		{
			CM_btnEdit();
			subtip_deprec();
		}




		function get_fecha_bd()
		{

			Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
				method:'GET',
				success:  cargar_fecha_bd,
				failure:CM_conexionFailure,
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
					var cadena=new String(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					
					var arreglo=cadena.split('/');
					
					h_txt_fecha_reg.setValue(new Date(parseInt(arreglo[2]),parseInt(arreglo[1])-1,parseInt(arreglo[0])));
					
				}
			}
		}

		function btnCaracteristicas()
		{
			var sm = getSelectionModel();
			var filas = ds.getModifiedRecords();
			var cont = filas.length;
			var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
			//sm.clearSelections() ;//limpiar las selecciones realizadas

			if(NumSelect != 0)//Verifica si hay filas seleccionadas
			{
				var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado

				var data = "maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
				data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
				data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
				data = data + "&maestro_vida_util=" + SelectionsRecord.data.vida_util;
				data = data + "&maestro_id_sub_tipo_activo=" + SelectionsRecord.data.id_sub_tipo_activo;

				var ParamVentana={Ventana:{width:'60%',height:'70%'}}
				layout_sub_tipo_activo_det.loadWindows(direccion+'../../../../sis_activos_fijos/vista/caracteristicas/caracteristicas_det.php?'+data,'Detalle de Solicitud',ParamVentana)
				//Abre la pestaña del detalle
				//Docs.loadTab('../caracteristicas/caracteristicas_det.php?'+data, "Características por SubTipo ["+ SelectionsRecord.data.codigo +"]");
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}




		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_sub_tipo_activo_det.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones

		this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnCaracteristicas,true,'caracteristicas','Características por Subtipo');

		
		     
	
		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_sub_tipo_activo_det.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}