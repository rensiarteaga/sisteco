<?php
/**
 * Nombre:		  	    siet_cbte_nuevo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:42
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	     id_siet_declara:<?php echo $id_siet_declara;?>,
	     id_gestion:<?php echo $id_gestion;?>,
         tipo_declara:'<?php echo $tipo_declara;?>'};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_siet_cbte_noingresan(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_siet_cbte_noingresan.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_siet_cbte_noingresan(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();  
	var componentes=new Array();
	var sw=0;
    var monedas_for=new Ext.form.MonedaField(
  			{
  				name:'mes_01',
  				fieldLabel:'Enero',
  				allowBlank:false,
  				align:'right',
  				maxLength:50,
  				minLength:0,
  				selectOnFocus:true,
  				allowDecimals:true,
  				decimalPrecision:2,
  				allowNegative:false,
  				minValue:0}
  				);
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarComprobanteFal.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_cbte',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cbte',
		'id_siet_cbte',
		'nro_cbte',
		'concepto_cbte',
		'importe',
		'nro_cuenta_banco',
		'fecha_cbte',
		'sw_ingresa_declaracion',
		'nro_doc'
		
		
	]),remoteSort:true});
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
		    m_id_siet_declara:maestro.id_siet_declara
		}
	});
	
	
	//FUNCIONES RENDER
	 function renderSeparadorDeMil(value,cell,record,row,colum,store)
		{
			return monedas_for.formatMoneda(value)
		}
		
	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Cbte',maestro.id_siet_cbte]]}),cm:cmMaestro});
	gridMaestro.render();
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_siet_cbte',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_siet_cbte'
		};
	vectorAtributos[1]={
			validacion:{
				labelSeparator:'',
				name: 'id_siet_declara',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:maestro.id_siet_declara,
			save_as:'id_siet_declara'
		};
	 vectorAtributos[2]= {
				validacion:{
					name:'id_siet_cbte',
					fieldLabel:'ID SIET CBTE',
					desc: 'id_siet_cbte',
					displayField: 'id_siet_cbte',
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:70,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'id_siet_cbte',
				save_as:'id_siet_cbte'
			};
	
	  vectorAtributos[3]= {
			validacion:{
				name:'id_cbte',
				fieldLabel:'ID Cbte',
				desc: 'id_cbte',
				displayField: 'id_cbte',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:false,
				width_grid:50,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sc.id_cbte',
			save_as:'id_cbte'
		};
	  vectorAtributos[4]= {
				validacion:{
					name:'fecha_cbte',
					fieldLabel:'Fecha Comprobante',
					desc: 'fecha_cbte',
					displayField: 'fecha_cbte',
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:false,
					width_grid:50,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'sc.fecha_cbte',
				save_as:'fecha_cbte'
			};
		vectorAtributos[5]= {
				validacion:{
					name:'nro_cbte',
					fieldLabel:'Nro Cbte',
					desc: 'nro_cbte',
					displayField: 'nro_cbte',
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:false,
					width_grid:50,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'sc.nro_cbte',
				save_as:'nro_cbte'
			};
			vectorAtributos[6]= {
				validacion:{
					name:'concepto_cbte',
					fieldLabel:'Comprobante Concepto',
					desc: 'concepto_cbte',
					displayField: 'concepto_cbte',
					filterCol:'cbte.concepto_cbte',
					
					allowBlank:false,
					maxLength:500,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:false,
					width_grid:450,
							
				},
				form:true,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'sc.concepto_cbte',
				save_as:'concepto_cbte'
			};
		vectorAtributos[7]= {
				validacion:{
					name:'nro_cuenta_banco',
					fieldLabel:'Nro. Cuenta Banco',
					desc: 'nro_cuenta_banco',
					displayField: 'nro_cuenta_banco',
					
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:100,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'cueban.nro_cuenta_banco',
				save_as:'nro_cuenta_banco'
				
			};
		vectorAtributos[8]= {
				validacion:{
					name:'nro_doc',
					fieldLabel:'Nro. Deposito/Cheque',
					desc: 'nro_doc',
					displayField: 'nro_doc',
					
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:100,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'che.nro_deposito#che.nro_cheque',
				save_as:'nro_doc'
				
			};
		vectorAtributos[9]= {
			validacion:{
				name:'importe',
				fieldLabel:'Importe',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :2,//para numeros float
				allowNegative: true,
				//minValue:0,
				vtype:'texto',
				grid_visible:true,
				align:'right',
				renderer: renderSeparadorDeMil,
				grid_editable:false,
				width_grid:100,
				width:'80%'
			},
			form:true,	
			tipo: 'NumberField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'importe',
			save_as:'importe'
			
		};

	vectorAtributos[10]= {
			validacion:{
				name:'sw_ingresa_declaracion',
				fieldLabel:'Ing. Cbte',
				desc: 'sw_ingresa_declaracion',
				displayField: 'sw_ingresa_declaracion',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				width:'55%',
                typeAhead:true,
				loadMask:true,
     				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['si-no','si-no'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				disabled:false,
				width_grid:70,
						
			},
			form:false,	
			tipo: 'ComboBox',
			filtro_0:true,
			filterColValue:'sw_ingresa_declaracion',
			save_as:'sw_ingresa_declaracion',
			defecto:'si'
		};
		
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={
		titulo_maestro:'Periodo Declaración (Maestro)',
		titulo_detalle:'No Ingresan(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_siet_cbte_noingresan = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_siet_cbte_noingresan.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_siet_cbte_noingresan,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit; 
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},*/
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php?id_siet_declara='+maestro.id_siet_declara},
			/*Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
			ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},*/
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de nuevos',
		
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}]
		}
	};
	function btn_repcbte(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_comprobante='+SelectionsRecord.data.id_cbte;
			data=data+'&m_vista=plan_pagos';
			
			window.open(direccion+'../../../../sis_contabilidad/control/comprobante/reporte/ActionPDFComprobante.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_siet_declara=datos.m_id_siet_declara;
	
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,    
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara
			}
		});
		//alert (datos.m_id_siet_declara);
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Cbte',maestro.id_siet_cbte]]);
		vectorAtributos[1].defecto=maestro.id_siet_declara;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php?id_siet_declara='+maestro.id_siet_declara},
				/*Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
				ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},*/
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de nuevos',
				
				grupos:[{
							tituloGrupo:'Datos',
							columna:0,
							id_grupo:0
						}]
				
				}};
		this.InitFunciones(paramFunciones)
	};


	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
		//tipo = ClaseMadre_getComponente('tipo');	
		//CM_ocultarGrupo('Fondos en Avance');
	    for(i=0;i<vectorAtributos.length;i++)
		{
			
		  componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
			
   	}



	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_siet_cbte_noingresan.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif',' ',btn_repcbte,true,'imprimir','');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_siet_cbte_noingresan.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

	
	
}