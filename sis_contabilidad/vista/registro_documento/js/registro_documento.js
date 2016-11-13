/**
 * Nombre:		  	    pagina_registro_documento.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
 */
function pagina_registro_documento(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
		var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	
  var Documento = Ext.data.Record.create(['id_documento','id_transaccion','desc_transaccion','tipo_documento','nro_documento',{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},'razon_social','nro_nit','nro_autorizacion','codigo_control','poliza_dui','formulario','tipo_retencion','importe_total','importe_ice','importe_no_gravado','importe_sujeto','importe_credito','importe_debito','importe_iue','importe_it','id_moneda','nombre']);
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarRegistroDocumento.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_documento',
			totalRecords: 'TotalCount'
		}, Documento),baseParams:{m_id_moneda:maestro.id_moneda}
		,remoteSort:true});
 

 
	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Comprobante ',maestro.desc_comprobante,'Transacción ',maestro.concepto_tran,'Moneda',maestro.desc_moneda],
	['Cuenta',maestro.desc_cuenta,'Auxiliar ',maestro.desc_auxiliar,'Partida ',maestro.desc_partida],
	['Tipo Documento',maestro.desc_plantilla],
	];
	
	//DATA STORE COMBOS

    var ds_transaccion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarTransaccion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_transaccion',totalRecords: 'TotalCount'},['id_transaccion','id_comprobante','id_fuente_financiamiento','id_unidad_organizacional','id_cuenta','id_partida','id_auxiliar','id_orden_trabajo','id_oec','concepto_tran','id_fina_regi_prog_proy_acti'])
	});

	
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
	baseParams:{sw_reg_comp:'si'}
	});
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])
	});
	
	ds_parametro.load({
		params:{
			start:0,
			limit: 1,
			CantFiltros:1,
			m_id_transaccion:maestro.id_transaccion,
			m_sw_reg_documento:'si'
			
		}
	});
	//FUNCIONES RENDER
	function render_id_moneda(value, p, record){
		rf = ds_moneda.getById(value);
		if(rf!=null){record.data['nombre'] =rf.data['nombre'];}
		return String.format('{0}', record.data['nombre'])
	}
//function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre']);}
	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');	
		function render_id_transaccion(value, p, record){return String.format('{0}', record.data['desc_transaccion']);}
		var tpl_id_transaccion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_documento
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};

// txt tipo_documento
	Atributos[1]={
		validacion:{
			name:'tipo_documento',
			fieldLabel:'Tipo Documento',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		defecto:maestro.tipo_documento,
		filterColValue:'DOCUME.tipo_documento',
		save_as:'tipo_documento'
	};

// txt nro_nit
	Atributos[2]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit',
		save_as:'nro_nit'
	};
	
	// txt nro_documento
	Atributos[3]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Número Docuemnto',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento',
		save_as:'nro_documento'
	};
	// txt nro_autorizacion
	Atributos[4]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Número Autorización',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	// txt codigo_control
	Atributos[5]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código Control',
			allowBlank:true,
			maxLength:14,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			regex: /^((([0-9]|[a-z])([a-z]|[0-9])-){3}([0-9]|[a-z])([a-z]|[0-9])(-([0-9]|[a-z])([a-z]|[0-9]))?)$/i,
			maskRe: /[\d\s-abcdef]/i,
			invalidText: 'Código inválido. Formato correcto "1b-df-14-10-2d"'
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control',
		save_as:'codigo_control'
	};
	
	// txt razon_social
	Atributos[6]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		save_as:'razon_social'
	};
// txt fecha_documento
	Atributos[7]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y',
		
		save_as:'fecha_documento'
	};



// txt poliza_dui
	Atributos[8]={
		validacion:{
			name:'poliza_dui',
			fieldLabel:'Poliza',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.poliza_dui',
		save_as:'poliza_dui'
	};
// txt formulario
	Atributos[9]={
		validacion:{
			name:'formulario',
			fieldLabel:'Formulario',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.formulario',
		save_as:'formulario'
	};
	
		
	
/*// txt tipo_retencion
	Atributos[11]={
		validacion:{
			name:'tipo_retencion',
			fieldLabel:'Tipo Retención',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.tipo_retencion',
		save_as:'tipo_retencion'
	};*/

	Atributos[10]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe total',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_total',
		save_as:'importe_total'
	};
 
	Atributos[11]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'ICE',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_ice',
		save_as:'importe_ice'
	};
	Atributos[12]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe no Grvado',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_no_gravado',
		save_as:'importe_no_gravado'
	};
	Atributos[13]={
	validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Sujeto a Impuesto',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_sujeto',
		save_as:'importe_sujeto'
	};
 	Atributos[14]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'Importe Credito',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_credito',
		save_as:'importe_credito'
	};
	 	Atributos[15]={
		validacion:{
			name:'importe_debito',
			fieldLabel:'Importe  Debito',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_debito',
		save_as:'importe_debito'
	};
	Atributos[16]={
		validacion:{
			name:'importe_iue',
			fieldLabel:'IUE Retenido',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_iud',
		save_as:'importe_iue'
	};
	  
		
	Atributos[17]={
		validacion:{
			name:'importe_it',
			fieldLabel:'IT Retenido',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_it',
		save_as:'importe_it'
	};

// txt id_moneda
	Atributos[18]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	
	
			

			//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Transsacion (Maestro)',titulo_detalle:'registro_documento (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_documento = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_registro_documento.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_registro_documento,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
		
		
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		

		
 
	
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit =this.btnEdit;
	var ClaseMadre_save=this.Save;
	//var ClaseMadre_ConfirmSave=this.ConfirmSave;
 	
	 //this.ConfirmSave= function()
	//{
		
	//	ds_periodo_subsistema.getAt(0).data['fecha_inicio']
		
	//	padre.getGrid().colModel.setHidden(padre.getColumnNum('id_transaccion'),false);
//		componentes[1].setValue(maestro.id_transaccion);
	//	ClaseMadre_ConfirmSave();
	//} 
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/documento/ActionEliminarRegistroDocumento.php',parametros:'&m_id_transaccion='+maestro.id_transaccion},
	Save:{url:direccion+'../../../control/documento/ActionGuardarRegistroDocumento.php',parametros:'&m_id_transaccion='+maestro.id_transaccion},
	ConfirmSave:{url:direccion+'../../../control/documento/ActionGuardarRegistroDocumento.php',parametros:'&m_sw_documento=si&id_transaccion='+maestro.id_transaccion},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'registro_documento'}};

		function 	 MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		/*if(j%2!=0){
			html=html+"<td></td><td></td></tr>";
		}*/
		//html=html+'</table>';
		
	 
		return html
	};		
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_transaccion=datos.m_id_transaccion;
	maestro.tipo_plantilla=datos.m_tipo_plantilla;
	maestro.desc_plantilla=datos.m_desc_plantilla;
	maestro.desc_comprobante=datos.m_desc_comprobante;
	maestro.concepto_tran=datos.m_concepto_tran;
	maestro.desc_cuenta=datos.m_desc_cuenta;
	maestro.desc_auxiliar=datos.m_desc_auxiliar;
	maestro.desc_partida=datos.m_desc_partida;
	maestro.id_moneda=datos.m_id_moneda;
	maestro.desc_moneda=datos.m_desc_moneda;
		
  this.getBotonNombre('monedas').setValue(maestro.id_moneda);	

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_transaccion:maestro.id_transaccion,
				m_sw_reg_documento:'si',
				m_id_moneda:maestro.id_moneda
			}
		};
		this.btnActualizar();
		
		
	var data_maestro=[['Comprobante ',maestro.desc_comprobante,'Transacción ',maestro.concepto_tran,'Moneda',maestro.desc_moneda],
	['Cuenta',maestro.desc_cuenta,'Auxiliar ',maestro.desc_auxiliar,'Partida ',maestro.desc_partida],
	['Tipo Documento',maestro.desc_plantilla],
	];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		

		paramFunciones.btnEliminar.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.Save.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.ConfirmSave.parametros='&m_sw_documento=si&id_transaccion='+maestro.id_transaccion
	 	
	if (maestro.tipo_plantilla==1){desactivarColumna();	compraCCF();}
	if (maestro.tipo_plantilla==2){desactivarColumna();	compraSCF();}
	if (maestro.tipo_plantilla==3){desactivarColumna();	ventaCDF();}
	if (maestro.tipo_plantilla==4){desactivarColumna();	ventaSDF();}
	if (maestro.tipo_plantilla==5){desactivarColumna();	notaDF();}
	if (maestro.tipo_plantilla==6){desactivarColumna();	notaCF();}
	if (maestro.tipo_plantilla==7){desactivarColumna();	boletosBSP();}
	if (maestro.tipo_plantilla>=8 && maestro.tipo_plantilla<=13){desactivarColumna();Retenciones();}
	if (maestro.tipo_plantilla==14){desactivarColumna();	Importaciones();} 
		this.InitFunciones(paramFunciones)
	
	};
	var padre=this; 	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	
	function compraCCF(){	
			
	/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_credito'),false);
	
	}
	function compraSCF(){	
	/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
	}
	function ventaCDF(){	
	/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_debito'),false);
	}
	function ventaSDF(){	
	/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
}

function notaDF(){	
	/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('formulario'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
	padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_debito'),false);
}
function notaCF(){	
/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('formulario'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_credito'),false);
}
function boletosBSP(){	
/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_credito'),false);
}
function Retenciones()
{
/*padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),false);*/
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_iue'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_it'),false);
}

			

function desactivarColumna(){
/*
padre.getGrid().colModel.setHidden(padre.getColumnNum('tipo_documento'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_documento'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_autorizacion'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('poliza_dui'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('formulario'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_total'),true);*/
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_no_gravado'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_sujeto'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_credito'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_debito'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_iue'),true);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_it'),true);

}
function Importaciones()
{

/*padre.getGrid().colModel.setHidden(padre.getColumnNum('nro_nit'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('codigo_control'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('razon_social'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('fecha_documento'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('poliza_dui'),false);*/
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_ice'),false);
padre.getGrid().colModel.setHidden(padre.getColumnNum('importe_credito'),false);
}
function InitRegistroComprobante()
{
	grid=ClaseMadre_getGrid();
	dialog=ClaseMadre_getDialog();
	sm=getSelectionModel();
	formulario=ClaseMadre_getFormulario();
 	for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}

	/*componentes[1].on('select',f_filtrar_periodo);
	componentes[2].on('select',f_filtrar_fecha);
	componentes[3].on('change',f_filtrar_comprobante);
	componentes[6].on('select',f_filtrar_momento);*/
	
};
//para que los hijos puedan ajustarse al tamaño


/********************************************************/

 var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
		});
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			//  renderer:render_id_moneda
			tpl:tpl_id_moneda_reg
			
		});

		ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
		monedas.on('select',
		function (combo, record, index){
			ds.load({
				params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_transaccion:maestro.id_transaccion,
						m_id_moneda:record.data.id_moneda,
						m_sw_reg_documento:'si'
						}});			
		});

/*------------------------------------------------------------*/
	
/*------------------------------------------------------------*/
/********************************************************/
	this.getLayout=function(){return layout_registro_documento.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBotonCombo(monedas,'monedas');

	if (maestro.tipo_plantilla==1){desactivarColumna();	compraCCF();}
	if (maestro.tipo_plantilla==2){desactivarColumna();	compraSCF();}
	if (maestro.tipo_plantilla==3){desactivarColumna();	ventaCDF();}
	if (maestro.tipo_plantilla==4){desactivarColumna();	ventaSDF();}
	if (maestro.tipo_plantilla==5){desactivarColumna();	notaDF();}
	if (maestro.tipo_plantilla==6){desactivarColumna();	notaCF();}
	if (maestro.tipo_plantilla==7){desactivarColumna();	boletosBSP();}
	if (maestro.tipo_plantilla>=8 && maestro.tipo_plantilla<=13){desactivarColumna();Retenciones();}
	if (maestro.tipo_plantilla==14){desactivarColumna();	Importaciones();} 
//	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Nuevo',btn_nuevo_grid,true,'nuevo_grid','Nuevo');
	this.getBotonNombre('monedas').setValue(maestro.id_moneda);	
	layout_registro_documento.getLayout().addListener('layout',this.onResize);
	layout_registro_documento.getVentana(idContenedor).on('resize',function(){layout_registro_documento.getLayout().layout()})

	 
//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_transaccion:maestro.id_transaccion,
			m_sw_reg_documento:'si',
			m_id_moneda:maestro.id_moneda
			
			
		}
	});	
	
	
}