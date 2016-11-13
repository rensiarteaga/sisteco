<?php 
/**
 * Nombre:		  	    supervisor_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 21:00:48
 *
 */
session_start();
?>
//<script>
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={TamanoPagina:20,
				     TiempoEspera:10000,
				     CantFiltros:1,
				     FiltroEstructura:false,
				     FiltroAvanzado:fa
	};
	var elemento={pagina:new pagina_supervisor(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_supervisor_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Anacleto Rojas Veizaga
 * Fecha creación:		2008-10-07 15:53:20
 */
function pagina_supervisor(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var layout_supervisor;
	var txt_fecha_reg;
	var combo_empleado;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supervisor/ActionListarSupervisor.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_supervisor',
			totalRecords:'TotalCount'
		},[
		'id_supervisor',
		'id_persona',
		'nombre_superv',
		'doc_id',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
    
//	/*var ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/responsable_almacen/ActionListarEmpleadoAlmacen.php'}),
//		    reader:new Ext.data.XmlReader({
//		    record:'ROWS',
//		    id:'id_empleado',
//		    totalRecords:'TotalCount'
//		    },['id_empleado','id_persona','desc_persona','nombre_tipo_documento','doc_id','email1'])
//	});*/
	
	var ds_empleado=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado',
			totalRecords:'TotalCount'
			},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
	
	//FUNCIONES RENDER
			
			//function render_id_empleado(value,p,record){return String.format('{0}',record.data['nombre_completo'])}
			function render_id_empleado(value,p,record){return String.format('{0}',record.data['nombre_superv'])}
			//var resultTplEmpleado=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>{nombre_tipo_documento}: </b>{doc_id}</FONT>','<br><FONT COLOR="#B5A642"><b>Email: </b>{email1}</FONT>','</div>');
			var resultTplEmpleado=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo_empleado}</FONT>','<br><FONT COLOR="#B5A642"><b>{nombre_tipo_documento}: </b>{doc_id}</FONT>','<br><FONT COLOR="#B5A642"><b>Email: </b>{email1}</FONT>','</div>');
    // hidden id_responsable_almacen
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_supervisor',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_supervisor'
	};
	
	// txt id_persona
	vectorAtributos[1]={
			validacion:{
			name:'id_persona',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Supervisor...',
			desc:'nombre_superv',
			store:ds_empleado,
			valueField:'id_persona',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplEmpleado,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			width:'85%',
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:215
			},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PER.nombre#PER.apellido_paterno#PER.apellido_materno',
		defecto: '',
		save_as:'txt_id_persona'
	};

	// txt fecha_reg
	vectorAtributos[2]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y',
			minValue:'01/01/1900',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SUPERV.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Supervisor',grid_maestro:'grid-'+idContenedor};
	layout_supervisor=new DocsLayoutMaestro(idContenedor);
	layout_supervisor.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_supervisor,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},
				  nuevo:{crear:true,separador:true},
				  editar:{crear:true,separador:false},
				  eliminar:{crear:true,separador:false},
				  actualizar:{crear:true,separador:false}};
    //----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/supervisor/ActionEliminarSupervisor.php'},
		Save:{url:direccion+'../../../control/supervisor/ActionGuardarSupervisor.php'},
		ConfirmSave:{url:direccion+'../../../control/supervisor/ActionGuardarSupervisor.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
			width:450,
			height:280,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Supervisor'
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		combo_empleado=ClaseMadre_getComponente('id_persona');
		//combo_almacen=ClaseMadre_getComponente('id_almacen');
		 /*var onAlmacenSelect=function(e){
		   var alma=combo_almacen.getValue();
		   data_alm='id_almacen='+alma;
		   if(alma != 0){
		   		actualizar_ds_combos();
		   		combo_empleado.enable();
		   		combo_empleado.setValue('');
		   		combo_empleado.modificado=true
		   }else{
		      	actualizar_ds_combos();
		   		combo_empleado.disable();
		      }
			};
		  combo_almacen.on('change',onAlmacenSelect);
		  combo_almacen.on('select',onAlmacenSelect)*/
	}
	
	/*function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_alm)); 	
		Ext.apply(combo_empleado.store.baseParams,datos)		
	}*/
	this.getLayout=function(){
		return layout_supervisor.getLayout();
	};
   this.btnNew=function(){
  	CM_ocultarComponente(txt_fecha_reg);
  	combo_empleado.enable();
	ClaseMadre_btnNew()
	};	
	 this.btnEdit=function(){
	 	CM_ocultarComponente(txt_fecha_reg);
	 	combo_empleado.disable();
		ClaseMadre_btnEdit()
	};	
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_supervisor.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}