/**
* Nombre:		  	    pagina_existencia_almacen_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 21:00:48
*/
function pagina_kardex_item(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var data_ep;
	var cmb_Item,txt_nombre,txt_descripcion,txt_super_grupo,txt_grupo,txt_sub_grupo,txt_id1;
	var txt_id2,txt_id3,txt_unidad_medida,txt_unidad_medida;


	
	
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
	
	/* ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen/ActionListarAlmacenEP.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
	record: 'ROWS',
	id: 'id_almacen',
	totalRecords: 'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_almacen_ep = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/almacen_ep/ActionListarAlmacenepFisEP.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
	record: 'ROWS',
	id: 'id_almacen_ep',
	totalRecords: 'TotalCount'
	}, ['id_almacen_ep','nombre','descripcion','desc_tipo_almacen'])
	});*/

	/*var ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url: direccion+'../../../../control/almacen/ActionListarAlmacen.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen',
		totalRecords: 'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_item',
		totalRecords: 'TotalCount'
	}, ['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});
*/
	//FUNCIONES RENDER

	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};

	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_ep(value, p, record){return String.format('{0}', record.data['desc_almacen_ep']);}

	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};

	// Definición de datos //
	/////////////////////////
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria

	filterCols_almacen=new Array();
	filterValues_almacen=new Array();

	
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
			editable: true,
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
	
	fC= new Array();
	fV= new Array();
	fC[0]='id_almacen_logico';
	fV[0]='';
 
	
	vectorAtributos[6]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Código Material',
			valueField: 'id_item',
			displayField: 'codigo',
			tipo:'ingreso',//determina el action a llamar
			filterCols:fC,
			filterValues:fV,
			allowBlank:false,
			maxLength:100,
			renderer:render_id_item,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
			width_grid:90,
			width:200,
			pageSize:10,
			grid_indice:1,
			direccion:direccion+'../'
		},
		tipo:'LovItemsAlm',
		save_as:'txt_id_item',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		id_grupo:1
	};

	vectorAtributos[7]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			grid_indice:3,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:true,
		save_as:'txt_nombre',
		filterColValue:'ITEM.nombre',
		id_grupo:1
	};

	vectorAtributos[8]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_descripcion',
		filterColValue:'ITEM.descripcion',
		id_grupo:1
	};

	vectorAtributos[9]= {
		validacion:{
			name:'unidad_medida',
			fieldLabel:'Unidad Medida',
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			disabled:true,
			width:'95%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_unidad_medida',
		id_grupo:1
	};

	vectorAtributos[10]= {
		validacion:{
			name:'nombre_supg',
			fieldLabel:'SuperGrupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:9,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_super_grupo',
		id_grupo:1
	};

	vectorAtributos[11]= {
		validacion:{
			name:'nombre_grupo',
			fieldLabel:'Grupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_grupo',
		id_grupo:1
	};

	vectorAtributos[12]= {
		validacion:{
			name:'nombre_subg',
			fieldLabel:'SubGrupo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:11,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_sub_grupo',
		id_grupo:1
	};

	vectorAtributos[13]= {
		validacion:{
			name:'nombre_id1',
			fieldLabel:'Identificador 1',
			grid_visible:true,
			grid_editable:false,
			grid_indice:12,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id1',
		id_grupo:1
	};

	vectorAtributos[14]= {
		validacion:{
			name:'nombre_id2',
			fieldLabel:'Identificador 2',
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id2',
		id_grupo:1
	};

	vectorAtributos[15]= {
		validacion:{
			name:'nombre_id3',
			fieldLabel:'Identificador 3',
			grid_visible:true,
			grid_editable:false,
			grid_indice:14,
			disabled:true,
			width:'100%'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id3',
		id_grupo:1
	};

	vectorAtributos[16]={
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

	vectorAtributos[17]={
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

vectorAtributos[18]={
		validacion:{
			labelSeparator:'',
			name:'codigo_ep',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'codigo_ep'
	};
vectorAtributos[19]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion'
	};	

	vectorAtributos[20]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti'
	};	

    vectorAtributos[21]= {
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo de Reporte',
			emptyText:'Elija el tipo...',
			allowBlank:true,
			typeAhead: false,
			lazyRender: true,
			forceSelection: true,
			mode: 'local',
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['atributo', 'valor'],data : Ext.kardex_item_combo.tipoReporte}),
			store: new Ext.data.SimpleStore({fields: ['atributo', 'valor'],data : [
			                                                                       ['1','Completo'],
			                                                                       ['2','Cantidades'],
			                                                                       ['3','Costos']

			                                                                  ]}),
			valueField:'atributo',
			displayField:'valor',
			width: 120,
			minChars : 0
		},
		tipo:'ComboBox',
		save_as:'tipo_reporte',
		defecto:1,
		id_grupo:0
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
		titulo_maestro:'Existencia de Almacenes'

	};
	layout_existencia_almacen=new DocsLayoutProceso(idContenedor);
	layout_existencia_almacen.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_existencia_almacen,idContenedor);

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
		var titulo = "Existencias de Almacen";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/kardex_item/ActionPDFKardexItemA.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'70%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Almacen',
		grupos:[
		{	tituloGrupo:'Almacen',
		columna:0,
		id_grupo:0
		},
		{	tituloGrupo:'Kardex Item',
		columna:0,
		id_grupo:1
		}



		]}};





		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
		function iniciarEventosFormularios(){
			//para iniciar eventos en el formulario
			//combo_almacen = ClaseMadre_getComponente('id_almacen');
			cmb_Item=ClaseMadre_getComponente('id_item');
			cmbEp=ClaseMadre_getComponente('id_ep');
		    cmbAlmacen = ClaseMadre_getComponente('id_almacen');
		    cmbAlmacenLogico = ClaseMadre_getComponente('id_almacen_logico');
		    cmbGestion=ClaseMadre_getComponente('id_parametro_almacen');
		    
			txt_nombre=ClaseMadre_getComponente('nombre');
			txt_descripcion=ClaseMadre_getComponente('descripcion');
			txt_super_grupo=ClaseMadre_getComponente('nombre_supg');
			txt_grupo=ClaseMadre_getComponente('nombre_grupo');
			txt_sub_grupo=ClaseMadre_getComponente('nombre_subg');
			txt_id1=ClaseMadre_getComponente('nombre_id1');
			txt_id2=ClaseMadre_getComponente('nombre_id2');
			txt_id3=ClaseMadre_getComponente('nombre_id3');
			txt_unidad_medida=ClaseMadre_getComponente('unidad_medida');
			
			txt_desc_almacen=ClaseMadre_getComponente('desc_almacen');
			txt_desc_almacen_logico=ClaseMadre_getComponente('desc_almacen_logico');
			
			dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		    dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');
		    
		    txt_desc_almacen=ClaseMadre_getComponente('desc_almacen');
		    txt_desc_almacen_logico=ClaseMadre_getComponente('desc_almacen_logico');
		    codigo_ep=ClaseMadre_getComponente('codigo_ep');
		    
		    gestion=ClaseMadre_getComponente('gestion');
		    id_fina_regi_prog_proy_acti=ClaseMadre_getComponente('id_fina_regi_prog_proy_acti');
		    
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
			id_fina_regi_prog_proy_acti.setValue(ep['id_fina_regi_prog_proy_acti']);
			
			codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));
			//alert(codigo_ep.getValue());
			
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
			if(cmbAlmacenLogico.store.getById(id)!=undefined){
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
				gestion.setValue(cmbGestion.store.getById(id).data.gestion);
			}
		};
		cmbEp.on('change',onEpSelect)
		
	    cmbAlmacen.on('select',onAlmacenSelect);
		cmbAlmacenLogico.on('select',onAlmacenLogicoSelect);
		cmbGestion.on('select',onGestionSelect);

		

			var onItemSelect=function(e){
				rec=cmb_Item.lov.getSelect();
				txt_nombre.setValue(rec["nombre"]);
				txt_descripcion.setValue(rec["descripcion"]);
				txt_super_grupo.setValue(rec["nombre_supg"]);
				txt_grupo.setValue(rec["nombre_grupo"]);
				txt_sub_grupo.setValue(rec["nombre_subg"]);
				txt_id1.setValue(rec["nombre_id1"]);
				txt_id2.setValue(rec["nombre_id2"]);
				txt_id3.setValue(rec["nombre_id3"]);
				//txt_unidad_medida.setValue(rec["nombre_unid_base"]);
			};

			

			cmb_Item.on('change',onItemSelect);
			//combo_almacen.on('select',onAlmacenSelect);
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
