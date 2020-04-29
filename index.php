<?php 
    require './functions.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eTutor Portal</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap&subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="homepage_assets/assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="homepage_assets/assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="homepage_assets/assets/css/main.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e76434167d.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="container">
                <div class="header__top">
                    <a href="" class="header__logo">
                        <img src="homepage_assets/assets/img/logo.png" alt="">
                    </a>
                    <!-- nav-bar -->
                    <nav class="menu">
                        <ul class="menu__list">
                            <li class="menu__item">
                                <a href="javascript:void(0)" class="menu__link">Home</a>
                            </li>
                            <li class="menu__item">
                                <a href="javascript:void(0)" class="menu__link">Contact</a>
                            </li>
                            <li class="menu__item">
                                <a href="javascript:void(0)" class="menu__link">Blog</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- login/register -->
                    <div class="user">
                        <div class="user__login">
                            <?php if(!isset($_SESSION)):?>
                            <i class="fas fa-sign-in-alt"></i>
                            <a href="#loginModal" class="user__link" data-toggle="modal">Login</a>
                            <?php else: ?>
                            <form action="logout_func.php" method="post">
                                <button class="btn btn-default" type="submit" name="logout" value="logout"><i class="fas fa-sign-out-alt"></i>Log Out</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="divider">
            <div class="container" style="margin-top: 5%; z-index: 1">
                <div class="header__content">
                    <h1 class="header__content-title">Learn Excilence in Teaching.</h1>
                    <div class="header__content-desc">eTutoring System</div>
                    <div class="header__content-img">
                        <img src="homepage_assets/assets/img/img_header.png" alt="">
                        <div class="header__content-list">
                            <img src="homepage_assets/assets/img/header_img-icon.png" alt="">
                            <img src="homepage_assets/assets/img/camera.png" alt="" class="header__content-item">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section-page">
            <div class="container">
                <div class="title">
                    <div class="title__name">
                        Blogs
                    </div>
                    <div class="title__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum venenatis mollis. Ut sem metus.
                    </div>
                </div>
                <div class="row mt-100">
                    <div class="col-lg-4">
                        <div class="post">
                            <a href="javascript:void(0)" class="post__img">
                                <img src="homepage_assets/assets/img/item1.jpg" alt="">
                            </a>
                           <div class="post__content">
                                <div class="post__info">
                                    <div class="post__date">
                                        <i class="fas fa-calendar-alt" class="post__icon"></i>
                                        <div class="post__text">April 5, 2017</div>
                                    </div>
                                    <div class="post__user">
                                        <i class="fas fa-user" class="post__icon"></i>
                                        <div class="post__text">John Doe</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="post__news">
                                    Learner Story: Alena – Exploring the Future Through Graphic Design
                                </a>
                                <div class="post__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum venenatis mollis. Ut sem metus, convallis a libero vel, suscipit 
                                </div>
                                <div class="post__readmore">
                                    <div class="readmore">
                                        <a href="javascript:void(0)" class="readmore__link">Read More</a>    
                                        <a href="javascript:void(0)" class="readmore__icon">
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                    <div class="interactive">
                                        <div class="interactive__like">
                                            <i class="fas fa-heart" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">50</div>
                                        </div>
                                        <div class="interactive__like">
                                            <i class="fas fa-comment-dots" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">75</div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="post">
                            <a href="javascript:void(0)" class="post__img">
                                <img src="homepage_assets/assets/img/item2.jpg" alt="">
                            </a>
                           <div class="post__content">
                                <div class="post__info">
                                    <div class="post__date">
                                        <i class="fas fa-calendar-alt" class="post__icon"></i>
                                        <div class="post__text">April 5, 2017</div>
                                    </div>
                                    <div class="post__user">
                                        <i class="fas fa-user" class="post__icon"></i>
                                        <div class="post__text">John Doe</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="post__news">
                                    Learner Story: Alena – Exploring the Future Through Graphic Design
                                </a>
                                <div class="post__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum venenatis mollis. Ut sem metus, convallis a libero vel, suscipit 
                                </div>
                                <div class="post__readmore">
                                    <div class="readmore">
                                        <a href="javascript:void(0)" class="readmore__link">Read More</a>    
                                        <a href="javascript:void(0)" class="readmore__icon">
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                    <div class="interactive">
                                        <div class="interactive__like">
                                            <i class="fas fa-heart" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">50</div>
                                        </div>
                                        <div class="interactive__like">
                                            <i class="fas fa-comment-dots" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">75</div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="post">
                            <a href="javascript:void(0)" class="post__img">
                                <img src="homepage_assets/assets/img/item3.jpg" alt="">
                            </a>
                           <div class="post__content">
                                <div class="post__info">
                                    <div class="post__date">
                                        <i class="fas fa-calendar-alt" class="post__icon"></i>
                                        <div class="post__text">April 5, 2017</div>
                                    </div>
                                    <div class="post__user">
                                        <i class="fas fa-user" class="post__icon"></i>
                                        <div class="post__text">John Doe</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="post__news">
                                    Learner Story: Alena – Exploring the Future Through Graphic Design
                                </a>
                                <div class="post__desc">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi bibendum venenatis mollis. Ut sem metus, convallis a libero vel, suscipit 
                                </div>
                                <div class="post__readmore">
                                    <div class="readmore">
                                        <a href="javascript:void(0)" class="readmore__link">Read More</a>    
                                        <a href="javascript:void(0)" class="readmore__icon">
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                    <div class="interactive">
                                        <div class="interactive__like">
                                            <i class="fas fa-heart" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">50</div>
                                        </div>
                                        <div class="interactive__like">
                                            <i class="fas fa-comment-dots" class="interactive__icon"></i>
                                            <div class="interactive__quanlity">75</div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
           <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-4">
                        <div class="footer__title">The eTutoring System Group 6</div>
                    </div>
                    <div class="col-lg-6">
                       <div class="footer__list">
                           <div class="footer__item">
                               <h4>Help Center:</h4>
                               <div>Documentations</div>
                               <div>Tutorials</div>
                           </div>
                           <div class="footer__item">
                               <h4>About Us:</h4>
                            <div>Our Team</div>
                        </div>
                        <div class="footer__item">
                            <h4>Tools:</h4>
                            <div>Create Account</div>
                            <div>Tutorials</div>    
                        </div>
                       </div>
                    </div>
                </div>
           </div>
        </footer>
    </div>
    
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Enter username and password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <form action="login_func.php" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" required name="username" placeholder="Enter username" >
                  </div>
                  <div class="form-group">
                    <label for="inputPassowrd">Password</label>
                    <input type="password" class="form-control" id="inputPassowrd" required name="password" placeholder="Password" >
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Log In</button>
                </div>
              </form>
          </div>
        </div>
    </div>
    
</body>
</html>