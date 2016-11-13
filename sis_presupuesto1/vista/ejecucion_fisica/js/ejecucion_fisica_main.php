<?php
/**
 * Nombre:		  	    solicitud_compra_item_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_ejecucion_fisica(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_ejecucion_fisica(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var tituloM,maestro,txt_sw_valida;
	var dialog;
	var tipoDeCambio;
	var importe_concepto;
	var importe_final;
	var sw_filtro;
	
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/ejecucion_fisica/ActionListarEjecucionFisica.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_ejecucion_fisica',
			totalRecords:'TotalCount'
		},[
		'id_ejecucion_fisica',
		'id_parametro',
		'desc_parametro',
		'id_proyecto',
		'periodo_pres',		
		'porcentaje_ejecucion',
		'estado',
		'id_usr_reg',
		'desc_usr_reg',
		'fecha_reg',
		'id_usr_mod',
		'desc_usr_mod',
		'fecha_mod',
		'justificacion_fisica',
		'justificacion_financiera',
		'acciones_fisica',
		'acciones_financiera',
		'problemas_fisica',
		'tiempo_solucion',
		
		'presupuesto_aprobado',
		'presupuesto_vigente',
		'ejecucion_financiera',
		'porcentaje_financiera'		
		
		]),remoteSort:true});
		
	// Definición de datos //
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});
	
	var ds_usuario_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional'])
			
	});
		
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5000">{gestion_pres}</FONT>','</div>');
	
	function render_id_usuario_reg(value, p, record){return String.format('{0}', record.data['desc_usr_reg']);}
	var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b></FONT>','</div>');

	function render_estado(value,p,record)
	{
		//value=='alta'
		if(value=='Cerrado')
		{
			return String.format('{0}',"<div style='text-align:center'><img src='"+direccion+"../../../../lib/imagenes/lock.png' align='center' /></div>")
		}
		else
		{
			if(value=='Abierto')
			return String.format('{0}',"<div style='text-align:center'><img src='"+direccion+"../../../../lib/imagenes/pencil.png' align='center' /></div>");
		}	
	}	
	
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	
		
	
	
	//Sirve para mostrar los datos en el grid	
	function renderPeriodo(value, p, record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}
		else
		{return "T O T A L :"}
	}
	
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_ejecucion_fisica',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_ejecucion_fisica'
	};	
	
	// txt id_parametro
	Atributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
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
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo:'ComboBox',
		//form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	Atributos[2]={
		validacion:{
			labelSeparator:'',
			name: 'id_proyecto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proyecto'
	};	
		
	// txt estado_gral
	Atributos[3]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:true,
			//emptyText:'Periodo...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			disable:false
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'MEMSER.periodo_pres',
		//defecto:1,
		id_grupo:0,
		save_as:'periodo_pres'
	};	
	
	Atributos[4]={
		validacion:{
			name:'presupuesto_aprobado',
			fieldLabel:'Presupuesto Aprobado (Bs)',
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
			grid_editable:false,
			width_grid:170,
			width:'50%',
			disabled:true	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,		
		id_grupo:0
	};	
	
	Atributos[5]={
		validacion:{
			name:'presupuesto_vigente',
			fieldLabel:'Presupuesto Vigente (Bs)',
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
			grid_editable:false,
			width_grid:170,
			width:'50%',
			disabled:true	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,		
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
			name:'ejecucion_financiera',
			fieldLabel:'Ejecución Financiera (Bs)',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:170,
			width:'50%',
			disabled:true	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,		
		id_grupo:0
	};
	
	Atributos[7]={
		validacion:{
			name:'porcentaje_financiera',
			fieldLabel:'Porcentaje de Ejecución Financiera (%)',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			grid_visible:true,
			grid_editable:true,
			width_grid:170,
			width:'50%',
			disabled:true	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,		
		id_grupo:3		
	};	
	
	Atributos[8]={
				validacion:{
					name:'justificacion_financiera',
					fieldLabel:'Justificación Ejecución Financiera',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:3,
				filtro_0:true,
				filterColValue:'EJEFIS.justificacion_financiera',
				save_as:'justificacion_financiera'
	};
	
	Atributos[9]={
				validacion:{
					name:'acciones_financiera',
					fieldLabel:'Acciones Ejecución Financiera',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:3,
				filtro_0:true,
				filterColValue:'EJEFIS.justificaciones_financiera',
				save_as:'acciones_financiera'
	};
	
	
	// txt total_general
	Atributos[10]={
		validacion:{
			name:'porcentaje_ejecucion',
			fieldLabel:'Porcentaje de Ejecución Física (%)',
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
			width_grid:170,
			width:'50%',
			disabled:false	
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'EJEFIS.porcentaje_ejecucion',
		id_grupo:2,
		save_as:'porcentaje_ejecucion'
	};	

	
	Atributos[11]={
				validacion:{
					name:'justificacion_fisica',
					fieldLabel:'Descripción Ejecución Física',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:2,
				filtro_0:true,
				filterColValue:'EJEFIS.justificacion_fisica',
				save_as:'justificacion_fisica'
			};	
			
	Atributos[12]={
				validacion:{
					name:'problemas_fisica',
					fieldLabel:'Problemas Ejecución Física',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:2,
				filtro_0:true,
				filterColValue:'EJEFIS.justificacion_fisica',
				save_as:'problemas_fisica'
			};	
			
	Atributos[13]={
				validacion:{
					name:'acciones_fisica',
					fieldLabel:'Soluciones Ejecución Física',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:2,
				filtro_0:true,
				filterColValue:'EJEFIS.acciones_fisica',
				save_as:'acciones_fisica'
	};
	
	Atributos[14]={
				validacion:{
					name:'tiempo_solucion',
					fieldLabel:'Tiempo Solución',
					allowBlank:false,
					maxLength:400,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:true,
					width_grid:250,
					width:'100%',
					disabled:false
				},
				tipo:'TextArea',
				id_grupo:2,
				filtro_0:true,
				filterColValue:'EJEFIS.tiempo_solucion',
				save_as:'tiempo_solucion'
			};	
			
	// txt estado
	Atributos[15] 	= {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			desc: 'estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			align: 'center',
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Abierto','Abierto'],['Cerrado','Cerrado']]}),			
			valueField:'ID',
			displayField:'valor',
			renderer: render_estado,
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:100, 
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,	
		defecto:'Abierto',
		filterColValue:'USUAUT.estado',	
		id_grupo:1,
		save_as:'estado'
	};
	
	Atributos[16]={
		validacion:{			
			name:'desc_usr_reg',
			fieldLabel:'Usuario Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,		
		form:false,		
		filterColValue:'USUARI1.login'
	};
	
// txt fecha_reg
	Atributos[17]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:120		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'EJEFIS.fecha_reg',
	};
	
	Atributos[18]={
		validacion:{			
			name:'desc_usr_mod',
			fieldLabel:'Usuario Modificación',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,		
		form:false,		
		filterColValue:'USUARI2.login'
	};
	
// txt fecha_reg
	Atributos[19]={
		validacion:{
			name:'fecha_mod',
			fieldLabel:'Fecha Modificación',
			grid_visible:true,
			grid_editable:false,
			width_grid:120		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'EJEFIS.fecha_mod',
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	tituloM='Ejecución Física';
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Proyecto (Maestro)',titulo_detalle:'Ejecución Física',grid_maestro:'grid-'+idContenedor};
	var layout_ejecucion_fisica= new DocsLayoutMaestro(idContenedor);
	layout_ejecucion_fisica.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_ejecucion_fisica,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	
	var CM_btnSave=this.Save;
	var CM_getDialog=this.getDialog; 
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var getFormulario=this.getFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	var ClaseMadre_getComponente=this.getComponente; 
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var cm_EnableSelect=this.EnableSelect;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
		
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ejecucion_fisica/ActionEliminarEjecucionFisica.php'},
		Save:{url:direccion+'../../../control/ejecucion_fisica/ActionGuardarEjecucionFisica.php'},
		ConfirmSave:{url:direccion+'../../../control/ejecucion_fisica/ActionGuardarEjecucionFisica.php'},
		Formulario:{titulo:'Ejecucion Fisica',html_apply:'dlgInfo-'+idContenedor,height:700,width:500,minWidth:150,minHeight:200,closable:true,guardar:filtro,
		grupos:[{
			tituloGrupo:'Datos',
			columna:0,
			id_grupo:0
		},
		{
			tituloGrupo:'Filtrar',
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Física',
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Financiera',
			columna:0,
			id_grupo:3
		}
		]
		}};
		
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m)
	{
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proyecto:maestro.id_proyecto				
			}
		};
		
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};		
		//prueba.setValue(maestro.id_moneda);
		this.btnActualizar();
		Atributos[2].defecto=maestro.id_proyecto;
		
		//CM_mostrarComponente(h_periodo_pres);
		paramFunciones.btnEliminar.parametros='&m_id_ejecucion_fisica='+maestro.id_ejecucion_fisica;
		paramFunciones.Save.parametros='&m_id_ejecucion_fisica='+maestro.id_ejecucion_fisica;
		paramFunciones.ConfirmSave.parametros='&m_id_ejecucion_fisica='+maestro.id_ejecucion_fisica;
		this.InitFunciones(paramFunciones);
		var CM_getBoton=this.getBoton;
		
		CM_getBoton('guardar-'+idContenedor).enable();
		CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();	
		CM_getBoton('cerrar-'+idContenedor).enable();
	};
	
	function btn_cerrar()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			if(componentes[5].getValue()=='Abierto' )	//estado ejecucion fisica
			{
				var sw=false;
				if(confirm('Esta seguro de bloquear la edición del porcentaje de ejcución física del periodo?'))
						{sw=true}
				if(sw)
				{
					var SelectionsRecord=sm.getSelections(); 			
		 			var arr_id_ejecucion_fisica = new Array;
		 			for(var i=0 ; i<NumSelect ; i++)
		 			{
					    arr_id_ejecucion_fisica[i]=SelectionsRecord[i].data.id_ejecucion_fisica;
					    	
						Ext.Ajax.request({
						//url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
						url:direccion+"../../../control/ejecucion_fisica/ActionEstadoEjecucionFisica.php",
						method:'POST',
						params:{cantidad_ids:NumSelect,id_ejecucion_fisica:arr_id_ejecucion_fisica[i],accion:'Cerrado'},
						success:ejecucion_fisica_Success,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
						});	
		 			}			
				}				
			}
			else
			{
				Ext.MessageBox.alert('Atención', 'Solo periodos en estado Abierto pueden ser cerrados.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un periodo.');
		}
	}	
	
	function ejecucion_fisica_Success(resp)
	{
		Ext.MessageBox.hide();
		
		if(resp.responseXML&&resp.responseXML.documentElement)
		{	
			//Ext.MessageBox.alert('Exito', 'Finalización exitosa, ahora puede imprimir la rendición.')	
			//btn_reporte_modificacion();							
			ClaseMadre_btnActualizar();
		}
		else
		{			
			ClaseMadre_conexionFailure();
		}
	}
	
	function btn_reporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_ejecucion_fisica='+SelectionsRecord.data.id_ejecucion_fisica;				
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/ejecucion_fisica/ActionPDFEjecucionFisica.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.btnNew=function()
	{
		sw_filtro="false";		
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		CM_mostrarGrupo('Financiera');
		CM_mostrarGrupo('Física');
		CM_btnNew();		
	};
		
	this.Save=function(){	    	
		CM_btnSave()			
	};
	
		
	function filtro()
	{
		if (sw_filtro=="true")
		{	
			ds.baseParams={valor_filtro:parseFloat(h_id_parametro.getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_proyecto:maestro.id_proyecto}});
			dialog.hide()
		}
		else
		{
			CM_btnSave();
		}
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		CM_mostrarGrupo('Financiera');
		CM_mostrarGrupo('Física');
		dialog=CM_getDialog(); 
		
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}
	
   var prueba=new Ext.form.ComboBox({
			store:ds_parametro,
			//displayField:'Gestión',
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			typeAhead:true,
			mode:'local',
			triggerAction:'all',
			emptyText:'Seleccionar Gestión...',
			selectOnFocus:true,
			width:135,
			valueField:'id_parametro',
			editable:false,			
			renderer:render_id_parametro,
			tpl:tpl_id_parametro			
	});
	
	ds_parametro.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	
	prueba.on('select',	function()
	{				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_proyecto:maestro.id_proyecto}});			
	});
		
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_ejecucion_fisica.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBotonCombo(prueba,'prueba');
	this.AdicionarBoton('../../../lib/imagenes/lock.png','Cierra el periodo para no permitir modificaciones',btn_cerrar,true,'cerrar','Cerrar Periodo');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Ejecucion Física y Financiera del periodo seleccionado',btn_reporte,true,'imp_ejecucion','Reporte');
	
	//para agregar botones	
	CM_getBoton('guardar-'+idContenedor).disable();
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('cerrar-'+idContenedor).disable();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data['estado']=='Abierto')//Abierto
		{
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('cerrar-'+idContenedor).enable();								
		}
		
		if(rec.data['estado']=='Cerrado')//Cerrado
		{
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('cerrar-'+idContenedor).disable();	
							
		}
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_ejecucion_fisica.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}