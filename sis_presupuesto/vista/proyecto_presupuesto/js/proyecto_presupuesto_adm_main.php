<?php 
/**
 * Nombre:		  	    proyecto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 15:33:00
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
var elemento={pagina:new pagina_proyecto_adm(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_proyecto_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 15:33:00
 */
function pagina_proyecto_adm(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	
	function render_desplegar_imagen(value, p, record)
	{	
		momentoActual = new Date();
		
		hora = momentoActual.getHours();
		minuto = momentoActual.getMinutes();
		segundo = momentoActual.getSeconds();
		
		hora_actual = hora+":"+minuto+":"+segundo;
		
		return  String.format('{0}',"<div style='text-align:center'><img src = ../../../sis_seguridad/control/persona/archivo/"+ record.data['numero']+"."+record.data['extension']+"?"+record.data['nombre_foto']+hora_actual+" align='center' width='70' height='70'/></div>");
	}		
	
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListarProyecto.php?tipo_vista=ejecucion_fisica_adm'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_proyecto',
			'codigo_proyecto',
			'nombre_proyecto',
			'descripcion_proyecto',
			{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
			'hora_registro',
			{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
			'hora_ultima_modificacion',
			'login',
			'nombre_corto',
			'codigo_sisin',
			'fase_proyecto',
			'tipo_estudio',
			'desc_usr_mod',
			'id_persona',
			'desc_persona',
			'foto_persona',
			'foto',
			'numero',
			'extension',
			'nombre_foto',
			'id_proyecto_cat_prog',
			'descripcion_pcp'
			
    		]),remoteSort:true});
			
		//DATA STORE COMBOS
    	
	var ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
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
		'desc_per',
		'id_proyecto_cat_prog',
		'descripcion_pcp'
		])
		});
		
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});
	
	var ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proyecto/ActionListarProyecto.php'}),
			reader: new Ext.data.XmlReader({	record: 'ROWS',	id: 'id_proyecto',	totalRecords: 'TotalCount'	}, ['id_proyecto','codigo','descripcion','codigo_sisin' ])
	});
			
	function render_id_persona(value,p,record){return String.format('{0}',record.data['desc_persona'])}		
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	function render_id_proyecto(value, p, record){return String.format('{0}', record.data['descripcion_pcp']);}
	
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5000">{gestion_pres}</FONT>','</div>');
	var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B50000">{codigo_sisin}</FONT>','</div>');

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			
		}
	});
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_proyecto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_proyecto',
		id_grupo:0
	};
	 
// txt codigo_proyecto
	vectorAtributos[1]= {
		validacion:{
			name:'codigo_proyecto',
			fieldLabel:'Código Proyecto',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'55%',
			grid_visible:true,
			grid_editable:true,
			width_grid:70			
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.codigo_proyecto',
		save_as:'txt_codigo_proyecto',
		id_grupo:1
	};
	
// txt nombre_proyecto
	vectorAtributos[2]= {
		validacion:{
			name:'nombre_proyecto',
			fieldLabel:'Nombre del Proyecto',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:true,
			width_grid:300
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.nombre_proyecto',
		save_as:'txt_nombre_proyecto',
		id_grupo:1
	};
	
// txt descripcion_proyecto
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion_proyecto',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'PROYEC.descripcion_proyecto',
		save_as:'txt_descripcion_proyecto',
		id_grupo:1
	};	
	
	// txt descripcion_proyecto
	vectorAtributos[4]= {
		validacion:{
			name:'nombre_corto',
			fieldLabel:'Nombre Corto',
			allowBlank:true,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROYEC.nombre_corto',
		save_as:'txt_nombre_corto',
		id_grupo:1
	};
	
	vectorAtributos[5]= {
			validacion: {
			name:'id_proyecto_cat_prog',
			fieldLabel:'Nombre Proyecto SISIN WEB',
			allowBlank:false,			
			//emptyText:'Proyecto...',
			desc: 'descripcion_pcp', //indica la columna del store principal ds del que proviane la descripcion 
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'descripcion',
			onSelect:function(record){
								componentes[4].setValue(record.data.id_proyecto);
								componentes[4].collapse();
																	
								componentes[5].setValue(record.data.codigo_sisin);								
								componentes[5].allowBlank=false;									
								
				},
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion#PROYEC.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			tpl:tpl_id_proyecto,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRCTPR.descripcion#PRCTPR.codigo',
		defecto: '',
		save_as:'txt_id_proyecto_cat_prog',
		id_grupo:1
	};
	
	// txt descripcion_proyecto
	vectorAtributos[6]= {
		validacion:{
			name:'codigo_sisin',
			fieldLabel:'Código SISIN',
			allowBlank:true,
			allowDecimals: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:true,
			width_grid:150
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'PROYEC.codigo_sisin',
		save_as:'txt_codigo_sisin',
		id_grupo:1
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'fase_proyecto',
			fieldLabel:'Fase del Proyecto',
			vtype:'texto',
			//emptyText:'Elija el Tipo...',
			allowBlank:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[ ['Estudio','Estudio'],['Ejecución','Ejecución'] ] }),
			valueField:'ID',
			displayField:'valor',
			onSelect:function(record){
								componentes[6].setValue(record.data.ID);
								componentes[6].collapse();
								if(record.data.ID=='Estudio')
								{									
									CM_mostrarComp(componentes[7]);									
									componentes[7].allowBlank=false;									
								} 
								else if(record.data.ID=='Ejecución')
								{									
									CM_ocultarComp(componentes[7]);									
									componentes[7].allowBlank=true;									
								} 		
				},
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PROYEC.fase_proyecto',
		save_as:'fase_proyecto',
		id_grupo:1
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'tipo_estudio',
			fieldLabel:'Tipo de Estudio',
			vtype:'texto',
			//emptyText:'Elija el Tipo...',
			allowBlank:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[ ['EI','EI'],['TESA','TESA'],['DISEÑO FINAL','DISEÑO FINAL']  ] }),
			valueField:'ID',
			displayField:'valor',
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PROYEC.tipo_estudio',
		save_as:'tipo_estudio',
		id_grupo:1
	};
	
	// txt id_persona
	vectorAtributos[9]= {
			validacion: {
				name:'id_persona',
				fieldLabel:'Responsable del Proyecto',
				allowBlank:false,
				//emptyText:'Id Persona...',
				desc: 'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_persona,
				valueField: 'id_persona',
				displayField: 'desc_per',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				confTrigguer:{
					url:direccion+'../../../../sis_seguridad/vista/persona/persona.php',
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
				grid_editable:false,
				width_grid:250,	  
				disabled:false				
			},
			tipo:'ComboTrigger',
			filtro_0:true,
			filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			save_as:'txt_id_persona',
			id_grupo:1
		};
			
	vectorAtributos[10]= {	
		validacion:{
		labelSeparator:'',
		//fieldLabel:'Foto',
		name: 'foto',
		inputType:'hidden',
		grid_visible:true, 
		grid_editable:false,
		renderer: render_desplegar_imagen
		//locked:true				
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'_foto_persona'		
	};		

	

	vectorAtributos[11]= {
		validacion:{
			name:'login',
			fieldLabel:'Usuario Registro',
			allowBlank:true,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'USUARI.login',
		save_as:'txt_loguin',
		id_grupo:0
	};
			
	// txt fecha_registro
	vectorAtributos[12] = {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha de Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PROYEC.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:2
	};
	
// txt hora_registro
	vectorAtributos[13]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora de Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			width:'35%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:false,
		filterColValue:'PROYEC.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:2
	};
	
	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name:'desc_usr_mod',
			fieldLabel:'Usuario Modificación',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'USUARI2.login'		
	};
	 
// txt fecha_ultima_modificacion
	vectorAtributos[15]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha de Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PROYEC.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:3
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[16]= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora de Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			width:'35%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:false,
		filterColValue:'PROYEC.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:3
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
	/*var config = {
		titulo_maestro:'proyecto',
		grid_maestro:'grid-'+idContenedor
	};
	layout_proyecto=new DocsLayoutMaestro(idContenedor);
	layout_proyecto.init(config);*/

	var config={titulo_maestro:'Proyecto',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_presupuesto/vista/ejecucion_fisica/ejecucion_fisica.php'};
	var layout_proyecto_presupuesto=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_proyecto_presupuesto.init(config);

	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_proyecto_presupuesto,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_saveSuccess=this.saveSuccess;
	var cm_EnableSelect=this.EnableSelect;

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
		btnEliminar:{url:direccion+'../../../../sis_parametros/control/proyecto/ActionEliminarProyecto.php'},
		Save:{url:direccion+'../../../../sis_parametros/control/proyecto/ActionGuardarProyecto.php'},
		ConfirmSave:{url:direccion+'../../../../sis_parametros/control/proyecto/ActionGuardarProyecto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'75%',
		width:'45%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'Proyecto',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Proyecto',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Datos de Registro',
				columna:0,
				id_grupo:2},
				{
				tituloGrupo:'Datos de Modificación',
				columna:0,
				id_grupo:3}]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_registro= ClaseMadre_getComponente('fecha_registro');
		h_txt_hora_registro= ClaseMadre_getComponente('hora_registro');
		h_txt_fecha_ultima_modificacion= ClaseMadre_getComponente('fecha_ultima_modificacion');
		h_txt_hora_ultima_modificacion= ClaseMadre_getComponente('hora_ultima_modificacion');
		
		getSelectionModel().on('rowdeselect',function(){
			if(_CP.getPagina(layout_proyecto_presupuesto.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_proyecto_presupuesto.getIdContentHijo()).pagina.bloquearMenu()
			}
		})
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var record=rec.data;
		_CP.getPagina(layout_proyecto_presupuesto.getIdContentHijo()).pagina.reload(rec.data);
		
		/*if(maestro.tipo_vista==2)
		{
			_CP.getPagina(layout_proyecto_presupuesto.getIdContentHijo()).pagina.bloquearMenu();
		}
		else
		{*/
			_CP.getPagina(layout_proyecto_presupuesto.getIdContentHijo()).pagina.desbloquearMenu();
		//}
		cm_EnableSelect(sm,row,rec)
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
				h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				h_txt_fecha_registro.disable(true)
			}else{
			
				h_txt_fecha_ultima_modificacion.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				h_txt_fecha_ultima_modificacion.disable(true)	
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
				h_txt_hora_registro.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				h_txt_hora_registro.disable(true)		
						
			}else{
			
				h_txt_hora_ultima_modificacion.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				h_txt_hora_ultima_modificacion.disable(true)
			}
		}
 	}
	
	function btnArchAdjunto()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();

			data='id_proyecto='+SelectionsRecord.data.id_proyecto;
							

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			
			layout_proyecto_presupuesto.loadWindows(direccion+'../../../../sis_presupuesto/vista/adjunto/adjunto.php?'+data,'Documentos Adjuntos',ParamVentana);					
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	 	
	this.btnNew = function(){	
		
		//dialog.resizeTo('45%','45%');

		get_fecha_bd();
		get_hora_bd();
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Proyecto');
		CM_mostrarGrupo('Datos de Registro');
		CM_ocultarGrupo('Datos de Modificación');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function(){ 	
		get_fecha_bd();
		get_hora_bd();
		CM_ocultarGrupo('Invisible');		
		CM_ocultarGrupo('Datos de Registro');		
		CM_mostrarGrupo('Datos de Proyecto');
		CM_mostrarGrupo('Datos de Modificación');
		
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaProyecto()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		var sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
		
		CM_ocultarComp(componentes[6]);									
		componentes[6].allowBlank=true;
	}
	
	var prueba=new Ext.form.ComboBox({
			store:ds_parametro,
			//displayField:'Gestión',
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			typeAhead:true,
			mode:'local',
			triggerAction:'all',
			emptyText:'Seleccionar Gestión...',
			selectOnFocus:true,
			width:135,
			valueField:'id_parametro',
			editable:false,			
			renderer:render_id_parametro,
			tpl:tpl_id_parametro			
	});
	
	ds_parametro.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	
	prueba.on('select',	function()
	{				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,id_parametro:prueba.getValue()}});			
	});
	
	//para que los hijos puedan ajustarse al tamaño 
	this.getLayout=function(){return layout_proyecto_presupuesto.getLayout()};
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
				this.AdicionarBotonCombo(prueba,'prueba');
				this.AdicionarBoton('../../../lib/imagenes/book.gif','Otros Documentos Adjuntos',btnArchAdjunto,true,'adjuntos','Documentos Adjuntos');
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				InitPaginaProyecto();
				layout_proyecto_presupuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}