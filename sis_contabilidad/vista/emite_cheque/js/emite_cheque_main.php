//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TiempoEspera:10000};
var maestro={ nombre_tabla:'<?php echo $m_nombre_tabla;?>',
              nombre_campo:'<?php echo $m_nombre_campo;?>',
              id_tabla:'<?php echo $m_id_tabla;?>',
              id_cuenta_bancaria:'<?php echo $m_id_cuenta_bancaria;?>',
              sw_cuenta_bancaria:'<?php echo $m_sw_cuenta_bancaria;?>',
              nombre_cheque:'<?php echo $m_nombre_cheque;?>',
              sw_nombre_cheque:'<?php echo $m_sw_nombre_cheque;?>',
              id_moneda:'<?php echo $m_id_moneda;?>',
              sw_moneda:'<?php echo $m_sw_moneda;?>',
	          importe_cheque:'<?php echo $m_importe_cheque;?>',
	          sw_importe_cheque:'<?php echo $m_sw_importe_cheque;?>',
	          cambio_estado:decodeURIComponent('<?php echo $m_cambio_estado;?>'),
	          id_avance:<?php if($m_id_avance=='') {echo 0;} else {echo $m_id_avance;}?>,
			  id_cheque:<?php if($m_id_cheque=='') {echo 0;} else {echo $m_id_cheque;}?>,
              vista:<?php echo $m_vista;?>,
              tipo_cheque:'<?php echo $m_tipo_cheque;?>'};
             /* echo $m_vista;
              exit;*/
             
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new EmiteCheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function EmiteCheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_cheque;
	var combo_cuenta_bancaria,txt_nombre_cheque;
	var combo_moneda,txt_importe_cheque,txt_cambio_estado;
	var txt_nombre_tabla,txt_nombre_campo,txt_id_tabla;
	var txt_desc_cuenta_bancaria,txt_tipo_cheque;
	
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco'])
	});

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	///////id tabla/////////
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cheque',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_cheque'
	};
	//// Cuenta Bancaria /////////
	vectorAtributos[1]={
		validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,
			emptyText:'Cuenta...',
			store:ds_cuenta_bancaria,
			valueField:'id_cuenta_bancaria',
			displayField:'desc_institucion',
			queryParam:'filterValue_0',
			filterCol:'CUEBAN.id_cuenta_bancaria',
			typeAhead:true,
			tpl:tpl_cuenta_bancaria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_bancaria'
	};
	///////Nombre////////////
	vectorAtributos[2]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%'
		},
		tipo:'TextField',
		save_as:'nombre_cheque'
	};
	//// Moneda /////////
	vectorAtributos[3]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:'100%'
		},
		tipo:'ComboBox',
		save_as:'id_moneda'
	};
	/////// Importe ////////////
	vectorAtributos[4]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%'
		},
		tipo:'NumberField',
		save_as:'importe_cheque'
	};
	///////nombre table/////////
	vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'nombre_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_tabla'
	};
	///////nombre campo/////////
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'nombre_campo',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_campo'
	};
	///////id tabla/////////
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'id_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_tabla'
	};
	///////nombre campo/////////
	vectorAtributos[8]={
		validacion:{
			labelSeparator:'',
			name:'cambio_estado',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'cambio_estado',
		defecto:maestro.cambio_estado
	};
	///////tipo cheque/////////
	vectorAtributos[9]={
		validacion:{
			labelSeparator:'',
			name:'tipo_cheque',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'tipo_cheque',
		defecto:maestro.tipo_cheque
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Cheque"};
	layout_cheque=new DocsLayoutProceso(idContenedor,idContenedorPadre); 
	layout_cheque.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,vectorAtributos,layout_cheque,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_btnNew=this.btnNew;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	
	function obtenerTitulo(){
		var titulo="Carga de Archivos "+ContPes;
		ContPes ++;
		return titulo
	}
	
	function retorno(resp){

		var root = resp.responseXML.documentElement;
		var v_id_cheque = root.getElementsByTagName('id_cheque')[0].firstChild.nodeValue;

		//var SelectionsRecord=sm.getSelected();
		//v_id_avance = maestro.id_avance==undefined ? 0:maestro.id_avance;
		//alert('avance:'+v_id_avance);
		//var data='m_id_avance='+v_id_avance+'&m_id_cheque='+v_id_cheque;
		
		Ext.MessageBox.hide();
		_CP.getVentana(idContenedor).hide();
		Ext.Msg.show({
			title:'Estado',
			msg:'El cheque se emitió exitosamente.',
			minWidth:300,
			maxWidth:800,
			buttons:Ext.Msg.OK
		});
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar()
		
		
		// Despues de emitir el cheque lo imprimimos automaticamente
		/*var data='m_id_moneda='+maestro.id_moneda+'&m_id_cheque='+v_id_cheque+'&desc_cuenta_bancaria='+txt_desc_cuenta_bancaria+'&id_avance='+maestro.id_avance;
		//alert(maestro.vista);
        if(maestro.vista==1){
			//alert (data);
		   window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);	
	       window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFReciboEntrega.php?'+data);
        }else
        {
        	window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);	
        }*/
	}

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{
		labelWidth:75,
		url:direccion+'../../../../sis_contabilidad/control/cheque/ActionGuardarCheque.php',
		abrir_pestana:false,
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		success:retorno,		
		width:400,
		height:500,
		minWidth:450,
		minHeight:550,	
		columnas:['95%'],
		grupos:[{tituloGrupo:'Datos del Cheque',columna:0,id_grupo:0}],parametros:''}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.nombre_tabla=datos.m_nombre_tabla;
		maestro.nombre_campo=datos.m_nombre_campo;
		maestro.id_tabla=datos.m_id_tabla;
		maestro.id_cuenta_bancaria=datos.m_id_cuenta_bancaria;
		maestro.sw_cuenta_bancaria=datos.m_sw_cuenta_bancaria;
		maestro.nombre_cheque=datos.m_nombre_cheque;
		maestro.sw_nombre_cheque=datos.m_sw_nombre_cheque;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.sw_moneda=datos.m_sw_moneda;
		maestro.importe_cheque=datos.m_importe_cheque;
		maestro.sw_importe_cheque=datos.m_sw_importe_cheque;
		maestro.cambio_estado=datos.m_cambio_estado;
		maestro.id_avance=datos.m_id_avance;
		maestro.id_cheque=datos.m_id_cheque;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.tipo_cheque=datos.m_tipo_cheque;
		txt_importe_cheque.setValue(maestro.importe_cheque);
		txt_nombre_cheque.setValue(maestro.nombre_cheque);
		combo_moneda.setValue(maestro.id_moneda);
		combo_cuenta_bancaria.setValue(maestro.id_cuenta_bancaria);
		txt_nombre_tabla.setValue(maestro.nombre_tabla);
		txt_nombre_campo.setValue(maestro.nombre_campo);
		txt_id_tabla.setValue(maestro.id_tabla);
		txt_cambio_estado.setValue(maestro.cambio_estado);
		txt_tipo_cheque.setValue(maestro.tipo_cheque);
		 //alert (datos.m_vista);
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		ds_moneda.reload();
		ds_cuenta_bancaria.reload();
		txt_id_cheque=ClaseMadre_getComponente('id_cheque');
		combo_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
		txt_nombre_cheque=ClaseMadre_getComponente('nombre_cheque');
		combo_moneda=ClaseMadre_getComponente('id_moneda');
		txt_importe_cheque=ClaseMadre_getComponente('importe_cheque');
		txt_nombre_tabla=ClaseMadre_getComponente('nombre_tabla');
		txt_nombre_campo=ClaseMadre_getComponente('nombre_campo');
		txt_id_tabla=ClaseMadre_getComponente('id_tabla');
		txt_cambio_estado=ClaseMadre_getComponente('cambio_estado');
		txt_importe_cheque.setValue(maestro.importe_cheque);
		txt_nombre_cheque.setValue(maestro.nombre_cheque);
		combo_moneda.setValue(maestro.id_moneda);
		combo_cuenta_bancaria.setValue(maestro.id_cuenta_bancaria);
		txt_nombre_tabla.setValue(maestro.nombre_tabla);
		txt_nombre_campo.setValue(maestro.nombre_campo);
		txt_id_tabla.setValue(maestro.id_tabla);
		txt_cambio_estado.setValue(maestro.cambio_estado);
		cmbCB=ClaseMadre_getComponente('id_cuenta_bancaria');
		txt_tipo_cheque=ClaseMadre_getComponente('tipo_cheque');
		txt_tipo_cheque.setValue(maestro.tipo_cheque);
		var onCBSelect = function(combo, record , index){
			//var cb=cmbCB.getValue();
			//data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			/*actualizar_ds_combos();
			//Limpia los valores de los combos
			cmbAlmacen.setValue('');
			cmbAlmacenLogico.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			cmbAlmacen.modificado=true;
			cmbAlmacenLogico.modificado=true;
			*/
			//Carga los datos en variables ocultas
			txt_desc_cuenta_bancaria=record.data['desc_institucion'];
			//alert ("-"+txt_desc_cuenta_bancaria+"-");
			//codigo_ep.setValue((ep['codigo_financiador']+'-'+ep['codigo_regional']+'-'+ep['codigo_programa']+'-'+ep['codigo_proyecto']+'-'+ep['codigo_actividad']));
		};
		
		if(maestro.sw_cuenta_bancaria=='true'){
			combo_cuenta_bancaria.enable()
		}
		else{
			combo_cuenta_bancaria.disable()
		}
		if(maestro.sw_nombre_cheque=='true'){
			txt_nombre_cheque.enable()
		}
		else{
			txt_nombre_cheque.disable()
		}
		if(maestro.sw_moneda=='true'){
			combo_moneda.enable()
		}
		else{
			combo_moneda.disable()
		}
		if(maestro.sw_importe_cheque=='true'){
			txt_importe_cheque.enable()
		}
		else{
			txt_importe_cheque.disable()
		}
		
		cmbCB.on('select',onCBSelect);
	}
	
	_CP.getVentana(idContenedor).on('resize',this.onResizePrimario);
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}