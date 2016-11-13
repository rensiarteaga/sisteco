<?php
/**
 * Nombre:		  	    proceso_compra_mul_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-20 17:42:42
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	id_proceso_compra:<?php echo $m_id_proceso_compra;?>,
	codigo_proceso:decodeURIComponent('<?php echo $m_codigo_proceso;?>'),
	desc_moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>'),
	desc_tipo_adq:decodeURIComponent('<?php echo $m_desc_tipo_adq;?>')}
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_proceso_compra_mul_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);



/**
* Nombre:		  	    pagina_proceso_compra_mul_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-20 17:42:43
*/
function pagina_proceso_compra_mul_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra_det/ActionListarProcesoCompraMulDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proceso_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_proceso_compra_det',
		'id_servicio',
		'desc_servicio',
		'id_item',
		'desc_item',
		'cantidad',
		'precio_referencial_total',
		'id_proceso_compra',
		'desc_proceso_compra',
		'estado_reg'

		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proceso_compra:maestro.id_proceso_compra
			}
		});
		// DEFINICIÓN DATOS DEL MAESTRO

		var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
		function italic(value){return '<i>'+value+'</i>';}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['id_proceso_compra',maestro.id_proceso_compra],['Código de Proceso',maestro.codigo_proceso],['Moneda',maestro.desc_moneda],['Tipo Adquisición',maestro.desc_tipo_adq]]}),cm:cmMaestro});
		gridMaestro.render();

		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_proceso_compra_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_proceso_compra_det',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra_det'
		};
		// txt id_servicio
		Atributos[1]={
			validacion:{
				name:'desc_servicio',
				fieldLabel:'Servicio',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
				
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SERVIC.nombre'
		};
		// txt id_item
		Atributos[2]={
			validacion:{
				name:'desc_item',
				fieldLabel:'Item',
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'ITEM.codigo',
			id_grupo:1
		};
		// txt cantidad
		Atributos[3]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				grid_visible:true,
				grid_editable:false,
				width_grid:100				
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOMDET.cantidad'
		};
		// txt precio_referencial_total
		Atributos[4]={
			validacion:{
				name:'precio_referencial_total',
				fieldLabel:'Precio Ref. Total',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
				
			},
			tipo:'Field',
			form:true,
			filtro_0:true,
			filterColValue:'PROCOMDET.precio_referencial_total'
		};
		// txt id_proceso_compra
		Atributos[5]={
			validacion:{
				name:'id_proceso_compra',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_proceso_compra,
			save_as:'id_proceso_compra'
		};
		// txt estado_reg
		Atributos[6]={
			validacion:{
				name:'estado_reg',
				fieldLabel:'Estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOMDET.estado_reg'
		};


		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Iniciar Procedimiento de Compra Múltiple (Maestro)',titulo_detalle:'Procedimiento Detalle (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_proceso_compra_mul_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_proceso_compra_mul_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_proceso_compra_mul_det,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/proceso_compra_mul_det/ActionEliminarProcesoCompraMulDet.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra_mul_det'}};

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));

				maestro.id_proceso_compra=datos.m_id_proceso_compra;
				maestro.desc_tipo_categoria_adq=datos.m_desc_tipo_categoria_adq;
				maestro.codigo_proceso=datos.m_codigo_proceso;
				maestro.desc_moneda=datos.m_desc_moneda;
				maestro.id_tipo_adq=datos.m_id_tipo_adq;
				maestro.desc_tipo_adq=datos.m_desc_tipo_adq;
				Atributos[5].defecto=maestro.id_proceso_compra;
				

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_proceso_compra:maestro.id_proceso_compra
					}
				};
				this.btnActualizar();
				gridMaestro.getDataSource().removeAll();
				gridMaestro.getDataSource().loadData([['id_proceso_compra',maestro.id_proceso_compra],['Código de Proceso',maestro.codigo_proceso],['Moneda',maestro.desc_moneda],['Tipo Adquisición',maestro.desc_tipo_adq]]);

				paramFunciones.btnEliminar.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra;
				this.InitFunciones(paramFunciones)
			};
			function btn_caracteristica(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra_det='+SelectionsRecord.data.id_proceso_compra_det;
					data=data+'&m_precio_referencial_total='+SelectionsRecord.data.precio_referencial_total;
					data=data+'&m_id_servicio='+SelectionsRecord.data.id_servicio;
					data=data+'&m_id_item='+SelectionsRecord.data.id_item;

					var ParamVentana={ventana:{width:'90%',height:'70%'}};
					layout_proceso_compra_mul_det.loadWindows(direccion+'../../../sis_adquisiciones/vista/caracteristica/caracteristica.php?'+data,'Características Detalle',ParamVentana);
					layout_proceso_compra_mul_det.getVentana().on('resize',function(){
						layout_proceso_compra_mul_det.getLayout().layout();
					})
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}
			function btn_grupo_sp_det(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra_det='+SelectionsRecord.data.id_proceso_compra_det;
					data=data+'&m_precio_referencial_total='+SelectionsRecord.data.precio_referencial_total;
					data=data+'&m_id_servicio='+SelectionsRecord.data.id_servicio;
					data=data+'&m_id_item='+SelectionsRecord.data.id_item;

					var ParamVentana={ventana:{width:'90%',height:'70%'}};
					layout_proceso_compra_mul_det.loadWindows(direccion+'../../../sis_adquisiciones/vista/grupo_sp_det/grupo_sp_det.php?'+data,'Detalle Agrupación',ParamVentana);
					layout_proceso_compra_mul_det.getVentana().on('resize',function(){
						layout_proceso_compra_mul_det.getLayout().layout();
					})
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra_mul_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Características Detalle',btn_caracteristica,true,'caracteristica','');

			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Detalle Agrupación',btn_grupo_sp_det,true,'grupo_sp_det','');

			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_proceso_compra_mul_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}