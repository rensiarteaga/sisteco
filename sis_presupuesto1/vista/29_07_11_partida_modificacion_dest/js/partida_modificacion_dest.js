/**
 * Nombre:		  	    pagina_partida_modificacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-05-10 18:19:16
 */



function pagina_partida_modificacion_dest(idContenedor,idContenedorPadre,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0;
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

	Atributos[8]={
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
	};		
	
// txt importe
	Atributos[9]={
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
	};
	
	Atributos[10]={
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
	};	
	
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
		height:400,
		width:480,
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
				   	
		ClaseMadre_btnNew();
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
    	
		ClaseMadre_btnEdit();	
    }
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario
		CM_ocultarGrupo('Oculto');
		componentes[6].setDisabled(true); //gasto
		componentes[7].setDisabled(true); //recurso
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
		componentes[10].setDisabled(true);			
		
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
						
			//combo responsable origen
			componentes[10].store.baseParams={sw_responsable:'si',id_unidad_organizacional:record.data.id_unidad_organizacional};
			componentes[10].modificado=true;		
			componentes[10].setValue('');
			componentes[10].setDisabled(false);			
 	}
 		
	//alert ('llega a la vista5');
	
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
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_modificacion:maestro.id_modificacion,
			tipo_modificacion:"'Incremento'"
		}
	});
		
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
	
	
	this.iniciaFormulario();
	InitPaginaPartidaModificacionDest();
	iniciarEventosFormularios();	
	layout_partida_modificacion_dest.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	
	_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
		
	_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}