<?php 
/**
 * Nombre:		  	    bancarizacion_main.php
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
var elemento={pagina:new pagina_bancarizacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_bancarizacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:35
 */
function pagina_bancarizacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	  
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/bancarizacion/ActionListarBancarizacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_bancarizacion',totalRecords:'TotalCount'
		},[		
		'id_bancarizacion',
		'id_usuario_reg',
		'login',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado',
		'id_moneda',
		'nombre_moneda',
		'id_deptos',
		'compra_ascii',
		'venta_ascii'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{sw_reg_comp:'si'}});
    var ds_deptos = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci&todos=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto'])
	});
	
	//FUNCIONES RENDER
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda']);}
	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

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
	
	var tpl_id_deptos=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>',
                                                           '<br><FONT COLOR="#6E6E6E">Codigo: {codigo_depto}</FONT>','</div>');	
	function formatURL(val) { if(val!="")
	 {return '<a href="'+ direccion+"../../../bancarizacion/"+val+'.txt" target="_blank">'+'Descargar'+'</a>';}}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_bancarizacion',
			fieldLabel:'Identificador',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_bancarizacion'
	};
	Atributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			renderer: formatDate,
			allowBlank:false
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
		Atributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			renderer: formatDate,
			allowBlank:false
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
	Atributos[3]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:'100%'
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'BANCA.observaciones'
	};	
	Atributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'BANCA.estado'
	};
// txt id_moneda
	Atributos[5]={
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
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'85%'
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filtro_1:false,
		filterColValue:'MONEDA.nombre'
		
	};
	Atributos[6]={
			validacion:{
				name:'id_deptos',
				fieldLabel:'Departamentos',
				allowBlank:false,
				store:ds_deptos,
				valueField:'id_depto',
				returnText:false, //retorna el valor visible
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_deptos,				
				defValor:function(val,record){
					var text = '\"'+ record['codigo_depto'] +'\" ' +'<'+record['nombre_depto'] +'>';
					return text;				
				},							
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
			    width:'85%'
			},
			tipo:'ComboMultiple2',
			form: true,
			filtro_0:false,
			filtro_1:false			
	};
	Atributos[7]={
		validacion:{
			name:'compra_ascii',
			fieldLabel:'ASCII Compra',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			renderer:formatURL,
			width:120
		},
		form:false,
		tipo:'TextField'
	};	
	Atributos[8]={
		validacion:{
			name:'venta_ascii',
			fieldLabel:'ASCII Venta',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			renderer:formatURL,
			width:120
		},
		form:false,
		tipo:'TextField'
	};		
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name:'id_usuario_reg',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[10]={
		validacion:{
			name:'login',
			fieldLabel:'Usuario Reg',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		form:false,
		tipo:'TextField'
	};
	
	Atributos[11]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			renderer: formatDate1
		},
		form:false,
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatDate1(value){return value?value.dateFormat('d/m/Y H:i:s'):value};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'bancarizacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/bancarizacion_det/bancarizacion_det.php'};
	var layout_bancarizacion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_bancarizacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_bancarizacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
    var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/bancarizacion/ActionEliminarBancarizacion.php'},
		Save:{url:direccion+'../../../control/bancarizacion/ActionGuardarBancarizacion.php'},
		ConfirmSave:{url:direccion+'../../../control/bancarizacion/ActionGuardarBancarizacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Bancarización'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )	
	}

	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		
		_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.desbloquearMenu();	               	
		_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.reload(rec.data);
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_bancarizacion.getLayout()};
	
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	function generaSuccess(){
		alert('Generación del detalle exitoso');
		Ext.MessageBox.hide();						
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
	}
	
	function generaasciiSuccess(){
		alert('El archivo se generó exitosamente');
		Ext.MessageBox.hide();						
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
	}
	
	function btn_generar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			Ext.Ajax.request({
						url:direccion+"../../../../sis_contabilidad/control/bancarizacion/ActionGeneraDetalleBancarizacion.php?"+data,
						success:generaSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_rep_pdf(t){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			data=data+'&tipo_operacion='+t;
			
			window.open(direccion+'../../../control/bancarizacion/ActionPDFBancarizacion.php?'+data)
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}
	
	function btn_rep_ascii(t){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			data=data+'&tipo_operacion='+t;
			Ext.Ajax.request({
						url:direccion+"../../../../sis_contabilidad/control/bancarizacion/ActionGeneraAscii.php?"+data,
						success:generaasciiSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}	
	
	function btn_rep_xls(t){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			data=data+'&tipo_operacion='+t;
			
			window.open(direccion+'../../../control/bancarizacion/ActionXLSBancarizacion.php?'+data)
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}
	
	var sw_reporte_compras = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_compras',fields:['ID','valor','filtro'],
                                              data:[['XLS','Archivo Excel'],['PDF','Reporte'],['TXT','Archivo ASCII']]}),
                                              typeAhead: false,
                                              mode:'local',
                                              triggerAction:'all',
                                              emptyText:'Compras...',
                                              selectOnFocus:true,
                                              width:120,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});
	
	sw_reporte_compras.on('select',function (combo, record, index)
	{  
		if(sw_reporte_compras.getValue()=="PDF"){
			btn_rep_pdf('compra');
		}else{
			if(sw_reporte_compras.getValue()=="XLS"){
				btn_rep_xls('compra');
			}else{
				btn_rep_ascii('compra');
			}
		}
		sw_reporte_compras.setValue("");
	});
	
    var sw_reporte_ventas = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_ventas',fields:['ID','valor','filtro'],
                                              data:[['XLS','Archivo Excel'],['PDF','Reporte'],['TXT','Archivo ASCII']]}),
                                              typeAhead:false,
                                              mode:'local',
                                              triggerAction:'all',
                                              emptyText:'Ventas...',
                                              selectOnFocus:true,
                                              width:120,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});	
    
    sw_reporte_ventas.on('select',function (combo, record, index)
	{  
	 	if(sw_reporte_ventas.getValue()=="PDF"){
	 		btn_rep_pdf('venta');
	 	}else{
	 		if(sw_reporte_ventas.getValue()=="XLS"){
		 		btn_rep_xls('venta');
		 	}else{
		  	   	btn_rep_ascii('venta');
		 	}
	 	}
	 	sw_reporte_ventas.setValue("");
	});                      
	
    this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
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
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Generar',btn_generar,true,'generar_det','Generar Detalle');
    this.AdicionarBotonCombo(sw_reporte_compras,'Reporte Compras');
    this.AdicionarBotonCombo(sw_reporte_ventas,'Reporte Ventas');
    
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_bancarizacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}