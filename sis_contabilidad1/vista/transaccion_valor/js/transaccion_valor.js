/**
 * Nombre:		  	    pagina_transaccion_valor.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2011-03-11 11:58:13
 */
function pagina_transaccion_valor(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();	
	var tipo_importe='ninguno';
	var m_desc_comprobante=maestro.desc_comprobante;
	var m_concepto_tran=maestro.concepto_tran;
	var data_maestro;
		
	/////////////////
	//  DATA STORE //
	/////////////////

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion_valor/ActionListarTransaccionValorUpdate.php?id_comprobante='+maestro.id_comprobante+'&id_transaccion='+maestro.id_transaccion+'&id_moneda='+maestro.id_moneda}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transac_valor',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_transac_valor',
			'id_transaccion',
			'id_comprobante',
			'importe_debe',
			'importe_haber',
			'tipo_moneda',
			'id_moneda'
			
			]),remoteSort:true});
			
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_comprobante:maestro.id_comprobante,
			m_id_transaccion:maestro.id_transaccion,
			m_id_moneda:maestro.id_moneda
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	/*var data_maestro=[['Descripcion de Comprobante ',maestro.desc_comprobante,'Descripcion de Transacción ',maestro.concepto_tran],
	                  ['Importe Debe Anterior',maestro.importe_debe,'Importe Haber Anterior ',maestro.importe_haber],
	                  ['Tipo Moneda',maestro.nombre]
	                 ];
	                 */
	data_maestro=[['Descripcion de Comprobante ',m_desc_comprobante],
	                  ['Descripcion de Transacción ',m_concepto_tran]
	                  ];
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
		Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transac_valor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_transac_valor'
	};
		Atributos[1]={
				validacion:{
					labelSeparator:'',
					name: 'id_transaccion',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_transaccion'
			};
		Atributos[2]={
				validacion:{
					labelSeparator:'',
					name: 'id_comprobante',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_comprobante'
			};
//importe debe
		
 
	Atributos[3]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe Actual',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,			
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		defecto:0,		
		save_as:'importe_debe'
	};
 //importe haber
	Atributos[4]={
		validacion:{
			name:'importe_haber', 
			fieldLabel:'Importe Haber Actual',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,			
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,			
			disabled:false		
		},		
		tipo: 'MonedaField',
		defecto:0,
		form: true,
		filtro_0:false,		
		save_as:'importe_haber'
	};
	Atributos[5]={
			validacion:{
				name:'tipo_moneda', 
				fieldLabel:'Tipo de moneda',
				allowBlank:true,				
				align:'right',				
				grid_visible:true,
				grid_editable:false,
				width_grid:200,			
				disabled:false		
			},		
			tipo: 'TextField',			
			form: true,
			filtro_0:false,		
			save_as:'tipo_moneda'
	};
	Atributos[6]={
			validacion:{
				labelSeparator:'',
				name: 'id_moneda',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_moneda'
		};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Modificacion al Importe Debe - Haber (Maestro)',titulo_detalle:'Importe Debe - Haber (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var layout_debe_haber = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_debe_haber.init(config);
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_debe_haber,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		editar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	
	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	
	var paramFunciones={	
	//Save:{url:direccion+'../../../control/transaccion_valor/ActionTransaccionValorUpdate.php',parametros:'&id_transaccion='+maestro.id_transaccion+'&id_comprobante='+maestro.id_comprobante+'&id_moneda='+maestro.id_moneda},
			Save:{url:direccion+'../../../control/transaccion_valor/ActionTransaccionValorUpdate.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:300,minWidth:300,minHeight:300,	closable:true,titulo:'Importe Debe - Haber'}};

		function MaestroJulio(data){
		
		var mayor=0;		
		var j;
		
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		 
		return html
	};		
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_moneda=datos.m_id_moneda;
		maestro.id_comprobante=datos.m_id_comprobante;
		maestro.id_transaccion=datos.m_id_transaccion;
		maestro.desc_comprobante=datos.m_desc_comprobante;
		maestro.concepto_tran=datos.m_concepto_tran;
				
		data_maestro=[['Descripcion de Comprobante ',maestro.desc_comprobante],
		                  ['Descripcion de Transacción ',maestro.concepto_tran]
		];
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_comprobante:maestro.id_comprobante,
				m_id_transaccion:maestro.id_transaccion,
				m_id_moneda:maestro.id_moneda				
			}
		});
	}
	function iniciarEventosFormularios()
	{		
		cmp_importe_debe = ClaseMadre_getComponente('importe_debe');
		cmp_importe_haber = ClaseMadre_getComponente('importe_haber');
		cmp_tipo_moneda= ClaseMadre_getComponente('tipo_moneda');
	}
	this.btnEdit=function()
	{	
		if(cmp_importe_haber.getValue()==0){cmp_importe_haber.disable();}
		else {cmp_importe_haber.enable();}
		if(cmp_importe_debe.getValue()==0){cmp_importe_debe.disable();}
		else{cmp_importe_debe.enable();}
		cmp_tipo_moneda.disable();
		ClaseMadre_btnEdit();
	}
	
/*------------------------------------------------------------*/
/********************************************************/

	this.getLayout=function(){return layout_debe_haber.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();	

	layout_debe_haber.getLayout().addListener('layout',this.onResize);
	//layout_debe_haber.getVentana().addListener('beforehide',function(){ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar()})
	
}