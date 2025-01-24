<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule('bizproc');

global $USER;
$currentUserId = $USER->GetID();

$taskService = new CBPTaskService();
$tasks = $taskService->GetList(
    ['ID' => 'ASC'], // Сортировка по ID, // Сортировка
    ['USER_ID' => $currentUserId, 'STATUS' => CBPTaskStatus::Running], // Фильтр
    false, //Параметры группировки
    false, //Параметры навигации
    ['NAME', 'DESCRIPTION', 'WORKFLOW_ID', 'DOCUMENT_NAME'] //Поля для выборки
);

$taskArray = [];
while ($task = $tasks->Fetch()) {
    $taskArray[] = $task;
}

echo '<pre>';
print_r($taskArray);
echo '</pre>';
