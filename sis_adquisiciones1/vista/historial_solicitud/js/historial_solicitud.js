/**
* Nombre:		  	    pagina_historial_solicitud.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-23 09:20:50
*/
function pagina_historial_solicitud(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;

	var num_cotizaciones,on;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_proceso/ActionListarHistorialSolPro.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_histo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_histo',
		'tipo',
		'id_proceso_compra',
		'id_cotizacion',
		'codigo_proceso',
		'num_doc',
		'observaciones',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'num_convocatoria',
		'id_proveedor',
		'desc_proveedor',
		'compra_simplificada',
		'num_cotizacion_proc',
		'id_tipo_categoria_adq',
		'num_convocatoria',
        'falta_adjudicar'

		]),remoteSort:true});




		// DEFINICIÓN DATOS DEL MAESTRO

		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");


		//DATA STORE COMBOS

		function negrita(val,cell,record,row,colum,store){
			if(record.data.tipo=='Proceso'){
				return '<span style="color:blue;font-size:8pt">'+val+'</span>'
			}
			else
			{
				if(record.data.tipo=='Cotización' && record.data.estado_vigente=='invitado'){

					return '<span style="color:red;font-size:8pt">'+val+'</span>'

				}
				else {
					if(record.data.tipo=='Cotización' && record.data.estado_vigente=='cotizado'){


						return '<span style="color:green;font-size:8pt">'+val+'</span>'

					}
					else {

						return val
					}
				}



			}
		}




		function proc_negrita(val,cell,record,row,colum,store){
			if(record.data.tipo=='Proceso'){
				return '<span style="color:blue;font-size:8pt">'+val+' - '+record.data.compra_simplificada+'</span>'
			}
			else
			{
				if(record.data.tipo=='Cotización' && record.data.estado_vigente=='invitado'){

					return '<span style="color:red;font-size:8pt">'+val+' - '+record.data.compra_simplificada+'</span>'

				}
				else {
					if(record.data.tipo=='Cotización' && record.data.estado_vigente=='cotizado'){


						return '<span style="color:green;font-size:8pt">'+val+' - '+record.data.compra_simplificada+'</span>'

					}
					else {

						return val+' - '+record.data.compra_simplificada
					}
				}



			}
		}


		var tpl_id_estado_compra_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{orden}</i></b>','<br><FONT COLOR="#B5A642">{orden}</FONT>','</div>');




		var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor','direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor'])
		,baseParams:{id_proceso_compra:maestro.id_proceso_compra}});


		function render_id_proveedor(value, p, record){

			if(record.data.tipo=='Proceso'){
				return '<span style="color:blue;font-size:8pt">'+record.data['desc_proveedor']+'</span>'
			}
			else
			{
				if(record.data.tipo=='Cotización' && record.data.estado_vigente=='invitado'){

					return '<span style="color:red;font-size:8pt">'+record.data['desc_proveedor']+'</span>'

				}
				else {
					if(record.data.tipo=='Cotización' && record.data.estado_vigente=='cotizado'){


						return '<span style="color:green;font-size:8pt">'+record.data['desc_proveedor']+'</span>'

					}
					else {

						return record.data['desc_proveedor']
					}
				}
			}
		}
		var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_estado_proceso
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_histo',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				renderer:negrita
			},
			tipo: 'Field',
			filtro_0:false
		};

		Atributos[1]={
			validacion:{
				name:'tipo',
				fieldLabel:'Tipo',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				sortable:false,
				renderer:proc_negrita

			},
			tipo: 'Field',
			form: false,
			filtro_0:false,
		};
		// txt estado_reg
		Atributos[2]={
			validacion:{
				name:'num_doc',
				fieldLabel:'Número',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				sortable:false,
				renderer:negrita

			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		
				
		Atributos[3]={
			validacion:{
				name:'num_convocatoria',
				fieldLabel:'Convocatoria',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				sortable:false,
				renderer:negrita

			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};

		Atributos[4]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código Proceso',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				sortable:false,
				renderer:negrita

			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso'
		};
		/*

		Atributos[4]={
		validacion:{
		name:'desc_proveedor',
		fieldLabel:'Proveedor',
		grid_visible:true,
		grid_editable:false,
		width_grid:300,
		sortable:false,
		renderer:negrita


		},
		tipo: 'Field',
		form:false,
		filtro_0:true,
		filterColValue:'VPROV.desc_proveedor'
		};
		*/

		Atributos[5]={
			validacion:{
				name:'id_proveedor',
				fieldLabel:'Proveedor',
				allowBlank:false,
				emptyText:'Proveedor...',
				desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_proveedor,
				valueField: 'id_proveedor',
				displayField: 'nombre_proveedor',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
				typeAhead:false,
				tpl:tpl_id_proveedor,
				onSelect: function(record){getComponente('id_proveedor').setValue(record.data.id_proveedor);
				getComponente('direccion_proveedor').setValue(record.data.direccion_proveedor);getComponente('direccion_proveedor').disable();
				getComponente('mail_proveedor').setValue(record.data.mail_proveedor);getComponente('mail_proveedor').disable();
				getComponente('telefono1_proveedor').setValue(record.data.telefono1_proveedor);getComponente('telefono1_proveedor').disable();
				getComponente('telefono2_proveedor').setValue(record.data.telefono2_proveedor);getComponente('telefono2_proveedor').disable();
				getComponente('fax_proveedor').setValue(record.data.fax_proveedor);getComponente('fax_proveedor').disable();
				getComponente('id_proveedor').collapse(); },
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
				renderer:render_id_proveedor,
				grid_visible:true,
				grid_editable:false,
				width_grid:300,
				width:'100%',
				disable:false,
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'VPROV.desc_proveedor',
			id_grupo:2
		};

		Atributos[6]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				sortable:false,
				renderer:negrita
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.estado_vigente#COTI.estado_vigente'
		};


		Atributos[7]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				grid_visible:true,
				grid_editable:false,
				width_grid:300,
				sortable:false,
				renderer:negrita
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'ESTPRO.observaciones#ESTPROC.observaciones'
		};

		// txt fecha_ini
		Atributos[8]= {
			validacion:{
				name:'fecha_ini',
				fieldLabel:'Fecha Estado',
				format: 'd/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				sortable:false

			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'ESTPRO.fecha_ini#ESTPROC.fecha_ini'

		};

		Atributos[9]={
			validacion:{
				name:'direccion_proveedor',
				fieldLabel:'Direccion',
				allowBlank:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:60,
				disabled:true
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filterColValue:'',
			id_grupo:2
		};

		//
		Atributos[10]={
			validacion:{
				name:'mail_proveedor',
				fieldLabel:'Email',
				allowBlank:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:60,
				disabled:true
			},
			tipo: 'Field',
			form: true,
			filtro_0:false,
			filterColValue:'',
			id_grupo:2
		};

		Atributos[11]={
			validacion:{
				name:'telefono1_proveedor',
				fieldLabel:'Telef. 1',
				allowBlank:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:60,
				disabled:true
			},
			tipo: 'Field',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'telefono1_proveedor',
			id_grupo:2
		};


		Atributos[12]={
			validacion:{
				name:'telefono2_proveedor',
				fieldLabel:'Telef. 2',
				allowBlank:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:60,
				disabled:true
			},
			tipo: 'Field',
			form: true,
			filtro_0:false,
			filterColValue:'',
			id_grupo:2
		};


		Atributos[13]={
			validacion:{
				name:'fax_proveedor',
				fieldLabel:'Fax',
				allowBlank:true,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:60,
				disabled:true
			},
			tipo: 'Field',
			form: true,
			filtro_0:false,
			filterColValue:'',
			id_grupo:2
		};

		Atributos[14]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				renderer:negrita
			},
			tipo: 'Field',
			filtro_0:false
		};

		Atributos[15]= {
			validacion:{
				name:'fecha_entrega',
				fieldLabel:'Fecha Entrega Propuesta',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			id_grupo:3
		};
		// txt fecha_venc
		Atributos[16]= {//==>SI
			validacion:{
				name:'fecha_venc',
				fieldLabel:'Fecha Max. Entrega Propuestas',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				disabled:false

			},

			tipo:'DateField',
			filtro_0:false,
			dateFormat:'m-d-Y',
			save_as:'fecha_venc',
			id_grupo:1  //1
		};

		// txt lugar_entrega ==> se usa
		Atributos[17]={
			validacion:{
				name:'lugar_entrega',
				fieldLabel:'Lugar de Entrega',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'60%',
				disabled:false,
				grid_indice:17
			},
			tipo: 'TextArea',
			filtro_0:false,
			id_grupo:1  //1
		};
		
		Atributos[18]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'num_cotizacion_proc',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				renderer:negrita
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'num_cotizacion'
		};
		
		Atributos[19]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_tipo_categoria_adq',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				renderer:negrita
			},
			tipo: 'Field',
			filtro_0:false
		};
		


		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro)',titulo_detalle:'Historial Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_historial_solicitud = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_historial_solicitud.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_historial_solicitud,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_btnDelete=this.btnEliminar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_conexionFailure=this.conexionFailure;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_saveSuccess=this.saveSuccess;
		var CM_mostrarComponente=this.mostrarComponente;
		var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var selModel=this.getSelectionModel;
		var EstehtmlMaestro=this.htmlMaestro;

		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={actualizar:{crear:true,separador:false}};

		//DEFINICIÓN DE FUNCIONES



		function cargar_maestro(){

			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['id_solicitud_compra',maestro.id_solicitud_compra],['Solicitante',maestro.desc_empleado_tpm_frppa],['Moneda',maestro.desc_moneda],['Centro',maestro.desc_unidad_organizacional]]));
		}

		cargar_maestro();

		var paramFunciones={
			Save:{url:direccion+'../../../control/cotizacion/ActionInvitarProveedorCotizacion.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:'38%',minWidth:550,minHeight:200,	closable:true,titulo:'Cotizacion',
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Cotizacion',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Proveedor',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Entrega Pedido',
				columna:0,
				id_grupo:3
			},
			{
				tituloGrupo:'Pago',
				columna:0,
				id_grupo:4
			},
			{
				tituloGrupo:'Datos Oferta',
				columna:0,
				id_grupo:5
			}
			]}};


			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));

				maestro.id_solicitud_compra=datos.m_id_solicitud_compra;


				maestro.desc_empleado_tpm_frppa=datos.m_desc_empleado_tpm_frppa
				maestro.desc_moneda=datos.m_desc_moneda

				maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_solicitud_compra:maestro.id_solicitud_compra
					}
				};
				this.btnActualizar();
				cargar_maestro();

				this.InitFunciones(paramFunciones)
			};

			this.EnableSelect=function(x,z,y){
				enable(x,z,y)
			};

			function btn_inv_prov(){
				var dialog=getDialog();

				var sm=getSelectionModel(), NumSelect=sm.getCount();
				if(NumSelect!=0){
                    var SelectionsRecord=sm.getSelected();
                    if(SelectionsRecord.data.falta_adjudicar>0){
				        getComponente('fecha_entrega').allowBlank=true;
					    CM_ocultarGrupo('Oculto');
					    CM_ocultarGrupo('Datos Entrega Pedido');
					    CM_ocultarGrupo('Datos Oferta');
					    CM_ocultarGrupo('Pago');
					    CM_mostrarGrupo('Cotizacion');
					    CM_mostrarGrupo('Datos Proveedor');

	   				    dialog.buttons[0].setText('Guardar');
					    //CM_ocultarGrupo('Cotizacion');
					    on=0;
					    
					    cmbProveedor.store.baseParams.id_proceso_compra=sm.getSelected().data.id_proceso_compra;
					    getComponente('id_proveedor').modificado=true;
					    //CM_btnNew();

					    dialog.show()
					    verificarCotizacion(sm.getSelected().data.id_proceso_compra);
				    }else{
				        alert("Todo lo solicitado ya fue adjudicado");
				    }
				}

			}

			function get_fecha_adq(){
				Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
						width:150,
						height:200,
						closable:false
					});
					
				Ext.Ajax.request({
					//url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php",
					method:'GET',
					success:cargar_fecha_adq,
					failure:CM_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}


			function cargar_fecha_adq(resp){
				Ext.MessageBox.hide();//ocultamos el loading
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
						var fecha = new Date(root.getElementsByTagName('fecha_fin')[0].firstChild.nodeValue);

						txt_fecha_entrega.maxValue=fecha;
						txt_fecha_venc.maxValue=fecha;
						fecha = new Date(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);

						txt_fecha_entrega.minValue=fecha;
						txt_fecha_venc.minValue=fecha;

						getComponente('fecha_entrega').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					}
				}
			}

			function verificarCotizacion(idproc){
				Ext.MessageBox.show({
					title: 'Verificando ...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
					width:150,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/cotizacion/ActionListarCotizacion.php?m_id_proceso_compra="+idproc,
					method:'GET',
					success:verificar,
					text: 'Verificando .....',
					failure:CM_conexionFailure,
					timeout:100000000
				})
			}


			function verificar(resp){
				Ext.MessageBox.hide();//ocultamos el loading
				//Ext.MessageBox.hide();
				if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
					var root=resp.responseXML.documentElement;
					num_cotizaciones=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
					get_fecha_adq();
					if(on==0){
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
							CM_ocultarComponente(getComponente('fecha_venc'));
							getComponente('fecha_venc').disable();
							getComponente('fecha_venc').allowBlank=true;
							getComponente('lugar_entrega').setValue(root.getElementsByTagName('lugar_entrega')[0].firstChild.nodeValue);
							getComponente('lugar_entrega').disable();
						}else{
							CM_mostrarComponente(getComponente('fecha_venc'));
							getComponente('lugar_entrega').setValue('');
							getComponente('fecha_venc').enable();
							getComponente('lugar_entrega').enable();
							getComponente('lugar_entrega').allowBlank=false;
						}
					}
				}
			}


			//Para manejo de eventos
			function iniciarEventosFormularios(){
				txt_fecha_entrega=getComponente('fecha_entrega');
				txt_fecha_venc=getComponente('fecha_venc');
				cmbProveedor=getComponente('id_proveedor');

				num_cotizaciones=0;
				on=0;

				CM_getBoton('invt_prov-'+idContenedor).disable();

				getSelectionModel().on('rowdeselect',function(){
					CM_getBoton('invt_prov-'+idContenedor).disable();
				});
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_historial_solicitud.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);

			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Invitar Proveedor',btn_inv_prov,true,'invt_prov','Invitar Proveedor');
			var CM_getBoton=this.getBoton;
			//para agregar botones

			this.iniciaFormulario();


			function  enable(sel,row,selected){
				var record=selected.data;

				if(selected&&record!=-1){

					if(record.tipo=='Proceso' && record.compra_simplificada=='Regular'){
						if(record.estado_vigente=='en_proceso'){					    
					       CM_getBoton('invt_prov-'+idContenedor).enable()
						}else{
						   CM_getBoton('invt_prov-'+idContenedor).disable()
						}
					}

				}
				enableSelect(sel,row,selected);
			}

			iniciarEventosFormularios();

			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_solicitud_compra:maestro.id_solicitud_compra
				}
			});
			layout_historial_solicitud.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}