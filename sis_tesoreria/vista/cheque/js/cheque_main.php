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
	          sw_importe_cheque:'<?php echo $m_sw_importe_cheque;?>'
             };
var elemento={pagina:new Cheque(idContenedor,direccion,paramConfig,maestro),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

//view added


function Cheque(idContenedor,direccion,paramConfig,maestro){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_cheque;
	var combo_cuenta_bancaria,txt_nombre_cheque;
	var combo_moneda,txt_importe_cheque;
	var txt_nombre_tabla,txt_nombre_campo,txt_id_tabla;
    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
  //// Cuenta Bancaria /////////
	vectorAtributos[0]={
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
			width:'100%'	
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_bancaria'	
	};
///////Nombre////////////
	vectorAtributos[1]={
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
	vectorAtributos[2]={
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
	vectorAtributos[3]={
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
    vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'nombre_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_tabla',
		defecto:maestro.nombre_tabla
	};
///////nombre campo/////////
    vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'nombre_campo',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_campo',
		defecto:maestro.nombre_campo
	};	
///////id tabla/////////
    vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'id_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_tabla',
		defecto:maestro.id_tabla
	};	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Cheque"};
	layout_cheque=new DocsLayoutProceso(idContenedor);
	layout_cheque.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_cheque,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Carga de Archivos "+ContPes;
		ContPes ++;
		return titulo
	}	
	function retorno(){
		Ext.MessageBox.hide();
		/*carga_archivo=ClaseMadre_getComponente('cuenta_bancaria');
		carga_archivo.reset();*/
		
		
		_CP.getVentana(idContenedor).hide();
		//this.pagina.close();
		Ext.Msg.show({
			title:'Estado',
			msg:'Proceso ejecutado satisfactoriamente.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		url:direccion+'../../../../sis_tesoreria/control/carga_archivo/ActionGuardarArchivo.php',
		abrir_pestana:false,
		titulo_pestana:obtenerTitulo,
		argument:'',
		fileUpload:true,
		success:retorno,
		columnas:[320],
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
		txt_importe_cheque.setValue(maestro.importe_cheque);
		txt_nombre_cheque.setValue(maestro.nombre_cheque);
		combo_moneda.setValue(maestro.id_moneda);
		combo_cuenta_bancaria.setValue(maestro.id_cuenta_bancaria);
		txt_nombre_tabla.defecto=maestro.nombre_tabla;
		txt_nombre_campo.defecto=maestro.nombre_campo;
		txt_id_tabla.defecto=maestro.id_tabla;
		this.InitFunciones(paramFunciones)
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	ds_moneda.reload();
	ds_cuenta_bancaria.reload();
	  combo_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
	  txt_nombre_cheque=ClaseMadre_getComponente('nombre_cheque');
	  combo_moneda=ClaseMadre_getComponente('id_moneda');
	  txt_importe_cheque=ClaseMadre_getComponente('importe_cheque');
	  txt_nombre_tabla=ClaseMadre_getComponente('nombre_tabla');
	  txt_nombre_campo=ClaseMadre_getComponente('nombre_campo');
	  txt_id_tabla=ClaseMadre_getComponente('id_tabla');
	  txt_importe_cheque.setValue(maestro.importe_cheque);
	  txt_nombre_cheque.setValue(maestro.nombre_cheque);
	  combo_moneda.setValue(maestro.id_moneda);
	  combo_cuenta_bancaria.setValue(maestro.id_cuenta_bancaria)	
	  if(maestro.sw_cuenta_bancaria){
	  	combo_cuenta_bancaria.enable()
	  }
	  else{
	  	combo_cuenta_bancaria.disable()
	  }
	  if(maestro.sw_nombre_cheque){
	  	txt_nombre_cheque.enable()
	  }
	  else{
	  	txt_nombre_cheque.disable()
	  }
	  if(maestro.sw_moneda){
	  	combo_moneda.enable()
	  }
	  else{
	  	combo_moneda.disable()
	  }
	  if(maestro.sw_importe_cheque){
	  	txt_importe_cheque.enable()
	  }
	  else{
	  	txt_importe_cheque.disable()
	  }
	    
	}
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}