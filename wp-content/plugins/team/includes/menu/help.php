<?php	

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	



if(empty($_POST['team_hidden'])){
		$team_member_slug = get_option( 'team_member_slug' );		
		$team_member_meta_fields = get_option( 'team_member_meta_fields' );		
		$team_member_social_field = get_option( 'team_member_social_field' );

	}
else{	
		if($_POST['team_hidden'] == 'Y') {
			//Form data sent

			$team_member_slug = sanitize_text_field($_POST['team_member_slug']);
			update_option('team_member_slug', $team_member_slug);
			
			if(empty($_POST['team_member_meta_fields'])){
				
				$_POST['team_member_meta_fields'] = array();
				}
			$team_member_meta_fields = stripslashes_deep($_POST['team_member_meta_fields']);
			update_option('team_member_meta_fields', $team_member_meta_fields);

			$team_member_social_field = stripslashes_deep($_POST['team_member_social_field']);
			update_option('team_member_social_field', $team_member_social_field);

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', 'team' ); ?></strong></p></div>
	
			<?php
			} 
	}
	



	$class_team_functions = new class_team_functions();
	$default_social_field = $class_team_functions->team_member_social_field();

?>


<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(team_plugin_name.' Settings', 'team')."</h2>";?>

    <div class="para-settings team-settings">
    
        <ul class="tab-nav"> 
    
            <li nav="1" class="nav1 active"><i class="fa fa-hand-o-right"></i> Help & Support</li>    
        </ul> <!-- tab-nav end --> 
		<ul class="box">
       		
                        
            <li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title">Buy premium</p>
                    <p class="option-info">
					<?php
                
                    if(team_customer_type=="free")
                        {
                    
                            echo 'You are using <strong> '.team_customer_type.' version  '.team_plugin_version.'</strong> of <strong>'.team_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                            echo '<br /><a href="'.team_pro_url.'">'.team_pro_url.'</a>';
                            
                        }
                    else
                        {
                    
                            echo 'Thanks for using <strong> premium version  '.team_plugin_version.'</strong> of <strong>'.team_plugin_name.'</strong> ';	
                            
                            
                        }
                    
                     ?>       

                    
                    </p>

                </div>
				<div class="option-box">
                    <p class="option-title">Documentation</p>
                    <p class="option-info"> Please see following link for the documentation <a href="http://pickplugins.com/docs/documentation/team/">http://pickplugins.com/docs/documentation/team/</a>
                    </p>

                </div>    
                
                        
				<div class="option-box">
                    <p class="option-title">Need Help ?</p>
                    <p class="option-info">Feel free to contact with any issue for this plugin, Ask any question via forum <a href="<?php echo team_qa_url; ?>"><?php echo team_qa_url; ?></a> <strong style="color:#139b50;">(free)</strong><br />

                    </p>

                </div>
                
                
                
                
				<div class="option-box">
                    <p class="option-title">Submit Reviews...</p>
                    <p class="option-info">We are working hard to build some awesome plugins for you and spend thousand hour for plugins. we wish your three(3) minute by submitting five star reviews at wordpress.org. if you have any issue please submit at forum.</p>
                	<img class="team-pro-pricing" src="<?php echo team_plugin_url."css/five-star.png";?>" /><br />
                    <a target="_blank" href="<?php echo team_wp_reviews; ?>">
                		<?php echo team_wp_reviews; ?>
               		</a>

                </div>
                
				<div class="option-box">
                    <p class="option-title">Please Share</p>
                    <p class="option-info">If you like this plugin please share with your social share network.</p>
                    <?php
                   		$class_team_functions = new class_team_functions();
						echo $class_team_functions->team_share_plugin();
					?>
                </div>
                
				<div class="option-box">
                    <p class="option-title">Video Tutorial</p>
                    <p class="option-info">Please watch this video tutorial.</p>
                	<iframe width="640" height="480" src="<?php echo team_tutorial_video_url; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                
                
                
                
            </li>            
        </ul>
    
    
		

        
    </div>



</div>
