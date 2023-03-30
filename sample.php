<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Carousel Template · Bootstrap v5.2</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        #timein-svg {
            transform: rotate(360deg);
        }
    </style>

    <link href="carousel.css" rel="stylesheet">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">EAMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Log</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> -->
                </div>
            </div>
        </nav>
    </header>

    <!-- data-bs-ride="carousel" -->

    <main>
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="rgba(13,110,253,0.8)" />
                    </svg>
                    <div class="container">

                        <div class="carousel-caption text-start">
                            <div class="text-center">
                                <h1><?php echo date('F d,Y') ?> <span id="nowtimeIn"></span></h1>
                            </div>
                            <h1>Time In</h1>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                            <!-- <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p> -->
                            <form action="sample-process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">ID</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGroup1" name="id" placeholder="Id Number">
                                        <label for="floatingInputGroup1" class="text-black">Id Number</label>
                                    </div>
                                    <div class="input-group-text">
                                        <input type="submit" name="submitTimeIn" value="Submit" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="rgba(255,193,7,0.8)" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption">
                            <div class="text-center">
                                <h1><?php echo date('F d,Y') ?> <span id="nowbreakOut"></span></h1>
                            </div>
                            <h1>Break Out</h1>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                            <!-- <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p> -->
                            <form action="sample-process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">ID</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGroup1" name="id" placeholder="Id Number">
                                        <label for="floatingInputGroup1" class="text-black">Id Number</label>
                                    </div>
                                    <div class="input-group-text">
                                        <input type="submit" name="submitBreakOut" value="Submit" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="rgba(50, 168, 82,0.8)" />
                    </svg>

                    <div class="container">
                        <div class="carousel-caption">
                            <div class="text-center">
                                <h1><?php echo date('F d,Y') ?> <span id="nowbreakIn"></span></h1>
                            </div>
                            <h1>Break In</h1>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                            <!-- <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p> -->
                            <form action="sample-process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">ID</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGroup1" name="id" placeholder="Id Number">
                                        <label for="floatingInputGroup1" class="text-black">Id Number</label>
                                    </div>
                                    <div class="input-group-text">
                                        <input type="submit" name="submitBreakIn" value="Submit" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <rect width="100%" height="100%" fill="rgba(220,53,69,0.8)" />
                    </svg>
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>Time Out</h1>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                            <!-- <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p> -->
                            <form action="sample-process.php" method="post">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">ID</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGroup1" name="id" placeholder="Id Number">
                                        <label for="floatingInputGroup1" class="text-black">Id Number</label>
                                    </div>
                                    <div class="input-group-text">
                                        <input type="submit" name="submitTimeOut" value="Submit" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
        </div>

        <div class="container marketing">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="card card-body border border-primary" style="box-shadow:0 4px 25px rgba(13,110,253,0.2);">
                        <button type="button" id="TimeIn" data-bs-target="#myCarousel" data-bs-slide-to="0" class="bg-white border border-0 active" aria-current="true" aria-label="Slide 1">
                            <svg id="TimeInSvg" class="bd-placeholder-img rounded-circle" style="background-color: rgba(13,110,253,0.7);" width="140" height="140" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none" />
                                <line x1="128" y1="80" x2="128" y2="128" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <line x1="169.6" y1="152" x2="128" y2="128" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <polyline points="184.2 99.7 224.2 99.7 224.2 59.7" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <path d="M190.2,190.2a88,88,0,1,1,0-124.4l34,33.9" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <!-- <animateTransform href="#TimeInSvg" attributeName="transform" attributeType="XML" type="rotate" from="0" to="360" dur="10s" repeatCount="indefinite" /> -->
                                <title>Time In</title>
                            </svg>
                            <h2 class="fw-normal" style="color:rgba(13,110,253,0.6);"><b>Time In</b></h2>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body border border-warning" style="box-shadow:0 4px 25px rgba(255,193,7,0.2);">
                        <button type="button" id="BreakOut" data-bs-target="#myCarousel" data-bs-slide-to="1" class="bg-white border border-0" aria-current="true" aria-label="Slide 2">
                            <svg class="bd-placeholder-img rounded-circle" style="background-color: rgba(255,193,7,0.7);" width="140" height="140" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-2" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" id="BreakOutSvg">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" id="mainIconPathAttribute"></path>
                                <path d="M15 4.55a8 8 0 0 0 -6 14.9m0 -4.45v5h-5" id="mainIconPathAttribute"></path>
                                <line x1="18.37" y1="7.16" x2="18.37" y2="7.17"></line>
                                <line x1="13" y1="19.94" x2="13" y2="19.95"></line>
                                <line x1="16.84" y1="18.37" x2="16.84" y2="18.38"></line>
                                <line x1="19.37" y1="15.1" x2="19.37" y2="15.11"></line>
                                <line x1="19.94" y1="11" x2="19.94" y2="11.01"></line>
                                <!-- <animateTransform href="#BreakOutSvg" attributeType="xml" attributeName="transform" type="rotate" from="359" to="0" dur="10s" repeatCount="indefinite"></animateTransform> -->
                                <title>Break Out</title>
                            </svg>

                            <h2 class="fw-normal" style="color:rgba(255,193,7,0.6);"><b>Break Out</b></h2>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body border border-success" style="box-shadow:0 4px 25px rgba(50, 168, 82,0.2);">
                        <button type="button" id="BreakIn" data-bs-target="#myCarousel" data-bs-slide-to="2" class="bg-white border border-0" aria-current="true" aria-label="Slide 2">
                            <svg class="bd-placeholder-img rounded-circle" style="background-color: rgba(50, 168, 82,0.7);" width="140" height="140" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-2" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" id="IconChangeColor" transform="scale(-1, 1)">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" id="mainIconPathAttribute"></path>
                                <path d="M15 4.55a8 8 0 0 0 -6 14.9m0 -4.45v5h-5" id="mainIconPathAttribute"></path>
                                <line x1="18.37" y1="7.16" x2="18.37" y2="7.17"></line>
                                <line x1="13" y1="19.94" x2="13" y2="19.95"></line>
                                <line x1="16.84" y1="18.37" x2="16.84" y2="18.38"></line>
                                <line x1="19.37" y1="15.1" x2="19.37" y2="15.11"></line>
                                <line x1="19.94" y1="11" x2="19.94" y2="11.01"></line>
                                <!-- <animateTransform href="#BreakInSvg" attributeType="xml" attributeName="transform" type="rotate" from="0" to="359" dur="10s" repeatCount="indefinite"></animateTransform> -->
                                <title>Break In</title>
                            </svg>
                            <h2 class="fw-normal" style="color: rgba(50, 168, 82,0.6);"><b>Break In</b></h2>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body border border-danger" style="box-shadow:0 4px 25px rgba(220,53,69,0.2);">
                        <button type="button" id="TimeOut" data-bs-target="#myCarousel" data-bs-slide-to="3" class="bg-white border border-0" aria-current="true" aria-label="Slide 3">
                            <svg class="bd-placeholder-img rounded-circle" style="background-color: rgba(220,53,69,0.7);" fill="#000" width="140" height="140" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" id="TimeOutSvg">
                                <rect width="256" height="256" fill="none" />
                                <line x1="128" y1="80" x2="128" y2="128" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <line x1="169.6" y1="152" x2="128" y2="128" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <polyline points="71.8 99.7 31.8 99.7 31.8 59.7" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <path d="M65.8,190.2a88,88,0,1,0,0-124.4l-34,33.9" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                                <!-- <animateTransform href="#TimeOutSvg" attributeType="xml" attributeName="transform" type="rotate" from="359" to="0" dur="10s" repeatCount="indefinite"></animateTransform> -->
                                <title>Time Out</title>
                            </svg>
                            <h2 class="fw-normal" style="color:rgba(220,53,69,0.6);"><b>Time Out</b></h2>
                            <p>Some details are put here. Some details are put here. Some details are put here.</p>
                        </button>
                    </div>
                </div>
            </div>

            <!-- <div class="card">
                <?php
                date_default_timezone_set('Asia/Manila');
                $time = date('H:i:s');
                echo $time;
                ?>
                <span class="time"></span>
            </div> -->
            <hr class="featurette-divider">
        </div>

        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
        </div> -->

        <footer class="container">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2022–2023 CCC &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            setInterval(function() {
                var time = new Date();
                var now = time.toLocaleString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric',
                    hour12: true
                })
                $('#nowtimeIn').html(now);
                $('#nowbreakOut').html(now);
                $('#nowbreakIn').html(now);
                $('#nowtimeOut').html(now);
            }, 500)
            console.log()

            $('.log_now').each(function() {
                $(this).click(function() {
                    var _this = $(this)
                    var eno = $('[name="eno"]').val()
                    if (eno == '') {
                        alert("Please enter your employee number");
                    } else {
                        $('.log_now').hide()
                        $('.loading').show()
                        $.ajax({
                            url: 'time_log.php',
                            method: 'POST',
                            data: {
                                type: _this.attr('data-id'),
                                eno: $('[name="eno"]').val()
                            },
                            error: err => console.log(err),
                            success: function(resp) {
                                if (typeof resp != undefined) {
                                    resp = JSON.parse(resp)

                                    if (resp.status == 1) {
                                        $('#log_display').html(resp.msg)
                                        $('.log_now').show()
                                        $('.loading').hide()
                                        setTimeout(function() {
                                            $('[name="eno"]').val('')
                                            $('#log_display').html('')
                                        }, 5000)
                                    } else {
                                        alert(resp.msg)
                                        $('.log_now').show()
                                        $('.loading').hide()
                                    }
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
    <script>
        beforeBtn.addEventListener('click', () => {
            const tempDiv = document.createElement('#sample');
            tempDiv.style.backgroundColor = randomColor();
            if (activeElem) {
                activeElem.insertAdjacentElement('beforebegin', tempDiv);
            }
            setListener(tempDiv);
        });

        afterBtn.addEventListener('click', () => {
            const tempDiv = document.createElement('#sample');
            tempDiv.style.backgroundColor = randomColor();
            if (activeElem) {
                activeElem.insertAdjacentElement('afterend', tempDiv);
            }
            setListener(tempDiv);
        });
        $(document).ready(function() {
            $('#timein').click(function() {
                myInterval = setInterval(setTime, 500);

                function setTime() {
                    const x = document.querySelector('#timein-svg');
                    x.style.transform = x.style.transform = "rotate(0deg)" ? "rotate(90deg)" : "rotate(270deg)";
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).keydown(function(e) {
                if (e.keyCode == 97 || e.keyCode == 49) {
                    document.getElementById("TimeIn").click();
                } else if (e.keyCode == 98 || e.keyCode == 50) {
                    document.getElementById("BreakOut").click();
                } else if (e.keyCode == 99 || e.keyCode == 51) {
                    document.getElementById("BreakIn").click();
                } else if (e.keyCode == 100 || e.keyCode == 52) {
                    document.getElementById("TimeOut").click();
                }
            });

        });
    </script>

    <script>
        const timeElement = document.querySelector(".time");

        function formatTime(date) {
            const hours12 = date.getHours() % 12 || 12;
            const minutes = date.getMinutes();
            const isAm = date.getHours() < 12;

            return `${hours12.toString().padStart(2, "0")}:${minutes
                .toString()
                .padStart(2, "0")} ${isAm ? "AM" : "PM"}`;
        }

        setInterval(() => {
            const now = new Date();

            timeElement.textContent = formatTime(now);
        }, 200);
    </script>
    <!-- <script src="bootstrap.bundle.min.js"></script> -->


</body>

</html>