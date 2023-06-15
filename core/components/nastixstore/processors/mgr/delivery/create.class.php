<?php

class nsDeliveryCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'nsDelivery';
    public $classKey = 'nsDelivery';
    public $languageTopics = ['nastixstore'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('nastixstore_delivery_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('nastixstore_delivery_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'nsDeliveryCreateProcessor';