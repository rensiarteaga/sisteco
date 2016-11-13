/*
 * Created on 20-abr-2010
 * By Jaime Rivera	
 */

import java.sql.*;
import net.sf.jasperreports.view.JasperViewer;
import net.sf.jasperreports.engine.xml.JRXmlLoader;
import net.sf.jasperreports.engine.JRParameter;
import net.sf.jasperreports.engine.JasperCompileManager;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.JasperExportManager;
import net.sf.jasperreports.engine.export.JRPdfExporterParameter;
import net.sf.jasperreports.engine.export.JRPdfExporterTagHelper;

import net.sf.jasperreports.engine.design.JasperDesign;
import net.sf.jasperreports.engine.JasperReport;

//para excel
import net.sf.jasperreports.engine.export.JRXlsExporter;
import net.sf.jasperreports.engine.export.JRXlsExporterParameter;

//para rtf
import net.sf.jasperreports.engine.export.JRRtfExporter;
import net.sf.jasperreports.engine.JRExporterParameter;

//para csv

import net.sf.jasperreports.engine.export.JRCsvExporter;

import java.io.*;
import java.util.*;
import java.text.*;




/**
 * Programa para conectar a una base de datos y ver un reporte de jasper de tipo (.jasper)
 * @autor Jaime Rivera
 * @fecha 20 de Abril del 2010
 *
 * Required jar files to run this class:
 * 1. jasperreports.jar
 * 2. postgresql-8.4-701.jdbc4.jar (para conexión postgres JDBC)
 * 3. commons-beanutils-1.5.jar
 * 4. commons-collections-2.1.jar
 * 5. commons-digester-1.7.jar
 * 6. commons-logging-1.0.2.jar
 *
 */

public class ReportDriver {
	public static final String JAVABRIDGE_PORT="8087";
	private static Connection conexion;
	private static HashMap parameters = new HashMap();
	private static String reportFile = new String();
	private static String outFile = new String();
	private static String cadena_con = new String();
	private static String usuario_con = new String();
	private static String passwd = new String();
  	static final php.java.bridge.JavaBridgeRunner runner =
    	php.java.bridge.JavaBridgeRunner.getInstance(JAVABRIDGE_PORT);
    
    
    /**
     * Constructor for ReportDriver
     */
    public ReportDriver() {
        
    }
    
    /**
     * Toma 3 parametros: cadena de conexion, usuario, password
     * y conecta a la base de datos.
     * @param con tiene la cadena de conexion,
     * @param usuario tiene el nombre de usuario
     * @param contrasenia tiene la contrasena del usuario,
     * 
     */
    public static String crearConexion(String con,String usuario,String contrasenia){
    	cadena_con=con;
    	usuario_con=usuario;
    	passwd=contrasenia;
    	String res=new String();
    	res="exito";
    	conexion = null;
        try{
            Class.forName("org.postgresql.Driver");
            conexion = DriverManager.getConnection(con,usuario,contrasenia);
        }catch(Exception ex) {
            String connectMsg = "No se pudo conectar ala base de datos: " + ex.getMessage() + " " + ex.getLocalizedMessage();
            System.out.println(connectMsg);
            res="error";
        }
        return res;
            
    }
    
    public static void addParametro(String nombre,String valor){
    	
    	parameters.put(nombre,valor);        	
    
    }
    
     public static void addParametro(String nombre,String valor,String tipo,String formato){
    	int resInt=0;
    	
    	java.util.Date convertedDate=new java.util.Date();
    	if(tipo.equals("Integer")){
    		
    		resInt= Integer.parseInt(valor);
    		parameters.put(nombre,resInt);
    	}
    	if(tipo.equals("Date")){
    		if(formato==""){
    			try{
    				SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
    				convertedDate = dateFormat.parse(valor); 
    			}catch(Exception ex) {
		           	String connectMsg = "No se pudo cambiar el formato de fecha a dd/mm/yyyy  " + ex.getMessage() + " " + ex.getLocalizedMessage();
		            System.out.println(connectMsg);
		        }
    			
    		}
    		else{
    			try{
    				SimpleDateFormat dateFormat = new SimpleDateFormat(formato);
    				convertedDate = dateFormat.parse(valor); 
    			}catch(Exception ex) {
		           	String connectMsg = "No se pudo cambiar el formato de fecha a "+valor + "   " + ex.getMessage() + " " + ex.getLocalizedMessage();
		            System.out.println(connectMsg);
		        }
    			
    			   		
    		}
    		parameters.put(nombre,convertedDate);
    	
    	}
    	       	
    
    }
    
    public static void setDatosReporte(String nombre_archivo,String reporte){
    	reportFile=reporte;
    	outFile="/tmp/"+nombre_archivo;
    
    }
   
    
    /**
     * Toma 1 parametro: tipo_archivo
     * y genera el reporte en el formato del tipo_archivo.
     * @param tipo_archivo tiene el tipo de archivo a generar,
     * 
     */
    public static void runReporte(String tipo_archivo) {
    	if(conexion!=null){
    
	    	/*switch(tipo_archivo) {
	    		case equals("pdf") : generarPDF(); break;
	    		case equals("xls") : generarXLS(); break;
	    		case equals("rtf") : generarXLS(); break;
	    		case equals("csv") : generarXLS(); break;
	    		case equals("html") : generarXLS(); break;
	    		default: System.out.println("Error al seleccionar el tipo de archivo: "+tipo_archivo);break;
	    	}*/
	
			if(tipo_archivo.equals("pdf")){
	    		generarPDF();
	    	}
	    	else if(tipo_archivo.equals("xls")){
	    		generarXLS();
	    	}
	    	else if(tipo_archivo.equals("rtf")){
	    		generarRTF();
	    	}
	    	else if(tipo_archivo.equals("csv")){
	    		generarCSV();
	    	}
	    	else if(tipo_archivo.equals("html")){
	    		generarHTML();
	    	}
	    	else
	    	{	
	    		System.out.println("Error al seleccionar el tipo de archivo: "+tipo_archivo);
	    		java.util.Date fecha=new java.util.Date();
	    		SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
	            generarLog("Error al seleccionar el tipo de archivo: "+tipo_archivo,"",sdf.format(fecha));
	    	}
	    	try{
	    		conexion.close();
	    	}
	    	catch(Exception ex) {
	            String connectMsg = "No se pudo cerrar la conexion a: " + ex.getMessage() + " " + ex.getLocalizedMessage();
	            System.out.println(connectMsg);
	        }
	    }
	    else{
	    	System.out.println("Error en la conexion");
	    	java.util.Date fecha=new java.util.Date();
	    	SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
	        generarLog("Error en la conexion:"+cadena_con+" Usuario: "+usuario_con+" Contrasena: "+passwd,"",sdf.format(fecha));
	    }
	}
		
		private static void generarCSV(){
			try{
				
	           	JasperFillManager jasperFillManager=new JasperFillManager();
				JasperPrint jasperPrint=jasperFillManager.fillReport(reportFile, parameters, conexion);
				
				//Esporta el reporte a CSV
				JRCsvExporter exporter = new JRCsvExporter();
	            File destFile = new File(outFile);
	
	            exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
	            exporter.setParameter(JRExporterParameter.OUTPUT_FILE_NAME,
	            destFile.toString());
	
	            exporter.exportReport();
				
			}catch(Exception ex) {
	           	String connectMsg = "No se pudo crear el reporte " + ex.getMessage() + " " + ex.getLocalizedMessage();
	            
	           	StringWriter sw = new StringWriter();
				ex.printStackTrace(new PrintWriter(sw));
				connectMsg = connectMsg+"*******"+sw.toString();
	           	
	            java.util.Date fecha=new java.util.Date();
	            SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
	            generarLog(connectMsg,reportFile,sdf.format(fecha));
	        }
		}
		
		private static void generarPDF() {
			//System.out.println(parameters);
			try{
				parameters.put(JRParameter.IS_IGNORE_PAGINATION, Boolean.FALSE);
	           	JasperFillManager jasperFillManager=new JasperFillManager();
				JasperPrint jasperPrint=jasperFillManager.fillReport(reportFile, parameters, conexion);
				JasperExportManager jasperExportManager=new JasperExportManager();
				jasperExportManager.exportReportToPdfFile(jasperPrint,outFile); 
	
			}catch(Exception ex) {
	           	String connectMsg = "No se pudo crear el reporte " + ex.getMessage() + " " + ex.getLocalizedMessage();
	            //System.out.println(ex.getMessage());
	           	StringWriter sw = new StringWriter();
				ex.printStackTrace(new PrintWriter(sw));
				connectMsg = connectMsg+"*******\n"+sw.toString();
	           
	            java.util.Date fecha=new java.util.Date();
	           SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
	            generarLog(connectMsg,reportFile,sdf.format(fecha));
	        }
	}
	
	private static void generarHTML(){
		try{
	
           	JasperFillManager jasperFillManager=new JasperFillManager();
			JasperPrint jasperPrint=jasperFillManager.fillReport(reportFile, parameters, conexion);
			JasperExportManager.exportReportToHtmlFile(jasperPrint, outFile);

		}catch(Exception ex) {
           	String connectMsg = "No se pudo crear el reporte " + ex.getMessage() + " " + ex.getLocalizedMessage();
           
           	StringWriter sw = new StringWriter();
			ex.printStackTrace(new PrintWriter(sw));
			connectMsg = connectMsg+"*******\n"+sw.toString();
           	
            java.util.Date fecha=new java.util.Date();
            SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
            generarLog(connectMsg,reportFile,sdf.format(fecha));
        }
	}
	
	private static void generarXLS(){
		try{
			
           	JasperFillManager jasperFillManager=new JasperFillManager();
			JasperPrint jasperPrint=jasperFillManager.fillReport(reportFile, parameters, conexion);
			
			 //Exporta el informe a excel

            OutputStream ouputStream= new FileOutputStream(new File(outFile));
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

            JRXlsExporter exporterXLS = new JRXlsExporter();
            exporterXLS.setParameter(JRXlsExporterParameter.JASPER_PRINT,jasperPrint);
            exporterXLS.setParameter(JRXlsExporterParameter.OUTPUT_STREAM,byteArrayOutputStream);
            
           
       
            exporterXLS.exportReport();

            ouputStream.write(byteArrayOutputStream.toByteArray());
            ouputStream.flush();
            ouputStream.close();
			

		}catch(Exception ex) {
           	String connectMsg = "No se pudo crear el reporte " + ex.getMessage() + " " + ex.getLocalizedMessage();
            
           	StringWriter sw = new StringWriter();
			ex.printStackTrace(new PrintWriter(sw));
			connectMsg = connectMsg+"*******\n"+sw.toString();
           	
            java.util.Date fecha=new java.util.Date();
            SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
            generarLog(connectMsg,reportFile,sdf.format(fecha));
        }
	}
	
	public static void generarRTF(){
		try{
			parameters.put(JRParameter.IS_IGNORE_PAGINATION, Boolean.FALSE);
			JasperFillManager jasperFillManager=new JasperFillManager();
			JasperPrint jasperPrint=jasperFillManager.fillReport(reportFile, parameters, conexion);
			
			 //Exporta el informe a rtf
			
			OutputStream ouputStream= new FileOutputStream(new File(outFile));
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

            JRRtfExporter exporter = new JRRtfExporter();
            exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
            exporter.setParameter(JRExporterParameter.OUTPUT_STREAM, ouputStream);

            exporter.exportReport();

            ouputStream.write(byteArrayOutputStream.toByteArray());
            ouputStream.flush();
            ouputStream.close();
        }catch(Exception ex) {
           	String connectMsg = "No se pudo crear el reporte " + ex.getMessage() + " " + ex.getLocalizedMessage();
            
           	StringWriter sw = new StringWriter();
			ex.printStackTrace(new PrintWriter(sw));
			connectMsg = connectMsg+"*******\n"+sw.toString();
           	
            java.util.Date fecha=new java.util.Date();
            SimpleDateFormat sdf=new SimpleDateFormat("dd/MM/yyyy H:mm:ss"); 
            generarLog(connectMsg,reportFile,sdf.format(fecha));
            
        }
	}
	
	
	public static void generarLog(String mensaje,String archivo, String fecha_hora){
		FileWriter salida=null;
		PrintWriter pw = null; 
		String linea="";

        try  {
            salida=new FileWriter("ReportDriverJavaLog.txt",true);
            pw = new PrintWriter(salida); 
            linea=archivo+"------>"+fecha_hora;
            pw.println(mensaje);
            pw.println("");
            pw.println(linea);
            pw.println("");
            pw.println("/*****************************************NUEVA TRANSACCION***************************************/");
            
       }catch (IOException ex) {
            System.out.println(ex);
       }finally{
			//cerrar los flujos de datos
            
            if(null!=salida){
                try{
                    salida.close();
                }catch(IOException ex){}
            }
            
       }

	}
	public static void main(String[] args) throws Exception{
	
		runner.waitFor();
    	System.exit(0);        
    }
    
  
}





/*Ejemplo de uso para casos de generar todo tipo de reportes
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStream;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import net.sf.jasperreports.engine.JRExporterParameter;
import net.sf.jasperreports.engine.JasperCompileManager;
import net.sf.jasperreports.engine.JasperExportManager;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.JasperReport;
import net.sf.jasperreports.engine.export.JRCsvExporter;
import net.sf.jasperreports.engine.export.JRRtfExporter;
import net.sf.jasperreports.engine.export.JRXlsExporter;
import net.sf.jasperreports.engine.export.JRXlsExporterParameter;

public class Jasper {
    public Jasper() {
    }

    public static void main(String[] args) {
        Jasper jasper = new Jasper();
        Connection conn = null;

        //Cargamos el driver JDBC
            try {
              Class.forName("oracle.jdbc.driver.OracleDriver");
            }catch (ClassNotFoundException e) {
              System.out.println("JDBC Driver not found.");}
            try {
                String dburl = "jdbc:oracle:thin:@localhost:1521:XE";
                conn = DriverManager.getConnection(dburl,"user","pass");

            }catch (SQLException e){
              System.out.println("Error de conexión: " + e.getMessage());}

        JasperReport report;

        try {

            report = JasperCompileManager.compileReport("C:\\report.jrxml");

            JasperPrint print = JasperFillManager.fillReport(report, null, conn);

            //Exporta el informe a PDF
            String destFileNamePdf="C:\\trabajo\\reporte1.pdf";
            //Creación del PDF
            JasperExportManager.exportReportToPdfFile(print, destFileNamePdf);

           

            //Exporta el informe a HTML
             JasperExportManager.exportReportToHtmlFile(print, destFileNamePdf);

            //Exporta el informe a excel

            OutputStream ouputStream= new FileOutputStream(new File("C:/trabajo/catalog.xls"));
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

            JRXlsExporter exporterXLS = new JRXlsExporter();
            exporterXLS.setParameter(JRXlsExporterParameter.JASPER_PRINT,print);
            exporterXLS.setParameter(JRXlsExporterParameter.OUTPUT_STREAM,byteArrayOutputStream);

            exporterXLS.exportReport();

            ouputStream.write(byteArrayOutputStream.toByteArray());
            ouputStream.flush();
            ouputStream.close();

            //Exporta el informe a csv

            String destFileNamePdf="C:\\trabajo\\reporte1.csv";
            JRCsvExporter exporter = new JRCsvExporter();
            File destFile = new File(destFileNamePdf);

            exporter.setParameter(JRExporterParameter.JASPER_PRINT, print);
            exporter.setParameter(JRExporterParameter.OUTPUT_FILE_NAME,
            destFile.toString());

            exporter.exportReport();

            //Exporta el informe a rtf

            OutputStream ouputStream= new FileOutputStream(new File("C:/trabajo/catalog.rtf"));
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();

            JRRtfExporter exporter = new JRRtfExporter();
            exporter.setParameter(JRExporterParameter.JASPER_PRINT, print);
            exporter.setParameter(JRExporterParameter.OUTPUT_STREAM, ouputStream);

            exporter.exportReport();

            ouputStream.write(byteArrayOutputStream.toByteArray());
            ouputStream.flush();
            ouputStream.close();

            

        } catch (Exception e) {System.out.println("Error"+e);}

    }
}


*/





