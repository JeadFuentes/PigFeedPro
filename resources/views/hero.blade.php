<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PigFeedPro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/sass/app.scss','resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body>
        <div class="hero">
            <video autoplay muted loop class="background-video">
                <source src="{{"build/swine.mp4"}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="overlay"></div>
            <div class="content">
                <img src="{{"build/PigFeedPro.png"}}" alt="PigFeedPro Logo" class="logo">
                <h1>PigFeedPro</h1>
                <p>"In pig farming, feed management can be challenging and labor-intensive. Manual feeding practices often result in overfeeding, underfeeding, 
                    or uneven distribution of feed. Moreover, the lack of real-time monitoring and data collection makes it difficult for farmers to accurately 
                    assess the feeding time and the number of sacks consumed every month. (Gao, et.al, 2018)</p>
                <p>Nowadays, more piggery farms have manual labor, requiring workers to check if there is enough food for the pigs and to feed them regularly. 
                    Laborers need to monitor the feed sacks to refill them when empty. Unfortunately, they sometimes fail to feed the pigs on time, which can 
                    adversely affect the pigs' health. This method is also time-consuming and economically inefficient as it necessitates constant monitoring.</p>
                <p style="margin-bottom: 40px">Automated Pig Feed Monitoring Systems have emerged as a creative solution in the field of pig farming. They address these problems by offering 
                    continuous monitoring and data collection capabilities. This system can track the number of sacks consumed every month, record feeding patterns, 
                    and monitor feed levels, notifying users when containers are empty. Leveraging advanced technologies, such as devices and data analysis, automated
                     systems optimize the feeding process. By providing real-time information and analysis, these systems aim to improve feed efficiency and revolutionize 
                     pig farming practices."</p>
                <a href="{{route('dashboard')}}" class="cta-button">Dashboard <i class='bx bxs-log-in-circle'></i></a>
            </div>
        </div>
    </body>
</html>