/**
* Nombre:		  	    TipoFacturacionCobranza.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/

function pagina_TipoFacturacionCobranza(idContenedor,direccion,paramConfig)
{ 
	
	var Atributos=new Array(),sw=0;
	
	 
	
	var componentes=new Array();

	//---DATA STORE
	this.setMoneda=function(id_moneda,simbolo){g_id_moneda=id_moneda;g_simbolo=simbolo};
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/TipoFacturacionCobranza/ActionListarTipoFacturacionCobranza.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_tipo_facturacion_cobranza',totalRecords:'TotalCount'
		},[	'id_tipo_facturacion_cobranza', 
			'nombre_proceso', 
			'sw_periodo', 
			'sw_banco'

		]),
		remoteSort:true});

	 function render_sw_periodo(value, p, record){	if(value=='si'){return 'SI';}if(value=='no'){return 'NO';}}
	 function render_sw_banco(value, p, record){	if(value=='si'){return 'SI';}if(value=='no'){return 'NO';}}
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		

		//en la posición 0 siempre esta la llave primaria
		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_tipo_facturacion_cobranza',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			id_grupo:0,
			filtro_0:false,
			save_as:'id_tipo_facturacion_cobranza'
		};
	 	Atributos[1]={
			validacion:{
				name:'nombre_proceso',
				fieldLabel:'Proceso',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'nombre_proceso',
			save_as:'nombre_proceso'
		};
		
		
		Atributos[2]={
			validacion:{
				name:'sw_periodo',
				fieldLabel:'SW Periodo',
				allowBlank:false,
				align:'left',
				emptyText:'Period...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_periodo,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			save_as:'sw_periodo'
		};
		Atributos[3]={
			validacion:{
				name:'sw_banco',
				fieldLabel:'SW Banco',
				allowBlank:false,
				align:'left',
				emptyText:'Fecha...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_banco,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			save_as:'sw_banco'
				};
		// txt pedido
		//alert ("llega alos parametros  comprobante 953");
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE

		var config={titulo_maestro:'SistemaDistribucion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_cobranza/vista/TipoFacturacionCobranza/ColumnaValor.php'};
		var layout_SistemaDistribucion=new DocsLayoutMaestroDeatalle(idContenedor);


		layout_SistemaDistribucion.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////
		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_SistemaDistribucion,idContenedor);
		//herencia
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		
		var ClaseMadre_getGrid=this.getGrid;
		
		var CM_btnNew=this.btnNew;
		var CM_saveSuccess=this.saveSuccess;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_getComponente=this.getComponente;
		var CM_btnEdit =this.btnEdit;
		var ClaseMadre_Eliminar =this.btnEliminar;
		var ClaseMadre_save=this.Save;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var ClaseMadre_conexionFailure=this.conexionFailure
		var CM_getFormulario=this.getFormulario;
		var CM_getComponente=this.getComponente;



		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////
		//guardar:{crear:false,separador:false},
		 
			var paramMenu={	nuevo:{crear:true,separador:true},
							editar:{crear:true,separador:false},
							eliminar:{crear:true,separador:false},
							actualizar:{crear:true,separador:false},
							excel:{crear:true,separador:false}};
	  
		//Obtiene los Atributos en array de componentes
		//alert('Atributos:'+Atributos.length)

		
	 
	 
		 
		
 
	 

		

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/TipoFacturacionCobranza/ActionEliminarTipoFacturacionCobranza.php'},
			Save:{url:direccion+'../../../control/TipoFacturacionCobranza/ActionGuardarTipoFacturacionCobranza.php'
			},
			ConfirmSave:{url:direccion+'../../../control/TipoFacturacionCobranza/ActionGuardarTipoFacturacionCobranza.php'},
			Formulario:{
				html_apply:'dlgInfo-'+idContenedor,
				height:400,width:480,minWidth:150,minHeight:200,columnas:['95%'],
				grupos:[
				{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Tipo Proceso Facturación Cobranza:',columna:0,id_grupo:1} 
				
				],
				closable:true,
				titulo:'Registro Tipo Facturacion y Cobranza'}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos

		function InitRegistroComprobante()
		{
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();

			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
		 
		 

		};
		
	 

		this.btnActualizar= function ()
		{_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.limpiarStore();
		ClaseMadre_btnActualizar();
		}
	   



		this.EnableSelect=function(sm,row,rec){
			cm_EnableSelect(sm,row,rec);
			_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.reload(rec.data,'no');
			edit_cbte= rec.data;
			_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.desbloquearMenu();
			//if(sw_editar=='no'){
			//_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.bloquearMenu();
			//_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.getBoton('monedas-'+layout_SistemaDistribucion.getIdContentHijo()).enable();
			//}
			
		}
 
	function btn_estado_proceso(){
		 var sm=getSelectionModel();
		 var filas=ds.getModifiedRecords();
		 var cont=filas.length;
		 var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='id_tipo_facturacion_cobranza='+SelectionsRecord.data.id_tipo_facturacion_cobranza; 
			data+='&nombre_proceso='+SelectionsRecord.data.nombre_proceso; 
			data+='&sw_periodo='+SelectionsRecord.data.sw_periodo; 
			data+='&sw_banco='+SelectionsRecord.data.sw_banco; 
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_SistemaDistribucion.loadWindows(direccion+'../../../../sis_cobranza/vista/TipoFacturacionCobranza/EstadoProceso.php?'+data,'Columna',ParamVentana);
			sm.clearSelections();
			}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
 

				//para que los hijos puedan ajustarse al tamaño
				this.getLayout=function(){return layout_SistemaDistribucion.getLayout()};
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones

				this.iniciaFormulario();
				//	iniciarEventosFormularios();
				InitRegistroComprobante();
 				CM_AdicionarMenuBoton=this.AdicionarMenuBoton;
				CM_getBotonMenuBotonNombre=this.getBotonMenuBotonNombre;
				CM_getMenuBoton=this.getMenuBoton;

			

				 

 

				CM_ocultarGrupo('Oculto:');
			 
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Columna',btn_estado_proceso,true,'estado Proceso','Estado Proceso');
 
				layout_SistemaDistribucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				//carga datos XML
				ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
				//DATA STORE COMBOS

}
