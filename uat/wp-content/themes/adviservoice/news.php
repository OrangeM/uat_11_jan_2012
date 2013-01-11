<?php

$direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/wp-newsticker";

?>
<script type="text/javascript" src="http://www.adviservoice.com.au/wp-content/plugins/news-ticker/jcarousel.js"></script>
<style>

.news_wrapper {
display: block;
width: 100%;
background-color: #<?php $wp_news_bg_color = get_option('wp_news_bg_color'); if(!empty($wp_news_bg_color)) {echo $wp_news_bg_color;} else {echo "EEE";}?>;
height: 30px;
border: 1px solid #<?php $wp_news_border_color = get_option('wp_news_border_color'); if(!empty($wp_news_border_color)) {echo $wp_news_border_color;} else {echo "CCC";}?>;
}

.news_wrapper p.label {
display: inline;
float: left;
background-color: #<?php $wp_news_label_bg_color = get_option('wp_news_label_bg_color'); if(!empty($wp_news_label_bg_color)) {echo $wp_news_label_bg_color;} else {echo "C33944";}?>;
color: #<?php $wp_news_label_color = get_option('wp_news_label_color'); if(!empty($wp_news_label_color)) {echo $wp_news_label_color;} else {echo "FFF";}?>;
height: 25px;
font-size: 11px;
font-weight: bold;
text-transform: uppercase;
padding-top: 5px;
padding-left: 7px;
padding-right: 7px;
}

#scroll-h {
height: 30px;
}

#scroll-h div {
padding-top: 3px;
margin-left: 10px;
}


</style>

        <?php
        
        wp_reset_query();

        global $post;
        
        $wp_news_slide_max = get_option('wp_news_slide_max');
        
        if(empty($wp_news_slide_max)) {
                
                $wp_news_slide_max = 10;
                
        }
        
        $wp_news_slide_sort = get_option('wp_news_slide_sort');
        
        if(empty($wp_news_slide_sort)) {
                
                $wp_news_slide_sort = "post_date";
                
        }
        
        $wp_news_slide_order = get_option('wp_news_slide_order');
        
        if(empty($wp_news_slide_order)) {
                
                $wp_news_slide_order = "DESC";
                
        }
        
        $wp_news_slide_categories = get_option('wp_news_slide_categories');
        
        if(empty($wp_news_slide_categories)) {
                
                $wp_news_slide_categories = 0;
                
        }
	
	$wp_news_label_name = get_option('wp_news_label_name');
        
        if(empty($wp_news_label_name)) {
                
                $wp_news_label_name = "Latest";
                
        }

	$args = array('suppress_filters' => true, 'post_type' => array('post', 'page'), 'post_status' => 'publish', 'numberposts' => $wp_news_slide_max, 'orderby' => $wp_news_slide_sort, 'order' => $wp_news_slide_order, 'category' => $wp_news_slide_categories);
		
	$wp_news_myposts = get_posts($args);
	$counter=0;
        
        if($wp_news_myposts) {
                
                ?>
<div class="news-ticker-wrapper" style=" height: 26px;margin-top: 9px;">
<div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block;"><div class="jcarousel-clip jcarousel-clip-horizontal" style="overflow: hidden; position: relative;">

        
<ul class="news-ticker jcarousel-list jcarousel-list-horizontal" style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: -489.677px; width: 3445px;">
 <?php
                
                foreach( $wp_news_myposts as $post ) :	setup_postdata($post);
               $counter++; 
        ?>
     
<li class="jcarousel-item jcarousel-item-horizontal jcarousel-item-<?php echo $counter ?> jcarousel-item-<?php echo $counter ?>-horizontal" style="float: left; list-style: none outside none;" jcarouselindex="<?php echo $counter ?>"><div class="ticker-wrapper"><span class="tickerTitle"><?php the_title();?></span> - <span class="tickerText"><?php echo wp_news_cut_content_feat(get_the_excerpt(), 15, "...");?></span><a href="<?php the_permalink(); ?>">Read more</a> | </div></li> 

 
 <?php

                endforeach;
                
        ?>
            

</ul></div>
<div class="jcarousel-prev jcarousel-prev-horizontal" style="display: block;" disabled="false"></div><div class="jcarousel-next jcarousel-next-horizontal" style="display: block;" disabled="false"></div></div>
</div>   
 
        <?php

        }
        
        wp_reset_query();
        
?>


<script language="javascript" type="text/javascript">
 
	jQuery('.news-ticker').jcarousel({
	wrap: 'circular',
	auto: 6,
	animation: 4050,
	scroll: 1	}); 

 /* stepcarousel.setup({
	galleryid: 'news-ticker-gallery', //id of carousel DIV
	beltclass: 'news-ticker-belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'news-ticker-panel', //class of panel DIVs each holding content
	panelbehavior: {speed: 4050, wraparound:true, wrapbehavior:"slide", persist:true},
	defaultbuttons: {enable: false},
	autostep: {enable:true, moveby:1, pause:6},
	contenttype: ['inline'],
	onslide:function(){
		var addAfterLast = false;
		var addBeforeFirst = false;
 		if(1 &lt; 0)
			addBeforeFirst = true;
		else
			addAfterLast = true;
		
		if (addBeforeFirst) {
			var html = jQuery('news-ticker-belt').html()
		}			
	}
  });*/
  
</script>
