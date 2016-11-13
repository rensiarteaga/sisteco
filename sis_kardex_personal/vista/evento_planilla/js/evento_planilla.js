/**
 * Nombre:		  	    pagina_evento_planilla.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		11-08-2010
 */
function pagina_evento_planilla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array;
	var ds;
	var accion_pp;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/evento_planilla/ActionListarEventoPlanilla.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_evento_planilla',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		   'id_evento_planilla',
			'id_planilla',
			'id_tipo_descuento_bono',
			'valor',
			'nombre'
		    'estado_reg'
		    ]),remoteSort:true});
	//carga datos XML


   ds_tipo_descuento_bono=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_descuento_bono/ActionListarTipoDescuentoBono.php?estado=activo"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_descuento_bono',totalRecords:'TotalCount'},['id_tipo_descuento_bono','nombre','tipo','codigo','descripcion','modalidad'])});
	
	
	
	
	
	
		function render_estado_reg(value){
			if(value=='activo'){value='Activo'	}
			else{	value='Inactivo'		}
			return value
		}
		
	
	
	// Definiciï¿½n de datos //
	// hidden id_empleado_frppa
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_evento_planilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
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
	
	
		filterCols=new Array();
		filterValues=new Array();
		filterCols[0]='id_gestion';
		filterValues[0]=maestro.id_gestion;

	
	
	Atributos[2]={
	    validacion:{
			fieldLabel:'Descuento/Bono',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Descuento/Bono...',
			name:'id_tipo_descuento_bono',
			desc:'desc_tipo_descuento_bono',
			store:ds_tipo_descuento_bono,
			valueField:'id_tipo_descuento_bono',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'DESBONO.nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:render_id_tipo_descuento_bono,
			
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		save_as:'id_tipo_descuento_bono',
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'DESBONO.nombre'
	};
	
	
	
    
	
	 Atributos[3]={
		validacion:{
			name:'valor',
			fieldLabel:'Valor',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150
		},
		tipo:'NumberField',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'valor'	
	};
	
	
	
	Atributos[4]= {
		validacion: {
			name:'estado_reg',
			fieldLabel:'Estado',
			
			lazyRender:true,
			renderer:render_estado_reg,			
			disabled:true,			
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:150
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'pp.estado_reg'
		};
		
		
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Planilla (Maestro)',
	//	titulo_detalle:'Presupuesto (Detalle)'
		grid_maestro:'grid-'+idContenedor
		,urlHijo:'../../../sis_kardex_personal/vista/columna_partida_ejecucion/columna_partida_ejecucion_arb.php'
	};
	layout_evento_planilla=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout_evento_planilla.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_evento_planilla,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
		var enableSelect=this.EnableSelect;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIóN DE LA BARRA DE MENú
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIï¿½N DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/evento_planilla/ActionEliminarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	Save:{url:direccion+'../../../control/evento_planilla/ActionGuardarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	ConfirmSave:{url:direccion+'../../../control/evento_planilla/ActionGuardarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Presupuesto'}};
	
	//funcion de reload
	
	
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_planilla=datos.id_planilla;
		maestro.id_gestion=datos.id_gestion;
	//	gridMaestro.getDataSource().removeAll();
		//gridMaestro.getDataSource().loadData([['Id Planilla',maestro.id_planilla],['Id gestion',maestro.id_gestion]]);
		

		Atributos[1].defecto=maestro.id_planilla;

		paramFunciones={
	  	btnEliminar:{url:direccion+'../../../control/evento_planilla/ActionEliminarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
		Save:{url:direccion+'../../../control/evento_planilla/ActionGuardarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
		ConfirmSave:{url:direccion+'../../../control/evento_planilla/ActionGuardarEventoPlanilla.php',parametros:'&m_id_planilla='+maestro.id_planilla},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Presupuesto'}};
	   
	   
	
		Atributos[2].validacion.filterValues[0]=maestro.id_gestion;
		
	  
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla
			}
			};
		 	
		this.iniciarEventosFormularios;
		this.btnActualizar();
		iniciarEventosFormularios();
		this.InitFunciones(paramFunciones);
		//_CP.getPagina(layout_evento_planilla.getIdContentHijo()).pagina.limpiarStore();
	}
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		
		getSelectionModel().on('rowdeselect',function(){
					//if(_CP.getPagina(layout_evento_planilla.getIdContentHijo()).pagina.limpiarStore()){ 
						//_CP.getPagina(layout_evento_planilla.getIdContentHijo()).pagina.bloquearMenu();
					//}
				})
	}
	this.btnNew=function(){
		//ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
	mostrarComponente(getComponente('fecha_reg'));
	ClaseMadre_btnEdit()
	};
//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){
		return layout_evento_planilla.getLayout()
	};
	
	function btn_revertir(){
		accion_pp='revertir';
		
		operar_accion(accion_pp);
	}
	
	function btn_comprometer(){
		accion_pp='comprometer';
		operar_accion(accion_pp);
	}
	
	var operar_accion=function(acc){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			
				var SelectionsRecord=sm.getSelected();
			    var data='id_evento_planilla='+SelectionsRecord.data.id_evento_planilla;
				data=data+'&accion_pp='+acc;
				
				 Ext.MessageBox.show({
						title: 'Procesando ...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando comprobante presupuestario ...</div>",
						width:150,
						height:200,
						closable:false
					});
				
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/evento_planilla/ActionComprometer.php?"+data,
				method:'POST',
				success:caluloSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
	
		function caluloSuccess(){
			Ext.MessageBox.hide();
			alert("Se comprometió presupuesto para la planilla con éxito")	;
				ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla
				
			}
		});
		//this.btnActualizar();
		 
			
	}
		//evento de deselecion de una linea de grid
	function btn_rep_ppto(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					
					window.open(direccion+'../../../control/evento_planilla/ActionPDFEventoPlanilla.php?'+data)
				
						
			}else {
				alert ("Elija la obligación");
			}
					
					
			}			

	this.EnableSelect=function(sm,row,rec){
				_CP.getPagina(layout_evento_planilla.getIdContentHijo()).pagina.reload(rec.data);
				//_CP.getPagina(layout_evento_planilla.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm,row,rec);
			}

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/terminar.png','Comprometer Presupuesto',btn_comprometer,true,'comprometer','');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Solicitud Pago Obligación',btn_rep_ppto,true,'archivo_pago','Rep. Comprometido Planilla');
	var CM_getBoton=this.getBoton;
		function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){  
				   if(record.momento=='no' ){
				   	   CM_getBoton('comprometer-'+idContenedor).enable();
				   	   //CM_getBoton('revertir-'+idContenedor).disable();
				   }else{
				   	   CM_getBoton('comprometer-'+idContenedor).disable();
				   	   //CM_getBoton('revertir-'+idContenedor).enable();
				   }
				    
				}

				enableSelect(sel,row,selected);
			}
		
			
			
	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_planilla:maestro.id_planilla
				
			}
		});
  
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_evento_planilla.getLayout().addListener('layout',this.onResize);
	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}