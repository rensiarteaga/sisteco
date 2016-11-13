<?php
/**
 * Nombre:		  	    escala_salarial_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-19 10:28:40
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

var elemento={pagina:new pagina_escala_salarial(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);

}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_escala_salarial.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creacón:		2010-08-19 10:28:40
 */
function pagina_escala_salarial(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var cmbTipoEscalaSalarial;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/escala_salarial/ActionListarEscalaSalarial.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_escala_salarial',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_escala_salarial',
		'nombre','nivel','estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'descripcion','sueldo_mensual'
		]),remoteSort:true});

	
	 var ds_rango_ini = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/escala_salarial/ActionListarEscalaSalarial.php?estado_escala=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_escala_salarial',totalRecords: 'TotalCount'},['id_escala_salarial','nombre','nivel','descripcion'])
	    });
	 
	 var ds_rango_fin = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/escala_salarial/ActionListarEscalaSalarial.php?estado_escala=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_escala_salarial',totalRecords: 'TotalCount'},['id_escala_salarial','nombre','nivel','descripcion'])
	    });

	//FUNCIONES RENDER
	
    function render_id_rango_ini(value, p, record){return String.format('{0}', record.data['nivel']);}
    function render_id_rango_fin(value, p, record){return String.format('{0}', record.data['nivel']);}
	
    var tpl_id_rango_ini=new Ext.Template('<div class="search-item">','Nivel: {nivel}<br>','<b><FONT COLOR="#B5A642">{descripcion}</FONT></b>','</div>');
    var tpl_id_rango_fin=new Ext.Template('<div class="search-item">','Nivel: {nivel}<br>','<b><FONT COLOR="#B5A642">{descripcion}</FONT></b>','</div>');
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_escala_salarial
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_escala_salarial',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ESCSAL.nombre'
	};

// txt valor_defecto
	Atributos[2]={
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:2
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ESCSAL.nivel'
	};
	
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ESCSAL.descripcion'
	};
// txt estado_reg
	Atributos[4]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'ESCSAL.estado_reg',
		defecto:'activo'
	};
// txt fecha_reg
	Atributos[5]={
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
			width_grid:100
		},
		tipo:'Field',
		filtro_0:false,
		id_grupo:0,
		form:false,		
		filterColValue:'ESCSAL.fecha_reg',
	};
	
	Atributos[6]={
			validacion:{
				name:'sueldo_mensual',
				fieldLabel:'Sueldo Mensual',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,// para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			defecto:0,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'ESCSAL.sueldo_mensual'
		};
	
	
	
	/***********************************/
	Atributos[7]={
			validacion: {
			name:'id_rango_ini',
			fieldLabel:'Rango Inicial',
			allowBlank:true	,			
			emptyText:'Escala Inicial...',
			desc:'desc_escala_salarial', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rango_ini,
			valueField:'id_escala_salarial',
			displayField:'descripcion',
			filterCol:'ESCSAL.nivel#ESCSAL.nombre#ESCSAL.descripcion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:70,
			pageSize:15,
			minListWidth:70,
			grow:true,
			width:'100%',
			tpl:tpl_id_rango_ini,
			renderer:render_id_rango_ini,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:30 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:true,   
		//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		filterColValue:'ESCSAL.nivel',
		defecto:'',
		form:true,
		id_grupo:1,
		save_as:'id_rango_ini'
		};
	
	
	Atributos[8]={
			validacion: {
			name:'id_rango_fin',
			fieldLabel:'Rango Final',
			allowBlank:true	,			
			emptyText:'Escala Final...',
			desc:'desc_escala_salarial', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rango_fin,
			valueField:'id_escala_salarial',
			displayField:'descripcion',
			filterCol:'ESCSAL.nivel#ESCSAL.nombre#ESCSAL.descripcion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:70,
			pageSize:15,
			minListWidth:70,
			grow:true,
			width:'100%',
			tpl:tpl_id_rango_fin,
			renderer:render_id_rango_fin,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:30 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:true,   
		//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		filterColValue:'ESCSAL.nivel',
		defecto: '',
		form:true,
		id_grupo:1,
		save_as:'id_rango_fin'
		};
	
	Atributos[9]={
			validacion:{
				name:'porcentaje',
				fieldLabel:'Porcentaje(%)',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				maxValue:100,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,// para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:false,
				grid_editable:true,
				width_grid:100,
				width:'50%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			defecto:0,
			filtro_0:true,
			id_grupo:1,
			//filterColValue:'ESCSAL.sueldo_mensual'
		};
	
	
	   Atributos[10]={
			validacion:{
				name:'fecha_aplicacion',
				fieldLabel:'Fecha Aplicacion',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100
			},
			tipo:'DateField',
			filtro_0:false,
			id_grupo:1,
			dateFormat:'m-d-Y',
			form:true	
			//filterColValue:'ESCSAL.fecha_reg',
		};
	
	   
	  
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var layout_escala_salarial = new DocsLayoutMaestro(idContenedor);
	layout_escala_salarial.init({titulo_maestro:'Tipo Planilla (Maestro)',grid_maestro:'grid-'+idContenedor});
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_escala_salarial,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var dialog= this.getFormulario;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getFormulario=this.getFormulario;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},
	nuevo:{crear:true,separador:true},
	editar:{crear:true,separador:false},
	eliminar:{crear:true,separador:false},
	actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/escala_salarial/ActionEliminarEscalaSalarial.php'},
	Save:{url:direccion+'../../../control/escala_salarial/ActionGuardarEscalaSalarial.php'},
	ConfirmSave:{url:direccion+'../../../control/escala_salarial/ActionGuardarEscalaSalarial.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,
		grupos:[{tituloGrupo:'Datos Escala',columna:0,id_grupo:0},
			{tituloGrupo:'Incremento',columna:0,id_grupo:1}
			
			],
		
		titulo:'Escala Salarial'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	
	
	function btn_incremento(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		CM_ocultarGrupo('Datos Escala');
		CM_mostrarGrupo('Incremento');
		CM_btnNew();
			/*var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla;
			data= data +'&id_planilla='+SelectionsRecord.data.id_planilla;
			window.open(direccion+'../../../control/planilla/ActionPDFBoletaPago.php?'+data)*/
		CM_getFormulario().url=direccion+'../../../control/escala_salarial/ActionGuardarEscalaSalarialIncremento.php?';
		
	}
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	};
		
		
	
	this.btnNew=function(){
		//Deshabilita los controles
		CM_ocultarGrupo('Incremento');
		CM_mostrarGrupo('Datos Escala');
		//Llamada a la función de la clase base
		CM_getFormulario().url=direccion+'../../../control/escala_salarial/ActionGuardarEscalaSalarial.php?';
		CM_btnNew();
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		CM_getFormulario().url=direccion+'../../../control/escala_salarial/ActionGuardarEscalaSalarial.php?';
		if(NumSelect!=0){
			CM_ocultarGrupo('Incremento');
			CM_mostrarGrupo('Datos Escala');
			//Habilita y deshabilita el control en función de la definición de la consulta
			var SelectionsRecord=sm.getSelected();
			CM_btnEdit();
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_escala_salarial.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//para agregar botones
	
	
	this.AdicionarBoton('../../../lib/imagenes/arrow-up.gif','Incremento Salarial',btn_incremento,true,'incremento_salarial','');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//this.bloquearMenu();
	layout_escala_salarial.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
	
}