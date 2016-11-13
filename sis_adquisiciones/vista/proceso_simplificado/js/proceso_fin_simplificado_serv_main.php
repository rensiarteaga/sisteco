<?php 
/**
 * Nombre:		  	    proceso_fin_simplificado_serv_main.php
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
var elemento={pagina:new pag_proc_fin_simplif_serv(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_proceso_adjudicacion_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pag_proc_fin_simplif_serv(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on;
	var sw_grup=true,gridG,gSm,ds_g,gDlg;
	var bandera;
	var dialog;
	var adj;
	var id;
	var cont_se_adj;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraDir.php'}),
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
		'id_tipo_adq','id_proceso_compra_ant','num_convocatoria','id_cotizacion','id_moneda_base','numeracion_periodo_proceso','proceso_adjudicado','ejecutado','cantidad_sol','cant_se_adjudica','numeracion_periodo_cotizacion','id_caja','caja','id_cajero','cajero','id_comprador','comprador','monto_proceso','num_sol_por_proc'
		]),remoteSort:true});


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

		Atributos[1]={//18
			validacion:{
				name:'numeracion_periodo_proceso',
				fieldLabel:'Periodo/Nº Proc.',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:95,
				align:'right',
				width:'40%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.periodo#PROCOM.num_proceso',
			save_as:'numeracion_periodo'
		};

		// txt codigo_proceso
		Atributos[2]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:110,
				width:'100%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};

		Atributos[3]={
			validacion:{
				name:'desc_categoria_adq',
				fieldLabel:'Categoria',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};


		Atributos[4]={
			validacion:{
				name:'desc_tipo_adq',
				fieldLabel:'Tipo de Adquisicion',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:115,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'TIPADQ.nombre',
			save_as:'id_tipo_adq'
		};


		// txt id_moneda

		Atributos[5]={
			validacion:{
				name:'desc_moneda',
				fieldLabel:'Moneda',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};

		// txt num_proceso
		Atributos[6]={
			validacion:{
				name:'num_proceso',
				fieldLabel:'Nº Proceso',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};

		// txt fecha_reg
		Atributos[7]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};


		// txt estado_vigente//14
		Atributos[8]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};

		// txt observaciones
		Atributos[9]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};


		Atributos[10]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				width:'40%',
				align:'right',
				disabled:true
				
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'

		};

		
		Atributos[11]={
			validacion:{
				labelSeparator:'',
				name: 'caja',
				fieldLabel:'Caja',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'caja'
		};
		
		
		Atributos[12]={
			validacion:{
				labelSeparator:'',
				name: 'cajero',
				fieldLabel:'Cajero',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'cajero'
		};
	

		Atributos[13]={
			validacion:{
				name:'comprador',
				fieldLabel:'Comprador',
				allowBlank:true,
				maxLength:120,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true

			},
			tipo: 'TextField',
			form:true,
			filtro_0:true,
			filterColValue:'PER_COM.nombre#PER_COM.apellido_paterno#PER_COM.apellido_materno'
		};


		Atributos[14]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprador',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_comprador'
		};
		
		Atributos[15]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Precio Total',
				name: 'monto_proceso',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				//renderer:render_decimales,
				disabled:true,
				allowDecimals:true,
			    decimalPrecision:2,//para numeros float
			    allowNegative:false,
			    
			    maxLength:50,
			    grid_indice:5,
			    width_grid:80,
				align:'right'
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:false,
			save_as:'monto_proceso'
		};
		
		
		Atributos[16]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'SOLCOM.periodo#SOLCOM.num_solicitud',
			save_as:'num_sol_por_proc'
		};
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Adjudicacion',grid_maestro:'grid-'+idContenedor};
		lay_proc_fin_simplif_serv=new DocsLayoutMaestro(idContenedor);
		lay_proc_fin_simplif_serv.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,lay_proc_fin_simplif_serv,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var cm_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnEdit=this.btnEdit;
		var cmbtnActualizar=this.btnActualizar;
		var Cm_getDialog=this.getDialog;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var enableSelect=this.EnableSelect;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={

			actualizar:{crear:true,separador:false}
		};

		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraVale.php'},
			ConfirmSave:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraVale.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Adjudicacion',
			grupos:[{	tituloGrupo:'Proceso',
			columna:0,
			id_grupo:0
			}]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			

			//Para manejo de eventos
			function iniciarEventosFormularios(){
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

					
					var url='../../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_item_det_fin.php?'+data
						
				
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					lay_proc_fin_simplif_serv.loadWindows(direccion+url,'Procedimiento Detalle',ParamVentana);
					lay_proc_fin_simplif_serv.getVentana().on('resize',function(){
						lay_proc_fin_simplif_serv.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function btn_adj_proc(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					
					
					if(NumSelect!=0){
						window.open(direccion+'../../../control/adjudicacion/ActionPDFAdjudicacion.php?m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra+'&tipo=cotizacion');
					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
	                
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
            
			
			
			this.EnableSelect=function(x,z,y){
				enable(x,z,y)
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return lay_proc_fin_simplif_serv.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones
            this.AdicionarBoton('../../../lib/imagenes/detalle.png','Procedimiento Detalle',btn_proceso_compra_det,true,'procomdet','');
			this.AdicionarBoton('../../../lib/imagenes/detalle.png','Adjudicaciones por proceso',btn_adj_proc,true,'adj_proc','');			
            var CM_getBoton=this.getBoton;

			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
					
				}
				enableSelect(sel,row,selected);
			}
			
			this.iniciaFormulario();
			iniciarEventosFormularios();

			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					estado:'finalizado',
					tipo:'servicio'
				}
			});

			lay_proc_fin_simplif_serv.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}