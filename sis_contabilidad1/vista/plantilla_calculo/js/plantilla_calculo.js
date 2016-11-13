/**
 * Nombre:		  	    pagina_plantilla_calculo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-16 12:20:
 * Fechade modificación: 24/07/2009
 */
function pagina_plantilla_calculo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	var Atributos=new Array,sw=0;
    var cmpTipoCuenta, cmpEjercicio;
    
	//  DATA STORE //
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla_calculo/ActionListarPlantillaCalculo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_plantilla_calculo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_plantilla_calculo',
		'id_plantilla',
		'desc_plantilla',
		'tipo_cuenta',
		'id_ejercicio',
		'desc_ejercicio',
		'desc_cuenta_ejercicio',
		'debe_haber',
		'porcen_calculo',
		'campo_doc',
		'sw_porcentaje',
		'sw_retencion',
		'sw_contabilizacion'
		]),remoteSort:true});
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Plantilla',maestro.desc_plantilla]];;
	
	//DATA STORE COMBOS
    var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea'])
	});

    var ds_cuenta_ejercicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_ejercicio/ActionListarCuentaEjercicio.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_ejercicio',totalRecords: 'TotalCount'},['id_ejercicio','id_cuenta','tipo_ejercicio','desc_ejercicio']),
			baseParams:{m_sw_cuenta_ejercicio:'si',m_id_gestion:-1}
	});
    
    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},
				['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{m_id_gestion:-1}}); 
	
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');

	//FUNCIONES RENDER	
	function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_ejercicio(value, p, record){return String.format('{0}', record.data['desc_ejercicio']);}
	var tpl_id_ejercicio=new Ext.Template('<div class="search-item">','<b><i>{tipo_ejercicio} - </i></b>','<b><i>{desc_ejercicio}</i></b>','</div>');
	
	function render_tipo_cuenta(value){
		if(value==1){value='Cuenta Comprobante'	}
		else{	value='Cuenta Referencial'		}
		return value
	}
	function render_debe_haber(value){
		if(value==1){value='Debe'	}
		else{	value='Haber'		}
		return value
	}
	
	function render_sw_porcentaje(value){
		if(value==1){value='Si'	}
		else{	value='No'		}
		return value
	}
	
	function render_sw_retencion(value){
		if(value==1){value='Si'	}
		else{	value='No'		}
		return value
	}
	
	function render_sw_contabilizacion(value){
		if(value=='si'){value='Si'	}
		else{	value='No'		}
		return value
	}
	
	// hidden id_plantilla_calculo
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_plantilla_calculo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_plantilla_calculo'
	};
	
	// txt id_plantilla
	Atributos[1]={
		validacion:{
			name:'id_plantilla',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_plantilla,
		save_as:'id_plantilla'
	};

	// txt tipo_cuenta
	Atributos[2]={
		validacion:{
			name:'tipo_cuenta',
			fieldLabel:'Movimiento Al',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Cuenta Comprobante'],['2','Cuenta Referencial']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_tipo_cuenta,
			grid_editable:false,
			forceSelection:true,
			width_grid:250,
			width:250
			
		},
		tipo:'ComboBox',
		save_as:'tipo_cuenta'
		};
	
	// txt id_ejercicio
	Atributos[3]={
			validacion:{
			name:'id_ejercicio',
			fieldLabel:'Ejercicio',
			allowBlank:true,			
			emptyText:'Ejercicio...',
			desc: 'desc_ejercicio', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_ejercicio,//contenedor del combo 
			valueField: 'id_ejercicio',//que valor v tener el combo
			displayField: 'desc_ejercicio',//que va mostrar el combo
			queryParam: 'filterValue_0',
			//filterCol:'CUEJE.',
			filterCol:'CUEJE.desc_ejercicio',
			typeAhead:true,
			tpl:tpl_id_ejercicio,
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
			renderer:render_id_ejercicio,// el campo que va a mostrar en la grilla y este tiene que estar en el xml
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:250,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUEJE.desc_ejecicio',
		save_as:'id_ejercicio'
	};
	
	Atributos[4]={
		validacion:{
			name:'debe_haber',
			fieldLabel:'Cuenta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Debe'],['2','Haber']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_debe_haber,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'debe_haber'
		};

	// txt porcen_calculo
	Atributos[5]={
		validacion:{
			name:'porcen_calculo',
			fieldLabel:'Porcentaje Calculo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PLACA.porcen_calculo',
		save_as:'porcen_calculo'
	};
 	
	Atributos[6]= {
		validacion:{
			name:'campo_doc',
			fieldLabel:'Columna Documento',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:250
		},
		tipo: 'TextField',
	 	form: true,
		save_as:'campo_doc'
	};
	
	Atributos[7]= {
		validacion:{
			name:'sw_porcentaje',
			fieldLabel:'SW Porcentaje',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Si'],['2','No']]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_sw_porcentaje,
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' placa.sw_porcentaje',
		save_as:'sw_porcentaje'
	};
		
	Atributos[8]= {
		validacion:{
			name:'sw_retencion',
			fieldLabel:'SW Retencion',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Si'],['2','No']]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_sw_retencion,
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' placa.sw_retencion',
		save_as:'sw_retencion'
	};
	
	Atributos[9]= {
		validacion:{
			name:'sw_contabilizacion',
			fieldLabel:'SW Contabilizacion',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_sw_contabilizacion,
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' placa.sw_contabilizacion',
		save_as:'sw_contabilizacion'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Ejercicios de Calculo (Maestro)',titulo_detalle:'plantilla_calculo (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_plantilla_calculo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_plantilla_calculo.init(config);
		
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_plantilla_calculo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};

	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/plantilla_calculo/ActionEliminarPlantillaCalculo.php',parametros:'&m_id_plantilla='+maestro.id_plantilla},
		Save:{url:direccion+'../../../control/plantilla_calculo/ActionGuardarPlantillaCalculo.php',parametros:'&m_id_plantilla='+maestro.id_plantilla},
		ConfirmSave:{url:direccion+'../../../control/plantilla_calculo/ActionGuardarPlantillaCalculo.php',parametros:'&m_id_plantilla='+maestro.id_plantilla},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'plantilla_calculo'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_plantilla=datos.m_id_plantilla;
		maestro.desc_plantilla=datos.m_desc_plantilla;
		maestro.tipo_plantilla=datos.m_tipo_plantilla;
		
		gestion.setValue('');
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_plantilla:maestro.id_plantilla,
				m_id_gestion:-1
			}
		};
		
		this.btnActualizar();
		data_maestro=[['Plantilla',maestro.desc_plantilla]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_plantilla;

		paramFunciones.btnEliminar.parametros='&m_id_plantilla='+maestro.id_plantilla;
		paramFunciones.Save.parametros='&m_id_plantilla='+maestro.id_plantilla;
		paramFunciones.ConfirmSave.parametros='&m_id_plantilla='+maestro.id_plantilla;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		cmpTipoCuenta=getComponente('tipo_cuenta');
	    cmpEjercicio=getComponente('id_ejercicio');
	    
	    var onTipoCuentaSelect=function(e){
			var id=cmpTipoCuenta.getValue()
			if(id==1){
				CM_ocultarComponente(cmpEjercicio);
				cmpEjercicio.setValue('');
				cmpEjercicio.allowBlank=true
			}
			else{
				cmpEjercicio.enable();
				CM_mostrarComponente(cmpEjercicio);
				cmpEjercicio.setValue('');
				cmpEjercicio.allowBlank=false
			}
		};
	    cmpTipoCuenta.on('select',onTipoCuentaSelect);
	    cmpTipoCuenta.on('change',onTipoCuentaSelect); 
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
	
	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();
		ds_cuenta_ejercicio.baseParams={m_sw_cuenta_ejercicio:'si',m_id_gestion:g_id_gestion, m_tipo_plantilla:maestro.tipo_plantilla};
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_plantilla:maestro.id_plantilla,
				m_id_gestion:g_id_gestion
			}
		});	
		
		ds_cuenta_ejercicio.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina+100,
				CantFiltros:paramConfig.CantFiltros,
				m_sw_cuenta_ejercicio:'si',
				m_id_gestion:g_id_gestion,
				m_tipo_plantilla:maestro.tipo_plantilla
			}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_plantilla_calculo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_plantilla:maestro.id_plantilla,
			m_id_gestion:g_id_gestion
		}
	});*/
	
	//para agregar botones
	this.AdicionarBotonCombo(gestion,'gestion');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_plantilla_calculo.getLayout().addListener('layout',this.onResize);
	layout_plantilla_calculo.getVentana(idContenedor).on('resize',function(){layout_plantilla_calculo.getLayout().layout()})
}