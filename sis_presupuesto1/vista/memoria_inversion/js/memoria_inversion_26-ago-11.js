/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_memoria_inversion(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var dialog;
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mem_inversion_gasto/ActionListarMemoriaInversion.php'}),
		reader:new Ext.data.XmlReader({
		       record:'ROWS',
			   id:'id_mem_inversion_gasto',
			   totalRecords:'TotalCount'

		 },[
		   'id_mem_inversion_gasto',
		   'cantidad',
		   'costo_unitario',
		   'periodo_pres',
		   'tipo_mem',
		   'id_memoria_calculo',
		   'id_moneda',
		   'desc_moneda',
		   'total_general'
		  ]),remoteSort:true});
	// Definición de datos //
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});
	//FUNCIONES RENDER	
		function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		function renderSeparadorDeMil(value,cell,record,row,colum,store){		
			var monedas_for=new Ext.form.MonedaField();
			return monedas_for.formatMoneda(value)		 
		}
		function renderPeriodo(value,p,record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}
		else
		{return "T O T A L :"}
		}
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_mem_inversion_gasto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_mem_inversion_gasto'
	};
	// txt estado_gral
	Atributos[1]={
		validacion: {
			name:'tipo_insercion',
			fieldLabel:'Tipo Inserción',
			allowBlank:false,
			emptyText:'Tipo Inserc...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','En un mes especifico'],['2','En los doce meses']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:200,
			disable:false
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'MEMSER.periodo_pres',
		defecto:1,
		save_as:'tipo_insercion'
	};	
	// txt periodo_pres
	Atributos[2]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:false,
			emptyText:'Periodo...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			disable:false
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'MEMING.periodo_pres',
		defecto:1,
		save_as:'periodo_pres'
	};		
	// txt cantidad
	Atributos[3]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
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
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo:'NumberField',
		filtro_0:false,
		defecto:0,
		filterColValue:'MEMING.cantidad',
		save_as:'cantidad'
	};
	// txt costo_unitario
	Atributos[4]={
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Precio Unitario',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo:'NumberField',
		filtro_0:false,
		defecto:0,
		filterColValue:'MEMING.costo_unitario',
		save_as:'costo_unitario'
	};
	// txt tipo_mem
	Atributos[5]={
		validacion:{
			name:'tipo_mem',
			fieldLabel:'Tipo Memoria',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'MEMING.tipo_mem',
		save_as:'tipo_mem'
	};
	// txt id_memoria_calculo
	Atributos[6]={
		validacion:{
			name:'id_memoria_calculo',
			fieldLabel:'Memoria',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'60%',
			disabled:false		
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'MEMING.id_memoria_calculo',
		save_as:'id_memoria_calculo'
	};
	// txt total_general
	Atributos[7]={
		validacion:{
			name:'total_general',
			fieldLabel:'Importe Mensual',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:true		
		},
		tipo:'NumberField',
		filtro_0:false,
		filterColValue:'MEMING.total_general',
		save_as:'total_general'
	};
	// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc:'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
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
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:1,
		save_as:'id_moneda'
	};	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	tituloM='Memoria de Cálculo';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria de Cálculo (Maestro)',titulo_detalle:'Memoria de Inversión (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_inversion= new DocsLayoutMaestro(idContenedor);
	layout_memoria_inversion.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_inversion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var CM_btnSave=this.Save;
	var CM_getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var getFormulario=this.getFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/mem_inversion_gasto/ActionEliminarMemoriaGasto.php'},
		Save:{url:direccion+'../../../control/mem_inversion_gasto/ActionGuardarMemoriaGasto.php'},
		ConfirmSave:{url:direccion+'../../../control/mem_inversion_gasto/ActionGuardarMemoriaGasto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,
		            titulo:'Memoria de Inversiones',guardar:filtro,grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},
			        {tituloGrupo:'Filtrar',columna:0,id_grupo:1}]}};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		// alert (maestro.id_avance);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo
			}
		};
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};
		prueba.setValue(maestro.id_moneda);
		this.btnActualizar();
		Atributos[6].defecto=maestro.id_memoria_calculo;
		Atributos[8].defecto=maestro.id_moneda;
		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		var CM_getBoton=this.getBoton;
		this.InitFunciones(paramFunciones);
		if(maestro.tipo_vista==2){
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable()
		}
		else{
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable()
		}
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		dialog=CM_getDialog();
		h_id_moneda=getComponente('id_moneda');//texto
		h_cantidad=getComponente('cantidad');//texto
		h_costo_unitario=getComponente('costo_unitario');//texto
		h_total_general=getComponente('total_general');//texto
		h_tipo_mem=getComponente('tipo_mem');//texto
		h_id_memoria_calculo=getComponente('id_memoria_calculo');//texto
		h_tipo_insercion=getComponente('tipo_insercion');//texto
		h_periodo_pres=getComponente('periodo_pres');//texto
		CM_ocultarComponente(h_tipo_mem);
		CM_ocultarComponente(h_id_memoria_calculo);
		Atributos[5].defecto=2;	//Tipo memoria por defecto es inversion
		function costoTotal(){
			var multiplicacion;			
			multiplicacion=parseFloat(h_cantidad.getValue()) * parseFloat(h_costo_unitario.getValue());
			h_total_general.setValue(multiplicacion)
		}		
		h_cantidad.on('blur', costoTotal);
		h_costo_unitario.on('blur', costoTotal)	
		function insercion(){
			//Insercion en un mes especifico
			if(h_tipo_insercion.getValue()=='1'){
				CM_mostrarComponente(h_periodo_pres)
			}
			else{ //Insercion en los doce meses 
				CM_ocultarComponente(h_periodo_pres)
			}
		}
		h_tipo_insercion.on('change',insercion);	
		h_tipo_insercion.on('select',insercion)
	}
	this.btnNew=function(){
		sw_filtro="false";		
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		CM_btnNew()
	};
	
	this.Save=function(){		
		CM_btnSave()			
	};	
	function filtro(){
	   if (sw_filtro=="true"){	
			ds.baseParams={valor_filtro:parseFloat(h_id_moneda.getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});
			dialog.hide()
		}
		else{
			CM_btnSave()
		}
	}
	var prueba=new Ext.form.ComboBox({
			store:ds_moneda,
			displayField:'nombre',
			typeAhead:true,
			mode:'local',
			triggerAction:'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField:'id_moneda',
			editable:false,			
			tpl:tpl_id_moneda			
	});
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	prueba.on('select',	function(){				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});			
	});	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_inversion.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBotonCombo(prueba,'prueba');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_inversion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}