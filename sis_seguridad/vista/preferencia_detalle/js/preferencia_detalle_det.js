/**
 * Nombre:		  	    pagina_preferencia_detalle_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 15:55:40
 */
function pagina_preferencia_detalle_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/preferencia_detalle/ActionListarPreferenciaDetalle_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_preferencia_detalle',
			totalRecords: 'TotalCount'

		}, [
			'id_preferencia_detalle',
			'nombre_atributo',
			'valor_atributo',
			'descripcion_atributo',
			'desc_preferencia',
			'id_preferencia'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_preferencia:maestro.id_preferencia
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Preferencia',maestro.id_preferencia],['Nombre Módulo',maestro.nombre_modulo],['descripcion_modulo',maestro.descripcion_modulo]]}),cm:cmMaestro});
	gridMaestro.render();

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_preferencia_detalle',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_preferencia_detalle'
	};
	
// txt nombre_atributo
	vectorAtributos[1]= {
		validacion:{
			name:'nombre_atributo',
			fieldLabel:'Nombre Atributo',
			allowBlank:false,
			maxLength:20,
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
		filterColValue:'PREDET.nombre_atributo',
		save_as:'txt_nombre_atributo',
		id_grupo:0
	};
	
// txt valor_atributo
	vectorAtributos[2]= {
		validacion:{
			name:'valor_atributo',
			fieldLabel:'Valor Atributo',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PREDET.valor_atributo',
		save_as:'txt_valor_atributo',
		id_grupo:0
	};
	
// txt descripcion_atributo
	vectorAtributos[3]= {
		validacion:{
			name:'descripcion_atributo',
			fieldLabel:'Descripción Atributo',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PREDET.descripcion_atributo',
		save_as:'txt_descripcion_atributo',
		id_grupo:0
	};
	
// txt id_preferencia
	vectorAtributos[4]= {
		validacion:{
			name:'id_preferencia',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_preferencia,
		save_as:'txt_id_preferencia'
	};
		
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Preferencia del Usuario (Maestro)',
		titulo_detalle:'Preferencia Detalle (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_preferencia_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_preferencia_detalle.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_preferencia_detalle,idContenedor);
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
  var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/preferencia_detalle/ActionEliminarPreferenciaDetalle.php',parametros:'&m_id_preferencia='+maestro.id_preferencia},
	Save:{url:direccion+'../../../control/preferencia_detalle/ActionGuardarPreferenciaDetalle.php',parametros:'&m_id_preferencia='+maestro.id_preferencia},
	ConfirmSave:{url:direccion+'../../../control/preferencia_detalle/ActionGuardarPreferenciaDetalle.php'},
	Formulario:{
			titulo:'Detalle de Preferencia',
			html_apply:"dlgInfo-"+idContenedor,
			width:'50%',
			height:'46%',
			minWidth:200,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos del detalle de preferencia',
				columna:0,
				id_grupo:0
			}
			]
		}
	
	};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_preferencia=datos.m_id_preferencia;
		maestro.nombre_modulo=datos.m_nombre_modulo;
		maestro.descripcion_modulo=datos.m_descripcion_modulo;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_preferencia:maestro.id_preferencia
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Preferencia',maestro.id_preferencia],['Nombre Módulo',maestro.nombre_modulo],['descripcion_modulo',maestro.descripcion_modulo]]);
		vectorAtributos[4].defecto=maestro.id_preferencia;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/preferencia_detalle/ActionEliminarPreferenciaDetalle.php',parametros:'&m_id_preferencia='+maestro.id_preferencia},
			Save:{url:direccion+'../../../control/preferencia_detalle/ActionGuardarPreferenciaDetalle.php',parametros:'&m_id_preferencia='+maestro.id_preferencia},
			ConfirmSave:{url:direccion+'../../../control/preferencia_detalle/ActionGuardarPreferenciaDetalle.php'},
			Formulario:{
					titulo:'Detalle de Preferencia',
					html_apply:"dlgInfo-"+idContenedor,
					width:'50%',
					height:'46%',
					minWidth:200,
					minHeight:150,
					columnas:['95%'],
					closable:true,
					grupos:[
					{
						tituloGrupo:'Datos del detalle de preferencia',
						columna:0,
						id_grupo:0
					}
				]
			}
	
		};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.getLayout=function(){
		return layout_preferencia_detalle.getLayout();
	};

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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	
	layout_preferencia_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}