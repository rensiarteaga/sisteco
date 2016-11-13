<?php 
/**
 * Nombre:		  	    gestion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		
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
var elemento={pagina:new pagina_depreciacion_finalizado(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_depreciacion_finalizado(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/grupo_depreciacion/ActionListarDepreciacion2Contabilizado.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_grupo_proceso',totalRecords:'TotalCount'
		},[		
			'id_grupo_depreciacion',
			'anio_fin',
			'mes_fin_deprec',
			'id_depto',
			'desc_depto',
			'estado',
			'id_usuario',
			'usuario_reg',
			'fecha_reg',
			'id_grupo_proceso',
			'proyecto'
		]),remoteSort:true});
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_gestion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_grupo_proceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	Atributos[1]={
		validacion:{
			name:'anio_fin',
			fieldLabel:'Gestión',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			maxLength:4,
			minLength:4,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'GRU.ano_fin'
		
	};

	Atributos[2]={
			validacion:{
				name:'mes_fin_deprec',
				fieldLabel:'Mes',
				allowBlank:false,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				maxLength:4,
				minLength:4,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				align:'center',
				width:'100%',
				disabled:false,
				grid_indice:2		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'GRU.mes_fin'
			
		};
	Atributos[3]={
			validacion:{
				name:'desc_depto',
				fieldLabel:'Departamento',
				labelSeparator:'',
				inputType:'hidden',
				maxLength:20,
				grid_visible:true,
				grid_editable:false,
				width_grid:130,
				width:'100%',
				grid_indice:4		
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'DEPTO.nombre_depto'
			
		};
	Atributos[4]={
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				labelSeparator:'',
				inputType:'hidden',
				maxLength:20,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				grid_indice:5	
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false
			
		};
	Atributos[5]={
			validacion:{
			name:'usuario_reg',
			fieldLabel:'Usuario',
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			grid_indice:6		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'US.nombre_completo'
		
	};
	Atributos[6]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha reg.',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:7		
			},
			tipo:'Field',
			filtro_0:true,
			form:false,		
			filterColValue:'gru.fecha_reg',
		};
	Atributos[7]={
			validacion: {
			name:'proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:8,	
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:'no'
	};
	Atributos[8]={
			validacion:{
				name:'id_grupo_depreciacion',
				fieldLabel:'Grupo Deprec.',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				grid_indice:1		
			},
			tipo:'Field',
			filtro_0:true,
			form:false,		
			filterColValue:'gru.id_grupo_depreciacion',
		};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Maestro',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_grupo_proceso_no_borrador.php'};
	var layout_gestion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_gestion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_gestion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var cm_btnNew=this.btnNew;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu = {
			actualizar:{
				crear :true,
				separador:false
			}

		};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={

	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	function btn_nuevo(){
		cm_btnNew();
	}
	
	function btn_informe()
	{
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
				if(NumSelect==1){
					var SelectionsRecord=sm.getSelected();		
					var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
					data=data+'&txt_ano_fin='+SelectionsRecord.data.anio_fin;
					data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin_deprec;
					data=data+'&txt_depart='+SelectionsRecord.data.id_depto;
					window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteDepreciacionXLS.php?'+data);
				}
				else  {
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
				}		
	}
	function btn_reporte(){		
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
				if(NumSelect==1){
					var SelectionsRecord=sm.getSelected();		
					var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
					data=data+'&txt_ano_fin='+SelectionsRecord.data.anio_fin;
					data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin_deprec;
					data=data+'&txt_depart='+SelectionsRecord.data.desc_depto;
					window.open(direccion+'../../../../sis_activos_fijos/control/depreciacion/ActionPDFDepreciacion.php?'+data);					
					//window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/detalle_depreciacion/ActionPDFDetalleDepreciacion.php?'+data);
				}
				else if(NumSelect>1) {
					Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
				}				
	}
	
	/*************Correccion Reporte************/
	function btn_reporte_nuevo()
	{
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();		
			var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
			data=data+'&txt_ano_fin='+SelectionsRecord.data.anio_fin;
			data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin_deprec;
			data=data+'&txt_depart='+SelectionsRecord.data.desc_depto;
			window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteDepreciacionXLS2.php?'+data);
		}
		else  
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}
	}
	
	
	function btn_form605()
	{
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();		
			var data='m_id_grupo_depreciacion='+SelectionsRecord.data.id_grupo_depreciacion;
			data=data+'&txt_ano_fin='+SelectionsRecord.data.anio_fin;
			data=data+'&txt_mes_fin='+SelectionsRecord.data.mes_fin_deprec;
			data=data+'&txt_depart='+SelectionsRecord.data.desc_depto;
			window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionReporteFormulario605XLS.php?'+data);
		}
		else
		{
			window.alert(paramConfig.CantFiltros);
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro');
		}
	}
	function btn_comprobante(){		

		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_grupo_depreciacion=" + SelectionsRecord.data.id_grupo_depreciacion;
			data = data + "&maestro_ano_fin=" + SelectionsRecord.data.anio_fin;
			data = data + "&maestro_mes_fin=" + SelectionsRecord.data.mes_fin_deprec;
			
			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_gestion.loadWindows(direccion+'../../../../sis_activos_fijos/vista/depreciacion_depto/depreciacion_depto.php?'+data,'Caracteristicas AF',ParamVentana);
			layout_gestion.getVentana().on('resize',function(){
				layout_gestion.getLayout().layout();})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
				
	}
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_gestion.getIdContentHijo()).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_gestion.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/a_table.png','Generar Comprobantes',btn_comprobante,true,'comprobante','Generar Comprobantes');
	this.AdicionarBoton('../../../lib/imagenes/report.png','Reporte',btn_reporte,true,'depreciacion','Depreciacion');
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Reporte Depreciacion Excel',btn_informe,true,'depreciacion','Depreciacion');
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Detalle Form605',btn_form605,true,'formulario605','DetalleAF-Form605');
	//añadido 21/04/2014
	this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Reporte Excel',btn_reporte_nuevo,true,'depreciacion','Reporte Depreciación');
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_gestion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}