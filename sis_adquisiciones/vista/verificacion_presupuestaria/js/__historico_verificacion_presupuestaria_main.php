<?php 
/**
 * Nombre:		  	    historico_verificacion_presupuestaria.php
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_historico_verificacion_presupuestaria(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_historico_verificacion_presupuestaria(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var data='';
	var id_solicitud_compra;
	//prueba guardado
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
		'observaciones',
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
		{name: 'fecha_estado',type:'date',dateFormat:'Y-m-d'},
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','tipo_adq','num_solicitud','estado','numeracion_periodo','gestion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo:'historico'
		}
	});
	//DATA STORE COMBOS
	
		
		function negrita(val,cell,record,row,colum,store){
			if(record.get('reformulacion')=='1'){
								
				if(colum=='3'){
					return '<span style="color:red;font-size:8pt">Reformulación Pendiente</span>';
				}
				else{
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
				}
			}
			else
			{
				return val;
			}
		}
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra
	//en la posiciï¿½n 0 siempre esta la llave primaria

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
	
	
	Atributos[1]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Número Solicitud',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:'30%',
			disable:false,
			grid_indice:2,
			renderer:negrita
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo',
		save_as:'txt_num_solicitud'
	};
	
	// txt id_empleado_frppa_solicitante
	
	
	Atributos[2]={
		validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:3	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre',
		id_grupo:0
	};

     Atributos[3]={
		validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Centro',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:4
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		id_grupo:0
	};
	
	
	
Atributos[4]={
		validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:5
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:0
	};
	
	// txt localidad
	Atributos[5]={
		validacion:{
			name:'localidad',
			fieldLabel:'Localidad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:6,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.localidad',
		save_as:'localidad'
	};
	
	Atributos[6]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo Adquisicion',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7
		},
		tipo: 'TextArea',
		form:false,
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		id_grupo:0
	};
	
	
// txt id_rpa

Atributos[7]={
		validacion:{
			name:'desc_rpa',
			fieldLabel:'RPA',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:8
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP_8.apellido_paterno#EMPLEP_8.apellido_materno#EMPLEP_8.nombre',
		id_grupo:0
	};
	// txt tipo_adjudicacion
	Atributos[8]={
		validacion:{
			name:'tipo_adjudicacion',
			fieldLabel:'Adjudicación',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'40%',
			disable:false,
			grid_indice:9,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.tipo_adjudicacion',
		save_as:'tipo_adjudicacion'
	};
	
	
	
Atributos[9]={
		validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Tipo Categoria',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:10
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TIPCAT.nombre',
		id_grupo:0
	};
	
	Atributos[10]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			width:'100%',
			disable:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'SEGSOL.gestion',
		id_grupo:0
	};
	
	
// txt observaciones

	Atributos[11]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11,
			renderer:negrita		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'ESTPRO.observaciones',
		save_as:'observaciones'
	};


	Atributos[12]={
		validacion:{
			name:'siguiente_estado',
			fieldLabel:'Siguiente Estado',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'40%',
			disable:false,
			grid_indice:12,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.siguiente_estado',
		save_as:'siguiente_estado'
	};

// txt id_tipo_categoria_adq
	
	Atributos[13]={
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
			grid_indice:13,		
			width:300,
			renderer:negrita
			},
			tipo:'epField',
			save_as:'id_ep'
		};
		
		// txt num_solicitud



	
	// txt localidad
	Atributos[14]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:14,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.nombre',
		save_as:'estado'
	};
	
	Atributos[15]= {
        validacion:{
			name:'fecha_estado',
			fieldLabel:'Fecha Inicio Estado',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true,
			grid_indice:15
			
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ESTPRO.fecha_ini',
		save_as:'fecha_estado',
		id_grupo:0
	};


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(val,cell,record,row,colum,store){
		
		if(record.get('reformulacion')=='1'){
			
			return '<span style="color:red;font-size:8pt">'+ val?val.dateFormat('d/m/Y'):'' +'</span>';
		}
		
		else
		{
			return val?val.dateFormat('d/m/Y'):'';
		}
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'verificacion_presupuestaria',grid_maestro:'grid-'+idContenedor};
	layout_historico_verificacion_presupuestaria=new DocsLayoutMaestroEP(idContenedor);
	layout_historico_verificacion_presupuestaria.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_historico_verificacion_presupuestaria,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_enableSelect=this.EnableSelect;

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'verificacion_presupuestaria'}};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	
	function btn_solicitud_compra_det(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
			data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.tipo_adq=='Bien'){
				layout_historico_verificacion_presupuestaria.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_verificacion_solicitud_bien/detalle_verificacion_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
			else{
				layout_historico_verificacion_presupuestaria.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_verificacion_solicitud_servicio/detalle_verificacion_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
		
layout_historico_verificacion_presupuestaria.getVentana().on('resize',function(){
			layout_historico_verificacion_presupuestaria.getLayout().layout();
				})
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
		data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
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
			btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	
	
	function btn_reporte_solicitud_compra(){
		window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVer.php?'+data)	
	}
	
	this.EnableSelect=function(x,z,y){
			
		enable(x,z,y);
		
		
	}	
	
	function btn_verificar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra+'&tipo=copia';
							
			window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVer.php?'+data)	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_historico_verificacion_presupuestaria.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','Detalle');
	
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Verificar Presupuesto',btn_verificar,true,'verificar_presupuesto','Presupuesto');
	//this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Reporte Solicitud Compra',btn_reporte_solicitud_compra,true,'reporte_solicitud_compra','');	
	var CM_getBoton=this.getBoton;
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedor).pagina.btnActualizar();
	}
	
	function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				}
				CM_enableSelect(sel,row,selected);
				
			}		

	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_historico_verificacion_presupuestaria.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	//layout_verificacion_presupuestaria.getVentana().addListener('beforehide',salta);
	
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}