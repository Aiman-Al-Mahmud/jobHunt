<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHunt Admin Dashboard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: rgb(249, 250, 251);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 256px;
            background-color: white;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            padding: 1.5rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .logo-job {
            color: #6E41E2;
        }

        .logo-hunt {
            color: #FF5722;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #4B5563;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
        }

        .nav-item:hover {
            background-color: #F3F4F6;
            color: #6E41E2;
        }

        .nav-item.active {
            background-color: #F3F4F6;
            color: #6E41E2;
        }

        .nav-item i {
            margin-right: 0.75rem;
        }

        .main-content {
            margin-left: 256px;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome h1 {
            font-size: 1.5rem;
            color: #1F2937;
            margin-bottom: 0.5rem;
        }

        .welcome p {
            color: #6B7280;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-container {
            position: relative;
        }

        .search-container i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .search-input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            outline: none;
        }

        .search-input:focus {
            border-color: #6E41E2;
            box-shadow: 0 0 0 2px rgba(110, 65, 226, 0.1);
        }

        .logout-btn {
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #F3F4F6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #F3F4F6;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 1.125rem;
            color: #1F2937;
            font-weight: 600;
        }

        .stat-icon {
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .stat-icon.purple {
            background-color: #F3E8FF;
            color: #6E41E2;
        }

        .stat-icon.orange {
            background-color: #FFF3E0;
            color: #FF5722;
        }

        .stat-icon.blue {
            background-color: #E0F2FE;
            color: #0EA5E9;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .recent-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .recent-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #F3F4F6;
        }

        .recent-card h2 {
            font-size: 1.125rem;
            color: #1F2937;
            margin-bottom: 1rem;
        }

        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .recent-item:last-child {
            border-bottom: none;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background-color: #F3E8FF;
            color: #6E41E2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            margin-right: 0.75rem;
        }

        .job-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background-color: #FFF3E0;
            color: #FF5722;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
        }

        .view-btn {
            font-size: 0.875rem;
            color: #6E41E2;
            text-decoration: none;
        }

        .view-btn:hover {
            text-decoration: underline;
        }

        .view-btn.orange {
            color: #FF5722;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .recent-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <span class="logo-job">Job</span><span class="logo-hunt">Hunt</span>
        </div>
        <nav>
            <a href="#" class="nav-item active">
                <i data-lucide="trending-up"></i>
                Dashboard
            </a>
            <a href="#" class="nav-item">
                <i data-lucide="users"></i>
                Users
            </a>
            <a href="#" class="nav-item">
                <i data-lucide="briefcase"></i>
                <span class="nav-item-text">Jobs</span>
            </a>
            <a href="#" class="nav-item">
                <i data-lucide="bell"></i>
                Notifications
            </a>
            <a href="#" class="nav-item">
                <i data-lucide="settings"></i>
                Settings
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="welcome">
                <h1>Welcome Back, Aiman!</h1>
                <p>Here's what's happening in your dashboard today.</p>
            </div>
            <div class="search-bar">
                <div class="search-container">
                    <i data-lucide="search"></i>
                    <input type="text" placeholder="Search..." class="search-input">
                </div>
                <button class="logout-btn">
                    <i data-lucide="log-out"></i>
                </button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Total Users</h3>
                    <div class="stat-icon purple">
                        <i data-lucide="users"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $userCount; ?></div>
                <div class="stat-label">Active platform users</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Job Posts</h3>
                    <div class="stat-icon orange">
                        <i data-lucide="briefcase"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $jobCount; ?></div>
                <div class="stat-label">Active job listings</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Total Applications</h3>
                    <div class="stat-icon blue">
                        <i data-lucide="trending-up"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo count($jobApplications); ?></div>                <div class="stat-label">Submitted applications</div>
            </div>
        </div>

        <div class="recent-grid">
            <div class="recent-card">
                <h2>Recent Users</h2>
                <?php foreach ($users as $user): ?>
                <div class="recent-item">
                    <div class="user-info">
                        <div class="user-avatar">
                            <?php echo substr($user->name, 0, 1); ?>
                        </div>
                        <span><?php echo $user->name; ?></span>
                    </div>
                    <a href="#" class="nav-item">
                 <span class="view-btn orange">View Profile</span>
            </a>                
        </div>
                <?php endforeach; ?>
            </div>

            <div class="recent-card">
                <h2>Recent Job Posts</h2>
                <?php foreach ($jobApplications as $job): ?>
                <div class="recent-item">
                    <div class="user-info">
                        <div class="job-icon">
                            <i data-lucide="briefcase"></i>
                        </div>
                        <span><?php echo $job->title; ?></span>
                    </div>
                    <a href="#" class="view-btn orange">View Details</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Add click handlers for navigation items
        // Add click handlers for navigation items
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.remove('active');
        });
        item.classList.add('active');

        // Check if the clicked item is the "Jobs" navigation item
        if (item.querySelector('.nav-item-text').textContent.trim() === 'Jobs') {
            // Redirect to the 'account/my-jobs' route
            window.location.href = '/account/my-jobs';
        }
        
    });
});

// Add click handler for logout button
document.querySelector('.logout-btn').addEventListener('click', () => {
    // Add your logout logic here
    console.log('Logout clicked');
});

    </script>
</body>
</html>