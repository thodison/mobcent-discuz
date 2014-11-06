<?php

/**
 * UI Diy model类
 *
 * @author 谢建平 <jianping_xie@aliyun.com>
 * @copyright 2012-2014 Appbyme
 */

if (!defined('IN_DISCUZ') || !defined('IN_APPBYME')) {
    exit('Access Denied');
}

class AppbymeUIDiyModel extends DiscuzAR
{
    // navigator
    const NAV_KEY = 'app_uidiy_nav_info';
    const NAV_KEY_TEMP = 'app_uidiy_nav_info_temp';

    const NAV_TYPE_BOTTOM = 'bottom';
    const NAV_ITEM_ICON_1 = 'mc_forum_main_bar_button1';

    // module
    const MODULE_KEY = 'app_uidiy_modules';
    const MODULE_KEY_TEMP = 'app_uidiy_modules_temp';
    
    const MODULE_ID_DISCOVER = 1;
    const MODULE_ID_FASTPOST = 2;

    const MODULE_TYPE_FULL = 'full';
    const MODULE_TYPE_SUBNAV = 'subnav';
    const MODULE_TYPE_NEWS = 'news';
    const MODULE_TYPE_FASTPOST = 'fastpost';
    const MODULE_TYPE_CUSTOM = 'custom';

    const MODULE_STYLE_CARD = 'card';
    const MODULE_STYLE_FLAT = 'flat';

    // mc_forum_top_bar_button5
    // mc_forum_icon27
    
    // component
    const COMPONENT_TYPE_DEFAULT = 'forumlist';
    const COMPONENT_TYPE_DISCOVER = 'discover';
    const COMPONENT_TYPE_FASTTEXT = 'fasttext';
    const COMPONENT_TYPE_FASTIMAGE = 'fastimage';
    const COMPONENT_TYPE_FASTCAMERA = 'fastcamera';
    const COMPONENT_TYPE_FASTAUDIO = 'fastaudio';
    const COMPONENT_TYPE_WEATHER = 'weather';
    const COMPONENT_TYPE_SEARCH = 'search';
    const COMPONENT_TYPE_FORUMLIST = 'forumlist';
    const COMPONENT_TYPE_NEWSLIST = 'newslist';
    const COMPONENT_TYPE_TOPICLIST = 'topiclist';
    const COMPONENT_TYPE_SIGN = 'sign';
    const COMPONENT_TYPE_MESSAGELIST = 'messagelist';
    const COMPONENT_TYPE_SETTING = 'setting';
    const COMPONENT_TYPE_ABOAT = 'aboat';
    const COMPONENT_TYPE_USERINFO = 'userinfo';
    const COMPONENT_TYPE_MODULEREF = 'moduleRef';
    const COMPONENT_TYPE_WEBAPP = 'webapp';
    const COMPONENT_TYPE_LAYOUT = 'layout';
    const COMPONENT_TYPE_SURROUDING_POSTLIST = 'surroudingPostlist';
    const COMPONENT_TYPE_SURROUDING_USERLIST = 'surroudingUserlist';
    const COMPONENT_TYPE_RECOMMEND_USERLIST = 'recommendUserlist';

    const COMPONENT_ICON_STYLE_IMAGE = 'image';
    const COMPONENT_ICON_STYLE_TEXT_IMAGE = 'textImage';
    const COMPONENT_ICON_STYLE_TEXT_OVERLAP_UP = 'textOverlapUp';
    const COMPONENT_ICON_STYLE_TEXT_OVERLAP_DOWN = 'textOverlapDown';
    const COMPONENT_ICON_STYLE_CIRCLE = 'circle';
    const COMPONENT_ICON_STYLE_NEWS = 'news';
    const COMPONENT_ICON_STYLE_TEXT_OVERLAP_UP_VIDEO = 'textOverlapUp_Video';
    const COMPONENT_ICON_STYLE_TEXT_OVERLAP_DOWN_VIDEO = 'textOverlapDown_Video';

    const COMPONENT_STYLE_FLAT = 'flat';
    const COMPONENT_STYLE_CARD = 'card';
    const COMPONENT_STYLE_IMAGE = 'image';

    const COMPONENT_STYLE_LAYOUT_DEFAULT = 'layoutDefault';
    const COMPONENT_STYLE_LAYOUT_IMAGE = 'layoutImage';
    const COMPONENT_STYLE_LAYOUT_SUDOKU = 'layoutSudoku';
    const COMPONENT_STYLE_LAYOUT_SLIDER = 'layoutSlider';

    const COMPONENT_STYLE_LAYOUT_ONE_COL = 'layoutOneCol';
    const COMPONENT_STYLE_LAYOUT_ONE_COL_HIGH = 'layoutOneCol_High';
    const COMPONENT_STYLE_LAYOUT_ONE_COL_MID = 'layoutOneCol_Mid';
    const COMPONENT_STYLE_LAYOUT_ONE_COL_LOW = 'layoutOneCol_Low';
    const COMPONENT_STYLE_LAYOUT_TWO_COL = 'layoutTwoCol';
    const COMPONENT_STYLE_LAYOUT_TWO_COL_HIGH = 'layoutTwoCol_High';
    const COMPONENT_STYLE_LAYOUT_TWO_COL_MID = 'layoutTwoCol_Mid';
    const COMPONENT_STYLE_LAYOUT_TWO_COL_LOW = 'layoutTwoCol_Low';
    const COMPONENT_STYLE_LAYOUT_THREE_COL = 'layoutThreeCol';
    const COMPONENT_STYLE_LAYOUT_THREE_COL_HIGH = 'layoutThreeCol_High';
    const COMPONENT_STYLE_LAYOUT_THREE_COL_MID = 'layoutThreeCol_Mid';
    const COMPONENT_STYLE_LAYOUT_THREE_COL_LOW = 'layoutThreeCol_Low';
    const COMPONENT_STYLE_LAYOUT_FOUR_COL = 'layoutFourCol';
    const COMPONENT_STYLE_LAYOUT_FOUR_COL_HIGH = 'layoutFourCol_High';
    const COMPONENT_STYLE_LAYOUT_FOUR_COL_MID = 'layoutFourCol_Mid';
    const COMPONENT_STYLE_LAYOUT_FOUR_COL_LOW = 'layoutFourCol_Low';
    const COMPONENT_STYLE_LAYOUT_ONE_COL_TWO_ROW = 'layoutOneColTwoRow';
    const COMPONENT_STYLE_LAYOUT_ONE_COL_THREE_ROW = 'layoutOneColThreeRow';
    const COMPONENT_STYLE_LAYOUT_TWO_COL_ONE_ROW = 'layoutTwoColOneRow';
    const COMPONENT_STYLE_LAYOUT_THREE_COL_ONE_ROW = 'layoutThreeColOneRow';

    const COMPONENT_STYLE_DISCOVER_DEFAULT = 'discoverDefault';
    const COMPONENT_STYLE_DISCOVER_CUSTOM = 'discoverCustom';
    const COMPONENT_STYLE_DISCOVER_SLIDER = 'discoverSlider';

    public static function initNavigation()
    {
        return array(
            'type' => self::NAV_TYPE_BOTTOM,
            'navItemList' => array(
                self::initNavItemDiscover(),
            ),
        );
    }

    public static function initNavItem()
    {
        return array(
            'moduleId' => 0,
            'title' => '',
            'icon' => self::NAV_ITEM_ICON_1,
        );
    }

    public static function initNavItemDiscover()
    {
        return array_merge(
            self::initNavItem(),
            array(
                'moduleId' => self::MODULE_ID_DISCOVER,
                'title' => '发现',
            )
        );
    }

    public static function getNavigationInfo($isTemp=false)
    {
        $data = DbUtils::getDzDbUtils(true)->queryScalar('
            SELECT cvalue
            FROM %t
            WHERE ckey = %s
            ',
            array('appbyme_config', $isTemp ? self::NAV_KEY_TEMP : self::NAV_KEY)
        );
        return $data ? (array)unserialize(WebUtils::u($data)) : array();
    }

    public static function saveNavigationInfo($navInfo, $isTemp=false)
    {
        $key = $isTemp ? self::NAV_KEY_TEMP : self::NAV_KEY;
        $appUIDiyNavInfo = array(
            'ckey' => $key, 
            'cvalue' => WebUtils::t(serialize($navInfo)),
        );
        $config = DbUtils::getDzDbUtils(true)->queryRow('
            SELECT * 
            FROM %t 
            WHERE ckey=%s
            ',
            array('appbyme_config', $key)
        );
        if (empty($config)) {
            DbUtils::getDzDbUtils(true)->insert('appbyme_config', $appUIDiyNavInfo);
        } else {
            DbUtils::getDzDbUtils(true)->update('appbyme_config', $appUIDiyNavInfo, array('ckey' => $key));
        }
        return true;
    }

    public static function initModule()
    {
        return array(
            'id' => 0,
            'type' => self::MODULE_TYPE_FULL,
            'style' => self::MODULE_STYLE_CARD,
            'title' => '',
            'icon' => Yii::app()->getController()->rootUrl.'/images/admin/module-default.png',
            'leftTopbars' => array(
                self::initComponent(),
            ),
            'rightTopbars' => array(
                self::initComponent(),
                self::initComponent(),  
            ),
            'componentList' => array(),
            'extParams' => array('padding' => '',),
        );
    }

    public static function initDiscoverModule()
    {
        return array_merge(self::initModule(), array(
            'id' => self::MODULE_ID_DISCOVER,
            'title' => '发现',
            'componentList' => array(
                self::initComponentDiscover(),
            ),
        ));
    }
    
    public static function initFastpostModule()
    {
        return array_merge(self::initModule(), array(
            'id' => self::MODULE_ID_FASTPOST,
            'title' => '快速发表',
            'type' => self::MODULE_TYPE_FASTPOST,
            // 'icon' => Yii::app()->getController()->rootUrl.'/images/admin/module-fastpost.png',
        ));
    }

    public static function getModules($isTemp=false)
    {
        $data = DbUtils::getDzDbUtils(true)->queryScalar('
            SELECT cvalue
            FROM %t
            WHERE ckey = %s
            ',
            array('appbyme_config', $isTemp ? self::MODULE_KEY_TEMP : self::MODULE_KEY)
        );
        return $data ? (array)unserialize(WebUtils::u($data)) : array();
    }

    public static function saveModules($modules, $isTemp=false)
    {
        $key = $isTemp ? self::MODULE_KEY_TEMP : self::MODULE_KEY;
        $appUIDiyModules = array(
            'ckey' => $key, 
            'cvalue' => WebUtils::t(serialize($modules)),
        );
        $config = DbUtils::getDzDbUtils(true)->queryRow('
            SELECT * 
            FROM %t 
            WHERE ckey=%s
            ',
            array('appbyme_config', $key)
        );
        if (empty($config)) {
            DbUtils::getDzDbUtils(true)->insert('appbyme_config', $appUIDiyModules);
        } else {
            DbUtils::getDzDbUtils(true)->update('appbyme_config', $appUIDiyModules, array('ckey' => $key));
        }
        return true;
    }

    public static function deleteNavInfo($isTemp=false)
    {
        return DbUtils::getDzDbUtils(true)->delete('appbyme_config', array(
            'where' => 'ckey = %s',
            'arg' => array($isTemp ? self::NAV_KEY_TEMP : self::NAV_KEY),
        ));
    }

    public static function deleteModules($isTemp=false)
    {
        return DbUtils::getDzDbUtils(true)->delete('appbyme_config', array(
            'where' => 'ckey = %s',
            'arg' => array($isTemp ? self::MODULE_KEY_TEMP : self::MODULE_KEY),
        ));
    }

    public static function initComponent()
    {
        return array(
            'id' => '',
            'type' => self::COMPONENT_TYPE_DEFAULT,
            'style' => self::COMPONENT_STYLE_FLAT,
            'title' => '',
            'desc' => '',
            'icon' => Yii::app()->getController()->rootUrl.'/images/admin/module-default.png',
            'iconStyle' => self::COMPONENT_ICON_STYLE_IMAGE,
            'componentList' => array(),
            'extParams' => array(
                'fastpostForumIds' => array(),
            ),
        );
    }

    public static function initComponentDiscover()
    {
        return array_merge(self::initComponent(), array(
            'type' => self::COMPONENT_TYPE_DISCOVER,
            'componentList' => array(
                array_merge(self::initLayout(), array(
                    'style' => self::COMPONENT_STYLE_DISCOVER_SLIDER,
                    'componentList' => array(
                    ),
                )),
                array_merge(self::initLayout(), array(
                    'style' => self::COMPONENT_STYLE_DISCOVER_DEFAULT,
                    'componentList' => array(
                        array_merge(self::initComponent(), array(
                            'title' => '个人中心',
                            'type' => self::COMPONENT_TYPE_USERINFO,
                        )),
                        array_merge(self::initComponent(), array(
                            'title' => '周边用户',
                            'type' => self::COMPONENT_TYPE_SURROUDING_USERLIST,
                        )),
                        array_merge(self::initComponent(), array(
                            'title' => '周边帖子',
                            'type' => self::COMPONENT_TYPE_SURROUDING_POSTLIST,
                        )),
                        array_merge(self::initComponent(), array(
                            'title' => '推荐用户',
                            'type' => self::COMPONENT_TYPE_RECOMMEND_USERLIST,
                        )),
                        array_merge(self::initComponent(), array(
                            'title' => '设置',
                            'type' => self::COMPONENT_TYPE_SETTING,
                        )),
                        // array_merge(self::initComponent(), array(
                        //     'title' => '关于',
                        //     'type' => self::COMPONENT_TYPE_ABOAT,
                        // )),
                    ),
                )),
                array_merge(self::initLayout(), array(
                    'style' => self::COMPONENT_STYLE_DISCOVER_CUSTOM,
                    'componentList' => array(
                    ),
                )),
            ),
        ));
    }

    public static function initLayout()
    {
        return array_merge(self::initComponent(), array(
            'type' => self::COMPONENT_TYPE_LAYOUT,
            'style' => self::COMPONENT_STYLE_LAYOUT_DEFAULT,
        ));
    }
}
