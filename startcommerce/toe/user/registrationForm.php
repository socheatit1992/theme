<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#regForm').submit(function(){
            jQuery(this).sendForm({
                msgElID: 'toeRegistrationMsg',
                onSuccess: function(res) {
                   if(!res.error) {
                       jQuery('#regForm').clearForm();
                       if(res.data.redirect) 
                           document.location.href = res.data.redirect;
                   }
                }
            })
            return false;
        });
    });
</script>
<?php if(!$this->fieldsOnly) {
    echo html::formStart('userRegister', array('method' => 'POST', 'attrs' => 'id="regForm" class="formFields"'));
}?>
<table>
    <?php /* foreach($this->standartFields as $f) { ?>
        <tr>
            <td>
                <div class="forminput">
                    <?php 
                        if(in_array($f->getHtml(), array('text', 'textarea', 'password'))) {
                            $f->addHtmlParam('attrs', 'placeholder="'.lang::_($f->label).'"');
                        }
                        $f->display();
                    ?>
                </div>
            </td>
        </tr>
    <?php } */?>
    <?php
        if($this->metaFields) {
            foreach($this->metaFields as $f) { ?>
        <tr>
            <td>
                <div class="forminput">
                    <?php 
                        if(in_array($f->getHtml(), array('text', 'password', 'textarea'))) {
                            $f->addHtmlParam('attrs', 'placeholder="'.lang::_($f->label).'"');
                        }
                        $f->display();
                    ?>
                </div>
            </td>
        </tr>        
            <?php }
        }
    if(!$this->fieldsOnly) {
    ?>
    <tr>
        <td>
            <?php if(!empty($this->toeReturn)) {
                echo html::hidden('toeReturn', array('value' => $this->toeReturn));
            }?>
            <?php echo html::hidden('mod', array('value' => 'user'))?>
            <?php echo html::hidden('action', array('value' => 'postRegisterLoad'))?>
            <?php echo html::hidden('reqType', array('value' => 'ajax'))?>
            <?php echo html::submit('register', array('value' => lang::_('Register'), 'attrs'=>'class="tcf_submit btn yellow"'))?>
        </td>
        <td id="toeRegistrationMsg"></td> 
    </tr>
    <?php }?>
</table>
<?php if(!$this->fieldsOnly) {
    echo html::formEnd();
}?>