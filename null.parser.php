<?php
/** Parses entry layout expressions.
 *
 * 'format' => 'field1/field2'         / means lay out vertically
 * 'format' => 'field1|field2/field3'  | means lay out horizontally with .row and .n.columns
 * 'format' => 'field1+field2/field3'  + means put side-by-side with <span> tags
 * 'format' => '3.field1|9.field2'     n. means number of columns
 *
 * Usage:
 *   Layout::parse("title/image/excerpt")->toHtml();
 */

class Symbol {
  public $char = '';

  public function toHtml() {
    return '';
  }
}

class Open extends Symbol {
  public function __construct() {
    $this->char = '(';
  }

  public function toString() {
    return "Open";
  }
}

class Close extends Symbol {
  public function __construct() {
    $this->char = ')';
  }

  public function toString() {
    return "Close";
  }
}

class Pipe extends Symbol {
  public function __construct() {
    $this->char = '|';
  }

  public function toString() {
    return "Pipe";
  }
}

class Slash extends Symbol {
  public function __construct() {
    $this->char = '/';
  }

  public function toString() {
    return "Slash";
  }
}

class Dot extends Symbol {
  public function __construct() {
    $this->char = '.';
  }

  public function toString() {
    return "Dot";
  }

  public function toHtml() {
    return '&nbsp;';
  }
}

class Word {
  public $word = '';

  public function __construct($word='') {
    if ($word != '') {
      $this->word = "__" . strtoupper($word) . "__";
    }
  }

  public function toString() {
    return "Word(".$this->word.")";
  }

  public function toHtml() {
    return $this->word;
  }
}

class Group {
  public $components = array();
  public function __construct($components=array()) {
    $this->components = $components;
  }

  public function toString() {
    $tr = "Group(";

    foreach ($this->components as $component) {
      $tr .= $component->toString();
      $tr .= ",";
    }

    return substr($tr, 0, strlen($tr)-1).")";
  }

  public function toHtml() {
    $tr = "";
    foreach ($this->components as $component) {
      $tr .= $component->toHtml();
    }
    return $tr;
  }
}

class GroupHorizontal extends Group {
  public function toString() {
    $tr = "GroupHorizontal(";

    foreach ($this->components as $component) {
      $tr .= $component->toString();
      $tr .= ",";
    }

    return substr($tr, 0, strlen($tr)-1).")";
  }

  public function toHtml() {
    global $availableColumnWidths;

    $numComponents = count($this->components);
    $width = $availableColumnWidths[$numComponents];

    foreach ($this->components as $component) {
      $tr .= NullColumn($width, $component->toHtml());
    }

    return NullRow($tr);
  }
}

class GroupVertical extends Group {
  public function toString() {
    $tr = "GroupVertical(";

    foreach ($this->components as $component) {
      $tr .= $component->toHtml();
      $tr .= ",";
    }

    return substr($tr, 0, strlen($tr)-1).")";
  }

  public function toHtml() {
    foreach ($this->components as $component) {
      $tr .= NullTag('div', $component->toHtml());
    }
    return $tr;
  }
}


class Layout {
  private $components = array();

  public function __construct($components = array()) {
    self::$components = $components;
  }

  public static function parse($str) {
    $str = trim(str_replace(' ', '', $str));
    $parsedSymbols = Layout::parseSymbols($str);
    $parsed = Layout::parseFromSymbols($parsedSymbols);

    if (count($parsed) > 1) {
      return new Group($parsed);
    } else {
      return $parsed[0];
    }
  }

  public static function parseFromSymbols($parsedSymbols=array()) {
    $parsed = Layout::parseGroups($parsedSymbols);
    $parsed = Layout::parseSymbolGroups(Slash, $parsed);
    $parsed = Layout::parseSymbolGroups(Pipe, $parsed);
    // $parsed = Layout::parseOther(Dot, $parsed);
    return $parsed;
  }

  public static function parseSymbols($str) {
    $tr = array();
    $numChars = strlen($str);
    $wordStart = 0;
    $isWord = true;

    for( $i = 0; $i < $numChars; $i ++ ) {
      $char = substr( $str, $i, 1 );

      if ($char == '(' || $char == ')' || $char == '|' || $char == '/' || $char == '.') {

        if ( $isWord ) {
          // Register the word.
          $word = substr( $str, $wordStart, $i - $wordStart );
          array_push( $tr, new Word($word) );
        }

        $isWord = false;

        if ($char == '(') {
          array_push( $tr, new Open() );
        } else if ($char == ')') {
          array_push( $tr, new Close() );
        } else if ( $char == '|' ) {
          array_push( $tr, new Pipe() );
        } else if ( $char == '/' ) {
          array_push( $tr, new Slash() );
        } else if ( $char == '.' ) {
          array_push( $tr, new Dot() );
        }

      } else {

        if ( ! $isWord ) {
          $isWord = true;
          $wordStart = $i;
        }

      }
    } // end for

    if ($isWord) {
      // Register the word.
      $word = substr( $str, $wordStart, $i - $wordStart );
      // print $word . $wordStart . " " . ($i - $wordStart);
      $isWord = false;
      array_push( $tr, new Word($word) );
    }

    return $tr;
  }

  public static function parseGroups($toParse) {
    $tr = array();

    $inside = false;
    $depth = 0;
    $numElts = count($toParse);
    $groupElts = array();

    for( $i = 0; $i < $numElts; $i ++ ) {
      $elt = $toParse[$i];

      if (is_a($elt, Open) && !$inside) {
        // Starting a group.
        $inside = true;
        $depth ++;
      } else if (is_a($elt, Open)) {
        // Group within a group. We don't really care. Parse it later.
        $depth ++;
        array_push($groupElts, $elt);
      } else if (is_a($elt, Close) && $inside) {
        $depth --;
        if ($depth == 0) {
          // Done with this group.
          $group = new Group( Layout::parseFromSymbols( $groupElts ) );
          // Skip this closing paren.
          $inside = false;
          $groupElts = array();
          array_push($tr, $group);
        }
        array_push($groupElts, $elt);
      } else if ($inside) {
        array_push($groupElts, $elt);
      } else {
        array_push($tr, $elt);
      }
    } // end for

    return $tr;
  }

  // These are groups that are naturally grouped by an operator:
  // e/a|b|c/d => e,Group(a,b,c),c
  public function parseSymbolGroups($separator, $toParse=array()) {
    $other = Slash;
    if ( $separator == Slash ) {
      $other = Pipe;
    }

    $tr = array();
    $numSymbols = count($toParse);
    $inside = false;
    $groupElts = array();

    for( $i = 0; $i < $numSymbols; $i ++ ) {
      $elt = $toParse[$i];
      $isEnd = $i == ($numSymbols - 1);

      if ( is_a( $elt, $separator ) && ! $inside ) {
        $previous = array_pop($tr);

        $inside = true;
        array_push( $groupElts, $previous );
        continue;
      }

      if ($inside) {

        if ( ! is_a( $elt, Pipe ) && ! is_a( $elt, Slash ) ) {
          array_push( $groupElts, $elt );
        }

        if ( is_a( $elt, $other ) || $isEnd ) {
          // End the group here.

          $group == null;
          if ( $separator == Slash ) {
            $group = new GroupVertical($groupElts);
          } else {
            $group = new GroupHorizontal($groupElts);
          }

          array_push( $tr, $group );
          $inside = false;

          if ( !$isEnd ) {
            // If this isn't the end of the symbols to parse, we're still going to need this element.
            array_push( $tr, $elt );
          }

          continue;
        }

      } else {
        // If not inside, add it to the result at the top level.
        array_push( $tr, $elt );
      }

    } // end for

    return $tr;
  }
}

?>
