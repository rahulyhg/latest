<?php

namespace Application\Model\Entity;

interface PersonalDetailsInterface
{
   public function exchangeArray($data);
   
   public function exchangeArrayTable($data);
}