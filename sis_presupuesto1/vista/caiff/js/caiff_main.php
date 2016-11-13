<?php 
/**
 * Nombre:		  	    caiff_main.php
 * PropÃƒÂ³sito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creaciÃƒÂ³n:		
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_caiff(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_caiff.js
 * PropÃƒÂ³sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciÃƒÂ³n:		2008-08-18 17:10:52
 */
function pagina_caiff(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes= new Array(); 
	var cmb_gestion,cmb_periodo;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caiff/ActionListarCaiff.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caiff',totalRecords:'TotalCount'
		},[		
		'id_caiff',
		'id_gestion',
	 	'desc_gestion',
		'id_periodo',
		'desc_periodo',
		{name:'fecha_inicio',type:'date',dateFormat : 'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat : 'Y-m-d'},
		'estado',
		'descripcion','usuario_reg',
		'fecha_reg'
		
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

	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])});


	var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_registro','fecha_final','estado_peri_gral'])});
	
	//FUNCIONES RENDER
	
	function render_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
	var tpl_periodo=new Ext.Template('<div class="search-item">','<b><i>{periodo}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{estado_peri_gral}</FONT>','</div>');
	
	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');
	
	/////////////////////////
	// DefiniciÃƒÂ³n de datos //
	/////////////////////////
	
	// hidden id_usuario_autorizado
	//en la posiciÃƒÂ³n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caiff',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'h_id_caiff'
	};
	Atributos[1]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gesti\u00F3n',
			allowBlank:false,			
			emptyText:'Gesti\u00F3n...',
			desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
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
			minChars:1, ///caracteres mÃ¯Â¿Â½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false,
			grid_indice:1
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.id_gestion',
		save_as:'h_id_gestion'
	}; 
	Atributos[2]={
			validacion:{
				name:'id_periodo',
				fieldLabel:'Periodo',
				allowBlank:false,			
				emptyText:'Periodo...',
				desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
				store: ds_periodo,
				valueField: 'id_periodo',
				displayField: 'periodo',
				queryParam: 'filterValue_0',
				filterCol:'PERIOD.periodo,',
				typeAhead:true,
				align:'center',
				tpl: tpl_periodo,
				forceSelection:true,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mÃ¯Â¿Â½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer: render_periodo,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'h_id_periodo'
		};
		// txt fecha_inicio
	Atributos[3]={
		validacion:{
				name:'fecha_inicio',
				fieldLabel:'Fecha Inicio',
				allowBlank:false,
				format : 'd/m/Y', // formato para validacion
				minValue : '01/01/1900',
				disabledDaysText: 'Dia no valido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'ca.fecha_inicio',
		dateFormat :'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_inicio',
			
	};
	
	// txt fecha_fin


	Atributos[4]={
		validacion:{
				name:'fecha_fin',
				fieldLabel:'Fecha Fin',
				allowBlank:false,
				format : 'd/m/Y', // formato para validacion
				minValue : '01/01/1900',
				disabledDaysText: 'Dia no valido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'ca.fecha_fin',
		dateFormat :'m/d/Y',
		defecto:'',
		save_as:'txt_fecha_fin',
			
	};
		Atributos[5]={
			validacion:{
			name:'descripcion',
			fieldLabel:'Descripci\u00F3n',
			allowBlank : true,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : true,
			width_grid : 400,
			width : '100%',
			disabled : false	
		},
		tipo : 'TextArea',
		form : true,
		filtro_0 : true,
		filterColValue : 'CA.descripcion',
		save_as : 'txt_descripcion'
	};
 
	// txt estado
	Atributos[6] 	= {
			validacion : {
				name : 'estado',
				fieldLabel : 'Estado',
				align : 'center',
				lazyRender : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 130,
				

			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'al.estado',
			form : false,
			save_as:'txt_estado'
	};
	

	Atributos[7]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:false,
			grid_editable:false,
			grid_visible : true,
			
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'ca.fecha_reg'
	};
	
	Atributos[8]={
		validacion:{			
			name:'usuario_reg',
			fieldLabel:'Fecha \u00DAltima Modificaci\u00F3n',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'ca.usuario_reg'
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};	

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Caiff',grid_maestro:'grid-'+idContenedor};
	var layout_caiff=new DocsLayoutMaestro(idContenedor);
	layout_caiff.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caiff,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_conexionFailure=this.cm_conexionFailure

	///////////////////////////////////
	// DEFINICIÃƒâ€œN DE LA BARRA DE MENÃƒÅ¡//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÃƒâ€œN DE FUNCIONES ------------------------- //
	//  aquÃƒÂ­ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caiff/ActionEliminarCaiff.php'},
		Save:{url:direccion+'../../../control/caiff/ActionGuardarCaiff.php'},
		ConfirmSave:{url:direccion+'../../../control/caiff/ActionGuardarCaiff.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Caiff'}};
	//-------------- DEFINICIÃƒâ€œN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0;i<Atributos.length;i++)
		{
			componentes[i]=getComponente(Atributos[i].validacion.name);
		}
	//para iniciar eventos en el formulario
		cmb_gestion = getComponente('id_gestion');
		cmb_periodo = getComponente('id_periodo');
		
		var onGestionSelect = function(e) {
			var id = cmb_gestion.getValue();
			
			//cmb_periodo.filterValues[0]=id_gestion;
			componentes[2].store.baseParams={id_gestion:id};
			cmb_periodo.modificado = true;
			cmb_periodo.setValue('');
			
		};	
		
		cmb_gestion.on('select',onGestionSelect);
		cmb_gestion.on('change',onGestionSelect);	
	}
/*********************************************************MIGRAR TRANSACCIONES CON PARTIDA ******************/
	function btn_migrar_tcp(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de migrar Transacciones con Partida?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Migrando...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
				
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,descripcion:SelectionsRecord.data.descripcion,
						   fecha_ini:SelectionsRecord.data.fecha_ini,fecha_fin:SelectionsRecord.data.fecha_fin,
						   accion:'migrar_cp'},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
			
		} else{
			Ext.MessageBox.alert('AtenciÃ³n', 'Antes debe seleccionar un item.');
		} 

	}
	/********************************************************* FIN MIGRAR TRANSACCIONES CON PARTIDA ******************/
	/*********************************************************MIGRAR TRANSACCIONES SIN PARTIDA ******************/
	function btn_migrar_tsp(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de migrar Transacciones sin Partida?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Migrando...</div>",
					width:200,
					height:200,
					closable:false
				});
				//alert(SelectionsRecord.data.fecha_inicio.dateFormat());
				//alert(SelectionsRecord.data.fecha_inicio.getValue());
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,
						    fecha_ini:''+SelectionsRecord.data.fecha_inicio+'',
						    fecha_fin:''+SelectionsRecord.data.fecha_fin+'',
						    
						   accion:'migrar_sp'},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un item.');
		} 

	}
	/********************************************************* FIN MIGRAR TRANSACCIONES SIN PARTIDA ******************/
	/*********************************************************1era ValidaciÃ³n ******************/
	function btn_validacion_1(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de realizar la primera validación')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Primera Validación...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,descripcion:SelectionsRecord.data.descripcion,
						   fecha_ini:SelectionsRecord.data.fecha_ini,fecha_fin:SelectionsRecord.data.fecha_fin,
						   accion:'1_validar'},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Informaciónn',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:10000000000000000000
				});
			}
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un item.');
		} 

	}
	/********************************************************* FIN 1ra Validacion ******************/
	/*********************************************************2da ValidaciÃ³n ******************/
	function btn_validacion_2(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('Â¿EstÃ¡ seguro de realizar la segunda validaciÃ³n')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Segunda Validación...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,descripcion:SelectionsRecord.data.descripcion,
						   fecha_ini:SelectionsRecord.data.fecha_ini,fecha_fin:SelectionsRecord.data.fecha_fin,
						   accion:'2_validar'},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('InformaciÃ³n',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('InformaciÃ³n',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:10000000000000000000
				});
			}
			
		} else{
			Ext.MessageBox.alert('AtenciÃ³n', 'Antes debe seleccionar un item.');
		} 

	}
	/********************************************************* FIN SEGUNDA VALIDACION ******************/
	/*********************************************************3era ValidaciÃ³n ******************/
	function btn_validacion_3(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de realizar la tercera validación')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Tercera Validación...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,descripcion:SelectionsRecord.data.descripcion,
						   fecha_ini:SelectionsRecord.data.fecha_ini,fecha_fin:SelectionsRecord.data.fecha_fin,
						   accion:'3_validar'},
				success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							alert ('error?');
							//Ext.MessageBox.alert('InformaciÃ³n',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							//alert('no_error');
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:100
				});
			}
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un item.');
		} 

	}
	/*********************************************************4ta Validación ******************/
	function btn_validacion_4(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de realizar la cuarta validación')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cuarta Validación...</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/caiff/ActionMigrarPartidas.php",
					method:'POST',
					params:{cantidad_ids:'1',m_id_caiff:SelectionsRecord.data.id_caiff,id_gestion:SelectionsRecord.data.id_gestion,
						   id_periodo:SelectionsRecord.data.id_periodo,descripcion:SelectionsRecord.data.descripcion,
						   fecha_ini:SelectionsRecord.data.fecha_ini,fecha_fin:SelectionsRecord.data.fecha_fin,
						   accion:'4_validar'},
				success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							alert ('error?');
							//Ext.MessageBox.alert('InformaciÃ³n',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							//alert('no_error');
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
							Ext.MessageBox.hide();	
						}
					},
					failure:CM_conexionFailure,
					timeout:100
				});
			}
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un item.');
		} 

	}
	
	/********************************************************* FIN 3ra Validacion ******************/
	/*************************************************** REPORTE DIFERENCIAS ******************/
	function btn_rep_diferencias()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff='+SelectionsRecord.data.id_caiff;	
	        data=data+'&id_gestion='+SelectionsRecord.data.id_gestion;				
	        data=data+'&sw_ejecuta=diferencias';
	       Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/caiff/ActionPDFReportesCAIF.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	/***************************************************FIN REPORTE DIFERENCIAS ******************/
	/*************************************************** REPORTE BALANCE ******************/
	function btn_rep_balance()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff='+SelectionsRecord.data.id_caiff;	
	        data=data+'&id_gestion='+SelectionsRecord.data.id_gestion;				
	              data=data+'&sw_ejecuta=balance';
		  Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			window.open(direccion+'../../../control/caiff/ActionPDFReportesCAIF.php?'+data);					
			
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	/***************************************************FIN REPORTE BALANCE******************/
	/*************************************************** REPORTE CUENTAS FALTANTES ******************/
	function btn_rep_cuentas_faltantes()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff='+SelectionsRecord.data.id_caiff;	
	            data=data+'&id_gestion='+SelectionsRecord.data.id_gestion;				
	            data=data+'&sw_ejecuta=cuenta_fasoc';
		 	Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
		 	window.open(direccion+'../../../control/caiff/ActionPDFReportesCAIF.php?'+data);					
			
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	/***************************************************FIN REPORTE CUENTAS FALTANTES ******************/
	function btn_ajustes(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff='+SelectionsRecord.data.id_caiff;
			/*data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;
			data=data+'&nombre_largo='+SelectionsRecord.data.nombre_largo;
*/  
			var ParamVentana={Ventana:{width:'100%',height:'100%'}}
			layout_caiff.loadWindows(direccion+'../../../../sis_presupuesto/vista/caiff/caiff_ajuste_cbte.php?'+data,'Ajustes',ParamVentana);
			//layout_caiff.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_comprobante2/registro_comprobante.php?'+data,'Ajustes',ParamVentana);
			}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	/*this.EnableSelect=function(sm,row,rec){
		_CP.getPagina(layout_caiff.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_caiff.getIdContentHijo()).pagina.desbloquearMenu();
		enable(sm,row,rec);
	}*/
	//para que los hijos puedan ajustarse al tamaÃƒÂ±o
	this.getLayout=function(){return layout_caiff.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÃƒï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Migrar Transaccion sin Partida',btn_migrar_tsp,true,'migrar_tsp','Migrar TSP');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Migrar Transacciones con Partida',btn_migrar_tcp,true,'migrar_tcp','Migrar TCP');
	
	this.AdicionarBoton('../../../lib/imagenes/copy.png','1era. Validacion',btn_validacion_1,true,'validacion1','1era. Validacion');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','2da. Validacion',btn_validacion_2,true,'validacion2','2da. Validacion');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','3era. Validacion',btn_validacion_3,true,'validacion3','3era. Validacion');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','4ta. Validacion',btn_validacion_4,true,'validacion4','4ta. Validacion');
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Cuentas que faltan asociar',btn_rep_cuentas_faltantes,true,'rep_cuen_fal','Cuentas Faltan Asociar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Comprobantes con Diferencias',btn_rep_diferencias,true,'rep_diferencias','Diferencias');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Balance Presupuestario',btn_rep_balance,true,'rep_balance','Balance P.');

	this.AdicionarBoton('../../../lib/imagenes/copy.png','Migrar Transaccion sin Partida',btn_migrar_tsp,true,'migrar_tsp','Migrar TSP');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Ajustes',btn_ajustes,true,'ajustes','Ajustes');
	
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte CAIF',btn_rep_caif,true,'rep_caif','CAIF');
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
//-------------- DEFINICIÃƒâ€œN DE FUNCIONES PROPIAS --------------//

	layout_caiff.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}