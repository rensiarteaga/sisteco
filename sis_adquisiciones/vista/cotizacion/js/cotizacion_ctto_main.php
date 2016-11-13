<?php
/**
 * Nombre:		  	    descuento_bono_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Mercedes Zambrana Meneses
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
var maestro={id_cotizacion:<?php echo $id_cotizacion;?>,id_persona:'<?php echo $m_id_persona;?>',codigo_empleado:'<?php echo $m_codigo_empleado;?>',desc_persona:'<?php echo $m_desc_persona;?>',email1:'<?php echo $m_email1;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_cotizacion_ctto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

_CP.setPagina(elemento);


}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_descuento_bono.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		11-08-2010
 */
function pagina_cotizacion_ctto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cotizacion_ctto/ActionListarCotizacionCtto.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_cotizacion_ctto',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_cotizacion_ctto','id_cotizacion',
		'antecedentes',
		'controversias',
		'doc_integrantes',
		{name: 'fecha_ctto',type:'date',dateFormat:'Y-m-d'},
		'garantias',
		'legislacion',
		'multas',
		'nro_contrato',
		'obligaciones',
		
		'controversias',
		'partes',
		'usuario_reg',
		'vigencia',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_cotizacion:maestro.id_cotizacion
		}
	});
	// DEFINICIï¿½N DATOS DEL MAESTRO
    var dataMaestro=[['Id Cotizacion',maestro.id_cotizacion]
   // ,['Funcionario',maestro.desc_persona],['Email',maestro.email1]
    ];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	
	
	vectorAtributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_cotizacion_ctto',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cotizacion_ctto'
		};


	vectorAtributos[1]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_cotizacion',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				defecto:maestro.id_cotizacion,
				filtro_0:false,
				save_as:'id_cotizacion'
			};
		
		



		// txt num_cotizacion
	vectorAtributos[2]={//==> SI
			validacion:{
				name:'antecedentes',
				fieldLabel:'Antecedentes',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'90%',
				disabled:false,
				grid_indice:2
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'COT.antecedentes',
			save_as:'antecedentes',
			
		};



	vectorAtributos[3]={//==> SI
				validacion:{
					name:'controversias',
					fieldLabel:'controversias',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.controversias',
				save_as:'controversias',
				
			};


		
	vectorAtributos[4]={//==> SI
				validacion:{
					name:'doc_integrantes',
					fieldLabel:'doc_integrantes',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.doc_integrantes',
				save_as:'doc_integrantes',
				
			};


		
	vectorAtributos[5]={//==> SI
				validacion:{
					name:'garantias',
					fieldLabel:'garantias',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.garantias',
				save_as:'garantias',
				
			};

	
	vectorAtributos[6]={//==> SI
				validacion:{
					name:'legislacion',
					fieldLabel:'legislacion',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.legislacion',
				save_as:'legislacion',
				
			};

	vectorAtributos[7]={//==> SI
				validacion:{
					name:'multas',
					fieldLabel:'multas',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.multas',
				save_as:'multas',
				
			};

		
	vectorAtributos[8]={//==> SI
				validacion:{
					name:'obligaciones',
					fieldLabel:'obligaciones',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.obligaciones',
				save_as:'obligaciones',
				
			};

	vectorAtributos[9]={//==> SI
				validacion:{
					name:'partes',
					fieldLabel:'partes',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.partes',
				save_as:'partes',
				
			};


	vectorAtributos[10]={//==> SI
				validacion:{
					name:'vigencia',
					fieldLabel:'vigencia',
					allowBlank:true,
					maxLength:300,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:false,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:'90%',
					disabled:false,
					grid_indice:2
				},
				tipo: 'TextArea',
				form: true,
				filtro_0:true,
				filterColValue:'COT.vigencia',
				save_as:'vigencia',
				
			};	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro OC(Maestro)',
		titulo_detalle:'Contrato(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_cotizacion_ctto=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cotizacion_ctto.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_cotizacion_ctto,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIï¿½N DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	Save:{url:direccion+'../../../control/cotizacion_ctto/ActionGuardarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	ConfirmSave:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Bono/Descuento'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_cotizacion=datos.id_cotizacion;
		console.log(maestro.id_cotizacion+'--');
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id cotizacion',maestro.id_cotizacion]

		//,['Funcionario',maestro.desc_persona],['Email',maestro.email1]

		]);
		vectorAtributos[1].defecto=maestro.id_cotizacion;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	   Save:{url:direccion+'../../../control/cotizacion_ctto/ActionGuardarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	  ConfirmSave:{url:direccion+'../../../control/cotizacion_ctto/ActionEliminarCotizacionCtto.php',parametros:'&id_cotizacion='+maestro.id_cotizacion},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Contrato'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				id_cotizacion:maestro.id_cotizacion
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		
		
	
		
	}
	this.btnNew=function(){
		
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			
			
			
			ClaseMadre_btnEdit();
		}else{
			alert("Antes debe seleccionar un item");
		}
	
	};
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){
		return layout_cotizacion_ctto.getLayout()
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
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cotizacion_ctto.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}