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
		echo "var aux =\"$parametro\";";
		?>
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>

var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_depreciacion_depto_detalle(idContenedor,direccion,paramConfig,aux),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_depreciacion_depto_detalle(idContenedor,direccion,paramConfig,aux)
{	 

	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout;
	var cm,grid; 


	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/depreciacion_depto/ActionListarDepreciacionDeptoDetalle.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_activo_fijo',
					totalRecords : 'TotalCount'
				}, [ 	'id_activo_fijo', 'codigo','codigo_financiador',
						'codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad'
						
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
			name: 'id_activo_fijo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'id_activo_fijo'
	},

	{
			validacion : {
				name : 'codigo',
				fieldLabel : 'C&oacute;digo Activo Fijo',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 110
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'af.codigo',
			form : false
	},

	{
		validacion : {
			name : 'codigo_financiador',
			fieldLabel : 'Financiador',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 90
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'fatram.usuario_reg',
		form : false
	},
	{
		validacion : {
			name : 'codigo_regional',
			fieldLabel : 'Regional',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 90
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'fatram.usuario_reg',
		form : false
	},
	{
		validacion : {
			name : 'codigo_programa',
			fieldLabel : 'Programa',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 90
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'fatram.usuario_reg',
		form : false
	},
	{
		validacion : {
			name : 'codigo_proyecto',
			fieldLabel : 'Proyecto',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 90
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'fatram.usuario_reg',
		form : false
	},
	{
		validacion : {
			name : 'codigo_actividad',
			fieldLabel : 'Actividad',
			align : 'left',
			grid_visible : true,
			grid_editable : false,
			width_grid : 90
		},
		tipo : 'TextField',
		filtro_0 : false,
		filterColValue : 'fatram.usuario_reg',
		form : false
	}];
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
		layout = new DocsLayoutMaestro(idContenedor);
		layout.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		this.pagina = Pagina;
		this.pagina(paramConfig, vectorAtributos, ds, layout,idContenedor);
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
			ds.lastOptions = 
			{
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					m_id_cbte_depto : maestro.id_cbte_depto,
					m_id_grupo_depreciacion : maestro.id_grupo_depreciacion
				}
			};
			
			this.btnActualizar();
		}
		
		
	var paramMenu={	actualizar:{crear:true,separador:false}	};
	function formatDate(value) 
	{
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	
	//datos necesarios para el filtro
	var paramFunciones = 
	{
			btnEliminar : {
				url : direccion+ "../../../control/fase_tramo/ActionEliminarFaseTramo.php"
			},
			Save : {url : direccion+ "../../../control/fase_tramo/ActionGuardarFaseTramo.php"
			},
			ConfirmSave : {url : direccion+ "../../../control/fase_tramo/ActionGuardarFaseTramo.php"
			},
			Formulario : {
				titulo : 'Registro Fase Tramo',
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