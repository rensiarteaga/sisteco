<?php
/**
 * Nombre:		  	    unidad_medida_sec_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 15:29:34
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
     echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
?>	
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_unidad_medida_base:<?php echo $m_id_unidad_medida_base;?>,nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_unidad_medida_sec_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_unidad_medida_sec_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamented
* Fecha creación:		2007-10-17 15:29:35
*/
function pagina_unidad_medida_sec_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_medida_sec/ActionListarUnidadMedidaSec_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_medida_sec',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_unidad_medida_sec',
		'nombre',
		'abreviatura',
		'factor_conv',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_unidad_medida_base',
		'id_unidad_medida_base'
		]),remoteSort:true});
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_unidad_medida_base:maestro.id_unidad_medida_base
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO

		var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
		function italic(value){return '<i>'+value+'</i>';}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({
			fields: ['atributo','valor'],
			data :[['Id Unidad de Medida base',maestro.id_unidad_medida_base],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]
		}),cm:cmMaestro});
		gridMaestro.render();
		//DATA STORE COMBOS
	//FUNCIONES RENDER
	// Definición de datos //
		// hidden id_unidad_medida_sec
		//en la posición 0 siempre esta la llave primaria
		vectorAtributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_unidad_medida_sec',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_unidad_medida_sec'
		};
		// txt nombre
		vectorAtributos[1]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				allowBlank:false,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%'
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'UNMEDS.nombre',
			save_as:'txt_nombre'
		};
		// txt abreviatura
		vectorAtributos[2]={
			validacion:{
				name:'abreviatura',
				fieldLabel:'Abreviatura',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:80
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'UNMEDS.abreviatura',
			save_as:'txt_abreviatura'
		};
		// txt factor_conv
		vectorAtributos[3]={
			validacion:{
				name:'factor_conv',
				fieldLabel:'Factor Conversión',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:110
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'UNMEDS.factor_conv',
			save_as:'txt_factor_conv'
		};
	// txt descripcion
		vectorAtributos[4]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:200,
				width:'100%'
			},
			tipo: 'TextField',
			filtro_0:false,
			filterColValue:'UNMEDS.descripcion',
			save_as:'txt_descripcion'
		};
		// txt observaciones
		vectorAtributos[5]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:200,
				width:'100%'
			},
			tipo: 'TextArea',
			filtro_0:false,
			filterColValue:'UNMEDS.observaciones',
			save_as:'txt_observaciones'
		};

		// txt id_unidad_medida_base
		vectorAtributos[6]={
			validacion:{
				name:'id_unidad_medida_base',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_unidad_medida_base,
			save_as:'txt_id_unidad_medida_base'
		};
		// txt fecha_reg
		vectorAtributos[7]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha de Registro',
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
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'UNMEDS.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
	//----------- FUNCIONES RENDER
		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : '';
		};
		//---------- INICIAMOS LAYOUT DETALLE
		var config={
			titulo_maestro:'Medida Base (Maestro)',
			titulo_detalle:'Medidas secundarias (Detalle)',
			grid_maestro:'grid-'+idContenedor
		};
		layout_unidad_medida_sec = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_unidad_medida_sec.init(config);
		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_unidad_medida_sec,idContenedor);
		//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_save=this.Save;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_ocultarTodosComponente=this.ocultarTodosComponente;
		var CM_mostrarTodosComponente=this.mostrarTodosComponente;
		var ClaseMadre_btnEdit=this.btnEdit;
		var ClaseMadre_btnEliminar = this.btnEliminar;
		var ClaseMadre_btnActualizar = this.btnActualizar;
		//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(params){
			var datos=Ext.urlDecode(decodeURIComponent(params));
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_unidad_medida_base:datos.m_id_unidad_medida_base
				}
			});
			gridMaestro.getDataSource().removeAll();
			gridMaestro.getDataSource().loadData([['Id Unidad de Medida base',datos.m_id_unidad_medida_base],['Nombre',datos.m_nombre],['Descripcion',datos.m_descripcion]]);
			vectorAtributos[6].defecto=datos.m_id_unidad_medida_base;
			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/unidad_medida_sec/ActionEliminarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+datos.m_id_unidad_medida_base},
				Save:{url:direccion+'../../../control/unidad_medida_sec/ActionGuardarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+datos.m_id_unidad_medida_base},
				ConfirmSave:{url:direccion+'../../../control/unidad_medida_sec/ActionGuardarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+datos.m_id_unidad_medida_base},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
				width:480,
				minWidth:150,minHeight:200,closable:true,titulo: 'Unidad de Medida Secundaria'}
			}
			this.InitFunciones(paramFunciones);
		};
		//--------- DEFINICIÓN DE FUNCIONES
		//aquí se parametrizan las funciones que se ejecutan en la clase madre

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/unidad_medida_sec/ActionEliminarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+maestro.id_unidad_medida_base},
			Save:{url:direccion+'../../../control/unidad_medida_sec/ActionGuardarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+maestro.id_unidad_medida_base},
			ConfirmSave:{url:direccion+'../../../control/unidad_medida_sec/ActionGuardarUnidadMedidaSec.php',parametros:'&m_id_unidad_medida_base='+maestro.id_unidad_medida_base},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
			width:480,
			minWidth:150,minHeight:200,closable:true,titulo: 'Unidad de Medida Secundaria'}
		}
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
		function iniciarEventosFormularios()
		{txt_fecha_reg=ClaseMadre_getComponente('fecha_reg')			//para iniciar eventos en el formulario
		}
		this.btnNew = function()
		{	CM_ocultarComponente(txt_fecha_reg);
			ClaseMadre_btnNew()		}
		this.btnEdit = function()
		{	CM_ocultarComponente(txt_fecha_reg);
			ClaseMadre_btnEdit()		}
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_unidad_medida_sec.getLayout()
		};
		//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
			var tam_elementos=elementos.length;
			for(i=0;i<tam_elementos;i++){
				if(elementos[i].idContenedor==idContenedorHijo){
					return elementos[i]}			}
		};
		this.getElementos=function(){return elementos;};
		this.setPagina=function(elemento){elementos.push(elemento);};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones
		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_unidad_medida_sec.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}