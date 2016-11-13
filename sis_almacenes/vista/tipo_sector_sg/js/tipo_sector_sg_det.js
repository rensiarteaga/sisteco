/**
* Nombre:		  	    pagina_tipo_sector_sg_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-10 18:51:59
*/
function pagina_tipo_sector_sg_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){	
	var vectorAtributos=new Array;
	var ds,ds_supergrupo,layout_tipo_sector_sg,h_txt_descripcion;
	var elementos=new Array();
	var sw=0;
//  DATA STORE //
ds=new Ext.data.Store({
	proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_sector_sg/ActionListarTipoSectorSg_det.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_tal_tipo_sector_sg',
		totalRecords:'TotalCount'
	},[
	'id_tal_tipo_sector_sg',
	'id_tipo_sector',
	'desc_tipo_sector',
	'desc_supergrupo',
	'desc_descripcion_sg',
	'id_supergrupo'
	]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_sector:maestro.id_tipo_sector
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Tipo Sector',maestro.id_tipo_sector],['Código',maestro.codigo],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	ds_supergrupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_supergrupo',
		totalRecords:'TotalCount'
	},['id_supergrupo','codigo','nombre','descripcion','observaciones','estado_registro','fecha_reg'])
	});
	//FUNCIONES RENDER
	function render_id_supergrupo(value,p,record){return String.format('{0}',record.data['desc_supergrupo'])};
	var resultTplSuperGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tal_tipo_sector_sg',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tal_tipo_sector_sg'
	};
	// txt id_tipo_sector
	vectorAtributos[1]={
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
	// txt id_supergrupo
	var filterCols=new Array();
	var filterValues=new Array();
	filterCols[0]='estado_registro';
	filterValues[0]='activo';
	vectorAtributos[2]={
		validacion: {
			name:'id_supergrupo',
			fieldLabel:'Nombre del Super Grupo',
			allowBlank:false,
			emptyText:'Super Grupo...',
			desc:'desc_supergrupo',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			filterCol:'SUPGRU.nombre#SUPGRU.descripcion',
			filterCols:filterCols,
			filterValues:filterValues,
			typeAhead:true,
			forceSelection:false,
			tpl:resultTplSuperGrupo,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:300,
			grow:true,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_supergrupo,
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'SUPGRU.nombre#SUPGRU.descripcion',
		defecto: '',
		save_as:'txt_id_supergrupo'
	};
	// txt descripcion
	vectorAtributos[3]={
		validacion:{
			name:'desc_descripcion_sg',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:350
		},
		tipo:'TextField',
		filtro_0:true,
		defecto:'',
		filterColValue:'SUPGRU.descripcion',
		save_as:'txt_descripcion'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipo de Sector (Maestro)',titulo_detalle:'Super Grupos del Sector (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_tipo_sector_sg=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_sector_sg.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_sector_sg,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_sector_sg/ActionEliminarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
		Save:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
		ConfirmSave:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:400,height:180,minWidth:150,minHeight:200,closable:true,titulo: 'Super Grupos del Sector'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_sector=datos.m_id_tipo_sector;
		maestro.codigo=datos.m_codigo;
		maestro.descripcion=datos.m_descripcion;
		maestro.observaciones=datos.m_observaciones;
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Tipo Sector',maestro.id_tipo_sector],['Código',maestro.codigo],['Descripción',maestro.descripcion]]);
		vectorAtributos[1].defecto=maestro.id_tipo_sector;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/tipo_sector_sg/ActionEliminarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
			Save:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
			ConfirmSave:{url:direccion+'../../../control/tipo_sector_sg/ActionGuardarTipoSectorSg.php',parametros:'&m_id_tipo_sector='+maestro.id_tipo_sector},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:400,height:180,minWidth:150,minHeight:200,closable:true,titulo: 'Super Grupos del Sector'}
		};
		this.InitFunciones(paramFunciones);
		 ds.lastOptions={params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_sector:maestro.id_tipo_sector
			}
		};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		h_txt_descripcion=ClaseMadre_getComponente('desc_descripcion_sg')
	}
	this.btnNew = function(){
		CM_ocultarComponente(h_txt_descripcion);
		ClaseMadre_btnNew()
	};
	this.btnEdit = function(){
		CM_ocultarComponente(h_txt_descripcion);
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_sector_sg.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_sector_sg.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}