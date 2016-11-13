/**
 * Nombre:		  	    pagina_preferencia_usuario_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 15:55:31
 */
function pagina_preferencia_usuario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia_usuario/ActionListarPreferenciaUsuario.php'}),
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
		'id_usuario',
		'contrasenia',
		'estilo_usuario'
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
	
	ds_preferencia = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia/ActionListarPreferencia.php?txt_usuario='+maestro.id_usuario}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_preferencia',
			totalRecords: 'TotalCount'
		}, ['id_preferencia','nombre_modulo','descripcion_modulo'])
	});

	function render_id_preferencia(value, p, record){return String.format('{0}', record.data['desc_preferencia']);};
	// DEFINICIÓN DATOS DEL MAESTRO
	var dataMaestro=[['Usuario',maestro.id_usuario]];
	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_preferencia_usuario
	//en la posición 0 siempre esta la llave primaria

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
		form:false,
		id_grupo:0
	};
	 

	vectorAtributos[1]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_preferencia',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_preferencia',
		form:false,
		id_grupo:0
	};
	
	
	vectorAtributos[2]= {
			validacion: {
			name:'desc_preferencia',
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
		id_grupo:0
	};
	
	
	vectorAtributos[3]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_usuario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_usuario',
		form:false,
		id_grupo:0
	};
	
	vectorAtributos[4]= {
		validacion:{
			name:'contrasenia',
			fieldLabel:'Contraseña Actual',
			allowBlank:true,
			maxLength:10000,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			inputType:'password',
			width_grid:200,
			width:'50%'
		},
		tipo: 'TextField',
		save_as:'txt_contrasenia',
		id_grupo:0
	};
	
	
	vectorAtributos[5]= {
		validacion:{
			name:'contrasenia_nueva',
			fieldLabel:'Contraseña Nueva',
			allowBlank:true,
			maxLength:10000,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:200,
			inputType:'password',
			width:'50%'
		},
		tipo: 'TextField',
		save_as:'txt_contrasenia_nueva',
		id_grupo:0
	};
	
	
	
	vectorAtributos[6]= {
		validacion:{
			name:'contrasenia_nueva_rep',
			fieldLabel:'Repetir Contraseña Nueva',
			allowBlank:true,
			maxLength:10000,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:200,
			inputType:'password',
			width:'50%'
		},
		tipo: 'TextField',
		save_as:'txt_contrasenia_nueva_rep',
		id_grupo:0
	};
	
	
	vectorAtributos[7]={
			validacion:{
				name:'estilo_usuario',
				fieldLabel:'Estilo Usuario',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : Ext.usuario_combo.estilo
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width:100,
				grid_indice:2,
				width_grid:100 // ancho de columna en el grid
			},
			tipo:'ComboBox',
			filterColValue:'SALDET.estado_item',
			save_as:'txt_estilo_usuarios',
			id_grupo:0
		};
	
	
	
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
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
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/preferencia_usuario/ActionEliminarPreferenciaUsuario.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/usuario/ActionGuardarUsuario.php',parametros:'&hidden_id_usuario_0='+maestro.id_usuario,
	success: miFuncionSuccess},
	ConfirmSave:{url:direccion+'../../../control/usuario/ActionGuardarUsuario.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'40%',
		width:'40%',
	titulo:'Preferencia de Usuario',
	columnas:['95%'],
	minWidth:150,minHeight:200,closable:true,grupos:[{
				tituloGrupo:'Preferencia',
				columna:0,
				id_grupo:0}]}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	function miFuncionSuccess(resp)
	{
		CM_saveSuccess(resp);
		layout_preferencia_usuario.getLayout().addListener('layout',this.onResize);
	
	}
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	   	obtEmpleado();
	}
	
	function obtEmpleado(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionEmpleadoLogueado.php",
			method:'GET',
			success:ter,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		})
	}
	//recupera nombre e id de empleado y llena el formulario
	function ter(resp){
		var root = resp.responseXML.documentElement;
		if(root.getElementsByTagName('id_empleado')[0]!==undefined){
			id_emp = root.getElementsByTagName('id_empleado')[0].firstChild.nodeValue;
			if(id_emp!="null"){
				var empleado=root.getElementsByTagName('nombre')[0].firstChild.nodeValue;
				empleado=empleado+" "+ root.getElementsByTagName('paterno')[0].firstChild.nodeValue;
				empleado=empleado+" " +root.getElementsByTagName('materno')[0].firstChild.nodeValue;
				gridMaestro.getDataSource().removeAll();
				gridMaestro.getDataSource().loadData([['Id Usuario',maestro.id_usuario],['Usuario',empleado]]);
	
			}
			else{
				alert("Solamentes usuarios registrados como empleados pueden modificar su información");
				dialog.hide()
			}
		}
		else{
			alert("Ocurrió un error en la petición de verificación de usuario")
		}
	}
	
		function btn_cambio_clave(){
			
			CM_ocultarComponente(ClaseMadre_getComponente('desc_preferencia'));
			CM_ocultarComponente(ClaseMadre_getComponente('estilo_usuario'));
			CM_mostrarComponente(ClaseMadre_getComponente('contrasenia'));
			CM_mostrarComponente(ClaseMadre_getComponente('contrasenia_nueva'));
			CM_mostrarComponente(ClaseMadre_getComponente('contrasenia_nueva_rep'));
		
			var sm = getSelectionModel();
			var filas = ds.getModifiedRecords();
			var cont = filas.length;
			var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
			var sw=false;
				ClaseMadre_getComponente('contrasenia').setValue('');
				ClaseMadre_getComponente('contrasenia').allowBlank=false;
				ClaseMadre_getComponente('contrasenia_nueva').allowBlank=false;
				ClaseMadre_getComponente('contrasenia_nueva_rep').allowBlank=false;
				ClaseMadre_getComponente('estilo_usuario').allowBlank=true;
				
				ClaseMadre_btnEdit();
			}
			
			
		function btn_cambio_estilo(){
			
			CM_ocultarComponente(ClaseMadre_getComponente('desc_preferencia'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia_nueva'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia_nueva_rep'));
			CM_mostrarComponente(ClaseMadre_getComponente('estilo_usuario'));
		
			var sm = getSelectionModel();
			var filas = ds.getModifiedRecords();
			var cont = filas.length;
			var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
			var sw=false;
				
				ClaseMadre_getComponente('contrasenia').allowBlank=true;
				ClaseMadre_getComponente('contrasenia_nueva').allowBlank=true;
				ClaseMadre_getComponente('contrasenia_nueva_rep').allowBlank=true;
				ClaseMadre_getComponente('estilo_usuario').allowBlank=false;
	    		ClaseMadre_btnEdit();
	    		layout_preferencia_usuario.getLayout().addListener('layout',this.onResize);
		}
			

		function btn_cambio_preferencia(){
			
			CM_ocultarComponente(ClaseMadre_getComponente('estilo_usuario'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia_nueva'));
			CM_ocultarComponente(ClaseMadre_getComponente('contrasenia_nueva_rep'));
			CM_mostrarComponente(ClaseMadre_getComponente('desc_preferencia'));
		
			var sm = getSelectionModel();
			var filas = ds.getModifiedRecords();
			var cont = filas.length;
			var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
			var sw=false;
				
				ClaseMadre_getComponente('contrasenia').allowBlank=true;
				ClaseMadre_getComponente('contrasenia_nueva').allowBlank=true;
				ClaseMadre_getComponente('contrasenia_nueva_rep').allowBlank=true;
				ClaseMadre_getComponente('estilo_usuario').allowBlank=false;
	    		ClaseMadre_btnEdit();
	    		layout_preferencia_usuario.getLayout().addListener('layout',this.onResize);
			}
			
			
	function InitPaginaPreferenciaUsuarioDet()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_preferencia_usuario.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cambiar Contraseña',btn_cambio_clave,true,'cambio_clave','Cambio Contraseña');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cambiar Estilo',btn_cambio_estilo,true,'cambio_estilo','Cambio Estilo');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cambiar Preferencia',btn_cambio_preferencia,true,'cambio_preferencia','Cambio Preferencia');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaPreferenciaUsuarioDet();
	layout_preferencia_usuario.getLayout().addListener('layout',this.onResize);
	//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}