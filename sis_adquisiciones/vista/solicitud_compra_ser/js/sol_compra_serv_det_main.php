<?php
/**
 * Nombre:		  	    solicitud_compra_serv_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pag_sol_compra_serv_det(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
* Nombre:		  	    pagina_solicitud_compra_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pag_sol_compra_serv_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM,maestro;
	var gestionS;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_solicitud_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_solicitud_compra_det',

		//'id_item_antiguo',
		'cantidad',
		'precio_referencial_estimado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_inicio_serv',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_serv',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'estado_reg',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_servicio',
		'desc_servicio',
		'tipo_servicio','id_item','desc_item','item',
		
		'abreviatura',
		'id_unidad_medida_base',
		'precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial',
		'especificaciones_tecnicas','id_cuenta','desc_cuenta','id_partida','codigo_partida','precio_referencial_total_as','total_gestion','gestion'
		]),remoteSort:true});

		//carga datos XML
		


		//DATA STORE COMBOS

		//
		var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarSerField.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio'])
		});
		
		var ds_unid_med_bas=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php?tipo_unidad_medida_nombre=Servicios'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	});



		//FUNCIONES RENDER
		function renderUnidMedBas(value,p,record){return String.format('{0}',record.data['abreviatura'])}
		function render_id_servicio(value, p, record){return String.format('{0}', record.data['desc_servicio']);}
		var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');

		 function render_decimales(v){
            return getComponente('precio_total_moneda_seleccionada').formatMoneda(v);
        }
		 var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almacenes/control/item/ActionListarItem.php'}),
				reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad'])
				});

				//FUNCIONES RENDER

				function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
		
		
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_solicitud_compra_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_solicitud_compra_det',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_solicitud_compra_det',
			id_grupo:0
		};
		
		Atributos[1]={
			validacion:{
				name:'tipo_servicio',
				fieldLabel:'Tipo Compra',
				allowBlank:false,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: false,
			filterColValue:'TIPSER.nombre',
			filtro_0:true,
			id_grupo:1
		};

		
		filterCols_servicio=new Array();
	    filterValues_servicio=new Array();
	    filterCols_servicio[0]='servicio.id_tipo_adq';
	    filterValues_servicio[0]='%';
	    filterCols_servicio[1]='servicio.estado';
	    filterValues_servicio[1]='%';
		
		Atributos[2]={
			validacion:{
				name:'id_servicio',
				desc:'desc_servicio',
				fieldLabel:'Item/Servicio',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				store:ds_servicio,
				renderer:render_id_servicio,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:200,
				pageSize:10,
				direccion:direccion,
				filterCols:filterCols_servicio,
				filterValues:filterValues_servicio,
				grid_indice:2
			},
			tipo:'LovServicio',
			save_as:'id_servicio',
			filtro_0:true,
			defecto:'',
			filterColValue:'SERVIC.codigo#SERVIC.nombre',
			id_grupo:1
		};
		
		// txt id_item
		Atributos[3]={
			validacion:{
				name:'id_item',
				desc:'desc_item',
				fieldLabel:'Código Item',
				allowBlank:false,
				maxLength:500,
				minLength:0,
				store:ds_item,
				valueField: 'id_item',
				displayField: 'descripcion',
				renderer:render_id_item,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:200,
				pageSize:10,
				direccion:direccion,

				grid_indice:1
			},
			tipo:'LovItemsAlm',
			save_as:'id_item',
			filtro_0:true,
			defecto:'',
			filterColValue:'ITTEM.codigo#ITTEM.nombre',
			id_grupo:1
		};
		Atributos[18]={
				validacion:{
					name:'item',
					fieldLabel:'Item',
					allowBlank:false,
					maxLength:500,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					width:'100%',
					disable:false,
					grid_indice:2
				},
				tipo: 'TextField',
				form: false,
				filterColValue:'ITTEM.codigo#ITTEM.nombre',
				filtro_0:true,
				id_grupo:1
			};

		
		
		Atributos[4]={
		validacion:{
					fieldLabel:'Unidad Medida',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Unidad Medida...',
			name:'id_unidad_medida_base',
			desc:'abreviatura',
			store:ds_unid_med_bas,
			valueField:'id_unidad_medida_base',
			displayField:'nombre',
			filterCol:'UNMEDB.nombre#UNMEDB.abreviatura',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplUniMed,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderUnidMedBas,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:200,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'umb.nombre',
		id_grupo:1
	};
		
		// txt cantidad
		Atributos[5]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:75,
				width:'62%',
				disable:false,
				grid_indice:6
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad',
			id_grupo:2,
			save_as:'cantidad'
		};

		// txt fecha_inicio_serv
		Atributos[6]= {
			validacion:{
				name:'fecha_inicio_serv',
				fieldLabel:'Fecha Inicio',
				
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:102,
				disabled:false,
				grid_indice:12,
				width:200
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_inicio_serv',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_inicio_serv',
			id_grupo:1
		};


		Atributos[7]= {
			validacion:{
				name:'fecha_fin_serv',
				fieldLabel:'Fecha Fin',
				
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				
				width_grid:90,
				disabled:true,
				grid_indice:13,
				width:200
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_fin_serv',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin_serv',
			id_grupo:1
			
		};

		// txt id_solicitud_compra
		Atributos[8]={
			validacion:{
				name:'id_solicitud_compra',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'id_solicitud_compra'
		};

		// txt fecha_fin_serv
		


		Atributos[9]={
			validacion:{
				name:'precio_referencial_moneda_seleccionada',
				fieldLabel:'Precio Unitario',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				decimalPrecision:6,//para numeros float
				width_grid:90,
				width:'62%',
				disabled:false,
				grid_indice:9,
				//renderer:render_decimales,
    			allowNegative:false,
    			allowDecimals:true,
    			allowMil:true
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			id_grupo:2
		};


		Atributos[10]={
			validacion:{
				name:'precio_total_moneda_seleccionada',
				fieldLabel:'Precio Total',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				decimalPrecision:6,//para numeros float
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:40,
				width:'62%',
				align:'right',
				disabled:true,
				grid_indice:10,
				//renderer:render_decimales,
    			allowNegative:false,
    			allowDecimals:true,
    			allowMil:true
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			id_grupo:2
		};

			
		Atributos[11]={
		validacion:{
			name:'precio_referencial_total_as',
			fieldLabel:'Precio Total Gestion Siguiente',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:95,
			align:'right',
			width:'62%',
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.precio_referencial_total_as',
		
		id_grupo:2
	};
	
	
	Atributos[12]={
		validacion:{
			name:'total_gestion',
			fieldLabel:'Precio Total Gestion Vigente',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0.1,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:95,
			align:'right',
			width:'62%',
			disabled:true
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:2
	};
		

		Atributos[13]={
			validacion:{
				name:'especificaciones_tecnicas',
				fieldLabel:'Especificaciones Tecnicas',
				allowBlank:false,
				//maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:110,
				width:'100%',
				disabled:false,
				grid_indice:4
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.especificaciones_tecnicas',
			save_as:'especificaciones_tecnicas',
			id_grupo:2
		};

		Atributos[14]={
			validacion:{
				name:'id_cuenta',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'id_cuenta'
		};


		Atributos[15]={
			validacion:{
				name:'id_partida',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'id_partida'
		};

		Atributos[16]={
			validacion:{
				name:'desc_cuenta',
				fieldLabel:'Cuenta',
				allowBlank:true,
				//maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:11
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA.desc_cuenta#CUENTA.nombre_cuenta',
			save_as:'desc_cuenta',
			id_grupo:0
		};


		Atributos[17]={
			validacion:{
				name:'codigo_partida',
				fieldLabel:'Partida',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:11
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
			save_as:'codigo_partida',
			id_grupo:0
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
		tituloM='Solicitud Detalle';
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud Compra (Maestro)',grid_maestro:'grid-'+idContenedor};
		var layout_solserv_det = new DocsLayoutMaestro(idContenedor);
		layout_solserv_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_solserv_det,idContenedor);
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
		var CM_getColumnNum=this.getColumnNum;
		var CM_getColumnModel=this.getColumnModel;
		var getGrid=this.getGrid;
		
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES
		

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php'},
			Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
			ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Servicio Solicitado',

			grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Pedido',
			
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Datos Pedido',
				columna:0,
				id_grupo:2
			},

			{
				tituloGrupo:'Informacion Presupuestaria',
				columna:0,
				id_grupo:3
			}
			]

			}};



			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m){
				maestro=m;
                
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:1,
						m_id_solicitud_compra:maestro.id_solicitud_compra,
						m_tipo_adq:maestro.tipo_adq,
						m_simbolo:maestro.simbolo,
						id_empresa:maestro.id_empresa
						
					}
				};
		       
		        var serv =getComponente('id_servicio');
		        serv.lov.modifica_filterValues(0,'%');
				getComponente('id_servicio').filterValues[0] = maestro.id_tipo_adq;
				getComponente('id_servicio').modificado = true;
				getComponente('id_servicio').filterValues[1] ='activo';
			    getComponente('id_servicio').modificado = true;
				this.btnActualizar();
				//iniciarEventosFormularios();
				
				if(maestro.id_tipo_adq==4){
					   unidadMedida='%'; 
					   
				   }else{
						unidadMedida='Servicios'; 
					}

				 ds_unid_med_bas.baseParams={
				   tipo_unidad_medida_nombre:unidadMedida
				}
				 ds_unid_med_bas.modificado=true;


					if(maestro.es_item==0 ){
							hideColumns([[CM_getColumnNum('id_item'),true]]);
							hideColumns([[CM_getColumnNum('item'),true]]);
							hideColumns([[CM_getColumnNum('id_servicio'),false]]);
							hideColumns([[CM_getColumnNum('tipo_servicio'),false]]);
						}else{
							
						//hideColumns([[CM_getColumnNum('tipo_servicio'),true]]);
					        hideColumns([[CM_getColumnNum('id_servicio'),true]]);
					        hideColumns([[CM_getColumnNum('tipo_servicio'),true]]);
					        hideColumns([[CM_getColumnNum('id_item'),false]]);
					        hideColumns([[CM_getColumnNum('item'),false]]);
						}


			//&& getComponente('id_servicio').getValue()!=null && getComponente('id_servicio')!=undefined		
                         
          
				Atributos[8].defecto=maestro.id_solicitud_compra;
          
                               
              
				//ds_tipo_servicio.baseParams={m_id_tipo_adq:maestro.id_tipo_adq}

				paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
				paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
				paramFunciones.ConfirmSave.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
				this.InitFunciones(paramFunciones)
			};



			function hideColumns(colIndexes){
				cm.totalWidth = null;
				grid=getGrid();
				vista_grid=grid.getView();
				for(var i=0;i<colIndexes.length;i++){
					cm.config[colIndexes[i][0]].hidden = colIndexes[i][1];
					
			        var cid = vista_grid.getColumnId(colIndexes[i][0]);
			        
			        if(colIndexes[i][1]){
			        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "none");
			        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "none");
			        }
			        else{
			        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "");
			        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "");
			        }
			        
				}
		        if(Ext.isSafari){
		            vista_grid.updateHeaders();
		        }
		        vista_grid.updateSplitters();
		        vista_grid.layout();
		    }
			
			function btn_caracteristica(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					//
					var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
					data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
					data=data+'&m_id_detalle='+SelectionsRecord.data.desc_servicio;
                    data=data+'&m_id_item_propuesto=-1&m_id_servicio_propuesto=-1';
					
					var ParamVentana={ventana:{width:'90%',height:'70%'}};
					layout_solserv_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Caracteristicas Adicionales',ParamVentana);
					layout_solserv_det.getVentana().on('resize',function(){
						layout_solserv_det.getLayout().layout();
					})
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				cm=CM_getColumnModel();
				
				txt_cantidad=getComponente('cantidad');
				txt_precio_referencial_moneda_seleccionada=getComponente('precio_referencial_moneda_seleccionada');
				txt_precio_total_moneda_seleccionada=getComponente('precio_total_moneda_seleccionada');
				txt_id_servicio=getComponente('id_servicio');

				txt_fecha_inicioS=getComponente('fecha_inicio_serv');
				txt_fecha_finS=getComponente('fecha_fin_serv');


				txt_lim_sup_fecha=getComponente('fecha_fin_serv');
				txt_lim_inf_fecha=getComponente('fecha_inicio_serv');
				
				txt_total_gestion_asS=getComponente('precio_referencial_total_as');
				var CalcularCostoTotal = function(e) {


                    var unit=txt_precio_referencial_moneda_seleccionada.getValue();
					var cant = txt_cantidad.getValue();

					if(unit!=undefined && unit!=null && cant!=undefined && cant!=null){
						txt_precio_total_moneda_seleccionada.setValue(unit*cant);
					}
					else{
						txt_precio_total_moneda_seleccionada.setValue('0');
					}
				};


				var onFecha=function(e){
					txt_fecha_finS.purgeListeners();
					txt_fecha_finS.isDirty();
					txt_fecha_finS.reset();
					if(txt_fecha_inicioS.getValue()!=''){

						txt_fecha_finS.enable();
//						txt_fecha_finS.setValue(txt_fecha_inicioS.getValue().dateFormat('d/m/Y'));
						txt_fecha_finS.modificado=true;
						txt_fecha_finS.minValue=txt_fecha_inicioS.getValue();
					}
					txt_fecha_finS.modificado=true;
				};

				
				txt_cantidad.on('blur',CalcularCostoTotal);
				txt_precio_referencial_moneda_seleccionada.on('blur',CalcularCostoTotal);
				txt_fecha_inicioS.on('change', onFecha);
				txt_fecha_inicioS.on('select', onFecha);
				txt_fecha_inicioS.on('blur',onFecha);

				
				
				var onTotalGestionS=function(e){
        	 	   if(parseFloat(txt_precio_total_moneda_seleccionada.getValue())>0){
        		        getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue()-txt_total_gestion_asS.getValue());
        		    }
        		}
		           txt_total_gestion_asS.on('blur',onTotalGestionS);
	 	   }
			
			


			this.btnNew=function(){
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Informacion Presupuestaria');
				txt_fecha_inicioS.setValue('');
				get_fecha_adq();
				CM_ocultarComponente(getComponente('precio_referencial_total_as'));
				getComponente('precio_referencial_total_as').allowBlank=true;
				getComponente('precio_referencial_total_as').reset();
		        CM_ocultarComponente(getComponente('total_gestion'));
		        if(maestro.tipo_adq!='Bien'){
		        	CM_mostrarComponente(getComponente('fecha_inicio_serv'));
					CM_mostrarComponente(getComponente('fecha_fin_serv'));
					getComponente('fecha_inicio_serv').allowBlank=false;
					getComponente('fecha_fin_serv').allowBlank=true;
			    }else{
			    	CM_ocultarComponente(getComponente('fecha_inicio_serv'));
					CM_ocultarComponente(getComponente('fecha_fin_serv'));

					getComponente('fecha_inicio_serv').allowBlank=true;
					getComponente('fecha_fin_serv').allowBlank=true;
				 }

					CM_ocultarComponente(getComponente('id_item'));
					CM_mostrarComponente(getComponente('id_servicio'));
					getComponente('id_item').allowBlank=true;

				 
		        
				CM_btnNew();
			}


			function get_fecha_adq(){
				Ext.Ajax.request({
					url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa=1&m_gestion="+maestro.gestion,
					method:'GET',
					success:cargar_fecha_adq,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_fecha_adq(resp){

				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
                        gestionS=root.getElementsByTagName('gestion')[0].firstChild.nodeValue;
						txt_lim_inf_fecha.setValue('');
						
						/**12-enero, modificar**/
						txt_lim_inf_fecha.setValue('01/01/'+root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
					 	//txt_lim_inf_fecha.setValue(maestro.fecha_reg.dateFormat('d/m/Y'));
						/***/
						
						
						txt_fecha_inicioS.minValue=txt_lim_inf_fecha.getValue();
						txt_fecha_inicioS.setValue(txt_fecha_inicioS.getValue());
						
						 if(maestro.avance=='si'){
					        txt_lim_sup_fecha.setValue(root.getElementsByTagName('fecha_fin')[0].firstChild.nodeValue);
    					    txt_fecha_finS.maxValue=txt_lim_sup_fecha.getValue();;
			             }
						txt_lim_inf_fecha.setValue('');
						txt_lim_sup_fecha.setValue('');
                        txt_fecha_finS.setValue('');

					}
				}
			}



			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();

				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					CM_ocultarGrupo('Oculto');
					CM_ocultarGrupo('Informacion Presupuestaria');
					getComponente('precio_total_moneda_seleccionada').setValue(getComponente('cantidad').getValue()*					getComponente('precio_referencial_moneda_seleccionada').getValue());
					
					if(getComponente('especificaciones_tecnicas').getValue()!=''){
						CM_mostrarComponente(getComponente('especificaciones_tecnicas'));

					}
					if(maestro.tipo_adq!='Bien'){
			        	CM_mostrarComponente(getComponente('fecha_inicio_serv'));
						CM_mostrarComponente(getComponente('fecha_fin_serv'));
						getComponente('fecha_inicio_serv').allowBlank=false;
						getComponente('fecha_fin_serv').allowBlank=true;
				    }else{
				    	CM_ocultarComponente(getComponente('fecha_inicio_serv'));
						CM_ocultarComponente(getComponente('fecha_fin_serv'));

						getComponente('fecha_inicio_serv').allowBlank=true;
						getComponente('fecha_fin_serv').allowBlank=true;


						
					 }


					 

					
					getComponente('fecha_fin_serv').minValue=SelectionsRecord.data.fecha_inicio_serv;
					getComponente('fecha_fin_serv').setValue(SelectionsRecord.data.fecha_fin_serv);
					CM_btnEdit();
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}


			function get_fecha_bd()
			{
				Ext.Ajax.request({
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					method:'GET',
					success:cargar_fecha_bd,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_fecha_bd(resp)
			{

				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
				{
					var root = resp.responseXML.documentElement;
					if(getComponente('fecha_reg').getValue()==""){
						getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);

					}
				}
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_solserv_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones


			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			
			
			layout_solserv_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}