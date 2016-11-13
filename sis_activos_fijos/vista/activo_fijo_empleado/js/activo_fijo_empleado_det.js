/**
* Nombre:		  	    pagina_devengado_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:43:29
*/
function PaginaActivoFijoEmpleado(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleado.php'}),
		
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
		'des_activo_fijo',
		'id_empleado',
		'desc_empleado',
		'id_deposito',
		'nombre_deposito',
		{name: 'fecha_asig', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Código',maestro.codigo],['Descripción',maestro.descripcion],['Descripción Larga',maestro.descripcion_larga]];

	//DATA STORE COMBOS

	/////DATA STORE COMBOS////////////
	
	//FUNCIONES RENDER
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function render_deposito(value, p, record){return String.format('{0}', record.data['nombre_deposito']);}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	//en la posición 0 siempre esta la llave primaria

		// id_activo_fijo_empleado
		Atributos[0]={
				validacion:{
				labelSeparator:'',
				name: 'id_activo_fijo_empleado',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo: 'Field',
			save_as:'hidden_id_activo_fijo_empleado',
			filtro_0:false
		};
		
		// id_activo_fijo
		Atributos[1]={
				validacion:{
				name: 'id_activo_fijo',
				inputType:"hidden",
				labelSeparator:'',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_activo_fijo',
			defecto:maestro.id_activo_fijo
		};	
			
		// desc_empleado
		Atributos[2] = {
			validacion:{
				fieldLabel: 'Funcionario',
				name: 'desc_empleado',
				width_grid:250,
				grid_visible:true, // se muestra en el grid
				grid_editable:false
	
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'vkp.apellido_paterno'
		};
		
		// nombre_deposito
		Atributos[3] = {
			validacion:{
				fieldLabel: 'Depósito',
				name: 'nombre_deposito',
				width_grid:180,
				grid_visible:true, // se muestra en el grid
				grid_editable:false
	
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'dep.nombre_deposito'
		};
		
		// estado
		Atributos[4] = {
			validacion:{
				fieldLabel: 'Estado',
				name: 'estado',
				width_grid:80,
				grid_visible:true, // se muestra en el grid
				grid_editable:false
	
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'afe.estado'
		};
	
		// fecha_asig
		Atributos[5] = {
			validacion:{
				name: 'fecha_asig',
				fieldLabel: 'Fecha de Asignación',
				grid_visible:true, // se muestra en el grid
				renderer: formatDate,
				width_grid:100
			},
			tipo: 'DateField',
			form:false,
			filtro_0:true,
			filterColValue:'afe.fecha_asig'
		};
		
	
		// fecha_reg
		Atributos[6]={
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
		

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Informacion de Activo Fijo',titulo_detalle:'Responsable de Activo Fijo',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout.init(config);


	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_conexionFailure=this.conexionFailure;


	//DEFINICIÓN DE LA BARRA DE MENÚ
	
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
		
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado.php"
		},
		Save:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
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
			}]
		}};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));

		maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
		maestro.codigo=datos.maestro_codigo;
		maestro.descripcion=datos.maestro_descripcion;
		maestro.descripcion_larga=datos.maestro_descripcion_larga;
		

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_activo_fijo: maestro.id_activo_fijo
			}
		};
		this.btnActualizar();
		data_maestro=[['Código',maestro.codigo],['Descripción',maestro.descripcion],['Descripción Larga',maestro.descripcion_larga]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_activo_fijo;
		
		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');		
	}
	
	function get_fecha_bd()
	{
				
		Ext.Ajax.request({
					url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
					method:'POST',
					success:cargar_fecha_bd,
					failure:ClaseMadre_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
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
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: maestro.id_activo_fijo
		}
	});


	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	layout.getVentana(idContenedor).on('resize',function(){layout.getLayout().layout()})

}