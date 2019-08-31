<?php

namespace Boussaid\Tips\XF\Finder;

use XF\Mvc\Entity\Finder;

class Tips extends Finder
{
	public function orderByDate($direction = 'DESC')
	{		
		$this->setDefaultOrder('tip_date', $direction);
		return $this;
	}
}