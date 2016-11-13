<?php
/**
 * Nombre:		  	    detalle_beneficiarios_gral_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				José Mita
 * Fecha creación:		2011-06-14 14:51:07
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
/*var maestro={id_archivo_control:<?php echo $id_archivo_control;?>,id_archivo_control:decodeURIComponent('<?php echo $id_archivo_control;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';*/
var elemento={pagina:new pagina_detalle_beneficiario_gral(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	   pagina_detalle_beneficiario_gral.js
 * Propósito: 			pagina objeto principal
 * Autor:				José Mita 
 * Fecha creación:		2011-06-13 17:51:07
 */
function pagina_detalle_beneficiario_gral(idContenedor,direccion,paramConfig) //,maestro,idContenedorPadre
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/detalle_beneficiario_gral/ActionListarDetalleBeneficiariosGral.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_beneficiario_vejez',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_beneficiario_vejez',
				'beneficiario',
				'codigo_control_factura_ben',
				'consumo',
				'estado',
				{name: 'fecha_nacimiento',type:'date',dateFormat:'m-d-Y'}, //Y-m-d'fecha_nacimiento',
				'id_archivo_control',
				'id_cliente',
				'id_lectura',
				'importe_des_direc',
				'importe_des_indirec',
				'importe_facturado',
				'numero_autorizacion_fecha_ben',
				'numero_factura_ben',
				'numero_ident',
				'tipo_identificacion',
				'regional'
					
		
		]),remoteSort:true});
	
		
	// DEFINICIÓN DATOS DEL MAESTRO

	/*function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_reclamo',maestro.id_reclamo],['nro_reclamo',maestro.nro_reclamo],['nombre_reclamante',maestro.nombre_reclamante]];
	*/
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	function render_estado(value, p, record)
	{				
		if(value == 1)
		{return "Inactivo"}
		if(value == 0)
		{return "Activo"}	
		return 'OTRO';		
	}
	

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_respuesta_reclamo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_beneficiario_vejez',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	Atributos[1]={
			validacion:{
				labelSeparator:'',
				name: 'id_archivo_control',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
	
	Atributos[2]={
			validacion:{
				labelSeparator:'',
				name: 'id_cliente',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
	
	Atributos[3]={
			validacion:{
				labelSeparator:'',
				name: 'id_lectura',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

	Atributos[4]={
			validacion:{
				name:'beneficiario',
				fieldLabel:'Beneficiario',
				allowBlank:false,
				grid_visible:true,
				grid_editable:false,
				width:'100%',
				width_grid:200		
			},
			tipo:'TextArea',
			filtro_0:true,
			form:true,		
			filterColValue:'beneficiario',
			id_grupo:1
		};
		
	Atributos[5]= {
			validacion:{
				name:'fecha_nacimiento',
				fieldLabel:'Fecha Nacimiento',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion			
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:false				
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'fecha_nacimiento',
			dateFormat:'m-d-Y',
			defecto:'',	
			id_grupo:1
		};
	
	Atributos[6]={
			validacion:{
				name:'tipo_identificacion',
				fieldLabel:'Tipo Identificacion',
				allowBlank:false,
				grid_visible:true,
				grid_editable:false,
				width:'100%',
				width_grid:100		
			},
			tipo:'TextArea',
			filtro_0:true,
			form:true,		
			filterColValue:'tipo_identificacion',
			id_grupo:1
		};
	
	Atributos[7]={
			validacion:{
				name:'numero_ident',
				fieldLabel:'Número Identificación',
				allowBlank:false,
				grid_visible:true,
				grid_editable:false,
				width:'100%',
				width_grid:100		
			},
			tipo:'TextArea',
			filtro_0:true,
			form:true,		
			filterColValue:'numero_ident',
			id_grupo:1
		};
	
	Atributos[8]={
			validacion:{
				name:'consumo',
				fieldLabel:'Consumo',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'consumo',
			id_grupo:0
		};
	
	Atributos[9]={
			validacion:{
				name:'importe_des_direc',
				fieldLabel:'Importe Descuento Direc',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'importe_des_direc',
			id_grupo:0
		};
	
	Atributos[10]={
			validacion:{
				name:'importe_des_indirec',
				fieldLabel:'Importe Descuento Indirec',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'importe_des_indirec',
			id_grupo:0
		};
	
	Atributos[11]={
			validacion:{
				name:'importe_facturado',
				fieldLabel:'Importe Facturado',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'importe_facturado',
			id_grupo:0
		};
	
	Atributos[12]={
			validacion:{
				name:'numero_factura_ben',
				fieldLabel:'Número Factura',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'numero_factura_ben',
			id_grupo:0
		};
	
	Atributos[13]={
			validacion:{
				name:'codigo_control_factura_ben',
				fieldLabel:'Código Control',
				allowBlank:false,
				grid_visible:true,
				grid_editable:false,
				width:'100%',
				width_grid:100		
			},
			tipo:'TextArea',
			filtro_0:true,
			form:true,		
			filterColValue:'codigo_control_factura_ben',
			id_grupo:1
		};
	
	Atributos[14]={
			validacion:{
				name:'numero_autorizacion_fecha_ben',
				fieldLabel:'Número Autorización',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'numero_autorizacion_fecha_ben',
			id_grupo:0
		};
	
	
	Atributos[15]={
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','ACTIVO'],['1','INACTIVO']]}), // 
				valueField:'id',
				displayField:'valor',
				renderer: render_estado,
				lazyRender:true,
				forceSelection:true,
				width_grid:170,
				width:300,
				grid_visible:false,
				grid_editable:false,
				grid_indice:13,
				disabled:false		
			},
			tipo:'ComboBox',
			form:true,
			id_grupo:1,
			filtro_0:false,
			filterColValue:'estado'		
		};
	Atributos[16]={
			validacion:{
				name:'regional',
				fieldLabel:'Regional',
				allowBlank:false,
				grid_visible:true,
				grid_editable:false,
				width:'100%',
				width_grid:100		
			},
			tipo:'TextArea',
			filtro_0:true,
			form:true,		
			filterColValue:'regional'
		};

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Recuperación Vejez (Maestro)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_beneficiarios_gral = new DocsLayoutMaestro(idContenedor);
	layout_detalle_beneficiarios_gral.init(config);
	
		
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_beneficiarios_gral,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
    
	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/detalle_beneficiario_gral/ActionEliminarDetalleBeneficiarioGral.php'},
	Save:{url:direccion+'../../../control/detalle_beneficiario_gral/ActionGuardarDetalleBeneficiarioGral.php'},
	ConfirmSave:{url:direccion+'../../../control/detalle_beneficiario_gral/ActionGuardarDetalleBeneficiarioGral.php'},
	
	Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		grupos:[
		{tituloGrupo:'Oculto',columna:0,id_grupo:0},
		{tituloGrupo:'Detalle Beneficiario',columna:0,id_grupo:1}		
		],		
		height:550, //alto
		width:480,  //ancho
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Respuesta '}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m)
	{		
		maestro=m;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_archivo_control:maestro.id_archivo_control
			}
		};
		
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_archivo_control;

		paramFunciones.btnEliminar.parametros='&id_archivo_control='+maestro.id_archivo_control;
		paramFunciones.Save.parametros='&id_archivo_control='+maestro.id_archivo_control;
		paramFunciones.ConfirmSave.parametros='&id_archivo_control='+maestro.id_archivo_control;
		this.InitFunciones(paramFunciones)
	};

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	//para iniciar eventos en el formulario
		CM_ocultarGrupo('Oculto');
	
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_beneficiarios_gral.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_detalle_beneficiarios_gral.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
