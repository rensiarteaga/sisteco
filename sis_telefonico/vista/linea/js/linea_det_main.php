<?php
/**
 * Nombre:		  	    linea_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:10
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

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
var maestro={
	     	id_tipo_llamada:'<?php echo $m_id_tipo_llamada;?>',nombre_tipo_llamada:'<?php echo $m_nombre_tipo_llamada;?>',descripcion:'<?php echo $m_descripcion;?>'};
var elemento={idContenedor:idContenedor,pagina:new pagina_linea_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_linea_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:10
 */
function pagina_linea_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_linea;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/linea/ActionListarLinea_det.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_linea',
			totalRecords:'TotalCount'
		},[
		'id_linea',
		'empresa',
		'puerto_linea',
		'numero_telefono',
		'costo_segundo',
		'tiempo_espera',
		'observaciones',
		'desc_tipo_llamada',
		'id_tipo_llamada','estado_reg',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},'sim_card'
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_llamada:maestro.id_tipo_llamada
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Id',maestro.id_tipo_llamada],['Nombre',maestro.nombre_tipo_llamada],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	// hidden id_linea
   vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_linea',
			inputType:'hidden',
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_linea'
	};
// txt empresa
	vectorAtributos[1]={
		validacion:{
			name:'empresa',
			fieldLabel:'Empresa',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:130
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.empresa',
		save_as:'txt_empresa'
	};
// txt puerto_linea
	vectorAtributos[2]={
		validacion:{
			name:'puerto_linea',
			fieldLabel:'Línea',
			allowBlank:true,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.puerto_linea',
		save_as:'txt_puerto_linea',
		form:false
	};
// txt numero_telefono
	vectorAtributos[3]={
		validacion:{
			name:'numero_telefono',
			fieldLabel:'Número de Teléfono',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.numero_telefono',
		save_as:'txt_numero_telefono'
	};
// txt numero_telefono
	vectorAtributos[4]={
		validacion:{
			name:'costo_segundo',
			fieldLabel:'Costo por Segundo',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:115
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.costo_segundo',
		save_as:'txt_costo_segundo',
		form:false
	};
	// txt tiempo_espera
	vectorAtributos[5]={
		validacion:{
			name:'tiempo_espera',
			fieldLabel:'Tiempo de Espera',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:115
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.tiempo_espera',
		save_as:'txt_tiempo_espera',
		form:false
	};
	vectorAtributos[6]={
			validacion:{
				name:'sim_card',
				fieldLabel:'Sim Card',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:195
			},
			tipo:'TextField',
			filtro_0:true,
			filterColValue:'COMPON.sim_card',
			save_as:'sim_card'
		};
	vectorAtributos[7]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'LINEA.observaciones',
		save_as:'txt_observaciones'
	};
// txt id_tipo_llamada
	vectorAtributos[8]={
		validacion:{
			name:'id_tipo_llamada',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_llamada,
		save_as:'txt_id_tipo_llamada'
	};
	vectorAtributos[9]= {
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
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				
				grid_indice:10
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'LINEA.estado_reg'
		};
	vectorAtributos[10]= {
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
				width:150,
				disabled:false,
				width_grid:65,

			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'LINEA.fecha_ini',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_ini'
		};


	vectorAtributos[11]= {
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
				width:150,
				disabled:false,
				width_grid:65,

			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'LINEA.fecha_fin',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin'
		};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipos de Llamadas (Maestro)',titulo_detalle:'Lineas (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_linea=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_linea.init(config);	
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_linea,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/linea/ActionEliminarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	Save:{url:direccion+'../../../control/linea/ActionGuardarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	ConfirmSave:{url:direccion+'../../../control/linea/ActionGuardarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Línea'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_llamada=datos.m_id_tipo_llamada;
		maestro.nombre_tipo_llamada=datos.m_nombre_tipo_llamada;
		maestro.descripcion=datos.m_descripcion;
    	gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id',maestro.id_tipo_llamada],['Nombre',maestro.nombre_tipo_llamada],['Descripcion',maestro.descripcion]]);
		vectorAtributos[5].defecto=maestro.id_tipo_llamada;
		paramFunciones={
			btnEliminar:{url:direccion+'../../../control/linea/ActionEliminarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	        Save:{url:direccion+'../../../control/linea/ActionGuardarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	        ConfirmSave:{url:direccion+'../../../control/linea/ActionGuardarLinea.php',parametros:'&m_id_tipo_llamada='+maestro.id_tipo_llamada},
	        Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Línea'}
		};
		this.InitFunciones(paramFunciones);
			ds.lastOptions={
				params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_llamada:maestro.id_tipo_llamada
				}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
		
	};
	
	
    this.getLayout=function(){
		return layout_linea.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	layout_linea.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)	
}