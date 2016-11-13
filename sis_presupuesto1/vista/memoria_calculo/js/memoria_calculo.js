/**
 * Nombre:		  	    pagina_memoria_calculo.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2008-07-10 09:08:18
 */
function pagina_memoria_calculo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	
	var componentes=new Array();
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
		allowNegative:false,
		minValue:0}	
	); 		
	

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_memoria_calculo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_memoria_calculo',
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'justificacion',
		'id_partida_presupuesto',
		'desc_partida_presupuesto',
		'tipo_detalle',
		'id_moneda',
		'des_moneda',
		'costo_estimado',
		'tipo_cambio',
		'total',
		'id_moneda2',
		'desc_moneda2'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_partida_presupuesto:maestro.id_partida_presupuesto,
			tipo_memoria:maestro.tipo_memoria,
			id_moneda:maestro.id_moneda	
		}
	});	
		
	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
	else return "  "
	}
	
	// DEFINICI�N DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(51-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(52-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad],
					   ['Partida',maestro.desc_partida.replace(/^\s+/, "").replace(/\s+$/, "") ]
					   ];
	
	//DATA STORE COMBOS
    var ds_concepto_ingas = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_ingas/ActionListarConceptoIngas.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords:'TotalCount'}, ['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv']),
			baseParams:{m_id_partida : maestro.id_partida}
    });
    var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
    			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
	});
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{prioridad:1}
	});
	
	var ds_moneda2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});	
	
	//FUNCIONES RENDER
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</i></b>','</div>');
	//var tpl_id_moneda=		  new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>'    ,'<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT><br>','</div>');
	
	
	function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
	var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['des_moneda'])}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function render_id_moneda2(value, p, record){return String.format('{0}', record.data['desc_moneda2']);}
	var tpl_id_moneda2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	function render_tipo_memoria(value)
	{	
		if(value==1){return 'Recursos'};
		if(value==2){return 'Gastos'};
		if(value==3){return 'Inversiones'};
		if(value==4){return 'Pasajes'};
		if(value==5){return 'Viajes'};
		if(value==6){return 'RRHH'};
		if(value==7){return 'Servicios'};
		if(value==8){return 'Otros Gastos'};
		if(value==9){return 'Combustibles'};
	}
	
	function render_moneda(value)
	{
		if(value == 1){return "Bolivianos"}
		if(value == 2){return "D�lares Americanos"}
		if(value == 3){return "Unidad de Fomento a la Vivienda"}
		if(value == 4){return "Otros"}
	}
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
			return monedas_for.formatMoneda(value)		 
	}
	
	// hidden id_memoria_calculo
	//en la posici�n 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_memoria_calculo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_memoria_calculo'
	};
	
	// txt id_concepto_ingas
	Atributos[1]={
			validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto',
			allowBlank:false,			
			emptyText:'Concepto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			desc: 'desc_ingas_item_serv',
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'desc_ingas_item_serv',
			typeAhead:true,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'desc_ingas_item_serv',
		save_as:'id_concepto_ingas'
	};
	
	// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda a Presupuestar',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'des_moneda', //indica la columna del store principal ds del que proviane la descripcion
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	// txt justificacion
	Atributos[3]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificacion',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'MEMCAL.justificacion',
		save_as:'justificacion'
	};
	
	// txt id_partida_presupuesto
	Atributos[4]={
		validacion:{
			name:'id_partida_presupuesto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		id_grupo:0,
		defecto:maestro.id_partida_presupuesto,
		save_as:'id_partida_presupuesto'
	};
	// txt tipo_detalle
	Atributos[5]={
		validacion:{
			name:'tipo_detalle',
			fieldLabel:'Tipo Memoria',
			allowBlank:true,
			maxLength:50,
			align:'left', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			renderer:render_tipo_memoria,
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'50%',
			disabled:true
		},
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'MEMCAL.tipo_detalle',
		defecto:maestro.tipo_memoria,
		save_as:'tipo_detalle'
	};
	
	
	
	// txt costo_estimado
	Atributos[6]={
		validacion:{
			name:'costo_estimado',
			fieldLabel:'Costo Estimado',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:false
		},
		tipo: 'NumberField',
		defecto:0,
		id_grupo:0,
		form: false			
	};
	// txt tipo_cambio
	Atributos[7]={				
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo de Cambio',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:6,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		id_grupo:0,
		form: false		
	};
	
	// txt total
	Atributos[2]={
		validacion:{
			name:'total',
			fieldLabel:'Total Presupuestado',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: renderSeparadorDeMil,
			width_grid:140,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:1,
		//filterColValue:'PARDET.total',
		save_as:'total'
	};	
	
	// txt id_moneda
	Atributos[9]={
			validacion:{
			name:'id_moneda2',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda2', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda2,
			valueField: 'id_moneda2',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda2,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda2,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda2'
	};
	
	
	
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Detalle de Partida Gasto (Maestro)',titulo_detalle:'Memoria de C�lculo (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_calculo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_memoria_calculo.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_calculo,idContenedor);
	var EstehtmlMaestro=this.htmlMaestro;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getGrid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_actualizar=this.btnActualizar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	//DEFINICI�N DE LA BARRA DE MEN�
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

	//DEFINICI�N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/memoria_calculo/ActionEliminarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
	Save:{url:direccion+'../../../control/memoria_calculo/ActionGuardarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
	ConfirmSave:{url:direccion+'../../../control/memoria_calculo/ActionGuardarMemoriaCalculo.php',parametros:'&m_id_partida_presupuesto='+maestro.id_partida_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Memoria de C�lculo',
	grupos:[{
				tituloGrupo:'Datos Memoria C�lculo',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Filtrar',
				columna:0,
				id_grupo:1
			}]	
		}
	};
	
	this.getLayout=function(){
		return layout_memoria_calculo.getLayout()
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(unescape(params)));
		maestro.id_partida_presupuesto=datos.m_id_partida_presupuesto;
		maestro.id_presupuesto=datos.m_id_presupuesto;
		maestro.id_parametro=datos.m_id_parametro;
		maestro.nombre_financiador=datos.m_nombre_financiador;
		maestro.nombre_regional=datos.m_nombre_regional;
		maestro.nombre_programa=datos.m_nombre_programa;
		maestro.nombre_proyecto=datos.m_nombre_proyecto;
		maestro.nombre_actividad=datos.m_nombre_actividad;
		maestro.id_partida=datos.m_id_partida;
		maestro.desc_partida=datos.m_desc_partida;
	 	maestro.desc_moneda=datos.m_desc_moneda;
	 	maestro.tipo_pres=datos.m_tipo_pres;
	 	maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
	 	maestro.id_moneda=datos.m_id_moneda;
	 	maestro.tipo_memoria=datos.m_tipo_memoria;
	 	maestro.tipo_vista=datos.m_tipo_vista;
	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_partida_presupuesto:maestro.id_partida_presupuesto,
				tipo_memoria:maestro.tipo_memoria,
				id_moneda:maestro.id_moneda	
			}
		};
		prueba.setValue(maestro.id_moneda);
		
		this.btnActualizar();
		data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(51-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(52-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad],
					   ['Partida',maestro.desc_partida.replace(/^\s+/, "").replace(/\s+$/, "") ]
					   ];

		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		Atributos[1].validacion.store.baseParams={m_id_partida:maestro.id_partida};
		Atributos[8].defecto=maestro.id_moneda;		
		Atributos[4].defecto=maestro.id_partida_presupuesto;
		Atributos[5].defecto=maestro.tipo_memoria;
		
 
		this.InitFunciones(paramFunciones);
		
		//Ocultado temporalmente para mostrar los botones	
		ocultarBotones(); 
	 	padre.getBotonNombre(render_tipo_memoria(maestro.tipo_memoria)).show();		
	 	
	 	
	 	/*ds_presupuesto.load
		({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_presupuesto:maestro.id_presupuesto				
				},
			callback: function(){
				
				estado_pres=ds_presupuesto.getAt(0).data['estado_pres'];	
				//si el estado del presupuesto es 3 = Revision Final, bloqueamos los botones de modificacion	  				
				if(estado_pres==3)
				{
					CM_getBoton('nuevo-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
				}
				else
				{
					CM_getBoton('nuevo-'+idContenedor).enable();
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
				}
			}
		});	*/
	 	
	 	if(maestro.tipo_vista==2)
		{
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
		}
		else
		{
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
		}
	};
	
	function btn_ingreso(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);

			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
			data+='&m_sw_vista=recurso';
			data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_recurso/memoria_recurso.php?'+data,'Memoria de Ingresos',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_memoria_gasto(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);
			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_gasto/memoria_gasto.php?'+data,'Memoria de Gastos x Item',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_memoria_inversion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);
			
			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_inversion/memoria_inversion.php?'+data,'Memoria de Inversiones',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_memoria_pasajes(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);

			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_pasaje/memoria_pasaje.php?'+data,'Memoria de Otros Gastos',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_memoria_viaticos(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);			
			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);			

			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_viaje/memoria_viaje.php?'+data,'Memoria Viaje Gasto',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_servicio_gasto(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);

			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_servicio/memoria_servicio.php?'+data,'Memoria de Servicios',ParamVentana);
		
			//Para actualizar los datos del padre al cerrar el hijo
			layout_memoria_calculo.getVentana().on('resize',function(){ layout_memoria_calculo.getLayout().layout()	})			
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_rrhh_gasto(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);			
			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+escape(maestro.id_presupuesto);
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);

			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_rrhh_gasto/memoria_rrhh_gasto.php?'+data,'Memoria RRHH Gasto',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_memoria_otros(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);

			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_tipo_pres='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
			data+='&m_sw_vista=otros';
			data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			 
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_rrhh_gasto/memoria_rrhh_gasto.php?'+data,'Memoria de RRHH',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}	
	
	function btn_memoria_combustibles(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_memoria_calculo='+SelectionsRecord.data.id_memoria_calculo;
			data+='&m_tipo_detalle='+escape(SelectionsRecord.data.tipo_detalle);
			data+='&m_id_partida_presupuesto='+SelectionsRecord.data.id_partida_presupuesto;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda; 
			data+='&m_desc_moneda='+escape(SelectionsRecord.data.des_moneda);
			data+='&m_id_presupuesto='+maestro.id_presupuesto;
			data+='&m_id_parametro='+maestro.id_parametro;
		 	data+='&m_nombre_financiador='+escape(maestro.nombre_financiador);
			data+='&m_nombre_regional='+escape(maestro.nombre_regional);
		 	data+='&m_nombre_programa='+escape(maestro.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(maestro.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(maestro.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(maestro.desc_unidad_organizacional);
		 	data+='&m_desc_concepto_ingas='+escape(SelectionsRecord.data.desc_concepto_ingas);
		 	data+='&m_costo_estimado='+escape(SelectionsRecord.data.costo_estimado);
		 	data+='&m_tipo_cambio='+escape(SelectionsRecord.data.tipo_cambio);
		 	data+='&m_tipo_vista='+escape(maestro.tipo_vista);
			
			var ParamVentana={Ventana:{width:'60%',height:'60%'}}
			layout_memoria_calculo.loadWindows(direccion+'../../../../sis_presupuesto/vista/memoria_combustible/memoria_combustible.php?'+data,'Memoria de Combustibles',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	function ocultarBotones(){	
		padre.getBotonNombre('Recursos').hide();
		padre.getBotonNombre('Gastos').hide();
		padre.getBotonNombre('Inversiones').hide();
		padre.getBotonNombre('Pasajes').hide();
		padre.getBotonNombre('Viajes').hide();		
		padre.getBotonNombre('RRHH').hide();		
		padre.getBotonNombre('Servicios').hide();		
		padre.getBotonNombre('Otros Gastos').hide();
		padre.getBotonNombre('Combustibles').hide();		
	}
	
	function InitMemoriaCalculo()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);			
		}	 
		
	};
	
	var prueba=new Ext.form.ComboBox({
			store: ds_moneda2,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',			
			editable:false,			
			tpl:tpl_id_moneda			
		});

	//prueba.setValue(maestro.id_moneda);
	
		ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
	);
	
	prueba.on('select',
		function(){		
			
			ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros: paramConfig.CantFiltros,
				 id_partida_presupuesto:maestro.id_partida_presupuesto,
				 tipo_memoria:maestro.tipo_memoria,
				 id_moneda: prueba.getValue()
			}
		};		
		
			
		
		data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(51-maestro.tipo_pres.length)],['Moneda',prueba.getValue()+". "+render_moneda(prueba.getValue())+tabular(52-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad],
					   ['Partida',maestro.desc_partida.replace(/^\s+/, "").replace(/\s+$/, "") ]
					   ];		
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		ClaseMadre_btnActualizar()		
	});	
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_memoria_calculo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);		
	
	
//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto
/*	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto',	'estado_pres'])//,
		//baseParams:{id_presupuesto : maestro.id_presupuesto}
		});

	var estado_pres;
	var CM_getBoton=this.getBoton;
	
	ds_presupuesto.load
		({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_presupuesto:maestro.id_presupuesto				
				},
			callback: function(){
				
				estado_pres=ds_presupuesto.getAt(0).data['estado_pres'];	
				//si el estado del presupuesto es 3 = Revision Final, bloqueamos los botones de modificacion	  				
				if(estado_pres==3)
				{
					CM_getBoton('nuevo-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
				}
				else
				{
					CM_getBoton('nuevo-'+idContenedor).enable();
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
				}
			}
		});	*/
	var CM_getBoton=this.getBoton;	
	if(maestro.tipo_vista==2)
	{
		CM_getBoton('nuevo-'+idContenedor).disable();
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
	}
	else
	{
		CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('editar-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
	}	
		
//Fin codigo de bloqueo de botones
	
	
			
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones	
	var padre=this;
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Recursos',btn_ingreso,false,'Recursos','Memoria de Recursos');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Gasto x Item',btn_memoria_gasto,false,'Gastos','Memoria de Gastos x Item');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Inversiones',btn_memoria_inversion,false,'Inversiones','Memoria de Inversiones');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Pasajes',btn_memoria_pasajes,false,'Pasajes','Memoria de Pasajes');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Vi�ticos',btn_memoria_viaticos,false,'Viajes','Memoria de Vi�ticos');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de RRHH',btn_rrhh_gasto,false,'RRHH','Memoria de RRHH');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Servicios',btn_servicio_gasto,false,'Servicios','Memoria de Servicios');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Otros Gastos',btn_memoria_otros,false,'Otros Gastos','Memoria de Otros Gastos');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Memoria de Combustibles',btn_memoria_combustibles,false,'Combustibles','Memoria de Combustibles');
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitMemoriaCalculo()
	layout_memoria_calculo.getLayout().addListener('layout',this.onResize);
	layout_memoria_calculo.getVentana(idContenedor).on('resize',function(){layout_memoria_calculo.getLayout().layout()})
	
	//Comentado temporalmente para mostrar los botones 
	ocultarBotones();
	padre.getBotonNombre(render_tipo_memoria(maestro.tipo_memoria)).show();	
	CM_ocultarGrupo('Filtrar');
	
	layout_memoria_calculo.getVentana().addListener('beforehide',salta)
}