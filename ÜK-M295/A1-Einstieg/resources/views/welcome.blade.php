<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ÜK-M295 A1-Einstieg</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* Custom Laravel ÜK-M295 Styles */
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
                justify-content: flex-end;
            }
            nav a {
                display: inline-block;
                margin-left: 1rem;
                padding: 0.5rem 1rem;
                border: 1px solid #3e3e3a;
                border-radius: 0.25rem;
                transition: border-color 0.2s;
                color: #ececec;
                text-decoration: none;
                font-size: 0.875rem;
            }
            nav a:hover {
                border-color: #62605b;
            }
            .main-content {
                display: flex;
                flex-direction: column-reverse;
                gap: 2rem;
            }
            @media (min-width: 1024px) {
                .main-content {
                    flex-direction: row;
                }
            }
            .left-content {
                flex: 1;
                padding: 2rem;
                background-color: #161615;
                border-radius: 0 0 0.5rem 0.5rem;
                box-shadow: inset 0 0 0 1px rgba(255, 250, 237, 0.177);
            }
            @media (min-width: 1024px) {
                .left-content {
                    border-radius: 0.5rem 0 0 0.5rem;
                }
            }
            .right-content {
                width: 100%;
                aspect-ratio: 335/376;
                background-color: #1d0002;
                border-radius: 0.5rem 0.5rem 0 0;
                position: relative;
                overflow: hidden;
                box-shadow: inset 0 0 0 1px rgba(255, 250, 237, 0.177);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @media (min-width: 1024px) {
                .right-content {
                    width: 438px;
                    aspect-ratio: auto;
                    border-radius: 0 0.5rem 0.5rem 0;
                }
            }

            .laravel-logo {
                width: 80%;
                color: #ff4433;
                position: relative;
                z-index: 2;
                transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
                animation: logo-float 6s ease-in-out infinite;
                filter: drop-shadow(0 0 15px rgba(255, 68, 51, 0.4));
            }

            .laravel-logo path {
                opacity: 0;
                animation: fade-in 1.2s forwards;
            }

            /* Animation für jedes Path-Element mit Verzögerung */
            .laravel-logo path:nth-child(1) {
                animation-delay: 0.2s;
            }
            .laravel-logo path:nth-child(2) {
                animation-delay: 0.4s;
            }
            .laravel-logo path:nth-child(3) {
                animation-delay: 0.6s;
            }
            .laravel-logo path:nth-child(4) {
                animation-delay: 0.8s;
            }
            .laravel-logo path:nth-child(5) {
                animation-delay: 1s;
            }
            .laravel-logo path:nth-child(6) {
                animation-delay: 1.2s;
            }
            .laravel-logo path:nth-child(7) {
                animation-delay: 1.4s;
            }

            .logo-bg {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                overflow: hidden;
                opacity: 0.15;
                z-index: 1;
            }

            .grid-line {
                position: absolute;
                background: linear-gradient(90deg, transparent, rgba(255, 68, 51, 0.2), transparent);
                height: 1px;
                width: 100%;
                animation: grid-line-move 8s linear infinite;
            }

            .grid-line:nth-child(1) {
                top: 15%;
                animation-delay: 0s;
            }

            .grid-line:nth-child(2) {
                top: 35%;
                animation-delay: 2s;
            }

            .grid-line:nth-child(3) {
                top: 55%;
                animation-delay: 4s;
            }

            .grid-line:nth-child(4) {
                top: 75%;
                animation-delay: 6s;
            }

            .vertical-line {
                position: absolute;
                background: linear-gradient(180deg, transparent, rgba(255, 68, 51, 0.2), transparent);
                width: 1px;
                height: 100%;
                animation: vertical-line-move 12s linear infinite;
            }

            .vertical-line:nth-child(5) {
                left: 25%;
                animation-delay: 1s;
            }

            .vertical-line:nth-child(6) {
                left: 45%;
                animation-delay: 3s;
            }

            .vertical-line:nth-child(7) {
                left: 65%;
                animation-delay: 5s;
            }

            .vertical-line:nth-child(8) {
                left: 85%;
                animation-delay: 7s;
            }

            .glow {
                position: absolute;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(255, 68, 51, 0.4) 0%, rgba(255, 68, 51, 0) 70%);
                filter: blur(20px);
                opacity: 0.7;
                z-index: 1;
                animation: glow-move 15s linear infinite;
            }

            .glow:nth-child(9) {
                top: 30%;
                left: 20%;
                animation-delay: 0s;
            }

            .glow:nth-child(10) {
                top: 60%;
                left: 60%;
                width: 200px;
                height: 200px;
                animation-delay: 7.5s;
            }

            @keyframes logo-float {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

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

            @keyframes grid-line-move {
                0% {
                    transform: translateY(-50px);
                    opacity: 0;
                }
                20% {
                    opacity: 1;
                }
                80% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(calc(100% + 50px));
                    opacity: 0;
                }
            }

            @keyframes vertical-line-move {
                0% {
                    transform: translateX(-50px);
                    opacity: 0;
                }
                20% {
                    opacity: 1;
                }
                80% {
                    opacity: 1;
                }
                100% {
                    transform: translateX(calc(100% + 50px));
                    opacity: 0;
                }
            }

            @keyframes glow-move {
                0% {
                    transform: translate(0, 0);
                    opacity: 0.2;
                }
                25% {
                    transform: translate(40px, 30px);
                    opacity: 0.7;
                }
                50% {
                    transform: translate(0, 60px);
                    opacity: 0.5;
                }
                75% {
                    transform: translate(-40px, 30px);
                    opacity: 0.7;
                }
                100% {
                    transform: translate(0, 0);
                    opacity: 0.2;
                }
            }
            h1 {
                margin-top: 0;
                margin-bottom: 0.25rem;
                font-weight: 500;
                font-size: 1.5rem;
            }
            .subtitle {
                color: #a1a09a;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }
            .link-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 0.75rem 0;
                position: relative;
            }
            .link-item:not(:last-child)::before {
                content: '';
                position: absolute;
                top: 2rem;
                bottom: 0;
                left: 0.9rem;
                border-left: 1px solid #3e3e3a;
            }
            .circle {
                position: relative;
                padding: 0.25rem;
                z-index: 1;
                background-color: #161615;
            }
            .circle-inner {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 1.75rem;
                height: 1.75rem;
                border-radius: 9999px;
                background-color: #161615;
                border: 1px solid #3e3e3a;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
            }
            .circle-dot {
                width: 0.375rem;
                height: 0.375rem;
                border-radius: 9999px;
                background-color: #3e3e3a;
            }
            .doc-link {
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
                font-weight: 500;
                text-decoration: none;
                color: #ff4433;
                margin-left: 0.25rem;
            }
            .doc-link span {
                text-decoration: underline;
                text-underline-offset: 4px;
            }
            .doc-link svg {
                width: 0.625rem;
                height: 0.625rem;
            }
            .tags-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 0.5rem;
                margin-top: 2rem;
                margin-bottom: 1.5rem;
            }
            .tag-column {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            .tag-header {
                background-color: #1d1d1b;
                padding: 0.5rem;
                text-align: center;
                border-radius: 0.25rem;
                font-weight: 500;
                font-size: 0.875rem;
            }
            .tag-item {
                background-color: #272725;
                padding: 0.5rem;
                text-align: center;
                border-radius: 0.25rem;
                font-size: 0.75rem;
            }
            .mittag {
                background-color: #201000;
                color: #ff9000;
            }
            .cta-button {
                display: inline-block;
                padding: 0.5rem 1.25rem;
                background-color: #ff4433;
                color: #0a0a0a;
                border-radius: 0.25rem;
                font-weight: 500;
                transition: background-color 0.2s;
                text-decoration: none;
            }
            .cta-button:hover {
                background-color: #ff5544;
            }
            .laravel-logo {
                width: 80%;
                color: #ff4433;
            }
            .footer {
                margin-top: 2rem;
                font-size: 0.75rem;
                color: #a1a09a;
            }

            /* Mobile responsive adjustments */
            @media (max-width: 768px) {
                .tags-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
                
                .link-item {
                    gap: 0.5rem;
                }
            }

            @media (max-width: 480px) {
                .tags-grid {
                    grid-template-columns: 1fr;
                }
                
                nav {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                }
                
                nav a {
                    margin-left: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <nav>
                    <a href="{{ url('/') }}">Log in</a>
                    <a href="{{ url('/api-links') }}">API Links</a>
                </nav>
            </header>
            
            <div class="main-content">
                <div class="left-content">
                    <h1>ÜK-M295 A1-Einstieg</h1>
                    <p class="subtitle">Backend für Reaktive Webapplikationen entwickeln.<br>Tage 1-5 im Überblick.</p>
                    
                    <div>
                        <div class="link-item">
                            <span class="circle">
                                <span class="circle-inner">
                                    <span class="circle-dot"></span>
                                </span>
                            </span>
                            <span>
                                Laravel Dokumentation
                                <a href="https://laravel.com/docs" target="_blank" class="doc-link">
                                    <span>lesen</span>
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <div class="link-item">
                            <span class="circle">
                                <span class="circle-inner">
                                    <span class="circle-dot"></span>
                                </span>
                            </span>
                            <span>
                                Eigene Notiz-Dokumentation
                                <a href="https://github.com/HeiligerG/Laravel-Learning/tree/master/notes" target="_blank" class="doc-link">
                                    <span>reinschauen</span>
                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    
                    <div class="tags-grid">
                        <div class="tag-column">
                            <div class="tag-header">Tag 1</div>
                            <div class="tag-item">Backend-Frameworks</div>
                            <div class="tag-item">Laravel / MVC</div>
                            <div class="tag-item">Projekt Setup</div>
                            <div class="tag-item mittag">Mittag</div>
                            <div class="tag-item">Routes</div>
                            <div class="tag-item">Migrations</div>
                        </div>
                        <div class="tag-column">
                            <div class="tag-header">Tag 2</div>
                            <div class="tag-item">Eloquent Models</div>
                            <div class="tag-item">Controllers</div>
                            <div class="tag-item">Collections</div>
                            <div class="tag-item mittag">Mittag</div>
                            <div class="tag-item">Relationships</div>
                            <div class="tag-item">Factories</div>
                        </div>
                        <div class="tag-column">
                            <div class="tag-header">Tag 3</div>
                            <div class="tag-item">RESTful API</div>
                            <div class="tag-item">Insomnium</div>
                            <div class="tag-item mittag">Mittag</div>
                            <div class="tag-item">Request Validation & API Resource</div>
                            <div class="tag-item">Start «Real World» Projekt</div>
                        </div>
                        <div class="tag-column">
                            <div class="tag-header">Tag 4</div>
                            <div class="tag-item">Testing</div>
                            <div class="tag-item">Route Model Binding</div>
                            <div class="tag-item mittag">Mittag</div>
                        </div>
                        <div class="tag-column">
                            <div class="tag-header">Tag 5</div>
                            <div class="tag-item">Projektarbeit</div>
                            <div class="tag-item mittag">Mittag</div>
                        </div>
                    </div>
                    
                    <div>
                        <a href="{{ url('/') }}" class="cta-button">Projekt starten</a>
                    </div>
                    
                    <div class="footer">
                        ÜK-M295 Backend für Reaktive Webapplikationen
                    </div>
                </div>
                
                <!-- In der right-content-Div Folgendes einfügen: -->
                <div class="right-content">
                    <div class="logo-bg">
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                        <div class="grid-line"></div>
                        <div class="vertical-line"></div>
                        <div class="vertical-line"></div>
                        <div class="vertical-line"></div>
                        <div class="vertical-line"></div>
                        <div class="glow"></div>
                        <div class="glow"></div>
                    </div>
                    <svg class="laravel-logo" viewBox="0 0 438 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="currentColor" />
                        <path d="M110.256 41.6337C108.061 38.1275 104.945 35.3731 100.905 33.3681C96.8667 31.3647 92.8016 30.3618 88.7131 30.3618C83.4247 30.3618 78.5885 31.3389 74.201 33.2923C69.8111 35.2456 66.0474 37.928 62.9059 41.3333C59.7643 44.7401 57.3198 48.6726 55.5754 53.1293C53.8287 57.589 52.9572 62.274 52.9572 67.1813C52.9572 72.1925 53.8287 76.8995 55.5754 81.3069C57.3191 85.7173 59.7636 89.6241 62.9059 93.0293C66.0474 96.4361 69.8119 99.1155 74.201 101.069C78.5885 103.022 83.4247 103.999 88.7131 103.999C92.8016 103.999 96.8667 102.997 100.905 100.994C104.945 98.9911 108.061 96.2359 110.256 92.7282V102.195H126.563V32.1642H110.256V41.6337ZM108.76 75.7472C107.762 78.4531 106.366 80.8078 104.572 82.8112C102.776 84.8161 100.606 86.4183 98.0637 87.6206C95.5202 88.823 92.7004 89.4238 89.6103 89.4238C86.5178 89.4238 83.7252 88.823 81.2324 87.6206C78.7388 86.4183 76.5949 84.8161 74.7998 82.8112C73.004 80.8078 71.6319 78.4531 70.6856 75.7472C69.7356 73.0421 69.2644 70.1868 69.2644 67.1821C69.2644 64.1758 69.7356 61.3205 70.6856 58.6154C71.6319 55.9102 73.004 53.5571 74.7998 51.5522C76.5949 49.5495 78.738 47.9451 81.2324 46.7427C83.7252 45.5404 86.5178 44.9396 89.6103 44.9396C92.7012 44.9396 95.5202 45.5404 98.0637 46.7427C100.606 47.9451 102.776 49.5487 104.572 51.5522C106.367 53.5571 107.762 55.9102 108.76 58.6154C109.756 61.3205 110.256 64.1758 110.256 67.1821C110.256 70.1868 109.756 73.0421 108.76 75.7472Z" fill="currentColor" />
                        <path d="M242.805 41.6337C240.611 38.1275 237.494 35.3731 233.455 33.3681C229.416 31.3647 225.351 30.3618 221.262 30.3618C215.974 30.3618 211.138 31.3389 206.75 33.2923C202.36 35.2456 198.597 37.928 195.455 41.3333C192.314 44.7401 189.869 48.6726 188.125 53.1293C186.378 57.589 185.507 62.274 185.507 67.1813C185.507 72.1925 186.378 76.8995 188.125 81.3069C189.868 85.7173 192.313 89.6241 195.455 93.0293C198.597 96.4361 202.361 99.1155 206.75 101.069C211.138 103.022 215.974 103.999 221.262 103.999C225.351 103.999 229.416 102.997 233.455 100.994C237.494 98.9911 240.611 96.2359 242.805 92.7282V102.195H259.112V32.1642H242.805V41.6337ZM241.31 75.7472C240.312 78.4531 238.916 80.8078 237.122 82.8112C235.326 84.8161 233.156 86.4183 230.614 87.6206C228.07 88.823 225.251 89.4238 222.16 89.4238C219.068 89.4238 216.275 88.823 213.782 87.6206C211.289 86.4183 209.145 84.8161 207.35 82.8112C205.554 80.8078 204.182 78.4531 203.236 75.7472C202.286 73.0421 201.814 70.1868 201.814 67.1821C201.814 64.1758 202.286 61.3205 203.236 58.6154C204.182 55.9102 205.554 53.5571 207.35 51.5522C209.145 49.5495 211.288 47.9451 213.782 46.7427C216.275 45.5404 219.068 44.9396 222.16 44.9396C225.251 44.9396 228.07 45.5404 230.614 46.7427C233.156 47.9451 235.326 49.5487 237.122 51.5522C238.917 53.5571 240.312 55.9102 241.31 58.6154C242.306 61.3205 242.806 64.1758 242.806 67.1821C242.805 70.1868 242.305 73.0421 241.31 75.7472Z" fill="currentColor" />
                        <path d="M438 -3H421.694V102.197H438V-3Z" fill="currentColor" />
                        <path d="M139.43 102.197H155.735V48.2834H183.712V32.1665H139.43V102.197Z" fill="currentColor" />
                        <path d="M324.49 32.1665L303.995 85.794L283.498 32.1665H266.983L293.748 102.197H314.242L341.006 32.1665H324.49Z" fill="currentColor" />
                        <path d="M376.571 30.3656C356.603 30.3656 340.797 46.8497 340.797 67.1828C340.797 89.6597 356.094 104 378.661 104C391.29 104 399.354 99.1488 409.206 88.5848L398.189 80.0226C398.183 80.031 389.874 90.9895 377.468 90.9895C363.048 90.9895 356.977 79.3111 356.977 73.269H411.075C413.917 50.1328 398.775 30.3656 376.571 30.3656ZM357.02 61.0967C357.145 59.7487 359.023 43.3761 376.442 43.3761C393.861 43.3761 395.978 59.7464 396.099 61.0967H357.02Z" fill="currentColor" />
                    </svg>
                </div>
            </div>
        </div>
    </body>
</html>