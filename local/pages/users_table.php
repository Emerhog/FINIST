<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Таблица сотрудников");
use Bitrix\Highloadblock;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

Loader::includeModule('main');
Loader::includeModule('highloadblock');
?>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php'); ?>

<?php
$hlblockName = 'UsersList';
$hlblockData = Highloadblock\HighloadBlockTable::getList(
    ['filter' => ['=NAME' => $hlblockName]
    ])->fetch();

$hlblockId = $hlblockData['ID'];

$hlblock = Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();

$entity = Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$entityDataClass = $entity->getDataClass();

$rsData = $entityDataClass::getList([
    'select' => ['*'],
    'order' => ['ID' => 'ASC']
]);
?>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Должность</th>
        </tr>
        <?php while ($arItem = $rsData->fetch()): ?>
            <tr>
                <td><?= $arItem['ID'] ?></td>
                <td><?= $arItem['UF_NAME'] ?></td>
                <td><?= $arItem['UF_SURNAME'] ?></td>
                <td><?= $arItem['UF_POSITION'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>