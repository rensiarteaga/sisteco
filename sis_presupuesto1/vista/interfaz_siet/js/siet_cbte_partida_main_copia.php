<?php
/**
 * Nombre:		  	    siet_cbte_partida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				A.V.Q
 * Fecha creación:		01/11/2015
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
var maestro={id_siet_cbte:<?php echo $id_siet_cbte;?>,
		     id_siet_declara:<?php echo $id_siet_declara;?>,
		     id_parametro:<?php echo $id_parametro;?>};
//
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_siet_cbte_partida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_solicitud_compra_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 */
function pagina_siet_cbte_partida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	var gestion;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarSietCbtePartida.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_cbte_partida',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_siet_cbte_partida',
		'id_siet_cbte',
		'id_partida',
		'importe'
	]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_siet_cbte:maestro.id_siet_cbte,
			m_id_siet_declara:maestro.id_siet_declara
			
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//DATA STORE COMBOS

//  
    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?sw_vista_reporte=rep_ejecucion_partida&id_tipo_pres=2&id_parametro='+maestro.id_parametro}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords:'TotalCount'},['id_partida','codigo_partida','nombre_partida'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_partida',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});
	

	//FUNCIONES RENDER
	function render_id_partida(value, p, record){return String.format('{0}', record.data['id_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{codigo_partida}</i></b>','<br><FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_siet_cbte_partida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_siet_cbte_partida'
		
	};
	Atributos[1]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_siet_cbte',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_siet_cbte',
			defecto:maestro.id_siet_cbte
			
		};
	
	Atributos[2]={
		validacion:{
			fieldLabel:'Partida',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Partida...',
			name:'id_partida',
			desc:'id_partida',
			store:ds_partida,
			valueField:'id_partida',
			displayField:'id_partida',
			filterCol:'PARTID.nombre_partida#PARTID.codigo_partida',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_id_partida,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:200,
			grid_indice:3
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida#PARTID.codigo_partida'
	
	};
	
// txt precio_referencial_estimado
	Atributos[3]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe Ejecutado',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:6,//para numeros float
			allowNegative:false,
			minValue:0.1,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:95,
			align:'right',
			width:'40%',
			disable:false,
			grid_indice:6
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'importe',
		save_as:'importe'
		
	};
		//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
    
	function formatBoolean(value){
        if(value=="true"){
        	return "si";
        }else{
        	return "no";
        }
    };
     tituloM='Detalle de Partidas';
	//---------- INICIAMOS LAYOUT DETALLE
   
     var config = {
 			titulo_maestro:'Partidas',
 			grid_maestro:'grid-'+idContenedor
 		};

	var layout_siet_cbte_partida = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_siet_cbte_partida.init(config);
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_siet_cbte_partida,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
	Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
	ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte'+maestro.id_siet_cbte},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Partidas',
	
	grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:1
			}]
	
	}};
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_siet_cbte=datos.m_id_siet_cbte;
		maestro.id_siet_declara=datos.m_id_siet_declara;
		
		
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_cbte:maestro.id_siet_cbte,
				m_id_siet_declara:maestro.id_siet_declara
				
			}
		};
		
		iniciarEventosFormularios();

		Atributos[1].defecto=maestro.id_siet_cbte;
		
		/*
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.ConfirmSave.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		*/this.InitFunciones(paramFunciones)
	};
	
	

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		
	    
	}

		

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_siet_cbte_partida.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_siet_cbte_partida.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}