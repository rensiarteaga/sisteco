<?php 
/**
 * Nombre:		  	    tipo_unidad_constructiva_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-07 15:46:18
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
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:fa};
var maestro={id_planilla:<?php 
    if($id_planilla) {echo $id_planilla;} 
    else {echo '0';}
   ?>,
   id_ppto:<?php 
     if($id_presupuesto) 
        {echo $id_presupuesto;} 
     else {echo '0';} 
   ?>};


var elemento={pagina:new pagina_columna_partida_ejecucion_arb(idContenedor,direccion,paramConfig,idContenedorPadre,maestro),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function pagina_columna_partida_ejecucion_arb(idContenedor,direccion,paramConfig,idContenedorPadre,maestro){
	var Atributos=[];
	var layout_columna_partida_ejecucion_arb;
	var cmpNombreUnidad,cmpNombreCargo,cmpCentro;
	var cmpCargoIndividual,cmpDescripcion,cmpIdNivel;
	var cmpEstadoReg,cmpObservaciones,cmpRelacion;
	var cmpIdEstructuraOrganizacional,cmpIdUnidadOrganizacional;
	var Dialog;
	var copiados;
	var ds_nivel=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/nivel_organizacional/ActionListarNivelOrganizacional.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_nivel_organizacional',totalRecords:'TotalCount'},['id_nivel_organizacional','nombre_nivel','numero_nivel'])
	});
	var resultTplNivel=new Ext.Template('<div class="search-item">','<b><i>{nombre_nivel}</i></b>','<br><FONT COLOR="#B5A642"><b>Nivel: </b>{numero_nivel}</FONT>','</div>');
	Atributos[0]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Codigo',
				name: 'codigo_columna',
				inputType:'hidden',
				grid_visible:true, 
				
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
		
		Atributos[1]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Nombre',
				
				name: 'nombre_columna',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.nombre_columna'
			
		};
		
		
		
		Atributos[2]={
			validacion:{
				labelSeparator:'',
				name: 'id_ppto',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
		Atributos[3]={
			validacion:{
				labelSeparator:'',
				name: 'importe',
				
				fieldLabel:'Importe',
				align:'right',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'NumberField',
			filtro_0:false
			
		};
		
		
		Atributos[4]={
			validacion:{
				labelSeparator:'',
				name: 'id_planilla',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
			
		};
		
		
			Atributos[5]={
			validacion:{
				labelSeparator:'',
				name: 'cuenta',
				fieldLabel:'Cuenta Pasivo',
				inputType:'hidden',
				grid_visible:true, 
				width_grid:220,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.cuenta'
			
		};
		
		
		Atributos[6]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Auxiliar Pasivo',
				name: 'auxiliar',
				inputType:'hidden',
				grid_visible:true, 
				width_grid:170,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.auxiliar'
		};
		
		
		Atributos[7]={
			validacion:{
				labelSeparator:'',
				name: 'partida',
				width_grid:190,
				
				fieldLabel:'Partida Presupuestaria',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'vcpe.partida'
		};

		
		
		Atributos[8]={
			validacion:{
				labelSeparator:'',
				name: 'tiene_ppto',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
	
//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo');
	var DatosDefecto={
		empresa:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etucr.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		otro:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_otro.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		}
	}
	var config={titulo:'Unidad Organizacional'};
	layout_columna_partida_ejecucion_arb=new DocsLayoutArb(idContenedor);
	layout_columna_partida_ejecucion_arb.init(config);
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_columna_partida_ejecucion_arb,idContenedor,DatosNodo,DatosDefecto);
	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEliminar=this.btnEliminar;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var btnActualizar=this.btnActualizar;
	var setValuesBasicos=this.setValuesBasicos;
	var getDialog=this.getDialog;
	var getFormulario=this.getFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var onBeforeMove=this.onBeforeMove;
	var guardarSuccess=this.guardarSuccess;
	// parametros las funciones//
	var paramFunciones={
		Basicas:{url:direccion+'../../../../sis_kardex_personal/control/columna_partida_ejecucion/ActionGuardarUnidadOrganizacionalArb.php'},
		Formulario:{height:415,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Unidad Organizacional'},
		Listar:{url:direccion+'../../../../sis_kardex_personal/control/columna_partida_ejecucion/ActionListarColParEjeArb.php',raiz:'empresa',baseParams:{},clearOnLoad:true,enableDD:true}
	};
// parametros del menu //

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	
	
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	function iniciarEventos(){
		
		var treLoader=getLoader();
		var trePanel=getTreePanel();
		Dialog=getDialog();
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		
	}
	
	this.reload=function(m){
		//Verifica el tipo de reload
		
		getLoader().baseParams={id_planilla:m.id_planilla,id_ppto:m.id_presupuesto,
		id_planilla_ppto:m.id_planilla_presupuesto, momento:m.momento, verificar:'no'};
		getTreeRaiz().reload();
		//this.btnActualizar();

		verif_ppto.on('select',function (combo, record, index){verificacion=verif_ppto.getValue();
		
		
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando...</div>",
				width:150,
				height:200,
				closable:true
			});
			
			
			getLoader().baseParams={id_planilla:m.id_planilla,id_ppto:m.id_presupuesto,
			id_planilla_ppto:m.id_planilla_presupuesto, momento:m.momento, verificar:verificacion};
			
			getTreeRaiz().reload();
			Ext.MessageBox.hide(); //alert(resp.argument.nodo.parentNode);
			//this.btnActualizar();
			
  		});
		
	};
	
	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}

	function terSuccess(resp){ 
		var regreso=Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			Ext.MessageBox.hide(); //alert(resp.argument.nodo.parentNode);
			resp.argument.nodo.parentNode.reload();
			
			resp.argument.nodo.reload();
			if(regreso.id_padre!=undefined && regreso.id_padre!=null){
				regreso.id_padre.reload();
			}
		}
	}
	
   this.getLayout=function(){
		return layout_columna_partida_ejecucion_arb.getLayout()
	};	
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	
	

var verif_ppto =new Ext.form.ComboBox({
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['no','Sin Verificar'],['si','Verificar Presupuesto']]}),
			
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Verificación de Presupuesto...',
			selectOnFocus:true,
			width:120,
			valueField:'ID',
			displayField:'valor',
			defecto:'no',
			value:'no'
			
		});
 
	this.AdicionarBotonCombo(verif_ppto,'ppto');
	
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	
	iniciarEventos()
}