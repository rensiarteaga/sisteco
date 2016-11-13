/**
 * Nombre:		  	    pagina_depreciacion2.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-07-20 14:54:38
 */
function pagina_depreciacion2(idContenedor,direccion,usuario,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/grupo_depreciacion/ActionListarDepreciacion2.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_grupo_depreciacion',totalRecords:'TotalCount'
		},[		
		'id_grupo_depreciacion',
		'ano_fin',
		'mes_fin',
		'id_depto',
		'desc_depto',
		'estado',
		'id_usuario_reg',
		'desc_usuario',
		'fecha_reg',
		'id_usuario_reg2',
		'desc_usuario2',
		'proyecto',
		'nombre_depto'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

   var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','nombre_corto','nombre_largo'])
		});
   
     var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','nombre','apellido_paterno','apellido_materno','desc_persona'])
	});	
    
	//FUNCIONES RENDER
	
		function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

		function render_id_usuario_reg(value, p, record){return String.format('{0}', record.data['desc_usuario2']);}
		var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','{desc_persona}<br>','</div>');

		function render_mes_fin(value, p, record){return String.format('{0}', record.data[1]); }
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_grupo_depreciacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_grupo_depreciacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt ano_fin
	Atributos[1]={
		validacion:{
			name:'ano_fin',
			fieldLabel:'Año',
			allowBlank: false,
			maxLength:4,
			minLength:4,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1900,
			maxValue: 2050,
			minText: 'La fecha debe ser mayor a 1900',
			maxText: 'La fecha debe ser menor a 2050',
			nanText : 'Fecha no válida',
			minLengthText :'La fecha debe estar en formato yyyy',
			maxLengthText :'La fecha debe estar en formato yyyy',			
			vtype:"texto",
			width: 80,
			grid_visible:true,
			width_grid: 100,
			typeAhead: false,
			//editable:true,
			mode: 'local',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['v1'],data : Ext.proc_depreciacionCombo.anos}),
			store: new Ext.data.SimpleStore({fields: ['v1','v2'],data : 
				[
				 ['2000', '2000'],
			        ['2001', '2001'], 
			        ['2002', '2002'],
			        ['2003', '2003'],  
			        ['2004', '2004'], 
			        ['2005', '2005'],
			        ['2006', '2006'],
			        ['2007', '2007'],
			        ['2008', '2008'],
			        ['2009', '2009'],                                 
					['2010', '2010'],
			        ['2011', '2011'],
			        ['2012', '2012'],
			        ['2013', '2013'],
			        ['2014', '2014'],
			        ['2015', '2015'],
			        ['2016', '2016'],
			        ['2017', '2017'],
			        ['2018', '2018'],
			        ['2019', '2019'],
			        ['2020', '2020'],
			        ['2021', '2021'],
					['2022', '2022'],
					['2023', '2023'],
					['2024', '2024'],
					['2025', '2025']
				 ]}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			forceSelection:true,
			grid_indice:1
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GRUDE.ano_fin'
		
	};
// txt mes_fin
	Atributos[2]={
		validacion:{
			name:'mes_fin',
			fieldLabel:'Mes',
			allowBlank: false,
			typeAhead: false,
			lazyRender:true,
			forceSelection:true,
			mode: 'local',
			triggerAction: 'all',			
			//store: new Ext.data.SimpleStore({fields: ['mes', 'nombre'],data : Ext.proc_depreciacionCombo.meses}),
			store: new Ext.data.SimpleStore({fields: ['mes', 'nombre'],data :[
			                                                                  ['1', 'Enero'],
			                                                                  ['2', 'Febrero'],
			                                                                  ['3', 'Marzo'],
			                                                                  ['4', 'Abril'],
			                                                                  ['5', 'Mayo'],
			                                                                  ['6', 'Junio'],
			                                                                  ['7', 'Julio'],
			                                                                  ['8', 'Agosto'],
			                                                                  ['9', 'Septiembre'],
			                                                                  ['10', 'Octubre'],
			                                                                  ['11', 'Noviembre'],
			                                                                  ['12', 'Diciembre']
			                                                              ]}),
			valueField:'mes',
			displayField:'nombre',
			grid_visible:true,
			width_grid:65, // ancho de columna en el grid
			width: 120,
			minChars : 0,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GRUDE.mes_fin'
		
	};
// txt id_depto
	Atributos[3]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,		
			valueField: 'id_depto',
			displayField: 'codigo_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto'
	};
// txt estado
	Atributos[4]={
		validacion:{
			name:'estado',
			labelSeparator:'',
			inputType:'hidden',
			maxLength:20,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			grid_indice:4		
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		filterColValue:'GRUDE.estado'
		
	};
// txt id_usuario_reg
	Atributos[5]={
			validacion:{
			name:'desc_usuario',
			fieldLabel:'Usuario',
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			grid_indice:5		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'GRUDE.desc_usuario'
		
	};
// txt fecha_reg
	Atributos[6]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'GRUDE.fecha_reg',
	};
// txt id_usuario_reg2
	Atributos[7]={
			validacion:{
			name:'id_usuario_reg2',
			fieldLabel:'Usuario Asig.',
			allowBlank:true,			
			emptyText:'Usuario Asig....',
			desc: 'desc_usuario2', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_reg,
			grid_visible:true,
			grid_editable:true,
			width_grid:170,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_7.nombre_completo',
		id_grupo:1
		
	};
	
	Atributos[8]={
		validacion: {
			name:'proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:'no'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Depreciación',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/depreciacion2_det/depreciacion2_det.php'};
	var layout_depreciacion2=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_depreciacion2.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_depreciacion2,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var cm_EnableSelect=this.EnableSelect;
	var cm_Save=this.Save;
	var cm_Success=this.saveSuccess

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
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/grupo_depreciacion/ActionEliminarDepreciacion2.php'},
		Save:{url:direccion+'../../../control/grupo_depreciacion/ActionGuardarDepreciacion2.php',success:procesoSuccess},
		//Save:{url:direccion+'../../../control/grupo_depreciacion/ActionGuardarDepreciacion2.php',success:procesoSuccess,timeout:600000},
		ConfirmSave:{url:direccion+'../../../control/grupo_depreciacion/ActionGuardarDepreciacion2.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'depreciacion2',
	grupos:[
			{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Usuario',
				columna:0,
				id_grupo:1
			}
			]
	}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_depreciar(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			getComponente('estado').setValue('depreciado');
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.estado=='borrador')
				sw=1;
			else
				sw=0;
			cm_Save();												
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}		
	}
	
	function btn_procesar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			getComponente('estado').setValue('pendiente');
			cm_Save();												
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}		
	}
	
	function btn_finalizar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			getComponente('estado').setValue('contabilizado');
			cm_Save();												
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}		
	}
	
	function btn_reporte(){		
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			var SelectionsRecord=sm.getSelected();		
			var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
			data=data+'&txt_ano_fin='+SelectionsRecord.data.ano_fin;
			data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin;
			data=data+'&txt_depart='+SelectionsRecord.data.nombre_depto;
			window.open(direccion+'../../../../sis_activos_fijos/control/depreciacion/ActionPDFDepreciacion.php?'+data);					
			//window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/detalle_depreciacion/ActionPDFDetalleDepreciacion.php?'+data);
		}else if(NumSelect>1) {
			Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
		}				
	}
	
	function btn_informe(){		
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			var SelectionsRecord=sm.getSelected();		
			var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
			data=data+'&txt_ano_fin='+SelectionsRecord.data.ano_fin;
			data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin;
			data=data+'&txt_depart='+SelectionsRecord.data.nombre_depto;
			window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteDepreciacionXLS.php?'+data);
			//window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteDepreciacionPFD.php?'+data);
			
			//Ext.MessageBox.alert('Estado', 'Redirecionando.....');
		} else  {
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}				
	}
	
	function btn_comprobante(){		
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_grupo_depreciacion=" + SelectionsRecord.data.id_grupo_depreciacion;
			data = data + "&maestro_ano_fin=" + SelectionsRecord.data.ano_fin;
			data = data + "&maestro_mes_fin=" + SelectionsRecord.data.mes_fin;
			data = data + "&maestro_desc_depto=" + SelectionsRecord.data.desc_depto;
			data = data + "&maestro_estado=" + SelectionsRecord.data.estado;
			data = data + "&maestro_desc_usuario=" + SelectionsRecord.data.desc_usuario;
			data = data + "&maestro_fecha_reg=" + SelectionsRecord.data.fecha_reg;
			data = data + "&maestro_desc_usuario2=" + SelectionsRecord.data.desc_usuario2;
			data = data + "&maestro_proyecto=" + SelectionsRecord.data.proyecto;
			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_depreciacion2.loadWindows(direccion+'../../../../sis_activos_fijos/vista/depreciacion2_comprobante/depreciacion2_comprobante.php?'+data,'Caracteristicas AF',ParamVentana);
			layout_depreciacion2.getVentana().on('resize',function(){
			layout_depreciacion2.getLayout().layout();})
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}	
	}
	
	function btn_form605(){
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();		
			var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
			data=data+'&txt_ano_fin='+SelectionsRecord.data.ano_fin;
			data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin;
			data=data+'&txt_depart='+SelectionsRecord.data.nombre_depto;
			window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteFormulario605XLS.php?'+data);
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro');
		}
	}
	
	function obtenerTitulo()
	{
		var vMes_fin = getComponente('mes_fin');
		var vGestion_fin = getComponente('ano_fin');
		return 'Depreciación: ' + vMes_fin.getValue() + '/' + vGestion_fin.getValue();
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		ds_depto.baseParams={usuario:usuario,
			subsistema:'actif'};
			ds_depto.modificado=true;
		CM_ocultarGrupo('Usuario');
	//para iniciar eventos en el formulario
	}	
	
	function procesoSuccess(resp){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(sw==1){		
			sw=0;
			var postData = "id_grupo_depreciacion="+SelectionsRecord.data.id_grupo_depreciacion;
			var vTitulo = obtenerTitulo();
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_depreciacion2.loadWindows(direccion+'../../depreciacion_temp/depreciacion_temp.php?'+postData,vTitulo,ParamVentana);
		}
		cm_Success(resp);	
	}
	
	
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		datas_edit=rec.data;
		_CP.getPagina(layout_depreciacion2.getIdContentHijo()).pagina.desbloquearMenu();
		_CP.getPagina(layout_depreciacion2.getIdContentHijo()).pagina.reload(rec.data);
	}
	
	this.btnNew=function(){
		CM_btnNew();
		getComponente('estado').setValue('borrador');
	}
	
	this.btnEdit=function(){
		CM_btnEdit();
		getComponente('estado').setValue('borrador');
	}
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_depreciacion2.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});	
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Depreciar-Revertir',btn_depreciar,true,'depreciar','Depreciar-Revertir');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Procesar-Revertir',btn_procesar,true,'procesar','Procesar-Revertir');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Finalizar',btn_finalizar,true,'finalizar','Finalizar');
	this.AdicionarBoton('../../../lib/imagenes/report.png','Reporte',btn_reporte,true,'depreciacion','Depreciación');
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Generar Comprobantes',btn_form605,true,'formulario605','DetalleAF-Form605');
	
	/******************************************************Informe General Depreciacion*******************************************************/
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Reporte Excel',btn_informe,true,'depreciacion','Depreciación');
	
	/******************************************************Automatizacion Asientos Contables**************************************************/
	this.AdicionarBoton('../../../lib/imagenes/a_table.png','Generar Comprobantes',btn_comprobante,true,'comprobante','Generar Comprobantes');
	
	function bloquearbotones(tipo){
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('depreciar-'+idContenedor).disable();
		CM_getBoton('procesar-'+idContenedor).disable();
		CM_getBoton('finalizar-'+idContenedor).disable();		
	}
	
	function enable(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		bloquearbotones();
		if(rec.data['estado']=='borrador'){
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('depreciar-'+idContenedor).enable();	
		}else if(rec.data['estado']=='depreciado'){			
			CM_getBoton('depreciar-'+idContenedor).enable();	
			if(rec.data['proyecto']=='no')
				CM_getBoton('procesar-'+idContenedor).enable();
			else
				CM_getBoton('finalizar-'+idContenedor).enable();	
		}else if(rec.data['estado']=='pendiente'){
			CM_getBoton('procesar-'+idContenedor).enable();			
		}
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_depreciacion2.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}