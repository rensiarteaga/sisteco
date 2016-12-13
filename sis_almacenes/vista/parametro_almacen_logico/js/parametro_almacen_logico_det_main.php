<?php
/**
 * Nombre:		  	    almacen_logico_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 18:53:05
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
	var maestro={id_almacen_logico:<?php echo $m_id_almacen_logico;?>,codigo:'<?php echo $m_codigo;?>',nombre:'<?php echo $m_nombre;?>',descripcion:'<?php echo $m_descripcion;?>'};
	var elemento={idContenedor:idContenedor,pagina:new pagina_parametro_almacen_logico_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento)
}
Ext.onReady(main,main);
 
/**
* Nombre:		  	    pagina_almacen_logico_det.js
* Propósito: 			pagina objeto principal
* Autor:				Rensi arteaga Copari
* Fecha creación:		03/12/2016
*/
function pagina_parametro_almacen_logico_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,layout_parametro_almacen_logico,combo_bloqueado,combo_cerrado,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro_almacen_logico/ActionListarParametroAlmacenLogico.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_almacen_logico',totalRecords:'TotalCount'},
		['id_parametro_almacen_logico',
		'id_almacen_logico',
		'id_parametro_almacen',
		'gestion',
		'estado'
		]),remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_almacen_logico:maestro.id_almacen_logico
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Almacén Lógico',maestro.id_almacen_logico],['Codigo',maestro.codigo],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	
	//FUNCIONES RENDER
	function render_id_tipo_almacen(value,p,record){return String.format('{0}',record.data['desc_tipo_almacen'])};
	var resultTplTipoAlm=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquía: </b>{nombre_nivel}</FONT>','</div>');

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_parametro_almacen_logico',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_logico'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'id_almacen_logico',
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
			name:'gestion',
			fieldLabel:'Gestión',
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
		filterColValue:'gestion',
		save_as:'txt_gestion'
	};


	vectorAtributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
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
		filterColValue:'gestion',
		save_as:'txt_cgestion'
	};

	

		// txt id_unidad_organizacional

	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Almacenes - Estructura Programática (Maestro)',titulo_detalle:'Almacenes Lógicos (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_parametro_almacen_logico=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_parametro_almacen_logico.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_parametro_almacen_logico,idContenedor);
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
		maestro.id_almacen_logico=datos.m_id_almacen_logico
		maestro.codigo=datos.m_codigo;
		maestro.nombre=datos.m_nombre;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_logico:maestro.id_almacen_logico
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Almacén Lógico',maestro.id_almacen_logico],['Codigo',maestro.codigo],['Nombre',maestro.nombre],['Descripción',maestro.descripcion]]);
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------///
	function btn_kardex_logico(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			layout_parametro_almacen_logico.loadWindows(direccion+'../../../vista/kardex_logico/kardex_logico_det.php?'+data,'Kardex',ParamVentana);
			layout_parametro_almacen_logico.getVentana().on('resize',function(){
				layout_parametro_almacen_logico.getLayout().layout()
			})
		}
	}
	
	//función cerrar la gestion y crear una nueva con los saldos iniciales
	function btn_fin_gestion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(confirm("¿Está seguro de cerrar la gestión?")){
				var SelectionsRecord=sm.getSelected();
				var data=SelectionsRecord.data.id_parametro_almacen_logico;
				Ext.MessageBox.show({
					title: 'Ejecutando proceso',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cerrando  Gestión ...</div>",
					width:350,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/parametro_almacen_logico/ActionCerrarGestion.php?hidden_id_parametro_almacen_logico="+data,
					method:'GET',
					success:terminado,
					failure:Cm_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				})
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function terminado(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Gestion finalizada.<br>');
		Cm_btnActualizar()
	}
	
	
	this.getLayout=function(){
		return layout_parametro_almacen_logico.getLayout()
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
	this.AdicionarBoton('../../../lib/imagenes/book_open.png','Kardex',btn_kardex_logico,true,'kardex_logico','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Cerrar Gestión',btn_fin_gestion,true,'ter_ges','');
	
	this.iniciaFormulario();
	layout_parametro_almacen_logico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}