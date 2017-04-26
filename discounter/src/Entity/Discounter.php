<?php

namespace Drupal\discounter\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the DiscountContent entity.
 *
 * @ContentEntityType(
 * id = "discounter1",
 * label = @Translation("Discounter Content entity"),
 * base_table = "discounter1",
 * entity_keys = {
 *   "id" = "id",
 *   "uuid" = "uuid",
 *   "uid" = "uid"
 * },
 * )
 */
class Discounter extends ContentEntityBase implements ContentEntityInterface{

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('Discounter code'))
      ->setDefaultValueCallback('Drupal\discounter\Entity\Discounter::getDiscounterCode')
      ->setSettings(array(
        'max_length' => 10,
        ));

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('The user ID of the discount.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback('Drupal\discounter\Entity\Discounter::getCurrentUserId')
      ->setTranslatable(TRUE);
    return $fields;
  }

/*
 *Get user id.
 */
  public static function getCurrentUserId() {
    return [\Drupal::currentUser()->id()];
  }

/*
 *Generate discount code and check to unique, then return code to entity.
 */
  public static function getDiscounterCode() {
    $query = db_select('discounter1', 'v');
    $query->fields('v',array('code'));
    $result = $query->execute();
    while($record = $result->fetchAssoc()) {
      $array_code[] = $record['code'];
    }
    while (TRUE) {
      $length = 10;
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      if (!(in_array($randomString, $array_code))) {
        break;
      }
    }
    return $randomString;
  }
}
