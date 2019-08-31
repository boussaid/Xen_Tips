<?php

namespace Boussaid\Tips\XF\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Tips extends Repository
{
	/**
	 * @return Finder
	 */
	public function findTips()
	{
		return $this->finder('Boussaid\Tips\XF:Tips')
		->orderByDate('DESC');	
	}
	
	/**
	 * @return Finder
	 */
	public function findActiveTips()
	{
		return $this->findTips()
			->where('active', 1);
	}
}