/**
 * Nombre: pagina_parametro_prorrateo_horas.js 
 */
function pagina_parametro_prorrateo_horas(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var cmpId_gestion;
	var cmpPresupuesto;
	var g_id_gestion='';
	// ///////////////
	// DATA STORE //
	// ///////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_costo_planilla/ActionListarProrrateoHoras.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_parametro_costo_planilla',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_parametro_costo_planilla',
		'id_empleado_planilla',
		'id_gestion',
		'gestion',
		'id_unidad_organizacional',
		'nombre_unidad',
		'id_fina_regi_prog_proy_acti',
		'id_financiador',
		'nombre_financiador',
		'id_regional',
		'nombre_regional',
		'id_programa',
		'nombre_programa',
		'id_proyecto',
		'nombre_proyecto',
		'id_actividad',
		'nombre_actividad',
		'id_orden_trabajo',
		'desc_orden',
		'descrip_orden',
		'id_usuario_reg',
		'id_presupuesto',
		'desc_presupuesto',
		'estado_reg',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'horas_normales',
		'costo_horas_normales',
		'horas_extra',
		'costo_horas_extra',
		'horas_nocturnas',
		'costo_horas_nocturnas',
		'horas_disp',
		'costo_horas_disp',
		'id_resumen_horario_mes',
		'factor_prorrateo'
		
		,'total_horas_normales','total_horas_extra','total_horas_nocturnas','total_horas_disp'
		]),remoteSort:true});

	
	// DATA STORE COMBOS
        var ds_orden_trabajo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords:'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden'])});
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>{desc_orden}</b>','<br><FONT COLOR="#B5A642"><b>Motivo:</b> {motivo_orden}</FONT>','</div>');
	// FUNCIONES RENDER
	 var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																																								'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																																								'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																																								'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																																								'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																																								]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
	function render_id_presupuesto(value, p, record){
		 //if(record.data['total_horas_normales']!=maestro.horas_normales_efectivas){
		   //                                           return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              
		     //                                         else { 
		       //                                       	return '<span style="color:357120;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';
		                                              /*	    if(record.data['horas_extra']==0){
		                                              	        return '<span style="color:357120;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              	     else{
		                                              	     	if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
		                                              	     		return '<span style="color:00215B;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              	     	else{*/
		                                              	     		return record.data['desc_presupuesto'];
		                                              	     	/*}
		                                              	     }*/
		                                              	     //}
		                                              	     
		                                             }
		                                             

		                                             
		                                             /*
		                                             
		                                             function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2' || record.data['horas_normales']==0){
		                                              return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              else { 
		                                              	    if(record.data['horas_extra']==0){
		                                              	        return '<span style="color:357120;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              	     else{
		                                              	     	if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
		                                              	     		return '<span style="color:00215B;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}
		                                              	     	else{
		                                              	     		return record.data['desc_presupuesto'];
		                                              	     	}
		                                              	     }
		                                              	     }
		                                              	     
		                                             }
		                                             */        

		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
		
		
function render_id_unidad_organizacional(value, p, record){
	/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_unidad'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_unidad'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_unidad'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_unidad'];		
					/*}
				}
				
			}*/
}
	function render_id_orden_trabajo(value, p, record){
			/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['descrip_orden'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['descrip_orden'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['descrip_orden'] + '</span>';	
					}
					else{*/
				        return record.data['descrip_orden'];		
					/*}
				}
				
			}*/
	}	
	function render_financiador(value,p,record){
			/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_financiador'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_financiador'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_financiador'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_financiador'];		
					/*}
				}
				
			}*/
	}	
    function render_regional(value,p,record){
    		/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_regional'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_regional'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_regional'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_regional'];		
					/*}
				}
				
			}*/
    }	
    function render_programa(value,p,record){
    		/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_programa'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_programa'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_programa'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_programa'];		
					/*}
				}
				
			}*/
    }	
    function render_proyecto(value,p,record){
    		/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_proyecto'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_proyecto'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_proyecto'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_proyecto'];		
					/*}
				}
				
			}*/
    }	
    function render_actividad(value,p,record){
    		/*if(record.data['horas_normales']==0){
					return '<span style="color:red;font-size:8pt">' + record.data['nombre_actividad'] + '</span>';
			}
			else
			{
				if(record.data['horas_extra']==0){
					return '<span style="color:#357120;font-size:8pt">' + record.data['nombre_actividad'] + '</span>';
				}
				else{
					if(record.data['horas_disp']==0 || record.data['horas_nocturnas']==0){
					  return '<span style="color:#00215B;font-size:8pt">' + record.data['nombre_actividad'] + '</span>';	
					}
					else{*/
				        return record.data['nombre_actividad'];		
					/*}
				}
				
			}*/
    }	
    function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else if(value=='inactivo'){value='Inactivo'	}
		return value
	}
	
function color_norm(val,cell,record,row,colum,store){
	
	
			if(record.get('total_horas_normales')!=maestro.horas_normales_efectivas){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
					
			}
			else
			{
				return '<span style="color:#357120;font-size:8pt">' + val + '</span>';
			}
			
}
function color_extra(val,cell,record,row,colum,store){
if(record.get('total_horas_extra')!=maestro.horas_extra){
				
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
					return '<span style="color:#357120;font-size:8pt">' + val + '</span>';
			}
}

function color_disp(val,cell,record,row,colum,store){
			if(record.get('total_horas_disp')!=maestro.horas_disp) {
				
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				
						return '<span style="color:#357120;font-size:8pt">' + val + '</span>';
			}
}

function color_noct(val,cell,record,row,colum,store){
if(record.get('total_horas_nocturnas')!=maestro.horas_nocturnas) {
				
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				
						return '<span style="color:#357120;font-size:8pt">' + val + '</span>';
			}
}
				
			
		
function render_id_gestion(val,cell,record,row,colum,store){
			/*if(record.get('horas_normales')==0){
					return '<span style="color:red;font-size:8pt">' + record.get('gestion') + '</span>';
			}
			else
			{
				if(record.get('horas_extra')==0){
					return '<span style="color:#357120;font-size:8pt">' + record.get('gestion') + '</span>';
				}
				else{
					if(record.get('horas_disp')==0 || record.get('horas_nocturnas')==0){
						return '<span style="color:00215B;font-size:8pt">' + record.get('gestion') + '</span>';
					}
					else{*/
				        return record.get('gestion');		
					/*}
				}
				
			}*/
		}		
    // ///////////////////////
	// Definición de datos //
	// ///////////////////////
	
	// hidden id_columna_valor
	// en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_parametro_costo_planilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	// txt id_empleado_planilla
	Atributos[1]={
		validacion:{
			name:'id_empleado_planilla',
			fieldLabel:'id_empleado_planilla',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'NumberField',
		form:false,
		filtro_0:true,
		filterColValue:'COLVAL.id_empleado_planilla'
	};
		Atributos[2]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Factor',
			name:'factor_prorrateo',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		defecto:'activo',
		filtro_0:false
	};	
	// txt id_columna
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'id_gestion',
			fieldLabel:'Gestion',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_id_gestion
		},
		form:false,
		tipo:'Field',
		filtro_0:false
	};
// txt valor
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
			,renderer:render_id_unidad_organizacional
		},
		form:false,
		tipo:'Field',
		filtro_0:false
	};
// txt valor_automatico
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false	
	};
	Atributos[6]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:250	
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'PRESUP.desc_presupuesto'
	};
	Atributos[7]={
		validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,			
			emptyText:'Orden Trabajo...',
			desc:'descrip_orden', 
			store:ds_orden_trabajo,
			valueField:'id_orden_trabajo',
			displayField:'desc_orden',
			queryParam:'filterValue_0',
			filterCol:'ORDTRA.desc_orden',
			typeAhead:true,
			tpl:tpl_id_orden_trabajo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			width:200,
			grid_visible:true,
			grid_editable:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ORDTRA.desc_orden'
	};
		Atributos[8]={
			validacion:{
				name:'horas_normales',
				fieldLabel:'Horas Normales Efectivas',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_norm,
				width:'40%'
			},
			tipo:'NumberField',
			defecto:'0.00',
			filtro_0:true,
			filterColValue:'PACOPLA.horas_normales',
			save_as:'horas_normales'
		};
	Atributos[9]={
			validacion:{
				name:'costo_horas_normales',
				fieldLabel:'Costo de Horas Normales',
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_norm,
				width:'40%'
			},
			tipo:'NumberField',
			form:false,
			filtro_0:true,
			filterColValue:'PACOPLA.costo_horas_normales',
			save_as:'costo_horas_normales'
		};
		Atributos[10]={
			validacion:{
				name:'horas_extra',
				fieldLabel:'Horas Extra',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_extra,
				width:'40%'
			},
			tipo:'NumberField',
			defecto:'0.00',
			filtro_0:true,
			filterColValue:'PACOPLA.horas_extra',
			save_as:'horas_extra'
		};
	Atributos[11]={
			validacion:{
				name:'costo_horas_extra',
				fieldLabel:'Costo de Horas Extra',
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_extra,
				width:'40%'
			},
			tipo:'NumberField',
			form:false,
			filtro_0:true,
			filterColValue:'PACOPLA.costo_horas_extra',
			save_as:'costo_horas_extra'
		};
	Atributos[12]={
			validacion:{
				name:'horas_nocturnas',
				fieldLabel:'Horas Nocturnas',
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_noct,
				width:'40%'
			},
			tipo:'NumberField',
			defecto:'0.00',
			filtro_0:true,
			filterColValue:'PACOPLA.horas_nocturnas',
			save_as:'horas_nocturnas'
		};
	Atributos[13]={
			validacion:{
				name:'costo_horas_nocturnas',
				fieldLabel:'Costo de Horas Nocturnas',
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				align:'right',
				width_grid:150,
				renderer:color_noct,
				width:'40%'
			},
			tipo:'NumberField',
			form:false,
			filtro_0:true,
			filterColValue:'PACOPLA.costo_horas_nocturnas',
			save_as:'costo_horas_nocturnas'
		};
	
	Atributos[14]={
		validacion:{
			labelSeparator:'',
			name:'id_resumen_horario_mes',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	Atributos[15]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PACOPLA.fecha_reg',
		dateFormat:'m/d/Y'
	};
	Atributos[16]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Estado',
			name:'estado_reg',
			inputType:'hidden',
			grid_visible:true, 
			renderer:render_estado_reg,
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		defecto:'activo',
		filtro_0:false
	};
			
	// ----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	// ---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Columna-Valor ',grid_maestro:'grid-'+idContenedor};
	var layout_columna_valor = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_columna_valor.init(config);
	// ---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_columna_valor,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var enableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	var ClaseMadre_saveSuccess=this.saveSuccess;
	var ClaseMadre_eliminarSuccess=this.eliminarSucess;
	var EstehtmlMaestro=this.htmlMaestro;
	// DEFINICIÓN DE LA BARRA DE MENU
	var paramMenu={guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	// DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/parametro_costo_planilla/ActionEliminarParametroCostoPlanilla.php',success:eliminarSuccess},
	Save:{url:direccion+'../../../control/parametro_costo_planilla/ActionGuardarParametroCostoPlanilla.php',success:Success},
	ConfirmSave:{url:direccion+'../../../control/parametro_costo_planilla/ActionGuardarParametroCostoPlanilla.php',success:Success},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:260,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Prorrateo Horas - Costos'}};
	
	// -------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_empleado_planilla:maestro.id_empleado_planilla,
				id_resumen_horario_mes:maestro.id_resumen_horario_mes
			}
		};
		this.btnActualizar();
		
		// iniciarEventosFormularios();
        cmpId_gestion=getComponente('id_gestion');
	    cmpPresupuesto=getComponente('id_presupuesto');
	    g_id_gestion=maestro.id_gestion;
	    cmpPresupuesto.store.baseParams={m_sw_rendicion:'si',sw_inv_gasto:'si',id_gestion:g_id_gestion};
        cmpPresupuesto.modificado=true;
		Atributos[1].defecto=maestro.id_empleado_planilla;
        Atributos[14].defecto=maestro.id_resumen_horario_mes;
		paramFunciones.btnEliminar.parametros='&id_empleado_planilla='+maestro.id_empleado_planilla+'&id_resumen_horario_mes='+maestro.id_resumen_horario_mes+'&id_gestion='+maestro.id_gestion;
		paramFunciones.Save.parametros='&id_empleado_planilla='+maestro.id_empleado_planilla+'&id_resumen_horario_mes='+maestro.id_resumen_horario_mes+'&id_gestion='+maestro.id_gestion;
		paramFunciones.ConfirmSave.parametros='&id_empleado_planilla='+maestro.id_empleado_planilla+'&id_resumen_horario_mes='+maestro.id_resumen_horario_mes+'&id_gestion='+maestro.id_gestion;

		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones)
		
	};
	
	// Para manejo de eventos
	function iniciarEventosFormularios(){	
	// para iniciar eventos en el formulario
	       
	    
	}
	// para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_columna_valor.getLayout()};
	// para el manejo de hijos
	
	this.Init(); // iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	function eliminarSuccess(resp){
		//Ext.MessageBox.hide();
		//ClaseMadre_limpiar();
		ClaseMadre_eliminarSuccess(resp);
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
		
	};
	function Success(resp){	
	//Ext.MessageBox.hide();
	//this.dlgInfo.hide();
	//ClaseMadre_limpiar();
	ClaseMadre_saveSuccess(resp);
	_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
	};
	this.InitFunciones(paramFunciones);
	// para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	/*
	 * layout_columna_valor.getLayout().addListener('layout',this.onResize);
	 * layout_columna_valor.getVentana(idContenedor).on('resize',function(){layout_columna_valor.getLayout().layout()})
	 */
	
	layout_columna_valor.getLayout().addListener('layout',this.onResize);

	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}