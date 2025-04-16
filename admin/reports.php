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
    <title>Reports - University GSO Inventory Lending System</title>
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
                <a href="reports.php" class="active">Reports</a>
                <a href="users.php">Users</a>
            </nav>
            <div class="user-info">
                <img src="/api/placeholder/32/32" alt="User avatar">
                <span>Admin User</span>
            </div>
        </div>
    </header>
    
    <main>
        <div class="filters-container">
            <div class="filter-group">
                <label class="form-label">Report Type</label>
                <select class="form-control" id="reportType">
                    <option>Lending Activity</option>
                    <option>Inventory Status</option>
                    <option>Overdue Items</option>
                    <option>Item Utilization</option>
                    <option>Borrower Activity</option>
                    <option>Maintenance Reports</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="form-label">Date Range</label>
                <div style="display: flex; gap: 1rem;">
                    <input type="date" class="form-control" id="startDate" value="2025-01-01">
                    <input type="date" class="form-control" id="endDate" value="2025-04-13">
                </div>
            </div>
            <div class="filter-group">
                <label class="form-label">Format</label>
                <select class="form-control" id="reportFormat">
                    <option>Web View</option>
                    <option>PDF</option>
                    <option>Excel</option>
                    <option>CSV</option>
                </select>
            </div>
            <button class="btn btn-primary" id="generateReport">Generate Report</button>
        </div>
        
        <div class="report-container">
            <div class="report-header">
                <h2>Lending Activity Report</h2>
                <p>Date</p>
                <div class="report-actions">
                    <button class="btn btn-secondary">Print</button>
                    <button class="btn btn-secondary">Export</button>
                </div>
            </div>
            
            <div class="report-summary">
                <div class="summary-card">
                    <div>Total Loans</div>
                    <div class="summary-value">0</div>
                </div>
                <div class="summary-card">
                    <div>Average Loan Duration</div>
                    <div class="summary-value">0</div>
                </div>
                <div class="summary-card">
                    <div>Overdue Rate</div>
                    <div class="summary-value">0</div>
                </div>
                <div class="summary-card">
                    <div>Most Borrowed Category</div>
                    <div class="summary-value">Blank</div>
                </div>
            </div>
            
            <div class="charts-container">
                <div class="chart-box">
                    <h3>Monthly Lending Activity</h3>
                    <div class="chart-placeholder">
                        <img src="/api/placeholder/500/300" alt="Monthly lending chart">
                    </div>
                </div>
                <div class="chart-box">
                    <h3>Top 5 Most Borrowed Items</h3>
                    <div class="chart-placeholder">
                        <img src="/api/placeholder/500/300" alt="Top items chart">
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <h3>Detailed Lending Data</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Loans</th>
                            <th>Electronics</th>
                            <th>Audio Equipment</th>
                            <th>Classroom Equipment</th>
                            <th>Furniture</th>
                            <th>Office Supplies</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
            <div class="insights-container">
                <h3>Key Insights</h3>
                <ul>
                    <li>Electronics continue to be the most borrowed category, representing 41.7% of all loans.</li>
                    <li>March saw the highest lending activity, likely due to end-of-quarter projects.</li>
                    <li>The Dell Projector X3000 is the most borrowed item, accounting for 12% of all loans.</li>
                    <li>Faculty members are the primary borrowers (52%), followed by student organizations (31%).</li>
                    <li>Weekend lending has increased by 15% compared to previous quarter.</li>
                </ul>
            </div>
        </div>
    </main>
    
    <script>
        // Generate Report Button
        document.getElementById('generateReport').addEventListener('click', function() {
            const reportType = document.getElementById('reportType').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const format = document.getElementById('reportFormat').value;
            
            alert(`Generating ${reportType} report from ${startDate} to ${endDate} in ${format} format.`);
            // Here you would normally generate the report based on selected parameters
        });
        
        // Print Button
        document.querySelector('.report-actions .btn:first-child').addEventListener('click', function() {
            alert('Preparing document for printing...');
            // Here you would normally open the print dialog
            // window.print();
        });
        
        // Export Button
        document.querySelector('.report-actions .btn:last-child').addEventListener('click', function() {
            const format = document.getElementById('reportFormat').value;
            alert(`Exporting report as ${format}...`);
            // Here you would normally handle the export process
        });
        
        // Change Report Type
        document.getElementById('reportType').addEventListener('change', function() {
            const reportType = this.value;
            document.querySelector('.report-header h2').textContent = `${reportType} Report`;
            
            // Here you would normally update the report content based on the selected type
            alert(`Loading ${reportType} report data...`);
        });
    </script>
    
    <style>
        /* Additional styles for the Reports page */
        .filters-container {
            display: flex;
            gap: 1rem;
            background-color: #f5f5f5;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        
        .filter-group {
            flex: 1;
            min-width: 200px;
        }
        
        .report-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        
        .report-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1rem;
        }
        
        .report-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .report-header p {
            color: #666;
            margin: 0.5rem 0;
            flex-basis: 100%;
        }
        
        .report-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .report-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .summary-card {
            background-color: #f5f7ff;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
        }
        
        .summary-value {
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 0.5rem;
            color: #2c3e50;
        }
        
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .chart-box {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .chart-box h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .chart-placeholder {
            width: 100%;
            height: 300px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        
        .insights-container {
            background-color: #f0f7ff;
            border-radius: 0.5rem;
            padding: 1rem 1.5rem;
            margin-top: 2rem;
        }
        
        .insights-container h3 {
            margin-top: 0.5rem;
        }
        
        .insights-container ul {
            padding-left: 1.5rem;
        }
        
        .insights-container li {
            margin-bottom: 0.5rem;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
    </style>
</body>
</html>
