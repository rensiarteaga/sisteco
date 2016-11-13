<?php 
/**
 * Nombre:		  	    parametro_bancarizacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		13.07.2015
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
var elemento={pagina:new pagina_parametro_bancarizacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_parametro_bancarizacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		13.07.2015
 */
function pagina_parametro_bancarizacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_bancarizacion/ActionListarParametroBancarizacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_parametro_bancarizacion',totalRecords:'TotalCount'
		},[		
				'id_parametro_bancarizacion',
		'monto',
		'id_moneda',
		'estado_reg',
		{name:'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg','desc_moneda'
		]),remoteSort:true});


	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});

	function render_id_moneda(value, p, record){ 
	    if(record.data.id_moneda!=''){
	          if(record.modified){
	                return String.format('{0}',ds_moneda.getById(value).data.nombre);
	          }
	          else{
	                return String.format('{0}', record.data['desc_moneda']);
	          }
		}else{
	      	 var cadena='falta definir';
		     return '<span style="color:red;font-size:8pt">' +cadena + '</span>';
	    }
	}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{simbolo}</FONT>','</div>');
	
	

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro_bancarizacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_parametro_bancarizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_parametro_bancarizacion'
	};

	Atributos[1]={
			validacion:{
				name:'monto',
				fieldLabel:'Importe',
				allowBlank:true,
				align:'center', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PARBAN.monto',
			save_as:'monto'
		};



	Atributos[2]={
			validacion:{
				name:'id_moneda',
				fieldLabel:'Moneda',
				allowBlank:true,
				emptyText:'Moneda...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField:'id_moneda',
				displayField:'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:true,
				tpl:tpl_id_moneda,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				//editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
				
			},
			tipo:'ComboBox',
			form: true,
			
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
			
		};
	Atributos[3]={
			validacion:{
				name:'estado_reg',
				fieldLabel:'Estado',
				vtype:'texto',
				emptyText:'Estado...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['valor'],data:[['activo'],['inactivo']]}),
				valueField:'valor',
				displayField:'valor',
				grid_visible:true,
				grid_editable:false,
				forceSelection:true,
				width:100,
				width_grid:80
			},
			tipo:'ComboBox',
			defecto:"",
			save_as:'estado_reg'
		};
		

	Atributos[4]= {//==>SI
			validacion:{
				name:'fecha_ini',
				fieldLabel:'Fecha Inicio',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PARBAN.fecha_ini',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_ini'
			
		};


	Atributos[5]= {//==>SI
			validacion:{
				name:'fecha_fin',
				fieldLabel:'Fecha Fin',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PARBAN.fecha_fin',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin'
			
		};


	Atributos[6]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'fecha_reg',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate
			},
			tipo: 'Field',
			filtro_0:false,
			
			save_as:'num_proceso'
		};

	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'parametro_bancarizacion',grid_maestro:'grid-'+idContenedor};
	var layout_parametro_bancarizacion=new DocsLayoutMaestro(idContenedor);
	layout_parametro_bancarizacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro_bancarizacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro_bancarizacion/ActionEliminarParametroBancarizacion.php'},
		Save:{url:direccion+'../../../control/parametro_bancarizacion/ActionGuardarParametroBancarizacion.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro_bancarizacion/ActionGuardarParametroBancarizacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Bancarizacion'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		txt_fecha_fin=getComponente ('fecha_fin');
		txt_estado_reg=getComponente ('estado_reg');


		var onEstado=function(e){
			if (e.value=='inactivo'){
				txt_fecha_fin.allowBlank=false;
			}else{
				txt_fecha_fin.allowBlank=true;
			}
		}
		
		txt_estado_reg.on('change',onEstado);
	}

	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_fin);
		CM_ocultarComponente(txt_estado_reg);
		txt_fecha_fin.allowBlank=true;
		txt_estado_reg.allowBlank=true;
		CM_btnNew()
	
	};


	this.btnEdit=function(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		CM_mostrarComponente(txt_fecha_fin);
		CM_mostrarComponente(txt_estado_reg);
	
		CM_btnEdit()
		
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_parametro_bancarizacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_parametro_bancarizacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}