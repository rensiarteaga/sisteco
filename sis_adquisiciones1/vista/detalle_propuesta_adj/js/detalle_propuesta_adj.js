/**
* Nombre:		  	    pagina_DetallePropuesta.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2009-02-03 11:26:27
*/
function pag_DetPropAdj(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{


	var Atributos=new Array,sw=0;

	var cmpClasificado,cmpIdItem,cmpNombre,cmpDescripcion,txt_precio,txt_precio_total,txt_cantidad;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/detalle_propuesta/ActionListarDetallePropuesta.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_detalle_propuesta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_detalle_propuesta',
		'id_cotizacion_det',
		'id_item',
		'desc_item',
		'precio',
		'cantidad',
		'precio_total',
		'nombre',
		'descripcion',
		'res_desc',
		'codigo_item',
		'clasificado',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item_solicitado',
		'garantia',
		'observaciones',
		'estado',
        'id_unidad_medida_base',
		'desc_unidad_medida'
		]),remoteSort:true});


		// DEFINICIÓN DATOS DEL MAESTRO
        var ds_uni_med=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	    });

		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
		function italic(value){return '<i>'+value+'</i>';}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
		var data_maestro=[[' id_cotizacion_det ',maestro.id_cotizacion_det],[' Item Solicitado ',maestro.desc_item],[' Moneda ',maestro.desc_moneda]];

		//DATA STORE COMBOS

        var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');
		function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item'])}
		function render_id_unimed(value, p, record){return String.format('{0}', record.data['desc_unidad_medida'])}
		var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almacenes/control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad','calidad','descripcion_aux','tipo_item'])
		});


		function render_codigo(value, p, record){
			if(record.data['estado']=='seleccionado'){
				return String.format('<FONT COLOR="green">{0}</FONT>', record.data['codigo_item'])
			}
			else{
				return String.format('{0}', record.data['codigo_item'])

			}
		}



		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_detalle_propuesta
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_detalle_propuesta',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};


		Atributos[1]={
			validacion:{
				fieldLabel:'Item Clasificado',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data : [['si','si'],['no','no']] // from states.js
				}),
				valueField:'ID',
				displayField:'valor',
				disabled:true,
				mode: 'local',
				name: 'clasificado',
				grid_visible:false,
				grid_editable:false,
				value:'si'

			},
			tipo: 'ComboBox',
			filtro_0:false
		};

		// txt id_item
		Atributos[2]={
			validacion:{
				name:'id_item',
				desc:'desc_item',
				fieldLabel:'Código Item',
				allowBlank:false,
				maxLength:500,
				minLength:0,
				store:ds_item,
				valueField: 'id_item',
				displayField: 'nombre',
				renderer:render_id_item,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:false,
				grid_editable:false,
				width_grid:90,
				width:200,
				pageSize:10,
				direccion:direccion
			},
			tipo:'LovItemsAlm',
			save_as:'id_item',
			filtro_0:true,
			defecto:'',
			filterColValue:'ITEM.codigo#ITEM.nombre#DETPROP.descripcion'
		};



		Atributos[3]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				disabled:true,
				grid_visible:false,
				grid_editable:false,
				width:'80%'

			},

			tipo: 'Field',
			filtro_0:false,
			filtro_0:true,
			filterColValue:'DETPROP.nombre'
		};
		// txt descripcion
		Atributos[4]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				disabled:true,
				grid_visible:false,
				grid_editable:false
			},

			tipo:'TextArea',
			filtro_0:false,
			filterColValue:'DETPROP.descripcion',
		};
		// txt descripcion
		Atributos[5]={
			validacion:{
				name:'codigo_item',
				fieldLabel:'Código',
				grid_visible:true,
				grid_editable:false,
				renderer:render_codigo,
				width_grid:100
			},
			tipo:'Field',
			filtro_0:false,
			form:false,
			filterColValue:'DETPROP.descripcion',
		};

		// txt descripcion
		Atributos[6]={
			validacion:{
				name:'res_desc',
				fieldLabel:'Descripcion',
				grid_visible:true,
				grid_editable:false,
				width_grid:250
			},
			tipo:'Field',
			filtro_0:false,
			form:false,
			filterColValue:'DETPROP.descripcion',
		};
      Atributos[7]={
		validacion:{
			fieldLabel:'Unidad de Medida',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Unidad Medida...',
			name:'id_unidad_medida_base',
			desc:'desc_unidad_medida',
			store:ds_uni_med,
			valueField:'id_unidad_medida_base',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'UNMEDB.nombre',
			typeAhead:true,
			forceSelection:false,
			tpl:resultTplUniMed,
			mode:'remote',
			queryDelay:50,
			pageSize:5,
			minListWidth:150,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			renderer:render_id_unimed,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'UNIMED.nombre',
		save_as:'id_unidad_medida_base'
	};
		// txt cantidad
		Atributos[8]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				maxValue:maestro.cantidad_sol,
				allowBlank:false,
				disabled:true,
				align:'right',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'40%'

			},

			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'DETPROP.cantidad'
		};


		// txt precio
		Atributos[9]={
			validacion:{
				name:'precio',
				fieldLabel:'Precio Unitario',
				allowBlank:false,
				disabled:true,
				align:'right',
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:6,//para numeros float
				allowNegative:false,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'40%'

			},

			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'DETPROP.precio'
		};

		Atributos[10]={
			validacion:{
				name:'precio_total',
				fieldLabel:'Precio Total',
				allowBlank:false,
				disabled:true,
				decimalPrecision:2,//para numeros float
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:'40%',
				allowMil:true,
				allowDecimals:true,
				allowNegative:false,
				align:'right'
			},

			tipo: 'NumberField',
			filtro_0:false
		};

		Atributos[11]={
			validacion:{
				name:'garantia',
				fieldLabel:'garantia',
				grid_visible:true,
				grid_editable:false,
				maxLength:250,
				width_grid:100
			},
			form:false,
			tipo:'Field',
			filtro_0:true,
			filterColValue:'DETPROP.garantia',
		};

		Atributos[12]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				grid_visible:true,
				maxLength:450,
				grid_editable:false
			},
			form:false,
			tipo:'TextArea',
			filtro_0:false,
			filterColValue:'DETPROP.observaciones',
		};




		// txt fecha_reg
		Atributos[13]={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'DETPROP.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''
		};

		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Detalle de Cotizaciones (Maestro)',titulo_detalle:'DetallePropuesta (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_DetallePropuesta = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_DetallePropuesta.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_DetallePropuesta,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var EstehtmlMaestro=this.htmlMaestro;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_btnActualizar=this.btnActualizar;
		var CM_eliminarSucess=this.eliminarSucess;
		var enableSelect=this.EnableSelect;
		
		var Cm_conexionFailure=this.conexionFailure;




		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		var paramFunciones={
			Save:{url:direccion+'../../../control/detalle_propuesta/ActionGuardarDetallePropuesta.php',parametros:'&id_cotizacion_det='+maestro.id_cotizacion_det+'&id_item_solicitado='+maestro.id_item+'&id_moneda='+maestro.id_moneda},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'DetallePropuesta'}};

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_cotizacion_det:maestro.id_cotizacion_det
					}
				};
				this.btnActualizar();
				data_maestro=[[' id_cotizacion_det ',maestro.id_cotizacion_det],[' Item Solicitado ',maestro.desc_item],[' Moneda ',maestro.desc_moneda]];
				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
				paramFunciones.Save.parametros='&id_cotizacion_det='+maestro.id_cotizacion_det+'&id_item_solicitado='+maestro.id_item+'&id_moneda='+maestro.id_moneda;
				this.InitFunciones(paramFunciones)
			};

			//Para manejo de eventos

			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				cmpClasificado=getComponente('clasificado');
				cmpIdItem=getComponente('id_item');
				cmpNombre=getComponente('nombre');
				cmpDescripcion=getComponente('descripcion');
				/*CM_ocultarComponente(cmpNombre);
				cmpNombre.disable();
				CM_ocultarComponente(cmpDescripcion);
				cmpDescripcion.disable();*/


				var onIdItemSelect=function(e){

					if(cmpClasificado.getValue()=='no'){
						CM_ocultarComponente(cmpIdItem);
						cmpIdItem.disable();
						CM_mostrarComponente(cmpNombre);
						cmpNombre.enable();
						CM_mostrarComponente(cmpDescripcion);
						cmpDescripcion.enable();
					}
					else{
						CM_mostrarComponente(cmpIdItem);
						cmpIdItem.enable();
						CM_ocultarComponente(cmpNombre);
						cmpNombre.disable()
						CM_ocultarComponente(cmpDescripcion);
						cmpDescripcion.disable();
					}

				};

				cmpClasificado.on('select',onIdItemSelect);

			}


			this.EnableSelect=function(x,z,y){
				enable(x,z,y)
			}


			function btn_clasif(){
				CM_btnEdit();
				cmpClasificado.setValue('si');
			}


			function btn_seladj(){
				var sm=getSelectionModel();
				var record=sm.getSelected().data;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					Ext.Ajax.request({
						url:direccion + "../../../control/detalle_propuesta/ActionSelecAdjud.php",
						params:{id_detalle_propuesta:record.id_detalle_propuesta,estado:'seleccionado',id_cotizacion_det:record.id_cotizacion_det},
						method:'POST',
						success:terminado,
						failure:Cm_conexionFailure,
						timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
					});
				}
			}
			
			function terminado(resp){				
				var regreso = Ext.util.JSON.decode(resp.responseText);				
				if(regreso.success){
					alert(regreso.mensaje);
					CM_btnActualizar()
				}
			}

			_CP.getVentana(idContenedor).addListener('beforehide',function(){
				_CP.getPagina(idContenedorPadre).pagina.ActualizarPadre()});

				//para que los hijos puedan ajustarse al tamaño
				this.getLayout=function(){return layout_DetallePropuesta.getLayout()};
				//para el manejo de hijos

				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				this.InitFunciones(paramFunciones);

				this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Clasificar',btn_clasif,true,'clasif','Clasificar');
				this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Seleccionar para adjudicar',btn_seladj,true,'seladj','Seleccionar para adjudicar');
				var CM_getBoton=this.getBoton;
				//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_cotizacion_det:maestro.id_cotizacion_det
					}
				});

				//para agregar botones

				function  enable(sel,row,selected){
					var record=selected.data;
					if(selected&&record!=-1){

						if(record.estado=='clasificado' ){
							CM_getBoton('clasif-'+idContenedor).enable();
							CM_getBoton('seladj-'+idContenedor).enable();
						}
						else
						{
							if(record.estado=='registrado' ){
								CM_getBoton('clasif-'+idContenedor).enable();
								CM_getBoton('seladj-'+idContenedor).disable();
							}
							else
							{


								CM_getBoton('clasif-'+idContenedor).disable();
								CM_getBoton('seladj-'+idContenedor).disable();
							}

						}

					}

					enableSelect(sel,row,selected);
				}

				this.iniciaFormulario();
				iniciarEventosFormularios();
				layout_DetallePropuesta.getLayout().addListener('layout',this.onResize);
				layout_DetallePropuesta.getVentana(idContenedor).on('resize',function(){layout_DetallePropuesta.getLayout().layout()})

}