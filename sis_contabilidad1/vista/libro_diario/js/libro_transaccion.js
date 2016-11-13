/**
 * Nombre:		  	    pagina_libro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-19 19:27:09
 */
function pagina_libro_transacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarlibroTransacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transaccion',
			totalRecords: 'TotalCount'

		}, [
		'id_transaccion',
		'id_comprobante',
		'desc_comprobante',
		'id_fuente_financiamiento',
		'desc_fuente_financiamiento',
		'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_cuenta',
		'desc_cuenta',
		'id_partida',
		'desc_partida',
		'id_auxiliar',
		'desc_auxiliar',
		'id_orden_trabajo',
		'desc_orden_trabajo',
		'id_oec',
		'concepto_tran'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_comprobante:maestro.id_comprobante
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_comprobante',maestro.id_comprobante],['Acreedor',maestro.concepto_cbte]];
	
	//DATA STORE COMBOS

   /* var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarComprobante.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},['id_comprobante','id_parametro','nro_cbte','momento_cbte','fecha_cbte','concepto_cbte','glosa_cbte','acreedor','aprobacion','conformidad','pedido','id_periodo_subsis','id_moneda_reg','id_usuario','id_subsistema','id_clase_cbte'])
	});

    var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla'])
	});

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion']),
			baseParams:{sw_transaccional:1}
	});

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento','id_concepto_colectivo'])
	});

    var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});

    var ds_orden_trabajo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario'])
	});
*/
	//FUNCIONES RENDER
	
	/*	function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
		var tpl_id_comprobante=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['desc_fuente_financiamiento']);}
		var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b>Fuente: </b><FONT COLOR="#B5A642">{denominacion}</FONT></BR> ','<b>Código: </b><FONT COLOR="#B5A642">{codigo_fuente}</FONT><br>','</div>');

		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>Unidad: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT></BR>','<b>Centro: </b><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b>Cuenta: </b><FONT COLOR="#B5A642">{desc_cuenta}</FONT></br>','<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','</div>');

		function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_partida}</FONT><br>','</div>');

		function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
		var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden_trabajo']);}
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>Orden: </b><FONT COLOR="#B5A642">{desc_orden}</FONT>','</div>');
*/
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_transaccion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transaccion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_transaccion'
	};
// txt id_comprobante
	Atributos[1]={
		validacion:{
			name:'id_comprobante',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_comprobante,
		save_as:'id_comprobante'
	};
/*// txt id_fuente_financiamiento
	Atributos[2]={
			validacion:{
			name:'id_fuente_financiamiento',
			fieldLabel:'Fuente Financiamiento',
			allowBlank:false,			
			emptyText:'Fuente Financiamiento...',
			desc: 'desc_fuente_financiamiento', //indica la columna del store principal ds del que proviane la descripcion
			//store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'desc_fuente_financiamiento',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.codigo_fuente#FUNFIN.denominacion',
			typeAhead:true,
			//tpl:tpl_id_fuente_financiamiento,
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
			//renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'FUNFIN.codigo_fuente',
		save_as:'id_fuente_financiamiento'
	};
// txt id_fina_regi_prog_proy_acti
	Atributos[3]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};
// txt id_unidad_organizacional
	Atributos[4]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
// txt id_cuenta
	Atributos[5]={
			validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,			
			emptyText:'Cuenta...',
			desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cuenta',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion',
			typeAhead:true,
			tpl:tpl_id_cuenta,
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
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta',
		save_as:'id_cuenta'
	};
// txt id_partida
	Atributos[6]={
			validacion:{
			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:true,			
			emptyText:'Partida...',
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida',
			typeAhead:true,
			tpl:tpl_id_partida,
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
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.desc_partida',
		save_as:'id_partida'
	};
*/// txt id_auxiliar
/*	Atributos[7]={
			validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'.',
			typeAhead:true,
			tpl:tpl_id_auxiliar,
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
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'.',
		save_as:'id_auxiliar'
	};
// txt id_orden_trabajo
	Atributos[8]={
			validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,			
			emptyText:'Orden de Trabajo...',
			desc: 'desc_orden_trabajo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_orden_trabajo,
			valueField: 'id_orden_trabajo',
			displayField: 'id_orden_trabajo',
			queryParam: 'filterValue_0',
			filterCol:'ORDTRA.id_orden_trabajo#ORDTRA.desc_orden#ORDTRA.motivo_orden',
			typeAhead:true,
			tpl:tpl_id_orden_trabajo,
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
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'ORDTRA.id_orden_trabajo',
		save_as:'id_orden_trabajo'
	};
// txt id_oec
	Atributos[9]={
		validacion:{
			name:'id_oec',
			fieldLabel:'OEC',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'TRANSC.id_oec',
		save_as:'id_oec'
	};
// txt concepto_tran
	Atributos[10]={
		validacion:{
			name:'concepto_tran',
			fieldLabel:'Concepto',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'TRANSC.concepto_tran',
		save_as:'concepto_tran'
	};
*/
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'libro Diario(Maestro)',titulo_detalle:'libro_transacion (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_libro_transacion = new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_libro_transacion.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_libro_transacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/transaccion/ActionEliminarlibroTransacion.php',parametros:'&m_id_comprobante='+maestro.id_comprobante},
	Save:{url:direccion+'../../../control/transaccion/ActionGuardarlibroTransacion.php',parametros:'&m_id_comprobante='+maestro.id_comprobante},
	ConfirmSave:{url:direccion+'../../../control/transaccion/ActionGuardarlibroTransacion.php',parametros:'&m_id_comprobante='+maestro.id_comprobante},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'libro_transacion'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_comprobante=datos.m_id_comprobante;
maestro.concepto_cbte=datos.m_concepto_cbte;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_comprobante:maestro.id_comprobante
			}
		};
		this.btnActualizar();
		data_maestro=[['id_comprobante',maestro.id_comprobante],['Acreedor',maestro.concepto_cbte]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_comprobante;

		paramFunciones.btnEliminar.parametros='&m_id_comprobante='+maestro.id_comprobante;
		paramFunciones.Save.parametros='&m_id_comprobante='+maestro.id_comprobante;
		paramFunciones.ConfirmSave.parametros='&m_id_comprobante='+maestro.id_comprobante;
		this.InitFunciones(paramFunciones)
	};
	function btn_libro_documento(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_transaccion='+SelectionsRecord.data.id_transaccion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_libro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/libro_documento/libro_documento.php?'+data,'Documentos',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_libro_transacion.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Documentos',btn_libro_documento,true,'libro_documento','Documemto');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_libro_transacion.getLayout().addListener('layout',this.onResize);
	layout_libro_transacion.getVentana(idContenedor).on('resize',function(){layout_libro_transacion.getLayout().layout()})
	
}