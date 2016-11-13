function PaginaID3(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_id3;
	var elementos=new Array();
	var marcas_html,div_dlgFrm,dlgFrm,uniMed,stockMin,costoEstimado,precioEstimado,txt_uni_med,txt_costo_estimado,txt_precio_estimado,txt_stock_min;
	var sw=0;
	var combo_supergrupo,combo_grupo,combo_subgrupo,combo_id1,combo_id2,txt_codigo,txt_nombre,txt_descripcion,txt_convertido;
	var	txt_fecha_reg,txt_nivel_convertido;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id3/ActionListarId3.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},
		[{name:'codigo', type: 'string'},
		'id_id3',
		'nombre',
		'descripcion',
		'nivel_convertido',
		'convertido',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_id2',
		'id_id1',
		'id_subgrupo',
		'id_grupo',
		'id_supergrupo',
		'desc_id2',
		'desc_id1',
		'desc_subgrupo',
		'desc_grupo',
		'desc_supergrupo'
		]),
		remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			registro:paramConfig.registro
		}
	});
	/////////////////////////
	//   PARÁMETROS        //
	/////////////////////////
	ds_uni_med=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	});
	ds_supergrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre','codigo'])
	});
	ds_grupo=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre','codigo'])
	});
	ds_subgrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre','codigo'])
	});
	ds_id1=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id1/ActionListarId1.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id1',totalRecords:'TotalCount'},['id_id1','nombre','codigo'])
	});
	ds_id2=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id2/ActionListarId2.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre','codigo'])
	});
	////////////////FUNCIONES RENDER ////////////
	function renderSuperGrupo(value,p,record){return String.format('{0}',record.data['desc_supergrupo'])}
	function renderGrupo(value,p,record){return String.format('{0}',record.data['desc_grupo'])}
	function renderSubGrupo(value,p,record){return String.format('{0}',record.data['desc_subgrupo'])}
	function renderId1(value,p,record){return String.format('{0}',record.data['desc_id1'])}
	function renderId2(value,p,record){return String.format('{0}',record.data['desc_id2'])}
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplSubGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplId1=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplId2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
	var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_id3',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_id3'
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
			emptyText:'SuperGrupo',
			name:'id_supergrupo',
			desc:'desc_supergrupo',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
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
			queryParam:'filterValue_0',
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
			emptyText:'Grupo',
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
			width_grid:110,
			width:300,
			grid_indice:5
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'g.nombre#g.codigo',
		save_as:'hidden_id_grupo'
	};
	
	var filterCols_subgrupo=new Array();
	var filterValues_subgrupo=new Array();
	filterCols_subgrupo[0]='supgru.id_supergrupo';
	filterValues_subgrupo[0]='%';
	filterCols_subgrupo[1]='g.id_grupo';
	filterValues_subgrupo[1]='%';
	filterCols_subgrupo[2]='sub.estado_registro';
	filterValues_subgrupo[2]='activo';

	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Sub Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'SubGrupo',
			name:'id_subgrupo',
			desc:'desc_subgrupo',
			store:ds_subgrupo,
			valueField:'id_subgrupo',
			displayField:'nombre',
			filterCol:'sub.nombre#sub.codigo',
			filterCols:filterCols_subgrupo,
			filterValues:filterValues_subgrupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSubGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderSubGrupo,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			grid_indice:6
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'sub.nombre#sub.codigo',
		save_as:'hidden_id_subgrupo'
	};
	
	var filterCols_id1=new Array();
	var filterValues_id1=new Array();
	filterCols_id1[0]='supgru.id_supergrupo';
	filterValues_id1[0]='%';
	filterCols_id1[1]='g.id_grupo';
	filterValues_id1[1]='%';
	filterCols_id1[2]='sub.id_subgrupo';
	filterValues_id1[2]='%';
	filterCols_id1[3]='id1.estado_registro';
	filterValues_id1[3]='activo';
	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Identificador Id1',
			allowBlank:false,
			vtype:"texto",
			emptyText:'ID1',
			name:'id_id1',
			desc:'desc_id1',
			store:ds_id1,
			valueField:'id_id1',
			displayField:'nombre',
			filterCol:'id1.nombre#id1.codigo',
			filterCols:filterCols_id1,
			filterValues:filterValues_id1,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId1,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderId1,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:7
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'id1.nombre#id1.codigo',
		save_as:'hidden_id_id1'
	};
	
	var filterCols_id2=new Array();
	var filterValues_id2=new Array();
	filterCols_id2[0]='supgru.id_supergrupo';
	filterValues_id2[0]='%';
	filterCols_id2[1]='g.id_grupo';
	filterValues_id2[1]='%';
	filterCols_id2[2]='sub.id_subgrupo';
	filterValues_id2[2]='%';
	filterCols_id2[3]='id1.id_id1';
	filterValues_id2[3]='%';
	filterCols_id2[4]='id2.estado_registro';
	filterValues_id2[4]='activo';

	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Identificador Id2',
			allowBlank:false,
			vtype:"texto",
			emptyText:'ID2',
			name:'id_id2',
			desc:'desc_id2',
			store:ds_id2,
			valueField:'id_id2',
			displayField:'nombre',
			filterCol:'id2.nombre#id2.codigo',
			filterCols:filterCols_id2,
			filterValues:filterValues_id2,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId2,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderId2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			grid_indice:8
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'id2.nombre#id2.codigo',
		save_as:'hidden_id_id2'
	};

	vectorAtributos[6]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:5,
			minLength:1,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:50,
			grid_indice:1
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'id3.codigo',
		save_as:'txt_codigo'
	};

	vectorAtributos[7]={
		validacion:{
			name:'nombre',
			fieldLabel:'Identificador 3',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'60%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:2
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'id3.nombre',
		save_as:'txt_nombre'
	};

	vectorAtributos[8]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'id3.descripcion',
		save_as:'txt_descripcion'
	};

	vectorAtributos[9]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'80%',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			grid_indice:9
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'id3.observaciones',
		save_as:'txt_observaciones'
	};

	vectorAtributos[10]={
		validacion:{
			name:'estado_registro',
			fieldLabel:'Estado',
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id', 'valor'],data:Ext.id3_combo.estado}),
			store:new Ext.data.SimpleStore({fields:['id', 'valor'],data:[['activo', 'Activo'],['inactivo', 'Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			width:65,
			grid_indice:10
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'id3.estado_registro',
		save_as:'txt_estado_registro',
		defecto:"activo"
	};

	vectorAtributos[11]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:11
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'id3.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y',
		defecto:""
	};

	vectorAtributos[12]={
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

	vectorAtributos[13]={
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
			grid_indice:13
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'txt_nivel_convertido',
		defecto:""
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	var config={titulo_maestro:"Identificador Id3",grid_maestro:"grid-"+idContenedor};
	layout_id3=new DocsLayoutMaestro(idContenedor);
	layout_id3.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_id3,idContenedor);
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
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/id3/ActionEliminarId3.php"},
		Save:{url:direccion+"../../../control/id3/ActionGuardarId3.php"},
		ConfirmSave:{url:direccion+"../../../control/id3/ActionGuardarId3.php"},
		Formulario:{
			guardar:overloadSave,
			html_apply:"dlgInfo"+idContenedor,width:'40%',height:'55%',minWidth:150,minHeight:200,labelWidth:75,closable:true,titulo:'Identificador 3'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function crearDialogItem(){
		marcas_html="<div class='x-dlg-hd'>"+'Convertir a Item'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:150 // label settings here cascade unless overridden
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
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm.addButton('Convertir',crearItem);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		//creación de componentes
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
		combo_subgrupo=ClaseMadre_getComponente('id_subgrupo');
		combo_id1=ClaseMadre_getComponente('id_id1');
		combo_id2=ClaseMadre_getComponente('id_id2');
		txt_codigo=ClaseMadre_getComponente('codigo');
		txt_nombre = ClaseMadre_getComponente('nombre');
		txt_descripcion = ClaseMadre_getComponente('descripcion');
		txt_convertido=ClaseMadre_getComponente('convertido');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		txt_nivel_convertido=ClaseMadre_getComponente('nivel_convertido');
		var onCodigoSelect=function(e){
			var cod=txt_codigo.getValue();
			/*if (cod==0){Ext.MessageBox.alert('Estado','El Código no puede tener el valor 0');
			txt_codigo.setValue('')}*/
		};
		var onSuperGrupoSelect=function(e){
			var id=combo_supergrupo.getValue()
			combo_grupo.filterValues[0]=id;
			combo_grupo.modificado=true;
			combo_subgrupo.filterValues[0]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[0]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[0]=id;
			combo_id2.modificado=true;
			combo_grupo.enable();
			combo_subgrupo.enable();
			combo_id1.enable();
			combo_id2.enable();
			combo_grupo.allowBlank=false;
			combo_grupo.setValue('');
			combo_subgrupo.allowBlank=false;
			combo_subgrupo.setValue('');
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('')
		};
		var onGrupoSelect=function(e){
			var id=combo_grupo.getValue()
			combo_subgrupo.filterValues[1]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[1]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[1]=id;
			combo_id2.modificado=true;
			combo_subgrupo.allowBlank=false;
			combo_subgrupo.setValue('');
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('')
		};
		var onSubGrupoSelect=function(e){
			var id=combo_subgrupo.getValue()
			combo_id1.filterValues[2]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[2]=id;
			combo_id2.modificado=true;
			combo_id1.allowBlank=false;
			combo_id1.setValue('');
			combo_id2.allowBlank=false;
			combo_id2.setValue('')
		};
		var onId1Select=function(e){
			var id=combo_id1.getValue()
			combo_id2.filterValues[3]=id;
			combo_id2.modificado=true;
			combo_id2.allowBlank=false;
			combo_id2.setValue('')
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
		combo_grupo.on('select',onGrupoSelect);
		combo_grupo.on('change',onGrupoSelect);
		combo_subgrupo.on('select',onSubGrupoSelect);
		combo_subgrupo.on('change',onSubGrupoSelect);
		combo_id1.on('select',onId1Select);
		combo_id1.on('change',onId1Select);
		txt_codigo.on('select',onCodigoSelect);
		txt_codigo.on('change',onCodigoSelect);
		txt_nombre.on('blur',CopiarDescrip)
	}
	//boton crear item
	function btnCrearItem(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		if(NumSelect!=0){
			if(txt_convertido.getValue()=='no'){
			dlgFrm.show()
			}
			else{Ext.MessageBox.alert('Estado','El material ya es un Item.')}
		}
		else{Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un elemento.');}
	}
	function crearItem(){
		if(txt_convertido.getValue()=='no'){
			var sm=getSelectionModel();
			txt_uni_med=uniMed.getValue();
			txt_costo_estimado=costoEstimado.getValue();
			txt_precio_estimado=precioEstimado.getValue();
			txt_stock_min=stockMin.getValue();
			dlgFrm.hide();
			var SelectionsRecord=sm.getSelected(); //es el primer registro selecionado
			var data="cantidad_ids=1&hidden_id_id3_0="+SelectionsRecord.data.id_id3;
			data=data+"&txt_codigo_0="+SelectionsRecord.data.codigo;
			data=data+"&txt_nombre_0="+SelectionsRecord.data.nombre;
			data=data+"&txt_descripcion_0="+SelectionsRecord.data.descripcion;
			data=data+"&txt_nivel_convertido_0="+SelectionsRecord.data.nivel_convertido;
			data=data+"&txt_convertido_0="+SelectionsRecord.data.convertido;
			data=data+"&txt_observaciones_0="+SelectionsRecord.data.observaciones;
			data=data+"&txt_estado_registro_0="+SelectionsRecord.data.estado_registro;
			data=data+"&txt_fecha_reg_0="+SelectionsRecord.data.fecha_reg;
			data=data+"&hidden_id_id2_0="+SelectionsRecord.data.id_id2;
			data=data+"&hidden_id_id1_0="+SelectionsRecord.data.id_id1;
			data=data+"&hidden_id_subgrupo_0="+SelectionsRecord.data.id_subgrupo;
			data=data+"&hidden_id_grupo_0="+SelectionsRecord.data.id_grupo;
			data=data+"&hidden_id_supergrupo_0="+SelectionsRecord.data.id_supergrupo;
			data=data+"&txt_id_unidad_medida_base_0="+txt_uni_med;
			data=data+"&txt_costo_estimado_0="+txt_costo_estimado;
			data=data+"&txt_precio_estimado_0="+txt_precio_estimado;
			data=data+"&txt_stock_min_0="+txt_stock_min;
			Ext.Ajax.request({url:direccion+"../../../control/id3/ActionCrearItemId3.php",
			params:data,
			method:'POST',
			failure:ClaseMadre_conexionFailure,
			timeout:100000});
			Ext.MessageBox.alert('Estado', 'El material fue convertido con éxito');
			ClaseMadre_btnActualizar();
		}else{Ext.MessageBox.alert('Estado', 'El material ya es un Item.');}
		ClaseMadre_clearSelections();
	}
	this.btnNew=function(){
		CM_ocultarComponente(txt_convertido);
		CM_ocultarComponente(txt_nivel_convertido);
		CM_ocultarComponente(txt_fecha_reg);
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		if(txt_convertido.getValue()=='si'){
			
			CM_ocultarComponente(txt_convertido);
		    CM_ocultarComponente(txt_nivel_convertido);
		    CM_ocultarComponente(txt_fecha_reg);
			combo_supergrupo.disable();
			combo_grupo.disable();
			combo_subgrupo.disable();
			combo_id1.disable();
			combo_id2.disable();
			txt_codigo.disable();
			ClaseMadre_btnEdit()
				
		}
		else{
			CM_ocultarComponente(txt_convertido);
		    CM_ocultarComponente(txt_nivel_convertido);
		    CM_ocultarComponente(txt_fecha_reg);
			h_txt_codigo=txt_codigo.getValue();
			//h_txt_cod=h_txt_codigo.substr(19,3);
			var editar = h_txt_codigo.split('.');
			txt_codigo.setValue(editar[5]);
			combo_supergrupo.enable();
			combo_grupo.disable();
			combo_subgrupo.disable();
			combo_id1.disable();
			combo_id2.disable();
			ClaseMadre_btnEdit()
		}
	};
	function overloadSave(a,b){
		arr={registro:paramConfig.registro};
		ClaseMadre_save(a,b,arr);
	}
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton("../../../lib/imagenes/wrench.png",'Crear Item',btnCrearItem,true, 'crear_item','');
	this.iniciaFormulario();
	crearDialogItem();
	iniciarEventosFormularios();
	layout_id3.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}