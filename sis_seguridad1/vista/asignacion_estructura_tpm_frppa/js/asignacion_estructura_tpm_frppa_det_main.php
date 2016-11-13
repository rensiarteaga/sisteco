<?php
/**
 * Nombre:		  	    asignacion_estructura_tpm_frppa_det_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-10-31 11:34:04
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
	   echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	   }
	?>

var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	     	id_asignacion_estructura:<?php echo $m_id_asignacion_estructura;?>,nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_asignacion_estructura_tpm_frppa_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_asignacion_estructura_tpm_frppa_det.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-10-31 11:34:04
 */
function pagina_asignacion_estructura_tpm_frppa_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var grid;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionListarAsignacionEstructuraTpmFrppa_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_asignacion_estructura_frppa',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_asignacion_estructura_frppa',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		'id_asignacion_estructura',
		'desc_asignacion_estructura',
		'editar',
        'id_financiador','desc_financiador','id_regional','desc_regional','id_programa','desc_programa','id_proyecto','desc_proyecto','id_actividad','desc_actividad'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_asignacion_estructura:maestro.id_asignacion_estructura
		}
	});
	// DEFINICI�N DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/financiador/ActionListarFinanciador.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_financiador',totalRecords:'TotalCount'},['id_financiador','nombre_financiador'])});
	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/regional/ActionListaRegionalEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','nombre_regional'])});
	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa/ActionListaProgramaEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_programa',totalRecords:'TotalCount'},['id_programa','nombre_programa'])});
	ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords:'TotalCount'},['id_proyecto','nombre_proyecto'])});
	ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/actividad/ActionListaActividadEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actividad',totalRecords:'TotalCount'},['id_actividad','nombre_actividad'])});
	
	//FUNCIONES RENDER
	
	function renderFinanciador(value,p,record){return String.format('{0}',record.data['desc_financiador']);}
	function renderRegional(value,p,record){return String.format('{0}',record.data['desc_regional']);}
	function renderPrograma(value,p,record){return String.format('{0}',record.data['desc_programa']);}
	function renderProyecto(value,p,record){return String.format('{0}',record.data['desc_proyecto']);}
	function renderActividad(value,p,record){return String.format('{0}',record.data['desc_actividad']);}
	
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
		//en la posici�n 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_asignacion_estructura_frppa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_asignacion_estructura_frppa',
		id_grupo:0
	};
	 
// txt fecha_registro
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ASESTF.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};
	
// txt hora_registro
	vectorAtributos[2]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ASESTF.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};
	
// txt id_asignacion_estructura
	vectorAtributos[3]= {
		validacion:{
			name:'id_asignacion_estructura',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_asignacion_estructura,
		save_as:'txt_id_asignacion_estructura',
		id_grupo:0
	};
	
// txt editar
	vectorAtributos[4]= {
			validacion: {
			name:'editar',
			fieldLabel:'Editar',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ASESTF.editar',
		defecto:'si',
		save_as:'txt_editar',
		id_grupo:3
	};
	

	vectorAtributos[5] ={
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
			filterCol:'FINANC.nombre_financiador',
			typeAhead:true,forceSelection:true,
			renderer:renderFinanciador,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		id_grupo:1,
		save_as:'txt_id_financiador',
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'FINANC.nombre_financiador'
	
	};
	filterCols_regional=new Array();
	filterValues_regional=new Array();
	filterCols_regional[0]='frppa.id_financiador';
	filterValues_regional[0]='%';

	vectorAtributos[6] ={validacion:{fieldLabel:'Regional',allowBlank:false,vtype:'texto',emptyText:'Regional...',name:'id_regional',desc:'desc_regional',store:ds_regional,valueField:'id_regional',displayField:'nombre_regional',queryParam:'filterValue_0',filterCol:'REGION.codigo_regional#REGION.descripcion_regional',filterCols:filterCols_regional,filterValues:filterValues_regional,typeAhead:true,forceSelection:true,renderer:renderRegional,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_regional',tipo:'ComboBox',filtro_0:true,filtro_1:true,filtro_2:true,
		filterColValue:'REGION.nombre_regional'};
	
	filterCols_programa=new Array();
	filterValues_programa=new Array();
	filterCols_programa[0]='frppa.id_financiador';
	filterValues_programa[0]='%';
	filterCols_programa[1]='frppa.id_regional';
	filterValues_programa[1]='%';

	vectorAtributos[7] ={validacion:{fieldLabel:'Programa',allowBlank:false,vtype:'texto',emptyText:'Programa...',name:'id_programa',desc:'desc_programa',store:ds_programa,valueField:'id_programa',displayField:'nombre_programa',queryParam:'filterValue_0',filterCol:'nombre_programa',filterCols:filterCols_programa,filterValues:filterValues_programa,typeAhead:true,forceSelection:true,renderer:renderPrograma,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_programa',tipo:'ComboBox',
	filtro_0:true,
	filtro_1:true,
	filtro_2:true,
		filterColValue:'PROGRA.nombre_programa'};
	
	filterCols_proyecto=new Array();
	filterValues_proyecto=new Array();
	filterCols_proyecto[0]='frppa.id_financiador';
	filterValues_proyecto[0]='%';
	filterCols_proyecto[1]='frppa.id_regional';
	filterValues_proyecto[1]='%';
	filterCols_proyecto[2]='PGPYAC.id_programa';
	filterValues_proyecto[2]='%';

	vectorAtributos[8]={validacion:{fieldLabel:'Proyecto',allowBlank:false,vtype:'texto',emptyText:'Proyecto...',name:'id_proyecto',desc:'desc_proyecto',store:ds_proyecto,valueField:'id_proyecto',displayField:'nombre_proyecto',queryParam:'filterValue_0',filterCol:'nombre_proyecto',filterCols:filterCols_proyecto,filterValues:filterValues_proyecto,typeAhead:true,forceSelection:true,renderer:renderProyecto,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_proyecto',tipo:'ComboBox',
	filtro_0:true,
	filtro_1:true,
	filtro_2:true,
		filterColValue:'PROYEC.nombre_proyecto'};
	
	filterCols_actividad=new Array();
	filterValues_actividad=new Array();
	filterCols_actividad[0]='frppa.id_financiador';
	filterValues_actividad[0]='%';
	filterCols_actividad[1]='frppa.id_regional';
	filterValues_actividad[1]='%';
	filterCols_actividad[2]='PGPYAC.id_programa';
	filterValues_actividad[2]='%';
	filterCols_actividad[3]='PGPYAC.id_proyecto';
	filterValues_actividad[3]='%';

	vectorAtributos[9]={validacion:{fieldLabel:'Actividad',allowBlank:false,vtype:'texto',emptyText:'Actividad...',name:'id_actividad',desc:'desc_actividad',store:ds_actividad ,valueField:'id_actividad',displayField:'nombre_actividad',queryParam:'filterValue_0',filterCol:'nombre_actividad',filterCols:filterCols_actividad,filterValues:filterValues_actividad,typeAhead:true,forceSelection:true,renderer:renderActividad,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_actividad',tipo:'ComboBox',
	filtro_0:true,
	filtro_1:true,
	filtro_2:true,
		filterColValue:'ACTIVI.nombre_actividad'};
	
	
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Agrupacion Estructura (Maestro)',
		titulo_detalle:'Agrupacion Estructura FRPPA (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_asignacion_estructura_tpm_frppa = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_asignacion_estructura_tpm_frppa.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_asignacion_estructura_tpm_frppa,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_btnEdit=this.btnEdit;
	//-------- DEFINICI�N DE LA BARRA DE MEN�
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICI�N DE FUNCIONES
	//aqu� se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionEliminarAsignacionEstructuraTpmFrppa.php',parametros:'&m_id_asignacion_estructura='+maestro.id_asignacion_estructura},
	Save:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionGuardarAsignacionEstructuraTpmFrppa.php',parametros:'&m_id_asignacion_estructura='+maestro.id_asignacion_estructura},
	ConfirmSave:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionGuardarAsignacionEstructuraTpmFrppa.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'40%',
	columnas:['90%'],
	
	minWidth:150,minHeight:200,closable:true,titulo: 'Asignacion de Estructura FRPPA',
		grupos:
		[
		{
			tituloGrupo:'Invisible',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Estructura Programatica',	
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Datos de Registro',	
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Validacion de Estructura',	
			columna:0,
			id_grupo:3
		}]}
	}
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_asignacion_estructura=datos.m_id_asignacion_estructura;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_asignacion_estructura:maestro.id_asignacion_estructura
			}
		});
		
		
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]);
		vectorAtributos[3].defecto=maestro.id_asignacion_estructura;
		var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionEliminarAsignacionEstructuraTpmFrppa.php',parametros:'&m_id_asignacion_estructura='+maestro.id_asignacion_estructura},
		Save:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionGuardarAsignacionEstructuraTpmFrppa.php',parametros:'&m_id_asignacion_estructura='+maestro.id_asignacion_estructura},
		ConfirmSave:{url:direccion+'../../../control/asignacion_estructura_tpm_frppa/ActionGuardarAsignacionEstructuraTpmFrppa.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'50%',width:'40%',
		columnas:['90%'],
	
	minWidth:150,minHeight:150,closable:true,titulo: 'Agrupacion de Estructura FRPPA',
		grupos:
		[
		{
			tituloGrupo:'Invisible',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Estructura Programatica',	
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Datos de Registro',	
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Validacion de Estructura',	
			columna:0,
			id_grupo:3
		}]}
	};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		h_txt_fecha_registro = ClaseMadre_getComponente('fecha_registro');
		h_txt_hora_registro = ClaseMadre_getComponente('hora_registro');

		// EVENTOS EP
		combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');


		var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  id;
			combo_actividad.modificado = true;
			combo_regional.setValue('');
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_actividad.setValue('');

		};

		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
		//fin eventos EP
	
	
	}
	
	this.btnNew = function()
	{
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Estructura Programatica');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Validacion de Estructura');
		
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		dialog.resizeTo('40%','70%');
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Estructura a Asignar');
		CM_mostrarGrupo('Datos de Registro');
		CM_mostrarGrupo('Validacion de Estructura');
		get_fecha_bd();
		get_hora_bd();
		componentes[0].disable();
		componentes[1].disable();
		ClaseMadre_btnNew();
	};
	
	this.btnEdit=function()
	{
	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Estructura Programatica');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Validaci�n de Estructura');
		
		
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		dialog.resizeTo('40%','70%');
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Estructura a Asignar');
		CM_mostrarGrupo('Datos de Registro');
		CM_mostrarGrupo('Validaci�n de Estructura');
		componentes[0].disable();
		componentes[1].disable();
		ClaseMadre_btnEdit();
	
	};
	
	function get_fecha_bd()
		{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			})
		}

	 	function cargar_fecha_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(h_txt_fecha_registro.getValue()=="")
				{
					h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
		
				}
			}
		}
		
		
		function get_hora_bd()
		{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
			method:'GET',
			success:cargar_hora_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			})
		}

	 	function cargar_hora_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(h_txt_hora_registro.getValue()=="")
				{
					h_txt_hora_registro.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
			}
		}
	function InitPaginaAsignacionEstructuraFRPPA()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){
		return layout_asignacion_estructura_tpm_frppa.getLayout()
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
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaAsignacionEstructuraFRPPA();
	layout_asignacion_estructura_tpm_frppa.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}