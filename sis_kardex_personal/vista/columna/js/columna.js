/**
 * Nombre:		  	    pagina_columna.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creacón:		2010-08-19 10:28:40
 */
function pagina_columna(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0, k_gestion;
	var cmbTipoColumna;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/columna/ActionListarColumna.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_columna',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_columna',
		'id_tipo_planilla',
		'desc_tipo_planilla',
		'id_columna_tipo',
		'desc_tipo_columna',
		'formula',
		'valor_defecto',
		'estado_reg',
		'fecha_reg',
		'id_usuario',
		'usuario',
		'def_tipo_columna',
		'formula_original','codigo','en_reporte','orden_reporte','total',
		'orden_ejecucion',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	/*function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_tipo_planilla',maestro.id_tipo_planilla],['Nombre',maestro.nombre],['Descripciï¿½n',maestro.descripcion]];*/
	
	//DATA STORE COMBOS

    var ds_tipo_planilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_planilla/ActionListarTipoPlanilla.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_planilla',totalRecords: 'TotalCount'},['id_tipo_planilla','nombre','descripcion','estado_reg','fecha_reg','id_usuario'])
	});

    var ds_tipo_columna = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_columna/ActionListarColumnaTipo.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_columna_tipo',totalRecords: 'TotalCount'},['id_columna_tipo','id_parametro_kardex','id_partida','nombre','valor','tipo_dato','id_moneda','tipo_aporte','estado_reg','fecha_reg','cotizable','descripcion','descontar','observacion','incremento','formula','codigo'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','apellido_paterno','apellido_materno','nombre','apellido_paterno','apellido_materno','nombre'])
	});

	//FUNCIONES RENDER
	//ENDE-0001: 27/08/2012: adicion en renderer de id_parametro_kardex y <br> antes de la adicion
		function render_id_columna_tipo(value, p, record){return String.format('{0}', record.data['desc_tipo_columna']);}
		var tpl_id_columna_tipo=new Ext.Template('<div class="search-item">','<b>{nombre}</b><br>','<FONT COLOR="#B5A642">Definición: {tipo_dato}</FONT><br>','<FONT COLOR="#B5A642">Fórmula: {formula}</FONT><br>','<FONT COLOR="#B5A642">Constante:{valor}</FONT><br>','<FONT COLOR="#B5A642"><b>--Identificador: {id_parametro_kardex}--</b></FONT>','</div>');

		function render_id_usuario(value, p, record){return String.format('{0}',record.data['usuario'])};

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_columna',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_tipo_planilla
	Atributos[1]={
		validacion:{
			name:'id_tipo_planilla',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
	
	Atributos[10]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:1
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.codigo'
	};
// txt id_columna_tipo
	Atributos[2]={
			validacion:{
			name:'id_columna_tipo',
			fieldLabel:'Tipo Columna',
			allowBlank:true,			
			emptyText:'Tipo Columna...',
			desc: 'desc_tipo_columna', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_columna,
			valueField: 'id_columna_tipo',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'COLTIP.id_columna_tipo#COLTIP.nombre#COLTIP.codigo',
			typeAhead:true,
			tpl:tpl_id_columna_tipo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_columna_tipo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLTIP.id_columna_tipo#COLTIP.nombre#COLTIP.codigo'
	};
	
	Atributos[3]={
			validacion:{
			name:'def_tipo_columna',
			fieldLabel:'Definición',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7,
			disabled:true
		},
		tipo:'Field',
		form: true,
		filtro_0:false
	};
// txt formula
	Atributos[4]={
		validacion:{
			name:'formula',
			fieldLabel:'Fórmula',
			allowBlank:true,
			
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:3		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.formula'
	};
// txt valor_defecto
	Atributos[5]={
		validacion:{
			name:'valor_defecto',
			fieldLabel:'Valor por Defecto',
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
			width:'100%',
			disabled:true,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.valor_defecto'
	};
// txt estado_reg
	Atributos[6]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.estado_reg',
		defecto:'activo'
	};
// txt fecha_reg
	Atributos[7]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'COLUMNA.fecha_reg',
	};
// txt id_usuario
	Atributos[8]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7,
			renderer:render_id_usuario
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'USUARI.login'
	};
	
	Atributos[9]={
			validacion:{
			name:'formula_original',
			fieldLabel:'Fórmula Original',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7,
			disabled:true
		},
		tipo:'Field',
		form: false,
		filtro_0:false
	};
	
	Atributos[10]={
			validacion: {
			name:'en_reporte',
			fieldLabel:'En Reporte',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']
			,['PS','Planilla de Sueldos'],['PN','Planilla Sueldo Neto'],['PI','Planilla Impositiva'],
			['PS,PN','Planilla Sueldos y Neto'],
			['PS,PI','Planilla Sueldos e Impositiva'],
			['PN,PI','Planilla Neto e Impositiva'],
			['PS,PN,PI','Todas'],
			['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.en_reporte',
		defecto:'si'
	};
	
	Atributos[11]={
		validacion:{
			name:'orden_reporte',
			fieldLabel:'Orden en Reporte',
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
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.orden_reporte'
	};
	
	Atributos[12]={
			validacion: {
			name:'total',
			fieldLabel:'Es Total',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.total',
		defecto:'no'
	};

	
	Atributos[13]={
		validacion:{
			name:'orden_ejecucion',
			fieldLabel:'Orden Ejecución',
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
			width_grid:100,
			width:'100%',
			disabled:false
			
				
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.orden_ejecucion'
	};
	
	Atributos[14]={
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COLUMNA.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	/*var config={titulo_maestro:'Tipo Planilla (Maestro)',titulo_detalle:'columna (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_columna = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_columna.init(config);*/
	
	var layout_columna = new DocsLayoutMaestro(idContenedor);
	layout_columna.init({titulo_maestro:'Tipo Planilla (Maestro)',titulo_detalle:'Columnas (Detalle)',grid_maestro:'grid-'+idContenedor});
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_columna,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var dialog= this.getFormulario;
	var EstehtmlMaestro=this.htmlMaestro;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false},excel:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/columna/ActionEliminarColumna.php'},
	Save:{url:direccion+'../../../control/columna/ActionGuardarColumna.php'},
	ConfirmSave:{url:direccion+'../../../control/columna/ActionGuardarColumna.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Columnas'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	
	this.reload=function(m){
		maestro=m;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_tipo_planilla:maestro.id_tipo_planilla
			}
		};
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_tipo_planilla;
		paramFunciones.btnEliminar.parametros='&id_tipo_planilla='+maestro.id_tipo_planilla;
		paramFunciones.Save.parametros='&id_tipo_planilla='+maestro.id_tipo_planilla;
		paramFunciones.ConfirmSave.parametros='&id_tipo_planilla='+maestro.id_tipo_planilla;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		cmbTipoColumna=getComponente('id_columna_tipo');
		txtDefTipoCol=getComponente('def_tipo_columna');
		txtFormula=getComponente('formula');
		txtValorDefecto=getComponente('valor_defecto');
		txtEnReporte=getComponente('en_reporte');
		txtOrden=getComponente('orden_reporte');
		txtOrden.disable();
		var onTipoColSelect=function(e){
			
			if(e.value!=''){
				var rec=cmbTipoColumna.store.getById(cmbTipoColumna.getValue());
				
				//Carga el field con la definición del tipo de columna escogida
				txtDefTipoCol.setValue(rec.data['tipo_dato']);
				
				//Habilita y deshabilita controles según corresponda y carga el valor
				if(rec.data['tipo_dato']=='basico'){
					txtFormula.disable();
					txtFormula.setValue('');
					txtFormula.allowBlank=true;
					txtValorDefecto.disable();
					txtValorDefecto.setValue('');
					txtValorDefecto.allowBlank=true;
					
				}
				if(rec.data['tipo_dato']=='constante'){
					txtFormula.disable();
					txtFormula.setValue('');
					txtFormula.allowBlank=true;
					txtValorDefecto.enable();
					txtValorDefecto.setValue(rec.data['valor']);
					txtValorDefecto.allowBlank=false;
				}
				if(rec.data['tipo_dato']=='formula'){
					txtFormula.enable();
					txtFormula.setValue(rec.data['formula']);
					txtFormula.allowBlank=false;
					txtValorDefecto.disable();
					txtValorDefecto.setValue('');
					txtValorDefecto.allowBlank=true;
				}
//				if(rec.data['codigo']!='' && rec.data['codigo']!=undefined){
//				getComponente('codigo').setValue(rec.data['codigo']);	
//				}
				
			}

		};
		
		cmbTipoColumna.on('change',onTipoColSelect);
		cmbTipoColumna.on('select',onTipoColSelect);
		
		var enReporte=function(e){
			if(e.value=='si'){
				txtOrden.enable();
			}else{
				txtOrden.disable();
			}
		}
		
		
		txtEnReporte.on('select',enReporte);
	}
	
	this.btnNew=function(){
		//Deshabilita los controles
		txtFormula.disable();
		txtValorDefecto.disable();
		
		//Llamada a la función de la clase base
		CM_btnNew();
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			//Habilita y deshabilita el control en función de la definición de la consulta
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.def_tipo_columna=='basico'){
				txtFormula.disable();
				txtValorDefecto.disable();
			}
			if(SelectionsRecord.data.def_tipo_columna=='constante'){
				txtFormula.disable();
				txtValorDefecto.enable();
			}
			if(SelectionsRecord.data.def_tipo_columna=='formula'){
				txtFormula.enable();
				txtValorDefecto.disable();
			}
			
			
			if(SelectionsRecord.data.en_reporte=='no'){
				txtOrden.disable();
			}else{
				txtOrden.enable();
			}
			CM_btnEdit();
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_columna.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	
	/*var ds_col_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	   		var tpl_gestion_col=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
			var col_gestion =new Ext.form.ComboBox({
					store:ds_col_gestion,
					displayField:'gestion',
					typeAhead:true,
					mode:'remote',
					triggerAction:'all',
					emptyText:'gestion...',
					selectOnFocus:true,
					width:100,
					valueField:'id_gestion',
					tpl:tpl_gestion_col
				});
  
				
				col_gestion.on('select',function (combo, record, index){mi_gestion=mi_gestion.getRawValue();
				ds.load({
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							m_id_gestion:mi_gestion
							
							
						}
					});	
				   });
							
			this.AdicionarBotonCombo(col_gestion,'gestion');++++*/
			
			
			
						var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	   		var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
			var k_gestion =new Ext.form.ComboBox({
					store:ds_cmb_gestion,
					displayField:'gestion',
					typeAhead:true,
					mode:'remote',
					triggerAction:'all',
					emptyText:'gestion...',
					selectOnFocus:true,
					width:100,
					valueField:'id_gestion',
					tpl:tpl_gestion_cmb
				});
  
				
				k_gestion.on('select',function (combo, record, index){kp_gestion=k_gestion.getRawValue();
				ds.load({
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							m_id_gestion:k_gestion.getValue(),id_tipo_planilla:maestro.id_tipo_planilla
							
							
						}
					});	
				   });
	this.AdicionarBotonCombo(k_gestion,'gestion');
	layout_columna.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}