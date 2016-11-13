/**
 * Nombre:		  	    pagina_subactividad_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-24 18:28:46
 */
function pagina_subactividad(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subactividad/ActionListarSubactividad.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subactividad',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_subactividad',
			'codigo',
			'direccion',
			'descripcion',
			'observaciones',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
			'desc_programa_proyecto_actividad',
			'id_prog_proy_acti'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    ds_programa_proyecto_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/programa_proyecto_actividad/ActionListarProgramaProyectoActividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, ['id_prog_proy_acti','id_programa','id_proyecto','id_actividad','desc_prog_proy_acti'])
	});

	//FUNCIONES RENDER
	
	function render_id_prog_proy_acti(value, p, record){return String.format('{0}', record.data['desc_programa_proyecto_actividad']);}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_subactividad',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_subactividad',
		id_grupo:0
	};
	 
// txt codigo
	vectorAtributos[1]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			width:'60%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.codigo',
		save_as:'txt_codigo',
		id_grupo:1
	};
	
// txt direccion
	vectorAtributos[2]= {
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'80%',
			grid_editable:true,
			width_grid:150
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.direccion',
		save_as:'txt_direccion',
		id_grupo:1
	};
	
// txt descripcion
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.descripcion',
		save_as:'txt_descripcion',
		id_grupo:1
	};
	
// txt observaciones
	vectorAtributos[4]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width:'100%',
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};
	
// txt fecha_reg
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			width:'150%',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:3
	};
	
// txt id_prog_proy_acti
	vectorAtributos[6]= {
			validacion: {
			name:'id_prog_proy_acti',
			fieldLabel:'Relación Prog/Proy/Acti',
			allowBlank:false,			
			emptyText:'Prog/Proy/Acti...',
			desc: 'desc_programa_proyecto_actividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_programa_proyecto_actividad,
			valueField: 'id_prog_proy_acti',
			displayField: 'desc_prog_proy_acti',
			queryParam: 'filterValue_0',
			filterCol:'PGPYAC.nombre_programa#PGPYAC.nombre_proyecto#PGPYAC.nombre_actividad',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_prog_proy_acti,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		defecto: '',
		save_as:'txt_id_prog_proy_acti',
		id_grupo:2
	};


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Subactividad',
		grid_maestro:'grid-'+idContenedor
	};
	layout_subactividad=new DocsLayoutMaestro(idContenedor);
	layout_subactividad.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_subactividad,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/subactividad/ActionEliminarSubactividad.php'},
		Save:{url:direccion+'../../../control/subactividad/ActionGuardarSubactividad.php'},
		ConfirmSave:{url:direccion+'../../../control/subactividad/ActionGuardarSubactividad.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',
		width:'45%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'subactividad',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Sub-Actividad',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Relación Prog/Proy/Act',
				columna:0,
				id_grupo:2},
				{
				tituloGrupo:'Datos de Registro',
				columna:0,
				id_grupo:3}
				]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		h_txt_fecha_registro= ClaseMadre_getComponente('fecha_reg')
	}

	function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			})
		}

	 	function cargar_fecha_bd(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
					h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					h_txt_fecha_registro.disable(true)
				}
		}
		
	this.btnNew = function(){	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Sub-Actividad');
		CM_ocultarGrupo('Relación Prog/Proy/Act');
		CM_ocultarGrupo('Datos de Registro');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		dialog.resizeTo('45%','55%');
		var SelectionsRecord  = sm.getSelected();
		get_fecha_bd();
		CM_mostrarGrupo('Datos de Sub-Actividad');
		CM_mostrarGrupo('Relación Prog/Proy/Act');
		CM_mostrarGrupo('Datos de Registro');
		ClaseMadre_btnNew()	
	};
	
	this.btnEdit=function(){ 	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Sub-Actividad');
		CM_ocultarGrupo('Relación Prog/Proy/Act');
		CM_ocultarGrupo('Datos de Registro');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		dialog.resizeTo('45%','55%');	
		CM_mostrarGrupo('Datos de Sub-Actividad');
		CM_mostrarGrupo('Relación Prog/Proy/Act');
		get_fecha_bd();
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaSubActividad(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		var sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_subactividad.getLayout()};
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

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				InitPaginaSubActividad();
				layout_subactividad.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}