/**
 * Nombre:		  	    pagina_asignacion_estructura_main.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-10-31 11:34:02
 */
function pagina_asignacion_estructura(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var grid;
	var dialog;
	var formulario;
	var componentes=new Array();
	var bandera=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asignacion_estructura/ActionListarAsignacionEstructura.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_asignacion_estructura',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_asignacion_estructura',
		'nombre',
		'descripcion',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'validar_estructura'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_asignacion_estructura
	//en la posici�n 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_asignacion_estructura',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_asignacion_estructura',
		id_grupo:0
	};
	
// txt nombre
	vectorAtributos[1]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			vtype:"texto",
			width:'65%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.nombre',
		save_as:'txt_nombre',
		id_grupo:1
	};
	
// txt descripcion
	vectorAtributos[2]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			vtype:"texto",
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.descripcion',
		save_as:'txt_descripcion',
		id_grupo:1
	};
	
// txt fecha_registro
	vectorAtributos[3]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			vtype:"texto",
			width:'65%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};
	
// txt hora_registro
	vectorAtributos[4]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			vtype:"texto",
			width:'65%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};
	
// txt fecha_ultima_modificacion
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificaci�n',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			vtype:"texto",
			width:'65%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[6]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificacion',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'65%',
			vtype:"texto"
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
	};
	
// txt validar_estructura
	vectorAtributos[7]= {
			validacion: {
			name:'validar_estructura',
			fieldLabel:'Validar Estructura',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data :  [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60, // ancho de columna en el gris
			width: '100%',
			vtype:"texto"
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.validar_estructura',
		defecto:'si',
		save_as:'txt_validar_estructura',
		id_grupo:1
	};
	
	
	
	// txt fecha_ultima_modificacion
	vectorAtributos[8]= {
		validacion:{
			name:'fecha_ultima_modificacion1',
			fieldLabel:'Fecha Ultima Modificacion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			vtype:"texto",
			width:'65%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion1',
		id_grupo:0
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[9]= {
		validacion:{
			name:'hora_ultima_modificacion1',
			fieldLabel:'Hora Ultima Modificacion',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'65%',
			vtype:"texto"
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion1',
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
	var config = {
		titulo_maestro:'asignacion_estructura',
		grid_maestro:'grid-'+idContenedor
	};
	layout_asignacion_estructura=new DocsLayoutMaestro(idContenedor);
	layout_asignacion_estructura.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_asignacion_estructura,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
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
	var CM_saveSuccess= this.saveSuccess;

	///////////////////////////////////
	// DEFINICI�N DE LA BARRA DE MEN�//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/asignacion_estructura/ActionEliminarAsignacionEstructura.php'},
		Save:{url:direccion+'../../../control/asignacion_estructura/ActionGuardarAsignacionEstructura.php'},
		ConfirmSave:{url:direccion+'../../../control/asignacion_estructura/ActionGuardarAsignacionEstructura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'45%',
		width:'40%',
			minWidth:150,minHeight:200,	closable:true,titulo:'Asignacion de Estructura',
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos de Estructura a Asignar',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos de Registro',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos de Modificaciones',
				columna:0,
				id_grupo:3
			}
			
		
			]}};
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
	
	function miFuncionSuccess(resp)
	{
		if(bandera=1){
			CM_saveSuccess(resp);
			get_fecha_bd();
			get_hora_bd();
			bandera=0
		}
		else{
			CM_saveSuccess(resp)
		}
	}
	
	
	this.btnNew = function()
	{
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Estructura a Asignar');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
		
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		dialog.resizeTo('40%','60%');
		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Estructura a Asignar');
		CM_mostrarGrupo('Datos de Registro');
		
		componentes[2].disable();
		componentes[3].disable();
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnNew()
	};
		
	this.btnEdit=function()
	{
	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Estructura a Asignar');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
		
		if(componentes[2].getValue()!=""){
			CM_mostrarGrupo('Datos de Modificaciones');
		}
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		dialog.resizeTo('40%','60%');
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Estructura a Asignar');
		get_fecha_bd();
		get_hora_bd();
		componentes[4].disable();
		componentes[5].disable();
		ClaseMadre_btnEdit()
		
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
			
				}else{
					h_txt_fecha_ultima_modificacion.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
				
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
			
							
				}else{
				
					h_txt_hora_ultima_modificacion.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				
				}
			}
		}
	
		function InitPaginaAsignacionEstructura()
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
	
	function btn_asignacion_estructura_tpm_frppa(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_asignacion_estructura='+SelectionsRecord.data.id_asignacion_estructura;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={ventana:{width:'80%',height:'70%'}}
			layout_asignacion_estructura.loadWindows(direccion+'../../../vista/asignacion_estructura_tpm_frppa/asignacion_estructura_tpm_frppa_det.php?'+data,'Agrupacion Estructura FRPPA',ParamVentana);
			layout_asignacion_estructura.getVentana().on('resize',function(){
			layout_asignacion_estructura.getLayout().layout()
			})
		}
		else
		{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		h_txt_fecha_registro = ClaseMadre_getComponente('fecha_registro');
		h_txt_fecha_ultima_modificacion = ClaseMadre_getComponente('fecha_ultima_modificacion');
		h_txt_hora_registro = ClaseMadre_getComponente('hora_registro');
		h_txt_hora_ultima_modificacion = ClaseMadre_getComponente('hora_ultima_modificacion');
		
		
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_asignacion_estructura.getLayout();};
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
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_asignacion_estructura_tpm_frppa,true,'asignacion_estructura_tpm_frppa','Asignacion Estructura FRPPA');

				this.iniciaFormulario();
				iniciarEventosFormularios();
				InitPaginaAsignacionEstructura();
				get_fecha_bd();
				get_hora_bd();
				layout_asignacion_estructura.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}