# mysql-export-explode
Clase php para exportar tablas gigantes y dividir los resultados en varios archivos para hacer la tarea de exportacion e importacion mas fácil.


Ejemplo de uso

<?php
    
    # Including the class
    include 'mysql_export_explode.php';
    $export = new mysql_export_explode;
    
    
    $export->db = 'dataBaseName'; # -- Set your database name
	  $export->connect('host','user','password'); # -- Connecting to database
	  $export->rows = array('Id','firstName','Telephone','Address'); # -- Set which fields you want to export
	  $export->exportTable('myTableName',15); # -- Table name and in few fractions you want to split the table
	
	?>
	
	At the end of the SQL files are created in the directory where the script is executed in the following format
	---------------------------------------
	myTableName_0.sql
	myTableName_1.sql
	myTableName_2.sql
	 ...
