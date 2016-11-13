<?php
/**
 * Nombre:		  	    solicitud_compra_serv_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
var maestro={id_cotizacion:<?php echo $id_cotizacion;?>};
//
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new cotizacion_ctto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_solicitud_compra_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 */
function cotizacion_ctto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	var gestion;
	var nombreEtiquetaTipo, nombreEtiquetaItem, mostrarGrid, unidadMedida;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion_ctto/ActionListarCotizacionCtto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion_ctto',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cotizacion_ctto',
		'id_cotizacion',
		'antecedentes',
		'controversias',
		'doc_integrantes',
		{name: 'fecha_ctto',type:'date',dateFormat:'Y-m-d'},
		'garantias',
		'legislacion',
		'multas',
		'nro_contrato',
		'obligaciones',
		
		'controversias',
		'partes',
		'usuario_reg',
		'vigencia',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_cotizacion:maestro.id_cotizacion
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO
   


		/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_cotizacion_ctto',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cotizacion_ctto'
		};


		Atributos[1]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_cotizacion',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				defecto:maestro.id_cotizacion,
				filtro_0:false,
				save_as:'id_cotizacion'
			};
		
		



		// txt num_cotizacion
		Atributos[2]={//==> SI
			validacion:{
				name:'antecedentes',
				fieldLabel:'Antecedentes',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:80,
				width:'40%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'COT.antecedentes',
			save_as:'antecedentes',
			
		};



		Atributos[3]={//==> SI
				validacion:{
					name:'controversias',
					fieldLabel:'controversias',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.controversias',
				save_as:'controversias',
				
			};


		
		Atributos[4]={//==> SI
				validacion:{
					name:'doc_integrantes',
					fieldLabel:'doc_integrantes',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.doc_integrantes',
				save_as:'doc_integrantes',
				
			};


		
		Atributos[5]={//==> SI
				validacion:{
					name:'garantias',
					fieldLabel:'garantias',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.garantias',
				save_as:'garantias',
				
			};

	
		Atributos[6]={//==> SI
				validacion:{
					name:'legislacion',
					fieldLabel:'legislacion',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.legislacion',
				save_as:'legislacion',
				
			};

		Atributos[7]={//==> SI
				validacion:{
					name:'multas',
					fieldLabel:'multas',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.multas',
				save_as:'multas',
				
			};

		
		Atributos[8]={//==> SI
				validacion:{
					name:'obligaciones',
					fieldLabel:'obligaciones',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.obligaciones',
				save_as:'obligaciones',
				
			};

		Atributos[9]={//==> SI
				validacion:{
					name:'partes',
					fieldLabel:'partes',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.partes',
				save_as:'partes',
				
			};


		Atributos[10]={//==> SI
				validacion:{
					name:'vigencia',
					fieldLabel:'vigencia',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:'40%',
					disabled:true,
					grid_indice:2
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'COT.vigencia',
				save_as:'vigencia',
				
			};

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
    
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud Compra (Maestro)',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_cotizacion_ctto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cotizacion_ctto.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_cotizacion_ctto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getColumnModel=this.getColumnModel;
	var getGrid=this.getGrid;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	Save:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	ConfirmSave:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Solicitud',
	
	grupos:[]
	
	}};

	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_cotizacion=datos.id_cotizacion;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_cotizacion:maestro.id_cotizacion
			}
		};

		 
		
		this.btnActualizar();
		iniciarEventosFormularios();

		Atributos[1].defecto=maestro.id_cotizacion;

		
		
		paramFunciones.btnEliminar.parametros='&id_cotizacion='+maestro.id_cotizacion;
		paramFunciones.Save.parametros='&id_cotizacion='+maestro.id_cotizacion;
		paramFunciones.ConfirmSave.parametros='&id_cotizacion='+maestro.id_cotizacion;
		this.InitFunciones(paramFunciones)
	};
	
	

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	
    
	}




	

	
	this.btnNew=function(){
	
	    
			
		CM_btnNew();
		
	}
	
	
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			


			CM_btnEdit();
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cotizacion_ctto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_cotizacion_ctto.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}