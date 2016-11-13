/**
 * Nombre:		  	    pagina_partida.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 11:38:59
 */
function pagina_partida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){

	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?tipo_partida='+2}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'
		},[		
		'id_partida',
		'codigo_partida',
		'nombre_partida',
		'nivel_partida',
		'sw_transaccional',
		'tipo_partida',
		'id_parametro',
		'desc_parametro',
		'id_partida_padre',
		'tipo_memoria',
		'desc_partida'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_concepto_colectivo:maestro.id_concepto_colectivo
		}
	});
	
		// DEFINICIÓN DATOS DEL MAESTRO

	function tabular(n)
{ if (n>=0)	{return "  "+tabular(n-1)}
else return "  "
}
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Concepto Colectivo','  '+maestro.desc_colectivo+tabular(51-maestro.desc_colectivo.length)],['Estado','  '+maestro.estado_colectivo+tabular(maestro.estado_colectivo.length)],
	 ['Responsable',maestro.desc_usuario]];
	
	//DATA STORE COMBOS 
    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?tipo_partida=+2'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria'])
	});

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?tipo_partida='+2}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria'])
	});

	//FUNCIONES RENDER
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');

	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion_pres}</FONT><br>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');

	function render_id_partida_padre(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida_padre=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida'
	};
// txt codigo_partida
	Atributos[1]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disable:true		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida',
		save_as:'codigo_partida'
	};
// txt nombre_partida
	Atributos[2]={
		validacion:{
			name:'nombre_partida',
			fieldLabel:'Partida',
			allowBlank:true,
			maxLength:75,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disable:true		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida',
		save_as:'nombre_partida'
	};
// txt nivel_partida
	Atributos[3]={
		validacion:{
			name:'nivel_partida',
			fieldLabel:'Nivel',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			disable:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARTID.nivel_partida',
		save_as:'nivel_partida'
	};
// txt sw_transaccional
	Atributos[4]={
		validacion:{
			name:'sw_transaccional',
			fieldLabel:'Transaccional',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARTID.sw_transaccional',
		save_as:'sw_transaccional'
	};
// txt tipo_partida
	Atributos[5]={
		validacion:{
			name:'tipo_partida',
			fieldLabel:'Tipo Partida',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARTID.tipo_partida',
		save_as:'tipo_partida'
	};
// txt id_parametro
	Atributos[6]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Parametro',
			allowBlank:true,			
			emptyText:'Parametro...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:false,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			disable:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
// txt id_partida_padre
	Atributos[7]={
			validacion:{
			name:'id_partida_padre',
			fieldLabel:'Partida Padre',
			allowBlank:true,			
			emptyText:'Partida Padre...',
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'codigo_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida#PARTID.nivel_partida',
			typeAhead:true,
			tpl:tpl_id_partida_padre,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_partida_padre,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'PARTID.codigo_partida',
		save_as:'id_partida_padre'
	};
	// txt tipo_memoria
	Atributos[8]={
		validacion:{
			name:'tipo_memoria',
			fieldLabel:'Tipo Memoria',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARTID.tipo_memoria',
		save_as:'tipo_memoria'
	};
	// txt desc_partida
	Atributos[9]={
		validacion:{
			name:'desc_partida',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:500,
			width:'100%',
			disable:true		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.desc_partida',
		save_as:'desc_partida'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Conceptos Colectivos (Maestro)',titulo_detalle:'Partida Colectiva (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_partida= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_partida.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina = Pagina;
  	this.pagina(paramConfig,Atributos,ds,layout_partida,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//var paramMenu={	nuevo:{crear:true,separador:true},actualizar:{crear:true,separador:true}};
	var paramMenu={	actualizar:{crear:true,separador:true}};
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/partida/ActionEliminarPartida.php'},
		Save:{url:direccion+'../../../control/partida/ActionGuardarPartida.php'},
		ConfirmSave:{url:direccion+'../../../control/partida/ActionGuardarPartida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Partida'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_concepto_ingas(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_partida='+SelectionsRecord.data.id_partida;
			data=data+'&m_codigo_partida='+SelectionsRecord.data.codigo_partida;
			data=data+'&m_nombre_partida='+SelectionsRecord.data.nombre_partida;
			data=data+'&m_nivel_partida='+SelectionsRecord.data.nivel_partida;

			var ParamVentana={Ventana:{width:'70%',height:'50%'}}
			layout_partida.loadWindows(direccion+'../../../../sis_presupuesto/vista/concepto_ingas/concepto_ingas.php?'+data,'Concepto Ingreso Gasto',ParamVentana);

		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
 
		maestro.id_concepto_colectivo=datos.m_id_concepto_colectivo;
		maestro.estado_colectivo=datos.m_estado_colectivo;
		maestro.id_usuario=datos.m_id_usuario;
		maestro.desc_usuario=datos.m_desc_usuario;
		maestro.desc_colectivo=datos.m_desc_colectivo;
 	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_concepto_colectivo:maestro.id_concepto_colectivo
			}
		};
		this.btnActualizar();
		data_maestro=[['Concepto Colectivo','  '+maestro.desc_colectivo+tabular(51-maestro.desc_colectivo.length)],['Estado','  '+maestro.estado_colectivo+tabular(maestro.estado_colectivo.length)],
	 	['Responsable',maestro.desc_usuario]];
	 
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[6].defecto=maestro.id_categoria;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_partida.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Concepto Ingreso Gasto',btn_concepto_ingas,true,'concepto_ingas','Concepto de Ingreso o Gasto');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_partida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	
	layout_partida.getVentana(idContenedor).on('resize',function(){layout_partida.getLayout().layout()})
}

 