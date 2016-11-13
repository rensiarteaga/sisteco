/**
 * Nombre:		  	    pagina_contrato.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creaciï¿½n:		02-09-2010
 */
function pagina_tipo_col_base(idContenedor,direccion,paramConfig){
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	
	var combo_persona,txt_codigo_empleado,txt_nombre_tipo_documento;
    var txt_doc_id,txt_email1;
    var maestro=new Array();
	var sw=0;
	var componentes=new Array;
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_columna_base/ActionListarTipoColumnaBase.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_columna_base',totalRecords:'TotalCount'
		},[		
				'id_tipo_columna_base',
		'prioridad',
		'id_tipo_columna',
		'desc_tipo_columna',
		'id_tipo_columna_fk',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_columna_fk'
		
		]),remoteSort:true});
	//DATA STORE COMBOS   	
	
		ds_tipo_columna=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_columna/ActionListarColumnaTipo.php?compromete=si"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_columna_tipo','id_parametro_kardex','desc_parametro_kardex','id_partida','desc_partida','nombre','valor','tipo_dato','codigo','compromete','id_tipo_obligacion','desc_tipo_obligacion'])});
		ds_tipo_columna_fk=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_columna/ActionListarColumnaTipo.php?compromete=si"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_columna_tipo','id_parametro_kardex','desc_parametro_kardex','id_partida','desc_partida','nombre','valor','tipo_dato','codigo','compromete','id_tipo_obligacion','desc_tipo_obligacion'])});
		
	//FUNCIONES RENDER
	
	function render_id_tipo_columna(value,p,record){return String.format('{0}',record.data['desc_tipo_columna'])}
	function render_id_tipo_columna_fk(value,p,record){return String.format('{0}',record.data['desc_tipo_columna_fk'])}
	
	
	var tpl_id_tipo_columna=new Ext.Template('<div class="search-item">','Columna:{codigo}-{nombre}<br>','<b><FONT COLOR="#B5A642">Partida: {desc_partida}<br></FONT></b>',
	'Obligacion:{desc_tipo_obligacion}','Parametro:{id_parametro_kardex}',
	'</div>');
    
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_columna_base',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	
	// txt nombre
	Atributos[2]={
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'TICOBA.prioridad',
		id_grupo:0
	};

		
	
	Atributos[1]={
		validacion:{
			fieldLabel:'Tipo Columna',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Tipo Columna...',
			name:'id_tipo_columna',
			desc:'desc_tipo_columna',
			store:ds_tipo_columna,
			valueField:'id_columna_tipo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'COLTIP.codigo#COLTIP.nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:render_id_tipo_columna,
			mode:'remote',
			queryDelay:50,
			
			pageSize:10,
			minListWidth:230,
			width:230,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TICOBA.desc_tipo_columna',
		id_grupo:0
	};


	Atributos[3]={
		validacion:{
			fieldLabel:'Tipo Columna Presupuesto',
			allowBlank:true,
			vtype:'texto',
			emptyText:'Tipo Columna Padre...',
			name:'id_tipo_columna_fk',
			desc:'desc_tipo_columna_fk',
			store:ds_tipo_columna_fk,
			valueField:'id_columna_tipo',
			displayField:'codigo',
			queryParam:'filterValue_0',
			filterCol:'COLTIP.codigo#COLTIP.nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:render_id_tipo_columna_fk,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:230,
			width:150,
			tpl:tpl_id_tipo_columna,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TICOBA.desc_tipo_columna_fk',
		id_grupo:0,
		form:true
	};


	// txt fecha_reg
	Atributos[4]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'contra.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
	};

	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	
	var config={titulo_maestro:'Tipo Columna (Maestro)',titulo_detalle:'Base(Detalle)',grid_maestro:'grid-'+idContenedor};
	
	
	var layout_tipo_col_base=new DocsLayoutMaestro(idContenedor);
	layout_tipo_col_base.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_col_base,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_col_base,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	
	
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_columna_base/ActionEliminarTipoColumnaBase.php'},
		Save:{url:direccion+'../../../control/tipo_columna_base/ActionGuardarTipoColumnaBase.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_columna_base/ActionGuardarTipoColumnaBase.php'},
		Formulario:
		    {html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Tipo Columna Base',
		    
		    grupos:[
				{	tituloGrupo:'Oculto',columna:0,	id_grupo:0	}
					]
		    }};
	
	this.reload=function(m){ 
			maestro=m;			
	
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_tipo_columna:maestro.id_columna_tipo
				}
			};			
				
			this.btnActualizar();
			Atributos[1].defecto=maestro.id_columna_tipo;
			
			paramFunciones.btnEliminar.parametros='&m_id_tipo_columna='+maestro.id_columna_tipo;
			paramFunciones.Save.parametros='&m_id_tipo_columna='+maestro.id_columna_tipo;
			paramFunciones.ConfirmSave.parametros='&m_id_tipo_columna='+maestro.id_columna_tipo;			
			
			this.InitFunciones(paramFunciones)
	};
		
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		
		
		
	}

	
	this.btnNew=function(){
		CM_ocultarComponente(getComponente('id_tipo_columna'));	
		CM_btnNew();
	}
	
	this.btnEdit=function(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		CM_ocultarComponente(getComponente('id_tipo_columna'));	
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			
			CM_btnEdit();
		}else{
			alert('Es necesario seleccionar un item');
		}
	};
	//para que los hijos puedan ajustarse al tamaï¿½o
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}
	this.getLayout=function(){
		return layout_tipo_columna_base.getLayout()
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
	
	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	var CM_getBoton=this.getBoton;
	function enable(sel,row,selected){
			var record=selected.data;
			
			CM_enableSelect(sel,row,selected)
	}
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_col_base.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}