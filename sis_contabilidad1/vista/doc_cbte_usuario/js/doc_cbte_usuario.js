/**
 * Nombre:		  	    pagina_transaccion_valor.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2011-03-11 11:58:13
 */
function pagina_doc_cbte_usuario(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();	
	var m_nombre_largo=maestro.nombre_largo;
	var m_desc_periodo=maestro.desc_periodo;
	var m_fecha_inicio=maestro.fecha_inicio;
	var m_fecha_final=maestro.fecha_final;
    var data_maestro;
    var var_id_periodo_subsistema;
		
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/doc_cbte_usuario/ActionListarDocCbteUsuario.php?id_periodo_subsistema='+maestro.id_periodo_subsistema+'&id_periodo='+maestro.id_periodo}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_doc_cbte_usuario',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		    'id_periodo_subsistema',
			'id_doc_cbte_usuario',
			'id_documento',
			'id_clase_cbte',
			'id_usuario',
			'documento',
			'desc_persona',
			'titulo_cbte',
			'desc_clase',
			'sw_validacion',
			'sw_edicion'
			]),remoteSort:true});
			
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_periodo_subsistema:maestro.id_periodo_subsistema,
			m_id_periodo:maestro.id_periodo
		}
	});
	//Definicion del Data Store
	//USUARIO
	var ds_usuario=new Ext.data.Store({ 
			proxy:new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),		
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_usuario','desc_persona','login'])//,'codigo_depto'])
		});
	function render_usuario(value,p,record){return String.format('{0}',record.data['desc_persona'])}
	var tpl_usuario=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">Nombre:{desc_persona}</FONT><br>{login}','</div>');

	//Clase Comprobante
	var ds_clase_cbte = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'},['id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento','titulo_cbte']),remoteSort:true});
	function render_clase_cbte(value,p,record){return String.format('{0}',record.data['desc_clase'])}
	var tpl_clase_cbte=new Ext.Template('<div class="search-item">','{desc_clase}<br>','<FONT COLOR="#B5A642">Titulo:{titulo_cbte}</FONT>','</div>');

	//Documento
	var ds_documento= new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/documento/ActionListarDocumento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'},
				['id_documento','codigo','descripcion','documento','prefijo','sufijo','estado','id_subsistema','desc_subsistema','num_firma','tipo_numeracion','id_tipo_proceso','tipo','desc_tipo_proceso'	]),baseParams:{m_id_subsis:9},remoteSort:true});
	function render_documento(value,p,record){return String.format('{0}',record.data['documento'])}
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	data_maestro=[['Sistema: ',m_nombre_largo],
	              ['Periodo ',m_desc_periodo]];
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_doc_cbte_usuario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_doc_cbte_usuario'
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_periodo_subsistema',
			grid_visible:false, 
			grid_editable:false,
			disabled:true	
		},
		form: true,
		tipo: 'TextField',
		filtro_0:false,
		save_as:'id_periodo_subsistema'
	};
		
	Atributos[2]={
		validacion:{
			fieldLabel:'Tipo de Documento',
			name:'id_documento',
			vtype:"texto",
			emptyText:'Tipo de Documento...',
			allowBlank:false,
			desc:'documento',//es el nombre de la persona
			store:ds_documento,//agregado			
			valueField:'id_documento',
			displayField:'documento',//es el nombre de la persona',
			queryParam:'filterValue_0',				
			filterCol:'DOCUME.documento',
			typeAhead:false,
			forceSelection:false,
			//tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',			
			renderer:render_documento,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:200,
			grid_indice:1	
			},
		tipo: 'ComboBox',
		form: true,	
		filtro_0:true,
		filterColValue:'doc.documento',
		save_as:'id_documento'
	};
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Clase de Comprobante',
			name:'id_clase_cbte',
			vtype:"texto",
			emptyText:'Clase de comprobante...',
			allowBlank:true,
			desc:'desc_clase',//es el nombre de la persona
			store:ds_clase_cbte,//agregado			
			valueField:'id_clase_cbte',
			displayField:'desc_clase',//es el nombre de la persona',
			queryParam:'filterValue_0',				
			filterCol:'CBCLAS.titulo_cbte#CBCLAS.desc_clase',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_clase_cbte,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_clase_cbte,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200,
			grid_indice:2	
			},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'cc.titulo_cbte#cc.desc_clase',	
		save_as:'id_clase_cbte'
	};
		
	Atributos[4]={
		validacion:{
			fieldLabel:'Nombre de Usuario',
			name:'id_usuario',
			vtype:"texto",
			emptyText:'Nombre De Usuario...',
			allowBlank:false,
			desc:'desc_persona',//es el nombre de la persona
			store:ds_usuario,//agregado			
			valueField:'id_usuario',
			displayField:'desc_persona',//es el nombre de la persona',
			queryParam:'filterValue_0',				
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_usuario,
			//tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:200,
			grid_indice:3	
			},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'per.apellido_paterno#per.apellido_materno#per.nombre',
		save_as:'id_usuario'
	};
	
	//importe debe
	Atributos[5]={
		validacion:{
			name:'sw_validacion',
			fieldLabel:'Validación',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','si'],['no','no']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:true,
			forceSelection:true,
			align:'center',
			width:100							
		},		
		tipo: 'ComboBox',			
		form: true,
		filtro_0:false,		
		save_as:'sw_validacion'
	};
	
	Atributos[6]={			
		validacion:{
			name:'sw_edicion',
			fieldLabel:'Edición',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','si'],['no','no']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:true,
			forceSelection:true,
			align:'center',
			width:100					
		},		
		tipo: 'ComboBox',			
		form: true,
		filtro_0:false,		
		save_as:'sw_edicion'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:m_nombre_largo+' (Maestro)',titulo_detalle:'Permisos para Validar y Editar (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var layout_doc_cbte_usuario = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_doc_cbte_usuario.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_doc_cbte_usuario,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var Cm_btnActualizar=this.btnActualizar;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/doc_cbte_usuario/ActionEliminarDocCbteUsuario.php'},			
		ConfirmSave:{url:direccion+'../../../control/doc_cbte_usuario/ActionGuardarDocCbteUsuario.php?id_periodo_subsistema_0='+maestro.id_periodo_subsistema},
		Save:{url:direccion+'../../../control/doc_cbte_usuario/ActionGuardarDocCbteUsuario.php?id_periodo_subsistema_0='+maestro.id_periodo_subsistema},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:400,minWidth:300,minHeight:300,	closable:true,titulo:'Documento - Comprobante - Usuario'}};

	function MaestroJulio(data){
		var mayor=0;		
		var j;
		
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j]){
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
			}
		}
		html=html+"</tr>";
		}
		html=html+"</table>";
		 
		return html
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		//console.log(params);
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//console.log(datos);
		//maestro=datos;
		//console.log(maestro);
		maestro.id_periodo=datos.m_id_periodo;
		maestro.id_periodo_subsistema=datos.m_id_periodo_subsistema;
		maestro.nombre_largo=datos.m_nombre_largo;
		maestro.desc_periodo=datos.m_desc_periodo;
		maestro.fecha_inicio=datos.m_fecha_inicio;
		maestro.fecha_final=datos.m_fecha_final;
				
		data_maestro=[['Sistema: ',datos.m_nombre_largo],
	                  ['Periodo ',datos.m_desc_periodo]
	                  //['Fecha Inicio',m_fecha_inicio,'Fecha Final',m_fecha_final],
	                  ];
	   	paramFunciones.btnEliminar.parametros='&id_periodo_subsistema_0='+datos.m_id_periodo_subsistema;
		paramFunciones.Save.parametros='&id_periodo_subsistema_0='+datos.m_id_periodo_subsistema;
		paramFunciones.ConfirmSave.parametros='&id_periodo_subsistema_0='+datos.m_id_periodo_subsistema;
		this.InitFunciones(paramFunciones);
		var_id_periodo_subsistema.setValue(datos.m_id_periodo_subsistema); 
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		// alert (maestro.id_periodo_subsistema+"maestro.id_periodo_subsistema=datos.m_id_periodo_subsistema;"+datos.m_id_periodo_subsistema);
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_periodo_subsistema:datos.m_id_periodo_subsistema,
				m_id_periodo:datos.m_id_periodo	
			}
		});
	}
	
	this.btnNew=function(){	
		ClaseMadre_btnNew();
		var_id_periodo_subsistema.setValue(maestro.id_periodo_subsistema); 	
	};
	
	function InitRegistroUsuario(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		var_id_periodo_subsistema=ClaseMadre_getComponente('id_periodo_subsistema');
 	};

 	function btn_ppto(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			Ext.MessageBox.confirm("Atención","Esta seguro de Permitir la Validación de Cbtes. Presupuestarios?",function(btn){
				if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Abriendo periodo...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Habilitando ...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/periodo_subsistema/ActionAbrirCerrarPeriodoSubsistema.php",
					success:mostrar_respuesta,
					params:{accion:'permite',id_periodo_subsistema:datas_edit.id_periodo_subsistema},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
				} 
			});
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}

 	function btn_nppto(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			Ext.MessageBox.confirm("Atención","Esta seguro de Restringir la Validación de Cbtes. Presupuestarios?",function(btn){
				if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Abriendo periodo...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Restringiendo ...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/periodo_subsistema/ActionAbrirCerrarPeriodoSubsistema.php",
					success:mostrar_respuesta,
					params:{accion:'deniega',id_periodo_subsistema:datas_edit.id_periodo_subsistema},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
				} 
			});
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}

 	function mostrar_respuesta(resp){
		Ext.MessageBox.hide();
		Cm_btnActualizar();
	}
	
	this.getLayout=function(){return layout_doc_cbte_usuario.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Permitir Validar Cbtes. Presupuestarios',btn_ppto,true,'Permitir','Permitir Validar');
 	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Restringir Validar Cbtes. Presupuestarios',btn_nppto,true,'Restringir','Restringir Validar');
 	
	this.iniciaFormulario();
	InitRegistroUsuario();
	
	//alert (maestro.id_periodo_subsistema);
	var_id_periodo_subsistema.setValue(maestro.id_periodo_subsistema); 	
	layout_doc_cbte_usuario.getLayout().addListener('layout',this.onResize);
}