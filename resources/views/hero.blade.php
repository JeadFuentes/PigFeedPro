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
                <source src="{{"storage/swine.mp4"}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="overlay"></div>
            <div class="content">
                <img src="{{"storage/PigFeedPro.png"}}" alt="PigFeedPro Logo" class="logo">
                <h1>PigFeedPro</h1>
                <p>"In pig farming, feed management can be challenging and labor-intensive. Manual feeding practices often result in overfeeding, underfeeding, 
                    or uneven distribution of feed. Moreover, the lack of real-time monitoring and data collection makes it difficult for farmers to accurately 
                    assess the feeding time and the number of sacks consumed every month. (Gao, et.al, 2018)</p>
                <p style="margin-bottom: 40px">Automated Pig Feed Monitoring System are revolutionizing pig farming by offering a more efficient, 
                    convenient, and controlled way to feed pigs. This system are designed to dispense feed at predetermined intervals, eliminating 
                    the need for manual feeding and improving overall pig health and productivity.</p>
                <button type="button" class="cta-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Dashboard <i class='bx bxs-log-in-circle'></i>
                </button>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-hand text-danger"></i> &ensp; Security Check</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checkpin') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="input_text" class="form-label">Enter PIN:</label>
                            <input type="text" id="input_text" name="input_text" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>