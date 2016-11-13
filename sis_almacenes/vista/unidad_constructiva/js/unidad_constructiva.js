/**
 * Nombre:		  	    pagina_unidad_constructiva_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-03-31 11:16:49
 */
function pagina_unidad_constructiva(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_unidad_constructiva',
		'codigo',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tipo_unidad_constructiva',
		'desc_tipo_unidad_constructiva',
		'desc_subactividad',
		'id_subactividad'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    ds_tipo_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_tipo_unidad_constructiva','codigo','nombre','tipo','descripcion','observaciones','fecha_reg','estado'])
	});

    ds_subactividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/subactividad/ActionListarSubactividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subactividad',
			totalRecords: 'TotalCount'
		}, ['id_subactividad','codigo','direccion','descripcion','observaciones','fecha_reg','id_prog_proy_acti'])
	});

	//FUNCIONES RENDER
	
			function render_id_tipo_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_tipo_unidad_constructiva']);}
			function render_id_subactividad(value, p, record){return String.format('{0}', record.data['desc_subactividad']);}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_unidad_constructiva
	//en la posición 0 siempre esta la llave primaria

	var param_id_unidad_constructiva = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_unidad_constructiva',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_unidad_constructiva'
	};
	vectorAtributos[0] = param_id_unidad_constructiva;
// txt codigo
	var param_codigo= {
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNICON.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[1] = param_codigo;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNICON.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[2] = param_fecha_reg;
// txt id_tipo_unidad_constructiva
	var param_id_tipo_unidad_constructiva= {
			validacion: {
			name:'id_tipo_unidad_constructiva',
			fieldLabel:'Id.Tipo Unidad Constructiva',
			allowBlank:false,			
			emptyText:'Id.Tipo Unidad Constructiva...',
			desc: 'desc_tipo_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_unidad_constructiva,
			valueField: 'id_tipo_unidad_constructiva',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'TIPOUC.codigo#TIPOUC.nombre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_unidad_constructiva,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPOUC.codigo',
		defecto: '',
		save_as:'txt_id_tipo_unidad_constructiva'
	};
	vectorAtributos[3] = param_id_tipo_unidad_constructiva;
// txt id_subactividad
	/*var param_id_subactividad= {
			validacion: {
			name:'id_subactividad',
			fieldLabel:'Id.Subactividad',
			allowBlank:false,			
			emptyText:'Id.Subactividad...',
			desc: 'desc_subactividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subactividad,
			valueField: 'id_subactividad',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'SUBACT.codigo#SUBACT.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subactividad,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.codigo',
		defecto: '',
		save_as:'txt_id_subactividad'
	};
	vectorAtributos[4] = param_id_subactividad;*/

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
		titulo_maestro:'unidad_constructiva',
		grid_maestro:'grid-'+idContenedor
	};
	layout_unidad_constructiva=new DocsLayoutMaestro(idContenedor);
	layout_unidad_constructiva.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_unidad_constructiva,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/unidad_constructiva/ActionEliminarUnidadConstructiva.php'},
		Save:{url:direccion+'../../../control/unidad_constructiva/ActionGuardarUnidadConstructiva.php'},
		ConfirmSave:{url:direccion+'../../../control/unidad_constructiva/ActionGuardarUnidadConstructiva.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,
			minWidth:150,minHeight:200,	closable:true,titulo:'unidad_constructiva'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_unidad_constructiva.getLayout();};
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

				layout_unidad_constructiva.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}