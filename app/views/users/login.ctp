   <?php
  $session->flash('auth');
  echo $form->create('User', array('action' => 'login'));
  //echo $form->inputs(array( 'legend' => __('Login', true), 'username', 'password'));
  echo $form->input('username',   array('type' => 'text', 'size' => 15));
  echo $form->input('password',  array('type' => 'password', 'size' => 15));
  echo $form->end('Login');
  ?>
