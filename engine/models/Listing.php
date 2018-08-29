<?php

namespace app\models;

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://www.easyads.io
 * @copyright  2017 EasyAds (https://www.easyads.io)
 * @license    https://www.easyads.io
 * @since      1.0
 */

use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class Listing
 * @package app\common\models
 */
class Listing extends \app\models\auto\Listing
{
    const STATUS_ACTIVE             = 'active';
    const STATUS_EXPIRED            = 'expired';
    const STATUS_DRAFT              = 'draft';
    const STATUS_DEACTIVATED        = 'deactivated';
    const STATUS_PENDING_APPROVAL   = 'pending approval';

    const TYPE_PREICO = 0;
    const TYPE_ICO = 1;

    const EVENT_TYPE_ACTIVE = 'active';
    const EVENT_TYPE_UPCOMING = 'upcoming';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'type'], 'required'],
            [['title', 'price'], 'trim'],
            [['category_id', 'currency_id', 'location_id', 'negotiable', 'hide_phone', 'hide_email', 'package_id'], 'integer'],
            [['price'], 'double'],
            //[['active_from_date'],'date', 'format'=>'Y-M-d', 'skipOnEmpty' => true],
            //[['active_from_date'], 'default', 'value' => null],
            [['title'], 'string', 'max' => 80],
            [['description'], 'string', 'min' => 30],
            [['description'], 'string'],
            [['status'], 'safe'],

            [['token', 'platform', 'pre_ico_price', 'ico_price', 'whitelist_kyc', 'restricted_areas', 'bonus', 'accepting', 'minimum_investment', 'soft_cap', 'hard_cap'], 'match',
                'pattern' => '/^[a-z0-9,.=\s-]+$/i', 'message' => t('app', 'Field can only contain Alphabet, Numbers and special characters -.,='), 'skipOnEmpty' => true],
            [['youtube', 'bounty', 'mvp_prototype'], 'url', 'skipOnEmpty' => true],
            [['youtube'], 'match', 'pattern' => '/^(http(s)??\:\/\/)?(www\.)?(youtube\.com\/watch\?v=)|(youtu.be\/)[a-zA-Z0-9\-_]+$/i', 'message' => t('app', 'Entered link is not a valid youtube URL.')],
            [['token', 'platform', 'pre_ico_price', 'ico_price', 'whitelist_kyc', 'restricted_areas', 'bonus', 'accepting', 'minimum_investment', 'soft_cap', 'hard_cap', 'youtube', 'bounty', 'mvp_prototype'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors[] = [
            'class'     => SluggableBehavior::className(),
            'value' => [$this, 'getSlug'] //https://github.com/yiisoft/yii2/issues/7773
        ];

        return $behaviors;
    }

    /**
     *@inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'title'         => t('app', 'Ad title'),
            'price'         => t('app', 'Ad price'),
            'status'        => t('app', 'Ad status'),
            'category_id'   => t('app', 'Ad category'),
            'currency_id'   => t('app', 'Ad currency'),
            'description'   => t('app', 'ICO description'),
            'negotiable'    => t('app', 'Negotiable Price'),
            'hide_phone'    => t('app', 'Hide phone in ad'),
            'hide_email'    => t('app', 'Hide email in ad'),
            'youtube'       => t('app', 'Youtube link'),
            'token'       => t('app', 'Token name / Ticker'),
            'platform'       => t('app', 'Platform and Token Type (e.g. Ethereum, ERC20)'),
            'pre_ico_price'       => t('app', 'PRE-ICO Price per token (e.g. 1 IBC = 0.01 ETH)'),
            'ico_price'       => t('app', 'Price per token (e.g. 1 IBC = 0.01 ETH)'),
            'bounty'       => t('app', 'Link to bounty'),
            'mvp_prototype'       => t('app', 'Link to MVP/Prototype'),
            'whitelist_kyc'       => t('app', 'Whitelist/KYC?'),
            'restricted_areas'       => t('app', 'Any restrictions in who can participate?'),
            'bonus'       => t('app', 'Bonus'),
            'accepting'       => t('app', 'Accepting'),
            'minimum_investment'       => t('app', 'Minimum Investment'),
            'soft_cap'       => t('app', 'Soft Cap'),
            'hard_cap'       => t('app', 'Hard Cap'),
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->customer_id = app()->customer->identity->id;
        }

        // this will change the way of listing ads ( promo and regular ) v 1.0.1
        if($this->promo_expire_at === null) {
            $this->promo_expire_at = $this->created_at;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();

        $listingImage = ListingImage::find()->where(['listing_id' => $this->listing_id])->all();
        foreach ($listingImage as $key => $value) {
            $value->delete();
        }

        return true;
    }

    /**
     * @return array|null|string|\yii\db\ActiveRecord
     */
    public function generateSlug()
    {
        $unique = \app\helpers\StringHelper::uniqid();
        $exists = $this->findBySlug($unique);

        if (!empty($exists)) {
            return $this->generateSlug();
        }

        return $unique;
    }

    /**
     * @param $slug
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findBySlug($slug)
    {
        return $this->find()->where(array(
            'slug' => $slug,
        ))->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['currency_id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(CustomerStore::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['location_id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(ListingPackage::className(), ['package_id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFieldValues()
    {
        return $this->hasMany(CategoryFieldValue::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(ListingImage::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * @param $customer
     * @return bool
     */
    public function isOwnedBy($customer)
    {
        $customer_id = $customer;
        if (is_object($customer_id) && !empty($customer_id->customer_id)) {
            $customer_id = $customer_id->customer_id;
        }
        return $customer_id == $this->customer_id;
    }

    /**
     * @return bool
     */
    public function deactivate()
    {
        $this->status = self::STATUS_DEACTIVATED;
        $this->save(false);
        return true;
    }

    /**
     * @return bool
     */
    public function activate()
    {
        if($this->status == self::STATUS_DEACTIVATED) {
            $this->status = self::STATUS_ACTIVE;
            $this->save(false);
        }
        return true;
    }

    /**
     * @return bool
     */
    public static function sendAdActivateEmail($ad = null)
    {
        if ($ad == null || $ad->status == self::STATUS_ACTIVE) {
            return false;
        }

        if (!($modelCustomer = Customer::find()->where(['customer_id'=>$ad->customer_id])->one())) {
            return false;
        }

        return app()->mailSystem->add('ad-is-active', ['listing_id' => $ad->listing_id]);
    }

    /**
     * @return bool
     */
    public static function sendAdDeactivateEmail($ad = null)
    {
        if ($ad == null || $ad->status == self::STATUS_DEACTIVATED) {
            return false;
        }

        if (!($modelCustomer = Customer::find()->where(['customer_id'=>$ad->customer_id])->one())) {
            return false;
        }

        return app()->mailSystem->add('ad-is-deactivated', ['listing_id' => $ad->listing_id]);
    }

    /**
     * @return bool
     */
    public static function sendWaitingApprovalEmail($ad = null)
    {
        if ($ad == null || $ad->status != self::STATUS_PENDING_APPROVAL) {
            return false;
        }

        if (!($modelCustomer = Customer::find()->where(['customer_id'=>$ad->customer_id])->one())) {
            return false;
        }

        return app()->mailSystem->add('ad-is-waiting-approval', ['listing_id' => $ad->listing_id]);
    }

    /**
     * @param null $ad
     * @return string
     */
    public function getMetaDescription()
    {
        return StringHelper::truncate(strip_tags($this->description), 160, '');
    }

    /**
     * @param $event
     * @return string
     * //https://github.com/yiisoft/yii2/issues/7773
     */
    public function getSlug($event)
    {
        if(!empty($event->sender->slug)) {
            return $event->sender->slug;
        }
        return Inflector::slug($event->sender->title . ' ' . $this->generateSlug());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorite()
    {
        $id = 0;
        if(app()->customer->identity) {
            $id = app()->customer->identity->id;
        }
        return $this->hasOne(ListingFavorite::className(), ['listing_id' => 'listing_id'])
            ->andOnCondition(['customer_id' => $id]);
    }

    /**
     * @return ListingImage|array|null
     */
    public function getMainImage()
    {
        $uploadedImage = ListingImage::find()
            ->select('sort_order')
            ->where(['listing_id' => $this->listing_id])
            ->orderBy('sort_order ASC')
            ->one();

        return $this->hasOne(ListingImage::className(), ['listing_id' => 'listing_id'])->andFilterWhere(['sort_order' => $uploadedImage->sort_order]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStat()
    {
        return $this->hasOne(ListingStat::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * Check whether an ad is negotiable
     *
     * @return bool
     */
    public function isNegotiable()
    {
        return (bool)$this->negotiable;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSymbolOfCurrency($currencyCode)
    {
        return Currency::find()->where([
            'code' => $currencyCode,
            'status'    => Currency::STATUS_ACTIVE
        ]);
    }

    /**
     * @param $currencyCode
     * @return bool|string
     */
    public function getPriceAsCurrency($currencyCode)
    {
        if(!$currencyCode) return false;

//        $fmt = new \NumberFormatter('',\NumberFormatter::CURRENCY );
//        $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, '&#8381;');
//        echo $fmt->format(1234567.89);
//        dd($fmt);

        return app()->formatter->asCurrency($this->price,$currencyCode,[\NumberFormatter::MIN_FRACTION_DIGITS => 0]);
    }

    /**
     * @return string
     */
    public function getUpdatedDateAsDateTimeFull()
    {
        return app()->formatter->asDatetime($this->updated_at, 'full');
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function getIsExpired()
    {
        return $this->status == self::STATUS_EXPIRED;
    }

    /**
     * @return bool
     */
    public function getIsFavorite()
    {
        return (!empty($this->favorite)) ? true : false;
    }

    public function getIsPromoted()
    {
        return (strtotime(date("Y-m-d H:i:s")) < strtotime($this->promo_expire_at)) ? true : false;
    }

    /**
     * Get string that consist of zone name and country name
     *
     * @return string
     */
    public function getZoneCountryString()
    {
        return $this->location->country->name;
    }
    /**
     * Get string that represents days/hours left until ad becomes active
     *
     * @return string
     */
    public function getDateUntilActive() {
        $date = new \DateTime($this->active_from_date);
        $now =  new \DateTime();
        $interval = $now->diff( $date);
        $totalDays = (int)$interval->format("%a");
        $hours = (int)$interval->format("%h");
        $pluralizeDays = ($totalDays == 1 || $totalDays == 0) ?  t('app', 'day') :  t('app', 'days');
        $pluralizeHours = ($hours == 1 || $hours == 0) ?  t('app', 'hour') :  t('app', 'hours');
        return $interval->format("%a ".$pluralizeDays.", %h ".$pluralizeHours);
    }

    /**
     * @return array
     */
    static function getListingStatusesList()
    {
        return [
            self::STATUS_ACTIVE             => t('app', 'Active'),
            self::STATUS_EXPIRED            => t('app', 'Expired'),
            self::STATUS_DRAFT              => t('app', 'Draft'),
            self::STATUS_DEACTIVATED        => t('app', 'Deactivated'),
            self::STATUS_PENDING_APPROVAL   => t('app', 'Pending approval'),
        ];
    }

    static function getTypes() {
        return [
            self::TYPE_PREICO  => t('app', 'Pre-ICO'),
            self::TYPE_ICO => t('app', 'ICO')
        ];
    }
}