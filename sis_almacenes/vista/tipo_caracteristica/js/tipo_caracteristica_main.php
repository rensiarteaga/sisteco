<?php 
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
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaTipoCaracteristica(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function PaginaTipoCaracteristica(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_tipo_caracteristica,h_txt_fecha_reg;
	var elementos=new Array();
    var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_caracteristica/ActionListarTipoCaracteristica.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_caracteristica',
			totalRecords:'TotalCount'
		},[
		'id_tipo_caracteristica',
		'codigo',
		'descripcion',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),
		remoteSort:true});
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		// hidden id_tipo_caracteristica
		vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name:'id_tipo_caracteristica',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_tipo_caracteristica'
		};
		// txt codigo
		vectorAtributos[1]={
			validacion:{
				name:'codigo',
				fieldLabel:'Código',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'',
				grid_visible:true,
				grid_editable:false,
				renderer:mayus,
				width_grid:100
			},
			tipo:'TextField',
			filtro_0:true,
			save_as:'txt_codigo'
		};
		// txt descripcion
		vectorAtributos[2]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'',
				grid_visible:true,
				grid_editable:true,
				grow:true,
				width_grid:250
			},
			tipo:'TextArea',
			filtro_0:true,
			save_as:'txt_descripcion'
		};
		// txt fecha_reg
		vectorAtributos[3]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:false,
				format:'d/m/Y',
				minValue:'01/01/1900',
				grid_visible:true,
				grid_editable:false,
				renderer:formatDate,
				width_grid:100,
				disabled:true
			},
			tipo:'DateField',
			filtro_0:true,
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg'
		};
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
		function mayus (value){return value ? value.toUpperCase():''}
 		//////////////////////////////////////////////////////////////
		//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		//////////////////////////////////////////////////////////////
		var config={titulo_maestro:'Tipo Característica',grid_maestro:'grid-'+idContenedor};
		layout_tipo_caracteristica=new DocsLayoutMaestro(idContenedor);
		layout_tipo_caracteristica.init(config);
		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////
		this.pagina=Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_caracteristica,idContenedor);
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
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/tipo_caracteristica/ActionEliminarTipoCaracteristica.php'},
			Save:{url:direccion+'../../../control/tipo_caracteristica/ActionGuardarTipoCaracteristica.php'},
			ConfirmSave:{url:direccion+'../../../control/tipo_caracteristica/ActionGuardarTipoCaracteristica.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:250,minWidth:300,minHeight:200,closable:true,titulo:'Registro de Tipo de Características'}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function iniciarEventosFormularios(){
			h_txt_fecha_reg=ClaseMadre_getComponente('fecha_reg')
		}
		//Obtiene la fecha de la base de datos
		function get_fecha_bd(){
				Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
				method:'GET',
				success:cargar_fecha_bd,
				failure:ClaseMadre_conexionFailure,
				timeout:100000
			})
		}
		function cargar_fecha_bd(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(h_txt_fecha_reg.getValue()==""){
					h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
				}
			}
		}
		function btnCaract(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected(); 
				var data="m_id_tipo_caracteristica="+SelectionsRecord.data.id_tipo_caracteristica;
				data=data+"&m_codigo="+SelectionsRecord.data.codigo;
				data=data+"&m_descripcion="+SelectionsRecord.data.descripcion;
				var paramVentana={Ventana:{width:'80%',height:'70%'}};
				layout_tipo_caracteristica.loadWindows(direccion+'../../caracteristica/caracteristica.php?'+data,"Características ["+SelectionsRecord.data.codigo+"]",paramVentana);
				layout_tipo_caracteristica.getVentana().on('resize',function(){layout_tipo_caracteristica.getLayout().layout()})
		       }
			else{
				Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
			}
		}
	this.btnNew=function(){
		CM_ocultarComponente(h_txt_fecha_reg);
	    get_fecha_bd();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		CM_ocultarComponente(h_txt_fecha_reg);
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_tipo_caracteristica.getLayout()
		};
		//para el manejo de hijos
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
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);
		//para agregar botones
		this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnCaract,true,'caract','Características');
		this.iniciaFormulario();
		iniciarEventosFormularios();
		layout_tipo_caracteristica.getLayout().addListener('layout',this.onResize)
}