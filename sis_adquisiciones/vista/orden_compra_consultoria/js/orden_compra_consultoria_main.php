<?php 
/**
 * Nombre:		  	    orden_compra_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 16:28:12
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_orden_compra_consultoria(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_orden_compra_consultoria.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-05-28 17:32:05
 */
function pagina_orden_compra_consultoria(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var num_cotizaciones=0;
	var on=0;
	var pagina="";
	var bloquear='no';
	var componentes=new Array;
	var fin_rev=0; //bandera para finalizar o revertir pagos, para finalizar fin_rev=1, para revertir fin_rev=2
	var tipoP='consultores';
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion/ActionListarConsultores.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cotizacion',
		'desc_proveedor',
		'num_os',
		'codigo_proceso',
		'observaciones',
		'num_sol',
		'prox_pago',
		{name: 'fecha_prox_pago',type:'date',dateFormat:'Y-m-d'},
		'tipo_plantilla','factura_total','num_factura','fecha_factura'
		]),remoteSort:true});

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cotizacion
	//en la posiciï¿½n 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_cotizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cotizacion'
	};
	
//	Atributos[1]={//==> SI
//		validacion:{
//			name:'check_pagar',
//			fieldLabel:'Pagar',
//			allowBlank:true,
//			maxLength:50,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:true,
//			grid_editable:true,
//			width_grid:100,
//			width:'90%',
//			disabled:false,
//			grid_indice:3,
//			renderer:render_incluido
//		},
//		tipo: 'Checkbox',
//		defecto:'false',
//		form:false,
//		filtro_0:false,
//		save_as:'check_pagar'
//		
//	};
	
	
	Atributos[1]={//==> SI
		validacion:{
			name:'desc_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'prov.desc_proveedor',
		save_as:'id_proveedor'
		
	};
	
	
	
	Atributos[2]={//==> SI
		validacion:{
			name:'num_os',
			fieldLabel:'Nº OS',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'d.codigo_depto#p.periodo#c.num_orden_compra',
		save_as:'num_os'
		
	};
	
	
	
	Atributos[3]={//==> SI
		validacion:{
			name:'codigo_proceso',
			fieldLabel:'Proceso',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'p.codigo_proceso',
		save_as:'codigo_proceso'
		
	};
	
	Atributos[4]={//==> SI
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
			width_grid:100,
			width:'90%',
			disabled:false,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'p.observaciones',
		save_as:'observaciones'
		
	};
	
	
	Atributos[5]={//==> SI
		validacion:{
			name:'num_sol',
			fieldLabel:'Nº Solicitudes',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'num_sol',
		save_as:'num_sol'
		
	};
	
	
	Atributos[6]={//==> SI
		validacion:{
			name:'prox_pago',
			fieldLabel:'Nº Pago',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'p.nro_cuota',
		save_as:'prox_pago'
		
	};
	
	Atributos[7]= {//39
		validacion:{
			name:'fecha_prox_pago',
			fieldLabel:'Fecha de Pago',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:97,
			disabled:false,
			grid_indice:16,
			width:163
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'p.fecha_pago',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_prox_pago'
		
	};
	
	Atributos[8]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'tipo_plantilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'tipo_documento'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
//	var render_incluido=function (value, p, record){
//		
//				var  inc;
//				if(record.data['check_pagar']){
//					inc='si';
//				}else
//				{
//					inc='no'
//					record.set('check_pagar','no');
//				}
//				return inc
//			};
			
	 //---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Orden de Compra',grid_maestro:'grid-'+idContenedor, urlHijo:'../../../sis_adquisiciones/vista/plan_pago/plan_pago.php'};
	
	layout_orden_compra_consultoria= new DocsLayoutMaestroDeatalle(idContenedor);
	layout_orden_compra_consultoria.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_orden_compra_consultoria,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnDelete=this.btnDelete;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_dialog= this.getDialog;
	var CM_saveSuccess=this.saveSuccess;
	var enableSelect=this.EnableSelect;
	var getColumnModel=this.getColumnModel;
	
	
//DEFINICIóN DE LA BARRA DE MENú
	var paramMenu={
	guardar:{crear:true,separador:false},
	actualizar:{crear:true,separador:false}};
//DEFINICIóN DE FUNCIONES
	
	var paramFunciones={
	Save:{url:direccion+'../../../control/cotizacion/ActionGuardarPagosConsultoria.php'},
	ConfirmSave:{url:direccion+'../../../control/cotizacion/ActionGuardarPagosConsultoria.php'},
	
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:680,minWidth:450,minHeight:230,	closable:true,titulo:'Orden compra',columnas:['47%','47%'],
	grupos:[{
			tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
		}
	]}};
	
	//-------------- Sobrecarga de funciones --------------------//
//	this.reload=function(params){
//		
//		var datos=Ext.urlDecode(decodeURIComponent(params));
//		maestro.id_proceso_compra=datos.m_id_proceso_compra;
//		maestro.codigo_procedo=datos.m_codigo_proceso;
//		maestro.num_proceso=datos.m_num_proceso;
//		maestro.tipo_adq=datos.m_tipo_adq;
//		maestro.id_tipo_categoria_adq=datos.m_id_tipo_categoria_adq;
//		maestro.lugar_entrega=datos.m_lugar_entrega;
//		maestro.id_moneda=datos.m_id_moneda;
//		maestro.desc_moneda=datos.m_desc_moneda;
//		maestro.num_cotizacion=datos.m_num_cotizacion;
//		maestro.factura_total=datos.m_factura_total;
//		maestro.avance=datos.m_avance;
//		
//
//		ds.lastOptions={
//			params:{
//				start:0,
//				limit: paramConfig.TamanoPagina,
//				CantFiltros:paramConfig.CantFiltros,
//				m_id_proceso_compra:maestro.id_proceso_compra,
//				adjudicacion:'si'
//			}
//		};
//		
//		_CP.getPagina(layout_orden_compra_consultoria.getIdContentHijo()).pagina.limpiarStore()
//		this.btnActualizar();
//		
//		iniciarEventosFormularios();
//
//		
//		Atributos[1].defecto=maestro.id_proceso_compra;		
//		
//		paramFunciones.Save.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra
//		this.iniciarEventosFormularios;
//		this.InitFunciones(paramFunciones);
//		
//	};
//	
//	

		/*	var mycm =this.getColumnModel();
			mycm.setRenderer(this.getColumnNum('incluido'),render_incluido);			
		*/



	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name);
		}
		
		CM_ocultarGrupo('Oculto');
		getComponente('observaciones').setValue('');
	 	//cmp_incluido=getComponente('check_pagar');
		getSelectionModel().on('rowdeselect',function(){
						if(_CP.getPagina(layout_orden_compra_consultoria.getIdContentHijo()).pagina.limpiarStore()){
							if(bloquear=='si'){
							   _CP.getPagina(layout_orden_compra_consultoria.getIdContentHijo()).pagina.bloquearMenu();
							}else{
							   _CP.getPagina(layout_orden_compra_consultoria.getIdContentHijo()).pagina.desbloquearMenu();
							}
						}
					})

			//getColumnModel().setRenderer(0,render_incluido);
			//cmp_incluido.on('check',onCheck)
					
	}
	
	
//	function onCheck(x,check){
//			var record=getSelectionModel().getSelected();
//			value_check=record.data.check_pagar;
//			
//			if(check){
//				
//			}
//			else{
//				
//				
////				/record.commit;
//			}
//		}
	
	this.EnableSelect=function(x,z,y){
		_CP.getPagina(layout_orden_compra_consultoria.getIdContentHijo()).pagina.reload(y.data);
		enable(x,z,y);
	}
	

	
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_orden_compra_consultoria.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	    
	 	
		
		var CM_getBoton=this.getBoton;
	
		function  enable(sel,row,selected){
		    var record=selected.data; 
			if(selected&&record!=-1){
				
				}
			enableSelect(sel,row,selected);
		}
	
	
        
        
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			en_planilla:'no'
		}
	});
	layout_orden_compra_consultoria.getLayout().addListener('layout',this.onResize);
	
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}