<?php
/**
 * footer template
 *
 * @package MeineLeberUndIch
 */
?>
    <footer class="text-white body-font mt-10">
        <div class="flex flex-col" style="background:#006685 !important;">
            <div class="container mx-auto py-6 px-5 flex flex-wrap flex-col lg:flex-row">
                <div>
                    <a href="<?php echo get_site_url(); ?>" target="_self">
                        <img src="<?php echo get_template_directory_uri(); ?>/dist/images/logo-white.png"
                             class="h-16 mt-4 me-6">
                    </a>
                </div>
                <div class="flex lg:flex-1 flex-col lg:ms-5">
                    <div class="w-5/6 md:w-full flex flex-wrap lg:text-base xl:text-lg justify-start lg:justify-between mt-5">
                        <ul class="flex flex-wrap flex-col lg:flex-row justify-between"
                            id="footer-menu"><?php
                            wp_nav_menu(
                                [
                                    'container'      => '',
                                    'items_wrap'     => '%3$s',
                                    'theme_location' => 'footer-menu',
                                    'menu_class'     => 'me-3 hover:font-bold',
                                ]
                            );
                            ?>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy">
                                <a style="cursor: pointer;" class="ot-sdk-show-settings">Cookie-Einstellungen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container mx-auto px-5 flex flex-wrap flex-col lg:flex-row">
                <div class="flex flex-1 lg:flex-row">
                    <p style="margin-top: 0px;margin-bottom: 0px;">
                        © 2021 Gilead Sciences GmbH. All rights reserved.
                    </p>
                </div>
            </div>
            <div style="background:#006685 !important;display: block;"
                 class="container mx-auto py-3 px-5 flex flex-wrap justify-between flex-col sm:flex-row">
                <div class="flex-1">
                    <strong class="font-bold text-lg mb-0">Meldung von Nebenwirkungen</strong>
                    <p>Wir bitten Sie, jeden Verdachtsfall auf Nebenwirkungen über das nationale Meldesystem anzuzeigen:
                        <br>
                        Bundesinstitut für Arzneimittel und Medizinprodukte, Abt. Pharmakovigilanz,
                        Kurt-Georg-Kiesinger-Allee 3, D-53175 Bonn, Website: <a target="_blank" class="underline"
                                                                                href="http://www.bfarm.de">http://www.bfarm.de</a>
                    </p>
                    <p>
                        Bzw. falls zutreffend: Bundesinstitut für Impfstoffe und biomedizinische Arzneimittel,
                        Paul-Ehrlich-Institut, Paul-Ehrlich-Str. 51 – 59, 63225 Langen, Tel: +49 6103 77 0, Fax: +49
                        6103 77 1234, Website: <a class="underline" href="https://www.pei.de">www.pei.de</a>
                    </p>
                    <p>Sie können Verdachtsfälle von Nebenwirkungen zu Gilead Produkten auch direkt an Gilead Sciences
                        GmbH, Abteilung Arzneimittelsicherheit melden: <br>
                        Per E-Mail an <a class="underline" href="mailto:drugsafetygermany@gilead.com">drugsafetygermany@gilead.com</a>
                        oder per Fax unter +49 (0) 89 899890 96
                    </p>
                </div>
            </div>
        </div>
    </footer>
<?php
wp_footer();
?>
    </body><?php
