<?php echo $javascript->link('jquery.min', false); ?>	
<?php echo $javascript->link('prototype', false); ?>

<div class='help'>
Each controller action represents an action that can be performed on this controller. All users must have Pages/display and User/login & logout  allowed otherwise no page will be displayed and users won't be able to login and out of the application.</br>
Some explanation:</br> 
index - stands for main listing </br> 
view - is for viewing a particular record </br> 
add - add a new record </br> 
Similarly edit and delete are given to a role so that members are able to edit and delete a record </br> 
Those are the five basic actions for each controller. Some controllers have other actions: </br> 
Users: login, logout, changePass </br> 
Stat: update_select (for updating the location based on the selected phone), all reports regarding updates are also here. Note that the map report is a separate case and will be displayed regardless of other permissions sets(even if you don't have access to the triggered alerts report all triggered alerts will be highlighted on the map).</br> 
Role: managePermissions - this is the page you are look at now, allowDenyPermission - is the page that is being called when you click allow or deny here </br> 
Alert - triggeredAlerts - the report </br> 
Note that any new actions added will be available here and have to be allowed specifically for each role. 

</div>
<div class="managepermissions">
<table>
  <th>Controller/ Action</th>
  <?php
      foreach($data as $d)
         echo '<th width="15%">'.$d['Role']['name'].'</th>';
  ?>
  <?php 
      $first = true;
      
      foreach($ctlist as $controller => $actions) {
           if($first)
              echo '<tr>';
           else
              echo '<tr style="border-top: 1px solid; margin-top: 5px;">';
                 
           echo '<td style="font-weight: bold">'.$controller.'</td>';

           foreach($data as $val) { 
                echo '<td>';
				echo $ajax->link( 'Allow all', '/roles/allowDenyPermission/'.$val['Role']['id'].'/'.$controller.'/all/allow', array('update' => 'updacl'));
                echo '&nbsp;&nbsp;';
                echo $ajax->link( 'Deny all', '/roles/allowDenyPermission/'.$val['Role']['id'].'/'.$controller.'/all/deny', array('update' => 'updacl'));
                echo '</td>';                     
           }
           
           echo '</tr>';
           
           foreach($actions as $a => $perm) {
               echo '<tr>';
               echo '<td>'.$a.'</td>';  
               
               foreach($perm as $key => $val) {
                  if($val == 1)
                     $st = 'style="color: #66CC00;"';
                  else
                     $st = 'style="color: #990000;"';   
                  echo '<td id="'.$controller.'_'.$a.'_'.$key.'" '.$st.'>';

                  if($val == 1)
                     echo 'allowed ' . $ajax->link( 'deny?', '/roles/allowDenyPermission/'.$key.'/'.$controller.'/'.$a.'/deny', array('update' => 'updacl'));
                  else
                     echo 'denied ' . $ajax->link( 'allow?', '/roles/allowDenyPermission/'.$key.'/'.$controller.'/'.$a.'/allow', array('update' => 'updacl'));
                                       
                  echo '</td>';
               }
                               
               echo '</tr>';
           }
           
           $first = false;
      }
  ?>
</table>
</div>
<div id="updacl" style='display: none;'></div>