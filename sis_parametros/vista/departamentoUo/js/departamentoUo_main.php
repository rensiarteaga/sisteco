<?php
/**
 * Nombre:		  	    departamentoEP_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-01-23 11:04:01
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

var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:false};
var maestro={
		id_depto:<?php echo $id_depto;?>,
		codigo_depto:'<?php echo $codigo_depto;?>',
		nombre_depto:'<?php echo $nombre_depto;?>',
};
var elemento={pagina:new pagina_departamentoUO(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre?>'),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_departamentoEP.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2009-01-23 11:04:01
 */

function pagina_departamentoUO(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var txt_subsistema, txt_proceso;
	/////////////////
	//  DATA STORE //
	/////////////////

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_uo/ActionListarDepartamentoUO.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_uo',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_uo',
		'id_depto',
		'id_unidad_organizacional',
		'desc_depto',
		'nombre_unidad',
		'estado'
		]),remoteSort:true});

	// DEFINICIï¿½N DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['ID Depto.',maestro.id_depto],['Codigo de Departamento',maestro.codigo_depto],['Nombre de Departamento',maestro.nombre_depto]];
	
	//DATA STORE COMBOS
    
    var ds_depto = new Ext.data.Store({
    	proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepto.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_depto',
			totalRecords: 'TotalCount'},
			['id_depto',
			 'codigo_depto',
			 'nombre_depto',
			 'estado'])
    });
	
	var ds_departamento_uo = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),baseParams:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,sw_presto:1},
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_unidad_organizacional',
			totalRecords: 'TotalCount'},
		['id_unidad_organizacional',
		 'nombre_unidad',
		 'nombre_cargo',
		 'centro',
		 'cargo_individual',
		 'descripcion',
		 {name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		 'id_nivel_organizacional',
		 'nombre_nivel',
		 'estado_reg']),
		 
	});
	

	//FUNCIONES RENDER
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');

	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
	var tpl_id_unidad_organizacinal=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_frppa}</FONT><br>','<FONT COLOR="#0000ff">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{centro}</FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT><br>','</div>');

	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	//en la posiciï¿½n 0 siempre esta la llave primaria
	//id_depto_uo
	Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_depto_uo',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

	// txt id_depto
	Atributos[1]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_depto
	};
	
	//id_unidad_organizacional
	Atributos[2]= {
			validacion:{
				fieldLabel:'Unidad Organizacional',
				name:'id_unidad_organizacional',
				allowBlank:false,
				desc:'nombre_unidad',//es el nombre del departamento
				store:ds_departamento_uo,//agregado
				valueField:'id_unidad_organizacional',
				displayField:'nombre_unidad',
				queryParam:'filterValue_0',
				filterCol:'UNIORG.nombre_unidad',
				typeAhead:false,
				forceSelection:false,
				tpl:tpl_id_unidad_organizacinal,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_unidad_organizacional,
				grid_visible:true,
				grid_editable:false,
				width_grid:300,
				width:300,
				grid_indice:1	
				},
			tipo: 'ComboBox',
			form: true,
			filtro_0:true,			
			filterColValue:'UNIORG.nombre_unidad',
			save_as:'id_unidad_organizacional'
		};
	
	Atributos[3]={
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,
				grid_visible:true,
				grid_editable:false,
				forceSelection:true,
				width:100
			},
			tipo:'ComboBox',
			defecto:'activo',
			form: true,
			filtro_0:true,
			filterColValue:'DEPUO.estado'	
	};
	
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
			titulo_maestro:'Departamentos (Maestro)',
			titulo_detalle:'departamentoUO (Detalle)',
			grid_maestro:'grid-'+idContenedor};
	var layout_departamentoUO = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamentoUO.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamentoUO,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}};
	
	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depto_uo/ActionEliminarDepartamentoUO.php',parametros:'&id_depto='+maestro.id_depto},
	Save:{url:direccion+'../../../control/depto_uo/ActionGuardarDepartamentoUO.php',parametros:'&id_depto='+maestro.id_depto},
	ConfirmSave:{url:direccion+'../../../control/depto_uo/ActionGuardarDepartamentoUO.php',parametros:'&id_depto='+maestro.id_depto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'departamentoUo'}};
	
	//Para manejo de eventos
	
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		txt_subsistema = ClaseMadre_getComponente('nombre_largo');
		txt_proceso=ClaseMadre_getComponente('id_tipo_proceso');
		
		var onEstadoSelect = function(com,rec,ind){
			
			var id=txt_subsistema.getValue();
			var c=txt_proceso.getValue();
			
			if(id=='Sistema de Flujo de Trabajo'){
				 console.log(com)
				 console.log(rec)
				 console.log(ind)				
				
				txt_proceso.enable();
				CM_mostrarComponente(txt_proceso);
			}
			else
			{
				txt_proceso.disable();
				CM_ocultarComponente(txt_proceso);
			}
		}
	}
 
	/* this.btnNew = function(){
	 	
	 	CM_btnNew();
	 	txt_proceso.disable();
		CM_ocultarComponente(txt_proceso);
	 	
	 }*/
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		};
		this.btnActualizar();
		data_maestro=[['ID Depto.',maestro.id_depto],['Codigo de Departamento',maestro.codigo_depto],['Nombre de Departamento',maestro.nombre_depto]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_depto;

		paramFunciones.btnEliminar.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.Save.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.ConfirmSave.parametros='&id_depto='+maestro.id_depto;
		this.InitFunciones(paramFunciones)
	};
		
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamentoUO.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_depto:maestro.id_depto
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_departamentoUO.getLayout().addListener('layout',this.onResize);
	layout_departamentoUO.getVentana(idContenedor).on('resize',function(){layout_departamentoUO.getLayout().layout()})
	
}