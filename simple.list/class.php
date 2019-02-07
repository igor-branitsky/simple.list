<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
Bitrix\Highloadblock as HL,
Bitrix\Main\Entity;

class FLXMD_SimpleElements extends CBitrixComponent
{

	private $arFilter = ['ACTIVE' => 'Y'];

	public function executeComponent()
	{
		if (Loader::includeModule("iblock")) {

			if ($this->StartResultCache(36000000)) {

				if (empty($this->arParams['IBLOCK_ID']) || $this->arParams['IBLOCK_ID'] === 'not') {
					$this->AbortResultCache();
					ShowError(GetMessage("FLXMD_SIMPLE_ELEMENT_NOT_PARAMS"));
					return;
				}

				if (!is_array($this->arParams['ELEMENTS_ID'])) {
					$this->arParams['ELEMENTS_ID'] = explode(',', $this->arParams['ELEMENTS_ID']);
				} else if($this->arParams['ELEMENTS_ID']){
					$this->arParams['ELEMENTS_ID'] = array_unique(array_diff(explode(',', implode(',', $this->arParams['ELEMENTS_ID'])),  ['', ' ']));
				}

				$this->arFilter['IBLOCK_ID'] = $this->arParams["IBLOCK_ID"];

				if(!empty($this->arParams['SECTIONS_ID']) && $this->arParams['SECTIONS_ID'] !== 'not' && empty($this->arParams['ELEMENTS_ID'])) {

					$this->arFilter['SECTIONS_ID'] = $this->arParams["SECTIONS_ID"];

				} else if(!empty($this->arParams['ELEMENTS_ID'])) {

					$this->arFilter['ID'] = $this->arParams['ELEMENTS_ID'];

				}

				if (!empty($this->arFilter)) {

					$dbElements = CIBlockElement::GetList(
						['SORT' => 'ASC'],
						$this->arFilter
					);

					while($objElements = $dbElements->GetNextElement()) {

						$arFields = $objElements->GetFields();
						$arProps = $objElements->GetProperties();

						$arButtons = CIBlock::GetPanelButtons(
							$arFields["IBLOCK_ID"],
							$arFields["ID"],
							0,
							["SECTION_BUTTONS" => false, "SESSID " => false]
						);

						$arFields["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
						$arFields["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

						$this->arResult['ITEMS'][] = array_merge($arFields, $arProps);

					}

				}

				$this->IncludeComponentTemplate();
			}

		} else {
			ShowError(GetMessage("FLXMD_SIMPLE_ELEMENT_IN_MODULE_NOT_FOUND"));
			return;
		}

	}

}