/**
* Nombre:		  	    pagina_registro_comprobante.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/

function pagina_SistemaDistribucion(idContenedor,direccion,paramConfig)
{ 
	
	var Atributos=new Array(),sw=0;
	
	 
	
	var componentes=new Array();

	//---DATA STORE
	this.setMoneda=function(id_moneda,simbolo){g_id_moneda=id_moneda;g_simbolo=simbolo};
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/SistemaDistribucion/ActionListarSistemaDistribucion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_sistema',totalRecords:'TotalCount'
		},[	 'id_sistema', 
			 'id_sistema_distribucion', 
			 'nombre_sistema_distribucion', 
			 'id_depto_conta', 
			 'nombre_depto', 
			 'conexion', 
			 { name: 'fecha_separacion',type:'date',dateFormat:'Y-m-d'},
		 	 'id_usuario', 
			 'nombre_completo', 
			 'fecha_reg',
			 'id_gestion',
			 'gestion',
		]),
		remoteSort:true});
 
	 
		//FUNCIONES RENDER
		var ds_id_sistema_distribucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/SistemaDBL/ActionListarSistemaDBL.php?'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_sistema_distribucion',totalRecords: 'TotalCount'},['id_sistema_distribucion','nombre_sistema_distribucion','representante'])});
		function render_id_sistema_distribucion(value, p, record){return String.format('{0}', record.data['nombre_sistema_distribucion']);}
		var tpl_id_sistema_distribucion=new Ext.Template('<div class="search-item">', '<b>Sistema: </b> <FONT COLOR="#0000ff">{nombre_sistema_distribucion} </FONT> ','</div>');
		
		
		var ds_id_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=conta_parametro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])});
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion}</FONT><br>','</div>');

		var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])});
		function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');

		//en la posición 0 siempre esta la llave primaria
		 Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_sistema',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			id_grupo:0,
			filtro_0:false,
			save_as:'id_sistema'
		};
	 
		// txt id_parametro
		Atributos[1]={
			validacion:{
				name:'id_sistema_distribucion',
				fieldLabel:'sistema',
				allowBlank:false,
				emptyText:'Sis...',
				desc: 'nombre_sistema_distribucion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_sistema_distribucion,
				valueField: 'id_sistema_distribucion',
				displayField: 'nombre_sistema_distribucion',
				queryParam: 'filterValue_0',
				filterCol:'nombre_sistema_distribucion',
				typeAhead:true,
				tpl:tpl_id_sistema_distribucion,
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
				renderer:render_id_sistema_distribucion,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:3

			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			//filtro_0:true,
			//filterColValue:'PARAM.gestion_conta',
			save_as:'id_sistema_distribucion'
		};
	//id_depto
		Atributos[2]={
			validacion:{
				name:'id_depto_conta',
				fieldLabel:'Departamento Contable',
				//allowBlank:false,
				allowBlank:true,
				emptyText:'Departamento...',
				desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'80%',
				//	onSelect:function(record){},
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:'80%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'dep.nombre_depto',
			save_as:'id_depto',
			id_grupo:1
		}; 	
		//id_gestion
		Atributos[3]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestión',
				//allowBlank:false,
				allowBlank:true,
				emptyText:'Gestion...',
				desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_gestion,
				valueField: 'id_gestion',
				displayField: 'gestion',
				queryParam: 'filterValue_0',
				filterCol:'gestion',
				typeAhead:false,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'80%',
				//	onSelect:function(record){},
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:'80%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'ges.gestion',
			save_as:'id_gestion',
			id_grupo:1
		}; 
		
	
		// txt conexion
		Atributos[4]={
			validacion:{
				name:'conexion',
				fieldLabel:'Conexión',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'sis.conexion',
			save_as:'conexion'
		};
	Atributos[5]= {
			validacion:{
				name:'fecha_separacion',
				fieldLabel:'Fecha Separación',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'sis.fecha_separacion',
			dateFormat:'m-d-Y',
			id_grupo:1,
			defecto:new Date(),
			save_as:'fecha_separacion'
		};
			// txt conexion
		Atributos[6]={
			validacion:{
				name:'nombre_completo',
				fieldLabel:'Usuario',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'usu.nombre_completo',
			save_as:'nombre_completo'
		};
					// txt conexion
		Atributos[7]={
			validacion:{
				name:'fechareg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'sis.fechareg' 
		};
		
		// txt conexion
		Atributos[8]={
			validacion:{
				name:'nombre_sistema_distribucion',
				fieldLabel:'nombre_sistema_distribucion',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'sis.nombre_sistema_distribucion',
			save_as:'nombre_sistema_distribucion'
		};
		// txt pedido
		//alert ("llega alos parametros  comprobante 953");
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE

		var config={titulo_maestro:'SistemaDistribucion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_cobranza/vista/SistemaDistribucionProceso/ProcesoFacturacionCobranza.php'};
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
		 
			var paramMenu={			actualizar:{crear:true,separador:false} };
	  
		//Obtiene los Atributos en array de componentes
		//alert('Atributos:'+Atributos.length)

		
	 
	 
		 
		
 
	 

		

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/SistemaDistribucion/ActionEliminarSistemaDistribucion.php'},
			Save:{url:direccion+'../../../control/SistemaDistribucion/ActionGuardarSistemaDistribucion.php'
			},
			ConfirmSave:{url:direccion+'../../../control/SistemaDistribucion/ActionGuardarSistemaDistribucion.php'},
			Formulario:{
				html_apply:'dlgInfo-'+idContenedor,
				height:400,width:480,minWidth:150,minHeight:200,columnas:['95%'],
				grupos:[
				{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Sistema de Distribucion :',columna:0,id_grupo:1},
				{tituloGrupo:'Datos de Seguridad:',columna:0,id_grupo:2}
				
				],
				closable:true,
				titulo:'Registro Comprobante'}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos

		function InitRegistroComprobante()
		{
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();

			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
			//recuperar los componentes
			 comp_id_sistema_distribucion=ClaseMadre_getComponente('id_sistema_distribucion');
			 comp_nombre_sistema_distribucion=ClaseMadre_getComponente('nombre_sistema_distribucion');
			
				comp_id_sistema_distribucion.on('select',f_set_nombre_sistema_distribucion);	
			
			getSelectionModel().on('rowselect',	function( SM,rowIndex){
				datas_edit=SM.getSelected().data;
				var_rowIndex=rowIndex;})
		 

		};
		
		function f_set_nombre_sistema_distribucion( combo, record, index ){
			comp_nombre_sistema_distribucion.setValue(record.data.nombre_sistema_distribucion);
		}

		this.btnActualizar= function ()
		{_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.limpiarStore();
		ClaseMadre_btnActualizar();
		}
	   



		this.EnableSelect=function(sm,row,rec){
			cm_EnableSelect(sm,row,rec);
			_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.reload(rec.data,'no');
			edit_cbte= rec.data;
			//_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.desbloquearMenu();
			//if(sw_editar=='no'){
			//_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.bloquearMenu();
			//_CP.getPagina(layout_SistemaDistribucion.getIdContentHijo()).pagina.getBoton('monedas-'+layout_SistemaDistribucion.getIdContentHijo()).enable();
			//}
			g_comprobante=rec.data.id_comprobante;
			g_subsistema=rec.data.id_subsistema;
			g_titulo=rec.data.titulo_cbte;
			g_cbte=rec.data.momento_cbte;
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
				//CM_mostrarGrupo('Oculto:');

				layout_SistemaDistribucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				//carga datos XML
				ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
				//DATA STORE COMBOS

}
