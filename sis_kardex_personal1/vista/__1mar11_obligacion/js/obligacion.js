/**
* Nombre:		  	    pagina_afp.js
* Propósito: 			pagina objeto principal
* Autor:				Mercedes Zambrana Meneses
* Fecha creación:		11-08-2010
*/
function pagina_obligacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0, g_pago;
	
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
		{name: 'fecha_pago',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});


		var ds_id_tipo_obligacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/tipo_obligacion/ActionListarTipoObligacion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_obligacion',totalRecords: 'TotalCount'},
		['id_tipo_obligacion','codigo','nombre'])
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
			allowBlank:false,
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
					getComponente('id_tipo_obligacion').disable();
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
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected(); //alert(SelectionsRecord.data.id_tipo_obligacion);
					
					getComponente('accion_obli').setValue('pago');
					getComponente('id_tipo_obligacion').setValue(SelectionsRecord.data.id_tipo_obligacion);
					getComponente('id_obligacion').setValue(SelectionsRecord.data.id_obligacion);
					getComponente('observaciones').setValue(SelectionsRecord.data.observaciones);
					
					CM_ocultarGrupo('Datos Fijos');
					CM_mostrarGrupo('Datos Editables');
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
		}

		function btn_reporte_obligaciones(){
		
					var data='id_planilla='+maestro.id_planilla;
					window.open(direccion+'../../../control/obligacion/ActionPDFObligacionPlanilla.php?'+data)
				
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
					
				}
			}
			
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de Obligaciones',btn_reporte_obligaciones,true,'ver_reporte_obligaciones','Reporte Obligaciones');
	
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