<?php 
/**
 * Nombre:		  	    depreciacion_gestion_main.php
 * PropÃƒÂ³sito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creaciÃƒÂ³n:		290902015
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_depreciacion_gestion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_depreciacion_gestion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depreciacion_gestion/ActionListarDepreciacionGestion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_depreciacion_gestion',totalRecords:'TotalCount'
		},[	
		'id_depreciacion_gestion',	
		'proyecto',
		'estado',
		'usuario_reg',
		'fecha_reg',
		'id_gestion_fin','gestion_fin','mes_fin',
		'id_gestion_ini','gestion_ini','mes_ini',
		'id_depto','desc_depto','id_proyecto','desc_proyecto'
		]),remoteSort:true});

    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});

	//FUNCIONES RENDER
	function render_id_gestion_fin(value, p, record){return String.format('{0}', record.data['gestion_fin']);}
	function render_id_gestion_ini(value, p, record){return String.format('{0}', record.data['gestion_ini']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}','</div>');

	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=actif'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

	function renderMes(component, value, record)
	{
		if(record.data['mes_fin'] == 1) return String.format('{0}', 'Enero');
		else if(record.data['mes_fin'] == 2)	return String.format('{0}', 'Febrero');
		else if(record.data['mes_fin'] == 3)	return String.format('{0}', 'Marzo');
		else if(record.data['mes_fin'] == 4)	return String.format('{0}', 'Abril');
		else if(record.data['mes_fin'] == 5)	return String.format('{0}', 'Mayo');
		else if(record.data['mes_fin'] == 6)	return String.format('{0}', 'Junio');
		else if(record.data['mes_fin'] == 7)	return String.format('{0}', 'Julio');
		else if(record.data['mes_fin'] == 8)	return String.format('{0}', 'Agosto');
		else if(record.data['mes_fin'] == 9)	return String.format('{0}', 'Septiembre');
		else if(record.data['mes_fin'] == 10)	return String.format('{0}', 'Octubre');
		else if(record.data['mes_fin'] == 11)	return String.format('{0}', 'Noviembre');
		else if(record.data['mes_fin'] == 12)	return String.format('{0}', 'Diciembre');
	}
	function renderMesInicio(component, value, record)
	{
		if(record.data['mes_ini'] == 1) return String.format('{0}', 'Enero');
		else if(record.data['mes_ini'] == 2)	return String.format('{0}', 'Febrero');
		else if(record.data['mes_ini'] == 3)	return String.format('{0}', 'Marzo');
		else if(record.data['mes_ini'] == 4)	return String.format('{0}', 'Abril');
		else if(record.data['mes_ini'] == 5)	return String.format('{0}', 'Mayo');
		else if(record.data['mes_ini'] == 6)	return String.format('{0}', 'Junio');
		else if(record.data['mes_ini'] == 7)	return String.format('{0}', 'Julio');
		else if(record.data['mes_ini'] == 8)	return String.format('{0}', 'Agosto');
		else if(record.data['mes_ini'] == 9)	return String.format('{0}', 'Septiembre');
		else if(record.data['mes_ini'] == 10)	return String.format('{0}', 'Octubre');
		else if(record.data['mes_ini'] == 11)	return String.format('{0}', 'Noviembre');
		else if(record.data['mes_ini'] == 12)	return String.format('{0}', 'Diciembre');
	}

	var ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListarProyecto.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	function render_id_proyecto(value, p, record){return String.format('{0}', record.data['desc_proyecto']);}
	var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo_proyecto}-{nombre_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_proyecto}</FONT>','</div>');
	
	/////////////////////////
	// DefiniciÃƒÂ³n de datos //
	/////////////////////////
	
	// hidden id_param_gral
	//en la posiciÃƒÂ³n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depreciacion_gestion',
			inputType:'hidden',
			grid_visible: false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};

	Atributos[1]={
			validacion:{
			name:'id_gestion_ini',
			fieldLabel:'Gestion Inicio',
			allowBlank:false,			
			emptyText:'gestion...',
			desc: 'gestion_ini', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mÃƒÂ­nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer: render_id_gestion_ini,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150,
			disabled:false,
			id_grupo:0,
			grid_indice:3		
		},
		tipo:'ComboBox',
		savce_as:'txt_id_gestion_ini',
		form: true,
		filtro_0:false,
		filterColValue:'GESTIO.gestion'
		
	};
	Atributos[2]={
			validacion:{
				name:'mes_ini',
				fieldLabel:'Mes Inicio',
				allowBlank: false,
				typeAhead: false,
				lazyRender:true,
				forceSelection:true,
				mode: 'local',
				renderer: renderMesInicio,
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
				width_grid:90, // ancho de columna en el grid
				width:150,
				minChars : 0,
				id_grupo:0,
				grid_indice:2
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'txt_mes_ini',
			filterColValue:'dg.mes_ini'
			
		};
	// txt id_gestion
	Atributos[3]={
			validacion:{
			name:'id_gestion_fin',
			fieldLabel:'Gestion Fin',
			allowBlank:false,			
			emptyText:'gestion...',
			desc: 'gestion_fin', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mÃƒÂ­nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer: render_id_gestion_fin,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150,
			disabled:false,
			grid_indice:5
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:false,
		filterColValue:'GESTIO.gestion'
		
	};
	Atributos[4]={
			validacion:{
				name:'mes_fin',
				fieldLabel:'Mes Fin',
				allowBlank: false,
				typeAhead: false,
				lazyRender:true,
				forceSelection:true,
				mode: 'local',
				renderer: renderMes,
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
				width_grid:90, // ancho de columna en el grid
				width:150,
				minChars : 0,
				grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'txt_mes_fin',
			id_grupo:1,
			filterColValue:'dg.mes_fin'
			
		};
	// txt id_depto
	Atributos[5]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			//emptyText:'Departamento de TesorerÃƒÂ­a...',
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
			minChars:1, ///caracteres mÃƒÂ­nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:160,
			disabled:false,
			grid_indice:6
					
		},
		tipo:'ComboBox',		
		filtro_0:true,
		filterColValue:'CUDOC.desc_depto',
		save_as:'txt_id_depto',
		id_grupo:2	
	};	
	Atributos[6]={
		validacion: {
			name:'proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			mode:'local',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:160,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:'no',
		id_grupo:2
		
	};
	Atributos[7]={
				validacion : {
					name : 'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'al.usuario_reg',
				form : false
		};
	Atributos[8]={
				validacion : {
					name : 'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					//renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'al.fecha_reg',
				grid_indice:8,
				dateFormat : 'm-d-Y'
		};
	Atributos[9]={
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
		grid_indice:9,
		save_as:'txt_estado',
		filterColValue:'GRUDE.estado'
		
	};
	Atributos[10]={
			validacion:{
				name:'id_depreciacion_gestion',
				fieldLabel:'Identificador ',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				grid_indice:1		
			},
			tipo:'Field',
			filtro_0:true,
			form:false,		
			filterColValue:''
		};
	Atributos[11]= {
			validacion: {
			name:'id_proyecto',
			fieldLabel:'Detalle Proyecto',
			allowBlank: true,			
			emptyText:'Proyecto...',
			desc: 'desc_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'descripcion_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion_proyecto#PROYEC.codigo_proyecto#PROYEC.nombre_proyecto',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:250,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			tpl: tpl_id_proyecto,
			grid_visible:false,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROYEC.nombre_proyecto#PROYEC.codigo_proyecto',
		defecto: '',
		save_as:'h_id_proyecto',
		id_grupo:2
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	/*var config={titulo_maestro:'Depreciacion Gestion',grid_maestro:'grid-'+idContenedor};
	var layout_depreciacion_gestion=new DocsLayoutMaestro(idContenedor);
	layout_depreciacion_gestion.init(config);*/
	var config={titulo_maestro:'Depreciacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/depreciacion_gestion/depreciacion_gestion_detalle.php'};
	var layout_depreciacion_gestion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_depreciacion_gestion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_depreciacion_gestion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_enableSelect=this.EnableSelect;
	var cm_Save=this.Save;
	var cm_Success=this.saveSuccess
	
	///////////////////////////////////
	// DEFINICIÃƒâ€œN DE LA BARRA DE MENÃƒÅ¡//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÃƒâ€œN DE FUNCIONES ------------------------- //
	//  aquÃƒÂ­ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/depreciacion_gestion/ActionEliminarDepreciacionGestion.php'},
		Save:{url:direccion+'../../../control/depreciacion_gestion/ActionGuardarDepreciacionGestion.php',success:procesoSuccess},
		ConfirmSave:{url:direccion+'../../../control/depreciacion_gestion/ActionGuardarDepreciacionGestion.php'},
		Formulario:{
						html_apply:'dlgInfo-'+idContenedor,height:430,width:500,minWidth:150,minHeight:200,	closable:true,titulo:'Depreciacion Gestion'
						,columnas:['80%','80%'],grupos:[{	tituloGrupo:'Datos Inicio Depreciacion',columna:0,	id_grupo:0}
															,{tituloGrupo:'Datos Fin Depreciacion',columna:0,	id_grupo:1}
															,{tituloGrupo:'Otros Datos',columna:0,	id_grupo:2}
															
															]
					}

		};
	
	
	//-------------- DEFINICIÃƒâ€œN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario
		cmb_proy=getComponente('proyecto');
		//getComponente('id_proyecto').setVisible(false);
		function onComboProyectoSelect()
		{
			if(cmb_proy.getValue() == 'si')
			{
				//getComponente('id_proyecto').setVisible(true);
				getComponente('id_proyecto').setVisible(false);
				cmb_proy.allowBlank = false; 
			}
			else
			{
				getComponente('id_proyecto').setVisible(false);
				getComponente('id_proyecto').setValue(null);
				cmb_proy.allowBlank = true; 
			}
		}
		cmb_proy.on('select',onComboProyectoSelect);
		cmb_proy.on('change',onComboProyectoSelect); 
		
	}
	
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		_CP.getPagina(layout_depreciacion_gestion.getIdContentHijo()).pagina.desbloquearMenu();
		_CP.getPagina(layout_depreciacion_gestion.getIdContentHijo()).pagina.reload(rec.data);
	}
	
	this.btnEdit=function(){
		CM_btnEdit();
		getComponente('estado').setValue(null);
	}

	//para que los hijos puedan ajustarse al tamaÃƒÂ±o
	this.getLayout=function(){return layout_depreciacion_gestion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÃƒï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);


	var CM_getBoton=this.getBoton;
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
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Reporte Excel',btn_reporte,true,'depreciacion','Depreciaci\u00F3n');

	function btn_reporte()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_depreciacion_gestion='+SelectionsRecord.data.id_depreciacion_gestion;	
			data=data+'&m_proyecto='+SelectionsRecord.data.proyecto;
			data=data+'&fecha_desde='+SelectionsRecord.data.mes_ini+'/01/'+SelectionsRecord.data.gestion_ini;
			data=data+'&fecha_hasta='+SelectionsRecord.data.mes_fin+'/01/'+SelectionsRecord.data.gestion_fin;
			data=data+'&mes_ini='+SelectionsRecord.data.mes_ini;
			data=data+'&anio_ini='+SelectionsRecord.data.gestion_ini;
			data=data+'&mes_fin='+SelectionsRecord.data.mes_fin;
			data=data+'&anio_fin='+SelectionsRecord.data.gestion_fin;
			
			window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/depreciacion_gestion/ActionReporteDepreciacionGestionXLS.php?'+data);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}		
		
	}
	
	
	function btn_depreciar(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
	
			
			if(SelectionsRecord.data.estado=='borrador')
			{	
				if(confirm('Esta seguro de generar la depreciacion  del proceso ?'))
				{
					getComponente('estado').setValue('depreciado');
					cm_Save();
				}
			}
			else
			{
				if(confirm('Esta seguro de revertir la depreciacion  del proceso ?'))
				{
					getComponente('estado').setValue('borrador');
					cm_Save();
				}
			}
			
															
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}		
	}
	
	function procesoSuccess(resp)
	{
		cm_Success(resp);	
	}

	function bloquearbotones(tipo){
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('depreciacion-'+idContenedor).disable();
	
	}
	 
	function enable(sm,row,rec)
	{
		CM_enableSelect(sm,row,rec);

		bloquearbotones();
		if(rec.data['estado'] == 'borrador')
		{
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('depreciar-'+idContenedor).setText('Depreciar');	
		}
		else
		{
			CM_getBoton('depreciar-'+idContenedor).setText('Revertir');	
			CM_getBoton('depreciacion-'+idContenedor).enable();
		}
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_depreciacion_gestion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}