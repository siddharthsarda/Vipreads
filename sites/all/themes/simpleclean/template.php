<?php
/**
 * @file
 * Contains theme preprocess functions
 */
 
 /**
  * Override or insert variables into the html template.
  */
function simpleclean_preprocess_html(&$vars) {
  // Add conditional CSS for IE6.
  drupal_add_css(path_to_theme() . '/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}

/**
 * Format submitted by in articles
 */
function simpleclean_preprocess_node(&$vars) {
  $node = $vars['node'];
  $vars['date'] = format_date($node->created, 'custom', 'd M Y');

  if (variable_get('node_submitted_' . $node->type, TRUE)) {
    $vars['display_submitted'] = TRUE;
    $vars['submitted'] = t('By @username on !datetime', array('@username' => $node->name, '!datetime' => $vars['date']));
    $vars['user_picture'] = theme_get_setting('toggle_node_user_picture') ? theme('user_picture', array('account' => $node)) : '';
    
    // Add a footer for post
    $account = user_load($vars['node']->uid);
    $vars['simpleclean_postfooter'] = '';
    if (!empty($account->signature)) {  
      $postfooter = "<div class='post-footer'>" . $vars['user_picture'] . "<h3>" . check_plain(format_username($account)) . "</h3>";
      $cleansignature = strip_tags($account->signature);
      $postfooter .= "<p>" . check_plain($cleansignature) . "</p>";
      $postfooter .= "</div>";
      $vars['simpleclean_postfooter'] = $postfooter;
    } 
  }
  else {
    $vars['display_submitted'] = FALSE;
    $vars['submitted'] = '';
    $vars['user_picture'] = '';
  }
  
  // Remove Add new comment from teasers on frontpage
  
  if ($vars['is_front']) {
    unset($vars['content']['links']['comment']['#links']['comment-add']);
    unset($vars['content']['links']['comment']['#links']['comment_forbidden']);
  }
  
}

/**
 * Format submitted by in comments
 */
function simpleclean_preprocess_comment(&$vars) {
  $comment = $vars['elements']['#comment'];
  $node = $vars['elements']['#node'];
  $vars['created']   = format_date($comment->created, 'custom', 'd M Y');
  $vars['changed']   = format_date($comment->changed, 'custom', 'd M Y');
  $vars['submitted'] = t('By @username on !datetime at about @time.', array('@username' => $comment->name, '!datetime' => $vars['created'], '@time' => format_date($comment->created, 'custom', 'H:i')));
}

/**
 * Change button to Post instead of Save
 */
function simpleclean_form_comment_form_alter(&$form, &$form_state, &$form_id) {
 $form['actions']['submit']['#value'] = t('Post');
 $form['comment_body']['#after_build'][] = 'configure_comment_form'; 
}

function configure_comment_form(&$form) {
  $form['und'][0]['format']['#access'] = FALSE;
  return $form;
}

/**
 * Returns HTML for a feed icon.
 *
 * @param $variables
 *   An associative array containing:
 *   - url: An internal system path or a fully qualified external URL of the
 *     feed.
 *   - title: A descriptive title of the feed.
 */
function simpleclean_feed_icon($variables) {
  $text = t('Subscribe to @feed-title', array('@feed-title' => $variables['title']));
  $twitterText=t("Follow us on Twitter");
  $outputText='';
  if ($image = theme('image', array('path' => 'misc/feed.png', 'width' => 16, 'height' => 16, 'alt' => $text))) {
    $outputText = l($image, $variables['url'], array('html' => TRUE, 'attributes' => array('class' => array('feed-icon'), 'title' => $text)));
 
  $path = path_to_theme();
  $twitter_icon = '<span ><a class="twitter-icon" href="http://twitter.com/vipreads"></a></span>';
  return $twitter_icon.$outputText;
  }
}





