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
    <title>Lending - University GSO Inventory Lending System</title>
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
                <a href="lending.php" class="active">Lending</a>
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
                <div class="table-title">Lending Management</div>
                <div class="table-actions">
                    <div class="search-bar">
                        <i>🔍</i>
                        <input type="text" placeholder="Search loans...">
                    </div>
                    <button class="btn btn-secondary" id="showFilters">Filters</button>
                    <button class="btn btn-primary" id="showLendModal">New Loan</button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Item</th>
                        <th>Borrower</th>
                        <th>Checkout Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
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
    
    <!-- New Loan Modal -->
    <div class="modal" id="lendModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create New Loan</h3>
                <button class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Item</label>
                    <select class="form-control">
                        <option>Select an item</option>
                        <option>Dell Projector X3000</option>
                        <option>Wireless Microphone Set</option>
                        <option>Digital Camera Kit</option>
                        <option>Portable Speaker</option>
                        <option>Laptop (Dell XPS)</option>
                        <option>Conference Room Chairs (x10)</option>
                        <option>Whiteboard (Portable)</option>
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
                    <input type="date" class="form-control" value="2025-04-16">
                </div>
                <div class="form-group">
                    <label class="form-label">Expected Return Date</label>
                    <input type="date" class="form-control" value="2025-04-23">
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
                <button class="btn btn-primary">Create Loan</button>
            </div>
        </div>
    </div>
    
    <!-- Filter Modal -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Filter Loans</h3>
                <button class="close-button" id="closeFilterModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Active</option>
                        <option>Overdue</option>
                        <option>Returned</option>
                        <option>Extended</option>
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
                <div class="form-group">
                    <label class="form-label">Item Category</label>
                    <select class="form-control">
                        <option>All</option>
                        <option>Electronics</option>
                        <option>Audio Equipment</option>
                        <option>Classroom Equipment</option>
                        <option>Furniture</option>
                        <option>Office Supplies</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="resetFilters">Reset</button>
                <button class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
    
    <!-- Loan Details Modal -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Loan Details</h3>
                <button class="close-button" id="closeDetailsModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="details-grid">
                    <div class="details-item">
                        <div class="details-label">Loan ID</div>
                        <div class="details-value" id="detailLoanId">LOAN-001</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Item</div>
                        <div class="details-value" id="detailItem">Dell Projector X3000</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Item ID</div>
                        <div class="details-value" id="detailItemId">ITEM-056</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Borrower</div>
                        <div class="details-value" id="detailBorrower">Prof. Johnson</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Borrower Type</div>
                        <div class="details-value" id="detailBorrowerType">Faculty</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Contact</div>
                        <div class="details-value" id="detailContact">johnson@university.edu</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Purpose</div>
                        <div class="details-value" id="detailPurpose">Special lecture presentation</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Checkout Date</div>
                        <div class="details-value" id="detailCheckout">Apr 10, 2025</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Due Date</div>
                        <div class="details-value" id="detailDue">Apr 17, 2025</div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Status</div>
                        <div class="details-value" id="detailStatus"><span class="status-badge status-active">Active</span></div>
                    </div>
                    <div class="details-item">
                        <div class="details-label">Initial Condition</div>
                        <div class="details-value" id="detailCondition">Excellent</div>
                    </div>
                    <div class="details-item full-width">
                        <div class="details-label">Notes</div>
                        <div class="details-value" id="detailNotes">Includes carrying case and HDMI cable. User was instructed on proper operation.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="extendLoan">Extend Loan</button>
                <button class="btn btn-primary" id="returnFromDetails">Process Return</button>
            </div>
        </div>
    </div>
    
    <script>
        // Show New Loan Modal
        document.getElementById('showLendModal').addEventListener('click', function() {
            document.getElementById('lendModal').style.display = 'flex';
        });
        
        // Close New Loan Modal
        document.querySelector('#lendModal .close-button').addEventListener('click', function() {
            document.getElementById('lendModal').style.display = 'none';
        });
        
        // Cancel Button for New Loan Modal
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
        
        // Show Details Modal when Details button is clicked
        document.querySelectorAll('tbody .btn-secondary').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('detailsModal').style.display = 'flex';
                
                // In a real application, you would populate the details modal with data from the selected row
                const row = this.closest('tr');
                const loanId = row.cells[0].textContent;
                const item = row.cells[1].textContent;
                const borrower = row.cells[2].textContent;
                const checkoutDate = row.cells[3].textContent;
                const dueDate = row.cells[4].textContent;
                const status = row.cells[5].querySelector('.status-badge').textContent;
                
                // Update modal content with the data
                document.getElementById('detailLoanId').textContent = loanId;
                document.getElementById('detailItem').textContent = item;
                document.getElementById('detailBorrower').textContent = borrower;
                document.getElementById('detailCheckout').textContent = checkoutDate;
                document.getElementById('detailDue').textContent = dueDate;
            });
        });
        
        // Close Details Modal
        document.getElementById('closeDetailsModal').addEventListener('click', function() {
            document.getElementById('detailsModal').style.display = 'none';
        });
        
        // Process Return from Details Modal
        document.getElementById('returnFromDetails').addEventListener('click', function() {
            const loanId = document.getElementById('detailLoanId').textContent;
            const item = document.getElementById('detailItem').textContent;
            
            if (confirm(`Confirm return of ${item} (${loanId})?`)) {
                // Here you would normally process the return
                alert('Item returned successfully!');
                document.getElementById('detailsModal').style.display = 'none';
            }
        });
        
        // Process Return directly from table
        document.querySelectorAll('tbody .btn-primary').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const loanId = row.cells[0].textContent;
                const item = row.cells[1].textContent;
                
                if (confirm(`Confirm return of ${item} (${loanId})?`)) {
                    // Here you would normally process the return
                    alert('Item returned successfully!');
                }
            });
        });
        
        // Extend Loan from Details Modal
        document.getElementById('extendLoan').addEventListener('click', function() {
            const loanId = document.getElementById('detailLoanId').textContent;
            const item = document.getElementById('detailItem').textContent;
            const currentDueDate = document.getElementById('detailDue').textContent;
            
            const newDueDate = prompt(`Enter new due date for ${item} (${loanId})\nCurrent due date: ${currentDueDate}`, '');
            if (newDueDate) {
                // Here you would normally process the extension
                alert(`Loan extended successfully to ${newDueDate}!`);
                document.getElementById('detailDue').textContent = newDueDate;
            }
        });
        
        // Close modals when clicking outside content
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    </script>
</body>
</html>
