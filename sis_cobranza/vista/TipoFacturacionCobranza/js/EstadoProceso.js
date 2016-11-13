/**
 * Nombre:		  	    pagina_registro_documento.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
 */
function pagina_EstadoProceso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var componentes_grid=new Array();
	var grid;	
	var var_record;	
	/////////////////
	//  DATA STORE //
	/////////////////
 
  	var Documento = Ext.data.Record.create(['id_estado_proceso', 'id_tipo_facturacion_cobranza', 'nombre_proceso', 'accion_anterior', 'accion_siguiente', 'prioridad', 'sw_dblink_anterior', 'sw_dblink_siguiente','nombre_estado']);
	var ds = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/EstadoProceso/ActionListarEstadoProceso.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_estado_proceso',	totalRecords: 'TotalCount'}, Documento),remoteSort:true});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Proceso ',maestro.nombre_proceso,'sw_periodo ',maestro.sw_periodo,'sw_banco',maestro.sw_banco]];
	
	//DATA STORE GRILLA
	ds.load({params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_concepto_factura:maestro.id_concepto_factura
					}
			});	
    //FUNCIONES DE LOS COMBOS
 
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_documento
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_estado_proceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_estado_proceso'
	};

		Atributos[1]={
		validacion:{
			name:'id_tipo_facturacion_cobranza',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_facturacion_cobranza,
		id_grupo:0,
		save_as:'id_tipo_facturacion_cobranza'
	};	
  
	 
		// txt calculo_conta
		Atributos[2]={
			validacion:{
				name:'nombre_estado',
				fieldLabel:'Nombre Estado',
				allowBlank:true,
				maxLength:1000,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'nombre_estado',
			save_as:'nombre_estado'
		};	// txt calculo_conta
		Atributos[3]={
			validacion:{
				name:'accion_anterior',
				fieldLabel:'Acción Anterior',
				allowBlank:true,
				maxLength:100000000,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'accion_anterior',
			save_as:'accion_anterior'
		};	
		// txt calculo_conta
		Atributos[4]={
			validacion:{
				name:'accion_siguiente',
				fieldLabel:'Acción siguiente',
				allowBlank:true,
				maxLength:100000000,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'accion_siguiente',
			save_as:'accion_siguiente'
		};	
	Atributos[5]={
			validacion:{
				labelSeparator:'prioridad',
				fieldLabel:'Prioridad',
				name: 'prioridad',
				allowBlank:true,
				allowDecimals:false,
				maxLength:70,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:2
			},
			tipo: 'NumberField',
			form: true,
			id_grupo:1,
			filtro_0:true,
			filterColValue:'prioridad',
			save_as:'prioridad'
		};
		// txt calculo_conta
		Atributos[6]={
			validacion:{
				name:'sw_dblink_anterior',
				fieldLabel:'DBL Acción Anterior',
				allowBlank:true,
				maxLength:100000000,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'sw_dblink_anterior',
			save_as:'sw_dblink_anterior'
		};	
		// txt calculo_conta
		Atributos[7]={
			validacion:{
				name:'sw_dblink_siguiente',
				fieldLabel:'DBL Acción siguiente',
				allowBlank:true,
				maxLength:100000000,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'sw_dblink_siguiente',
			save_as:'sw_dblink_siguiente'
		};
	
			//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipo Facturacion Cobranza (Maestro)',titulo_detalle:'Estado Proceso (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_estado_proceso = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_registro_estado_proceso.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_registro_estado_proceso,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var getCM=this.getColumnModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit =this.btnEdit;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_ocultarGrupo=this.ocultarGrupo;
	
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/EstadoProceso/ActionEliminarEstadoProceso.php',parametros:'&id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza},
	Save:{url:direccion+'../../../control/EstadoProceso/ActionGuardarEstadoProceso.php',parametros:'&id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza},
	ConfirmSave:{url:direccion+'../../../control/EstadoProceso/ActionGuardarEstadoProceso.php',parametros:'&id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'registro columna',
	grupos:[
				{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Estado Proceso:',columna:0,id_grupo:1}
				]
	}};
function 	 MaestroJulio(data){
		
		var mayor=0;		
		var j;
		
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
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
	
	var datos=Ext.urlDecode(decodeURIComponent(params));
	
  

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_facturacion_cobranza:maestro.id_tipo_facturacion_cobranza
			}
			 
		};
		this.btnActualizar();
		 
		var data_maestro=[['Proceso ',maestro.nombre_proceso,'sw_periodo ',maestro.sw_periodo,'sw_banco',maestro.sw_banco]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		paramFunciones.btnEliminar.parametros='id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza;
		paramFunciones.Save.parametros='id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza;
		paramFunciones.ConfirmSave.parametros='id_tipo_facturacion_cobranza='+maestro.id_tipo_facturacion_cobranza;
	 	

		this.InitFunciones(paramFunciones)
	
	};
	
	
	
	
 

function InitRegistroDocumento()
{		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		
		
};
 
 
	



/********************************************************/

	this.getLayout=function(){return layout_registro_estado_proceso.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	InitRegistroDocumento();


	 
 
CM_ocultarGrupo('Oculto:');
	layout_registro_estado_proceso.getLayout().addListener('layout',this.onResize);
	layout_registro_estado_proceso.getVentana().addListener('beforehide',function(){ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar()})


	  		
}