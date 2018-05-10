<?php

namespace Mtigdemir\Github\Transformer;

class RepositoryTransformer
{
    protected $items;

    /**
     * RepositoryTransformer constructor.
     * @param $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function groupBy()
    {
        $groupArray = [];

        foreach ($this->items as $key => $item) {
            $groupArray[$item]['items'][] = $key;
            $groupArray[$item]['count'] +=1;
        }

        arsort($groupArray);

        return $groupArray;
    }

    public function convert(array $repositories)
    {
        $this->items = array_column($this->filterEmptyLanguages($repositories), 'language', 'id');

        return $this;
    }

    // Remove Empty and Null Languages from array
    public function filterEmptyLanguages(array $data)
    {
        foreach ($data as $key => $item) {
            if ($item['language'] == '' || $item == null) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }
}