<?php 
session_start();
?>
//<script>
var paginaSueldo;

function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TamanoPagina:24,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};



var elemento={pagina:new PaginaSueldo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function PaginaSueldo(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds,ds_empleado;
	var combo_empleado;
	var fecha;
	//  DATA STORE      		//
    ds=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/sueldo/ActionListarSueldo.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_sueldo',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name:'descripcion', type:'string'},
		'id_sueldo',
		'id_empleado',
		'desc_empleado',
		'sueldo','tipo_contrato','nombre_cargo'
		]),
		remoteSort:true // metodo de ordenacion remoto
	});
	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			}
	});
/////DATA STORE COMBOS////////////
	ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/sueldo/ActionListarEmpleado.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado',
			totalRecords:'TotalCount'
		},['id_empleado','desc_empleado'])
	});
	function renderEmpleado(value,p,record){return String.format('{0}',record.data['desc_empleado'])}
	// ------------------  PARÁMETROS --------------------------//
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_sueldo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_sueldo'
	};
	///////// txt codigo_empleado//////
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'id_empleado',  
			desc:'desc_empleado',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_empleado',
			filterCol:'EMPLEA.nombre_completo',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:renderEmpleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:220 
			},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'EMPLEA.nombre_completo',
		save_as:'txt_id_empleado'
	};	
/////////// txt sueldo //////
	vectorAtributos[2]={
		validacion:{
			name:'sueldo',
			fieldLabel:'Sueldo',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100,  // ancho de columna en el gris
			align:'right',
			renderer:'usMoney' 
		},
		tipo:'NumberField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		save_as:'txt_sueldo'
	};

	vectorAtributos[3]={
			validacion:{
				name:'nombre_cargo',
				fieldLabel:'Cargo',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:200  // ancho de columna en el gris
				
 
			},
			tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			save_as:'nombre_cargo'
		};
	
	vectorAtributos[4] = {
			validacion:{
				name: 'tipo_contrato',
				fieldLabel: 'Tipo',
				typeAhead: true,
				loadMask: true,
				allowBlank: false,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID', 'nombre'],
					data : [
					        ['consultor', 'Consultor'],
					        ['planta', 'Planta']        
					        ] // from states.js
				}),
				valueField:'ID',
				displayField:'nombre',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:140 // ancho de columna en el grid
				
			},
			
			tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
			save_as:'txt_tipo_contrato',
			defecto:""
		};
		
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={
		titulo_maestro:"Sueldo",
		grid_maestro:"grid-"+idContenedor
	};
	layout_sueldo=new DocsLayoutMaestro(idContenedor);
	layout_sueldo.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_sueldo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	parametrosFiltro="&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/sueldo/ActionEliminarSueldo.php"},
		Save:{url:direccion+"../../../control/sueldo/ActionGuardarSueldo.php"},
		ConfirmSave:{url:direccion+"../../../control/sueldo/ActionGuardarSueldo.php"},
		Formulario:{html_apply:"dlgInfo"+idContenedor,width:310,height:200,minWidth:150,minHeight:200,labelWidth:75,closable:true}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_empleado=ClaseMadre_getComponente('id_empleado')
	}
	this.btnNew=function(){
	ds_empleado.reload();
	combo_empleado.enable();
	ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
	ds_empleado.reload();
	combo_empleado.disable();
	ClaseMadre_btnEdit()
	};
	this.SaveAndOther=function(){
	ds_empleado.reload();
	combo_empleado.enable();
	ClaseMadre_SaveAndOther()
	};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_sueldo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}