<?php
/**
 * Nombre:		  	    usuario_asignacion_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:00:23
 *
 */
session_start();
?>
//<script>
var pagina_usuario_asignacion_det;

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
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	    	id_usuario:<?php echo $m_id_usuario;?>,id_persona:'<?php echo $m_id_persona;?>',apellido_paterno:'<?php echo $m_apellido_paterno;?>',apellido_materno:'<?php echo $m_apellido_materno;?>',nombre:'<?php echo $m_nombre;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_usuario_asignacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_usuario_asignacion_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:00:23
 */
function pagina_usuario_asignacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_asignacion/ActionListarUsuarioAsignacion_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario_asignacion',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_usuario_asignacion',
			'id_asignacion_estructura',
			'desc_asignacion_estructura',
			'desc_usuario',
			'id_usuario'
	
		]),remoteSort:true});

	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	//var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Usuario ',maestro.apellido_paterno],['Cuenta ',maestro.apellido_materno],['Fecha Registro',maestro.nombre]]}),cm:cmMaestro});
	//gridMaestro.render();
	//DATA STORE COMBOS

    ds_asignacion_estructura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asignacion_estructura/ActionListarAsignacionEstructura_det.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_asignacion_estructura',
			totalRecords: 'TotalCount'
		}, ['id_asignacion_estructura','nombre','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','validar_estructura'])
	});

    ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario/ActionListarUsuario.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario',
			totalRecords: 'TotalCount'
		}, ['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado'])
	});

	//FUNCIONES RENDER
	
			function render_id_asignacion_estructura(value, p, record){return String.format('{0}', record.data['desc_asignacion_estructura']);}
			function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_asignacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_asignacion',
		id_grupo:0
	};
	 
// txt id_asignacion_estructura
	vectorAtributos[1]= {
			validacion: {
			name:'id_asignacion_estructura',
			fieldLabel:'Estructura a Asignar',
			allowBlank:false,			
			emptyText:'Id Asignacion Estructura...',
			desc: 'desc_asignacion_estructura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_asignacion_estructura,
			valueField: 'id_asignacion_estructura',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ASIEST.nombre#ASIEST.descripcion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:350,
			grow:true,
			width:350,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_asignacion_estructura,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ASIEST.nombre',
		defecto: '',
		save_as:'txt_id_asignacion_estructura',
		id_grupo:1
	};
	
// txt id_usuario
	vectorAtributos[2]= {
			validacion: {
			name:'id_usuario',
			fieldLabel:'Id Usuario',
			allowBlank:false,			
			emptyText:'Id Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'USUARI.id_persona#USUARI.apellido_paterno#USUARI.apellido_materno#USUARI.nombredesc',
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
			renderer:render_id_usuario,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'USUARI.id_persona',
		defecto: maestro.id_usuario,
		save_as:'txt_id_usuario',
		id_grupo:0
	};
	
	
	
	vectorAtributos[3] = {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000000000,
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
		filterColValue:'ASIEST.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	
	
		var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_seguridad/vista/usuario_asignacion_det/usuario_asignacion_det.php'};
		var layout_usuario_asignacion=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_usuario_asignacion.init(config);
		
	
		
	
	
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_usuario_asignacion,idContenedor);
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

	var cm_EnableSelect=this.EnableSelect;
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
	btnEliminar:{url:direccion+'../../../control/usuario_asignacion/ActionEliminarUsuarioAsignacion.php',parametros:'&m_id_usuario='+maestro.id_usuario},
	Save:{url:direccion+'../../../control/usuario_asignacion/ActionGuardarUsuarioAsignacion.php',parametros:'&m_id_usuario='+maestro.id_usuario,
	success: miFuncionSuccess},
	ConfirmSave:{url:direccion+'../../../control/usuario_asignacion/ActionGuardarUsuarioAsignacion.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
		width:'40%',
		columnas:['95%'],
		minWidth:150,minHeight:200,closable:true,titulo: 'Asignacion de Usuario',
		grupos:[{
					tituloGrupo:'Invisible',
					columna:0,
					id_grupo:0
				},
				{
					tituloGrupo:'Estructura Programatica',
					columna:0,
					id_grupo:1
				},
				{
					tituloGrupo:'Detalle Estructura Programatica',
					columna:0,
					id_grupo:2
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
				m_id_usuario:maestro.id_usuario,
				
				
			}
		});
		
		
		this.btnActualizar();
		
	
		vectorAtributos[2].defecto=maestro.id_usuario;
		paramFunciones.btnEliminar.parametros='&m_id_usuario='+maestro.id_usuario;
		paramFunciones.Save.parametros='&m_id_usuario='+maestro.id_usuario;
		paramFunciones.ConfirmSave.parametros='&m_id_usuario='+maestro.id_usuario;
		
		
		
		
	    iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};
	

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function miFuncionSuccess(resp){
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_asignacion_estructura').modificado=true
	}
	
	function InitPaginaUsuarioAsignacionDet(){	
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	
	this.btnNew = function()
	{	var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('54%','60%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Estructura');
		CM_ocultarGrupo('Detalle Estructura Programatica');
		ds_asignacion_estructura.modificado=true;
		ClaseMadre_btnNew()
	};
	
	this.btnEdit = function()
	{	var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		var limpiar = sm.purgeListeners();
		dialog.resizeTo('54%','60%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos de Estructura');
		CM_ocultarGrupo('Detalle Estructura Programatica');
		combo_asignacion.setValue(ClaseMadre_getComponente('id_asignacion_estructura').getValue());
		//get_privilegios();
		ClaseMadre_btnEdit()
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	    ds_asignacion_estructura.baseParams={txt_usuario:maestro.id_usuario};
		combo_asignacion= ClaseMadre_getComponente('id_asignacion_estructura');
		h_descripcion= ClaseMadre_getComponente('descripcion');
		variable=ClaseMadre_getComponente('descripcion');
		h_descripcion1=ClaseMadre_getComponente('descripcion');
		
		
		function get_datos_asignacion(){
			m=0;
			num_registros=0;
			var postData;
			h_descripcion1="";
			
			if(combo_asignacion.getValue() == undefined || combo_asignacion.getValue() == null || combo_asignacion.getValue() == ""){
				  postData = "CantFiltros=1&filterCol_0=tipo_medidor&filterValue_0="+combo_asignacion.getValue()
			}
			else{
				postData = "CantFiltros=1&filterCol_0=ASIEST.id_asignacion_estructura&filterValue_0="+combo_asignacion.getValue()
			}
			Ext.Ajax.request({url:'../../../sis_parametros/control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActiUsuario.php?m_id_asignacion_estructura='+combo_asignacion.getValue(),
			params: postData,
			method:'POST',
			success:cargar_asignacion_data,
			failure:ClaseMadre_conexionFailure,
			timeout:100000})
		}

		function cargar_asignacion_data(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				num_registros= root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				 while(m<num_registros){
						variable.setValue(root.getElementsByTagName('desc_frppa')[m].firstChild.nodeValue);
						h_descripcion1 = h_descripcion1 + variable.getValue()+" 		";
						m=m+1
					}
						if(h_descripcion1!=""){
							h_descripcion.setValue(h_descripcion1);			
							CM_mostrarGrupo('Detalle Estructura Programatica');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				}
		}

		//combo_asignacion.on('select',get_datos_asignacion);
		//combo_asignacion.on('change', get_datos_asignacion);
		
	}
		
		function get_privilegios(){
			m=0;
			num_registros=0;
			var postData;
			h_descripcion1="";
			Ext.Ajax.request({url:'../../../sis_parametros/control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActiUsuario.php?m_id_asignacion_estructura='+combo_asignacion.getValue(),
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
						variable.setValue(root.getElementsByTagName('desc_frppa')[m].firstChild.nodeValue);
						h_descripcion1 = h_descripcion1 + variable.getValue()+"                                                                                        ";
						m=m+1
					}
						if(h_descripcion1!=""){
							h_descripcion.setValue(h_descripcion1);			
							CM_mostrarGrupo('Detalle Estructura Programatica');
							ClaseMadre_getComponente('descripcion').disable(true)
						}
				}
		}
		
	//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_usuario_asignacion.getLayout()
		};


		
		
		this.EnableSelect=function(sm,row,rec){
			
			_CP.getPagina(layout_usuario_asignacion.getIdContentHijo()).pagina.reload(rec.data);
			_CP.getPagina(layout_usuario_asignacion.getIdContentHijo()).pagina.desbloquearMenu();
			enable(sm,row,rec);
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
	
	function  enable(sel,row,selected){
		var record=selected.data;
		
		if(selected&&record!=-1){ 
			
			_CP.getPagina(layout_usuario_asignacion.getIdContentHijo()).pagina.desbloquearMenu()}
		else{
			_CP.getPagina(layout_usuario_asignacion.getIdContentHijo()).pagina.bloquearMenu()
		}
		cm_EnableSelect(sel,row,selected);
		
	}
	
	
	
	//para agregar botones
	this.iniciaFormulario();
	InitPaginaUsuarioAsignacionDet();
	iniciarEventosFormularios();
	
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_usuario:maestro.id_usuario
		}
	});
	
	layout_usuario_asignacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}