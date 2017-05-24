<?php

/**
 * Title changer form
 * Allows to start Batch operations
 */
function alias_old_form() {
  $form = array();
 
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('GO'),
  );
 
  return $form;
}
 
/**
 * Submit callback for title changer form
 */
function alias_old_form_submit($form, &$form_state) {
  $result = node_load_multiple(array(), array('type' => 'test', 'status' => 0)); 

  foreach ($result as $row) {
    $operations[] = array('alias_old_change_alias', array($row->nid));
  }
    $batch = array(
    'operations' => $operations,
    'finished' => 'alias_old_finished',
    'title' => 'Обновление alias',
    'init_message' => 'Подготовка данных',
    'progress_message' => 'Выполнено @current из @total.',
    'error_message' => 'Произошла ошибка.',
    'file' => drupal_get_path('module', 'alias_old') . '/alias_old.batch.inc',
  );

  batch_set($batch);
  batch_process();
}



