/**
 * Nombre:		  	    pagina_rubro_cuenta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-02 11:34:34
 */
function pagina_rubro_cuenta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	var Atributos=new Array,sw=0;
	var cmpId_cuenta;

	//  DATA STORE //
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rubro_cuenta/ActionListarRubroCuenta.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_rubro_cuenta',totalRecords: 'TotalCount'}, ['id_rubro_cuenta','id_rubro','desc_rubro','id_cuenta','desc_cuenta']),remoteSort:true});

	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_rubro:maestro.id_rubro
		}
	});*/
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Rubro',maestro.nombre_rubro],['Nombre EEFF',maestro.nombre_eeff]];
	  var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
    'sw_oec','sw_aux'
    
    ])});
	//DATA STORE COMBOS
    var ds_rubro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rubro/ActionListarRubro.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rubro',totalRecords: 'TotalCount'},['id_rubro','id_reporte_eeff','nombre_rubro','fk_rubro','sw_debe_haber'])});
   // var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion'])});
	//FUNCIONES RENDER
		function render_id_rubro(value, p, record){return String.format('{0}', record.data['desc_rubro']);}
		var tpl_id_rubro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_rubro}</FONT><br>','</div>');
		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>',
		'<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<b>Nombre: </b><FONT COLOR="#B5A642">{nombre_cuenta}</FONT>','</div>');
		
		function render_id_cuenta(value, p, record){return String.format('{0}',record.data['desc_cuenta'])}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_cta2}</FONT><br>','<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{nombre_cuenta}</FONT><br>','</div>'); 
	// hidden id_rubro_cuenta
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_rubro_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_rubro_cuenta'
	};
// txt id_rubro
	Atributos[1]={
		validacion:{
			name:'id_rubro',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_rubro,
		save_as:'id_rubro'
	};
	

	//var datos = ['id_cuenta','desc_cuenta','nro_cuenta','nombre_cuenta','sw_transaccional','sw_oec','sw_aux'];	


	 
Atributos[2]={
			validacion:{
 			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'desc_cuenta', 		
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:200,
			lazyRender:true,
      		width:'100%',
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'cuenta.id_cuenta',
		save_as:'id_cuenta'
	};

	/*Atributos[2]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			fieldLabel:'Cuenta',
			mode:'remote',
			triggerAction:'all',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			valueField: 'id_cuenta',
			displayField: 'desc_cta', 
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_cuenta,
			width_grid:250,
			width:200,
			pageSize:10,//importante
			typeAhead:false,
			loadMask:true,
			queryParam:'filterValue_0',
			forceSelection:true,
			minChars:1,
			listWidth:300,
			resizable:true,
			lazyRender:true,
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta', 
			direccion:direccion,
			store:ds_cuenta,
		 	data:dataLov,
		 	lov:paramLOV,
		 	dir:'ASC',
		 	sort:'CUENTA.nro_cuenta',
		 	tpl:tpl_id_cuenta,
			title:'Selecionar Cuenta'
		},
		tipo:'LovCuenta',
		//tipo:'Lovs',
		save_as:'id_cuenta'
		};*/
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Rubro (Maestro)',
	titulo_detalle:'rubro_cuenta (Detalle)',
	grid_maestro:'grid-'+idContenedor};
	var layout_rubro_cuenta = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_rubro_cuenta.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_rubro_cuenta,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponente=this.getComponente;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/rubro_cuenta/ActionEliminarRubroCuenta.php',parametros:'&m_id_rubro='+maestro.id_rubro},
	Save:{url:direccion+'../../../control/rubro_cuenta/ActionGuardarRubroCuenta.php',parametros:'&m_id_rubro='+maestro.id_rubro},
	ConfirmSave:{url:direccion+'../../../control/rubro_cuenta/ActionGuardarRubroCuenta.php',parametros:'&m_id_rubro='+maestro.id_rubro},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'rubro_cuenta'}};
	
	
	
	
	
	
		function 	 MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		/*if(j%2!=0){
			html=html+"<td></td><td></td></tr>";
		}*/
		//html=html+'</table>';
		
	 
		return html
	};	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_rubro=datos.m_id_rubro;
    maestro.nombre_rubro=datos.m_nombre_rubro;
    maestro.nombre_eeff=datos.m_nombre_eeff;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_rubro:maestro.id_rubro
			}
		};
		this.btnActualizar();
		data_maestro=[
		['Rubro',maestro.nombre_rubro],
		['EEFF',maestro.nombre_eeff]
		];
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		Atributos[1].defecto=maestro.id_rubro;

		paramFunciones.btnEliminar.parametros='&m_id_rubro='+maestro.id_rubro;
		paramFunciones.Save.parametros='&m_id_rubro='+maestro.id_rubro;
		paramFunciones.ConfirmSave.parametros='&m_id_rubro='+maestro.id_rubro;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){			
	//para iniciar eventos en el formulario
	cmpId_cuenta=ClaseMadre_getComponente('id_cuenta');
				
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rubro_cuenta.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	   var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	   var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
var gestion =new Ext.form.ComboBox({
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
  ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:g_id_gestion,
			m_sw_rubro_cuenta:'si',
			m_id_rubro:maestro.id_rubro
		}
	});	
  /*componentes[4].setValue(g_id_gestion);
  
  componentes[3].store.baseParams={m_sw_cuenta_ejercicio:'si',m_id_gestion:g_id_gestion}; 
  componentes[3].modificado=true;*/
//cmpId_cuenta.store.baseParams={m_id_gestion:g_id_gestion,m_sw_rubro_cuenta:'si'}; 
cmpId_cuenta.setBaseParams('combo',{params:{start:0,limit:10,CantFiltros:7,id_gestion:g_id_gestion,sw_transaccional:1}});
cmpId_cuenta.setBaseParams('lov',{params:{start:0,limit:10,CantFiltros:7,id_gestion:g_id_gestion,dir:'asc',sort:'CUENTA.nro_cuenta'}});
//{params:{start:0,limit:paramConfig.pageSize,CantFiltros:0}}
  });

	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBotonCombo(gestion,'gestion');	
	layout_rubro_cuenta.getLayout().addListener('layout',this.onResize);
	layout_rubro_cuenta.getVentana(idContenedor).on('resize',function(){layout_rubro_cuenta.getLayout().layout()})
	
}