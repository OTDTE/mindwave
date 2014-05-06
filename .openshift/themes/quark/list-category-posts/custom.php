<?php
/*
Plugin Info & license stuff...
*/
$lcp_output = '';    
//Show category?
    if ($atts['catlink'] == 'yes'){
        $cat_link = get_category_link($lcp_category_id);
        $cat_title = get_cat_name($lcp_category_id);
        $lcp_output = '<div class="topic-heading"><a href="' . $cat_link . '" title="' . $cat_title . '">' . $cat_title . '</a></div>';
    }
$lcp_output .= '<div class="post">';//For default ul

//Posts loop:

foreach($catposts as $single):
    $lcp_output .= '<h2 class="entry-title"><a href="' . get_permalink($single->ID) . '">' . $single->post_title . '</a></h2>';
    //Show comments?
    if($atts['comments'] == yes){
        $lcp_output .= ' (' . $single->comment_count . ')';
    }
    //Style for date:
    if($atts['date']=='yes'){
        $lcp_output .= ' <div class="entry-meta"> ' . get_the_time($atts['dateformat'], $single) . '</div>';
    }
    //Show author?
    if($atts['author']=='yes'){
        $lcp_userdata = get_userdata($single->post_author);
        $lcp_output .=' <div class="entry-meta">' .$lcp_userdata->display_name . '</div>';
    }
    //Show thumbnail?
    if($atts['thumbnail']=='yes'){
        $lcp_output .= '<div class="lcp_thumbnail"><a href="' . get_permalink($single->ID) . '">' . get_the_post_thumbnail($single->ID, array('40','40')) .'</a></div>';
    }

    //Show content?
    if($atts['content']=='yes' && $single->post_content){
        $lcpcontent = apply_filters('the_content', $single->post_content); // added to parse shortcodes
        $lcpcontent = str_replace(']]>', ']]&gt', $lcpcontent); // added to parse shortcodes
        $lcp_output .= '<p>' . $lcpcontent . '</p>'; // line tweaked to output filtered content
    }
    //Show excerpt?
    if($atts['excerpt']=='yes' && !($atts['content']=='yes' && $single->post_content) ){
        $lcp_output .= lcp_excerpt($single);
    }
    endforeach;
$lcp_output .= '</div>';
?>