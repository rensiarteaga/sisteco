/**
 * Nombre:		  	    pagina_partida_modificacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-05-10 18:19:16
 */

function pagina_partida_modificacion_dest(idContenedor,idContenedorPadre,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0,ds2;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_modificacion/ActionListarPartidaModificacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_partida_modificacion',totalRecords:'TotalCount'
		},[		
		'id_partida_modificacion',
		'id_modificacion',
		'id_partida_presupuesto',
		'id_usuario_autorizado',
		'desc_usuario_autorizado',
		'id_partida_ejecucion',
		'tipo_modificacion',
		'id_moneda',
		'desc_moneda',
		'importe',
		'estado',
		'id_usuario_reg',
		'desc_usuario_reg',
		'fecha_reg',		
		'id_partida',
		'desc_partida',				
		'id_presupuesto',
		'desc_presupuesto',
		'desc_disponibilidad'
		]),remoteSort:true});

	//DATA STORE COMBOS
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });
    
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo'])
	});	
	
	var ds_usuario_autorizado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional'])
			
	});	
	
	var ds_usuario_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional'])
			
	});	

	//FUNCIONES RENDER
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{desc_par}</i></b>','</div>');
		
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');																										
				
	function render_id_usuario_autorizado(value, p, record){return String.format('{0}', record.data['desc_usuario_autorizado']);}
	var tpl_id_usuario_autorizado=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b>','<br><FONT COLOR="#B5A642"><b>Unidad Org.: </b>{desc_unidad_organizacional}</FONT>','</div>');	
	
	function render_id_usuario_reg(value, p, record){return String.format('{0}', record.data['desc_usuario_reg']);}
	var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b>','<br><FONT COLOR="#B5A642"><b>Unidad Org.: </b>{desc_unidad_organizacional}</FONT>','</div>');

	function formatoImporte(num){  
			 var cadena = ""; var aux;  
			 var cont = 1,m,k;  
			   
			 if(num<0) aux=1; else aux=0;  
			 num=num.toString();  
		   
			 for(m=num.length-1; m>=0; m--){
				 cadena = num.charAt(m) + cadena;  
				 if(num.charAt(m)!='.'){
				   
					 if(cont%3 == 0 && m >aux)  cadena = "," + cadena; else cadena = cadena;  
				   
					 if(cont== 3) cont = 1; else cont++;  
				 } else{
					 cont = 1;
				 }
			 }  
			 return cadena;  
		}
		
		function render_importe(value, p, record)
		{
			var num=formatoImporte(value);
			if(value<0){
				return String.format('{0}', '<FONT COLOR="#FF0000"><b>'+num+'</b></FONT>');
			} else if(value>0){
				return String.format('{0}', '<FONT COLOR="#0000FF"><b>'+num+'</b></FONT>');
			} else{
				return String.format('{0}', '<b>'+num+'</b>');
			}
		}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_modificacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_modificacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt id_modificacion
	Atributos[1]={
		validacion:{
			name:'id_modificacion',
			fieldLabel:'Id Modificación',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		defecto:maestro.id_modificacion,
		id_grupo:0,
		filterColValue:'PARMOD.id_modificacion'
		
	};
// txt id_partida_presupuesto
	Atributos[2]={
		validacion:{
			name:'id_partida_presupuesto',
			fieldLabel:'Id Partida Presupuesto',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PARMOD.id_partida_presupuesto'		
	};		
	
// txt id_partida_ejecucion
	Atributos[3]={
		validacion:{
			name:'id_partida_ejecucion',
			fieldLabel:'id Partida Ejecucion',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'PARMOD.id_partida_ejecucion'		
	};
	
// txt tipo_modificacion
	Atributos[4]={
		validacion:{
			name:'tipo_modificacion',
			fieldLabel:'Tipo Modificación',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		defecto:'Incremento',
		id_grupo:0,
		filterColValue:'PARMOD.tipo_modificacion'		
	};	
	
	Atributos[5]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupuesto',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',//desc_presupuesto_destino  desc_unidad_organizacional
			queryParam: 'filterValue_0',			
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',		
			typeAhead:true,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false//,
			//grid_indice:13		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'PRESUP.desc_presupuesto',
		save_as:'id_presupuesto'
	};		
	
	/*Atributos[6]={
			validacion:{
 			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			//emptyText:'Partida',
			desc: 'desc_partida', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:3,
			editable:true,
			renderer:render_id_partida,
 			grid_visible:true,
 			grid_editable:false,
			width_grid:200,
			lazyRender:true,
      		width:300,
			disabled:true//,
			//grid_indice:9		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};	*/
	
	Atributos[6]={				//gasto
		validacion:{
			name:'id_partida_gasto',
			desc:'desc_partida',
			fieldLabel:'Partida',
			allowBlank:true,
			valueField: 'id_partida',
			tipo:'gasto',//determina el action a llamar
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			//vtype:"texto",
			grid_visible:false,
			grid_editable:false,
			renderer:render_id_partida,
			width_grid:200,			
			width:300,
			pageSize:10,
			direccion:direccion
			//grid_indice:14
		},
		tipo:'LovPartida',
		form: true,
		filtro_0:true,
		id_grupo:1,		
		save_as:'id_partida_gasto'
	};
	
	
	Atributos[7]={				//ingreso
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida.',
			allowBlank:true,
			valueField: 'id_partida',
			tipo:'ingreso',//determina el action a llamar
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			//vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_partida,
			width_grid:200,			
			width:300,
			pageSize:10,
			direccion:direccion
			//grid_indice:14
		},
		tipo:'LovPartida',
		form: true,
		filtro_0:true,
		id_grupo:1		
		//save_as:'id_partida'
	};
	
	//moneda
	Atributos[8]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			align:'left',
			renderer:render_id_moneda	
		},
		tipo: 'Field',
		filtro_0:false
		
	};

	/*Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Mon...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:200,
			disabled:false//,
			//grid_indice:11					
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:1,	
		//defecto:maestro.id_moneda,	
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	*/	
	
// txt importe

	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'importe',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			align:'right',
			renderer:render_importe	
		},
		tipo: 'Field',
		filtro_0:false
		
	};

	/*Atributos[9]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe',
			allowBlank:false,
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
			width:100,
			disabled:false,
			renderer:render_importe			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'PARMOD.importe'		
	};*/
	
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_autorizado',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,			
			renderer:render_id_usuario_autorizado
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	
	/*Atributos[10]={
			validacion:{
			name:'id_usuario_autorizado',
			fieldLabel:'Responsable Presupuesto',
			allowBlank:false,			
			//emptyText:'Usuario autorizado',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_autorizado,
			valueField: 'id_usuario_autorizado',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#UNIORG.nombre_unidad',
			typeAhead:true,			
			tpl:tpl_id_usuario_autorizado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_autorizado,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			//grid_indice:7,
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usuario_autorizado'
	};	*/
	
// txt estado
	Atributos[11]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'PARMOD.estado'		
	};	
	
	// txt tipo_modificacion
	Atributos[12]={
		validacion:{
			name:'desc_disponibilidad',
			fieldLabel:'Disponibilidad',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false			
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false		
		//id_grupo:0,
		//filterColValue:'PARMOD.tipo_modificacion'		
	};	
	
	Atributos[13]={
			validacion:{
			name:'id_usuario_reg',
			fieldLabel:'Responsable Registro',
			allowBlank:true,			
			emptyText:'Usuario registro...',
			desc: 'desc_usuario_reg', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_reg,
			valueField: 'id_usuario_autorizado',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_reg,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false//,
			//grid_indice:17		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PERSON3.apellido_paterno#PERSON3.apellido_materno#PERSON3.nombre',
		save_as:'id_usu_autorizado_reg'
	};
	
// txt fecha_reg
	Atributos[14]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'PARMOD.fecha_reg',
	};
			
		
	//alert ('llega a la vista3');

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Partida Modificación',grid_maestro:'grid-'+idContenedor};
	var layout_partida_modificacion_dest=new DocsLayoutMaestro(idContenedor);
	layout_partida_modificacion_dest.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_partida_modificacion_dest,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getComponente=this.getComponente;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;


	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/partida_modificacion/ActionEliminarPartidaModificacion.php'},
		Save:{url:direccion+'../../../control/partida_modificacion/ActionGuardarPartidaModificacion.php'},
		ConfirmSave:{url:direccion+'../../../control/partida_modificacion/ActionGuardarPartidaModificacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:480,
		width:900
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Incremento',
		grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:1
			}			
			]
		}};
		
	
 		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params)
	{			
		////////////////////////////
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_modificacion=datos.id_modificacion;
		//maestro.id_moneda=datos.id_moneda;
		maestro.id_parametro=datos.id_parametro;
		maestro.tipo_presupuesto=datos.tipo_presupuesto;
		maestro.id_gestion=datos.id_gestion;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_modificacion:maestro.id_modificacion,
				tipo_modificacion:"'Incremento'"
			}
		};		

		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();		
				
		this.btnActualizar();		
		
		Atributos[1].defecto=maestro.id_modificacion;
		componentes[5].store.baseParams={sw_traspaso:'si',m_id_parametro:maestro.id_parametro,m_tipo_pres:maestro.tipo_presupuesto};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
					
		//vectorAtributos[4].defecto=maestro.id_correspondencia;
		
		paramFunciones.btnEliminar.parametros='&id_modificacion='+maestro.id_modificacion+'&id_tipo_presupuesto='+maestro.tipo_presupuesto;
		paramFunciones.Save.parametros='&id_modificacion'+maestro.id_modificacion+'&id_tipo_presupuesto='+maestro.tipo_presupuesto;
		paramFunciones.ConfirmSave.parametros='&id_modificacion='+maestro.id_modificacion+'&id_tipo_presupuesto='+maestro.tipo_presupuesto;
		this.InitFunciones(paramFunciones)		
	};
				
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
/*
	this.btnNew=function()
	{		
		CM_ocultarGrupo('Oculto');	
		
		if(maestro.tipo_presupuesto == 1 || maestro.tipo_presupuesto == 4)
		{
				CM_mostrarComponente(componentes[7]);
				CM_ocultarComponente(componentes[6]);				
				componentes[7].setDisabled(true);
				componentes[6].setDisabled(false);				
		}
		else
		{
				CM_ocultarComponente(componentes[7]);
				CM_mostrarComponente(componentes[6]);
				componentes[6].setDisabled(true);
				componentes[7].setDisabled(false);						
		}	
		

		componentes[8].setDisabled(true);
		ClaseMadre_btnNew();
		ds2.rejectChanges();
		ds2.removeAll();
	}
	
	this.btnEdit=function()
    {
    	CM_ocultarGrupo('Oculto');
    	
    	if(maestro.tipo_presupuesto == 1 || maestro.tipo_presupuesto == 4)
		{
				CM_mostrarComponente(componentes[7]);
				CM_ocultarComponente(componentes[6]);
				componentes[7].setDisabled(true);
				componentes[6].setDisabled(false);				
		}
		else
		{
				CM_ocultarComponente(componentes[7]);
				CM_mostrarComponente(componentes[6]);
				componentes[6].setDisabled(true);
				componentes[7].setDisabled(false);
		}
    	
		componentes[8].setDisabled(true);
		ClaseMadre_btnEdit();	
    }*/
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario
		CM_ocultarGrupo('Oculto');
		componentes[6].setDisabled(true); //gasto
		componentes[7].setDisabled(true); //recurso
		componentes[8].setDisabled(true);
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	
	function InitPaginaPartidaModificacionDest()
    {							
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
    	
    	componentes[5].store.baseParams={sw_traspaso:'si',m_id_parametro:maestro.id_parametro,m_tipo_pres:maestro.tipo_presupuesto};  //,m_id_unidad_organizacional:record.data.id_unidad_organizacional
//			
		componentes[6].setDisabled(true); //gasto
		componentes[7].setDisabled(true); //recurso	
		componentes[8].setDisabled(true);						
		
		componentes[5].on('select',evento_presupuesto); //presupuesto
	}
	
	function evento_presupuesto( combo, record, index )
	{
			//combo partida
			//componentes[6].store.baseParams={sw_traspaso:'si',m_id_presupuesto:record.data.id_presupuesto,m_id_gestion:maestro.id_gestion};
						
			if(maestro.tipo_presupuesto == 1 || maestro.tipo_presupuesto == 4)
			{
				componentes[7].store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:maestro.id_gestion};
				CM_mostrarComponente(componentes[7]);
				CM_ocultarComponente(componentes[6]);
				componentes[7].modificado=true;		
				componentes[7].setValue('');
				componentes[7].allowBlank=true;			
				componentes[6].setDisabled(true);
				componentes[7].setDisabled(false);					
			}
			else
			{
				componentes[6].store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:maestro.id_gestion};
				CM_ocultarComponente(componentes[7]);
				CM_mostrarComponente(componentes[6]);	
				componentes[6].modificado=true;		
				componentes[6].setValue('');			
				componentes[6].allowBlank=true;
				componentes[6].setDisabled(false);
				componentes[7].setDisabled(true);				
			}			
			
			componentes[8].setDisabled(true);
			componentes[6].on('select',evento_partida); //partida
			componentes[7].on('select',evento_partida); //partida
			
		//	grid2.stopEditing();
		  // ds2.rejectChanges();
		   //ds2.removeAll();
			
			
			//combo responsable origen
			/*componentes[10].store.baseParams={sw_responsable:'si',id_unidad_organizacional:record.data.id_unidad_organizacional};
			componentes[10].modificado=true;		
			componentes[10].setValue('');
			componentes[10].setDisabled(false);	*/		
 	}
 	 	
 	function evento_partida (combo, record, index)
 	{
 		/*componentes[8].setDisabled(false);
 		 		
 		componentes[8].on('select',evento_moneda); //moneda*/
 		
 		var parlocal={
			start:0,
			limit: paramConfig.TamanoPagina,
			id_presupuesto:componentes[5].getValue(),
			id_partida:componentes[6].getValue(),
			id_moneda:componentes[8].getValue()
		}
 		if(maestro.tipo_presupuesto == 1 || maestro.tipo_presupuesto == 4){ 		
			parlocal.id_partida=componentes[7].getValue();
		}
		
		//ds2.load(parlocal);
 	}
 	
 	/*function evento_moneda (combo, record, index)
 	{
 		if(maestro.tipo_presupuesto == 1 || maestro.tipo_presupuesto == 4)
		{ 		
			window.open(direccion+'../../../control/presupuesto_vigente/ActionListarPresupuestoVigente.php?id_presupuesto='+componentes[5].getValue()+'&id_partida='+componentes[7].getValue()+'&id_moneda='+componentes[8].getValue());
		}
		else
		{
			window.open(direccion+'../../../control/presupuesto_vigente/ActionListarPresupuestoVigente.php?id_presupuesto='+componentes[5].getValue()+'&id_partida='+componentes[6].getValue()+'&id_moneda='+componentes[8].getValue());
		}
 	}*/
 		
	//alert ('llega a la vista5');
	/*
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_partida_modificacion_dest.getLayout()};
	//alert ('llega a la vista5.1');
	this.Init(); //iniciamos la clase madre
	
	//alert ('llega a la vista5.2');
	
	this.InitBarraMenu(paramMenu);
	
	//alert ('llega a la vista5.3');
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//carga datos XML
	
	//alert ('llega a la vista6');
	

	//para agregar botones		
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data['estado']=='Borrador')//en_rendicion
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();									
		}		
		if(rec.data['estado']=='Validado')//conta_rendicion
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();									
		}		
	}
		
	//this.iniciaFormulario();
	
	/*
		////////////////////
	//var fm = Ext.form
	var Ed=Ext.grid.GridEditor;
	
	 function formatBoolean(value){
        return value ? 'Yes' : 'No';  
    };

    // the column model has information about grid columns
    // dataIndex maps the column to the specific data field in
    // the data store (created below)
    var cmol = new Ext.grid.ColumnModel(
        [
         {
           header: "Descripción",
           dataIndex: 'descripcion',
           width: 220
        },
        {
           header: "ENE",
           dataIndex: 'mes_01',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "FEB",
           dataIndex: 'mes_02',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "MAR",
           dataIndex: 'mes_03',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "ABR",
           dataIndex: 'mes_04',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "MAY",
           dataIndex: 'mes_05',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
       
        {
           header: "JUN",
           dataIndex: 'mes_06',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "JUL",
           dataIndex: 'mes_07',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "AGO",
           dataIndex: 'mes_08',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "SEP",
           dataIndex: 'mes_09',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "OCT",
           dataIndex: 'mes_10',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
         {
           header: "NOV",
           dataIndex: 'mes_11',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "DIC",
           dataIndex: 'mes_12',
           width: 40,
           editor: new  Ext.grid.GridEditor(new Ext.form.NumberField({
               allowBlank: false
           }))
        },
        {
           header: "TOTAL",
           dataIndex: 'total',
           width: 40
        }
        
        
        ]);

    // by default columns are sortable
    cmol.defaultSortable = false;

  
    
    
    	//---DATA STORE
	 ds2 = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto_vigente/ActionListarPresupuestoVigente.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_partida_detalle_modificacion',totalRecords:'TotalCount'
		},[		
		  'descripcion',
			{name:'mes_01' ,mapping: 'mes_01', type: 'float'},
			{name:'mes_02' ,mapping: 'mes_02', type: 'float'},
			{name:'mes_03' ,mapping: 'mes_03', type: 'float'},
			{name:'mes_04' ,mapping: 'mes_04', type: 'float'},
			{name:'mes_05' ,mapping: 'mes_05', type: 'float'},
			{name:'mes_06' ,mapping: 'mes_06', type: 'float'},
			{name:'mes_07' ,mapping: 'mes_07', type: 'float'},
			{name:'mes_08' ,mapping: 'mes_08', type: 'float'},
			{name:'mes_09' ,mapping: 'mes_09', type: 'float'},
			{name:'mes_10' ,mapping: 'mes_10', type: 'float'},
			{name:'mes_11' ,mapping: 'mes_11', type: 'float'},
			{name:'mes_12' ,mapping: 'mes_12', type: 'float'},
			{name:'total' ,mapping: 'total', type: 'float'},
			'fila'
           
		]),remoteSort:false});
   
    

    
	this.iniciaFormulario({width:800,legend:'Distribución Partida Origen', id:'grilla_adicional_dest'});
   
    
     Ext.get('grilla_adicional_dest').createChild({
        tag:'div', 
        id:'grid-adicional2_dest',
        style:"border:1px solid #99bbe8;overflow: hidden; width: 790px; height: 100px;position:relative;left:0;top:0;"
      
    });
    
   
    var grid2 = new Ext.grid.EditorGrid('grid-adicional2_dest', {
        ds: ds2,
        cm: cmol,
        enableColLock:false
    });
    grid2.render();
    
    
    grid2.on('beforeedit',function(e){
    	
    
      if(e.record.data.fila=='total'||e.record.data.fila=='vigente'){
       
      	return false
      }else{
      	
      	return true
      	
      }
    
    
    })
    
     grid2.on('validateedit',function(e){
    	
     if( e.value <= ds2.getAt(0).data[e.field] && e.record.data.fila!='total' ){
		    	
		    	
		     	ds2.commitChanges()
		    	total_restante(e);
    	     	return true
		     }
		    else{
		        if(e.record.data.fila=='total'){
		        	
		        	return true
		        }
		        else{
		    	
		    	 return false
		        }
		    }
    })
    	
     ds2.on('update',function(e){
      	total_reformulacion(e);
		
		ds2.commitChanges()    	
     	
     })
    
    
    
  function total_reformulacion(e){
  	
  	var rec = ds2.getAt(1);
    	rec.data['total'] = parseFloat(rec.data['mes_01'])+ parseFloat(rec.data['mes_02']) + parseFloat(rec.data['mes_03']) + parseFloat(rec.data['mes_04']) + parseFloat(rec.data['mes_05']) + parseFloat(rec.data['mes_06']) + parseFloat(rec.data['mes_07']) + parseFloat(rec.data['mes_08']) + parseFloat(rec.data['mes_09']) + parseFloat(rec.data['mes_10']) + parseFloat(rec.data['mes_11']) + parseFloat(rec.data['mes_12']);
    	ds2.getAt(2).set('total',parseFloat(ds2.getAt(0).data['total'])-rec.data['total']);
    	ds2.commitChanges()
    }
    
    function total_restante(e){
   
    	var rec1 = ds2.getAt(0);
     	ds2.getAt(2).set(e.field,parseFloat(rec1.data[e.field])-parseFloat(e.value));
    	ds2.getAt(2).commit() 
    	//ds2.loadData()
    	ds2.commitChanges()
  
    }
		
    
    
    
 
	////////////
	
	//RAC: agrega grilla formulario
	
	
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_modificacion:maestro.id_modificacion,
			tipo_modificacion:"'Incremento'"
		}
	});
		
	InitPaginaPartidaModificacionDest();
	iniciarEventosFormularios();	
	layout_partida_modificacion_dest.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	
	_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
		
	_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);*/
	
}