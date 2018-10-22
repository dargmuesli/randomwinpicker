<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    function get_warning_html($success, $error)
    {
        $underconstruction = false;

        $warning_html = '
            <noscript>
                <div class="alert">
                    <p>
                        '.translate('scripts.warning.noscript').'
                    </p>
                </div>
            </noscript>';

        if ($success != null) {
            $warning_html .= '
                <div class="note">
                    <p>
                        $success
                    </p>
                </div>';
        }

        if ($underconstruction || $error) {
            $warning_html .= '
                <div class="alert">';

            if ($underconstruction) {
                $warning_html .= '
                    <p>
                        '.translate('scripts.warning.noscript').'
                    </p>';
            }

            if ($error) {
                $warning_html .= '
                    <p>
                        '.$error.'
                    </p>';
            }

            $warning_html .= '
                </div>';
        }

        $_SESSION['error'] = null;
        $_SESSION['success'] = null;

        return $warning_html;
    }
