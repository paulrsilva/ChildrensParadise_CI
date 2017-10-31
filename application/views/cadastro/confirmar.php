<div class="col-lg-4 col-lg-offset-4">
    <h2>Quase lá</h2>
    <h5>Olá,  você está confirmando o agendamento para o email <span><?php echo $email;?></span></h5>
    <small>Complete alguns dados para confirmar o agendamento e uma senha para gerenciar seu evento</small>
 
<?php 
    $fattr = array('class' => 'form-signin');
    echo form_open(site_url().'childrens/confirmar/token/'.$token, $fattr); ?>
    <div class="form-group">
      <?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array('name'=>'passconf', 'id'=> 'passconf', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passconf'))); ?>
      <?php echo form_error('passconf') ?>
    </div>
    <?php echo form_hidden('user_id', $user_id);?>
    <?php echo form_submit(array('value'=>'Complete', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
    <?php echo form_close(); ?>
   
</div>