<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Loader::includeModule("iblock");

$arTypeIBlockList = ['not' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_NOT_CHOSEN')];
$arIBlockList = ['not' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_NOT_CHOSEN')];
$arSectionList = ['not' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_NOT_CHOSEN')];
$arElementsList = [];

$dbTypeIBlock = CIBlockType::GetList(
	['NAME' => 'ASC'],
	[]
);

while ($arTypeIBlock = $dbTypeIBlock->Fetch()) {
	$arTypeIBlockList[$arTypeIBlock['ID']] = "[{$arTypeIBlock["ID"]}] {$arTypeIBlock["NAME"]}";
}

if (!empty($arCurrentValues["TYPE_IBLOCK"]) && $arCurrentValues["TYPE_IBLOCK"] != 'not') {

	$dbIBlock = CIBlock::GetList(
		['NAME' => 'ASC'],
		['TYPE' => $arCurrentValues["TYPE_IBLOCK"], 'ACTIVE' => 'Y'],
		false
	);

	while ($arIBlock = $dbIBlock->Fetch()) {

		$arIBlockList[$arIBlock["ID"]] = "[{$arIBlock["ID"]}] {$arIBlock["NAME"]}";

	}
}

if (!empty($arCurrentValues["IBLOCK_ID"]) && $arCurrentValues["IBLOCK_ID"] != 'not') {

	$dbSection = CIBlockSection::GetList(
		['NAME' => 'ASC'],
		['IBLOCK_ID' => $arCurrentValues["IBLOCK_ID"], 'ACTIVE' => 'Y', 'DEPTH_LEVEL' => '1'],
		false,
		['ID', 'NAME'],
		false
	);

	while ($arSection = $dbSection->Fetch()) {

		$arSectionList[$arSection["ID"]] = "[{$arSection["ID"]}] {$arSection["NAME"]}";

	}
}

if (!empty($arCurrentValues["IBLOCK_ID"]) && $arCurrentValues["IBLOCK_ID"] != 'not') {

	$arFilter = ['IBLOCK_ID' => $arCurrentValues["IBLOCK_ID"], 'ACTIVE' => 'Y'];

	if (!empty($arCurrentValues["SECTIONS_ID"]) && $arCurrentValues["SECTIONS_ID"] != 'not') {
		$arFilter['SECTION_ID'] = $arCurrentValues["SECTIONS_ID"];
	}

	$dbElements = CIBlockElement::GetList(
		['NAME' => 'ASC'],
		$arFilter,
		false,
		false,
		['ID', 'NAME']
	);

	while ($arElement = $dbElements->Fetch()) {

		$arElementsList[$arElement["ID"]] = "[{$arElement["ID"]}] {$arElement["NAME"]}";

	}
}

$arComponentParameters = array(
	'GROUPS' => array(),
	'PARAMETERS' => array(
		'TYPE_IBLOCK' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_TYPE_IBLOCK'),
			'TYPE' => 'LIST',
			'REFRESH' => 'Y',
			'VALUES' => $arTypeIBlockList,
		),
		'IBLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_IBLOCK_ID'),
			'TYPE' => 'LIST',
		    'REFRESH' => 'Y',
		    'VALUES' => $arIBlockList,
		),
		'SECTIONS_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_SECTIONS_ID'),
			'TYPE' => 'LIST',
			'REFRESH' => 'Y',
			'VALUES' => $arSectionList,
		),
		'ELEMENTS_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_SIMPLE_ELEMENTS_ELEMENTS_ID'),
			'TYPE' => 'LIST',
		    'VALUES' => $arElementsList,
		    'MULTIPLE' => 'Y',
		    'ADDITIONAL_VALUES' => 'Y',
		),
	),
);