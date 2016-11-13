function pagina_cierre_apertura(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//console.log(maestro);
		
		var gestion=1; 
	
	//---DATA STORE
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cierre_apertura/ActionListarCierreApertura.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cierre_apertura',totalRecords:'TotalCount'
		},['id_cierre_apertura', 
		 'id_comprobante', 
		 'descripcion', 
		 'nro_cbte', 
		 'id_gestion_actual',
		 'gestion_actual',
		 'id_gestion_nueva',
		 'gestion_nueva',
		 'sw_volcar',
		 'sw_siguiente_gestion',
		 'id_moneda',
		 'nombre',
		 'sw_actualizacion',
		 'sw_estado',
		 'id_reporte_eeff',
		 'nombre_eeff',
		 'id_cuenta_diferencia',
		 'cuenta',
		 'id_depto_conta',
		
		]),remoteSort:true});
 
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_transaccion:maestro.id_transaccion,
			m_id_moneda:maestro.id_moneda,
			m_id_depto:maestro.id_depto,
			m_codigo_depto:maestro.codigo_depto,
			m_nombre_depto:maestro.nombre_depto,
			m_id_depto_conta:maestro.id_depto_conta
		}
	});
			
	//DATA STORE COMBOS
	var ds_gestion_actual = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?estado=abierto'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'
		},['id_gestion',		'gestion',		'estado_ges_gral',		'id_empresa',		'desc_empresa',		'id_moneda_base',		'desc_moneda'		]) });		
	ds_gestion_actual.filter("estado_ges_gral", "abierto");
	var tpl_id_gestion_actual =new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_ges_gral}</FONT><br>','</div>');		
	function render_id_gestion_actual(value, p, record){return String.format('{0}', record.data['gestion_actual']);}//grilla
	
	var ds_gestion_nueva = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?estado=abierto'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'
		},['id_gestion',		'gestion',		'estado_ges_gral',		'id_empresa',		'desc_empresa',		'id_moneda_base',		'desc_moneda'		]) });		
	var tpl_id_gestion_nueva =new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT><br>','<b>Esatdo: </b><FONT COLOR="#B5A642">{estado_ges_gral}</FONT><br>','</div>');		
	function render_id_gestion_nueva(value, p, record){return String.format('{0}', record.data['gestion_nueva']);}//grilla

	var ds_moneda = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},
		['id_moneda','nombre','simbolo','estado','origen','prioridad'])});
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	function render_moneda(value, p, record){return String.format('{0}', record.data['nombre']);}

	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php?sw_transaccional=1'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'
    ])});

	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['cuenta']);}
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nombre_cuenta}</b></i><br>','<FONT COLOR="#B5A642">{nro_cuenta}</FONT>','</div>');
	
	var ds_eeff = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'
		},['id_reporte_eeff','nombre_eeff'
		]),remoteSort:true});
	var tpl_id_reporte_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
	function render_id_reporte_eeff(value, p, record){return String.format('{0}', record.data['nombre_eeff']);}
			
	//FUNCIONES RENDER
	function render_sw_volcar(value, p, record)
	{	if(value=='si'){return 'SI';}
	 	if(value=='no'){return 'NO';}
	}	
	function render_sw_siguiente_gestion(value, p, record)
	{	if(value=='si'){return 'SI';}
	 	if(value=='no'){return 'NO';}
	}
	function render_sw_actualizacion(value, p, record)
	{	if(value=='si'){return 'SI';}
	 	if(value=='no'){return 'NO';}
	}
	function render_sw_estado(value, p, record)
	{	if(value=='activo'){return 'ACTIVO';}
	 	if(value=='inactivo'){return 'INACTIVO';}
	}	
	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	
	//en la posiciï¿½n 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cierre_apertura',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cierre_apertura'
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',				
			name:'id_comprobante',
			fieldLabel:'ID Cbte.',
			desc: 'id_comprobante',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:20,
			disabled:true,
			grid_indice:1
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'ciap.id_comprobante'
	};

	Atributos[2]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Nro.Cbte.',
			name: 'nro_cbte',
			allowBlank:false,
			allowDecimals:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:20,
			disabled:true,
			grid_indice:2
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'ciap.nro_cbte'
	};
	
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'ciap.descripcion',
		save_as:'descripcion'
	};
	
	Atributos[4]={
		validacion:{
			name:'id_gestion_actual',
			fieldLabel:'Gestion Origen',
			allowBlank:false,
			emptyText:'Gestion...',
			desc: 'gestion_actual', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion_actual,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion_actual, //la vista del combo
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion_actual,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false,
			grid_indice:4
	
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'gestion_actual.gestion',
		save_as:'id_gestion_actual'
	};
	
	Atributos[5]={
		validacion:{
			name:'id_gestion_nueva',
			fieldLabel:'Gestion Nueva',
			allowBlank:false,
			emptyText:'Gestion...',
			desc: 'gestion_nueva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion_nueva, //ds del combo 
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion_nueva, //la vista del combo
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion_nueva,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false,
			grid_indice:5
	
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'gestion_nueva.gestion',
		save_as:'id_gestion_nueva'
	}; 
	
	Atributos[6]={
		validacion:{
			name:'sw_volcar',
			fieldLabel:'Cierre ',
			allowBlank:false,
			align:'left',
			emptyText:'Cerrar ...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_sw_volcar,
			grid_editable:false,
			width_grid:60,
			minListWidth:200,
			width:200,
			disabled:false,
			grid_indice:6
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'ciap.sw_volcar', 
		save_as:'sw_volcar'
	};
	
	Atributos[7]={
		validacion:{
			name:'sw_siguiente_gestion',
			fieldLabel:'Apertura',
			allowBlank:false,
			align:'left',
			emptyText:'Aperturar...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_sw_siguiente_gestion,
			grid_editable:false,
			width_grid:60,
			minListWidth:200,
			width:200,
			disabled:false,
			grid_indice:7
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'ciap.sw_siguiente_gestion', 
		save_as:'sw_siguiente_gestion'
	};
	Atributos[8]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false,
			grid_indice:8
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//defecto:1,
		filterColValue:'mon.nombre',
		save_as:'id_moneda'
	};
	
	Atributos[9]={
		validacion:{
			name:'sw_actualizacion',
			fieldLabel:'Actualización',
			allowBlank:false,
			align:'left',
			emptyText:'Actualización...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_sw_actualizacion,
			grid_editable:false,
			width_grid:100,
			minListWidth:200,
			width:200,
			disabled:false,
			grid_indice:9
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'ciap.sw_actualizacion', 
		save_as:'sw_actualizacion'
	};
	Atributos[10]={
		validacion:{
			name:'sw_estado',
			fieldLabel:'Estado',
			allowBlank:false,
			align:'left',
			emptyText:'Estado...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['activo','ACTIVO'],['inactivo','INACTIVO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_sw_estado,
			grid_editable:false,
			width_grid:100,
			minListWidth:200,
			width:200,
			disabled:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		form: true,
		 filtro_0:true,
		 filterColValue:'ciap.sw_estado', 
		save_as:'sw_estado'
	};
	
	Atributos[11]={
		validacion:{
			name:'id_reporte_eeff',
			fieldLabel:'EEFF',
			allowBlank:false,
			emptyText:'EEFF...',
			desc: 'nombre_eeff', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_eeff,
			valueField: 'id_reporte_eeff',
			displayField: 'nombre_eeff',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_reporte_eeff,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_reporte_eeff,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false,
			grid_indice:8
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//defecto:1,
		filterColValue:'ciap.id_reporte_eeff',
		save_as:'id_reporte_eeff'
	};
		
	Atributos[12]={
		validacion:{
			name:'id_cuenta_diferencia',
			fieldLabel:'Cuenta',
			allowBlank:false,
			emptyText:'Cuenta...',
			desc:'nombre_cuenta',
			store:ds_cuenta,
			valueField:'id_cuenta',
			displayField:'nombre_cuenta',
			queryParam:'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
			//filterCols:filterCols_cuenta,
			//filterValues:filterValues_cuenta,
			tpl:tpl_id_cuenta,
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width:300,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		form: true,
 		filterColValue:'ciap.id_cuenta_diferencia',
  		save_as:'id_cuenta_diferencia'
	};
	
	Atributos[13]={
		validacion:{
			name: 'id_depto_conta',
			labelSeparator:'',
			inputType:'hidden',
			tipo_grafo: 'nodo'
		},
		tipo: 'Field',
		defecto:maestro.id_depto_conta
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_depto ',maestro.id_depto,'Codigo Departamento ',maestro.codigo_depto],
	['Nombre Departamento',maestro.nombre_depto,'id_dpto_conta ',maestro.id_depto_conta]];
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamento(Maestro)',titulo_detalle:'Registro (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_cheque=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cheque.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;

	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cheque,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew =this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_conexionFailure=this.conexionFailure

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	this.btnNew=function(){
		ClaseMadre_btnNew();
	}
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cierre_apertura/ActionEliminarCierreApertura.php'},
		Save:{url:direccion+'../../../control/cierre_apertura/ActionGuardarCierreApertura.php'},
		ConfirmSave:{url:direccion+'../../../control/cierre_apertura/ActionGuardarCierreApertura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:450,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Cierre/Apertura'}};

	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));

	function MaestroJulio(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
			for(i=0;i<data[j].length;i++){
				if(data[j]){
					if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
			}
			html=html+"</tr>";
		}
		html=html+"</table>";
		return html
	};	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		cmp_id_gestion_actual = ClaseMadre_getComponente('id_gestion_actual');
		cmp_id_cuenta_diferecia = ClaseMadre_getComponente('id_cuenta_diferencia');
        cmp_id_gestion_actual.on('select',onGestion);
	}
	
	function btn_cierreapertura(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_id_actualizacion=datas_edit.id_actualizacion;
			
			Ext.MessageBox.confirm("Atenciï¿½n","Esta seguro generar Comprobante?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Generando comprobante comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../../sis_contabilidad/control/cierre_apertura/ActionGenerarCbteCierreApertura.php",
					success:mostrar_respuesta,
					params:{m_id_cierre_apertura:datas_edit.id_cierre_apertura},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una actualizaciï¿½n.');
		}	
	}

	function mostrar_respuesta(resp){
		//console.log(resp.responseXML.documentElement.getElementsByTagName('mensaje'));
		Ext.MessageBox.confirm("Generacion",resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue+" ",
		function(btn){
			ds.baseParams={
					start:0,
					limit: 30,
					CantFiltros:paramConfig.CantFiltros,
					m_id_depto_conta:maestro.id_depto_conta
				};
			ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
					m_id_depto_conta:maestro.id_depto_conta
			}});
		 });
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
	}

	CM_AdicionarMenuBoton=this.AdicionarMenuBoton;	
	
	this.reload=function(params){
		//console.log(params);
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_depto_conta=datos.m_id_depto_conta;
		maestro.id_depto=datos.m_id_depto;
		maestro.codigo_depto=datos.m_codigo_depto;
		maestro.nombre_depto=datos.m_nombre_depto;
		cmp_id_gestion_actual = ClaseMadre_getComponente('id_gestion_actual');
		cmp_id_gestion_actual.on('select',onGestion);
		
		var data_maestro=[	['id_depto',maestro.id_depto,'Codigo Departamento ',maestro.codigo_depto],
							['Nombre Departamento',maestro.nombre_depto,'id_dpto_conta ',maestro.id_depto_conta]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_transaccion:maestro.id_transaccion,
				m_id_moneda:maestro.id_moneda,
				m_id_depto:maestro.id_depto,
				m_codigo_depto:maestro.codigo_depto,
				m_nombre_depto:maestro.nombre_depto,
				m_id_depto_conta:maestro.id_depto_conta
			}
		};
		
		this.btnActualizar();
		paramFunciones.btnEliminar.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.Save.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.ConfirmSave.parametros='&m_sw_documento=si&id_transaccion='+maestro.id_transaccion
		this.InitFunciones(paramFunciones)
	};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_cheque.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);

	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Generar Comprobante',btn_cierreapertura,true,'departamentoConta','');

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_transaccion:maestro.id_transaccion,
			m_id_moneda:maestro.id_moneda,
			m_id_depto:maestro.id_depto,
			m_codigo_depto:maestro.codigo_depto,
			m_nombre_depto:maestro.nombre_depto,
			m_id_depto_conta:maestro.id_depto_conta
		}
	});
	
	function onGestion(com,rec,ind){		
		var	gestion= rec.data.id_gestion;
		cmp_id_cuenta_diferecia.store.baseParams = {sw_transaccional:1, m_id_gestion:gestion};
		cmp_id_cuenta_diferecia.modificado=true;
		cmp_id_cuenta_diferecia.setValue('');
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_cheque.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}