<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\Goals;

use Piwik\Plugins\VisitFrequency\API as VisitFrequencyAPI;

class Archiver extends \Piwik\Plugin\Archiver
{
    const VISITS_UNTIL_RECORD_NAME = 'visits_until_conv';
    const DAYS_UNTIL_CONV_RECORD_NAME = 'days_until_conv';
    const ITEMS_SKU_RECORD_NAME = 'Goals_ItemsSku';
    const ITEMS_NAME_RECORD_NAME = 'Goals_ItemsName';
    const ITEMS_CATEGORY_RECORD_NAME = 'Goals_ItemsCategory';
    const SKU_FIELD = 'idaction_sku';
    const NAME_FIELD = 'idaction_name';
    const CATEGORY_FIELD = 'idaction_category';
    const CATEGORY2_FIELD = 'idaction_category2';
    const CATEGORY3_FIELD = 'idaction_category3';
    const CATEGORY4_FIELD = 'idaction_category4';
    const CATEGORY5_FIELD = 'idaction_category5';
    const NO_LABEL = ':';
    const LOG_CONVERSION_TABLE = 'log_conversion';
    const VISITS_COUNT_FIELD = 'visitor_count_visits';
    const SECONDS_SINCE_FIRST_VISIT_FIELD = 'visitor_seconds_since_first';

    public function getDependentSegmentsToArchive()
    {
        return [
            VisitFrequencyAPI::NEW_VISITOR_SEGMENT,
            VisitFrequencyAPI::RETURNING_VISITOR_SEGMENT,
        ];
    }

    /**
     * @param string $recordName 'nb_conversions'
     * @param int|bool $idGoal idGoal to return the metrics for, or false to return overall
     * @return string Archive record name
     */
    public static function getRecordName($recordName, $idGoal = false)
    {
        $idGoalStr = '';
        if ($idGoal !== false) {
            $idGoalStr = $idGoal . "_";
        }
        return 'Goal_' . $idGoalStr . $recordName;
    }

    public static function getItemRecordNameAbandonedCart($recordName)
    {
        return $recordName . '_Cart';
    }
}
