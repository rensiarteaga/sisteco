<?php
session_start();
?>

var detalle_movimiento;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		?>
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaCostos(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function PaginaCostos(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_fase_tramo;
	var cm,vista_grid,grid; 
	var combo_item;
	var txt_unidad_medida;
	
	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/costo/ActionListarCosto.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_costo',
					totalRecords : 'TotalCount'
				}, [ 	'id_costo', 'codigo_costo', 'desc_costo',
						'estado','fecha_reg','usuario_reg'
					]),
				remoteSort : true
			});
	//DATA STORE COMBOS

	
	///////////////////////// 
	// Definicion de datos // 
	/////////////////////////
	//en la posici�n 0 siempre esta la llave primaria

	vectorAtributos = [
	 {
		validacion:{
			labelSeparator:'',
			name: 'id_costo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_costo'
	},
	{
		validacion : {
			name : 'codigo_costo',
			fieldLabel : 'Codigo',
			align : 'center',
			lazyRender : true,
			grid_visible : true,
			grid_editable : false,
			width_grid : 130
		},
		tipo : 'TextField',
		filtro_0 : true,
		filterColValue : 'movpr.estado',
		form : true,
		save_as : 'txt_cod_costo'
	},
	{
		validacion:{
			name:'desc_costo', 
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			width:'100%',
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'movpr.concepto_ingreso',
		save_as:'txt_desc_costo'
	},
	{
		validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:true,
		tipo:'ComboBox',
		defecto:'activo',
		filtro_0:true,
		id_grupo:0,
		save_as:'txt_estado',
		filterColValue:'OBJ.estado_reg'
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
			width_grid : 150
		},
		tipo : 'DateField',
		form : false,
		filtro_0 : false,
		filterColValue : 'cos.fecha_reg',
		dateFormat : 'd-m-Y'
	},
	{
		validacion : {
			name : 'usuario_reg',
			fieldLabel : 'Responsable Registro',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 190
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'cos.usuario_reg',
		form : false
	}
	];
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
		layout_fase_tramo = new DocsLayoutMaestro(idContenedor);
		layout_fase_tramo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_fase_tramo,idContenedor);
	// herencia de metodos
	var CM_getComponente = this.getComponente;
	var CM_btnNew = this.btnNew;
	var CM_btnEdit = this.btnEdit;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	var cm_getComponente = this.getComponente;
	var CM_getColumnModel=this.getColumnModel;
	var CM_getColumnNum=this.getColumnNum;
			
//	this.reload = function(m) 
//	{
//		maestro = m;
//		ds.lastOptions = 
//		{
//			params : {
//				start : 0,
//				limit : paramConfig.TamanoPagina,
//				CantFiltros : paramConfig.CantFiltros,
//				id_costeo : maestro.id_costeo
//				}
//		};
//		this.btnActualizar();
//	}
	this.btnEdit = function()
	{ 
			CM_btnEdit();
			
	}
	
	this.btnNew = function() 
	{
		CM_btnNew();		
	}
		
	var paramMenu={
			nuevo:{		crear:true,separador:false	},
			editar:{	crear:true ,separador:false},
			eliminar:{	crear:true,separador:false},
			actualizar:{crear:true,separador:false}
			};
	function formatDate(value) 
	{
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	
	//datos necesarios para el filtro
	var paramFunciones = 
	{
			btnEliminar : {
				url : direccion+ "../../../control/costo/ActionEliminarCosto.php"
			},
			Save : {url : direccion+ "../../../control/costo/ActionGuardarCosto.php"
			},
			ConfirmSave : {url : direccion+ "../../../control/costo/ActionGuardarCosto.php"
			},
			Formulario : {
				titulo : 'Registro Costos',
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
	
		
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	this.getLayout=function(){return layout_fase_tramo.getLayout()};
	this.Init(); //iniciamos la clase madre 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	
	iniciarEventosFormularios();
	layout_fase_tramo.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}