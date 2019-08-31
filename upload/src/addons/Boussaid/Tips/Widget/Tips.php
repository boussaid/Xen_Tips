<?php

namespace Boussaid\Tips\Widget;

use XF\Widget\AbstractWidget;

class Tips extends AbstractWidget {

    public function render()
    {
        $repo = $this->repository('Boussaid\Tips\XF:Tips');
		$finder = $repo->findActiveTips();
		$tip = $finder->fetch();
		
		$viewParams = [
			'tip' => $tip
		];
		return $this->renderer('random_tips', $viewParams);
    }

}