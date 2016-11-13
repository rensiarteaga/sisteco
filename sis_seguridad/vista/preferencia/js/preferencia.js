/**
 * Nombre:		  	    pagina_preferencia_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 15:55:25
 */
function pagina_preferencia(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////

	ds = new Ext.data.Store({
		
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia/ActionListarPreferencia.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_preferencia',
			totalRecords: 'TotalCount'
		}, [
			'id_preferencia',
			'nombre_modulo',
			'descripcion_modulo'
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
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_preferencia',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_preferencia'
	};
	 
// txt nombre_modulo
	vectorAtributos[1]= {
		validacion:{
			name:'nombre_modulo',
			fieldLabel:'Nombre Módulo',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PREFER.nombre_modulo',
		save_as:'txt_nombre_modulo',
		id_grupo:0
	};
	
// txt descripcion_modulo
	vectorAtributos[2]= {
		validacion:{
			name:'descripcion_modulo',
			fieldLabel:'Descripción Módulo',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PREFER.descripcion_modulo',
		save_as:'txt_descripcion_modulo',
		id_grupo:0
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	
	var config = {
		titulo_maestro:'preferencia',
		grid_maestro:'grid-'+idContenedor
	};
	layout_preferencia=new DocsLayoutMaestro(idContenedor);
	layout_preferencia.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_preferencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/preferencia/ActionEliminarPreferencia.php'},
		Save:{url:direccion+'../../../control/preferencia/ActionGuardarPreferencia.php'},
		ConfirmSave:{url:direccion+'../../../control/preferencia/ActionGuardarPreferencia.php'},
		Formulario:{
			titulo:'Preferencia del Usuario',
			html_apply:"dlgInfo-"+idContenedor,
			width:'50%',
			height:'34%',
			minWidth:200,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Preferencia',
				columna:0,
				id_grupo:0
			}
			]
		}
		};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_preferencia_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_preferencia='+SelectionsRecord.data.id_preferencia;
			data=data+'&m_nombre_modulo='+SelectionsRecord.data.nombre_modulo;
			data=data+'&m_descripcion_modulo='+SelectionsRecord.data.descripcion_modulo;

			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_preferencia.loadWindows(direccion+'../../../vista/preferencia_detalle/preferencia_detalle_det.php?'+data,'Preferencia Detalle',ParamVentana);
			layout_preferencia.getVentana().on('resize',function(){
			layout_preferencia.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_preferencia.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Preferencia',btn_preferencia_detalle,true,'preferencia_detalle','Detalle');

				this.iniciaFormulario();
				
				layout_preferencia.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}