<?php
use Bitrix\Main\ModuleManager;

class newfield extends CModule
{
    var $MODULE_ID = "newfield";
    var $MODULE_NAME = "Highload блок создания нового типа поля в CRM";
    var $MODULE_DESCRIPTION = "Модуль для создания нового типа пользовательского поля в CRM с выпадающим селектором";

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
        $APPLICATION->IncludeAdminFile("Установка модуля", $_SERVER["DOCUMENT_ROOT"]."/local/modules/newfield/install/step.php");
    }

    function DoUninstall()
    {
        global $APPLICATION;
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Удаление модуля", $_SERVER["DOCUMENT_ROOT"]."/local/modules/newfield/install/unstep.php");
    }
}