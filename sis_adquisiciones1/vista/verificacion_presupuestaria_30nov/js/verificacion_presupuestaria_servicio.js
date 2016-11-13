function pagina_verificacion_presupuestaria_servicio(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var data='';
	var id_solicitud_compra;
	var reporte;
	//prueba guardado
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
				'observaciones',
		'justificacion',
		'localidad',
		'siguiente_estado',
		'tipo_adjudicacion',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'desc_empleado_tpm_frppa',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_cuenta',
		'desc_cuenta',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'reformulacion',
		'dias_max',
		'dias_min',
		'dias',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'tipo_adq',
		'num_solicitud',
		'estado',
		'numeracion_periodo',
		'gestion',
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'preaprobador',
		'aprobador',
		'tiene_presupuesto',
		'permite_agrupar'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

   var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php?tipo=sol'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre','desc_categoria_adq','precio_min','precio_max'])
	});
	//FUNCIONES RENDER
	function render_id_tipo_categoria_adq(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:blue;font-size:8pt">' + record.data['desc_tipo_categoria_adq']+ '</span>'}else{return record.data['desc_tipo_categoria_adq']}}
	var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria_adq}</i></b>','<br><b>{precio_min} - {precio_max} Bs.<b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');
	
		
		function negrita(val,cell,record,row,colum,store){
			if(record.get('reformulacion')=='1'){
								
				
					return '<span style="color:blue;font-size:8pt">' + val + '</span>';
				}
			
			
			else if(record.get('tiene_presupuesto')=='0'){
					return '<b>' + val + '</b>';
			}
			else
			{
				return val;
			}
		}
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_solicitud_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra'
	};

    Atributos[13]={
		validacion: {
			name:'permite_agrupar',
			fieldLabel: 'Agrupar',
			width: '8%',
			grid_visible:false, 
			grid_editable:false, 
			width_grid:40,
			renderer:formatBoolean 
		},
		tipo:'Checkbox',
		form:true,
		id_grupo:2
	};
	
	
	
		// txt num_solicitud
	Atributos[3]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Período/Nº Sol.',
			align:'right',
			grid_visible:true,
			width_grid:70,
			grid_indice:1,
			renderer:negrita
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo'

	};
	
	
// txt id_empleado_frppa_solicitante
	Atributos[1]={
			validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			grid_visible:true,
			renderer:negrita,
			width_grid:120,
			grid_indice:2
				
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre'
	};
	
	// txt id_unidad_organizacional
	Atributos[2]={
			validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:true,
			width_grid:120,
			grid_indice:7	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Adquisicion',
			name: 'tipo_adq',
			inputType:'hidden',
			grid_visible:false
			
		},
		tipo: 'Field',
		filtro_0:true,
		form:false
	};
	
	
// txt id_tipo_categoria_adq
	Atributos[5]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Modalidad',
			allowBlank:false,			
			emptyText:'Modalidad...',
			desc: 'desc_tipo_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_categoria_adq,
			valueField: 'id_tipo_categoria_adq',
			displayField: 'desc_categoria_adq',
			queryParam: 'filterValue_0',
			filterCol:'CATADQ.nombre#CATADQ.precio_min#CATADQ.precio_max',
			typeAhead:true,
			tpl:tpl_id_tipo_categoria_adq,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			listWidth:350,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			renderer:render_id_tipo_categoria_adq,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'90%',
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:false,
		filterColValue:'TIPCAT.nombre',
		id_grupo:2
	};

// txt id_rpa
	Atributos[6]={
			validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			grid_visible:true,
			width_grid:100,
			width:'80%',
			grid_indice:10	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.gestion'
	};


	
	// txt localidad
	Atributos[7]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			grid_visible:true,
			width_grid:100,
			width:'45%',
			grid_indice:9		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ESTCOM.nombre'
	};
	
	// txt estado_vigente_solicitud
	Atributos[8]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones Pre-aprobación',
			grid_visible:true,
			width_grid:130,
			grid_indice:4		
		},
		tipo: 'Field',
		form: false,
		filtro_0:false,
		filtro_1:false
	};
	
	
	// txt id_moneda
	Atributos[9]={
			validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			grid_visible:true,
			width_grid:120,
			grid_indice:6		
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.nombre'
	};
	
	
		
	// txt localidad
	Atributos[11]={
		validacion:{
			name:'fecha_sol',
			fieldLabel:'Fecha',
			grid_visible:true,
			renderer: formatDate,
			width_grid:80,
			grid_indice:5
			
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.fecha_reg'
	};
	
	
	// txt observaciones
	Atributos[12]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			grid_visible:true,
			width_grid:100,
			grid_indice:4		
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SEGSOL.observaciones'
	};

// txt id_fina_regi_prog_proy_acti
	Atributos[10]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:8,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep'
		};
		
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////

		function formatBoolean(value){
			return value;
		};

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};


		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Aprobacion Gerencial',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/detalle_verificacion_solicitud_servicio/detalle_verificacion_solicitud_det.php'};
		var layout_verificacion_presupuestaria_servicio=new DocsLayoutMaestroDetalleEP(idContenedor);
		layout_verificacion_presupuestaria_servicio.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_verificacion_presupuestaria_servicio,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var CM_enableSelect=this.EnableSelect;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		///////////////////////////////////
		// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
		///////////////////////////////////

		var paramMenu={
			editar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
		//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
			//Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
			Save:{url:direccion+'../../../control/solicitud_compra/ActionModificarModalidadSolCom.php'},
			//ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
			ConfirmSave:{url:direccion+'../../../control/solicitud_compra/ActionModificarModalidadSolCom.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,columnas:['90%'],grupos:[
			{tituloGrupo:'Datos',columna:0,id_grupo:0},
			{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1},
			{tituloGrupo:'Categoria',columna:0,id_grupo:2}
			],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Aprobacion Gerencial'}};
			//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//



			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				txt_check=getComponente('permite_agrupar');

				var onCheck=function(e,v){
					if(!v){
						getComponente('id_tipo_categoria_adq').enable();
					}else{
						getComponente('id_tipo_categoria_adq').disable();
					}
				}

				txt_check.on('check', onCheck);
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_verificacion_presupuestaria_servicio.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_verificacion_presupuestaria_servicio.getIdContentHijo()).pagina.bloquearMenu()
					}
				})

			}




			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					CM_ocultarGrupo('Datos');
					CM_ocultarGrupo('Estructura Programatica');
					CM_btnEdit();
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}





			function btn_cancelar(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					Ext.MessageBox.show({
						title: 'Observaciones',
						msg: 'Ingrese observaciones a la solicitud:',
						width:300,
						buttons: Ext.MessageBox.OK,
						multiline: true,
						fn: getObservaciones

					});
					data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					data=data+'&operacion=cancelar';


				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}



			function btn_aprobar(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();

					if(parseFloat(SelectionsRecord.data.tiene_presupuesto)>0){
						Ext.MessageBox.show({
							title: '<span style="color:blue;font-size:15pt"> SOLICITUD CATEGORIA '+SelectionsRecord.data.desc_tipo_categoria_adq +'</span>' ,
							msg: 'Ingrese las observaciones de aprobación:',
							width:600,
							buttons: Ext.MessageBox.OK,
							multiline: true,
							fn: getObservaciones

						});
						id_solicitud_compra=SelectionsRecord.data.id_solicitud_compra;
						data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
						data=data+'&operacion=aprobar_presupuesto';
					}else{

						Ext.MessageBox.alert('Atención', 'No tiene presupuesto para aprobar esta solicitud');

					}
				}

				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

			function btn_correccion(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					Ext.MessageBox.show({
						title: 'Observaciones de Corrección',
						msg: 'Ingrese observaciones para corrección:',
						width:300,
						buttons: Ext.MessageBox.OK,
						multiline: true,
						fn: getObservacionesC

					});
					data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					data=data+'&operacion=correccion';


				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function getObservaciones(btn,text){
				if(btn!='cancel'){
					observaciones=text;
					data=data+'&observaciones='+observaciones;
					data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
					Ext.Ajax.request({
						url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
						method:'GET',
						success:esteSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
					});}
			}
			function getObservacionesC(btn,text){
				if(btn!='cancel'){
					observaciones=text;

					data=data+'&observaciones='+observaciones;
					data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";

					Ext.Ajax.request({
						url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
						method:'GET',
						success:esteSuccessC,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
					});}
			}


			function esteSuccess(resp){
				if(resp.responseXML&&resp.responseXML.documentElement){
					btn_reporte_solicitud_compra();
					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
				}
			}
			function esteSuccessC(resp){
				if(resp.responseXML&&resp.responseXML.documentElement){

					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
				}
			}


			function btn_reporte_solicitud_compra(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					data=data+'&tipo_repo=1';
					window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data);
				}

			}


			this.EnableSelect=function(x,z,y){
				enable(x,z,y);
				_CP.getPagina(layout_verificacion_presupuestaria_servicio.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_verificacion_presupuestaria_servicio.getIdContentHijo()).pagina.desbloquearMenu();
			}

			function btn_verificar(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();

					var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;

					window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data)

				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	function btn_anular(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='cantidad_ids=1&hidden_id_solicitud_compra_0='+SelectionsRecord.data.id_solicitud_compra;
			
			Ext.MessageBox.show({
           title: 'Observaciones de Anulación',
           msg: 'Ingrese observaciones de anulación:',
           width:300,
           buttons: Ext.MessageBox.OK,
           multiline: true,
           fn: getObservaciones1
           
       });
					
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
			
			function getObservaciones1(btn,text){
				if(btn!='cancel'){
				observaciones=text;
				data=data+'&observaciones_0='+observaciones;
				
					Ext.Ajax.request({
					url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
					method:'GET',
					success:esteSuccessA,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});}		
				
				
			}
			
			function esteSuccessA(resp){
				if(resp.responseXML&&resp.responseXML.documentElement){
					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
				}
			}





			//para que los hijos puedan ajustarse al tamaï¿½o
			this.getLayout=function(){return layout_verificacion_presupuestaria_servicio.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					vista:'verificacion',
					bien:2
				}
			});


			this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Solicitud',btn_aprobar,true,'aprobar_presupuesto','Aprobación');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'pedir_correccion','Corrección');
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Solicitud',btn_anular,true,'anular_solicitud','Anular');
    this.AdicionarBoton('../../../lib/imagenes/print.gif','Vista Previa Solicitud',btn_verificar,true,'ver_pres','Verificar');
			var CM_getBoton=this.getBoton;
			CM_getBoton('pedir_correccion-'+idContenedor).enable();
			CM_getBoton('aprobar_presupuesto-'+idContenedor).enable();
			CM_getBoton('ver_pres-'+idContenedor).enable();
			function salta(){
				ContenedorPrincipal.getPagina(idContenedor).pagina.btnActualizar();
			}

			function  enable(sel,row,selected){

				var record=selected.data;

				if(selected&&record!=-1){


					if(record.reformulacion=='1'){
						CM_getBoton('pedir_correccion-'+idContenedor).disable();
						CM_getBoton('aprobar_presupuesto-'+idContenedor).disable();
						CM_getBoton('ver_pres-'+idContenedor).disable();
						CM_getBoton('editar-'+idContenedor).disable();
					}
					else{
						CM_getBoton('pedir_correccion-'+idContenedor).enable();
						CM_getBoton('aprobar_presupuesto-'+idContenedor).enable();
						CM_getBoton('ver_pres-'+idContenedor).enable();
						CM_getBoton('editar-'+idContenedor).enable();
					}


				}
				CM_enableSelect(sel,row,selected);

			}


			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_verificacion_presupuestaria_servicio.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			//layout_verificacion_presupuestaria.getVentana().addListener('beforehide',salta);

			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}