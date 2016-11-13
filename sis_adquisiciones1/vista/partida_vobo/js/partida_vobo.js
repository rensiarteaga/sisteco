/**
 * Nombre:		  	    partida_vobo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 10:05:35
 */
//function partida_vobo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
function pagina_partida_vobo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_vobo/ActionListarPartidaVobo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_partida_vobo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_partida_vobo',
		'id_partida',
		'desc_partida',
		'id_parametro_adquisicion',
		'gestion',
		'estado_reg','id_vobo_detalle'
		

		]),remoteSort:true});

		
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_vobo_detalle:maestro.id_vobo_detalle
			
		}
	});
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
/*
id_parametro_adquisicion',$f["id_parametro_adquisicion"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('fecha',$f["fecha"]);
		    $xml->add_nodo('id_gestion_subsistema',$f["id_gestion_subsistema"]);
		    $xml->add_nodo('id_subsistema',$f["id_subsistema"]);
		    $xml->add_nodo('id_gestion',$f["id_gestion"]);
		    $xml->add_nodo('gestion
*/

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords:'TotalCount'},['id_partida','desc_partida','codigo_partida','nombre_partida','sw_transaccional','sw_movimiento','desc_par'])
	});

    var ds_parametro_adquisicion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_adquisicion/ActionListarParametroAdquisicion.php?estado=activo'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_adquisicion',totalRecords:'TotalCount'},['id_parametro_adquisicion','estado','fecha','id_gestion_subsistema','id_subsistema','id_gestion','gestion'])
	});

    

	//FUNCIONES RENDER
	
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{codigo_partida}</i></b>','<b><i>-{nombre_partida}</i></b>','<br><FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

	function render_id_parametro_adquisicion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_parametro_adquisicion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_servicio_proveedor
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_partida_vobo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_vobo'
	};
	
	
	Atributos[1]= {
			validacion: {
			name:'id_parametro_adquisicion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro_adquisicion,
			valueField: 'id_parametro_adquisicion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_parametro_adquisicion,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:350,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro_adquisicion,
			grid_visible:true,
			grid_editable:true,
			onSelect: function(record){
                ds_partida.baseParams={'id_gestion_reporte':record.data.id_gestion,
                'sw_transaccional':1};
                getComponente('id_parametro_adquisicion').setValue(record.data.id_parametro_adquisicion);
                getComponente('id_parametro_adquisicion').setRawValue(record.data.gestion);
                getComponente('id_parametro_adquisicion').collapse();
                ds_partida.modificado=true;
                
      		},
			grid_indice:3,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		save_as:'id_parametro_adquisicion'
	};
	
//	Atributos[2]={
//		validacion:{
//			name:'id_partida',
//			desc:'desc_partida',
//			fieldLabel:'Partida',
//			allowBlank:false,
//			maxLength:100,
//			minLength:0,
//			store:ds_partida,
//			renderer:render_id_partida,
//			selectOnFocus:true,
//			vtype:"texto",
//			grid_visible:true,
//			grid_editable:false,
//			width_grid:170,
//			width:200,
//			pageSize:10,
//			//direccion:direccion,
//			grid_indice:1
//			},
//		//tipo:'LovServicio',
//		tipo:'ComboBox',
//		save_as:'id_partida',
//		filtro_0:true,
//		defecto:'',
//		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida'
//		
//	};
	
	
	Atributos[2]= {
			validacion: {
			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:350,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:true,
			grid_indice:3,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};


	
	Atributos[3]={
			validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTVB.estado_reg',
		defecto:'activo',
		save_as:'estado_reg'
	};
	
	Atributos[4]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_vobo_detalle',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:maestro.id_vobo_detalle,
			save_as:'id_vobo_detalle'
			
			
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	/*var config={titulo_maestro:'Proveedores (Maestro)',titulo_detalle:'Servicios (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_servicio_proveedor = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_servicio_proveedor.init(config);*/
	
	//var config={titulo_maestro:'partida-verificacion tecnica',grid_maestro:'grid-'+idContenedor};
//	var config={titulo_maestro:'Partida-Verificacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_vobo/vobo_detalle.php'};
//	
//	//var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/solicitud_compra_bien/sol_compra_bien_det.php'};
//	var layout_partida_vobo=new DocsLayoutMaestroDeatalle(idContenedor);
//	layout_partida_vobo.init(config);
//
	var config={titulo_maestro:'Solicitud Compra (Maestro)',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_partida_vobo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_partida_vobo.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_partida_vobo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/partida_vobo/ActionEliminarPartidaVobo.php'},
	Save:{url:direccion+'../../../control/partida_vobo/ActionGuardarPartidaVobo.php'},
	ConfirmSave:{url:direccion+'../../../control/partida_vobo/ActionGuardarPartidaVobo.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Partida-Verificación Técnica'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	
//-------------- Sobrecarga de funciones --------------------//
var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/detalle_vobo/ActionListarDetalleVobo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_vobo_detalle',totalRecords: 'TotalCount'},['id_vobo_detalle',
		
		'id_depto',
        'desc_depto',
		'id_usuario',
        'desc_empleado',
		'id_partida_vobo',
        'estado_reg'
		])
		});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_vobo_detalle:maestro.id_vobo_detalle

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			data1=[['Nro Solicitud',ds_maestro.getAt(0).get('desc_depto')],['Funcionario',ds_maestro.getAt(0).get('desc_empleado')]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
		}

	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_vobo_detalle=datos.m_id_vobo_detalle;
		
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_vobo_detalle:maestro.id_vobo_detalle

				},
				callback:cargar_maestro
			});
			
		
		
		
		this.btnActualizar();
		iniciarEventosFormularios();

		Atributos[4].defecto=maestro.id_vobo_detalle;
		
		
		paramFunciones.btnEliminar.parametros='&m_id_vobo_detalle='+maestro.id_vobo_detalle;
		paramFunciones.Save.parametros='&m_id_vobo_detalle='+maestro.id_vobo_detalle;
		paramFunciones.ConfirmSave.parametros='&m_id_vobo_detalle='+maestro.id_vobo_detalle;
		this.InitFunciones(paramFunciones);
		this.btnActualizar();
	};
			
	function iniciarEventosFormularios(){

				
			
	}
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_partida_vobo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/user_otro.png','Empleado Verificación',btn_autorizacion,true,'autorizacion','');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	
	layout_partida_vobo.getLayout().addListener('layout',this.onResize);
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
	
}