<?php
session_start();
?>
//<script>
var detalle_movimiento;

function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";

		?>

	//
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_detalle_cbte(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_detalle_cbte(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;

	var layout;

	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/cbte_depto/ActionListarCbteDeptoDetalle.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_cbte_depto_det',
					totalRecords : 'TotalCount'
				}, [ 'id_cbte_depto_det', 'id_cbte_depto','id_fina_regi_prog_proy_acti',
						'desc_epe', 'descripcion', 'estado',
						'usuario_reg', 'nombre_financiador', 'nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s'
						}]),
				remoteSort : true
			});

	
	 var ds_ep = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActi.php'}),
					reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','codigo_ep','desc_frppa'])
					});
			
	 function render_ep(value, p, record){return String.format('{0}', record.data['desc_epe']);}
		var tpl_epe=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_ep}</FONT><br>','{desc_frppa}','</div>');

		
	 vectorAtributos[0]={
			 validacion:{
					labelSeparator:'',
					name: 'id_cbte_depto_det',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false,
					width_grid:80 
				},
				tipo: 'Field',
				filtro_0:false,
				save_as : 'h_id_cbtedepto_det'
			 };

	 vectorAtributos[1]={
			 validacion : {
					labelSeparator : '',
					name : 'id_cbte_depto',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'h_id_cbte_depto'
			 };


	 vectorAtributos[2]={
				validacion:{
					name:'id_fina_regi_prog_proy_acti',
					fieldLabel:'Estructura Programática',
					allowBlank: false,
					emptyText:'Estructura Programática...',
					desc: 'desc_epe', //indica la columna del store principal ds del que proviane la descripcion
					store: ds_ep,
					valueField: 'id_fina_regi_prog_proy_acti',
					displayField: 'codigo_ep',
					queryParam: 'filterValue_0',
					filterCol:'FINANC.codigo_financiador#REGION.codigo_regional#PROGRA.codigo_programa#PROYEC.codigo_proyecto#ACTIVI.codigo_actividad',
					typeAhead:false,
					tpl: tpl_epe,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:20,
					minListWidth:'80%',
					//	onSelect:function(record){},
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_ep,
					grid_visible:true,
					grid_editable:false,
					width_grid:230,
					width:250,
					disabled:false
				},
				tipo:'ComboBox',
				form: true,
				filterColValue:'vep.desc_epe',
				save_as:'h_id_epe'
			};
		
	 vectorAtributos[3]={
			 validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : true,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					forceSelection : true,
					width_grid : 200,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'det.descripcion',
				filtro_1 : true,
				form : true,
				save_as : 'txt_descripcion'	
			 };

	 vectorAtributos[4]={
			 validacion : {
					name : 'nombre_financiador',
					fieldLabel : 'Financiador',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : '',
				form : false
			 	
		};

	 vectorAtributos[5]={
			 validacion : {
					name : 'nombre_regional',
					fieldLabel : 'Regional',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : '',
				form : false
			 	
		};

	 vectorAtributos[6]={
			 validacion : {
					name : 'nombre_programa',
					fieldLabel : 'Programa',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : '',
				form : false
			 	
		};

	 vectorAtributos[7]={
			 validacion : {
					name : 'nombre_proyecto',
					fieldLabel : 'Proyecto',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : '',
				form : false
			 	
		};

	 vectorAtributos[8]={
			 validacion : {
					name : 'nombre_actividad',
					fieldLabel : 'Actividad',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : '',
				form : false
			 	
		};

	 vectorAtributos[9]={
				validacion : {
					name : 'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					align : 'center',
					width_grid : 130
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				dateFormat : 'm-d-Y'
				
				};
	 vectorAtributos[10]={
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
				form : false
			};

	 	function formatDate(value) {
			return value ? value.dateFormat('d/m/Y h:i:s'):''};	
	 
		//---------- INICIAMOS LAYOUT DETALLE
		var config = {
				titulo_maestro : 'detalle',
				grid_maestro : 'grid-' + idContenedor
			};
		layout = new DocsLayoutMaestro(idContenedor);
		layout.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////
			this.pagina = Pagina;
			this.pagina(paramConfig, vectorAtributos, ds, layout,
					idContenedor);
		// herencia de metodos
			var CM_getComponente = this.getComponente;
			var CM_btnNew = this.btnNew;
			var CM_btnEdit = this.btnEdit;
			var CM_ocultarComponente = this.ocultarComponente;
			var CM_mostrarComponente = this.mostrarComponente;
			var cm_getComponente = this.getComponente;
			var CM_getColumnModel=this.getColumnModel;
			var CM_getColumnNum=this.getColumnNum;

		this.reload = function(m) 
		{
			maestro = m;
			ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_cbte_depto : maestro.id_cbte_depto
				}
			};
			vectorAtributos[1].defecto = maestro.id_cbte_depto;							
			this.btnActualizar();
		}
		var paramMenu={
				nuevo:{		crear:true,separador:true},
				editar:{crear:true ,separador:false},
				eliminar:{
							crear:true,separador:false
							},
				actualizar:{
							crear:true,separador:false}
		};

		var paramFunciones = {
				btnEliminar : {
					url : direccion
							+ "../../../control/cbte_depto/ActionEliminarCbteDeptoDetalle.php"
				},
				Save : {
					url : direccion
							+ "../../../control/cbte_depto/ActionGuardarCbteDeptoDetalle.php"
				},
				ConfirmSave : {
					url : direccion
							+ "../../../control/cbte_depto/ActionGuardarCbteDeptoDetalle.php"
				},
				Formulario : {
					titulo : 'Registro Detalle',
					html_apply : "dlgInfo-" + idContenedor,
					width : 450,
					height : 250,
					columnas : [ '95%' ],
					closable : true
				}
			};
		function iniciarEventosFormularios()
		{
		}

		this.getLayout=function(){return layout.getLayout()};
		this.Init(); //iniciamos la clase madre 
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		
		this.iniciaFormulario();
		var cm_BloquearMenu = this.BloquearMenu;
		var cm_DesbloquearMenu = this.DesbloquearMenu;
		var cm_getBoton = this.getBoton;

		cm_BloquearMenu();

		iniciarEventosFormularios();
		layout.getLayout().addListener('layout', this.onResize);
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
				this.onResizePrimario);
		
}
