/**
 * Nombre:		  	    pagina_empleado_planilla.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-27 14:34:08
 */
function pagina_columna_partida_ejecucion(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/columna_partida_ejecucion/ActionListarVistaColParEje.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'codigo_columna',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'codigo_columna',
		'nombre_columna',
		'id_ppto',
		'id_planilla',
		'importe',
		'cuenta',
		'auxiliar','partida','tiene_ppto'
		
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	//DATA STORE COMBOS

	 function negrita(val,cell,record,row,colum,store){

			if(record.get('tiene_ppto')=='0'){
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				return val;
			}
		}


	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_empleado_planilla
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Código',
				name: 'codigo_columna',
				inputType:'hidden',
				grid_visible:true, 
				renderer:negrita,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
		
		Atributos[1]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Nombre',
				renderer:negrita,
				name: 'nombre_columna',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.nombre_columna'
			
		};
		
		
		
		Atributos[2]={
			validacion:{
				labelSeparator:'',
				name: 'id_ppto',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
		Atributos[3]={
			validacion:{
				labelSeparator:'',
				name: 'importe',
				renderer:negrita,
				fieldLabel:'Importe',
				align:'right',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'NumberField',
			filtro_0:false
			
		};
		
		
		Atributos[4]={
			validacion:{
				labelSeparator:'',
				name: 'id_planilla',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
			Atributos[5]={
			validacion:{
				labelSeparator:'',
				name: 'cuenta',
				fieldLabel:'Cuenta Pasivo',
				inputType:'hidden',
				grid_visible:true, 
				width_grid:220,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.cuenta'
			
		};
		
		
		Atributos[6]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Auxiliar Pasivo',
				name: 'auxiliar',
				inputType:'hidden',
				grid_visible:true, 
				width_grid:170,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.auxiliar'
		};
		
		
		Atributos[7]={
			validacion:{
				labelSeparator:'',
				name: 'partida',
				width_grid:190,
				renderer:negrita,
				fieldLabel:'Partida Presupuestaria',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.partida'
		};

		
		
		Atributos[8]={
			validacion:{
				labelSeparator:'',
				name: 'tiene_ppto',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
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
		layout_empleado_planilla = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		paramMenu={actualizar:{crear:true,separador:false}};
	} else{
		config={titulo_maestro:'Planilla (Maestro)',titulo_detalle:'Funcionarios (Detalle)',grid_maestro:'grid-'+idContenedor};
		layout_empleado_planilla = new DocsLayoutMaestro(idContenedor);
		paramMenu={
		actualizar:{crear:true,separador:false}};
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
	this.reload=function(m){
		//Verifica el tipo de reload
		if(maestro.vista_doble=='si'){
			var datos=Ext.urlDecode(decodeURIComponent(m));
			maestro.id_planilla=datos.id_planilla;
			maestro.id_presupuesto=datos.id_prespuesto;

			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:maestro.id_planilla,
					id_ppto:maestro.id_presupuesto
				}
			};
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.limpiarStore();
			_CP.getPagina(layout_empleado_planilla.getIdContentHijo()).pagina.bloquearMenu();
			this.btnActualizar();
			iniciarEventosFormularios();

			//gridMaestro.getDataSource().removeAll();

			//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
			Atributos[4].defecto=maestro.id_planilla;
			Atributos[2].defecto=maestro.id_presupuesto;
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
					id_planilla:m.id_planilla,
					id_ppto:m.id_presupuesto
				}
			};
			this.btnActualizar();
			
			Atributos[4].defecto=maestro.id_planilla;
			Atributos[2].defecto=maestro.id_presupuesto;
			paramFunciones.btnEliminar.parametros='&id_planilla='+m.id_planilla;
			paramFunciones.Save.parametros='&id_planilla='+m.id_planilla;
			paramFunciones.ConfirmSave.parametros='&id_planilla='+m.id_planilla;
			this.InitFunciones(paramFunciones)
		}
		
	};
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	
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

	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	if(maestro.vista_doble=='si'){
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla,
				id_ppto:maestro.id_presupuesto
			}
		});
	} else{
		this.bloquearMenu();
	}
		
	layout_empleado_planilla.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}