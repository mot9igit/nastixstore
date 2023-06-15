<?php

class nsAddressGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'nsAddress';
    public $classKey = 'nsAddress';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'street:LIKE' => "%{$query}%",
                'OR:index:LIKE' => "%{$query}%",
                'OR:settlement:LIKE' => "%{$query}%",
                'OR:region:LIKE' => "%{$query}%"
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('nastixstore_update'),
            'action' => 'updateAddress',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('nastixstore_remove'),
            'multiple' => $this->modx->lexicon('nastixstore_remove'),
            'action' => 'removeAddress',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'nsAddressGetListProcessor';