/**
* Nombre:		  	    pagina_eeff_compara.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_eeff_compara(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	
	var dialog;
	var habilita_hijo='si';
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff_compara/ActionListarEeffCom.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_eeff',totalRecords:'TotalCount'
		},[
		   'id_eeff',
			'id_reporte_eeff',
			'nombre_eeff',
			'id_gestion_act',
			'desges_act',
			'id_gestion_ant',
			'desges_ant',
			'id_moneda',
			'nombre_moneda',
			'eeff_actual',
			'eeff_fecran',
			'eeff_nivel',
			'eeff_texto',
			'mat_contador',
			'id_empleado_fc',
			'nombre_fc',
			'id_empleado_f1',
			'nombre_f1',
			'id_empleado_f2',
			'nombre_f2',
			'id_empleado_f3',
			'nombre_f3',
			'eeff_fecha'
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=cobra_sis'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
    });
	
	var ds_empleado_fc = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?correspondencia=si'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
	var ds_empleado_f1 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?correspondencia=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
	var ds_empleado_f2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?correspondencia=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
	var ds_empleado_f3 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?correspondencia=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
	var ds_reporte_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff'])
	});
	
	/*FUNCIONES RENDER*/
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desges_act']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');	
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['nombre_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<FONT COLOR="#B50000"><b> - </b>{simbolo}</FONT>','</div>');
	
	function render_id_empleado_fc(value, p, record){return String.format('{0}', record.data['nombre_fc']);}
	var tpl_id_empleado_fc=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
	
	function render_id_empleado_f1(value, p, record){return String.format('{0}', record.data['nombre_f1']);}
	var tpl_id_empleado_f1=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
	
	function render_id_empleado_f2(value, p, record){return String.format('{0}', record.data['nombre_f2']);}
	var tpl_id_empleado_f2=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
	
	function render_id_empleado_f3(value, p, record){return String.format('{0}', record.data['nombre_f3']);}
	var tpl_id_empleado_f3=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
	
	function render_id_reporte_eeff(value, p, record){return String.format('{0}', record.data['nombre_eeff']);}
	var tpl_id_reporte_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
	
	function render_dato(value, p, record){	
		if(value==1){return 'A Fecha';}
		if(value==2){return 'Entre Fechas';}		
	}
	
	function render_sino(value, p, record){	
		if(value=='no'){return 'NO';}
		if(value=='si'){return 'SI';}	
	}
	
	function render_niv(value, p, record){	
		if(value==2){return 'N - 2';}
		if(value==3){return 'N - 3';}
		if(value==4){return 'N - 4';}
		if(value==5){return 'N - 5';}
		if(value==6){return 'N - 6';}
		if(value==7){return 'N - 7';}
		if(value==8){return 'N - 8';}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria

   Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_eeff',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_eeff',
		id_grupo:0
   };
   
   Atributos[1]={
		validacion:{
			name:'id_reporte_eeff',
			fieldLabel:'Estado Financiero',
			allowBlank:false,			
			emptyText:'...',
			desc: 'nombre_eeff', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_reporte_eeff,
			valueField: 'id_reporte_eeff',
			displayField: 'nombre_eeff',
			queryParam: 'filterValue_0',
			filterCol:'nombre_eeff',
			typeAhead:false,
			tpl:tpl_id_reporte_eeff,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_reporte_eeff,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EFR.nombre_eeff',
		save_as:'id_reporte_eeff',
		id_grupo:0
   };
   
   Atributos[2]={
		validacion:{
			name:'id_gestion_act',
			fieldLabel:'Gestión Vigente',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'desges_act', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GES.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			align:'center',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GES.gestion',
		save_as:'id_gestion_act',
		id_grupo:0			
   };
   
   Atributos[3]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion_ant',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_gestion_ant',
		id_grupo:0
   };
   
   Atributos[4]={
		validacion:{
			name:'desges_ant',
			fieldLabel:'Gestión Anterior',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			align:'center',
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'GEA.gestion',
		save_as:'desges_ant',
		id_grupo:0
	};
	
   	Atributos[5]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'nombre_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MON.nombre',
		save_as:'id_moneda',
		id_grupo:0
	};
   	
   	Atributos[6]={
		validacion:{
			name:'eeff_actual',
			fieldLabel:'Actualización',
			allowBlank:true,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'eeff_actual'
	};
   	
   	Atributos[7]={
		validacion:{
			name:'eeff_nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[2,'N - 2'],[3,'N - 3'],[4,'N - 4'],[5,'N - 5'],[6,'N - 6'],[7,'N - 7'],[8,'N - 8']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			renderer:render_niv,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'eeff_nivel'
	};
   	
   	Atributos[8]={
		validacion:{
			name:'eeff_fecran',
			fieldLabel:'Fechas',
			allowBlank:true,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'A Fecha'],[2,'Entre Fechas']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_dato,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'eeff_fecran'
	};
   	
   	Atributos[9]={
		validacion:{
			name:'eeff_texto',
			fieldLabel:'Observación',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			disabled:false
		},
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'EEF.eeff_texto',
		save_as:'eeff_texto',
		id_grupo:0
	};
   	
   	Atributos[10]={
		validacion:{
			name:'mat_contador',
			fieldLabel:'Matricula',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'EEF.mat_contador',
		save_as:'mat_contador',
		id_grupo:0
	};
   	
   	Atributos[11]={
		validacion:{
			name:'id_empleado_fc',
			fieldLabel:'Contador',
			allowBlank:false,			
			emptyText:'Contador...',
			desc: 'nombre_fc', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_fc,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado_fc,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_fc,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'FC.desc_persona',
		save_as:'id_empleado_fc',
		id_grupo:0
	};
   	
   	Atributos[12]={
		validacion:{
			name:'id_empleado_f1',
			fieldLabel:'Firma-1',
			allowBlank:false,			
			emptyText:'...',
			desc: 'nombre_f1', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_f1,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado_f1,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_f1,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'F1.desc_persona',
		save_as:'id_empleado_f1',
		id_grupo:0
	};
   	
   	Atributos[13]={
		validacion:{
			name:'id_empleado_f2',
			fieldLabel:'Firma-2',
			allowBlank:true,			
			emptyText:'...',
			desc: 'nombre_f2', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_f2,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado_f2,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_f2,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'F2.desc_persona',
		save_as:'id_empleado_f2',
		id_grupo:0
	};
   	
   	Atributos[14]={
		validacion:{
			name:'id_empleado_f3',
			fieldLabel:'Firma-3',
			allowBlank:true,			
			emptyText:'...',
			desc: 'nombre_f3', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado_f3,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado_f3,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_f3,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'F3.desc_persona',
		save_as:'id_empleado_f3',
		id_grupo:0
	};
   	
   	Atributos[15]= {
		validacion:{
			name:'eeff_fecha',
			fieldLabel:'Generedo el',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,				
			disabled:true
		},
		tipo:'TextField',
		form:false,
		filtro_0:false,
		id_grupo:0
	};
   	
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'EEFF',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/eeff_compara/eeff_linea.php'};
	//var config={titulo_maestro:'EEFF',grid_maestro:'grid-'+idContenedor};
    layout_eeff=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_eeff.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_eeff,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
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
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/eeff_compara/ActionEliminarEeffCom.php'},
		Save:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffCom.php'},
		ConfirmSave:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffCom.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:480,minWidth:150,minHeight:200,closable:true,titulo:'EEFF Comparativo',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		dialog=Cm_getDialog();
		getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_eeff.getIdContentHijo()).pagina.limpiarStore()){}
		})
	}
	
	function btn_nota(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){			
			var SelectionsRecord=sm.getSelected();
			var data='m_id_eeff='+SelectionsRecord.data.id_eeff;
			data=data+'&m_desges_act='+SelectionsRecord.data.desges_act;
			data=data+'&m_desges_ant='+SelectionsRecord.data.desges_ant;
			data=data+'&m_nombre_eeff='+SelectionsRecord.data.nombre_eeff;
			
			var ParamVentana={Ventana:{width:'50%',height:'50%'}}
			layout_eeff.loadWindows(direccion+'../../../../sis_contabilidad/vista/eeff_compara/eeff_nota.php?'+data,'eeff_nota',ParamVentana);
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_eeff_jasper(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){	
			var SelectionsRecord=sm.getSelected();
			var data='&id_eeff='+SelectionsRecord.data.id_eeff
			data+='&sw_rep='+1;
			window.open(direccion+'../../../../sis_contabilidad/control/eeff_compara/reporte/ActionPDFEeffComJasper.php?'+data);
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_nota_jasper(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){	
			var SelectionsRecord=sm.getSelected();
			var data='&id_eeff='+SelectionsRecord.data.id_eeff
			data+='&sw_rep='+3;
			window.open(direccion+'../../../../sis_contabilidad/control/eeff_compara/reporte/ActionPDFEeffComJasper.php?'+data);
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_eeffniv_jasper(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){	
			var SelectionsRecord=sm.getSelected();
			var data='&id_eeff='+SelectionsRecord.data.id_eeff
			data+='&sw_rep='+2;
			window.open(direccion+'../../../../sis_contabilidad/control/eeff_compara/reporte/ActionPDFEeffComJasper.php?'+data);
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_eeff.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_eeff.getIdContentHijo()).pagina.bloquearMenu();
	    _CP.getPagina(layout_eeff.getIdContentHijo()).pagina.desbloquearMenu();
	    
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();
	    _CP.getPagina(idContenedor).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_eeff.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Notas al Estado Financiero',btn_nota,true,'eeff_nota','Notas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión del EEFF Comparativo',btn_eeff_jasper,true,'eeff_jasper','EEFF');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión de Notas al EEFF',btn_nota_jasper,true,'eeff_nota_jasper','Notas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión del EEFF Comparativo por Nivel',btn_eeffniv_jasper,true,'eeff_jasper','EEFF x Nivel');
	
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_eeff.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
