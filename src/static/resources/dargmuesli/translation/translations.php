<?php
    $translations = [
        'scripts' => [
            'account' => [
                'guest' => [
                    'de' => 'Gast',
                    'en' => 'Guest'
                ],
                'profile' => [
                    'de' => 'Profil',
                    'en' => 'Profile'
                ],
                'login' => [
                    'de' => 'Anmelden',
                    'en' => 'Sign in/up'
                ],
                'logout' => [
                    'de' => 'Abmelden',
                    'en' => 'Logout'
                ],
                'member' => [
                    'de' => 'Mitglied',
                    'en' => 'Member'
                ]
            ],
            'draw' => [
                'error' => [
                    'de' => 'Zu viele Gewinne für zu wenig Teilnehmer! Wer soll das alles gewinnen?!',
                    'en' => 'Too many items for too few participants! Who shall win all that?!'
                ]
            ],
            'logreg' => [
                'in' => [
                    'captcha' => [
                        'error' => [
                            'de' => 'Captcha falsch!',
                            'en' => 'Captcha incorrect!'
                        ]
                    ],
                    'email' => [
                        'error' => [
                            'de' => 'E-Mail konnte nicht versendet werden!',
                            'en' => 'Email could not be send!'
                        ],
                        'success' => [
                            'de' => 'Erfolgreich registriert.',
                            'en' => 'Registered successfully.'
                        ],
                        'success-error' => [
                            'de' => 'Du musst noch deine E-Mail-Adresse bestätigen!',
                            'en' => 'You still need to validate your email address!'
                        ]
                    ],
                    'incomplete' => [
                        'error' => [
                            'de' => 'Bestätigung unvollständig! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=resend&email=%email" title="Bestätigungsmail neu versenden">E-Mail neu versenden</a> oder <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Diese Anfrage löschen">diese Anfrage löschen</a>.',
                            'en' => 'Validation incomplete! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=resend&email=%email" title="Resend the validation email">Resend the email</a> or <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Delete this request">delete this request</a>.'
                        ]
                    ],
                    'password' => [
                        'error' => [
                            'de' => 'Falsches Passwort!',
                            'en' => 'Wrong Password!'
                        ]
                    ],
                    'success' => [
                        'de' => 'Erfolgreich angemeldet.',
                        'en' => 'Login successful.'
                    ]
                ],
                'out' => [
                    'success' => [
                        'de' => 'Erfolgreich abgemeldet.',
                        'en' => 'Logout successful.'
                    ]
                ]
            ],
            'recover' => [
                'activation' => [
                    'error' => [
                        'de' => 'Account wurde noch nicht aktiviert! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Diese Anfrage löschen">Diese Anfrage löschen</a>.',
                        'en' => 'Account was not activated yet! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Delete this request">delete this request</a>.'
                    ],
                ],
                'email' => [
                    'error' => [
                        'de' => 'E-Mail konnte nicht versendet werden!',
                        'en' => 'Email could not be sent!'
                    ],
                    'success' => [
                        'de' => 'E-Mail wurde erfolgreich versendet.',
                        'en' => 'Email sent successfully.'
                    ]
                ],
                'existence' => [
                    'error' => [
                        'de' => 'Benutzer existiert nicht!',
                        'en' => 'User does not exist!'
                    ]
                ],
                'reset' => [
                    'error' => [
                        'de' => 'Passwort konnte nicht geändert werden!',
                        'en' => 'Password could not be changed!'
                    ],
                    'success' => [
                        'de' => 'Passwort erfolgreich geändert.',
                        'en' => 'Password changed successfully.'
                    ]
                ]
            ],
            'suggest' => [
                'bug' => [
                    'de' => 'Fehlermeldung',
                    'en' => 'Bug%20Report'
                ],
                'feature' => [
                    'de' => 'Neuer%20Vorschlag%20für%20Gewinne',
                    'en' => 'New%20Item%20Suggestion'
                ]
            ],
            'validation' => [
                'delete' => [
                    'success' => [
                        'de' => 'Anfrage erfolgreich gelöscht.',
                        'en' => 'Request successfully deleted.'
                    ]
                ],
                'resend' => [
                    'error' => [
                        'de' => 'E-Mail konnte nicht versendet werden!',
                        'en' => 'Email could not be sent!'
                    ],
                    'success' => [
                        'de' => 'E-Mail wurde erfolgreich versendet.',
                        'en' => 'Email sent successfully.'
                    ]
                ],
                'validate' => [
                    'error' => [
                        'general' => [
                            'de' => 'Bestätigung fehlgeschlagen! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=resend&email=%email" title="Bestätigungsmail neu versenden">E-Mail neu versenden</a> oder <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Diese Anfrage löschen">diese Anfrage löschen</a>.',
                            'en' => 'Validation went wrong! <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=resend&email=%email" title="Resend the validation email">Resend the email</a> or <a href="'.getenv('BASE_URL').'/resources/dargmuesli/validation.php?task=delete&email=%email" title="Delete this request">delete this request</a>.'
                        ],
                        'inexistent' => [
                            'de' => 'Bestätigung fehlgeschlagen! Benutzer existiert nicht.',
                            'en' => 'Validation went wrong! User does not exist.'
                        ]
                    ],
                    'success' => [
                        'de' => 'Bestätigung erfolgreich.',
                        'en' => 'Validation successful.'
                    ]
                ]
            ],
            'warning' => [
                'construction' => [
                    'de' => 'Manche Funktionen dieser Website funktionieren momentan nicht, aber es arbeitet jemand daran!',
                    'en' => 'Some functionality of this website currently do not work, but somebody is working on it!'
                ],
                'noscript' => [
                    'de' => 'Um alle Funktionen dieser Website benutzen zu können, muss JAVASCRIPT aktiviert sein.',
                    'en' => 'To be able to use all features of this website JAVASCRIPT needs to be enabled.'
                ]
            ]
        ],
        'pages' => [
            'accounts' => [
                'description' => [
                    'details' => [
                        'de' => 'Ich empfehle Passwort-Manager wie <a href="http://keepass.info/" title="KeePass Password-Manager" rel="noopener" target="_blank">KeePass</a>!
                                <br>
                                Passwörter werden als <a href="https://de.wikipedia.org/wiki/Salt_%28Kryptologie%29" title="Salt (Kryptologie)" rel="noopener" target="_blank">gesalzener</a> <a href="https://de.wikipedia.org/wiki/SHA-2" title="SHA-2" rel="noopener" target="_blank">SHA256-Hash</a> gespeichert.
                                <br>
                                Wenn du "angemeldet bleiben" willst, werden deine Anmeldeinformationen in <a href="https://de.wikipedia.org/wiki/HTTP-Cookie" title="HTTP-Cookie">HTTP-Cookies</a> gespeichert. Schaue in das <a href="../imprint/#cookies" title="Impressum">Impressum</a> für weitere Erklärungen.',
                        'en' => 'I recommend password manager like <a href="http://keepass.info/" title="KeePass Password-Manager" rel="noopener" target="_blank">KeePass</a>!
                                <br>
                                Passwords are stored as <a href="https://en.wikipedia.org/wiki/Salt_%28cryptography%29" title="Salt (cryptography)" rel="noopener" target="_blank">salted</a> <a href="https://en.wikipedia.org/wiki/SHA-2" title="SHA-2" rel="noopener" target="_blank">SHA256-Hash</a>.
                                <br>
                                If you want to "stay logged in", your login information will be stored in <a href="https://en.wikipedia.org/wiki/HTTP_cookie" title="HTTP cookie">HTTP cookies</a>. Check the <a href="../imprint/#cookies" title="Imprint">imprint</a> for further explanation.'
                    ],
                    'short' => [
                        'de' => 'Um auf alle Funktionen dieser Website zugreifen zu können, musst du dich anmelden oder dich registrieren!',
                        'en' => 'To access all features on this website you need to login or create an account!'
                    ]
                ],
                'input' => [
                    'checkbox' => [
                        'de' => 'Angemeldet bleiben',
                        'en' => 'Stay logged in'
                    ],
                    'email' => [
                        'placeholder' => [
                            'de' => 'E-Mail-Adresse',
                            'en' => 'e-mail address'
                        ],
                        'title' => [
                            'de' => 'Ein valides E-Mail-Format',
                            'en' => 'A valid email format.'
                        ]
                    ],
                    'password' => [
                        'placeholder' => [
                            'de' => 'Passwort',
                            'en' => 'passwort'
                        ],
                        'title' => [
                            'de' => 'Mindestens 6 Zeichen: Zahlen sowie große und kleine Buchstaben.',
                            'en' => 'At least 6 characters: numbers and small & large letters.'
                        ]
                    ]
                ],
                'link' => [
                    'recovery' => [
                        'de' => 'Password verloren?',
                        'en' => 'Password lost?'
                    ],
                    'skip' => [
                        'de' => 'Überspringen',
                        'en' => 'Skip'
                    ]
                ],
                'profile' => [
                    'error' => [
                        'de' => 'Du bist nicht angemeldet!',
                        'en' => 'You are not logged in!'
                    ],
                    'information' => [
                        'description' => [
                            'de' => 'Wie dein Passwort gespeichert wird',
                            'en' => 'How your password is saved'
                        ],
                        'title' => [
                            'de' => 'Information',
                            'en' => 'Information'
                        ]
                    ],
                    'settings' => [
                        'encoding' => [
                            'description' => [
                                'de' => 'Falls komische Zeichen (&#xFFFD;) beim Hochladen einer .csv-Datei auftauchen, hilft meist eine andere Codierung.',
                                'en' => 'If weird characters &#xFFFD; are showing up when you use the csv file upload, try a different encoding.'
                            ],
                            'title' => [
                                'de' => 'Codierung',
                                'en' => 'Encoding'
                            ]
                        ],
                        'prices' => [
                            'description' => [
                                'de' => 'Möchtest du, dass ein Preisstempel auf allen gezogenen Gewinnen angezeigt wird?',
                                'en' => 'Do you want a price stamp displayed on all items when they are drawn?'
                            ],
                            'no' => [
                                'de' => 'Nein',
                                'en' => 'No'
                            ],
                            'title' => [
                                'de' => 'Preise',
                                'en' => 'Prices'
                            ],
                            'yes' => [
                                'de' => 'Ja',
                                'en' => 'Yes'
                            ]
                        ],
                        'privacy' => [
                            'description' => [
                                'de' => 'Welcher Name soll in der oberen rechten Ecke der Website angezeigt werden?
                                        <br>
                                        Zum Beispiel möchten die meisten YouTuber nicht, dass ihre E-Mail-Adresse dort und dann in ihren Videos zu sehen ist.',
                                'en' => 'Which name do you want to display on the website\'s upper right corner?
                                        <br>
                                        For example, as a YouTuber you may want to show something else than your private e-mail address in your videos...'
                            ],
                            'input' => [
                                'email' => [
                                    'de' => 'E-Mail-Adresse',
                                    'en' => 'E-mail address'
                                ],
                                'member' => [
                                    'de' => 'Mitglied',
                                    'en' => 'Member'
                                ]
                            ],
                            'title' => [
                                'de' => 'Privatsphäre',
                                'en' => 'Privacy'
                            ]
                        ],
                        'storage' => [
                            'description' => [
                                'de' => 'Du kannst auswählen, wie lange deine Daten gespeichert werden sollen.
                                        <br>
                                        Sie für eine kurze Zeit zu speichern bedeutet, dass die Daten beim Schließen des Browsers verloren gehen.
                                        <br>
                                        Um die Daten länger zu behalten, können <a href="../imprint.php#cookies" title="Imprint">Cookies</a> als Speichermethode benutzt werden. Solange du diese nicht gelöscht werden, kann das eine sehr lange Zeit sein.',
                                'en' => 'You can choose how long you want your data to be saved.
                                        <br>
                                        Storing it for a short time means that as soon as you close your browser the data will be lost.
                                        <br>
                                        To keep the data longer, <a href="../imprint.php#cookies" title="Imprint">cookies</a> are used as saving method. If you do not delete them this will be a long time.'
                            ],
                            'input' => [
                                'session' => [
                                    'de' => 'Sitzung',
                                    'en' => 'Session'
                                ]
                            ],
                            'title' => [
                                'de' => 'Speichern der Daten',
                                'en' => 'Storage of data'
                            ]
                        ],
                        'title' => [
                            'de' => 'Einstellungen',
                            'en' => 'Settings'
                        ],
                        'view' => [
                            'description' => [
                                'de' => 'Möchtest du dir auf jeder Seite die Erklärungen, nur die Steuerelemente oder nur die Daten anzeigen lassen?
                                        <br>
                                        Erfahrene Benutzer können die Erklärungen ausstellen, aber die Steuerelemente sichtbar lassen, um trotzdem Gewinnspiele erstellen zu können.
                                        <br>
                                        YouTuber können nach dem Erstellen eines Gewinnspiels alles abstellen, um eine aufgeräumte Oberfläche für ihre Videos zu erhalten.',
                                'en' => 'Do you want to see the instructions, just the controls or only your data?
                                        <br>
                                        As a pro you might want to turn off the instructions, but keep the controls to be still able to set up your raffles.
                                        <br>
                                        YouTubers can turn off everything after the raffle is set up to get a clean look & feel for their videos.'
                            ],
                            'input' => [
                                'controls' => [
                                    'de' => 'Steuerelemente',
                                    'en' => 'Controls'
                                ],
                                'explanations' => [
                                    'de' => 'Erklärungen',
                                    'en' => 'Instructions'
                                ]
                            ],
                            'title' => [
                                'de' => 'Ansicht',
                                'en' => 'View'
                            ]
                        ],
                        'youtube' => [
                            'description' => [
                                'de' => 'Hast du ein YouTube-Konto? Zeige mir das: Ich bin sehr daran interessiert, zu sehen, dass meine Website genutzt wird!',
                                'en' => 'Do you have a YouTube account? Tell me about it: I\'m very interested in seeing my website used!'
                            ]
                        ]
                    ],
                    'title' => [
                        'head' => [
                            'de' => 'Profil',
                            'en' => 'Profile'
                        ]
                    ]
                ],
                'recovery' => [
                    'description' => [
                        'de' => 'Wenn du dein Passwort verloren haben solltest, kannst du unten einfach deine E-Mail-Adresse eingeben und dir wird ein Link zum Zurücksetzen zugeschickt.',
                        'en' => 'If you lost your password, enter your e-mail address and a reset link will be sent to it.'
                    ],
                    'input' => [
                        'email' => [
                            'placeholder' => [
                                'de' => 'E-Mail-Adresse',
                                'en' => 'e-mail address'
                            ],
                            'title' => [
                                'de' => 'Ein valides E-Mail-Format',
                                'en' => 'A valid email format.'
                            ]
                        ],
                        'send' => [
                            'de' => 'Senden',
                            'en' => 'Send'
                        ]
                    ],
                    'title' => [
                        'head' => [
                            'de' => 'Passwort-Wiederherstellung',
                            'en' => 'Password recovery'
                        ]
                    ]
                ],
                'reset' => [
                    'description' => [
                        'de' => 'Gib ein neues Passwort ein, um Zugang zu deinem Konto zurückzuerlangen.',
                        'en' => 'Enter your new password to regain access to your account.'
                    ],
                    'input' => [
                        'change' => [
                            'de' => 'Ändern',
                            'en' => 'Change'
                        ],
                        'password' => [
                            'placeholder' => [
                                'de' => 'Passwort',
                                'en' => 'password'
                            ],
                            'title' => [
                                'de' => 'Mindestens 6 Zeichen: Zahlen sowie große und kleine Buchstaben.',
                                'en' => 'At least 6 characters: numbers and small & large letters.'
                            ]
                        ]
                    ],
                    'title' => [
                        'head' => [
                            'de' => 'Passwort ändern',
                            'en' => 'Change Password'
                        ]
                    ]
                ],
                'title' => [
                    'head' => [
                        'de' => 'Anmelden',
                        'en' => 'Sign in / up'
                    ]
                ]
            ],
            'error' => [
                'content' => [
                    'de' => 'Schau was du angerichtet hast! Das ist eine Sonneneruption...',
                    'en' => 'Look what you\'ve done! That is a sun eruption...'
                ],
                'title' => [
                    'head' => [
                        'de' => 'Fehler',
                        'en' => 'Error'
                    ]
                ]
            ],
            'draw' => [
                'button' => [
                    'de' => 'Los!',
                    'en' => 'Go!'
                ],
                'next' => [
                    'de' => 'Zeige den nächsten Gewinner!',
                    'en' => 'Reveal the next winner!'
                ],
                'title' => [
                    'head' => [
                        'de' => 'Ziehung',
                        'en' => 'Draw'
                    ]
                ]
            ],
            'general' => [
                'footer' => [
                    'imprint' => [
                        'de' => 'Impressum',
                        'en' => 'Imprint'
                    ],
                    'bug-report' => [
                        'de' => 'Fehlerbericht',
                        'en' => 'Bug Report'
                    ]
                ]
            ],
            'imprint' => [
                'contact' => [
                    'province' => [
                        'de' => 'Hessen',
                        'en' => 'Hesse'
                    ],
                    'title' => [
                        'de' => 'Kontakt',
                        'en' => 'Contact'
                    ]
                ],
                'disclaimer' => [
                    'content' => [
                        'content' => [
                            'de' => 'Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.',
                            'en' => 'The contents of our pages have been created with the utmost care. However, we cannot guarantee the contents\' accuracy, completeness or topicality. According to statutory provisions, we are furthermore responsible for our own content on these web pages. In this context, please note that we are accordingly not obliged to monitor merely the transmitted or saved information of third parties, or investigate circumstances pointing to illegal activity. Our obligations to remove or block the use of information under generally applicable laws remain unaffected by this as per §§ 8 to 10 of the Telemedia Act (TMG).'
                        ],
                        'title' => [
                            'de' => 'Haftung für Inhalte',
                            'en' => 'Accountability for content'
                        ]
                    ],
                    'copyright' => [
                        'content' => [
                            'de' => 'Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.',
                            'en' => 'Our web pages and their contents are subject to German copyright law. Unless expressly permitted by law (§ 44a et seq. of the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection on our web pages requires the prior consent of the respective owner of the rights. Individual reproductions of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. Unauthorized utilization of copyrighted works is punishable (§ 106 of the copyright law).'
                        ],
                        'title' => [
                            'de' => 'Urheberrecht',
                            'en' => 'Copyright'
                        ]
                    ],
                    'links' => [
                        'content' => [
                            'de' => 'Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.',
                            'en' => 'Responsibility for the content of external links (to web pages of third parties) lies solely with the operators of the linked pages. No violations were evident to us at the time of linking. Should any legal infringement become known to us, we will remove the respective link immediately.'
                        ],
                        'title' => [
                            'de' => 'Haftung für Links',
                            'en' => 'Accountability for links'
                        ]
                    ],
                    'title' => [
                        'de' => 'Haftungsausschluss',
                        'en' => 'Disclaimer'
                    ],
                    'tou' => [
                        'content' => [
                            'de' => 'Soweit besondere Bedingungen für einzelne Nutzungen dieser Website von den anderen Punkten abweichen, wird an entsprechender Stelle ausdrücklich darauf hingewiesen. In diesem Falle gelten im jeweiligen Einzelfall die besonderen Nutzungsbedingungen.',
                            'en' => 'This disclaimer is to be regarded as part of the internet publication which you were referred from. If sections or individual formulations of this text are not legal or correct, the content or validity of the other parts remain uninfluenced by this fact.'
                        ],
                        'title' => [
                            'de' => 'Besondere Nutzungsbedingungen',
                            'en' => 'Special terms of use'
                        ]
                    ]
                ],
                'privacy' => [
                    'analytics' => [
                        'content' => [
                            'de' => 'Diese Website nutzt Funktionen des  Webanalysedienstes Google Analytics. Anbieter ist die Google Inc. 1600 Amphitheatre Parkway Mountain View, CA 94043, USA. Google Analytics verwendet sog. "Cookies". Das sind Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.
                                    <br>
                                    Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum zuvor gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt.
                                    <br>
                                    Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und installieren: https://tools.google.com/dlpage/gaoptout?hl=de',
                            'en' => 'This website uses Google Analytics, a web analytics service provided by Google, Inc. (Google). Google Analytics uses cookies, which are text files placed on your computer, to help the website analyze how users use the site. The information generated by the cookie about your use of the website (including your IP address) will be transmitted to and stored by Google on servers in the United States . Google will use this information for the purpose of evaluating your use of the website, compiling reports on website activity for website operators and providing other services relating to website activity and internet usage. Google may also transfer this information to third parties where required to do so by law, or where such third parties process the information on Google\'s behalf. Google will not associate your IP address with any other data held by Google. You may refuse the use of cookies by selecting the appropriate settings on your browser, however please note that if you do this you may not be able to use the full functionality of this website. By using this website, you consent to the processing of data about you by Google in the manner and for the purposes set out above.'
                        ],
                        'title' => [
                            'de' => 'Datenschutzerklärung für die Nutzung von Google Analytics',
                            'en' => 'Web analysis with Google Analytics'
                        ]
                    ],
                    'cookies' => [
                        'content' => [
                            'de' => 'Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert.
                                    <br>
                                    Die meisten der von uns verwendeten Cookies sind so genannte „Session-Cookies“. Sie werden nach Ende Ihres Besuchs automatisch gelöscht. Andere Cookies bleiben auf Ihrem Endgerät gespeichert, bis Sie diese löschen. Diese Cookies ermöglichen es uns, Ihren Browser beim nächsten Besuch wiederzuerkennen.
                                    <br>
                                    Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website eingeschränkt sein.',
                            'en' => 'To optimize our web presence, we use cookies. These are small text files stored in your computer\'s main memory. These cookies are deleted after you close the browser. Other cookies remain on your computer (long-term cookies) and permit its recognition on your next visit. This allows us to improve your access to our site.
                                    <br>
                                    You can prevent storage of cookies by choosing a "disable cookies" option in your browser settings. But this can limit the functionality of our Internet offers as a result.'
                        ],
                        'title' => [
                            'de' => 'Cookies',
                            'en' => 'Information about cookies'
                        ]
                    ],
                    'disclosure' => [
                        'content' => [
                            'de' => 'Sie haben jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung sowie ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden.',
                            'en' => 'According to the Federal Data Protection Act, you have a right to free-of-charge information about your stored data, and possibly entitlement to correction, blocking or deletion of such data. Inquiries can be directed to the e-mail address mentioned above.'
                        ],
                        'title' => [
                            'de' => 'Auskunft, Löschung, Sperrung',
                            'en' => 'Disclosure'
                        ]
                    ],
                    'general' => [
                        'content' => [
                            'de' => 'Your personal data (e.g. title, name, house address, e-mail address, phone number, bank details, credit card number) are processed by us only in accordance with the provisions of German data privacy laws. The following provisions describe the type, scope and purpose of collecting, processing and utilizing personal data. This data privacy policy applies only to our web pages. If links on our pages route you to other pages, please inquire there about how your data are handled in such cases.',
                            'en' => 'Your personal data (e.g. title, name, house address, e-mail address, phone number, bank details, credit card number) are processed by us only in accordance with the provisions of German data privacy laws. The following provisions describe the type, scope and purpose of collecting, processing and utilizing personal data. This data privacy policy applies only to our web pages. If links on our pages route you to other pages, please inquire there about how your data are handled in such cases.'
                        ],
                        'title' => [
                            'de' => 'General',
                            'en' => 'General'
                        ]
                    ],
                    'inventory' => [
                        'content' => [
                            'de' => 'Your personal data, insofar as these are necessary for this contractual relationship (inventory data) in terms of its establishment, organization of content and modifications, are used exclusively for fulfilling the contract. For goods to be delivered, for instance, your name and address must be relayed to the supplier of the goods.
                                    <br>
                                    Without your explicit consent or a legal basis, your personal data are not passed on to third parties outside the scope of fulfilling this contract. After completion of the contract, your data are blocked against further use. After expiry of deadlines as per tax-related and commercial regulations, these data are deleted unless you have expressly consented to their further use.',
                            'en' => 'Your personal data, insofar as these are necessary for this contractual relationship (inventory data) in terms of its establishment, organization of content and modifications, are used exclusively for fulfilling the contract. For goods to be delivered, for instance, your name and address must be relayed to the supplier of the goods.
                                    <br>
                                    Without your explicit consent or a legal basis, your personal data are not passed on to third parties outside the scope of fulfilling this contract. After completion of the contract, your data are blocked against further use. After expiry of deadlines as per tax-related and commercial regulations, these data are deleted unless you have expressly consented to their further use.'
                        ],
                        'title' => [
                            'de' => 'Inventory data',
                            'en' => 'Inventory data'
                        ]
                    ],
                    'logs' => [
                        'content' => [
                            'de' => 'Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind: Browsertyp/ Browserversion, verwendetes Betriebssystem, Referrer URL, Hostname des zugreifenden Rechners und Uhrzeit der Serveranfrage. Diese Daten sind nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.',
                            'en' => 'Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind: Browsertyp/ Browserversion, verwendetes Betriebssystem, Referrer URL, Hostname des zugreifenden Rechners und Uhrzeit der Serveranfrage. Diese Daten sind nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.'
                        ],
                        'title' => [
                            'de' => 'Server-Logdateien',
                            'en' => 'Server Log Files'
                        ]
                    ],
                    'title' => [
                        'de' => 'Datenschutzerklärung',
                        'en' => 'Privacy Statement'
                    ],
                ],
                'sources' => [
                    'images' => [
                        'galaxy' => [
                            'de' => 'Galaxie',
                            'en' => 'Galaxy'
                        ],
                        'local' => [
                            'de' => 'Lokal',
                            'en' => 'Local'
                        ],
                        'milkyway' => [
                            'de' => 'Milchstraße',
                            'en' => 'Milky Way'
                        ],
                        'prefix' => [
                            'de' => 'Alle Autoren, Originalbilder und ihre (von Jonas Thelemann) bearbeitete Version.',
                            'en' => 'All authors, original images and their edited version (by Jonas Thelemann).'
                        ],
                        'sun-eruption' => [
                            'de' => 'Sonneneruption',
                            'en' => 'Sun Eruption'
                        ],
                        'user' => [
                            'de' => 'Benutzer',
                            'en' => 'User'
                        ]
                    ],
                    'title' => [
                        'de' => 'Quellenangaben für die verwendeten Bilder und Grafiken:',
                        'en' => 'Indication of source for images and graphics:'
                    ]
                ],
                'title' => [
                    'de' => 'Impressum',
                    'en' => 'Legal Disclosure'
                ],
                'tmg' => [
                    'de' => 'Angaben gemäß § 5 TMG.',
                    'en' => 'Information in accordance with section 5 TMG.'
                ]
            ],
            'items' => [
                'condition' => [
                    'bs' => [
                        'de' => 'Kampfspuren',
                        'en' => 'Battle-Scarred'
                    ],
                    'fn' => [
                        'de' => 'Fabrikneu',
                        'en' => 'Factory New'
                    ],
                    'ft' => [
                        'de' => 'Einsatzerprobt',
                        'en' => 'Field-Tested'
                    ],
                    'mw' => [
                        'de' => 'Minimale Gebrauchsspuren',
                        'en' => 'Minimal Wear'
                    ],
                    'title' => [
                        'de' => 'Zustand',
                        'en' => 'Condition'
                    ],
                    'ww' => [
                        'de' => 'Abgenutzt',
                        'en' => 'Well-Worn'
                    ]
                ],
                'form' => [
                    'add' => [
                        'de' => 'Hinzufügen',
                        'en' => 'Add'
                    ],
                    'reset' => [
                        'de' => 'Zurücksetzen',
                        'en' => 'Reset'
                    ],
                ],
                'improvements' => [
                    'button' => [
                        'de' => 'Schlage neue Gewinne &amp; Kategorien vor',
                        'en' => 'Suggest new items &amp; categories'
                    ],
                    'title' => [
                        'de' => 'Verbesserungen',
                        'en' => 'Improvements'
                    ]
                ],
                'instructions' => [
                    'categories' => [
                        'configure' => [
                            'de' => 'Konfiguriere unten die Gewinnklassen.',
                            'en' => 'Configure the prize classes below.'
                        ],
                        'items' => [
                            'de' => 'Du kannst so viele Gewinne hinzufügen, wie du willst.
                                    <br>
                                    Um einen Gegenstand zu entfernen, klicke doppelt auf ihn.',
                            'en' => 'You can add as many items as you want.
                                    <br>
                                    To remove an item, double click it.'
                        ],
                        'title' => [
                            'de' => 'Kategorien erstellen',
                            'en' => 'Create categories'
                        ]
                    ],
                    'items' => [
                        'class' => [
                            'de' => 'Gib die Gewinne für die jeweilige Gewinnklasse an.',
                            'en' => 'Specify the items that can be won by each win class.'
                        ],
                        'select' => [
                            'de' => 'Klicke auf die entsprechende Tabellenzelle auf der linken Seite, um sie auszuwählen.
                                    <br>
                                    Dann wähle auf der rechten Seite die Gewinne und Eigenschaften aus.',
                            'en' => 'Click on the corresponding table cell on the left side to select it.
                                    <br>
                                    Then choose the item(s) and attributes that can be won on the right side.'
                        ],
                        'title' => [
                            'de' => 'Gewinne hinzufügen',
                            'en' => 'Assign items'
                        ]
                    ]
                ],
                'items' => [
                    'title' => [
                        'de' => 'Gewinne',
                        'en' => 'Wins'
                    ]
                ],
                'table' => [
                    'class' => [
                        'de' => 'Klasse',
                        'en' => 'Class'
                    ],
                    'down' => [
                        'de' => 'Runter',
                        'en' => 'Down'
                    ],
                    'remove' => [
                        'de' => 'Entfernen',
                        'en' => 'Remove'
                    ],
                    'up' => [
                        'de' => 'Hoch',
                        'en' => 'Up'
                    ],
                    'win' => [
                        'de' => 'Gewinn',
                        'en' => 'Win'
                    ]
                ],
                'title' => [
                    'head' => [
                        'de' => 'Gewinne',
                        'en' => 'Items'
                    ]
                ],
                'tools' => [
                    'hide' => [
                        'de' => 'Verstecke alle Bilder',
                        'en' => 'Hide all images'
                    ],
                    'import' => [
                        'de' => 'Importiere Sitzungsdaten',
                        'en' => 'Import session data'
                    ],
                    'title' => [
                        'de' => 'Werkzeuge',
                        'en' => 'Tools'
                    ]
                ],
                'type' => [
                    'title' => [
                        'de' => 'Typ',
                        'en' => 'Type'
                    ]
                ]
            ],
            'participants' => [
                'csv' => [
                    'button' => [
                        'de' => 'Tutorial: Wie man diese Datei (richtig) erstellt',
                        'en' => 'Tutorial: How to build this file (correctly)'
                    ],
                    'content' => [
                        'de' => 'Du kannst auch eine <a href="https://de.wikipedia.org/wiki/CSV_%28Dateiformat%29" title="CSV (Dateiformat)" rel="noopener" target="_blank">.csv</a>-Datei hochladen, um die Tabelle zu füllen.
                                <br>
                                Warnung: Die Tabelle wird beim Hochladen einer Datei zurückgesetzt!',
                        'en' => 'You can also upload a <a href="https://en.wikipedia.org/wiki/Comma-separated_values" title="Comma-separated values" rel="noopener" target="_blank">.csv</a> file to fill the table below.
                                <br>
                                Warning: The table resets when you load a file!'
                    ],
                    'spoiler' => [
                        'de' => 'Um diese Datei zu erhalten, klicke auf "Speichern unter" in <a href="https://www.openoffice.org/de/" title="Apache OpenOffice" rel="noopener" target="_blank">OpenOffice Calc</a> oder "Exportieren" in <a href="https://products.office.com/de-DE/home" title="Microsoft Office" rel="noopener" target="_blank">Microsoft Office Excel</a>.
                                Dann wähle eine semikolongetrennte .csv-Datei mit den Titeln "username" und "quantity". Gehe sicher, dass die Codierung auf UTF-8 gestellt ist!
                                <br>
                                Lasse deinen Mauszeiger über diesem Text schweben, um ein Formatbeispiel zu sehen.',
                        'en' => 'To get this file use "save as" in <a href="https://www.openoffice.org/" title="Apache OpenOffice" rel="noopener" target="_blank">OpenOffice Calc</a> or "export" in <a href="https://products.office.com/en/home" title="Microsoft Office" rel="noopener" target="_blank">Microsoft Office Excel</a>.
                                Then choose a semicolon seperated .csv-file that has the headlines "username" and "quantity". Make sure that encoding is set to UTF-8!
                                <br>
                                Let your cursor hover over this text to see a format example.'
                    ],
                    'title' => [
                        'de' => 'CSV Dateien',
                        'en' => 'CSV files'
                    ]
                ],
                'data' => [
                    'content' => [
                        'de' => 'Gib die Namen aller Teilnehmer und ihre Gewinnchancen an.
                                <br>
                                Beispielweise abhängig von der Anzahl der gespendeten CS:GO Keys.',
                        'en' => 'Enter all participants\' names and their chance of winning.
                                <br>
                                For instance, depending on the amount of CS:GO keys they\'ve donated.'
                    ],
                    'title' => [
                        'de' => 'Namen und Quantität',
                        'en' => 'Names and quantity'
                    ]
                ],
                'form' => [
                    'add' => [
                        'de' => 'Hinzufügen',
                        'en' => 'Add'
                    ],
                    'quantity' => [
                        'de' => 'Die Gewinnwahrscheinlichkeit.',
                        'en' => 'The count of chances to win.'
                    ],
                    'reset' => [
                        'de' => 'Zurücksetzen',
                        'en' => 'Reset'
                    ],
                    'upload' => [
                        'de' => 'Hochladen',
                        'en' => 'Upload'
                    ],
                    'username' => [
                        'de' => 'Ein Benutzername.',
                        'en' => 'A username.'
                    ]
                ],
                'table' => [
                    'down' => [
                        'de' => 'Runter',
                        'en' => 'Down'
                    ],
                    'quantity' => [
                        'de' => 'Quantität',
                        'en' => 'Quantity'
                    ],
                    'remove' => [
                        'de' => 'Entfernen',
                        'en' => 'Remove'
                    ],
                    'username' => [
                        'de' => 'Benutzername',
                        'en' => 'Username'
                    ],
                    'up' => [
                        'de' => 'Hoch',
                        'en' => 'Up'
                    ],
                ],
                'title' => [
                    'head' => [
                        'de' => 'Teilnehmer',
                        'en' => 'Participants'
                    ]
                ]
            ],
            'start' => [
                'about' => [
                    'content' => [
                        'de' => 'Diese Website bestimmt einen "wahren" zufälligen Gewinner für alle möglichen Verlosungsarten.
                                <br>
                                Sie ist im Speziellen für CS:GO Case Openings konzipiert.',
                        'en' => 'This website chooses a "true" random winner for any type of raffle.
                                <br>
                                It\'s made especially for CS:GO Case openings.'
                    ],
                    'title' => [
                        'de' => 'Wofür ist diese Website?',
                        'en' => 'What is this website for?'
                    ]
                ],
                'hint' => [
                    'de' => 'Scrolle herunter, um eine kurze Beschreibung zu sehen...',
                    'en' => 'Scroll down to see a short description...'
                ],
                'overview' => [
                    'content' => [
                        'prefix' => [
                            'de' => 'Alle Informationen, die RandomWinPicker braucht, können in 2 einfachen Schritten angegeben werden:',
                            'en' => 'All the information RandomWinPicker needs is given in 2 simple steps:'
                        ],
                        'table' => [
                            'li1' => [
                                'de' => 'Gib an, wer bei deinem Gewinnspiel teilnimmt und wie groß die Gewinnchance für jeden Teilnehmer ist.
                                        <br>
                                        Zum Beispiel können die Gewinnchancen von der Anzahl der vom Teilnehmer gespendeten CS:GO Keys abhängen.',
                                'en' => 'Tell RandomWinPicker who participates in your raffle and how great the chance of winning for each user is.
                                        <br>
                                        For example, the chances of winning may depend on the amount of CS:GO keys a user has donated.'
                            ],
                            'li2' => [
                                'de' => 'Wähle alle Gegenstände aus, die von jedem Teilnehmer in einer bestimmten Gewinnkategorie gewonnen werden können.
                                        <br>
                                        Beispielsweise könnte es einen Messerskin auf Platz 1 zu gewinnen geben.',
                                'en' => 'Choose all items that can be won by any user in a certain winning category.
                                        <br>
                                        Maybe a knife skin can be won on the first place.'
                            ]
                        ],
                        'suffix' => [
                            'de' => 'Das ist alles!',
                            'en' => 'That\'s it!'
                        ]
                    ],
                    'title' => [
                        'de' => 'Wie beginne ich?',
                        'en' => 'How do I start?'
                    ]
                ],
                'randomness' => [
                    'content' => [
                        'de' => 'RandomWinPicker benutzt die <a href="https://www.random.org/" title="RANDOM.ORG" rel="noopener" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" rel="noopener" target="_blank">API</a>, um einen Gewinner mit der Zufälligkeit von atmospherischem Rauschen zu bestimmen.
                                <br>
                                Das ist einer der besten Wege, wenn nicht der beste Weg, zufällige Daten zu erzeugen. <cite title="https://www.random.org/">Besser als die pseudo-zufälligen Zahlenalgorithmen, die typischerweise in Computerprogrammen benutzt werden</cite>.
                                <br>
                                Aber es gibt eine Begrenzung: Jeden Tag können nur 1.000 Anfragen zu random.org gesendet werden und 250.000 Bits können in den angefragten Antworten von random.org sein. Danach wird die Javascriptfunktion <a href="https://developer.mozilla.org/de/docs/Web/JavaScript/Reference/Global_Objects/Math/math.random" title="Math.random()" rel="noopener" target="_blank">Math.random()</a> des Browsers benutzt.',
                        'en' => 'RandomWinPicker uses the <a href="https://www.random.org/" title="RANDOM.ORG" rel="noopener" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" rel="noopener" target="_blank">API</a> to choose a winner based on the randomness of atmospheric noise.
                                <br>
                                This is one of the best - if not the best - way to generate random data. It is <cite title="https://www.random.org/">better than the pseudo-random number algorithms typically used in computer programs</cite>.
                                <br>
                                But there is one limit: Every day only 1,000 requests can be sent to random.org and 250,000 bits can be in the requested answers from random.org. After that the Javascript function <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random" title="Math.random()" rel="noopener" target="_blank">Math.random()</a> of your Browser is used.'
                    ],
                    'title' => [
                        'de' => 'Ein "wahrer" Gewinner?',
                        'en' => 'A "true" random winner?'
                    ]
                ],
                'title' => [
                    'head' => [
                        'de' => 'Willkommen',
                        'en' => 'Welcome'
                    ],
                    'body' => [
                        'de' => 'Will&shy;kom&shy;men bei
                                <br>
                                Ran&shy;dom&shy;Win&shy;Pick&shy;er',
                        'en' => 'Wel&shy;come to
                                <br>
                                Ran&shy;dom&shy;Win&shy;Pick&shy;er'
                    ]
                ]
            ]
        ]
    ];

    function get_language()
    {
        $language = 'en';

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $httpAcceptLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $language = strtolower(substr($httpAcceptLanguages[0], 0, 2));
        }

        if (isset($_COOKIE['i18next']) && is_string($_COOKIE['i18next'])) {
            $language = $_COOKIE['i18next'];
        }

        return $language;
    }

    function translate($id)
    {
        global $translations;

        $translation = $translations;
        $idParts = explode('.', $id);

        foreach ($idParts as $idPart) {
            $translation = $translation[$idPart];
        }

        return $translation[get_language()];
    }
