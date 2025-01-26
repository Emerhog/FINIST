<?php
use Bitrix\Main\ModuleManager;

class highloadusers extends CModule
{
    var $MODULE_ID = "highloadusers";
    var $MODULE_NAME = "Highload блок пользователей";
    var $MODULE_DESCRIPTION = "Модуль для установки highload блока и добавления в него пользователей";

    function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__ . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->PARTNER_NAME = "Evgeny Vasiev";
        $this->PARTNER_URI = "https://myworkbitrix24.ru/";
    }

    function DoInstall()
    {
        global $APPLICATION;
        ModuleManager::registerModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Установка модуля", $_SERVER["DOCUMENT_ROOT"]."/local/modules/highloadusers/install/step.php");
    }

    function DoUninstall()
    {
        global $APPLICATION;
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Удаление модуля", $_SERVER["DOCUMENT_ROOT"]."/local/modules/highloadusers/install/unstep.php");
    }
}