<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package start
 */

get_header(); ?>
<div id="primary" class="content-area col col-md-8" style="margin-top: -2.2%;"> 
    <main id="main" class="site-main col-md-12" role="main">  
        <div class="row">
            <div>
                <a href="/events"><img src="/custom/featured_events.jpg" style="display: block; margin: 0 auto;"> </a>
            </div>
            <div>
                <a href="/events"><img src="/custom/gif/gifevents.gif" style="width: 100%;"> </a>
            </div>
        </div>
        <div class="row" style="margin-top: 3%;">
            <div>
                <a><img src="/custom/featured_post.jpg" style="display: block; margin: 0 auto;"> </a>
            </div>
            <div style="margin-top: -1%;">

                <?php
                global $wpdb;
                $sql = "SELECT posts.post_title as post_title, posts.guid as post_url, 
        posts.post_content as post_content, attachments.guid as post_image
        FROM $wpdb->posts AS posts
        LEFT JOIN $wpdb->posts as attachments ON 
        posts.ID = attachments.POST_PARENT
        WHERE posts.post_type='post' 
        AND posts.post_status='publish' 
        AND attachments.post_type='attachment' 
        ORDER BY RAND() LIMIT 6";
                $results = $wpdb->get_results($sql, OBJECT);

                $cnt = 0;

                foreach ($results as $record):
                    $cnt++;
                    if ($cnt % 2 > 0) {
                        ?>
                        <div class="row">
                        <?php
                    }
                    ?>
                    <div class="col-md-6"> 
                        <a href="<?php echo $record->post_url; ?>">
                            <div
                                style="background-image: url('<?php echo $record->post_image; ?>'); height:200px; background-repeat: no-repeat;"></div>
                        </a>
                        <h4 style=" margin-top: 1%;"><a
                                href="<?php echo $record->post_url; ?>"><?php echo $record->post_title; ?></a></h4> 
                        <p style="margin-top: -3%;"><?php echo substr($record->post_content, 0, 150); ?>...
                            <a href="<?php echo $record->post_url; ?>">read more</a>
                        </p>
                    </div>
                    <?php
                    if ($cnt % 2 == 0) {
                        ?>
                        </div>
                    <?php }
                endforeach; ?>
            </div>
        </div>
          
    </main><!-- #main --> 
</div><!-- #primary -->
  <?php get_sidebar(); ?> <?php get_footer(); ?> 
