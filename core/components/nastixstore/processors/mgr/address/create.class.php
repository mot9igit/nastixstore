<?php

class nsAddressCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'nsAddress';
    public $classKey = 'nsAddress';
    public $languageTopics = ['nastixstore'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        return parent::beforeSet();
    }

}

return 'nsAddressCreateProcessor';