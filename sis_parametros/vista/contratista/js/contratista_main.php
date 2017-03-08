<?php 
/**
 * Nombre:		  	    contratista_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-11-06 21:05:13
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_contratista(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_contratista_main.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-11-06 21:05:13
 */
function pagina_contratista(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/contratista/ActionListarContratista.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_contratista',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_contratista',
		'codigo',
		'observaciones',
		'estado_registro',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_institucion',
		'desc_institucion',
		'desc_person',
		'id_persona'
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
    ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, ['id_institucion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona','direccion','id_tipo_doc_institucion'])
	});
    ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_per'])
	});
	//FUNCIONES RENDER
			function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
			function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_person']);}
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	// hidden id_contratista
	//en la posici�n 0 siempre esta la llave primaria
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_contratista',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_contratista'
	};
	 
// txt codigo1
	vectorAtributos[1]= {
		validacion:{
			name:'codigo',
			fieldLabel:'C�digo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%',
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.codigo',
		save_as:'txt_codigo',
		id_grupo:0
	};
	
	// txt id_institucion5
	vectorAtributos[3]= {
			validacion: {
			name:'id_institucion',
			fieldLabel:'Instituci�n',
			allowBlank:true,			
			emptyText:'Instituci�n...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			onSelect: function(record){componentes[3].setValue(record.data.id_institucion);  componentes[4].setValue(""); componentes[3].collapse(); },
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:true,
			width_grid:160 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		defecto: '',
		save_as:'txt_id_institucion',
		id_grupo:0
	};
	
// txt id_persona6
	vectorAtributos[4]= {
			validacion: {
			name:'id_persona',
			fieldLabel:'Persona',
			allowBlank:true,			
			emptyText:'Persona...',
			desc: 'desc_person', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			onSelect: function(record){componentes[4].setValue(record.data.id_persona);  componentes[3].setValue(""); componentes[4].collapse(); },
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_persona,
			grid_visible:true,
			grid_editable:true,
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_paterno',
		defecto: '',
		save_as:'txt_id_persona',
		id_grupo:0
	};
	
	// txt estado_registro3
	vectorAtributos[5]= {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado de Registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.contratista_combo.estado_registro
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:110, // ancho de columna en el gris
			disabled:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro',
		id_grupo:1
	};
	
	// txt observaciones4
	vectorAtributos[6]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};
	
	
	vectorAtributos[2]= {
			validacion: {
			name:'persona_institucion',
			fieldLabel:'Tipo Contratista',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.contratista_combo.persona_institucion
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:110, // ancho de columna en el gris
			disabled:false
		},
		tipo:'ComboBox',
		filterColValue:'CONTRA.estado_registro',
		save_as:'txt_persona_institucion',
		id_grupo:0
	};
	
	
	// txt fecha_reg2
	vectorAtributos[7]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:1
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
		titulo_maestro:'contratista',
		grid_maestro:'grid-'+idContenedor
	};
	layout_contratista=new DocsLayoutMaestro(idContenedor);
	layout_contratista.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_contratista,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
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
		btnEliminar:{url:direccion+'../../../control/contratista/ActionEliminarContratista.php'},
		Save:{url:direccion+'../../../control/contratista/ActionGuardarContratista.php'},
		ConfirmSave:{url:direccion+'../../../control/contratista/ActionGuardarContratista.php'},
		Formulario:{
			titulo:'Contratista',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'70%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{	tituloGrupo:'Datos Contratista',
				columna:0,
				id_grupo:0
			},
			{	tituloGrupo:'Datos Fecha-Estado-Observaciones',
				columna:0,
				id_grupo:1
			}
			]
		}
	};
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
	 this.btnNew = function()
	{	CM_ocultarComponente(componentes[3]);
		CM_ocultarComponente(componentes[4]);
		get_fecha_bd();
		ClaseMadre_btnNew()
	};
	
	 this.btnEdit = function(){	
		if(componentes[4].getValue()>0){//persona
			componentes[2].setValue('Persona');
			CM_mostrarComponente(componentes[4]);
			CM_ocultarComponente(componentes[3]);
		}
		if(componentes[3].getValue()>0){//institucion
			componentes[2].setValue('Instituci�n');
			CM_mostrarComponente(componentes[3]);
			CM_ocultarComponente(componentes[4]);
		}
		get_fecha_bd();
		ClaseMadre_btnEdit()
	};
    
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
			if(componentes[7].getValue()==""){
				componentes[7].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			}
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
		combo_persona_institucion= ClaseMadre_getComponente('persona_institucion');
		function persona_institucion(){
			if(combo_persona_institucion.getValue()=='persona'){
				CM_mostrarComponente(componentes[4]);
				CM_ocultarComponente(componentes[3])
			}
			else{
				CM_mostrarComponente(componentes[3]);
				CM_ocultarComponente(componentes[4])
			}
			
		}
		
		combo_persona_institucion.on('select',persona_institucion);
		combo_persona_institucion.on('change',persona_institucion);
		
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		sm=getSelectionModel()
	}
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_contratista.getLayout()};
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
				//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				this.iniciaFormulario();
				iniciarEventosFormularios();
				layout_contratista.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}