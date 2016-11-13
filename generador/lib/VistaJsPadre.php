<?php
function crearArchivo_VistaJsPadre($direccion,$db,$sistema,$table,$prefijo,$codigo,$meta,$datos_generales){

	
	
	$table_fjava = FormatPhpToJava($table);
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$aux = $meta[0]["descripcion_tabla"];
	$descripcion_tabla=decodificarForamto($aux);
	$hijos=$datos_generales["datos_hijos"];
	
	
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table.".js","w+");

	$sql = "/**
 * Nombre:		  	    pagina_".$table."_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		$fecha
 */
function pagina_".$table."(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/".$table."/ActionListar".$table_fjava.".php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: '".$meta[0]["campo"]."',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		";

	for($i=0;$i<=$num_campos -2; $i ++){

		if($meta[$i]["type"]=="date"){
			$sql.= "\t\t{name: '".$meta[$i]["campo"]."',type:'date',dateFormat:'Y-m-d'},\n";
		}else{
			$sql.= "\t\t'".$meta[$i]["campo"]."',\n";
		}
		//si el campo es llave foranea
		if($meta[$i]["referenciado"] != null){ //si es llave en otro lado sacamos la desripción de la tabla madre

			$vec_ref = $meta[$i]["referenciado"];
			$table_ref = $vec_ref[0];//tabla referenciada por el campo $i
			$id_table_ref = $vec_ref[1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);
			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$codigo_ref=$descripcion_tabla_ref["codigo"];
			$campo_ref=$descripcion_tabla_ref["dt_1"];
			$sistema_ref =$sistema;
			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla
			$sql.= "\t\t'desc_$table_ref_sp',\n";
		}
	}
			//si el campo es llave foranea
		if($meta[$i]["referenciado"] != null){ //si es llave en otro lado sacamos la desripción de la tabla madre

			$vec_ref = $meta[$i]["referenciado"];
			$table_ref = $vec_ref[0];//tabla referenciada por el campo $i
			$id_table_ref = $vec_ref[1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);
			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$codigo_ref=$descripcion_tabla_ref["codigo"];
			$campo_ref=$descripcion_tabla_ref["dt_1"];
			$sistema_ref =$sistema;
			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla
			$sql.= "\t\t'desc_$table_ref_sp',\n";
		}
			if($meta[$i]["type"]=="date"){
		$sql.= "\t\t{name: '".$meta[$i]["campo"]."',type:'date',dateFormat:'Y-m-d'}\n";
	}else{

		$sql.= "\t\t'".$meta[$i]["campo"]."'\n";
	}

	$sql.="
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS\n";
	
	$funciones_render="";
	for($i=0;$i<=$num_campos -1; $i ++){

		if($meta[$i]["referenciado"]!=null){
			$vec_ref = $meta[$i]["referenciado"];
			$table_ref = $vec_ref[0];//tabla referenciada por el campo $i
			$id_table_ref = $vec_ref[1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);
			
			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$sistema_ref =$sistema;
			if($descripcion_tabla_ref["sistema"]!= null && $descripcion_tabla_ref["sistema"]!=''){
				$sistema_ref = $descripcion_tabla_ref["sistema"];
			}
			else{
				echo "la tabla: $table_ref no tiene en la descripción SISTEMA\n";
			}

			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla

			$sql.="
    ds_$table_ref_sp = new Ext.data.Store({";

			$table_ref_sp_fjava = FormatPhpToJava($table_ref_sp);
			
			if($sistema_ref==$sistema){
				$sql.="proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/".$table_ref_sp."/ActionListar".$table_ref_sp_fjava.".php'}),";
			}
			else{
				$sql.="proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_$sistema_ref/control/".$table_ref_sp."/ActionListar".$table_ref_sp_fjava.".php'}),";
			}
			$sql.="
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: '$id_table_ref',
			totalRecords: 'TotalCount'
		}, [";

			
			for($j=0;$j<$num_campos_ref-1;$j++)
			{
				$sql.="'".$meta_ref[$j]["campo"]."',";
			}
			$sql.="'".$meta_ref[$j]["campo"]."'])
	});\n";
			
			$funciones_render.="
			function render_".$meta[$i]["campo"]."(value, p, record){return String.format('{0}', record.data['desc_".$table_ref_sp."']);}";		

		}
	}



	$sql.="
	//FUNCIONES RENDER
	$funciones_render;";
	
	
	$sql.="
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden ".$meta[0]["campo"]."
	//en la posición 0 siempre esta la llave primaria

	var param_".$meta[0]["campo"]." = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: '".$meta[0]["campo"]."',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_".$meta[0]["campo"]."'
	};
	vectorAtributos[0] = param_".$meta[0]["campo"].";\n";

	for($i=1;$i<=$num_campos -1; $i ++){


		$name=$meta[$i]["campo"];
		$fieldLabel=$meta[$i]["campo"];
		if($meta[$i]["descripcion"]!= null){

			$decripcion = decodificarForamto($meta[$i]["descripcion"]);
			$decripcion_tabla = decodificarForamto($meta[$i]["descripcion_tabla"]);
			$fieldLabel=$decripcion["label"];
			$codigo=$decripcion_tabla["codigo"];
		}

		if($meta[$i]['notnull']==1){
			$allowBlank= 'false';
		}
		else{
			$allowBlank= 'false';
		}
		$maxLength=$meta[$i]["modifier"]-4;
		$minLength=0;
		$grid_visible='true';
		$grid_editable='true';
		$width_grid='100';
		$disable = "false";
		$tipo_dato ="default";
		$tipo= 'Field';
		$filterColValue=$codigo.".$name";
		if($meta[$i]["type"]=="date"){$tipo_dato ="fecha";$tipo= 'DateField';}
		if($meta[$i]["type"]=="varchar" && $maxLength > 50){$tipo_dato ="texto_largo";$tipo= 'TextArea';}
		if($meta[$i]["type"]=="varchar" && $maxLength <=50){$tipo_dato ="texto_corto";$tipo= 'TextField';}
		if($meta[$i]["type"]=="int4"){$tipo_dato ="numero_entero";$tipo='NumberField';$allowDecimals='false';}
		if($meta[$i]["type"]=="numeric"){$tipo_dato ="numero_float";$tipo= 'NumberField';$allowDecimals='true';}
		if($meta[$i]["type"]=="time"){$tipo_dato="time";$tipo= 'TextField';$maxLength=8;}

		//--- verifica si es tipo CHECK --//
		$check = $meta[$i]["check"];
		if($check!=null){$tipo_dato ="combo_local";$tipo= 'ComboBox';}
		
		//--- verifica si es un COMBO REMOTO --//
		$referenciado = $meta[$i]["referenciado"];
		if($referenciado!=null){
			$tipo_dato ="combo_remoto";$tipo= 'ComboBox';
			$table_ref = $referenciado [0];//tabla referenciada por el campo $i
			$id_table_ref=$referenciado [1];//id de la tabla referenciada en el campo $i
			$meta_ref = metadata($db,null,$table_ref);
			$num_campos_ref = sizeof($meta_ref);
			$aux = $meta_ref[0]["descripcion_tabla"];
			$descripcion_tabla_ref = decodificarForamto($aux);
			$codigo_ref=$descripcion_tabla_ref["codigo"];
			$codigo_ref_original=$descripcion_tabla_ref["codigo"];
			$campo_ref=$descripcion_tabla_ref["dt_1"];
			$table_ref_sp =substr($table_ref,4);//le quitamos el prefijo al nombre de la tabla
	  		if($codigo_ref == $codigo)
	  		$codigo_ref.="_$i";
			$filterColValue=$codigo_ref.".$campo_ref";
		}

		/*echo $tipo ."= ";
		echo $tipo_dato."<br>";*/

		//---------------------------------------//
		if($tipo_dato=='texto_largo' or $tipo_dato=='texto_corto'){
			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			maxLength:$maxLength,
			minLength:$minLength,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:$width_grid
		},
		tipo: '$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";

		}
		//---------------------------------------//
		if($tipo_dato=='numero_entero' or $tipo_dato=='numero_float'){

			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:$allowDecimals,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:100
		},
		tipo: '$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";
		}

		//---------------------------------------//
		if($tipo_dato=='fecha'){

			if($name=="fecha_reg"){
				$disable = "true";
				$allowBlank = "true";
			}
			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			renderer: formatDate,
			width_grid:85,
			disabled:$disable
		},
		tipo:'$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";
		}
		//---------------------------------------//
		if($tipo_dato=='combo_local'){

			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
			validacion: {
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.".$table."_combo.".$meta[$i]["campo"]."
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		defecto:'".$check[0]."',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";
		}
		//---------------------------------------//
		if($tipo_dato=='combo_remoto'){
			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
			validacion: {
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,			
			emptyText:'$fieldLabel...',
			name: '".$meta[$i]["campo"]."',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_$table_ref_sp', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_$table_ref_sp,
			valueField: '$id_table_ref',
			displayField: '".$descripcion_tabla_ref["dt_1"]."',
			queryParam: 'filterValue_0',
			filterCol:'";
			for($k=1;$k<=$descripcion_tabla_ref["num_dt"]-1;$k++){
				$fil = $descripcion_tabla_ref["dt_".$k];
				$sql.="$codigo_ref_original.$fil#";
			}
			$fil = $descripcion_tabla_ref["dt_".$k];
			$sql.="$codigo_ref_original.$fil";
			$sql.="',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_".$meta[$i]["campo"].",
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		defecto: '".$check[0]."',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";
		}
		
		
		

	//---------------------------------------//
	if($tipo_dato=='id_padre'){

			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'$tipo',
		filtro_0:false,
		defecto:maestro.".$meta[$i]["campo"]."
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";
		}
		
		
	//---------------------------------------//
		if($tipo_dato=='time'){

			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			maxLength:$maxLength,
			minLength:$minLength,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:$width_grid
		},
		tipo:'$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";

		}

	//---------------------------------------//
		if($tipo_dato=='default'){

			$sql.= "// txt ".$meta[$i]["campo"]."
	var param_".$meta[$i]["campo"]."= {
		validacion:{
			name:'$name',
			fieldLabel:'$fieldLabel',
			allowBlank:$allowBlank,
			maxLength:$maxLength,
			minLength:$minLength,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:$grid_visible,
			grid_editable:$grid_editable,
			width_grid:$width_grid
		},
		tipo: '$tipo',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'$filterColValue',
		save_as:'txt_".$meta[$i]["campo"]."'
	};
	vectorAtributos[$i] = param_".$meta[$i]["campo"].";\n";

		}
	}

	$sql.="
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'".$table."',
		grid_maestro:'grid-'+idContenedor
	};
	layout_".$table." = new DocsLayoutMaestro(idContenedor);
	layout_".$table.".init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_".$table.",idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
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
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+'../../../control/$table/ActionEliminar$table_fjava.php'
		},
		Save:{
			url:direccion+'../../../control/$table/ActionGuardar$table_fjava.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/$table/ActionGuardar$table_fjava.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: '".$table."'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//\n";
	
	
	//--   para la creación de los botones que abriran los hijos --//
	$num_hijos = sizeof($hijos); //numero de hijos
	$botones_extra="";
	
	for($i=0;$i<$num_hijos;$i++){
	
		$meta_hijo=metadata($db,$prefijo,$hijos[$i]["nombre_tabla"]);
		$id_table_hijo = $meta_hijo[0]["campo"];
		$table_hijo=$hijos[$i]["nombre_tabla"];
		$aux = $meta_hijo[0]["descripcion_tabla"];
		$descripcion_tabla_hijo= decodificarForamto($aux);
		$sistema_hijo=$descripcion_tabla_hijo["sistema"];
		
		
		$sql.="function btn_".$table_hijo."(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_".$meta[0]["campo"]."='+SelectionsRecord.data.".$meta[0]["campo"].";\n";
			
			//definicion de los datos del padre que seran transmitidos al hijo
			for($j=1;$j<=$descripcion_tabla["num_dt"];$j++){
					$sql.="\t\t\tdata=data+'&m_".$descripcion_tabla["dt_$j"]."='+SelectionsRecord.data.".$descripcion_tabla["dt_$j"].";\n";
				}
		
			$sql.="
			var ParamVentana={ventan:{width:'90%',height:'70%'}}
			";
				
			if($sistema==$sistema_hijo){
				$sql.="layout_$table.loadWindows(direccion+'../../".$table_hijo."/".$table_hijo."_det.php?'+data,'".$hijos[$i]["nombre"]."',ParamVentana);\n";
			}
			else{
				$sql.="layout_$table.loadWindows(direccion+'../../../$sistema_hijo/".$table_hijo."/".$table_hijo."_det.php?'+data,'".$hijos[$i]["nombre"]."',ParamVentana);\n";
			}
			$sql.="layout_$table.getVentana().on('resize',function(){
			layout_$table.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	";
			
			
	$botones_extra.="
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_".$table_hijo.",true,'$table_hijo','".$hijos[$i]["nombre"]."');\n";		
	}
	

$sql.="
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_$table.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				$botones_extra
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_".$table.".getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>