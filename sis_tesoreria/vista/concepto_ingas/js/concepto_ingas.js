/**
 * Nombre:		  	    pagina_concepto_ingas.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-10-16 15:11:34
 */
function pagina_concepto_ingas(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var combo_cuenta,
		combo_desc_ingas_item_serv,
		txt_id_partida,
		combo_concepto_ingas,
		txt_sw_tesoro;
	var g_id_gestion;	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
		                               
		reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id:'id_concepto_ingas',
		totalRecords:'TotalCount'
		},[		
		'id_concepto_ingas',
		'desc_ingas',
		'id_partida',
		'desc_partida',
		'id_item',
		'desc_item',
		'id_servicio',
		'desc_servicio',
		'desc_ingas_item_serv',
		'id_partida',
		'desc_partida',
		'sw_tesoro'
		]),remoteSort:true});

	//DATA STORE COMBOS
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},
		['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_tesoro'])
	});
	
  	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}}); 
	
  	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
  	
	var ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_almacenes/control/item/ActionListarItem.php'}),
  		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});
	
	var ds_servicio=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_adquisiciones/control/servicio/ActionListarServicio.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre'])
	});
	
	 var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?tipo_partida=+2'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria'])
	});
	
	var ds_concepto_ingas=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',	id:'id_concepto_ingas',	totalRecords:'TotalCount'},['id_concepto_ingas','desc_ingas','id_partida','desc_partida','id_item','desc_item','id_servicio','desc_servicio','desc_ingas_item_serv','id_partida','desc_partida','id_cuenta','desc_cuenta','sw_tesoro'])
	});
	
	//FUNCIONES RENDER
    function render_id_item(value,p,record){return String.format('{0}', record.data['desc_item'])}
	var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Cï¿½digo: </b>{codigo}</FONT>','</div>');
    
	function render_id_servicio(value,p,record){return String.format('{0}', record.data['desc_servicio'])}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','</div>');
			
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
    var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');
	
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_ingas_item_serv']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>{desc_ingas_item_serv}</b>','<br><FONT COLOR="#B50000"><b>Partida: </b>{desc_partida}</FONT>','<br><FONT COLOR="#B5A642"><b>Tesoro: </b>{sw_tesoro}</FONT>','</div>');  
		
	//////////////////////////	
	function render_concepto_ingas(value)
	{
		if(value==1){value='Caja-Viatico-FA'	}
		if(value==2){value='No'	}
		if(value==3){value='Viaticos'	}
		if(value==4){value='Fondos en Avance'	}
		if(value==5){value='Cajas'	}
		if(value==6){value='Pasaje x Agencia'	}
		if(value==7){value='Descuento - Viatico'	}
		return value
	}
		
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false,
		save_as:'id_concepto_ingas'
	};

	Atributos[1]={
		validacion:{
			name:'desc_ingas_item_serv',
			fieldLabel:'Concepto de Gasto',
			allowBlank:true,			
			//emptyText:'Descripcion...',
			desc: 'desc_ingas_item_serv', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			//onSelect: function(record){componentes[0].setValue(record.data.id_concepto_ingas);componentes[1].setValue(record.data.desc_ingas_item_serv);componentes[1].collapse();},
			valueField: 'desc_ingas_item_serv',//valor que agarra o guarda
			displayField: 'desc_ingas_item_serv',//el que muestra
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas_item_serv',
			typeAhead:false,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,//tiempo de retardo para buscar en el combo
			pageSize:15,//tamaï¿½o de registros que hay en combo (paginacion)
			maxLength:150,//tamaï¿½o de max de caracteres
			grow:true,//
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:350,//tamaï¿½o del combo en el grid
			width:200,//tamaï¿½o del combo en el formulario
			minListWidth:300,//tamaï¿½o ANCHO de la lista en el formulario
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONING.desc_ingas_item_serv',
		save_as:'desc_ingas'
	};
	
	Atributos[2]={
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida',
			tipo:'partida',//determina el action a llamar
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_partida,
			width_grid:350,
			width:200,
			pageSize:10,
			direccion:direccion,
			disabled:false
			
		},
		tipo:'LovPartida',
		filtro_0:true,
		filtro_1:true,
		form:true,
		filterColValue:'PARTID.codigo_partida#PARTID.desc_partida',
		save_as:'id_partida'
		}; 
	
	Atributos[3]={
		validacion:{
			name:'sw_tesoro',
			fieldLabel:'Tesoreria',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.concepto_ingas_combo.sw_tesoro}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Caja - Viático - Fondo Avance'],['2','No'],['3','Viáticos'],['4','Fondos en Avance'],['5','Cajas'],['6','Pasaje por Agencia'],['7','Descuento - Viatico']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_concepto_ingas,
			grid_editable:false,
			forceSelection:true,
			align:'center',
			width_grid:150,
			width:200,
			minListWidth:100
			
		},
		tipo:'ComboBox',
		//defecto:'1',
		save_as:'sw_tesoro'
		};
		
	// ----------FUNCIONES RENDER---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE-------//
	var config={titulo_maestro:'Concepto Ingreso Gasto',grid_maestro:'grid-'+idContenedor};
	var layout_concepto_ingas=new DocsLayoutMaestro(idContenedor);
	layout_concepto_ingas.init(config);

	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_concepto_ingas,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var btnActualizar=this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;


	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionEliminarConceptoIngas.php'},
		Save:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionGuardarConceptoIngas.php'},
        ConfirmSave:{url:direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionGuardarConceptoIngas.php'},
	   	Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:400,width:480,minWidth:150,minHeight:200,
		closable:true,titulo:'Ingreso - Gasto'}};
		
		//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function btn_concepto_cta()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='m_id_concepto_ingas='+SelectionsRecord.data.id_concepto_ingas;
			data=data+'&m_desc_concepto_ingas='+SelectionsRecord.data.desc_ingas_item_serv;
			data=data+'&m_id_partida='+SelectionsRecord.data.id_partida;
			data=data+'&m_desc_partida='+SelectionsRecord.data.desc_partida;
			
			var ParamVentana={Ventana:{width:'70%',height:'70%'}}
			layout_concepto_ingas.loadWindows(direccion+'../../../../sis_tesoreria/vista/concepto_cta/concepto_cta.php?'+data,'concepto_cta',ParamVentana);

		}
		else
		{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function iniciarEventosFormularios(){ //para iniciar eventos en el formulario
		//combo_cuenta=ClaseMadre_getComponente('id_cuenta');
		combo_concepto_ingas=ClaseMadre_getComponente('id_concepto_ingas');
		combo_desc_ingas_item_serv=ClaseMadre_getComponente('desc_ingas_item_serv');
		txt_id_partida=ClaseMadre_getComponente('id_partida');
		txt_sw_tesoro=ClaseMadre_getComponente('sw_tesoro');
		
		var onCuentaSelect=function(combo,record,index)
		{
			txt_id_partida.setValue(record.data.id_partida);
			combo_concepto_ingas.setValue(record.data.id_concepto_ingas);
				
		};
		
		//alert ("sdfadsf");
		combo_desc_ingas_item_serv.on('select',onCuentaSelect);
		//combo_desc_ingas_item_serv.on('change',onCuentaSelect);
	}
	
	function InitPaginaConceptoIngas()
	{	for(var i=0; i<Atributos.length; i++)
		{	
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}
	
	this.btnNew=function()
	{
		componentes[1].setDisabled(false);
		CM_ocultarComponente(getComponente('id_partida'));
		//componentes[3].setDisabled(true);
		//componentes[3].setValue('1');
		btnNew();
	}
		
	this.btnEdit=function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		CM_ocultarComponente(getComponente('id_partida'));
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			componentes[3].setDisabled(false);
			componentes[1].setDisabled(true);
			txt_id_partida.setValue(SelectionsRecord.data.id_partida);
			combo_concepto_ingas.setValue(SelectionsRecord.data.id_concepto_ingas);
			//combo_cuenta.filterValues[0]=txt_id_partida.getValue();
			//combo_cuenta.modificado=true;
			//combo_cuenta.allowBlank=false
		}
		else
		{	
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
		btnEdit();
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

	gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();	
		ds_concepto_ingas.baseParams={sw_tesoro:2,m_gestion:g_id_gestion};	
		componentes[1].modificado=true;
  		ds.load({
			params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_tesoro:1,
			m_gestion:g_id_gestion
			}
		});
  	});
  	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_concepto_ingas.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML

	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Presupuesto, cuenta y auxiliar',btn_concepto_cta,true,'concepto_cta','Asociacion');
	this.AdicionarBotonCombo(gestion,'gestion');	
	
	this.iniciaFormulario();
	InitPaginaConceptoIngas();
	iniciarEventosFormularios();
	layout_concepto_ingas.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}