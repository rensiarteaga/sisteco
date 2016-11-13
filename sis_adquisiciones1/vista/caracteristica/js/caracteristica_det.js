/**
 * Nombre:		  	    pagina_caracteristica_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 09:57:27
 */
function pagina_caracteristica_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caracteristica/ActionListarCaracteristica_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_caracteristica',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_caracteristica',
		'caracteristica',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_solicitud_compra_det',
		'desc_solicitud_compra_det',
		'id_item_propuesto',
		'desc_item_propuesto',
		'desc_servicio_propuesto',
		'id_servicio_propuesto'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_servicio_propuesto:maestro.id_servicio_propuesto,
			id_item_propuesto:maestro.id_item_propuesto,
			m_id_solicitud_compra_det:maestro.id_solicitud_compra_det 
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	if(maestro.id_solicitud_compra_det>0){
		data1=[['Detalle Solicitud',maestro.id_solicitud_compra_det],['Solicitud',maestro.id_detalle]];
	}
	else{
		data1=[['Servicio Propuesto',maestro.id_servicio_propuesto],['Item Propuesto',maestro.id_item_propuesto],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]]
	}
	
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		
	
//	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
//	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
//	function italic(value){return '<i>'+value+'</i>';}
//	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
//	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data: data1}),cm:cmMaestro});
//	gridMaestro.render();
//	//DATA STORE COMBOS

    var ds_solicitud_compra_det = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra_det',totalRecords:'TotalCount'},['id_solicitud_compra_det','id_item_antiguo','cantidad','precio_referencial_estimado','fecha_reg','fecha_inicio_serv','fecha_fin_serv','descripcion','partida_presupuestaria','estado_reg','pac_verificado','id_solicitud_compra','id_tipo_servicio','id_item','monto_aprobado','mat_bajo_responsabilidad'])
	});

    /*var ds_item_propuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_propuesto/ActionListarItemPropuesto.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item_propuesto',totalRecords:'TotalCount'},['id_item_propuesto','nombre','descripcion','costo_estimado','observaciones','estado_reg','fecha_reg','id_unidad_medida_base','id_proveedor','id_moneda','id_usuario'])
	});*/

	//FUNCIONES RENDER
	
	function render_id_solicitud_compra_det(value, p, record){return String.format('{0}', record.data['desc_solicitud_compra_det']);}
	var tpl_id_solicitud_compra_det=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{id_item}</FONT>','</div>');

	/*function render_id_item_propuesto(value, p, record){return String.format('{0}', record.data['desc_item_propuesto']);}
	var tpl_id_item_propuesto=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
*/
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// id_caracteristica
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_caracteristica',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caracteristica'
	};
// txt caracteristica
	Atributos[1]={
		validacion:{
			name:'caracteristica',
			fieldLabel:'Caracteristica',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CARACT.caracteristica',
		save_as:'caracteristica'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CARACT.descripcion',
		save_as:'descripcion'
	};
// txt fecha_reg
	Atributos[3]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',			
			format: 'd/m/Y', //formato para validacion			
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:5
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CARACT.fecha_reg',
		dateFormat:'m-d-Y'
	};





	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	if(maestro.id_solicitud_compra_det>0){
		tituloM='Solicitud Detalle';
	}
	else{
		tituloM='Servicios Propuestos(Maestro)';
	}
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:tituloM,titulo_detalle:'Características (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_caracteristica = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_caracteristica.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_caracteristica,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/caracteristica/ActionEliminarCaracteristica.php',parametros:'&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det},
	Save:{url:direccion+'../../../control/caracteristica/ActionGuardarCaracteristica.php',parametros:'&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det},
	ConfirmSave:{url:direccion+'../../../control/caracteristica/ActionGuardarCaracteristica.php',parametros:'&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'caracteristica'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	if(maestro.id_solicitud_compra_det>0){
	    var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php?m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra_det',totalRecords: 'TotalCount'},['id_solicitud_comrpa_det','num_solicitud','tipo_adq','desc_empleado_tpm_frppa','desc_servicio','desc_item','descripcion','item','desc_cuenta','partida_presupuestaria'])
		});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra_det:maestro.id_solicitud_compra_det

			},
			callback:cargar_maestro
		});
		
		
		
	}
	else{
		Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
		
	}
	
	function cargar_maestro(){
			if(ds_maestro.getAt(0).get('tipo_adq')=='Bien'){
				data1=[['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Item',ds_maestro.getAt(0).get('desc_item')],['Descripcion',ds_maestro.getAt(0).get('item')],['Cuenta',ds_maestro.getAt(0).get('desc_cuenta')],['Partida',ds_maestro.getAt(0).get('partida_presupuestaria')]];
			}
			else{
				data1=[['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Servicio',ds_maestro.getAt(0).get('desc_servicio')],['Descripcion',ds_maestro.getAt(0).get('descripcion')],['Cuenta',ds_maestro.getAt(0).get('desc_cuenta')],['Partida',ds_maestro.getAt(0).get('partida_presupuestaria')]];
			}

		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));

		}
	
        
		
		
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_item_propuesto=datos.m_id_item_propuesto;	
		maestro.id_servicio_propuesto=datos.m_id_servicio_propuesto;
		maestro.id_solicitud_compra_det=datos.m_id_solicitud_compra_det;
		maestro.id_detalle=datos.m_id_detalle;
		maestro.nombre=datos.m_nombre;
		if(maestro.id_solicitud_compra_det>0){
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_solicitud_compra_det:maestro.id_solicitud_compra_det

				},
				callback:cargar_maestro
			});
		}
		else{
			
			data1=[['Servicio Propuesto',maestro.id_servicio_propuesto],['Item Propuesto',maestro.id_item_propuesto],['Nombre',maestro.nombre],['Descripcion',maestro.descripcion]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
		}
		
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_servicio_propuesto:maestro.id_servicio_propuesto,
				id_item_propuesto:maestro.id_item_propuesto,
				m_id_solicitud_compra_det:maestro.id_solicitud_compra_det
			}
		};
		this.btnActualizar();

	
		paramFunciones.btnEliminar.parametros='&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det;
		paramFunciones.Save.parametros='&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det;
		paramFunciones.ConfirmSave.parametros='&m_id_servicio_propuesto='+maestro.id_servicio_propuesto+'&m_id_item_propuesto='+maestro.id_item_propuesto+'&m_id_solicitud_compra_det='+maestro.id_solicitud_compra_det;
		this.InitFunciones(paramFunciones)
	};
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caracteristica.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	layout_caracteristica.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}