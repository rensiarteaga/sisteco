<?php 
/**
 * Nombre:		  	    rendiciones_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-06 19:01:08
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
var elemento={pagina:new pagina_rendiciones_det_rendi(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_rendiciones_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-06 19:01:08
 */
function pagina_rendiciones_det_rendi(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var maestro;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarRendiciones.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_regis',totalRecords:'TotalCount'
		},[		
		'id_caja_regis',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_cajero',
		'id_fina_regi_prog_proy_acti',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_concepto_ingas',
		'desc_partida_partida',
		'desc_ingas_concepto_ingas',
		'desc_concepto_ingas',
		{name: 'fecha_regis',type:'date',dateFormat:'Y-m-d'},
		'importe_regis',
		'nombre',
		'nombre_unidad',
		'desc_documento',
		'tipo_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'nro_documento',
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'codigo_control',
		'desc_epe',
		'id_presupuesto',
		'desc_presupuesto',
		'concepto_regis',
		'estado_regis'
		
	
		]),remoteSort:true});

	
	

	//FUNCIONES RENDER
	

		
		function negrita(val,cell,record,row,colum,store){
			if(record.get('estado_regis')=='2'){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else{
				return val;
			}
		}
		function renderEstado(value, p, record){	//solo registros diferentes de tesoreria
			if(value == 1){return "Pendiente"}		
			if(value == 2){return "Marcado para contabilizar"}
			if(value == 3){return "En contabilizacion"}
			if(value == 4){return "Finalizado"}
		
		}	

		
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_regis',
			inputType:'hidden'
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_regis'
	};
// txt id_cajero
	Atributos[1]={
			validacion:{
			name:'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Cajero',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:1,
			renderer:negrita		
		},
		tipo:'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre#EMPLEA_1.codigo_empleado'
		
	};

 
Atributos[2]={
			validacion:{
			name:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Presupuesto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			grid_indice:3,
			renderer:negrita		
		},
		tipo:'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto'
	};
// txt id_concepto_ingas
	Atributos[3]={
			validacion:{
			name:'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Concepto Gasto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:4		
		},
		tipo:'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'PARTID_4.desc_partida#CONING_4.desc_ingas'
	};
// txt fecha_regis
	Atributos[4]= {
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:5		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_regis',
		dateFormat:'m-d-Y',
		defecto:''
	};
// txt importe_regis
	Atributos[5]={
		validacion:{
			name:'importe_regis',
			fieldLabel:'Importe Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:12		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.importe_regis'
	};
// txt nombre
	Atributos[6]={
		validacion:{
			name:'nombre',
			fieldLabel:'Moneda',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:5		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'MONEDA.nombre'
	};
// txt nombre_unidad
	Atributos[7]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Caja',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:2,
			renderer:negrita		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG_1.nombre_unidad'
	};
		
	
	Atributos[8]={
			validacion:{
				name:'desc_documento',
				fieldLabel:'Tipo Documento',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:6
			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			save_as:'tipo_documento',
			filterColValue:'PLANTI.desc_plantilla'
		};
// txt fecha_documento
	Atributos[9]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			grid_indice:8		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y'
		
	};
// txt nro_documento
	Atributos[10]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'No Documento',
			allowDecimals:false,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:9		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento'
	};
// txt razon_social
	Atributos[11]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:10		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social'
	};
// txt nro_nit
	Atributos[12]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:11		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit'
	};
// txt nro_autorizacion
	Atributos[13]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'No Autorización',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:13		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion'
	};
// txt codigo_control
	Atributos[14]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de control',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:14		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control'
	};
	
	Atributos[15]={
		validacion:{
			labelSeparator:'',
			name: 'fk_id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'fk_id_caja_regis'
	};
	
	Atributos[16]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Referencias',
			grid_visible:true,
			grid_editable:true,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis'
	};
	
	Atributos[17]={
		validacion:{
			name:'estado_regis',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:7,
			renderer:renderEstado	
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.estado_regis'
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vales de Caja(Maestro)',titulo_detalle:'Rendiciones(Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_rendiciones_det=new DocsLayoutMaestro(idContenedor);
	layout_rendiciones_det.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_rendiciones_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var cm_EnableSelect=this.EnableSelect;
	//var CM_getBoton=this.getBoton;
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:true},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarRendiciones.php'},
		Save:{url:direccion+'../../../control/caja_regis/ActionGuardarRendiciones.php'},
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarRendiciones_rendi.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:420,
		width:'60%',minWidth:150,minHeight:200,	closable:true,titulo:'rendiciones'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.reload=function(m){
				maestro=m;
				
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_fk_id_caja_regis:maestro.id_caja_regis

					}
				};
				this.btnActualizar();
				

				paramFunciones.btnEliminar.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				paramFunciones.Save.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				paramFunciones.ConfirmSave.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				this.InitFunciones(paramFunciones)
			};
	this.EnableSelect=function(sm,row,rec){
	
				
				enable(sm,row,rec);
	}
	this.btnEdit=function(){
		
		
		cm_btnEdit();
	}
	
	function btn_marcar()
	{
		
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
				var sm=getSelectionModel();
				Ext.Ajax.request({
					url:direccion+"../../../control/caja_regis/ActionMarcarRendiciones.php",
					success:esteSuccess,
					params:{'id_caja_regis':sm.getSelected().data.id_caja_regis},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una Rendicion.')
		}		
	}
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	}
		

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rendiciones_det.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Marcar/Desmarcar Rendicion',btn_marcar,true,'marcar','Marcar/Desmarcar Rendicion');
	
	 var CM_getBoton=this.getBoton;
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		if(rec.data['estado_regis']==3||rec.data['estado_regis']==4){
			CM_getBoton('marcar-'+idContenedor).disable();
			CM_getBoton('guardar-'+idContenedor).disable();
			
		}
		else{
			CM_getBoton('marcar-'+idContenedor).enable();
			CM_getBoton('guardar-'+idContenedor).enable();
		}
			
	}
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_rendiciones_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}