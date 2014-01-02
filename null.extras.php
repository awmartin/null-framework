<?php

function _NullSocial($socialArray) {
    $socialLinks = "";
    foreach ($socialArray as $socialKey => $linkInfo){
        $url = NullGetSocialUrl($socialKey, $linkInfo);
        $icon = NullGetSocialIcon($socialKey);
        $link = NullTag('a', $icon, array('class' => 'social-link', 'href' => $url, 'target' => '_blank'));
        $socialLinks = $socialLinks.$link;
    }
    return NullTag('div', $socialLinks, array('class' => 'social'));
}

function NullGetSocialUrl($socialKey, $linkInfo){
    if ($socialKey == "linkedin") {
        return 'http://linkedin.com/in/'.$linkInfo;
    } elseif ($socialKey == "twitter") {
        return 'http://twitter.com/'.$linkInfo;
    } elseif ($socialKey == "github") {
        return 'http://github.com/'.$linkInfo;
    } elseif ($socialKey == "email") {
        return 'mailto:'.$linkInfo;
    } elseif ($socialKey == 'googleplus') {
        return $linkInfo;
    } elseif ($socialKey == 'rss') {
        return get_bloginfo('rss2_url');
    } else {
        return "";
    }
}

function NullGetSocialIcon($socialKey) {
    global $socialIconArray;
    
    $socialUrl = get_bloginfo('template_url')."/img/";
    
    if ($socialKey == "linkedin") {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['linkedin'], 'alt' => 'LinkedIn'));
    } else if ($socialKey == "twitter") {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['twitter'], 'alt' => 'Twitter'));
    } else if ($socialKey == "github") {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['github'], 'alt' => 'Github'));
    } else if ($socialKey == "email") {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['email'], 'alt' => 'Email'));
    } else if ($socialKey == 'googleplus') {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['googleplus'], 'alt' => 'Google Plus'));
    } else if ($socialKey == 'rss') {
        return NullFlag('img', array('src' => $socialUrl.$socialIconArray['rss'], 'alt' => 'RSS'));
    }
}

$socialIconArray = array();
function NullRegisterSocialIcons($iconArray=array()) {
    global $socialIconArray;
    $socialIconArray = $iconArray;
}

?>