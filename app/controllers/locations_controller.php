<?php
class LocationsController extends AppController {

	var $name = 'Locations';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');


	function beforeRender() {
			if ($this->action == 'view'){
				
					if (!in_array($this->viewVars['location']['Location']['id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/locations/index', null, false);
					} 
			}
			if ($this->action == 'edit'){
					if (!in_array($this->data['Location']['id'], $this->Session->read("userLocations") )) { //edit
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/locations/index', null, false);
					} 
			}
	}	
   
	function index() {
		$this->Location->recursive = 0;
		$this->paginate['Location'] = array('order' => 'Location.name ASC');
		
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Location'] = array('order' => 'Location.name Asc',
										'conditions'=>array( 
											"OR" => array("Location.name LIKE "=>"%".$search."%", 
													"Location.shortname LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('locations', $this->paginate());
		$locs = $this->Location->find('list', array ('callbacks' => false));
		$this->set('parents', $locs);
		foreach (array_keys($locs) as $l) {
			$level =0;
			$this->findLevel($l, $level);
			$locs[$l] = $level;
		}
		$this->set('levels', $locs);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('location', $this->Location->read(null, $id));
		$roles = $this->Location->User->Role->find('list');
		$this->set('roles', $roles);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Location->create();
			if ($this->Location->save($this->data)) {
				//add location to session
				$newLocations = $this->Session->read("userLocations");
				$newLocations[] = $this->Location->getLastInsertID();
				$this->Session->write("userLocations", $newLocations);
			
				$this->Session->setFlash('The location has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
			}
		}
		
		
		$par = $this->Location->Parent->find('list', array('conditions' => array ('deleted' => 0), 'order' => array('name' => 'ASC')));	   
		$parents = array();
		$parents[0] = 'No Parent';
		foreach ($par as $key => $lname)
			$parents[$key] = $lname;
		$this->set('parents', $parents);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash('The location has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Location->read(null, $id);
			$children = array();
			$this->findLocationChildren ($id, $children);
			if (!empty($children))
				$par= $this->Location->Parent->find('list', array('callbacks' => 'false','conditions' => array ('id not in (' . implode(',', $children) . ')', 'deleted' => 0), 'order' => array('name' => 'ASC')));
			else
				$par= $this->Location->Parent->find('list', array('callbacks' => 'false','conditions' => array ('id not in (' .  $id . ')', 'deleted' => 0), 'order' => array('name' => 'ASC')));
			$parents = array();
			$parents[0] = 'No Parent';
			foreach ($par as $key => $lname)
				$parents[$key] = $lname;
			$this->set('parents', $parents);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for location', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Location->delete($id)) {
			$this->Session->setFlash('Location deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Location->data['softDel'] == 1) { //soft deletion give success message
			//remove deleted location from session
			$newLocations = array();
			foreach ($this->Session->read("userLocations") as $l) {
				if ($l != $id)
					$newLocations[] = $l;
				
			}
			$this->Session->write("userLocations", $newLocations);
			
			$this->Session->setFlash('Location deleted' , 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Location was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function getChildTree( $location_id = null, $options = array()) 
	{
		

		if ( $location_id === null ) return null;

		$result = array();

		$children = $this->Location->find('list', array('callbacks' => 'false', 'conditions' => array( 'parent_id' => $location_id, 'deleted = 0')));

		if ( count( $children ) === 0 ) {

			return null;

		} else {

			foreach ( array_keys( $children ) as $child )
			{

				$grandchildren = $this->getChildTree( $child , array(
					'depth'       => $options['depth'] + 1,
					'parent'      => $location_id,
					'approvalState' => $options['approvalState']
				));

				$attrs = $this->getLocalAttributes( $child, $options['approvalState'] );
				$result[$child] = array(
					'parent'      => $location_id,
					'lid'         => $child,
					'depth'       => $options['depth'] + 1,
					'lname'       => $attrs['lname'],
					'local_items' => $attrs['items'],
					'children'    => $grandchildren
				);
			}
		}

		if ( $options['depth'] == 1 )
		{

			$attrs = $this->getLocalAttributes( $location_id, $options['approvalState'] );

			$this_location = $this->Location->read(null,$location_id);
			
			
			$root = array(
				'parent'      => $this_location['Location']['parent_id'],
				'lid'         => $location_id,
				'depth'       => $options['depth'],
				'lname'       => $attrs['lname'],
				'local_items' => $attrs['items'],
				'children'    => $result
			);
			return $root;
		} else
		{
			return $result;
		}
	}

	function getLocalAttributes( $location_id, $approvalState = 2)
	{

		App::import('Controller', 'Stats');
		$stat = new StatsController;
		$stat->constructClasses();
		
		App::import('Controller', 'Approvals');
		$approvals = new ApprovalsController;
		$approvals->constructClasses();
		
		App::import('Controller', 'Users');
		$usersController = new UsersController;
		$usersController->constructClasses();
		
		$users = $usersController->User->find("all");
		$userNames = array();
		foreach ($users as $user)
			$userNames[$user['User']['id']] = $user['User']['name'];

		$items       = array();
		$stat_ids    = array();
		$local_stats = array();

		$thisLocation = $this->Location->findById( $location_id );

		$facility = $thisLocation['Location']['name'];

		if ( $approvalState == 1 )
		{
			$approved_list = $stat->Stat->findAllByLocationId( $location_id );
			foreach ( $approved_list as $one_approval ) 
			{
				if (count($one_approval['Approval']) != 0)
					array_push( $local_stats, $one_approval );
			}
		} else if ( $approvalState == 0 )
		{
			$pending_stats = $stat->Stat->findAllByLocationId( $location_id );
			foreach ( $pending_stats as $one_approval ) 
			{
				if (count($one_approval['Approval']) == 0)
					array_push( $local_stats, $one_approval );
			}
		} else
		{
			$local_stats = $stat->Stat->findAllByLocationId( $location_id );
		}

		$last_updated = "";

		foreach ( $local_stats as $one_stat ) 
		{

			$last_approval = "";
			$approver      = "";
			$quantity      = 0;
			
			if ( strtotime($one_stat['Stat']['created']) > $last_updated)
			{
				$last_updated = strtotime($one_stat['Stat']['created']);
				$last_stat    = $one_stat['Stat']['id'];
			}
			$last_updated = max(strtotime($one_stat['Stat']['created']),$last_updated);
			$last_updated = date("Y-m-d H:i:s", $last_updated);
			

			if ( !empty($one_stat['Approval']) )
			{

				$last_approval = null;
				foreach ($one_stat['Approval'] as $approval)
				{
					$last_approval = max(strtotime($approval['created']), $last_approval);
				}

				$last_approval = date("Y-m-d H:i:s", $last_approval);
				$approver = $userNames[$one_stat['Approval'][0]['user_id']];

			} 

			if ( isset( $items[$one_stat['Item']['id']]['stat_ids'] ) )
			{
				$stat_list = array_merge( $items[$one_stat['Item']['id']]['stat_ids'], array($one_stat['Stat']['id']) );
			} else {
				$stat_list = array($one_stat['Stat']['id']);
			}

			if (isset( $items[$one_stat['Item']['id']]))
			{
				$new_quantity = intval($one_stat['Stat']['quantity']);
				$new_quantity *= ($one_stat['Modifier']['id'] == 2) ? -1 : 1;
				$quantity = $items[$one_stat['Item']['id']]['quantity'] + $new_quantity;
			} else
			{
				$quantity = intval($one_stat['Stat']['quantity']);
				$quantity *= ($one_stat['Modifier']['id'] == 2) ? -1 : 1;
			}

			$items[$one_stat['Item']['id']] = array(
				'icode'          => $one_stat['Item']['code'],
				'name'          => $one_stat['Item']['name'],
				'quantity'      => $quantity,
				'stat_ids'      => $stat_list,
				'last_stat'     => $last_stat,
				'approver'      => $approver,
				'last_approval' => $last_approval,
				'last_updated'  => $last_updated
			);

		}

		return array(
			'items' => $items,
			'lname' => $facility,
			'lid' => $location_id
		);
	}

	function setAggregates($node)
	{

		$children = $node['children'];
		if (count($children) == 0)
		{
			$node['total_items'] = $node['local_items'];
			$node['aggregate_items'] = null;
		} else
		{
			$aggregate_items = array();
			foreach ($children as $child_key => $child_value)
			{
				$child_with_aggregates = $this->setAggregates($child_value);
				$node['children'][$child_key] = $child_with_aggregates;
				foreach ($child_with_aggregates['total_items'] as $one_item_key => $one_item_value)
				{
					if (isset($aggregate_items[$one_item_key]))
					{
						$aggregate_items[$one_item_key]['quantity'] += $one_item_value['quantity'];
					} else
					{
						$aggregate_items[$one_item_key] = $one_item_value;
					}
				}
			}

			$total_items = $node['local_items'];
			$node['aggregate_items'] = $aggregate_items;
			foreach ($aggregate_items as $agg_key => $agg_val)
			{
				if (isset($total_items[$agg_key]))
				{
					$total_items[$agg_key]['quantity'] += $agg_val['quantity'];
				} else
				{
					$total_items[$agg_key] = $agg_val;
				}
			}
			$node['total_items'] = $total_items;
		}

		return $node;
	}

	function flattenTree($node)
	{

		pr($node);

		$children = $node['children'];
		$result = array();
		if (count($children) != 0)
		{
			$node['children_ids'] = array_keys($children);
			unset($node['children']);
			array_push($result, $node);
			foreach ($children as $child)
			{
				$flat_child = $this->flattenTree($child);
				foreach ($flat_child as $kid)
					array_push($result, $kid);
			}

			return $result;
		} else
		{
			unset($node['children']);
			array_push($result, $node);
			return $result;
		}

	}

	function removeEmpties( $flattened )
	{

		$not_empty = array();

		foreach ( $flattened as $child )
		{
			if ( !empty($child['total_items'] ) )
			{
				array_push($not_emtpy, $child);
			}
		}

		return $not_empty;

	}

	function arrayToHash( $array )
	{
		$result = array();
		foreach ($array as $element)
		{

			if ( ! isset( $result[$element['lid']] ) ) $result[$element['lid']] = array();

			foreach ( $element['total_items'] as $item_key => $item_value )
			{

				$result[$element['lid']][$item_key] = $item_value;
				$result[$element['lid']][$item_key]['lname'] = $element['lname'];
				$result[$element['lid']][$item_key]['depth'] = $element['depth'];

				if ($element['aggregate_items'])
				{
					$result[$element['lid']][$item_key]['aggregate_items'] = array();
					foreach ( $element['aggregate_items'] as $agg_key => $agg_value )
					{
						$result[$element['lid']][$item_key]['aggregate_items'][$agg_key] = $agg_value;
					}
				}

				$result[$element['lid']][$item_key]['local_items'] = array();
				foreach ( $element['local_items'] as $agg_key => $agg_value )
				{
					$result[$element['lid']][$item_key]['local_items'][$agg_key] = $agg_value;
				}

				$result[$element['lid']][$item_key]['total_items'] = array();
				foreach ( $element['total_items'] as $agg_key => $agg_value )
				{
					$result[$element['lid']][$item_key]['total_items'][$agg_key] = $agg_value;
				}


				if (isset($element['children_ids']))
					$result[$element['lid']][$item_key]['children_ids'] = $element['children_ids'];
				if (isset($element['parent']))
					$result[$element['lid']][$item_key]['parent'] = $element['parent'];
			}
		}
		return $result;
	}
}
?>