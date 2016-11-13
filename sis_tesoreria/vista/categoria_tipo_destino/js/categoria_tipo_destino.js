/**
 * Nombre:		  	    pagina_categoria_tipo_destino.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 12:25:02
 */
function pagina_categoria_tipo_destino(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_tipo_destino/ActionListarCategoriaTipoDestino.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_categoria_tipo_destino',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_categoria_tipo_destino',
		'id_categoria',
		'desc_categoria',
		'id_tipo_destino',
		'importe_viatico',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_usr_reg',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'apellido_paterno_usuario',
		'apellido_materno_usuario',
		'nombre_usuario',
		'desc_usuario',
		'tipo_hotel'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_tipo_destino',maestro.id_tipo_destino],['Descripción',maestro.descripcion]];
	
	//DATA STORE COMBOS

    var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/categoria/ActionListarCategoria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria','cod_categoria'])
	});

	//FUNCIONES RENDER
	
		function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
		var tpl_id_categoria=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_categoria}</FONT><br>','</div>');
		
		function render_fecha_reg(value,p,record){return value.dateFormat('d/m/Y');}
		function render_usuario(value,p,record){return String.format('{0}', record.data['desc_usuario']);}

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_categoria_tipo_destino
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_categoria_tipo_destino',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_categoria
	Atributos[1]={
			validacion:{
			name:'id_categoria',
			fieldLabel:'Categoria',
			allowBlank:false,			
			emptyText:'Categoria...',
			desc: 'desc_categoria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria,
			valueField: 'id_categoria',
			displayField: 'desc_categoria',
			queryParam: 'filterValue_0',
			filterCol:'CATEGO.desc_categoria',
			typeAhead:true,
			tpl:tpl_id_categoria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.desc_categoria'
	};
	
	// txt id_tipo_destino
	Atributos[2]={
			validacion:{
				name:'id_tipo_destino',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_tipo_destino
		};
	
	//txt importe_viatico
	Atributos[3]={
		validacion:{
			name:'importe_viatico',
			fieldLabel:'Importe viático',
			allowBlank:false,
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
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CATIDE.importe_viatico'
	};
// txt fecha_reg
	Atributos[4]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			renderer:render_fecha_reg
		},
		tipo:'Field',
		filtro_0:true,
		form:false,
		dateFormat:'m-d-Y',
		filterColValue:'CATIDE.fecha_reg',
	};
// txt id_usr_reg
	Atributos[5]={
		validacion:{
			name:'id_usr_reg',
			fieldLabel:'Usuario registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			renderer:render_usuario
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CATIDE.id_usr_reg',
	};
// txt tipo_hotel
	Atributos[6]={
		validacion:{
			name:'tipo_hotel',
			fieldLabel:'Tipo Hotel',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATIDE.tipo_hotel'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipo Destino (Maestro)',titulo_detalle:'Categoría/Tipo Destino (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_categoria_tipo_destino = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_categoria_tipo_destino.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_categoria_tipo_destino,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/categoria_tipo_destino/ActionEliminarCategoriaTipoDestino.php',parametros:'&id_tipo_destino='+maestro.id_tipo_destino},
	Save:{url:direccion+'../../../control/categoria_tipo_destino/ActionGuardarCategoriaTipoDestino.php',parametros:'&id_tipo_destino='+maestro.id_tipo_destino},
	ConfirmSave:{url:direccion+'../../../control/categoria_tipo_destino/ActionGuardarCategoriaTipoDestino.php',parametros:'&id_tipo_destino='+maestro.id_tipo_destino},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Categoría/Tipo destino'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_tipo_destino:maestro.id_tipo_destino
			}
		};
		this.btnActualizar();
		data_maestro=[['id_tipo_destino',maestro.id_tipo_destino],['Descripción',maestro.descripcion]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));

		paramFunciones.btnEliminar.parametros='&id_tipo_destino='+maestro.id_tipo_destino;
		paramFunciones.Save.parametros='&id_tipo_destino='+maestro.id_tipo_destino;
		paramFunciones.ConfirmSave.parametros='&id_tipo_destino='+maestro.id_tipo_destino;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_categoria_tipo_destino.getLayout()};
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
			id_tipo_destino:maestro.id_tipo_destino
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_categoria_tipo_destino.getLayout().addListener('layout',this.onResize);
	layout_categoria_tipo_destino.getVentana(idContenedor).on('resize',function(){layout_categoria_tipo_destino.getLayout().layout()})
	
}