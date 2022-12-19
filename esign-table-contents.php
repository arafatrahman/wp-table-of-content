<?php
/**
 * Template Name:  Sticky Table of Contents 
 * The template for displaying  Sticky Table of Contents  pages.
 *
 */


get_header(); ?>

<style>
.container{
    width:100% !important;
}
.esign-toc-list li{
    list-style-type: none ;
}

.esign-flex-container {
  display: flex;
  flex-wrap: nowrap;
  position: relative;
}

.esign-flex-container > #esign-table-of-content {
  
  width: 30%;
  margin: 10px;


}

.esign-flex-container > #esign-content {
 
  width: 70%;
  margin: 10px;
}

.sidebar {
  position: sticky;
  top: 0;
  float: left !important;
  width: 450px !important;

  padding: 50px !important;

  border-right: 2px solid #c2c1be;
}

.esign-toc-list li{
    list-style-type: none !important;
}
.active {
   
    background-color: #e7ebed;
    padding: 5px 15px 5px 15px;
    border-radius: 5px;
    margin-top: 20px;
    margin-bottom: 20px;
}

.esign-display-none{
    /*display: none;*/
}
body{
    background: none !important;
}

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

$(window).scroll(function(){
    var scrollTop = $(document).scrollTop();
    var anchors = $('body').find('h2, h3, h4, h5, h6');
    
    for (var i = 0; i < anchors.length; i++){
        if (scrollTop > $(anchors[i]).offset().top - 300 && scrollTop < $(anchors[i]).offset().top + $(anchors[i]).height() - 30) {
           
            $('ul li a[href="#' + $(anchors[i]).attr('id') + '"]').addClass('active');
          //  $('ul li a[href="#' + $(anchors[i]).attr('id') + '"]').closest('li').next('li').removeClass('esign-display-none');
        } else{
            $('ul li a[href="#' + $(anchors[i]).attr('id') + '"]').removeClass('active');
         //   $('ul li a[href="#' + $(anchors[i]).attr('id') + '"]').closest('li').next('li').addClass('esign-display-none');
            
        }
    }
});

</script>

<?php
add_filter('the_content', function ($content) {            
    $content = get_the_content();

    $pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';
    if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
        $find = array();
        $replace = array();
        $count = 0;

       // print_r($matches);
        foreach( $matches as $match ) {
            $find[]    = $match['full_tag'];
            $id        =  sanitize_title_with_dashes($match['tag_contents']).'-' .$count;
            $id_attr   = sprintf( ' id="%s"', $id );
            $replace[] = sprintf( '<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents']);
            $count ++;
        }
        $content = str_replace( $find, $replace, $content );
    }
    return $content;
});

?>

	<div id="primary" class="content-area full-width">

        <aside id="secondary" class="widget-area sidebar" >

        <?php
                                //    add_filter('the_content', function ($content) {            
                                    $content = get_the_content();

                                        $pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_extra>[^>]*)>(?P<tag_contents>[^<]*)</h\d>)#i';
                                        if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
                                            $find = array();
                                            $replace = array();
                                            $count = 0;

                                           // print_r($matches);
                                            foreach( $matches as $match ) {
                                                $find[]    = $match['full_tag'];
                                                $id        =  sanitize_title_with_dashes($match['tag_contents']).'-' .$count;
                                                $id_attr   = sprintf( ' id="%s"', $id );
                                                $replace[] = sprintf( '<%1$s%2$s%3$s>%4$s</%1$s>', $match['tag_name'], $match['tag_extra'], $id_attr, $match['tag_contents']);
                                                $count ++;
                                            }
                                            $content = str_replace( $find, $replace, $content );
                                        }
                                                

                                        preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );
                                      // print_r($matches);
                                        foreach( $matches as $match ) {

                                            preg_match_all('`"([^"]*)"`', $match['tag_extra'], $results);                                           
                                          
                                            echo  '<div class="esign-toc-list">';
                                            echo '<ul>                                            
                                                        <li>';
                                                        if($match['tag_name'] == 'h2'){
                                                            $className = str_replace('"', '', $results['0']['0']);
                                                            $linkId = '#'.str_replace('"', '', $results['0']['0']);
                                                            echo '<a href="'.$linkId.'" >' . $match['tag_contents'] . '</a>';
                                                        }


                                                        
                                                        echo '<ul id="'.$className.'" >';
                                                        echo '<li >';
                                                        if($match['tag_name'] != 'h2'){
                                                            $linkId = '#'.str_replace('"', '', $results['0']['0']);
                                                            echo '<a href="'.$linkId.'" >' . $match['tag_contents'] . '</a></li>';
                                                        }
                                                        echo '</ul>
                                                        </li>
                                                 </ul></div>';                                 
                                        }


                                    //  return $content;
                                //  });        
                                ?>

        </aside><!-- #secondary -->

		<main id="main" class="site-main" style="overflow:hidden">
           
                                <?php
                                    while ( have_posts() ) : the_post();
                                        get_template_part( 'template-parts/content', 'page' );
                                        if ( comments_open() || get_comments_number() ) :
                                            comments_template();
                                        endif;
                                    endwhile; 
                                ?>
              
		</main>
	</div>

<?php get_footer(); ?>