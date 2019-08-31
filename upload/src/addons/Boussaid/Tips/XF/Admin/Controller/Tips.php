<?php

namespace Boussaid\Tips\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;

class Tips extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('tips');
	}
	
	public function actionIndex(ParameterBag $params)
	{
		$repo = $this->repository('Boussaid\Tips\XF:Tips');
		$finder = $repo->findTips();
		$tip = $finder->fetch();
		
		$viewParams = [
			'tip' => $tip
		];
		return $this->view('Boussaid\Tips\XF:Tips\Listing', 'bm_tips_list', $viewParams);
	}
	
	protected function tipAddEdit(\Boussaid\Tips\XF\Entity\Tips $tip)
	{
		$visitor = \XF::visitor();
		$tipEditor = $this->service('Boussaid\Tips\XF:Editor', $visitor);
		$viewParams = [
			'tips' => $tip,
			'disabledButtons' => $tipEditor->getDisabledEditorButtons()
		];
		return $this->view('Boussaid\Tips\XF:Tips\Edit', 'bm_tips_edit', $viewParams);
	}

	public function actionAdd()
	{
		$tip = $this->em()->create('Boussaid\Tips\XF:Tips');
		return $this->tipAddEdit($tip);
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$tip = $this->assertTipsExists($params['tip_id']);
		return $this->tipAddEdit($tip);
	}
	protected function pageSaveProcess(\Boussaid\Tips\XF\Entity\Tips $tip)
	{
		$entityInput = $this->filter([
			'tip_title' => 'str',
			'active' => 'bool'
			]);
		$entityInput['tip_message'] = $this->plugin('XF:Editor')->fromInput('tip_message');
		
		$form = $this->formAction();
		$form->basicEntitySave($tip, $entityInput);

		//$extraInput = $this->filter([]);
		return $form;
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params['tip_id'])
		{
			$tip = $this->assertTipsExists($params['tip_id']);
		}
		else
		{
			$tip = $this->em()->create('Boussaid\Tips\XF:Tips');
		}

		$form = $this->pageSaveProcess($tip);
		$form->run();

		return $this->redirect($this->buildLink('tips-admin') . $this->buildLinkHash($tip->tip_id));
	}

	public function actionDelete(ParameterBag $params)
	{
		$tip = $this->assertTipsExists($params['tip_id']);
		if (!$tip->canEdit())
		{
			return $this->error(\XF::phrase('item_cannot_be_deleted_associated_with_addon_explain'));
		}

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$tip,
			$this->buildLink('tips-admin/delete', $tip),
			$this->buildLink('tips-admin/edit', $tip),
			$this->buildLink('tips-admin'),
			$tip->tip_message
		);
	}

	public function actionToggle()
	{
		/** @var \XF\ControllerPlugin\Toggle $plugin */
		$plugin = $this->plugin('XF:Toggle');
		return $plugin->actionToggle('Boussaid\Tips\XF:Tips');
	}
		
	protected function assertTipsExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('Boussaid\Tips\XF:Tips', $id, $with, $phraseKey);
	}
}