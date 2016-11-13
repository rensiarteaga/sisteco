<?php 
/**
 * Nombre:		  	    departamento_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_departamento_adq(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_departamento.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2009-01-23 11:04:01
*/
function pagina_departamento_adq(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'
		},[
		'id_depto',
		'codigo_depto',
		'nombre_depto',
		'estado',
		'id_subsistema',
		'nombre_corto',
		'nombre_largo'
		]),remoteSort:true
	});


	//DATA STORE COMBOS

	var ds_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo'])
	});

	function render_subsis(value, p, record){return String.format('{0}', record.data['nombre_largo']);}
	var tpl_subsis=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_corto}</FONT><br>','<b>{nombre_largo}</b>','</div>');

	//FUNCIONES RENDER


	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_depto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false

	};
	// txt codigo_depto
	Atributos[1]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'Codigo de Departamento',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codigo_depto'

	};
	// txt nombre_depto
	Atributos[2]={
		validacion:{
			name:'nombre_depto',
			fieldLabel:'Nombre de Departamento',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto'

	};
	// txt estado
	Atributos[3]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.departamentoEP_combo.estado}),
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
		filterColValue:'DEPEP.estado'

	};

	Atributos[4]={
		validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,
			emptyText:'Subsistema...',
			desc: 'nombre_largo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsis,
			valueField: 'id_subsistema',
			displayField: 'nombre_largo',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto,SUBSIS.nombre_largo',
			tpl:tpl_subsis,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_subsis,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%'
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SUBSIS.nombre_corto,SUBSIS.nombre_largo'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

//	function renderEstado(value){
//		if(value==1){value='Activo' }
//		if(value==2){value='Inactivo' }
//
//		return value
//	}
	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'departamento',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'Partida-Verificacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_vobo/vobo_detalle.php'};
	var layout_departamento=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_departamento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////


	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_departamento,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
var cm_EnableSelect=this.EnableSelect;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'departamento'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
//	function btn_departamentoUsuario(){
//		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
//		if(NumSelect!=0){
//			var SelectionsRecord=sm.getSelected();
//			var data='id_depto='+SelectionsRecord.data.id_depto;
//			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
//			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;
//
//			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
//			layout_departamento.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_vobo/vobo_detalle.php?'+data,'Usuario porDepartamento',ParamVentana);
//
//		}
//		else
//		{
//			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
//		}
//	}

	
	

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_departamento.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_departamento.getIdContentHijo()).pagina.bloquearMenu()
					}
				})


	}

	this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_departamento.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_departamento.getIdContentHijo()).pagina.desbloquearMenu();
			}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_departamento.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML


	//para agregar botones

	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Usuario porDepartamento',btn_departamentoUsuario,true,'departamentoUsuario','');


	this.iniciaFormulario();
	iniciarEventosFormularios();
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			oc:'si'
		}
	});
	layout_departamento.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}