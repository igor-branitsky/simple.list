<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<?if (!empty($arResult['ITEMS'])):?>

	<?foreach ($arResult['ITEMS'] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage("FLXMD_SIMPLE_ELEM_TMP_DELETE")));
		?>
		<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?=$arItem['ID'];?> - <?=$arItem['NAME'];?>
		</div>
	<?endforeach;?>

<?endif;?>