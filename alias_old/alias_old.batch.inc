<?php

/**
 * Batch process callback.
 */
function alias_old_change_alias($nid, &$context) {

  $node = node_load($nid);
  $path = "'node/$nid'";

  // Get alias path
  $alias = db_query("SELECT alias FROM url_alias WHERE source = ".$path." LIMIT 1");
  while($record = $alias->fetchAssoc()) {
        // New alias path
        $alias_path = $record['alias'].'-old';
  }
  // Set alias path
  if(!(substr($alias_path, -4) == '-old')) {
    db_query("UPDATE url_alias SET alias = '".$alias_path."' WHERE source = ".$path);  	
  }

 
  $context['results']['titles'][] = $node->title;
  $context['message'] = 'Обновлена дата у материала <em>' . check_plain($node->title) . '</em>';
}
 
/**
 * Batch finish callback.
 */
function alias_old_finished($success, $results, $operations) {
  if ($success) {
    drupal_set_message('Завершено');
  }
  else {
    drupal_set_message('Завершено с ошибками.', 'error');
  }
}
