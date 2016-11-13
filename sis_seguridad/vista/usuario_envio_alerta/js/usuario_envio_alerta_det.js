/**
 * Nombre:		  	    pagina_usuario_envio_alerta_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:40:58
 */
function pagina_usuario_envio_alerta_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	var m=0;
	var num_registros=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_envio_alerta/ActionListarUsuarioEnvioAlerta_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario_envio_alerta',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_usuario_envio_alerta',
			'id_usuario',
			'desc_usuario',
			'desc_envio_alerta',
			'id_envio_alerta'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_usuario:maestro.id_usuario,
			txt_envio_alerta:1
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Usuario',maestro.apellido_paterno],['Cuenta',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_envio_alerta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/envio_alerta/ActionListarEnvioAlerta.php?txt_usuario='+maestro.id_usuario}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_envio_alerta',
			totalRecords: 'TotalCount'
		}, ['id_envio_alerta','nombre_alerta','prioridad','titulo_mensaje','mensaje','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_envio_alerta(value, p, record){return String.format('{0}', record.data['desc_envio_alerta']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_envio_alerta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_envio_alerta',
		id_grupo:0
	};
	 
// txt id_usuario
	vectorAtributos[1]= {
		validacion:{
			name:'id_usuario',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_usuario,
		save_as:'txt_id_usuario',
		id_grupo:0
	};
	
// txt id_envio_alerta
	vectorAtributos[2]= {
			validacion: {
			name:'id_envio_alerta',
			fieldLabel:'Alerta Enviada',
			allowBlank:false,			
			emptyText:'Alerta a Enviar...',
			desc: 'desc_envio_alerta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_envio_alerta,
			valueField: 'id_envio_alerta',
			displayField: 'nombre_alerta',
			queryParam: 'filterValue_0',
			filterCol:'ENVALE.nombre_alerta#ENVALE.titulo_mensaje#ENVALE.mensaje',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_envio_alerta,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ENVALE.nombre_alerta',
		defecto: '',
		save_as:'txt_id_envio_alerta',
		id_grupo:1
	};
	

	vectorAtributos[3] = {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:10000,
			minLength:0,
			selectOnFocus:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'RROOLL.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Usuarios (Maestro)',
		titulo_detalle:'Usuario Envio Alerta (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_usuario_envio_alerta = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_usuario_envio_alerta.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_usuario_envio_alerta,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/usuario_envio_alerta/ActionEliminarUsuarioEnvioAlerta.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/usuario_envio_alerta/ActionGuardarUsuarioEnvioAlerta.php',parametros:'&m_id_usuario='+maestro.id_usuario,
	success:miFuncionSuccess},
	ConfirmSave:{url:direccion+'../../../control/usuario_envio_alerta/ActionGuardarUsuarioEnvioAlerta.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
		width:'40%',
		columnas:['95%'],
		minWidth:150,minHeight:200,closable:true,grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Alertas',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Detalle Alerta',
				columna:0,
				id_grupo:2}]}
	};
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_usuario=datos.m_id_usuario;
		maestro.id_persona=datos.m_id_persona;
		maestro.apellido_paterno=datos.m_apellido_paterno;
		maestro.apellido_materno=datos.m_apellido_materno;
		maestro.nombre= datos.m_nombre;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_usuario:maestro.id_usuario,
				txt_envio_alerta:1
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Usuario',maestro.apellido_paterno],['Cuenta',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]);
		vectorAtributos[1].defecto=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/usuario_envio_alerta/ActionEliminarUsuarioEnvioAlerta.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			Save:{url:direccion+'../../../control/usuario_envio_alerta/ActionGuardarUsuarioEnvioAlerta.php',parametros:'&m_id_usuario='+maestro.id_usuario,
			success:miFuncionSuccess},
			ConfirmSave:{url:direccion+'../../../control/usuario_envio_alerta/ActionGuardarUsuarioEnvioAlerta.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
			width:'40%',
			columnas:['95%'],
			minWidth:150,minHeight:200,closable:true,grupos:[{
						tituloGrupo:'Invisible',
						columna:0,
						id_grupo:0},
						{
						tituloGrupo:'Datos de Alertas',
						columna:0,
						id_grupo:1},
						{
						tituloGrupo:'Detalle Alerta',
						columna:0,
						id_grupo:2}]}
			};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function miFuncionSuccess(resp){
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_envio_alerta').modificado=true
	}
	
	this.btnNew = function(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('45%','60%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Alertas');
		CM_ocultarGrupo('Detalle Alerta');
		ClaseMadre_btnNew()
	};
	this.btnEdit = function(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('45%','60%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Alertas');
		CM_ocultarGrupo('Detalle Alerta');
		ClaseMadre_btnEdit()
	};
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	    combo_envio_alerta= ClaseMadre_getComponente('id_envio_alerta');
		h_descripcion= ClaseMadre_getComponente('descripcion');
		variable=ClaseMadre_getComponente('descripcion');
		h_descripcion1=ClaseMadre_getComponente('descripcion');
		
		function get_datos_alertas(){
			m=0;
			num_registros=0;
			var postData;
			h_descripcion1="";
			if(combo_envio_alerta.getValue() == undefined || combo_envio_alerta.getValue() == null || combo_envio_alerta.getValue() == ""){
				  postData = "CantFiltros=1&filterCol_0=id_envio_alerta&filterValue_0="+combo_envio_alerta.getValue()
			}
			else{
			  	  postData = "CantFiltros=1&filterCol_0=MEENAL.id_envio_alerta&filterValue_0="+combo_envio_alerta.getValue()
			}
			Ext.Ajax.request({url:'../../../sis_seguridad/control/metaproceso_envio_alerta/ActionListarMetaprocesoEnvioAlerta_det.php?m_id_envio_alerta='+combo_envio_alerta.getValue(),
			params: postData,
			method:'POST',
			success:cargar_alertas_data,
			failure:ClaseMadre_conexionFailure,
			timeout:100000})
		}

		function cargar_alertas_data(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				num_registros= root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				 while(m<num_registros){
						variable.setValue(root.getElementsByTagName('desc_metaproceso')[m].firstChild.nodeValue);
						h_descripcion1 = h_descripcion1 + variable.getValue()+"                                                                                        ";
						m=m+1
					}
						if(h_descripcion1!=""){
							h_descripcion.setValue(h_descripcion1);			
							CM_mostrarGrupo('Detalle Alerta');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				}
		}

		combo_envio_alerta.on('select',get_datos_alertas);
		combo_envio_alerta.on('change', get_datos_alertas);
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_usuario_envio_alerta.getLayout()
	};

function InitPaginaUsuarioEnvioAlerta()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
	}

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
	InitPaginaUsuarioEnvioAlerta();
	layout_usuario_envio_alerta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}