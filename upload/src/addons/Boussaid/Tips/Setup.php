<?php

namespace Boussaid\Tips;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use \XF\AddOn\StepRunnerInstallTrait;
	use \XF\AddOn\StepRunnerUpgradeTrait;
	use \XF\AddOn\StepRunnerUninstallTrait;

	public function install(array $stepParams = [])
	{
		$this->schemaManager()->createTable('xf_bm_tips', function(Create $table)
		{
			$table->addColumn('tip_id','int', 10)->autoIncrement();
			$table->addColumn('tip_date', 'int', 10);
			$table->addColumn('tip_title', 'varchar', 20);
			$table->addColumn('tip_message', 'mediumtext');
			$table->addColumn('active', 'tinyint', 3)->setDefault(1);
			$table->addPrimaryKey('tip_id');
			$table->addKey('tip_date');
		});
	}

	public function upgrade(array $stepParams = [])
	{
		// TODO: Implement upgrade() method.
	}

	public function uninstall(array $stepParams = [])
	{
		$this->schemaManager()->dropTable('xf_bm_tips');
	}
}