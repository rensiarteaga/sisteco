/*** Nombre:		  	    pagina_tipo_adq.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creación:		2010-06-23 11:47:21
*/
function pagina_metodo_depreciacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metodo_depreciacion/ActionListaMetodoDepreciacion.php'}),


		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metodo_depreciacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'descripcion', type: 'string'},
		'id_metodo_depreciacion',
		'descripcion'
		]),remoteSort:true});




		/////////////////////////
		// Definición de datos //
		/////////////////////////
		
		
		
	Atributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_metodo_depreciacion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
			
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_metodo_depreciacion'
	}


	/////////// txt descripcion//////
	Atributos[1] = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripcion',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:400 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_descripcion'
	}



		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Métodos de Depreciación',grid_maestro:'grid-'+idContenedor};
		var layout_metodo_depreciacion=new DocsLayoutMaestro(idContenedor);
		layout_metodo_depreciacion.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_metodo_depreciacion,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_btnEdit=this.btnEdit;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_ocultarComponente=this.ocultarComponente;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_enableSelect=this.EnableSelect;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////




		var paramMenu = {
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear :true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		function iniciarPaginaTipoActivo(){
			for(var i=0;i<Atributos.length-1;i++){
				componentes[i]=getComponente(Atributos[i].validacion.name)
			}
		}


		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/metodo_depreciacion/ActionEliminaMetodoDepreciacion.php'},
			Save:{url:direccion+'../../../control/metodo_depreciacion/ActionSaveMetodoDepreciacion.php'},
			ConfirmSave:{url:direccion+'../../../control/metodo_depreciacion/ActionSaveMetodoDepreciacion.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,
			closable:true,titulo:'Métodos de Depreciación',grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}]}};


			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_parametro_adquisicion.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);

			this.iniciaFormulario();
			iniciarEventosFormularios();

			layout_metodo_depreciacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
			
			
					//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
		//DAT
			
}