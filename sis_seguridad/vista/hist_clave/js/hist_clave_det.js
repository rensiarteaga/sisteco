/**
 * Nombre:		  	    pagina_hist_clave_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 17:45:49
 */
function pagina_hist_clave_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/hist_clave/ActionListarHistClave_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_hist_clave',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_hist_clave',
			'id_usuario',
			'desc_usuario',
			{name: 'fecha_cambio',type:'date',dateFormat:'Y-m-d'},
			'hora_cambio',
			'contrasenia_anterior'
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
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Usuario',maestro.apellido_paterno],['Cuenta',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_hist_clave',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_hist_clave',
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
	
// txt fecha_cambio
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_cambio',
			fieldLabel:'Fecha Cambio',
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
		filterColValue:'HISCLA.fecha_cambio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_cambio',
		id_grupo:1
	};
	
// txt hora_cambio
	vectorAtributos[3]= {
		validacion:{
			name:'hora_cambio',
			fieldLabel:'Hora Cambio',
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
		filterColValue:'HISCLA.hora_cambio',
		save_as:'txt_hora_cambio',
		id_grupo:1
	};
	
// txt contrasenia_anterior
	vectorAtributos[4]= {
		validacion:{
			name:'contrasenia_anterior',
			fieldLabel:'Contraseña Anterior',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HISCLA.contrasenia_anterior',
		save_as:'txt_contrasenia_anterior',
		id_grupo:2
	};
	

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Usuarios (Maestro)',
		titulo_detalle:'Historico Contrasenia (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_hist_clave = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_hist_clave.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_hist_clave,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_save=this.Save;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/hist_clave/ActionEliminarHistClave.php',parametros:'&m_id_usuario='+maestro.id_usuario},
		Save:{url:direccion+'../../../control/hist_clave/ActionGuardarHistClave.php',parametros:'&m_id_usuario='+maestro.id_usuario},
		ConfirmSave:{url:direccion+'../../../control/hist_clave/ActionGuardarHistClave.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'40%',
			width:'40%',
			columnas:['95%'],
			minWidth:150,minHeight:200,closable:true,grupos:[{	
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
			{
				tituloGrupo:'Datos de Modificación',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Clave',
				columna:0,
				id_grupo:0
			}
		]}
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
		gridMaestro.getDataSource().loadData([['Usuario',maestro.apellido_paterno],['Cuenta',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]);
		vectorAtributos[1].defecto=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/hist_clave/ActionEliminarHistClave.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			Save:{url:direccion+'../../../control/hist_clave/ActionGuardarHistClave.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			ConfirmSave:{url:direccion+'../../../control/hist_clave/ActionGuardarHistClave.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'40%',
				width:'40%',
			columnas:['95%'],
			
			minWidth:150,minHeight:200,closable:true,grupos:[
			{	tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos de Modificación',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Clave',
				columna:0,
				id_grupo:0
			}
			]}
		};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	h_txt_fecha_cambio= ClaseMadre_getComponente('fecha_cambio');
		h_txt_hora_cambio= ClaseMadre_getComponente('hora_cambio')
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
					h_txt_fecha_cambio.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					h_txt_fecha_cambio.disable(true)
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

	 	function cargar_hora_bd(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
					h_txt_hora_cambio.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
					h_txt_hora_cambio.disable(true)
				}
		}
	
	this.btnEdit = function(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Modificación');
		CM_mostrarGrupo('Clave');
		dialog.resizeTo('40%','40%');
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit()
	};
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_hist_clave.getLayout()
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
	
	function InitPaginaHistClave()
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
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaHistClave();
	layout_hist_clave.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}