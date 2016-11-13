/**
 * Nombre:		  	    pagina_orden_trabajo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-27 09:14:44
 */
function pagina_cheque_cbte(idContenedor,direccion,usuario,paramConfig){
	var Atributos=new Array,sw=0;
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
		'desc_banco'
		]),remoteSort:true});
	 
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
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
		if(value=='deposito'){return 'deposito';}		
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
			fieldLabel:'Nº Cuenta Bancaria',
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
		filterColValue:'ctabco.nro_cuenta_banco',
	//	save_as:'motivo_orden'
	};	 
		 
	
	Atributos[3]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'Nº Cheque',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'che.nro_cheque'
		
	
	};	

	 // txt fecha_final
	Atributos[4]= {
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'Fecha Cheque',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:5		
		},
		form:true,
		tipo:'DateField',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'che.fecha_cheque',
		dateFormat:'m-d-Y',
		defecto:'',
		
	};
	Atributos[5]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'CBTE',
			allowBlank:false,
			//align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.orden_trabajo_combo.abierto_cerrado}),
			
			width_grid:40,
			width:'20%',
			disabled:true,
			grid_indice:6			
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:0,
		defecto:1,
		filtro_0:true,
		filterColValue:'cbte.nro_cbte'
		
	};
	Atributos[6]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'DEPTO',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'depto.codigo_depto'
		
	
	};	
 
	Atributos[7]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe',
			allowBlank:false,
			//align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.orden_trabajo_combo.abierto_cerrado}),
			
			width_grid:80,
			width:'20%',
			disabled:true,
			grid_indice:8	
				
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:0,
		defecto:1,
		filtro_0:true,
		filterColValue:'chv.importe_cheque',
		
	};
		 
		 
	Atributos[8]={
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
			width:'100%',
			disabled:true,
			grid_indice:9		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'mon.nombre',
		grid_indice:9
	
	};
	
	Atributos[9]={
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'CUENTA_8.nro_cuenta#CUENTA_8.descripcion##CUEBAN_8.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};	
		Atributos[10]={
		validacion:{
			name:'tipo_cheque',
			fieldLabel:'Tipo Transacción',
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
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:true,
		save_as:'tipo_cheque'
	};
	Atributos[11]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre Cheque',
			allowBlank:false,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'che.nombre_cheque',
		save_as: 'nombre_cheque'
	
	};	

 	Atributos[12]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Estado Cheque',
			allowBlank:false,
			align:'left', 
			emptyText:'Estado...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['5','Anulae y Generar Nuevo'],['6','Anular']]}),
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
			grid_indice:11	
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:true,
		save_as:'estado_cheque'
	};
	
	Atributos[13]={
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
		filterColValue:'che.observaciones_anulacion',
		save_as: 'observaciones_anulacion'
	
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
		actualizar:{crear:true,separador:false}
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
	}
		
	
	 

	 
	 
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cheque_cbte.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cheque_cbte.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}