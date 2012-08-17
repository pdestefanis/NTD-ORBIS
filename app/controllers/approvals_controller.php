<?php
class ApprovalsController extends AppController {

	const NOT_APPROVED = 0;
	const APPROVED     = 1;
	const ALL          = 2;

	var $name = 'Approvals';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->AuthExt->allow(array('restIndex', 'restApproval')); 
	}
	
	function index($strFilter = null) 
	{

		App::import('Controller', 'Users');
		App::import('Controller', 'Locations');
		App::import('Controller', 'Stats');

		$stats = new StatsController;
		$stats->constructClasses();

		$location = new LocationsController;
		$location->constructClasses();

		// get current location id
		$users = new UsersController;
		$users->constructClasses();
		$user = $users->AuthExt->user();
		$location_id = $user['User']['location_id'];

		$user_reach = $user['User']['reach'];

		if ($user_reach != 0)
		{
			for ( $i = 0; $i < $user_reach; $i++)
			{
				$this_location = $location->Location->read(null, $location_id);
				if ( $this_location['Location']['parent_id'] != 0)
					$location_id = $this_location['Location']['parent_id'];
			}
		}

		$all = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::ALL
		));

		$all = $location->setAggregates($all);
		$all = $location->flattenTree($all);
		$all = $location->arrayToHash($all);
		$this->set('all', $all);

		$approved = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::APPROVED
		));

		$approved = $location->setAggregates($approved);
		$approved = $location->flattenTree($approved);
		$approved = $location->arrayToHash($approved);
		$this->set('approved', $approved);

	}

	function pending()
	{
		
		App::import('Controller', 'Users');
		App::import('Controller', 'Locations');
		App::import('Controller', 'Stats');

		$stat = new StatsController;
		$stat->constructClasses();
		
		$this->set( 'live_inventory', $stat->aggregatedInventory() );

		$users = new UsersController;
		$users->constructClasses();
		$user = $users->AuthExt->user();
		$location_id = $user['User']['location_id'];

		$location = new LocationsController;
		$location->constructClasses();

		$user_reach = $user['User']['reach'];
		
		if ($user_reach != 0)
		{
			for ( $i = 0; $i < $user_reach; $i++)
			{
				$this_location = $location->Location->read(null, $location_id);
				if ( $this_location['Location']['parent_id'] != 0)
					$location_id = $this_location['Location']['parent_id'];
			}
		}

		$all = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::ALL
		));

		$all = $location->setAggregates($all);
		$all = $location->flattenTree($all);
		$all = $location->arrayToHash($all);
		$this->set('all', $all);

		$pending = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::NOT_APPROVED
		));

		$pending = $location->setAggregates($pending);
		$pending = $location->flattenTree($pending);
		$pending = $location->arrayToHash($pending);
		$this->set('pending', $pending);

		$approved = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::APPROVED
		));

		$approved = $location->setAggregates($approved);
		$approved = $location->flattenTree($approved);
		$approved = $location->arrayToHash($approved);
		$this->set('approved', $approved);

	}

	function restIndex ($pId = 0)
	{
		$this->autoRender = false;

		if ($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']) return;
		
		App::import('Controller', 'Phones');
		App::import('Controller', 'Users');
		App::import('Controller', 'Locations');

		$phones = new PhonesController;
		$phones->constructClasses();
		$phone = $phones->Phone->read(null, $pId);

		$location_id = $phone['Phone']['location_id'];
		$location = new LocationsController;
		$location->constructClasses();

		$users = new UsersController;
		$users->constructClasses();

		$user = $users->User->find("list", array(
			"conditions" => array("phone_id" => $pId), 
			"recursive"  => -1, 
			"fields"     => array("User.reach")
		));
			
		if ( ! empty($user) )
		{
			$user_reach = array_shift(array_values($user));
			if ($user_reach != 0)
			{
				for ( $i = 0; $i < $user_reach; $i++)
				{
					$this_location = $location->Location->read(null, $location_id);
					if ( $this_location['Location']['parent_id'] != 0)
						$location_id = $this_location['Location']['parent_id'];
				}
			}
		}

		$pending = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::NOT_APPROVED
		));


		$pending = $location->setAggregates($pending);

		$pending = $location->flattenTree($pending);
		$pending = $location->arrayToHash($pending);

		$quit = false;
		echo "Pending \n";
		$items = array();
		
		$location = $pending[$location_id];
		foreach ($location as $key => $item)
		{
			$name = $item['total_items'][$key]['name'];
			$quantity = $item['total_items'][$key]['quantity'];
			$code = $item['total_items'][$key]['icode'];

			array_push($items, "$name($code): $quantity");
		}

		echo implode("\n", $items);
	}
	
	function restApprove($mId=null, $pId=null, $iCode=null)
	{
		$this->autoRender = false;
		if ($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']) return;

		echo "m:$mId, pid:$pId, iCode:$iCode";
		App::import('Controller', 'Phones');
		App::import('Controller', 'Users');
		App::import('Controller', 'Locations');

		$phones = new PhonesController;
		$phones->constructClasses();
		$phone = $phones->Phone->read(null, $pId);

		$location_id = $phone['Phone']['location_id'];

		$location = new LocationsController;
		$location->constructClasses();

		$users = new UsersController;
		$users->constructClasses();

		$user = $users->User->find("list", array(
			"conditions" => array("phone_id" => $pId), 
			"recursive"  => -1, 
			"fields"     => array("User.reach")
		));
			
		if ( ! empty($user) )
		{
			$user_reach = array_shift(array_values($user));
			if ($user_reach != 0)
			{
				for ( $i = 0; $i < $user_reach; $i++)
				{
					$this_location = $location->Location->read(null, $location_id);
					if ( $this_location['Location']['parent_id'] != 0)
						$location_id = $this_location['Location']['parent_id'];
				}
			}
		}

		$location = new LocationsController;
		$location->constructClasses();

		$pending = $location->getChildTree( $location_id, array(
			'depth' => 1,
			'parent' => null,
			'approvalState' => self::NOT_APPROVED
		));

		$pending = $location->setAggregates($pending);
		$pending = $location->flattenTree($pending);
		$pending = $location->arrayToHash($pending);


		$quit = false;
		$all_stats_ids = array();
		echo "Approved\n ";
		$location = $pending[$location_id];
		foreach ($location as $key => $item)
		{
			if ($item['total_items'][$key]['icode'] == $iCode || $iCode == "ALL")
			{

				$name = $item['total_items'][$key]['name'];
				$quantity = $item['total_items'][$key]['quantity'];
				$all_stats_ids = array_merge($all_stats_ids, $item['local_items'][$key]['stat_ids']);
				$all_stats_ids = array_merge($all_stats_ids, $item['aggregate_items'][$key]['stat_ids']);
				echo "$name: $quantity";
			}
		}

		echo "\n stats ids: ". implode(",",$all_stats_ids);
	}

	function approvalsByLocation()
	{
		$allApprovals = $this->Approval->find('all');
		$approvalsByLocation = array();
		foreach ($allApprovals as $approvalsStats) {
			foreach ($approvalsStats['Stat'] as $approvalStat) {
				if (isset($approvalsByLocation[$approvalStat['location_id']])) {
					$approvalsByLocation[$approvalStat['location_id']][$approvalStat['item_id']] = array(
						"created" => $approvalStat['created']
					);
				} else {
					$approvalsByLocation[$approvalStat['location_id']] = array();
					$approvalsByLocation[$approvalStat['location_id']][$approvalStat['item_id']] = array(
						"created" => $approvalStat['created']
					);
				}
			}
		}
		return $approvalsByLocation;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid approval', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('approval', $this->Approval->read(null, $id));
		$this->set('locations', $this->Approval->Stat->Location->find('list', array ('conditions' => array('Location.deleted = 0'))));
		$this->set('items', $this->Approval->Stat->Item->find('list'));
	}

	public function add()
	{
		App::import('Controller', 'Users');
		$users = new UsersController;
		$users->constructClasses();
		$user = $users->AuthExt->user();
		$user_id = $user['User']['id'];
		
		if (isset($this->params['form']['stat_ids']))
		{
			$stat_ids = explode( ",", $this->params['form']['stat_ids'] );
			$this->data = array(
				"Approval" => array( "user_id" => $user_id ),
				"Stat"     => array( "Stat" => $stat_ids )
			);
		}
		

		if (!empty($this->data)) {

			$this->Approval->create();
			if ($this->Approval->save($this->data)) {
				$this->Session->setFlash(__('The approval has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approval could not be saved. Please, try again.', true));
			}

		}
		
		$messagereceiveds = $this->Approval->Messagereceived->find('list');
		$users = $this->Approval->User->find('list');
		$stats = $this->Approval->Stat->find('list');
		$this->set(compact('messagereceiveds', 'users', 'stats'));
		
	}

	private function approve(){
		$this->Session->setFlash('Approved successfully', 'flash_success');
		$this->redirect( '/' );
	}

	private function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid approval', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Approval->save($this->data)) {
				$this->Session->setFlash(__('The approval has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approval could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Approval->read(null, $id);
		}
		$messagereceiveds = $this->Approval->Messagereceived->find('list');
		$users = $this->Approval->User->find('list');
		$stats = $this->Approval->Stat->find('list');
		$this->set(compact('messagereceiveds', 'users', 'stats'));
	}

	private function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for approval', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Approval->delete($id)) {
			$this->Session->setFlash(__('Approval deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Approval was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>