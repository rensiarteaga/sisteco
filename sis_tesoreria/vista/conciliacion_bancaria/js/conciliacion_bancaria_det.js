/**
* Nombre:		  	    pagina_conciliacion_bancaria_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function ConciliacionBancariaDet(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var filtro;
	var txt_nro_cheque,txt_nro_deposito;
	var	txt_fecha_cheque,txt_nombre_cheque;
	var	txt_estado_cheque,txt_fecha_cobro;
	var	txt_importe_cheque,txt_vista_cheque;
	var estado_grid;
	var g_vista_cheque = maestro.vista_cheque;
	
	var monedas_for=new Ext.form.MonedaField(
		{
		name:'mes_01',
		fieldLabel:'Enero',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000}	
	);
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cheque/ActionListarCheque.php?sw_conci_banc=1'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},[
		'id_cheque',
		'id_transaccion',
		'desc_comprobante',
		'desc_transaccion',
		'nro_cheque',
		'nro_deposito',
		{name:'fecha_cheque',type:'date',dateFormat:'Y-m-d'},
		'nombre_cheque',
		'estado_cheque',
		'id_cuenta_bancaria',
		{name:'fecha_cobro',type:'date',dateFormat:'Y-m-d'},
		'id_cheque_valor',
		'id_moneda',
		'nombre_moneda',
		'importe_cheque'
		]),remoteSort:true});
		
	//carga datos XML
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
		m_fecha_inicio:maestro.fecha_inicio,
		m_fecha_fin:maestro.fecha_fin,
		m_id_moneda:maestro.id_moneda,
		m_desc_institucion:maestro.desc_institucion,
		m_nro_cuenta_banco:maestro.nro_cuenta_banco,
		m_vista_cheque:maestro.vista_cheque}});
		
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
    Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
    var data_maestro=[['Institucion ',maestro.desc_institucion+tabular(70-maestro.desc_institucion.length)],['No Cuenta Banco ',maestro.nro_cuenta_banco+tabular(70-maestro.nro_cuenta_banco.length)]];
	
    //DATA STORE COMBOS
    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
	baseParams:{estado:'activo'}
	});
	/////***** ***///
	function tabular(n){
		if (n>=0)	{return "  "+tabular(n-1)}
	        else return "  "
     }
	padre=this;
	//FUNCIONES RENDER
	function render_id_moneda_reg(value, p, record){return String.format('{0}', record.data['nombre_moneda']);}
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	// hidden id_cheque
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cheque',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};
	//desc_comprobante
	Atributos[1]={
		validacion:{
			name:'desc_comprobante',
			fieldLabel:'N° Cbte.',
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CBTE.nro_cbte'
	};
	// desc_transaccion
	Atributos[2]={
		validacion:{
			name:'desc_transaccion',
			fieldLabel:'Concepto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TRANSC.concepto_tran'
	};
	// txt nro_cheque
	Atributos[3]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'N° Cheque',
			allowBlank:false,
			allowDecimals:false,
		    allowNegative:false,
			align:'left',
			grid_visible:true,
			grid_editable:false,
			width_grid:90
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CHEQUE.nro_cheque'
	};
	// nro_deposito
	Atributos[4]={
		validacion:{
			name:'nro_deposito',
			fieldLabel:'N° Depósito',
			allowBlank:false,
			align:'left',
			grid_visible:true,
			grid_editable:false,
			width_grid:90
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CHEQUE.nro_deposito'
	};
	// fecha_cheque
	Atributos[5]={
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'Fecha Cheque',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:90
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CHEQUE.fecha_cheque',
		dateFormat:'m-d-Y'
	};
	// 
	Atributos[6]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Beneficiario',
			allowBlank:true,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CHEQUE.nombre_cheque'
	};
	//estado_cheque
	Atributos[7]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Cobrado',
			checked:false,
		    renderer:formatBoolean,
		    selectOnFocus:true,
		    grid_visible:true,
		    grid_editable:true,
			width_grid:100
		},
		tipo:'Checkbox',
		form:false
	};
// fecha_cobro
	Atributos[8]={
		validacion:{
			name:'fecha_cobro',
			fieldLabel:'Fecha de Cobro',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:true,
			renderer:formatDate,
			width_grid:110
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CHEQUE.fecha_cobro',
		dateFormat:'m-d-Y'
	};
	// txt conformidad
	Atributos[9]={
		validacion:{
			name:'nombre_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:120
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MONEDA.nombre'
	};
	// txt pedido
	Atributos[10]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe Cobrado',
			allowBlank:true,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:115
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CHEVAL.importe_cheque'
	};

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	function formatBoolean(value){
		if(value==1) return 'Si' 
		else 
		{if(value==2) return 'Si'
		 else return 'No'
		}
     }
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Conciliación Bancaria',grid_maestro:'grid-'+idContenedor};
	var layout_conciliacion_det=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_conciliacion_det.init(config);
	
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_conciliacion_det,idContenedor);
	var getComponente=this.getComponente;
	var getComponenteGrid=this.getComponenteGrid;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_saveSuccess=this.saveSuccess;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var cm_EnableSelect=this.EnableSelect;
	var getColumnNum=this.getColumnNum;
	var InitFunciones=this.InitFunciones;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
			guardar:{crear:true,separador:false},
		//	nuevo:{crear:true,separador:true},
		//	editar:{crear:true,separador:false},
		//	eliminar:{crear:true,separador:false},
		//	actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//datos necesarios para el filtro
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		ConfirmSave:{url:direccion+'../../../../sis_contabilidad/control/cheque/ActionModificarCheque.php',parametros:'&vista_cheque='+g_vista_cheque+'&m_id_cuenta_bancaria='+maestro.id_cuenta_bancaria+'&m_fecha_inicio='+maestro.fecha_inicio+'&m_fecha_fin='+maestro.fecha_fin+'&m_id_moneda='+maestro.id_moneda}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	   	maestro.id_cuenta_bancaria=datos.m_id_cuenta_bancaria;
       	maestro.fecha_inicio=datos.m_fecha_inicio;
       	maestro.fecha_fin=datos.m_fecha_fin;
       	maestro.id_moneda=datos.m_id_moneda;
       	maestro.desc_institucion=datos.m_desc_institucion;
       	maestro.nro_cuenta_banco=datos.m_nro_cuenta_banco;
       	maestro.vista_cheque=datos.m_vista_cheque; 
       	       	     	
		data_maestro=[['Institucion ',maestro.desc_institucion+tabular(51-maestro.desc_institucion.length)],['No Cuenta Banco ',maestro.nro_cuenta_banco+tabular(51-maestro.nro_cuenta_banco.length)]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		//vectorAtributos[2].defecto=maestro.id_partida;
	   	
		paramFunciones.ConfirmSave.parametros='&vista_cheque='+maestro.vista_cheque;
		InitFunciones(paramFunciones)
	   	ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
		        m_fecha_inicio:maestro.fecha_inicio,
		        m_fecha_fin:maestro.fecha_fin,
		        m_id_moneda:maestro.id_moneda,
		        m_desc_institucion:maestro.desc_institucion,
		        m_nro_cuenta_banco:maestro.nro_cuenta_banco,
		        m_vista_cheque:maestro.vista_cheque
			}
		};
		Cm_btnActualizar()
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		txt_nro_cheque=getComponente('nro_cheque');
		txt_nro_deposito=getComponente('nro_deposito');
		txt_fecha_cheque=getComponente('fecha_cheque');
		txt_nombre_cheque=getComponente('nombre_cheque');
		txt_estado_cheque=getComponente('estado_cheque');
		txt_fecha_cobro=getComponente('fecha_cobro');
		txt_importe_cheque=getComponente('importe_cheque');
		estado_grid=getComponenteGrid('estado_cheque');
		getGrid().colModel.setHidden(getColumnNum('nro_deposito'),true);
		estado_grid.on('check',onCheck)
	}
	
	function onCheck(x,check){
			var record=getSelectionModel().getSelected();
			value_check=record.data.estado_cheque;
			if(value_check!=check){
				record.commit();
				if(check){
				  record.set('fecha_cobro',record.data.fecha_cheque)	
				}
				else{
					record.set('fecha_cobro','')	
				}
			}		
		}
		
	function btn_cheque(){
	     g_vista_cheque=1;
	     paramFunciones.ConfirmSave.parametros='&vista_cheque='+g_vista_cheque;
	    InitFunciones(paramFunciones)
		getGrid().colModel.setHidden(getColumnNum('nro_deposito'),true);
		getGrid().colModel.setHidden(getColumnNum('nro_cheque'),false);
    	getGrid().colModel.setHidden(getColumnNum('nombre_cheque'),false);
    	getGrid().colModel.setColumnHeader(getColumnNum('fecha_cheque'),'Fecha del Cheque');
    	getGrid().colModel.setColumnHeader(getColumnNum('fecha_cobro'),'Fecha de Cobro');
    	getGrid().colModel.setColumnHeader(getColumnNum('estado_cheque'),'Cobrado');
    	getGrid().colModel.setColumnHeader(getColumnNum('importe_cheque'),'Importe Cobrado');
    	if (prueba.getValue()==''){				   
			   ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	                     m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	                     m_fecha_inicio:maestro.fecha_inicio,
	                     m_fecha_fin:maestro.fecha_fin,
	                     m_id_moneda:maestro.id_moneda,
			             m_vista_cheque:g_vista_cheque}});
			    Cm_btnActualizar()         
		}
		else{
			  ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	                     m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	                     m_fecha_inicio:maestro.fecha_inicio,
	                     m_fecha_fin:maestro.fecha_fin,
	                     m_id_moneda:prueba.getValue(),
			             m_vista_cheque:g_vista_cheque}});
			     Cm_btnActualizar()        
		}
	}
	
    function btn_deposito(){
    	 g_vista_cheque=2;
	     paramFunciones.ConfirmSave.parametros='&vista_cheque='+g_vista_cheque;
	     InitFunciones(paramFunciones)
    	getGrid().colModel.setColumnHeader(getColumnNum('fecha_cheque'),'Fecha de Emisión');
    	getGrid().colModel.setColumnHeader(getColumnNum('fecha_cobro'),'Fecha de Depósito');
    	getGrid().colModel.setColumnHeader(getColumnNum('estado_cheque'),'Depositado');
    	getGrid().colModel.setColumnHeader(getColumnNum('importe_cheque'),'Importe Depositado');
    	getGrid().colModel.setHidden(getColumnNum('nro_deposito'),false);
    	getGrid().colModel.setHidden(getColumnNum('nro_cheque'),true);
    	getGrid().colModel.setHidden(getColumnNum('nombre_cheque'),true);
    	if (prueba.getValue()==''){            	
			   ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	                     m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	                     m_fecha_inicio:maestro.fecha_inicio,
	                     m_fecha_fin:maestro.fecha_fin,
	                     m_id_moneda:maestro.id_moneda,
			             m_vista_cheque:g_vista_cheque}});
			   Cm_btnActualizar()          
		}
		else{
			 ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	                     m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	                     m_fecha_inicio:maestro.fecha_inicio,
	                     m_fecha_fin:maestro.fecha_fin,
	                     m_id_moneda:prueba.getValue(),
			             m_vista_cheque:g_vista_cheque}});
			 Cm_btnActualizar()
		}			
	}
	
	function btn_imprimir_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		if(NumSelect!=0){	
			if(SelectionsRecord.data.nro_cheque!=''){
				var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
			    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
			}
			else{	 				
			    Ext.MessageBox.alert('...','La solicitud seleccionada no es cheque.')
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado','Debe seleccionar una solicitud.')
	    }
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_conciliacion_det.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	var prueba=new Ext.form.ComboBox({
		store: ds_moneda,
		displayField:'nombre',
		typeAhead:true,
		mode:'local',
		triggerAction:'all',
		emptyText:'Seleccionar moneda...',
		selectOnFocus:true,
		width:135,
		valueField:'id_moneda',
		tpl:tpl_id_moneda_reg
		
	});
	ds_moneda.load({
		params:{
			start:0,
			limit:1000000
		}
	}
	);
	//esto es para el combo y mandarle datos al hijo
	prueba.on('select',
	function(){
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	             m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	             m_fecha_inicio:maestro.fecha_inicio,
	             m_fecha_fin:maestro.fecha_fin,
	             m_id_moneda:prueba.getValue(),
		         m_vista_cheque:g_vista_cheque}});
	});
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBotonCombo(prueba,'prueba');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cheques',btn_cheque,true,'cheques','Cheques');
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Depósitos',btn_deposito,true,'depositos','Depósitos');
    this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Cheque',btn_imprimir_cheque,true,'imprimir_cheque','Cheque');

	layout_conciliacion_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}