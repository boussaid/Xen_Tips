<?php

namespace Boussaid\Tips\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Tips extends Entity
{
      public function canEdit()
      {
        return true;
      }
	
	public static function getStructure(Structure $structure)
	{
		$options = \XF::options();
		$structure->table = 'xf_bm_tips';
		$structure->shortName = 'Boussaid\Tips\XF:Tips';
		$structure->contentType = 'tips';
		$structure->primaryKey = 'tip_id';
		$structure->columns = [
			'tip_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'tip_date' => ['type' => self::UINT, 'required' => true, 'default' => \XF::$time],
			'tip_title' => ['type' => self::STR, 'maxLength' => '20'],
			'tip_message' => ['type' => self::STR, 'maxLength' => '450', 'required' => 'please_enter_valid_tip'],
			'active' => ['type' => self::BOOL, 'default' => true]
		];
		$structure->getters = [];
		$structure->relations = [];
		
		return $structure;
	}
}