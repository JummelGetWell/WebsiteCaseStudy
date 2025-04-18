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
    <title>Inventory - University GSO Inventory Lending System</title>
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
                <a href="inventory.php" class="active">Inventory</a>
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
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">Inventory Management</div>
                <div class="table-actions">
                    <div class="search-bar">
                        <i>🔍</i>
                        <input type="text" placeholder="Search inventory...">
                    </div>
                    <button class="btn btn-secondary" id="showFilters">Filters</button>
                    <button class="btn btn-primary" id="showAddItemModal">Add Item</button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Acquisition Date</th>
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
    
    <!-- Add Item Modal -->
    <div class="modal" id="addItemModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Item</h3>
                <button class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" placeholder="Enter item name">
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-control">
                        <option>Electronics</option>
                        <option>Audio Equipment</option>
                        <option>Classroom Equipment</option>
                        <option>Furniture</option>
                        <option>Office Supplies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" placeholder="Enter item description"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Acquisition Date</label>
                    <input type="date" class="form-control" value="2025-04-13">
                </div>
                <div class="form-group">
                    <label class="form-label">Condition</label>
                    <select class="form-control">
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Initial Value ($)</label>
                    <input type="number" class="form-control" placeholder="Enter initial value">
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" placeholder="Enter quantity" value="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" rows="2" placeholder="Any additional notes"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelAddItem">Cancel</button>
                <button class="btn btn-primary">Add Item</button>
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
                    <label class="form-label">Acquisition Date Range</label>
                    <div style="display: flex; gap: 1rem;">
                        <input type="date" class="form-control" placeholder="From">
                        <input type="date" class="form-control" placeholder="To">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Condition</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Excellent</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
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
        // Show Add Item Modal
        document.getElementById('showAddItemModal').addEventListener('click', function() {
            document.getElementById('addItemModal').style.display = 'flex';
        });
        
        // Close Add Item Modal
        document.querySelector('#addItemModal .close-button').addEventListener('click', function() {
            document.getElementById('addItemModal').style.display = 'none';
        });
        
        // Cancel Button for Add Item Modal
        document.getElementById('cancelAddItem').addEventListener('click', function() {
            document.getElementById('addItemModal').style.display = 'none';
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
                const itemId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                alert(`Edit item: ${itemName} (${itemId})`);
                // Here you would normally open an edit modal
            });
        });
        
        document.querySelectorAll('table .btn-secondary').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const itemId = row.cells[0].textContent;
                const itemName = row.cells[1].textContent;
                
                alert(`View item details: ${itemName} (${itemId})`);
                // Here you would normally open a view modal
            });
        });
    </script>
</body>
</html>
