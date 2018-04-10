<?php

namespace Salesforce;

/**
 * @package Salesforce
 */
class Formatter
{
    /**
     * @param array $records
     *
     * @return array
     */
    static public function formatRecords(array $records)
    {
        foreach ($records['records'] as $key => $columns) {
            $records['records'][$key] = self::formatColumns($columns);
        }

        return $records;
    }

    /**
     * @param array $columns
     *
     * @return array
     */
    static public function formatColumns(array $columns)
    {
        return array_reduce($columns['columns'], function ($sum, $item) {
            $sum[$item['fieldNameOrPath']] = $item['value'];

            return $sum;
        }, []);
    }
}
