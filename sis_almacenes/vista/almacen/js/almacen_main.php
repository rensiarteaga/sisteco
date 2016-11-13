<?php 
/**
 * Nombre:		  	    almacen_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:00:48
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_almacen(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/******
* Nombre:		  	    pagina_almacen_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-18 21:00:48
*/
function pagina_almacen(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_almacen,txt_filas,txt_columnas,combo_bloqueado,combo_cerrado,txt_nro_prest_pendientes,txt_nro_ing_no_finalizados,txt_nro_sal_no_finalizadas,txt_fecha_ultimo_inventario,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen',totalRecords:'TotalCount'},
		['id_almacen',
		'codigo',
		'nombre',
		'descripcion',
		'direccion',
		'via_fil_max',
		'via_col_max',
		'bloqueado',
		'cerrado',
		'nro_prest_pendientes',
		'nro_ing_no_finalizados',
		'nro_sal_no_finalizadas',
		'observaciones',
		{name:'fecha_ultimo_inventario',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_regional',
		'id_regional',
		'superficie_m2'
		]),remoteSort:true
	});
	ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
	//DATA STORE COMBOS
	var ds_regional=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/regional/ActionListarRegional.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','codigo_regional','nombre_regional','descripcion_regional','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])});
	function render_id_regional(value,p,record){return String.format('{0}',record.data['desc_regional'])}
	var resultTplRegional=new Ext.Template('<div class="search-item">','<b><i>{nombre_regional}</i></b>','<br><FONT COLOR="#B5A642">{codigo_regional}</FONT>','</div>');

	vectorAtributos[0]={validacion:{labelSeparator:'',name:'id_almacen',inputType:'hidden',grid_visible:false,grid_editable:false},tipo:'Field',filtro_0:false,save_as:'hidden_id_almacen'};
	vectorAtributos[1]={validacion:{name:'codigo',fieldLabel:'Código',allowBlank:false,maxLength:20,minLength:0,selectOnFocus:true,vtype:'texto',grid_visible:true,grid_editable:false,width_grid:85},tipo:'TextField',filtro_0:true,filterColValue:'ALMACE.codigo',save_as:'txt_codigo'};
	vectorAtributos[2]={validacion:{name:'nombre',fieldLabel:'Nombre',allowBlank:false,maxLength:50,minLength:0,selectOnFocus:true,vtype:'texto',grid_visible:true,grid_editable:true,width_grid:105,width:'85%'},tipo: 'TextField',filtro_0:true,filterColValue:'ALMACE.nombre',save_as:'txt_nombre'};
	vectorAtributos[3]={validacion:{name:'id_regional',fieldLabel:'Ubicación',allowBlank:false,emptyText:'Regional...',desc:'desc_regional',store:ds_regional,valueField:'id_regional',displayField:'nombre_regional',filterCol:'REGION.codigo_regional#REGION.nombre_regional',typeAhead:true,forceSelection:true,tpl:resultTplRegional,mode:'remote',queryDelay:250,pageSize:20,minListWidth:200,grow:true,width:'85%',resizable:true,queryParam:'filterValue_0',minChars:1,triggerAction:'all',editable:true,renderer:render_id_regional,grid_visible:true,grid_editable:true,width_grid:100},tipo:'ComboBox',filtro_0:true,filterColValue:'REGION.codigo_regional#REGION.nombre_regional',defecto:'',save_as:'txt_id_regional'};
	vectorAtributos[4]={validacion:{name:'direccion',fieldLabel:'Dirección',allowBlank:false,maxLength:150,minLength:0,selectOnFocus:true,vtype:'texto',grid_visible:true,grid_editable:true,width_grid:150,width:'85%'},tipo:'TextField',filtro_0:true,filterColValue:'ALMACE.direccion',save_as:'txt_direccion'};
	vectorAtributos[5]={validacion:{name:'descripcion',fieldLabel:'Descripción',allowBlank:true,maxLength:150,minLength:0,selectOnFocus:true,vtype:'texto',grid_visible:true,grid_editable:true,width_grid:180,width:'85%'},tipo:'TextArea',filtro_0:false,filterColValue:'ALMACE.descripcion',save_as:'txt_descripcion'};
	vectorAtributos[6]={validacion:{name:'observaciones',fieldLabel:'Observaciones',allowBlank:true,maxLength:200,minLength:0,selectOnFocus:true,vtype:'texto',grid_visible:true,grid_editable:true,width_grid:180,width:'85%'},tipo:'TextArea',filtro_0:false,filterColValue:'ALMACE.observaciones',save_as:'txt_observaciones'};
	vectorAtributos[7]={
		validacion:{
			name:'via_fil_max',
			fieldLabel:'# Filas',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:50
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'ALMACE.via_fil_max',
		save_as:'txt_via_fil_max'
	};

	vectorAtributos[8]={
		validacion:{
			name:'via_col_max',
			fieldLabel:'# Columnas',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:70
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'ALMACE.via_col_max',
		save_as:'txt_via_col_max'
	};

	vectorAtributos[9]={
		validacion:{
			name:'bloqueado',
			fieldLabel:'Bloqueado',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.almacen_combo.bloqueado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:80
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.bloqueado',
		defecto:'no',
		save_as:'txt_bloqueado'
	};

	vectorAtributos[10]={
		validacion:{
			name:'cerrado',
			fieldLabel:'Cerrado',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.almacen_combo.cerrado}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['No','No'],['Definitivo','Definitivo'],['Periodico','Periodico'],['Gestion','Gestion']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:80
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.cerrado',
		defecto:'No',
		save_as:'txt_cerrado'
	};

	vectorAtributos[11]={
		validacion:{
			name:'nro_prest_pendientes',
			fieldLabel:'Cantidad de Prestamos Pendientes ',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:200
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'ALMACE.nro_prest_pendientes',
		defecto:'0',
		save_as:'txt_nro_prest_pendientes'
	};

	vectorAtributos[12]={
		validacion:{
			name:'nro_ing_no_finalizados',
			fieldLabel:'# Ingresos no Realizados',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:140
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'ALMACE.nro_ing_no_finalizados',
		defecto:'0',
		save_as:'txt_nro_ing_no_finalizados'
	};

	vectorAtributos[13]={
		validacion:{
			name:'nro_sal_no_finalizadas',
			fieldLabel:'# Salidas no Finalizadas',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:140
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'ALMACE.nro_sal_no_finalizadas',
		defecto:'0',
		save_as:'txt_nro_sal_no_finalizadas'
	};

	vectorAtributos[14]={
		validacion:{
			name:'fecha_ultimo_inventario',
			fieldLabel:'Fecha del Ultimo Inventario',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:false,
			grid_editable:false,
			renderer:formatDate,
			width_grid:180,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'ALMACE.fecha_ultimo_inventario',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultimo_inventario'
	};

	vectorAtributos[15]={
		validacion:{
			name:'superficie_m2',
			fieldLabel:'Superficie(m2)',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:1,
			vtype:'texto',
			width:'40%',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			align:'right'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ALMACE.superficie_m2',
		save_as:'txt_superficie_m2'
	};

	vectorAtributos[16]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'ALMACE.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};

	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Almacen',grid_maestro:'grid-'+idContenedor};
	layout_almacen=new DocsLayoutMaestro(idContenedor);
	layout_almacen.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/almacen/ActionEliminarAlmacen.php'},
		Save:{url:direccion+'../../../control/almacen/ActionGuardarAlmacen.php'},
		ConfirmSave:{url:direccion+'../../../control/almacen/ActionGuardarAlmacen.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'45%',minWidth:150,minHeight:200,	closable:true,titulo:'Almacen'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_almacen_sector(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen='+SelectionsRecord.data.id_almacen;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_via_fil_max='+SelectionsRecord.data.via_fil_max;
			data=data+'&m_via_col_max='+SelectionsRecord.data.via_col_max;
			data=data+'&m_superficie_m2='+SelectionsRecord.data.superficie_m2;
			var ParamVentana={Ventana:{width:'90%',height:'80%'}};
			layout_almacen.loadWindows(direccion+'../../almacen_sector/almacen_sector_det.php?'+data,'Sectores del Almacén',ParamVentana);
			layout_almacen.getVentana().on('resize',function(){layout_almacen.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		txt_filas=ClaseMadre_getComponente('via_fil_max');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_columnas=ClaseMadre_getComponente('via_col_max');
		combo_bloqueado=ClaseMadre_getComponente('bloqueado');
		combo_cerrado=ClaseMadre_getComponente('cerrado');
		txt_nro_prest_pendientes=ClaseMadre_getComponente('nro_prest_pendientes');
		txt_nro_ing_no_finalizados=ClaseMadre_getComponente('nro_ing_no_finalizados');
		txt_nro_sal_no_finalizadas=ClaseMadre_getComponente('nro_sal_no_finalizadas');
		txt_fecha_ultimo_inventario=ClaseMadre_getComponente('fecha_ultimo_inventario');
		function onFilasSelect(){
			var filas=txt_filas.getValue();
			if(filas<=0){
				Ext.MessageBox.alert('Cantidad de Filas', 'La cantidad de Filas debe ser igual o mayor a 1');
				txt_filas.setValue('')
			}
		}
		txt_filas.on('select',onFilasSelect);
		txt_filas.on('change',onFilasSelect);
		function onColumnasSelect(){
			var columnas=txt_columnas.getValue();
			if(columnas<=0){
				Ext.MessageBox.alert('Cantidad de Columnas', 'La cantidad de Columnas debe ser igual o mayor a 1');
				txt_columnas.setValue('')
			}
		}
		txt_columnas.on('select',onColumnasSelect);
		txt_columnas.on('change',onColumnasSelect);
		////para controlar boqueados y cerrados////////
		function onCerradoSelect(){
			var cerrado=combo_cerrado.getValue();
			if(cerrado=='si'){
				combo_bloqueado.setValue('si');
				combo_bloqueado.disable()
			}
			else{combo_bloqueado.enable()}
		}
		combo_cerrado.on('select',onCerradoSelect);
		combo_cerrado.on('change',onCerradoSelect)
	}

	this.btnNew=function(){
		CM_ocultarComponente(txt_nro_ing_no_finalizados);
		CM_ocultarComponente(txt_nro_sal_no_finalizadas);
		CM_ocultarComponente(txt_fecha_ultimo_inventario);
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(combo_bloqueado);
		CM_ocultarComponente(combo_cerrado);
		CM_ocultarComponente(txt_nro_prest_pendientes);
		txt_nro_ing_no_finalizados.disable();
		txt_nro_sal_no_finalizadas.disable();
		txt_nro_prest_pendientes.disable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_nro_ing_no_finalizados);
		CM_ocultarComponente(txt_nro_sal_no_finalizadas);
		CM_ocultarComponente(txt_fecha_ultimo_inventario);
		CM_ocultarComponente(txt_fecha_reg);
		CM_ocultarComponente(combo_bloqueado);
		CM_ocultarComponente(combo_cerrado);
		CM_ocultarComponente(txt_nro_prest_pendientes);
		txt_nro_prest_pendientes.disable();
		txt_nro_ing_no_finalizados.disable();
		txt_nro_sal_no_finalizadas.disable();
		ClaseMadre_btnEdit()
	};
	this.getLayout=function(){return layout_almacen.getLayout()};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Sectores del Almacén',btn_almacen_sector,true,'almacen_sector','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_almacen.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}