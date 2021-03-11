<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header3-wrap">
                <div class="form-header">

                    <input class="au-input au-input--xl"
                           onkeyup="searchTable()"
                           type="text"
                           id="searchBar"
                           name="search"
                           placeholder="Search in table..."/>

                    <div class="au-btn--submit">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                </div>
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="https://png.pngtree.com/png-vector/20190225/ourlarge/pngtree-vector-avatar-icon-png-image_702436.jpg"
                                     alt="John Doe"/>
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?php echo $this->user->getNick() ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="https://png.pngtree.com/png-vector/20190225/ourlarge/pngtree-vector-avatar-icon-png-image_702436.jpg"
                                                 alt="user ic"/>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#"><?php echo $this->user->getName() ?></a>
                                        </h5>
                                        <span class="email"><?php echo $this->user->getEmail() ?> </span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="/logout">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>