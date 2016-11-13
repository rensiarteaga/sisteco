<?php 
/**
 * Nombre:		  	    tipo_descuento_bono_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		17-08-2010
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
var elemento={pagina:new pagina_tipo_descuento_bono(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tipo_descuento_bono.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		17-08-2010
 */
function pagina_tipo_descuento_bono(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_descuento_bono/ActionListarTipoDescuentoBono.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_descuento_bono',totalRecords:'TotalCount'
		},[		
				'id_tipo_descuento_bono','codigo',
		'nombre','descripcion','tipo',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'modalidad','valor_modalidad_porcentual', 'forma_asignacion'
		]),remoteSort:true});

	    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','{simbolo} - {nombre}','</div>');
	

	//FUNCIONES RENDER
	function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else if(value=='inactivo'){value='Inactivo'	}
		return value
	}
	
		function render_tipo(value)
	{
		if(value=='bono'){value='Bono'	}
		else if(value=='descuento'){value='Descuento'	}
		else if(value=='asignacion'){value='Asignacion'	}
		return value
	}
	
	
	function render_forma(value){
		if(value=='individual'){value='Individual'	}
		else if(value=='colectiva'){value='Colectiva'}
		return value
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna_tipo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_descuento_bono',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};

	
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DESBONO.codigo'
		
	};
// txt nombre
	Atributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DESBONO.nombre'
		
	};
	
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DESBONO.descripcion'
		
	};

	Atributos[4]= {
		validacion: {
			name:'tipo',			
			fieldLabel:'Tipo',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['bono','Bono'],['descuento','Descuento'],['asignacion','Asignacion']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_tipo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		filterColValue:'DESBONO.tipo'		
	};
	Atributos[5]= {
		validacion: {
			name:'estado_reg',			
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		filterColValue:'DESBONO.estado_reg'		
	};
	
// txt fecha_reg
	Atributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DESBONO.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:''
		
	};
	
	
	
	
	Atributos[7]= {
		validacion: {
			name:'modalidad',			
			fieldLabel:'Modalidad de Pago',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['efectivo','Efectivo'],['especie','Especie'],['porcentual','Porcentual']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		filterColValue:'DESBONO.modalidad'		
	};
	
	
	Atributos[8]={
		validacion:{
			name:'valor_modalidad_porcentual',
			fieldLabel:'Valor % del basico',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
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
		filterColValue:'DESBONO.valor_modalidad_porcentual'
	};
	
/*	Atributos[9]= {
		validacion: {
			name:'forma_asignacion',			
			fieldLabel:'Forma de Asignación',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['individual','Individual'],['colectiva','Colectiva']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_forma,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		filterColValue:'DESBONO.forma_asignacion'		
	};*/
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Asignaciones',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_descuento_bono=new DocsLayoutMaestro(idContenedor);
	layout_tipo_descuento_bono.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_descuento_bono,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarComponente =this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/tipo_descuento_bono/ActionEliminarTipoDescuentoBono.php'},
		Save:{url:direccion+'../../../control/tipo_descuento_bono/ActionGuardarTipoDescuentoBono.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_descuento_bono/ActionGuardarTipoDescuentoBono.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Asignaciones'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	modalidad=getComponente('modalidad');
	CM_ocultarComponente(getComponente('valor_modalidad_porcentual'));
	
	var onModalidad=function(e){
		if(e.value=='porcentual'){
			CM_mostrarComponente(getComponente('valor_modalidad_porcentual'));
		}else{
			CM_ocultarComponente(getComponente('valor_modalidad_porcentual'));
		}
	}
	modalidad.on('select',onModalidad);
	
	}
	
	this.btnNew=function(){
		btnNew();
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.modalidad=='porcentual'){
				CM_mostrarComponente(getComponente('valor_modalidad_porcentual'));
			}else{
				CM_ocultarComponente(getComponente('valor_modalidad_porcentual'));
			}
			btnEdit();
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_descuento_bono.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_descuento_bono.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}