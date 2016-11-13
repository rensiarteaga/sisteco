/**
 * Nombre:		  	    pagina_campo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-30 18:22:18
 */
function pagina_campo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/campo/ActionListarCampo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_campo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_campo',
		'nombre',
		'id_tabla',
		'nombre_metaproceso',
		'descripcion_metaproceso',
		'nombre_tabla',
		'desc_tabla',
		'funcion_grupo',
		'label',
		'width_reporte',
		'funcion',
		'casting',
		'filtro',
		'filtro_grupo',
		'formulario',
		'grupo',
		'dato_descriptivo',
		'grid_indice'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tabla:maestro.id_tabla
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['id_tabla',maestro.id_tabla],['nombre',maestro.nombre],['metaproceso',maestro.desc_metaproceso]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	ds_relacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/desc_tabla/ActionListarDescripcionTabla.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nombre',
			totalRecords: 'TotalCount'
		}, ['nombre','desc'])
	});
	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_campo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_campo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_campo',
		id_grupo:0
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre Campo',
			allowBlank:false,
			emptyText:'campo...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_relacion,
			valueField: 'nombre',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'a.attname',
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
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.nombre',
		save_as:'nombre',
		id_grupo:0
	};
	
	
// txt id_tabla
	Atributos[2]={
		validacion:{
			name:'id_tabla',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tabla,
		save_as:'id_tabla',
		id_grupo:0
	};
// txt funcion_grupo
	Atributos[3]={
			validacion: {
			name:'funcion_grupo',
			fieldLabel:'Función de Grupo',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['count','count'],['sum','sum'],['avg','avg'],['max','max'],['min','min']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.funcion_grupo',
		defecto:'count',
		save_as:'funcion_grupo',
		id_grupo:1
	};
// txt label
	Atributos[4]={
		validacion:{
			name:'label',
			fieldLabel:'label',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.label',
		save_as:'label',
		id_grupo:1
	};
// txt width_reporte
	Atributos[5]={
		validacion:{
			name:'width_reporte',
			fieldLabel:'Ancho Reporte',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:9		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.width_reporte',
		save_as:'width_reporte',
		id_grupo:1
	};
// txt funcion
	Atributos[6]={
		validacion:{
			name:'funcion',
			fieldLabel:'Función Consulta',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:5		
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'CAMTAB.funcion',
		save_as:'funcion',
		id_grupo:1
	};
// txt casting
	Atributos[7]={
		validacion:{
			name:'casting',
			fieldLabel:'Casting',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:6		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.casting',
		save_as:'casting',
		id_grupo:1
	};
// txt filtro
	Atributos[8]={
		validacion:{
			name:'filtro',
			fieldLabel:'Filtro',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'CAMTAB.filtro',
		save_as:'filtro',
		id_grupo:1
	};
// txt filtro_grupo
	Atributos[9]={
		validacion:{
			name:'filtro_grupo',
			fieldLabel:'Filtro Grupo',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:8		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'CAMTAB.filtro_grupo',
		save_as:'filtro_grupo',
		id_grupo:1
	};
// txt formulario
	Atributos[10]={
			validacion: {
			name:'formulario',
			fieldLabel:'Guardar',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['true','true'],['false','false']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'CAMTAB.formulario',
		defecto:'true',
		save_as:'formulario',
		id_grupo:0
	};
// txt grupo
/*	Atributos[11]={
			validacion: {
			name:'grupo',
			fieldLabel:'grupo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['true','true'],['false','false']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.grupo',
		defecto:'true',
		save_as:'grupo',
		id_grupo:0
	};*/
	
	// txt dato_descriptivo
	Atributos[11]={
			validacion: {
			name:'dato_descriptivo',
			fieldLabel:'Dato Descriptivo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['true','true'],['false','false']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.dato_descriptivo',
		defecto:'false',
		save_as:'dato_descriptivo',
		id_grupo:0
	};
	
	Atributos[5]={
		validacion:{
			name:'grid_indice',
			fieldLabel:'Indice del Grid',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'20%',
			disable:false,
			grid_indice:1
				
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAMTAB.grid_indice',
		save_as:'grid_indice',
		id_grupo:0
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tabla (Maestro)',titulo_detalle:'Campo (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_campo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_campo.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_campo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/campo/ActionEliminarCampo.php',parametros:'&m_id_tabla='+maestro.id_tabla},
	Save:{url:direccion+'../../../control/campo/ActionGuardarCampo.php',parametros:'&m_id_tabla='+maestro.id_tabla},
	ConfirmSave:{url:direccion+'../../../control/campo/ActionGuardarCampo.php',parametros:'&m_id_tabla='+maestro.id_tabla},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'campo',
		grupos:[
		{	tituloGrupo:'Parámetros Obligatorios',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Parámetros Opcionales',
			columna:0,
			id_grupo:1
		}]}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_tabla=datos.m_id_tabla;
maestro.nombre=datos.m_nombre;
maestro.desc_metaproceso=datos.m_desc_metaproceso;
		ds_relacion.baseParams={tabla:maestro.nombre};
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tabla:maestro.id_tabla
			}
		};
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['id_tabla',maestro.id_tabla],['nombre',maestro.nombre],['metaproceso',maestro.desc_metaproceso]]);
		Atributos[2].defecto=maestro.id_tabla;

		paramFunciones.btnEliminar.parametros='&m_id_tabla='+maestro.id_tabla;
		paramFunciones.Save.parametros='&m_id_tabla='+maestro.id_tabla;
		paramFunciones.ConfirmSave.parametros='&m_id_tabla='+maestro.id_tabla;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_campo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	ds_relacion.baseParams={tabla:maestro.nombre};
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_campo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}