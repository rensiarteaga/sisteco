/**
 * Nombre:		  	    pagina_tipo_sector_sg_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-11 16:16:52
 */
function pagina_tipo_sector_sg_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_sector_sg/ActionListarTipoSectorSg_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tal_tipo_sector_sg',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tal_tipo_sector_sg',
		'id_tipo_sector',
		'desc_tipo_sector',
		'desc_supergrupo',
		'id_supergrupo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_sector:maestro.id_tipo_sector
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
var dataMaestro=[['Id Tipo Sector',maestro.id_tipo_sector],['Código',maestro.codigo],['Descripción',maestro.descripcion]];

	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_supergrupo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/supergrupo/ActionListarSupergrupo.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_supergrupo',
			totalRecords: 'TotalCount'
		}, ['id_supergrupo','codigo','nombre','descripcion','observaciones','estado_registro','fecha_reg'])
	});

	//FUNCIONES RENDER
	
			function render_id_supergrupo(value, p, record){return String.format('{0}', record.data['desc_supergrupo']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tal_tipo_sector_sg
	//en la posición 0 siempre esta la llave primaria

	var param_id_tal_tipo_sector_sg = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tal_tipo_sector_sg',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tal_tipo_sector_sg'
	};
	vectorAtributos[0] = param_id_tal_tipo_sector_sg;
// txt id_tipo_sector
	var param_id_tipo_sector= {
		validacion:{
			name:'id_tipo_sector',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_sector,
		save_as:'txt_id_tipo_sector'
	};
	vectorAtributos[1] = param_id_tipo_sector;
// txt id_supergrupo
	var param_id_supergrupo= {
			validacion: {
			name:'id_supergrupo',
			fieldLabel:'Super Grupo',
			allowBlank:false,			
			emptyText:'Super Grupo...',
			name: 'id_supergrupo',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_supergrupo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_supergrupo,
			valueField: 'id_supergrupo',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'SUPGRU.codigo#SUPGRU.nombre#SUPGRU.descripcion',
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
			renderer:render_id_supergrupo,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUPGRU.codigo',
		defecto: '',
		save_as:'txt_id_supergrupo'
	};
	vectorAtributos[2] = param_id_supergrupo;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Tipo Sectores (Maestro)',
		titulo_detalle:'Super Grupos - Sector (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tipo_sector_sg = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_sector_sg.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_sector_sg,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tipo_sector_sg/ActionEliminarTipoSectorSg.php'},
	Save:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php'},
	ConfirmSave:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'tipo_sector_sg'}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_sector_sg.getLayout();
	};



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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_sector_sg.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}