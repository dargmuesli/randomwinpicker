<?php
    $translations = [
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
                    'de' => 'RandomWinPicker benutzt die <a href="https://www.random.org/" title="RANDOM.ORG" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" target="_blank">API</a>, um einen Gewinner mit der Zufälligkeit von atmospherischem Rauschen zu bestimmen.
                            <br>
                            Das ist einer der besten Wege, wenn nicht der beste Weg, zufällige Daten zu erzeugen. <cite title="https://www.random.org/">Besser als die pseudo-zufälligen Zahlenalgorithmen, die typischerweise in Computerprogrammen benutzt werden</cite>.
                            <br>
                            Aber es gibt eine Begrenzung: Jeden Tag können nur 1.000 Anfragen zu random.org gesendet werden und 250.000 Bits können in den angefragten Antworten von random.org sein. Danach wird die Javascriptfunktion <a href="https://developer.mozilla.org/de/docs/Web/JavaScript/Reference/Global_Objects/Math/math.random" title="Math.random()" target="_blank">Math.random()</a> des Browsers benutzt.',
                    'en' => 'RandomWinPicker uses the <a href="https://www.random.org/" title="RANDOM.ORG" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" target="_blank">API</a> to choose a winner based on the randomness of atmospheric noise.
                            <br>
                            This is one of the best - if not the best - way to generate random data. It is <cite title="https://www.random.org/">better than the pseudo-random number algorithms typically used in computer programs</cite>.
                            <br>
                            But there is one limit: Every day only 1,000 requests can be sent to random.org and 250,000 bits can be in the requested answers from random.org. After that the Javascript function <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random" title="Math.random()" target="_blank">Math.random()</a> of your Browser is used.'
                ],
                'title' => [
                    'de' => 'Ein "wahrer" Gewinner?',
                    'en' => 'A "true" random winner?'
                ]
            ],
            'title' => [
                'de' => 'Will&shy;kom&shy;men bei
                        <br>
                        Ran&shy;dom&shy;Win&shy;Pick&shy;er',
                'en' => 'Wel&shy;come to
                        <br>
                        Ran&shy;dom&shy;Win&shy;Pick&shy;er'
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

        if (isset($_SESSION['lang']) && is_string($_SESSION['lang'])) {
            $language = $_SESSION['lang'];
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
