<?php
require '../vendor/autoload.php'; // Make sure this path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;


function detailsReport($sql_for_v_log, $file_name)
{
  include '_dbconnect.php';
  include '_function.php';
  // $des = "Page Load visitor_log_report_process";
  // $rem = "Details Visitor Log Report Process";
  // include '../include/_audi_log.php';
  $i = 1;
  if (!$sql_for_v_log) {
    // Handle the case where $sql_for_v_log is null or empty
    die('Error: SQL result is empty.');
  }
  $columns = [
    'Sl No',
    'Visitor Log Id',
    'Visitor Id',
    'Visitor Name',
    'Govt. Id Type',
    'Govt. Id No',
    'Company Name',
    'Designation',
    'Mobile No',
    'Email ID',
    'Address',
    'Issued Id Card No',
    'Visitor Type',
    'Purpose',
    'Material Carried',
    'Vehicle Type',
    'Vehicle No',
    'Visited Branch',
    'Employee Code',
    'Employee Name',
    'Department',
    'Designation',
    'Check In Time',
    'Check Out Time',
    'Status',
    'Meeting End Time',
    'Meeting End Status',
    'Security Permission',
    'Employee Permission',
    'Visitor Image',
  ];

  $colum_name = [
    'i',
    'visit_uid',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'visitor_id',
    'id_card_no',
    'visitor_type',
    'visit_purpose',
    'things_brought',
    'vehical_type',
    'vahical_num',
    'branch_id',
    'emp_id',
    'emp_id',
    'emp_id',
    'emp_id',
    'visit_uid',
    'visit_uid',
    'check_status',
    'visit_uid',
    'meeting_status',
    'security_approval',
    'Emp_approve',
    'visit_uid',
  ];


  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  foreach ($columns as $key => $value) {
    $cell = $sheet->getCell([($key + 1), 1])->getCoordinate();
    $sheet->setCellValue($cell, $value);
    $sheet->getStyle($cell)->getFont()->setBold(true); // Make the text bold
    $sheet->getColumnDimensionByColumn($key + 1)->setAutoSize(true); // Auto-size the column
  }

  // Freeze the first row
  $sheet->freezePane('A2');

  $alternateImagePath = '../src/error.png'; // Path to the alternate image
  $no_data = mysqli_num_rows($sql_for_v_log);

  for ($i = 1; $i <= $no_data; $i++) {
    $log_data = mysqli_fetch_assoc($sql_for_v_log);
    for ($j = 0; $j < count($colum_name); $j++) {

      $cellAddress = $sheet->getCell([($j + 1), ($i + 1)])->getCoordinate();


      if ($colum_name[$j] != "") {
        $column = $colum_name[$j];
        if ($j == 0) {

          $sheet->setCellValue($cellAddress, $i);
        } else if (in_array($j, range(3, 10))) {
          $v_id = $log_data[$column];
          $v_details = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `visitor_info` WHERE `visitor_id` = '$v_id'"));
          switch ($j) {
            case 3:
              $sheet->setCellValue($cellAddress, ucfirst($v_details['name']));
              break;
            case 4:
              $sheet->setCellValue($cellAddress, ucfirst($v_details['govt_id_type']));
              break;
            case 5:
              $sheet->setCellValue($cellAddress, $v_details['govt_id_no']);
              break;
            case 6:
              $sheet->setCellValue($cellAddress, $v_details['com_name']);
              break;
            case 7:
              $sheet->setCellValue($cellAddress, $v_details['designation']);
              break;
            case 8:
              $sheet->setCellValue($cellAddress, $v_details['contact_no']);
              break;
            case 9:
              $sheet->setCellValue($cellAddress, $v_details['mail_id']);
              break;
            case 10:
              $sheet->setCellValue($cellAddress, $v_details['address']);
              break;
          }
        } else if ($j == 12) {
          $v_type_id = $log_data[$column];
          $v_type_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id`='$v_type_id'"));
          if (!empty($v_type_details)) {
            $typeName = $v_type_details['type_name'];
          }
          $sheet->setCellValue($cellAddress, $typeName ?? "Default");
        } else if ($j == 13) {
          $v_p_id = $log_data[$column];
          $purpose = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `visit_purpose` WHERE `purpose_id`='$v_p_id'"));
          $sheet->setCellValue($cellAddress, $purpose['purpose'] ?? "");
        } else if ($j == 17) {
          $sheet->setCellValue($cellAddress, ucfirst(findBranch($conn, $log_data[$column])));
        } else if (in_array($j, range(19, 21))) {
          $emp_code = $log_data[$column];
          $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `eomploye_details` WHERE `Emp_code` = '$emp_code'"));
          switch ($j) {
            case 19:
              if (!empty($emp_details)) {
                $empName = ucfirst($emp_details['EmployeeName']);
              } else {
                $empName = "Not Exist";
              }
              $sheet->setCellValue($cellAddress, $empName);
              break;
            case 20:
              if (!empty($emp_details)) {
                $dept = ucfirst(findDepartment($conn, $emp_details['DepartmentId']));
              } else {
                $dept = "Not Exist";
              }
              $sheet->setCellValue($cellAddress, $dept);
              break;
            case 21:
              if (!empty($emp_details)) {
                $dept = ucfirst(findDesig($conn, $emp_details['DesignationId']));
              } else {
                $dept = "Not Exist";
              }
              $sheet->setCellValue($cellAddress, $dept);

              break;

          }
        } else if (in_array($j, range(22, 23)) || $j == 25) {
          $v_lof_id = $log_data[$column];
          $timeing_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_log` where `visit_uid` = '$v_lof_id'"));
          switch ($j) {
            case 22:

              $inTime = $timeing_data['checkin_date'] . '  ' . $timeing_data['checkin_time'];

              $sheet->setCellValue($cellAddress, $inTime);
              break;
            case 23:
              $outTime = $timeing_data['checkout_date'] . '  ' . $timeing_data['checkout_time'];

              $sheet->setCellValue($cellAddress, $outTime);
              break;
            case 25:
              $meetingEnd = $timeing_data['meeting_end_date'] . '  ' . $timeing_data['meeting_end_time'];

              $sheet->setCellValue($cellAddress, $meetingEnd);

              break;
          }
        } else if ($j == (count($colum_name) - 1)) {
          $imagePath = '../upload/' . $log_data[$column] . '.png';
          // $sheet->setCellValue($cellAddress, $imagePath);
          if (!file_exists($imagePath)) {
            $imagePath = $alternateImagePath;
          }

          $drawing = new Drawing();
          $drawing->setName('Visitor Image');
          $drawing->setDescription('Visitor Image');
          $drawing->setPath($imagePath); // Path to your image
          $drawing->setHeight(85); // Height of the image
          $drawing->setCoordinates($cellAddress); // Setting the image in the cell
          $drawing->setOffsetX(0);
          $drawing->setOffsetY(0);
          $drawing->setWorksheet($sheet);
          $drawing->setResizeProportional(false);
          $sheet->getColumnDimensionByColumn($j + 1)->setWidth(8); // Adjust the width as needed
        } else {
          $sheet->setCellValue($cellAddress, $log_data[$column]);
        }
      }
    }
    $sheet->getRowDimension($i + 1)->setRowHeight(65.75);
  }

  $sheet->freezePane('E2');

  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();
  $sheet->getStyle('A1:' . $highestColumn . $highestRow)
    ->applyFromArray([
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
        ],
      ],
    ]);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="' . $file_name . '"');
  header('Cache-Control: max-age=0');

  $writer = new Xlsx($spreadsheet);
  $writer->save('php://output');
  exit;
}

// include '../include/_dbconnect.php';

// $from_date = "2021-01-01";
// $to_date = date("Y-m-d");

// $from_date .= " 00:00:01";
// $to_date .= " 23:59:59";

// $sql = "SELECT * FROM `visitor_log` WHERE `register_time_stamp` BETWEEN '$from_date' AND '$to_date'";
// $sql_for_v_log = mysqli_query($conn, $sql);
// $file_name = 'Details_report_of ' . date("d-m-Y", strtotime($from_date)) . ' to ' . date("d-m-Y", strtotime($to_date)) . '.xlsx';
// detailsReport($sql_for_v_log, $file_name);