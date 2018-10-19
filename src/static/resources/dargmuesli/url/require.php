<?php
    $lclPath = 'layout/extension';
    $drgPath = '/resources/dargmuesli';
    $pkgPath = '/resources/packages/yarn';
    $featureTranslations = array(
        'lcl' => array(
            'ext' => array(
                'js' => '/extension.js',
                'css' => '/extension.css',
            ),
        ),
        'drg' => array(
            'base' => array(
                'func.js' => '/base/functions.js',
                'func.mjs' => '/base/functions.min.js',
                'opt.js' => '/base/options.js',
                'stl.css' => '/base/style.css',
                'stl.mcss' => '/base/style.min.css',
            ),
            'gtm' => array(
                'mjs' => '/google-tagmanager/tagmanager.js',
                'js' => '/google-tagmanager/tagmanager.min.js',
            ),
        ),
        'pkg' => array(
            'jq' => array(
                'js' => '/jquery/jquery.js',
                'mjs' => '/jquery/jquery.min.js',
                'slm.js' => '/jquery/jquery.slim.js',
                'slm.mjs' => '/jquery/jquery.slim.min.js',
            ),
        ),
        'ext' => array(
            'recaptcha' => array(
                'de-async-defer' => 'https://www.google.com/recaptcha/api.js?hl=de',
            ),
        ),
    );

    function get_feature_translation($featureArray)
    {
        if (empty($featureArray) || !is_array($featureArray)) {
            return;
        }

        global $featureTranslations;
        global $lclPath;
        global $drgPath;
        global $pkgPath;

        $featureTranslation = null;

        foreach ($featureArray as $key => $value) {
            $featureParts = array();

            if (!is_numeric($key)) {
                $featureParts = explode('/', $key);
            } else {
                $featureParts = explode('/', $value);
            }

            if (isset($featureTranslations[$featureParts[0]][$featureParts[1]]) && array_key_exists($featureParts[2], $featureTranslations[$featureParts[0]][$featureParts[1]])) {
                $link = null;

                $featurePaths = $featureTranslations[$featureParts[0]][$featureParts[1]][$featureParts[2]];

                if (!is_array($featurePaths)) {
                    $featurePaths = array($featurePaths);
                }

                foreach ($featurePaths as $featurePath) {
                    switch ($featureParts[0]) {
                        case 'lcl':
                            $link = $lclPath.$featurePath;
                            break;
                        case 'drg':
                            $link = $drgPath.$featurePath;
                            break;
                        case 'pkg':
                            $link = $pkgPath.$featurePath;
                            break;
                        case 'ext':
                            $link = $featurePath;
                            break;
                    }

                    $tag = null;

                    if (is_type($link, 'script')) {
                        $tag = '<script src="'.$link.'"></script>';
                    } elseif (is_type($link, 'style')) {
                        $tag = '<link href="'.$link.'" rel="stylesheet">';
                    } else {
                        $tag = '<!--'.$featureParts[0].'/'.$featureParts[1].'/'.$featureParts[2].'-->';
                    }

                    if (!is_numeric($key)) {
                        $tag = preg_replace('/></', ' crossorigin="anonymous" integrity="'.$value.'"><', $tag);
                    }

                    $featureTranslation .= PHP_EOL.$tag;
                }
            } else {
                $featureTranslation .= PHP_EOL.'<!--'.$featureParts[0].'/'.$featureParts[1].'/'.$featureParts[2].'-->';
            }
        }

        return $featureTranslation;
    }

    function is_type($link, $type)
    {
        $typeArray = null;
        $link = parse_url($link, PHP_URL_PATH);

        switch ($type) {
            case 'script':
                $typeArray = array('js');
                break;
            case 'style':
                $typeArray = array('css');
                break;
        }

        if (strpos($link, '.') !== false) {
            return in_array(substr(strrchr($link, '.'), 1), $typeArray);
        } else {
            return in_array($id, $typeArray);
        }
    }
