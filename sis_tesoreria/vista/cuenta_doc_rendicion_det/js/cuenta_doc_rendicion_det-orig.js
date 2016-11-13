/**
 * Nombre:		  	    pagina_detalle_viatico.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:09
 */
function pagina_detalle_viatico(idContenedor,direccion,paramConfig) 
//tipo se refiere a si es registro para el comprometido o para rendición. valores: 'comp','rendic'
{
	var maestro;
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_det/ActionListarDetalleViatico.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_doc_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'cantidad',
		'tipo_transporte',
		'importe',
		'id_tipo_destino',
		'desc_tipo_destino',
		'id_cobertura',
		'desc_cobertura',
		'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'id_presupuesto',
		'desc_presupuesto',
		'observaciones'
		]),remoteSort:true});

	
	
	
	//DATA STORE COMBOS

   

    var ds_tipo_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_destino/ActionListarTipoDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_destino',totalRecords: 'TotalCount'},['id_tipo_destino','descripcion','id_moneda','fecha_reg','id_usr_reg'])
	});

    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','descripcion'])
	});

   

     var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv' ])
	});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});

	//FUNCIONES RENDER
	
		
		function render_id_tipo_destino(value, p, record){return String.format('{0}', record.data['desc_tipo_destino']);}
		var tpl_id_tipo_destino=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

		function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
		var tpl_id_cobertura=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

		function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
		var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<b>   Tipo Presupuesto: </b><FONT COLOR="#B5A642">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamineto: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
		
		'</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_cuenta_doc
	Atributos[1]={
		validacion:{
			name:'id_cuenta_doc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
	
	Atributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.desc_presupuesto',
			typeAhead:true,
			tpl:tpl_id_presupuesto,
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
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PRESUP.desc_presupuesto',
		id_grupo:0
	};
	
	
	// txt id_concepto_ingas
	Atributos[3]={
			validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto',
			allowBlank:false,			
			emptyText:'Concepto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas',
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas',
			typeAhead:true,
			tpl:tpl_id_concepto_ingas,
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
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		id_grupo:0
	};
	
// txt cantidad
	Atributos[4]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.cantidad',
		id_grupo:1
	};
// txt tipo_transporte
	Atributos[5]={
			validacion: {
			name:'tipo_transporte',
			fieldLabel:'Tipo de Transporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['aereo','aereo'],['terrestre','terrestre'],['fluvial_maritimo','fluvial_maritimo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.tipo_transporte',
		defecto:'aereo',
		id_grupo:3
	};
// txt importe
	Atributos[6]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
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
		filterColValue:'CUDODE.importe',
		id_grupo:1
	};
// txt id_tipo_destino
	Atributos[7]={
			validacion:{
			name:'id_tipo_destino',
			fieldLabel:'Tipo de Destino',
			allowBlank:false,			
			emptyText:'Tipo de Destino...',
			desc: 'desc_tipo_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_destino,
			valueField: 'id_tipo_destino',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPDES.descripcion',
			typeAhead:true,
			tpl:tpl_id_tipo_destino,
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
			renderer:render_id_tipo_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPDES.descripcion',
		id_grupo:2
	};
// txt id_cobertura
	Atributos[8]={
			validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura',
			allowBlank:false,			
			emptyText:'Cobertura...',
			desc: 'desc_cobertura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,
			valueField: 'id_cobertura',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.descripcion',
			typeAhead:true,
			tpl:tpl_id_cobertura,
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
			renderer:render_id_cobertura,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.descripcion',
		id_grupo:2
	};


// txt id_presupuesto
	
	
	Atributos[9]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:15		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.observaciones',
		id_grupo:1
		
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud de Viáticos (Maestro)',titulo_detalle:'detalle_viatico (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_detalle_viatico = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_detalle_viatico.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_viatico,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cuenta_doc_det/ActionEliminarDetalleViatico.php'},
	Save:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php'},
	ConfirmSave:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],width:'75%',minWidth:350,minHeight:400,	closable:true,titulo:'detalle_viatico',
		
			grupos:[
			{
				tituloGrupo:'Datos Prepupuesto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Generales',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Viatico',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Pasaje',
				columna:0,
				id_grupo:3
			}]
		}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_cuenta_doc:maestro.id_cuenta_doc
			}
		};
		this.btnActualizar();
		componentes[3].setDisabled(true);
		Atributos[1].defecto=maestro.id_cuenta_doc;
		paramFunciones.btnEliminar.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.Save.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.ConfirmSave.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		componentes[2].on('select',filtrar_epe_concepto_ingas);
		componentes[3].on('select',validarConcepto);
		componentes[8].on('select',obtenerImporte)
	}
	
	function filtrar_epe_concepto_ingas(combo,record, index)
	{	componentes[3].store.baseParams={};
		
		componentes[3].setValue();
		componentes[3].store.baseParams={sw_tesoro:3,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		componentes[3].modificado=true;
		componentes[3].setDisabled(false);
		
	}
	function validarConcepto(combo,record,index){
		var nombre_concepto;
		nombre_concepto=record.data.desc_ingas.toLowerCase();
		if(nombre_concepto.indexOf('hotel')!=-1){
			tipoOtro();
		}
		else if(nombre_concepto.indexOf('pasajes')!=-1){
			tipoPasaje();
		}
		else if(nombre_concepto.indexOf('viaticos')!=-1 || nombre_concepto.indexOf('viaticos')!=-1){
			tipoViatico();
		}
		else{
			tipoOtro();
		}
	}
	
	function obtenerImporte(combo,record,index){
		
		if(componentes[4].getValue()=='' || componentes[7].getValue==''){
			componentes[8].reset();
			alert('Antes debe definir el tipo de destino y la cantidad de dias');
		}
		
		Ext.MessageBox.show({
						title: 'Cargando Importe...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Centro...</div>",
						width:150,
						height:200,
						closable:false
					});
					
	
		Ext.Ajax.request({
					url:direccion+"../../../control/cuenta_doc_det/ActionObtenerImporteViatico.php",
					success:cargar_respuesta,
					params:{id_cobertura:record.data.id_cobertura,id_categoria:maestro.id_categoria,id_tipo_destino:componentes[7].getValue(),cantidad:componentes[4].getValue()},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
	}
	
	function cargar_respuesta(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1')
			{
				componentes[6].setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
			}
			else{ 
			
				Ext.MessageBox.alert('Alerta','No se puede obtener el importe para la cobertura y categoria seleccionados. Por favor revise la parametrizacion');
			}
			
								
		}
	}
	
	
	function tipoPasaje(){
		CM_mostrarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		SiBlancosGrupo(2);
		NoBlancosGrupo(3);
		NoBlancosGrupo(1);
		componentes[6].setDisabled(false);
		
	}
	function tipoViatico(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_mostrarGrupo('Datos Viatico');
		SiBlancosGrupo(3);
		NoBlancosGrupo(2);
		NoBlancosGrupo(1);
		componentes[6].setDisabled(true);
	}
	function tipoOtro(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		SiBlancosGrupo(3);
		SiBlancosGrupo(2);
		
		componentes[9].allowBlank=false;
		componentes[6].setDisabled(false);
	}
	
	this.btnNew=function(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		CM_btnNew();
		
	}	
	this.btnEdit=function(){
		
		var nombre_concepto;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			nombre_concepto=SelectionsRecord.data.desc_concepto_ingas.toLowerCase();;
			
			if(nombre_concepto.indexOf('hotel')!=-1){
				
				tipoOtro();
			}
			else if(nombre_concepto.indexOf('pasajes')!=-1){
				
				tipoPasaje();
			}
			else if(nombre_concepto.indexOf('viaticos')!=-1 || nombre_concepto.indexOf('viaticos')!=-1){
				
				tipoViatico();
			}
			else{
				
				tipoOtro();
			}
			CM_btnEdit();
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
				
	}
	
	
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_viatico.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_viatico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}