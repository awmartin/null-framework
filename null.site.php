<?php
    
function NullSiteTitle(){
    echo _NullSiteTitle();
}

function _NullSiteTitle($wrap=true) {
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
    echo _NullSiteDescription();
}

function _NullSiteDescription() {
    return NullTag('h2', get_bloginfo('description'), array('id' => 'site-description'));
}

function NullGoogleAnalytics($account) {
    echo _NullGoogleAnalytics($account);
}

function _NullGoogleAnalytics($account) {
	$ga = '<script type="text/javascript" src="'.get_site_url().'/wp-includes/js/jquery/jquery.js"></script>';
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
?>