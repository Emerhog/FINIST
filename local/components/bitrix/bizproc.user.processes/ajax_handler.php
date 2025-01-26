<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require $_SERVER["DOCUMENT_ROOT"] . '/local/lib/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Bitrix\Main\Loader;

Loader::includeModule('bizproc');

global $USER;
$currentUserId = $USER->GetID();

$taskService = new CBPTaskService();
$tasks = $taskService->GetList(
    ['ID' => 'ASC'], // Сортировка по ID
    ['USER_ID' => $currentUserId, 'STATUS' => CBPTaskStatus::Running], // Фильтр
    false, // Параметры группировки
    false, // Параметры навигации
    ['NAME', 'DESCRIPTION', 'WORKFLOW_ID', 'DOCUMENT_NAME'] // Поля для выборки
);

$taskArray = [];
while ($task = $tasks->Fetch()) {
    $taskArray[] = $task;
}

var_dump($taskArray); //Готовый массив

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Название');
$sheet->setCellValue('B1', 'Описание');
$sheet->setCellValue('C1', 'ID бп');
$sheet->setCellValue('D1', 'Название документа');

$row = 2;
foreach ($taskArray as $task) {
    $sheet->setCellValue('A' . $row, $task['NAME']);
    $sheet->setCellValue('B' . $row, $task['DESCRIPTION']);
    $sheet->setCellValue('C' . $row, $task['WORKFLOW_ID']);
    $sheet->setCellValue('D' . $row, $task['DOCUMENT_NAME']);
    $row++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="BPtasks.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;