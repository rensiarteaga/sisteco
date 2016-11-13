<?php
/**
 * Nombre:		  	    actualizacion.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Jose MIta
 * Fecha creación:		2010-11-25 19:06:46
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
	var maestro={id_depto:decodeURIComponent(<?php echo $id_depto;?>),codigo_depto:decodeURIComponent('<?php echo $codigo_depto;?>'),nombre_depto:decodeURIComponent('<?php echo $nombre_depto;?>')};
	
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new pagina_actualizacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_cuenta_doc_rendicion_cab.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 19:06:46
 */

function pagina_actualizacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{ 
	var Atributos=new Array,sw=0;
	var var_id_depto;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/actualizacion/ActionListarActualizacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actualizacion',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_actualizacion',
		{name: 'fecha',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_depto',
		'desc_depto',
		'descripcion',
		'id_usuario',
		'desc_usuario',
		'id_moneda',
		'desc_moneda',
		'id_comprobante',
		'glosa_cbte',
		'nro_cbte'
	]),remoteSort:true});
	
	//DATA STORE COMBOS
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	}); 
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
	//FUNCIONES RENDER
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto'])}			
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#0000ff">{desc_depto}</FONT><br>','</div>'); 
	
	// DEFINICIÓN DATOS DEL MAESTRO
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_actualizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	// txt id_depto
	Atributos[1]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:true,
			emptyText:'Departamento...',
			desc: 'desc_depto',
			store:ds_depto,
			valueField: 'id_depto',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'id_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:0,		
		save_as:'id_depto'
	};
	
 	Atributos[2]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha Actualización',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			align:'center',
			width_grid:120,
			disabled:false
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'actual.fecha',
		dateFormat:'m-d-Y',
		defecto:new Date(),
		save_as:'fecha'
	};
 	
	Atributos[3]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
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
			pageSize:10,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:250	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	Atributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,			
			grid_visible:true,
			grid_editable:false,
			width_grid:280,
			width:250,
			disabled:false		
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'actual.descripcion',
		form: true
	};

	Atributos[5]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'ID Comprobante',
			name: 'id_comprobante',
			allowBlank:true,
			allowDecimals:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width_grid:100,
			width:'100%',
			disabled:true
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'actual.id_comprobante',
		save_as:'id_comprobante'
	};
	
	Atributos[6]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Nº Cbte.',
			name: 'nro_cbte',
			allowBlank:true,
			allowDecimals:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'right',
			width:'100%',
			disabled:true
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'actual.nro_cbte',
		save_as:'nro_cbte'
	};
	
	Atributos[7]={
		validacion:{
			name:'desc_usuario',
			fieldLabel:'Usuario',
			allowBlank:true,			
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo:'TextField',
		form: false
	};
	
	Atributos[8]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false
		},
		form:false,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'actual.fecha_reg',
		dateFormat:'m-d-Y',
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){   return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' (Maestro)',titulo_detalle:'Actualización Detalle'         ,grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_parametros/vista/actualizacion_detalle/actualizacion_detalle.php?idSub='+decodeURI('Actualización Detalle')+'&'};
	var layout = new DocsLayoutMaestroDeatalle(idContenedor );
	layout.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);

	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit =this.btnEdit;
	var ClaseMadre_Eliminar =this.btnEliminar;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionEliminarActualizacion.php'},
		Save:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionGuardarActualizacion.php'},
		ConfirmSave:{url:direccion+'../../../../sis_contabilidad/control/actualizacion/ActionGuardarActualizacion.php' },
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Registro de actualizaciones',	
		grupos:[{
				tituloGrupo:'Datos de Actualización',
				columna:0,
				id_grupo:0}]
	}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		maestro=Ext.urlDecode(decodeURIComponent(params));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		};

		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		ClaseMadre_btnActualizar();
		var_id_depto.setValue(maestro.id_depto);
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		var_id_depto=ClaseMadre_getComponente('id_depto');
	}
	
   this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data);	
	}
   
   this.btnNew=function(){
 		var_id_depto.setDisabled(true);
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		 CM_btnNew();
		 var_id_depto.setValue(maestro.id_depto);
		console.log(ClaseMadre_getFormulario()); 
	};
	
	this.btnEdit=function(){
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		 CM_btnEdit();
		 var_id_depto.setValue(maestro.id_depto);
	}; 
	
	this.btnEliminar=function(){
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		 ClaseMadre_Eliminar();
	}; 
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.getLayout=function(){return layout.getLayout()};
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();

	function btn_generar_actualizacion(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_id_actualizacion=datas_edit.id_actualizacion;
			
			Ext.MessageBox.confirm("Atención","Esta seguro de Generar la Actualización?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Actualización ...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando Actualización ...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../../sis_contabilidad/control/actualizacion/ActionGenerarActualizacion.php",
					success:mostrar_respuesta,
					params:{m_id_actualizacion:datas_edit.id_actualizacion, m_sw_proce:'gen_act'},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una Actualización.');
		}
	}
	
	function btn_ajustar_saldo(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_id_actualizacion=datas_edit.id_actualizacion;
			
			Ext.MessageBox.confirm("Atención","Esta seguro de Ajustar los Saldos?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Actualización ...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ajustando Saldos ...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../../sis_contabilidad/control/actualizacion/ActionGenerarActualizacion.php",
					success:mostrar_respuesta,
					params:{m_id_actualizacion:datas_edit.id_actualizacion, m_sw_proce:'aju_sal'},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una Ultima Actualización.');
		}
	}
	
	function mostrar_respuesta(resp){
		Ext.MessageBox.confirm("Generación",resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue+" ",
		function(btn){
			ds.baseParams={
				start:0,
				limit: 30,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			};
			ds.load({
				params:{
					start:0,
					limit:paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_depto:maestro.id_depto
				}
			});
		 });
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
	}
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Generar Actualización',btn_generar_actualizacion,true,'genrar actualizacion','Generar Actualización');
	//this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Ajusta los Saldos Actalizados',btn_ajustar_saldo,true,'ajustar saldos','Ajustar Saldos');
	
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	
 
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_depto:maestro.id_depto
		}
	});
}