<?php 
/**
 * Nombre:		  	    usuario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 17:44:04
 *
 */
session_start();
?>
//<script>
var pagina_usuario;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php
	if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	
	?>
var paramConfig={TamanoPagina:30,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_usuario(idContenedor,direccion,paramConfig),idContenedor:'<?php echo $idContenedor;?>'};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_usuario_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-26 17:44:04
*/
function pagina_usuario(idContenedor,direccion,paramConfig)
{
	var sm;
	var grid;
	var dialog;
	var formulario;
	var componentes=new Array();
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dato;
	var pagina;
	var data;
	var boton_on=0;
	var dia, mes, anio;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario/ActionListarUsuario.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_usuario',
		'id_persona',
		'desc_persona',
		'login',
		'contrasenia',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'estado_usuario',
		'estilo_usuario',
		'filtro_avanzado',
		{name:'fecha_expiracion',type:'date',dateFormat:'Y-m-d'},
		'autentificacion',
		'id_nivel_seguridad',
		'nombre_nivel',
		'prioridad',
		{name:'fecha_inactivacion',type:'date',dateFormat:'Y-m-d'}
		
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

	ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/persona/ActionListarPersona.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, [{name:'id_persona', mapping:'id_persona'},
		{name:'p',mapping:'apellido_paterno'},
		{name:'m',mapping:'apellido_materno'},
		{name:'n',mapping:'nombre'},
		'fecha_nacimiento',
		'foto_persona',
		'doc_id',
		'genero',
		'casilla',
		'telefono1',
		'telefono2',
		'celular1',
		'celular2',
		'pag_web',
		'email1',
		'email2',
		'email3',
		'fecha_registro',
		'hora_registro',
		'fecha_ultima_modificacion',
		'hora_ultima_modificacion',
		'observaciones',
		'id_tipo_doc_identificacion',
		'desc_per'
		])
	});

	ds_nivel_seguridad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nivel_seguridad/ActionListarNivelSeguridad.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_nivel_seguridad',
			totalRecords: 'TotalCount'
		}, [{name:'id_nivel_seguridad', mapping:'id_nivel_seguridad'},
		'id_nivel_seguridad',
		'codigo',
		'nombre_nivel',
		'prioridad'
		])
	});
	
	//FUNCIONES RENDER
	function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_persona']);}
	
	var resultTpl = new Ext.Template(
		'<div class="search-item">',
		'<span>{n} {p} {m}  </span></br>',
		'</div>'
	);
	
	function render_nivel_seguridad(value, p, record){return String.format('{0}', record.data['nombre_nivel']);}

	var resultTp2 = new Ext.Template(
		'<div class="search-item">',
		'<span>nombre_nivel  </span></br>',
		'</div>'
	);

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_usuario',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario',
		id_grupo:0
	};

	// txt id_persona
	vectorAtributos[1]= {
		validacion: {
			name:'id_persona',
			fieldLabel:'Persona',
			allowBlank:false,
			emptyText:'Id Persona...',
			desc: 'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			confTrigguer:{
				url:direccion+'../../../vista/persona/persona.php',
			    paramTri:'prueba:XXX',		
			    title:'Personas',
			    param:{width:800,height:800},
			    idContenedor:idContenedor,
			   // clase_vista:'pagina_persona'
			},
			
			
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:350,
			grow:true,
			width:350,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_persona,
			grid_visible:true,
			grid_editable:true,
			width_grid:250
          
		},
		tipo:'ComboTrigger',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'txt_id_persona',
		id_grupo:1
	};

	// txt login
	vectorAtributos[2]= {
		validacion:{
			name:'login',
			fieldLabel:'Cuenta Usuario',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.login',
		save_as:'txt_login',
		id_grupo:1
	};

	// txt contrasenia
	vectorAtributos[3]= {
		validacion:{
			name:'contrasenia',
			fieldLabel:'Contraseña',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			inputType:'password',
			width:'50%'
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'USUARI.contrasenia',
		save_as:'txt_contrasenia',
		id_grupo:1
	};
	
	// txt fecha_registro
	vectorAtributos[4]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			align:'center',
			width:'50%',
			width_grid:120
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.fecha_registro',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};

	// txt hora_registro
	vectorAtributos[5]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:12,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			align:'center',
			width:'50%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};

	// txt fecha_ultima_modificacion
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			align:'center',
			disabled:false,
			width:'50%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};

	// txt hora_ultima_modificacion
	vectorAtributos[7]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			align:'center',
			width:'50%'
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
	};

	// txt estado_usuario
	vectorAtributos[8]= {
		validacion:{
			name:'estado_usuario',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['activo','Activo'],['inactivo','Inactivo'],['eliminado','Eliminado']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			align:'center',
			grid_editable:true,
			width_grid:90, // ancho de columna en el gris
			width:'50%'
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		defecto:'activo',
		filterColValue:'USUARI.estado_usuario',
		save_as:'txt_estado_usuario',
		id_grupo:5
	};

	// txt estilo_usuario
	vectorAtributos[9]= {
		validacion:{
			name:'estilo_usuario',
			fieldLabel:'Estilo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['xtheme-aero.css','xtheme-aero.css'],
						['xtheme-gray.css','xtheme-gray.css'],
						['xtheme-vista.css','xtheme-vista.css'],
						['xtheme-galdaka.css','xtheme-galdaka.css'],
						['xtheme-halo.css','xtheme-halo.css']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:120, // ancho de columna en el gris
			width:'50%'
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.estilo_usuario',
		save_as:'txt_estilo_usuario',
		id_grupo:4
	};

	// txt filtro_avanzado
	vectorAtributos[10]= {
		validacion: {
			name:'filtro_avanzado',
			fieldLabel:'Filtro Avanzado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data :[['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			align:'center',
			grid_editable:true,
			width_grid:60, // ancho de columna en el gris
			width:'50%'
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.filtro_avanzado',
		defecto:'si',
		save_as:'txt_filtro_avanzado',
		id_grupo:4
	};

	// txt apellido_paterno
	vectorAtributos[11]= {
		validacion:{
			name:'desc_persona',
			fieldLabel:'Apellido Paterno',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'PER.apellido_paterno',
		save_as:'txt_apellido_paterno',
		id_grupo:0
	};

	vectorAtributos[12]= {
		validacion:{
			name:'fecha_expiracion',
			fieldLabel:'Fecha Expiración',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:95,
			disabled:false,
			align:'center',
			width:'50%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.fecha_expiracion',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_expiracion',
		id_grupo:5
	};

	// txt autentificacion
	vectorAtributos[13]= {
		validacion:{
			name:'autentificacion',
			fieldLabel:'Tipo autentificación',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['ldap','ldap'],['local','local']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:250, // ancho de columna en el gris
			width:350
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		defecto:'ldap',
		filterColValue:'USUARI.autentificacion',
		save_as:'txt_autentificacion',
		id_grupo:4
	};
	
	/// id_nivel_seguridad
	vectorAtributos[14]={
		validacion:{
			fieldLabel:'Nivel Seguridad',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Nivel...',
			name:'id_nivel_seguridad',
			desc:'nombre_nivel',
			store:ds_nivel_seguridad,
			valueField:'id_nivel_seguridad',
			displayField:'nombre_nivel',
			filterCol:'NIVEL.nombre_nivel',
			typeAhead:false,
			forceSelection:false,
			//tpl:resultTp2,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_nivel_seguridad,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:200,
			grid_indice:0
			
		},
		tipo:'ComboBox',
		id_grupo:1
	};

	vectorAtributos[15]= {
		validacion:{
			name:'fecha_inactivacion',
			fieldLabel:'Fecha Inactivacion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:95,
			disabled:false,
			align:'center',
			width:'50%'
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.fecha_inactivacion',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_inactivacion',
		id_grupo:6
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
		titulo_maestro:'usuario',
		grid_maestro:'grid-'+idContenedor,
		txt_id_persona:1
	};
	layout_usuario=new DocsLayoutMaestro(idContenedor);
	layout_usuario.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_usuario,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/usuario/ActionEliminarUsuario.php'},
		Save:{url:direccion+'../../../control/usuario/ActionGuardarUsuario.php',
		success:miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/usuario/ActionGuardarUsuario.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'75%',width:'45%',
		minWidth:250,
		minHeight:300,
		closable:true,
		titulo:'usuario',
		columnas:['95%'],
		grupos:[{
			tituloGrupo:'Invisible',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Datos de Usuario',
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
		},

		{
			tituloGrupo:'Preferencias de Usuario',
			columna:0,
			id_grupo:4
		},
		{
			tituloGrupo:'Estado de Usuario',
			columna:0,
			id_grupo:5
		},{
			tituloGrupo:'Inactivacion Usuario',
			columna:0,
			id_grupo:6
		}
		]
	}};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function miFuncionSuccess(resp)
	{
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_persona').modificado=true
	}
	this.btnNew = function()
	{
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Usuario');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
		CM_ocultarGrupo('Preferencias de Usuario');
		CM_ocultarGrupo('Estado de Usuario');
		CM_ocultarGrupo('Inactivacion Usuario');
		//		var sm = getSelectionModel();
		//		var filas = ds.getModifiedRecords();
		//		var cont = filas.length;
		//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//		var sw=false;
		//		dialog.resizeTo('45%','75%');
		//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Usuario');
		CM_mostrarGrupo('Datos de Registro');
		CM_mostrarGrupo('Preferencias de Usuario');
		CM_mostrarGrupo('Estado de Usuario');
		componentes[3].disable();
		componentes[4].disable();
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnNew();
	};

	this.btnEdit=function()
	{
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Usuario');
		CM_ocultarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificaciones');
		CM_ocultarGrupo('Preferencias de Usuario');
		CM_ocultarGrupo('Estado de Usuario');
		CM_ocultarGrupo('Inactivacion Usuario');
		//		var sm = getSelectionModel();
		//		var filas = ds.getModifiedRecords();
		//		var cont = filas.length;
		//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//		var sw=false;
		//		dialog.resizeTo('45%','75%');
		//		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Usuario');
		CM_mostrarGrupo('Datos de Modificaciones');
		CM_mostrarGrupo('Preferencias de Usuario');
		CM_mostrarGrupo('Estado de Usuario');
		componentes[5].disable();
		componentes[6].disable();
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit()
	};
	
	function btn_usuario_rol(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();

			var data='m_id_usuario='+SelectionsRecord.data.id_usuario;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_apellido_paterno='+SelectionsRecord.data.desc_persona;
			data=data+'&m_apellido_materno='+SelectionsRecord.data.login;
			data=data+'&m_nombre='+SelectionsRecord.data.fecha_registro;

			var ParamVentana={ventana:{width:'90%',height:'80%'}}
			layout_usuario.loadWindows(direccion+'../../../vista/usuario_rol/usuario_rol_det.php?'+data,'Usuario Rol',ParamVentana);
			layout_usuario.getVentana().on('resize',function(){
				layout_usuario.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function btn_usuario_lugar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_usuario='+SelectionsRecord.data.id_usuario;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_apellido_paterno='+SelectionsRecord.data.desc_persona;
			data=data+'&m_apellido_materno='+SelectionsRecord.data.login;
			data=data+'&m_nombre='+SelectionsRecord.data.fecha_registro;

			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_usuario.loadWindows(direccion+'../../../vista/usuario_lugar/usuario_lugar_det.php?txt_usuario=0&'+data,'Usuario Lugar',ParamVentana);
			layout_usuario.getVentana().on('resize',function(){
				layout_usuario.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function btn_usuario_asignacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_usuario='+SelectionsRecord.data.id_usuario;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_apellido_paterno='+SelectionsRecord.data.desc_persona;
			data=data+'&m_apellido_materno='+SelectionsRecord.data.login;
			data=data+'&m_nombre='+SelectionsRecord.data.fecha_registro;

			var ParamVentana={ventana:{width:'100%',height:'70%'}}
			layout_usuario.loadWindows(direccion+'../../../vista/usuario_asignacion/usuario_asignacion_det.php?'+data,'Usuario Asignación',ParamVentana);
			layout_usuario.getVentana().on('resize',function(){
				layout_usuario.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function btn_usuario_sincronizar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			Ext.Ajax.request({
				url:direccion+"../../../control/usuario/ActionSincronizarEPUsuarioEmpleado.php",
				success:cargar_respuesta,
				params:{'id_usuario':sm.getSelected().data.id_usuario},
				failure:ClaseMadre_conexionFailure,
				timeout:paramConfig.TiempoEspera
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function cargar_respuesta(resp){

		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText);
		if(regreso.success=='true'){
		
			alert("Sincronización Exitosa, se añadieron "+regreso.suma+"  EP's")	
		}
		else{
		    
		   alert("FALLO en la Sincronización")	
		}
	}

	function btn_hist_clave(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_usuario='+SelectionsRecord.data.id_usuario;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_apellido_paterno='+SelectionsRecord.data.desc_persona;
			data=data+'&m_apellido_materno='+SelectionsRecord.data.login;
			data=data+'&m_nombre='+SelectionsRecord.data.fecha_registro;
			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_usuario.loadWindows(direccion+'../../../vista/hist_clave/hist_clave_det.php?'+data,'Historico Contrasenia',ParamVentana);
			layout_usuario.getVentana().on('resize',function(){
				layout_usuario.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		h_txt_fecha_registro = ClaseMadre_getComponente('fecha_registro');
		h_txt_fecha_ultima_modificacion = ClaseMadre_getComponente('fecha_ultima_modificacion');
		h_txt_hora_registro = ClaseMadre_getComponente('hora_registro');
		h_txt_hora_ultima_modificacion = ClaseMadre_getComponente('hora_ultima_modificacion');
		h_txt_fecha_expiracion= ClaseMadre_getComponente('fecha_expiracion');
	}
	
	function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}
	
	function cargar_fecha_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_registro.getValue()!="")
			{
				h_txt_fecha_ultima_modificacion.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}else{
				h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				h_txt_fecha_expiracion.minValue=h_txt_fecha_registro.getValue();
				h_txt_fecha_expiracion.setValue('');
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
		});
	}
	
	function cargar_hora_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(h_txt_hora_registro.getValue()!="")
			{
				h_txt_hora_ultima_modificacion.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
			}else{
				h_txt_hora_registro.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
			}
		}
	}
	
	function btn_inactivar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			
	
			CM_ocultarGrupo('Invisible');
			CM_ocultarGrupo('Datos de Usuario');
			//CM_ocultarGrupo('Datos de Registro');
			//CM_ocultarGrupo('Datos de Modificaciones');
			CM_ocultarGrupo('Preferencias de Usuario');
			CM_ocultarGrupo('Estado de Usuario');
			CM_mostrarGrupo('Inactivacion Usuario');
			ClaseMadre_btnEdit();
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	
	function InitPaginaUsuario()
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
	this.getLayout=function(){return layout_usuario.getLayout();};
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
	
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Rol del Usuario',btn_usuario_rol,true,'usuario_rol','Usuario Rol');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Lugar del Usuario',btn_usuario_lugar,true,'usuario_lugar','Usuario Lugar');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Asignación de Estructura',btn_usuario_asignacion,true,'usuario_asignacion','Usuario Asignación');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Sincronizar de Estructura Programatica',btn_usuario_sincronizar,true,'Sin_EP','Sincronizar EP');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Alertas',btn_usuario_envio_alerta,true,'usuariozar_envio_alerta','Usuario Envio Alerta');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Historico Contraseñas',btn_hist_clave,true,'hist_clave','Historico Contrasenia');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Inactivar',btn_inactivar,true,'inactivar','Inactivar Cuenta');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaUsuario();
	layout_usuario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}