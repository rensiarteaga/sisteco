/**
 * Nombre:		  	    pagina_metaproceso_envio_alerta_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 09:09:29
 */
function pagina_metaproceso_envio_alerta_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso_envio_alerta/ActionListarMetaprocesoEnvioAlerta_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso_envio_alerta',
			totalRecords: 'TotalCount'

		}, [
			'id_metaproceso_envio_alerta',
			'id_envio_alerta',
			'desc_envio_alerta',
			'desc_metaproceso',
			'id_metaproceso',
			'nombre_corto'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_envio_alerta:maestro.id_envio_alerta,
			txt_metaproceso_envio_alerta:1
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Nombre De Alerta',maestro.nombre_alerta],['Titulo de Mensaje',maestro.titulo_mensaje],['Mensaje',maestro.mensaje]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, ['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones'])
	});

    ds_metaproceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso_det.php?txt_envio_alerta='+maestro.id_envio_alerta}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'
		}, ['id_metaproceso','id_subsistema','fk_id_metaproceso','nivel','nombre','codigo_procedimiento','nombre_achivo','ruta_archivo','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion','visible','habilitar_log','orden_logico','icono','nombre_tabla','prefijo','codigo_base','tipo_vista','con_ep','con_interfaz','num_datos_hijo'])
	});

	//FUNCIONES RENDER
	
	function render_id_metaproceso(value, p, record){return String.format('{0}', record.data['desc_metaproceso']);};
	function render_id_subsistema(value, p, record){return String.format('{0}', record.data['nombre_corto']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_metaproceso_envio_alerta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_metaproceso_envio_alerta'
	};
	 
// txt id_envio_alerta
	vectorAtributos[1]= {
		validacion:{
			name:'id_envio_alerta',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_envio_alerta,
		save_as:'txt_id_envio_alerta'
	};
	

	vectorAtributos[2]= {
			validacion: {
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,			
			emptyText:'Id Subsistema...',
			desc: 'nombre_corto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			onSelect:function(record){
				componentes[2].setValue(record.data.id_subsistema);
				componentes[2].collapse();
				componentes[3].setValue(record.data.id_subsistema);
				onSelectSubsistema();
			},	
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subsistema,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_corto',
		defecto: '',
		save_as:'txt_id_subsistema'
	};
	
		

// txt id_metaproceso
	vectorAtributos[3]= {
			validacion: {
			name:'id_metaproceso',
			fieldLabel:'Metaproceso',
			allowBlank:false,			
			emptyText:'Id Metaproceso...',
			desc: 'desc_metaproceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_metaproceso,
			valueField: 'id_metaproceso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'METPRO.nombre#METPRO.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_metaproceso,
			grid_visible:true,
			grid_editable:true,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre',
		defecto: '',
		save_as:'txt_id_metaproceso'
	};
	

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Envio Alerta (Maestro)',
		titulo_detalle:'Metaproceso Envio Alerta (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_metaproceso_envio_alerta = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_metaproceso_envio_alerta.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_metaproceso_envio_alerta,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_saveSuccess= this.saveSuccess;
	var ClaseMadre_btnActualizar = this.btnActualizar;
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
		btnEliminar:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionEliminarMetaprocesoEnvioAlerta.php',parametros:'&m_id_envio_alerta='+maestro.id_envio_alerta},
		Save:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionGuardarMetaprocesoEnvioAlerta.php',parametros:'&m_id_envio_alerta='+maestro.id_envio_alerta,
		success: miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionGuardarMetaprocesoEnvioAlerta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
					width:'40%',columnas:['95%'],
					minWidth:150,minHeight:200,closable:true,titulo: 'Envio de Alertas a Metaprocesos'}
	};
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_usuario=datos.m_id_usuario;
		maestro.id_persona=datos.m_id_persona;
		maestro.apellido_paterno=datos.m_apellido_paterno;
		maestro.apellido_materno=datos.m_apellido_materno;
		maestro.nombre= datos.m_nombre;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_envio_alerta:maestro.id_envio_alerta,
				txt_metaproceso_envio_alerta:1
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Nombre De Alerta',maestro.nombre_alerta],['Titulo de Mensaje',maestro.titulo_mensaje],['Mensaje',maestro.mensaje]]);
		vectorAtributos[3].defecto=maestro.id_usuario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionEliminarMetaprocesoEnvioAlerta.php',parametros:'&m_id_envio_alerta='+maestro.id_envio_alerta},
			Save:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionGuardarMetaprocesoEnvioAlerta.php',parametros:'&m_id_envio_alerta='+maestro.id_envio_alerta,
			success: miFuncionSuccess},
			ConfirmSave:{url:direccion+'../../../control/metaproceso_envio_alerta/ActionGuardarMetaprocesoEnvioAlerta.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',
				width:'40%',columnas:['95%'],
				minWidth:150,minHeight:200,closable:true,titulo: 'Envio de Alertas a Metaprocesos'}
		};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function miFuncionSuccess(resp){
		
		CM_saveSuccess(resp);
		ClaseMadre_getComponente('id_metaproceso').modificado=true
	}
	//Para manejo de eventos
	
	 function onSelectSubsistema(){
    	ds_metaproceso.baseParams={	m_id_subsistema:componentes[2].getValue()};
        componentes[3].modificado=true;
      	componentes[3].setValue('')
    }
	
	function iniciarEventosFormularios()
	{	for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		sm=getSelectionModel()
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_metaproceso_envio_alerta.getLayout()
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
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_metaproceso_envio_alerta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}