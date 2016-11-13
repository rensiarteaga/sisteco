/**
 * Nombre:		  	    pagina_envio_alerta_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 09:09:12
 */
function pagina_envio_alerta(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/envio_alerta/ActionListarEnvioAlerta.php?txt_usuario=0'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_envio_alerta',
			totalRecords: 'TotalCount'

		}, [
			'id_envio_alerta',
			'nombre_alerta',
			'prioridad',
			'titulo_mensaje',
			'mensaje',
			{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
			'hora_registro',
			{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
			'hora_ultima_modificacion'
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

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_envio_alerta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_envio_alerta',
		id_grupo:0
	};
	 
// txt nombre_alerta
	vectorAtributos[1]= {
		validacion:{
			name:'nombre_alerta',
			fieldLabel:'Nombre De Alerta',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.nombre_alerta',
		save_as:'txt_nombre_alerta',
		id_grupo:1
	};
	
// txt prioridad
	vectorAtributos[2]= {
			validacion: {
			name:'prioridad',
			fieldLabel:'Prioridad De Alerta',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.envio_alerta_combo.prioridad
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
		filterColValue:'ENVALE.prioridad',
		defecto:'baja',
		save_as:'txt_prioridad',
		id_grupo:1
	};
	
// txt titulo_mensaje
	vectorAtributos[3]= {
		validacion:{
			name:'titulo_mensaje',
			fieldLabel:'Titulo de Mensaje',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.titulo_mensaje',
		save_as:'txt_titulo_mensaje',
		id_grupo:1
	};
	
// txt mensaje
	vectorAtributos[4]= {
		validacion:{
			name:'mensaje',
			fieldLabel:'Mensaje',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.mensaje',
		save_as:'txt_mensaje',
		id_grupo:1
	};
	
// txt fecha_registro
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};
	
// txt hora_registro
	vectorAtributos[6]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};
	
// txt fecha_ultima_modificacion
	vectorAtributos[7]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificacion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[8]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificacion',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
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
		titulo_maestro:'envio_alerta',
		grid_maestro:'grid-'+idContenedor
	};
	layout_envio_alerta=new DocsLayoutMaestro(idContenedor);
	layout_envio_alerta.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_envio_alerta,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/envio_alerta/ActionEliminarEnvioAlerta.php'},
		Save:{url:direccion+'../../../control/envio_alerta/ActionGuardarEnvioAlerta.php'},
		ConfirmSave:{url:direccion+'../../../control/envio_alerta/ActionGuardarEnvioAlerta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',
		width:'40%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'Alertas a Enviar',
		grupos:[
		{
			tituloGrupo:'Invisible',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Datos de Alerta',
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
		
		]
		}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_metaproceso_envio_alerta(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_envio_alerta='+SelectionsRecord.data.id_envio_alerta;
			data=data+'&m_nombre_alerta='+SelectionsRecord.data.nombre_alerta;
			data=data+'&m_titulo_mensaje='+SelectionsRecord.data.titulo_mensaje;
			data=data+'&m_mensaje='+SelectionsRecord.data.mensaje;

			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_envio_alerta.loadWindows(direccion+'../../../vista/metaproceso_envio_alerta/metaproceso_envio_alerta_det.php?'+data,'Metaproceso Envio Alerta',ParamVentana);
			layout_envio_alerta.getVentana().on('resize',function(){
			layout_envio_alerta.getLayout().layout();
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		h_txt_fecha_registro= ClaseMadre_getComponente('fecha_registro');
		h_txt_hora_registro= ClaseMadre_getComponente('hora_registro');
		h_txt_fecha_ultima_modificacion= ClaseMadre_getComponente('fecha_ultima_modificacion');
		h_txt_hora_ultima_modificacion= ClaseMadre_getComponente('hora_ultima_modificacion');
	}
	
	
		function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_fecha_bd(resp){
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
		
		
		function get_hora_bd(){
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
		
	
	
	this.btnNew = function()
	{
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Alertas');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
				
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		dialog.resizeTo('40%','60%');
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Alertas');
		CM_mostrarGrupo('Datos de Registro');
		componentes[4].disable();
		componentes[5].disable();
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnNew()
	};
		
	this.btnEdit=function()
	{
	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Usuario');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
				
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//		dialog.resizeTo('40%','60%');
//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Usuario');
		CM_mostrarGrupo('Datos de Modificaciones');
		componentes[6].disable();
		componentes[7].disable();
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit()
	};
		
		
	function InitPaginaEnvioAlerta()
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

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_envio_alerta.getLayout();};
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

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Alertas a Metaprocesos',btn_metaproceso_envio_alerta,true,'metaproceso_envio_alerta','Metaproceso Envio Alerta');

				this.iniciaFormulario();
				iniciarEventosFormularios();
 				InitPaginaEnvioAlerta();
				layout_envio_alerta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}