/**
 * Nombre:		  	    pagina_lugar_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 16:40:31
 */
function pagina_lugar(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var componentes=new Array();

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'

		}, [
			'id_lugar',
			'fk_id_lugar',
			'desc_lugar',
			'nivel',
			'codigo',
			'nombre',
			'ubicacion',
			'telefono1',
			'telefono2',
			'fax',
			'observacion',
			'sw_municipio'
		]),remoteSort:true});
		
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			txt_usuario:0
			
		}
	});
	
    ds_lugar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar.php?txt_usuario='+0}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, ['id_lugar','fk_id_lugar','nivel','codigo','nombre','ubicacion','telefono1','telefono2','fax','observacion'])
	});

	//FUNCIONES RENDER
	function render_fk_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_lugar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_lugar',
		id_grupo:0
	};
	 
// txt fk_id_lugar
	vectorAtributos[1]= {
			validacion: {
			name:'fk_id_lugar',
			fieldLabel:'Lugar Padre',
			allowBlank:false,			
			emptyText:'Id Lugar Padre...',
			desc: 'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre#LUGARR.ubicacion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_fk_id_lugar,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR_1.nombre',
		defecto: '',
		save_as:'txt_fk_id_lugar',
		id_grupo:1
	};
	
// txt nivel
	vectorAtributos[2]= {
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.nivel',
		save_as:'txt_nivel',
		id_grupo:1
	};
	
// txt codigo
	vectorAtributos[3]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.codigo',
		save_as:'txt_codigo',
		id_grupo:1
	};
	
// txt nombre
	vectorAtributos[4]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Lugar',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.nombre',
		save_as:'txt_nombre',
		id_grupo:1
	};
	
// txt ubicacion
	vectorAtributos[5]= {
		validacion:{
			name:'ubicacion',
			fieldLabel:'Ubicación',
			allowBlank:true,
			maxLength:300,
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
		filterColValue:'LUGARR.ubicacion',
		save_as:'txt_ubicacion',
		id_grupo:2
	};
	
// txt telefono1
	vectorAtributos[6]= {
		validacion:{
			name:'telefono1',
			fieldLabel:'Teléfono Principal',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.telefono1',
		save_as:'txt_telefono1',
		id_grupo:2
	};
	
// txt telefono2
	vectorAtributos[7]= {
		validacion:{
			name:'telefono2',
			fieldLabel:'Teléfono Alternativo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.telefono2',
		save_as:'txt_telefono2',
		id_grupo:2
	};
	
// txt fax
	vectorAtributos[8]= {
		validacion:{
			name:'fax',
			fieldLabel:'Fax',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.fax',
		save_as:'txt_fax',
		id_grupo:2
	};
	
// txt observacion
	vectorAtributos[9]= {
		validacion:{
			name:'observacion',
			fieldLabel:'Observacion',
			allowBlank:true,
			maxLength:500,
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
		filterColValue:'LUGARR.observacion',
		save_as:'txt_observacion',
		id_grupo:3
	};
	

	//txt sw_municipio
	vectorAtributos[10]= {
			validacion: {
			name:'sw_municipio',
			fieldLabel:'Municipio',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.lugar_combo.sw_municipio
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60, // ancho de columna en el gris
			width: '100%',
			vtype:"texto"
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'LUGARR.sw_municipio',
		defecto:'no',
		save_as:'txt_sw_municipio',
		id_grupo:3
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	
	var config = {
		titulo_maestro:'lugar',
		grid_maestro:'grid-'+idContenedor
	};
	layout_lugar=new DocsLayoutMaestro(idContenedor);
	layout_lugar.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_lugar,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_mostrarGrupo= this.ocultarComponente;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_btnEdit=this.btnEdit;

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
		btnEliminar:{url:direccion+'../../../control/lugar/ActionEliminarLugar.php'},
		Save:{url:direccion+'../../../control/lugar/ActionGuardarLugar.php'},
		ConfirmSave:{url:direccion+'../../../control/lugar/ActionGuardarLugar.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'70%',
		width:'40%',
		minWidth:150,minHeight:200,	columnas:['95%'],closable:true,titulo:'Lugar',
		grupos:[
		{	tituloGrupo:'Invisible',
			columna:0,
			id_grupo:0
		},
		{	tituloGrupo:'Datos Generales de Lugar',
			columna:0,
			id_grupo:1
		},
		{	tituloGrupo:'Datos de Ubicación',
			columna:0,
			id_grupo:2
		},
		{	tituloGrupo:'Observaciones de Lugar',
			columna:0,
			id_grupo:3
		}		
		]
		}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.btnNew = function()
	{
//		var sm = getSelectionModel();
//		var filas = ds.getModifiedRecords();
//		var cont = filas.length;
//		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
//		var sw=false;
//
//		var SelectionsRecord  = sm.getSelected();
//		var limpiar = sm.purgeListeners();
//		
//		dialog.resizeTo('40%','70%');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos Generales de Lugar');
		CM_mostrarGrupo('Datos de Ubicación');
		CM_mostrarGrupo('Observaciones de Lugar');
		ClaseMadre_btnNew();
	};
	
	this.btnEdit=function(){
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Datos Generales de Lugar');
		CM_mostrarGrupo('Datos de Ubicación');
		CM_mostrarGrupo('Observaciones de Lugar');
		CM_ocultarComponente('');
		dialog.resizeTo('40%','70%');
		ClaseMadre_btnEdit();
	};

	function InitPaginaLugar()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_lugar.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				InitPaginaLugar();
				layout_lugar.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}