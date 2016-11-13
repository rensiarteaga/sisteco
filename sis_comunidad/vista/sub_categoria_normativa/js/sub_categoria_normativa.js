/**
 * Nombre:		  	    sub_categoria_normativa.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2013-05-16 11:47:22
 */
function pagina_detalle_normativa(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sub_categoria_normativa/ActionListarSubCategoriaNormativa_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_detalle_normativa',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_detalle_normativa',
		'nombre_subcategoria',
		'descripcion_subcategoria',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'id_normativa_interna',

		]),remoteSort:true});

	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_adq:maestro.id_tipo_adq,
			m_codigo:maestro.codigo
		}
	});*/
	// DEFINICIÓN DATOS DEL MAESTRO

var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		


	//FUNCIONES RENDER
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_servicio
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_detalle_normativa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		//save_as:'id_tipo_servicio'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre_subcategoria',
			fieldLabel:'NOMBRE',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DN.nombre_subcategoria',
		//save_as:'nombre',
		id_grupo:0
	};

	
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion_subcategoria',
			fieldLabel:'DESCRIPCION',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:350,
			width:'100%',
			disable:false
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DN.descripcion_subcategoria',
		//save_as:'descripcion',
		id_grupo:0
	};
// txt id_tipo_adq
	Atributos[3]={
		validacion:{
			name:'id_normativa_interna',
			fieldLabel:'CODIGO',
			labelSeparator:'',
			//inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			disabled:false
		},
		form: false,
		tipo:'Field',
		filtro_0:false
		//defecto:maestro.id_normativa_interna
		//save_as:'id_tipo_adq'
	};
 
	
	// txt fecha_reg
	Atributos[4]= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'FECHA DE REGISTRO',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:150,
			disabled:true,
			grid_indice:7	
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DN.fecha_registro',
		dateFormat:'m-d-Y'
		
	};

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipos de adquisiciones (Maestro)',titulo_detalle:'Tipos de Servicio (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_servicio = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_tipo_servicio.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tipo_servicio,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getDialog=this.getDialog;
	

//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/sub_categoria_normativa/ActionEliminarSubCategoriaNormativa.php'},
	Save:{url:direccion+'../../../control/sub_categoria_normativa/ActionGuardarSubCategoriaNormativa.php'},
	ConfirmSave:{url:direccion+'../../../control/sub_categoria_normativa/ActionGuardarSubCategoriaNormativa.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:650,minWidth:150,minHeight:150,	closable:true,titulo:'SUBCATEGORIA DE CADA NORMATIVA'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	
	/*var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/tipo_adq/ActionListarTipoAdq.php?id_tipo_adq='+maestro.id_tipo_adq}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_adq',totalRecords: 'TotalCount'},['id_tipo_adq',
		'nombre',
		'codigo',
		'descripcion',
		'observaciones','tipo_adq'
		])
		});
		
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_tipo_adq:maestro.id_tipo_adq

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
		
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Tipo de Adquisición',ds_maestro.getAt(0).get('tipo_adq')],['Nombre',ds_maestro.getAt(0).get('nombre')],['Código',ds_maestro.getAt(0).get('codigo')],['Descripción',ds_maestro.getAt(0).get('descripcion')]]));
		}*/
		/*Lo siguiente se encarga de mandar a mi ActionListarSubCategoria_det.php el id de Normativas internas del grid superior*/
		this.reload=function(m){
			maestro=m;
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_normativa_interna:maestro.id_normativa_interna
					//maestro.id_tipo_adq=datos.m_id_tipo_adq;
				}
			};
			this.btnActualizar();
			
			
			
			Atributos[4].defecto=maestro.id_normativa_interna;
			paramFunciones.btnEliminar.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq+'&m_codigo='+maestro.codigo;
			paramFunciones.Save.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq+'&m_codigo='+maestro.codigo;
			paramFunciones.ConfirmSave.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq+'&m_codigo='+maestro.codigo;
			this.InitFunciones(paramFunciones)
		};
	/*  
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_tipo_adq=datos.m_id_tipo_adq;
    		maestro.nombre=datos.m_nombre;
    		maestro.codigo=datos.m_codigo;
    		maestro.descripcion=datos.m_descripcion
			ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_tipo_adq:maestro.id_tipo_adq

				},
				callback:cargar_maestro
			});
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_adq:maestro.id_tipo_adq,
				m_descripcion:maestro.descripcion,
				m_codigo:maestro.codigo
			}
		};
		this.btnActualizar();
		//Atributos[4].defecto=maestro.id_tipo_adq;
		//Atributos[5].defecto=maestro.descripcion;
		//paramFunciones.btnEliminar.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq;
		//paramFunciones.Save.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq+'&m_codigo='+maestro.codigo;
		//paramFunciones.ConfirmSave.parametros='&m_id_tipo_adq='+maestro.id_tipo_adq+'&m_codigo='+maestro.codigo;
		this.InitFunciones(paramFunciones)
	};*/
	function btn_servicio(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_detalle_normativa='+SelectionsRecord.data.id_detalle_normativa;
			data=data+'&m_nombre_subcategoria='+SelectionsRecord.data.nombre_subcategoria;   
			data=data+'&m_descripcion_subcategoria='+SelectionsRecord.data.descripcion_subcategoria;
            data=data+'&m_codigo='+SelectionsRecord.data.id_normativa_interna;
			var ParamVentana={Ventana:{width:'85%',height:'70%'}};
			layout_tipo_servicio.loadWindows(direccion+'../../../vista/archivos_normativas_internas1/archivos_normativas_internas.php?'+data,'Archivos',ParamVentana);
            layout_tipo_servicio.getVentana().on('resize',function(){
			layout_tipo_servicio.getLayout().layout();
				})
		}  
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
   /* this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		    var dialog=CM_getDialog();
		    dialog.setContentSize(500,230);
		    CM_ocultarGrupo('Datos de Cuenta');
            CM_ocultarGrupo('Datos de Partida');
            CM_mostrarGrupo('Tipo de Servicio');
            //getComponente('estado').enable();
			var SelectionsRecord=sm.getSelected();
			var data=SelectionsRecord.data.id_proceso_compra;
        	verificar_NumServicios();
			CM_btnEdit();
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
		
    this.btnNew=function(){
        var dialog=CM_getDialog();
		dialog.setContentSize(500,230);
        CM_ocultarGrupo('Datos de Cuenta');
        CM_ocultarGrupo('Datos de Partida');
        CM_mostrarGrupo('Tipo de Servicio');
        //verificar_NumServicios();
	    //getComponente('codigo').enable();
	    //getComponente('estado').disable();
		CM_btnNew();
	}		*/
		
	//para verificar
    function verificar_NumServicios(){
	   		var sm=getSelectionModel();
	   		var filas=ds.getModifiedRecords();
	   		var cont=filas.length;
	   		var NumSelect=sm.getCount();
	   		var SelectionsRecord=sm.getSelected();
	   		var data='m_id_tipo_servicio='+SelectionsRecord.data.id_detalle_normativa;
	
		Ext.Ajax.request({
			url:direccion+"../../../control/servicio/ActionListarServicio_det.php?"+data,
			method:'GET',
			success:verificar,
			failure:CM_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}
	
	function verificar(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				num_tipo_servicios=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  	 getComponente('codigo').disable();
				  }else{
				 	 getComponente('codigo').enable();
				}
			}
		}
			
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_servicio.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','VER ARCHIVOS',btn_servicio,true,'servicio','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_servicio.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}