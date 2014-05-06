<?php
/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace DeviceDetector\Parser\Device;

use DeviceDetector\Parser\ParserAbstract;

abstract class DeviceParserAbstract extends ParserAbstract
{
    protected $deviceType = null;
    protected $model = null;
    protected $brand = null;

    /**
     * Known device brands
     *
     * Note: Before using a new brand in on of the regex files, it needs to be added here
     *
     * @var array
     */
    public static $deviceBrands = array(
        'AC' => 'Acer',
        'AI' => 'Airness',
        'AL' => 'Alcatel',
        'AN' => 'Arnova',
        'AO' => 'Amoi',
        'AP' => 'Apple',
        'AR' => 'Archos',
        'AU' => 'Asus',
        'AV' => 'Avvio',
        'AX' => 'Audiovox',
        'BB' => 'BBK',
        'BE' => 'Becker',
        'BI' => 'Bird',
        'BL' => 'Beetel',
        'BM' => 'Bmobile',
        'BN' => 'Barnes & Noble',
        'BO' => 'BangOlufsen',
        'BQ' => 'BenQ',
        'BS' => 'BenQ-Siemens',
        'BX' => 'bq',
        'CA' => 'Cat',
        'CH' => 'Cherry Mobile',
        'CK' => 'Cricket',
        'CL' => 'Compal',
        'CN' => 'CnM',
        'CR' => 'CreNova',
        'CT' => 'Capitel',
        'CO' => 'Coolpad',
        'CU' => 'Cube',
        'DE' => 'Denver',
        'DB' => 'Dbtel',
        'DC' => 'DoCoMo',
        'DI' => 'Dicam',
        'DL' => 'Dell',
        'DM' => 'DMM',
        'DP' => 'Dopod',
        'EC' => 'Ericsson',
        'EI' => 'Ezio',
        'ER' => 'Ericy',
        'ET' => 'eTouch',
        'EZ' => 'Ezze',
        'FL' => 'Fly',
        'GD' => 'Gemini',
        'GI' => 'Gionee',
        'GG' => 'Gigabyte',
        'GO' => 'Google',
        'GR' => 'Gradiente',
        'GU' => 'Grundig',
        'HA' => 'Haier',
        'HP' => 'HP',
        'HT' => 'HTC',
        'HU' => 'Huawei',
        'HX' => 'Humax',
        'IA' => 'Ikea',
        'IB' => 'iBall',
        'IK' => 'iKoMo',
        'IM' => 'i-mate',
        'IN' => 'Innostream',
        'II' => 'Inkti',
        'IX' => 'Intex',
        'IO' => 'i-mobile',
        'IQ' => 'INQ',
        'IT' => 'Intek',
        'IV' => 'Inverto',
        'JI' => 'Jiayu',
        'JO' => 'Jolla',
        'KA' => 'Karbonn',
        'KD' => 'KDDI',
        'KN' => 'Kindle',
        'KO' => 'Konka',
        'KT' => 'K-Touch',
        'KH' => 'KT-Tech',
        'KY' => 'Kyocera',
        'LA' => 'Lanix',
        'LC' => 'LCT',
        'LE' => 'Lenovo',
        'LN' => 'Lenco',
        'LG' => 'LG',
        'LO' => 'Loewe',
        'LU' => 'LGUPlus',
        'LX' => 'Lexibook',
        'MA' => 'Manta Multimedia',
        'MB' => 'Mobistel',
        'MD' => 'Medion',
        'ME' => 'Metz',
        'MI' => 'MicroMax',
        'MK' => 'MediaTek',
        'MO' => 'Mio',
        'MR' => 'Motorola',
        'MS' => 'Microsoft',
        'MT' => 'Mitsubishi',
        'MY' => 'MyPhone',
        'NE' => 'NEC',
        'NG' => 'NGM',
        'NI' => 'Nintendo',
        'NK' => 'Nokia',
        'NN' => 'Nikon',
        'NW' => 'Newgen',
        'NX' => 'Nexian',
        'OD' => 'Onda',
        'OP' => 'OPPO',
        'OR' => 'Orange',
        'OT' => 'O2',
        'OU' => 'OUYA',
        'PA' => 'Panasonic',
        'PE' => 'PEAQ',
        'PH' => 'Philips',
        'PL' => 'Polaroid',
        'PM' => 'Palm',
        'PO' => 'phoneOne',
        'PT' => 'Pantech',
        'PP' => 'PolyPad',
        'PR' => 'Prestigio',
        'QT' => 'Qtek',
        'RM' => 'RIM',
        'RO' => 'Rover',
        'SA' => 'Samsung',
        'SD' => 'Sega',
        'SE' => 'Sony Ericsson',
        'SF' => 'Softbank',
        'SG' => 'Sagem',
        'SH' => 'Sharp',
        'SI' => 'Siemens',
        'SN' => 'Sendo',
        'SO' => 'Sony',
        'SP' => 'Spice',
        'SU' => 'SuperSonic',
        'SV' => 'Selevision',
        'SY' => 'Sanyo',
        'SM' => 'Symphony',
        'SR' => 'Smart',
        'TA' => 'Tesla',
        'TC' => 'TCL',
        'TE' => 'Telit',
        'TH' => 'TiPhone',
        'TI' => 'TIANYU',
        'TL' => 'Telefunken',
        'TM' => 'T-Mobile',
        'TN' => 'Thomson',
        'TO' => 'Toplux',
        'TS' => 'Toshiba',
        'TT' => 'TechnoTrend',
        'TV' => 'TVC',
        'TX' => 'TechniSat',
        'TZ' => 'teXet',
        'UT' => 'UTStarcom',
        'VD' => 'Videocon',
        'VE' => 'Vertu',
        'VI' => 'Vitelcom',
        'VK' => 'VK Mobile',
        'VS' => 'ViewSonic',
        'VT' => 'Vestel',
        'VO' => 'Voxtel',
        'VW' => 'Videoweb',
        'WB' => 'Web TV',
        'WE' => 'WellcoM',
        'WO' => 'Wonu',
        'WX' => 'Woxter',
        'XI' => 'Xiaomi',
        'XX' => 'Unknown',
        'YU' => 'Yuandao',
        'ZO' => 'Zonda',
        'ZT' => 'ZTE',
    );

    public function getDeviceType()
    {
        return $this->deviceType;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function parse()
    {
        $regexes = $this->getRegexes();
        foreach ($regexes as $brand => $regex) {
            $matches = $this->matchUserAgent($regex['regex']);
            if ($matches) {
                break;
            }
        }

        if (!$matches) {
            return false;
        }

        $brandId = array_search($brand, self::$deviceBrands);
        if($brandId === false) {
            throw new \Exception("The brand with name '$brand' should be listed in the deviceBrands array.");
        }
        $this->brand = $brandId;

        if (isset($regex['device'])) {
            $this->device = $regex['device'];
        }

        if (isset($regex['model'])) {
            $this->model = $this->buildModel($regex['model'], $matches);
        }

        if (isset($regex['models'])) {
            foreach ($regex['models'] as $modelRegex) {
                $matches = $this->matchUserAgent($modelRegex['regex']);
                if ($matches)
                    break;
            }

            if (!$matches) {
                return true;
            }

            $this->model = trim($this->buildModel($modelRegex['model'], $matches));

            if (isset($modelRegex['device'])) {
                $this->deviceType = $modelRegex['device'];
            }
        }

        return true;
    }

    protected function buildModel($model, $matches)
    {
        $model = $this->buildByMatch($model, $matches);

        $model = $this->buildByMatch($model, $matches, '2');

        $model = $this->buildModelExceptions($model);

        $model = str_replace('_', ' ', $model);

        return $model;
    }

    protected function buildModelExceptions($model)
    {
        if ($this->brand == 'O2') {
            #$model = preg_replace('/([a-z])([A-Z])/', '$1 $2', $model);
            #$model = ucwords(str_replace('_', ' ', $model));
        }

        return $model;
    }

}