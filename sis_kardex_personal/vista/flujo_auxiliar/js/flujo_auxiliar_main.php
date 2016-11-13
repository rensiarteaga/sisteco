<?php
/**
 * Nombre:		  	    flujo_auxiliar_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		10-02-2011
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){
	echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_flujo_auxiliar(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_flujo_auxiliar.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		10-02-2011
 */
function pagina_flujo_auxiliar(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,ds_usuario,ds_uo;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_flujo/control/auxiliar/ActionListarAuxiliar.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_auxiliar',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_auxiliar',
		'id_uo',
		'nombre_unidad',
		'nombre_cargo',
		'id_usuario',
		'login',
		'id_persona',		
		'nombre_completo',
		'estado_reg',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
   
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	//DATA STORE COMBOS
	
	var ds_uo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?correspondencia=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','desc_persona','login'])
	});
	//FUNCIONES RENDER
	function render_id_uo(value,p,record){return String.format('{0}',record.data['nombre_unidad'])}
	var tpl_id_uo=new Ext.Template('<div class="search-item">','<B>Nombre Unidad: </B><FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<B><FONT COLOR="#000000">Nombre Cargo: </FONT></B><FONT COLOR="#B5A642">{nombre_cargo}</FONT>','</div>');
	function render_id_usuario(value,p,record){return String.format('{0}',record.data['nombre_completo'])}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<B>Nombre: </B><FONT COLOR="#B5A642">{desc_persona}</FONT><br>','<B><FONT COLOR="#000000">Login: </FONT></B><FONT COLOR="#B5A642">{login}</FONT>','</div>');
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_auxiliar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		save_as:'hidden_id_auxiliar',
		tipo:'Field',
		filtro_0:false
	};

	vectorAtributos[1]={
	validacion:{
		fieldLabel:'Unidad Organizacional',
		allowBlank:false,
		vtype:'texto',
		emptyText:'UO...',
		name:'id_uo',
		desc:'nombre_unidad',
		store:ds_uo,
		valueField:'id_unidad_organizacional',
		displayField:'nombre_unidad',
		queryParam:'filterValue_0',
		tpl:tpl_id_uo,
		filterCol:'UNIORG.nombre_unidad',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_uo,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200,
		grid_indice:1
	},
	save_as:'hidden_id_uo',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'UNIORG.nombre_unidad'
};   
	vectorAtributos[2]={
	validacion:{
		fieldLabel:'Usuario',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Usuario...',
		name:'id_usuario',
		desc:'nombre_completo',
		store:ds_usuario,
		valueField:'id_usuario',
		displayField:'desc_persona',
		queryParam:'filterValue_0',
		tpl:tpl_id_usuario,
		filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_usuario,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200,
		grid_indice:2
	},
	save_as:'hidden_id_usuario',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre'
};   
// txt fecha_registro
	vectorAtributos[3]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:false,
		filtro_1:false,
		dateFormat:'m-d-Y'
	};	
	vectorAtributos[4]= {
		validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			renderer:render_estado_reg,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'AUXILI.estado_reg',
		save_as:'txt_estado_reg'
		};
		
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipo Proceso',grid_maestro:'grid-'+idContenedor};	
	var layout_flujo_auxiliar=new DocsLayoutMaestro(idContenedor);
	layout_flujo_auxiliar.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_flujo_auxiliar,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../../sis_flujo/control/auxiliar/ActionEliminarAuxiliar.php'},
	Save:{url:direccion+'../../../../sis_flujo/control/auxiliar/ActionGuardarAuxiliar.php'},
	ConfirmSave:{url:direccion+'../../../../sis_flujo/control/auxiliar/ActionGuardarAuxiliar.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Usuario'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
				
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_flujo_auxiliar.getLayout()
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
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_flujo_auxiliar.getLayout().addListener('layout',this.onResize);//arregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}