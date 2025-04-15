

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Place - Find Your Next Gig</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/Swift-Place/public/css/styles.css">
</head>
<body>
    <header>
        <nav>
        <div class="nav-container">
        <div class="nav-left-container">
            <div class="logo-container">
                <img src="/Swift-Place/public/photos/Logos-removebg-preview.png" alt="Logo" class="logo-img">
            </div>
           
                <ul class="nav-left">
                    <li><a href="/Swift-Place/index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#">
                            Login <i class="fa-solid fa-chevron-down"></i> <!-- Dropdown Icon -->
                        </a>
                        <ul class="dropdown-menu">
                        <li><a href="/Swift-Place/routes/auth_route.php?action=loginClient"><i class="fa-solid fa-user"></i>Client Login</a></li>

                        <li><a href="/Swift-Place/index.php?controller=freelancer&action=showLogin"><i class="fa-solid fa-briefcase"></i> Freelancer Login</a></li>


                        </ul>
                    </li>
                </ul>
        </div>
            <div class="nav-right">
            <a href="/Swift-Place/views/auth/choose_role.php" class="btn">Sign Up</a>

            </div>
        </div>
    </nav>
    </header>
    <div id="loader"></div>
    
    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
    
    
    

    <section class="hero">
        <div class="hero-content">
            <h1 id="Find">Find Your Next Gig</h1>
            <p>Discover freelance projects that match your skills</p>
            <div class="buttons">
                <a href="../html/register.html" class="btn primary">Join us now</a>
            </div>
        </div>
    </section>
    

    <section class="categories">
        <h2>Freelance Categories</h2>
        <div class="category-grid">
            <div class="category web-design"><span>Web Design</span></div>
            <div class="category graphic-design"><span>Graphic Design</span></div>
            <div class="category content-writing"><span>Content Writing</span></div>
            <div class="category digital-marketing"><span>Digital Marketing</span></div>
            <div class="category seo-services"><span>SEO Services</span></div>
            <div class="category video-editing"><span>Video Editing</span></div>
            <div class="category audio-music"><span>Audio & Music</span></div>
            <div class="category animation"><span>Animation</span></div>
            <div class="category programming-tech"><span>Programming & Tech</span></div>
            <div class="category consulting"><span>Consulting</span></div>
        </div>
    </section>
    

    <section class="benefits">
        <h2>Why Choose Swift Place?</h2>
        <div class="benefit-grid">
            <div class="benefit">
                <i class="fa-solid fa-rocket"></i>
                <h3>Fast & Efficient</h3>
                <p>Get your projects done quickly with skilled freelancers.</p>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-lock"></i>
                <h3>Secure & Reliable</h3>
                <p>Work with trusted professionals.</p>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-layer-group"></i>
                <h3>Wide Range of Services</h3>
                <p>Find experts in various categories to match your needs.</p>
            </div>
        </div>
        <a href="../html/register.html" class="bton">Join Now</a>
    </section>


<section class="cta-section">
    <div class="cta-container">
        <h2>Find the Right Talent for Your Needs</h2>
        <p>Connect with top professionals to get your projects done efficiently.</p>
        <div class="cta-buttons">
            <a href="#" class="cta-button">Find top talent <span>Talent Marketplace™ →</span></a>
            <a href="#" class="cta-button">Explore services <span>Project Catalog™ →</span></a>
            <a href="#" class="cta-button">Get expert advice <span>Consultations →</span></a>
        </div>
    </div>
</section>


<section class="premium-section">
    <div class="premium-content">
        <div class="premium-text">
            <h2>Empowering <span class="highlight">businesses</span> with top-tier freelance talent</h2>
            <div class="features">
                <div class="feature">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <h4>Expert Talent Matching</h4>
                        <p>Get paired with highly skilled professionals who align with your project’s goals.</p>
                    </div>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <h4>Guaranteed Satisfaction</h4>
                        <p>Enjoy risk-free hiring with refund policies for unsatisfactory deliveries.</p>
                    </div>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <h4>Seamless Project Management</h4>
                        <p>Access tools that simplify collaboration and enhance workflow efficiency.</p>
                    </div>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>
                        <h4>Flexible Payment Solutions</h4>
                        <p>Choose between per-project pricing or hourly rates tailored to your needs.</p>
                    </div>
                </div>
            </div>
            <a href="register.html" class="btn-premium">Get Started</a>
        </div>
    </div>
</section>


    

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Pricing</a>
                <a href="#">About Us</a>
                <a href="#">Features</a>
                <a href="#">Help Center</a>
                <a href="#">Contact Us</a>
                <a href="#">FAQ</a>
                <a href="#">Careers</a>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <p>&copy; 2024 Swift Place - Privacy - Terms - Sitemap</p>
        </div>
    </footer>
    

</body>
<script src="/Swift-Place/public/js/index.js"></script>
    
<script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
</html>
