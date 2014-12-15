<div class="wrap">
    <h1><?=$this->theme_page_data['page_title']?></h1>
    <div class="section panel">
        <form method="post" enctype="multipart/form-data" action="options.php">
            <?php settings_fields($this->theme_option_group); ?>
            <?php do_settings_sections($this->theme_option_page);?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>    
      </form>
    </div>        
</div>