/**
 * Nombre:		  	    pagina_usuario_rol_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 17:44:32
 */
function pagina_usuario_rol_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_rol/ActionListarUsuarioRol_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario_rol',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_usuario_rol',
			'id_rol',
			'desc_rol',
			'desc_usuario',
			'id_usuario'
			,'descripcion',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
			'estado_reg',
			{name: 'fecha_inactivacion',type:'date',dateFormat:'Y-m-d'},'usuario_reg'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_usuario:maestro.id_usuario,
				txt_rol:1//bandera que sirve para listar roles que no han sido asignados al usuario
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Usuario ',maestro.apellido_paterno],['Cuenta',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_rol = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rol/ActionListarRol_det.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_rol',
			totalRecords: 'TotalCount'
		}, ['id_rol','nombre','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion'])
	});

	//FUNCIONES RENDER
	
	function render_id_rol(value, p, record){return String.format('{0}', record.data['desc_rol']);};
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_rol',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_rol',
		id_grupo:0
	};
	 
// txt id_rol
	vectorAtributos[1]= {
		validacion: {
			name:'id_rol',
			fieldLabel:'Rol',
			allowBlank:false,			
			emptyText:'Id Rol...',
			desc: 'desc_rol', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rol,
			valueField: 'id_rol',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'RROOLL.nombre',
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:450,
			grow:true,
			width:350,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_rol,
			grid_visible:true,
			grid_editable:true,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROLL.nombre',
		defecto: '',
		save_as:'txt_id_rol',
		id_grupo:1
	};
	
// txt id_usuario
	vectorAtributos[2]= {
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
	

	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000000,
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
		filterColValue:'RROLL.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
	};
	
	vectorAtributos[5]= {
			validacion:{
				name:'estado_reg',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : [['activo','Activo'],['inactivo','Inactivo']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				align:'center',
				grid_editable:false,
				width_grid:90, // ancho de columna en el gris
				width:'50%'
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto:'activo',
			filterColValue:'USUROL.estado_reg',
			save_as:'estado_reg',
			id_grupo:0
		};

	vectorAtributos[4]= {
	validacion:{
		name:'usuario_reg',
		labelSeparator:'',
		fieldLabel:'Usuario Registro',
		grid_visible:true,
		grid_editable:false,
		disabled:true
	},
	tipo:'Field',
	filtro_0:false,
	//defecto:maestro.id_usuario,
	save_as:'txt_usuario_reg',
	id_grupo:0
};


	vectorAtributos[6]= {
			validacion:{
				name:'fecha_reg',
				label:'Fecha Registro',
				labelSeparator:'',
				format: 'd/m/Y',
				renderer: formatDate,
				grid_visible:true,
				grid_editable:false,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			save_as:'txt_fecha_reg',
			id_grupo:0
		};



	vectorAtributos[7]= {
			validacion:{
				name:'fecha_inactivacion',
				label:'Fecha Inactivación',
				labelSeparator:'',
				format: 'd/m/Y',
				renderer: formatDate,
				grid_visible:true,
				grid_editable:false,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			save_as:'fecha_inactivacion',
			id_grupo:0
		};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Usuarios (Maestro)',
		titulo_detalle:'Usuario Rol (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_usuario_rol = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_usuario_rol.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_usuario_rol,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_saveSuccess=this.saveSuccess;
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
	btnEliminar:{url:direccion+'../../../control/usuario_rol/ActionEliminarUsuarioRol.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/usuario_rol/ActionGuardarUsuarioRol.php',parametros:'&m_id_usuario='+maestro.id_usuario,
	success:miFuncionSuccess
	},
	ConfirmSave:{url:direccion+'../../../control/usuario_rol/ActionGuardarUsuarioRol.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',
		width:'45%',columnas:['95%'],
		minWidth:150,minHeight:200,closable:true,titulo: 'Roles de Usuario',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Rol',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Privilegios Rol',
				columna:0,
				id_grupo:2}]
			
	}
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
				txt_rol:1//bandera que sirve para listar roles que no han sido asignados al usuario
			}
		});
		ClaseMadre_getComponente('id_rol').store.baseParams.txt_usuario=maestro.id_usuario;
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Usuario ',maestro.apellido_paterno],['Cuenta', maestro.apellido_materno],['Fecha Registro',maestro.nombre]]);
		vectorAtributos[2].defecto=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/usuario_rol/ActionEliminarUsuarioRol.php',parametros:'&m_id_usuario='+maestro.id_usuario},
			Save:{url:direccion+'../../../control/usuario_rol/ActionGuardarUsuarioRol.php',parametros:'&m_id_usuario='+maestro.id_usuario,
			success:miFuncionSuccess
			},
		ConfirmSave:{url:direccion+'../../../control/usuario_rol/ActionGuardarUsuarioRol.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',
					width:'45%',columnas:['95%'],
					minWidth:150,minHeight:200,closable:true,titulo: 'Roles de Usuario',
					grupos:[{
						tituloGrupo:'Invisible',
						columna:0,
						id_grupo:0
					},
					{
						tituloGrupo:'Datos de Rol',
						columna:0,
						id_grupo:1
					},
					{
						tituloGrupo:'Privilegios Rol',
						columna:0,
						id_grupo:2
					}]
			}
	   };
	   iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function miFuncionSuccess(resp){
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_rol').modificado=true
	}
	
	this.btnNew = function(){
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//
//		var SelectionsRecord  = sm.getSelected();
//		var limpiar = sm.purgeListeners();
		
		dialog.resizeTo('45%','60%');
		ClaseMadre_getComponente('id_rol').modificado=true;
		
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Rol');
		CM_ocultarGrupo('Privilegios Rol');
		ClaseMadre_btnNew()
	};
	
	
	this.btnEdit = function()
	{	ds_rol.modificado=true;
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		dialog.resizeTo('45%','60%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Rol');
		CM_ocultarGrupo('Privilegios Rol');
		combo_rol.setValue(ClaseMadre_getComponente('id_rol').getValue());
		get_privilegios();
		ClaseMadre_btnEdit()
		
	};
	
	//Para manejo de eventos
		function iniciarEventosFormularios(){	
		    ds_rol.baseParams={txt_usuario:maestro.id_usuario};
		    combo_rol= ClaseMadre_getComponente('id_rol');
			h_descripcion= ClaseMadre_getComponente('descripcion');
			variable=ClaseMadre_getComponente('descripcion');
			h_descripcion1=ClaseMadre_getComponente('descripcion');
				
			function get_datos_privilegios(){
				m=0;
				num_registros=0;
				var postData;
				h_descripcion1="";
				
				
//				if(combo_rol.getValue() == undefined || combo_rol.getValue() == null || combo_rol.getValue() == ""){
//				    postData = "CantFiltros=1&filterCol_0=id_rol&filterValue_0="+combo_rol.getValue()
//				}
//				else{
//			  	  	postData = "CantFiltros=1&filterCol_0=RROLL.id_rol&filterValue_0="+combo_rol.getValue()
//				}
				if(combo_rol.getValue() == undefined || combo_rol.getValue() == null || combo_rol.getValue() == ""){
				    Ext.Ajax.request({url:'../../../sis_seguridad/control/rol_metaproceso/ActionListarUsuarioRolMetaproceso_det.php?m_id_rol='+combo_rol.getValue(),
				    params: postData,
				    method:'POST',
				    success:cargar_privilegios_data,
				    failure:ClaseMadre_conexionFailure,
				    timeout:100000})
				}
			}

			function cargar_privilegios_data(resp){
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
							CM_mostrarGrupo('Privilegios Rol');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				 }
		     }

			combo_rol.on('select',get_datos_privilegios);
			combo_rol.on('change', get_datos_privilegios)
		}
	
	
	function get_privilegios(){
		
			m=0;
			num_registros=0;
			var postData;
			h_descripcion1="";
			Ext.Ajax.request({url:'../../../sis_seguridad/control/rol_metaproceso/ActionListarUsuarioRolMetaproceso_det.php?m_id_rol='+combo_rol.getValue(),
			params: postData,
			method:'POST',
			success:cargar_privilegios,
			failure:ClaseMadre_conexionFailure,
			timeout:100000})
		}

		function cargar_privilegios(resp){
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
							CM_mostrarGrupo('Privilegios Rol');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				}
		}

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_usuario_rol.getLayout()
	};

	function InitPaginaUsuarioRol()
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
	InitPaginaUsuarioRol();
	layout_usuario_rol.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}