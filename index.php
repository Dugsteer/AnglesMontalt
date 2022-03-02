<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anglès Montalt</title>
    <link rel="icon" type="image/png" href="img/favicon.png" ; />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.min.css">
</head>

<body>

    <div class="wrapper">
        <div class="phone">
            <a href="https://api.whatsapp.com/send?phone=34666068734&text=M%27agradaria%20saber%20m%C3%A9s%20sobre%20els%20classes%20d%27Angl%C3%A8s%21"
                <i class="fab fa-whatsapp"></i></a>
        </div>
        <div class="expander" id="expander">
            <h4 id="pop">English a Sant Vicenç!</h4>
            <ul class="popClass">
                <li id="li1">Professor Nadiu</li>
                <li id="li2">Individuals o Grups Petits</li>
                <li id="li3">Video o Presencial</li>
                <li id="li4">La Primera Classe Gratis...</li><br>
            </ul>
            <!-- <div id="close" class="close">Tanca</div> -->
        </div>

        <!-- <div class="popup" id="popup"></div> -->


        <div class="image-div">
            <img src="img/UnionFlag.png" onclick="location.reload();" id="flag" alt="">
        </div>
        <div class="header">
            <div class="header-left">
                <p>AM</p>
            </div>
            <div class="header-right">
                <p>Anglès Montalt</p>
                <h5 id="number1">Classes 666068734</h5>
            </div>
        </div>
        <div class="navcontent booky2" id="navcontent">
            <ul>
                <li id="whose" onclick="whoIs();" class="underline">Qui Soc?</li>
                <li id="contact" onclick="inTouch();" class="underline">Contacte</li>
                <li class="underline" onclick="window.scrollTo(0, 900);">Què Faig?</li>
                <a href="https://esl-ology.com">
                    <li class="underline">Esl-ology.com</li>
                </a>

            </ul>
            <span class="booky2text" id="web">Un lloc web gratuït que estic programant per ajudar a professors i
                estudiants"</span>
        </div>

        <div class="topsdiv">
            <div id="top2" class="top2">
                <div class="piccy">
                    <img src="img/DugWebpic.jpg" alt="">
                    <p>
                    <blockquote>"Parlar una altra llengua és tenir una segona ànima"—Carlemany</blockquote>
                    </p>
                </div>
                <p>Em dic Dugald Steer i soc professor llicenciat en anglès molt appasionat a la llengua anglèsa. Tinc
                    més de 10 anys d'experiencia amb tots els nivels fins a IELTS i Cambridge Advanced. Tant si ets
                    principiant, fes servir l'anglès a la feina, necesites reforç escolar o tens un examen, t'ofereixo
                    un programa a mida que et garanteix els millors resultats i una experiencia encantadora.
                </p>
                <div class="booky" data-tooltip="També escric llibres per a nens. Aquests són alguns exemples.">

                    <img src="img/OlogySeries.jpg" alt="">


                </div>

            </div>

            <div id="top1" class="top1" name="top1">
                <div class="left1">
                    <p>Address</p>


                    <form id="form-id" class="form-class" method="post" action="contact-form-process.php">

                        <div class="form-group">
                            <label for="Name" class="label">Nom</label>
                            <div class="input-group">
                                <input type="text" id="Name" name="Name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Email" class="label">E-mail</label>
                            <div class="input-group">
                                <input type="email" id="Email" name="Email" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Message" class="label">Missatge</label>
                            <div class="input-group">
                                <textarea id="Message" name="Message" class="form-control" rows="6" maxlength="3000"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="button" class="btn btn-primary btn-lg btn-block">Send
                                Message</button>
                        </div>
                    </form>
                    <p>
                    <blockquote>Faig classes a casa meva, a casa teva, per Internet. On vulguis!</blockquote>
                    </p>

                </div>
                <div class="contact">
                    <p class="details">Poseu-vos en contacte amb mi mitjançcant aquest formulari o enviant un whatsapp a
                        666068734 i us respondré el més aviat possible. La primera classe de prova és gratis. La meva
                        adreça és:<br><br>Dugald Steer <br> Carrer Costa Daurada 5, <br> Sant Vicenç de Montalt, <br>
                        08394 Barcelona
                    </p>
                </div>

                <div class="right1">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1492.5603196920222!2d2.515591200798547!3d41.566633567011884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x525adaf767e02e5d!2sAngl%C3%A8s%20Montalt!5e0!3m2!1sen!2ses!4v1602058352261!5m2!1sen!2ses"
                        width="400" height="300" frameborder="0" style="border:1x solid black;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <div class="img-container">
                            <img src="img/girl.jpg" alt="" class="nens">
                        </div>
                        <h2>Nens</h2>
                        <i class="fas fa-child"></i>
                        <ul class="list">
                            <li class="list-item">Grups Petits</li>
                            <li class="list-item">Reforç del Llibre Escolar</li>
                            <li class="list-item">Jocs i Activitats</li>
                            <li class="list-item">Videos i Cançons</li>
                            <li class="list-item">Jocs Online</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                    </div>
                    <div class="card-back">
                        <ul class="list">
                            <li class="list-item">Grups Petits</li>
                            <li class="list-item">Reforç del Llibre Escolar</li>
                            <li class="list-item">Jocs i Activitats</li>
                            <li class="list-item">Videos i Cançons</li>
                            <li class="list-item">Jocs Online</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                        <div class="img-holder">
                            <div class="img-container-back">
                                <img src="img/girl-min.jpg" alt="" class="nens2">
                            </div>
                            <span data-tooltip="Més Info" class="span1"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <div class="img-container">
                            <img src="img/online.jpg" alt="" class="nens">
                        </div>
                        <h2>Zoom</h2>
                        <i class="fas fa-laptop"></i>
                        <ul class="list">
                            <li class="list-item">Clases cuan vulguis</li>
                            <li class="list-item">Clases 1-1 o grups</li>
                            <li class="list-item">Jocs i Activitats</li>
                            <li class="list-item">A Teu Ritme</li>
                            <li class="list-item">Packs Economics</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                    </div>
                    <div class="card-back">
                        <ul class="list">
                            <li class="list-item">Clases cuan vulguis</li>
                            <li class="list-item">Clases 1-1 o grups</li>
                            <li class="list-item">Jocs i Activitats</li>
                            <li class="list-item">A Teu Ritme</li>
                            <li class="list-item">Packs Economics</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                        <div class="img-holder">
                            <div class="img-container-back">
                                <img src="img/online-min.jpg" alt="" class="nens2">
                            </div>
                            <span data-tooltip="Més Info" class="span1"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <div class="img-container">
                            <img src="img/business.jpg" alt="" class="nens">
                        </div>
                        <h2>Negocis</h2>
                        <i class="fas fa-chart-bar"></i>
                        <ul class="list">
                            <li class="list-item">Grups Petits i Grans</li>
                            <li class="list-item">Experiencia en 'Business'</li>
                            <li class="list-item">Per a Meetings</li>
                            <li class="list-item">Per Trucades</li>
                            <li class="list-item">Per Escriure al Maxim</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                    </div>
                    <div class="card-back">
                        <ul class="list">
                            <li class="list-item">Grups Petits i Grans</li>
                            <li class="list-item">Experiencia en 'Business'</li>
                            <li class="list-item">Per a Meetings</li>
                            <li class="list-item">Per Trucades</li>
                            <li class="list-item">Per Escriure al Maxim</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                        <div class="img-holder">
                            <div class="img-container-back">
                                <img src="img/business-min.jpg" alt="" class="nens2">
                            </div>
                            <span data-tooltip="Més Info" class="span1"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <div class="img-container">
                            <img src="img/adults.jpg" alt="" class="nens">
                        </div>
                        <h2>Adults</h2>
                        <i class="fas fa-user"></i>
                        <ul class="list">
                            <li class="list-item">Grups Petits</li>
                            <li class="list-item">Clases Particulars</li>
                            <li class="list-item">Examens de Cambridge</li>
                            <li class="list-item">Preparaciò Entrevistes</li>
                            <li class="list-item">Progres Ràpid</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                    </div>
                    <div class="card-back">
                        <ul class="list">
                            <li class="list-item">Grups Petits</li>
                            <li class="list-item">Clases Particulars</li>
                            <li class="list-item">Examens de Cambridge</li>
                            <li class="list-item">Preparaciò Entrevistes</li>
                            <li class="list-item">Progres Ràpid</li>
                            <li class="list-item">i Parlar Moltissim!</li>
                        </ul>
                        <div class="img-holder">
                            <div class="img-container-back">
                                <img src="img/adults-min.jpg" alt="" class="nens2">
                            </div>
                            <span data-tooltip="Més Info" class="span1"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <h3>Website by D.A.Steer/Anglès Montalt © <?php echo date('Y'); ?></h3>

        <script src="script.min.js"></script>
</body>

</html>