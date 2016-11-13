/**
 * Nombre:		  	    pagina_solicitud_viaticos2.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:07
 */
function pagina_vista_tesorero(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	var maestro=new Array;
	var componentes=new Array;
	var fecha=new Date();
	var grid;
	var reporte; //reporte 0:sin reporte, reporte 1: vista previa, reporte 2: reporte oficial
	var cm;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarVistaTesorero.php?'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cuenta_doc',totalRecords:'TotalCount'
		},[		
		'id_cuenta_doc',
		'nro_documento',
		'id_empleado',
		'desc_empleado',
		'estado',
		'fecha_sol',
		'id_cuenta_bancaria',
		'id_cuenta_bancaria_fin',
		'desc_cuenta_bancaria',
		'desc_cuenta_bancaria_fin',
		'id_caja_fin',
		'desc_caja_fin',
		'id_cajero_fin',
		'desc_cajero_fin',
		'tipo_pago_fin',
		'saldo_solicitante',
		'desc_moneda',
		'tipo_cuenta_doc',
		'tipo_pago',
		'motivo',
		'observaciones',
		'nro_deposito',
		'nombre_cheque'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional']),
		baseParams:{estado_repo:'1'}
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
    
    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco','gestion']),
    	baseParams:{m_sw_combo:'combo'}
    });

	function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja_fin']);}
	var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{id_caja} - </b></i>','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

	function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero_fin']);}
	var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
	
	function render_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
	function render_cuenta_bancaria_fin(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria_fin']);}
	
	//var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><b><i><b>Gestión: </b>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
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
		
	function render_saldo_solicitante(value, p, record){
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
	
	// hidden id_cuenta_doc
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_doc'
	};
	
	
	
// txt id_empleado
	Atributos[1]={
			validacion:{
			name:'desc_empleado',
			fieldLabel:'Empleado',
			grid_visible:true,
			grid_editable:false,
			width_grid:250	
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue: 'desc_empleado'
		
	};
	
	// txt estado
	Atributos[2]={
		validacion:{
			name: 'tipo_cuenta_doc', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Tipo',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'tipo_cuenta_doc',
	};


// txt estado
	Atributos[3]={
		validacion:{
			name: 'estado', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'estado',
	};
	
	
// txt nro_documento
	Atributos[4]={
		validacion:{
			name: 'nro_documento', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'No',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:2		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'nro_documento',
	};

// txt motivo
	Atributos[5]={
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
				
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'motivo'
		
	};

// txt observaciones
	Atributos[6]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'observaciones'
		
	};
	Atributos[7]= {
		validacion:{
			name:'fecha_sol',
			fieldLabel:'Fecha de Solicitud',
			grid_visible:true,
			grid_editable:false,
			width_grid:85	
		},
		form:false,
		tipo:'Field',
		filtro_0:false
		
		
	};
	
	Atributos[8]={
				validacion:{
					name:'id_cuenta_bancaria',
					desc:'desc_cuenta_bancaria',
					fieldLabel:'Cuenta Bancaria',
					allowBlank:false,
					emptyText:'Cuenta...',
					store:ds_cuenta_bancaria,
					valueField:'id_cuenta_bancaria',
					displayField:'nro_cuenta_banco',
					queryParam:'filterValue_0',
					filterCol:'INSTIT.nombre#CUENTA.nro_cuenta#AUXILI.codigo_auxiliar#CUEBAN.nro_cuenta_banco',
					typeAhead:false,
					tpl:tpl_cuenta_bancaria,
					forceSelection:false,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					width:200,
					grid_visible:true,
					renderer:render_cuenta_bancaria,
					grid_editable:false
				},
				tipo:'ComboBox',
				save_as:'id_cuenta_bancaria',
				id_grupo:0
			};
		
		//
		Atributos[9]={
				validacion:{
					name:'tipo_pago_fin',
					fieldLabel:'Forma de Pago Saldo',
					allowBlank:false,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','cheque'],['efectivo','efectivo'],['deposito','deposito']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					disabled:false,
					onSelect:function(record){
								componentes[9].setValue(record.data.ID);
								componentes[9].collapse();
								if(record.data.ID=='efectivo'){
									// Despliega el grupo de los datos de la cuenta bancaria
									CM_ocultarGrupo('Datos Pago');
								
									// Oculta los demás grupos
									CM_mostrarGrupo('Finalizacion');
									CM_mostrarGrupo('Datos Caja Finalizacion');
									CM_ocultarGrupo('Datos Cuenta Finalizacion');
									CM_ocultarGrupo('Deposito');
												
											
									// Define como opcionales todos los campos de los grupos no
									// visibles, y como obligatorios el grupo visible
									SiBlancosGrupo(0);
									NoBlancosGrupo(1);
									NoBlancosGrupo(2);
									SiBlancosGrupo(3);
									SiBlancosGrupo(4);
									
								} else if(record.data.ID=='cheque'){
									// Despliega el grupo de los datos de la cuenta bancaria
									CM_ocultarGrupo('Datos Pago');
								
									// Oculta los demás grupos
									CM_mostrarGrupo('Finalizacion');
									CM_ocultarGrupo('Datos Caja Finalizacion');
									CM_mostrarGrupo('Datos Cuenta Finalizacion');
									CM_ocultarGrupo('Deposito');
												
											
									// Define como opcionales todos los campos de los grupos no
									// visibles, y como obligatorios el grupo visible
									SiBlancosGrupo(0);
									NoBlancosGrupo(1);
									SiBlancosGrupo(2);
									NoBlancosGrupo(3);
									SiBlancosGrupo(4);
								} 
								else{
									componentes[9].reset();
									alert('No se puede seleccionar este tipo');
								}
					}
				},
				tipo: 'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'CUDOC.tipo_pago_fin',
				defecto:'cheque',
				id_grupo:1
				
			};
		
		Atributos[10]={
				validacion:{
					name:'id_cuenta_bancaria_fin',
					fieldLabel:'Cuenta Bancaria Fin.',
					allowBlank:false,
					emptyText:'Cuenta...',
					desc:'desc_cuenta_bancaria_fin',
					store:ds_cuenta_bancaria,
					valueField:'id_cuenta_bancaria',
					displayField:'nro_cuenta_banco',
					queryParam:'filterValue_0',
					filterCol:'INSTIT.nombre#CUENTA.nro_cuenta#AUXILI.codigo_auxiliar#CUEBAN.nro_cuenta_banco',
					typeAhead:false,
					tpl:tpl_cuenta_bancaria,
					forceSelection:false,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					minChars:1, // /caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					width:200,
					grid_visible:true,
					grid_editable:false,
					renderer:render_cuenta_bancaria_fin,
					
				},
				tipo:'ComboBox',
				id_grupo:3
			};
		
		Atributos[11]={
				validacion:{
					name:'nro_deposito',
					fieldLabel:'Número Depósito',
					allowBlank:false,
					maxLength:40,
					minLength:0,
					selectOnFocus:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:130,
					width:'100%',
					disabled:false		
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'CUDOC.nro_deposito',
				id_grupo:4
				
			};
		
		Atributos[12]={
				validacion:{
				name:'id_caja_fin',
				fieldLabel:'Caja Fin.',
				allowBlank:false,			
				emptyText:'Caja...',
				desc: 'desc_caja_fin', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_caja,
				valueField: 'id_caja',
				displayField: 'desc_unidad_organizacional',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
				typeAhead:true,
				tpl:tpl_id_caja,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				onSelect:function(record){
					
					componentes[12].setValue(record.data.id_caja);
					componentes[12].collapse();
					componentes[13].reset();
					ds_cajero.baseParams.m_id_caja=record.data.id_caja;
					componentes[13].modificado=true							
				},
				
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_caja,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false	
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
			id_grupo:2
		};
	// txt id_cajero
		Atributos[13]={
				validacion:{
				name:'id_cajero_fin',
				fieldLabel:'Cajero Fin.',
				allowBlank:false,			
				emptyText:'Cajero...',
				desc: 'desc_cajero_fin', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cajero,
				valueField: 'id_cajero',
				displayField: 'desc_empleado',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				typeAhead:true,
				tpl:tpl_id_cajero,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_cajero,
				grid_visible:true,
				grid_editable:false,
				width_grid:130,
				width:'100%',
				disabled:false	
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
			id_grupo:2
		};
		
		Atributos[14]={////////
			validacion:{
				name:'saldo_solicitante',
				fieldLabel:'Saldo Solicitante',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				align:'right',
				grid_indice:-1,
				renderer:render_saldo_solicitante
			},
			tipo:'Field',
			form:false,
			filtro_0:true
		};
		
		Atributos[15]={
				validacion:{
					name:'nombre_cheque',
					fieldLabel:'Nombre Cheque',
					allowBlank:true,
					maxLength:70,
					minLength:0,
					selectOnFocus:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:130,
					width:'100%',
					disabled:false		
				},
				tipo: 'TextField',
				form: true,
				filtro_0:false,
				filterColValue:'CUDOC.nombre_cheque',
				id_grupo:5
				
			};
		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	var titulo;
	titulo='Vista Tesorero';
	
	var config={titulo_maestro:titulo,grid_maestro:'grid-'+idContenedor};
	var layout_tesorero=new DocsLayoutMaestro(idContenedor);
	layout_tesorero.init(config);

	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tesorero,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getGrid=this.getGrid;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getFormulario=this.getFormulario;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
		//editar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',width:'65%',minWidth:350,minHeight:400,	closable:true,titulo:titulo,
		
			grupos:[
			
			{
				tituloGrupo:'Datos Pago',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Finalizacion',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Caja Finalizacion',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Cuenta Finalizacion',
				columna:0,
				id_grupo:3
			}
			,
			{
				tituloGrupo:'Deposito',
				columna:0,
				id_grupo:4
			}
			,
			{
				tituloGrupo:'Datos Cheque',
				columna:0,
				id_grupo:5
			}
			]
		}};
	
		
	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	

	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	for(var i=0; i<Atributos.length; i++)
		{	
			componentes[i]=CM_getComponente(Atributos[i].validacion.name)
		
		}
		grid=CM_getGrid();
		cm=grid.getColumnModel();	
		
	}
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		
			
					
	}	
	
	function btn_edit_nombre_cheque()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
			/*if(SelectionsRecord.data.tipo_cuenta_doc=='rendicion_caja')
			{*/
				// Define el Action para el cambio de estado del registro temporalmente
				CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php'+'?vista=solicitud_viatico&accion=cheque';				
			/*}
			else
			{
				CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionContabilizarSolPag.php?accion=contabilizar_sol_pago';
			}*/
			
			// Verificación del tipo de pago para habilitar la ventana para
			// introducción de los datos faltantes
			if(SelectionsRecord.data.tipo_pago=='cheque')
			{
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_ocultarGrupo('Datos Pago');			
				CM_ocultarGrupo('Finalizacion');
				CM_ocultarGrupo('Datos Caja Finalizacion');
				CM_ocultarGrupo('Datos Cuenta Finalizacion');
				CM_ocultarGrupo('Deposito');
				CM_mostrarGrupo('Datos Cheque');
									
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				SiBlancosGrupo(4);
				NoBlancosGrupo(5); 
				
				// Llamamos a la función sobrecarga del Edit
				CM_btnEdit();			
			} 
			else 
				alert('El pago por caja no permite modificar el nombre del cheque');
		} 
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	
	function btn_cont_sol_pag()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
			if(SelectionsRecord.data.tipo_cuenta_doc=='rendicion_caja'){
				// Define el Action para el cambio de estado del registro temporalmente
				CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php'+'?vista=rendicion_caja&accion=generar_reposicion';
				
			}
			else{
				CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionContabilizarSolPag.php?accion=contabilizar_sol_pago';
			}
			// Verificación del tipo de pago para habilitar la ventana para
			// introducción de los datos faltantes
			if(SelectionsRecord.data.tipo_pago=='cheque')
			{
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_mostrarGrupo('Datos Pago');
			
				// Oculta los demás grupos
				CM_ocultarGrupo('Finalizacion');
				CM_ocultarGrupo('Datos Caja Finalizacion');
				CM_ocultarGrupo('Datos Cuenta Finalizacion');
				CM_ocultarGrupo('Deposito');
				CM_ocultarGrupo('Datos Cheque');
									
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				NoBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				SiBlancosGrupo(4);
				SiBlancosGrupo(5);
				
				// Llamamos a la función sobrecarga del Edit
				CM_btnEdit();			
			} 
			else 
				alert('El pago por caja no deberia pasar por esta etapa');
			
		} 
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
		
	
	
	function btn_fin()
	{
		//Finalización definitiva
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1){
			if(confirm('¿Está seguro de Finalizar el registro?')){
				Ext.Ajax.request({
					url:direccion+"../../../control/cuenta_doc/ActionFinalizarCuentaDoc.php",
					method:'POST',
					params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc},
					success:esteSuccess,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});			
			}
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	
	
	function btn_cue_dep()
	{
		//Registro de cuenta bancaria cuando el saldo es a favor del solicitante, y cuenta bancaria y depósito cuando el saldo es a favor de la empresa
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			//Verifica si el saldo es distinto de cero, si es cero no permite hacer el registro
			var aux=parseFloat(SelectionsRecord.data.saldo_solicitante);
			// Define el Action para el cambio de estado del registro temporalmente
			CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionRegistrarCuentaDepositoFin.php';
			
			if(aux==0){
				Ext.MessageBox.alert('Operación no permitida','El saldo es cero. Proceda directamente con la Finalización.');
				return;
			}
			else if(aux<0){
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_ocultarGrupo('Datos Pago');
			
				// Oculta los demás grupos
				CM_ocultarGrupo('Finalizacion');
				CM_ocultarGrupo('Datos Caja Finalizacion');
				CM_mostrarGrupo('Datos Cuenta Finalizacion');
				CM_mostrarGrupo('Deposito');
				CM_ocultarGrupo('Datos Cheque');
							
						
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				NoBlancosGrupo(3);
				SiBlancosGrupo(5);
				if(componentes[10].getValue()!=undefined && componentes[10].getValue()!=''){
					NoBlancosGrupo(4);
				}
				else{
					SiBlancosGrupo(4);
				}
				componentes[9].setValue('deposito')
				
			}
			else{
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_ocultarGrupo('Datos Pago');
			
				// Oculta los demás grupos
				CM_mostrarGrupo('Finalizacion');
				CM_ocultarGrupo('Datos Caja Finalizacion');
				CM_ocultarGrupo('Datos Cuenta Finalizacion');
				CM_ocultarGrupo('Deposito');
				CM_ocultarGrupo('Datos Cheque');
							
						
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				SiBlancosGrupo(0);
				NoBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				SiBlancosGrupo(4);
				SiBlancosGrupo(5);
						
			}
			
			
			//Verifica si se ha llenado ya el tipo_pago_fin para mostrar los datos
			var strTipoPagoFin=SelectionsRecord.data.tipo_pago_fin;
			
			if(strTipoPagoFin!=''){
				if(strTipoPagoFin=='efectivo'){
					// Despliega el grupo de los datos de la cuenta bancaria
					CM_ocultarGrupo('Datos Pago');
				
					// Oculta los demás grupos
					CM_mostrarGrupo('Finalizacion');
					CM_mostrarGrupo('Datos Caja Finalizacion');
					CM_ocultarGrupo('Datos Cuenta Finalizacion');
					CM_ocultarGrupo('Deposito');
					CM_ocultarGrupo('Datos Cheque');
								
							
					// Define como opcionales todos los campos de los grupos no
					// visibles, y como obligatorios el grupo visible
					SiBlancosGrupo(0);
					NoBlancosGrupo(1);
					NoBlancosGrupo(2);
					SiBlancosGrupo(3);
					SiBlancosGrupo(4);
					SiBlancosGrupo(5);
				}else if(strTipoPagoFin=='cheque'){
					// Despliega el grupo de los datos de la cuenta bancaria
					CM_ocultarGrupo('Datos Pago');
				
					// Oculta los demás grupos
					CM_mostrarGrupo('Finalizacion');
					CM_ocultarGrupo('Datos Caja Finalizacion');
					CM_mostrarGrupo('Datos Cuenta Finalizacion');
					CM_ocultarGrupo('Deposito');
					CM_ocultarGrupo('Datos Cheque');
								
							
					// Define como opcionales todos los campos de los grupos no
					// visibles, y como obligatorios el grupo visible
					SiBlancosGrupo(0);
					NoBlancosGrupo(1);
					SiBlancosGrupo(2);
					NoBlancosGrupo(3);
					SiBlancosGrupo(4);
					SiBlancosGrupo(5);
				} else if(strTipoPagoFin=='deposito'){
					// Despliega el grupo de los datos de la cuenta bancaria
					CM_ocultarGrupo('Datos Pago');
				
					// Oculta los demás grupos
					CM_ocultarGrupo('Finalizacion');
					CM_ocultarGrupo('Datos Caja Finalizacion');
					CM_mostrarGrupo('Datos Cuenta Finalizacion');
					CM_mostrarGrupo('Deposito');
					CM_ocultarGrupo('Datos Cheque');
											
					// Define como opcionales todos los campos de los grupos no
					// visibles, y como obligatorios el grupo visible
					SiBlancosGrupo(0);
					SiBlancosGrupo(1);
					SiBlancosGrupo(2);
					NoBlancosGrupo(3);
					SiBlancosGrupo(5);
					if(componentes[10].getValue()!=undefined && componentes[10].getValue()!=''){
						NoBlancosGrupo(4);
						//alert(componentes[10].getValue());
					}
					else{
						SiBlancosGrupo(4);
						//alert('entra2');
					}
				}
			}
			
			//Verifica el saldo del solicitante para desplegar una alerta
			var saldoSolic=parseFloat(SelectionsRecord.data.saldo_solicitante);
			if(saldoSolic<0){
				alert('Saldo a favor de la Empresa: '+saldoSolic*(-1));
			} else if(saldoSolic>0){
				alert('Saldo a favor del Solicitante: '+saldoSolic);
			} else{
				alert('No hay saldo');
				return;
			}

			// Llamamos a la función sobrecarga del Edit
			CM_btnEdit();
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
		
	}
	
	
	function esteSuccess(resp)
	{
		Ext.MessageBox.hide();
				if(resp.responseXML&&resp.responseXML.documentElement)
				{
					if(reporte==2 || reporte==1)
						btn_reporte();
					
					ClaseMadre_btnActualizar();
				}
				else
				{
					ClaseMadre_conexionFailure();
				}
	}
	
	
	function btn_reporte()
	{
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
					if(SelectionsRecord.data.tipo_cuenta_doc=='rendicion_caja'){
						var data='id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
						data= data + '&tipo_vista=avance';	
					}else{
						var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
						data= data + '&estado=oficial';	
					}
					  				    
					switch (SelectionsRecord.data.tipo_cuenta_doc)
					{
						case 'solicitud_viatico': 
						 	window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolViaje.php?'+data);
						 	 break;
						case 'solicitud_avance':
						 	window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolicitudFondos.php?'+data)
						 	 break;
						case 'ampliacion_viatico':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolViaje.php?'+data);
							break;
						case 'ampliacion_avance':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolicitudFondos.php?'+data);
							break;
						case 'rendicion_caja':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data);
							break;							
						 	
					}
				
					}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	 
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_viaticos2.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
	this.AdicionarBoton('../../../lib/imagenes/editar.png','Editar nombre del cheque',btn_edit_nombre_cheque,false,'edit_nombre_cheque','');	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Reporte de Solicitud o Rendicion',btn_reporte,true,'imp_ejecucion','Reporte');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Contabilizar Pago',btn_cont_sol_pag,false,'cont_sol_pago','Contabilizar Pago');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Registrar Datos Finalizacion',btn_cue_dep,false,'cue_dep','Datos Finalizacion');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar',btn_fin,false,'sol_fin','Finalizar');
	
	
	
	function bloquearBotones()
	{
		
		CM_getBoton('edit_nombre_cheque-'+idContenedor).disable();
		CM_getBoton('cont_sol_pago-'+idContenedor).disable();
		
		CM_getBoton('sol_fin-'+idContenedor).disable();
		CM_getBoton('cue_dep-'+idContenedor).disable();				
		
	}
	
	
	function enable(sm,row,rec)
	{
		bloquearBotones();
		cm_EnableSelect(sm,row,rec);
		if(rec.data.tipo_cuenta_doc=='rendicion_caja')
		{
			CM_getBoton('edit_nombre_cheque-'+idContenedor).enable();
			CM_getBoton('cont_sol_pago-'+idContenedor).enable();
			CM_getBoton('sol_fin-'+idContenedor).enable();
			CM_getBoton('cue_dep-'+idContenedor).enable();
		}
		else
		{
			if(rec.data.estado=='en_finaliz')
			{
				CM_getBoton('sol_fin-'+idContenedor).enable();
				CM_getBoton('cue_dep-'+idContenedor).enable();
			}
			else
			{
				CM_getBoton('edit_nombre_cheque-'+idContenedor).enable();
				CM_getBoton('cont_sol_pago-'+idContenedor).enable();
			}
		}				
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tesorero.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}