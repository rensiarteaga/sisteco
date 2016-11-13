<?php
/**
 * Nombre:		  	   tarjeta_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		12-08-2010
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
	}?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_empleado:<?php echo $m_id_empleado;?>,desc_persona:'<?php echo $m_desc_persona;?>',email1:'<?php echo $m_email1;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tarjeta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tarjeta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		11-08-2010
 */
function pagina_tarjeta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tarjeta/ActionListarTarjeta.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tarjeta',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_tarjeta',
		'estado_codigo',
		'id_empleado',
		'nombre_completo',
		'nombre_usuario'
		]),remoteSort:true});
	//carga datos XML
	// DEFINICIÓN DATOS DEL MAESTRO
    var dataMaestro=[['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	
	
		function render_estado_codigo(value){
		if(value=='1'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	      }
	
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tarjeta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		save_as:'hidden_id_tarjeta',
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'hidden_id_empleado'
	};
	

vectorAtributos[2]={
		validacion:{
			labelSeparator:'',
			name:'nombre_usuario',
			fieldLabel:'Usuario',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TARJET.nombre_usuario',	
		save_as:'txt_nombre_usuario'
	};
	
		vectorAtributos[3]= {
		validacion: {
			name:'estado_codigo',
			emptyText:'Estado...',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Activo'],['2','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_codigo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		save_as:'txt_estado_codigo'
		};
			
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Habilitar Funcionario para Marcar (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	var layout_tarjeta=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tarjeta.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tarjeta,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tarjeta/ActionEliminarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/tarjeta/ActionGuardarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/tarjeta/ActionGuardarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Porcentaje Pago'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_empleado=datos.m_id_empleado;
		maestro.desc_persona=datos.m_desc_persona;
		maestro.email1=datos.m_email1;
	
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]]);
		vectorAtributos[1].defecto=maestro.id_empleado;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/tarjeta/ActionEliminarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/tarjeta/ActionGuardarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/tarjeta/ActionGuardarTarjeta.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Porcentaje Pago'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		  
		
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tarjeta.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_empleado:maestro.id_empleado
		}
	});
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tarjeta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}