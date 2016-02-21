# mysql-export-explode
Clase php para exportar tablas mysql gigantes y dividir los resultados en varios archivos para hacer la tarea de exportacion e importacion mas fácil.


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


Multi table support
------------------
You can export multiple tables...

<?php
    # Including the class
	include 'mysql_export_explode.php';
	$export = new mysql_export_explode;
    
	$export->db = 'mysql_explode_test'; # -- Set your database name
	$export->connect('localhost','root','your password'); # -- Connecting to database
	$keys = array(
		'table1'=>array('id','row1_table1','row1_table1'),
		'table2'=>array('id','row1_table2','row1_table2')
		
	);

	foreach(array('table1','table2') as $t){
		$export->rows = $keys[$t]; # -- Set dinamicaly which fields you want to export
		$export->exportTable($t,2); # -- Table name and in few fractions you want to split the table
	}
?>
