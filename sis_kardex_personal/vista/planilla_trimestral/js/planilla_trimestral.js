/**
 * Nombre:		  	    pagina_planilla_trimestral.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2010-08-23 11:07:47
 */
function pagina_planilla_trimestral(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var marcas_html,div_dlgFrm,dlgFrm,FechaDesde,FechaHasta;
	var txt_fecha_desde,txt_fecha_hasta,txt_id_planilla_trimestral, t_gestion,t_dia, t_periodo,txt_fecha_planilla_trimestral;
	var tipo='';
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/planilla_trimestral/ActionListarPlanillaTrimestral.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_planilla_trimestral',totalRecords:'TotalCount'
		},[		
		'id_planilla_trimestral',
		'id_tipo_planilla_trimestral',
		'desc_tipo_planilla_trimestral',
		'id_periodo',
		'desc_periodo',
		'id_usuario',
		'usuario',
		'id_moneda',
		'desc_moneda',
		'numero',
		'estado',
		'observaciones',
		'fecha_reg',
		'codigo_depto',
		{name: 'fecha_planilla_trimestral',type:'date',dateFormat:'Y-m-d'},
		'gestion',
		'id_gestion',
		'periodo_lite', 'fk_id_planilla_trimestral', 'estado_anticipo','recalcular','estado_obligacion'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
	
    var ds_tipo_planilla_trimestral = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_planilla_trimestral/ActionListarTipoPlanilla.php?basica=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_planilla_trimestral',totalRecords: 'TotalCount'},['id_tipo_planilla_trimestral','nombre','descripcion','estado_reg','fecha_reg','id_usuario','id_depto','codigo_depto'])
	});

    var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
    		baseParams:{id_gestion:0},
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_final','estado_peri_gral','periodo_lite'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER

    function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}','</div>');
	
	function render_id_tipo_planilla_trimestral(value, p, record){return String.format('{0}', record.data['desc_tipo_planilla_trimestral']);}
	var tpl_id_tipo_planilla_trimestral=new Ext.Template('<div class="search-item">','<b>{codigo_depto}</b><br>','{nombre}<br>','<FONT COLOR="#2F4F4F"><i>{descripcion}</i></FONT>','</div>'); 
	
	function render_id_periodo(value, p, record){return String.format('{0}', record.data['periodo_lite']);}
	var tpl_id_periodo=new Ext.Template('<div class="search-item">','{periodo} - {periodo_lite}','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','{simbolo} - {nombre}','</div>');
		
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['usuario']);}

	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_planilla_trimestral
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_planilla_trimestral',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	// txt id_tipo_planilla_trimestral
	Atributos[1]={
			validacion:{
			name:'id_tipo_planilla_trimestral',
			fieldLabel:'Tipo Planilla',
			allowBlank:false,			
			emptyText:'tipo planilla_trimestral...',
			desc: 'desc_tipo_planilla_trimestral', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_planilla_trimestral,
			valueField: 'id_tipo_planilla_trimestral',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPPLA.nombre#DEPTO.codigo_depto#TIPPLA.descripcion',
			typeAhead:false,
			tpl:tpl_id_tipo_planilla_trimestral,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_planilla_trimestral,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPPLA.nombre'
		
	};
	
	// txt id_moneda
	Atributos[2]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:150,
			grid_indice:1	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERIOD.gestion'
		
	};
// txt id_periodo
	Atributos[3]={
			validacion:{
			name:'id_periodo',
			fieldLabel:'Periodo',
			allowBlank:false,			
			emptyText:'periodo...',
			desc: 'periodo_lite', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo,
			valueField: 'id_periodo',
			displayField: 'periodo_lite',
			queryParam: 'filterValue_0',
			filterCol:'PERIOD.periodo',
			typeAhead:false,
			tpl:tpl_id_periodo,
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
			renderer:render_id_periodo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:3	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERIOD.periodo_lite'
		
	};
	// txt id_usuario
	Atributos[4]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			renderer:render_id_usuario,
			grid_indice:9
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'USUARI.login'
		
	};
	// txt id_moneda
	Atributos[5]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#MONEDA.simbolo',
			typeAhead:true,
			tpl:tpl_id_moneda,
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
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:'100%',
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.simbolo'
		
	};
	// txt numero
	Atributos[6]={
		validacion:{
			name:'numero',
			fieldLabel:'Planilla',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:4
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.numero'
		
	};
	// txt estado
	Atributos[7]={
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.estado'
	};
	// txt observaciones
	Atributos[8]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:700,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			grid_indice:8	
		},
		tipo:'TextArea',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.observaciones'
		
	};
// txt fecha_reg
	Atributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Reg.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:10	
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		form:false,		
		filterColValue:'PLANIL.fecha_reg',
	};
	
	Atributos[10]= {
			validacion:{
				name:'fecha_planilla_trimestral',
				fieldLabel:'Fecha',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:78,
				allowBlank:false,
				grid_indice:2
			},
			tipo:'DateField',
			form:true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'PLANIL.fecha_planilla_trimestral',
			dateFormat:'m-d-Y'
		};
	
	Atributos[11]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'Depto.',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:4
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'DEPTO.codigo_depto'
		
	};
	
	Atributos[12]={
		validacion:{
			name:'tipo_a',
			
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		//form: true,
		filtro_0:false,
			
	};

	Atributos[13]={
			validacion: {
			name:'estado_anticipo',
			fieldLabel:'Estado Anticipo',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PLANIL.estado_anticipo'
	};
	
	
	Atributos[14]={
		validacion:{
			labelSeparator:'',
			name:'reporte_planilla_trimestral',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'reporte_planilla_trimestral'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'planilla_trimestral',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'Planilla',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_planilla_trimestral/empleado_planilla_trimestral.php'};
	var layout_planilla_trimestral=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_planilla_trimestral.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_planilla_trimestral,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/planilla_trimestral/ActionEliminarPlanilla.php'},
		Save:{url:direccion+'../../../control/planilla_trimestral/ActionGuardarPlanilla.php'},
		ConfirmSave:{url:direccion+'../../../control/planilla_trimestral/ActionGuardarPlanilla.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'planilla_trimestral'}};
	
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		cmbGestion=getComponente('id_gestion');
		cmbPeriodo=getComponente('id_periodo');
		txt_fecha=getComponente('fecha_planilla_trimestral');
		txt_fecha_desde=getComponente('fecha_planilla_trimestral');
		txt_fecha_planilla_trimestral=getComponente('fecha_planilla_trimestral');
		reporte_planilla_trimestral=getComponente('reporte_planilla_trimestral');
		var filtrar_periodo = function( combo, record, index )
		{		
			//Filtramos los presupuestos segun la gestion seleccionada
			cmbPeriodo.store.baseParams={id_gestion:record.data.id_gestion};
			t_gestion=record.data.gestion;
			cmbPeriodo.modificado=true;			
			cmbPeriodo.setValue('');			
		}
		
		cmbGestion.on('select',filtrar_periodo);
		
		var calendario=function(combo, record, index){
			
			if(record.data.periodo ==1  || record.data.periodo ==3||record.data.periodo ==5||record.data.periodo ==7||record.data.periodo ==8||record.data.periodo ==10||record.data.periodo ==12){
				t_dia=31;
				
				
			}else{
				if(record.data.periodo==2){
					if(t_gestion%4==0){
						t_dia=29;
					}else{
						t_dia=28;
					}
				}else{
					t_dia=30;
				}
			}
			
			if(record.data.periodo<10){
				t_periodo='0'+record.data.periodo;
			}
			else{ 
			    t_periodo=record.data.periodo;
			}
			
			//alert (t_dia+'/'+record.data.periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_planilla_trimestral.setValue('01/'+t_periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_desde.setValue(txt_fecha_planilla_trimestral.getValue().dateFormat('d/m/Y'));
			txt_fecha.minValue=txt_fecha_desde.getValue();
			
			txt_fecha_planilla_trimestral.setValue(t_dia+'/'+t_periodo+'/'+(parseFloat(t_gestion)));
			txt_fecha_desde.setValue(txt_fecha_planilla_trimestral.getValue().dateFormat('d/m/Y'));
			txt_fecha.maxValue=txt_fecha_desde.getValue();
			
			txt_fecha.setValue(txt_fecha.getValue());
			
		}
		
		
		
		cmbPeriodo.on('select', calendario); 
		
	}
	
	this.btnEdit = function(){
		var sm=getSelectionModel();
		
		if(sm.getCount()!=0){
				ds_periodo.baseParams={id_gestion:sm.getSelected().data.id_gestion}
				CM_btnEdit();
			}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	this.EnableSelect=function(sm,row,rec){
		//cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_planilla_trimestral.getIdContentHijo()).pagina.reload(rec.data);
		if(rec.data.desc_tipo_planilla_trimestral=='sueldo'||rec.data.desc_tipo_planilla_trimestral=='aguinaldo' ||rec.data.desc_tipo_planilla_trimestral=='general' ){
			_CP.getPagina(layout_planilla_trimestral.getIdContentHijo()).pagina.desbloquearMenu();
		}else{
			_CP.getPagina(layout_planilla_trimestral.getIdContentHijo()).pagina.bloquearMenu();
		}
		enable(sm, row, rec);
	}
	
	function btn_empleado_planilla_trimestral(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
			data=data+"&vista_doble=si"; 
			data=data+"&estado="+SelectionsRecord.data.estado;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_planilla_trimestral/empleado_planilla_trimestral.php?'+data,'Funcionario - Planilla',ParamVentana);
			layout_planilla_trimestral.getVentana().on('resize',function(){
			layout_planilla_trimestral.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	/*function btn_empleado_planilla_trimestral3(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data="id_planilla_trimestral="+SelectionsRecord.data.id_planilla_trimestral;
			data=data+"&vista_doble=si";
			data=data+"&id_tipo_planilla_trimestral="+SelectionsRecord.data.id_tipo_planilla_trimestral;
			data=data+"&estado="+SelectionsRecord.data.estado;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_planilla_trimestral3/empleado_planilla_trimestral.php?'+data,'Funcionario - Planilla',ParamVentana);
			layout_planilla_trimestral.getVentana().on('resize',function(){
			layout_planilla_trimestral.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}*/
	
		function btn_empleado_planilla_trimestral3(){ 
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data="id_planilla_trimestral="+SelectionsRecord.data.id_planilla_trimestral;
				data=data+"&vista_doble=si";
				data=data+"&id_tipo_planilla_trimestral="+SelectionsRecord.data.id_tipo_planilla_trimestral;
				data=data+"&estado="+SelectionsRecord.data.estado;
				data=data+"&desc_periodo="+SelectionsRecord.data.desc_periodo;
				data=data+"&gestion="+SelectionsRecord.data.gestion;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}}
				layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_planilla_trimestral3/empleado_planilla_trimestral.php?'+data,'Funcionario - Planilla',ParamVentana,'DinaMainPla','false');
				layout_planilla_trimestral.getVentana().on('resize',function(){
				layout_planilla_trimestral.getLayout().layout();
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
     function btn_planilla_trimestral_presupuesto(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			
			if(SelectionsRecord.data.estado_anticipo!='' && SelectionsRecord.data.estado_anticipo!=null && SelectionsRecord.data.estado_anticipo!=undefined && SelectionsRecord.data.estado_anticipo!='pagado'){
				alert('Existen funcionarios con pago de anticipo pendiente. Antes de proceder con el Presupuesto, es necesario el pago correspondiente a la Quincena');
				
			}else{// esta pagado el anticipo o no existe ningun funcionario con anticipo
				
				if(SelectionsRecord.data.estado!='borrador'){
						
					
					var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&id_gestion='+SelectionsRecord.data.id_gestion;
					data=data+"&vista_doble=si";
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/planilla_trimestral_presupuesto/planilla_trimestral_presupuesto.php?'+data,'Funcionario - Planilla',ParamVentana);
					layout_planilla_trimestral.getVentana().on('resize',function(){
					layout_planilla_trimestral.getLayout().layout();
					
					});
				}else{
					alert('Es necesario proceder con la validacion de la planilla_trimestral previamente');
				}
			}
		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

	}
     
     
     function btn_obligacion(){
 		var sm=getSelectionModel();
 		var NumSelect=sm.getCount();
 		if(NumSelect!=0){
 			var SelectionsRecord=sm.getSelected();
 			var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&id_gestion='+SelectionsRecord.data.id_gestion+'&desc_periodo='+SelectionsRecord.data.desc_periodo+'&gestion='+SelectionsRecord.data.gestion;
 			data=data+"&vista_doble=si";
 			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
 			
 			layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/obligacion/obligacion.php?'+data,'Obligaciones por planilla_trimestral',ParamVentana);
 			
 			
 			layout_planilla_trimestral.getVentana().on('resize',function(){
 			layout_planilla_trimestral.getLayout().layout();
 			
 			});

 		}else{var enableSelect=this.EnableSelect;
 			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
 		}

 	}
      
     
	
	

	
		
	function btn_calcular_planilla_trimestral(){
		
		tipo='';
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
				
			
			     var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
				
			     Ext.MessageBox.show({
						title: 'Procesando Planilla...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
						width:150,
						height:200,
						closable:false
					});
			
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/planilla_trimestral/ActionCalcularPlanilla.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
			
		

		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

	}
	
	
	function caluloSuccess(){
		Ext.MessageBox.hide();
		if(tipo=='' || tipo=='anticipo'){
		  alert("Se calculó la planilla_trimestral con exito")	
		}else{
			if(tipo=='validar'){
				alert('Validación de planilla_trimestral exitosa');
			}else{
				if(tipo=='revertir'){
					alert('Reversión de calculo de planilla_trimestral exitosa');
				}else{
					if(tipo=='pago_anticipo'){
						alert('Solicitud de Pago de Anticipo exitosa');
						
					}else{
						alert('Generación de planilla_trimestral exitosa');
					}
				}
			}
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});
		}
	   
		
	}
	function resumen_horarioSuccess(){
			alert('Generación de resumen de marcas exitosa');
			ocultarFrm();
			Ext.MessageBox.hide();						
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});
	}
	function btn_reporte_planilla_trimestral(){ //alert("----");
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					data= data+'&reporte_planilla_trimestral='+reporte_planilla_trimestral.getValue();
					//alert(data);
					
				if(reporte_planilla_trimestral.getValue()=='AUX'){
					window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaSueldoNeto.php?'+data)

				}else
				  {if (reporte_planilla_trimestral.getValue()=='PI')
						window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaImpositivaAreas.php?'+data)
				  else{ if(reporte_planilla_trimestral.getValue()=='PS')
						window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleado.php?'+data)
					  else{if(reporte_planilla_trimestral.getValue()=='quincena')
						window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=ANTICIPO');
					    else{if(reporte_planilla_trimestral.getValue()=='TE')
						 		window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=BONO_TE');
						 	else{if(reporte_planilla_trimestral.getValue()=='TRA')
						 		window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=BONO_TRA');
						 		else{if(reporte_planilla_trimestral.getValue()=='RESUM')
						 			 window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFSumPlanillaEmpleado.php?'+data+'&tipo_reporte=RESUM');
						 			 else{if(reporte_planilla_trimestral.getValue()=='CACSELFIJO')
						 			      window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=AFCOOP');
						 			      else{if(reporte_planilla_trimestral.getValue()=='CACSELPORCEN')
						 			           window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data+'&tipo_reporte=APCOOP');
						 			           else{
						 			             window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&tipo_reporte=BONO_ROPA');	
						 			           }
						 			      }
						 			 }
						        }
					         }
				         }
				     }
				 }
		    }
		}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
					
				/*if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='auxiliar'){
					window.open(direccion+'../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaSueldoNeto.php?'+data)

				}else{if (SelectionsRecord.data.desc_tipo_planilla_trimestral=='impositiva'){
					
					
						window.open(direccion+'../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaImpositiva.php?'+data)
				
					}else{
					
					window.open(direccion+'../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleado.php?'+data)
					}
				}
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}*/
			}
			
			function btn_obligacion_afp(){ //alert("----");
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					data= data+'&reporte_planilla_trimestral='+reporte_planilla_trimestral.getValue();
					//alert(data);
					
				
					window.open(direccion+'../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosAFPs.php?'+data)

				}
			}
			

			function btn_obligacion_afp_excel(){ //alert("----");
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					data= data+'&reporte_planilla_trimestral='+reporte_planilla_trimestral.getValue();
					data=data+'&reporte_excel=si'
					//alert(data);
					
				
					window.open(direccion+'../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosAFPs.php?'+data)

				}
			}
			
	function generar_planilla_trimestral(t)	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
			data=data+'&tipo='+t;
			
			if(SelectionsRecord.data.recalcular=='si'&&t!='revertir'){
				
				 alert("Es necesario recalcular la planilla_trimestral, debido a que se modificó el resumen de marcas asociados a uno o mas funcionarios");
			}else{
					if(t=='validar' || t=='revertir'||t=='gen_obligacion'){
						var texto_msj='';
						if(t=='validar'){
							texto_msj='Está seguro de Validar los Calculos de la Planilla?';
						}else{
							if(t=='revertir')
							    texto_msj='Está seguro de Revertir los Calculos de la Planilla?';
							else
								texto_msj='Está seguro de generar las Obligaciones de la Planilla?';
							
						}
							Ext.MessageBox.confirm("Atención",texto_msj,function(btn){
								 if(btn=='yes'){
									Ext.MessageBox.show({
										title: 'Procesando Planilla...',
										msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
										width:150,
										height:200,
										closable:false
									});
									
									Ext.Ajax.request({
										url:direccion+"../../../../sis_kardex_personal/control/planilla_trimestral/ActionCalcularPlanilla.php?"+data,
										success:caluloSuccess,
										failure:ClaseMadre_conexionFailure,
										timeout:paramConfig.TiempoEspera
									});
		
								}
							});
					}else{
						if(t=='cbte_costo' && SelectionsRecord.data.estado_obligacion=='calculado'){
						    alert('Es necesario calcular el total de obligaciones para generar el Comprobante de Costos');	
						}else{
							Ext.MessageBox.show({
										title: 'Procesando Planilla...',
										msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando Planilla...</div>",
										width:150,
										height:200,
										closable:false
									});
							
							Ext.Ajax.request({
								url:direccion+"../../../../sis_kardex_personal/control/planilla_trimestral/ActionCalcularPlanilla.php?"+data,
								success:caluloSuccess,
								failure:ClaseMadre_conexionFailure,
								timeout:paramConfig.TiempoEspera
							})
						}
					}
			}
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_resumen_horario(){					   
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			txt_id_planilla_trimestral=SelectionsRecord.data.id_planilla_trimestral;
		   dlgFrm.show()
		   }
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}													   									 
	}
	function ProcesarResumenHorario(){
		
			var txt_fecha_desde=FechaDesde.getValue();
		    var txt_fecha_hasta=FechaHasta.getValue();
			var data='id_planilla_trimestral='+txt_id_planilla_trimestral;
			data=data+'&txt_fecha_desde='+txt_fecha_desde.dateFormat('m/d/Y');
			data=data+'&txt_fecha_hasta='+txt_fecha_hasta.dateFormat('m/d/Y');
			
			Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCargaResumenMarcas.php?"+data,
						success:resumen_horarioSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
		
	}
	function crearDialogFechas(){
		marcas_html="<div class='x-dlg-hd'>"+'Rango de Fechas'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:70 // label settings here cascade unless overridden
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:70,
			width:250,
			height:170,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm.addButton('Procesar',ProcesarResumenHorario);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		//creación de componentes
		FechaDesde=new Ext.form.DateField({
			name:'fecha_desde',
			fieldLabel:'Fecha Desde',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		FechaHasta=new Ext.form.DateField({
			name:'fecha_hasta',
			fieldLabel:'Fecha Hasta',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		
		Formulario.fieldset({legend:'Procesar Resúmen'},FechaDesde,FechaHasta);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	function btn_resumen_marcas(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&m_nombre_completo='+SelectionsRecord.data.nombre_completo;
			data=data+"&vista_doble=si";
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_planilla_trimestral.loadWindows(direccion+'../../../../sis_kardex_personal/vista/resumen_horario_mes/resumen_horario_mes.php?'+data,'Resumen Horarios',ParamVentana);
			layout_planilla_trimestral.getVentana().on('resize',function(){
			layout_planilla_trimestral.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un funcionario');
		}

	}
	function btn_planilla_trimestral_neto(){
		tipo='neto';
		generar_planilla_trimestral(tipo);
	}
		
	function btn_planilla_trimestral_impositiva(){
			tipo='impositiva';
			generar_planilla_trimestral(tipo);
	}

	function btn_clon_planilla_trimestral(){
		//tipo='clon';
		var id_padre;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			id_padre=SelectionsRecord.data.id_planilla_trimestral;
		}else{
			alert('Es necesario seleccionar una planilla_trimestral base');
		}
		CM_btnNew();
		getComponente('tipo_a').setValue('clon');
		getComponente('id_planilla_trimestral').setValue(id_padre);
	}
	
		function btn_boleta_pago(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					window.open(direccion+'../../../control/planilla_trimestral/ActionPDFBoletaPago.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function btn_boleta_pagoSF(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					window.open(direccion+'../../../control/planilla_trimestral/ActionPDFBoletaPagoSF.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function btn_reporte_planilla_trimestral_uo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
				if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='sueldo'){
					
					window.open(direccion+'../../../control/planilla_trimestral/ActionPDFSumPlanillaEmpleado.php?'+data)

				   }
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
		function btn_cbte_costo_planilla_trimestral(){
				tipo='cbte_costo';
				generar_planilla_trimestral(tipo);
		}
			
			
		function btn_validar_cal(){
				tipo='validar';
				generar_planilla_trimestral(tipo);
		}
	
		function btn_revertir_cal(){
				tipo='revertir';
				generar_planilla_trimestral(tipo);
		}
		
		function btn_anticipo(){
			tipo='anticipo';
			generar_planilla_trimestral(tipo);
		}
		
		
		function btn_pago_anticipo(){
			tipo='pago_anticipo';
			generar_planilla_trimestral(tipo);
		}
		
		
		function btn_rev_anticipo(){
			tipo='rev_anticipo';
			generar_planilla_trimestral(tipo);
		}
		
		
		
		function btn_gen_obligacion(){
			tipo='gen_obligacion';
			generar_planilla_trimestral(tipo);
		}
		
		function btn_reporte_anticipo(){
			reporte_planilla_trimestral.setValue('quincena');
			btn_reporte_planilla_trimestral();
		}
		
		
		function btn_reporte_abono_anticipo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&tipo_reporte=DESQUIN';
					
				/*if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='sueldo'){
					

				   }*/
				//window.open(direccion+'../../../control/planilla_trimestral/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/ActionPDFPlanillaEmpleadoBonos.php?'+data);
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		
		
		function btn_rep_abonos(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral+'&tipo=LIQPAG';
				/*if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla_trimestral/ActionPDFPlanillaEmpleadoCuentaB.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
		function btn_resumen_costos(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					data=data+'&gestion='+SelectionsRecord.data.gestion;
					data=data+'&mes='+SelectionsRecord.data.periodo_lite;
					data=data+'&planilla_trimestral='+SelectionsRecord.data.numero;
				/*if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla_trimestral/ActionPDFResumenCostos.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_resumen_costos_dis(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					data=data+'&gestion='+SelectionsRecord.data.gestion;
					data=data+'&mes='+SelectionsRecord.data.periodo_lite;
					data=data+'&planilla_trimestral='+SelectionsRecord.data.numero;
					data=data+'&fecha_planilla_trimestral='+SelectionsRecord.data.fecha_planilla_trimestral.dateFormat('m/d/Y');
					
				/*if(SelectionsRecord.data.desc_tipo_planilla_trimestral=='sueldo'){
					

				   }*/
				window.open(direccion+'../../../control/planilla_trimestral/ActionPDFResumenCostosDis.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	//para que los hijos puedan ajustarse al tamaï¿½o
var nombre='';
			function btn_archivo_pago(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla_trimestral='+SelectionsRecord.data.id_planilla_trimestral;
					var data=data+'&codigo=SUELDO';
					var data=data+'&monto=7000';
					nombre='davinci_'+SelectionsRecord.data.desc_periodo+'-'+SelectionsRecord.data.gestion+'.txt';
					var data=data+'&nombre='+nombre;
					Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla_trimestral/ActionGenerarDavinci.php?"+data,
						success:successGenerar,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			}
			}
			
	function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla_trimestral/archivos/davinci/'+nombre);
	}
	
	this.getLayout=function(){return layout_planilla_trimestral.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	//this.AdicionarBoton('../../../lib/imagenes/user_otro.png','Empleados de Planilla',btn_empleado_planilla_trimestral,true,'empleado_planilla_trimestral','');
	
	//this.AdicionarBoton('../../../lib/imagenes/user_otro.png','Empleados de Planilla',btn_empleado_planilla_trimestral3,true,'empleado_planilla_trimestral','');
	this.AdicionarMenuBotonSimple({text:'Empleados', 
		                           nombre:'cálculos',
		                           icon:'../../../lib/imagenes/user_otro.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Registro Lista',
		                        	       nombre:'empleado_planilla_trimestral',
		                        	       handler:btn_empleado_planilla_trimestral,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	       },
		                        	       {text:'Registro Matriz',
			                        	       nombre:'empleado_planilla_trimestral',
			                        	       handler:btn_empleado_planilla_trimestral3,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
		                             
	this.AdicionarMenuBotonSimple({text:'Anticipos', 
		                           nombre:'Anticipos',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Calcular Anticipo',
		                        	       nombre:'anticipo',
		                        	       handler:btn_anticipo,
		                        	       icon:'../../../lib/imagenes/script_gear.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Habilitar Anticipo',
			                        	       nombre:'pago_anticipo',
			                        	       handler:btn_pago_anticipo,
			                        	       icon:'../../../lib/imagenes/ok.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Revertir Anticipo',
			                        	       nombre:'rev_anticipo',
			                        	       handler:btn_rev_anticipo,
			                        	       icon:'../../../lib/imagenes/cross.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	     {text:'Reporte Anticipo',
			                        	       nombre:'rep_anticipo',
			                        	       handler:btn_reporte_anticipo,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Reporte Abono Anticipo',
			                        	       nombre:'rep_abono_anticipo',
			                        	       handler:btn_reporte_abono_anticipo,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
			                        	    
		                        	   ] 
		                             });
	/*this.AdicionarBoton('../../../lib/imagenes/script_gear.png','Anticipo',btn_anticipo,true,'anticipo','Calcular Anticipo');
    this.AdicionarBoton('../../../lib/imagenes/ok.png','Habilitar para Anticipo',btn_pago_anticipo,true,'pago_anticipo','Habilitar para Anticipo');
    
    this.AdicionarBoton('../../../lib/imagenes/cross.gif','Rev. Anticipo',btn_rev_anticipo,true,'rev_anticipo','Revertir Anticipo');
    */
   
	this.AdicionarMenuBotonSimple({text:'Cálculo Planilla', 
		                           nombre:'Cálculo Planilla',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Calcular Planilla',
		                        	       nombre:'cal_planilla_trimestral',
		                        	       handler:btn_calcular_planilla_trimestral,
		                        	       icon:'../../../lib/imagenes/det.ico',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Validar Cálculo',
			                        	       nombre:'validar_cal',
			                        	       handler:btn_validar_cal,
			                        	       icon:'../../../lib/imagenes/book_next.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Revertir Calculo',
			                        	       nombre:'revertir_cal',
			                        	       handler:btn_revertir_cal,
			                        	       icon:'../../../lib/imagenes/book_previous.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
    
	//this.AdicionarBoton('../../../lib/imagenes/det.ico','Calcular planilla_trimestral',btn_calcular_planilla_trimestral,true,'cal_planilla_trimestral','');
	
	
	//this.AdicionarBoton('../../../lib/imagenes/book_next.png','Validar',btn_validar_cal,true,'validar_cal','');
	//this.AdicionarBoton('../../../lib/imagenes/book_previous.png','Revertir Calculo',btn_revertir_cal,true,'revertir_cal','');
	this.AdicionarBoton('../../../lib/imagenes/procsim.png','Presupuesto',btn_planilla_trimestral_presupuesto,true,'planilla_trimestral_presupuesto','Presupuesto');
	//this.AdicionarBoton('../../../lib/imagenes/report.png','Obligacion',btn_obligacion,true,'obligacion','Obligaciones');
	//this.AdicionarBoton('../../../lib/imagenes/report.png','Obligacion',btn_obligacion,true,'obligacion','');
	
	
	this.AdicionarMenuBotonSimple({text:'Obligaciones', 
		                           nombre:'Obligaciones',
		                           icon:'../../../lib/imagenes/report.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Generar Obligaciones',
		                        	       nombre:'gen_obligacion',
		                        	       handler:btn_gen_obligacion,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Detalle de Obligaciones',
			                        	       nombre:'obligacion',
			                        	       handler:btn_obligacion,
			                        	       icon:'../../../lib/imagenes/report.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Detalle AFP',
			                        	       nombre:'obligacion_afp',
			                        	       handler:btn_obligacion_afp,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Detalle AFP EXCEL',
			                        	       nombre:'obligacion_afp',
			                        	       handler:btn_obligacion_afp_excel,
			                        	       icon:'../../../lib/imagenes/excel_16x16.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
	
	
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de Planilla',btn_reporte_planilla_trimestral,true,'ver_reporte_planilla_trimestral','Reporte Planilla');
	//this.AdicionarBoton('../../../lib/imagenes/detalle.png','Planilla Sueldo Neto',btn_planilla_trimestral_neto,true,'planilla_trimestral_neto','');
	//this.AdicionarBoton('../../../lib/imagenes/detalle.png','Planilla Impositiva',btn_planilla_trimestral_impositiva,true,'planilla_trimestral_impositiva','');
	this.AdicionarMenuBotonSimple({text:'Resumen Horario', 
		                           nombre:'Resumen Horas',
		                           icon:'../../../lib/imagenes/copy.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Generar Resumen de Marcas',
		                        	       nombre:'resumen_horario',
		                        	       handler:btn_resumen_horario,
		                        	       icon:'../../../lib/imagenes/copy.png',
		                        	      // cls:'x-btn-text-icon'
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Resumen de Marcas',
			                        	       nombre:'resumen_marcas',
			                        	       handler:btn_resumen_marcas,
			                        	       icon:'../../../lib/imagenes/copy.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },
			                        	    {text:'Generar Cbte. Costo/Planilla',
			                        	       nombre:'costo_planilla_trimestral',
			                        	       handler:btn_cbte_costo_planilla_trimestral,
			                        	       icon:'../../../lib/imagenes/ok.png',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
		                             
		                             
		 
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Resumen UO',btn_reporte_planilla_trimestral_uo,true,'ver_reporte_planilla_trimestral_uo','Reporte Resumen Planilla');
	
  //  this.AdicionarBoton('../../../lib/imagenes/copy.png','Generar Resumen de Marcas',btn_resumen_horario,true,'resumen_horario','');		
    //this.AdicionarBoton('../../../lib/imagenes/copy.png','Resumen de Marcas',btn_resumen_marcas,true,'resumen_marcas','');		
    
    
    var sw_reporte_planilla_trimestral = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_planilla_trimestral',fields:['ID','valor','filtro'],
                                              data:[['PS','Planilla de Sueldos'],['PI','Planilla Impositiva'],['AUX','Planilla Sueldo Neto'],
                                              ['RESUM','Resumen de Planilla'],
                                              ['TE','Asig. Te'],['ROPA','Asig. Ropa'],['TRA','Asig. Transporte'],['ABONO','Abono en Cuentas'],['PAGO','Boleta de Pago'],['PAGOSF','Boleta Pago S/F'],['RESU','Costos x Centros'],['RESUDIS','Costos x Distritos'],['CACSELFIJO','Aporte Fijo CACSEL'],['CACSELPORCEN','Aporte % CACSEL']]}),
                                              typeAhead: false,
                                              mode: 'local',
                                              triggerAction: 'all',
                                              emptyText:'Reporte...',
                                              selectOnFocus:true,
                                              width:120,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});	
   sw_reporte_planilla_trimestral.on('select',function (combo, record, index)
                                     {  
                                     	//alert (sw_reporte_planilla_trimestral.getValue());
                                     	if(sw_reporte_planilla_trimestral.getValue()=='ABONO'){
                                     		btn_rep_abonos();
                                     	}else{
                                     		if(sw_reporte_planilla_trimestral.getValue()=='PAGO')
                                     		   btn_boleta_pago();
                                     		 else{
                                     		 	if(sw_reporte_planilla_trimestral.getValue()=='PAGOSF')
                                     		 	 btn_boleta_pagoSF();
                                     		 	 else{
                                     		        if(sw_reporte_planilla_trimestral.getValue()=='RESU')
                                     		           btn_resumen_costos();
                                     		     	else{
                                     		     		if(sw_reporte_planilla_trimestral.getValue()=='RESUDIS')
                                     		     		  btn_resumen_costos_dis();
                                     		     		else{   
                                     			         reporte_planilla_trimestral.setValue(sw_reporte_planilla_trimestral.getValue());
                                     	        		 btn_reporte_planilla_trimestral();
                                     		     		}
                                     		     	}
                                     		 	 }
                                     		 }
                                      	   
                                     	}
                                     	//alert (reporte_planilla_trimestral.getValue());
                                     }
                          );
    
                          
                          
                          
                          
    
    
    this.AdicionarBotonCombo(sw_reporte_planilla_trimestral,'Reporte Planilla');
    
    this.AdicionarBoton('../../../lib/imagenes/copy.png','Clonar Planilla',btn_clon_planilla_trimestral,true,'clon_planilla_trimestral','Clonar Planilla');
    //this.AdicionarBoton('../../../lib/imagenes/print.gif','Abonos Empleados',btn_rep_abonos,true,'rep_planilla_trimestral','');
    /*	 this.AdicionarMenuBotonSimple({text:'Reportes', 
		                           nombre:'Reportes',
		                           icon:'../../../lib/imagenes/print.gif',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[
		                        	       /*{text:'Reporte Resumen UO',
			                        	       nombre:'ver_reporte_planilla_trimestral_uo',
			                        	       handler:btn_reporte_planilla_trimestral_uo,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    },*/
			                        	   /* {text:'Boleta de Pago',
			                        	       nombre:'boleta_pago',
			                        	       handler:btn_boleta_pago,
			                        	       icon:'../../../lib/imagenes/print.gif',
			                        	       // cls:'x-btn-text-icon'
			                        	        cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });*/
    //this.AdicionarBoton('../../../lib/imagenes/print.gif','Boleta de Pago',btn_boleta_pago,true,'boleta_pago','');
      
    this.AdicionarBoton('../../../lib/imagenes/copy.png','Archivo Davinci',btn_archivo_pago,true,'archivo_pago','Archivo Davinci');
    
   var CM_getBoton=this.getBoton;
   
   
   
	function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
				   CM_getBoton('clon_planilla_trimestral-'+idContenedor).disable();
				   CM_getBoton('resumen_horario-'+idContenedor).disable();
				   CM_getBoton('resumen_marcas-'+idContenedor).disable();
				
				if(record.estado=='borrador'){
				   	   CM_getBoton('validar_cal-'+idContenedor).enable();
				   	   CM_getBoton('revertir_cal-'+idContenedor).disable();
				   	   CM_getBoton('cal_planilla_trimestral-'+idContenedor).enable();
				   	 
				   	   
				   	   if(record.estado_anticipo==null || record.estado_anticipo==undefined || record.estado_anticipo=='' || record.estado_anticipo=='pagado'){
				   	   	   CM_getBoton('anticipo-'+idContenedor).disable();
				   	   	   CM_getBoton('pago_anticipo-'+idContenedor).disable();
				   	   }else{
				   	   	   
				   	   		if(record.estado_anticipo=='calculado'){
				   	   			CM_getBoton('pago_anticipo-'+idContenedor).enable();
				   	   			CM_getBoton('anticipo-'+idContenedor).enable();
				   	   			 CM_getBoton('rev_anticipo-'+idContenedor).disable();
				   	   		}else{
				   	   			CM_getBoton('pago_anticipo-'+idContenedor).disable();
				   	   			CM_getBoton('anticipo-'+idContenedor).disable();
				   	   			CM_getBoton('rev_anticipo-'+idContenedor).enable();
				   	   		}
				   	    }
				   	   
				}else{
					if(record.estado=='calculado'){
						CM_getBoton('revertir_cal-'+idContenedor).enable();
					}else{
						CM_getBoton('revertir_cal-'+idContenedor).disable();
					}
					  
					  CM_getBoton('validar_cal-'+idContenedor).disable();
				   	  CM_getBoton('cal_planilla_trimestral-'+idContenedor).disable();
				   	  CM_getBoton('anticipo-'+idContenedor).disable();
				   	  CM_getBoton('pago_anticipo-'+idContenedor).disable();
				   	  CM_getBoton('rev_anticipo-'+idContenedor).disable();
				}
				   
				   
				if(record.desc_tipo_planilla_trimestral=='sueldo'||record.desc_tipo_planilla_trimestral=='general'){
					// CM_getBoton('planilla_trimestral_neto-'+idContenedor).enable();
					 //CM_getBoton('planilla_trimestral_impositiva-'+idContenedor).disable();
					 CM_getBoton('empleado_planilla_trimestral-'+idContenedor).enable();
					// CM_getBoton('boleta_pago-'+idContenedor).enable();
					 CM_getBoton('clon_planilla_trimestral-'+idContenedor).disable();
					 CM_getBoton('obligacion-'+idContenedor).enable();
					 CM_getBoton('resumen_horario-'+idContenedor).enable();
					 CM_getBoton('resumen_marcas-'+idContenedor).enable();
				}
				
				if(record.desc_tipo_planilla_trimestral=='auxiliar'){ // es del sueldo neto, para generar la impositiva
					 //CM_getBoton('planilla_trimestral_neto-'+idContenedor).disable();
					// CM_getBoton('planilla_trimestral_impositiva-'+idContenedor).enable();
					// CM_getBoton('boleta_pago-'+idContenedor).disable();
					 CM_getBoton('obligacion-'+idContenedor).disable();
					 CM_getBoton('rev_anticipo-'+idContenedor).disable();
					 CM_getBoton('resumen_horario-'+idContenedor).disable();
					 CM_getBoton('resumen_marcas-'+idContenedor).disable();
				
				}
				
				 
				if(record.desc_tipo_planilla_trimestral=='impositiva'|| record.desc_tipo_planilla_trimestral=='sueldo' || record.desc_tipo_planilla_trimestral=='general'){ // es del sueldo neto, para generar la impositiva
					// CM_getBoton('planilla_trimestral_neto-'+idContenedor).disable();
					// CM_getBoton('planilla_trimestral_impositiva-'+idContenedor).disable();
					// CM_getBoton('boleta_pago-'+idContenedor).disable();
					// CM_getBoton('obligacion-'+idContenedor).disable();
					// CM_getBoton('rev_anticipo-'+idContenedor).disable();
					// CM_getBoton('resumen_horario-'+idContenedor).disable();
					 //CM_getBoton('resumen_marcas-'+idContenedor).disable();
				
					 
					 if(record.estado!='borrador' && record.estado!='pendiente' && record.estado!='anulado'){
					 	CM_getBoton('clon_planilla_trimestral-'+idContenedor).enable();
					 }else{
					 	CM_getBoton('clon_planilla_trimestral-'+idContenedor).disable();
					 }
				}
				
				
				if(record.desc_tipo_planilla_trimestral=='aguinaldo'){ 
					 CM_getBoton('resumen_marcas-'+idContenedor).disable();
					 CM_getBoton('resumen_horario-'+idContenedor).disable();
					 CM_getBoton('rev_anticipo-'+idContenedor).disable();
					// CM_getBoton('planilla_trimestral_neto-'+idContenedor).disable();
				}
				  
		}
	}

	this.iniciaFormulario();
	crearDialogFechas();
	iniciarEventosFormularios();
	layout_planilla_trimestral.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}