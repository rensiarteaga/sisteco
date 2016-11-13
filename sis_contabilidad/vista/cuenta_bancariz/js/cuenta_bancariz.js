/**
 * Nombre:		  	    pagina_cuenta_bancariz.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:37
 */
function pagina_cuenta_bancariz(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancariz/ActionListarCuentaBancariz.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_bancariz',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_bancariz',
		'id_parametro',
		'id_cuenta',
		'desc_cuenta',
		'estado',
		'id_usuario_reg',
		'login',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_parametro',maestro.id_parametro]];
	
	//DATA STORE COMBOS

   var ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../control/cuenta/ActionListarCuenField.php?m_id_gestion="+maestro.id_gestion}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','desc_cuenta','nro_cuenta','nombre_cuenta'])});
   var tpl_cuenta=new Ext.Template('<div class="search-item">','<b>{desc_cuenta}</b>','<br><FONT COLOR="#B5A642"><b>Nombre:</b> {nombre_cuenta}</FONT>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta:</b> {nro_cuenta}</FONT>','</div>');
        

	//FUNCIONES RENDER
	function render_id_cuenta(value,p,record){return String.format('{0}',record.data['desc_cuenta'])}
	function render_estado(value, p, record){
			if (value=='activo') {
				return 'Activo';
			}else {
				return 'Inactivo';
			}
		
		}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_nivel_cuenta
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cuenta_bancariz',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_cuenta_bancariz'
	};
// txt id_parametro
	Atributos[1]={
		validacion:{
			name:'id_parametro',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_parametro,
		save_as:'txt_id_parametro'
	};
	Atributos[2]={
		validacion:{
			fieldLabel:'Cuenta',
		    allowBlank:false,
		    vtype:'texto',
		    emptyText:'Cuenta...',
		    name:'id_cuenta',
		    desc:'desc_cuenta',
		    store:ds_cuenta,
		    valueField:'id_cuenta',
		    displayField:'desc_cuenta',
		    queryParam:'filterValue_0',
		    filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
		    typeAhead:true,
		    forceSelection:true,
		    renderer:render_id_cuenta,
		    tpl:tpl_cuenta,
		    mode:'remote',
		    queryDelay:50,
		    pageSize:10,
		    minListWidth:230,
		    width:250,
		    resizable:true,
		    minChars:0,
		    triggerAction:'all',
		    editable:true,
		    grid_visible:true,
		    grid_editable:false,
		    width_grid:230
		},
		tipo:'ComboBox',
	    filtro_0:true,
	    filterColValue:'CUENTA.nombre_cuenta',
	    save_as:'txt_id_cuenta'
	};
// txt estado_gestion
	Atributos[3]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			typeAhead:false,
			maxLength:50,
			minLength:0,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:20,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			renderer:render_estado	
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CUEBANC.estado',
		save_as:'txt_estado'
	};
    Atributos[4]={
		validacion:{
			labelSeparator:'',
			name:'id_usuario_reg',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[5]={
		validacion:{
			name:'login',
			fieldLabel:'Usuario Reg',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		form:false,
		tipo:'TextField'
	};
	Atributos[6]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		form:false,
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros Generales (Maestro)',titulo_detalle:'cuenta_bancariz (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_cuenta_bancariz = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cuenta_bancariz.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_cuenta_bancariz,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},
	                        nuevo:{crear:true,separador:true},
	                         editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cuenta_bancariz/ActionEliminarCuentaBancariz.php',parametros:'&maestro_id_parametro='+maestro.id_parametro},
	Save:{url:direccion+'../../../control/cuenta_bancariz/ActionGuardarCuentaBancariz.php',parametros:'&maestro_id_parametro='+maestro.id_parametro},
	ConfirmSave:{url:direccion+'../../../control/cuenta_bancariz/ActionGuardarCuentaBancariz.php',parametros:'&maestro_id_parametro='+maestro.id_parametro},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'cuenta_bancariz'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_parametro=datos.m_id_parametro;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_parametro:maestro.id_parametro
			}
		};
		this.btnActualizar();
		data_maestro=[['id_parametro',maestro.id_parametro]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_parametro;

		paramFunciones.btnEliminar.parametros='&maestro_id_parametro='+maestro.id_parametro;
		paramFunciones.Save.parametros='&maestro_id_parametro='+maestro.id_parametro;
		paramFunciones.ConfirmSave.parametros='&maestro_id_parametro='+maestro.id_parametro;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	 cmpCuenta=getComponente('id_cuenta');
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cuenta_bancariz.getLayout()};
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
			maestro_id_parametro:maestro.id_parametro
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cuenta_bancariz.getLayout().addListener('layout',this.onResize);
	layout_cuenta_bancariz.getVentana(idContenedor).on('resize',function(){layout_cuenta_bancariz.getLayout().layout()})
	
}