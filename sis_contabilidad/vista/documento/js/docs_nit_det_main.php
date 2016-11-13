<?php 
/**
 * Nombre:		  	    docs_nit_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-28 17:32:19
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
	
	var idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_docs_nit_det(idContenedor,direccion,paramConfig,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_docs_nit_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_docs_nit_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocsNitDet.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'
		},[
		'id_documento',
		'nro_nit',
		'razon_social',
		'nro_autorizacion',
		'sw_lcv'
		]),remoteSort:true
	});
	
	//FUNCIONES RENDER
	function render_sino(value, p, record){	
		if(value=='no'){return 'NO';}
		if(value=='si'){return 'SI';}
	}
	
	///////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'nro_nit',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};

	Atributos[2]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razón Social',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'razon_social',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Autorización',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[4]={
		validacion:{
			name:'sw_lcv',
			fieldLabel:'Válido en LCV',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['no','NO'],['si','SI']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Lineas - EEFF',grid_maestro:'grid-'+idContenedor};
	layout_nit_det= new DocsLayoutMaestro(idContenedor);
	layout_nit_det.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_nit_det,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
		guardar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIï¿½N DE FUNCIONES
	 var paramFunciones={
		ConfirmSave:{url:direccion+'../../../control/documento/ActionGuardarDocsNit.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:500,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Detalle de Lineas',
			grupos:[{
				tituloGrupo:'Datos de Linea',
					columna:0,
					id_grupo:0
			}]}
		};
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//Ext.MessageBox.alert('Estado', 'llega');
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_nro_nit:maestro.nro_nit
			}
		};
		
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.nro_nit;
		/*
		paramFunciones.btnEliminar.parametros='&m_id_eeff='+maestro.id_eeff;
		paramFunciones.ConfirmSave.parametros='&m_id_eeff='+maestro.id_eeff;
		paramFunciones.Save.parametros='&m_id_eeff='+maestro.id_eeff;*/
	 
		this.InitFunciones(paramFunciones)
	};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_nit_det.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();

	layout_nit_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}