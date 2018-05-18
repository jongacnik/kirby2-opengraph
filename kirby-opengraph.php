<?php

/**
 * KirbyOpengraph
 *
 * Included blueprint field group:
 * opengraph: opengraph
 *
 * Included snippet:
 * snippet('opengraph')
 *
 * Opengraph data site method:
 * $site->opengraph();
 *
 * Opengraph data page method:
 * $page->opengraph();
 *
 */

namespace KirbyOpengraph;
use c;
use site;
use page;

class KirbyOpengraph {
  public static function register () {
    site::$methods['opengraph'] = function ($site) {
      return self::getOgData();
    };

    page::$methods['opengraph'] = function ($page, $data = []) {
      return self::getOgData($page, $data);
    };

    kirby()->set('snippet', 'opengraph', __DIR__ . '/snippets/opengraph.php');
    kirby()->set('blueprint', 'fields/opengraph', __DIR__ . '/blueprints/opengraph.yml');
  }

  public static function getOgData ($page = false, $data = []) {
    // defaults
    $ogtitle = site()->title()->value();
    $ogdescription = site()->opengraphDescription()->value();
    $ogimage = site()->opengraphImage()->toFile();
    if ($ogimage) $ogimage = $ogimage->url();

    // override w/ page specific data
    if ($page && !$page->isHomePage()) {
      $thistitle = $page->title()->value();
      $ogtitle = $thistitle ? $thistitle : $ogtitle;

      $thistext = $page->opengraphDescription()->value();
      $thistext = $thistext ? $thistext : $page->text()->excerpt(240);
      $ogdescription = $thistext ? $thistext : $ogdescription;

      $thisimage = $page->opengraphImage()->toFile();
      if ($thisimage) {
        $ogimage = $thisimage->url();
      } else if ($thisimage = $page->featuredimage()->toFile()) {
        $ogimage = $thisimage->url();
      } else if (c::get('opengraph.image') && $thisimage = c::get('opengraph.image')($page)) {
        $ogimage = $thisimage->url();
      }
    }

    return [
      'title' => $ogtitle,
      'description' => $ogdescription,
      'image' => $ogimage
    ];
  }
}

KirbyOpengraph::register();
