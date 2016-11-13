/**
 * Nombre:		  	    pagina_bancarizacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:35
 */
function pagina_bancarizacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	  
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/bancarizacion/ActionListarBancarizacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_bancarizacion',totalRecords:'TotalCount'
		},[		
		'id_bancarizacion',
		'id_usuario_reg',
		'login',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

  
	
	//FUNCIONES RENDER
	
	

		function render_estado_gestion(value, p, record){
			if (value==1) {
				return 'Pre Abierto';
			}else if(value==2){
				return 'Abierto';
			}else if(value==3){
				return 'Pre Cerrado';
			}else if(value==4){
				return 'Cerrado';
			}
		
		}
			
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_bancarizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_parametro'
	};
	Atributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
		Atributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
	Atributos[3]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'BANCA.observaciones'
	};	
	Atributos[4]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'BANCA.estado'
	};
Atributos[5]={
		validacion:{
			labelSeparator:'',
			name:'id_usuario_reg',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[6]={
		validacion:{
			name:'login',
			fieldLabel:'Usuario Reg',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		form:false,
		tipo:'TextField'
	};
	Atributos[7]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};

	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'bancarizacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/bancarizacion_det/bancarizacion_det.php'};
	var layout_bancarizacion=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_bancarizacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_bancarizacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
    var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	var ClaseMadre_conexionFailure=this.conexionFailure;
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
		btnEliminar:{url:direccion+'../../../control/bancarizacion/ActionEliminarBancarizacion.php'},
		Save:{url:direccion+'../../../control/bancarizacion/ActionGuardarBancarizacion.php'},
		ConfirmSave:{url:direccion+'../../../control/bancarizacion/ActionGuardarBancarizacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:350,minWidth:150,minHeight:200,	closable:true,titulo:'bancarizacion'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )	
	}
this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		
		_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.desbloquearMenu();	               	
		_CP.getPagina(layout_bancarizacion.getIdContentHijo()).pagina.reload(rec.data);
			
		
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_bancarizacion.getLayout()};
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	function generaSuccess(){
			alert('Generación del detalle exitoso');
			Ext.MessageBox.hide();						
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});
	}
	function btn_generar(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			Ext.Ajax.request({
						url:direccion+"../../../../sis_contabilidad/control/bancarizacion/ActionGeneraDetalle.php?"+data,
						success:generaSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_rep_pdf(t){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
					data=data+'&tipo='+t;
					
				window.open(direccion+'../../../control/bancarizacion/ActionPDFBancarizacion.php?'+data)
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	function btn_rep_ascii(t){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_bancarizacion='+SelectionsRecord.data.id_bancarizacion;
			data=data+'&tipo='+t;
			Ext.Ajax.request({
						url:direccion+"../../../../sis_contabilidad/control/bancarizacion/ActionGeneraAscii.php?"+data,
						success:generaSuccess,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});

		}else{var enableSelect=this.EnableSelect;
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}	
	var sw_reporte_compras = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_compras',fields:['ID','valor','filtro'],
                                              data:[['PDF','Reporte'],['TXT','Archivo ASCII']]}),
                                              typeAhead: false,
                                              mode:'local',
                                              triggerAction:'all',
                                              emptyText:'Compras...',
                                              selectOnFocus:true,
                                              width:120,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});	
   sw_reporte_compras.on('select',function (combo, record, index)
                                     {  
                                     	//alert (sw_reporte_planilla.getValue());
                                     	if(sw_reporte_compras.getValue()=='PDF'){
                                     		btn_rep_pdf('c');
                                     	}else{
                                     		
                                      	   btn_rep_ascii('c');
                                     	}
                                     	//alert (reporte_planilla.getValue());
                                     }
                          );
    var sw_reporte_ventas = new Ext.form.ComboBox({store: new Ext.data.SimpleStore({name:'reporte_ventas',fields:['ID','valor','filtro'],
                                              data:[['PDF','Reporte'],['TXT','Archivo ASCII']]}),
                                              typeAhead:false,
                                              mode:'local',
                                              triggerAction:'all',
                                              emptyText:'Ventas...',
                                              selectOnFocus:true,
                                              width:120,
                                              valueField:'ID',
                                              displayField:'valor',
                                              mode:'local'});	
   sw_reporte_ventas.on('select',function (combo, record, index)
                                     {  
                                     	//alert (sw_reporte_planilla.getValue());
                                     	if(sw_reporte_ventas.getValue()=='PDF'){
                                     		btn_rep_pdf('v');
                                     	}else{
                                     		
                                      	   btn_rep_ascii('v');
                                     	}
                                     	//alert (reporte_planilla.getValue());
                                     }
                          );                      
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
    
	//para agregar botones
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Generar',btn_generar,true,'generar_det','Generar Detalle');
    this.AdicionarBotonCombo(sw_reporte_compras,'Reporte Compras');
    this.AdicionarBotonCombo(sw_reporte_ventas,'Reporte Ventas');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_bancarizacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}