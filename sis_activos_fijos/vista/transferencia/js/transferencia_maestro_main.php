<?php 
/**
 * Nombre:		  	    transferencia_maestro_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
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
<?php if($_SESSION["ss_filtro_avanzado"]!='')
{echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
				 TiempoEspera:_CP.getConfig().ss_tiempo_espera,
				 CantFiltros:1,
				 FiltroEstructura:false,
				 FiltroAvanzado:fa};
			
var elemento={pagina:new pagina_transferencia_maestro(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
 */
function pagina_transferencia_maestro(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transferencia/ActionListarTransferencia.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja',totalRecords:'TotalCount'
		},[		
		'id_transferencia',
		'id_empleado_origen',
		'desc_empleado_origen',
		'id_empleado_destino',
		'desc_empleado_destino',
		{name: 'fecha_transferencia',type:'date',dateFormat:'Y-m-d'},
		'estado'
		]),remoteSort:true});

	//DATA STORE COMBOS

     ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_empleado',totalRecords: 'TotalCount'}, ['id_empleado','desc_nombrecompleto'])});
		
	//FUNCIONES RENDER
	
	function renderEmpleadoOrigen(value, p, record){return String.format('{0}', record.data['desc_empleado_origen']);}
	function renderEmpleadoDestino(value, p, record){return String.format('{0}', record.data['desc_empleado_destino']);}	
		
		
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transferencia',
			inputType:'hidden',
			grid_visible:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_transferencia'
	};
	
	

	Atributos[1]={
			validacion:{
				fieldLabel: 'Funcionario Origen',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Empleado...',
				name: 'id_empleado_origen',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_empleado_origen', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField:'desc_nombrecompleto',
				queryParam: 'filterValue_0',
				filterCol:'apellido_paterno',
				//filterCol:'apellido_paterno',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true,
				renderer: renderEmpleadoOrigen,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:250
			},
	        id_grupo: 0,
			tipo: 'ComboBox',
			save_as:'id_empleado_origen'
		};
		
	Atributos[2]={
			validacion:{
				fieldLabel: 'Funcionario Destino',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Empleado...',
				name: 'id_empleado_destino',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_empleado_destino', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField:'desc_nombrecompleto',
				queryParam: 'filterValue_0',
				filterCol:'apellido_paterno',
				//filterCol:'apellido_paterno',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				editable : true,
				renderer: renderEmpleadoDestino,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:250
			},
	        id_grupo: 0,
			tipo: 'ComboBox',
			save_as:'id_empleado_destino'
		};
		
	Atributos[3]={
			validacion:{
				name: 'fecha_transferencia',
				fieldLabel: 'Fecha Transferencia',
				allowBlank: false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				renderer: formatDate,
				width_grid:80
			},
			id_grupo: 0,
			tipo: 'DateField',
			filtro_0:true,
			filterColValue:'fecha_transferencia',
			save_as:'fecha_transferencia',
			dateFormat:'m-d-Y'
		};
		
	
	
		
// txt id_unidad_organizacional

	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name:'estado',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo:'Field',
		form:true
	};
		
	
	//---------- INICIAMOS LAYOUT DETALLE
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	var config={titulo_maestro:'Transferencia',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/transferencia/transferencia_empleado.php'};
	
	var layout_transferencia_maestro=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_transferencia_maestro.init(config);

	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_transferencia_maestro,idContenedor);
	var cm_EnableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	var CM_Save=this.Save;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		
		nuevo:{crear:true,separador:true},
					editar:{crear:true,separador:true},
					eliminar:{crear:true,separador:true},
					actualizar:{crear:true,separador:false}
	};


	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/transferencia/ActionEliminarTransferencia.php'},
		Save:{url:direccion+'../../../control/transferencia/ActionGuardarTransferencia.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'transferencia'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
			_CP.getPagina(layout_transferencia_maestro.getIdContentHijo()).pagina.desbloquearMenu()
		_CP.getPagina(layout_transferencia_maestro.getIdContentHijo()).pagina.reload(rec.data);
				
					
	}	
	function btnFin(){//para iniciar eventos en el formulario
		ClaseMadre_getComponente('estado').setValue('finalizado');
		CM_Save();
	}
	
	function btnRepTransferencia()
	{	var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado
			data = "id_transferencia=" + SelectionsRecord.data.id_transferencia;
			data = data + "&origen=" + SelectionsRecord.data.desc_empleado_origen;
			data = data + "&destino=" + SelectionsRecord.data.desc_empleado_destino;
				
			//alert('pasa fecha');
			window.open(direccion+'../../../control/_reportes/activo_fijo_transferencia_vista/ActionPDFTransferenciaEmpleado.php?'+data);
			
		}

		else
		{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_transferencia_maestro.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	this.iniciaFormulario();
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Formulario de Transferencia',btnRepTransferencia,true,'formulario','Formulario');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Transferencia',btnFin,true,'finalizar','Finalizar Transferencia');
	iniciarEventosFormularios();
	layout_transferencia_maestro.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}