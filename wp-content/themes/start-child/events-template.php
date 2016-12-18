<?php /* Template Name: events */


get_header(); ?>

<link rel="stylesheet" type="text/css" href="/custom/css/events-template.css">
<link rel="stylesheet" type="text/css" href="/custom/css/events-carousel.css">

<div id="primary" class="content-area col-md-8">
    <main id="main" class="site-main col-md-12" role="main">
        <?php
        global $wpdb;
        ?>
        <div class="loading_events_spinning">Loading&#8230;</div>
        <div class="row">
            <div class="inner-addon right-addon">
                <input type="text" class="form-control" placeholder="Search events..." id="events_string_filter">
                <i class="glyphicon glyphicon-search form-control-feedback" id="search_events_string"></i>
            </div>
        </div>
        <div class="row" style="margin-top: 3%;">
            <details id="filters_container">
                <summary style="font-size: 150%;">Advanced search</summary>
                <div class="row" style="margin-top: 3%;">
                    <div class="col col-md-12" style="margin-top: 1%;">
                        <label>Country</label>
                        <select class="form-control" style="width: 100%" id="events_select_country">
                            <option value="" disabled selected>Pick a country..</option>
                            <?php
                            $results = $wpdb->get_results('SELECT ID,country, count(*) as cnt FROM xwy_custom_events_countries GROUP BY country ORDER BY country', OBJECT);
                            foreach ($results as $record):
                                ?>
                                <option value="<?php echo $record->ID; ?>"><?php echo $record->country; ?></option>
                                <?php
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="col col-md-12" style="margin-top: 1%;">
                        <label>City</label>
                        <select class="form-control" style="width: 100%" id="events_select_city">
                            <option value="" disabled selected>First pick a country..</option>
                        </select>
                    </div>
                    <div class="col col-md-6" style="margin-top: 1%;">
                        <label>From</label>
                        <input type="input" id="events_select_date_from" class="form-control date_input"
                               style="width: 100%"/>
                    </div>
                    <div class="col col-md-6" style="margin-top: 1%;">
                        <label>To</label>
                        <input type="input" id="events_select_date_to" class="form-control date_input"
                               style="width: 100%"/>
                    </div>
                    <div class="col col-md-12" style="margin-top: 3%;">
                        <button type="button" class="btn btn-default" aria-label="Left Align"
                                id="search_events_filters">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"> Search </span>
                        </button>
                    </div>
                </div>
            </details>
        </div>
        <div class="row" style="margin-top: 3%;">
            <details open id="events_container">
                <summary style="font-size: 150%;">Events</summary>
                <div id="events_content">
                </div>
                <div class="row">
                    <div class="col col-md-12">
                        <ul class="pagination pagination-sm" id="events_pagination">
                        </ul>
                    </div>
                </div>
            </details>
        </div>
        <div class="row" style="margin-top: 3%;">
            <details id="details_container">
                <summary style="font-size: 150%;">Detail</summary>
                <div class="row" style="margin-top: 3%;" id="details_content">
                    <div class="col-md-12">
                        <img id="details_image" src=""> 
                    </div>
                    <div class="col-md-12">
                        <h3 id="details_title"></h3>
                        <p id="details_description">
                        </p>
                    </div>
                </div>
            </details>
        </div>
        <div class="row" style="margin-top: 3%;">
            <div>
                <a href="/events"><img src="/custom/past_events.jpg" style="display: block; margin: 0 auto;"> </a>
            </div>
            <div class="col-md-12">
                <div class="carousel slide" id="myCarousel">
                    <div class="carousel-inner" id="carousel_events_container">
                    </div>
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i
                            class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next"><i
                            class="glyphicon glyphicon-chevron-right"></i></a>
                </div>
            </div>

        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<script>
    var country_id = "<?php echo trim($_GET['country_id']); ?>";
    var city_id = "<?php echo trim($_GET['city_id']); ?>";
    var date_from = "<?php echo trim($_GET['date_from']); ?>";
    var date_to = "<?php echo trim($_GET['date_to']); ?>";
</script>
<script src="/custom/js/events-template.js"></script>


