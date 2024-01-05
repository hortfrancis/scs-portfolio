<?php

// Start/resume session to use session variables
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Set session variables & sanitiase input data
    $_SESSION['name'] = trim(htmlspecialchars($_POST['name']));
    $_SESSION['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $_SESSION['phone'] = preg_replace('/\D/', '', $_POST['phone']);
    $_SESSION['message'] = trim(htmlspecialchars($_POST['message']));

    $phoneValidationPattern = "/(\+?\d{1,4}[\s\-]?)?(\(?[\d\s\-]{1,}?\)?[\s\-]?)?[\d\s\-]{7,15}/";

    if (
        empty($_SESSION['name'])
        || empty($_SESSION['email'])
        // Phone number either passess the regex or is not provided
        || (!preg_match($phoneValidationPattern, $_SESSION['phone']) && !$_SESSION['phone'] === '')
        || empty($_SESSION['message'])
    ) {
        $_SESSION['error'] = true;

        // Redirect to the form, so the user can try again 
        header('Location: index.php#contact-form');
        exit();
    } else {
        // Send data to database 

        include_once 'lib/add-message-to-database.php';

        // Pass the message data as an associative array to be stored in the database, 
        // and evaluate if this was successful
        if (addMessageToDatabase(
            [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'phone' => $_SESSION['phone'],
                'message' => $_SESSION['message']
            ]
        )) {
            $_SESSION['success'] = true;

            // Reset session variables
            $_SESSION['name'] = $_SESSION['email'] = $_SESSION['phone'] = $_SESSION['message'] = '';
        } else {
            // Set error message
            $_SESSION['error'] = true;
        }
        // Follow Post/Redirect/Get pattern to avoid resubmitting the form on refresh
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex Hort-Francis | SCS Portfolio</title>

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <meta name="description" content="Alex Hort-Francis - Web Developer & Technology Consultant. Explore projects, code snippets, and get in touch.">
    <meta name="keywords" content="Alex Hort-Francis, Web Developer, Technology Consultant, Portfolio, Projects, Code Snippets">

    <!-- Open Graph tags for social media sharing -->
    <meta property="og:title" content="Alex Hort-Francis | SCS Portfolio">
    <meta property="og:description" content="Web Developer & Technology Consultant. Check out my projects and get in touch!">
    <meta property="og:image" content="images/profile-picture.jpeg">
    <meta property="og:url" content="https://alex-hort-francis.netmatters-scs.co.uk/">
    <meta property="og:type" content="website">

    <link type="text/css" rel="stylesheet" href="css/application.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,400;0,600;0,800;1,400;1,600&display=swap" rel="stylesheet">
</head>

<body id="top">

    <!-- 'Burger' button to access primary navigation -->
    <button aria-hidden="true" class="primary-nav__menu-button">
        <svg viewBox="0 0 100 100" aria-hidden="true">
            <g class="primary-nav__menu-button-burger-lines">
                <line x1="20" y1="25" x2="80" y2="25" />
                <line x1="20" y1="50" x2="80" y2="50" />
                <line x1="20" y1="75" x2="80" y2="75" />
            </g>
            <g class="primary-nav__menu-button-cross-lines primary-nav__menu-button-cross-lines--hidden">
                <line x1="28" y1="28" x2="72" y2="72" />
                <line x1="28" y1="72" x2="72" y2="28" />
            </g>
        </svg>
    </button>

    <!-- Primary navigation -->
    <aside>
        <nav class="primary-nav primary-nav--hidden">

            <a href="index.php" class="primary-nav__logo"><span>A</span><span>HF</span></a>

            <div class="primary-nav__vertical-flex-container">

                <ul class="primary-nav__subpages-menu"> <!-- Primary navigation -->
                    <li><a href="about.html">About</a></li>
                    <li><a href="index.php#projects">Portfolio</a></li>
                    <li><a href="code-snippets.html">Code Snippets</a></li>
                    <li><a href="scs-scheme.html">SCS Scheme</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                </ul>

                <ul class="primary-nav__social-media-menu">
                    <li>
                        <a href="https://www.linkedin.com/in/hortfrancis" target="_blank" aria-label="LinkedIn" class="primary-nav__social-media-link primary-nav__social-media-link--linkedin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" focusable="false" role="img">
                                <title>LinkedIn</title>
                                <path d="M0 0v24h24v-24h-24zm8 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.397-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/hortfrancis" target="_blank" aria-label="GitHub" class="primary-nav__social-media-link primary-nav__social-media-link--github">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" focusable="false" role="img">
                                <title>GitHub</title>
                                <path d="M0 0v24h24v-24h-24zm14.534 19.59c-.406.078-.534-.171-.534-.384v-2.195c0-.747-.262-1.233-.55-1.481 1.782-.198 3.654-.875 3.654-3.947 0-.874-.311-1.588-.824-2.147.083-.202.357-1.016-.079-2.117 0 0-.671-.215-2.198.82-.639-.18-1.323-.267-2.003-.271-.68.003-1.364.091-2.003.269-1.528-1.035-2.2-.82-2.2-.82-.434 1.102-.16 1.915-.077 2.118-.512.56-.824 1.273-.824 2.147 0 3.064 1.867 3.751 3.645 3.954-.229.2-.436.552-.508 1.07-.457.204-1.614.557-2.328-.666 0 0-.423-.768-1.227-.825 0 0-.78-.01-.055.487 0 0 .525.246.889 1.17 0 0 .463 1.428 2.688.944v1.489c0 .211-.129.459-.528.385-3.18-1.057-5.472-4.056-5.472-7.59 0-4.419 3.582-8 8-8s8 3.581 8 8c0 3.533-2.289 6.531-5.466 7.59z" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/hortfrancis/" target="_blank" aria-label="Instagram" class="primary-nav__social-media-link primary-nav__social-media-link--instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" focusable="false" role="img">
                                <title>Instagram</title>
                                <path d="M14.667 12c0 1.473-1.194 2.667-2.667 2.667-1.473 0-2.667-1.193-2.667-2.667 0-1.473 1.194-2.667 2.667-2.667 1.473 0 2.667 1.194 2.667 2.667zm3.846-3.232c.038.843.046 1.096.046 3.232s-.008 2.389-.046 3.233c-.1 2.15-1.109 3.181-3.279 3.279-.844.038-1.097.047-3.234.047-2.136 0-2.39-.008-3.232-.046-2.174-.099-3.181-1.132-3.279-3.279-.039-.845-.048-1.098-.048-3.234s.009-2.389.047-3.232c.099-2.152 1.109-3.181 3.279-3.279.844-.039 1.097-.047 3.233-.047s2.39.008 3.233.046c2.168.099 3.18 1.128 3.28 3.28zm-2.405 3.232c0-2.269-1.84-4.108-4.108-4.108-2.269 0-4.108 1.839-4.108 4.108 0 2.269 1.84 4.108 4.108 4.108 2.269 0 4.108-1.839 4.108-4.108zm1.122-4.27c0-.53-.43-.96-.96-.96s-.96.43-.96.96.43.96.96.96c.531 0 .96-.43.96-.96zm6.77-7.73v24h-24v-24h24zm-4 12c0-2.172-.009-2.445-.048-3.298-.131-2.902-1.745-4.52-4.653-4.653-.854-.04-1.126-.049-3.299-.049s-2.444.009-3.298.048c-2.906.133-4.52 1.745-4.654 4.653-.039.854-.048 1.127-.048 3.299 0 2.173.009 2.445.048 3.298.134 2.906 1.746 4.521 4.654 4.654.854.039 1.125.048 3.298.048s2.445-.009 3.299-.048c2.902-.133 4.522-1.745 4.653-4.654.039-.853.048-1.125.048-3.298z" />
                            </svg>
                        </a>
                    </li>
                </ul>

            </div>

        </nav>
    </aside>

    <!-- Main page content -->
    <div class="layout-vertical-flex-container">

        <header>
            <div id="banner">
                <hgroup class="banner__heading-group">
                    <h1 class="banner__heading">Alex <span class="no-line-break">Hort-Francis</span></h1>
                    <p class="banner__subheading">Web Developer & <span class="no-line-break">Technology
                            Consultant</span>
                    </p>
                </hgroup>
                <!-- Typewriter text animation for banner__heading & banner__subheading -->
                <script src="js/typewriterText.js"></script>
            </div>
        </header>

        <main>
            <section id="projects">

                <h2>Projects</h2>

                <div class="projects__layout-grid-container">

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/netmatters-homepage-screenshot.png" alt="Netmatters homepage project" />
                            <div class="projects__card-text-area">
                                <h3>Netmatters Homepage</h3>
                                <p>A rebuild of the Netmatters website, from scratch. A vanilla JavaScript & PHP project, with a MySQL database for 'latest news' and contact form submissions.</p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-css3"></use>
                                        </svg>CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-sass"></use>
                                        </svg>Sass (SCSS)</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-javascript"></use>
                                        </svg>JavaScript</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-php"></use>
                                        </svg>PHP</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-mysql"></use>
                                        </svg>MySQL</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vscode"></use>
                                        </svg>Visual Studio Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://hortfrancis.com/scs-portfolio/netmatters-homepage/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/netmatters-homepage" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/array-reflection-screenshot.png" alt="JavaScript Array Reflection" />
                            <div class="projects__card-text-area">
                                <h3>JavaScript Array Reflection</h3>
                                <p>A front-end web application that fetches an image from a 3rd party API and allows the user to assign it to a (validated) email address. Written with vanilla JavaScript. </p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-css3"></use>
                                        </svg>CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-sass"></use>
                                        </svg>Sass (SCSS)</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-javascript"></use>
                                        </svg>JavaScript</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vscode"></use>
                                        </svg>Visual Studio Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://hortfrancis.com/scs-portfolio/array-reflection/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/array-reflection" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/laravel-reflection-screenshot.png" alt="Laravel reflection project" />
                            <div class="projects__card-text-area">
                                <h3>Laravel Reflection</h3>
                                <p>A full-stack 'company management app' that applies CRUD operations and RESTful actions on companies and employees, stored in a MySQL database. Blade components with Tailwind CSS render the user interface. </p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-tailwindcss"></use>
                                        </svg>Tailwind CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-php"></use>
                                        </svg>PHP</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-laravel"></use>
                                        </svg>Laravel</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-mysql"></use>
                                        </svg>MySQL</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-phpstorm"></use>
                                        </svg>PhpStorm</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://hortfrancis.com/scs-portfolio/laravel-reflection/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/laravel-reflection" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/my-next-blog-screenshot.png" alt="Next Blog project" />
                            <div class="projects__card-text-area">
                                <h3>My Next Blog</h3>
                                <p>A Next.js project from a previous mini-bootcamp with Tech Educators. I created a full-stack React application and deployed with Vercel, using the 'JAM' stack: JavaScript, APIs, Markdown.</p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-tailwindcss"></use>
                                        </svg>Tailwind CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-typescript"></use>
                                        </svg>TypeScript</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-node-js"></use>
                                        </svg>Node</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-npm"></use>
                                        </svg>npm</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-react"></use>
                                        </svg>React</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-next-js"></use>
                                        </svg>Next.js</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vercel"></use>
                                        </svg>Vercel</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vscode"></use>
                                        </svg>Visual Studio Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://next-blog-hortfrancis.vercel.app/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/my-next-blog" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/to-do-app-screenshot.png" alt="To Do App" />
                            <div class="projects__card-text-area">
                                <h3>To Do App</h3>
                                <p>Front-end application using React, with Redux for state management. Users can add, edit,
                                    and delete tasks, and can mark tasks as 'done'. Made previously while studying with HyperionDev.</p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-css3"></use>
                                        </svg>CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-javascript"></use>
                                        </svg>JavaScript</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-node-js"></use>
                                        </svg>Node</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-npm"></use>
                                        </svg>npm</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-react"></use>
                                        </svg>React</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-redux"></use>
                                        </svg>Redux</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vscode"></use>
                                        </svg>Visual Studio Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://hortfrancis.github.io/to-do-app/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/to-do-app" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                    <section class="projects__card">

                        <div>
                            <img src="images/projects/cash-balance-manipulator-screenshot.png" alt="Cash Balance Manipulator" />
                            <div class="projects__card-text-area">
                                <h3>Cash Balance Manipulator</h3>
                                <p>A web user interface for manipulating a cash balance.
                                    Along with adding or subtracting an amount to the balance, the user can add interest at
                                    a fixed rate of 5% or apply a charge to the balance at a fixed rate of 15%. Made previously while studying with HyperionDev.</p>
                                <h4>Technologies</h4>
                                <ul class="projects__card-tech-list">
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-html-five"></use>
                                        </svg>HTML</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-css3"></use>
                                        </svg>CSS</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-javascript"></use>
                                        </svg>JavaScript</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-node-js"></use>
                                        </svg>Node</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-npm"></use>
                                        </svg>npm</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-react"></use>
                                        </svg>React</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-redux"></use>
                                        </svg>Redux</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-git"></use>
                                        </svg>Git</li>
                                    <li><svg class="icon">
                                            <use href="icons/symbol-defs.svg#icon-vscode"></use>
                                        </svg>Visual Studio Code</li>
                                </ul>
                            </div>
                        </div>

                        <div class="projects__card-button-group">
                            <a href="https://hortfrancis.github.io/cash-balance-manipulator/" target="_blank" class="projects__card-button">Live site</a>
                            <a href="https://github.com/hortfrancis/cash-balance-manipulator" target="_blank" class="projects__card-button">Code repo</a>
                        </div>

                    </section>

                </div>
            </section>

            <div id="contact" class="contact-form">
                <form id="contact-form" action="index.php" method="post">

                    <h2>Get In Touch</h2>
                    <div class="contact-form__validation-event-delegator">
                        <div class="contact-form__input-group">
                            <label for="contact-form-name">Name</label>
                            <input type="text" id="contact-form-name" name="name" required placeholder="What's your name?" value="<?php
                                                                                                                                    if (isset($_SESSION['name'])) {
                                                                                                                                        echo $_SESSION['name'];
                                                                                                                                    }
                                                                                                                                    ?>">
                            <span class="contact-form__error-indicator contact-form__error-indicator--hidden">Don't
                                forget to leave your name</span>
                        </div>

                        <div class="contact-form__input-group">
                            <label for="contact-form-email">Email</label>
                            <input type="email" id="contact-form-email" name="email" required pattern="^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,6}$" placeholder="What's your email address?" value="<?php
                                                                                                                                                                                                            if (isset($_SESSION['email'])) {
                                                                                                                                                                                                                echo $_SESSION['email'];
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>">
                            <span class="contact-form__error-indicator contact-form__error-indicator--hidden">Don't
                                forget to leave your correct email address</span>
                        </div>


                        <div class="contact-form__input-group">
                            <label for="contact-form-phone">Phone <i>(optional)</i></label>
                            <input type="tel" id="contact-form-phone" name="phone" pattern="(\+?\d{1,4}[\s\-]?)?(\(?[\d\s\-]{1,}?\)?[\s\-]?)?[\d\s\-]{7,15}" placeholder=" What's your phone number?" value="<?php
                                                                                                                                                                                                                if (isset($_SESSION['phone'])) {
                                                                                                                                                                                                                    echo $_SESSION['phone'];
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>">
                            <span class="contact-form__error-indicator contact-form__error-indicator--hidden">Your phone
                                number seems miss-typed</span>
                        </div>

                        <div class="contact-form__input-group">
                            <label for="contact-form-message">Message</label>
                            <textarea id="contact-form-message" name="message" required placeholder="What would you like to say?"><?php
                                                                                                                                    if (isset($_SESSION['message'])) {
                                                                                                                                        echo $_SESSION['message'];
                                                                                                                                    }
                                                                                                                                    ?></textarea>
                            <span class="contact-form__error-indicator contact-form__error-indicator--hidden">Don't
                                forget to leave a message</span>
                        </div>
                    </div>
                    <div class="contact-form__input-group">
                        <button type="submit">Submit</button>
                    </div>

                </form>
            </div>
        </main>

        <footer class="footer">

            <a href="#top" class="footer__back-to-top-link">Back to top
                <svg class="icon">
                    <use href="icons/symbol-defs.svg#icon-chevron-up"></use>
                </svg>
            </a>

        </footer>
    </div>

    <!-- JavaScript script imports -->
    <script src="js/navMenuToggle.js"></script>
    <script src="js/contactFormValidation.js"></script>
    <script src="js/contactFormSuccessIndicator.js"></script>
    <script src="js/contactFormSubmissionFailIndicator.js"></script>
    <?php
    // If the form has just been submitted, provide a visual indicator of success
    if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
        echo '<script>createFormSuccessIndicator();</script>';
        // Reset session variable to avoid the indicator being shown on refresh
        $_SESSION['success'] = false;
    }

    // If the form data has failed server-side validation, provide a visual indicator of the error
    if (isset($_SESSION['error']) && $_SESSION['error'] === true) {
        echo '<script>createFormSubmissionFailIndicator();</script>';
        // Reset session variable to avoid the indicator being shown on refresh
        $_SESSION['error'] = false;
    }
    ?>
</body>

</html>