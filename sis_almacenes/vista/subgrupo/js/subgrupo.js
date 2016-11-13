function PaginaSubGrupo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_sub_grupo,combo_supergrupo,combo_grupo,txt_descripcion,txt_nombre,txt_fecha_reg,txt_codigo,h_txt_codigo,h_txt_cod;
	var marcas_html,div_dlgFrm,dlgFrm,uniMed,stockMin,costoEstimado,precioEstimado,txt_uni_med,txt_costo_estimado,txt_precio_estimado,txt_stock_min;
	var elementos=new Array();
	var sw=0;
	var combo_supergrupo,combo_grupo,txt_nombre,txt_descripcion,txt_fecha_reg,txt_codigo;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupoItem.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},
		[{name:'descripcion',type:'string'},
		'id_subgrupo',
		'codigo',
		'nombre',
		'descripcion',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tipo_material',
		'id_grupo',
		'id_supergrupo',
		'desc_material',
		'desc_grupo',
		'desc_supergrupo',
		'nivel_convertido',
		'convertido'
		]),
		remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			registro:paramConfig.registro
		}
	});
	/////DATA STORE COMBOS////////////
	ds_uni_med=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	});
	ds_grupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre','codigo'])
	});
	ds_supergrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre','codigo'])
	});
	ds_material=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_material/ActionListarTipoMaterial.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_material',totalRecords:'TotalCount'},['id_tipo_material','nombre','descripcion'])
	});
	function renderGrupo(value,p,record){return String.format('{0}',record.data['desc_grupo'])}
	function renderSuperGrupo(value,p,record){return String.format('{0}',record.data['desc_supergrupo'])}
	function renderMaterial(value,p,record){return String.format('{0}',record.data['desc_material'])}
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplMat=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_subgrupo',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_subgrupo'
	};

	var filterCols_super_grupo=new Array();
	var filterValues_super_grupo=new Array();
	filterCols_super_grupo[0]='estado_registro';
	filterValues_super_grupo[0]='activo';
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Super Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Super Grupo...',
			name:'id_supergrupo',
			desc:'desc_supergrupo',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'supgru.nombre#supgru.codigo',
			filterCols:filterCols_super_grupo,
			filterValues:filterValues_super_grupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSupGru,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderSuperGrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'supgru.nombre#supgru.codigo',
		save_as:'hidden_id_supergrupo'
	};

	var filterCols_grupo=new Array();
	var filterValues_grupo=new Array();
	filterCols_grupo[0]='supgru.id_supergrupo';
	filterValues_grupo[0]='%';
	filterCols_grupo[1]='g.estado_registro';
	filterValues_grupo[1]='activo';
	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Grupo...',
			name:'id_grupo',
			desc:'desc_grupo',
			store:ds_grupo,
			valueField:'id_grupo',
			displayField:'nombre',
			filterCol:'g.nombre#g.codigo',
			filterCols:filterCols_grupo,
			filterValues:filterValues_grupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderGrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:5
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'g.nombre#g.codigo',
		save_as:'hidden_id_grupo'
	};

	vectorAtributos[3]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:5,
			minLength:1,
			selectOnFocus:true,
			width:50,
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sub.codigo',
		save_as:'txt_codigo'
	};

	vectorAtributos[4]={
		validacion:{
			name:'nombre',
			fieldLabel:'Subgrupo',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'60%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			grid_indice:2
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sub.nombre',
		save_as:'txt_nombre'
	};

	vectorAtributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			width:'70%',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'sub.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[6]={
		validacion:{
			fieldLabel:'Tipo Material',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Material...',
			name:'id_tipo_material',
			desc:'desc_material',
			store:ds_material,
			valueField:'id_tipo_material',
			displayField:'nombre',
			filterCol:'TIPMAT.nombre#TIPMAT.descripcion',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplMat,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderMaterial,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:300,
			grid_indice:6
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'mat.nombre#mat.descripcion',
		save_as:'hidden_id_tipo_material'
	};

	vectorAtributos[7]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'70%',
			grid_visible:true,
			grid_editable:true,
			width_grid:120
			,
			grid_indice:7
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'sub.observaciones',
		save_as:'txt_observaciones'
	};

	vectorAtributos[8]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.subgrupoCombo.estado}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:50,
			width:65,
			grid_indice:8
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'sub.estado_registro',
		save_as:'txt_estado_registro',
		defecto:"activo"
	};

	vectorAtributos[9]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:110,
			disabled:true,
			grid_indice:9
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'sub.fecha_Reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y'
	};
	vectorAtributos[10]={
		validacion:{
			name:'nivel_convertido',
			fieldLabel:'nivel',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			width:'50%',
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			grid_indice:11
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'txt_nivel_convertido',
		defecto:""
	};

	vectorAtributos[11]={
		validacion:{
			name:'convertido',
			fieldLabel:'convertido',
			allowBlank:true,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			width:'50%',
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			grid_indice:12
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'txt_convertido',
		defecto:""
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config={titulo_maestro:"Sub Grupo",grid_maestro:"grid-"+idContenedor};
	layout_sub_grupo=new DocsLayoutMaestro(idContenedor);
	layout_sub_grupo.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_sub_grupo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/subgrupo/ActionEliminarSubGrupo.php"},
		Save:{url:direccion+"../../../control/subgrupo/ActionGuardarSubGrupo.php"},
		ConfirmSave:{url:direccion+"../../../control/subgrupo/ActionGuardarSubGrupo.php"},
		Formulario:{
			guardar:overloadSave,
			html_apply:"dlgInfo"+idContenedor,width:'40%',height:'45%',minWidth:150,minHeight:200,labelWidth:75,closable:true,titulo:'Subgrupo'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function crearDialogItem(){
		 marcas_html="<div class='x-dlg-hd'>"+'Convertir a Item'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		 div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		 var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:150
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:150,
			width:380,
			height:215,
			minWidth:paramFunciones.Formulario.minWidth,
			minHeight:paramFunciones.Formulario.minHeight,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);
		dlgFrm.addButton('Convertir',crearItem);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		uniMed=new Ext.form.ComboBox({
			name:'id_unidad_medida_base',
			fieldLabel:'Unidad de Medida Base',
			allowBlank:false,
			emptyText:'Unidad de Medida...',
			store:ds_uni_med,
			filterCol:'UNMEDB.nombre#UNMEDB.abreviatura',
			queryParam:'filterValue_0',
			valueField:'id_unidad_medida_base',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplUniMed,
			displayField:'nombre',
			triggerAction:'all',
			minChars:1,
			mode:'remote',
			width:'60%'
		});
		stockMin=new Ext.form.NumberField({
			name:'stock_min',
			fieldLabel:'Stock Mínimo',
			allowBlank:true,
			allowDecimals:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:50
		});
		costoEstimado=new Ext.form.NumberField({
			name:'costo_estimado',
			fieldLabel:'Costo Estimado',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:50
		});
		precioEstimado=new Ext.form.NumberField({
			name:'precio_venta_almacen',
			fieldLabel:'Precio Estimado',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:50
		});
		Formulario.fieldset({legend:'Datos de Item'},uniMed,costoEstimado,precioEstimado,stockMin);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	
	function iniciarEventosFormularios(){
		combo_supergrupo=ClaseMadre_getComponente('id_supergrupo');
		combo_grupo=ClaseMadre_getComponente('id_grupo');
		txt_nombre=ClaseMadre_getComponente('nombre');
		txt_descripcion=ClaseMadre_getComponente('descripcion');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_codigo=ClaseMadre_getComponente('codigo');
		txt_convertido=ClaseMadre_getComponente('convertido');
		var onSuperGrupoSelect=function(e){
			var id=combo_supergrupo.getValue()
			combo_grupo.filterValues[0]=id;
			combo_grupo.modificado=true;
			combo_grupo.enable();
			combo_grupo.allowBlank=false;
			combo_grupo.setValue('')
		};
		var CopiarDescrip=function(e){
			if(txt_nombre.getValue()!=''){
				if(txt_descripcion.getValue()==''){
					txt_descripcion.setValue(txt_nombre.getValue())
				}
			}
		};
		combo_supergrupo.on('select',onSuperGrupoSelect);
		combo_supergrupo.on('change',onSuperGrupoSelect);
		txt_nombre.on('blur',CopiarDescrip)
	}
		//boton crear item
	function btnCrearItem(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		if(NumSelect!=0){
			if(txt_convertido.getValue()=='no'){
			dlgFrm.show()
			}
			else{Ext.MessageBox.alert('Estado','El material ya es un Item.')}
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un elemento.')}
	}
	function crearItem(){
		if(txt_convertido.getValue()=='no'){
			var sm=getSelectionModel();
			txt_uni_med=uniMed.getValue();
			txt_costo_estimado=costoEstimado.getValue();
			txt_precio_estimado=precioEstimado.getValue();
			txt_stock_min=stockMin.getValue();
			dlgFrm.hide();
			var SelectionsRecord=sm.getSelected();
			var data="cantidad_ids=1&hidden_id_subgrupo_0="+SelectionsRecord.data.id_subgrupo;
			data=data+"&txt_codigo_0="+SelectionsRecord.data.codigo;
			data=data+"&txt_nombre_0="+SelectionsRecord.data.nombre;
			data=data+"&txt_descripcion_0="+SelectionsRecord.data.descripcion;
			data=data+"&txt_observaciones_0="+SelectionsRecord.data.observaciones;
			data=data+"&txt_estado_registro_0="+SelectionsRecord.data.estado_registro;
			var aux_fecha=new Date(SelectionsRecord.data.fecha_reg);
			data=data+"&txt_fecha_reg_0="+aux_fecha.format('m-d-Y');
			data=data+"&hidden_id_tipo_material_0="+SelectionsRecord.data.id_subgrupo;
			data=data+"&hidden_id_grupo_0="+SelectionsRecord.data.id_grupo;
			data=data+"&hidden_id_supergrupo_0="+SelectionsRecord.data.id_supergrupo;
			data=data+"&txt_nivel_convertido_0="+SelectionsRecord.data.nivel_convertido;
			data=data+"&txt_convertido_0="+SelectionsRecord.data.convertido;
			data=data+"&txt_id_unidad_medida_base_0="+txt_uni_med;
			data=data+"&txt_costo_estimado_0="+txt_costo_estimado;
			data=data+"&txt_precio_estimado_0="+txt_precio_estimado;
			data=data+"&txt_stock_min_0="+txt_stock_min;
			Ext.Ajax.request({url:direccion+"../../../control/subgrupo/ActionCrearItem.php",
			params:data,
			method:'POST',
			failure:ClaseMadre_conexionFailure,
			timeout:100000});
			Ext.MessageBox.alert('Estado','El material fue convertido con éxito');
			ClaseMadre_btnActualizar()
		}else{Ext.MessageBox.alert('Estado','El material ya es un Item.')}
		ClaseMadre_clearSelections()
	}
	
	this.btnNew=function(){
		CM_ocultarComponente(txt_fecha_reg);
		combo_grupo.disable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(txt_fecha_reg);
		h_txt_codigo=txt_codigo.getValue();
		//h_txt_cod=h_txt_codigo.substr(6,3);
		var editar = h_txt_codigo.split('.');
		//alert (editar[0]);
		//txt_codigo.setValue(h_txt_cod);
		txt_codigo.setValue(editar[2]);
		combo_grupo.disable();
		ClaseMadre_btnEdit()
	};
	function overloadSave(a,b){
		arr={registro:paramConfig.registro};
		ClaseMadre_save(a,b,arr);
	}
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton("../../../lib/imagenes/wrench.png",'Crear Item',btnCrearItem,true,'crear_item','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	crearDialogItem();
	layout_sub_grupo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}