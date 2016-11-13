<?php 
/**
 * Nombre:		  	    parametro_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:35
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
var elemento={pagina:new pagina_parametro(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_parametro.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:35
 */
function pagina_parametro(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	  
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'
		},[		
		'id_parametro',
		'id_gestion',
		'desc_gestion',
		'cantidad_nivel',
		'estado_gestion',
		'gestion_conta',
		'porcen_iva',
		'porcen_it',
		'porcen_servicio',
		'porcen_bien',
		'porcen_remesa',
		'id_moneda',
		'nombre_moneda',
		'id_fina_regi_prog_proy_acti',
		'epe',
		'id_unidad_organizacional',
		'desc_unidad_organizacional'
		]),remoteSort:true});
	
	//DATA STORE COMBOS

    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=conta_parametro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});
    
    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
    
	var ds_epe = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuarioSCI.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','id_financiador','codigo_financiador','nombre_financiador','id_regional','codigo_regional','nombre_regional','id_programa','codigo_programa','nombre_programa','id_proyecto','codigo_proyecto','nombre_proyecto','id_actividad','codigo_actividad','nombre_actividad','desc_epe']),	baseParams:{sw_reg_comp:'si'}});
    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])});
    
    var tpl_id_epe=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_financiador}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_regional}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_programa}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_proyecto}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_actividad}</FONT>','</div>');
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>Unidad: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<b>Centro: </b><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

	function render_id_epe(value, p, record){rf = ds_epe.getById(value);if(rf!=null){record.data['id_fina_regi_prog_proy_acti'] =rf.data['id_fina_regi_prog_proy_acti'];record.data['epe'] =rf.data['desc_epe'];};return String.format('{0}',record.data['epe'])}
	function render_id_unidad_organizacional(value, p, record){rf = ds_unidad_organizacional.getById(value);if(rf!=null){record.data['id_unidad_organizacional'] =rf.data['id_unidad_organizacional'];record.data['desc_unidad_organizacional'] =rf.data['nombre_unidad'];};return String.format('{0}',record.data['desc_unidad_organizacional'])}
	
	ds_moneda.baseParams={
			estado:'activo'
	};
	
	//FUNCIONES RENDER
	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['nombre_moneda'])}

	function render_estado_gestion(value, p, record){
		if (value==1) {
			return 'Pre Abierto';
		}else if(value==2){
			return 'Abierto';
		}else if(value==3){
			return 'Pre Cerrado';
		}else if(value==4){
			return 'Cerrado';
		}
	
	}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion}</FONT><br>','</div>');
    var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
				
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_parametro',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_parametro'
	};
// txt id_gestion
	Atributos[1]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
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
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		save_as:'id_gestion'
	};
// txt cantidad_nivel
	Atributos[2]={
		validacion:{
			name:'cantidad_nivel',
			fieldLabel:'N° de Niveles',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			maxValue:99,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:50,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.cantidad_nivel',
		save_as:'cantidad_nivel'
	};
	
	
// txt estado_gestion
	Atributos[3]={
		validacion:{
			name:'estado_gestion',
			fieldLabel:'Estado Gestión',
			typeAhead:false,
			//allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','2','3','4'],['Pre Abierto','Abierto','Pre Cerrado','Cerrado']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:2,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			renderer:render_estado_gestion		
		},
		tipo: 'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'PARAM.estado_gestion',
		save_as:'estado_gestion'
	};
// txt gestion_conta
	Atributos[4]={
		validacion:{
			name:'gestion_conta',
			fieldLabel:'Gestión Contabilidad',
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
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'PARAM.gestion_conta',
		save_as:'gestion_conta'
	};
// txt porcen_iva
	Atributos[5]={
		validacion:{
			name:'porcen_iva',
			fieldLabel:'Porcentaje IVA',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.porcen_iva',
		save_as:'porcen_iva'
	};
// txt porcen_it
	Atributos[6]={
		validacion:{
			name:'porcen_it',
			fieldLabel:'Porcentaje IT',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.porcen_it',
		save_as:'porcen_it'
	};
// txt porcen_servicio
	Atributos[7]={
		validacion:{
			name:'porcen_servicio',
			fieldLabel:'Porcentaje Servicio',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.porcen_servicio',
		save_as:'porcen_servicio'
	};
// txt porcen_bien
	Atributos[8]={
		validacion:{
			name:'porcen_bien',
			fieldLabel:'Porcentaje Bien',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.porcen_bien',
		save_as:'porcen_bien'
	};
// txt porcen_remesa
	Atributos[9]={
		validacion:{
			name:'porcen_remesa',
			fieldLabel:'Porcentaje Remesa',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAM.porcen_remesa',
		save_as:'porcen_remesa'
	};
	//id_moneda
	Atributos[10]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'nombre_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'50%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};

	
	Atributos[11]={
			validacion:{
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'Estructura Programàtica...',
			desc: 'epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_epe,
			valueField: 'id_fina_regi_prog_proy_acti',
			displayField: 'desc_epe',
			queryParam: 'filterValue_0',
			filterCol:'FRPPA.desc_epe#FRPPA.nombre_financiador#FRPPA.nombre_regional#FRPPA.nombre_programa#FRPPA.nombre_proyecto#FRPPA.nombre_actividad',
			typeAhead:false,
			tpl:tpl_id_epe,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_epe,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//id_grupo:1,
		filterColValue:'epe',
		save_as:'id_fina_regi_prog_proy_acti'
	};

// txt id_unidad_organizacional
	Atributos[12]={
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
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//id_grupo:1,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional' 
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'parametro',grid_maestro:'grid-'+idContenedor};
	var layout_parametro=new DocsLayoutMaestro(idContenedor);
	layout_parametro.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro/ActionEliminarParametro.php'},
		Save:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:350,minWidth:150,minHeight:200,	closable:true,titulo:'parametro'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_nivel_cuenta(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro='+SelectionsRecord.data.id_parametro;

			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_parametro.loadWindows(direccion+'../../../../sis_contabilidad/vista/nivel_cuenta/nivel_cuenta.php?'+data,'Niveles del Plan de Cuentas',ParamVentana);
		}
		else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_cuenta_bancariz(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro='+SelectionsRecord.data.id_parametro;
                data=data+'&m_id_gestion='+SelectionsRecord.data.id_gestion;  
			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_parametro.loadWindows(direccion+'../../../../sis_contabilidad/vista/cuenta_bancariz/cuenta_bancariz.php?'+data,'Bancarizacion de Cuentas',ParamVentana);
		}
		else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_migrar(){       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1){
			if(confirm('Esta seguro de Migrar Plan de Cuentas, Relacionador Contable-Presupuestario y Relaciones Contables de la gestión anterior a la actual?'))
				{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_0=" + SelectionsRecord.data.id_parametro+"&cantidad_ids=1&accion=migrar";
				
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Migrando información...</div>",
					width:200,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({url:direccion+"../../../control/parametro/ActionGuardarParametro.php",
				params:data,
				method:'POST',
				success:function(resp){
					var root = resp.responseXML.documentElement;
					var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
					if(error=='1'){
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
						return;
					} else {
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
					}
					ds.load({params:{
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}});
				},
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion.');
		}
	}
	
	function btn_actual(){       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1){
			if(confirm('Esta seguro de Actualizar Relaciones Contables de la gestión anterior a la actual?'))
				{sw=true}
			if(sw){
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_0=" + SelectionsRecord.data.id_parametro+"&cantidad_ids=1&accion=actual";
				
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Actualizando información...</div>",
					width:200,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({url:direccion+"../../../control/parametro/ActionGuardarParametro.php",
				params:data,
				method:'POST',
				success:function(resp){
					var root = resp.responseXML.documentElement;
					var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
					if(error=='1'){
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
						return;
					} else {
						Ext.MessageBox.alert('Informacion',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
					}
					ds.load({params:{
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}});
				},
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
 
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_parametro.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Niveles del Plan de Cuentas',btn_nivel_cuenta,true,'nivel_cuenta','Niveles');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Bancarizacion de Cuentas',btn_cuenta_bancariz,true,'cuenta_bancariz','Bancarizacion');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Permite migrar los plan de cuentas y parametrizaciones de la gestion anterior a la nueva',btn_migrar,true,'migrar','Migrar del anterior');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Permite Actualizar Parametrizaciones de la gestion anterior a la nueva',btn_actual,true,'migrar','Actualizar del anterior');

	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_parametro.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}