<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>API for Dihauti Residence</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .text-align-center {
            text-align: center;
        }

        .title {
            font-size: 84px;
            font-weight: 900;
        }

        .lead {
            font-size: 44px;
            font-weight: 600;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .mg-rl-auto {
            margin: 0 auto;
        }

        .size-text {
            font-size: 25px;
            font-weight: 400;
        }

        .size-lead {
            font-size: 34px;
            font-weight: 600;
        }

        .mg-l-30 {
            margin-left: 30px;
        }

        .width-10 {
            width: 100%;
        }

        .flex-column {
            display: flex;
            flex-direction: column;
        }
        .width-5{
            width: 50%;
        }
    </style>
</head>
<body>
<div class="flex-column">
    <div class="title m-b-md text-align-center width-10">
        Dihauti Residence
    </div>

    <div class="links m-b-md text-align-center">
        <a href="https://api.dihauti.ru/api/documentation">Documentations</a>
        <a href="https://github.com/SirMendax/dihauti_residence">Repository in GitHub</a>
        <a href="https://dihauti.ru">Dihauti.ru</a>
    </div>

    <div class="lead m-b-md text-align-center">
        Road map of project
    </div>
    <p class="size-lead text-align-center">The development administration system</p>
    <div class="mg-rl-auto width-5">
        <p class="mg-l-30 size-text">1.1. User penalty system.</p>
        <p class="mg-l-30 size-text">1.2. Penalty and banned lists</p>
    </div>

    <p class="size-lead text-align-center">Rework private message system</p>
    <div class="mg-rl-auto width-5">
        <p class="mg-l-30 size-text">2.1. Chat's events.</p>
        <p class="mg-l-30 size-text">2.2. Emoji.</p>
        <p class="mg-l-30 size-text">2.2. Insert links and media content from other sources</p>
    </div>
    <p class="size-lead text-align-center">Rework comments and replies system</p>
    <div class="mg-rl-auto width-5">
        <p class="mg-l-30 size-text">3.1. Add comment and reply in real-time</p>
        <p class="mg-l-30 size-text">3.1. Create tree structure</p>
    </div>
</div>
</div>
</body>
</html>
