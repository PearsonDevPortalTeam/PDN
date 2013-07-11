<?php
/**
* @file
* Default theme implementation to present all user profile data.
*
* This template is used when viewing a registered member's profile page,
* e.g., example.com/user/123. 123 being the users ID.
*
* Use render($user_profile) to print all profile items, or print a subset
* such as render($user_profile['user_picture']). Always call
* render($user_profile) at the end in order to print all remaining items. If
* the item is a category, it will contain all its profile items. By default,
* $user_profile['summary'] is provided, which contains data on the user's
* history. Other data can be included by modules. $user_profile['user_picture']
* is available for showing the account picture.
*
* Available variables:
* - $user_profile: An array of profile items. Use render() to print them.
* - Field variables: for each field instance attached to the user a
* corresponding variable is defined; e.g., $account->field_example has a
* variable $field_example defined. When needing to access a field's raw
* values, developers/themers are strongly encouraged to use these
* variables. Otherwise they will have to explicitly specify the desired
* field language, e.g. $account->field_example['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see user-profile-category.tpl.php
* Where the html is handled for the group.
* @see user-profile-item.tpl.php
* Where the html is handled for each item in the group.
* @see template_preprocess_user_profile()
*
* @ingroup themeable
*/
?>
<?php 
$user_id = arg(1);
global $base_url, $theme_path;
$user_obj = user_load($user_id);
$language = LANGUAGE_NONE;
if(!empty($user_obj->field_user_full_name[$language][0]['value']))
    $user_name = $user_obj->field_user_full_name[$language][0]['value'];
if(empty($user_name))
    $user_name = $user_obj->name;


?>

<div class="profile"<?php print $attributes; ?>>
    <div class="row">
        <div class="span8">
            <?php print render($user_profile['user_picture']);?>
            <br/>
            <div class="userinfo" style="padding-right: 20px;">
                <b>Name</b>: <?php print $user_name;?> &nbsp; <?php print l('Edit Profile', "user/$user_obj->uid/edit");?>
                <br/>
                <b>Member Since</b>: <?php print format_date($user_obj->created, "custom", "d M Y")?>
                <br/>
                <b>Last Access</b>: <?php print format_date($user_obj->access, "custom", "d M Y")?>
                <br/><br/>
                <?php if(!empty($user_obj->field_user_company_name[$language][0]['value'])):?>
                <b>I work at</b>: <?php print $user_obj->field_user_company_name[$language][0]['value'];?>
                <br/>
                <?php endif;
                if(!empty($user_obj->field_about_me[$language][0]['value'])):
                ?>
                <b>Biography</b>: <?php print $user_obj->field_about_me[$language][0]['value'];?>
                <?php  endif;?>
                <br/>
               <?php print l('Send this user a Private Message', "messages/new/$user_obj->uid/edit");?>               
            </div>
        </div>
        <div class="span16">
            <div class="row">
                <div class="span8">
                    <img src="<?php print "$base_url/$theme_path/images/product_chat.png";?>" />
                </div>
                <div class="span8">
                    <div class="statistic-group">
                        <div class="statistic-header">Blogs</div>
                        <table class="statistic-table">
                            <tbody>
                            <tr>
                                <td class="name">Posts</td>
                                <td class="value"><span>10</span></td>
                            </tr>
                            <tr>
                                <td class="name">Star Ratings</td>
                                <td class="value"><span>5</span></td>
                            </tr>
                            <tr>
                                <td class="name">Comments</td>
                                <td class="value"><span>11</span></td>
                            </tr>
                            <tr>
                                <td class="name">Posts Rated</td>
                                <td class="value"><span>22</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="span16">
                    <?php 
                    if(function_exists('pdn_userpoints')) 
                        print pdn_userpoints($user_obj);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="span8">
                     <?php
                        if(function_exists('get_follows_count'))
                        print get_follows_count($user_obj);
                     ?>
                </div>
                <div class="span8">
                    <?php
                        if(function_exists('get_bookmarks_count'))
                        print get_bookmarks_count($user_obj);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="statistic-group">
                        <div class="statistic-header">User Points</div>
                        <table class="statistic-table">
                            <tbody>
                            <tr>
                                <td class="name">Forum</td>
                                <td class="value"><span>100</span></td>
                            </tr>
                            <tr>
                                <td class="name">Comments</td>
                                <td class="value"><span>50</span></td>
                            </tr>
                            <tr>
                                <td class="name">API Useage</td>
                                <td class="value"><span>55</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="span8">
                    <div class="statistic-group">
                        <div class="statistic-header">Forums</div>
                        <table class="statistic-table">
                            <tbody>
                            <tr>
                                <td class="name">Posted Topics</td>
                                <td class="value"><span>77</span></td>
                            </tr>
                            <tr>
                                <td class="name">Votes Up</td>
                                <td class="value"><span>40</span></td>
                            </tr>
                            <tr>
                                <td class="name">Replies</td>
                                <td class="value"><span>316</span></td>
                            </tr>
                            </tbody>
                        </table>
                     </div>
                </div>
            </div>
            <div class="row">
                <div class="span5">
                    <div class="Column1"> 
                        <div class="ColumnImg Column1Img"> &nbsp;</div>  &nbsp; 2 Gold
                            <div class="Column-sub Column1-sub" title="Forums Answerer IV 
Achieved on 1/22/2012 
Provided multiple answers to questions in Forums.">
                                    Forums Answerer IV
                            </div>
                            <div class="Column-sub Column1-sub" title="Forums Answerer II 
Achieved on 7/10/2011 
Provided multiple answers to questions in Forums.">Forums Answerer II</div>

                    </div>
                </div>
                <div class="span5">
                    <div class="Column1"> 
                        <div class="ColumnImg Column2Img"> &nbsp;</div> &nbsp; 6 Silver 
                            <div>
                                    <div class="Column-sub Column2-sub" title="Thread Mover II 
Achieved on 1/21/2013 
Helped users get answers by moving 
their questions to the right forums."> Thread Mover II  </div>
                                    <div class="Column-sub Column2-sub" title="Code Answerer II 
Achieved on 5/5/2012 
Provided many forum answers with code."> Code Answerer II</div>
                                    <div class="Column-sub Column2-sub" title="Forums Replies IV 
Achieved on 5/1/2012 
Replied multiple times to Forums."> Forums Replies IV</div>
                                    <div class="Column-sub Column2-sub" title=" Forums Answerer III 
Achieved on 11/5/2011 
Provided multiple answers to questions in Forums."> Forums Answerer III</div>
                                    <div class="Column-sub Column2-sub" title="Forums Replies III 
Achieved on 7/31/2011 
Replied multiple times to Forums."> Forums Replies III</div>
                                    <div class="Column-sub Column2-sub" title="First Helpful Vote 
Achieved on 7/9/2011 
Voted a post as helpful for the first time.">First Helpful Vote</div>

                            </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="Column3"> 
                        <div class="ColumnImg Column3Img"> &nbsp;</div> &nbsp; 3 Bronze
                            <div>
                                    <div class="Column-sub Column3-sub" title="Thread Mover I 
Achieved on 1/8/2013 
Helped users get answers by moving 
their questions to the right forums."> Thread Mover I</div>
                                    <div class="Column-sub Column3-sub" title="First Forums Spam Report 
Achieved on 11/11/2011 
Reported first forums SPAM post.">First Forums Spam </div>
                                    <div class="Column-sub Column3-sub" title="New Blog Rater 
Achieved on 11/9/2011 
Gave your first rating to a blog post.">New Blog Rater</div>


                            </div>
		      </div>
                </div>
            </div>
        </div>
    </div>
</div> 