<?php
/**
 * User: Zura
 * Date: 3/2/2016
 * Time: 1:45 PM
 */

namespace centigen\base\helpers;
use Yii;
use yii\db\Exception;


/**
 * Class DatetimeHelper
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class DateHelper
{
    public static $yiiFormatToMomentMapping = [
        'php:d F Y' => 'DD MMMM YYYY',
        'php:d M Y' => 'DD MMM YYYY',
        'd/MM/YYYY HH:mm' => 'D/MM/YYYY HH:mm',
        'MM/d/YYYY HH:mm' => 'MM/D/YYYY HH:mm',
        'd/M/YYYY HH:mm' => 'D/M/YYYY HH:mm',
        'M/d/YYYY HH:mm' => 'M/D/YYYY HH:mm',
        'dd/MM/YYYY HH:mm' => 'DD/MM/YYYY HH:mm',
        'MM/DD/YYYY HH:mm' => 'MM/DD/YYYY HH:mm'
    ];

    public static $yiiFormatToPhpMapping = [
        'd/MM/YYYY HH:mm' => 'j/m/Y H:i',
        'MM/d/YYYY HH:mm' => 'm/j/Y H:i',
        'd/M/YYYY HH:mm' => 'j/n/Y H:i',
        'M/d/YYYY HH:mm' => 'n/j/Y H:i',
        'dd/MM/YYYY HH:mm' => 'd/m/Y H:i',
        'MM/DD/YYYY HH:mm' => 'm/d/Y H:i'
    ];
    
    /**
    * @var integer
    */
    const SECONDS_IN_A_MINUTE = 60;
    /**
     * @var integer
     */
    const SECONDS_IN_AN_HOUR = 3600;
    /**
     * @var integer
     */
    const SECONDS_IN_A_DAY = 86400;
    /**
     * @var integer
     */
    const SECONDS_IN_A_WEEK = 604800;
    /**
     * @var integer
     */
    const SECONDS_IN_A_MONTH = 2592000;
    /**
     * @var integer
     */
    const SECONDS_IN_A_YEAR = 31536000;

    const MYSQL_DATE_FORMAT = 'Y-m-d';
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Get current time into mysql date or datetime (depending on $asDate parameter) format to save into DB
     *
     * @author zura
     * @param bool $asDate
     * @return string
     */
    public static function getNowIntoMysql($asDate = false)
    {
        $now = new \DateTime();

        return $now->format($asDate ? self::MYSQL_DATE_FORMAT : self::MYSQL_DATETIME_FORMAT);
    }

    /**
     * Convert date string from given format to mysql
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $format
     * @param $dateString
     * @param null $timezone Date will be converted in this timezone
     * @param null $dateStringTimezone Date is considered to be in this timezone, thus, is converted from this timezone
     * @return string Mysql datetime string
     * @throws Exception
     */
    public static function fromFormatIntoMysql($format, $dateString, $timezone = null, $dateStringTimezone = null)
    {
        $datetime = \DateTime::createFromFormat($format, $dateString);
        if (!$datetime){
            throw new \InvalidArgumentException('Unable to parse date: '.$dateString.', using format: '.$format);
        }
        if ($timezone !== null){
            if ($dateStringTimezone === null){
                $dateStringTimezone = Yii::$app->timeZone;
            }
            $datetime = self::convertBetweenTimezones($datetime, $dateStringTimezone, $timezone);
        }
        return $datetime->format(self::MYSQL_DATETIME_FORMAT);
    }

    /**
     * Get current time in milliseconds
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return float
     */
    public static function getNowInMilliseconds()
    {
        list( $usec, $sec ) = explode(" ", microtime());
        $val = (floatval($usec) + floatval($sec)) * 1000;
        return round($val);
    }

    /**
     * Get current time into format
     *
     * @author zura
     * @param $format
     * @return string
     */
    public static function getNowIntoFormat($format)
    {
        $datetime = new \DateTime();

        return Yii::$app->formatter->asDate($datetime, $format);
    }

    /**
     * Get current time into given timezone
     *
     * @author zura
     * @param $timezone
     * @return \DateTime
     */
    public static function getCurrentTimeIntoTimezone($timezone)
    {
        $d = new \DateTime();

        $d->setTimezone(new \DateTimeZone($d->getTimezone()->getName()));
        $currentOffset = $d->getOffset();
        $d->setTimezone(new \DateTimeZone($timezone));
        $newOffset = $d->getOffset();

        return time() + ($newOffset - $currentOffset);
    }

    /**
     * Convert datetime from one timezone into another
     *
     * @author zura
     * @param \DateTime $datetime
     * @param           $timezoneFrom
     * @param           $timezoneTo
     * @return \DateTime
     */
    public static function convertBetweenTimezones(\DateTime $datetime, $timezoneFrom, $timezoneTo)
    {
        $datetime->setTimezone(new \DateTimeZone($timezoneFrom));
        $currentOffset = $datetime->getOffset();
        $datetime->setTimezone(new \DateTimeZone($timezoneTo));
        $newOffset = $datetime->getOffset();

        return (new \DateTime())->setTimestamp($datetime->getTimestamp() + ( $newOffset - $currentOffset ));
    }

    /**
     * Convert mysql date format into given format using Yii2 formatter with optional timezone conversion
     *
     * @author zura
     * @param string $dateString
     * @param string $toFormat
     * @param string $timezoneTo
     * @param string $timezoneFrom
     * @param bool   $asDate
     * @return string
     */
    public static function fromMySqlToFormat($dateString, $toFormat, $timezoneTo = null, $timezoneFrom = null, $asDate = false)
    {
        if (!$dateString) {
            return $dateString;
        }
        $datetime = \DateTime::createFromFormat($asDate ? self::MYSQL_DATE_FORMAT : self::MYSQL_DATETIME_FORMAT, $dateString);
        if ($timezoneTo) {
            if (!$timezoneFrom) {
                $timezoneFrom = Yii::$app->formatter->defaultTimeZone;
            }
            $datetime = self::convertBetweenTimezones($datetime, $timezoneFrom, $timezoneTo);
        }
        return Yii::$app->formatter->{$asDate ? 'asDate' : 'asDatetime'}($datetime, $toFormat);
    }

    /**
     * Convert mysql datetime into time using Yii2 formatter with optional timezone conversion
     *
     * @author zura
     * @param string $dateString
     * @param string $timezoneTo
     * @param string $timezoneFrom
     * @return string
     */
    public static function fromMySqlToTime($dateString, $timezoneTo = null, $timezoneFrom = null)
    {
        if (!$dateString) {
            return $dateString;
        }
        $datetime = \DateTime::createFromFormat(self::MYSQL_DATETIME_FORMAT, $dateString);
        if ($timezoneTo) {
            if (!$timezoneFrom) {
                $timezoneFrom = Yii::$app->formatter->defaultTimeZone;
            }
            $datetime = self::convertBetweenTimezones($datetime, $timezoneFrom, $timezoneTo);
        }
        return Yii::$app->formatter->asTime($datetime);
    }

    /**
     * Convert timestamp received from user into mysql date or datetime format (depending on $asDate parameter) to save
     * it in DB
     *
     * @author zura
     * @param      $timestamp
     * @param null $timezoneFrom
     * @param null $timezoneTo
     * @param bool $asDate
     * @return string
     */
    public static function fromTimestampToMysql($timestamp, $timezoneFrom = null, $timezoneTo = null, $asDate = false)
    {
        $datetime = new \DateTime();
        if (strlen(strval($timestamp)) > 10) {
            $timestamp = $timestamp / 1000;
        }
        $datetime->setTimestamp($timestamp);
        if ($timezoneFrom) {
            if (!$timezoneTo) {
                $timezoneTo = Yii::$app->formatter->defaultTimeZone;
            }
            $datetime = self::convertBetweenTimezones($datetime, $timezoneFrom, $timezoneTo);
        }

        return $datetime->format($asDate ? self::MYSQL_DATE_FORMAT : self::MYSQL_DATETIME_FORMAT);
    }

    /**
     * Check if date is valid
     *
     * @author zura
     * @param $date
     * @param $format
     * @return bool|\DateTime
     */
    public static function validateDate($date, $format)
    {
        $d = \DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) == $date) {
            return $d;
        }

        return false;
    }

    /**
     * Convert Date from one format into another
     *
     * @author zura
     * @param $date
     * @param $formatFrom
     * @param $formatTo
     * @return string
     */
    public static function convertBetweenFormats($date, $formatFrom, $formatTo)
    {
        $d = \DateTime::createFromFormat($formatFrom, $date);

        return $d->format($formatTo);
    }

    public static function fromMySqlIntoTimestamp($dateString, $timezoneTo = null, $asDate = false, $multipleOn1000 = false)
    {
        $d = \DateTime::createFromFormat($asDate ? self::MYSQL_DATE_FORMAT : self::MYSQL_DATETIME_FORMAT, $dateString);
        if ($timezoneTo){
            $d = self::convertBetweenTimezones($d, Yii::$app->formatter->defaultTimeZone, $timezoneTo);
        }

        return $d->getTimestamp() * ($multipleOn1000 ? 1000 : 1);
    }

    /**
     * Convert mysql datetime string into php DateTime Object
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param            $dateString
     * @param null       $timezoneTo
     * @param bool|false $asDate
     * @return \DateTime
     */
    public static function fromMySqlIntoDateTime($dateString, $timezoneTo = null, $asDate = false)
    {
        $d = \DateTime::createFromFormat($asDate ? self::MYSQL_DATE_FORMAT : self::MYSQL_DATETIME_FORMAT, $dateString);
        if ($timezoneTo){
            $d = self::convertBetweenTimezones($d, Yii::$app->formatter->defaultTimeZone, $timezoneTo);
        }

        return $d;
    }

    public static function fromTimestampIntoFormat($timestamp, $toFormat, $timezoneTo = null, $timezoneFrom = null, $asDate = false)
    {
        return self::fromMySqlToFormat(self::fromTimestampToMysql($timestamp), $toFormat, $timezoneTo, $timezoneFrom, $asDate);
    }

    public static function addDate($datetime, $interval)
    {
        $date = $datetime;
        if (is_string($date)){
            $date = self::fromMySqlIntoDateTime($date);
        }

        $date = date_add($date, date_interval_create_from_date_string($interval));
        if (is_string($datetime)){
            $date = $date->format(self::MYSQL_DATE_FORMAT);
        }
        return $date;
    }

    public static function getDaysFromTimestamp($time)
    {
        return floor($time / 86400);
    }
    
    

    /**
     * Get corresponding momentjs format fot given yii format
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $format
     * @return mixed
     */
    public static function getMomentFormat($format)
    {
        return \yii\helpers\ArrayHelper::getValue(self::$yiiFormatToMomentMapping, $format) ?: $format;
    }

    /**
     * Get corresponding php format for given yii format
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $format
     * @return mixed
     */
    public static function getPhpFormat($format)
    {
        $format = \yii\helpers\ArrayHelper::getValue(self::$yiiFormatToPhpMapping, $format);
        if (!$format && strpos($format, 'php:') === 0){
            return str_replace('php:', '', $format);
        }
        return $format;
    }

    /**
     * Get corresponding momentjs format for current `datetimeFormat`
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return mixed
     */
    public static function getMomentDatetimeFormat()
    {
        return self::getMomentFormat(\Yii::$app->formatter->datetimeFormat);
    }

    /**
     * Get corresponding php datetime formar for current `datetimeFormat`
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return mixed
     */
    public static function getPhpDatetimeFormat()
    {
        return self::getPhpFormat(\Yii::$app->formatter->datetimeFormat);
    }
}