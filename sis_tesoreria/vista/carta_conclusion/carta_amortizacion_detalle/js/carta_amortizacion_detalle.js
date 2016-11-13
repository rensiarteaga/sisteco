/**
 * Nombre:		  	    pagina_carta_amortizacion_detalle.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-18 20:39:05
 */
function pagina_carta_amortizacion_detalle(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var tituloM,maestro,txt_fk_carta;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/carta/ActionListarCartaRegistro.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_carta',totalRecords:'TotalCount'
		},[		
		'id_carta',
        {name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		'obs_carta',
		'importe_pagado',
		'fk_carta'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
      
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_carta',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};
	Atributos[1]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Amortización',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:120,
			disabled:false		
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CARTA.fecha_inicio',
		dateFormat:'m-d-Y'		
	};
	Atributos[2]={
		validacion:{
			name:'importe_pagado',
			fieldLabel:'Importe Pagado',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'CARTA.importe_pagado'
	};

	
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'fk_carta',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};

	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
     tituloM='Carta';
	//---------- INICIAMOS LAYOUT DETALLE

	var config={titulo_maestro:'Carta (Maestro)',titulo_detalle:'Detalle de Carta (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_carta_amortizacion_detalle= new DocsLayoutMaestro(idContenedor);
		layout_carta_amortizacion_detalle.init(config);
	// INICIAMOS HERENCIA //
	
	this.pagina=Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_carta_amortizacion_detalle,idContenedor);
			var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadregetComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	
	this.reload=function(m){
				maestro=m;
               // alert (maestro.id_avance);
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_carta:maestro.id_carta
					}
				};
				this.btnActualizar();
				m_id_carta=maestro.id_carta
					
			};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/carta/ActionEliminarCartaRegistro.php'},
		Save:{url:direccion+'../../../control/carta/ActionGuardarCartaAmortizacionDetalle.php'},
		ConfirmSave:{url:direccion+'../../../control/carta/ActionGuardarAmortizacionDetalle.php'},
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:400,width:480,
		minWidth:150,minHeight:200,
		closable:true,titulo:'carta',
		grupos:[{tituloGrupo:'Carta',
			columna: 0,
			id_grupo:0
		}
		
	    ]
		}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
     
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
	   txt_fk_carta=ClaseMadregetComponente('fk_carta');
	}
		
	this.btnNew=function(){
		
		
		//alert(txt_fk_carta.getValue());
		btnNew();	
		txt_fk_carta.setValue(m_id_carta);	
	}
  //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_carta_amortizacion_detalle.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//InitPaginaCartaRegistro();
	this.bloquearMenu();
	layout_carta_amortizacion_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}