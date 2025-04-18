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
    <title>University GSO Inventory Lending System</title>
    <link rel="stylesheet" href="../styles_Common.css"> 
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <i>📚</i> PLP GSO Inventory System
            </div>
            <nav>
                <a href="admin.php" class="active">Dashboard</a>
                <a href="inventory.php">Inventory</a>
                <a href="lending.php">Lending</a>
                <a href="returns.php">Returns</a>
                <a href="reports.php">Reports</a>
                <a href="users.php">Users</a>
            </nav>
            <div class="user-info">
                <img src="/api/placeholder/32/32" alt="User avatar">
                <span>Admin User</span>
            </div>
        </div>
    </header>
    
    <main>
        <div class="dashboard">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Total Items</div>
                    <div class="card-icon">📦</div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Items in inventory</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Currently Lent</div>
                    <div class="card-icon">🔄</div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Items currently lent out</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Overdue</div>
                    <div class="card-icon">⚠️</div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Items past their return date</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Available</div>
                    <div class="card-icon">✅</div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Items available for lending</div>
            </div>
        </div>
        
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">Inventory Items</div>
                <div class="table-actions">
                    <div class="search-bar">
                        <i>🔍</i>
                        <input type="text" placeholder="Search inventory...">
                    </div>
                    <button class="btn btn-secondary" id="showFilters">Filters</button>
                    <button class="btn btn-primary" id="showLendModal">Lend Item</button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Borrower</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>
    
    <!-- Lend Item Modal -->
    <div class="modal" id="lendModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Lend Item</h3>
                <button class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Item</label>
                    <select class="form-control">
                        <option>Select an item</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Borrower Type</label>
                    <select class="form-control">
                        <option>Staff</option>
                        <option>Faculty</option>
                        <option>Department</option>
                        <option>Student Organization</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Borrower Information</label>
                    <input type="text" class="form-control" placeholder="Name/ID/Department">
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Information</label>
                    <input type="text" class="form-control" placeholder="Email or Phone">
                </div>
                <div class="form-group">
                    <label class="form-label">Purpose</label>
                    <textarea class="form-control" rows="3" placeholder="State the purpose of borrowing this item"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Lending Date</label>
                    <input type="date" class="form-control" value="2025-04-13">
                </div>
                <div class="form-group">
                    <label class="form-label">Expected Return Date</label>
                    <input type="date" class="form-control" value="2025-04-20">
                </div>
                <div class="form-group">
                    <label class="form-label">Current Condition</label>
                    <select class="form-control">
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" rows="2" placeholder="Any additional notes about the loan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelLend">Cancel</button>
                <button class="btn btn-primary">Confirm Lending</button>
            </div>
        </div>
    </div>
    
    <!-- Filter Modal -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Filter Items</h3>
                <button class="close-button" id="closeFilterModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Available</option>
                        <option>Lent</option>
                        <option>Overdue</option>
                        <option>Maintenance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Electronics</option>
                        <option>Audio Equipment</option>
                        <option>Classroom Equipment</option>
                        <option>Furniture</option>
                        <option>Office Supplies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Date Range</label>
                    <div style="display: flex; gap: 1rem;">
                        <input type="date" class="form-control" placeholder="From">
                        <input type="date" class="form-control" placeholder="To">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Borrower Type</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Staff</option>
                        <option>Faculty</option>
                        <option>Department</option>
                        <option>Student Organization</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="resetFilters">Reset</button>
                <button class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
    
    <script>
        // Show Lend Modal
        document.getElementById('showLendModal').addEventListener('click', function() {
            document.getElementById('lendModal').style.display = 'flex';
        });
        
        // Close Lend Modal
        document.querySelector('.close-button').addEventListener('click', function() {
            document.getElementById('lendModal').style.display = 'none';
        });
        
        // Cancel Button for Lend Modal
        document.getElementById('cancelLend').addEventListener('click', function() {
            document.getElementById('lendModal').style.display = 'none';
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
                const action = this.textContent.trim();
                const row = this.closest('tr');
                const itemId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                if (action === 'Lend') {
                    document.getElementById('lendModal').style.display = 'flex';
                } else if (action === 'Return') {
                    if (confirm(`Confirm return of ${itemName} (${itemId})?`)) {
                        // Here you would normally process the return
                        alert('Item returned successfully!');
                    }
                }
            });
        });
    </script>
</body>
</html>
