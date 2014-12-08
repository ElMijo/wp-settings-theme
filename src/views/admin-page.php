<div class="wrap">
   <h2><?=$this->theme_page_data['page_title']?></h2>
 
<!--         <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="num_elements">
                            Number of elements on a row:
                        </label>
                    </th>
                    <td>
                        <input type="text" name="num_elements" size="25" />
                    </td>
                </tr>
            </table>
        </form> -->

    <div class="section panel">
      <h1>Custom Theme Options</h1>
      <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
          settings_fields('pu_theme_options'); 
        
          do_settings_sections('pu_theme_options.php');
        ?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>  
            
      </form>
      
      <p>Created by <a href="http://www.paulund.co.uk">Paulund</a>.</p>
    </div>        
</div>