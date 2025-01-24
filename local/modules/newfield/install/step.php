<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule('crm');

$userTypeEntity = new CUserTypeEntity();

$arFields = [
    'ENTITY_ID' => 'CRM_DEAL',
    'FIELD_NAME' => 'UF_CRM_NEW_FIELD',
    'USER_TYPE_ID' => 'enumeration',
    'XML_ID' => 'UF_CRM_NEW_FIELD',
    'SORT' => 100,
    'MULTIPLE' => 'N',
    'MANDATORY' => 'N',
    'SHOW_FILTER' => 'E',
    'SHOW_IN_LIST' => 'Y',
    'EDIT_IN_LIST' => '',
    'IS_SEARCHABLE' => 'Y',
    'SETTINGS' => [],
    'EDIT_FORM_LABEL' => [
        'ru' => 'Новое поле', // Название поля в форме редактирования
        'en' => 'New Field',
    ],
    'LIST_COLUMN_LABEL' => [
        'ru' => 'Новое поле', // Название колонки в списке
        'en' => 'New Field',
    ],
    'LIST_FILTER_LABEL' => [
        'ru' => 'Новое поле', // Название поля в фильтре
        'en' => 'New Field',
    ],
];

$userTypeId = $userTypeEntity->Add($arFields);

$enum = new CUserFieldEnum(); //Класс с методами для перечислений в списке. (GetList, SetEnumValues, DeleteFieldEnum)
$enum->SetEnumValues($userTypeId, [
    'n0' => ['VALUE' => 'Тест1', 'DEF' => 'N', 'SORT' => 100], //n0 - это временны идентификатор (не добавляется в БД), DEF - значение по умолчанию Y/N
    'n1' => ['VALUE' => 'Тест2', 'DEF' => 'N', 'SORT' => 200],
    'n2' => ['VALUE' => 'Тест3', 'DEF' => 'N', 'SORT' => 300],
]);
