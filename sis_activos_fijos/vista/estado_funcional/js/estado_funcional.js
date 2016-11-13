/**
 * Nombre:		  	    pagina_estado_funcional_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Williams Escobar
 * Fecha creación:		2011-01-07 17:43:08
 */
function pagina_estado_funcional(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_funcional/ActionListaEstadoFuncional.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_estado_funcional',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_estado_funcional',
			'codigo',
			'descripcion',			
			'estado'
			]),remoteSort:true});
			
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	/////////////////////////
	// Definición de datos //
	/////////////////////////
//id_estado_funcional
	vectorAtributos[0]= {
	validacion:{
		labelSeparator:'',
		name: 'id_estado_funcional',
		inputType:'hidden',
		grid_visible:false,
		grid_editable:false
	},
	tipo: 'Field',
	filtro_0:false,
	save_as:'id_estado_funcional'
};
		//codigo
	vectorAtributos[1]= {
			validacion:{
				labelSeparator:'',
				name:'codigo',
				fieldLabel:'Codigo: ',
				allowBlank:false,
				inputType:'',
				maxLength:10,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:150,
				grid_indice:1
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'codigo',
			save_as:'codigo'
		};
	//txt estado
	vectorAtributos[2]= {
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				maxLength:4,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:80,
					width:40,
					disabled:false,
					grid_indice:2	
				},
			tipo: 'Field',
			form:false,
			filtro_0:false,
			save_as:'estado'
		};
	// txt descripcion
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion: ',
			allowBlank:true,
			grid_visible:true,
			width_grid:200,
			witdh:300,
			grid_indice:3	
		},	
		form:true,
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'descripcion',
		save_as:'descripcion'			
	};	 
	 
//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	//function formatDate(value){
		//return value?value.dateFormat('d/m/Y'):''};


		//---------- INICIAMOS LAYOUT DETALLE
		//var config={titulo_maestro:'tipo_accion',grid_maestro:'grid-'+idContenedor};
		var config={titulo_maestro:'Estado Funcional',grid_maestro:'grid-'+idContenedor};
		
		//var layout_tipo_adq=new DocsLayoutMaestro(idContenedor);
		var layout_estado_funcional=new DocsLayoutMaestro(idContenedor);
		layout_estado_funcional.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		
		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,vectorAtributos,ds,layout_estado_funcional,idContenedor);
		var getComponente=this.getComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_conexionFailure=this.conexionFailure;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var Cm_getDialog=this.getDialog;
		var ClaseMadre_getComponente=this.getComponente;

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
			btnEliminar:{url:direccion+'../../../control/estado_funcional/ActionEliminaEstadoFuncional.php'},
			Save:{url:direccion+'../../../control/estado_funcional/ActionSaveEstadoFuncional.php'},
			ConfirmSave:{url:direccion+'../../../control/estado_funcional/ActionSaveEstadoFuncional.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Datos de Estado Funcional'}};
		
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
	
		
		//function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		//xt_empleado_sel=ClaseMadre_getComponente('empleado_sel');
		// txt_criterio=ClaseMadre_getComponente('criterio');
		//var getComponente=this.getComponente;
		//  txt_empleado_sel.on('select',onEstadoSelect);
		//}
		
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			}
		});
		
	///parametros de la pagina
		this.getLayout=function(){return layout_estado_funcional.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);	//para agregar botones		
		this.iniciaFormulario();
		layout_estado_funcional.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	}