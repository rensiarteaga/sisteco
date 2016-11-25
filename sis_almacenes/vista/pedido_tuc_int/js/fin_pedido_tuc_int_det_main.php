<?php
/**
 * Nombre:		  	    fin_pedido_tuc_int_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		30/12/2016
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
	var maestro={id_salida:<?php echo $m_id_salida;?>,correlativo_sal:'<?php echo $m_correlativo_sal;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_fin_pedido_tuc_int_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento)
}
Ext.onReady(main,main);
 
/**
* Nombre:		  	    pagina_almacen_logico_det.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi arteaga Copari
* Fecha creación:		03/12/2016
*/
function pagina_fin_pedido_tuc_int_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_fin_pedido_tuc_int,combo_bloqueado,combo_cerrado,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/pedido_tuc_int/ActionListarPedidoTucInt.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_pedido_tuc_int',totalRecords:'TotalCount'},
		['id_pedido_tuc_int',
		 'id_salida',
         'id_orden_salida_uc_detalle',
         'id_tipo_unidad_constructiva',
         'id_item',
         'cantidad_solicitada',
         'nuevo',
         'fecha_reg',
         'usado',
         'demasia',
         'sw_autorizado',
         'sw_entregado',
         'id_salida_complementaria',
         'nombre',
         'codigo',
         'descripcion',
         'correlativo_sal_com'  
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_salida:maestro.id_salida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Salida',maestro.id_salida],['Correlativo',maestro.correlativo_sal],['Nombre',maestro.correlativo_sal]]}),cm:cmMaestro});
	gridMaestro.render();
	
	
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_pedido_tuc_int',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_pedido_tuc_int'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'id_salida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_almacen_ep,
		save_as:'txt_id_salida'
	};
	
	vectorAtributos[2]={
		validacion:{
			name:'id_parametro_almacen',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_almacen_ep,
		save_as:'txt_id_almacen_ep'
	};

  
	vectorAtributos[3]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'codigo',
		save_as:'txt_codigo'
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'nombre',
		save_as:'txt_nombre'
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'cantidad_solicitada',
			fieldLabel:'Solicitado',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'cantidad_solicitada',
		save_as:'txt_cantidad_solicitada'
	};
	
	vectorAtributos[6]={
		validacion:{
			name:'demasia',
			fieldLabel:'Demasia',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'demasia',
		save_as:'txt_cdemasia'
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'nuevo',
			fieldLabel:'Disponible',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'nuevo',
		save_as:'txt_nuevo'
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'faltante',
			fieldLabel:'Faltante',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1,
			renderer: 	function (value, p, record){return String.format('{0}', (record.data['cantidad_solicitada']  - record.data['nuevo'])*1 + record.data['demasia']*1)}
		},
		tipo:'NumberField',
		filtro_0: false
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'sw_autorizado',
			fieldLabel:'Autorizado S/E',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sw_autorizado',
		save_as:'txt_sw_autorizado'
	};
	
	vectorAtributos[10]={
		validacion:{
			name:'sw_entregado',
			fieldLabel:'Entregado',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sw_entregado',
		save_as:'txt_sw_entregado'
	};
	
	vectorAtributos[11]={
		validacion:{
			name:'id_salida_complementaria',
			fieldLabel:'ID Salida Com.',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sw_id_salida_complementaria'
	};


	

		// txt id_unidad_organizacional

	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Almacenes - Estructura Programática (Maestro)',titulo_detalle:'Almacenes Lógicos (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_fin_pedido_tuc_int=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_fin_pedido_tuc_int.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_fin_pedido_tuc_int,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var Cm_btnActualizar = this.btnActualizar;
	var Cm_conexionFailure=this.conexionFailure;
	
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Almacen Lógico'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_salida=datos.m_id_salida
		maestro.correlativo_sal = datos.m_correlativo_sal;
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_salida:maestro.id_salida
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Salida',maestro.id_salida],['Correlativo',maestro.correlativo_sal]]);
	};
	
	
	
	
	
	//función revalorar costos en toda la gestion
	function btn_generar_salida(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){			
				var SelectionsRecord=sm.getSelected();
				var data=SelectionsRecord.data.id_salida;
				Ext.MessageBox.show({
					title: 'Ejecutando proceso',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando ...</div>",
					width:350,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/pedido_tuc_int/ActionGenerarSalidaPendiente.php?hidden_id_salida="+data,
					method:'GET',
					success:terminado,
					failure:Cm_conexionFailure,
					timeout:9999999//TIEMPO DE ESPERA PARA DAR FALLO
				});			
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	

	function terminado(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Proceso finalizado.<br>');
		Cm_btnActualizar()
	}
	
	
	this.getLayout=function(){
		return layout_fin_pedido_tuc_int.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/lock_open.png','Generar salida con los items faltantes',btn_generar_salida,true,'gen_sal_tuc','');
	
	this.iniciaFormulario();
	layout_fin_pedido_tuc_int.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}