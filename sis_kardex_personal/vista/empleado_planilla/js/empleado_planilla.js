/**
 * Nombre:		  	    pagina_empleado_planilla.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-27 14:34:08
 */
function pagina_empleado_planilla(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/empleado_planilla/ActionListarEmpleadoPlanilla.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado_planilla',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_planilla',
		'id_empleado',
		'nombre_completo',
		'id_planilla',
		'id_usuario',
		'usuario',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'pago_liquido'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	//DATA STORE COMBOS

	 var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','apellido_paterno','apellido_materno','nombre','codigo_empleado'])
	    });

  	//FUNCIONES RENDER
	
    function render_id_empleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}','</div>');

	function render_id_usuario(value, p, record){return String.format('{0}', record.data['usuario']);}

	render_incluido=function (value, p, record){
			if(record.data['pago_liquido']=='true'){
					return 'si';
				}else{
					return 'no';
				}
				
			};
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_empleado_planilla
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_empleado_planilla',
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
				name:'id_empleado',
				fieldLabel:'Funcionario',
				allowBlank:false,			
				emptyText:'funcionario...',
				desc: 'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField: 'desc_persona',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
				typeAhead:false,
				tpl:tpl_id_empleado,
				forceSelection:true,
				mode:'remote',
				pageSize:20,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_empleado,
				grid_visible:true,
				grid_editable:false,
				width_grid:300,
				width:250,
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'EMPLEA.nombre_completo'
			
		};
	// txt id_planilla
		Atributos[2]={
				validacion:{
				name:'id_planilla',
				fieldLabel:'id_planilla',
				grid_visible:false,
				grid_editable:false,
				width_grid:100
			},
			tipo:'Field',
			form: false,
			filtro_0:false,
			filterColValue:'PLANIL.id_planilla'
			
		};
	// txt id_usuario
		Atributos[3]={
				validacion:{
				name:'id_usuario',
				fieldLabel:'Usuario',
				renderer:render_id_usuario,
				grid_visible:false,
				grid_editable:false,
				width_grid:70		
			},
			tipo:'Field',
			form: false,
			filtro_0:false,
			filterColValue:'USUARI.login'
			
		};
	// txt fecha_reg
		Atributos[4]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Reg.',
				grid_visible:false,
				grid_editable:false,
				width_grid:100		
			},
			tipo:'Field',
			filtro_0:false,
			form:false,		
			filterColValue:'EMPPLA.fecha_reg',
			dateFormat:'m-d-Y'
		};
		
		Atributos[5]={
				validacion:{
				name:'pago_liquido',
				fieldLabel:'pago_liquido',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				checked:true,
				renderer:render_incluido
			},
			tipo:'Checkbox',
			form: false,
			filtro_0:false,
			filterColValue:'EMPPLA.pago_liquido'
			
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	

	//---------- INICIAMOS LAYOUT DETALLE
	/*var config={titulo_maestro:'Planilla de Sueldos (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_empleado_planilla = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_empleado_planilla.init(config);*/
	
	var config;
	var layout_empleado_planilla;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu;

	if(maestro.vista_doble=='si'){
		config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/columna_valor/columna_valor.php'};
		layout_empleado_planilla = new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		paramMenu={actualizar:{crear:true,separador:false}};
	} else{
		config={titulo_maestro:'Planilla (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor};
		layout_empleado_planilla = new DocsLayoutMaestro(idContenedor);
		paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	}
	layout_empleado_planilla.init(config);
	
	//var layout_empleado_planilla = new DocsLayoutMaestro(idContenedor);
	//layout_empleado_planilla.init({titulo_maestro:'Planilla (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor});
		
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_empleado_planilla,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var enableSelect=this.EnableSelect;
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/empleado_planilla/ActionEliminarEmpleadoPlanilla.php'},
	Save:{url:direccion+'../../../control/empleado_planilla/ActionGuardarEmpleadoPlanilla.php'},
	ConfirmSave:{url:direccion+'../../../control/empleado_planilla/ActionGuardarEmpleadoPlanilla.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Funcionarios'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	
	
	
	var mi_colm =this.getColumnModel();
	mi_colm.setRenderer(this.getColumnNum('pago_liquido'),render_incluido);
	
	this.reload=function(m){
		//Verifica el tipo de reload
		if(maestro.vista_doble=='si'){
			var datos=Ext.urlDecode(decodeURIComponent(m));
			maestro.id_planilla=datos.id_planilla;

			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:maestro.id_planilla
				}
			};
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.limpiarStore();
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.bloquearMenu();
			this.btnActualizar();
			iniciarEventosFormularios();

			//gridMaestro.getDataSource().removeAll();

			//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
			Atributos[2].defecto=maestro.id_planilla;
			paramFunciones.btnEliminar.parametros='&id_planilla='+maestro.id_planilla;
			paramFunciones.Save.parametros='&id_planilla='+maestro.id_planilla;
			paramFunciones.ConfirmSave.parametros='&id_planilla='+maestro.id_planilla;
			this.iniciarEventosFormularios;
			this.InitFunciones(paramFunciones);
		
		} else{
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:m.id_planilla
				}
			};
			this.btnActualizar();
			
			Atributos[2].defecto=maestro.id_tipo_planilla;
			paramFunciones.btnEliminar.parametros='&id_planilla='+m.id_planilla;
			paramFunciones.Save.parametros='&id_planilla='+m.id_planilla;
			paramFunciones.ConfirmSave.parametros='&id_planilla='+m.id_planilla;
			this.InitFunciones(paramFunciones)
		}
		
	};
		function btn_papeleta_sueldo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla;
					data= data +'&id_planilla='+SelectionsRecord.data.id_planilla;
					window.open(direccion+'../../../control/planilla/ActionPDFBoletaPago.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	
	}
		function btn_resumen_horario_mes(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado_planilla='+SelectionsRecord.data.id_empleado_planilla+'&m_nombre_completo='+SelectionsRecord.data.nombre_completo;
			data=data+"&vista_doble=si";
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado_planilla.loadWindows(direccion+'../../../../sis_kardex_personal/vista/resumen_horario_mes/resumen_horario_mes.php?'+data,'Resumen Horarios',ParamVentana);
			layout_empleado_planilla.getVentana().on('resize',function(){
			layout_empleado_planilla.getLayout().layout();
			
			});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un funcionario');
		}

	}
	if(maestro.vista_doble=='si'){
		this.EnableSelect=function(sm,row,rec){
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.reload(rec.data);
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.desbloquearMenu();
			enableSelect(sm,row,rec);
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_empleado_planilla.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Papeleta de Sueldo',btn_papeleta_sueldo,true,'papeleta_sueldo','');
	//this.AdicionarBoton('../../../lib/imagenes/copy.png','Resumen Horarios',btn_resumen_horario_mes,true,'resumen_horario_mes','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	if(maestro.vista_doble=='si'){
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla
			}
		});
	} else{
		this.bloquearMenu();
	}
		
	layout_empleado_planilla.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}