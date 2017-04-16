<?php
function NullLink($text, $url, $class="") {
    return NullTag('a', $text, array('href' => $url, 'class' => $class));
}

// Build a generic HTML tag with attributes. Setting an attribute value to null
// places the key without an ="" afterwards.
function NullTag($tag, $content="", $attr=array()) {
  $start = NullTagOpen($tag, $attr);
  $end = NullTagClose($tag);

  return $start.$content.$end;
}

function NullTagOpen($tag, $attr=array()) {
  $quote = "\"";
  $equal = "=";

  $start = "<".$tag;

  foreach ($attr as $name => $value) {
    if ($value == null) {
      $start .= " ".$name;
    } else {
      $start .= " ".$name.$equal.$quote.$value.$quote;
    }
  }

  $start .= ">";

  return $start;
}

function NullTagClose($tag) {
  $end = "</".$tag.">";
  return $end;
}

function NullFlag($flag, $attr=array()) {
    $start = "<".$flag;
    foreach ($attr as $name => $value) {
        $start = $start." ".$name."=\"".$value."\"";
    }
    $end = ">";
    return $start.$end;
}
?>
