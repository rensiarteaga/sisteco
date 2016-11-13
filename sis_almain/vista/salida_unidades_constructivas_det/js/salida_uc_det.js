function pagina_salida_uc_det(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_salida_uc_det;
	

	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/salida_unidades_constructivas_det/ActionListarSalidaUnidadConstructivaDet.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_salida_uc_detalle',
					totalRecords : 'TotalCount'
				}, [ 	'id_salida_uc_detalle', 'id_salida_uc', 'cantidad',
						'id_unidad_constructiva', 'desc_uc',
						'usuario_reg','fecha_reg'
						
				]),
				remoteSort : true
			});
	 
	  var ds_uc = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php?f_salida_uc_det=true'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_unidad_constructiva','desc_unidad_constructiva','codigo','nombre','descripcion'])
	});
	 
	  function render_id_uc(value, p, record){return String.format('{0}', record.data['desc_uc']);}
	  
	  var tpl_uc = new Ext.Template('<div class="search-item">','<b>{codigo}</b><br>','<FONT COLOR="#B5A642">{nombre} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT></br>','</div>');
		
	 vectorAtributos =
	[
	  
	 {
		 validacion:{
				labelSeparator:'',
				name: 'id_salida_uc_detalle',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false,
				width_grid:80 
			},
			tipo: 'Field',
			filtro_0:false,
			save_as : 'hidden_id_salida_uc_det'
	 },
	 {
			validacion : {
				labelSeparator : '',
				name : 'id_salida_uc',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			form : true,
			save_as : 'hidden_id_salida_uc'
	 },
	 {
		 validacion: {
				name:'id_unidad_constructiva',
				fieldLabel:'Unidad Constructiva',
				allowBlank:true,
				emptyText:'UnidadConstructiva...',
				name: 'id_unidad_constructiva',
				desc: 'desc_uc',
				store:ds_uc,
				valueField: 'id_unidad_constructiva',
				displayField: 'desc_unidad_constructiva',
				queryParam: 'filterValue_0',
				filterCol:'',
				tpl: tpl_uc,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:300,
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_uc,
				grid_visible:true,
				grid_editable:false,
				width_grid:200, // ancho de columna en el grid
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'uc.codigo#uc.descripcion',
			defecto: '',
			save_as:'txt_id_uc'
	 },
	 {
		 validacion : {
				name :'cantidad',
				fieldLabel : 'Cantidad',
				allowBlank : false,  
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				decimalPrecision : 2,
				vtype:"texto",
				minValue : '0',
				minValue : '0',
				round : false,
				align : 'right',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width:285
			},
			tipo : 'NumberField',
			filtro_0 : true,
			filterColValue : 'sucd.cantidad',
			form : true,
			save_as : 'txt_cantidad'
	 },
	 {
		 validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'sucd.usuario_reg',
			form : false
	 },
	 {
		 validacion : {
				name : 'fecha_reg',
				fieldLabel : 'Fecha Registro',
				format : 'd/m/Y',
				minValue : '01/01/1900',
				grid_visible : true,
				grid_editable : false,
				//renderer : formatDate,
				align : 'center',
				width_grid : 95
			},
			tipo : 'TextField',
			form : false,
			filtro_0 : false,
			dateFormat : 'm-d-Y'
	 }
	                    
	 ];
	 
	 

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
			titulo_maestro:'SalidaUC (Maestro)',
			grid_maestro:'grid-'+idContenedor
		};
	layout_salida_uc_det = new DocsLayoutMaestro(idContenedor);
	layout_salida_uc_det.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_uc_det,idContenedor);
	
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_btnEdit = this.btnEdit;
	var CM_enableSelect=this.EnableSelect;
	this.btnNew =function()
	{
		ClaseMadre_btnNew();
		ClaseMadre_getComponente('id_salida_uc').setValue(maestro.id_salida_uc);
		ds_uc.baseParams.id_uc_filtro = maestro.id_unidad_constructiva;
	}
	this.btnEdit = function()
	{
		cm_btnEdit();
		ds_uc.baseParams.id_uc_filtro = maestro.id_unidad_constructiva;
	}
	
	this.reload=function(m)
	{
		maestro = m;
		ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_salida_uc : maestro.id_salida_uc
				}
			};
		this.btnActualizar();
	};
	
	var paramMenu={
			nuevo:{crear:false,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
	};
	
	
	var paramMenu = {	nuevo : {crear : true,separador : true},
						editar : {crear : true,separador : false},
						eliminar : {crear : true,separador : false},
						actualizar : {crear : true,separador : false}
					};
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/salida_unidades_constructivas_det/ActionEliminarSalidaUnidadConstructivaDet.php'},
	Save:{url:direccion+'../../../control/salida_unidades_constructivas_det/ActionGuardarSalidaUnidadConstructivaDet.php'},
	ConfirmSave:{url:direccion+'../../../control/salida_unidades_constructivas_det/ActionGuardarSalidaUnidadConstructivaDet.php'},
	Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:340,width:480,
					minWidth:150,minHeight:200,closable:true,titulo: 'Salida Unidades Constructivas Detalle'
				}
	};
	/*
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
		_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.desbloquearMenu();
	}
	*/
	function iniciarEventosFormularios()
	{
		 
	}
	
	function btnDetalleItem()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect == 1)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "m_id_salida_uc_detalle=" + SelectionsRecord.data.id_salida_uc_detalle;
			//data = data+"&m_cantidad="+SelectionsRecord.data.cantidad;
			data = data+"&m_id_unidad_constructiva="+SelectionsRecord.data.id_unidad_constructiva;
			data = data+"&m_desc_uc="+SelectionsRecord.data.desc_uc;
			//data = data+"&m_id_almacen="+maestro.id_almacen; 
	
			
			var ParamVentana={Ventana:{width:'60%',height:'70%'}};
			layout_salida_uc_det.loadWindows(direccion+'../../../../sis_almain/vista/salida_unidades_constructivas_det_item/salida_uc_det_item.php?'+data,'Clasificacion Items',ParamVentana);
		}
		else if(NumSelect > 1)
		{
			Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe tener seleccionado un registro.'); 
		}
	}
	
	// -------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	
	// Botones adicionales en el menu
	this.AdicionarBoton('../../../lib/imagenes/bricks.png','Detalle-Item', btnDetalleItem, false,'detalleItem', 'Detalle-Item');
	
	cm_BloquearMenu();
	
	iniciarEventosFormularios();
	layout_salida_uc_det.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	 
}