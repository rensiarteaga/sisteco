/**
* Nombre:		  	    pagina_rendicion_documento.js
* Propósito: 			pagina objeto principal
* Autor:				avq
* Fecha creación:		08/10/2010
*/
function pagina_rendicion_documento(idContenedor,direccion,paramConfig,idContenedorPadre){
	var vectorAtributos=new Array;
	var componentes=new Array()
	var ds;
	var elementos=new Array();
	var sw=0;
	
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
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarDetalleRendicionDocumento.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			//id: 'id_documento',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_caja',		
		'id_cuenta_doc',			
		'id_cuenta_doc_rendicion',
		'id_documento',
		'nro_documento',
		'razon_social',
		'motivo',
		'nro_nit',
		'factura',
		'importe_rendicion',
		'importe_total',
		'fk_id_cuenta_doc',
		'id_subsistema',
		'fecha'
		]),remoteSort:true
	});
	
	function render_nro_documento(value, p, record){		
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['nro_documento']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
	
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['nro_documento']+ '</span>');
			
			else
				return String.format('{0}', record.data['nro_documento']);
	}
		
	function render_razon_social(value, p, record){
			
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['razon_social']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
				
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['razon_social']+ '</span>');
			
			else
				return String.format('{0}', record.data['razon_social']);
	}
		
	function render_motivo(value, p, record){
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['motivo']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
				
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['motivo']+ '</span>');
			
			else
				return String.format('{0}', record.data['motivo']);
	}		
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
  vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_cuenta_doc',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		form:true,
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_doc'
	};
	vectorAtributos[1] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_caja',
			fieldLabel:'Id Caja',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0,
			width_grid:60
		},
		form:true,
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja'
	};
	
vectorAtributos[2] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_cuenta_doc_rendicion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_doc_rendicion'
	};
	
vectorAtributos[3] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};	
	
			
vectorAtributos[4]= {
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nro Recibo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			renderer:render_nro_documento,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:200
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		save_as:'nro_documento',
		id_grupo:1
	};
vectorAtributos[5]= {
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			renderer:render_razon_social,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:200
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		save_as:'razon_social',
		id_grupo:1
	};
	vectorAtributos[6]= {
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			renderer:render_motivo,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:200
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		save_as:'motivo',
		id_grupo:1
	};
	vectorAtributos[7]={
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			
			vtype:'texto',
			width_grid:95,
			disabled:true
			
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'fecha',
		
		defecto:'',
		save_as:'fecha'
	};
	vectorAtributos[8]= {
		validacion:{
			name:'nro_nit',
			fieldLabel:'Nro NIT',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:100,
			align:'left'
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		save_as:'nro_nit',
		id_grupo:1
	};

vectorAtributos[9]= {
		validacion:{
			name:'factura',
			fieldLabel:'Nro Factura',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:100,
			align:'left'
		},
		form:false,
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'INGDET.cantidad',
		save_as:'factura',
		id_grupo:1
	};

	vectorAtributos[10]= {
		validacion:{
			name:'importe_rendicion',
			fieldLabel:'Importe Liquido',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			width_grid:100,
			renderer: render_total,
			align:'right'
		},
		form:false,
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		save_as:'importe_rendicion',
		id_grupo:1
	};
	vectorAtributos[11]= {
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			width:'95%',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:5,
			renderer: render_total,
			width_grid:100,
			align:'right'
		},
		form:false,
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'INGDET.cantidad',
		save_as:'importe_total',
		id_grupo:1
	};	
	
	
	//----------- FUNCIONES RENDER

	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={titulo_maestro:'Solicitud de Viáticos (Maestro)',titulo_detalle:'detalle_viatico (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_rendicion_documento = new DocsLayoutMaestro(idContenedor);
	layout_rendicion_documento.init(config);
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
		
	this.pagina(paramConfig,vectorAtributos,ds,layout_rendicion_documento,idContenedor);
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure= this.conexionFailure;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ


	var paramMenu={
		actualizar:{crear:true,separador:false}
	};




	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_doc/ActionCorregirRecibo.php',mensaje:'¿Está seguro de revertir el recibo?'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:'80%',
		columnas:['60%','34%'],
		grupos:[{tituloGrupo:'Información del Material',columna:0,id_grupo:0},
		{tituloGrupo:'Datos Ingreso',columna:1,id_grupo:1}
		],
		minWidth:150,minHeight:200,closable:true,titulo: 'Detalle'}
	}
	
	
	
	this.reload=function(params){
		maestro=params
		//maestro.id_cuenta_doc=maestro.id_cuenta_doc;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_caja:maestro.id_caja
			}
		};
		this.btnActualizar();
		vectorAtributos[1].defecto=maestro.id_caja;
		paramFunciones.btnEliminar.parametros='&id_caja='+maestro.id_caja;
	
		
	
		this.InitFunciones(paramFunciones)
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	
	function iniciarPaginaRenDocumento()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	}
	function btn_corregir_recibo(){
		
	ClaseMadre_btnEliminar();	
		
		
	}
		

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_rendicion_documento.getLayout();
	};

	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Recibo',btn_corregir_recibo,true,'corr_rec','Corregir Recibo');
	
	this.iniciaFormulario();
	iniciarPaginaRenDocumento();
	layout_rendicion_documento.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	


}