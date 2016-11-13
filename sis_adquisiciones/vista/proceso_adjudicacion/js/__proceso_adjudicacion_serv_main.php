<?php 
/**
 * Nombre:		  	    proceso_adjudicacion_serv_main.php
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
var elemento={pagina:new pagina_proceso_adjudicacion_serv(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_proceso_adjudicacion_serv_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_proceso_adjudicacion_serv(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on;
	var sw_grup=true,gridG,gSm,ds_g,gDlg;
	var bandera;
	var dialog;
	var adj;
	var id;
	var cont_se_adj;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompra.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[
		'id_proceso_compra',
		'observaciones',
		'codigo_proceso',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_categoria_adq',
		'desc_categoria_adq',
		'id_moneda',
		'desc_moneda',
		'num_cotizacion',
		'num_proceso',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_cotizacion_sis',
		'num_proceso_sis',
		{name: 'fecha_proc',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_adq',
		'tipo_adq',
		'id_tipo_adq','id_proceso_compra_ant','num_convocatoria','id_cotizacion','id_moneda_base','numeracion_periodo_proceso','proceso_adjudicado','ejecutado','cantidad_sol','cant_se_adjudica','numeracion_periodo_cotizacion','num_sol_por_proc'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				estado_cotizacion:'cotizado',/////////////para listar solo los procesos que esten cotizados==> listos para adjudicacion
				estado:'en_proceso',
				tipo:'servicio'
			}
		});

		/////////////////////////
		// Definición de datos //
		/////////////////////////


		// hidden id_proceso_compra
		//en la posición 0 siempre esta la llave primaria
		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra'
		};

		Atributos[1]={//18
			validacion:{
				name:'numeracion_periodo_proceso',
				fieldLabel:'Periodo/Nº Proc.',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:95,
				width:'40%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.periodo#PROCOM.num_proceso',
			save_as:'numeracion_periodo'
		};
		
		// txt codigo_proceso
		Atributos[2]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:110,
				width:'100%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};
		
		Atributos[3]={
			validacion:{
				name:'desc_categoria_adq',
				fieldLabel:'Categoria',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		
		
		Atributos[4]={
			validacion:{
				name:'desc_tipo_adq',
				fieldLabel:'Tipo de Adquisicion',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:115,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'TIPADQ.nombre',
			save_as:'id_tipo_adq'
		};
		
		
		// txt id_moneda
		
		Atributos[5]={
			validacion:{
				name:'desc_moneda',
				fieldLabel:'Moneda',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
	
		// txt num_proceso
		Atributos[6]={
			validacion:{
				name:'num_proceso',
				fieldLabel:'Nº Proceso',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};
		
		// txt num_cotizacion
		Atributos[7]={
			validacion:{
				name:'numeracion_periodo_cotizacion',
				fieldLabel:'Nº Cotización',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				align:'right',
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_cotizacion#PROCOM.periodo',
			save_as:'num_cotizacion'
		};

		Atributos[8]={//16
			validacion:{
				name:'num_convocatoria',
				fieldLabel:'Nº Convocatoria',
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
				align:'center',
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_convocatoria',
			save_as:'num_convocatoria'
		};

		// txt fecha_reg
		Atributos[9]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};

	
		// txt estado_vigente//14
		Atributos[10]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};

		// txt observaciones
		Atributos[11]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};
		

		Atributos[12]={//17
			validacion:{
				name:'id_cotizacion',
				fieldLabel:'id_cotizacion',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false
	    };
	    
	    Atributos[13]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				width:'40%',
				align:'right',
				disabled:true
				
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'
			
		};
	 
 Atributos[14]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:120
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'SOLCOM.periodo#SOLCOM.num_solicitud',
			save_as:'num_sol_por_proc'
		};
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Adjudicacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_serv_det.php'};
		layout_proceso_adjudicacion_serv=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_proceso_adjudicacion_serv.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_proceso_adjudicacion_serv,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var cm_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnEdit=this.btnEdit;
		var cmbtnActualizar=this.btnActualizar;
		var Cm_getDialog=this.getDialog;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

	    
		var paramMenu={
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Adjudicacion',
			grupos:[
			{	tituloGrupo:'Proceso',
			columna:0,
			id_grupo:0
			}
			]

			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			
			function btn_resolucion_adjudicacion(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
					if(NumSelect!=0){
						 if(sw_grup){
						 	InitDetalleAdj(SelectionsRecord.data.id_proceso_compra);
						 }else{
						 	reloadDetalleGrupo(SelectionsRecord.data.id_proceso_compra);
						 }
					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
			}
			
			
			
			function InitDetalleAdj(id_proceso_compra){
  			   
				//crear ventana para para manejar grupos
				var Win=Ext.DomHelper.append(document.body,{tag:'div',id:"gDlg-"+idContenedor},true);
				var dGrid=Ext.DomHelper.append("gDlg-"+idContenedor,{tag:'div',id:"grid_g-"+idContenedor},true);
				
				gDlg = new Ext.LayoutDialog(Win,{
					modal: true,
					width: 500,
					height: 200,
					fixedCenter:true,
					closable: true,
					center:{title:'Grupos',titlebar:false,autoScroll:true}
				});

				
				    gDlg.addButton('Guardar',siAdj,gDlg);	
				  	gDlg.addButton('Cancelar',noAdj,gDlg);	
					gDlg.buttons[0].enable();
				
					ds_g = new Ext.data.Store({
						proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/cotizacion/ActionListarCotizacion.php'}),
						// aqui se define la estructura del XML
						reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion',totalRecords:'TotalCount'},[
	
						'id_cotizacion',
						'id_proceso_compra',
						'id_proveedor','desc_proveedor',
						'se_adjudica','precio_total','num_detalle_adjudicado','cantidad_sol', 'cant_se_adjudica']),remoteSort:false});

					ds_g.load({
						params:{
							start:0,
							limit:100,
							m_id_proceso_compra:id_proceso_compra,
							proceso_adjudicacion:'si'
						}
					});
					
					
					var fm = Ext.form, Ed = Ext.grid.GridEditor;
					
					var	check_adj= new Ed(new fm.Checkbox({disabled:false,checked:true}));
						
					
					var cmG = new Ext.grid.ColumnModel(
							[{header:"Proveedor",width:200,dataIndex:'desc_proveedor'},
							 {header:"Precio Total",width:80,dataIndex:'precio_total'},
							 {header:"Elegir para Adjudicacion",width:140,dataIndex:'se_adjudica',renderer:render_adq,editor:check_adj,align:'center'}
							 ]);
							 
							 
					function render_adq(value,p,record){
					    if(value==true||value=='true'){
					        return 'si';
						}else{
						    return 'no'
						}
					}
						
					gSm=new Ext.grid.RowSelectionModel({singleSelect:true});
					var glayout=gDlg.getLayout();
					
				    gridG=new Ext.grid.EditorGrid(dGrid,{ds:ds_g,cm:cmG,selModel:gSm});
					
					
					
			function terminado(resp){
			    
                if(adj==1){
                  
			     window.open(direccion+'../../../control/proceso_compra/reporte/ActionPDFEvaluacionPropuesta.php?id_proceso_compra_0='+id);
			     
			     if(gDlg.isVisible()){
							gDlg.hide();
						}

			     adj=0;
                }
			    
				this.getGrid().stopEditing()
				getSelectionModel().clearSelections();
				var regreso = Ext.util.JSON.decode(resp.responseText)
				Ext.MessageBox.hide();//ocultamos el loading
				if(regreso.success){
					 Ext.MessageBox.alert('Estado','Ejecución satisfactoria');
					 if(gDlg.isVisible()){
 				       gDlg.hide();
					 }
				}
				else{
					Ext.MessageBox.alert('Estado','Ejecución no realizada');
					    if(gDlg.isVisible()){
							gDlg.hide();
						}
						else{
							Actualizar()
						}
					}
				}
			
				var g_panel=new Ext.GridPanel(gridG,{fitToFrame:true,closable:false});
										
					glayout.add('center',g_panel);
					gDlg.show();

					gridG.render();
					// add a paging toolbar to the grid's footer
					var gPaging=new Ext.PagingToolbar(gridG.getView().getFooterPanel(true),ds_g, {
						pageSize: 25,
						displayInfo:true,
						displayMsg:'Grupos {0} - {1} de {2}',
						emptyMsg:"No hay Grupos"
					});

				function siAdj(){if(gSm.getSelected()){
				/*desde aqui falta verificar el monto aprobado para que pueda adjudicar*/
					adjudicar(gSm.getSelected().data.id_proceso_compra,gSm.getSelected().data.id_cotizacion,gSm.getSelected().data.se_adjudica)
					}
				}
			
			function noAdj(){
				if(gDlg.isVisible()){
					gDlg.hide()
				}
			} 
				
				
			function adjudicar(id_proceso_compra,id_cotizacion,se_adjudica){
					//Actualizar();
				    // var record=getSelectionModel().getSelected(); //es el primer registro selecionado
				   var filas;
				   filas= ds_g.getModifiedRecords();
				   
				   var cont = filas.length;
				   
				   /***/
				   if(cont>0){//cant de regis modif > 0?
			            if(confirm("¿Está seguro de guardar los cambios?")){
								//postData, para el envio de datos a la capa de control
							var postData="cantidad_ids="+cont;
							var i=0;
							var record=filas[i].data;
							for(i=0;i<cont;i++){
							    var record=filas[i].data;
							    postData=postData+"&id_proceso_compra_"+i+"="+record['id_proceso_compra']+"&id_cotizacion_"+i+"="+record['id_cotizacion']
							    			     +"&figura_acta_"+i+"="+record['se_adjudica'];
							     
							}
							
							if(record['se_adjudica']){
							    id=record['id_proceso_compra'];
							    adj=1;
							   }else{
							   
							    adj=0;
							   }  
							  
							  
							 Ext.Ajax.request({
				   	  		    url:direccion+"../../../control/cotizacion/ActionGuardarEstadoCotizacion.php",
				   	  		    params:postData,
				   	  		    method:'POST',
								success:terminado,
								failure:cm_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							});
							Actualizar();
					}
				}
			}
					gDlg.on('hide',function(){Actualizar()});
					sw_grup=false;
					
					
				var verificarAdj=function(e){
			
					 if(gSm.getSelected().data.se_adjudica){
   				           cont_se_adj=cont_se_adj+1;
		       		       //alert(cont_se_adj);
					   }else{
					       if(cont_se_adj>0){
					           cont_se_adj=cont_se_adj-1;
					       }
					      // alert("**"+cont_se_adj+"**");
					   }
//alert((parseFloat(cont_se_adj)+parseFloat(e.record.data.cant_se_adjudica))+"---"+e.record.data.cantidad_sol+"....."+e.record.data.cant_se_adjudica);
					   if((parseFloat(cont_se_adj)+parseFloat(e.record.data.cant_se_adjudica))<=e.record.data.cantidad_sol){
					       
					      if(parseFloat(e.record.data.cantidad_sol)>parseFloat(e.record.data.cant_se_adjudica)){
					     	//if(parseFloat(e.record.data.num_detalle_adjudicado)>0){
					  		// alert('La cotizacion ya tiene. adjudicaciones');
					   	   	 //	e.record.set('se_adjudica', e.originalValue);	
					   	   	 	
					   	   	 //	return false;
					   	   	 	
					  		  //}
					      }else{
					          if(gSm.getSelected().data.se_adjudica){
					               	alert('La cotizacion ya tiene adjudicaciones asignadas para el total de lo solicitado');
					  		        e.record.set('se_adjudica', e.originalValue);	
					  		        cont_se_adj=cont_se_adj-1;
					  		        return false;
					  		            ds_g.load({
									params:{
											start:0,
											limit:100,
											m_id_proceso_compra:id_proceso_compra,
											proceso_adjudicacion:'si'
										}
									});
					  		        
					          }
					      }
					    }else{
					  		   alert('La cotizacion ya tiene adjudicaciones asignadas para el total de lo solicitado');
					  		    e.record.set('se_adjudica', e.originalValue);	
					  		    cont_se_adj=cont_se_adj-1;
					  		    return false;
					  		    
					  		        ds_g.load({
									params:{
											start:0,
											limit:100,
											m_id_proceso_compra:id_proceso_compra,
											proceso_adjudicacion:'si'
										}
									});
					  		    
					    }
					    
					
					}
					gridG.on('afteredit',verificarAdj);
				}
			
			
			function btn_adjudicacion(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					data=data+'&m_num_proceso='+SelectionsRecord.data.num_proceso;
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_lugar_entrega='+SelectionsRecord.data.lugar_entrega;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;
					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;

					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					  layout_proceso_adjudicacion_serv.loadWindows(direccion+'../../../../sis_adquisiciones/vista/proceso_adjudicacion_det/proceso_adjudicacion_serv_dir_det.php?'+data,'Cotizacion de Proceso',ParamVentana);
					

					layout_proceso_adjudicacion_serv.getVentana().on('resize',function(){
						layout_proceso_adjudicacion_serv.getLayout().layout();
					});

				}else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function reloadDetalleGrupo(id_proceso_compra){
			  	gSm.clearSelections();
				gDlg.buttons[0].enable();
				gDlg.show();
				ds_g.rejectChanges();
				ds_g.reload({params:{
					start:0,
					limit:100,
					m_id_proceso_compra:id_proceso_compra,
					proceso_adjudicacion:'si'
				}});
				
				
				cont_se_adj=0;
			}

			function Actualizar(){
				ds.load(ds.lastOptions);//actualizar
				ds.rejectChanges()//vacia el vector de records modificados
			}
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				cont_se_adj=0;
				dialog=Cm_getDialog();
				
				getSelectionModel().on('rowdeselect',function(){
				
					if(_CP.getPagina(layout_proceso_adjudicacion_serv.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_proceso_adjudicacion_serv.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
			}
            
			this.EnableSelect=function(x,z,y){
			 	enable(x,z,y);
			 	_CP.getPagina(layout_proceso_adjudicacion_serv.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_proceso_adjudicacion_serv.getIdContentHijo()).pagina.desbloquearMenu();
		    }

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_adjudicacion_serv.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones



			
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Adjudicaciones',btn_adjudicacion,true,'adjudicacion','Cotizaciones Recepcionadas');
						//this.AdicionarBoton('../../../lib/imagenes/print.gif','Resolucion Adjudicacion',btn_resolucion_adjudicacion,true,'resolucion_adjudicacion','Resolucion de Adjudicacion');
			
			var CM_getBoton=this.getBoton;
			//CM_getBoton('resolucion_adjudicacion-'+idContenedor).enable();
			CM_getBoton('adjudicacion-'+idContenedor).enable();
			
			function  enable(sel,row,selected){
				var record=selected.data; 
			
				if(selected&&record!=-1){
				    /*if(record.proceso_adjudicado>0){
				         CM_getBoton('adjudicacion-'+idContenedor).enable();
				     }else{
				        CM_getBoton('adjudicacion-'+idContenedor).disable();
				    }*/
				    /* if(parseFloat(record.cant_se_adjudica)<parseFloat(record.cantidad_sol)){
				            CM_getBoton('resolucion_adjudicacion-'+idContenedor).enable();
				        }else{
				            CM_getBoton('resolucion_adjudicacion-'+idContenedor).disable();
				        }*/
				}
				
				
			}
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_proceso_adjudicacion_serv.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}