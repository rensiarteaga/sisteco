/**
 * Nombre:		  	    pagina_adm_cheque.js
 * Propósito: 			pagina objeto principal
 * Autor:				AVQ
 * Fecha creación:		04/04/2012
 */
function pagina_cheques(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	var monedas_for=new Ext.form.MonedaField(
			{
				name:'importe',
				fieldLabel:'valor',	
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_contabilidad/control/cheque/ActionPDFCheque.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},[	
         'id_cheque',		
		'nro_cheque',
		'nro_deposito',
		//'fecha_cheque',
		{name: 'fecha_cheque',type:'date',dateFormat:'Y-m-d'},
		'nombre_cheque',
		'importe_cheque',
		'estado',
		//'nombre',
		'cuenta_bancaria',
		'observaciones_anulacion',
		'tipo_cheque',
		'id_moneda'
		]),remoteSort:true});

	//DATA STORE COMBOS
	var ds_ges_cta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount+100'},
				['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta',
				 'nro_cheque','estado_cuenta','nro_cuenta_banco','id_moneda','nombre_moneda','gestion']),baseParams:{m_id_gestion:-2}
	});
    
	var tpl_ges_cta=new Ext.Template('<div class="search-item">'
			,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
			'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
			'<b>Gestion: </b><FONT COLOR="#B5A642">{gestion}</FONT><br>','</div>');
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	//ATRIBUTOS
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			fieldLabel:'Identificador Cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	Atributos[1]={//2
			validacion:{
				name:'nro_cheque',
				fieldLabel:'Nro.Cheque',
				grid_visible:true,
				grid_editable:false,
				width_grid:80
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CHEQUE.nro_cheque'
		};
	Atributos[2]={//2
			validacion:{
				name:'nro_deposito',
				fieldLabel:'Nro.Deposito',
				grid_visible:true,
				grid_editable:false,
				width_grid:80
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CHEQUE.nro_deposito'
		};	
	Atributos[3]={//1
			validacion:{
				name:'fecha_cheque',
				fieldLabel:'Fecha Cheque',
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				renderer:formatDate
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CHEQUE.fecha_cheque'
		};
	
	Atributos[4]={//4
			validacion:{
				name:'nombre_cheque',
				fieldLabel:'Nombre Cheque',
				grid_visible:true,
				grid_editable:false,
				width_grid:250
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CHEQUE.nombre_cheque'
		};
	Atributos[5]={//5
			validacion:{
				name:'importe_cheque',
				fieldLabel:'Importe',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				align:'right',
				renderer: render_total,
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CHEQUE.importe_cheque'
		};

	Atributos[6]={
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:80
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'estado'
		};	

	Atributos[7]={//3
			validacion:{
				name:'cuenta_bancaria',
				fieldLabel:'Cuenta Bancaria',
				grid_visible:true,
				grid_editable:false,
				width_grid:250
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'ins.nombre#cb.nro_cuenta_banco'
		};
	
	Atributos[8]={//6
			validacion:{
				name:'observaciones_anulacion',
				fieldLabel:'Observaciones',
				grid_visible:true,
				grid_editable:false,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'cheque.observaciones_anulacion'
		};
	
	Atributos[9]={//7
			validacion:{
				name:'tipo_cheque',
				fieldLabel:'Tipo Cheque',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'cheque.tipo_cheque'
		};
	
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			fieldLabel:'Moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	// ----------     FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cheques',grid_maestro:'grid-'+idContenedor};
	var layout_caja=new DocsLayoutMaestro(idContenedor);
	layout_caja.init(config);

	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caja,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
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
	var CM_btnActualizar = this.btnActualizar;
	var CM_conexionFailure = this.conexionFailure;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja/ActionEliminarCaja.php'},
		Save:{url:direccion+'../../../control/caja/ActionGuardarCaja.php'},
		ConfirmSave:{url:direccion+'../../../control/caja/ActionGuardarCaja.php'},
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:400,width:480,
		minWidth:150,minHeight:200,
		closable:true,titulo:'caja',
		grupos:[{tituloGrupo:'Cheque',columna:0,id_grupo:0}]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_imp_cheque(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();	
		if(NumSelect!=0){
		  var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
			  data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			//  alert (data);
			window.open(direccion+'../../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		
	}
	
	var ges_cta = new Ext.form.ComboBox({
		store: ds_ges_cta,
		limit: paramConfig.TamanoPagina+100,
		displayField:'nro_cuenta_banco',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'Cuenta Bancaria ...',
		queryParam: 'filterValue_0',
		filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
		selectOnFocus:true,
		width:230,
		valueField: 'id_cuenta_bancaria',
		tpl:tpl_ges_cta
	});
	
	ges_cta.on('select',function (combo, record, index)
	{
		g_id_cuenta_bancaria=ges_cta.getValue();
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_estado_che: 4,
				m_id_cuenta_bancaria:g_id_cuenta_bancaria
			}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_estado_che: 4,
			m_id_cuenta_bancaria:-2
		}
	});
	
	//para agregar botones
	this.AdicionarBotonCombo(ges_cta,'cuenta');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Impresión Cheque',btn_imp_cheque,true,'cheque','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}