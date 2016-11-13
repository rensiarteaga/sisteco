/**
 * Nombre:		  	    pagina_avance_detalle.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-02 22:29:51
 */
function pagina_avance_detalle(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	//  DATA STORE //
	var txt_sw_valida,cmb_presupuesto,cmb_concepto_ingas;
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance_detalle/ActionListarAvanceDetalle.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_avance_detalle',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_avance_detalle',
		'id_avance',
		'id_concepto_ingas',
		'desc_ingas_item_serv',
		'importe_detalle',
		'observa_detalle',
		'sw_valida',
		'id_presupuesto',
		'desc_presupuesto',
		'id_item',
		'id_servicio',
		'id_solicitud_compra_det'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_avance:maestro.id_avance,
			m_fecha_avance:maestro.fecha_avance,
			m_importe_avance:maestro.importe_avance
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
    var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var data_maestro=[
	['Identificador',maestro.id_avance],
	['Fecha Descargo',maestro.fecha_avance],
	['Importe Total',maestro.importe_avance]];
//----------------------------------------------------------	
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
	{header:"Valor", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
	]);
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[
			['Fecha Descargo',maestro.fecha_avance],
			['Importe Total',maestro.importe_avance]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
//DATA STORE COMBOS
  var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),
	baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si',avance:'si',id_empleado_reg:maestro.id_empleado_reg,id_departamento:maestro.id_depto}
	});
   
	
	var ds_concepto_ingas=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php'}),
	
	//var ds_concepto_ingas=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords:'TotalCount'},['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv','id_partida','desc_partida','id_cuenta','desc_cuenta','sw_tesoro']),
	baseParams:{m_id_presupuesto:1,m_id_unidad_organizacional:1,m_sw_rendicion:'si',sw_tesoro:1},remoteSort:true
	});
	//FUNCIONES RENDER
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_ingas_item_serv']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>{desc_ingas_item_serv}</b>','<br><FONT COLOR="#B5A642"><b>Tesoro: </b>{sw_tesoro}</FONT>','</div>');
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		/*var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<b>   Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamineto: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
		'</div>');*/
		
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B50000">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	
		
	// Definición de datos //
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_avance_detalle',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_avance_detalle'
	};
	// txt id_avance
	Atributos[1]={
		validacion:{
			name:'id_avance',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_avance,
		save_as:'id_avance'
	};
	//combo presupuesto	
     Atributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto'
	};
   Atributos[3]={
	  validacion:{
		name:'id_concepto_ingas',
		fieldLabel:'Concepto de Gasto',
		allowBlank:false,			
		emptyText:'Concepto...',
		desc:'desc_ingas_item_serv', //indica la columna del store principal ds del que proviane la descripcion
		store:ds_concepto_ingas,
		valueField:'id_concepto_ingas',//valor que agarra o guarda
		displayField:'desc_ingas_item_serv',//el que muestra
		queryParam:'filterValue_0',
		filterCol:'desc_ingas_item_serv',
		typeAhead:true,
		tpl:tpl_id_concepto_ingas,
		forceSelection:true,
		mode:'remote',
		queryDelay:250,//tiempo de retardo para buscar en el combo
		pageSize:10,//tamaño de registros que hay en combo (paginacion)
		maxLength:150,//tamaño de max de caracteres
		grow:true,//
		resizable:true,
		minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
		triggerAction:'all',
		renderer:render_id_concepto_ingas,
		grid_visible:true,
		grid_editable:false,
		width_grid:200,//tamaño del combo en el grid
		width:200,//tamaño del combo en el formulario
		minListWidth:200,//tamaño ANCHO de la lista en el formulario
		disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		save_as:'id_concepto_ingas'
	};
// txt importe_detalle
	Atributos[4]={
		validacion:{
			name:'importe_detalle',
			fieldLabel:'Importe',
			allowBlank:false,
			align:'right',
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'AVADET.importe_detalle',
		save_as:'importe_detalle'
	};
// txt observa_detalle
	Atributos[5]={
			validacion:{
			name:'observa_detalle',
			fieldLabel:'Detalle',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:true
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'AVADET.observa_detalle',
		save_as:'observa_detalle'
	};
	/////////// txt sw_valida //////
	Atributos[6]={
		validacion:{
			labelSeparator:'',
			name:'sw_valida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		save_as:'sw_valida'
		};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatValida(value){
		if (value==1) return 'Si';
		else return 'No'
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Descargo (Maestro)',titulo_detalle:'Conceptos de Gasto (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_avance_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_avance_detalle.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_avance_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
    var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/avance_detalle/ActionEliminarAvanceDetalle.php',parametros:'&m_id_avance='+maestro.id_avance},
	Save:{url:direccion+'../../../control/avance_detalle/ActionGuardarAvanceDetalle.php',parametros:'&m_id_avance='+maestro.id_avance},
	ConfirmSave:{url:direccion+'../../../control/avance_detalle/ActionGuardarAvanceDetalle.php',parametros:'&m_id_avance='+maestro.id_avance},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Concepto de Gasto'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_avance=datos.m_id_avance;
	maestro.fecha_avance=datos.m_fecha_avance;
	maestro.importe_avance=datos.m_importe_avance;
	maestro.id_empleado_reg=datos.m_id_empleado_reg;
	maestro.id_depto=datos.m_id_depto;
	ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_avance:maestro.id_avance,
				m_fecha_avance:maestro.fecha_avance,
			    m_importe_avance:maestro.importe_avance
			}
		};
		this.btnActualizar();
		data_maestro=[['Identificador',maestro.id_avance],['Fecha Descargo',maestro.fecha_avance],['Importe Total',maestro.importe_avance]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));		
		var cmMaestro=new Ext.grid.ColumnModel([
		{header:" ", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
		{header:" ", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
		]);
				
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
			ds:new Ext.data.SimpleStore({
				fields:['atributo','valor'],
				data:[
				['Fecha Descargo',maestro.fecha_avance],
				['Importe Total',maestro.importe_avance]]
			}),
			cm:cmMaestro
		});
		gridMaestro.render();
		Atributos[1].defecto=maestro.id_avance;
		ds_presupuesto.baseParams={m_sw_rendicion:'si',sw_inv_gasto:'si',avance:'si',id_empleado_reg:maestro.id_empleado_reg,id_departamento:maestro.id_depto};
		paramFunciones.btnEliminar.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.Save.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.ConfirmSave.parametros='&m_id_avance='+maestro.id_avance;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	txt_sw_valida=getComponente('sw_valida');
	cmb_presupuesto=getComponente('id_presupuesto');
	cmb_concepto_ingas=getComponente('id_concepto_ingas');
	cmb_concepto_ingas.disable();
	var onPresupuestoSelect=function(combo,record,index){
			var presup=record.data.id_presupuesto;
			var unior=record.data.id_unidad_organizacional;
			ds_concepto_ingas.baseParams={m_id_presupuesto:presup,m_id_unidad_organizacional:unior,m_sw_rendicion:'si',sw_tesoro:1};
			cmb_concepto_ingas.enable();
			cmb_concepto_ingas.setValue('');
			cmb_concepto_ingas.modificado=true;			
		};
		cmb_presupuesto.on('select',onPresupuestoSelect);
	}
	/*this.btnEliminar=function(){
		if(txt_sw_valida.getValue()==1){
		   	Ext.MessageBox.alert('ESTADO', 'No se puede eliminar porque el detalle ya fue aprobado.');
		  }
		else{
		    btnEliminar()	
		     }
		};
	this.btnEdit=function(){
		if(txt_sw_valida.getValue()==1){
		   	Ext.MessageBox.alert('ESTADO', 'No se puede modificar porque el detalle ya fue aprobado.');
		  }
		else{
		    btnEdit()	
		     }
		};	*/	
   	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_avance_detalle.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_avance_detalle.getLayout().addListener('layout',this.onResize);
	layout_avance_detalle.getVentana(idContenedor).on('resize',function(){layout_avance_detalle.getLayout().layout()})	
}