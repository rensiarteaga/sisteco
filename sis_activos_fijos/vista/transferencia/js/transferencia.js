/**
 * Nombre:		  	    pagina_transferencia.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:09
 */
function pagina_transferencia(idContenedor,direccion,paramConfig,vista) 
//tipo se refiere a si es registro para el comprometido o para rendición. valores: 'comp','rendic'
//vista=> 'viatico','fa','efectivo'
{
	var maestro;
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var cm;
	var grid;
	var v_id_activo_fijo_empleado,cmb_id_activo_fijo,txt_fecha_reg,
		txt_desc_activo_fijo,txt_desc_activo_fijo,txt_descripcion_larga,
		txt_id_empleado_anterior,txt_estado;
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

		},[
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'id_activo_fijo_empleado',
		'estado',
		'id_activo_fijo',
		'id_empleado',
		'desc_activo_fijo',
		'desc_empleado',
		{name: 'fecha_asig', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'descripcion_larga',
		'codigo',
		'id_empleado_anterior',
		'desc_empleado_anterior'
		]),remoteSort:true});

	
	/////DATA STORE COMBOS////////////
	ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_empleado',totalRecords: 'TotalCount'}, ['id_empleado','desc_nombrecompleto'])});
	ds_activo_fijo_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy
	({url: direccion+'../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleadoActivos.php'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_activo_fijo_empleado',totalRecords: 'TotalCount'}, 
	['id_activo_fijo_empleado','estado','id_activo_fijo','id_empleado','desc_activo_fijo','desc_empleado','fecha_asig','descripcion_larga','codigo','id_empleado_anterior','desc_empleado_anterior'])});

	var resultTplActivo=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642"><b>Descripción: </b>{descripcion_larga}</FONT>','<br><FONT COLOR="#B5A642"><b>Responsable: </b>{desc_empleado}</FONT>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado}</FONT>','</div>');

	////////////////FUNCIONES RENDER ////////////
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function renderActivoFijoEmpleado(value, p, record){return String.format('{0}', record.data['codigo']);}
	function renderEmpleadoAnt(value, p, record){return String.format('{0}', record.data['desc_empleado_anterior']);}
	function renderDescActivoFijo(value, p, record){return String.format('{0}', record.data['desc_activo_fijo']);}
	function renderDescripcionLarga(value, p, record){return String.format('{0}', record.data['descripcion_larga']);}


	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
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
	};
// txt id_cuenta_doc
	Atributos[1]={
		validacion:{
			fieldLabel: 'Codigo de Activo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Codigo...',
			name: 'id_activo_fijo',
			desc: 'desc_tipo_activo',
			store: ds_activo_fijo_empleado,
			valueField:'id_activo_fijo_empleado',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'af.codigo',
			typeAhead: true,
			forceSelection: true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderActivoFijoEmpleado,
			tpl:resultTplActivo,
			triggerAction: 'all',
			typeAhead: true,
			selectOnFocus:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100
		},
		id_grupo: 0,
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'af.codigo',
		save_as:'hidden_id_activo_fijo'
	};
	
	// txt id_parametro
	Atributos[2]={
			validacion: {
			name:'desc_activo_fijo',
			fieldLabel:'Denominación',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderDescActivoFijo,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		tipo:'Field',
		filtro_0:true,
		//filterColValue:'desc_activo_fijo'
		filterColValue:'af.descripcion'	
	};
	
	Atributos[3]={
			validacion: {
			name:'descripcion_larga',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderDescripcionLarga,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'af.descripcion_larga'
	};
	
	
	// txt id_concepto_ingas
	Atributos[4]={
			validacion: {
			name:'id_empleado_anterior',
			fieldLabel:'Funcionario Origen',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderEmpleadoAnt,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		tipo:'Field',
		filtro_0:false,
		filterColValue:'id_emplempleado_anterior'
	};
	
// txt cantidad
	
	
	
	Atributos[5]={
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo'],['eliminado','Eliminado']]}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65,
			disabled: true
		},
		id_grupo: 1,
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'afe.estado',
		save_as:'txt_estado',
		defecto:'activo'
	};
	
	
	
// txt tipo_transporte
	Atributos[6]={
			validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80, // ancho de columna en el gris
			disabled: true
		},
		id_grupo: 1,
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'afe.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y'
	};
	if(vista=='padre'){
	
		Atributos[7]={
			validacion:{
				fieldLabel: 'Funcionario Destino',
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
				width_grid:250
			},
	        id_grupo: 0,
			tipo: 'ComboBox',
			save_as:'hidden_id_empleado'
		};
		
		Atributos[8]={
			validacion:{
				name: 'fecha_asig',
				fieldLabel: 'Fecha Transferencia',
				allowBlank: false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				renderer: formatDate,
				width_grid:80
			},
			id_grupo: 0,
			tipo: 'DateField',
			filtro_0:true,
			filterColValue:'afe.fecha_asig',
			save_as:'txt_fecha_asig',
			dateFormat:'m-d-Y'
		};
	}
	else{
		Atributos[7]={
			validacion:{
				labelSeparator:'',
				name: 'id_transferencia',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_transferencia'
		};
		
		Atributos[8]={
		validacion:{
			labelSeparator:'',
			name: 'id_empleado',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado'
	};
	}


	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Transferencia',titulo_detalle:'Transferencia (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_transferencia = new DocsLayoutMaestro(idContenedor);
	layout_transferencia.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_transferencia,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getGrid=this.getGrid;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_InitFunciones=this.InitFunciones;
	
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={nuevo:{crear:true,separador:true},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+"../../../control/activo_fijo_empleado/ActionEliminaTransferencia.php"},
	Save:{url:direccion+"../../../control/activo_fijo_empleado/ActionTransfiereActivos.php"},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',width:'40%',minWidth:350,minHeight:400,	closable:true,titulo:'Transferencia de Activos',
		
			grupos:[
			{
				tituloGrupo:'Información general',
				columna:0,
				id_grupo:0
			},
			
			{	tituloGrupo:'Datos vigentes del Activo Fijo',
				columna:0,
				id_grupo:1
			}]
		}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_transferencia:maestro.id_transferencia
				
			}
		};
		
		ds_activo_fijo_empleado.baseParams.id_empleado=maestro.id_empleado_origen;
		
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);
	}
		
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	v_id_activo_fijo_empleado = ClaseMadre_getComponente('id_activo_fijo_empleado');
	    cmb_id_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
        txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
        txt_desc_activo_fijo=ClaseMadre_getComponente('desc_activo_fijo');
	 	txt_descripcion_larga=ClaseMadre_getComponente('descripcion_larga');
	 	txt_id_empleado_anterior=ClaseMadre_getComponente('id_empleado_anterior');
	 	
	 	txt_estado=ClaseMadre_getComponente('estado');
	    
        
		var onActivoFijoModif = function(e) {
			var id = cmb_id_activo_fijo.getValue();
			if(cmb_id_activo_fijo.store.getById(id)!=undefined){
				v_id_activo_fijo_empleado.setValue(cmb_id_activo_fijo.store.getById(id).data.id_activo_fijo_empleado);
				txt_id_empleado_anterior.setValue(cmb_id_activo_fijo.store.getById(id).data.desc_empleado);
				txt_descripcion_larga.setValue(cmb_id_activo_fijo.store.getById(id).data.descripcion_larga);
				txt_desc_activo_fijo.setValue(cmb_id_activo_fijo.store.getById(id).data.desc_activo_fijo);
				txt_fecha_reg.setValue(cmb_id_activo_fijo.store.getById(id).data.fecha_reg);
				txt_estado.setValue(cmb_id_activo_fijo.store.getById(id).data.estado);
				
			}
		};
		cmb_id_activo_fijo.on('select',onActivoFijoModif);
		cmb_id_activo_fijo.on('change',onActivoFijoModif);
	}
	this.btnNew = function(){
		CM_btnNew();
		if(vista!='padre')
		{	
			ClaseMadre_getComponente('id_empleado').setValue(maestro.id_empleado_destino);
			ClaseMadre_getComponente('id_transferencia').setValue(maestro.id_transferencia);
		}
		
	}
	
	
	
	function btnRepTransferencia()
	{	var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado
			if(SelectionsRecord.data.estado=='activo') {
				data = "codigo=" + SelectionsRecord.data.codigo;
				data = data + "&estado=" + SelectionsRecord.data.estado;
				data = data + "&descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
				data = data + "&id_empleado_anterior=" + SelectionsRecord.data.id_empleado_anterior;
				data = data + "&id_empleado=" + SelectionsRecord.data.id_empleado;
				data = data + "&fecha_asig=" + formatDate(SelectionsRecord.data.fecha_asig);
				//alert('pasa fecha');
				window.open(direccion+'../../../control/_reportes/activo_fijo_transferencia_vista/ActionPDFActivoFijoTransferenciaVista.php?'+data);
			}else
			{	Ext.MessageBox.alert('Estado', 'El Estado es Inactivo.');		}
		}

		else
		{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_viatico.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	
	
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	if(vista=='padre')
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Formulario de Transferencia',btnRepTransferencia,true,'formulario','Formulario');		
	
	iniciarEventosFormularios();
	
	
	if(vista=='padre'){
		
		this.desbloquearMenu();
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		};
		this.btnActualizar();
	}
	else{
		this.bloquearMenu();
	}
	layout_transferencia.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	
}