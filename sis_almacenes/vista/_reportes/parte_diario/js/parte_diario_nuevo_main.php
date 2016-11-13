//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new pagina_parte_diario(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_parte_diario_main.js
* Propósito: 			pagina objeto principal
* Autor:				RCM
* Fecha creación:		25/08/2008
*/
function pagina_parte_diario(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;

	//DATA STORE's
	var ds_parametro_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro_almacen/ActionListarParametroAlmacen.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro_almacen',totalRecords: 'TotalCount'}, ['id_parametro_almacen','cierre','gestion','estado'])});
	var ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen/ActionListarAlmacenEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_almacen',totalRecords: 'TotalCount'}, ['id_almacen','nombre','descripcion'])});
	var ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen_logico/ActionListarAlmacenLogicoFisEPM.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_almacen_logico',totalRecords: 'TotalCount'}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])});


	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};

	var resultTplParAlm = new Ext.Template('<div class="search-item">','<b>Gestión: {gestion}</b>','<br><FONT COLOR="#B5A642">Estado: {estado}</FONT>','</div>');
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');


	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gestión',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión...',
			name:'id_parametro_almacen',
			desc:'gestion',
			store:ds_parametro_almacen,
			valueField:'id_parametro_almacen',
			displayField:'gestion',
			filterCol:'PARALM.gestion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParAlm,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			//renderer:renderParAlm,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:0
		},
		tipo:'ComboBox',
		save_as:'txt_id_parametro_almacen',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha desde',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_desde',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha hasta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};

	vectorAtributos[3]= {
		validacion:{
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:14,
			width:300
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:1
	}

	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	vectorAtributos[4]= {
		validacion: {
			fieldLabel:'Almacén Físico',
			allowBlank:true,
			emptyText:'Almacén Físico...',
			name: 'id_almacen',
			desc: 'desc_almacen',
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.nombre',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMACE.nombre',
		defecto: '',
		save_as:'txt_id_almacen',
		id_grupo:1
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';
	vectorAtributos[5]= {
		validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:false,
			emptyText:'Almacén Lógico...',
			name: 'id_almacen_logico',
			desc: 'desc_almacen_logico',
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:1
	};

	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'id_financiador',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_financiador'
	};

	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'id_regional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_regional'
	};

	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'id_programa',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_programa'
	};

	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'id_proyecto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_proyecto'
	};

	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			name:'id_actividad',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_actividad'
	};
	
	vectorAtributos[11]={
		validacion:{
			labelSeparator:'',
			name:'desc_almacen',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_desc_almacen'
	};
	
	vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name:'desc_almacen_logico',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_desc_almacen_logico'
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
	//Inicia Layout
	var config={
		titulo_maestro:'Movimiento Físico de Almacén'

	};
	layout=new DocsLayoutProceso(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Movimiento Físico de Almacén";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/parte_diario/ActionParteDiarioNuevo.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'70%',
		columnas:['47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Parte Diario',
		grupos:[
		{tituloGrupo:'Fechas',columna:0,id_grupo:0},
		{tituloGrupo:'Almacén',columna:0,id_grupo:1}
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		cmbEp=ClaseMadre_getComponente('id_ep');
		cmbAlmacen = ClaseMadre_getComponente('id_almacen');
		cmbAlmacenLogico = ClaseMadre_getComponente('id_almacen_logico');
		cmbGestion=ClaseMadre_getComponente('id_parametro_almacen');
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
		txt_id_financiador=ClaseMadre_getComponente('id_financiador');
		txt_id_regional=ClaseMadre_getComponente('id_regional');
		txt_id_programa=ClaseMadre_getComponente('id_programa');
		txt_id_proyecto=ClaseMadre_getComponente('id_proyecto');
		txt_id_actividad=ClaseMadre_getComponente('id_actividad');
		txt_desc_almacen=ClaseMadre_getComponente('desc_almacen');
		txt_desc_almacen_logico=ClaseMadre_getComponente('desc_almacen_logico');

		var onEpSelect = function(e){
			var ep=cmbEp.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			cmbAlmacen.setValue('');
			cmbAlmacenLogico.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			cmbAlmacen.modificado=true;
			cmbAlmacenLogico.modificado=true;
			//Carga los datos en variables ocultas
			txt_id_financiador.setValue(ep['id_financiador']);
			txt_id_regional.setValue(ep['id_regional']);
			txt_id_programa.setValue(ep['id_programa']);
			txt_id_proyecto.setValue(ep['id_proyecto']);
			txt_id_actividad.setValue(ep['id_actividad']);
		};

		var onAlmacenSelect = function(e) {
			var id = cmbAlmacen.getValue();
			//alert(id);
			if(id=='') id='x';
			cmbAlmacenLogico.filterValues[0] =  id;
			cmbAlmacenLogico.modificado = true;
			cmbAlmacenLogico.setValue('');
			cmbAlmacenLogico.modificado=true;
			
			//Obtiene la descripción del almacén
			if(cmbAlmacen.store.getById(id)!=undefined){
				txt_desc_almacen.setValue(cmbAlmacen.store.getById(id).data.nombre);
			}
		};
		
		var onAlmacenLogicoSelect = function(e) {
			var id = cmbAlmacenLogico.getValue();
			
			//Obtiene la descripción del almacén
			if(cmbAlmacen.store.getById(id)!=undefined){
				txt_desc_almacen_logico.setValue(cmbAlmacenLogico.store.getById(id).data.nombre);
			}
		};
		
		var onGestionSelect = function(e) {
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined){
				intGestion=cmbGestion.store.getById(id).data.gestion;
			
				//Define límites de la fecha
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				
				//Instancia un objeto fecha con los datos obtenidos para que el DateFIeld los acepte sin problema
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				dteFechaDesde.minValue=dte_fecha_ini_valid;
				dteFechaDesde.maxValue=dte_fecha_fin_valid;
				dteFechaHasta.minValue=dte_fecha_ini_valid;
				dteFechaHasta.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				dteFechaDesde.setValue(dte_fecha_ini_valid);
				dteFechaHasta.setValue(dte_fecha_fin_valid);
			}
		};
		
		cmbEp.on('change',onEpSelect)
		cmbAlmacen.on('select',onAlmacenSelect);
		cmbAlmacenLogico.on('select',onAlmacenLogicoSelect);
		cmbGestion.on('select',onGestionSelect);
	}
	
	function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep));
		Ext.apply(cmbAlmacen.store.baseParams,datos);
		Ext.apply(cmbAlmacenLogico.store.baseParams,datos)
	}

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
