<script type="text/javascript">
// <!--
jQuery(document).ready(function(){
    jQuery('#toeUserData').submit(function(){
        jQuery(this).sendForm();
        return false;
    });
});
// -->
</script>

<h2 style="margin-top:25px;"><?php echo lang::_e('User Profile'); ?></h2>

<?php echo html::formStart('userData', array('attrs' => 'id="toeUserData"'))?>
<table>
    <tr>
        <td><?php lang::_e('Email')?></td>
        <td><div class="forminput"><?php echo html::text('email', array('value' => $this->userData->user_email))?></div></td>
    </tr>
<?php frame::_()->getModule('user')->getView('user')->displayAllMeta();?>
</table>
<?php echo html::hidden('reqType', array('value' => 'ajax'))?>
<?php echo html::hidden('mod', array('value' => 'user'))?>
<?php echo html::hidden('action', array('value' => 'putProfile'))?>
<?php echo html::submit('save', array('value' => lang::_('Update'), 'attrs'=>'class="tcf_submit btn"'))?>
<div id="msg"></div>
<?php echo html::formEnd()?>