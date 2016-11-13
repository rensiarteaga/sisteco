/**
 * Nombre:		  	    pagina_resumen_horario_mes.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		11-08-2010
 */
function pagina_resumen_horario_mes(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	var txt_id_empleado_planilla_f,txt_horas_normales,txt_horas_extra,txt_horas_nocturnas,txt_horas_disp;
	var ds_empleado_planilla;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/resumen_horario_mes/ActionListarResumenHorarioMes.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_resumen_horario_mes',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_resumen_horario_mes',
		'id_empleado_planilla',
		'usuario_reg',
		'horas_disp',
		'horas_normales',
		'horas_extra',
		'horas_nocturnas',		
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		'nombre_completo',
		'id_empleado',
		'id_gestion',
		'parametrizado',
		'id_planilla',
		'horas_normales_efectivas',
		'costo_horas_normales_efectivas',
		'costo_horas_extra',
		'costo_horas_nocturnas',
		'costo_horas_disp'
		]),remoteSort:true});
	//carga datos XM
	// DEFINICIÓN DATOS DEL MAESTRO
	ds_empleado_planilla=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/resumen_horario_mes/ActionListarEmpleadoPlanillaNuevo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_planilla',totalRecords:'TotalCount'},['id_empleado_planilla','id_empleado','nombre_completo','id_planilla']),
			baseParams:{m_id_planilla:maestro.id_planilla}
	});
    /*var dataMaestro=[['Id Funcionario Planilla',maestro.id_empleado_planilla],['Funcionario',maestro.nombre_completo]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);*/
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	/*var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();*/
	//DATA STORE COMBOS
	
	function render_estado_reg(value){
		if(value=='finalizado'){
			value='Finalizado'
		}
		else{ 
			if(value=='validado'){
				value='Validado'
			}
		    else{
		    	if(value=='borrador'){
		    		value='Borrador'
		    	}
		        else{
		        	if(value=='factor_calculado'){
		        		value='Factor Calculado'
		        	}
		        	else{
		        	    value='Prorrateo Columnas'	
		        	}
		        	
		        }
		    }
		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_resumen_horario_mes',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		save_as:'hidden_id_resumen_horario_mes',
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado_planilla',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado_planilla'
	};
	vectorAtributos[2]={
					validacion:{
					name:'id_empleado_planilla_f',
					fieldLabel:'Funcionario',
					allowBlank:true,			
					emptyText:'Funcionario...',
					store:ds_empleado_planilla,
					valueField:'id_empleado_planilla',
					displayField:'nombre_completo',
					filterCol:'EMPLEA.nombre_completo',
					/*filterCols:filterCols_empleado_planilla,
			        filterValues:filterValues_empleado_planilla,*/
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:15,
					minListWidth:350,
					grow:true,
					width:'100%',
					resizable:true,
					queryParam:'filterValue_0',
					minChars:2, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					grid_visible:false,
					grid_editable:false
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:false,
				save_as:'hidden_id_empleado_planilla_f'
			};
		vectorAtributos[3]={
		validacion:{
			name:'usuario_reg',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'usuario_reg'
	};
	vectorAtributos[4]={
		validacion:{
			name:'nombre_completo',
			fieldLabel:'Funcionario',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			disabled:true
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'EMPLEA.nombre_completo',
		save_as:'nombre_completo'
	};
	vectorAtributos[5]={
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'RESHORMES.estado_reg',
		save_as:'txt_estado_reg'
		};
		vectorAtributos[6]={
			validacion:{
				name:'horas_normales',
				fieldLabel:'Horas Normales',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:100,
				width:'40%'
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.horas_normales',
			save_as:'horas_normales'
		};
		vectorAtributos[7]={
			validacion:{
				name:'horas_normales_efectivas',
				fieldLabel:'Horas Normales Efectivas',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				width:'40%'
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.horas_normales_efectivas',
			save_as:'horas_normales_efectivas'
		};
		vectorAtributos[8]={
			validacion:{
				name:'costo_horas_normales_efectivas',
				fieldLabel:'Costo Horas Normales',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:150,
				width:'40%'
			},
			form:false,
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.costo_horas_normales_efectivas',
			save_as:'costo_horas_normales_efectivas'
		};
		vectorAtributos[9]={
			validacion:{
				name:'horas_extra',
				fieldLabel:'Horas Extra',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:100,
				width:'40%'
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.horas_extra',
			save_as:'horas_extra'
		};
		vectorAtributos[10]={
			validacion:{
				name:'costo_horas_extra',
				fieldLabel:'Costo Horas Extra',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:120,
				width:'40%'
			},
			form:false,
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.costo_horas_extra',
			save_as:'costo_horas_extra'
		};
		vectorAtributos[11]={
			validacion:{
				name:'horas_nocturnas',
				fieldLabel:'Horas Nocturnas',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:100,
				width:'40%'
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.horas_nocturnas',
			save_as:'horas_nocturnas'
		};
		vectorAtributos[12]={
			validacion:{
				name:'costo_horas_nocturnas',
				fieldLabel:'Costo Horas Nocturnas',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:150,
				width:'40%'
			},
			form:false,
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.costo_horas_nocturnas',
			save_as:'costo_horas_nocturnas'
		};
			vectorAtributos[13]={
			validacion:{
				name:'horas_disp',
				fieldLabel:'Dias Disp.',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:100,
				width:'40%'
			},
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.horas_disp',
			save_as:'horas_disp'
		};
		vectorAtributos[14]={
			validacion:{
				name:'costo_horas_disp',
				fieldLabel:'Costo Asignación Disp',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:120,
				width:'40%'
			},
			form:false,
			tipo:'NumberField',
			filtro_0:true,
			filterColValue:'RESHORMES.costo_horas_disp',
			save_as:'costo_horas_disp'
		};
// txt fecha_registro
	vectorAtributos[15]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100,
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESHORMES.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};	
		vectorAtributos[16]={
		validacion:{
			name:'parametrizado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		save_as:'parametrizado'
	};
	vectorAtributos[17]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		save_as:'id_empleado'
	};
	vectorAtributos[18]={
		validacion:{
			name:'id_planilla',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_planilla,
		save_as:'hidden_id_planilla'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Resumen Horarios Mes (Maestro)',
	    grid_maestro:'grid-'+idContenedor
		,urlHijo:'../../../sis_kardex_personal/vista/parametro_costo_planilla/parametro_prorrateo_horas.php'
	};
	layout_resumen_horario_mes=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout_resumen_horario_mes.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_resumen_horario_mes,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CMenableSelect=this.EnableSelect;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/resumen_horario_mes/ActionEliminarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	Save:{url:direccion+'../../../control/resumen_horario_mes/ActionGuardarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	ConfirmSave:{url:direccion+'../../../control/resumen_horario_mes/ActionGuardarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Resumen Horarios'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_planilla=datos.m_id_planilla;
		maestro.nombre_completo=datos.m_nombre_completo;
	    vectorAtributos[18].defecto=maestro.id_planilla;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/resumen_horario_mes/ActionEliminarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	   Save:{url:direccion+'../../../control/resumen_horario_mes/ActionGuardarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	  ConfirmSave:{url:direccion+'../../../control/resumen_horario_mes/ActionGuardarResumenHorarioMes.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Resumen Horarios'}};
		ds_empleado_planilla.baseParams={m_id_planilla:maestro.id_planilla};
	   this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_planilla:maestro.id_planilla
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		txt_horas_normales=getComponente('horas_normales_efectivas');
		txt_horas_extra=getComponente('horas_extra');
		txt_horas_nocturnas=getComponente('horas_nocturnas');
		txt_horas_disp=getComponente('horas_disp');
		txt_id_empleado_planilla_f=getComponente('id_empleado_planilla_f')
	}
this.btnEdit=function(){
	   mostrarComponente(txt_horas_normales);
	   mostrarComponente(txt_horas_extra);
	   mostrarComponente(txt_horas_nocturnas);
	   mostrarComponente(txt_horas_disp);
	ocultarComponente(txt_id_empleado_planilla_f);
	ClaseMadre_btnEdit()
	};
	this.btnNew=function(){
	   ocultarComponente(txt_horas_normales);
	   ocultarComponente(txt_horas_extra);
	   ocultarComponente(txt_horas_nocturnas);
	   ocultarComponente(txt_horas_disp);
	   mostrarComponente(txt_id_empleado_planilla_f);
	   ClaseMadre_btnNew()
	};
	function btn_prorratea(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla;
			        data=data+'&horas_normales='+SelectionsRecord.data.horas_normales_efectivas;
			        data=data+'&horas_extra='+SelectionsRecord.data.horas_extra;
			        data=data+'&horas_disp='+SelectionsRecord.data.horas_disp;
			        data=data+'&horas_nocturnas='+SelectionsRecord.data.horas_nocturnas;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionProrrateaHoras.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_prorratea_todos(){
		
		 var data='id_planilla='+maestro.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionProrrateaHorasTodos.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
	}
	function btn_prorratea_otros(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			    data=data+'&tipo=1';
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionProrrateaOtrosHoras.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
  function btn_prorratea_otros_todos(){
			    var data='id_planilla='+maestro.id_planilla;
			    data=data+'&tipo=2';
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionProrrateaOtrosHoras.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		
	}
function caluloSuccess(){
		
		  alert("El proceso concluyo exitosamente")	
			ClaseMadre_btnActualizar();
	}
	function btn_valida_resumen(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
				 var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&horas_disp='+SelectionsRecord.data.costo_horas_normales_efectivas;
			        data=data+'&horas_normales='+SelectionsRecord.data.horas_normales_efectivas;
			        data=data+'&horas_extra='+SelectionsRecord.data.horas_extra;
			        data=data+'&horas_nocturnas='+SelectionsRecord.data.horas_nocturnas;
			        data=data+'&id_planilla='+SelectionsRecord.data.id_planilla;
				    valida(data);
			    
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_valida_resumen_todos(){
				 var data='id_planilla='+maestro.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionValidaResumenTodos.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
			    
		
	}
	function valida(data){
		
		var filas = ds.getModifiedRecords();//recupera la catidad de modificaciones hechas
		var cont = filas.length;

		if(cont>0){//verifica si existen modificaciones hechas en los registros del grid
			//Actualiza los combos remotos
			if(confirm("Tiene registros pendientes sin guardar que se perderan, desea continuar?")){
				ds.rejectChanges()//vacia el vector de records modificados
				ds.lastOptions.callback=seleccionaFila;
				ds.load(ds.lastOptions);//actualizar

			}
		}
		else{

			Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionValidaResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});

		}
			
	}
	function btn_corrige_resumen(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&tipo=1';
			        data=data+'&id_planilla='+SelectionsRecord.data.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCorrigeResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_valida_prorrateo(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&tipo=2';
			        data=data+'&id_planilla='+SelectionsRecord.data.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCorrigeResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_valida_prorrateo_todos(){
			    var data='tipo=5';
			        data=data+'&id_planilla='+maestro.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCorrigeResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		
	}
	function btn_corrige_prorrateo(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&tipo=4';
			        data=data+'&id_planilla='+SelectionsRecord.data.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCorrigeResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_corrige_finalizado(){
		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_resumen_horario_mes='+SelectionsRecord.data.id_resumen_horario_mes;
			        data=data+'&tipo=3';
			        data=data+'&id_planilla='+SelectionsRecord.data.id_planilla;
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/resumen_horario_mes/ActionCorrigeResumen.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_resumen_horario_mes.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.EnableSelect=function(sm,row,rec){
				_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm,row,rec);
			}
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarMenuBotonSimple({text:'Validar Resumenes', 
		                           nombre:'ValidarResumenes',
		                           icon:'../../../lib/imagenes/terminar.png',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Validar Resumen de Horarios',
		                        	       nombre:'ValidaResumen',
		                        	       handler:btn_valida_resumen,
		                        	       icon:'../../../lib/imagenes/terminar.png',
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Validar Resúmen de Todos',
			                        	       nombre:'ValidaResumenTodos',
			                        	       handler:btn_valida_resumen_todos,
			                        	       icon:'../../../lib/imagenes/terminar.png',
			                        	       cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
    this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Resumen de Horarios',btn_corrige_resumen,true,'CorrigeResumen','Corregir Resumen de Horarios');		                             
	this.AdicionarMenuBotonSimple({text:'Prorrateo de Costos', 
		                           nombre:'ProrrateaParametrizados',
		                           icon:'../../../lib/imagenes/det.ico',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Prorratear Costos',
		                        	       nombre:'ProrrateaCostos',
		                        	       handler:btn_prorratea,
		                        	       icon:'../../../lib/imagenes/det.ico',
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Prorratea Costos de Todos',
			                        	       nombre:'ProrrateaCostosTodos',
			                        	       handler:btn_prorratea_todos,
			                        	       icon:'../../../lib/imagenes/det.ico',
			                        	       cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });		                             
	this.AdicionarMenuBotonSimple({text:'Validar Prorrateo', 
		                           nombre:'ValidarProrrateos',
		                           icon:'../../../lib/imagenes/terminar.png',
		                           cls:'x-btn-text-icon bmenu', // icon and text class
		                           items:[{text:'Validar Prorrateo',
		                        	       nombre:'ValidaProrrateo',
		                        	       handler:btn_valida_prorrateo,
		                        	       icon:'../../../lib/imagenes/terminar.png',
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Validar Prorrateo de Todos',
			                        	       nombre:'ValidaProrrateoTodos',
			                        	       handler:btn_valida_prorrateo_todos,
			                        	       icon:'../../../lib/imagenes/terminar.png',
			                        	       cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
    this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Prorrateo Costos',btn_corrige_prorrateo,true,'CorrigeProrrateo','Corregir Prorrateo Costos');		                              
	this.AdicionarMenuBotonSimple({text:'Prorratear Columnas', 
		                           nombre:'ProrrateaColumnas',
		                           icon:'../../../lib/imagenes/det.ico',
		                           cls: 'x-btn-text-icon bmenu', // icon and text class
		                           items:[{ text:'Prorratear Columnas',
		                        	       nombre:'ProrrateaOtrosCostos',
		                        	       handler:btn_prorratea_otros,
		                        	       icon:'../../../lib/imagenes/det.ico',
		                        	       cls: 'x-btn-icon',
		                        	      },
		                        	       {text:'Prorratear Columnas de Todos',
			                        	       nombre:'ProrrateaOtrosCostosTodos',
			                        	       handler:btn_prorratea_otros_todos,
			                        	       icon:'../../../lib/imagenes/det.ico',
			                        	       cls: 'x-btn-icon',
			                        	    }
		                        	   ] 
		                             });
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Prorrateo Columnas',btn_corrige_finalizado,true,'CorrigeFinalizado','Corregir Prorrateo Columnas');
	var CM_getBoton=this.getBoton;
	function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){ 
				   if(record.parametrizado==1 && record.estado_reg=='validado'){
				   	   CM_getBoton('ProrrateaCostos-'+idContenedor).enable();
				   	   CM_getBoton('ProrrateaCostosTodos-'+idContenedor).enable();
				   }else{
				   	   CM_getBoton('ProrrateaCostos-'+idContenedor).disable();
				   	   CM_getBoton('ProrrateaCostosTodos-'+idContenedor).disable();
				   }
				   if(record.estado_reg=='borrador'){
				   	CM_getBoton('ValidaResumen-'+idContenedor).enable();
				   	CM_getBoton('ValidaResumenTodos-'+idContenedor).enable();
				   	CM_getBoton('CorrigeResumen-'+idContenedor).disable();				   	
				   	CM_getBoton('ValidaProrrateo-'+idContenedor).disable();
				   	CM_getBoton('ValidaProrrateoTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeProrrateo-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostos-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostosTodos-'+idContenedor).disable();				   	
				   	CM_getBoton('CorrigeFinalizado-'+idContenedor).disable();				   	
				   	_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.bloquearMenu();
				   	CM_getBoton('guardar-'+idContenedor).enable();
		            CM_getBoton('eliminar-'+idContenedor).enable();
	                CM_getBoton('editar-'+idContenedor).enable();
				   }				
				   if(record.estado_reg=='validado'){				   				   
				   	CM_getBoton('ValidaResumen-'+idContenedor).disable();
				   	CM_getBoton('ValidaResumenTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeResumen-'+idContenedor).enable();				   	
				   	CM_getBoton('ValidaProrrateo-'+idContenedor).enable();
				   	CM_getBoton('ValidaProrrateoTodos-'+idContenedor).enable();
				   	CM_getBoton('CorrigeProrrateo-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostos-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostosTodos-'+idContenedor).disable();				   	
				   	CM_getBoton('CorrigeFinalizado-'+idContenedor).disable();
				   	_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.desbloquearMenu();
				   	CM_getBoton('guardar-'+idContenedor).enable();
		            CM_getBoton('eliminar-'+idContenedor).disable();
	                CM_getBoton('editar-'+idContenedor).disable();
				   }				   
				    if(record.estado_reg=='factor_calculado'){
				   	 	
				   	CM_getBoton('ValidaResumen-'+idContenedor).disable();
				   	CM_getBoton('ValidaResumenTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeResumen-'+idContenedor).disable();				   	
				   	CM_getBoton('ValidaProrrateo-'+idContenedor).disable();
				   	CM_getBoton('ValidaProrrateoTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeProrrateo-'+idContenedor).enable();				   	
				   	CM_getBoton('ProrrateaOtrosCostos-'+idContenedor).enable();				   	
				   	CM_getBoton('ProrrateaOtrosCostosTodos-'+idContenedor).enable();				   	
				   	CM_getBoton('CorrigeFinalizado-'+idContenedor).disable();
				   	_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.bloquearMenu();
				   	CM_getBoton('guardar-'+idContenedor).disable();
		            CM_getBoton('eliminar-'+idContenedor).disable();
	                CM_getBoton('editar-'+idContenedor).disable();
				   }
				  
				   if(record.estado_reg=='prorrateo_columnas'){
				   			   	
				   	CM_getBoton('ValidaResumen-'+idContenedor).disable();
				   	CM_getBoton('ValidaResumenTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeResumen-'+idContenedor).disable();				   	
				   	CM_getBoton('ValidaProrrateo-'+idContenedor).disable();
				   	CM_getBoton('ValidaProrrateoTodos-'+idContenedor).disable();
				   	CM_getBoton('CorrigeProrrateo-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostos-'+idContenedor).disable();				   	
				   	CM_getBoton('ProrrateaOtrosCostosTodos-'+idContenedor).disable();				   	
				   	CM_getBoton('CorrigeFinalizado-'+idContenedor).enable();
				   	_CP.getPagina(layout_resumen_horario_mes.getIdContentHijo()).pagina.bloquearMenu();
				   	CM_getBoton('guardar-'+idContenedor).disable();
		            CM_getBoton('eliminar-'+idContenedor).disable();
	                CM_getBoton('editar-'+idContenedor).disable();
				   } 
				}

				CMenableSelect(sel,row,selected);
			}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_planilla:maestro.id_planilla
		}
	});
	layout_resumen_horario_mes.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}