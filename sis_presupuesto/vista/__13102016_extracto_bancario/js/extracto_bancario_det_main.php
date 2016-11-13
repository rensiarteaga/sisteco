<?php 
/**
 * Nombre:		  	    extracto_bancario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
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
	var maestro={
	     	id_cuenta_bancaria:<?php echo $id_cuenta_bancaria;?>,id_parametro:'<?php echo $id_parametro;?>',
	    	id_periodo:'<?php echo $id_periodo;?>',nro_cuenta_banco:'<?php echo $nro_cuenta_banco;?>',
	    	periodo_lite:'<?php echo $periodo_lite;?>',gestion:'<?php echo $gestion;?>',};
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_extracto_bancario(idContenedor,direccion,paramConfig,maestro),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_extracto_bancario_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 */
function pagina_extracto_bancario(idContenedor,direccion,paramConfig,maestro)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	
	 var monedas_for=new Ext.form.MonedaField(
	   			{
	   				name:'mes_01',
	   				fieldLabel:'Enero',
	   				allowBlank:false,
	   				align:'right',
	   				maxLength:50,
	   				minLength:-100000000000000,
	   				selectOnFocus:true,
	   				allowDecimals:true,
	   				decimalPrecision:2,
	   				allowNegative:true,
	   				minValue:-100000000000000}
	   				);
	
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/extracto_bancario/ActionListarExtractoBancario.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_extracto_bancario',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_extracto_bancario',
			'id_cuenta_bancaria',
			'fecha_movimiento',
			'agencia',
			'descripcion',
			'nro_documento',
			'monto',
			'tipo_importe',
			'sub_tipo_importe',
			'observaciones',
			'id_siet_cbte',
			'sw_asocia'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			hidden_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
			id_parametro:maestro.id_parametro,
			id_periodo:maestro.id_periodo
		}
	});
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{
		return monedas_for.formatMoneda(value)
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_extracto_bancario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_extracto_bancario'
	};
	vectorAtributos[1]= {
			validacion:{
				labelSeparator:'',
				name: 'id_cuenta_bancaria',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			defecto:maestro.id_cuenta_bancaria,
			tipo: 'Field',
			filtro_0:false,
			save_as:'hidden_id_cuenta_bancaria'
		};
		 
// txt nombre
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_movimiento',
			fieldLabel:'Fecha ',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		form:false,
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'fecha_movimiento',
		save_as:'fecha_movimiento',
		id_grupo:0
	};
	vectorAtributos[3]= {
			validacion:{
				name:'agencia',
				fieldLabel:'Agencia',
				allowBlank:false,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:200
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'agencia',
			save_as:'agencia',
			id_grupo:0
		};
	vectorAtributos[4]= {
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción ',
				allowBlank:false,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:200
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'descripcion',
			save_as:'descripcion',
			id_grupo:0
		};
	vectorAtributos[5]= {
			validacion:{
				name:'nro_documento',
				fieldLabel:'Nro Documento',
				allowBlank:false,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:200
			},
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nro_documento',
			save_as:'nro_documento',
			id_grupo:0
		};
// txt simbolo
	vectorAtributos[6]= {
		validacion:{
			name:'monto',
			fieldLabel:'Monto',
			allowBlank:false,
			maxLength:50,
			minLength:-100000000000000000,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			align:'right',
			allowNegative: true,
			vtype:'texto',
			renderer: renderSeparadorDeMil,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		
		filterColValue:'monto',
		save_as:'monto',
		id_grupo:0
	};
	vectorAtributos[7]= {
			validacion:{
				name:'tipo_importe',
				fieldLabel:'Tipo Importe',
				allowBlank:false,
				maxLength:5,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			form: false,
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'tipo_importe',
			save_as:'tipo_importe',
			id_grupo:0
		};
	vectorAtributos[8]={
			validacion: {
				name:'sub_tipo_importe',
				fieldLabel:'Sub Tipo Importe',
				allowBlank:true,
				emptyText:'Prioridad...',
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
						
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['aportes_capital_tgn','Aportes Capital TGN'],
				                                                            ['arrendamiento','Arrendamiento'],
				                                                            ['credito_externo_bid','Credito Externo BID'],
				                                                            ['credito_externo_caf','Credito Externo CAF'],
				                                                            ['credito_interno_bcb','Credito Interno BCB'],
				                                                            ['dividendos','Dividendos'],
				                                                            ['ingreso_proyecto_eolico_qollpana','Ingreso Proyecto eolico Qollpana'],
				                                                            ['ingreso_proyecto_san_jose','Ingreso Proyecto San Jose'],
                                                                                        ['ingreso_proyecto_san_jose_santivanes','Ingreso Proyecto San Jose - Santivañez '],
 												    ['donacion_danesa','Donación Danesa'],
				                                                            ['traspaso','Traspaso'],
				                                                            ['otros','Otros'],
				                                                            ['','Borrar']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				//renderer: renderPrioridad,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:250,
				minListWidth:100,
				disable:false
			},
			form: false,
			tipo:'ComboBox',
			
			filtro_0:false,
			filterColValue:'sub_tipo_importe',
			save_as:'sub_tipo_importe',
			id_grupo:0 
		};		
	vectorAtributos[9]= {
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			form: false,
			tipo: 'TextField',
			filtro_0:true,   
			filterColValue:'observaciones',
			save_as:'observaciones',
			id_grupo:0
		};
        vectorAtributos[10]= {
			validacion:{
				name:'id_siet_cbte',
				fieldLabel:'ID SIET CBTE',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			form: false,
			tipo: 'TextField',
			filtro_0:true,   
			filterColValue:'EXTBAN.id_siet_cbte',
			save_as:'id_siet_cbte',
			id_grupo:0
		};
        vectorAtributos[11]= {
        		validacion:{
        			labelSeparator:'',
        			name: 'id_periodo',
        			inputType:'hidden',
        			grid_visible:false, 
        			grid_editable:false
        		},
        		defecto:maestro.id_periodo,
        		tipo: 'Field',
        		filtro_0:false,
        		save_as:'id_periodo'
        	};
        vectorAtributos[12]= {
        		validacion:{
        			labelSeparator:'',
        			name: 'id_parametro',
        			inputType:'hidden',
        			grid_visible:false, 
        			grid_editable:false
        		},
        		defecto:maestro.id_parametro,
        		tipo: 'Field',
        		filtro_0:false,
        		save_as:'id_parametro'
        	};
        vectorAtributos[13]= {
    			validacion:{
    				name:'sw_asocia',
    				fieldLabel:'Asociado',
    				allowBlank:true,
    				maxLength:500,
    				minLength:0,
    				selectOnFocus:true,
    				vtype:'texto',
    				grid_visible:true,
    				grid_editable:false,
    				width_grid:100
    			},
    			form: false,
    			tipo: 'TextField',
    			filtro_0:true,   
    			filterColValue:'sw_asocia',
    			save_as:'sw_asocia',
    			id_grupo:0
    		};
        vectorAtributos[14]= {
    			validacion:{
    				name:'id_extracto_bancario',
    				fieldLabel:'Extracto Bancario',
    				allowBlank:true,
    				maxLength:500,
    				minLength:0,
    				selectOnFocus:true,
    				vtype:'texto',
    				grid_visible:true,
    				grid_editable:false,
    				width_grid:100
    			},
    			form: false,
    			tipo: 'TextField',
    			filtro_0:true,   
    			filterColValue:'id_extracto_bancario',
    			save_as:'id_extracto_bancario',
    			id_grupo:0
    		};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'extracto_bancario',
		grid_maestro:'grid-'+idContenedor
	};
	layout_extracto_bancario=new DocsLayoutMaestro(idContenedor);
	layout_extracto_bancario.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_extracto_bancario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_Actualizar=this.btnActualizar();
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/extracto_bancario/ActionEliminarExtractoBancario.php'},
		Save:{url:direccion+'../../../control/extracto_bancario/ActionGuardarExtractoBancarioMod.php'},
		ConfirmSave:{url:direccion+'../../../control/extracto_bancario/ActionGuardarExtractoBancarioMod.php'},
		Formulario:{
			titulo:'extracto_bancario',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'48%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de extracto_bancario',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_cuenta_bancaria=datos.id_cuenta_bancaria;
		maestro.id_parametro=datos.id_parametro;
		maestro.id_periodo=datos.id_periodo;
		maestro.nro_cuenta_banco=datos.nro_cuenta_banco;
		//maestro.id_parametro=datos.id_parametro;
		maestro.gestion=datos.gestion;
		maestro.periodo_lite=datos.periodo_lite;
		
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				hidden_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
				id_parametro:maestro.id_parametro,
				id_periodo:maestro.id_periodo,
				nro_cuenta_banco:maestro.nro_cuenta_banco,
			    //id_parametro:maestro.id_parametro,
			    gestion:maestro.gestion,
			    periodo_lite:maestro.periodo_lite
			}
		});
		//gridMaestro.getDataSource().removeAll();
		//gridMaestro.getDataSource().loadData([['Moneda',maestro.id_moneda],['Nombre',maestro.nombre]]);
		//alert(maestro.id_cuenta_bancaria);
		vectorAtributos[1].defecto=maestro.id_cuenta_bancaria;
		vectorAtributos[11].defecto=maestro.id_periodo;
		vectorAtributos[12].defecto=maestro.id_parametro;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/extracto_bancario/ActionEliminarExtractoBancario.php'},
				Save:{url:direccion+'../../../control/extracto_bancario/ActionGuardarExtractoBancarioMod.php'},
				ConfirmSave:{url:direccion+'../../../control/extracto_bancario/ActionGuardarExtractoBancarioMod.php'},
				
			Formulario:{
				titulo:'Extracto Bancario',
				html_apply:"dlgInfo-"+idContenedor,
				width:400,
				height:900,
				minWidth:100,
				minHeight:150,
				columnas:['95%'],
				closable:true,
				grupos:[
				{
					tituloGrupo:'Datos Extracto Bancario',
					columna:0,
					id_grupo:0
				}
				]
			}
		};
		this.InitFunciones(paramFunciones)
	};
	



	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{			
		//id_comprobante = ClaseMadre_getComponente('id_comprobante');
		//id_cuenta_bancaria = ClaseMadre_getComponente('id_cuenta_bancaria');
		/*var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();*/
		/*var id_periodo_dec=ClaseMadre_getComponente('id_periodo_dec');
		var tipo_declara=ClaseMadre_getComponente('tipo_declara');
		var id_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
		var sw_ingresa_declaracion=ClaseMadre_getComponente('sw_ingresa_declaracion');
		var sw_fa=ClaseMadre_getComponente('sw_fa');
		var sw_reversion=ClaseMadre_getComponente('sw_reversion');*/
	    //  alert(id_periodo_dec);
		//ClaseMadre_getComponente('id_presupuesto').disabled=true;
		//ClaseMadre_getComponente('id_comprobante').disable(false); 
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		//ClaseMadre_getComponente('id_comprobante').on('select',evento_comprobante);		//parametro		
		
	
     }
	function btn_asoc_eb(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		//if(NumSelect==1){ 
			if(confirm('¿Está seguro de asociar el extracto bancario con Comprobantes SIET?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Asociando.</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
				url:direccion+"../../../control/extracto_bancario/ActionGuardarExtractoBancario.php",
					method:'POST',
            		params:{cantidad_ids:'1',id_cuenta_bancaria:maestro.id_cuenta_bancaria,id_parametro:maestro.id_parametro,id_periodo:maestro.id_periodo,nro_cuenta_banco:maestro.nro_cuenta_banco,periodo_lite:maestro.periodo_lite,gestion:maestro.gestion,tipo_registro:'asociar_eb'},
					success:function(resp){
						if (resp.responseXML==null){
							Ext.MessageBox.alert('Información','Error en el archivo, o no existe datos para la Cuenta Bancaria.');
							return; 
						}
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						
						if(error=='false')
						{
							ds.load({
								params:{
									start:0,
									limit: paramConfig.TamanoPagina,
									CantFiltros:paramConfig.CantFiltros,
									hidden_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
									id_parametro:maestro.id_parametro,
									id_periodo:maestro.id_periodo,
									nro_cuenta_banco:maestro.nro_cuenta_banco,
								    id_parametro:maestro.id_parametro,
								    gestion:maestro.gestion,
								    periodo_lite:maestro.periodo_lite
								}
						});
							
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);

							return;
						} else {
							
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							}
						
					},
					//success:mensaje(),
					failure:Cm_conexionFailure,
					
					timeout:100000000000
				});
				
			}
			
	}
	
	function btn_fin_ped(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		//if(NumSelect==1){ 
			if(confirm('¿Está seguro de subir el extracto bancario?')){
				//alert('declaracion:'+SelectionsRecord.data.id_declaracion);return '';
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Migrando.</div>",
					width:200,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
				url:direccion+"../../../control/extracto_bancario/ActionGuardarExtractoBancario.php",
					method:'POST',
            		params:{cantidad_ids:'1',id_cuenta_bancaria:maestro.id_cuenta_bancaria,id_parametro:maestro.id_parametro,id_periodo:maestro.id_periodo,nro_cuenta_banco:maestro.nro_cuenta_banco,periodo_lite:maestro.periodo_lite,gestion:maestro.gestion,tipo_registro:'subir_extracto'},
					success:function(resp){
						if (resp.responseXML==null){
							Ext.MessageBox.alert('Información','Error en el archivo, o no existe datos para la Cuenta Bancaria.');
							return; 
						}
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						
						if(error=='false')
						{
							ds.load({
								params:{
									start:0,
									limit: paramConfig.TamanoPagina,
									CantFiltros:paramConfig.CantFiltros,
									hidden_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
									id_parametro:maestro.id_parametro,
									id_periodo:maestro.id_periodo,
									nro_cuenta_banco:maestro.nro_cuenta_banco,
								    id_parametro:maestro.id_parametro,
								    gestion:maestro.gestion,
								    periodo_lite:maestro.periodo_lite
								}
						});
							
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);

							return;
						} else {
							
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							}
						
					},
					//success:mensaje(),
					failure:Cm_conexionFailure,
					
					timeout:100000000000
				});
				
			}
			
	}
	function btn_bus_trans(){
		//CM_ocultarGrupo('Origen Solicitud');
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
			//var SelectionsRecord=sm.getSelected();
			  	   var data='id_cuenta_bancaria='+maestro.id_cuenta_bancaria;
		  	           data=data+'&id_parametro='+maestro.id_parametro;
			  	       data=data+'&id_periodo='+maestro.id_periodo;
				  	   data=data+'&nro_cuenta_banco='+maestro.nro_cuenta_banco;
					   data=data+'&periodo_lite='+maestro.periodo_lite;  
					   data=data+'&gestion='+maestro.gestion;   
					   data=data+'&tipo_registro=bus_trans';  
					  // alert(data);
			   		if(confirm("¿Está seguro de buscar las transferencias?")){
						 Ext.Ajax.request({
						 url:direccion+"../../../control/extracto_bancario/ActionGuardarExtractoBancario.php?"+data,
						 //url:direccion+"../../../control/solicitud_compra/ActionGuardarSolicitudCompraFin.php?hidden_id_solicitud_compra_0="+data,
						 method:'GET',
						 success:terminadoP,
						 failure:Cm_conexionFailure,
						 timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						})
					}
						
			
		
	}


	function terminadoP(resp){
		alert('Busqueda de Transferencias para esta Cuenta Bancaria Finalizada');
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				hidden_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
				id_parametro:maestro.id_parametro,
				id_periodo:maestro.id_periodo,
				nro_cuenta_banco:maestro.nro_cuenta_banco,
			   //id_parametro:maestro.id_parametro,
			    gestion:maestro.gestion,
			    periodo_lite:maestro.periodo_lite
			}
			}); 
	}
	
	
	function mensaje(resp){
		Actualizar();
		
		}
	function Actualizar(){
		ds.load(ds.lastOptions);//actualizar
		ds.rejectChanges()//vacia el vector de records modificados
	}
	function fallo (){
alert ('fallo');
		}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_extracto_bancario.getLayout()};
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

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Subir Extracto',btn_subir_extracto,true,'subir_extracto','Subir Extractos');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Generar la migracion',btn_fin_ped,true,'migrar','Generar la Migración');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Asociar Extractos Bancarios',btn_asoc_eb,true,'asociar','Asociar Extractos Bancarios');
/*	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Buscar Transferencias',btn_bus_trans,true,'buscar_transferencias','Buscar Transferencias');*/
	
	this.iniciaFormulario();
	layout_extracto_bancario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}