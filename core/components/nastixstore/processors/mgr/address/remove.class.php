<?php

class nsAddressRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'nsAddress';
    public $classKey = 'nsAddress';
    public $languageTopics = ['nastixstore'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('nastixstore_address_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var nsDelivery $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('nastixstore_address_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'nsAddressRemoveProcessor';