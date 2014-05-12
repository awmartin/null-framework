<?php

function NullSiteTitle($wrap=true) {
    $siteTitle = get_bloginfo('name');
    $linkTitle = esc_attr( get_bloginfo( 'name', 'display' ) );
    $siteUrl = esc_url( home_url( '/' ) );
    
    $linkAttr = array(
        'href' => $siteUrl,
        'title' => $linkTitle,
        'rel' => 'home'
        );
    $link = NullTag('a', $siteTitle, $linkAttr);
    if (!$wrap) return $link;
    return NullTag('h1', $link, array('id' => 'site-title'));
}

function NullSiteDescription() {
    return NullTag('h2', get_bloginfo('description'), array('id' => 'site-description'));
}

function NullGoogleAnalytics($account) {
	$ga = '';
    $ga = $ga.'<script type="text/javascript">';
    $ga = $ga.'var _gaq = _gaq || [];';
    $ga = $ga."_gaq.push(['_setAccount', '".$account."']);";
    $ga = $ga."_gaq.push(['_trackPageview']);";
    $ga = $ga.'(function() {';
    $ga = $ga."  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
    $ga = $ga."  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
    $ga = $ga."  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
    $ga = $ga."})();";
    $ga = $ga.'</script>';
    return $ga;
}

function NullSiteTags(){
    $tags = get_tags();
    $html = '<div class="tags section">';
    foreach ( $tags as $tag ) {
    	$tag_link = get_tag_link( $tag->term_id );
			
    	$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
    	$html .= "{$tag->name}</a> ";
    }
    $html .= '</div>';
    return $html;
}
?>