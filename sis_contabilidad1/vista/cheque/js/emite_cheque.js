/**
 * Nombre:		  	    pagina_cheque.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 11:24:35
 */
function pagina_emite_cheque(idContenedor,direccion,paramConfig){
	
	//DATA STORE COMBOS
     var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['CUENTA_8.nro_cuenta','CUENTA_8.descripcion','CUEBAN_8.nro_cuenta_banco'])
	});

	//FUNCIONES RENDER
	    function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{CUENTA_8.nro_cuenta}</FONT><br>','<FONT COLOR="#B5A642">{CUENTA_8.descripcion}</FONT><br>','<FONT COLOR="#B5A642">{CUEBAN_8.nro_cuenta_banco}</FONT>','</div>');
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'cheque',grid_maestro:'grid-'+idContenedor};
	var layout_cheque=new DocsLayoutMaestro(idContenedor);
	layout_emite_cheque.init(config);
    //--------------- EMITE CHEQUE -----------------------//
    
     function emitecheque(){
		 marcas_html="<div class='x-dlg-hd'>"+'Datos del cheque'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		 div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		 var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:150
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:150,
			width:380,
			height:215,
			minWidth:250,
			minHeight:200,
			closable:true
		});
		dlgFrm.addKeyListener(27,ocultarFrm);
		dlgFrm.addButton('Emitir Cheque',crearItem);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		CuentaBan=new Ext.form.ComboBox({
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,
			emptyText:'Cuenta Bancaria...',
			store:ds_cuenta_bancaria,
			filterCol:'INSTIT.nombre',
			queryParam:'filterValue_0',
			valueField:'id_cuenta_bancaria',
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_cuenta_bancaria,
			displayField:'CUEBAN.nro_cuenta_banco',
			triggerAction:'all',
			minChars:1,
			mode:'remote',
			width:'60%'
		});
		NumDepo=new Ext.form.TextField({
			name:'nro_deposito',
			fieldLabel:'Número de Depósito',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:100
		});
		fechaCheque=new Ext.form.DateField({
			name:'fecha_cheque',
			fieldLabel:'Costo Estimado',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:50
		});
	
		Formulario.fieldset({legend:'Datos del Cheque'},CuentaBan,NumDepo,fechaCheque);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	
	//-----------------------------------------------------//
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_emite_cheque,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_emite_cheque.getLayout()};
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);

	this.iniciaFormulario();
    emitecheque();
	layout_emite_cheque.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}