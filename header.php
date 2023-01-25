<header>
        <div class="container">
            <div class="logo">
                <h1>
                    XYZ Buliders Inc.
                </h1>
            </div>
            <div class="menu">
                 <ul>
                     <li><a href="/PropertySite/">Home</a></li>
                     <li><a href="#">About Us</a></li>
                     <li><a href="#">Contact Us</a></li>
                     <li><a href="#">Services</a></li>

                     <?php 
                        session_start();

                        if(isset($_SESSION["user"]))
                        { 
                    ?>
                            <li>
                                   <form action="header.php" method="GET">
                                        <input type="submit" name="logout" value = "Logout" class="logout">
                                   </form> 

                            </li>
                     <?php   } 
                        else
                        {
                            echo "<li><a href='/PropertySite/Login'>Login</a></li>";
                            echo "<li><a href='/PropertySite/SignUp'>Sign Up</a></li>";
                        }

                        if(isset($_GET["logout"]))
                        {
                            // remove all session variables
                            session_unset();

                            // destroy the session
                            session_destroy();

                            echo "<script>window.location.href = '/propertysite/';</script>";
                        }

                     
                     ?>
                     
                     
                 </ul>   
            </div>
        </div>
</header>