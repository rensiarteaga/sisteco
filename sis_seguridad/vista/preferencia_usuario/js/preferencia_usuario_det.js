/**
 * Nombre:		  	    pagina_preferencia_usuario_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 15:55:31
 */
function pagina_preferencia_usuario_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia_usuario/ActionListarPreferenciaUsuario_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_preferencia_usuario',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_preferencia_usuario',
			'id_preferencia',
			'desc_preferencia',
			'desc_usuario',
			'id_usuario'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_usuario:maestro.id_usuario
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Persona: ',maestro.apellido_paterno],['Cuenta: ',maestro.apellido_materno],['fecha_registro',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_preferencia = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia/ActionListarPreferencia.php?txt_usuario='+maestro.id_usuario}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_preferencia',
			totalRecords: 'TotalCount'
		}, ['id_preferencia','nombre_modulo','descripcion_modulo'])
	});

	//FUNCIONES RENDER
	
			function render_id_preferencia(value, p, record){return String.format('{0}', record.data['desc_preferencia']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_preferencia_usuario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_preferencia_usuario',
		id_grupo:0
	};
	 
// txt id_preferencia
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
	
// txt id_usuario
	vectorAtributos[2]= {
			validacion: {
			name:'id_preferencia',
			fieldLabel:'Preferencia',
			allowBlank:false,			
			emptyText:'Preferencia...',
			desc: 'desc_preferencia', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_preferencia,
			valueField: 'id_preferencia',
			displayField: 'nombre_modulo',
			queryParam: 'filterValue_0',
			filterCol:'PREFER.nombre_modulo',
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
			renderer:render_id_preferencia,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PREFER.nombre_modulo',
		defecto: '',
		save_as:'txt_id_preferencia',
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
		titulo_maestro:'Preferencia del Usuario (Maestro)',
		titulo_detalle:'Preferencia Usuario (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_preferencia_usuario = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_preferencia_usuario.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_preferencia_usuario,idContenedor);
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
	btnEliminar:{url:direccion+'../../../control/preferencia_usuario/ActionEliminarPreferenciaUsuario.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/preferencia_usuario/ActionGuardarPreferenciaUsuario.php',parametros:'&m_id_usuario='+maestro.id_usuario,
	success: miFuncionSuccess},
	ConfirmSave:{url:direccion+'../../../control/preferencia_usuario/ActionGuardarPreferenciaUsuario.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
		width:'40%',
		titulo:'Preferencia de Usuario',
		columnas:['95%'],
		minWidth:150,minHeight:200,closable:true,grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Preferencia',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Detalle de Preferencia',
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
				m_id_usuario:maestro.id_usuario
				
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Persona: ',maestro.apellido_paterno],['Cuenta: ',maestro.apellido_materno],['fecha_registro',maestro.nombre]]);
		vectorAtributos[1].defecto=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/preferencia_usuario/ActionEliminarPreferenciaUsuario.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			Save:{url:direccion+'../../../control/preferencia_usuario/ActionGuardarPreferenciaUsuario.php',parametros:'&m_id_usuario='+maestro.id_usuario,
			success: miFuncionSuccess},
			ConfirmSave:{url:direccion+'../../../control/preferencia_usuario/ActionGuardarPreferenciaUsuario.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
				width:'40%',
				titulo:'Preferencia de Usuario',
				columnas:['95%'],
				minWidth:150,minHeight:200,closable:true,grupos:[{
						tituloGrupo:'Invisible',
						columna:0,
						id_grupo:0},
						{
						tituloGrupo:'Datos de Preferencia',
						columna:0,
						id_grupo:1},
						{
						tituloGrupo:'Detalle de Preferencia',
						columna:0,
						id_grupo:2}]}
		};
		this.InitFunciones(paramFunciones)
	};

	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	function miFuncionSuccess(resp)
	{	CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_preferencia').modificado=true
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	   combo_preferencia= ClaseMadre_getComponente('id_preferencia');
		h_descripcion= ClaseMadre_getComponente('descripcion');
		variable=ClaseMadre_getComponente('descripcion');
		h_descripcion1=ClaseMadre_getComponente('descripcion');
				
		function get_datos_preferencia(){
			m=0;
			num_registros=0;
			var postData;
			h_descripcion1="";
			if(combo_preferencia.getValue() == undefined || combo_preferencia.getValue() == null || combo_preferencia.getValue() == ""){
				  postData = "CantFiltros=1&filterCol_0=id_preferencia&filterValue_0="+combo_preferencia.getValue()
			}
			else{
			  	  postData = "CantFiltros=1&filterCol_0=PREDET.id_preferencia&filterValue_0="+combo_preferencia.getValue()
			}
			Ext.Ajax.request({url:'../../../sis_seguridad/control/preferencia_detalle/ActionListarPreferenciaDetalle_det.php?m_id_preferencia='+combo_preferencia.getValue(),
			params: postData,
			method:'POST',
			success:cargar_preferencia_data,
			failure:ClaseMadre_conexionFailure,
			timeout:100000})
		}

		function cargar_preferencia_data(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				num_registros= root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
			  	   while(m<num_registros){
				 		variable.setValue(root.getElementsByTagName('nombre_atributo')[m].firstChild.nodeValue);
						h_descripcion1 = h_descripcion1 + variable.getValue()+"                                                                                        ";
						m=m+1
					}
						if(h_descripcion1!=""){
							h_descripcion.setValue(h_descripcion1);			
							CM_mostrarGrupo('Detalle de Preferencia');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				}
		}

		combo_preferencia.on('select',get_datos_preferencia);
		combo_preferencia.on('change', get_datos_preferencia)
	}
	this.btnNew = function()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('40%','30%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Preferencia');
		CM_ocultarGrupo('Detalle de Preferencia');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit = function()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('40%','30%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Preferencia');
		CM_ocultarGrupo('Detalle de Preferencia');
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaPreferenciaUsuarioDet()
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

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_preferencia_usuario.getLayout()
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
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaPreferenciaUsuarioDet();
	layout_preferencia_usuario.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}