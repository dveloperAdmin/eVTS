<?php
include "include/xlsxgen.php";
      
$table_formate =[
      ['Sl_NO','Employee_Code','Employee_Name','Company_Name','Branch','Department','Sub_Department','Designation','Location','Employee_Type','Category','Contact']

];        // $datatable = emp_table();
$xlsx = SimpleXLSXGen::fromArray($table_formate);
$xlsx->downloadAs('Employee_details.xlsx');
?>
