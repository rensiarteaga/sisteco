<?php
/**
 * Nombre:		  	    tramo_unidad_constructiva_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-03-31 11:14:15
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
	     	id_tramo:<?php echo $m_id_tramo;?>,codigo:'<?php echo $m_codigo;?>',descripcion:'<?php echo $m_descripcion;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tramo_unidad_constructiva_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_tramo_unidad_constructiva_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-03-31 11:14:15
 */
function pagina_tramo_unidad_constructiva_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tramo_unidad_constructiva/ActionListarTramoUnidadConstructiva_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tramo_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tramo_unidad_constructiva',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_unidad_constructiva',
		'desc_unidad_constructiva',
		'desc_tramo',
		'id_tramo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tramo:maestro.id_tramo
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
//var dataMaestro=[['Id.Tramo',maestro.id_tramo],['Código',maestro.codigo],['Descripción',maestro.descripcion]];

//	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
//	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id.Tramo',maestro.id_tramo],['Código',maestro.codigo],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_unidad_constructiva','codigo','fecha_reg','id_tipo_unidad_constructiva','id_subactividad'])
	});

	//FUNCIONES RENDER
	
	function render_id_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_unidad_constructiva']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tramo_unidad_constructiva
	//en la posición 0 siempre esta la llave primaria

	var param_id_tramo_unidad_constructiva = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tramo_unidad_constructiva',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tramo_unidad_constructiva'
	};
	vectorAtributos[0] = param_id_tramo_unidad_constructiva;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:2,
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TRAUCO.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[1] = param_fecha_reg;
// txt id_unidad_constructiva
	var param_id_unidad_constructiva= {
			validacion: {
			name:'id_unidad_constructiva',
			fieldLabel:'Unidad Constructiva',
			allowBlank:false,			
			emptyText:'Id.UC...',
			desc: 'desc_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_constructiva,
			valueField: 'id_unidad_constructiva',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'UNICON.codigo#UNICON.direccion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_constructiva,
			grid_visible:true,
			grid_editable:true,
			grid_indice:1,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNICON.codigo',
		
		defecto: '',
		save_as:'txt_id_unidad_constructiva'
	};
	vectorAtributos[2] = param_id_unidad_constructiva;
// txt id_tramo
	var param_id_tramo= {
		validacion:{
			name:'id_tramo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tramo,
		save_as:'txt_id_tramo'
	};
	vectorAtributos[3] = param_id_tramo;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Tramos (Maestro)',
		titulo_detalle:'Relación Tramos Unidades Constructivas (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tramo_unidad_constructiva = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tramo_unidad_constructiva.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tramo_unidad_constructiva,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionEliminarTramoUnidadConstructiva.php',parametros:'&m_id_tramo='+maestro.id_tramo},
	Save:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionGuardarTramoUnidadConstructiva.php',parametros:'&m_id_tramo='+maestro.id_tramo},
	ConfirmSave:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionGuardarTramoUnidadConstructiva.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,
	
	
	minWidth:150,minHeight:200,closable:true,titulo: 'tramo_unidad_constructiva'}
	}

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tramo=datos.m_id_tramo;
		maestro.codigo=datos.m_codigo;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tramo:maestro.id_tramo
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id.Tramo',maestro.id_tramo],['Código',maestro.codigo],['Descripción',maestro.descripcion]]);
		vectorAtributos[3].defecto=maestro.id_tramo;
		paramFunciones.btnEliminar.parametros='&m_id_tramo='+maestro.id_tramo;
		paramFunciones.Save.parametros='&m_id_tramo='+maestro.id_tramo;
		paramFunciones.ConfirmSave.parametros='&m_id_tramo='+maestro.id_tramo;
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tramo_unidad_constructiva.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tramo_unidad_constructiva.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}