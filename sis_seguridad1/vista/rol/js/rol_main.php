<?php 
/**
 * Nombre:		  	    rol_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 17:42:43
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

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
var elemento={pagina:new pagina_rol(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_rol_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 17:42:43
 */
function pagina_rol(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rol/ActionListarRol.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_rol',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_rol',
		'nombre',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'descripcion'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			txt_usuario:0
		}
	});
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_rol
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_rol',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_rol'
	};
	 
// txt nombre
	vectorAtributos[1]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:190,
			grid_indice:1,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	
// txt fecha_registro
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:87,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:1
	};
	
// txt hora_registro
	vectorAtributos[3]= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:1
	};
	
// txt fecha_ultima_modificacion
	vectorAtributos[4]= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:105,
			align:'center',
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:2
	};
	
// txt hora_ultima_modificacion
	vectorAtributos[5] = {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:105,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:2
	};
	
// txt descripcion
	vectorAtributos[6]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			grid_indice:2
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.descripcion',
		save_as:'txt_descripcion',
		id_grupo:0
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'rol',
		grid_maestro:'grid-'+idContenedor
	};
	layout_rol=new DocsLayoutMaestro(idContenedor);
	layout_rol.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_rol,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/rol/ActionEliminarRol.php'},
		Save:{url:direccion+'../../../control/rol/ActionGuardarRol.php'},
		ConfirmSave:{url:direccion+'../../../control/rol/ActionGuardarRol.php'},
		Formulario:{
			titulo:'Rol',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'65%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Rol',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Hora y Fecha Registro',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Hora y Fecha Modificación',
				columna:0,
				id_grupo:3
			}
			]
		}
	
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_rol_metaproceso(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_rol='+SelectionsRecord.data.id_rol;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;

			var ParamVentana={ventana:{width:'100%',height:'90%'}}
			layout_rol.loadWindows(direccion+'../../../vista/rol_metaproceso/rol_metaproceso_det.php?'+data,'Rol Metaproceso',ParamVentana);
			layout_rol.getVentana().on('resize',function(){
			layout_rol.getLayout().layout();
		   })
		}
		else
		{
		 	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	

	
	this.btnNew = function()
	{
		CM_ocultarGrupo('Hora y Fecha Modificación');
		CM_mostrarGrupo('Datos de Rol');
		CM_mostrarGrupo('Hora y Fecha Registro');
		get_fecha_bd();
		//get_hora_bd();
		ClaseMadre_btnNew()
	};
	
	 this.btnEdit = function()
	{
		CM_mostrarGrupo('Documento de Identificación');
	    CM_mostrarGrupo('Hora y Fecha Registro');
		CM_mostrarGrupo('Hora y Fecha Modificación');
		get_fecha_bd();
		//get_hora_bd();
		
		ClaseMadre_btnEdit()
	};
	
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
			if(componentes[2].getValue()==""){
				componentes[2].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				get_hora_bd();
			}else{
				componentes[4].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			   		get_hora_bd();
			   
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
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
			if(componentes[3].getValue()==""){
					componentes[3].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}else{
					componentes[5].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				}
				
			}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	  for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		sm=getSelectionModel()
	}

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rol.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
		        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Metaprocesos de Rol',btn_rol_metaproceso,true,'rol_metaproceso','Metaproceso');
		       

				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_rol.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}