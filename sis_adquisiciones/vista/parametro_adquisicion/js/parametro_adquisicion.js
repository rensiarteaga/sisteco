/**
 * Nombre:		  	    pagina_parametro_adquisicion_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 09:36:29
 */
function pagina_parametro_adquisicion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var vectorAtributos=new Array;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_adquisicion/ActionListarParametroAdquisicion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_parametro_adquisicion',totalRecords:'TotalCount'
		},[		
		'id_parametro_adquisicion',
		'estado',
		{name: 'fecha',type:'date',dateFormat:'Y-m-d'},
		'periodo',
		'id_gestion_subsistema','id_subsistema','id_gestion','gestion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])});

	//FUNCIONES RENDER
	
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');
	
	//FUNCIONES RENDER
	/*function renderGestion(value, p, record){return String.format('{0}', record.data['gestion'])}
    function renderPeriodo(value, p, record){return String.format('{0}', record.data['periodo'])}*/
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro_adquisicion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_parametro_adquisicion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_parametro_adquisicion',
		id_grupo:0
	};
	//gestion
		
	Atributos[1]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false,
			grid_indice:1
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		save_as:'id_gestion',
		id_grupo:0
	}; 	
	Atributos[2]={
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['congelado','congelado'],['cerrado','cerrado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disabled:true,
			grid_indice:2,
			align:'center'
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARADQ.estado',
		defecto:'activo',
		save_as:'estado',
		iid_grupo:1
	};
	// txt fecha
	Atributos[3]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:3
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARADQ.fecha',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha',
		id_grupo:1
	};
	// txt num_solicitud_item
	Atributos[4]={
		validacion:{
			name:'id_gestion_subsistema',
			fieldLabel:'Gestion Subsistema',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		defecto: 1,
		filterColValue:'PARADQ.id_gestion_subsistema',
		save_as:'id_gestion_subsistema',
		id_grupo:0
	};
Atributos[5]={
		validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			width_grid:100,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		defecto: 1,
		filterColValue:'GESSUB.id_subsistema',
		save_as:'id_subsistema',
		id_grupo:0
	};


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'parametro_adquisicion',grid_maestro:'grid-'+idContenedor};
	var layout_parametro_adquisicion=new DocsLayoutMaestro(idContenedor);
	layout_parametro_adquisicion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro_adquisicion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
    var ClaseMadre_btnNew=this.btnNew;
    var ClaseMadre_btnEdit=this.btnEdit;
    var ClaseMadre_conexionFailure=this.conexionFailure;
    var ClaseMadre_ocultarComponente=this.ocultarComponente;
    var ClaseMadre_btnActualizar=this.btnActualizar;
    var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_enableSelect=this.EnableSelect;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
    	function iniciarPaginaParametroAdquisicion(){
		
		for(var i=0;i<Atributos.length-1;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}
	}
	
	
	//datos necesarios para el filtro
	function get_gestion()
		{
		Ext.Ajax.request({
			url:direccion+"../../../control/gestion_periodo/ActionObtenerGestion.php",
			method:'GET',
			success:cargar_gestion,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_gestion(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
			//if(componentes[18].getValue()==""){
					getComponente('gestion').setValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
				/*}
				componentes[20].setValue(root.getElementsByTagName('gestiond')[5].firstChild.nodeValue);
			}*/
		}
		}
	function get_periodo()
		{
		Ext.Ajax.request({
			url:direccion+"../../../control/gestion_periodo/ActionObtenerPeriodo.php",
			method:'GET',
			success:cargar_periodo,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_periodo(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
					getComponente('periodo').setValue(root.getElementsByTagName('periodo')[0].firstChild.nodeValue);
				
		  }
		}
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro_adquisicion/ActionEliminarParametroAdquisicion.php'},
		Save:{url:direccion+'../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:320,minWidth:150,minHeight:200,	closable:true,titulo:'Parametro Adquisición',grupos:[
			{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Fecha Congelado',
				columna:0,
				id_grupo:1
			}]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_correlativo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro_adquisicion='+SelectionsRecord.data.id_parametro_adquisicion;
			data=data+'&m_fecha='+SelectionsRecord.data.fecha;
			data=data+'&m_gestion='+SelectionsRecord.data.gestion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_parametro_adquisicion.loadWindows(direccion+'../../../../sis_adquisiciones/vista/correlativo/correlativo_det.php?'+data,'Secuenciales Adquisición',ParamVentana);
            layout_parametro_adquisicion.getVentana().on('resize',function(){
			layout_parametro_adquisicion.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
function btn_bloquear(){
	
       
       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		if(NumSelect==1){
			if(confirm('Esta seguro de  Bloquear la gestión y el periodo, desea continuar?'))
					{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_adquisicion_0=" + SelectionsRecord.data.id_parametro_adquisicion+"&estado_0=bloqueado&cantidad_ids=1";
				Ext.Ajax.request({url:direccion+"../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php",
				params:data,
				method:'POST',
				success:cargar_bloqueado,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
				}
		
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion y periodo.');
	}
	}
	function cargar_bloqueado(resp)
	{
		alert('El bloqueo de la gestion y periodo fue exitosa');
	}
	
	function btn_cerrar(){
	
      
       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		if(NumSelect==1){
			if(confirm('Esta seguro de  Cerrar la gestión y el periodo, desea continuar?'))
					{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_adquisicion_0=" + SelectionsRecord.data.id_parametro_adquisicion+"&estado_0=cerrado&cantidad_ids=1";
				Ext.Ajax.request({url:direccion+"../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php",
				params:data,
				method:'POST',
				success:cargar_cerrado,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
				}
		
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion y periodo.');
	}
	}
	
	function btn_congelar(){
		componentes[2].setValue('congelado');
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Fecha Congelado');
		ClaseMadre_btnEdit();
				
	}
	
	function btn_activar(){
	
     
       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1){
			if(confirm('Esta seguro de  Activar la gestión y el periodo, desea continuar?'))
					{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_adquisicion_0=" + SelectionsRecord.data.id_parametro_adquisicion+"&estado_0=activado&cantidad_ids=1";
				Ext.Ajax.request({url:direccion+"../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php",
				params:data,
				method:'POST',
				success:cargar_activo,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
				}
		
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion y periodo.');
	}
	}
	function btn_nueva(){
	
       
	
				var data="cantidad_ids=1";
				Ext.Ajax.request({url:direccion+"../../../control/parametro_adquisicion/ActionGuardarParametroAdquisicion.php",
				params:data,
				method:'POST',
				success:cargar_activo,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
		
	}


	function cargar_bloqueado(resp)
	{
		alert('El bloqueo de la gestion y periodo fue exitosa');
		ClaseMadre_btnActualizar();
	}
	
	function cargar_activo(resp)
	{
		alert('La activación de la gestion y periodo fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_congelado(resp)
	{
		alert('La congelación de la gestion y periodo fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_cerrado(resp)
	{
		alert('El cerrado de la gestion y periodo fue exitosa');
		ClaseMadre_btnActualizar();
	}
	
	//
	/*function btnTarifasIndex(){
		h_txt_id_fac_index=ClaseMadre_getComponente('id_fac_index');

		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;

		if(NumSelect!=0){
			if(confirm('Esta seguro de Indexar Tarifas, desea continuar?'))
					{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="hidden_id_fac_index=" + h_txt_id_fac_index.getValue();
				Ext.Ajax.request({url:direccion+"../../../control/tarifa_index/ActionGuardarTarifaIndexProc.php",
				params:data,
				method:'POST',
				success:cargar_tarifa,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}
		else{
			Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Antes debe seleccionar un Valor de Indexación...</b></span>')
		}
	}*/
	
	function btn_correlativo_rp(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			/*var data='m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_documento='+SelectionsRecord.data.documento;*/
            var data='m_id_gestion_subsistema=' + SelectionsRecord.data.id_gestion_subsistema;
			var ParamVentana={Ventana:{width:'70%',height:'50%'}}
			layout_parametro_adquisicion.loadWindows(direccion+'../../../../sis_adquisiciones/vista/correlativo_rp_adq/correlativo_rp_adq.php?'+data,'Correlativo RP',ParamVentana);
  	 }
	else
	 {
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	 }
	}
	
	this.EnableSelect=function(x,z,y){
			
		enable(x,z,y);
		
		
	}	
	function btn_correlativo_general(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			/*var data='m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_documento='+SelectionsRecord.data.documento;
        */
		  var data='m_id_gestion_subsistema=' + SelectionsRecord.data.id_gestion_subsistema;
			var ParamVentana={Ventana:{width:'50%',height:'50%'}}
			layout_parametro_adquisicion.loadWindows(direccion+'../../../../sis_adquisiciones/vista/correlativo_general_adq/correlativo_general_adq.php?'+data,'Correlativo General',ParamVentana);
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
	this.getLayout=function(){return layout_parametro_adquisicion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		/*this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Secuenciales Adquisición',btn_correlativo,true,'correlativo','Secuenciales Adquisición');*/
        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Nueva Gestion',btn_nueva,true,'Nueva Gestión','Nueva Gestión');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Activar',btn_activar,true,'activado','Activar');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Bloquear',btn_bloquear,true,'bloqueado','Bloquear');
        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Congelar',btn_congelar,true,'congelado','Congelar');
        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cerrar',btn_cerrar,true,'cerrado','Cerrar');
        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Correlativo RP',btn_correlativo_rp,true,'correlativo_rp','');

		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Correlativo General',btn_correlativo_general,true,'correlativo_general','');
		var CM_getBoton=this.getBoton;
		CM_getBoton('activado-'+idContenedor).enable();
		CM_getBoton('bloqueado-'+idContenedor).enable();
		CM_getBoton('cerrado-'+idContenedor).enable();
		CM_getBoton('congelado-'+idContenedor).enable();
		
		function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				    CM_getBoton('activado-'+idContenedor).enable();
					CM_getBoton('bloqueado-'+idContenedor).enable();
					CM_getBoton('cerrado-'+idContenedor).enable();
					CM_getBoton('congelado-'+idContenedor).enable();
        			   
					       if(record.estado=='activo'){
					       		CM_getBoton('activado-'+idContenedor).disable();
					       }
					       else if(record.estado=='cerrado'){
					       	 	CM_getBoton('activado-'+idContenedor).disable();
								CM_getBoton('bloqueado-'+idContenedor).disable();
								CM_getBoton('cerrado-'+idContenedor).disable();
								CM_getBoton('congelado-'+idContenedor).disable();
					       }
					       else if(record.estado=='bloqueado'){
					       	 	CM_getBoton('activado-'+idContenedor).disable();
								CM_getBoton('bloqueado-'+idContenedor).disable();
								CM_getBoton('congelado-'+idContenedor).disable();
					       }
					       else if(record.estado=='congelado'){
					       	 	CM_getBoton('congelado-'+idContenedor).disable();
					       }
				       		

				}
				CM_enableSelect(sel,row,selected);
				
			}			

		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	iniciarPaginaParametroAdquisicion(); 
	layout_parametro_adquisicion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}