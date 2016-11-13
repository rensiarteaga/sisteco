/**
 * Nombre:		  	    pagina_empleado_tpm_frppa_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:44:29
 */
function pagina_empleado_tpm_frppa_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,ds_financiador,ds_regional,ds_programa,ds_proyecto,ds_actividad;
	var layout_empleado_tpm_frppa;
	var combo_financiador,combo_regional,combo_programa,combo_proyecto,combo_actividad;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa_det.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_frppa',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_frppa',
		'id_empleado',
		'desc_empleado',
		{name:'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_ingreso',
        'id_financiador',
        'desc_financiador',
        'id_regional',
        'desc_regional',
        'id_programa',
        'desc_programa',
        'id_proyecto',
        'desc_proyecto',
        'id_actividad',
        'desc_actividad',
        'estado_reg'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_empleado:maestro.id_empleado
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    var dataMaestro=[['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	ds_financiador=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_financiador',totalRecords:'TotalCount'},['id_financiador','nombre_financiador'])});
	ds_regional=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/regional/ActionListaRegionalEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','nombre_regional'])});
	ds_programa=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa/ActionListaProgramaEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_programa',totalRecords:'TotalCount'},['id_programa','nombre_programa'])});
	ds_proyecto=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords:'TotalCount'},['id_proyecto','nombre_proyecto'])});
	ds_actividad=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/actividad/ActionListaActividadEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actividad',totalRecords:'TotalCount'},['id_actividad','nombre_actividad'])});
	//FUNCIONES RENDER
	function renderFinanciador(value,p,record){return String.format('{0}',record.data['desc_financiador'])}
	function renderRegional(value,p,record){return String.format('{0}',record.data['desc_regional'])}
	function renderPrograma(value,p,record){return String.format('{0}',record.data['desc_programa'])}
	function renderProyecto(value,p,record){return String.format('{0}',record.data['desc_proyecto'])}
	function renderActividad(value,p,record){return String.format('{0}',record.data['desc_actividad'])}
	
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_frppa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado_frppa'
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'txt_id_empleado'
	};
vectorAtributos[2]={
	validacion:{
		fieldLabel:'Financiador',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Financiador...',
		name:'id_financiador',
		desc:'desc_financiador',
		store:ds_financiador,
		valueField:'id_financiador',
		displayField:'nombre_financiador',
		queryParam:'filterValue_0',
		filterCol:'nombre_financiador',
		typeAhead:true,
		forceSelection:true,
		renderer:renderFinanciador,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:120
	},
	save_as:'txt_id_financiador',
	tipo:'ComboBox'
};
    filterCols_regional=new Array();
	filterValues_regional=new Array();
	filterCols_regional[0]='frppa.id_financiador';
	filterValues_regional[0]='%';
	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Regional',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Regional...',
			name:'id_regional',
			desc:'desc_regional',
			store:ds_regional,
			valueField:'id_regional',
			displayField:'nombre_regional',
			queryParam:'filterValue_0',
			filterCol:'REGION.codigo_regional#REGION.descripcion_regional#REGION.nombre_regional',
			filterCols:filterCols_regional,
			filterValues:filterValues_regional,
			typeAhead:true,
			forceSelection:true,
			renderer:renderRegional,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		save_as:'txt_id_regional',
		tipo:'ComboBox'
	};
	filterCols_programa=new Array();
	filterValues_programa=new Array();
	filterCols_programa[0]='frppa.id_financiador';
	filterValues_programa[0]='%';
	filterCols_programa[1]='frppa.id_regional';
	filterValues_programa[1]='%';
	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Programa',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Programa...',
			name:'id_programa',
			desc:'desc_programa',
			store:ds_programa,
			valueField:'id_programa',
			displayField:'nombre_programa',
			queryParam:'filterValue_0',
			filterCol:'nombre_programa',
			filterCols:filterCols_programa,
			filterValues:filterValues_programa,
			typeAhead:true,
			forceSelection:true,
			renderer:renderPrograma,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		save_as:'txt_id_programa',
		tipo:'ComboBox'
	};
	filterCols_proyecto=new Array();
	filterValues_proyecto=new Array();
	filterCols_proyecto[0]='frppa.id_financiador';
	filterValues_proyecto[0]='%';
	filterCols_proyecto[1]='frppa.id_regional';
	filterValues_proyecto[1]='%';
	filterCols_proyecto[2]='pgpyac.id_programa';
	filterValues_proyecto[2]='%';
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Proyecto',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Proyecto...',
			name:'id_proyecto',
			desc:'desc_proyecto',
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
			filterCol:'nombre_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead:true,
			forceSelection:true,
			renderer:renderProyecto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		save_as:'txt_id_proyecto',
		tipo:'ComboBox'
	};
	filterCols_actividad=new Array();
	filterValues_actividad=new Array();
	filterCols_actividad[0]='frppa.id_financiador';
	filterValues_actividad[0]='%';
	filterCols_actividad[1]='frppa.id_regional';
	filterValues_actividad[1]='%';
	filterCols_actividad[2]='pgpyac.id_programa';
	filterValues_actividad[2]='%';
	filterCols_actividad[3]='pgpyac.id_proyecto';
	filterValues_actividad[3]='%';
	vectorAtributos[6]={
		validacion:{
			fieldLabel:'Actividad',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Actividad...',
			name:'id_actividad',
			desc:'desc_actividad',
			store:ds_actividad,
			valueField:'id_actividad',
			displayField:'nombre_actividad',
			queryParam:'filterValue_0',
			filterCol:'nombre_actividad',
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad,
			typeAhead:true,
			forceSelection:true,
			renderer:renderActividad,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		save_as:'txt_id_actividad',
		tipo:'ComboBox'
	};
	// txt fecha_registro
	vectorAtributos[7]={
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEP.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro'
	};	
	
	vectorAtributos[8]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'',
		save_as:'estado_reg'
		};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Empleados Estructura Programática (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_empleado_tpm_frppa=new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_empleado_tpm_frppa.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_tpm_frppa,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
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
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/empleado_tpm_frppa/ActionEliminarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/empleado_tpm_frppa/ActionGuardarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/empleado_tpm_frppa/ActionGuardarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Estructura Programática'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_empleado=datos.m_id_empleado;
		maestro.id_persona=datos.m_id_persona;
		maestro.codigo_empleado=datos.m_codigo_empleado;
		maestro.desc_persona=datos.m_desc_persona;
		maestro.email1=datos.m_email1;
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]]);
		vectorAtributos[1].defecto=maestro.id_empleado;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/empleado_tpm_frppa/ActionEliminarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/empleado_tpm_frppa/ActionGuardarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/empleado_tpm_frppa/ActionGuardarEmpleadoTpmFrppa.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Estructura Programática'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		combo_financiador=ClaseMadre_getComponente('id_financiador');
		combo_regional=ClaseMadre_getComponente('id_regional');
		combo_programa=ClaseMadre_getComponente('id_programa');
		combo_proyecto=ClaseMadre_getComponente('id_proyecto');
		combo_actividad=ClaseMadre_getComponente('id_actividad');
		var onFinanciadorSelect=function(e){
			var id=combo_financiador.getValue()
			combo_regional.filterValues[0]=id;
			combo_regional.modificado=true;
			combo_programa.filterValues[0]=id;
			combo_programa.modificado=true;
			combo_proyecto.filterValues[0]=id;
			combo_proyecto.modificado=true;
			combo_actividad.filterValues[0]=id;
			combo_actividad.modificado=true;
			combo_regional.enable();
			combo_regional.setValue('');
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('')
		};
		var onRegionalSelect=function(e){
			var id=combo_regional.getValue()
			combo_programa.filterValues[1]=id;
			combo_programa.modificado=true;
			combo_proyecto.filterValues[1]=id;
			combo_proyecto.modificado=true;
			combo_actividad.filterValues[1]=id;
			combo_actividad.modificado=true;
			combo_programa.enable();
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('')
		};
		var onProgramaSelect=function(e){
			var id=combo_programa.getValue()
			combo_proyecto.filterValues[2]=id;
			combo_proyecto.modificado=true;
			combo_actividad.filterValues[2]=id;
			combo_actividad.modificado=true;
			combo_proyecto.enable();
			combo_proyecto.setValue('');
			combo_actividad.setValue('')
		};
		var onProyectoSelect=function(e){
			var id=combo_proyecto.getValue()
			combo_actividad.filterValues[3]=id;
			combo_actividad.enable();
			combo_actividad.modificado=true;
			combo_actividad.setValue('')
		};
		combo_financiador.on('select',onFinanciadorSelect);
		combo_financiador.on('change',onFinanciadorSelect);
		combo_regional.on('select',onRegionalSelect);
		combo_regional.on('change',onRegionalSelect);
		combo_programa.on('select',onProgramaSelect);
		combo_programa.on('change',onProgramaSelect);
		combo_proyecto.on('select',onProyectoSelect);
		combo_proyecto.on('change',onProyectoSelect)
	}
	this.btnNew=function(){
	combo_regional.disable();
	combo_programa.disable();
	combo_proyecto.disable();
	combo_actividad.disable();
	ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
	combo_regional.disable();
	combo_programa.disable();
	combo_proyecto.disable();
	combo_actividad.disable();
	ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_tpm_frppa.getLayout()
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
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado_tpm_frppa.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}