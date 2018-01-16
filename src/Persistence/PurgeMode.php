<?php

namespace DIOHz0r\Glpi\Fixtures\Persistence;

class PurgeMode {

   private static $values = [
      'NO_PURGE_MODE' => 0,
      'DELETE_MODE'   => 1,
      'TRUNCATE_MODE' => 2,
   ];
   /**
    * @var int
    */
   private $mode;

   public function __construct($mode) {
      if (false === array_key_exists($mode, array_flip(self::$values))) {
         throw new \InvalidArgumentException(
            sprintf('Unknown purge mode "%d".', $mode)
         );
      }
      $this->mode = $mode;
   }

   public static function createDeleteMode() {
      return new self(self::$values['DELETE_MODE']);
   }

   public static function createTruncateMode() {
      return new self(self::$values['TRUNCATE_MODE']);
   }

   public static function createNoPurgeMode() {
      return new self(self::$values['NO_PURGE_MODE']);
   }

   public function getValue() {
      return $this->mode;
   }

   public function __toString() {
      return (string) array_flip(self::$values)[$this->mode];
   }
}