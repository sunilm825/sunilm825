<?php 
/* Start Breadcumb*/
function mhl_custom_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. construction-category)
    $custom_taxonomy    = 'construction-category';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
        echo '<li><a href="' . get_home_url() . '"><span>' . $home_title .'</span></a></li>';
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="active">' . post_type_archive_title($prefix, false) . '</li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
				$link = the_permalink($post_type);
				echo '<li><a href="' .site_url().'/'.$post_type.'/'. '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';	 
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li itemprop="title">' . $custom_tax_name . '</li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
				$term = get_term_by("slug", get_query_var("term"), get_query_var("av-service-categories") );
				//$terms = wp_get_object_terms($post->ID, 'projects-category', array('orderby' => 'term_id', 'order' => 'ASC' ,'taxonomy' => 'projects-category') );
				  $av_terms = get_the_terms( $post->ID, 'dg-hair-categories');
				  if($post_type == 'post') {
					 echo '<li><a href="' .get_term_link($av_terms[0]->term_id).'"><span>' . $av_terms[0]->name . '</span></a></li>';
				  } else { 
				  echo '<li><a href="' .site_url().'/'.$post_type.'/'.'" ><span>' . $post_type_object->labels->name . '</span></a></li>';
				  }
				//echo '<li itemprop="title">' . $custom_tax_name . '</li>';
				//echo '<li itemprop="title"><a href="' .site_url().'/project/'.$terms[0]->name.'"title="' . $post_type_object->labels->name . '">' . $terms[0]->name.'</a></li>';
			}
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
					$post_type_object = get_post_type_object($post_type);
					$post_type_archive = get_post_type_archive_link($post_type).'/blog/';
                    $cat_display .= '<li><a href="' . $post_type_archive . '" >' . $post_type_object->labels->name . '</a></li>';
					
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="active">' . get_the_title() . '</li>';
				
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li><a class="active"  href="' . $cat_link . ' ">' . $cat_name . '</a></li>';
                echo '<li><a href="#">' . $separator . '</a></li>';
                echo '<li>' . get_the_title() . '</li>';
              
            } else {
                  
                 echo '<li class="active">' . get_the_title() . '</li>';
                
            }
              
        } else if ( is_category() ) {
               
            // Category page

			echo '<li><a  href="' .site_url().'/blog/'.'" title="' . $cat_name . '">' .'Blog'. '</a></li>';
			
            echo '<li><a>' . single_cat_title('', false) . '</a></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
				$prnt_cont=2;
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    
					
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="active">' . get_the_title() . '</li>';
                   
            } else {
                   
                // Just display current page if not parents
                 echo '<li class="active">' . get_the_title() . '</li>';
				 
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li>' . $separator . ' </li>';
               
            // Month link
            echo '<li><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li><a href="#">' . $separator . '</a></li>';
               
            // Day display
            echo '<li>' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li><a class="active" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li>' . $separator . ' </li>';
               
            // Month display
            echo '<li>' . get_the_time('M') . ' Archives</li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li>' . get_the_time('Y') . ' Archives</li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li itemprop="title">' . 'Author: ' . $userdata->display_name . '</li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li itemprop="title">'.__('Page') . ' ' . get_query_var('paged') . '</li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li>Search results for: ' . get_search_query() . '</li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li class="active">' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
		 //echo '</div>';
           
    }
       
}
?>