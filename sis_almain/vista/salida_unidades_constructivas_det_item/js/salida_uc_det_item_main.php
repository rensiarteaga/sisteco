<?php
/**
 * Nombre:		  	    tipo_servicio_det_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				UNKNOW
 * Fecha creacion:		06-01-2014
 *
 * _CP.getConfig().ss_tam_pag
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
	var maestro={		
						m_id_salida_uc_detalle:<?php echo $m_id_salida_uc_detalle;?>
						,m_id_unidad_constructiva:'<?php echo $m_id_unidad_constructiva;?>'
						,m_desc_uc:'<?php echo $m_desc_uc;?>'
						
				};
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_salida_uc_det_item(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//<script>
function pagina_salida_uc_det_item(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array;
	var ds;
	
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creaci�n del Data Store

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/salida_unidades_constructivas_det_item/ActionListarSalidaUCDetItem.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_salida_uc_detalle_item',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		'id_salida_uc_detalle_item',
		'id_salida_uc_detalle','cant_sal_uc_detalle','cant_item_uc','demasia_almacen','cantidad_calculada',
		'id_item','desc_item','id_unidad_constructiva','usuario_reg','fecha_reg'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		var data_maestro=[ ['Id. Unidad Constructiva',maestro.m_id_unidad_constructiva+ "                          "],['',''],['Desc. Unidad Constructiva',maestro.m_desc_uc]];
		
	Atributos = 
	[
	 {
		 validacion:{
				labelSeparator:'',
				name: 'id_salida_uc_detalle_item',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false,
				width_grid:80 
			},
			tipo: 'Field',
			save_as:'h_id_salida_uc_detalle_item'
	 },
	 {
		 validacion : {
				name : 'desc_item',
				fieldLabel : 'Item',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 250
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'it.codigo#it.nombre',
			form : false
	 },
	 {
		 validacion : {
				name :'cant_sal_uc_detalle',
				fieldLabel : 'Cant.Salida U.C. ',
				allowBlank : false,  
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				vtype:"texto",
				minValue : '0',
				minValue : '0',
				round : false,
				align : 'right',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width:285
			},
			tipo : 'NumberField',
			filtro_0 : false
	 },
	 {
		 validacion : {
				name :'cant_item_uc',
				fieldLabel : 'Cant.Salida Item U.C.',
				allowBlank : false,  
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				vtype:"texto",
				minValue : '0',
				minValue : '0',
				round : false,
				align : 'right',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width:285
			},
			tipo : 'NumberField',
			filtro_0 : false
	 },
	 {
		 validacion : {
				name :'demasia_almacen',
				fieldLabel : '% Demasia',
				allowBlank : false,  
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				decimalPrecision : 2,
				vtype:"texto",
				minValue : '0',
				minValue : '0',
				round : false,
				align : 'right',
				grid_visible : true,
				grid_editable : true,
				width_grid : 80,
				width:285
			},
			tipo : 'NumberField',
			form:true,
			save_as:'txt_demasia',
			filtro_0 : false
	 },
	 {
		 validacion : {
				name :'cantidad_calculada',
				fieldLabel : 'Total Salida U.C.',
				allowBlank : false,  
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				vtype:"texto",
				minValue : '0',
				minValue : '0',
				round : false,
				align : 'right',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width:285
			},
			tipo : 'NumberField',
			filtro_0 : false
	 },
	 {
		 validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'sucd.usuario_reg',
			form : false
	 },
	 {
		 validacion : {
				name : 'fecha_reg',
				fieldLabel : 'Fecha Registro',
				format : 'd/m/Y',
				minValue : '01/01/1900',
				grid_visible : true,
				grid_editable : false,
				//renderer : formatDate,
				align : 'center',
				width_grid : 95
			},
			tipo : 'TextField',
			form : false,
			filtro_0 : false,
			dateFormat : 'm-d-Y'
	 }
	          
	];
	
	var config = {
			titulo_maestro:"Salida Unidad Constructiva Items (Maestro)",
			titulo_detalle:"Items Salida Unidades Constructivas (Detalle)",
			grid_maestro:'grid-'+idContenedor
		};
		var layout_salida_uc_item= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_salida_uc_item.init(config);
		//////////////////////////////////////////////////////////////
		//---------         INICIAMOS HERENCIA           -----------//
		//////////////////////////////////////////////////////////////

		/// HEREDAMOS DE LA CLASE MADRE
		this.pagina = Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_salida_uc_item,idContenedor);
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var dialog= this.getFormulario;
	var getSelectionModel=this.getSelectionModel;
	var getGrid=this.getGrid;
	
	var paramMenu = {
			guardar:{crear:true,separador:false},
			actualizar:{
				crear :true,
				separador:false
			}};
	
	var paramFunciones = {
			btnEliminar:{url:direccion+"../../../control/salida_unidades_constructivas_det_item/ActionGuardarSalidaUCDetItem.php"},
			Save:{url:direccion+"../../../control/salida_unidades_constructivas_det_item/ActionGuardarSalidaUCDetItem.php"},
			ConfirmSave:{url:direccion+"../../../control/salida_unidades_constructivas_det_item/ActionGuardarSalidaUCDetItem.php"},
			Formulario:{titulo:' Salida Unidades Constructivas Items  ',
				html_apply:"dlgInfo",
				width:520,
				height:190,
				minWidth:150,
				minHeight:200,
				closable:true,
				columnas:[480],
				grupos:[
				{
					tituloGrupo:'Datos',
					columna:0,
					id_grupo:0
				}
				]
			}
		}
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.m_id_salida_uc_detalle=datos.m_id_salida_uc_detalle;
		maestro.m_id_unidad_constructiva=datos.m_id_unidad_constructiva;
		maestro.m_desc_uc=datos.m_desc_uc;

		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_uc_det:maestro.m_id_salida_uc_detalle
				
			}
		};
		this.btnActualizar();
		data_maestro=[ ['Id. Unidad Constructiva ',maestro.m_id_unidad_constructiva+ "                          "],['',''],['Desc. Unidad COnstructiva',maestro.m_desc_uc]]; 
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		
		this.InitFunciones(paramFunciones)
	};
	
	this.getLayout=function(){return layout_salida_uc_item.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

	this.iniciaFormulario();

		//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_uc_det: maestro.m_id_salida_uc_detalle
			} 
	});
	
//	layout_salida_uc_item.getLayout().addListener('layout',this.onResize);
//	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
	layout_salida_uc_item.getLayout().addListener('layout',this.onResize);
	layout_salida_uc_item.getVentana(idContenedor).on('resize',function(){layout_salida_uc_item.getLayout().layout()})
		
}