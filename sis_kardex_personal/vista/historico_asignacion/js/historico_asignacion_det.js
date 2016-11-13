/**
 * Nombre:		  	    pagina_tipo_unidad_cons_reemp_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio
 * Fecha creación:		2007-11-07 
 */
function pagina_historico_asignacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var vectorAtributos=new Array;
	var ds,ds_empleado;
	var elementos=new Array();
	var componentes=new Array();
	var combo_empleado,txt_fecha_asignacion,txt_estado,txt_fecha_finalizacion;
	var sw=0;
	var correo=0, id_emp_sel=0, estado_fun='', id_has; //1 para enviar correo
	//  DATA STORE //
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/historico_asignacion/ActionListarHistoricoAsignacion.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_historico_asignacion',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_historico_asignacion',
		{name:'fecha_asignacion',type:'date',dateFormat:'Y-m-d'},
		'estado',
		'id_unidad_organizacional',
		'id_empleado',
		{name:'fecha_finalizacion',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_registro',type:'date',dateFormat:'Y-m-d'},
	    'nombre_unidad',
	    'nombre_cargo',
	    'id_persona',
	    'desc_persona',
	    'id_empleado_suplente',
	    'suplente','id_lugar','desc_lugar'
	    
	    ,'usuario_reg','usuario_mod','fecha_ultima_mod'
	    //19.05.2014
	    ,'id_cargo','id_tipo_contrato','desc_cargo','desc_tipo_contrato','tipo_registro'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_unidad_organizacional:maestro.id_unidad_organizacional
		}
	});	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
	{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}
	]);	
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'
	}
	function italic(value){
		return '<i>'+value+'</i>'
	}	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['ID',maestro.id_unidad_organizacional],['Unidad',maestro.nombre_unidad],['Cargo',maestro.nombre_cargo]]}),cm:cmMaestro});
	gridMaestro.render();		
	
	//DATA STORE COMBOS	
	ds_empleado=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({
				record:'ROWS',
				id:'id_empleado',
				totalRecords:'TotalCount'
			},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
		});	
	var resultTpl=new Ext.Template(
		'<div class="search-item">',
		'<b><i>{desc_persona}</i></b>',
		'<b><br>{nombre_tipo_documento}:<i>{doc_id}</i></b>',
		'<br><FONT COLOR="#B5A642">{email1}</FONT>',
		'</div>'
		);	
		
		
		
	ds_empleado_suplente=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado/ActionListarEmpleado.php?filtro=1'}),
			reader:new Ext.data.XmlReader({
				record:'ROWS',
				id:'id_empleado',
				totalRecords:'TotalCount'
			},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
		});	
	var resultTplSuplente=new Ext.Template(
		'<div class="search-item">',
		'<b><i>{desc_persona}</i></b>',
		'<b><br>{nombre_tipo_documento}:<i>{doc_id}</i></b>',
		'<br><FONT COLOR="#B5A642">{email1}</FONT>',
		'</div>'
		);	
	
	ds_lugar=new Ext.data.Store({
			proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php?sw_municipio=si'}),
			reader:new Ext.data.XmlReader({
				record:'ROWS',
				id:'id_lugar',
				totalRecords:'TotalCount'
			},['id_lugar','codigo','nombre'])
		});	
	var tplLugar=new Ext.Template(
		'<div class="search-item">',
		'<b><i>{nombre}</i></b>',
		'</div>'
		);	
	//19.05.2014
	ds_cargo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cargo/ActionListarCargo.php?asignado=no'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_cargo',
			totalRecords:'TotalCount'
		},['id_cargo','codigo_cargo','nombre_cargo','numero_item','tipo_item'])
	});	
	
	var tplCargo=new Ext.Template(
			'<div class="search-item">',
			'N° Item:{numero_item}',
			'<b><i><br>{nombre_cargo}</i></b>',
			'</div>'
			);	

	ds_tipo_contrato=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_contrato/ActionListarTipoContrato.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_contrato',
			totalRecords:'TotalCount'
		},['id_tipo_contrato','codigo','nombre'])
	});	
	
	function render_cargo(value,p,record){return String.format('{0}',record.data['desc_cargo'])};
	function render_tipo_contrato(value,p,record){return String.format('{0}',record.data['desc_tipo_contrato'])};	
	//FUNCIONES RENDER
	function render_empleado(value,p,record){return String.format('{0}',record.data['desc_persona'])};
	function render_empleado_suplente(value,p,record){return String.format('{0}',record.data['suplente'])};
	function render_lugar(value,p,record){return String.format('{0}',record.data['desc_lugar'])};
	
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_historico_asignacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_historico_asignacion'
	};
	// txt id_tipo_unidad_constructiva_reemplazo
	vectorAtributos[1]={
		validacion:{
				fieldLabel:'Funcionario',
				allowBlank:false,
				emptyText:'Funcionario...',
				name:'id_empleado',
				desc:'desc_persona',
				store:ds_empleado,
				valueField:'id_empleado',
				displayField:'desc_persona',
				queryParam:'filterValue_0',
				filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				tpl:resultTpl,
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:false,
				resizable:true,
				minChars:1,
				triggerAction:'all',
				confTrigguer:{
					url:direccion+'../../../../sis_kardex_personal/vista/empleado/empleado.php',
				    paramTri:'prueba:XXX',		
				    title:'Personas',
				    param:{width:800,height:800},
				    idContenedor:idContenedor,
				   //
				},
				editable:true,
				renderer:render_empleado,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:230 // ancho de columna en el gris
			},
			tipo:'ComboTrigger',
			filtro_1:true,
			filtro_0:true,
			filterColValue:'PERSON.apellido_paterno#PERSON.nombre#PERSON.apellido_materno',
			save_as:'txt_id_empleado'
	};		
	
	
	vectorAtributos[2]={
			validacion:{
					fieldLabel:'Lugar',
					allowBlank:false,
					emptyText:'Lugar...',
					name:'id_lugar',
					desc:'desc_lugar',
					store:ds_lugar,
					valueField:'id_lugar',
					displayField:'nombre',
					queryParam:'filterValue_0',
					filterCol:'LUGARR.nombre',
					tpl:tplLugar,
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:450,
					grow:false,
					resizable:true,
					minChars:1,
					triggerAction:'all',
					editable:true,
					renderer:render_lugar,
					grid_visible:true,
					grid_editable:false,
					width:200,
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				save_as:'id_lugar'
		};	
	
	vectorAtributos[3]={
			validacion:{
					fieldLabel:'Cargo',
					allowBlank:true,
					emptyText:'Cargo...',
					name:'id_cargo',
					desc:'desc_cargo',
					store:ds_cargo,
					valueField:'id_cargo',
					displayField:'nombre_cargo',
					queryParam:'filterValue_0',
					filterCol:'CARGO.nombre_cargo',
					tpl:tplCargo,
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:450,
					grow:false,
					resizable:true,
					confTrigguer:{
						url:direccion+'../../../../sis_kardex_personal/vista/cargo/cargo.php',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   //
					},
					minChars:1,
					triggerAction:'all',
					editable:true,
					renderer:render_cargo,
					grid_visible:true,
					grid_editable:false,
					width:200,
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboTrigger',
				filtro_0:true,
				filtro_1:true,
				save_as:'id_cargo'
		};
	
	///////// fecha_asignacion /////////
	vectorAtributos[4]={
		validacion:{
			name:'fecha_asignacion',
			fieldLabel:'Fecha de Asignación',
			allowBlank:false,
			format:'d-m-Y',
			minValue:'01-01-1900',
			renderer:formatDate,
			grid_visible:true,
			grid_editable:false,
			width_grid:115,
			disabled:false
		},
		tipo:'DateField',
		save_as:'txt_fecha_asignacion',
		dateFormat:'m-d-Y',
		defecto:""
	};
	/////////// txt estado //////
    vectorAtributos[5]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			vtype:'texto',
			emptyText:'Estado...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['activo'],['inactivo'],['suplente'],['interino']]}),
			valueField:'valor',
			displayField:'valor',
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:100,
			width_grid:80
		},
		tipo:'ComboBox',
		defecto:"",
		save_as:'txt_estado'
	};
  vectorAtributos[6]={
		validacion:{
			name:'id_unidad_organizacional',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_unidad_organizacional,
		save_as:'id_unidad_organizacional'
	};
	///////// fecha_finalizacion /////////
	vectorAtributos[7]={
		validacion:{
			name:'fecha_finalizacion',
			fieldLabel:'Fecha de Finalización',
			allowBlank:true,
			format:'d-m-Y',
			minValue:'01-01-1900',
			renderer:formatDate,
			grid_visible:true,
			grid_editable:false,
			width_grid:115,
			disabled:false
		},
		tipo:'DateField',
		save_as:'txt_fecha_finalizacion',
		dateFormat:'m-d-Y',
		defecto:""
	};	
	
	
	vectorAtributos[8]={
		validacion:{
				fieldLabel:'Suplente',
				allowBlank:true,
				emptyText:'Suplente...',
				name:'id_empleado_suplente',
				desc:'suplente',
				store:ds_empleado_suplente,
				valueField:'id_empleado',
				displayField:'desc_persona',
				queryParam:'filterValue_0',
				filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				tpl:resultTpl,
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:false,
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_empleado_suplente,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:230 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			form:false,
			filtro_1:true,
			save_as:'txt_id_empleado_suplente'
	};	
	
	
	
		
	
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Usr. Registro',
			name:'usuario_reg',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		form:false,
		save_as:'usuario_reg'
	};
	
	
	
	vectorAtributos[10]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Usr. Modificación',
			name:'usuario_mod',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		form:false,
		save_as:'usuario_mod'
	};
	
	
	
	vectorAtributos[11]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Fecha Modificación',
				name:'fecha_ultima_mod',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			form:false,
			save_as:'fecha_ultima_mod'
		};
		
		
		
		vectorAtributos[12]={
				validacion:{
					name:'tipo_registro',
					fieldLabel:'Tipo Registro',
					allowBlank:false,
					typeAhead:true,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['nuevo','Nuevo'],['modificacion','Modificacion']]}),
					valueField:'ID',
					displayField:'valor',
					maxLength:30,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					width:100,
					forceSelection:true,
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filterColValue:'CARGO.tipo_registro',
				save_as:'tipo_registro'
			};
	
	//----------- FUNCIONES RENDER-----------//	
	function formatDate(value){return value ? value.dateFormat('d-m-Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE-----------//
	var config={
		titulo_maestro:'Unidad Organizacional (Maestro)',
		titulo_detalle:'Funcionarios Asignados (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_historico_asignacion=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_historico_asignacion.init(config);		
	//---------- INICIAMOS HERENCIA------------//
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_historico_asignacion,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_Save=this.Save;
	var cm_success=this.saveSuccess;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ------------//	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};	
	//--------- DEFINICIÓN DE FUNCIONES------------------//
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/historico_asignacion/ActionEliminarHistoricoAsignacion.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional},
		Save:{url:direccion+'../../../control/historico_asignacion/ActionGuardarHistoricoAsignacion.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional,success:esteSuccess},
		ConfirmSave:{url:direccion+'../../../control/historico_asignacion/ActionGuardarHistoricoAsignacionZZZ.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'380',height:'250',closable:true,titulo:'Asignación de Funcionarios'}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_padre=datos.maestro_id_padre;
		maestro.id_unidad_organizacional=datos.maestro_id_unidad_organizacional;
		maestro.nombre_cargo=datos.maestro_nombre_cargo;
		maestro.nombre_unidad=datos.maestro_nombre_unidad;
		maestro.cargo_individual=datos.maestro_cargo_individual;
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['ID',maestro.id_unidad_organizacional],['Unidad',maestro.nombre_unidad],['Cargo',maestro.nombre_cargo]]);
		vectorAtributos[6].defecto=maestro.id_unidad_organizacional;
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/historico_asignacion/ActionEliminarHistoricoAsignacion.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional},
		Save:{url:direccion+'../../../control/historico_asignacion/ActionGuardarHistoricoAsignacionXXX.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional,success:esteSuccess},
		ConfirmSave:{url:direccion+'../../../control/historico_asignacion/ActionGuardarHistoricoAsignacionAAA.php',parametros:'&id_unidad_organizacional='+maestro.id_unidad_organizacional},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'380',height:'200',closable:true,titulo:'Asignación de Funcionarios'}
	};
	this.InitFunciones(paramFunciones)
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_unidad_organizacional:maestro.id_unidad_organizacional
			}
		};
		this.btnActualizar()
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		combo_empleado=ClaseMadre_getComponente ('id_empleado');
		txt_fecha_asignacion=ClaseMadre_getComponente ('fecha_asignacion');
        txt_estado=ClaseMadre_getComponente ('estado');
        txt_fecha_finalizacion=ClaseMadre_getComponente ('fecha_finalizacion');
        //combo_empleado_suplente=ClaseMadre_getComponente ('id_empleado_suplente');
        ds_empleado_suplente.baseParams={filtro:1};
        CM_ocultarComponente(ClaseMadre_getComponente ('tipo_registro'));
        var onSuplente= function(e){
        	if(e.value=='suplente'){
        		CM_ocultarComponente(txt_fecha_finalizacion);
        		txt_fecha_finalizacion.allowBlank=true;
        		CM_ocultarComponente(ClaseMadre_getComponente ('tipo_registro'));
        		ClaseMadre_getComponente ('tipo_registro').setValue('modificacion');
        		//combo_empleado_suplente.allowBlank=false;
        	}else{
        		if(e.value=='inactivo'){
        		    estado_fun='baja';	
        		    CM_mostrarComponente(txt_fecha_finalizacion);
        		    txt_fecha_finalizacion.allowBlank=false;
        		    ClaseMadre_getComponente('fecha_finalizacion').allowBlank=false;
        		    CM_ocultarComponente(ClaseMadre_getComponente ('tipo_registro'));
        		    ClaseMadre_getComponente ('tipo_registro').setValue('modificacion');
        		}else{
        			CM_mostrarComponente(ClaseMadre_getComponente ('tipo_registro'));
        			//	estado_fun='modificacion a alta';
        			CM_ocultarComponente(txt_fecha_finalizacion);
        			txt_fecha_finalizacion.allowBlank=true;
        			//combo_empleado_suplente.allowBlank=true;
        			//combo_empleado_suplente.reset();
        			ClaseMadre_getComponente('fecha_finalizacion').allowBlank=true;
        			ClaseMadre_getComponente('fecha_finalizacion').reset();
        			ClaseMadre_getComponente ('tipo_registro').setValue('');
        		}
        	}
        }
        
        
        txt_estado.on ('select', onSuplente);
		txt_estado.on ('change', onSuplente);
		
		
		
		var onEmp=function(e){
			id_emp_sel=e.value;
			
		}
		
		combo_empleado.on('select',onEmp);
		combo_empleado.on('change',onEmp);
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_finalizacion);
		txt_fecha_finalizacion.allowBlank=true;
		correo=1;
		combo_empleado.enable();
		txt_estado.enable();
		id_has=null;
		estado_fun='alta';
		ClaseMadre_btnNew()
	//CM_Save();
	};
	this.btnEdit=function(){
		//CM_ocultarComponente(txt_fecha_finalizacion);
		//CM_ocultarComponente(txt_fecha_asignacion);
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		var estado=txt_estado.getValue();
		if(SelectionsRecord.data.estado=='no asignado'){
			combo_empleado.enable();
			txt_estado.enable()
		}
		if(SelectionsRecord.data.estado=='activo' || SelectionsRecord.data.estado=='inactivo'){
			combo_empleado.disable();
			txt_estado.enable()
		}
	
		if(SelectionsRecord.data.estado=='suplente'){
			CM_mostrarComponente(combo_empleado_suplente);
			combo_empleado_suplente.enable();
			combo_empleado_suplente.allowBlank=false;
		}
		id_emp_sel=SelectionsRecord.data.id_empleado;
		
		correo=1;
		id_has=SelectionsRecord.data.id_historico_asignacion;
		//estado_fun='modificacion';
		if(SelectionsRecord.data.estado=='inactivo'){
			estado_fun='baja';
			
		}else{
			estado_fun='modificacion';
		}
		
		ClaseMadre_btnEdit()
		//CM_Save();
	};
	
	
	function esteSuccess(resp, x){
		
					if(correo==1){
						
						correo=0;
							var sm=getSelectionModel();
							var NumSelect=sm.getCount();
							var SelectionsRecord=sm.getSelected();
					
							/*if(NumSelect==1){
								Ext.MessageBox.show({
										title: 'Procesando',
										msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Enviando Correos...</div>",
										width:300,
										height:200,
										closable:false
									});
							*/
								Ext.Ajax.request({
									url:direccion+"../../../control/empleado/ActionEnviaCorreo.php",
									method:'POST',
									params:{id_empleado:id_emp_sel, estado:estado_fun, id_ha:id_has},
									success:function(){Ext.MessageBox.hide();},
									failure:ClaseMadre_conexionFailure,
									timeout:100000000
								});
							//}
					}
					
					cm_success(resp,x);
					/*if(vista!='detalle'&& vista!='detalle_externo'){
						var sm=getSelectionModel();
						var NumSelect=sm.getCount();
						if(NumSelect==1){
							_CP.getPagina(layout_correspondencia.getIdContentHijo()).pagina.btnActualizar();
						}
						
					}*/			
		
	}
	
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_historico_asignacion.getLayout()
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
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_historico_asignacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)	
}