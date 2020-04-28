<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor_studentlist</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
</head>
<body style="background-image: url('assets/image/bg.jpg'); background-size: cover;">
    <!-- header -->
    <header class="header">
        <div class="header__left">
            <a href="#" class="header__item">
                <img src="assets/image/clock.png" alt="">
            </a>
            <a href="#" class="header__item">
                <img src="assets/image/coppy.png" alt="">
            </a>
            <a href="#" class="header__item">
                <img src="assets/image/email.png" alt="">
            </a>
            <!-- icon-navbar-mobile -->
            <label for="nav-sidebar-input" class="nav-sidebar">
                <i class="fas fa-bars"></i>
            </label>
            <input type="checkbox" name="" hidden class="nav-input" id="nav-sidebar-input">
            <label for="nav-sidebar-input" class="nav-overlay"></label>
            <!-- sidebar-mobile -->
            <div class="sidebar-mobile">
                <div class="sidebar-mobile__header">
                    <div class="tx-color">
                        <span>
                            Hi, User.
                        </span>
                    </div>
                    <label for="nav-sidebar-input" class="sidebar-mobile__close">    
                        <i class="fas fa-times"></i>
                    </label>
                </div>
                <ul class="sidebar-mobile__list">
                    <li class="sidebar-mobile__item">
                        <a href="#" class="sidebar-mobile__link">DashBoard</a>
                    </li>
                    <li class="sidebar-mobile__item">
                        <a href="#" class="sidebar-mobile__link">Tutor</a>
                    </li>
                    <li class="sidebar-mobile__item">
                        <a href="#" class="sidebar-mobile__link">Account</a>
                    </li>
                </ul>
                <ul class="sub-sidebar-mobile__list">
                    <li class="sub-sidebar-mobile__item">
                        <a href="" class="sub-sidebar-mobile__link">Tutor</a>
                    </li>
                    <li class="sub-sidebar-mobile__item">
                        <a href="" class="sub-sidebar-mobile__link">Student</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header__right">
            <div class="tx-color">
                <span>
                    Hi, Tuấn minh.
                </span>
            </div>
            <li class="setting">
            <a href="">
                <img src="assets/image/setting.png" alt="">
            </a>
            <ul class="profile">
                <li class="profile__item">
                    <a href="" class="profile__link">
                        Edit Profile
                    </a>
                    <a href="" class="profile__link">
                        Logout
                    </a>
                </li>
            </ul>
            </li>
        </div>
    </header>
    <!-- main -->
    <div class="main" style="position: relative;">
        <!-- sidebar -->
        <div class="sidebar">
            <ul class="sidebar__list">
                <li class="sidebar__item">
                    <a href="" class="sidebar__link">DashBoard</a>
                </li>
                <li class="sidebar__item">
                    <a href="" class="sidebar__link">Assignments</a>
                </li>
                <li class="sidebar__item">
                    <a href="" class="sidebar__link">Students List</a>
                </li>
                <li class="sidebar__item">
                    <a href="" class="sidebar__link">Account</a>
                </li>
            </ul>
            <ul class="sub-sidebar__list">
                <li class="sub-sidebar__item">
                    <a href="" class="sub-sidebar__link">My Profile</a>
                </li>
                <li class="sub-sidebar__item">
                    <a href="" class="sub-sidebar__link">Settings</a>
                </li>
                <li class="sub-sidebar__item">
                    <a href="" class="sub-sidebar__link">Logout</a>
                </li>
            </ul>
        </div>
        <div class="content">
            <h1 class="title">
                Student List
            </h1>
            <h3 class="title">
                Tutor name
            </h3>
            <div class="function">
                <div class="function__list">
                    <select class="function__item">
                        <option selected="selected">Bulk Actions</option>
                        <option>Sort by name</option>
                    </select>
                    <button class="function__item">Apply</button>
                    <button class="function__item">Add New</button>
                </div>
                <div class="search">
                    <input type="search" placeholder="Quick Search" class="function__item">
                    <button class="function__item">Search</button>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table class="table table-color">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>UserName</th>
                            <th>PassWord</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>1</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>2</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>3</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>4</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>5</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>6</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="checkbox">
                            </td>
                            <td>7</td>
                            <td>Blugraphic</td>
                            <td>Psd Freebies</td>
                            <td>psd,freebies,panel,admin</td>
                            <td>2014/02/19</td>
                            <td>17</td>
                            <td>
                                <a href="" class="close">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>
                <nav class="page">
                <ul class="pagination">
                    <li class="page__item"><a class="page__link" href="#">Previous</a></li>
                    <li class="page__item"><a class="page__link" href="#">...</a></li>
                    <li class="page__item"><a class="page__link" href="#">1</a></li>
                    <li class="page__item"><a class="page__link" href="#">2</a></li>
                    <li class="page__item"><a class="page__link" href="#">3</a></li>
                    <li class="page__item"><a class="page__link" href="#">...</a></li>
                    <li class="page__item"><a class="page__link" href="#">Next</a></li>
                </ul>
                </nav>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>