/**
* Nombre:		  	    pagina_eeff_linea.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_eeff_linea(idContenedor,direccion,paramConfig,idContenedorPadre)
{        
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff_compara/ActionListarEeffLinea.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_eeff_linea',totalRecords:'TotalCount'
		},[
		'id_eeff_linea',
		'id_eeff',
		'linea_nro',
		'id_cuenta_act',
		'descta_act',
		'id_cuenta_uno',
		'descta_ant',
		'linea_letra',
		'linea_dato',
		'linea_saldo',
		'linea_n',
		'linea_s',
		'linea_t',
		'linea_b',
		'id_eeff_nota',
		'nota_nro',
		'linea_desope',
		'linea_impre'
		]),remoteSort:true
	});

	var ds_cuenta_act = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux'])});
	
	var ds_cuenta_ant = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux'])});
	
	var ds_eeff_nota = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff_compara/ActionListarEeffNota.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_eeff_nota',totalRecords: 'TotalCount'},
	    ['id_eeff_nota','id_eeff','nota_nro','nota_texto'])});
	
	//FUNCIONES RENDER
	function render_dato(value, p, record){	
		if(value==1){return 'CUENTA';}
		if(value==2){return 'TOTAL';}
		if(value==3){return 'OPERACION';}
	}
	
	function render_borde(value, p, record){	
		if(value==1){return 'NINGUNO';}
		if(value==2){return 'SIMPLE';}
		if(value==3){return 'DOBLE';}
	}
	
	function render_letra(value, p, record){	
		if(value==1){return 'MAYUSCULA';}
		if(value==2){return 'Minúscula';}		
	}
	
	function render_sino(value, p, record){	
		if(value==1){return 'NO';}
		if(value==2){return 'SI';}		
	}
	
	function render_tab(value, p, record){	
		if(value==0){return '0';}
		if(value==1){return '1';}
		if(value==2){return '2';}		
	}
	
	function render_id_cuenta_act(value, p, record){return String.format('{0}', record.data['descta_act']);}
	var tpl_id_cuenta_act=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_cuenta_ant(value, p, record){return String.format('{0}', record.data['descta_ant']);}
	var tpl_id_cuenta_ant=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_eeff_nota(value, p, record){return String.format('{0}', record.data['nota_nro']);}
	var tpl_id_eeff_nota=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nota_nro}</FONT><br>','<FONT COLOR="#000000">{nota_texto}</FONT><br>','</div>');
	
	///////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_eeff_linea',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_eeff_linea'
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_eeff',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_eeff'
	};
	
	Atributos[2]={
		validacion:{
			name:'linea_nro',
			fieldLabel:'Nro.(despues de)',
			allowBlank:false,
			allowDecimals:false,
			maxLength:10,
			minLength:1,
			selectOnFocus:true,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:50,
			disabled:false
		},
		tipo: 'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'EFL.linea_nro',
		save_as:'linea_nro',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
			name:'linea_dato',
			fieldLabel:'Clase',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cuenta','CUENTA'],['total','TOTAL'],['operacion','OPERACION']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_dato,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_dato'
	};
	
	Atributos[4]={
		validacion:{
 			name:'id_cuenta_act',
			fieldLabel:'Cuenta Vigente',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'descta_act', 		
			store:ds_cuenta_act,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta_act,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta_act,
 			grid_visible:true,
 	 		grid_editable:true,
			width_grid:300,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0,
		save_as:'id_cuenta_act'
	};
	
	Atributos[5]={
		validacion:{
 			name:'id_cuenta_uno',
			fieldLabel:'Cuenta Anterior',
			allowBlank:true,			
			emptyText:'Cuenta...',
			desc: 'descta_ant', 		
			store:ds_cuenta_ant,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta_ant,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta_ant,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:300,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		id_grupo:0,
		save_as:'id_cuenta_uno'
	};
	
	Atributos[6]={
		validacion:{
			name:'linea_saldo',
			fieldLabel:'Con Saldo',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'NO'],[2,'SI']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_saldo'
	};
	
	Atributos[7]={
		validacion:{
			name:'linea_letra',
			fieldLabel:'Letra',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'MAYUSCULA'],[2,'Minúscula']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_letra,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_letra'
	};
	
	Atributos[8]={
		validacion:{
			name:'linea_n',
			fieldLabel:'Negrilla',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'NO'],[2,'SI']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_n'
	};
	
	Atributos[9]={
		validacion:{
			name:'linea_s',
			fieldLabel:'Subrayado',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'NO'],[2,'SI']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_sino,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_s'
	};
	
	Atributos[10]={
		validacion:{
			name:'linea_t',
			fieldLabel:'Tabular',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[0,'0'],[1,'1'],[2,'2']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_tab,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_t'
	};
	Atributos[11]={
		validacion:{
			name:'linea_b',
			fieldLabel:'Borde',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[1,'NINGUNO'],[2,'SIMPLE'],[3,'DOBLE']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_borde,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'linea_b'
	};
	
	Atributos[12]={
		validacion:{
 			name:'id_eeff_nota',
			fieldLabel:'Nro. Nota',
			allowBlank:true,			
			emptyText:'Nota ...',
			desc: 'nota_nro', 		
			store:ds_eeff_nota,
			valueField: 'id_eeff_nota',
			displayField: 'nota_nro',
			queryParam: 'filterValue_0',
			filterCol:'EFN.nota_nro',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_eeff_nota,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_eeff_nota,
 			grid_visible:true,
 	 		grid_editable:true,
			width_grid:100,
			lazyRender:true,
      		width:100,
      		align:'right',
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0,
		save_as:'id_eeff_nota'
	};
	
	Atributos[13]={
		validacion:{
			name:'linea_impre',
			fieldLabel:'Título',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'EFL.linea_desope',
		save_as:'linea_impre',
		id_grupo:0
	};
	
	Atributos[14]={
		validacion:{
			name:'linea_desope',
			fieldLabel:'Título',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		filterColValue:'EFL.linea_desope',
		save_as:'linea_desope',
		id_grupo:0
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Lineas - EEFF',grid_maestro:'grid-'+idContenedor};
	layout_eeff_linea= new DocsLayoutMaestro(idContenedor);
	layout_eeff_linea.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_eeff_linea,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIï¿½N DE FUNCIONES
	 var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/eeff_compara/ActionEliminarEeffLinea.php'},
		Save:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffLinea.php'},
		ConfirmSave:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffLinea.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:500,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Detalle de Lineas',
			grupos:[{
				tituloGrupo:'Datos de Linea',
					columna:0,
					id_grupo:0
			}]}
		};
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//Ext.MessageBox.alert('Estado', 'llega');
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_eeff:maestro.id_eeff
			}
		};
		
		this.btnActualizar();
		
		ds_cuenta_act.baseParams={
				m_id_eeff:maestro.id_eeff,
				m_vigente:'si'
		}
		ds_cuenta_ant.baseParams={
				m_id_eeff:maestro.id_eeff,
				m_vigente:'no'
		}
		ds_eeff_nota.baseParams={
				m_id_eeff:maestro.id_eeff,
				m_ninguno:'si'
		}
		
		Atributos[1].defecto=maestro.id_eeff;
		
		paramFunciones.btnEliminar.parametros='&m_id_eeff='+maestro.id_eeff;
		paramFunciones.ConfirmSave.parametros='&m_id_eeff='+maestro.id_eeff;
		paramFunciones.Save.parametros='&m_id_eeff='+maestro.id_eeff;
	 
		this.InitFunciones(paramFunciones)
	};
	
	function btn_opera(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){			
			var SelectionsRecord=sm.getSelected();
			if (SelectionsRecord.data.linea_dato == 3){
				var data='m_id_eeff_linea='+SelectionsRecord.data.id_eeff_linea;
				data=data+'&m_id_eeff='+SelectionsRecord.data.id_eeff;
				data=data+'&m_linea_desope='+SelectionsRecord.data.linea_desope;
				
				var ParamVentana={Ventana:{width:'50%',height:'50%'}}
				layout_eeff.loadWindows(direccion+'../../../../sis_contabilidad/vista/eeff_compara/eeff_opera.php?'+data,'eeff_opera',ParamVentana);
			}else{	
				Ext.MessageBox.alert('Estado', 'La Linea debe ser Clase: OPERACION');
			}
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	ds.lastOptions={
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
	}};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_eeff_linea.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Detalle de la Operación',btn_opera,true,'eeff_opera','Operación');
	
	this.iniciaFormulario();

	layout_eeff_linea.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}