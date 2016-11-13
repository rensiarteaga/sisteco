/**
 * Nombre:		  	    pagina_departamentoEP.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2009-01-23 11:04:01
 */

function pagina_departamentoDiv(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var txt_subsistema, txt_proceso;
	/////////////////
	//  DATA STORE //
	/////////////////

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_div/ActionListarDepartamentoDiv.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_division',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_division',
		'id_depto',
		'desc_depto',
		'codigo_division',
		'division',
		'estado'
		]),remoteSort:true});

	// DEFINICIï¿½N DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['ID Depto.',maestro.id_depto],['Código',maestro.codigo_depto],['Departamento',maestro.nombre_depto]];
	
	//DATA STORE COMBOS
    
    var ds_depto = new Ext.data.Store({
    	proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepto.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_depto',
			totalRecords: 'TotalCount'},
			['id_depto',
			 'codigo_depto',
			 'nombre_depto',
			 'estado'])
    });
	

	//FUNCIONES RENDER
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');


	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	//en la posiciï¿½n 0 siempre esta la llave primaria
	//id_depto_uo
	Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_depto_division',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

	// txt id_depto
	Atributos[1]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_depto
	};
	
	Atributos[2]= {
		validacion:{
			name:'codigo_division',
			fieldLabel:'Código',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		filterColValue:'DEPDIV.codigo_division',
		save_as:'codigo_division'	
	};
	
	Atributos[3]= {
		validacion:{
			name:'division',
			fieldLabel:'División',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		filterColValue:'DEPDIV.division',
		save_as:'division'	
	};
	
	Atributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'DEPDIV.estado'	
	};
	
	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
			titulo_maestro:'Departamentos (Maestro)',
			titulo_detalle:'División (Detalle)',
			grid_maestro:'grid-'+idContenedor};
	var layout_departamentoDiv = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamentoDiv.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamentoDiv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}};
	
	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depto_div/ActionEliminarDepartamentoDiv.php',parametros:'&id_depto='+maestro.id_depto},
	Save:{url:direccion+'../../../control/depto_div/ActionGuardarDepartamentoDiv.php',parametros:'&id_depto='+maestro.id_depto},
	ConfirmSave:{url:direccion+'../../../control/depto_div/ActionGuardarDepartamentoDiv.php',parametros:'&id_depto='+maestro.id_depto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'División'}};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
	}
 
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		};
		this.btnActualizar();
		data_maestro=[['ID Depto. ',maestro.id_depto],['Código ',maestro.codigo_depto],['Departamento ',maestro.nombre_depto]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_depto;

		paramFunciones.btnEliminar.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.Save.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.ConfirmSave.parametros='&id_depto='+maestro.id_depto;
		this.InitFunciones(paramFunciones)
	};
		
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamentoDiv.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_depto:maestro.id_depto
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_departamentoDiv.getLayout().addListener('layout',this.onResize);
	layout_departamentoDiv.getVentana(idContenedor).on('resize',function(){layout_departamentoDiv.getLayout().layout()})
	
}