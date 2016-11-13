<?php 
session_start();
?>
//<script>

function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

	var fa=false;
	<?php
	if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={
		TamanoPagina:30,
		TiempoEspera:100000000,
		CantFiltros:1,
		FiltroEstructura:false,
		FiltroAvanzado:fa,
			grid_html:'grid-'+idContenedor
	};
	var elemento={pagina:new paginaDosifica(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function paginaDosifica(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var ds_param;
	var parametrosFiltro;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/dosifica/ActionListarDosifica.php'}),
			reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_dosifica',totalRecords: 'TotalCount' 
		},[
		{name: 'clave_activa', type: 'string'},
		'id_dosifica',
		'tipo_fac',
		'nro_autoriza',
		{name: 'fecha_vence', type: 'date', dateFormat: 'Y-m-d'}, 
		'clave_activa',
		'sw_debito',
		'nro_inicial',
		'nro_actual',
		'actividad',
		'leyenda',
		'estado',		
		'desc_usr_reg',
		'fecha_reg'
		]),
		remoteSort: true 
	});

	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	/////////////////////////
	//   PARÁMETROS        //
	// Definición de datos //
	/////////////////////////

	//DATA STORE COMBOS
	
	////////////////FUNCIONES RENDER ////////////
	function renderTipo_fac(value, p, record){
		if(value == 1){return "Factura"}
		if(value == 2){return "Nota Débito/Crédito"}
	}
	
	function renderEstado(value, p, record){
		if(value == 1){return "Vigente"}
		if(value == 2){return "Inactivo"}
	}

	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_dosifica',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_dosifica'
	}

	// hidden id_cuenta  
	vectorAtributos[1]= {
		validacion: {
			name: 'tipo_fac',
			fieldLabel: 'Dosificación de',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : Ext.dosificacionCombo.tipo_Fact 
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			renderer: renderTipo_fac,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:150,
			width:200 
		},
		tipo:'ComboBox',
		filtro_0:false,
		defecto: '1',
		save_as:'txt_tipo_fac'
	}
	
	// txt nro Autoriza
	vectorAtributos[2]= {
		validacion:{
			name: 'nro_autoriza',
			fieldLabel: 'Nro. Autorización',
			allowBlank: false,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			grid_visible:true, 
			grid_editable:false, 
			width_grid:150,
			width:200, 
			disabled: false			
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOS.nro_autoriza',
		save_as:'txt_nro_autoriza'
	};
	
	// txt fecha_vence
	vectorAtributos[3]= {
		validacion:{
			name: 'fecha_vence',
			fieldLabel: 'Fecha Vencimiento',
			allowBlank: false,
			format: 'd/m/Y', 
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer: formatDate,
			align: 'center',
			width_grid:150
		},
		tipo: 'DateField',
		filtro_0:false,
		save_as:'txt_fecha_vence',
		dateFormat:'m-d-Y' 
	};
	
	// txt clave activa
	vectorAtributos[4]= {
		validacion:{
			name: 'clave_activa',
			fieldLabel: 'Llave de Dosificación',
			labelSeparator:'',
			allowBlank:false,
			maxLength:256,
			minLength:1,
			selectOnFocus:true,
			grid_editable:false, 
			grid_editable:false, 
			width_grid:250, 
			width: '100%',
			disabled:false
		},
		tipo: 'TextArea',
		filtro_0:false,
		filterColValue:'DOS.clave_activa',
		save_as:'txt_clave_activa'
	};
	
	vectorAtributos[5]={
		validacion: {
			name: 'sw_debito',
			fieldLabel:'Debito Fiscal',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),		
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			align: 'center',
			width_grid:100,
			width: 100,
			forceSelection:true,
			grid_visible:true, 
			grid_editable:false 
		},
		tipo:'ComboBox',
		save_as:'txt_sw_debito',
		filterColValue:'DOS.sw_debito'
	};	
	
	// txt nro inicial 
	vectorAtributos[6] = {
		validacion: {
			name: 'nro_inicial',
			fieldLabel: 'Nro. Inicial',
			allowBlank: false,
			maxLength:9,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			align: 'right',
			grid_visible:true, 
			grid_editable:false, 
			width_grid:100,
			width:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'dos.nro_inicial',
		save_as:'txt_nro_inicial'
	}
	
	// txt nro actual 
	vectorAtributos[7] = {
		validacion: {
			name: 'nro_actual',
			fieldLabel: 'Nro. Actual',
			allowBlank: false,
			maxLength:9,
			minLength:0,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			align: 'right',
			grid_visible:true, 
			grid_editable:false, 
			width_grid:100,
			width:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOS.nro_actual',
		save_as:'txt_nro_actual'
	}
	
	// txt actividad
	vectorAtributos[8]= {
		validacion:{
			name: 'actividad',
			fieldLabel: 'Actividad',
			labelSeparator:'',
			allowBlank:false,
			maxLength:256,
			minLength:1,
			selectOnFocus:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:250, 
			width: '100%',
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'DOS.actividad',
		save_as:'txt_actividad'
	};
	
	// txt leyenda
	vectorAtributos[9]= {
		validacion:{
			name: 'leyenda',
			fieldLabel: 'Leyenda',
			labelSeparator:'',
			allowBlank:false,
			maxLength:256,
			minLength:1,
			selectOnFocus:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:250, 
			width: '100%',
			disabled:false
		},
		tipo: 'TextArea',
		filtro_0:false,
		filterColValue:'DOS.leyenda',
		save_as:'txt_leyenda'
	};
	
	// combo estado
	vectorAtributos[10] 	= {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: true,
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : Ext.dosificacionCombo.estado 
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderEstado,
			forceSelection:true,
			grid_visible:true, 
			grid_editable:false, 
			align: 'center',
			width_grid:70, 
			width:100
		},
		tipo:'ComboBox',
		filtro_0:false,
		form:false,
		save_as:'txt_estado'
	};
	
	vectorAtributos[11]={
		validacion:{			
			name:'desc_usr_reg',
			fieldLabel:'Usuario Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'DOS.desc_usr_reg'
	};
	
	vectorAtributos[12]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:110		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'DOS.fecha_reg'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	}
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Dosificacion",
		grid_maestro:"grid-"+idContenedor
	};
	layout_dosificacion = new DocsLayoutMaestro(idContenedor);
	layout_dosificacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_dosificacion,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE --------------------//
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_save=this.Save;

	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+"../../../control/dosifica/ActionEliminarDosifica.php"
		},
		Save:{
			url:direccion+"../../../control/dosifica/ActionGuardarDosifica.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/dosifica/ActionGuardarDosifica.php"
		},
		Formulario:{
			titulo:' Registro de Dosificacion',
			html_apply:"dlgInfo-"+idContenedor,
			width:450,
			height:450,
			minWidth:150,
			minHeight:200,
			columnas:['95%'],
			closable:true,
			guardar:miGuardar
		}
	};

	//Funcion para convertir los caracteres especiales introducidos por el usuario
	function miGuardar()
	{	var decodificado;
		componente=ClaseMadre_getComponente('clave_activa');
		decodificado=componente.getValue();		
		decodificado=decodificado.replace(/&/g,"?amp;");
		   while(decodificado.indexOf('+')!=-1){
		         decodificado=decodificado.replace('+',"?mas;");
		}
		componente.setValue(decodificado);
		ClaseMadre_save()
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	this.iniciaFormulario();
	layout_dosificacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}