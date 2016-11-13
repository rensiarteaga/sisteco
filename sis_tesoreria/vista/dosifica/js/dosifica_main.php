<?php 
/**
 * Nombre:		  	    dosifica_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 10:19:31
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
var elemento={pagina:new pagina_dosifica(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_dosifica.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 10:19:31
 */
function pagina_dosifica(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/dosifica/ActionListarDosifica.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_dosifica',totalRecords:'TotalCount'
		},[		
		'id_dosifica',
		{name: 'fecha_vence',type:'date',dateFormat:'Y-m-d'},
		'llave_activar',
		'nro_autoriza',
		'nro_inicial',
		'nro_final',
		'estado_dosifica'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	//FUNCIONES RENDER
	// Definición de datos //
	// hidden id_dosifica
	//en la posición 0 siempre esta la llave primaria

	function render_estado_dosifica(value){
		if(value==1){value='Activo' }
		if(value==2){value='Inactivo' }
		
		return value
	}
	
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_dosifica',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_dosifica'
	};
// txt fecha_vence
	Atributos[1]= {
		validacion:{
			name:'fecha_vence',
			fieldLabel:'Fecha Vencimiento',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:130,
			width:120,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOSIFI.fecha_vence',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_vence'
	};
// txt llave_activar
	Atributos[2]={
		validacion:{
			name:'llave_activar',
			fieldLabel:'Llave de Dosificación',
			allowBlank:false,
			maxLength:256,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			//width:100,
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOSIFI.llave_activar',
		save_as:'llave_activar'
	};
// txt nro_autoriza
	Atributos[3]={
		validacion:{
			name:'nro_autoriza',
			fieldLabel:'Nro Autorización',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:120,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOSIFI.nro_autoriza',
		save_as:'nro_autoriza'
	};
// txt nro_inicial
	Atributos[4]={
		validacion:{
			name:'nro_inicial',
			fieldLabel:'Nro Inicial',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:120,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOSIFI.nro_inicial',
		save_as:'nro_inicial'
	};
// txt nro_final
	Atributos[5]={
		validacion:{
			name:'nro_final',
			fieldLabel:'Nro Actual',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:120,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOSIFI.nro_final',
		save_as:'nro_final'
	};

	Atributos[6]={
		validacion:{
			name:'estado_dosifica',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.dosifica_combo.estado_dosifica}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Activo'],['2','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_dosifica,
			grid_editable:false,
			forceSelection:true,
			width_grid:100,
			width:100
		},
		tipo:'ComboBox',
		save_as:'estado_dosifica',
		defecto:'1'
		};

	// ----------            FUNCIONES RENDER    ---------------//
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'dosifica',grid_maestro:'grid-'+idContenedor};
	var layout_dosifica=new DocsLayoutMaestro(idContenedor);
	layout_dosifica.init(config);

	// INICIAMOS HERENCIA //
	
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_dosifica,idContenedor);
	

	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/dosifica/ActionEliminarDosifica.php'},
		Save:{url:direccion+'../../../control/dosifica/ActionGuardarDosifica.php'},
		ConfirmSave:{url:direccion+'../../../control/dosifica/ActionGuardarDosifica.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'dosifica'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){ //para iniciar eventos en el formulario
		txt_nro_inicial=ClaseMadre_getComponente('nro_inicial');
	    txt_nro_final=ClaseMadre_getComponente('nro_final');
	    
	     var onNumeroFinalSelect=function(e){
	     	if(txt_nro_inicial.getValue()!='' && txt_nro_final.getValue()!=''){
			if(txt_nro_inicial.getValue()>=txt_nro_final.getValue()){
				txt_nro_inicial.setValue('');
				Ext.MessageBox.alert('Estado', 'El nro inicial no puede ser mayor al nro final.');
			}
	     	}
						
		};	
		txt_nro_inicial.on('select',onNumeroFinalSelect);
		txt_nro_inicial.on('change',onNumeroFinalSelect);
		txt_nro_final.on('select',onNumeroFinalSelect);
		txt_nro_final.on('change',onNumeroFinalSelect);
		
	    
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_dosifica.getLayout()};
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
	//InitPaginaDosifica();
	iniciarEventosFormularios();
	layout_dosifica.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}