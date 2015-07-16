<?php

namespace JesseMaxwell\PrayerBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'prayer_request' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.JesseMaxwell.PrayerBundle.Model.map
 */
class PrayerRequestTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.JesseMaxwell.PrayerBundle.Model.map.PrayerRequestTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('prayer_request');
        $this->setPhpName('PrayerRequest');
        $this->setClassname('JesseMaxwell\\PrayerBundle\\Model\\PrayerRequest');
        $this->setPackage('src.JesseMaxwell.PrayerBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 150, null);
        $this->addColumn('description', 'Description', 'CLOB', false, null, null);
        $this->addColumn('date', 'Date', 'DATE', true, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', true, null, null);
        $this->addColumn('answered', 'Answered', 'BOOLEAN', true, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // PrayerRequestTableMap
