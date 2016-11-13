<?php
/**
 * Nombre:		  	    cuenta_doc_rendicion_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				RCM
 * Fecha creación:		31/10/2009
 *
 */
session_start();
?>
//<script>


	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
		id_activo_fijo:<?php echo $m_id_activo_fijo;?>,
		codigo:decodeURIComponent('<?php echo $m_codigo;?>'),
		descripcion:decodeURIComponent('<?php echo $m_descripcion;?>'),
		descripcion_larga:decodeURIComponent('<?php echo $m_descripcion_larga;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new PaginaActivoFijoEmpleado(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_devengado_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:43:29
*/
function PaginaActivoFijoEmpleado(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleado.php'}),

		
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_empleado',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'id_activo_fijo_empleado',
		'estado',
		'id_activo_fijo',
		'id_empleado',
		'des_activo_fijo',
		'desc_empleado',
		{name: 'fecha_asig', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Código',maestro.codigo],['Descripción',maestro.descripcion],['Descripción Larga',maestro.descripcion_larga]];

	//DATA STORE COMBOS

	/////DATA STORE COMBOS////////////
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','desc_nombrecompleto'])

	});
	
	
	//FUNCIONES RENDER
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado_detalle
	//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
				validacion:{
				labelSeparator:'',
				name: 'id_activo_fijo_empleado',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo: 'Field',
			save_as:'hidden_id_activo_fijo_empleado',
			filtro_0:false
		};
		
		Atributos[1]={
				validacion:{
				name: 'id_activo_fijo',
				//fieldLabel: 'Id Activo',
				inputType:"hidden",
				labelSeparator:'',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_activo_fijo',
			defecto:maestro.id_activo_fijo
		};
		
		// txt id_parametro
		Atributos[2]={
				validacion:{
				fieldLabel: 'Funcionario',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Empleado...',
				name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField:'desc_nombrecompleto',
				queryParam: 'filterValue_0',
				filterCol:'apellido_paterno',
				//filterCol:'apellido_paterno',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true,
				renderer: renderEmpleado,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:120 // ancho de columna en el gris
			},
			
			tipo: 'ComboBox',
			save_as:'hidden_id_empleado'	
		};
	
		
		Atributos[3]={
			validacion: {
				name: 'estado',
				fieldLabel: 'Estado',
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:120 // ancho de columna en el grid
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'afe.estado',
			save_as:'txt_estado',
			defecto: 'activo'
		};
		
		
		// txt id_concepto_ingas
		Atributos[4]={
			validacion:{
				name: 'fecha_asig',
				fieldLabel: 'Fecha de Asignación',
				allowBlank: true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				//disabledDays: [0, 7],
				disabledDaysText: 'Día no válido',
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				renderer: formatDate,
				width_grid:120 // ancho de columna en el gris
			},
			tipo: 'DateField',
			filtro_0:true,
			filtro_1:true,
			filtro_2:true,
			filterColValue:'afe.fecha_asig',
			save_as:'txt_fecha_asig',
			dateFormat:'m-d-Y', //formato de fecha que envía para guardar
			defecto:"" // valor por default para este campo
		};
		
	
	// txt importe
		Atributos[5]={
			validacion:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha de registro',
				allowBlank: true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				//disabledDays: [0, 7],
				disabledDaysText: 'Día no válido',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				renderer: formatDate,
				width_grid:120, // ancho de columna en el gris
				disabled: true
			},
			tipo: 'DateField',
			filtro_0:true,
			filtro_1:true,
			filtro_2:true,
			filterColValue:'afe.fecha_reg',
			save_as:'txt_fecha_reg',
			dateFormat:'m-d-Y', //formato de fecha que envía para guardar
			defecto:"" // valor por default para este campo
		};
		

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Informacion de Activo Fijo',titulo_detalle:'Responsable de Activo Fijo',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout.init(config);


	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_conexionFailure=this.conexionFailure;


	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado.php"
		},
		Save:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		width:450,
			height:250,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[400],
			grupos:[
			{
				tituloGrupo:'Datos generales',
				columna:0,
				id_grupo:0
			}]
		}};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));

		maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
		maestro.codigo=datos.maestro_codigo;
		maestro.descripcion=datos.maestro_descripcion;
		maestro.descripcion_larga=datos.maestro_descripcion_larga;
		

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_activo_fijo: maestro.id_activo_fijo
			}
		};
		this.btnActualizar();
		data_maestro=[['Código',maestro.codigo],['Descripción',maestro.descripcion],['Descripción Larga',maestro.descripcion_larga]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_activo_fijo;
		
		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');		
	}
	
	function get_fecha_bd()
	{
				
		Ext.Ajax.request({
					url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
					method:'POST',
					success:cargar_fecha_bd,
					failure:ClaseMadre_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}
	
	this.btnNew = function()
	{
		
		ClaseMadre_btnNew()
		get_fecha_bd()
	}
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: maestro.id_activo_fijo
		}
	});


	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	layout.getVentana(idContenedor).on('resize',function(){layout.getLayout().layout()})

}