<?php
    session_start();
    if (empty($_SESSION['lname'])){
        echo "<script>window.location.href = '../403.html';</script>";
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - University GSO Inventory Lending System</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <i>📚</i> University GSO Inventory System
            </div>
            <nav>
                <a href="admin.php">Dashboard</a>
                <a href="inventory.php">Inventory</a>
                <a href="lending.php">Lending</a>
                <a href="returns.php">Returns</a>
                <a href="reports.php">Reports</a>
                <a href="users.php" class="active">Users</a>
            </nav>
            <div class="user-info">
                <img src="/api/placeholder/32/32" alt="User avatar">
                <span>Admin User</span>
            </div>
        </div>
    </header>
    
    <main>
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">User Management</div>
                <div class="table-actions">
                    <div class="search-bar">
                        <i>🔍</i>
                        <input type="text" placeholder="Search users...">
                    </div>
                    <button class="btn btn-secondary" id="showFilters">Filters</button>
                    <button class="btn btn-primary" id="showAddUserModal">Add User</button>
                </div>
            </div>
            
            <table>
                
            </table>
            
            <div class="pagination">
                <button>←</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>→</button>
            </div>
        </div>
        
        <div class="user-stats-container">
            <div class="stats-panel">
                <h3>User Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value">0</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Administrators</div>
                        <div class="stat-value">0</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Staff</div>
                        <div class="stat-value">0</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Borrowers</div>
                        <div class="stat-value">0</div>
                    </div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h3>Recent User Activity</h3>
                <ul class="activity-list">
                </ul>
            </div>
        </div>
    </main>
    
    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New User</h3>
                <button class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Enter email address">
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control">
                        <option>Administrator</option>
                        <option>Inventory Manager</option>
                        <option>Staff</option>
                        <option>Borrower</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select class="form-control">
                        <option>GSO Office</option>
                        <option>IT Department</option>
                        <option>Engineering</option>
                        <option>Faculty of Science</option>
                        <option>Student Affairs</option>
                        <option>Library</option>
                        <option>Administration</option>
                        <option>Finance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter phone number">
                </div>
                <div class="form-group">
                    <label class="form-label">Position/Title</label>
                    <input type="text" class="form-control" placeholder="Enter position or title">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm password">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="sendCredentials" checked>
                    <label class="form-check-label" for="sendCredentials">Send login credentials by email</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="requirePasswordChange" checked>
                    <label class="form-check-label" for="requirePasswordChange">Require password change on first login</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelAddUser">Cancel</button>
                <button class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
    
    <!-- Filter Modal -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Filter Users</h3>
                <button class="close-button" id="closeFilterModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Administrator</option>
                        <option>Inventory Manager</option>
                        <option>Staff</option>
                        <option>Borrower</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>GSO Office</option>
                        <option>IT Department</option>
                        <option>Engineering</option>
                        <option>Faculty of Science</option>
                        <option>Student Affairs</option>
                        <option>Library</option>
                        <option>Administration</option>
                        <option>Finance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Active</option>
                        <option>Inactive</option>
                        <option>Locked</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Registration Date</label>
                    <div style="display: flex; gap: 1rem;">
                        <input type="date" class="form-control" placeholder="From">
                        <input type="date" class="form-control" placeholder="To">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="resetFilters">Reset</button>
                <button class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
    
    <style>
        /* Additional styles for the Users page */
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-locked {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .user-stats-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 992px) {
            .user-stats-container {
                grid-template-columns: 1fr;
            }
        }
        
        .stats-panel, .recent-activity {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        
        .stats-panel h3, .recent-activity h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #333;
            font-size: 1.2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
        }
        
        .stat-item {
            background-color: #f5f7ff;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 0.5rem;
            color: #2c3e50;
        }
        
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .activity-list li {
            padding: 0.8rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-list li:last-child {
            border-bottom: none;
        }
        
        .activity-time {
            font-size: 0.85rem;
            color: #666;
        }
        
        .activity-desc {
            margin-top: 0.3rem;
        }
    </style>
    
    <script>
        // Show Add User Modal
        document.getElementById('showAddUserModal').addEventListener('click', function() {
            document.getElementById('addUserModal').style.display = 'flex';
        });
        
        // Close Add User Modal
        document.querySelector('#addUserModal .close-button').addEventListener('click', function() {
            document.getElementById('addUserModal').style.display = 'none';
        });
        
        // Cancel Button for Add User Modal
        document.getElementById('cancelAddUser').addEventListener('click', function() {
            document.getElementById('addUserModal').style.display = 'none';
        });
        
        // Show Filter Modal
        document.getElementById('showFilters').addEventListener('click', function() {
            document.getElementById('filterModal').style.display = 'flex';
        });
        
        // Close Filter Modal
        document.getElementById('closeFilterModal').addEventListener('click', function() {
            document.getElementById('filterModal').style.display = 'none';
        });
        
        // Reset Filters Button
        document.getElementById('resetFilters').addEventListener('click', function() {
            // Reset all form elements
            document.querySelectorAll('#filterModal select').forEach(select => {
                select.selectedIndex = 0;
            });
            
            document.querySelectorAll('#filterModal input[type="date"]').forEach(input => {
                input.value = '';
            });
        });
        
        // Close modals when clicking outside content
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
        
        // Table row actions
        document.querySelectorAll('table .btn-primary').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[0].textContent;
                const userName = row.cells[1].textContent;
                
                alert(`Edit user: ${userName} (${userId})`);
                // Here you would normally open an edit user modal
            });
        });
        
        document.querySelectorAll('table .btn-secondary').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[0].textContent;
                const userName = row.cells[1].textContent;
                
                alert(`View user details: ${userName} (${userId})`);
                // Here you would normally open a view user modal
            });
        });
        
        document.querySelectorAll('table .btn-warning').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.cells[0].textContent;
                const userName = row.cells[1].textContent;
                const action = this.textContent.trim();
                
                if (action === 'Activate') {
                    if (confirm(`Activate user account for ${userName} (${userId})?`)) {
                        alert('User account activated successfully!');
                        // Here you would normally update the user status
                    }
                } else if (action === 'Unlock') {
                    if (confirm(`Unlock user account for ${userName} (${userId})?`)) {
                        alert('User account unlocked successfully!');
                        // Here you would normally update the user status
                    }
                }
            });
        });
    </script>
</body>
</html>
