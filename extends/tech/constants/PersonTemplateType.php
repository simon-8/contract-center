<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class PersonTemplateType
{
    const SQUARE = 'square'; //正方形印章

    const RECTANGLE = 'rectangle'; //矩形印章

    const FZKC = 'fzkc';

    const YYGXSF = 'yygxsf';

    const HYLSF = 'hylsf';

    const BORDERLESS = 'borderless';

    const HWLS = 'hwls';

    const YGYJFCS = 'ygyjfcs';

    const YGYMBXS = 'ygymbxs';

    const HWXKBORDER = 'hwxkborder';

    const HWXK = 'hwxk';

    /**
     * 个人模板类型：
     * square-正方形印章，rectangle-矩形印章，fzkc-艺术字印章，yygxsf-艺术字印章，
     * hylsf-艺术字印章，borderless-无框矩形印章，hwls-华文隶书，hwxk-华文行楷，
     * hwxkborder-华文行楷带边框，ygyjfcs-叶根友疾风草书，ygymbxs-叶根友毛笔行书
     *
     * @return array
     */
    public static function getArray()
    {
        return array(
            self::SQUARE,
            self::RECTANGLE,
            self::FZKC,
            self::YYGXSF,
            self::HYLSF,
            self::BORDERLESS,
            self::HWLS,
            self::YGYJFCS,
            self::YGYMBXS,
            self::HWXKBORDER,
            self::HWXK
        );
    }
}