/**
 * Nombre:		  	    pagina_modificacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-05-10 18:01:22
 */
function pagina_modificacion_aprobacion(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/modificacion/ActionListarModificacion.php?aprobacion=si'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_modificacion',totalRecords:'TotalCount'
		},[		
		'id_modificacion',
		'id_parametro',
		'desc_parametro',
		'tipo_modificacion',
		'justificacion',
		'tipo_presupuesto',
		'desc_tipo_pres',
		'nro_modificacion',
		'estado_modificacion',
		'fecha_regis',
		'fecha_conclusion',
		'id_usuario_reg',
		'desc_usuario_reg',
		'total_disminucion',
		'total_incremento',
		'id_gestion'
		]),remoteSort:true});

	
	//DATA STORE COMBOS		
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
	
	var ds_usuario_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),
			baseParams:{sw_responsable:'si'}
	});
	
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});

	//FUNCIONES RENDER
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_gral}</FONT>','</div>');
		
	function render_id_usuario_reg(value, p, record){return String.format('{0}', record.data['desc_usuario_reg']);}
	var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b>','<br><FONT COLOR="#B5A642"><b>Unidad Org.: </b>{desc_unidad_organizacional}</FONT>','</div>');
	
//	function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
	function render_id_tipo_pres_gestion(value,p,record){return String.format('{0}', record.data['desc_tipo_pres']);}
	var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');	
	
	function renderTipoPresupuesto(value, p, record)
	{
		if(value == 1)
		{return "Recurso"}
		if(value == 2)
		{return "Gasto"}
		if(value == 3)
		{return "Inversión"}
		if(value == 4)
		{return "PNO - Recurso"}
		if(value == 5)
		{return "PNO - Gasto"}
		if(value == 6)
		{return "PNO - Inversión"}
		
		return '';
	}
	function renderTipoModificacion(value, p, record)
	{
		if(value == 1)
		{return "Traspaso"}
		if(value == 2)
		{return "Reformulación"}
		if(value == 3)
		{return "Otros"}
		return '';
	}	
	
	//Función para el formato de los importes
		function formatoImporte(num){  
			 var cadena = ""; var aux;  
			 var cont = 1,m,k;  
			   
			 if(num<0) aux=1; else aux=0;  
			 num=num.toString();  
		   
			 for(m=num.length-1; m>=0; m--){
				 cadena = num.charAt(m) + cadena;  
				 if(num.charAt(m)!='.'){
				   
					 if(cont%3 == 0 && m >aux)  cadena = "," + cadena; else cadena = cadena;  
				   
					 if(cont== 3) cont = 1; else cont++;  
				 } else{
					 cont = 1;
				 }
			 }  
			 return cadena;  
		}
		
		function render_importe(value, p, record)
		{
			var num=formatoImporte(value);
			if(value<0){
				return String.format('{0}', '<FONT COLOR="#FF0000"><b>'+num+'</b></FONT>');
			} else if(value>0){
				return String.format('{0}', '<FONT COLOR="#0000FF"><b>'+num+'</b></FONT>');
			} else{
				return String.format('{0}', '<b>'+num+'</b>');
			}
		}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
		
	// hidden id_modificacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_modificacion',
			fieldLabel:'Identificador',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:true
		
	};

	Atributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:200,
			//grid_indice:1,  //para colocar el orden en el indice
			//form_indice:1,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		//id_grupo:1,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	Atributos[2] = {
		validacion: {
			name:'tipo_modificacion',			
			fieldLabel:'Tipo Modificación',
			vtype:'texto',
			//emptyText:'Tipo Modificacion...',
			allowBlank: false,
			typeAhead: true,			
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.modificacion_combo.tipo_modificacion // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoModificacion,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			disabled:true,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:false,		
		form: true,
		save_as:'tipo_modificacion',
		filterColValue:'tipo_modificacion',
		defecto:2   //reformulacion
	};	

	Atributos[3]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false
			//grid_indice:18		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		//id_grupo:1,
		save_as:'justificacion',
		filterColValue:'MODIFI.justificacion'		
	};		
	
	Atributos[4]={
		validacion:{
			name:'tipo_presupuesto',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			//renderer:render_id_tipo_pres_gestion, renderTipoPresupuesto
			renderer:renderTipoPresupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'tipo_presupuesto'
	}; 

	/*Atributos[4] = {
		validacion: {
			name:'tipo_presupuesto',			
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,			
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.modificacion_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			width:200
		},
		tipo:'ComboBox',
		filtro_0:false,		
		form: true,
		save_as:'tipo_presupuesto',
		filterColValue:'PRESUP.tipo_presupuesto'
		//id_grupo:1
	};*/	
	
// txt nro_modificacion
	Atributos[5]={
		validacion:{
			name:'nro_modificacion',
			fieldLabel:'Nro Documento',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'MODIFI.nro_modificacion'
		
	};
// txt estado_modificacion
	Atributos[6]={
		validacion:{
			name:'estado_modificacion',
			fieldLabel:'Estado Modificación',
			allowBlank:true,
			maxLength:20,
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
		form: false,
		filtro_0:true,
		filterColValue:'MODIFI.estado_modificacion'
		
	};
// txt fecha_regis
	Atributos[7]={
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'MODIFI.fecha_regis',
	};	
	
// txt fecha_conclusion
	Atributos[8]={
		validacion:{
			name:'fecha_conclusion',
			fieldLabel:'Fecha Conclusion',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'MODIFI.fecha_conclusion',
	};
	
	Atributos[9]={
			validacion:{
			name:'id_usuario_reg',
			fieldLabel:'Responsable Registro',
			allowBlank:true,			
			//emptyText:'Usuario registro...',
			desc: 'desc_usuario_reg', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_reg,
			valueField: 'id_usuario_reg',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_reg,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
			//grid_indice:17		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'PERSON3.apellido_paterno#PERSON3.apellido_materno#PERSON3.nombre',
		save_as:'id_usuario_reg'
	};
	
	// txt nro_modificacion
	Atributos[10]={
		validacion:{
			name:'total_disminucion',
			fieldLabel:'T. Disminución',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			align:'right', 
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			renderer:render_importe			
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false		
	};
	
	Atributos[11]={
		validacion:{
			name:'total_incremento',
			fieldLabel:'T. Incremento',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			align:'right', 
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			renderer:render_importe			
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false		
	};
	
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Modificación',grid_maestro:'grid-'+idContenedor};
	var layout_modificacion_aprobar=new DocsLayoutMaestro(idContenedor);
	layout_modificacion_aprobar.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_modificacion_aprobar,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getComponente=this.getComponente;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		/*nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/modificacion/ActionEliminarModificacion.php'},
		Save:{url:direccion+'../../../control/modificacion/ActionGuardarModificacion.php'},
		ConfirmSave:{url:direccion+'../../../control/modificacion/ActionGuardarModificacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Modificación'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario		
	}
	
	function InitPaginaModificacion()
    {						
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}	
		
		//componentes[1].on('select',evento_parametro); //gestion
		componentes[1].on('select',evento_parametro);		//parametro		
		
	}
	
	function evento_parametro( combo, record, index )
	{		
		componentes[4].store.baseParams={m_id_parametro:componentes[1].getValue(),m_incluir_dobles:'no'};
		componentes[4].modificado=true;
		componentes[4].setValue('');
	}
	
	function btn_pdfDetalleModificaciones(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{			
			var SelectionsRecord=sm.getSelected();
			var data='id_modificacion='+SelectionsRecord.data.id_modificacion;
			data=data+'&id_moneda='+SelectionsRecord.data.id_moneda;					
			data=data+'&id_parametro='+SelectionsRecord.data.id_parametro;					
			data=data+'&tipo_presupuesto='+SelectionsRecord.data.tipo_presupuesto;
			data=data+'&id_gestion='+SelectionsRecord.data.id_gestion;					

			/*
			var data='&id_modificacion='+SelectionsRecord.data.id_modificacion;	
			data= data + '&tipo_vista=avance';*/			  	 	   			   	   
			//window.open(direccion+'../../../control/_reporte/cuenta_doc_rendicion/ActionPDFRendicionCuenta.php?'+data)	
			//window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)						
			//window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data)	
			window.open(direccion+'../../../control/modificacion/ActionPDFModificacion.php?'+data)					
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
		
	}
	function btnDetalleModificaciones()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_modificacion='+SelectionsRecord.data.id_modificacion;
			data=data+'&id_moneda='+SelectionsRecord.data.id_moneda;					
			data=data+'&id_parametro='+SelectionsRecord.data.id_parametro;					
			data=data+'&tipo_presupuesto='+SelectionsRecord.data.tipo_presupuesto;
			data=data+'&id_gestion='+SelectionsRecord.data.id_gestion;					

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			
			layout_modificacion_aprobar.loadWindows(direccion+'../../../../sis_presupuesto/vista/partida_modificacion_orig/partida_modificacion_orig.php?'+data,'Disminuciones',ParamVentana);
			layout_modificacion_aprobar.getVentana().on('resize',function(){
						layout_modificacion_aprobar.getLayout().layout();
					});
			/*layout_modificacion.loadWindows(direccion+'../../../../sis_presupuesto/vista/partida_modificacion_dest/partida_modificacion_dest.php?'+data,'Incrementos',ParamVentana);			
			layout_modificacion.getVentana().on('resize',function(){
						layout_modificacion.getLayout().layout();
					});*/
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}
	
	function btn_verificacion_presupuestaria()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{			
			var data='&id_modificacion='+SelectionsRecord.data.id_modificacion;	
			data= data + '&tipo_vista=avance';			  	 	   			   	   
			//window.open(direccion+'../../../control/_reporte/cuenta_doc_rendicion/ActionPDFRendicionCuenta.php?'+data)	
			//window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)						
			//window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data)	
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionVerificacion.php?'+data)					
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function btn_autorizacion_modificacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			//if(componentes[6].getValue()=='Borrador' || componentes[6].getValue()=='Rechazado')	//estado traspaso
			//{
				var sw=false;
				if(confirm('Esta seguro de enviar para AUTORIZACIÓN la modificación?'))
						{sw=true}
				if(sw)
				{
					var SelectionsRecord=sm.getSelections(); 			
		 			var arr_id_modificacion = new Array;
		 			for(var i=0 ; i<NumSelect ; i++)
		 			{
					    arr_id_modificacion[i]=SelectionsRecord[i].data.id_modificacion;
					    	
						Ext.Ajax.request({
						url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
						method:'POST',
						params:{cantidad_ids:NumSelect,id_modificacion:arr_id_modificacion[i],accion:'enviar_autorizar'},
						success:modificacion_Success,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
						});	
		 			}			
				}				
			/*}
			else
			{
				Ext.MessageBox.alert('...', 'Solo registros en estado VERIFICACION o RECHAZADO pueden ser enviados para autorización.');
			}*/	
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}	
		
	
	function btn_aprobar_modificacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			//if(componentes[6].getValue()=='Borrador' || componentes[6].getValue()=='Rechazado')	//estado traspaso
			//{
				var sw=false;
				if(confirm('Esta seguro de APROBAR la modificación?'))
						{sw=true}
				if(sw)
				{
					var SelectionsRecord=sm.getSelections(); 			
		 			var arr_id_modificacion = new Array;
		 			for(var i=0 ; i<NumSelect ; i++)
		 			{
						arr_id_modificacion[i]=SelectionsRecord[i].data.id_modificacion;
		 				
		 				Ext.Ajax.request({
						url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
						method:'POST',
						params:{cantidad_ids:NumSelect,id_modificacion:arr_id_modificacion[i],accion:'aprobar_modificacion'},
						success:modificacion_Success,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
						});				
		 			}
				}				
			/*}
			else
			{
				Ext.MessageBox.alert('...', 'Solo registros en estado VERIFICACION o RECHAZADO pueden ser enviados para autorización.');
			}*/	
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}	
	
	function btn_rechazar_modificacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			//if(componentes[6].getValue()=='Borrador' || componentes[6].getValue()=='Rechazado')	//estado traspaso
			//{
				var sw=false;
				if(confirm('Esta seguro de RECHAZAR la modificación?'))
						{sw=true}
				if(sw)
				{
					var SelectionsRecord=sm.getSelections(); 			
		 			var arr_id_modificacion = new Array;
		 			for(var i=0 ; i<NumSelect ; i++)
		 			{
						arr_id_modificacion[i]=SelectionsRecord[i].data.id_modificacion;
		 				
		 				Ext.Ajax.request({
						url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
						method:'POST',
						params:{cantidad_ids:NumSelect,id_modificacion:arr_id_modificacion[i],accion:'rechazar_modificacion'},
						success:modificacion_Success,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
						});				
		 			}								
				}				
			/*}
			else
			{
				Ext.MessageBox.alert('...', 'Solo registros en estado VERIFICACION o RECHAZADO pueden ser enviados para autorización.');
			}*/	
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}	
		
	
	function btn_concluir_modificacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			/*if(componentes[6].getValue()=='Aprobado')	//estado traspaso
			{*/
				var sw=false;
				if(confirm('Esta seguro de CONCLUIR la modificación?'))
						{sw=true}
				if(sw)
				{
					Ext.Ajax.request({
					url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
					method:'POST',
					params:{cantidad_ids:'1',id_modificacion:SelectionsRecord.data.id_modificacion,accion:'concluir_modificacion'},
					success:modificacion_Success,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});	
					
					/*var SelectionsRecord=sm.getSelected();			
	 				var data='id_partida_traspaso='+SelectionsRecord.data.id_partida_traspaso; 
	 				data=data+'&reformulacion=no';
					window.open(direccion+'../../../control/_reportes/partida_traspaso/PartidaTraspaso.php?'+data, "Traspaso");				
				*/
				}				
			/*}
			else
			{
				Ext.MessageBox.alert('...', 'Solo modificaciones en estado APROBADO pueden ser concluidos.');
			}	*/
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}

	function modificacion_Success(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{	
			//Ext.MessageBox.alert('Exito', 'Finalización exitosa, ahora puede imprimir la rendición.')	
			//btn_reporte_modificacion();				
			ClaseMadre_btnActualizar();
		}
		else
		{
			ClaseMadre_conexionFailure();
		}
	}	
	
	//Para manejo de eventos
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_modificacion_aprobar.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});	
	
	this.iniciaFormulario();
	InitPaginaModificacion();
	iniciarEventosFormularios();
	
	//Adicionamos el combo de gestion	
	var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
		
	
	var gestion =new Ext.form.ComboBox({
			store:ds_cmb_gestion,
			displayField:'gestion_pres',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Gestión...',
			selectOnFocus:true,
			width:100,
			valueField:'id_gestion',
			tpl:tpl_gestion_cmb
	});
	
  	gestion.on('select',function (combo, record, index)
  	{
  		g_id_gestion=gestion.getValue();
	  	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});	
    });
    this.AdicionarBotonCombo(gestion,'gestion');
    //Fin adicion del combo de gestion
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Pdf Detalle Modificacion',btn_pdfDetalleModificaciones,true,'pdfDetalle','');//boris claros 8/03/
    this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de los presupuestos y partidas afectadas',btnDetalleModificaciones,true,'detalle','Detalle Modificaciones'); //tucrem
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir reporte',btn_pdfDetalleModificaciones,true,'verificacion_presupuestaria','Reporte de Modificaciones'); //boris claros 8/03/
	//this.AdicionarBoton('../../../lib/imagenes/tucrem.png','Autorización la Modificación',btn_autorizacion_modificacion,true,'autorizacion_traspaso','Enviar Para Autorización');
	
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar la Reformulación seleccionada',btn_aprobar_modificacion,true,'aprobar_reformulacion','Aprobar');
	this.AdicionarBoton('../../../lib/imagenes/cross.gif','Rechazar la Reformulación seleccionada',btn_rechazar_modificacion,true,'rechazar_reformulacion','Rechazar');
	
	//this.AdicionarBoton('../../../lib/imagenes/book_next.png','Concluir la Modificación',btn_concluir_modificacion,true,'concluir_traspaso','Concluir Modificación');
	
		
	//para agregar botones	
	/*CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('detalle-'+idContenedor).disable();	
	CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
	CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();*/
	CM_getBoton('aprobar_reformulacion-'+idContenedor).disable();
	CM_getBoton('rechazar_reformulacion-'+idContenedor).disable();	
	//CM_getBoton('concluir_traspaso-'+idContenedor).disable();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		
		/*if(rec.data['estado_modificacion']=='Borrador')//Borrador
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('detalle-'+idContenedor).enable();	
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).enable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).enable();
			CM_getBoton('aprobar_reformulacion-'+idContenedor).disable();
			CM_getBoton('rechazar_reformulacion-'+idContenedor).disable();	
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();					
		}	*/	
		if(rec.data['estado_modificacion']=='Autorizacion')//Autorizacion
		{
			//alert("llega disa");
			/*CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('detalle-'+idContenedor).enable();	
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).enable();	
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();*/
			CM_getBoton('aprobar_reformulacion-'+idContenedor).enable();
			CM_getBoton('rechazar_reformulacion-'+idContenedor).enable();
			//CM_getBoton('concluir_traspaso-'+idContenedor).disable();								
		}	
		/*if(rec.data['estado_modificacion']=='Aprobado')//Aprobado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();	
			CM_getBoton('detalle-'+idContenedor).enable();	
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).enable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();	
			CM_getBoton('aprobar_reformulacion-'+idContenedor).disable();
			CM_getBoton('rechazar_reformulacion-'+idContenedor).disable();
			//CM_getBoton('concluir_traspaso-'+idContenedor).enable();								
		}	
		if(rec.data['estado_modificacion']=='Rechazado')//Rechazado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('detalle-'+idContenedor).enable();	
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).enable();	
			CM_getBoton('autorizacion_traspaso-'+idContenedor).enable();
			CM_getBoton('aprobar_reformulacion-'+idContenedor).disable();
			CM_getBoton('rechazar_reformulacion-'+idContenedor).disable();	
			//CM_getBoton('concluir_traspaso-'+idContenedor).disable();								
		}	
		if(rec.data['estado_modificacion']=='Concluido')//Concluido
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();	
			CM_getBoton('detalle-'+idContenedor).enable();	
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('aprobar_reformulacion-'+idContenedor).disable();
			CM_getBoton('rechazar_reformulacion-'+idContenedor).disable();	
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();								
		}	*/	
	}
    
	layout_modificacion_aprobar.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}