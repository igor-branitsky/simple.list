<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("FLXMD_SIMPLE_ELEMENT_NAME"),
	"DESCRIPTION" =>  Loc::getMessage('FLXMD_SIMPLE_ELEMENT_DESCRIPTION'),
	"CACHE_PATH" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "FLXMD",
		"NAME" =>  Loc::getMessage('FLXMD_SIMPLE_ELEMENT_PATH'),
	),
);
?>