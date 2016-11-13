<?php 
/**
 * Nombre:		  	    proceso_compra_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 16:28:12
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
var elemento={pagina:new pagina_proceso_compra_mul(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_proceso_compra_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_proceso_compra_mul(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0,cmpIdCategoria;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraMul.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[
		'id_proceso_compra',
		'observaciones',
		'codigo_proceso',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_categoria_adq',
		'desc_categoria_adq',
		'id_moneda',
		'desc_moneda',
		'num_cotizacion',
		'num_proceso',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_cotizacion_sis',
		'num_proceso_sis',
		{name: 'fecha_proc',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_adq',
		'tipo_adq',
		'id_tipo_adq',
		'id_parametro_adquisicion',
		'id_periodo'

		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
		//DATA STORE COMBOS

		var ds_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_adq/ActionListarCategoriaAdq.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_adq',totalRecords: 'TotalCount'},['id_categoria_adq','nombre','precio_min','precio_max','id_moneda','desc_moneda'])
		});

		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});

		var ds_tipo_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_adq/ActionListarTipoAdq.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_adq',totalRecords: 'TotalCount'},['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion','fecha_reg'])
		});

		//FUNCIONES RENDER

		function render_id_categoria_adq(value, p, record){	return String.format('{0}', record.data['desc_categoria_adq'])}
		var tpl_id_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">[{precio_min}  -  {precio_max}] {desc_moneda}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_tipo_adq(value, p, record){return String.format('{0}', record.data['desc_tipo_adq']);}
		var tpl_id_tipo_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');



		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_proceso_compra
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra'
		};
		// txt id_tipo_categoria_adq
		Atributos[1]={
			validacion:{
				name:'id_categoria_adq',
				fieldLabel:'Categoria',
				emptyText:'Categoria...',
				desc: 'desc_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_categoria_adq,
				valueField: 'id_categoria_adq',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'CATADQ.nombre',
				disable:true,
				typeAhead:true,
				tpl:tpl_id_categoria_adq,
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
				editable:true,
				renderer:render_id_categoria_adq,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		// txt id_tipo_adq
		Atributos[2]={
			validacion:{
				name:'id_tipo_adq',
				fieldLabel:'Tipo Adquisicion',
				allowBlank:true,
				emptyText:'Tipo de Adquisicion...',
				desc: 'desc_tipo_adq', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo_adq,
				valueField: 'id_tipo_adq',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'TIPADQ.nombre#TIPADQ.descripcion',
				typeAhead:true,
				tpl:tpl_id_tipo_adq,
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
				editable:true,
				renderer:render_id_tipo_adq,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false,
				grid_indice:15
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'TIPADQ.nombre',
			save_as:'id_tipo_adq'
		};
		// txt codigo_proceso
		Atributos[3]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				allowBlank:false,
				maxLength:20,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};
		// txt id_moneda
		Atributos[4]={
			validacion:{
				name:'id_moneda',
				fieldLabel:'Moneda',
				allowBlank:false,
				emptyText:'Moneda...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
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
				editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
		// txt num_proceso
		Atributos[5]={
			validacion:{
				name:'num_proceso',
				fieldLabel:'Nº Proceso',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};
		// txt num_cotizacion
		Atributos[6]={
			validacion:{
				name:'num_cotizacion',
				fieldLabel:'Nº Cotización',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.num_cotizacion',
			save_as:'num_cotizacion'
		};

		// txt observaciones
		Atributos[7]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				vtype:'texto',
				grid_visible:true,
				allowBlank:false,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};

		// txt fecha_reg
		Atributos[8]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y'
		};

		// txt periodo
		Atributos[9]={
			validacion:{
				name:'periodo',
				fieldLabel:'Periodo',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.periodo',
			save_as:'periodo'
		};
		// txt gestion
		Atributos[10]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestion',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'
		};
		// txt estado_vigente
		Atributos[11]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};


		// txt siguiente_estado
		Atributos[12]={
			validacion:{
				name:'siguiente_estado',
				fieldLabel:'Siguiente Estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.siguiente_estado'
		};

		// txt fecha_reg
		Atributos[13]={
			validacion:{
				name:'fecha_proc',
				fieldLabel:'Fecha Proceso',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'PROCOM.fecha_proc',
			dateFormat:'m-d-Y'
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'proceso_compra',grid_maestro:'grid-'+idContenedor};
		var layout_proceso_compra=new DocsLayoutMaestro(idContenedor);
		layout_proceso_compra.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_proceso_compra,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var Cm_conexionFailure=this.conexionFailure;
	    var cmbtnActualizar=this.btnActualizar;

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
			btnEliminar:{url:direccion+'../../../control/proceso_compra/ActionEliminarProcesoCompraMul.php'},
			Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
			ConfirmSave:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraMul.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			

			
			function btn_solicitud_proceso_compra(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_gestion='+SelectionsRecord.data.gestion;
					data=data+'&m_id_gestion='+SelectionsRecord.data.id_gestion;
					data=data+'&m_id_parametro_adquisicion='+SelectionsRecord.data.id_parametro_adquisicion;
					data=data+'&m_desc_tipo_adq='+encodeURIComponent(SelectionsRecord.data.desc_tipo_adq);
					
					var ParamVentana={Ventana:{width:'90%',height:'90%'}}
					layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/solicitud_proceso_compra/solicitud_proceso_compra.php?'+data,'Solicitudes de Compra',ParamVentana);
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}


			function btn_proceso_compra_det(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_desc_tipo_adq='+SelectionsRecord.data.desc_tipo_adq;

					
					var url='';
					if(SelectionsRecord.data.tipo_adq=='Bien'){
						url='../../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php?'+data;
					}else{
							
						url='../../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_serv_det.php?'+data
						
					}

					
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_proceso_compra.loadWindows(direccion+url,'Procedimiento Detalle',ParamVentana);
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			
		
			
			function btn_fin_pro(){
				var sm=getSelectionModel(), NumSelect=sm.getCount();
				if(NumSelect!=0){
					if(confirm("¿Está seguro de Iniciar el Proceso?")){
						 Ext.Ajax.request({
						 url:direccion+"../../../control/proceso_compra/ActionIniciarProcesoCompra.php",
						 success:cmbtnActualizar,
						 params:{'id_proceso_compra':sm.getSelected().data.id_proceso_compra},
						 failure:Cm_conexionFailure,
						 timeout:paramConfig.TiempoEspera
						})
					}
				}
				else{
					Ext.MessageBox.alert('Estado','Debe seleccionar un Prcoeso.')
				}
			}
			
			

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				cmpIdCategoria=getComponente('id_categoria_adq');
				ocultarComponente(cmpIdCategoria);
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			//para agregar botones		
			this.AdicionarBoton('../../../lib/imagenes/detalle.png','Solicitudes de Compra',btn_solicitud_proceso_compra,true,'solprocom','');
			this.AdicionarBoton('../../../lib/imagenes/detalle.png','Procedimiento Detalle',btn_proceso_compra_det,true,'procomdet','');
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Iniciar el Proceso',btn_fin_pro,true,'finpro','');
		

			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_proceso_compra.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}