<?php 
/**
 * Nombre:		  	    verificacion_tecnica.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
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
    echo "var id_empleado='$id_empleado';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_verificacion_tecnica_serv(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_preaprobacion_solicitud.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24fobservacioens
 */
function pagina_verificacion_tecnica_serv(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var observaciones='';
	var data='';
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
		'justificacion',
		'localidad',
		'siguiente_estado',
		'tipo_adjudicacion',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'desc_empleado_tpm_frppa',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_cuenta',
		'desc_cuenta',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'reformulacion',
		'dias_max',
		'dias_min',
		'dias',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'tipo_adq',
		'num_solicitud',
		'estado',
		'numeracion_periodo',
		'gestion',
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'preaprobador',
		'tiene_presupuesto',
		'aprobador','tiene_suplente','suplente'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			filtro:"SEGSOL.estado_vigente_solicitud like 'visto_bueno' ",
			vista:'visto_bueno',
			bien:2,
			
		}
	});
	//DATA STORE COMBOS

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
		
	// hidden id_solicitud_compra
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_solicitud_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra'
	};

	
	
		// txt num_solicitud
	Atributos[1]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Período/Nº Sol.',
			align:'right',
			grid_visible:true,
			width_grid:70,
			grid_indice:1
			
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo'

	};
	
	
// txt id_empleado_frppa_solicitante
	Atributos[2]={
			validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			grid_visible:true,
			
			width_grid:120,
			grid_indice:2
				
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre'
	};

	

	
	
// txt id_tipo_categoria_adq
	Atributos[3]={
			validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Categoria',
			grid_visible:true,
			width_grid:120,
			grid_indice:3
			
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPCAT.nombre'
	};



	
	
	
	
		Atributos[4]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			grid_visible:true,
			width_grid:100,
			grid_indice:4		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.observaciones'
	};
		
	// txt localidad
	Atributos[5]={
		validacion:{
			name:'fecha_sol',
			fieldLabel:'Fecha',
			grid_visible:true,
			renderer: formatDate,
			width_grid:80,
			grid_indice:5
			
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.fecha_reg'
	};
	
	
	// txt observaciones
// txt id_moneda
	Atributos[6]={
			validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			grid_visible:true,
			width_grid:120,
			grid_indice:6		
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.nombre'
	};

		
	// txt id_unidad_organizacional
	Atributos[7]={
			validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:true,
			width_grid:120,
			grid_indice:7	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	
// txt id_fina_regi_prog_proy_acti
	Atributos[8]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:8,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep'
		};
		// txt localidad
	Atributos[9]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			width_grid:100,
			width:'45%',
			grid_indice:9		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ESTCOM.nombre'
	};
	
	
	// txt id_rpa
	Atributos[10]={
			validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			grid_visible:true,
			width_grid:100,
			width:'80%',
			grid_indice:10	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.gestion'
	};

		Atributos[11]={
			validacion:{
				name:'suplente',
				fieldLabel:'Empleado Suplente',
				grid_visible:true,
				width_grid:100
			},
			tipo: 'Field',
			form: false,
			filtro_0:false,
			filtro_1:false
		};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
//	var config={titulo_maestro:'Verificación Técnica',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_solicitud_bien/detalle_seguimiento_solicitud_bien_det.php?refo=1'};
	var config={titulo_maestro:'Verificación Técnica',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_solicitud_servicio/detalle_seguimiento_solicitud_det.php?refo=1'};
	var layout_visto_bueno_serv=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_visto_bueno_serv.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_visto_bueno_serv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_enableSelect=this.EnableSelect;

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
		ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?vista=visto_bueno'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,columnas:['90%'],
			grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},
					{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:0},
					{tituloGrupo:'Observaciones',columna:0,id_grupo:2},
					{tituloGrupo:'Designacion de Suplente',columna:0,id_grupo:3}
			],width:'50%',minWidth:150,minHeight:100,	closable:true,titulo:'Verificación Técnica'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	
	   getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_visto_bueno_serv.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_visto_bueno_serv.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
	   
	}

	this.EnableSelect=function(x,z,y){
		CM_enableSelect(x,z,y);
		_CP.getPagina(layout_visto_bueno_serv.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_visto_bueno_serv.getIdContentHijo()).pagina.desbloquearMenu();
	}	
	
	
	
	
	
	
	function btn_aprobar(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			
			  
			        Ext.MessageBox.show({
                    title: 'Observaciones de Verificación Técnica',
                    msg: 'Ingrese observaciones para Visto Bueno',
                    width:300,
                    buttons: Ext.MessageBox.OK,
                    multiline: true,
                    allowBlank:false,
                    fn: getObservaciones
                    });

                    data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			        data=data+'&operacion=visto_bueno';
			        data=data+'&vista=visto_bueno';
			
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function btn_correccion(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			Ext.MessageBox.show({
           title: 'Observaciones de Corrección',
           msg: 'Ingrese observaciones para corrección:',
           width:300,
           buttons: Ext.MessageBox.OK,
           multiline: true,
           fn: getObservaciones
           
       });
			data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=correccion';
			data=data+'&vista=visto_bueno';
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	
	function getObservaciones(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones='+observaciones;
		data=data+"&filtro=ESTCOM.nombre like 'visto_bueno'";
		data=data+'&vista=visto_bueno';
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	function btn_verificar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
							
			window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data)	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_visto_bueno_serv.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	//this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','Detalle');
	
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Visto Bueno',btn_aprobar,true,'visto_bueno','Visto Bueno');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'pedir_correccion','Corrección');
    this.AdicionarBoton('../../../lib/imagenes/print.gif','Vista Previa Solicitud',btn_verificar,true,'ver_preprb','Verificar');
	
    
		
	this.iniciaFormulario();
	iniciarEventosFormularios();

	layout_visto_bueno_serv.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}