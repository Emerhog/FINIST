<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;

Loader::includeModule('main');
Loader::includeModule('highloadblock');
function getEmployees(){
    $result = UserTable::getList([
        'filter' => ['ACTIVE' => 'Y'],
        'select' => ['ID', 'NAME', 'LAST_NAME', 'WORK_POSITION'],
        'order' => ['LAST_NAME' => 'ASC']
    ]);

    $employees = [];
    while ($employee = $result->fetch()) {
        $employees[] = [
            'id' => $employee['ID'],
            'name' => $employee['NAME'],
            'surname' => $employee['LAST_NAME'],
            'position' => $employee['WORK_POSITION']
        ];
    }
    return $employees;
}

$hlblockData = [
    'NAME' => 'UsersList',
    'TABLE_NAME' => 'b_hlbk_users'
];

$result = Highloadblock\HighloadBlockTable::add($hlblockData); //result = object

if ($result->isSuccess()){
    echo "Highload блок создан!";

    $userTypeEntity = new CUserTypeEntity();

    $hlblockId = $result->getId();

    $userFields = [
        [
            'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
            'FIELD_NAME' => 'UF_NAME',
            'USER_TYPE_ID' => 'string',
            'MANDATORY' => 'Y'
        ],
        [
            'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
            'FIELD_NAME' => 'UF_SURNAME',
            'USER_TYPE_ID' => 'string',
            'MANDATORY' => 'N'
        ],
        [
            'ENTITY_ID' => 'HLBLOCK_' . $hlblockId,
            'FIELD_NAME' => 'UF_POSITION',
            'USER_TYPE_ID' => 'string',
            'MANDATORY' => 'N'
        ]
    ];

    foreach ($userFields as $userField) {
        $result = $userTypeEntity->Add($userField);
        if (!$result) {
            echo implode(', ', $result->getErrorMessages());
        }
    }

    $employees = getEmployees();

    $hlblock = Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();  //Получение массива данных о блоке
    $entity = Highloadblock\HighloadBlockTable::compileEntity($hlblock); //Компиляция ORM объекта блока для дальнейшей работы
    $entityDataClass = $entity->getDataClass(); //Возвращает имя класса `UsersListTable` для работы с CRUD: `add()`, `getList()`, `update()`, `delete()`

    foreach ($employees as $employee) {
        $result = $entityDataClass::add([
            'UF_NAME' => $employee['name'],
            'UF_SURNAME' => $employee['surname'],
            'UF_POSITION' => $employee['position']
        ]);

        if (!$result->isSuccess()) {
            echo "Ошибка при добавлении сотрудника " . implode(', ', $result->getErrorMessages());
        }
    }
} else {
    echo "Ошибка при создании Highload блока " . implode(', ', $result->getErrorMessages());
}