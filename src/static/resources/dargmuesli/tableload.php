<?php
    function get_init_table_html($content, $type)
    {
        $initTableHtml = '';

        if (isset($content)) {
            for ($i = 0; $i < count($content); $i++) {
                $initTableHtml = '
                    <tr id="tr' . ($i + 1) . '">
                        <td class="data">
                            '.$content[$i]['column0'].'
                        </td>
                        <td class="' . $content[$i]['column1classes'] . '">
                            '.$content[$i]['column1'].'
                        </td>
                        <td class="remove">
                            <button class="link" title="Remove" id="rR(' . ($i + 1) . ', 2, \'' . $type . '\')">
                                X
                            </button>
                        </td>
                        <td class="up">';

                if ($i > 0) {
                    $initTableHtml .= '
                        <button class="link" title="Up" id="mRU(' . ($i + 1) . ', 2, \'' . $type . '\')">
                            &#x25B2;
                        </button>';
                }

                $initTableHtml .= '
                    </td>
                    <td class="down">';

                if ($i != count($content) - 1) {
                    $initTableHtml .= '
                        <button class="link" title="Down" id="mRD(' . ($i + 1) . ', 2, \'' . $type . '\')">
                            &#x25BC;
                        </button>';
                }

                $initTableHtml .= '
                        </td>
                    </tr>';
            }
        } else {
            $initTableHtml = '
                <tr id="tr0">
                    <td class="data">
                        ---
                    </td>
                    <td class="data">
                        ---
                    </td>
                    <td>
                        ---
                    </td>
                    <td>
                        ---
                    </td>
                    <td>
                        ---
                    </td>
                </tr>';
        }

        return $initTableHtml;
    }
