<?php 
/**
 * Nombre:		  	    descargo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 10:39:24
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

var maestro={
		id_avance:<?php echo utf8_decode($m_id_avance);?>,	
		id_empleado:'<?php echo utf8_decode($m_id_empleado);?>',
		desc_empleado:'<?php echo utf8_decode($m_desc_empleado);?>',
		id_depto:'<?php echo utf8_decode($m_id_depto);?>',
		desc_depto:'<?php echo utf8_decode($m_desc_depto);?>',
		id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
		nombre_moneda:'<?php echo utf8_decode($m_nombre_moneda);?>'
	};
	
	idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';

//var elemento={pagina:new pagina_agrupador_rendicion_viaticos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
var elemento={pagina:new pagina_descargo_cheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
//var elemento={idContenedor:idContenedor,pagina:new pagina_agrupador_rendicion_viaticos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
* Nombre:		  	    pagina_solicitud_compra_personal_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-09 09:11:12
*/
//modificar  el onSelect de solicitante para que cuando elija id_tipo_categoria filtre despues los RPAs en base a la categoria que eligió y seguir modificando en la BD para que guarde!!
function pagina_descargo_cheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var data_ep;
	var txt_emp=0;
	var g_sw_contabilizar;
	var cmp_empleado,cmp_ep,cmp_estado_avance;
	var cmp_moneda,cmp_cheque,cmp_importe_avance;
	var data='';
//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance/ActionListarDescargo.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_avance',totalRecords:'TotalCount'
		},[		
		'id_avance',
		'id_empleado',		
		'desc_empleado',
		'tipo_avance',
		{name:'fecha_avance',type:'date',dateFormat:'Y-m-d'},		
		'importe_avance',
		'estado_avance',
		'id_moneda',
		'nombre_moneda',
		'id_cheque',
		'nro_cheque',
		'id_documento',
		'nro_documento',
		'id_comprobante',
		'nro_comprobante',
		'fk_avance',
		'sw_contabilizar',
		'nro_avance',
		{name:'fecha_ini_rendicion',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin_rendicion',type:'date',dateFormat:'Y-m-d'},
		'id_plan_pago',
		'id_depto_contabilidad',
		'nombre_depto',
		'id_usr_reg',
		'id_depto'
		]),remoteSort:true});
			//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_avance:maestro.id_avance
		}
	});
		//DATA STORE COMBOS
       var ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
    var ds_cheque=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cheque/ActionListarCheque.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cheque',totalRecords:'TotalCount'},['id_cheque','id_transaccion','nro_cheque','nro_deposito','fecha_cheque','nombre_cheque','estado_cheque','id_cuenta_bancaria'])
	});
 	//FUNCIONES RENDER
		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{desc_persona}</I></B></FONT><br>','<FONT COLOR="#B5A642">Email:{email1}</FONT>','</div>');
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{nombre}</I></B></FONT><br>','<FONT COLOR="#B5A642">Simbolo:{simbolo}</FONT>','</div>');
		function render_id_cheque(value, p, record){return String.format('{0}', record.data['nro_cheque']);}
		var tpl_id_cheque=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{nro_cheque}</I></B></FONT><br>','</div>');
	function renderEstado(value, p, record){
		if(value == 1)
		{return "Pendiente"}
		if(value == 2)
		{return "Descargo"}
		if(value == 3)
		{return "Cerrado"}
		if(value == 4)
		{return "Cheque Emitido"}
		if(value == 5)
		{return "Solicitud Contabilizada"}
		if(value == 6)
		{return "Solicitud Validada"}
		if(value == 7)
		{return "Descargo Contabilizado"}
		if(value == 8)
		{return "Descargo Validado"}
		return 'Otro';
	}	
	// Definición de datos //
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_avance',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false		
	};
// txt id_empleado
	Atributos[1]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			grid_indice:1		
		},
		tipo:'TextField',
		filtro_0:true,
		defecto:maestro.id_empleado,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre'
	};
	// txt tipo_avance
	Atributos[2]={
		validacion:{
			name:'nro_avance',
			fieldLabel:'Nro Avance',
			allowBlank:true,
			align:'left', 
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1		
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'AVANCE.nro_avance',
		save_as:'nro_avance'
	};
	// txt fecha_avance
	Atributos[3]= {
		validacion:{
			name:'fecha_ini_rendicion',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:3		
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AVANCE.fecha_ini_rendicion',
		dateFormat:'m-d-Y'
	};
	// txt fecha_avance
	Atributos[4]= {
		validacion:{
			name:'fecha_fin_rendicion',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:3		
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AVANCE.fecha_fin_rendicion',
		dateFormat:'m-d-Y'
	};	
// txt tipo_avance
	Atributos[5]={
		validacion:{
			name:'tipo_avance',
			fieldLabel:'Tipo Avance',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false		
		},
		tipo:'NumberField',
		form:false,
		filtro_0:false
	};
// txt fecha_avance
	Atributos[6]= {
		validacion:{
			name:'fecha_avance',
			fieldLabel:'Fecha Descargo',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:3		
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AVANCE.fecha_avance',
		dateFormat:'m-d-Y'
	};
// txt estado_avance
	Atributos[7]={
		validacion:{
			name:'estado_avance',
			fieldLabel:'Estado Descargo',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Pendiente'],['2','Descargo'],['3','Cerrado'],['4','Cheque Emitido'],['5','Solicitud Contabilizada'],['6','Solicitud Validada'],['7','Descargo Contabilizado'],['8','Comprometido']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'AVANCE.estado_avance',
		defecto:1
	};
	
// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			grid_indice:4		
		},
		tipo:'TextField',
		filtro_0:true,
		defecto:maestro.id_moneda,
		filterColValue:'MONEDA.nombre'
	};
	
	// txt importe_avance
	Atributos[9]={
		validacion:{
			name:'importe_avance',
			fieldLabel:'Importe Avance',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:5		
		},
		tipo:'NumberField',
		filtro_0:true,
		defecto:0,
		filterColValue:'AVANCE.importe_avance'
	};
// txt id_cheque
	Atributos[10]={
			validacion:{
			name:'id_cheque',
			fieldLabel:'Número de Cheque',
			allowBlank:true,
			align:'right',			
			enderer:render_id_cheque,
			grid_visible:false,
			grid_editable:false,
			width_grid:115,
			grid_indice:6		
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.nro_cheque'
	};
// txt id_documento
	Atributos[11]={
			validacion:{
			name:'id_documento',
			fieldLabel:'Documento',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:false,
		save_as:'id_documento'
	};
// txt id_comprobante
	Atributos[12]={
			validacion:{
			name:'id_comprobante',
			fieldLabel:'Comprobante',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:false,
		save_as:'id_comprobante'
	};
// txt fk_avance
	Atributos[13]={
			validacion:{
			labelSeparator:'',
			name:'fk_avance',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		defecto:maestro.id_avance,
		filtro_0:false
	};
	Atributos[14]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'',
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
			width:150,
			disabled:false		
		},
		tipo:'NumberField',
		form:false,
		save_as:'sw_contabilizar'
	};
	// txt id_depto
	Atributos[15]={
			validacion:{
			labelSeparator:'',
			name:'id_depto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		defecto:maestro.id_depto,
		filtro_0:false
	};
	Atributos[16]={
			validacion:{
			labelSeparator:'',
			name:'id_plan_pago',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
		// ----------            FUNCIONES RENDER    ---------------//
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/descargo_detalle/descargo_detalle.php'};
		var layout_descargo_cheque=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_descargo_cheque.init(config);
		
		// INICIAMOS HERENCIA //
		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_descargo_cheque,idContenedor);
		
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_getComponente=this.getComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;		
		
		var ClaseMadre_save=this.Save;
		var ClaseMadre_getComponente=this.getComponente;
		
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/descargo/ActionEliminarDescargo.php'},
			Save:{url:direccion+'../../../control/descargo/ActionGuardarDescargo.php'},
			ConfirmSave:{url:direccion+'../../../control/descargo/ActionGuardarDescargo.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,columnas:[400],
			grupos:[{tituloGrupo:'Fecha Descargo',columna:0,id_grupo:0}],
			width:450,minWidth:350,minHeight:200,closable:true,titulo:'Descargos'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		this.reload=function(params){		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_avance=datos.m_id_avance;
		maestro.id_empleado=datos.m_id_empleado;		
		maestro.desc_empleado=datos.m_desc_empleado;
		maestro.id_depto=datos.m_id_depto;
		maestro.desc_depto=datos.m_desc_depto;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.nombre_moneda=datos.m_nombre_moneda;		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_avance:maestro.id_avance
			}
		};		
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_empleado;
		Atributos[8].defecto=maestro.id_moneda;
		Atributos[13].defecto=maestro.id_avance;
		Atributos[15].defecto=maestro.id_depto;
		paramFunciones.btnEliminar.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.Save.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.ConfirmSave.parametros='&m_id_avance='+maestro.id_avance;
		this.InitFunciones(paramFunciones)
	};
		function InitPaginaDescargo()
	    {						
			for(var i=0; i<Atributos.length; i++)
			{
				componentes[i]=CM_getComponente(Atributos[i].validacion.name)
			}				
		}
				
		//Para manejo de eventos
		function iniciarEventosFormularios(){					
		   
		   cmp_empleado=CM_getComponente('id_empleado');
		   cmp_estado_avance=CM_getComponente('estado_avance');
		   cmp_moneda=CM_getComponente('id_moneda');
		   cmp_cheque=CM_getComponente('id_cheque');
		   cmp_importe_avance=CM_getComponente('importe_avance');
		   cmp_fecha_avance=CM_getComponente('fecha_avance');
		   	//evento de deselecion de una linea de grid
			getSelectionModel().on('rowdeselect',function(){
				if(_CP.getPagina(layout_descargo_cheque.getIdContentHijo()).pagina.limpiarStore()){
					_CP.getPagina(layout_descargo_cheque.getIdContentHijo()).pagina.bloquearMenu()
				}
			})
		}	
		
		function btn_reporte_rendicion(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();		
			
			if(NumSelect!=0)
			{		
			    var data='&id_avance='+SelectionsRecord.data.id_avance;	
			    data=data+'&tipo_vista=avance';	   	   			   	   
			    window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)				
			}
			else
			{
				Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.')
			} 
		}										
		function btnContabilizar(){		
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();			
			if(NumSelect!=0){				
				if(SelectionsRecord.data.estado_avance==2){
					if(SelectionsRecord.data.id_comprobante!=''){		
						Ext.MessageBox.alert('Estado','El fondo en avance seleccionado ya esta contabilizado.')			
					}
					else{	
						var sw=false;
						if(confirm('Esta seguro de contabilizar los descargos del fondo en avance?')){					
							var data='id_avance='+SelectionsRecord.data.id_avance;
			    				data=data+'&id_moneda='+SelectionsRecord.data.id_moneda;
			    				Ext.Ajax.request({url:direccion+"../../../control/avance/ActionComproContaDescargo.php",
			    								  params:data,
			    								  success:comprometido_contabilizado,
			    								  method:'POST',
			    								  failure:Cm_conexionFailure,
			    								  timeout:100000});
			  			        Cm_btnActualizar()
						}	
					}
				}	
				else{
					Ext.MessageBox.alert('Estado','Solo fondos en avance en estado Descargo')
				}
			}
			else{
				Ext.MessageBox.alert('Estado','Antes debe seleccionar un fondo en avance')
		    }	
		}
	function btn_anular(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='cantidad_ids=1&hidden_id_descargo_0='+SelectionsRecord.data.id_avance;
			data=data+'&hidden_id_plan_pago_0='+SelectionsRecord.data.id_plan_pago;
			Ext.Ajax.request({
			url:direccion+"../../../control/descargo/ActionAnularDescargo.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:Cm_conexionFailure,
			timeout:100000000
		});
					
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			Ext.MessageBox.alert('Estado','Descargo anulado exitosamente');
			Cm_btnActualizar();
		}
		else{
			Cm_conexionFailure();
		}
	}
		function comprometido_contabilizado(resp){
		Ext.MessageBox.alert('Estado','Descargo comprometido y contabilizado exitosamente');
	     }
		this.btnNew=function(){
          CM_ocultarComponente(cmp_empleado);
          CM_ocultarComponente(cmp_estado_avance);
          CM_ocultarComponente(cmp_fecha_avance);
          CM_ocultarComponente(cmp_moneda);
          CM_ocultarComponente(cmp_cheque);
          CM_ocultarComponente(cmp_importe_avance);
          CM_btnNew()			 
	 };	
	 this.btnEdit=function(){
          CM_ocultarComponente(cmp_empleado);
          CM_ocultarComponente(cmp_estado_avance);
          CM_ocultarComponente(cmp_moneda);
          CM_ocultarComponente(cmp_fecha_avance);
          CM_ocultarComponente(cmp_cheque);
          CM_ocultarComponente(cmp_importe_avance);
          CM_btnEdit()			 
	 };			
		this.EnableSelect=function(sm,row,rec){
				enable(sm,row,rec);
				_CP.getPagina(layout_descargo_cheque.getIdContentHijo()).pagina.reload(rec.data);			
				if(rec.data.estado_avance==8 || rec.data.estado_avance==7){
					_CP.getPagina(layout_descargo_cheque.getIdContentHijo()).pagina.bloquearMenu()	
				}
				else{
				  _CP.getPagina(layout_descargo_cheque.getIdContentHijo()).pagina.desbloquearMenu()	
				}
				
		};
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_descargo_cheque.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		this.iniciaFormulario();
		//carga datos XML
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Descargo',btn_reporte_rendicion,true,'imp_ejecucion','Rendición');
		this.AdicionarBoton('../../../lib/imagenes/det.ico','Comprometer/Contabilizar Descargo',btnContabilizar,true,'contabilizar','Comprometer/Contabilizar Descargo');		
		this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Descargo',btn_anular,true,'anular_descargo','');
		var CM_getBoton=this.getBoton;
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('contabilizar-'+idContenedor).disable();
			CM_getBoton('anular_descargo-'+idContenedor).disable();
			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
			           	  
			           	  if(record.estado_avance==2 && record.importe_avance > 0){
			               	CM_getBoton('contabilizar-'+idContenedor).enable();
			               	CM_getBoton('imp_ejecucion-'+idContenedor).enable();
			               }
			               else{
			               	CM_getBoton('contabilizar-'+idContenedor).disable();
			               	CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			               }
			               if(record.id_plan_pago > 0 && record.estado_avance==2){
			               		CM_getBoton('anular_descargo-'+idContenedor).enable();
			               	}
			               	else{
			               		CM_getBoton('anular_descargo-'+idContenedor).disable();
			               	}
				}
				cm_EnableSelect(sel,row,selected);				
			}
		InitPaginaDescargo();
		iniciarEventosFormularios();				
		layout_descargo_cheque.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}