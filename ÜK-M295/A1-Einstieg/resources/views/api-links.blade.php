<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>API-Links | ÜK-M295</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* Base Styles */
            body {
                background-color: #0a0a0a;
                color: #ececec;
                min-height: 100vh;
                font-family: 'Instrument Sans', sans-serif;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            header {
                margin-bottom: 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            nav a {
                display: inline-block;
                margin-left: 1rem;
                padding: 0.5rem 1rem;
                border: 1px solid #3e3e3a;
                border-radius: 0.25rem;
                transition: border-color 0.2s, background-color 0.2s;
                color: #ececec;
                text-decoration: none;
                font-size: 0.875rem;
            }
            nav a:hover {
                border-color: #ff4433;
                background-color: rgba(255, 68, 51, 0.1);
            }
            h1 {
                margin-top: 0;
                margin-bottom: 0.5rem;
                font-weight: 500;
                font-size: 1.75rem;
                color: #ff4433;
            }
            .subtitle {
                color: #a1a09a;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }

            /* API Section Styles */
            .api-section {
                margin-bottom: 2rem;
                background-color: #161615;
                border-radius: 0.5rem;
                box-shadow: inset 0 0 0 1px rgba(255, 250, 237, 0.177);
                overflow: hidden;
                opacity: 0;
                transform: translateY(10px);
                animation: fade-in 0.5s forwards;
            }
            .api-section-header {
                background-color: #1d1d1b;
                padding: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
                user-select: none;
            }
            .api-section-title {
                font-weight: 500;
                font-size: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .api-section-icon {
                color: #ff4433;
                width: 20px;
                height: 20px;
            }
            .api-section-toggle {
                width: 20px;
                height: 20px;
                transition: transform 0.3s;
            }
            .api-section.expanded .api-section-toggle {
                transform: rotate(180deg);
            }
            .api-links {
                padding: 0;
                margin: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s, padding 0.5s;
            }
            .api-section.expanded .api-links {
                max-height: 1500px;
                padding: 1rem;
            }
            .api-link-item {
                margin-bottom: 0.75rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid #3e3e3a;
                opacity: 0;
                transform: translateX(-10px);
                transition: opacity 0.3s, transform 0.3s;
            }
            .api-section.expanded .api-link-item {
                opacity: 1;
                transform: translateX(0);
            }
            .api-link-item:last-child {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }
            .api-link-row {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                align-items: center;
                margin-bottom: 0.5rem;
            }
            .api-method {
                font-size: 0.8rem;
                padding: 0.2rem 0.4rem;
                border-radius: 0.25rem;
                background-color: #2d2d2b;
                color: #ff4433;
                font-weight: 600;
                text-transform: uppercase;
            }
            .api-endpoint {
                font-family: monospace;
                font-size: 0.9rem;
                color: #a1a09a;
            }
            .api-description {
                font-size: 0.85rem;
                color: #d0d0d0;
            }
            .api-try {
                margin-left: auto;
                padding: 0.25rem 0.5rem;
                background-color: #2d2d2b;
                border: 1px solid #3e3e3a;
                border-radius: 0.25rem;
                color: #ececec;
                font-size: 0.8rem;
                cursor: pointer;
                transition: background-color 0.2s, border-color 0.2s;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
            }
            .api-try:hover {
                background-color: #3e3e3a;
                border-color: #ff4433;
            }
            .api-try svg {
                width: 14px;
                height: 14px;
            }
            .api-params {
                padding-left: 2rem;
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .api-param {
                display: flex;
                gap: 0.5rem;
                margin-bottom: 0.25rem;
                font-size: 0.8rem;
            }
            .api-param-name {
                color: #ff9000;
                font-family: monospace;
            }
            .api-param-type {
                color: #a1a09a;
            }
            .api-param-description {
                color: #d0d0d0;
            }
            .api-response {
                margin-top: 0.5rem;
                background-color: #1a1a18;
                border-radius: 0.25rem;
                padding: 0.75rem;
                position: relative;
            }
            .api-response-header {
                font-size: 0.8rem;
                color: #a1a09a;
                margin-bottom: 0.5rem;
                display: flex;
                justify-content: space-between;
            }
            .api-response-code {
                display: inline-block;
                padding: 0.1rem 0.3rem;
                border-radius: 0.25rem;
                background-color: #2d2d2b;
                color: #4caf50;
                font-family: monospace;
            }
            .api-response-content {
                font-family: monospace;
                font-size: 0.85rem;
                white-space: pre-wrap;
                color: #d0d0d0;
                overflow-x: auto;
            }
            .api-link-item {
                transition-delay: calc(var(--index) * 0.05s);
            }
            
            /* Animations */
            @keyframes fade-in {
                0% {
                    opacity: 0;
                    transform: translateY(10px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* API Section Animation Delays */
            .api-section:nth-child(1) { animation-delay: 0.1s; }
            .api-section:nth-child(2) { animation-delay: 0.2s; }
            .api-section:nth-child(3) { animation-delay: 0.3s; }
            .api-section:nth-child(4) { animation-delay: 0.4s; }
            .api-section:nth-child(5) { animation-delay: 0.5s; }
            .api-section:nth-child(6) { animation-delay: 0.6s; }
            
            /* Utilities */
            .flex {
                display: flex;
            }
            .justify-between {
                justify-content: space-between;
            }
            .items-center {
                align-items: center;
            }
            .back-home {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                background-color: #1d1d1b;
                border: 1px solid #3e3e3a;
                border-radius: 0.25rem;
                color: #ececec;
                font-size: 0.875rem;
                text-decoration: none;
                transition: background-color 0.2s, border-color 0.2s;
            }
            .back-home:hover {
                background-color: #3e3e3a;
                border-color: #ff4433;
            }
            .footer {
                margin-top: 2rem;
                padding-top: 1rem;
                border-top: 1px solid #3e3e3a;
                font-size: 0.75rem;
                color: #a1a09a;
                display: flex;
                justify-content: space-between;
            }
            
            /* Response status colors */
            .status-200 { color: #4caf50; }
            .status-201 { color: #4caf50; }
            .status-204 { color: #03a9f4; }
            .status-400 { color: #ff9800; }
            .status-401 { color: #f44336; }
            .status-404 { color: #f44336; }
            .status-500 { color: #f44336; }
            
            /* Dark scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #1a1a18;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb {
                background: #3e3e3a;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #ff4433;
            }
            
            /* Mobile styles */
            @media (max-width: 768px) {
                .container {
                    padding: 1rem;
                }
                header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }
                .api-link-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }
                .api-try {
                    margin-left: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <div>
                    <a href="{{ url('/') }}" class="back-home">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Zurück zur Startseite
                    </a>
                </div>
                <nav>
                    <a href="{{ url('api/responder/hi') }}" target="_blank">Test API</a>
                    <a href="https://laravel.com/docs/10.x/routing" target="_blank">Routing Docs</a>
                </nav>
            </header>
            
            <h1>API-Links</h1>
            <p class="subtitle">Übersicht aller verfügbaren API-Endpunkte für das ÜK-M295 Backend-Projekt.</p>
            
            <!-- Responder Section -->
            <div class="api-section expanded">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 15L15 12L10 9V15Z" fill="currentColor" />
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Responder
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <ul class="api-links">
                    <li class="api-link-item" style="--index: 0;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/hi</span>
                            <a href="{{ url('api/responder/hi') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt einen einfachen "Hallo Welt" String zurück.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">Hallo Welt</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 1;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/number</span>
                            <a href="{{ url('api/responder/number') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt eine zufällige Zahl zwischen 1 und 10 zurück.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">7</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 2;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/www</span>
                            <a href="{{ url('api/responder/www') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Leitet zur Laravel Routing-Dokumentation weiter.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">302 Redirect</span>
                            </div>
                            <div class="api-response-content">Redirect zu: https://laravel.com/docs/10.x/routing#redirect-routes</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 3;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/favicon</span>
                            <a href="{{ url('api/responder/favicon') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Lädt das Favicon als Datei herunter.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">Binary File (favicon.ico)</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 4;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/hi/{name}</span>
                            <a href="{{ url('api/responder/hi/ÜK-M295') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt den übergebenen Namen zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">name</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Name, der zurückgegeben werden soll</span>
                            </div>
                        </div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">ÜK-M295</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 5;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/weather</span>
                            <a href="{{ url('api/responder/weather') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt Wetterinformationen für Luzern zurück.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">{
    "city": "Luzern",
    "temperature": 20,
    "wind": 10,
    "rain": 0
}</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 6;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/error</span>
                            <a href="{{ url('api/responder/error') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt eine 401 Fehlermeldung zurück.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-401">401 Unauthorized</span>
                            </div>
                            <div class="api-response-content">{
    "error": "Nicht authorisiert!"
}</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 7;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/responder/multiply/{number1}/{number2}</span>
                            <a href="{{ url('api/responder/multiply/5/7') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Multipliziert zwei Zahlen und gibt das Ergebnis zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">number1</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">Erste Zahl</span>
                            </div>
                            <div class="api-param">
                                <span class="api-param-name">number2</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">Zweite Zahl</span>
                            </div>
                        </div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">{
    "result": 35
}</div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Hallo-Velo Section -->
            <div class="api-section">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 8L12 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 12L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Hallo-Velo
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <ul class="api-links">
                    <li class="api-link-item" style="--index: 0;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/hallo-velo/bikes</span>
                            <a href="{{ url('api/hallo-velo/bikes') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Fahrräder zurück.</div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">[
    {
        "id": 1,
        "name": "Mountain Bike",
        "type": "MTB",
        "...": "..."
    },
    {
        "id": 2,
        "name": "City Bike",
        "type": "Urban",
        "...": "..."
    }
]</div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 1;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/hallo-velo/bikes/{id}</span>
                            <a href="{{ url('api/hallo-velo/bikes/1') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt ein bestimmtes Fahrrad anhand der ID zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">id</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">ID des Fahrrads</span
                                </div>
                        </div>
                        <div class="api-response">
                            <div class="api-response-header">
                                <span>Response</span>
                                <span class="api-response-code status-200">200 OK</span>
                            </div>
                            <div class="api-response-content">{
    "id": 1,
    "name": "Mountain Bike",
    "type": "MTB",
    "price": 1200,
    "created_at": "2023-05-12T10:20:30.000000Z",
    "updated_at": "2023-05-12T10:20:30.000000Z"
}</div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Book'ler Section -->
            <div class="api-section">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5V4.5C4 3.67157 4.67157 3 5.5 3H18.5C19.3284 3 20 3.67157 20 4.5V19.5C20 20.3284 19.3284 21 18.5 21H5.5C4.67157 21 4 20.3284 4 19.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 8H8.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 8H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 12H8.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 12H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 16H8.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 16H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Book'ler
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <ul class="api-links">
                    <li class="api-link-item" style="--index: 0;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/posts</span>
                            <a href="{{ url('api/bookler/posts') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Bucheinträge zurück.</div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 1;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/posts/{id}</span>
                            <a href="{{ url('api/bookler/posts/1') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt einen bestimmten Bucheintrag anhand der ID zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">id</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">ID des Bucheintrags</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 2;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/search/{search}</span>
                            <a href="{{ url('api/bookler/search/Tipp') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Sucht nach Bucheinträgen mit dem angegebenen Begriff.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">search</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Suchbegriff</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 3;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/book-finder/slug/{slug}</span>
                            <a href="{{ url('api/bookler/book-finder/slug/harry-potter') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Findet Bücher anhand des Slugs.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">slug</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Slug des Buches</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 4;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/book-finder/title/{title}</span>
                            <a href="{{ url('api/bookler/book-finder/title/Harry Potter') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Findet Bücher anhand des Titels.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">title</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Titel des Buches</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 5;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/book-finder/author/{author}</span>
                            <a href="{{ url('api/bookler/book-finder/author/J.K. Rowling') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Findet Bücher anhand des Autors.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">author</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Name des Autors</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 6;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/book-finder/year/{year}</span>
                            <a href="{{ url('api/bookler/book-finder/year/2003') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Findet Bücher anhand des Erscheinungsjahres.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">year</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">Erscheinungsjahr</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 7;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/book-finder/max-pages/{pages}</span>
                            <a href="{{ url('api/bookler/book-finder/max-pages/300') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Findet Bücher mit maximal der angegebenen Seitenzahl.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">pages</span>
                                <span class="api-param-type">(integer)</span>
                                <span class="api-param-description">Maximale Seitenzahl</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 8;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/meta/count</span>
                            <a href="{{ url('api/bookler/meta/count') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt die Anzahl der Bucheinträge zurück.</div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 9;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/meta/avg-pages</span>
                            <a href="{{ url('api/bookler/meta/avg-pages') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt die durchschnittliche Seitenzahl aller Bücher zurück.</div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 10;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/bookler/dashboard</span>
                            <a href="{{ url('api/bookler/dashboard') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt Dashboard-Daten für die Bücher zurück.</div>
                    </li>
                </ul>
            </div>
            
            <!-- RelationSheep Section -->
            <div class="api-section">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6L20 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 6C5 5.44772 4.55228 5 4 5C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7C4.55228 7 5 6.55228 5 6Z" fill="currentColor" />
                            <path d="M8 12C8 11.4477 7.55228 11 7 11C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13C7.55228 13 8 12.5523 8 12Z" fill="currentColor" />
                            <path d="M12 18C12 17.4477 11.5523 17 11 17C10.4477 17 10 17.4477 10 18C10 18.5523 10.4477 19 11 19C11.5523 19 12 18.5523 12 18Z" fill="currentColor" />
                        </svg>
                        RelationSheep
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <ul class="api-links">
                    <li class="api-link-item" style="--index: 0;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/relationsheep/posts</span>
                            <a href="{{ url('api/relationsheep/posts') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Beiträge zurück.</div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 1;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/relationsheep/topics/{slug}/posts</span>
                            <a href="{{ url('api/relationsheep/topics/laravel/posts') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Beiträge zu einem bestimmten Thema zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">slug</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Slug des Themas</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 2;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/relationsheep/tags/{tagSlug}/posts</span>
                            <a href="{{ url('api/relationsheep/tags/backend/posts') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Beiträge zu einem bestimmten Tag zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">tagSlug</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Slug des Tags</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Ackerer Section -->
            <div class="api-section">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 9L12 2L22 9V20C22 20.5304 21.7893 21.0391 21.4142 21.4142C21.0391 21.7893 20.5304 22 20 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18 22V12C18 11.4696 17.7893 10.9609 17.4142 10.5858C17.0391 10.2107 16.5304 10 16 10H8C7.46957 10 6.96086 10.2107 6.58579 10.5858C6.21071 10.9609 6 11.4696 6 12V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Ackerer
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <ul class="api-links">
                    <li class="api-link-item" style="--index: 0;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/ackerer/plants/{slug}</span>
                            <a href="{{ url('api/ackerer/plants/tomato') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt eine bestimmte Pflanze anhand des Slugs zurück.</div>
                        <div class="api-params">
                            <div class="api-param">
                                <span class="api-param-name">slug</span>
                                <span class="api-param-type">(string)</span>
                                <span class="api-param-description">Slug der Pflanze</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="api-link-item" style="--index: 1;">
                        <div class="api-link-row">
                            <span class="api-method">GET</span>
                            <span class="api-endpoint">/api/ackerer/areas</span>
                            <a href="{{ url('api/ackerer/areas') }}" target="_blank" class="api-try">
                                Testen
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="api-description">Gibt alle Anbaugebiete zurück.</div>
                    </li>
                </ul>
            </div>
            
            <!-- Tool to Add New Route -->
            <div class="api-section">
                <div class="api-section-header" onclick="toggleSection(this.parentElement)">
                    <div class="api-section-title">
                        <svg class="api-section-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Neue Route hinzufügen
                    </div>
                    <svg class="api-section-toggle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="api-links">
                    <div class="api-description" style="margin-bottom: 1rem;">
                        Um neue Routes zu deiner Laravel-API hinzuzufügen, öffne die Datei <code>routes/api.php</code> und füge die neuen Route-Definitionen hinzu. Nach folgendem Muster:
                    </div>
                    <div class="api-response">
                        <div class="api-response-header">
                            <span>Beispiel: Neue Route hinzufügen</span>
                        </div>
                        <div class="api-response-content">// In routes/api.php

Route::prefix('new-feature')->group(function () {
    Route::get('/endpoint', function () {
        return response()->json([
            'message' => 'Neuer API-Endpunkt funktioniert!'
        ]);
    });
});</div>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <div>ÜK-M295 Backend für Reaktive Webapplikationen</div>
                <div>API-Links Übersicht</div>
            </div>
        </div>
        
        <script>
            function toggleSection(section) {
                // Toggle expanded class
                section.classList.toggle('expanded');
                
                // Find all api-link-items in the section
                const items = section.querySelectorAll('.api-link-item');
                
                // Set animation delay for each item
                items.forEach((item, index) => {
                    item.style.setProperty('--index', index);
                });
            }
            
            // Expand the first section by default
            document.addEventListener('DOMContentLoaded', function() {
                const firstSection = document.querySelector('.api-section');
                if (firstSection) {
                    firstSection.classList.add('expanded');
                }
            });
        </script>
    </body>
</html>