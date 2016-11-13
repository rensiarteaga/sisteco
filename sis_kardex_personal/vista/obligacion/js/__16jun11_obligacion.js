/**
* Nombre:		  	    pagina_afp.js
* Propósito: 			pagina objeto principal
* Autor:				Mercedes Zambrana Meneses
* Fecha creación:		11-08-2010
*/
function pagina_obligacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0, g_pago, m_bandera;
	var filterCols_obligacion=new Array();
	    				filterValues_obligacion=new Array();
	var mi_array=new Array;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/obligacion/ActionListarObligacion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_obligacion',totalRecords:'TotalCount'
		},[
		'id_obligacion',
		'id_tipo_obligacion',
		'codigo',
		'nombre',
		'id_planilla',
		'id_comprobante',
		'monto',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		
		'observaciones',
		'nro_cuenta_banco',
		'id_institucion',
		'desc_institucion','tipo_pago',
		{name: 'fecha_pago',type:'date',dateFormat:'Y-m-d'},
		'id_cuenta','desc_cuenta',
		'id_auxiliar','desc_auxiliar','id_cuenta_bancaria'
		]),remoteSort:true});

		var ds_id_tipo_obligacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/tipo_obligacion/ActionListarTipoObligacion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_obligacion',totalRecords: 'TotalCount'},
		['id_tipo_obligacion','codigo','nombre'])
		});
		
		var ds_id_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php?m_id_gestion='+maestro.id_gestion}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
			['id_cuenta','nro_cuenta','nombre_cuenta'])
			});
		
		var ds_id_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_obligacion',totalRecords: 'TotalCount'},
			['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
		});

 		var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php?estado=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda'
			])//,baseParams:{m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}
 			});

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}	
			var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT>','</div>');			
			

		//FUNCIONES RENDER


		function render_id_tipo_obligacion(value, p, record){return record.data['nombre']}
		var tpl_id_tipo_obligacion=new Ext.Template('<div class="search-item">',
		'<b>{codigo}</b>',
		'<br><FONT COLOR="#B5A642">{nombre}</FONT>',
		'</div>');

		function render_estado_reg(value)
		{
			if(value=='activo'){value='Activo'	}
			else if(value=='inactivo'){value='Inactivo'	}
			return value
		}

		function render_id_cuenta(value, p, record){return record.data['desc_cuenta']}
		function render_id_auxiliar(value, p, record){return record.data['desc_auxiliar']}
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_columna_tipo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_obligacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_empleado
		Atributos[1]={
			validacion:{
				name:'id_planilla',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_planilla
		};

		Atributos[2]={
			validacion:{
				name:'id_tipo_obligacion',
				fieldLabel:'Tipo Obligacion',
				allowBlank:false,
				//emptyText:'Presupuesto...',
				desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_tipo_obligacion,
				valueField: 'id_tipo_obligacion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'nombre',
				typeAhead:false,
				tpl:tpl_id_tipo_obligacion,
				forceSelection:true,
				mode:'remote',
				queryDelay:360,
				pageSize:10,
				minListWidth:400,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_tipo_obligacion,
				grid_visible:true,
				grid_editable:false,
				width_grid:400,
				grid_indice:1,
				width:'100%'
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'tob.codigo#tob.nombre',
			id_grupo:0
		};


		Atributos[3]= {
			validacion: {
				name:'estado_reg',
				fieldLabel:'Estado',displayField:'valor',
				lazyRender:true,
				renderer:render_estado_reg,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:90,

			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'TOB.estado_reg'
		};

		// txt fecha_reg
		Atributos[4]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'TOB.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''

		};
		
		
	Atributos[10]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cta Bancaria Origen',
			allowBlank:true,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
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
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:230,
			grid_indice:3,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		id_grupo:1,
		filterColValue:'INS.nombre#CTA.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};

	
	Atributos[6]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			grid_indice:2,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ob.observaciones',
		save_as: 'observaciones'
	
	};

	
	Atributos[7]={
			validacion:{
				name:'accion_obli',
				
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false
		};
		
		
	Atributos[8]= {
		validacion: {
			name:'tipo_pago',			
			fieldLabel:'Tipo Pago',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','cheque'],['transferencia','transferencia']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		id_grupo:1,
		filterColValue:'OB.tipo_pago'		
	};
	
	Atributos[9]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'monto',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
		Atributos[5]= {
			validacion:{
				name:'fecha_pago',
				fieldLabel:'Fecha Pago',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:false
			},
			form:true,
			id_grupo:1,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'OB.fecha_pago',
			dateFormat:'m-d-Y',
			defecto:''

		};
		
	
		
	Atributos[11]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			allowBlank:false,
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			width:200,
			pageSize:10,
			direccion:direccion,
			grid_visible:true,
			width_grid:200,
			renderer:render_id_cuenta,
			filterCols:filterCols_obligacion,
				filterValues:filterValues_obligacion,
			disabled:false,
			onSelect:function(record){ 				
				//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
				getComponente('id_cuenta').setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
				getComponente('id_cuenta').collapse();				
				ds_id_auxiliar.baseParams={cuenta:record.data.id_cuenta};				
				getComponente('id_auxiliar').modificado=true;
				getComponente('id_auxiliar').setValue('');
				getComponente('id_auxiliar').setDisabled(false);	 	
			}	
		},
		tipo:'LovCuenta',
		id_grupo:0,
		save_as:'id_cuenta',
		form:true
	};

			Atributos[12]= {
			validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:false,			
			//emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			grid_visible:true,
			renderer:render_id_auxiliar,
			disabled:true,
			width_grid:200 // ancho de columna en el gris
			
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'id_auxiliar',
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar'
	};
			
			
		Atributos[13]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'mi_array',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
		Atributos[14]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'cantidad_obligaciones',
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
		var config={titulo_maestro:'obligacion',
		grid_maestro:'grid-'+idContenedor,
		urlHijo:'../../../sis_kardex_personal/vista/columna_partida_ejecucion/columna_partida_ejecucion.php'};
		var layout_obligacion=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		layout_obligacion.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_obligacion,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var cm_EnableSelect=this.EnableSelect;
		var CM_btnNew=this.btnNew;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var CM_btnEdit=this.btnEdit;
		var dialog= this.getDialog;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/obligacion/ActionEliminarObligacion.php'},
			Save:{url:direccion+'../../../control/obligacion/ActionGuardarObligacion.php'},
			ConfirmSave:{url:direccion+'../../../control/obligacion/ActionGuardarObligacion.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Obligacion',
			grupos:
			[{tituloGrupo:'Datos Fijos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Editables',columna:0,id_grupo:1}
			]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			//funcion de reload

			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm, row, rec);
			}


			this.reload=function(params){


				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_planilla=datos.id_planilla;


				Atributos[1].defecto=maestro.id_planilla;
				/*
				paramFunciones={
				btnEliminar:{url:direccion+'../../../control/planilla_presupuesto/ActionEliminarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Save:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				ConfirmSave:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Presupuesto'}};

				*/



				this.InitFunciones(paramFunciones);

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_planilla:maestro.id_planilla
					}
				};

				this.btnActualizar()
			}

			this.btnNew=function(){
				dialog().resizeTo(450,270);
				getComponente('id_tipo_obligacion').enable();
				CM_ocultarGrupo('Datos Editables');
				CM_mostrarGrupo('Datos Fijos');
				CM_ocultarComponente(getComponente('id_cuenta'));
					CM_ocultarComponente(getComponente('id_auxiliar'));
					
					getComponente('id_cuenta').allowBlank=true;
					getComponente('id_auxiliar').allowBlank=true;
				CM_btnNew();
			}

			
			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					getComponente('accion_obli').setValue('');
					CM_ocultarGrupo('Datos Editables');
					CM_mostrarGrupo('Datos Fijos');
					CM_mostrarComponente(getComponente('id_cuenta'));
					CM_mostrarComponente(getComponente('id_auxiliar'));
					getComponente('id_tipo_obligacion').disable();
					
					getComponente('id_cuenta').enable();
	    			filterCols_obligacion[0]='GESTION.id_gestion';
	    			filterValues_obligacion[0]=maestro.id_gestion;
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
			}
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				txt_fecha_pago=getComponente('fecha_pago');
				cmb_cta_bancaria=getComponente('id_cuenta_bancaria');
				//para iniciar eventos en el formulario
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
				
				
				var FechaPago=function(e){
					cmb_cta_bancaria.setValue('');
					ds_cuenta_bancaria.modificado=true;
					g_pago=parseFloat(e.value.substring(6,10));
					
					
					ds_cuenta_bancaria.baseParams={
						gestion:g_pago,
						tipo_vista:'tkp_obligacion'
					}
					ds_cuenta_bancaria.modificado=true;
				}
				
				txt_fecha_pago.on('change',FechaPago);
			}
			
				
		function btn_solicitar_pago(){
				
				var sm=getSelectionModel();
				
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelectP=sm.getCount();
				var mm=sm.getSelections();
				var m;
				
				//[i].data[parametrosDatos[0].validacion.name];
				
				if(NumSelectP!=0){
					m_bandera='no';
					mi_array=new Array();
					for(m=0;m<NumSelectP;m++){
						
						mi_array[m]=mm[m].data['id_obligacion'];
						if(mm[m].data['id_cuenta']=='' || mm[m].data['id_cuenta']==undefined || mm[m].data['id_cuenta']==null){
							m_bandera='si';
						}
					}
					if(m_bandera=='no'){
							var SelectionsRecord=sm.getSelected(); //alert(SelectionsRecord.data.id_tipo_obligacion);
							getComponente('accion_obli').setValue('pago');
							getComponente('id_tipo_obligacion').setValue(SelectionsRecord.data.id_tipo_obligacion);
							getComponente('id_obligacion').setValue(SelectionsRecord.data.id_obligacion);
							getComponente('observaciones').setValue(SelectionsRecord.data.observaciones);
							
							CM_ocultarGrupo('Datos Fijos');
							CM_mostrarGrupo('Datos Editables');
							CM_ocultarComponente(getComponente('id_cuenta'));
							CM_ocultarComponente(getComponente('id_auxiliar'));
							
							getComponente('mi_array').setValue(mi_array);
							getComponente('cantidad_obligaciones').setValue(NumSelectP);
							CM_btnEdit();
							sm.clearSelections();
							NumSelectP=0;
							ds.rejectChanges();
						
							
					}else{
						alert('Es necesario registrar Cuenta/auxiliar para la obligacion que no cuente con ella');
					}
				}else{
					alert('Antes debe seleccionar un item');
				}
		}

		function btn_reporte_obligaciones(){
		
					var data='id_planilla='+maestro.id_planilla;
					window.open(direccion+'../../../control/obligacion/ActionPDFObligacionPlanilla.php?'+data)
				
			}
			
			var nombre='';
		function btn_archivo_pago(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&id_subsistema=5';
					var data=data+'&id_cuenta_bancaria='+SelectionsRecord.data.id_cuenta_bancaria;
					
					var data=data+'&nombre=pago_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					nombre='pago_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
						Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
						success:successGenerar,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			}
			}
			
		function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/'+nombre);
	}
		
			
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_obligacion.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			
 			var CM_getBoton=this.getBoton;
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Solicitar Pago',btn_solicitar_pago,true,'solicitar_pago','');
	
			
			
			
			function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
					if(record.estado_reg!='borrador'){
						CM_getBoton('solicitar_pago-'+idContenedor).disable();
					}else {
						CM_getBoton('solicitar_pago-'+idContenedor).enable();
					}
					
					if(record.codigo=='SUELLIQ'){
						CM_getBoton('archivo_pago-'+idContenedor).enable();
					}else{
						CM_getBoton('archivo_pago-'+idContenedor).disable();
					}
					
				}
			}
			
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de Obligaciones',btn_reporte_obligaciones,true,'ver_reporte_obligaciones','Reporte Obligaciones');
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Archivo Pago',btn_archivo_pago,true,'archivo_pago','Archivo de Pago TXT'); 
			this.iniciaFormulario();
			iniciarEventosFormularios();
			
			
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:maestro.id_planilla
				}
			});
			layout_obligacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
			_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}