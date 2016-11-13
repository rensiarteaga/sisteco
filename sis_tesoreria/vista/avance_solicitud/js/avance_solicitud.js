/**
 * Nombre:		  	    pagina_cajero.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:45
 */
function avance_solicitud(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	//  DATA STORE //
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance/ActionListarAvanceSolicitud.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_solicitud_compra',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		     'id_solicitud_compra',
			 'num_solicitud',
			 'precio_total',
			 'id_fina_regi_prog_proy_acti',
			 'desc_fina_regi_prog_proy_acti',
			 'id_empleado_frppa_solicitante',
			 'desc_empleado_tpm_frppa',
			 'localidad',
			 'id_moneda',
			 'desc_moneda',
			 'id_unidad_organizacional',
			 'desc_unidad_organizacional',
			 'id_tipo_categoria_adq',
			 'desc_tipo_categoria_adq',
			 'tipo_adjudicacion',
			 'tipo_adq',
			 'observaciones',
			 'nombre',
			 'id_financiador',
			 'id_regional',
			 'id_programa',
			 'id_proyecto',
			 'id_actividad',
			 'nombre_financiador',
			 'nombre_regional',
			 'nombre_programa',
			 'nombre_proyecto',
			 'nombre_actividad',
			 'codigo_financiador',
			 'codigo_regional',
			 'codigo_programa',
			 'codigo_proyecto',
			 'codigo_actividad',
			 'num_solicitud_peri',
			 'gestion',
			 'categoria'
		]),remoteSort:true});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[
	['Solicitante',maestro.desc_empleado],
	['Departamento',maestro.desc_depto]];
	//DATA STORE COMBOS
  	var ds_solicitud_compra=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/avance/ActionListarSolicitudAvance.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra',totalRecords: 'TotalCount'},['id_solicitud_compra','precio_total','solicitante','desc_ep','numeracion_solicitud','desc_solicitud'])
	});
    //FUNCIONES RENDER
    function render_solicitud_compra(value, p, record){return String.format('{0}', record.data['numeracion_periodo']);}
	var tpl_solicitud_compra=new Ext.Template('<div class="search-item">',
		'<b>Solicitud: </b><FONT COLOR="#B5A642">{numeracion_solicitud}</FONT><BR>',
		'<b>Solicitante: </b><FONT COLOR="#B5A642">{solicitante}</FONT><BR>',
		'<b>Monto Solicitud: </b><FONT COLOR="#B5A642">{precio_total}</FONT><BR>',
		'<b>Moneda: </b><FONT COLOR="#B5A642">Bolivianos</FONT><BR>',
		'<b>Código EP: </b><FONT COLOR="#B5A642">{desc_ep}</FONT>',		
		'</div>');
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_solicitud_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra'
	};
	// txt id_empleado
var filterCols_solicitud=new Array();
var filterValues_solicitud=new Array();
filterCols_solicitud[0]='emp.id_empleado';
filterValues_solicitud[0]=maestro.id_empleado;
Atributos[1]={
			validacion:{
			name:'id_solicitud',
			fieldLabel:'Solicitud',
			allowBlank:false,			
			emptyText:'Solicitud...',
			store:ds_solicitud_compra,
			valueField:'id_solicitud_compra',
			displayField:'desc_solicitud',
			queryParam:'filterValue_0',
			filterCol:'SOLADQ.num_solicitud#SOLADQ.periodo',
			filterCols:filterCols_solicitud,
			filterValues:filterValues_solicitud,
			typeAhead:true,
			tpl:tpl_solicitud_compra,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			triggerAction:'all',
			grid_visible:false,
			grid_editable:false,
			width:240,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_solicitud'
	};
// txt num_peri
	Atributos[2]={
			validacion:{
			name:'num_solicitud_peri',
			fieldLabel:'Periodo/Nº',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};
Atributos[3]={
			validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};
Atributos[4]={
			validacion:{
			name:'precio_total',
			fieldLabel:'Monto Solicitud',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};		
Atributos[5]={
			validacion:{
			name:'tipo_adjudicacion',
			fieldLabel:'Adjudicación',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};		
Atributos[6]={
			validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Modalidad',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};
Atributos[7]={
			validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};				
Atributos[8]={
			validacion:{
			name:'nombre_financiador',
			fieldLabel:'Financiador',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};
Atributos[9]={
			validacion:{
			name:'nombre_regional',
			fieldLabel:'Regional',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};						
Atributos[10]={
			validacion:{
			name:'nombre_programa',
			fieldLabel:'Programa',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};
Atributos[11]={
			validacion:{
			name:'nombre_proyecto',
			fieldLabel:'Sub Programa',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};					
Atributos[12]={
			validacion:{
			name:'nombre_actividad',
			fieldLabel:'Actividad',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true
		};					
		//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Fondo Avance (Maestro)',titulo_detalle:'Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_avance_solicitud=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_avance_solicitud.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_avance_solicitud,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;

//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={nuevo:{crear:true,separador:true},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));//IMPORTANTE
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/avance_solicitud/ActionEliminarAvanceSolicitud.php',parametros:'&m_id_avance='+maestro.id_avance},
	Save:{url:direccion+'../../../control/avance_solicitud/ActionGuardarAvanceSolicitud.php',parametros:'&m_id_avance='+maestro.id_avance},
	ConfirmSave:{url:direccion+'../../../control/avance_solicitud/ActionGuardarAvanceSolicitud.php',parametros:'&m_id_avance='+maestro.id_avance},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Solicitud'}};
		
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
		
	maestro.id_avance=datos.m_id_avance;
    maestro.id_depto=datos.m_id_depto;
    maestro.desc_depto=datos.m_desc_depto;
    maestro.id_ep=datos.m_id_ep;
    maestro.id_empleado=datos.m_id_empleado;
    maestro.desc_empleado=datos.m_desc_empleado;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_avance:maestro.id_avance
			}
		};
		
		this.btnActualizar();
		data_maestro=[['Solicitante',maestro.desc_empleado],
	                 ['Departamento',maestro.desc_depto]];		
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		//Atributos[1].defecto=maestro.id_caja;

		paramFunciones.btnEliminar.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.Save.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.ConfirmSave.parametros='&m_id_avance='+maestro.id_avance;
		cmb_solicitud.filterValues[0]=maestro.id_empleado;
		cmb_solicitud.modificado=true;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	cmb_solicitud=getComponente('id_solicitud')
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_avance_solicitud.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_avance:maestro.id_avance
		}
	});
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_avance_solicitud.getLayout().addListener('layout',this.onResize);
	layout_avance_solicitud.getVentana(idContenedor).on('resize',function(){layout_avance_solicitud.getLayout().layout()})
}