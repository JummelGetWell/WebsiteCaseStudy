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
    <title>Returns - University GSO Inventory Lending System</title>
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
                <a href="returns.php" class="active">Returns</a>
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
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">Return Management</div>
                <div class="table-actions">
                    <div class="search-bar">
                        <i>🔍</i>
                        <input type="text" placeholder="Search returns...">
                    </div>
                    <button class="btn btn-secondary" id="showFilters">Filters</button>
                    <button class="btn btn-primary" id="showReturnModal">Process Return</button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Return ID</th>
                        <th>Item</th>
                        <th>Borrower</th>
                        <th>Checkout Date</th>
                        <th>Return Date</th>
                        <th>Condition</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
            
            <div class="pagination">
                <button>←</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>→</button>
            </div>
        </div>
    </main>
    
    <!-- Process Return Modal -->
    <div class="modal" id="returnModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Process Item Return</h3>
                <button class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Item</label>
                    <select class="form-control">
                        <option>Select an item</option>
                        <option>INV-001 - Dell Projector X3000 (Prof. Johnson)</option>
                        <option>INV-003 - Portable Whiteboard (Engineering Dept.)</option>
                        <option>INV-005 - Wireless Presenter (Student Council)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Return Date</label>
                    <input type="date" class="form-control" value="2025-04-13">
                </div>
                <div class="form-group">
                    <label class="form-label">Current Condition</label>
                    <select class="form-control">
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                        <option>Damaged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Received By</label>
                    <input type="text" class="form-control" placeholder="Staff member receiving the item">
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" rows="3" placeholder="Any additional notes about the return condition"></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="needsMaintenance">
                    <label class="form-check-label" for="needsMaintenance">Item needs maintenance</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="damageReported">
                    <label class="form-check-label" for="damageReported">Damage reported</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelReturn">Cancel</button>
                <button class="btn btn-primary">Confirm Return</button>
            </div>
        </div>
    </div>
    
    <!-- Filter Modal -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Filter Returns</h3>
                <button class="close-button" id="closeFilterModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Condition</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                        <option>Damaged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Return Date Range</label>
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
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="needsMaintenanceFilter">
                    <label class="form-check-label" for="needsMaintenanceFilter">Needs maintenance</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="damageReportedFilter">
                    <label class="form-check-label" for="damageReportedFilter">Damage reported</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="resetFilters">Reset</button>
                <button class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
    
    <script>
        // Show Return Modal
        document.getElementById('showReturnModal').addEventListener('click', function() {
            document.getElementById('returnModal').style.display = 'flex';
        });
        
        // Close Return Modal
        document.querySelector('#returnModal .close-button').addEventListener('click', function() {
            document.getElementById('returnModal').style.display = 'none';
        });
        
        // Cancel Button for Return Modal
        document.getElementById('cancelReturn').addEventListener('click', function() {
            document.getElementById('returnModal').style.display = 'none';
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
            
            document.querySelectorAll('#filterModal input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
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
                const returnId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                alert(`Edit return details: ${itemName} (${returnId})`);
                // Here you would normally open an edit modal
            });
        });
        
        document.querySelectorAll('table .btn-secondary').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const returnId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                alert(`View return details: ${itemName} (${returnId})`);
                // Here you would normally open a view modal
            });
        });
        
        document.querySelectorAll('table .btn-warning').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const returnId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                alert(`Report damage for: ${itemName} (${returnId})`);
                // Here you would normally open a damage report modal
            });
        });
    </script>
</body>
</html>
