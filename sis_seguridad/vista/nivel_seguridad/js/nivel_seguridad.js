/**
 * Nombre:		  	    pagina_persona_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 17:19:23
 */
function pagina_nivel_seguridad(idContenedor,direccion,paramConfig, tipo)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////


	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nivel_seguridad/ActionListarNivelSeguridad.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_nivel_seguridad',
			totalRecords: 'TotalCount'
		}, [
			'id_nivel_seguridad',
			'codigo',
			'nombre_nivel',
			'prioridad'
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
	/*
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_nivel_seguridad',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_nivel_seguridad'
		
	};*/
	vectorAtributos[0]= {
		validacion:{
			name:'id_nivel_seguridad',
			labelSeparator:'',
			//allowBlank:false,
			
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:'80%'
		},
		tipo: 'Field',
		filterColValue:'NIVEL.id_nivel_seguridad',
		save_as:'id_nivel_seguridad'
		
	};
	
	 
//  nombre_tipo_documento
	vectorAtributos[1]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'80%'
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'NIVEL.codigo',
		save_as:'codigo'
		
	};
	
//  nombre_nivel
	vectorAtributos[2]= {
		validacion:{
			name:'nombre_nivel',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'NIVEL.nombre_nivel',
		save_as:'nombre_nivel'
	};
	
//  nombre_nivel
	vectorAtributos[3]= {
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'NIVEL.prioridad',
		save_as:'prioridad'
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
	//Inicia Layout
	var config = {
		titulo_maestro:'nivel_seguridad',
		grid_maestro:'grid-'+idContenedor
	};

		layout_persona=new DocsLayoutMaestro(idContenedor);
	
	layout_persona.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_persona,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var cm_EnableSelect=this.EnableSelect;
	var cm_DeselectRow=this.DeselectRow;
	var mGrid=this.getGrid;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
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
		btnEliminar:{url:direccion+'../../../control/nivel_seguridad/ActionEliminarNivelSeguridad.php'},
		Save:{url:direccion+'../../../control/nivel_seguridad/ActionGuardarNivelSeguridad.php'},
		ConfirmSave:{url:direccion+'../../../control/nivel_seguridad/ActionGuardarNivelSeguridad.php'},
		
		Formulario:{
			titulo:'Nivel Seguridad',
			html_apply:"dlgInfo-"+idContenedor,
			width:'64%',
			height:'80%',
			minWidth:200,
			minHeight:150,
			columnas:['47%','47%'],
			closable:true,
			upload:false,
			grupos:[
			{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
	}
		sm=getSelectionModel();
		
	}
	
//rac: 16/02/2010	para utlizar combo trigguer 
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
		
	};
	

	this.EnableSelect=function(sm,row,rec){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec); 
		
	}

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_persona.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
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
				
				
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_persona.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				
			    if (_CP.getVentana()){
			    	_CP.getVentana().on('resize',function(){layout_persona.getLayout().layout()})
			    }
			    
				
				
				_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				
					//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
				
				
				
}