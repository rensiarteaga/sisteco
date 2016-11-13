<?php 
/**
 * Nombre:		  	    institucion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:04:29
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
	    echo "var tipo='$tipo';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_institucion(idContenedor,direccion,paramConfig,tipo),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_institucion_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:04:29
 */
function pagina_institucion(idContenedor,direccion,paramConfig,tipo)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/institucion/ActionListarInstitucion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
    	'id_institucion',
		'doc_id',
		'nombre',
		'casilla',
		'telefono1',
		'telefono2',
		'celular1',
		'celular2',
		'fax',
		'email1',
		'email2',
		'pag_web',
		'observaciones',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'estado_institucion',
		'id_persona',
		'desc_persona',
		'direccion',
		'desc_tipo_doc_institucion',
		'id_tipo_doc_institucion',
		'codigo'
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
    ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_per'])
	});
    ds_tipo_doc_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_doc_institucion/ActionListarTipoDocInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_doc_institucion',
			totalRecords: 'TotalCount'
		}, ['id_tipo_doc_institucion','nombre_tipo_doc','observacion'])
	});
	//FUNCIONES RENDER
			function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_persona']);}
			function render_id_tipo_doc_institucion(value, p, record){return String.format('{0}', record.data['desc_tipo_doc_institucion']);}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_institucion
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_institucion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_institucion'
	};
	 
	// txt id_tipo_doc_institucion
	vectorAtributos[4]= {
			validacion: {
			name:'id_tipo_doc_institucion',
			fieldLabel:'Tipo Doc. Institución',
			allowBlank:true,			
			emptyText:'Tipo Documento de Institución...',
			desc: 'desc_tipo_doc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_doc_institucion,
			valueField: 'id_tipo_doc_institucion',
			displayField: 'nombre_tipo_doc',
			queryParam: 'filterValue_0',
			filterCol:'TIDOINS.nombre_tipo_doc',
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
			renderer:render_id_tipo_doc_institucion,
			grid_visible:true,
			grid_editable:true,
			width_grid:130 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIDOINS.nombre_tipo_doc',
		defecto: '',
		save_as:'txt_id_tipo_doc_institucion',
		id_grupo:1
	};
	
	//txt nombre
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
			width_grid:120,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	
// txt casilla
	vectorAtributos[14]= {
		validacion:{
			name:'casilla',
			fieldLabel:'Casilla Postal',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.casilla',
		save_as:'txt_casilla',
		id_grupo:3
	};
	
// txt telefono1
	vectorAtributos[6]= {
		validacion:{
			name:'telefono1',
			fieldLabel:'Telefono 1',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.telefono1',
		save_as:'txt_telefono1',
		id_grupo:2
	};
	
// txt telefono2
	vectorAtributos[7]= {
		validacion:{
			name:'telefono2',
			fieldLabel:'Telefono 2',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.telefono2',
		save_as:'txt_telefono2',
		id_grupo:2
	};
	
// txt celular1
	vectorAtributos[8]= {
		validacion:{
			name:'celular1',
			fieldLabel:'Celular 1',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.celular1',
		save_as:'txt_celular1',
		id_grupo:2
	};
	
// txt celular2
	vectorAtributos[9] = {
		validacion:{
			name:'celular2',
			fieldLabel:'Celular 2',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.celular2',
		save_as:'txt_celular2',
		id_grupo:2
	};
	
// txt fax
	vectorAtributos[10]= {
		validacion:{
			name:'fax',
			fieldLabel:'Fax',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.fax',
		save_as:'txt_fax',
		id_grupo:3
	};
	
// txt email1
	vectorAtributos[11]= {
		validacion:{
			name:'email1',
			fieldLabel:'Email 1',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.email1',
		save_as:'txt_email1',
		id_grupo:3
	};
	
// txt email2
	vectorAtributos[12] = {
		validacion:{
			name:'email2',
			fieldLabel:'Email 2',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.email2',
		save_as:'txt_email2',
		id_grupo:3
	};

// txt pag_web
	vectorAtributos[13]= {
		validacion:{
			name:'pag_web',
			fieldLabel:'Pagina Web',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.pag_web',
		save_as:'txt_pag_web',
		id_grupo:3
	};
	
// txt fecha_registro
	vectorAtributos[17]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:4
	};
	
// txt hora_registro
	vectorAtributos[18]= {
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
			width_grid:100,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:4
	};
	
// txt fecha_ultima_modificacion
	vectorAtributos[19]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:120,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:5
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[20]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:5
	};
	
	// txt direccion
	vectorAtributos[2]= {
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
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
		filterColValue:'INSTIT.direccion',
		save_as:'txt_direccion',
		id_grupo:0
	};
	
// txt id_persona
	vectorAtributos[3]= {
			validacion: {
			name:'id_persona',
			fieldLabel:'Responsable Institución',
			allowBlank:true,			
			emptyText:'Responsable...',
			desc: 'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			forceSelection:false,
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
			renderer:render_id_persona,
			grid_visible:true,
			grid_editable:true,
			width_grid:220 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_paterno',
		defecto: '',
		save_as:'txt_id_persona',
		id_grupo:0
	};
	
// txt estado_institucion
	vectorAtributos[15]= {
			validacion: {
			name:'estado_institucion',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			/*store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.institucion_combo.estado_institucion
			}),*/
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,			 // ancho de columna en el gris
			disabled:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.estado_institucion',
		defecto:'activo',
		save_as:'txt_estado_institucion',
		id_grupo:0
	};
	
// txt observaciones
	vectorAtributos[16]= {
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
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.observaciones',
		save_as:'txt_observaciones',
		id_grupo:0
	};
	
// txt doc_id
	vectorAtributos[5]= {
		validacion:{
			name:'doc_id',
			fieldLabel:'Doc. Identificación',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.doc_id',
		save_as:'txt_doc_id',
		id_grupo:1
	};
	
	vectorAtributos[21]= {
			validacion:{
				name:'codigo',
				fieldLabel:'Código',
				allowBlank:false,
				maxLength:20,
				minLength:1,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:120,
				width:'80%'
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'INSTIT.codigo',
			save_as:'txt_codigo',
			id_grupo:0
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
		titulo_maestro:'institucion',
		grid_maestro:'grid-'+idContenedor
	};
	layout_institucion=new DocsLayoutMaestro(idContenedor);
	layout_institucion.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_institucion,idContenedor);
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
    ///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
	if(tipo.substr(0, 7)=='sel_per'){
		var paramMenu={
		nuevo:{crear:true,separador:true},
		actualizar:{crear:true,separador:false}
	};
	}else{
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/institucion/ActionEliminarInstitucion.php'},
		Save:{url:direccion+'../../../control/institucion/ActionGuardarInstitucion.php'},
		ConfirmSave:{url:direccion+'../../../control/institucion/ActionGuardarInstitucion.php'},
		Formulario:{
			titulo:'Institución',
			html_apply:"dlgInfo-"+idContenedor,
			width:'65%',
			height:'100%',
			minWidth:100,
			minHeight:150,
			columnas:['47%','47%'],
			closable:true,
			grupos:[
			{	tituloGrupo:'Institución',
				columna:0,
				id_grupo:0
			},
			{	tituloGrupo:'Identificación de la Institución',
				columna:0,
				id_grupo:1
			},
			{	tituloGrupo:'Dirección Telefono',
				columna:1,
				id_grupo:2
			},
			{	tituloGrupo:'Dirección Correo-Web',
				columna:1,
				id_grupo:3
			},
			{	tituloGrupo:'Hora y Fecha Registro',
				columna:0,
				id_grupo:4
			},
			{	tituloGrupo:'Hora y Fecha Modificación',
				columna:0,
				id_grupo:5
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	 this.btnNew = function(){	
		CM_mostrarGrupo('Institución');
		CM_mostrarGrupo('Identificación de la Institución');
		CM_mostrarGrupo('Dirección Telefono');
		CM_mostrarGrupo('Dirección Correo - Web');
		CM_mostrarGrupo('Hora y Fecha Registro');
		CM_ocultarGrupo('Hora y Fecha Modificación');
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnNew()
	};
	
	 this.btnEdit = function(){
		CM_mostrarGrupo('Institución');
		CM_mostrarGrupo('Identificación de la Institución');
		CM_mostrarGrupo('Dirección Telefono');
		CM_mostrarGrupo('Dirección Correo - Web');
		CM_ocultarGrupo('Hora y Fecha Registro');
		CM_mostrarGrupo('Hora y Fecha Modificación');
		get_fecha_bd();
		get_hora_bd();
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
			if(componentes[17].getValue()==""){	
				componentes[17].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			}
			else{
		   		componentes[19].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
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
		{	Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
			if(componentes[18].getValue()==""){
					componentes[18].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
				else{
					componentes[20].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
			}
		}
	 	
	 	//jrr: 09/03/2011	para utlizar combo trigguer 
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			//carga datos XML
					ds.load({
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros
						}
					});
			
		};
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		for(i=0;i<vectorAtributos.length;i++)
			{	
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
			}
		sm=getSelectionModel()
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_institucion.getLayout()};
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
				layout_institucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}