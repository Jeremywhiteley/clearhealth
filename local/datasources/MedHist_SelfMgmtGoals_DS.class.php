<?php
$loader->requireOnce('includes/Datasource_sql.class.php');

/**
 * Displays a person's self management goals
 *
 * @package com.clearhealth.base
 */
class MedHist_SelfMgmtGoals_DS extends Datasource_sql {
	/**
	 * {@inheritdoc}
	 */
	var $_internalName = 'MedHist_SelfMgmtGoals_DS';
	
	/**
	 * The default output type for this datasource.
	 *
	 * @var string
	 */
	var $_type = 'html';
	
	var $_personId = '';
	
	function MedHist_SelfMgmtGoals_DS($person_id) {
		$this->_personId = $person_id;
		
		$qPersonId = clniDB::quote($person_id);
		$this->setup(Celini::dbInstance(),
			array(	'cols' 	=> "
						type, initiated, completed,last_edit
						 ",
				'from' 	=> "self_mgmt_goals smg",

				'where'	=> "smg.person_id = {$qPersonId} and completed = '0000-00-00'",
				'orderby'=> "initiated DESC")
			,
			array(
				'type' => 'Goal','initiated' => "Initiated", 'completed' => 'Completed', 'last_edit' => 'Last Edit'
			)
		);
		
		//echo $this->preview();exit;
		$this->registerFilter('type', array(&$this, '_lookup'));
	}
	
	
	
	
	function _lookup($value) {
		$em =& Celini::enumManagerInstance();
		return $em->lookup('self_mgmt_goals', $value);
	}
	
	
}
?>
