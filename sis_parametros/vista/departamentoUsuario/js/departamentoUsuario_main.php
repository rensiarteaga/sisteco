<?php
/**
 * Nombre:		  	    departamentoUsuario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-01-23 11:04:02
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
var maestro={id_depto:<?php echo $id_depto;?>,codigo_depto:decodeURIComponent('<?php echo $codigo_depto;?>'),nombre_depto:decodeURIComponent('<?php echo $nombre_depto;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_departamentoUsuario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_departamentoUsuario.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2009-01-23 11:04:02
 */
function pagina_departamentoUsuario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_usuario/ActionListarDepartamentoUsuario.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_usuario',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_usuario',
		'id_depto',
		'desc_depto',
		'id_usuario',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'desc_usuario',
		'estado','cargo','login'
		]),remoteSort:true});

	
	// DEFINICIï¿½N DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['ID Depto.',maestro.id_depto],['Codigo de Departamento',maestro.codigo_depto],['Nombre de Departamento',maestro.nombre_depto]];
	
	//DATA STORE COMBOS

    var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','apellido_paterno','apellido_materno','nombre','desc_persona','desc_usuario','login'])
	});

	//FUNCIONES RENDER
	
		function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');

		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{login}</FONT><br>','{desc_usuario}<br>','</div>');

	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_depto_usuario
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto_usuario',
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
// txt id_usuario
	Atributos[2]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:true,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_2.apellido_paterno#PERSON_2.apellido_materno#PERSON_2.nombre'
	};
// txt estado
	Atributos[4]={
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
		filterColValue:'DEPUS.estado'
		};

	Atributos[5]={
		validacion:{
			name:'cargo',
			fieldLabel:'Cargo',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:300,
		},
		tipo:'TextField',
		defecto:'',
		form: true,
		filtro_0:true,
		filterColValue:'DEPUS.cargo'
		};
		
	Atributos[3]={
		validacion:{
			name:'login',
			fieldLabel:'Login',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:150,
			width:300,
		},
		tipo:'TextField',
		defecto:'',
		form: false,
		filtro_0:false,
		filterColValue:'USUARI_2.login'
		};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
//function renderEstado(value){
//		if(value==1){value='Activo' }
//		if(value==2){value='Inactivo' }
//		
//		return value
//	}
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamentos (Maestro)',titulo_detalle:'Usuarios (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_departamentoUsuario = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamentoUsuario.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamentoUsuario,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depto_usuario/ActionEliminarDepartamentoUsuario.php',parametros:'&id_depto='+maestro.id_depto},
	Save:{url:direccion+'../../../control/depto_usuario/ActionGuardarDepartamentoUsuario.php',parametros:'&id_depto='+maestro.id_depto},
	ConfirmSave:{url:direccion+'../../../control/depto_usuario/ActionGuardarDepartamentoUsuario.php',parametros:'&id_depto='+maestro.id_depto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Usuarios'}};
	
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
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamentoUsuario.getLayout()};
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
	layout_departamentoUsuario.getLayout().addListener('layout',this.onResize);
	layout_departamentoUsuario.getVentana(idContenedor).on('resize',function(){layout_departamentoUsuario.getLayout().layout()})
	
}