/**
 * Nombre:		  	    pagina_orden_trabajo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-27 09:14:44
 */
function pagina_cheque_cbte(idContenedor,direccion,usuario,paramConfig){
	var Atributos=new Array,sw=0;
	
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cheque/ActionListarChequeCbte.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},[		
		'id_cheque',
		'nombre',
		'nro_cuenta_banco',
		'nro_cheque',
		'nombre_cheque',
		{name: 'fecha_cheque',type:'date',dateFormat:'Y-m-d'},
		'nro_cbte',
		'codigo_depto',
		'importe_cheque',
		'moneda',
		'observaciones_anulacion', 
		'estado_cheque',
		'tipo_cheque', 
		'id_cuenta_bancaria',
		'desc_banco','nro_transaccion','nro_deposito',
		'id_comprobante',
		'id_moneda','simbolo',
		'desc_clase','momento_cbte'
		]),remoteSort:true});
	 
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:-1
		}
	});
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},
				['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{m_id_gestion:-1}}); 
	
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
	var ds_ges_cta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount+100'},
				['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta',
				 'nro_cheque','estado_cuenta','nro_cuenta_banco','id_moneda','nombre_moneda','gestion']),baseParams:{m_id_gestion:-1}
	});
	
	var tpl_ges_cta=new Ext.Template('<div class="search-item">'
			,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
			'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
			'<b>Gestion: </b><FONT COLOR="#B5A642">{gestion}</FONT><br>','</div>');

	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda'
			])//,baseParams:{m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}
 			});

	function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}	
	var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT>','</div>');			
			
	function render_estado_cheque(value){
		if(value==0){value='Borrador'}
		if(value==1){value='Transitorio'}
		if(value==2){value='Efectivamente Cobrado'}
		if(value==3){value='Ingresos'}
		if(value==4){value='Impreso'}
		if(value==5){value='Anulado'}
		
		return value
	}

	function render_tipo_cheque(value, p, record)
	{	if(value=='transferencia'){return 'Transferencia';}
		if(value=='cheque'){return 'Cheque';}
		if(value=='deposito'){return 'Deposito';}		
	} 
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}	
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};
// txt desc_orden
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Banco',
			allowBlank:false,
			maxLength:100,
			minLength:1,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:true,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'ins.nombre',
		//save_as:'desc_orden'
	};
// txt motivo_orden
	Atributos[2]={
		validacion:{
			name:'nro_cuenta_banco',
			fieldLabel:'Nº Cta.Bancaria',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ctabco.nro_cuenta_banco',
	//	save_as:'motivo_orden'
	};	 
	
	Atributos[3]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Nº Cbte.',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.orden_trabajo_combo.abierto_cerrado}),
			width_grid:60,
			width:'60%',
			disabled:true,
			grid_indice:6			
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:0,
		defecto:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'cbte.nro_cbte'
		
	};
	Atributos[4]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'Depto.',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'60%',
			disabled:true,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'depto.codigo_depto'
	};	
 
	Atributos[5]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			renderer: render_total,
			width_grid:100,
			width:'60%',
			disabled:true,
			grid_indice:8	
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:0,
		defecto:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'chv.importe_cheque',
	};
		 
	Atributos[6]={
		validacion:{
			name:'moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'60%',
			disabled:true,
			grid_indice:9		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'mon.nombre',
		grid_indice:9
	};
	
	Atributos[7]={
		validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_banco', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
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
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:230,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		id_grupo:1,
		filterColValue:'ctabco.nro_cuenta_banco#ins.nombre',
		save_as:'id_cuenta_bancaria'
	};	
	
	Atributos[8]={
		validacion:{
			name:'tipo_cheque',
			fieldLabel:'Transacción',
			allowBlank:false,
			align:'left', 
			emptyText:'Tranmsac...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['transferencia','Transferencia'],['cheque','Cheque'] ]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_tipo_cheque,
			grid_editable:false,
			width_grid:200,
			width:230,
			minListWidth:200,
			grid_indice:12,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		save_as:'tipo_cheque'
	};
	
	Atributos[9]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Beneficiario',
			allowBlank:false,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:230,
			disabled:false,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.nombre_cheque',
		save_as: 'nombre_cheque'
	};	

 	Atributos[10]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Estado',
			allowBlank:false,
			align:'left', 
			emptyText:'Estado...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['5','Anular y Generar Nuevo'],['6','Anular']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_estado_cheque,
			grid_editable:false,
			width_grid:60,
			minListWidth:60,
			disabled:false,
			grid_indice:11,
			width:230
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		save_as:'estado_cheque'
	};
	
	Atributos[11]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'Nº Cheque',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:230,
			disabled:true,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.nro_cheque'
	};	
	
	Atributos[12]={
		validacion:{
			name:'nro_transaccion',
			fieldLabel:'Nº Transacción',
			allowBlank:true,
			maxLength:20,
			minLength:1,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:230,
			disabled:false,
			grid_indice:10		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.nro_transaccion',
		//save_as:'desc_orden'
	};
	
	
	Atributos[13]={
		validacion:{
			name:'nro_deposito',
			fieldLabel:'Nº Depósito',
			allowBlank:true,
			maxLength:20,
			minLength:1,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:230,
			disabled:false,
			grid_indice:10		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.nro_deposito',
		//save_as:'desc_orden'
	};
	
	// txt fecha_final
	Atributos[14]= {
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'Fecha',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			width:230,
			disabled:false,
			grid_indice:5		
		},
		form:true,
		tipo:'DateField',
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.fecha_cheque',
		dateFormat:'m-d-Y',
		defecto:'',
	};
	
	Atributos[15]={
		validacion:{
			name:'observaciones_anulacion',
			fieldLabel:'Observación',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false,
			grid_indice:10		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'che.observaciones_anulacion',
		save_as: 'observaciones_anulacion'
	};	
	
	Atributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[17]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[18]={
		validacion:{
			labelSeparator:'',
			name: 'simbolo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[19]={
		validacion:{
			labelSeparator:'',
			name: 'desc_clase',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[20]={
		validacion:{
			labelSeparator:'',
			name: 'momento_cbte',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Orden Trabajo',grid_maestro:'grid-'+idContenedor};
	var layout_cheque_cbte=new DocsLayoutMaestro(idContenedor);
	layout_cheque_cbte.init(config);

	// INICIAMOS HERENCIA //
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cheque_cbte,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
 
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
	
	var CM_mostrarComponente=this.mostrarComponente;
	var enableSelect=this.EnableSelect;

	this.EnableSelect=function(x,z,y){
	    if (y.data['estado_cheque']=='5'){
			 _CP.getPagina(idContenedor).pagina.getBoton('editar-'+idContenedor).disable();			    	}
		 else{
		 	_CP.getPagina(idContenedor).pagina.getBoton('editar-'+idContenedor).enable();
		 }		    					
		enableSelect(x,z,y);		    					
	}
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={		
		editar:{crear:true,separador:false},		
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cheque/ActionGuardarAnularCheque.php'},
		Save:{url:direccion+'../../../control/cheque/ActionGuardarAnularCheque.php'},
		ConfirmSave:{url:direccion+'../../../control/cheque/ActionGuardarAnularCheque.php'},
		
		//Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Orden de Trabajo'}
		
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,height:500,columnas:['90%'],
			grupos:
			[{tituloGrupo:'Datos Fijos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Editables',columna:0,id_grupo:1}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		txt_estado_orden=ClaseMadre_getComponente('estado_orden');
		txt_tipo_cheque=ClaseMadre_getComponente('tipo_cheque');
		
		if(ClaseMadre_getComponente('tipo_cheque').getValue()=='cheque'){
			ClaseMadre_getComponente('nro_cheque').enable();
		}else{
			ClaseMadre_getComponente('nro_cheque').disable();
		}
		
		var onTipoCheque=function(e){ 
			if(e.value=='cheque'){
				ClaseMadre_getComponente('nro_cheque').enable();
				
				ClaseMadre_getComponente('nro_transaccion').allowBlank=true;
				CM_mostrarComponente(ClaseMadre_getComponente('nro_cheque'));
				CM_ocultarComponente(ClaseMadre_getComponente('nro_transaccion'));
				CM_ocultarComponente(ClaseMadre_getComponente('nro_deposito'));
			}else{
				ClaseMadre_getComponente('nro_cheque').disable();
				
				ClaseMadre_getComponente('nro_transaccion').allowBlank=false;
				
				CM_ocultarComponente(ClaseMadre_getComponente('nro_cheque'));
				CM_mostrarComponente(ClaseMadre_getComponente('nro_transaccion'));
				CM_ocultarComponente(ClaseMadre_getComponente('nro_deposito'));
			}
		}
		txt_tipo_cheque.on('change',onTipoCheque);
		txt_tipo_cheque.on('select',onTipoCheque);
	}
		
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			
			ClaseMadre_getComponente('tipo_cheque').enable();
			
			if(SelectionsRecord.data.tipo_cheque=='cheque'){
				ClaseMadre_getComponente('tipo_cheque').setRawValue('Cheque');
				ClaseMadre_getComponente('nro_cheque').enable();
				
				ClaseMadre_getComponente('nro_transaccion').allowBlank=true;
				ClaseMadre_getComponente('nro_deposito').allowBlank=true;
				CM_mostrarComponente(ClaseMadre_getComponente('nro_cheque'));
				CM_ocultarComponente(ClaseMadre_getComponente('nro_transaccion'));
				CM_ocultarComponente(ClaseMadre_getComponente('nro_deposito'));
				ClaseMadre_getComponente('estado_cheque').enable();
			}else 
			{
				if(SelectionsRecord.data.tipo_cheque=='transferencia'){
					ClaseMadre_getComponente('estado_cheque').enable();
					ClaseMadre_getComponente('tipo_cheque').setRawValue('Transferencia');
					
					CM_ocultarComponente(ClaseMadre_getComponente('nro_cheque'));
					CM_mostrarComponente(ClaseMadre_getComponente('nro_transaccion'));
					CM_ocultarComponente(ClaseMadre_getComponente('nro_deposito'));
					
					ClaseMadre_getComponente('nro_transaccion').allowBlank=false;
					ClaseMadre_getComponente('nro_deposito').allowBlank=true;
				}else if (SelectionsRecord.data.tipo_cheque=='deposito')
				{ 
					ClaseMadre_getComponente('estado_cheque').disable();
					ClaseMadre_getComponente('tipo_cheque').setRawValue('Depósito');
					ClaseMadre_getComponente('tipo_cheque').disable();
					
					CM_ocultarComponente(ClaseMadre_getComponente('nro_cheque'));
					CM_ocultarComponente(ClaseMadre_getComponente('nro_transaccion'));
					CM_mostrarComponente(ClaseMadre_getComponente('nro_deposito'));
					
					ClaseMadre_getComponente('nro_transaccion').allowBlank=true;
					ClaseMadre_getComponente('nro_deposito').allowBlank=false;
		   		}
			}
					
			if(SelectionsRecord.data.estado_cheque==0){
			   ClaseMadre_getComponente('estado_cheque').setRawValue('Borrador');
			}else if(SelectionsRecord.data.estado_cheque==1){
				ClaseMadre_getComponente('estado_cheque').setRawValue('Transitorio');
			}else if(SelectionsRecord.data.estado_cheque==2){
				ClaseMadre_getComponente('estado_cheque').setRawValue('Efectivamente Cobrado');
			}else if(SelectionsRecord.data.estado_cheque==3){
				ClaseMadre_getComponente('estado_cheque').setRawValue('Ingresos');
			}else if(SelectionsRecord.data.estado_cheque==4){
				ClaseMadre_getComponente('estado_cheque').setRawValue('Impreso');
			}else if(SelectionsRecord.data.estado_cheque==5){
				ClaseMadre_getComponente('estado_cheque').setRawValue('Anulado');
			}
		}
		ClaseMadre_btnEdit();
	}
	
	function btn_repcbte(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_simbolo='+SelectionsRecord.data.simbolo;
			data=data+'&m_desc_clases='+SelectionsRecord.data.desc_clase;
			data=data+'&m_momento_cbte='+SelectionsRecord.data.momento_cbte;

			window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	var gestion = new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'gestion',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_gestion',
		tpl:tpl_gestion
	});
	
	var ges_cta = new Ext.form.ComboBox({
		store: ds_ges_cta,
		limit: paramConfig.TamanoPagina+100,
		displayField:'nro_cuenta_banco',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'Cuenta Bancaria...',
		queryParam: 'filterValue_0',
		filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
		selectOnFocus:true,
		width:230,
		valueField: 'id_cuenta_bancaria',
		tpl:tpl_ges_cta
	});
	
	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();
		ds_ges_cta.baseParams={m_id_gestion:g_id_gestion};	
		ds_cuenta_bancaria.baseParams={m_id_gestion:g_id_gestion};
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});
		
		ds_ges_cta.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina+100,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});
			
	});

	ges_cta.on('select',function (combo, record, index){
		g_id_cuenta_bancaria=ges_cta.getValue();
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion,
				m_id_cuenta_bancaria:g_id_cuenta_bancaria
			}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cheque_cbte.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBotonCombo(gestion,'gestion');
	this.AdicionarBotonCombo(ges_cta,'cuenta');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_repcbte,true,'rep_comprobante','');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cheque_cbte.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}