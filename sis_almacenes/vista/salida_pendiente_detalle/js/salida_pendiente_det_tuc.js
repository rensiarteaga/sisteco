function pagina_aprobacion_det_tuc(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=[];

	var cmpCantidad;
	var cmpRepeticion;
	var cmpId_tuc_r;
	var Dialog;
	var layout;

	//DATA STORE COMBOS

	ds_unidad_cons_reemp = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTUCReemplazo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, ['id_tipo_unidad_constructiva','codigo','nombre','tipo','descripcion','observaciones','fecha_reg'])
	});

	var resultTpl = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{codigo}</i></b>',
	'<b><br><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
	'</div>'
	);

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Salida',maestro.id_salida],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();




	//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo','id_reg');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		raiz:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tucr.png",
			allowDelete:false,
			allowEdit:true

		},
		rama:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tuc.png",
			allowDelte:true,
			allowEdit:true
		},
		item:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDelete:true,
			allowEdit:true
		}


	}

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo:'Pedido de Unidades Constructivas'
	};
	layout_tuc=new DocsLayoutArb(idContenedor);
	layout_tuc.init(config);
	layout=layout_tuc.getLayout();


	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_tuc,idContenedor,DatosNodo,DatosDefecto);


	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var guardarSuccess=this.guardarSuccess;
	var getDialog=this.getDialog;
	var ocultarFormulario=this.ocultarFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var getFormulario=this.getFormulario;
	var CM_btnEdit=this.btnEdit;
	
	/////////////////////////////
	// parametros las funciones//
	////////////////////////////


	var paramFunciones={
		Listar:{
			url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionListaPedidoDetalleEntregadosUcArb.php',
			baseParams:{id_salida:maestro.id_salida},
			allowDrag:false,
			allowDrop:false,
			clearOnLoad:true,
			//id:'id',
			text:'Mi Pedido',
			rootVisible:true,
			lines:true,
			cls:'root'
		}
	};
	
						//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_salida=datos.m_id_salida;
	    maestro.descripcion=datos.m_descripcion;
	    maestro.estado_reg=datos.m_estado_reg;
	    
	    gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Salida',maestro.id_salida],['Descripción',maestro.descripcion]]);
		
		
		paramFunciones.Listar.baseParams={id_salida:maestro.id_salida};
		this.InitFunciones(paramFunciones);
		this.getLoader().baseParams.id_salida=maestro.id_salida;
		this.btnActualizar()
		
	};

	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={		
		actualizar:{crear:true,separador:false}
	};



	function iniciarEventos(){

		var treLoader=getLoader();
		
		treLoader.on("beforeload", function(treeLoader,naux){
			var id_reg;
			while(naux.parentNode){
				if(naux.parentNode.id=='id'){
					id_reg=naux.attributes.id_reg
				}
				naux=naux.parentNode
			}
			treeLoader.baseParams.id_reg=id_reg
		}, this);

	}
	//menu contextual
	this.prepareCtx= function(node,e){
		node.select();
		getCtxMenu().items.get('remove')['disable']();
		getCtxMenu().items.get('reload')[!node.leaf ? 'enable' : 'disable']();
	
		getCtxMenu().showAt(e.getXY());
	};


	this.getLayout=function(){
		return layout;
	};
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos();
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);


}