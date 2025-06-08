<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SG HealthTrack | Dashboard</title>
  <link rel="stylesheet" href="../css/dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo">SG HealthTrack</div>
      <ul>
        <li class="active"><i class="fas fa-chart-line"></i> Dashboard</li>
        <li><i class="fas fa-calendar-check"></i> Appointments</li>
        <li><i class="fas fa-user-injured"></i> Patient Records</li>
        <li><i class="fas fa-credit-card"></i> Payments</li>
        <li><i class="fas fa-chart-pie"></i> Analytics</li>
      </ul>
    </aside>

    <main class="main">
      <header class="main-header">
        <div class="welcome">
          <h2>Dashboard</h2>
          <p>Welcome back! Here's what’s happening at your clinic today.</p>
        </div>
        <div class="user-action">
          <span>Dr. Sarah Johnson</span>
          <form action="logout.php" method="POST">
          <a href="logout.php" class="logout">Logout</a>
          </form>
        </div>
      </header>

      <section class="metrics">
        <div class="card green">
          <div class="label">Today's Patients</div>
          <div class="info">
            <h3>3</h3>
            <i class="fas fa-user-injured"></i>
          </div>
        </div>
        <div class="card">
          <div class="label">Appointments</div>
          <div class="info">
            <h3>3</h3>
            <i class="fas fa-calendar-alt"></i>
          </div>
        </div>
        <div class="card yellow">
          <div class="label">Revenue Today</div>
          <div class="info">
            <h3>$120</h3>
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
        <div class="card blue">
          <div class="label">Queue Status</div>
          <div class="info">
            <h3>3</h3>
            <i class="fas fa-clock"></i>
          </div>
        </div>
      </section>

      <section class="shortcuts">
        <div class="shortcut"><i class="fas fa-plus"></i><p>New Appointment</p><span>Schedule patient visit</span></div>
        <div class="shortcut"><i class="fas fa-file-medical"></i><p>Record Management</p><span>Manage patient files</span></div>
        <div class="shortcut"><i class="fas fa-money-check-alt"></i><p>Payment Processing</p><span>Handle billing</span></div>
      </section>

      <section class="lower">
        <div class="left">
          <div class="section-header">
            <h2>Patient Queue</h2>
            <i class="fas fa-sync-alt refresh-icon"></i>
          </div>
          <ul class="queue">
            <li><span class="dot green"></span> Sarah Wilson <span class="status-tag current">current</span></li>
            <li><span class="dot yellow"></span> Michael Chen <span class="status-tag next">next</span></li>
            <li><span class="dot gray"></span> Emma Johnson <span class="status-tag waiting">waiting</span></li>
          </ul>

          <h3>Today's Appointments</h3>
          <table class="styled-table">
            <tr><th>Patient</th><th>Time</th><th>Type</th><th>Status</th></tr>
            <tr><td>Sarah Wilson</td><td>09:00</td><td>Consultation</td><td><span class="tag in-progress">in-progress</span></td></tr>
            <tr><td>Michael Chen</td><td>09:30</td><td>Follow-up</td><td><span class="tag waiting">waiting</span></td></tr>
            <tr><td>Emma Johnson</td><td>10:00</td><td>Check-up</td><td><span class="tag scheduled">scheduled</span></td></tr>
          </table>

          <h3>Recent Payment Status</h3>
          <table class="styled-table">
            <tr><th>Patient</th><th>Service</th><th>Amount</th><th>Status</th></tr>
            <tr><td>Sarah Wilson</td><td>Consultation</td><td>$120.00</td><td><span class="tag paid">paid</span></td></tr>
            <tr><td>Michael Chen</td><td>Follow-up</td><td>$85.00</td><td><span class="tag pending">pending</span></td></tr>
            <tr><td>Emma Johnson</td><td>Blood Test</td><td>$45.00</td><td><span class="tag overdue">overdue</span></td></tr>
          </table>
        </div>

        <div class="right">
          <h2>Patient Volume Analytics</h2>
          <canvas id="volumeChart"></canvas>
        </div>
      </section>
    </main>
  </div>

  <script>
    const ctx = document.getElementById('volumeChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Patients',
          data: [100, 150, 130, 175, 170, 155],
          borderColor: '#14b8a6',
          backgroundColor: 'rgba(20, 184, 166, 0.1)',
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
</body>
</html>
