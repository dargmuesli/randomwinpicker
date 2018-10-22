<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/recaptcha.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    last_modified(get_page_mod_time());

    $response = null;

    function verify_recaptcha($response)
    {
        $reCaptcha = get_recaptcha();
        $verification = $reCaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['HTTP_X_REAL_IP']);

        if ($verification->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    if (!empty($_POST)) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $response = verify_recaptcha($_POST['g-recaptcha-response']);
        }
    }

    $skeletonTitle = translate('pages.imprint.title');
    $skeletonDescription = 'The legal disclosure of this website according to section 5 TMG with contact, image rights, disclaimer and privacy statement';
    $skeletonFeatures = ['lcl/ext/css', 'lcl/ext/js', 'ext/recaptcha/de-async-defer'];
    $skeletonKeywords = 'images, contents, pages, information, act, tmg, accountability, links, parties, legal';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="back">
                <a class="rotate" href="../" title="Back"></a>
            </div>
            <div id="account">
                '.get_account_html($email).'
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.imprint.title').'
            </h1>
            <div id="ld">
                '.translate('pages.imprint.tmg').'
                <section id="contact">
                    <h2>
                        '.translate('pages.imprint.contact.title').'
                    </h2>';

        if ($response) {
            $skeletonContent .= '
                <address>
                    <p>
                        Jonas Thelemann
                        <br>
                        Kassel, '.translate('pages.imprint.contact.province').', Deutschland
                    </p>
                    <p>
                        E-Mail: <a href="mailto:e-mail@jonas-thelemann.de" title="e-mail@jonas-thelemann.de">e-mail@jonas-thelemann.de</a>
                    </p>
                </address>';
        } else {
            $skeletonContent .= '
                <form action="." method="post" id="adform">
                    <div data-theme="dark" data-callback="sub" class="g-recaptcha" data-sitekey="'.get_recaptcha_sitekey().'"></div>
                </form>';
        }

        $skeletonContent .= '
                    </section>
                    <section>
                        <h2>
                            '.translate('pages.imprint.sources.title').'
                        </h2>
                        <p>
                            '.translate('pages.imprint.sources.images.prefix').'
                        </p>
                        <ul>
                            <li>
                                <a href="https://commons.wikimedia.org/wiki/Main_Page?uselang='.get_language().'" target="_blank" title="Wikimedia">
                                    https://commons.wikimedia.org/
                                </a>
                                <ul>
                                    <li>
                                        <a href="https://commons.wikimedia.org/wiki/User:Tryphon?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.user').': Tryphon">
                                            Tryphon
                                        </a>
                                        /
                                        <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                            NASA/JPL-Caltech and The Hubble Heritage Team (STScI/AURA)
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="https://commons.wikimedia.org/wiki/File:Sombrero_Galaxy_in_infrared_light_%28Hubble_Space_Telescope_and_Spitzer_Space_Telescope%29.jpg?uselang='.get_language().'" target="_blank" title="Sombrero Galaxie (Original)">
                                                    Sombrero_Galaxy_in_infrared_light_(Hubble_Space_Telescope_and_Spitzer_Space_Telescope).jpg
                                                </a>
                                                &#8594;
                                                <a href="../layout/icons/sombrero.jpg" target="_blank" title="Sombrero '.translate('pages.imprint.sources.images.galaxy').' ('.translate('pages.imprint.sources.images.local').')">
                                                    sombrero.jpg
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="https://commons.wikimedia.org/wiki/User:Keraunoscopia?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.user').': Keraunoscopia">
                                            Keraunoscopia
                                        </a>
                                        /
                                        <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                            NASA/JPL-Caltech/ESA/CXC/STScI
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="https://commons.wikimedia.org/wiki/File:Center_of_the_Milky_Way_Galaxy_IV_%E2%80%93_Composite.jpg?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.milkyway').' (Original)">
                                                    Center_of_the_Milky_Way_Galaxy_IV_–_Composite.jpg
                                                </a>
                                                &#8594;
                                                <a href="../layout/icons/milkyway.jpg" target="_blank" title="'.translate('pages.imprint.sources.images.milkyway').' ('.translate('pages.imprint.sources.images.local').')">
                                                    milkyway.jpg
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="https://commons.wikimedia.org/wiki/User:Njardarlogar?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.user').': Njardarlogar">
                                            Njardarlogar
                                        </a>
                                        /
                                        <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                            NASA, ESA, and the Hubble Heritage Team (STScI/AURA)
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="https://commons.wikimedia.org/wiki/File:NGC_2818_by_the_Hubble_Space_Telescope.jpg?uselang='.get_language().'" target="_blank" title="NGC 2818 (Original)">
                                                    NGC_2818_by_the_Hubble_Space_Telescope.jpg
                                                </a>
                                                &#8594;
                                                <a href="../layout/icons/hubble.jpg" target="_blank" title="NGC 2818 ('.translate('pages.imprint.sources.images.local').')">
                                                    hubble.jpg
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="https://commons.wikimedia.org/wiki/User:Flickr_upload_bot?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.user').': Flickr_upload_bot">
                                            Flickr_upload_bot
                                        </a>
                                        /
                                        <a href="https://www.nasa.gov/centers/goddard/home/index.html" target="_blank" title="flickr.com">
                                            NASA Goddard Space Flight Center
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="https://commons.wikimedia.org/wiki/File:Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg?uselang='.get_language().'" target="_blank" title="'.translate('pages.imprint.sources.images.sun-eruption').' (Original)">
                                                    800px-Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg
                                                </a>
                                                &#8594;
                                                <a href="../layout/icons/eruption.jpg" target="_blank" title="'.translate('pages.imprint.sources.images.sun-eruption').' ('.translate('pages.imprint.sources.images.local').')">
                                                    eruption.jpg
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="https://www.pexels.com/" target="_blank" title="Pexels">
                                    https://www.pexels.com/
                                </a>
                                <ul>
                                    <li>
                                        <a href="https://unsplash.com/ahmadreza_sajadi" target="_blank" title="'.translate('pages.imprint.sources.images.user').': Ahmadreza Sajadi">
                                            Ahmadreza Sajadi
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="https://www.pexels.com/photo/sky-night-space-galaxy-6547/" target="_blank" title="'.translate('pages.imprint.sources.images.galaxy').' (Original)">
                                                    sky-night-space-galaxy.jpeg
                                                </a>
                                                &#8594;
                                                <a href="../layout/icons/galaxy.jpg" target="_blank" title="'.translate('pages.imprint.sources.images.galaxy').' ('.translate('pages.imprint.sources.images.local').')">
                                                    galaxy.png
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </section>
                    <article>
                        <h2>
                            '.translate('pages.imprint.disclaimer.title').'
                        </h2>
                        <section>
                            <h3>
                                '.translate('pages.imprint.disclaimer.content.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.disclaimer.content.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.disclaimer.links.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.disclaimer.links.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.disclaimer.copyright.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.disclaimer.copyright.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.disclaimer.tou.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.disclaimer.tou.content').'
                            </p>
                        </section>
                    </article>
                    <article>
                        <h2>
                            '.translate('pages.imprint.privacy.title').'
                        </h2>
                        <!--<section>
                            <h3>
                                '.translate('pages.imprint.privacy.general.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.general.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.privacy.inventory.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.inventory.content').'
                            </p>
                        </section>-->
                        <section>
                            <h3>
                                '.translate('pages.imprint.privacy.analytics.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.analytics.content').'
                            </p>
                        </section>
                        <section id="cookies">
                            <h3>
                                '.translate('pages.imprint.privacy.cookies.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.cookies.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.privacy.logs.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.logs.content').'
                            </p>
                        </section>
                        <section>
                            <h3>
                                '.translate('pages.imprint.privacy.disclosure.title').'
                            </h3>
                            <p>
                                '.translate('pages.imprint.privacy.disclosure.content').'
                            </p>
                        </section>
                    </article>
                </div>
            </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
