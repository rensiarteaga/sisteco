<?php 
/**
 * Nombre:		  	    seguimiento_solicitud_main.php
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
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:2,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_seguimiento_solicitud_servicio(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_seguimiento_solicitud.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
 */
function pagina_seguimiento_solicitud_servicio(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var observaciones='';
	var data='';
	var componentes=new Array;
	 
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
		/*'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',*/
		'tipo_adq',
		'nro_solicitud_cadena',
		'estado',
		'numeracion_periodo',
		'gestion',
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'preaprobador',
		'aprobador',
		'monto_total'
		,'transcriptor','id_presupuesto','desc_presupuesto','es_item'
		]),remoteSort:true});


	
	function negrita(val,cell,record,row,colum,store){
			var dias,dias_min,dias_max;
			dias=parseInt(record.get('dias'));
			dias_max=parseInt(record.get('dias_max'));
			dias_min=parseInt(record.get('dias_min'));
			
			
			
			if(dias>dias_min && dias<=dias_max && record.get('estado')!='borrador' && record.get('estado')!='anulado' && record.get('estado')!='finalizado'){
								
				
				return '<span style="color:orange;font-size:8pt">' + val + '</span>';
				
			}
			else if(dias>dias_max  && record.get('estado')!='borrador' && record.get('estado')!='anulado' && record.get('estado')!='finalizado'){
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				return val;
			}
		}				
		
			
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

    Atributos[13]={
		validacion:{
			name:'preaprobador',
			fieldLabel:'Encargado Preaprobación',
			grid_visible:true,
			width_grid:130,
			grid_indice:11
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'PREA.nombre_completo'
	};
	
	
	Atributos[3]={
		validacion:{
			name:'nro_solicitud_cadena',
			fieldLabel:'Período/Nº Sol.',
			grid_visible:true,
			width_grid:90,
			grid_indice:1,
			renderer:negrita
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.nro_solicitud_cadena'

	};
	
	
// txt id_empleado_frppa_solicitante
	Atributos[1]={
			validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			grid_visible:true,
			renderer:negrita,
			width_grid:120,
			grid_indice:2
				
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre'
	};
	
	// txt id_unidad_organizacional
	Atributos[2]={
			validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:false,
			width_grid:120,
			grid_indice:7	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Adquisicion',
			name: 'tipo_adq',
			inputType:'hidden',
			grid_visible:false
			
		},
		tipo: 'Field',
		filtro_0:true,
		form:false
	};
	
	
// txt id_tipo_categoria_adq
	Atributos[5]={
			validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Categoria',
			grid_visible:true,
			width_grid:120,
			grid_indice:3,
			renderer:negrita	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPCAT.nombre'
	};

// txt id_rpa
	Atributos[6]={
			validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			grid_visible:true,
			width_grid:80,
			width:'80%',
			grid_indice:1
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.gestion'
	};


	
	// txt localidad
	Atributos[7]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			width_grid:100,
			width:'45%',
			grid_indice:4		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ESTCOM.nombre',
		id_grupo:3
	};
	
	// txt estado_vigente_solicitud
	Atributos[8]={
		validacion:{
			name:'aprobador',
			fieldLabel:'Encargado Aprobación',
			grid_visible:true,
			width_grid:130,
			grid_indice:12		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'APRO.nombre_completo'
	};
	
	
	// txt id_moneda
	Atributos[9]={
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
	
	
		
	// txt localidad
	Atributos[11]={
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
	Atributos[12]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			grid_visible:true,
			width_grid:100,
			grid_indice:9		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.observaciones'
	};

// txt id_fina_regi_prog_proy_acti
	/*Atributos[10]={
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
		*/
	
	
	Atributos[10]={
		validacion:{
			fieldLabel:'Presupuesto',
			allowBlank:false,
			emptyText:'Presupuesto',
			name:'desc_presupuesto',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:8,		
			width:300,
			width_grid:300
			},
			tipo:'Field',
			save_as:'id_ep'
		};
		// txt observaciones
	Atributos[14]={
		validacion:{
			name:'monto_total',
			fieldLabel:'Precio Total',
			grid_visible:true,
			align:'right',
			width_grid:100,
			grid_indice:5		
		},
		tipo: 'Field',
		form: false
		
	};
		
	
	Atributos[15]={
		validacion:{
			name:'transcriptor',
			fieldLabel:'Transcriptor',
			grid_visible:true,
			
			width_grid:100,
			grid_indice:10		
		},
		tipo: 'Field',
		form: false
		
	};
	Atributos[16]={
			validacion:{
				labelSeparator:'',
				name: 'operacion',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			save_as:'operacion',
			tipo: 'Field',
			filtro_0:false,
			filtro_1:false
		};
	
			// txt num_solicitud
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'seguimiento_solicitud',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_solicitud_servicio/detalle_seguimiento_solicitud_det.php?refo=1'};
	var layout_seguimiento_solicitud_servicio=new DocsLayoutMaestroDetalleEP(idContenedor);
	layout_seguimiento_solicitud_servicio.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_seguimiento_solicitud_servicio,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_enableSelect=this.EnableSelect;
	var CM_getCM=this.getColumnModel;
	var getColumnNum=this.getColumnNum;
	var CM_getComponente=this.getComponente;
	var CM_Save=this.Save;


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
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php',parametros:'operacion:activar_anular'},
		ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],
		grupos:[
		        {
		        	tituloGrupo:'Datos',
		        	columna:0,
		        	id_grupo:0
		        },
		        {   tituloGrupo:'Estructura Programatica',
		        	columna:0,
		        	id_grupo:1
		        },
		        {   tituloGrupo:'Estado',
		        	columna:0,
		        	id_grupo:2
		        }
		        
		        ],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'seguimiento_solicitud'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_estado_proceso(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_desc_empleado_tpm_frppa='+SelectionsRecord.data.desc_empleado_tpm_frppa;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_desc_unidad_organizacional='+SelectionsRecord.data.desc_unidad_organizacional;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_seguimiento_solicitud_servicio.loadWindows(direccion+'../../../../sis_adquisiciones/vista/historial_solicitud/historial_solicitud.php?'+data,'Historial Solicitud',ParamVentana);
layout_seguimiento_solicitud_servicio.getVentana().on('resize',function(){
			layout_seguimiento_solicitud_servicio.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	
	function btn_solicitud_rep(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			if(SelectionsRecord.data.estado=='aprobado' || SelectionsRecord.data.estado=='en_proceso' || SelectionsRecord.data.estado=='finalizado'){
						data=data+'&tipo_repo=1';
			}
							
			window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data);	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedor).pagina.btnActualizar();
	}
	
	function showResult(btn){
			if(btn!='no'){
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	
	
	function getObservaciones1(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones_0='+observaciones;
		
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
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

	function btn_historial_rep(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
							
			window.open(direccion+'../../../control/estado_proceso/reporte/ActionPDFHistorial.php?'+data)	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btnActivarSolicitud(){
    	var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		var estado=SelectionsRecord.data.estado;
	
		if(NumSelect==1){
			//mostrarGruposVista('estado');
	    	componentes[16].setValue('activar_anulado');
	    	alert(componentes[16].getValue());
	    	CM_Save();	
	   }
		
		else{
				Ext.MessageBox.alert('Atención', 'Debe seleccionar un registro.');
			}
    }
	
	
	this.EnableSelect=function(x,z,y){
			
		enable(x,z,y);
		_CP.getPagina(layout_seguimiento_solicitud_servicio.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_seguimiento_solicitud_servicio.getIdContentHijo()).pagina.desbloquearMenu();
		
	}	
	
	//Para manejo de eventos
	/*function iniciarEventosFormularios(){
		
		
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_seguimiento_solicitud_servicio.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_seguimiento_solicitud_servicio.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
			for (var i=0;i<Atributos.length;i++){
				componentes[i]=CM_getComponente(Atributos[i].validacion.name);
			}		
				
		/*var numc=getColumnNum('preaprobador');
		getGrid().getColumnModel().setHidden(numc,true);
		numc=getColumnNum('aprobador');
		getGrid().getColumnModel().setHidden(numc,true);*/
	//}
	
function iniciarEventosFormularios(){
		
		//para iniciar eventos en el formulario
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		cm=CM_getCM();
		grid=getGrid();
		vista_grid=grid.getView();
		
		/*Aca se ocultan las columnas en el grid q no se van a mostrar de acuerdo al tipo de ventana*/
		
		
		//componentes[10].on('select',evento_tipo);
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_seguimiento_solicitud_servicio.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		

		
		this.AdicionarBoton('../../../lib/imagenes/gtuc/images/book.gif','Historial Solicitud',btn_estado_proceso,true,'estado_proceso','Historial');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de Solicitud',btn_solicitud_rep,true,'reporte_solicitud','Reporte de Solicitud');
		this.AdicionarBoton('../../../lib/imagenes/presto1.bmp','Monitor de Solicitudes',btn_historial_rep,true,'historial_reporte','Monitor de Solicitudes');
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Activar Anulado',btnActivarSolicitud,true,'activar_anulado','Activar Anulado');
		

	var CM_getBoton=this.getBoton;
			
	
	
	function  enable(sel,row,selected){
			var record=selected.data;
                if(selected&&record!=-1){
					   					       
					       if(record.estado!='anulado'){
					           	CM_getBoton('activar_anulado-'+idContenedor).disable();
					       }else{
					           	CM_getBoton('activar_anulado-'+idContenedor).enable();
					       }
					       
				}
				CM_enableSelect(sel,row,selected);
				
			}		
		
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
		//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			bien:2
		}
	});
	layout_seguimiento_solicitud_servicio.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}