<?php

class nsOrderStatusCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'nsOrderStatus';
    public $classKey = 'nsOrderStatus';
    public $languageTopics = ['nastixstore'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('nastixstore_status_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('nastixstore_status_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'nsOrderStatusCreateProcessor';