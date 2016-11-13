<?php 
/**
 * Nombre:		  	    eeff_linea_main.php
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
	var elemento={idContenedor:idContenedor,pagina:new pagina_concepto_cta(idContenedor,direccion,paramConfig,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_concepto_cta(idContenedor,direccion,paramConfig,idContenedorPadre)
{        
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;
	var comp_id_presupuesto, comp_id_cuenta, comp_id_auxiliar;

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionListarConceptoCta.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_concepto_cta',totalRecords:'TotalCount'
		},[
		'id_concepto_cta',
		'id_concepto_ingas',
		'id_cuenta',
		'desc_cta2',
		'id_presupuesto',
		'desc_presupuesto',
		'nombre_auxiliar',
		'id_auxiliar'
		]),remoteSort:true
	});
	
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux'])});
	
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																										'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																										'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																										'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																										'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin' 
																										])
		//,baseParams:{sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas}
	});
	
	//FUNCIONES RENDER
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cta2']);}
	var tpl_id_cuenta=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['nombre_auxiliar']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</b></i><br>','<FONT COLOR="#B5A642">{codigo_auxiliar}</FONT>','</div>');
	
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
		'<br>  <FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br>  <FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
	
	///////////////////////
	// Definicion de datos //
	/////////////////////////
	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_cta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_cta'
	};

	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_ingas'
	};
	
	Atributos[2]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:450,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto#presup.id_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			store:ds_cuenta,
		    displayField: 'desc_cta2',
			valueField: 'id_cuenta',
			desc:'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nombre_cuenta',
			typeAhead:false,
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
		save_as:'id_cuenta',
		id_grupo:0
	};
	
	Atributos[4]={
		validacion:{
		    name:'id_auxiliar',
			fieldLabel:'Auxiliar de Cuenta',
			allowBlank:false,
			emptyText:'Auxiliar...',
		    desc:'nombre_auxiliar',
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			tpl:tpl_id_auxiliar,
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			triggerAction:'all',
			editable:true,
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width:300,
			width_grid:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
		save_as:'id_auxiliar',
		id_grupo:0
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cuenta',grid_maestro:'grid-'+idContenedor};
	layout_concepto_cta= new DocsLayoutMaestro(idContenedor);
	layout_concepto_cta.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_concepto_cta,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	var cm_btnEdit=this.btnEdit;
	
	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICION DE FUNCIONES
	 var paramFunciones={
		btnEliminar:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionEliminarConceptoCta.php'},
		Save:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionGuardarConceptoCta.php'},
		ConfirmSave:{url:direccion+'../../../../sis_presupuesto/control/concepto_cta/ActionGuardarConceptoCta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:500,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Cuenta Auxiliar',
			grupos:[{
				tituloGrupo:'Datos de Cuenta',
					columna:0,
					id_grupo:0
			}]}
		};
	
	 function iniciarEventosFormularios() {
		comp_id_presupuesto=getComponente('id_presupuesto');
		comp_id_cuenta=getComponente('id_cuenta');
		comp_id_auxiliar=getComponente('id_auxiliar');
			
		comp_id_cuenta.on('select',f_cuenta);
	}
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//Ext.MessageBox.alert('Estado', 'llega');
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_concepto_ingas:maestro.id_concepto_ingas
			}
		};
		
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_concepto_ingas;
		
		comp_id_presupuesto.store.baseParams={sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas};
		comp_id_presupuesto.modificado=true;
		
		comp_id_cuenta.store.baseParams={sw_reg_comp:'si',m_id_partida:maestro.id_partida};
		comp_id_cuenta.modificado=true;
		
		paramFunciones.btnEliminar.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
		paramFunciones.ConfirmSave.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
		paramFunciones.Save.parametros='&m_id_concepto_ingas='+maestro.id_concepto_ingas;
	 
		this.InitFunciones(paramFunciones)
	};
	
	this.btnEdit = function(){
		comp_id_presupuesto.store.baseParams={sw_inv_gasto:'no',m_id_concepto_gasto:maestro.id_concepto_ingas};
		comp_id_cuenta.store.baseParams={sw_reg_comp:'si',m_id_partida:maestro.id_partida};
		comp_id_auxiliar.store.baseParams={sw_reg_comp:'si', m_estado_aux:1, m_id_cuenta:comp_id_cuenta.getValue()};
		comp_id_presupuesto.modificado=true;
		comp_id_cuenta.modificado=true;
		comp_id_auxiliar.modificado=true;
		
		cm_btnEdit();
	}
	
	function f_cuenta(combo, record, index ){
		comp_id_auxiliar.store.baseParams={sw_reg_comp:'si', m_estado_aux:1, m_id_cuenta:record.data.id_cuenta};
		comp_id_auxiliar.modificado=true;
		comp_id_auxiliar.setValue('');
	}
	
	ds.lastOptions={
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
	}};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_concepto_cta.getLayout()};
	
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_concepto_cta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}